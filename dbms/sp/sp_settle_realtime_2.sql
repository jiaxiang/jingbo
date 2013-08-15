/*
 Store Procedure [sp_settle_month_2] definition

 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE:

 CALL sp_settle_realtime_2(@r,@m,'127.0.0.1');
 DATABASE:caipiao		HOST:
 
 只处理7天内的数据
 
 ag_settle_realtime.flag, 2->7 Done
 ag_agent.agent_type = 11 && ag_relations.rel_type
*/

DROP PROCEDURE IF EXISTS `sp_settle_realtime_2`;
DELIMITER //
CREATE PROCEDURE `sp_settle_realtime_2`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_ip VARCHAR(20)
)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN

	DECLARE t_id,t_agentid, t_contractid,cursor_end,t_ret, t_type, t_oldtype, t_clientid INT UNSIGNED;
	DECLARE t_pre_agentid INT UNSIGNED;
	DECLARE t_now DATETIME;
	DECLARE t_settletime, t_settle_starttime, t_settle_endtime TIMESTAMP;
	DECLARE t_msg, t_textmsg VARCHAR(255);
	DECLARE t_spid VARCHAR(6);
	DECLARE t_fromamt, t_fromamt_sum, t_bonus_sum, t_bonus DECIMAL(10, 2);
	DECLARE t_rate DECIMAL(5,3);
	DECLARE t_timepre DATETIME;
	DECLARE t_cur CURSOR FOR
		SELECT rel.agentid, rel.user_id, ag_bdtypes.id as `type` 
			FROM ag_agents agt, ag_relations rel, ag_bdtypes 
    		WHERE agt.agent_type = 11 and rel.client_type = 12 -- new super agent
    		GROUP BY rel.agentid, rel.user_id, ag_bdtypes.id
    		ORDER BY rel.agentid, rel.user_id;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET cursor_end=1;
	-- DECLARE EXIT HANDLER FOR SQLEXCEPTION rollback;

	SET t_now = CURRENT_TIMESTAMP;
	SET t_pre_agentid = 0, t_msg = '';
	SET po_msg = '', po_ret = 0, t_ret = 0, t_type = 0, t_oldtype = 0, t_spid = '';
	SET t_agentid = 0, t_clientid = 0, t_bonus_sum = 0, t_bonus = 0, t_fromamt_sum = 0;
	SET t_rate = 0, t_textmsg = '';
	SET cursor_end=0;
	SET t_timepre = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -7 DAY);
	
	SELECT textmsg INTO t_textmsg FROM ag_errorcodes WHERE scode = 'sp_settle_month_2' LIMIT 1;
	-- SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
	START TRANSACTION;
	
	CALL sp_lock(po_ret,po_msg,'settle',0);
	
	OPEN t_cur;
	cursor_loop:LOOP
		SET cursor_end=0;
		FETCH t_cur INTO t_agentid, t_clientid, t_type;
		
		IF cursor_end=1 OR po_ret > 0 THEN
			LEAVE cursor_loop;
		END IF;
SELECT t_agentid, t_pre_agentid, t_fromamt_sum;
		IF t_agentid <> t_pre_agentid THEN
		
			IF t_pre_agentid = 0 THEN
				INSERT INTO ag_settle_realtimes(user_id, fromamt, bonusbeforetax, bonus, 
					settletime, agent_type, flag, rate, taxrate, rcid, `type`)
				VALUES( t_agentid, 0, 0, 0, 
					t_now, 11, 2, 0, 0, 0, t_type);
				SELECT last_insert_id() INTO t_id;
			ELSE 
				IF t_fromamt_sum = 0 or t_fromamt_sum is null THEN
					DELETE FROM ag_settle_realtimes WHERE id = t_id;
				ELSE
					UPDATE ag_settle_realtimes SET
						fromamt = t_fromamt_sum, bonus = t_bonus_sum
					WHERE id = t_id;
				END IF;
				INSERT INTO ag_settle_realtimes(user_id, fromamt, bonusbeforetax, bonus, 
					settletime, agent_type, flag, rate, taxrate, rcid, `type`)
				VALUES( t_agentid, 0, 0, 0, 
					t_now, 11, 2, 0, 0, 0, t_type);
				SELECT last_insert_id() INTO t_id;
			END IF;
			SET t_bonus_sum = 0;
			SET t_fromamt_sum = 0;
			SET t_pre_agentid = t_agentid;
			SET t_oldtype = t_type;
		END IF;
		
		SET t_bonus = 0, t_fromamt = 0, t_rate = 0;
		
-- SELECT t_id, t_agentid, t_clientid, t_spid, t_textmsg, t_type;

		CALL sp_settle_realtime_2_inner(t_ret, t_msg, t_contractid, t_fromamt, t_bonus, t_rate,
			t_now, t_id, t_agentid, t_clientid, t_spid, t_textmsg, t_type, pi_ip);
select t_ret;		
		IF t_ret > 0 THEN 
			SET po_ret = t_ret;
			SET po_msg = CONCAT('sp_setmonth_client_inner:',t_msg);
		END IF;
		IF t_fromamt IS NULL THEN	SET t_fromamt = 0; END IF;
		IF t_bonus IS NULL THEN	SET t_bonus = 0; END IF;
		
		SET t_fromamt_sum = t_fromamt_sum + t_fromamt;
		SET t_bonus_sum = t_bonus_sum + t_bonus;
		
	END LOOP cursor_loop;
	CLOSE t_cur;
	SET cursor_end=0;

-- SELECT t_id, t_fromamt_sum, t_bonus_sum;
	IF t_id > 0 THEN
		IF t_fromamt_sum = 0 or t_fromamt_sum is null THEN
			DELETE FROM ag_settle_realtimes WHERE id = t_id;
		ELSE
			UPDATE ag_settle_realtimes SET
				fromamt = t_fromamt_sum, bonus = t_bonus_sum
			WHERE id = t_id;
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
		VALUES('sp_setmon_client','monthSettle_Super',po_ret,po_msg,pi_ip);
END;
//
DELIMITER ;

/*

 CALL sp_settle_realtime_2_inner(@r,@m,@cid, @amt, @bamt, @rate,'2011-12-26',65,422,423,'201111','',0,'127.0.0.1');
 DATABASE:caipiao		HOST:
 
 只处理7天内的数据
 
 ag_settle_realtime_dtls.flag, 2->6 Done
*/
DROP PROCEDURE IF EXISTS `sp_settle_realtime_2_inner`;
DELIMITER //
CREATE PROCEDURE `sp_settle_realtime_2_inner`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	OUT po_contractid int,
	OUT po_fromamtsum DECIMAL(10,3),
	OUT po_bonussum DECIMAL(10,3),
	OUT po_rate DECIMAL(10,3),
	IN pi_settletime DATETIME,
	IN pi_masterid int,
	IN pi_agentid int,
	IN pi_clientid int,
	IN pi_spid CHAR(6),
	IN pi_textmsg VARCHAR(50),
	IN pi_type int,
	IN pi_ip varchar(20)
)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
	DECLARE t_id, t_relid, t_ret, t_agent_contract, t_client_contract INT UNSIGNED;
	DECLARE t_now, t_starttime, t_timepre DATETIME;
	DECLARE t_msg VARCHAR(255);
	DECLARE t_agent_rate, t_client_rate DECIMAL(10,3);
	
	SET t_timepre = DATE_ADD(pi_settletime, INTERVAL -7 DAY);

	SET t_now = CURRENT_TIMESTAMP;
	SET po_msg = '', po_ret = 0, t_ret = 0, po_fromamtsum = 0, 
		po_bonussum = 0, po_contractid = 0, po_rate = 0, t_msg = '',
		t_agent_rate = 0, t_client_rate = 0, t_agent_contract = 0, t_client_contract = 0;
	SET t_relid = 0;

	SELECT id, `date_add` INTO t_relid, t_starttime
	FROM ag_relations rel 
		WHERE user_id = pi_clientid 
		AND agentid = pi_agentid -- AND client_type = 1
		ORDER BY id DESC LIMIT 1;
-- select pi_clientid;	
	IF t_relid > 0 THEN
		IF pi_type = 7 THEN
			SELECT SUM(mst.fromamt) INTO po_fromamtsum
			FROM ag_settle_realtimes mst
			WHERE mst.user_id = pi_clientid
				AND mst.flag = 2 
				AND mst.type = 7
				AND mst.settletime >= t_starttime
				AND mst.settletime >= t_timepre
				;
		ELSE
			SELECT SUM(mst.fromamt) INTO po_fromamtsum
			FROM ag_settle_realtimes mst
			WHERE mst.user_id = pi_clientid
				AND mst.flag = 2 
				AND mst.type <> 7
				AND mst.settletime >= t_starttime
				AND mst.settletime >= t_timepre
				;
		END IF;
	ELSE
		SET po_ret = 2093;
		SET po_msg = CONCAT('[2093]Cannot found relation:Agentid:',pi_agentid,' / Clientid:',pi_clientid,'');
	END IF;
	
	IF po_fromamtsum > 0 THEN
	
--		SELECT rcontr.id, rate
--			INTO po_contractid, po_rate
--			FROM `ag_realtime_contracts` rcontr
--		WHERE rcontr.relation_id = t_relid
--			AND type = pi_type AND flag = 2
--			AND contract_type = 2
--			AND starttime < t_now
			-- AND lastsettletime < t_timepre2
--			limit 1;
		
		SELECT rcontr.id, rate
			INTO t_agent_contract, t_agent_rate
			FROM `ag_realtime_contracts` rcontr
		WHERE rcontr.user_id = pi_agentid
			AND type = pi_type AND flag = 2
			AND contract_type = 0
			AND starttime < t_now
			-- AND lastsettletime < t_timepre2
			limit 1;
		SELECT rcontr.id, rate
			INTO t_client_contract, t_client_rate
			FROM `ag_realtime_contracts` rcontr
		WHERE rcontr.user_id = pi_clientid
			AND type = pi_type AND flag = 2
			AND contract_type = 0
			AND starttime < t_now
			-- AND lastsettletime < t_timepre2
			limit 1;
			
		SET po_contractid = t_client_contract;
		SET po_rate = t_agent_rate - t_client_rate;
		
		IF  po_rate IS NULL OR po_rate < 0 OR t_agent_rate IS NULL OR t_client_rate IS NULL THEN
			SET po_ret = 2103;
			SET po_msg = CONCAT('[return rate wrong:', po_ret, '][client:',pi_clientid,']', t_msg);
		END IF;
SELECT po_ret, pi_agentid, pi_clientid, po_fromamtsum, po_contractid, po_rate;

--		IF po_contractid IS NULL OR po_contractid = 0 THEN
--			SET po_ret = 2094;
--			SET po_msg = CONCAT('[2094]Contract not found for Agentid:',pi_agentid);
--		ELSE 
		IF po_ret = 0 THEN
			IF po_rate IS NULL THEN SET po_rate = 0; END IF;

			-- Calc Month-Profits
			SET po_bonussum = po_fromamtsum * po_rate;
SELECT po_rate, po_bonussum, po_fromamtsum;
			IF po_bonussum <> 0 THEN
				INSERT INTO ag_settle_realtime_dtls(masterid, agentid, user_id, fromamt, client_retamt,
					settletime, flag, rate, rcid, ticket_type, order_num, client_type)
				SELECT pi_masterid, pi_agentid, pi_clientid, po_fromamtsum, po_bonussum,
					pi_settletime, 2, po_rate, po_contractid, 99, 0, 11;
					
				CALL sp_money_add(t_ret, t_msg, pi_agentid, po_bonussum,
								0,po_bonussum,0,10, 0, pi_textmsg, null, pi_ip);
				IF t_ret > 0 THEN
					SET po_ret = 2102;
					SET po_msg = CONCAT('[money_add:', t_ret, '][client:',pi_clientid,']', t_msg);
				END IF;
			END IF;
			
			IF pi_type = 7 THEN
				UPDATE ag_settle_realtimes mst
				SET mst.flag = 7
				WHERE mst.user_id = pi_clientid
					AND mst.flag = 2 
					AND mst.type <> 7
					AND mst.settletime >= t_starttime
					AND mst.settletime >= t_timepre
					;
			ELSE
				UPDATE ag_settle_realtimes mst
				SET mst.flag = 7
				WHERE mst.user_id = pi_clientid
					AND mst.flag = 2 
					AND mst.type <> 7
					AND mst.settletime >= t_starttime
					AND mst.settletime >= t_timepre
					;
			END IF;
		
		END IF;	
	END IF;
	
END;
//
DELIMITER ;