/*

 Store Procedure [sp_update_money] definition
 
 AUTHOR:	fdy
 CREATE DATE:	2011-10-27
 UPDATE DATE: 
 
 CALL sp_update_money(@r,@m,1,425,3.5,8,0,'BONUS_MONEY','HELLO MEMO','','127.0.0.1');
 DATABASE:caipiao		HOST:

 * ���»�Ա�ʽ�
 * @param	int		pi_is_in  		����0��֧��1
 * @param  	int		pi_user_id	 	�û�id
 * @param  	int		pi_money		���
 * @param  	int		pi_logtype		��־����
 * @param  	string	pi_order_num	������
 * @param  	string	pi_money_type	�ʽ����
 * @param  	string	pi_memo			��ע
 * @return	bool	true or false	�ɹ���ʧ��
 */
 
DROP PROCEDURE IF EXISTS `sp_update_money`;
DELIMITER //
CREATE PROCEDURE `sp_update_money`(
	OUT po_ret INT,
	OUT po_msg VARCHAR(255),
	IN pi_is_in INT,
	IN pi_user_id INT,
	IN pi_money DECIMAL(11,2),
	IN pi_logtype INT,
	IN pi_order_num BIGINT,
	IN pi_money_type VARCHAR(255),
	IN pi_memo VARCHAR(255),
	IN pi_method VARCHAR(255),
	IN pi_ip VARCHAR(36)
)
	NOT DETERMINISTIC
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN 
	DECLARE t_ret, t_account_logs_id INT;
	DECLARE t_user_money, t_bonus_money, t_free_money, 
			t_old_user_money, t_old_bonus_money, t_old_free_money, 
		t_all_money, t_all_money2, t_delmoney DECIMAL(11, 2);
	DECLARE t_msg VARCHAR(255);
	
	SET t_user_money = 0, t_bonus_money = 0, t_free_money = 0, 
		t_old_user_money = 0, t_old_bonus_money = 0, t_old_free_money = 0, 
		t_all_money=0, t_all_money2 = 0, t_delmoney = 0;
		
	SET t_account_logs_id = 0, t_ret = 0, po_ret = 0, po_msg = '', t_msg = '';
	
	IF pi_money_type is null THEN SET pi_money_type = ''; END IF;
	
	SET pi_money_type = upper(pi_money_type);
	
	-- �ʽ�����������
	IF po_ret=0 AND pi_money_type != '' THEN
		IF pi_money_type NOT IN ('USER_MONEY', 'BONUS_MONEY', 'FREE_MONEY') THEN
			SET po_ret = 2032;
			SET po_msg = "pi_money_type error";
		END IF;
	END IF;
	
	-- SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
	-- START TRANSACTION;
	
	-- �������
	IF (pi_user_id <= 0 OR pi_is_in < 0 OR pi_logtype < 0 OR pi_money < 0) THEN
		SET po_ret = 2031;
		SET po_msg = "parament error";
	END IF;
	
	-- ������ʱ�ʽ����Ϊ����Ĭ��Ϊ����
	IF pi_is_in = 0 AND pi_money_type = '' THEN
		SET pi_money_type = 'USER_MONEY';
	END IF;
	IF pi_method is null THEN
		SET pi_method = 'CALL sp_update_money;';
	END IF;
	
	IF po_ret = 0 THEN
		-- ��ȡ�û��������ʽ�
		SELECT user_money, bonus_money, free_money INTO t_user_money, t_bonus_money, t_free_money
			FROM users WHERE `id` = pi_user_id;
			
		SET t_old_user_money = t_user_money, t_old_bonus_money = t_bonus_money, t_old_free_money = t_free_money;
		SET t_all_money = t_user_money + t_bonus_money + t_free_money;
		SET t_all_money2 = t_all_money;
		IF t_all_money < 0 THEN
			SET po_ret = 2033;
			SET po_msg = "user_all_money < 0 error";
		END IF;
	END IF;
	
	IF po_ret = 0 THEN	
		IF pi_is_in = 0 THEN
			SET t_all_money2 = t_all_money2 + pi_money;
		ELSE
			SET t_all_money2 = t_all_money2 - pi_money;
		END IF;
		IF t_all_money2 < 0 THEN
			SET po_ret = 2034;
			SET po_msg = "user_all_money < 0 error";
		END IF;
	END IF;
	
	-- ����ָ���ʽ����ʱ��Ҫ�ٴμ������Ƿ���
	IF po_ret = 0 THEN
	IF pi_is_in = 1 THEN
		IF pi_money_type = 'USER_MONEY' THEN
			SET t_user_money =  t_user_money - pi_money;
			IF t_user_money < 0 THEN
				SET po_ret = 2035;
				SET po_msg = "t_user_money < 0 error";
			END IF;
		ELSEIF pi_money_type = 'BONUS_MONEY' THEN
			SET t_bonus_money =  t_bonus_money - pi_money;
			IF t_bonus_money < 0 THEN
				SET po_ret = 2036;
				SET po_msg = "t_bonus_money < 0 error";
			END IF;
		ELSEIF pi_money_type = 'FREE_MONEY' THEN
			SET t_free_money =  t_free_money - pi_money;
			IF t_free_money < 0 THEN
				SET po_ret = 2037;
				SET po_msg = "t_free_money < 0 error";
			END IF;
		ELSE
			-- ��δָ���ʽ�����ʱ ����=>����=>�ʽ�ۿ�
			SET t_user_money = t_user_money - pi_money;
			IF t_user_money < 0 THEN
				SET t_delmoney = t_user_money;
				SET t_user_money = 0;
				SET t_bonus_money = t_bonus_money + t_delmoney;
				
				IF t_bonus_money < 0 THEN
					SET t_delmoney = t_bonus_money;
					SET t_bonus_money = 0;
					SET t_free_money = t_free_money + t_delmoney;
					
					-- �����쳣
					IF t_free_money < 0 THEN
						SET po_ret = 2038;
						SET po_msg = "t_free_money < 0 error";
					END IF;
				END IF;
			END IF;
		END IF;
	ELSE
		IF pi_money_type = 'USER_MONEY' THEN
			SET t_user_money =  t_user_money + pi_money;
		ELSEIF pi_money_type = 'BONUS_MONEY' THEN
			SET t_bonus_money =  t_bonus_money + pi_money;
		ELSEIF pi_money_type = 'FREE_MONEY' THEN
			SET t_free_money =  t_free_money + pi_money;
		END IF;
	END IF;
	END IF;
	
	IF po_ret = 0 THEN	
	
		INSERT INTO account_logs(order_num, user_id, log_type, is_in, 
				price, user_money, memo, method, ip)
			VALUES(pi_order_num, pi_user_id, pi_logtype, pi_is_in, 
				pi_money, t_all_money, pi_memo, pi_method, pi_ip);
		SELECT last_insert_id() INTO t_account_logs_id;
		IF t_account_logs_id = 0 THEN
			SET po_ret = 2039;
			SET po_msg = "account_logs insert error";
		END IF;
	END IF;
	
	-- ���Ļ�Ա�ʽ�
	IF po_ret = 0 THEN
		UPDATE users SET user_money = t_user_money, 
			bonus_money = t_bonus_money, free_money = t_free_money 
		WHERE id = pi_user_id;
	END IF;
	
	-- ���ʽ��¼�б仯ʱ���¼��ϸ��־
	IF po_ret = 0 THEN
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