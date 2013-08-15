/*
 Store Procedure [sp_settle_month_1] definition

 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE:

 CALL sp_settle_month_1(@r,@m,'127.0.0.1');
 DATABASE:caipiao		HOST:
 
 ֻ����7���ڵ����
 ֻ��������������������ļ�¼��
 ����һ���Ƚ�����ͨ�ķ�����㣬�ٽ��г�������Ľ��㣬�������˳�򲢲���ǿ�Ƶģ�Ҳ������©���㡣
 ��ϸ��¼�м�¼�˸�������ķֱ���˵�
 ���Ҫ��һ����ѯ�������������Ҫ��������ʺŲ鿴
 ag_settle_months.flag, 2->5->6 Done
 ag_settle_month_dtls.flag, 99 Done
*/

DROP PROCEDURE IF EXISTS `sp_settle_month_1`;
DELIMITER //
CREATE PROCEDURE `sp_settle_month_1`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_ip VARCHAR(20)
)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN

	DECLARE t_id,t_agentid, t_contractid,cursor_end,t_ret, t_type INT UNSIGNED;
	DECLARE t_now DATETIME;
	DECLARE t_settletime, t_settle_starttime, t_settle_endtime TIMESTAMP;
	DECLARE t_msg, t_textmsg VARCHAR(255);
	DECLARE t_spid VARCHAR(6);
	DECLARE t_fromamt, t_bonusbeforetax, t_bonus_sum DECIMAL(10, 2);
	DECLARE t_rate,t_taxrate DECIMAL(5,3);
	DECLARE t_timepre DATETIME;
	DECLARE t_cur CURSOR FOR
		SELECT user_id, ag_bdtypes.id as `type` FROM ag_agents, ag_bdtypes 
    		WHERE flag = 2 AND agent_type = 1 ORDER BY user_id;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET cursor_end=1;
	-- DECLARE EXIT HANDLER FOR SQLEXCEPTION rollback;

	SET t_now = CURRENT_TIMESTAMP;
	SET po_msg = '', po_ret = 0, t_ret = 0, t_type = 0, t_spid = '';
	SET t_agentid = 0, t_bonus_sum = 0;
	SET t_rate = 0, t_taxrate = 0, t_textmsg = '';
	SET cursor_end=0;
	SET t_timepre = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -7 DAY);
	
	SELECT textmsg INTO t_textmsg FROM ag_errorcodes WHERE scode = 'sp_settle_month_1' LIMIT 1;
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
		FETCH t_cur INTO t_agentid, t_type;
		IF cursor_end=1 OR po_ret > 0 THEN
			LEAVE cursor_loop;
		END IF;
		SET t_contractid = 0;
		SET t_rate = 0;
		SET t_taxrate = 0, t_bonus_sum = 0, t_fromamt = 0, t_bonusbeforetax = 0;
		SET t_id = 0;
		
		SELECT rcontr.id, taxrate
			INTO t_contractid, t_taxrate
		FROM `ag_month_contracts` rcontr
		WHERE rcontr.user_id = t_agentid
			AND `type` = t_type AND flag = 2
			AND starttime < CURRENT_TIMESTAMP
			LIMIT 1;
			
		IF t_contractid = 0 THEN
			SET po_ret = 2072;
			SET po_msg = CONCAT('Contract for super agent[',t_agentid,'] not found. type[', t_type,']');
		ELSE
			
			UPDATE ag_settle_months ar, ag_relations rel 
			SET ar.flag = 5
			WHERE rel.agentid = t_agentid
				AND ar.type = t_type AND rel.flag = 2
				AND ar.agent_type = 2 AND ar.flag = 2
				AND ar.settletime > t_timepre
				AND ar.user_id = rel.user_id;
			
			SET t_bonus_sum = 0, t_fromamt = 0, t_bonusbeforetax = 0;
			
			SELECT sum(fromamt)	INTO t_fromamt
			FROM ag_settle_months ar, ag_relations rel
			WHERE rel.agentid = t_agentid
				AND ar.`type` = t_type AND rel.flag = 2
				AND ar.agent_type = 2 AND ar.flag = 5
				AND ar.user_id = rel.user_id;

			IF t_fromamt = 0 OR t_fromamt is null THEN
				UPDATE ag_settle_months ar, ag_relations rel 
				SET ar.flag = 6
				WHERE rel.agentid = t_agentid
					AND ar.`type` = t_type AND rel.flag = 2
					AND ar.agent_type = 2 AND ar.flag = 5
					AND ar.user_id = rel.user_id;
			ELSE
				-- get Rate by amount of money
				SELECT rate INTO t_rate FROM ag_month_contract_dtls dtl
					WHERE contract_id = t_contractid 
					AND minimum <= t_fromamt AND maximum > t_fromamt
					ORDER BY maximum DESC LIMIT 1;
				IF t_rate = 0 THEN 
					SELECT rate INTO t_rate FROM ag_month_contract_dtls dtl
						WHERE contract_id = t_contractid AND maximum < t_fromamt
						ORDER BY maximum DESC LIMIT 1;
				END IF;
				
				SET t_bonusbeforetax = t_fromamt * t_rate;
				SET t_bonus_sum = t_bonusbeforetax *(1-t_taxrate);
				
				INSERT INTO ag_settle_months(user_id, fromamt, bonusbeforetax, bonus, 
					settletime, agent_type, flag, rate, taxrate, mcid, `type`, spid)
				VALUES( t_agentid, t_fromamt, t_bonusbeforetax, t_bonus_sum, 
					t_now, 1, 2, t_rate, t_taxrate, t_contractid, t_type, t_spid);
				
				SELECT last_insert_id() INTO t_id;
			
				IF t_id = 0 THEN
					SET po_ret = 2071;
					SET po_msg = CONCAT('Agent[',t_agentid, '] INSERT FAIL;');
				ELSE
					INSERT INTO ag_settle_month_dtls(masterid, agentid, user_id, fromamt,
						settletime, flag, rate, mcid, ticket_type, order_num)
					SELECT t_id, t_agentid, ar.user_id, sum(fromamt),
						t_now, 0, t_rate, t_contractid, 99, 0
					FROM ag_settle_months ar, ag_relations rel
					WHERE rel.agentid = t_agentid
						AND ar.`type` = t_type AND rel.flag = 2
						AND ar.agent_type = 2 AND ar.flag = 5
						AND ar.user_id = rel.user_id
						GROUP BY ar.user_id
						ORDER BY ar.id;
					
					UPDATE ag_settle_months ar, ag_relations rel 
					SET ar.flag = 6
					WHERE rel.agentid = t_agentid
						AND ar.`type` = t_type AND rel.flag = 2
						AND ar.agent_type = 2 AND ar.flag = 5
						AND ar.user_id = rel.user_id;
						
					UPDATE ag_month_contracts SET lastsettletime = CURRENT_TIMESTAMP WHERE id = t_contractid;
					
--					IF t_bonus_sum != 0 THEN
--						-- ADD AGENT USER_MONEY
--						CALL sp_money_add(po_ret, po_msg, t_agentid, t_bonus_sum,
--							t_bonus_sum,0,0,21, 0, 'sp_settle_month_1', null, pi_ip);
--					END IF;
				END IF;
			END IF;
		END IF;

	END LOOP cursor_loop;
	CLOSE t_cur;
	SET cursor_end=0;

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
		VALUES('sp_settle_month_1','monthSettle_Super',po_ret,po_msg,pi_ip);
END;
//
DELIMITER ;