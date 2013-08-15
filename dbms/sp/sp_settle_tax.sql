/*
 Store Procedure [sp_settle_month_1] definition

 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE:

 CALL sp_settle_tax(@r,@m,'127.0.0.1');
 DATABASE:caipiao		HOST:
 
 ���������½�ͼ�ʱ�����˰�ʷ���
 ���մ����ά�Ƚ��н��㣬����ֱ���������ͨ����
 ����ʱ���½����ڽ��м��㣬��settletimeΪ׼
 http://sz.bendibao.com/cyfw/grsds.asp
 
*/

DROP PROCEDURE IF EXISTS `sp_settle_tax`;
DELIMITER //
CREATE PROCEDURE `sp_settle_tax`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_ip VARCHAR(20)
)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN

	DECLARE t_id, t_subm ,t_agentid, cursor_end, t_ret, t_agent_type INT UNSIGNED;
	DECLARE t_now DATETIME;
	DECLARE t_settletime, t_settle_starttime, t_settle_endtime TIMESTAMP;
	DECLARE t_msg, t_textmsg VARCHAR(255);
	DECLARE t_spid VARCHAR(6);
	DECLARE t_fromamt, t_fromamt2, t_fromamt3, t_tax_sum, t_tax_low1 DECIMAL(10, 3);
	DECLARE t_taxrate DECIMAL(6,3);
	DECLARE t_cur CURSOR FOR
		SELECT user_id, agent_type FROM ag_agents 
    		WHERE agent_type <> 12 ORDER BY user_id;

	DECLARE CONTINUE HANDLER FOR NOT FOUND SET cursor_end=1;
	-- DECLARE EXIT HANDLER FOR SQLEXCEPTION rollback;

	SET t_now = CURRENT_TIMESTAMP;
	SET po_msg = '', po_ret = 0, t_ret = 0, t_spid = '', t_msg = '';
	SET t_agentid = 0, t_tax_sum = 0, t_agent_type = 0;
	SET t_taxrate = 0, t_textmsg = '';
	SET cursor_end=0;
	
	SET t_tax_low1 = 1; -- 800;
	
	SELECT textmsg INTO t_textmsg FROM ag_errorcodes WHERE scode = 'sp_settle_tax' LIMIT 1;
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
		FETCH t_cur INTO t_agentid, t_agent_type;
		IF cursor_end=1 OR po_ret > 0 THEN
			LEAVE cursor_loop;
		END IF;
		
		SET t_id = 0;
		SELECT id INTO t_id FROM ag_settle_months 
		WHERE taxflag = 90
			AND spid = t_spid
			AND user_id = t_agentid;
		IF t_id > 0 THEN
			SET po_ret = 2091;
			SET po_msg = concat('tax[',t_spid,']set_mon.id: ',t_id,'/agentid:',t_agentid);
			-- DELETE FROM ag_settle_months WHERE flag = 10 AND user_id = t_agentid AND spid = t_spid;
		END IF;
		
		-- month
		SET t_tax_sum = 0;
		SET t_fromamt = 0, t_fromamt3 = 0;
		
		SELECT sum(bonus) INTO t_fromamt
		FROM ag_settle_months ar
		WHERE user_id = t_agentid AND ar.taxflag = 2
			AND spid = t_spid;
		IF t_fromamt is null THEN 
			SET t_fromamt = 0; 
		END IF;
		
		-- realtime
		SET t_fromamt2 = 0;
		
		SELECT sum(bonus) INTO t_fromamt2
		FROM ag_settle_realtimes ar
		WHERE user_id = t_agentid AND ar.taxflag = 2
			AND ar.settletime > t_settle_starttime
			AND ar.settletime <= t_settle_endtime;
		IF t_fromamt2 is null THEN 
			SET t_fromamt2 = 0; 
		END IF;
		
		SET t_fromamt3 = t_fromamt + t_fromamt2 - t_tax_low1;
select 	t_agentid, t_fromamt,t_fromamt2,t_fromamt3;

		IF t_fromamt3 > 0 THEN
			SET t_id = 0;
			SET t_taxrate = 0, t_subm = 0;
			
			SELECT taxrate, subm INTO t_taxrate, t_subm 
				FROM ag_taxrate 
				WHERE lowx < t_fromamt3 AND highx >= t_fromamt3 LIMIT 1;
				
			SET t_tax_sum = t_fromamt3 * t_taxrate - t_subm;
select t_taxrate,t_tax_sum;
			INSERT INTO ag_settle_months(user_id, fromamt, bonusbeforetax, bonus, 
				settletime, agent_type, flag, rate, taxrate, mcid, `type`, spid, taxflag)
			VALUES( t_agentid, t_fromamt + t_fromamt2, 0, -1*t_tax_sum, 
				t_now, t_agent_type, 2, 0, t_taxrate, 0, 0, t_spid, 90);
			
			SELECT last_insert_id() INTO t_id;
		
			IF t_id = 0 THEN
				SET po_ret = 2071;
				SET po_msg = CONCAT('Agent[',t_agentid, '] INSERT FAIL;');
			ELSE
				IF t_fromamt > 0 THEN
					INSERT INTO ag_settle_month_dtls(masterid, agentid, user_id, fromamt,
							settletime, flag, rate, mcid, ticket_type, order_num)
					SELECT t_id, t_agentid, t_agentid, t_fromamt,
							t_now, 10, 0, 0, 99, 0;
				END IF;
				IF t_fromamt2 > 0 THEN
					INSERT INTO ag_settle_realtime_dtls(masterid, agentid, user_id, fromamt,
							settletime, flag, rate, rcid, ticket_type, order_num)
					SELECT t_id, t_agentid, t_agentid, t_fromamt2,
							t_now, 10, 0, 0, 99, 0;
				END IF;
			END IF;
		END IF;
		
		UPDATE ag_settle_months ar SET ar.taxflag = 0
		WHERE user_id = t_agentid AND ar.taxflag = 2
			AND spid = t_spid;
			
		UPDATE ag_settle_realtimes ar SET ar.taxflag = 0
		WHERE user_id = t_agentid AND ar.taxflag = 2
			AND ar.settletime > t_settle_starttime
			AND ar.settletime <= t_settle_endtime;

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
	
	INSERT INTO ag_settle_logs(actname,acttype, po_ret, po_msg,ip) 
		VALUES('sp_settle_tax', t_textmsg, po_ret,po_msg,pi_ip);

	select po_ret,po_msg;

END;
//
DELIMITER ;