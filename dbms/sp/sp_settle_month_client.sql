/*
 Store Procedure [sp_settle_month_client] definition

 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE:

 CALL sp_settle_month_client(@r,@m,'127.0.0.1');
 DATABASE:caipiao		HOST:
 
 ֻ����7���ڵ����
 
 ag_settle_month_dtls.flag, 2->6 Done
*/

DROP PROCEDURE IF EXISTS `sp_settle_month_client`;
DELIMITER //
CREATE PROCEDURE `sp_settle_month_client`(
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
    		WHERE agent_type <> 2 
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
	
	SELECT textmsg INTO t_textmsg FROM ag_errorcodes WHERE scode = 'sp_settle_month_client' LIMIT 1;
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
		FETCH t_cur INTO t_agentid, t_clientid, t_type;
		
		IF cursor_end=1 OR po_ret > 0 THEN
			LEAVE cursor_loop;
		END IF;
-- SELECT t_agentid, t_pre_agentid, t_fromamt_sum;
		IF t_agentid <> t_pre_agentid THEN
		
			IF t_pre_agentid = 0 THEN
				INSERT INTO ag_settle_months(user_id, fromamt, bonusbeforetax, bonus, 
					settletime, agent_type, flag, rate, taxrate, mcid, `type`, spid)
				VALUES( t_agentid, 0, 0, 0, 
					t_now, 1, 2, 0, 0, 0, t_type, t_spid);
				SELECT last_insert_id() INTO t_id;
			ELSE 
				IF t_fromamt_sum = 0 or t_fromamt_sum is null THEN
					DELETE FROM ag_settle_months WHERE id = t_id;
				ELSE
					UPDATE ag_settle_months SET
						fromamt = t_fromamt_sum, bonus = t_bonus_sum
					WHERE id = t_id;
				END IF;
				INSERT INTO ag_settle_months(user_id, fromamt, bonusbeforetax, bonus, 
					settletime, agent_type, flag, rate, taxrate, mcid, `type`, spid)
				VALUES( t_agentid, 0, 0, 0, 
					t_now, 1, 2, 0, 0, 0, t_type, t_spid);
				SELECT last_insert_id() INTO t_id;
			END IF;
			SET t_bonus_sum = 0;
			SET t_fromamt_sum = 0;
			SET t_pre_agentid = t_agentid;
			SET t_oldtype = t_type;
		END IF;
		
		SET t_bonus = 0, t_fromamt = 0, t_rate = 0;
		
-- SELECT t_id, t_agentid, t_clientid, t_spid, t_textmsg, t_type;

		CALL sp_settle_month_client_inner(t_ret, t_msg, t_contractid, t_fromamt, t_bonus, t_rate,
			t_now, t_id, t_agentid, t_clientid, t_spid, t_textmsg, t_type, pi_ip);
		
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
			DELETE FROM ag_settle_months WHERE id = t_id;
		ELSE
			UPDATE ag_settle_months SET
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

 CALL sp_settle_month_client_inner(@r,@m,@cid, @amt, @bamt, @rate,'2011-12-26',65,422,423,'201111','',0,'127.0.0.1');
 DATABASE:caipiao		HOST:
 
 ֻ����7���ڵ����
 
 ag_settle_month_dtls.flag, 2->6 Done
*/
DROP PROCEDURE IF EXISTS `sp_settle_month_client_inner`;
DELIMITER //
CREATE PROCEDURE `sp_settle_month_client_inner`(
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
	DECLARE t_id, t_relid, t_ret INT UNSIGNED;
	DECLARE t_client_type TINYINT UNSIGNED;
	DECLARE t_now, t_starttime DATETIME;
	DECLARE t_msg VARCHAR(255);

	SET t_now = CURRENT_TIMESTAMP;
	SET po_msg = '', po_ret = 0, t_ret = 0, po_fromamtsum = 0, 
		po_bonussum = 0, po_contractid = 0, po_rate = 0, t_msg = '';
	SET t_relid = 0, t_client_type = 0;
	
	SELECT id, `date_add`, client_type INTO t_relid, t_starttime, t_client_type
	FROM ag_relations rel 
		WHERE user_id = pi_clientid 
		AND agentid = pi_agentid -- AND client_type in (1,12)
		ORDER BY id DESC LIMIT 1;
	
	IF t_relid > 0 THEN
		IF pi_type = 7 THEN
			SELECT SUM(dtl.fromamt) INTO po_fromamtsum
			FROM ag_settle_months mst, ag_settle_month_dtls dtl
			WHERE mst.id = dtl.masterid AND mst.spid = pi_spid 
				AND mst.user_id = pi_agentid
				AND dtl.user_id = pi_clientid
				AND mst.flag = 4 --  �Ѿ��ɷ��ļ�¼
				AND dtl.client_type in (1,12)
				AND dtl.ticket_type = 7
				AND dtl.flag = 2
				AND mst.settletime >= t_starttime
				;
		ELSE
			SELECT SUM(dtl.fromamt) INTO po_fromamtsum
			FROM ag_settle_months mst, ag_settle_month_dtls dtl
			WHERE mst.id = dtl.masterid AND mst.spid = pi_spid 
				AND mst.user_id = pi_agentid
				AND dtl.user_id = pi_clientid
				AND mst.flag = 4 --  �Ѿ��ɷ��ļ�¼
				AND dtl.client_type in (1,12)
				AND dtl.ticket_type <> 7
				AND dtl.flag = 2
				AND mst.settletime >= t_starttime
				;
		END IF;
	ELSE
		SET po_ret = 2093;
		SET po_msg = CONCAT('[2093]Cannot found relation:Agentid:',pi_agentid,' / Clientid:',pi_clientid,'');
	END IF;
	
	IF po_fromamtsum > 0 THEN
	
		SELECT rcontr.id INTO po_contractid
		FROM `ag_month_contracts` rcontr
		WHERE rcontr.relation_id = t_relid 
			AND `type` = pi_type AND flag = 2
			AND contract_type = 1
			AND starttime < CURRENT_TIMESTAMP
			LIMIT 1;

-- SELECT pi_agentid, pi_clientid, po_fromamtsum, po_contractid;

--		IF po_contractid IS NULL OR po_contractid = 0 THEN
--			SET po_ret = 2094;
--			SET po_msg = CONCAT('[2094]Contract not found for Agentid:',pi_agentid);
--		ELSE 
			-- get Rate by amount of money
			SELECT rate INTO po_rate FROM ag_month_contract_dtls dtl
				WHERE contract_id = po_contractid 
				AND minimum <= po_fromamtsum AND maximum > po_fromamtsum
				ORDER BY maximum DESC LIMIT 1;
			IF po_rate = 0 THEN 
				SELECT rate INTO po_rate FROM ag_month_contract_dtls dtl
					WHERE contract_id = po_contractid AND maximum < po_fromamtsum
					ORDER BY maximum DESC LIMIT 1;
			END IF;
			IF po_rate IS NULL THEN SET po_rate = 0; END IF;

			-- Calc Month-Profits
			SET po_bonussum = -1 * po_fromamtsum * po_rate;
-- SELECT po_rate, po_bonussum, po_fromamtsum;
			IF po_bonussum <> 0 THEN
				INSERT INTO ag_settle_month_dtls(masterid, agentid, user_id, fromamt, client_retamt,
					settletime, flag, rate, mcid, ticket_type, order_num, client_type)
				SELECT pi_masterid, pi_agentid, pi_clientid, po_fromamtsum, po_bonussum,
					pi_settletime, 0, po_rate, po_contractid, 99, 0, t_client_type;
					
				CALL sp_update_money(t_ret, t_msg, 1, pi_agentid, -1 * po_bonussum, 10, 0, 
					'BONUS_MONEY', pi_textmsg, null, pi_ip);
				IF t_ret > 0 THEN
					SET po_ret = 2091;
					SET po_msg = CONCAT('[money_minus:', t_ret, '][agent:',pi_agentid,']',t_msg);
				END IF;
				IF po_ret = 0 THEN
					CALL sp_money_add(t_ret, t_msg, pi_clientid, -1 * po_bonussum,
									0,-1 * po_bonussum,0,10, 0, pi_textmsg, null, pi_ip);
					IF t_ret > 0 THEN
						SET po_ret = 2092;
						SET po_msg = CONCAT('[money_add:', t_ret, '][client:',pi_clientid,']', t_msg);
					END IF;
				END IF;
			END IF;
			
			IF pi_type = 7 THEN
				UPDATE ag_settle_months mst, ag_settle_month_dtls dtl
				SET dtl.flag = 6
				WHERE mst.id = dtl.masterid AND mst.spid = pi_spid 
					AND mst.user_id = pi_agentid
					AND dtl.user_id = pi_clientid
					AND dtl.client_type in (1,12)
					AND dtl.ticket_type = 7
					AND dtl.flag = 2
					AND mst.settletime >= t_starttime
					;
			ELSE
				UPDATE ag_settle_months mst, ag_settle_month_dtls dtl
				SET dtl.flag = 6
				WHERE mst.id = dtl.masterid AND mst.spid = pi_spid 
					AND mst.user_id = pi_agentid
					AND dtl.user_id = pi_clientid
					AND dtl.client_type in (1,12)
					AND dtl.ticket_type <> 7
					AND dtl.flag = 2
					AND mst.settletime >= t_starttime
					;
			END IF;
		
--		END IF;	
	END IF;
	
END;
//
DELIMITER ;