/*
 Store Procedure [sp_settle_realtime_client] definition

 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE:

 CALL sp_settle_realtime_client(@r,@m,'127.0.0.1');
 DATABASE:caipiao		HOST:
 
*/

DROP PROCEDURE IF EXISTS `sp_settle_realtime_client`;
DELIMITER //
CREATE PROCEDURE `sp_settle_realtime_client`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_ip VARCHAR(20)
)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN

	DECLARE t_id, t_newid, t_masterid, t_agentid, t_preagentid, t_clientid, cursor_end, t_ret, t_ticket_type INT UNSIGNED;
	DECLARE t_now DATETIME;
	DECLARE t_agent_type, t_preagent_type, t_client_type TINYINT;
	DECLARE t_order_num BIGINT UNSIGNED;
	DECLARE t_msg, t_textmsg VARCHAR(255);
	DECLARE t_fromamt, t_client_retamt,t_fromamt_sum, t_bonus_sum DECIMAL(10, 3);
	DECLARE t_client_rate DECIMAL(5,3);
	DECLARE t_cur CURSOR FOR
		SELECT dtls.id, dtls.masterid, dtls.agentid, dtls.user_id as clientid, client_rate, 
			dtls.client_retamt,dtls.fromamt, dtls.order_num, agt.agent_type, dtls.ticket_type, dtls.client_type
			FROM ag_settle_realtime_dtls dtls, ag_agents agt
    		WHERE dtls.flag = 4 AND dtls.client_type IN (1, 12)
    			AND dtls.agentid = agt.user_id AND agent_type != 2
    		ORDER BY dtls.agentid, dtls.user_id;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET cursor_end=1;
	-- DECLARE EXIT HANDLER FOR SQLEXCEPTION rollback;

	SET t_now = CURRENT_TIMESTAMP;
	SET po_msg = '', t_msg = '', po_ret = 0, t_ret = 0, t_newid = 0, t_client_type = 0;
	SET t_agentid = 0, t_order_num = 0, t_id = 0, t_masterid = 0, t_ticket_type = 0;
	SET t_client_rate = 0, t_textmsg = '', t_preagentid = 0, t_client_rate=0;
	SET t_agent_type = 0, t_preagent_type = 0;
	SET t_bonus_sum = 0, t_fromamt_sum = 0, t_fromamt = 0;
	SET cursor_end=0;
	
	SELECT textmsg INTO t_textmsg FROM ag_errorcodes WHERE scode = 'sp_settle_realtime_client' LIMIT 1;
	-- SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
	START TRANSACTION;
	
	CALL sp_lock(po_ret,po_msg,'settle',0);
	
	OPEN t_cur;
	cursor_loop:LOOP
		SET cursor_end=0;
		FETCH t_cur INTO t_id, t_masterid, t_agentid, t_clientid, t_client_rate, 
			t_client_retamt,t_fromamt, t_order_num, t_agent_type, t_ticket_type, t_client_type;
		IF cursor_end=1 OR po_ret > 0 THEN
			LEAVE cursor_loop;
		END IF;
SELECT t_agentid, t_preagentid, t_order_num, t_client_retamt;
		IF t_agentid <> t_preagentid THEN
			IF t_preagentid <> 0 THEN
				INSERT INTO ag_settle_realtimes(rcid, type, settletime, user_id, flag, agent_type,
							rate, fromamt, taxrate, bonusbeforetax, bonus)
						VALUES(0, 0, t_now, t_preagentid, 2, t_preagent_type,
							t_client_rate, t_fromamt_sum, 0, -1*t_bonus_sum, -1*t_bonus_sum);
				SELECT last_insert_id() INTO t_newid;
	
				UPDATE ag_settle_realtime_dtls SET masterid = t_newid
							WHERE agentid = t_preagentid AND settletime = t_now AND masterid = 0;
			END IF;
			SET t_preagentid = t_agentid;
			SET t_preagent_type = t_agent_type;
			SET t_fromamt_sum = 0;
			SET t_bonus_sum = 0;
		END IF;
		
		-- �ȿ�Ǯ �ٷ�Ǯ
		SET t_fromamt_sum = t_fromamt_sum + t_fromamt;
		SET t_bonus_sum = t_bonus_sum + t_client_retamt;
SELECT t_bonus_sum, t_fromamt_sum;
		INSERT INTO ag_settle_realtime_dtls(
				settletime, ticket_type, order_num, agentid, user_id, flag, rate, 
				client_type, client_rate, client_retamt, fromamt)
		VALUES(t_now, t_ticket_type, t_order_num, t_agentid, t_clientid, 90, t_client_rate,
				t_client_type, t_client_rate, -1*t_client_retamt, t_fromamt);
		
		IF t_client_retamt != 0 THEN
			CALL sp_update_money(t_ret, t_msg, 1, t_agentid, t_client_retamt, 8, t_order_num, 'BONUS_MONEY', t_textmsg, null, pi_ip);
			IF t_ret > 0 THEN
				SET po_ret = 2081;
				SET po_msg = CONCAT('[', t_ret, '][', t_order_num,'][',t_agentid,']',t_msg);
			END IF;
			IF po_ret = 0 THEN
				CALL sp_money_add(t_ret, t_msg, t_clientid, t_client_retamt,
								0,t_client_retamt,0,8, 0, t_textmsg, null, pi_ip);
				IF t_ret > 0 THEN
					SET po_ret = 2081;
					SET po_msg = CONCAT('[', t_ret, '][', t_order_num,'][',t_clientid,']', t_msg);
				END IF;
			END IF;
		END IF;
		
		UPDATE ag_settle_realtime_dtls SET flag = 6 WHERE flag = 4 AND id = t_id;
		
	END LOOP cursor_loop;
	CLOSE t_cur;
	SET cursor_end=0;
	
	SET t_preagentid = t_agentid;
	SET t_preagent_type = t_agent_type;
	IF po_ret = 0 AND t_preagentid > 0 THEN
	
		INSERT INTO ag_settle_realtimes(rcid, type, settletime, user_id, flag, agent_type,
					rate, fromamt, taxrate, bonusbeforetax, bonus)
				VALUES(0, 0, t_now, t_preagentid, 2, t_preagent_type,
					t_client_rate, t_fromamt_sum, 0, -1*t_bonus_sum, -1*t_bonus_sum);
		SELECT last_insert_id() INTO t_newid;

		UPDATE ag_settle_realtime_dtls SET masterid = t_newid
					WHERE agentid = t_preagentid AND settletime = t_now AND masterid = 0;
	END IF;

	CALL sp_lock(t_ret,t_msg,'settle',1);

	-- COMMIT
	-- SET po_ret = 0;
	IF po_ret <> 0 THEN
		rollback;
	ELSE
		commit;
	END IF;
	
	INSERT INTO ag_settle_logs(actname,acttype, po_ret, po_msg,ip) 
		VALUES('sp_realtime_client',t_textmsg,po_ret,po_msg,pi_ip);
	
	select po_ret,po_msg;
END;
//
DELIMITER ;