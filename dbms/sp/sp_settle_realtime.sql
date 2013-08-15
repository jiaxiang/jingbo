/*
 Store Procedure [sp_settle_realtime] definition

 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE:

 CALL sp_settle_realtime(@r,@m,'127.0.0.1');
 DATABASE:caipiao		HOST:

*/

DROP PROCEDURE IF EXISTS `sp_settle_realtime`;
DELIMITER //
CREATE PROCEDURE `sp_settle_realtime`(
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
	DECLARE t_order_num BIGINT UNSIGNED;
	DECLARE t_type, t_oldtype, cursor_end, t_agent_type, t_preagent_type, 
		t_client_type,t_flag, t_plan_type TINYINT UNSIGNED;
	DECLARE t_now, t_timepre, t_timepre2 DATETIME;

	DECLARE t_msg, t_textmsg VARCHAR(255);
	DECLARE t_rate, t_taxrate, t_client_rate, t_client_rate_beidan DECIMAL(5, 3);
	DECLARE t_fromamt, t_fromamt_hemai, t_fromamt_sum, t_bonusbeforetax_sum, t_bonus_sum DECIMAL(12, 3);
	
	DECLARE t_cur CURSOR FOR
		SELECT bsc.id, bsc.plan_type, rel.agentid, bsc.order_num, bsc.ticket_type, 
			bsc.play_method, bsc.user_id, ag_agents.agent_type, rel.client_type, rel.client_rate, rel.client_rate_beidan
		FROM `plans_basics` bsc, ag_relations rel, ag_agents
    		WHERE (bsc.`status` >= 2 and bsc.`status` <=5)
--    		AND bsc.`date_add` > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -3 HOUR)
    		AND bsc.`date_add` >= rel.date_add
    		AND bsc.user_id = rel.user_id AND ag_agents.user_id = rel.agentid
    		AND ag_agents.flag = 2
    		AND ag_agents.agent_type <> 1
    		AND agrretstatus = 0
    		AND rel.flag = 2
    		AND (bsc.ticket_type = 1 or bsc.ticket_type = 2 or bsc.ticket_type = 6 or bsc.ticket_type = 7 or bsc.ticket_type = 8)
    	ORDER BY rel.agentid, bsc.ticket_type, id;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET cursor_end=1;
	-- DECLARE EXIT HANDLER FOR SQLEXCEPTION rollback;

	SET t_timepre = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -7 DAY);
	SET t_timepre2 = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -30 MINUTE);
	SET t_now = CURRENT_TIMESTAMP;
	SET t_timetag = unix_timestamp(now());
	SET po_msg = '', t_msg = '', po_ret = 0, t_agent_type = 0, t_textmsg='',
		t_id = 0, t_type = 0, t_oldtype = 0, t_ret = 0, t_rate = 0, t_preagent_type = 0;
	SET t_clientid = 0, t_agentid = 0, t_preagentid = 0, t_fromamt = 0, t_fromamt_hemai = 0, 
		t_client_rate = 0, t_client_rate_beidan = 0, t_client_type = 0, t_plan_type = 0;
	SET t_fromamt_sum = 0, t_bonusbeforetax_sum = 0, t_bonus_sum  = 0, t_flag = 2;
	SET cursor_end=0;
	
	SELECT textmsg INTO t_textmsg FROM ag_errorcodes WHERE scode = 'sp_settle_realtime' LIMIT 1;
	-- SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
	START TRANSACTION;
	
	CALL sp_lock(po_ret,po_msg,'settle',0);
	
	OPEN t_cur;
	cursor_loop:LOOP
		SET cursor_end=0;
		FETCH t_cur INTO t_planid, t_plan_type, t_agentid, t_order_num, 
			t_ticket_type, t_play_method, t_clientid, t_agent_type, t_client_type, t_client_rate, t_client_rate_beidan;
		-- Get Contract Type
		SET t_type = 0;
		IF t_ticket_type = 7 THEN SET t_type = 7; END IF;
		IF cursor_end=1 OR po_ret > 0 THEN
SELECT 'LEAVE:',t_order_num;
			LEAVE cursor_loop;
		END IF;
SELECT 'IN LOOP', t_agentid, t_preagentid;

		IF t_agentid <> t_preagentid OR t_type <> t_oldtype THEN
			IF t_preagentid <> 0 THEN
				-- Get RealTime-Contract
				SET t_contractid = 0;
				SET t_rate = 0;
				SET t_taxrate = 0;

				SELECT rcontr.id, taxrate, rate
					INTO t_contractid, t_taxrate, t_rate
					FROM `ag_realtime_contracts` rcontr
				WHERE rcontr.user_id = t_preagentid
					AND type = t_oldtype AND flag = 2
					AND starttime < CURRENT_TIMESTAMP
					-- AND lastsettletime < t_timepre2
					limit 1;
SELECT 't_contractid: ', t_contractid;
				IF t_contractid = 0 THEN
					SET po_ret = 2041;
					SET po_msg = CONCAT('contractor not exists for agentid:', t_preagentid);
				ELSE
					-- Calc RealTime-Profits
					SET t_bonusbeforetax_sum = t_fromamt_sum * t_rate ;
					SET t_bonus_sum = t_bonusbeforetax_sum * (1-t_taxrate);

					INSERT INTO ag_settle_realtimes(rcid, type, settletime, user_id, flag, agent_type,
						rate, fromamt, taxrate, bonusbeforetax, bonus)
					VALUES(t_contractid, t_oldtype, t_now, t_preagentid, 2, t_preagent_type,
						t_rate, t_fromamt_sum, t_taxrate, t_bonusbeforetax_sum, t_bonus_sum);
					
					SELECT last_insert_id() INTO t_id;

					UPDATE plans_basics SET agrretstatus = 2 WHERE agrretstatus = t_timetag;
					
					UPDATE ag_settle_realtime_dtls SET rcid = t_contractid, masterid = t_id, rate = t_rate
						WHERE agentid = t_preagentid AND settletime = t_now AND masterid = 0;
						
					-- ADD AGENT BONUS_MONEY
					IF t_bonus_sum != 0 AND t_preagent_type != 2 THEN
						CALL sp_money_add(po_ret, po_msg, t_preagentid, t_bonus_sum,
							0,t_bonus_sum,0,8, 0, t_textmsg, null, pi_ip);
					END IF;
					
					IF po_ret != 0 THEN

						LEAVE cursor_loop;
					END IF;
					UPDATE ag_realtime_contracts SET lastsettletime = CURRENT_TIMESTAMP WHERE id = t_contractid;
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

SELECT 't_ticket_type,ORDNUM', t_ticket_type, t_order_num;
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
			SET po_ret = 2042;
			SET po_msg = concat('Unknow ticket_type:',t_ticket_type);
		END IF;
		IF t_plan_type = 1 THEN
			SET t_fromamt = t_fromamt_hemai;
		END IF;
		IF t_fromamt is null THEN
			SET po_ret = 2044;
			SET po_msg = concat('Unknow ticket_type:',t_ticket_type);
		END IF;
		
		SET t_fromamt_sum = t_fromamt_sum + t_fromamt;

		-- IF t_client_type = 1 OR t_client_type = 11 OR t_client_type = 12 THEN
		IF t_client_type = 1 OR t_client_type = 12 THEN
			SET t_flag = 4;
		ELSE
			SET t_flag = 2;
		END IF;
		IF t_type = 7 THEN SET t_client_rate = t_client_rate_beidan; END IF;
		
SELECT t_fromamt, t_fromamt_sum, t_client_type, t_flag, t_client_rate;

		INSERT INTO ag_settle_realtime_dtls(
				settletime, ticket_type, order_num, agentid, user_id, flag, rate, 
				client_type, client_rate, client_retamt, fromamt)
		VALUES(t_now, t_ticket_type, t_order_num, t_agentid, t_clientid, t_flag, 0,
				t_client_type, t_client_rate, t_fromamt*t_client_rate, t_fromamt);
		
		UPDATE plans_basics SET agrretstatus = t_timetag WHERE order_num = t_order_num;

	END LOOP cursor_loop;
	CLOSE t_cur;
	SET cursor_end=0;

	SET t_preagentid = t_agentid;
	SET t_oldtype = t_type;
	SET t_preagent_type = t_agent_type;
SELECT t_agentid, t_preagentid, t_oldtype;
	IF t_preagentid <> 0 AND po_ret = 0 THEN

				-- Get RealTime-Contract
				SET t_contractid = 0;
				SET t_rate = 0;
				SET t_taxrate = 0;

				SELECT rcontr.id, taxrate, rate
					INTO t_contractid, t_taxrate, t_rate
					FROM `ag_realtime_contracts` rcontr
				WHERE rcontr.user_id = t_preagentid
					AND type = t_oldtype AND flag = 2
					AND starttime < CURRENT_TIMESTAMP
					-- AND lastsettletime < t_timepre2
					limit 1;

SELECT 'GET t_contractid', t_contractid, t_rate;
				IF t_contractid = 0 THEN
					SET po_ret = 2043;
					SET po_msg = CONCAT('contractor not exists for agentid:', t_preagentid);
				ELSE
					-- Calc RealTime-Profits
					SET t_bonusbeforetax_sum = t_fromamt_sum * t_rate ;
					SET t_bonus_sum = t_bonusbeforetax_sum * (1-t_taxrate);

					INSERT INTO ag_settle_realtimes(rcid, type, settletime, user_id, flag, agent_type,
						rate, fromamt, taxrate, bonusbeforetax, bonus)
					VALUES(t_contractid, t_oldtype, t_now, t_preagentid, 2, t_preagent_type,
						t_rate, t_fromamt_sum, t_taxrate, t_bonusbeforetax_sum, t_bonus_sum);

					SELECT last_insert_id() INTO t_id;

					UPDATE plans_basics SET agrretstatus = 2 WHERE agrretstatus = t_timetag;
					
					UPDATE ag_settle_realtime_dtls SET rcid = t_contractid, masterid = t_id, rate = t_rate
						WHERE agentid = t_preagentid AND settletime = t_now AND masterid = 0;

					-- ADD AGENT BONUS_MONEY
					IF t_bonus_sum != 0 AND t_preagent_type != 2 THEN
						CALL sp_money_add(po_ret, po_msg, t_preagentid, t_bonus_sum,
							0,t_bonus_sum,0,8, 0, t_textmsg, null, pi_ip);
					END IF;
					UPDATE ag_realtime_contracts SET lastsettletime = CURRENT_TIMESTAMP WHERE id = t_contractid;
					
				END IF;

	END IF;
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
		VALUES('sp_settle_realtime',t_textmsg,po_ret,po_msg,pi_ip);
END;
//
DELIMITER ;