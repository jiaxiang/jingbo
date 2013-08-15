/*

 Store Procedure [sp_money_detail_log] definition

 AUTHOR:	fdy
 CREATE DATE:	2011-10-31
 UPDATE DATE:

 CALL sp_account_dtl_log(@r,@m,414,926,0,0,926,0,1,0);
 DATABASE:caipiao		HOST:

	* 添加详细资金记录
	* @param  	array  t_user_moneys		用户新资金结构体
	* @param  	array  t_old_user_moneys	用户老资金结构体
	* @param  	int    t_user_id	 		用户id
	* @param  	int    t_pid	 			父id t_logobj->id
	* @return 	bool   true or false
 */

DROP PROCEDURE IF EXISTS `sp_account_dtl_log`;
DELIMITER //
CREATE PROCEDURE `sp_account_dtl_log`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_user_id INT,
	IN pi_user_money DECIMAL(11,2),
	IN pi_bonus_money DECIMAL(11,2),
	IN pi_free_money DECIMAL(11,2),
	IN pi_old_user_money DECIMAL(11,2),
	IN pi_old_bonus_money DECIMAL(11,2),
	IN pi_old_free_money DECIMAL(11,2),
	IN pi_account_log_id VARCHAR(36)
)
	NOT DETERMINISTIC
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
	DECLARE t_is_in, t_id INT;
	DECLARE t_money_type VARCHAR(20);
	DECLARE t_change_money DECIMAL(11, 2);
	
	SET t_money_type = '';
	SET t_is_in = 0, t_id=0, po_ret = 0, po_msg = '', t_change_money = 0;

	-- SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
	-- START TRANSACTION;

	IF pi_user_money != pi_old_user_money THEN
		SET t_change_money = pi_user_money - pi_old_user_money;
	    IF (t_change_money < 0) THEN
	        SET t_change_money = t_change_money * -1;
	        SET t_is_in = 1;
	    END IF;
	    SET t_money_type ='USER_MONEY';
	    
	    INSERT INTO money_logs(account_log_id, user_id, log_type, is_in, price, user_money)
	    	VALUES(pi_account_log_id, pi_user_id, t_money_type,t_is_in, t_change_money, pi_old_user_money);
	    SELECT last_insert_id() INTO t_id;
		IF t_id = 0 THEN
			SET po_ret = 2021;
			SET po_msg = "money_logs insert error";
		END IF;
	END IF;
	IF pi_bonus_money != pi_old_bonus_money THEN
	    SET t_change_money = pi_bonus_money - pi_old_bonus_money;
	    IF (t_change_money < 0) THEN
	        SET t_change_money = t_change_money * -1;
	        SET t_is_in = 1;
	    END IF;
	    SET t_money_type ='BONUS_MONEY';
	    
	    INSERT INTO money_logs(account_log_id, user_id, log_type, is_in, price, user_money)
	    	VALUES(pi_account_log_id, pi_user_id, t_money_type,t_is_in, t_change_money, pi_old_user_money);
	    SELECT last_insert_id() INTO t_id;
		IF t_id = 0 THEN
			SET po_ret = 2022;
			SET po_msg = "money_logs insert error";
		END IF;
	END IF;
	IF pi_free_money != pi_old_free_money THEN
	    SET t_change_money = pi_free_money - pi_old_free_money;
	    IF (t_change_money < 0) THEN
	       SET t_change_money = t_change_money * -1;
	       SET t_is_in = 1;
	    END IF;
	    SET t_money_type ='FREE_MONEY';
	    INSERT INTO money_logs(account_log_id, user_id, log_type, is_in, price, user_money)
	    	VALUES(pi_account_log_id, pi_user_id, t_money_type,t_is_in, t_change_money, pi_old_user_money);
	    SELECT last_insert_id() INTO t_id;
		IF t_id = 0 THEN
			SET po_ret = 2023;
			SET po_msg = "money_logs insert error";
		END IF;
	END IF;

	-- COMMIT
--	SET po_ret = 0;
--	IF po_ret <> 0 THEN
--		rollback;
--	ELSE
--		commit;
--	END IF;
--	select po_ret,po_msg;
END;
//
DELIMITER ;