-- CREATE DATE:	2011-10-27
-- UPDATE DATE: 
-- CALL sp_settle_month(@r,@m,'127.0.0.1');
/*

 �������½�
 
 ���� ag_settle_periods.flag = 2 Ϊ��Ч������״̬�²����½�
 ���½�ִ��ʱ��Ϊ ag_settle_periods.settletime ǰ��12Сʱ�ڣ�����ʱ�䲻��ִ�С�
 
 ����������������ű�������
 1  ֻ���� 50 ���ڵĶ���
 2  ����ʱ�� > �¼ҿͻ������ϵ����ʱ�� ag_relations.date_add
 3  ����ʱ�� > ����ĺ�Լ��Чʱ�䣨��������Ŀǰ��ȡ��
 4  ����ʱ�� >  ���ڿ�ʼʱ�� ag_settle_periods.starttime
 5  ����ʱ�� <= ���ڽ���ʱ�� ag_settle_periods.endtime
 6  û�б���������Ķ��� plans_basics.agmretstatus = 0
 7  �¼Ҵ����ϵΪ��Ч ag_relations.flag = 2
 8  ������״̬��Ч ag_agent.flag = 2
 9  �ǳ�������
 10 ����״̬Ϊ 2-5

 �ù�̿��Է���ִ�У��������ظ��������⡣

*/

DROP PROCEDURE IF EXISTS `sp_settle_month`;
DELIMITER //
CREATE PROCEDURE `sp_settle_month`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_ip VARCHAR(20)
)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN 
	DECLARE t_id, t_contractid, t_planid, 
		t_agentid, t_preagentid, t_ret, 
		t_ticket_type, t_play_method, 
		t_clientid, t_timetag INT UNSIGNED;
	DECLARE t_order_num BIGINT(11);
	DECLARE t_type, t_oldtype, cursor_end, t_agent_type, t_preagent_type, 
		t_plan_type, t_client_type TINYINT UNSIGNED;
	DECLARE t_now, t_timepre, t_timepre2, t_contract_starttime DATETIME;
	DECLARE t_settletime, t_settle_starttime, t_settle_endtime, 
		t_order_date_add, t_rel_date_add TIMESTAMP;
	DECLARE t_spid VARCHAR(6);
	
	DECLARE t_msg, t_textmsg VARCHAR(255);
	DECLARE t_rate, t_taxrate DECIMAL(5, 3);
	DECLARE t_fromamt, t_fromamt_hemai, t_fromamt_sum, t_bonusbeforetax_sum, t_bonus_sum DECIMAL(12, 3);
	
	DECLARE t_cur CURSOR FOR 
		SELECT bsc.id, bsc.plan_type, rel.agentid, bsc.order_num, bsc.ticket_type, 
			bsc.play_method, bsc.user_id, ag_agents.agent_type, 
			bsc.date_add, rel.date_add, rel.client_type
			FROM `plans_basics` bsc, ag_relations rel, ag_agents
    	WHERE (bsc.`status` >= 2 and bsc.`status` <=5)
    		AND bsc.`date_add` > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -50 DAY)
    		AND bsc.user_id = rel.user_id 
    		AND rel.flag = 2
--    		AND ticket_type <> 7
    		AND ag_agents.user_id = rel.agentid
    		AND ag_agents.flag = 2
    		AND ag_agents.agent_type <> 1
    		AND agmretstatus = 0
    		AND (bsc.ticket_type = 1 or bsc.ticket_type = 2 or bsc.ticket_type = 6 or bsc.ticket_type = 7 or bsc.ticket_type = 8)
    	ORDER BY bsc.`ticket_type`, rel.agentid, id;
    
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET cursor_end=1;
	-- DECLARE EXIT HANDLER FOR SQLEXCEPTION rollback;

	SET t_timepre = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -7 HOUR);
	SET t_timepre2 = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -25 DAY);
	SET t_now = CURRENT_TIMESTAMP;
	SET t_timetag = unix_timestamp(now());
	SET po_msg = '', t_msg = '', po_ret = 0, t_agent_type = 0, t_preagent_type = 0, t_textmsg= '' ,
		t_id = 0, t_type = 0, t_oldtype = 0, t_ret = 0, t_rate = 0, t_spid='', t_plan_type = 0;
	SET t_clientid = 0, t_agentid = 0, t_preagentid = 0, t_fromamt = 0, t_fromamt_hemai = 0;
	SET t_fromamt_sum = 0, t_bonusbeforetax_sum = 0, t_bonus_sum  = 0, t_client_type = 0; 
	SET cursor_end=0;
	
	SELECT textmsg INTO t_textmsg FROM ag_errorcodes WHERE scode = 'sp_settle_month' LIMIT 1;
	-- SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
	START TRANSACTION;
	
	CALL sp_lock(po_ret,po_msg,'settle',0);

	-- get settle_periods
	SELECT `spid`, settletime, starttime, endtime INTO t_spid, t_settletime, t_settle_starttime, t_settle_endtime 
		FROM ag_settle_periods WHERE flag = 2
			AND DATE_ADD(settletime, INTERVAL -12 HOUR) < CURRENT_TIMESTAMP
			AND DATE_ADD(settletime, INTERVAL 12 HOUR) > CURRENT_TIMESTAMP
		  LIMIT 1;
	IF t_spid is null OR t_spid = '' THEN
		SET po_ret = 2051;
		SET po_msg = 'Settle Period not available.';
	END IF;
	
	OPEN t_cur;
	cursor_loop:LOOP
		SET cursor_end=0;
		FETCH t_cur INTO t_planid, t_plan_type, t_agentid, t_order_num, 
			t_ticket_type, t_play_method, t_clientid, t_agent_type, 
			t_order_date_add, t_rel_date_add, t_client_type;
		-- Get Contract Type
		SET t_type = 0;
		IF t_ticket_type = 7 THEN SET t_type = 7; END IF;
		
		IF cursor_end=1 OR po_ret > 0 THEN
SELECT 'LEAVE:', t_order_num;
			LEAVE cursor_loop;
		END IF;
SELECT '== IN LOOP ==', t_agentid, t_preagentid;
		
		IF t_agentid <> t_preagentid OR t_type <> t_oldtype THEN
			IF t_preagentid <> 0 THEN
				-- Get Month-Contract
				SET t_contractid = 0;
				SET t_rate = 0;
				SET t_taxrate = 0;
				
				SELECT mst.id, mst.taxrate, starttime
					INTO t_contractid, t_taxrate, t_contract_starttime
				FROM `ag_month_contracts` mst
				WHERE mst.user_id = t_preagentid 
					AND type = t_oldtype AND flag = 2
					AND contract_type = 0
					AND starttime <= CURRENT_TIMESTAMP
					-- AND lastsettletime < t_timepre2
					ORDER BY starttime DESC limit 1;
			
				IF t_contractid = 0 THEN
					SET po_ret = 2053;
					SET po_msg = CONCAT('contractor not exists for agentid:', t_preagentid);
				ELSE
					-- get Rate by amount of money
					SELECT rate INTO t_rate FROM ag_month_contract_dtls dtl
						WHERE contract_id = t_contractid 
						AND minimum <= t_fromamt_sum AND maximum > t_fromamt_sum
						ORDER BY maximum DESC LIMIT 1;
					IF t_rate = 0 THEN 
						SELECT rate INTO t_rate FROM ag_month_contract_dtls dtl
							WHERE contract_id = t_contractid AND maximum < t_fromamt_sum
							ORDER BY maximum DESC LIMIT 1;
					END IF;
						
					-- Calc Month-Profits
					SET t_bonusbeforetax_sum = t_fromamt_sum * t_rate ;
					SET t_bonus_sum = t_bonusbeforetax_sum * (1-t_taxrate);
SELECT t_contractid, t_rate, t_fromamt_sum;					
					INSERT INTO ag_settle_months(mcid, spid, type, user_id, flag, agent_type,
						rate, fromamt, taxrate, bonusbeforetax, bonus, settletime)
					VALUES(t_contractid, t_spid, t_oldtype, t_preagentid, 2, t_preagent_type, 
						t_rate, t_fromamt_sum, t_taxrate, t_bonusbeforetax_sum, t_bonus_sum, CURRENT_TIMESTAMP);
					
					SELECT last_insert_id() INTO t_id;
					
					UPDATE plans_basics SET agmretstatus = 2 WHERE agmretstatus = t_timetag;
					
					UPDATE ag_settle_month_dtls SET mcid = t_contractid, masterid = t_id, rate = t_rate
						WHERE agentid = t_preagentid AND settletime = t_now AND masterid = 0;
					
					-- ADD AGENT USER_MONEY
--					IF t_bonus_sum != 0 AND t_preagent_type != 2 THEN
--						CALL sp_money_add(po_ret, po_msg, t_preagentid, t_bonus_sum, 
--							t_bonus_sum,0,0,22, 0, t_textmsg, null, pi_ip);
--					END IF;
					IF po_ret != 0 THEN
						
						LEAVE cursor_loop;
					END IF;
					UPDATE ag_month_contracts SET lastsettletime = CURRENT_TIMESTAMP WHERE id = t_contractid;
				END IF;
			END IF;
			SET t_fromamt_sum = 0;
			SET t_bonusbeforetax_sum = 0;
			SET t_bonus_sum  = 0;
			SET t_timetag = unix_timestamp(now());
			SET t_preagentid = t_agentid;
			SET t_oldtype = t_type;
			SET t_preagent_type = t_agent_type;
		END IF;
		
SELECT po_ret, t_ticket_type, t_order_num;
SELECT t_order_date_add, t_rel_date_add, t_settle_starttime;
		-- �����������ڵĶ���
		-- �������Լ��ʼ��Ķ���
		-- �������û���������Ķ���
		IF po_ret = 0 
			AND t_order_date_add > t_settle_starttime 
			AND t_order_date_add <= t_settle_endtime 
			-- AND t_order_date_add >= t_contract_starttime 
			AND t_order_date_add >= t_rel_date_add 
			THEN
			SET t_fromamt = 0, t_fromamt_hemai = 0;
			IF t_ticket_type = 1 THEN
				-- 竞彩足球
				SELECT `price`, price_one*my_copies INTO t_fromamt, t_fromamt_hemai FROM plans_jczqs WHERE basic_id = t_order_num;
			ELSEIF t_ticket_type = 2 THEN
				-- 足彩
				SELECT `price`, price_one*my_copies INTO t_fromamt, t_fromamt_hemai FROM plans_sfcs WHERE basic_id = t_order_num;
			ELSEIF t_ticket_type = 6 THEN
				-- 竞彩篮球
				SELECT `price`, price_one*my_copies INTO t_fromamt, t_fromamt_hemai FROM plans_jclqs WHERE basic_id = t_order_num;
			ELSEIF t_ticket_type = 7 THEN
				-- 北单
				SELECT `price`, price_one*my_copies INTO t_fromamt, t_fromamt_hemai FROM plans_bjdcs WHERE basic_id = t_order_num;
			ELSEIF t_ticket_type = 8 THEN
				-- 大乐透
				SELECT `rgmoney`, `rgmoney` INTO t_fromamt, t_fromamt_hemai FROM sale_prousers left join plans_basics on sale_prousers.pbid=plans_basics.id WHERE plans_basics.order_num = t_order_num;
			ELSE
				-- ����-δ֪����
				SET po_ret = 2052;
				SET po_msg = concat('ord:[',t_order_num,'] ticket_type unkown:', t_ticket_type);
			END IF;
			IF t_plan_type = 1 THEN
				SET t_fromamt = t_fromamt_hemai;
			END IF;
			IF t_fromamt is null THEN
				SET po_ret = 2057;
				SET po_msg = concat('t_fromamt_hemai is null:',t_ticket_type);
			END IF;
			SET t_fromamt_sum = t_fromamt_sum + t_fromamt;
SELECT t_fromamt, 't_fromamt_sum',t_fromamt_sum, t_order_num;
			
			INSERT INTO ag_settle_month_dtls(masterid, flag, order_num, ticket_type,
				agentid, user_id, fromamt, order_date_add, settletime, client_type)
			VALUES(0, 2, t_order_num, t_ticket_type, t_agentid,
				t_clientid, t_fromamt, t_order_date_add, t_now, t_client_type);
				
			UPDATE plans_basics SET agmretstatus = t_timetag WHERE order_num = t_order_num;
		END IF;
		
	END LOOP cursor_loop;
	CLOSE t_cur;
	SET cursor_end=0;
	
	SET t_preagentid = t_agentid;
	SET t_oldtype = t_type;
	SET t_preagent_type = t_agent_type;
SELECT t_agentid, t_preagentid, t_oldtype;
	IF t_preagentid <> 0 AND po_ret = 0 THEN

				-- Get Month-Contract
				SET t_contractid = 0;
				SET t_rate = 0;
				SET t_taxrate = 0;
				
				SELECT mst.id, mst.taxrate
					INTO t_contractid, t_taxrate
					FROM `ag_month_contracts` mst
				WHERE mst.user_id = t_preagentid 
					AND type = t_oldtype AND flag = 2
					AND contract_type = 0
					AND starttime <= CURRENT_TIMESTAMP
					-- AND lastsettletime < t_timepre2
					ORDER BY starttime DESC limit 1;

SELECT 'GET t_contractid', t_contractid, t_rate;
				IF t_contractid = 0 THEN
					SET po_ret = 2054;
					SET po_msg = CONCAT('contractor not exists for agentid:', t_preagentid);
				ELSE
					-- get Rate by amount of money
					SELECT rate INTO t_rate FROM ag_month_contract_dtls dtl
						WHERE contract_id = t_contractid 
						AND minimum <= t_fromamt_sum AND maximum > t_fromamt_sum
						ORDER BY maximum DESC LIMIT 1;
					IF t_rate = 0 THEN 
						SELECT rate INTO t_rate FROM ag_month_contract_dtls dtl
							WHERE contract_id = t_contractid AND maximum < t_fromamt_sum
							ORDER BY maximum DESC LIMIT 1;
					END IF;
					-- Calc Month-Profits
					SET t_bonusbeforetax_sum = t_fromamt_sum * t_rate ;
					SET t_bonus_sum = t_bonusbeforetax_sum * (1-t_taxrate);
					
					INSERT INTO ag_settle_months(mcid, spid, type, user_id, flag, agent_type,
						rate, fromamt, taxrate, bonusbeforetax, bonus, settletime)
					VALUES(t_contractid, t_spid, t_oldtype, t_preagentid, 2, t_preagent_type, 
						t_rate, t_fromamt_sum, t_taxrate, t_bonusbeforetax_sum, t_bonus_sum, CURRENT_TIMESTAMP);
						
					SELECT last_insert_id() INTO t_id;
					
					UPDATE plans_basics SET agmretstatus = 2 WHERE agmretstatus = t_timetag;
					
					UPDATE ag_settle_month_dtls SET mcid = t_contractid, masterid = t_id, rate = t_rate
						WHERE agentid = t_preagentid AND settletime = t_now AND masterid = 0;
						
					-- ADD AGENT USER_MONEY
--					IF t_bonus_sum != 0 AND t_preagent_type != 2 THEN
--						CALL sp_money_add(po_ret, po_msg, t_preagentid, t_bonus_sum, 
--							t_bonus_sum,0,0,22, 0, t_textmsg, null, pi_ip);
--					END IF;
					
					UPDATE ag_month_contracts SET lastsettletime = CURRENT_TIMESTAMP WHERE id = t_contractid;
				END IF;
	
	END IF;
--	IF po_ret = 0 THEN
--		UPDATE ag_settle_periods SET flag = 0 WHERE spid = t_spid;
--	END IF;
	CALL sp_lock(t_ret,t_msg,'settle',1);
	
	-- COMMIT
	-- SET po_ret = 0;
	IF po_ret <> 0 THEN
		rollback;
	ELSE
		commit;
	END IF;
	select po_ret,po_msg;
	INSERT INTO ag_settle_logs(actname,acttype, po_ret, po_msg,ip) 
		VALUES('sp_settle_month',t_textmsg,po_ret,po_msg,pi_ip);
END;
//
DELIMITER ;