/*

 Store Procedure [sp_money_add] definition
 
 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE: 
 
 CALL sp_money_add(@r,@m,416, 5, 2,2,1,21, null, 'testfor 21',null, '127.0.0.1');
 DATABASE:caipiao		HOST:

 * 增加资金
 * 返还资金或充值相关
 * @param  	int    $user_id	 	用户id
 * @param  	int    $money		金额
 * @param  	array  $arrmoney	金额结构体(格式如:array('USER_MONEY'=>10, 'BONUS_MONEY'=>20, 'FREE_MONEY'=>30))
 * @param  	int	   $logtype		日志类型
 * @param  	string $order_num	订单号
 * @param  	string $memo		备注
 * @return	int    $money or error code 大于0 则是成功否则则是失败
 * 				   -1, 参数错误
 * 				   -2, 金额错误
 * 				   -3, 读取用户错误
 * 				   -4, 用户资金异常错误
 * 				   -5, 验证失败
 * 				   -6, 存储错误
 * 				   -7, 更新会员资金错误	
 */
 
DROP PROCEDURE IF EXISTS `sp_money_add`;
DELIMITER //
CREATE PROCEDURE `sp_money_add`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_user_id INT,
	IN pi_money DECIMAL(11,2),
	IN pi_user_money DECIMAL(11,2),
	IN pi_bonus_money DECIMAL(11,2),
	IN pi_free_money DECIMAL(11,2),
	IN pi_logtype INT,
	IN pi_order_num BIGINT,
	IN pi_memo VARCHAR(255),
	IN pi_method VARCHAR(255),
	IN pi_ip VARCHAR(36)
)
	NOT DETERMINISTIC
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN 
	DECLARE t_account_logs_id INT;
	DECLARE t_user_money, t_bonus_money, t_free_money, 
			t_old_user_money, t_old_bonus_money, t_old_free_money, 
			t_all_money DECIMAL(11, 2);
	
	SET t_user_money = 0, t_bonus_money = 0, t_free_money = 0, 
		t_old_user_money = 0, t_old_bonus_money = 0, t_old_free_money = 0, 
		t_all_money=0;
		
	SET t_account_logs_id = 0, po_ret = 0, po_msg = '';
	
	-- 参数检测
	IF pi_user_id <= 0 OR pi_logtype < 0 OR pi_money < 0 THEN
		SET po_ret = 2011;
		SET po_msg = "parament error";
	END IF;
	IF pi_money != (pi_user_money + pi_bonus_money + pi_free_money) THEN
		SET po_ret = 2012;
		SET po_msg = "parament error: pi_money sum";
	END IF;
	
	-- SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
	-- START TRANSACTION;
	
	IF po_ret = 0 THEN
		-- 获取用户所有总资金
		SELECT user_money, bonus_money, free_money INTO t_user_money, t_bonus_money, t_free_money
			FROM users WHERE `id` = pi_user_id;
			
		SET t_old_user_money = t_user_money, t_old_bonus_money = t_bonus_money, t_old_free_money = t_free_money;
		SET t_all_money = t_user_money + t_bonus_money + t_free_money;
		IF t_all_money < 0 THEN
			SET po_ret = 2013;
			SET po_msg = "user_all_money < 0 error";
		END IF;
		IF t_user_money < 0 THEN
			SET po_ret = 2014;
			SET po_msg = "user_money < 0 error";
		END IF;
	END IF;
	
	IF po_ret = 0 THEN	
		INSERT INTO account_logs(order_num, user_id, log_type, is_in, 
				price, user_money, memo, method, ip)
			VALUES(pi_order_num, pi_user_id, pi_logtype, 0, 
				pi_money, t_all_money, pi_memo, pi_method, pi_ip);
		SELECT last_insert_id() INTO t_account_logs_id;
		IF t_account_logs_id = 0 THEN
			SET po_ret = 2015;
			SET po_msg = "account_logs insert error";
		END IF;
	END IF;
	
	-- 更改会员资金
	IF po_ret = 0 THEN
	
		SET t_user_money =  t_user_money + pi_user_money;
		SET t_bonus_money =  t_bonus_money + pi_bonus_money;
		SET t_free_money =  t_free_money + pi_free_money;
		
		UPDATE users SET user_money = t_user_money, 
			bonus_money = t_bonus_money, free_money = t_free_money 
		WHERE id = pi_user_id;
		
		-- 当资金记录有变化时则记录详细日志
		CALL sp_account_dtl_log(po_ret, po_msg, pi_user_id,
	 		t_user_money,t_bonus_money,t_free_money,
	 		t_old_user_money,t_old_bonus_money,t_old_free_money, t_account_logs_id);
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