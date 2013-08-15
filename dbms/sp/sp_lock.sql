/*
 Store Procedure [sp_lock] definition

 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE:

 CALL sp_lock(@r,@m,'aaa',0);
 DATABASE:caipiao		HOST:
 
	处理时锁定重复调用的情况。
*/

DROP PROCEDURE IF EXISTS `sp_lock`;
DELIMITER //
CREATE PROCEDURE `sp_lock`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_pkey VARCHAR(20),
	IN pi_act INT -- 0: get lock ; 1: release lock;  
)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
	DECLARE t_cnt INT;
	DECLARE t_flag TINYINT UNSIGNED;
	DECLARE t_pre TIMESTAMP;
	SET po_ret = 0; 
	SET po_msg = '';
	SELECT count(1) INTO t_cnt FROM ag_locks WHERE pkey = pi_pkey;
	IF pi_act = 0 THEN
		IF t_cnt > 0 THEN 
			SELECT flag, add_time INTO t_flag, t_pre FROM ag_locks WHERE pkey = pi_pkey;
			SET po_ret = 2061;
			SET po_msg = CONCAT('LOCK BY OTHER ', pi_pkey , ' - ' , t_pre);
		ELSE
			INSERT INTO ag_locks (pkey,flag) VALUES(pi_pkey, 2);
		END IF;
	ELSE
		DELETE FROM ag_locks WHERE pkey = pi_pkey;
	END IF;
	
--	select po_ret,po_msg;
END;
//
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_geterrormsg`;
DELIMITER //
CREATE PROCEDURE `sp_geterrormsg`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_code VARCHAR(45)
)
    NOT DETERMINISTIC
    SQL SECURITY DEFINER
    COMMENT ''
BEGIN
	SET po_ret = 1;
	SET po_msg = '';
	IF pi_code is null OR pi_code = '' THEN
		SET po_ret = 2;
	ELSE
		SELECT textmsg,0 INTO po_msg,po_ret FROM ag_errorcodes WHERE scode = pi_code LIMIT 1;
	END IF;
--	select po_ret,po_msg;
END;
//
DELIMITER ;
