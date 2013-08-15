/* Function  structure for function  `expenses` */

/*!50003 DROP FUNCTION IF EXISTS `expenses` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `expenses`(money decimal(11,2),uid int,ordernum bigint,ppid int,bdflag tinyint) RETURNS varchar(30) CHARSET utf8
BEGIN
        declare result varchar(30); -- 返回字串
        declare umoney decimal(11,2); -- 用户余额
        declare bmoney decimal(11,2); -- 用户奖金余额
	declare fmoney decimal(11,2); -- 用户赠送余额
	declare mflag tinyint default 0; -- 扣款标记
	declare logtype tinyint default 2; -- 记录类型
	-- DECLARE bflag TINYINT default 0;
	-- DECLARE fflag TINYINT default 0;
	DECLARE ferrFlg INT;
        DECLARE CONTINUE HANDLER FOR SQLWARNING SET ferrFlg = 1;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET ferrFlg = 2;
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET ferrFlg = 3;
	set ferrFlg = 0;
        if bdflag <> 0 then
		set logtype = 10;
	end if;
        -- 查询用户余额
        SELECT user_money,bonus_money,free_money INTO umoney,bmoney,fmoney FROM users u WHERE u.id=uid FOR UPDATE;
        if umoney<0 || bmoney<0 || fmoney<0 then
		-- set result = '用户资金异常';
		set ferrFlg = 5;-- 用户资金异常
        else
		IF (umoney+bmoney+fmoney)<money THEN
		    -- SET result = '用户余额不足';
		    SET ferrFlg = 6;
		ELSE
		   -- 执行扣款
		   IF umoney>=money THEN -- 用户余额足够
			update users u set `user_money` = umoney-money where u.id = uid;
			set mflag = 1;
		   ELSE
			IF umoney+bmoney >= money THEN -- 用户余额+用户奖金足够
				update users u set `user_money`=0,`bonus_money`=(umoney+bmoney-money) where u.id = uid;
				SET mflag = 2;
			ELSE -- 三种资金
				update users u set `user_money`=0,`bonus_money`=0,`free_money`=(umoney+bmoney+fmoney-money) where u.id = uid ;
	                        SET mflag = 3;
			END IF;
		   END IF;
	           -- 写交易记录 account_logs
	           insert into account_logs (`order_num`,`user_id`,`log_type`,`is_in`,`price`,`user_money`,`add_time`,`pmid`,`memo`) 
	                             values (ordernum,uid,logtype,1,money,umoney+bmoney+fmoney,now(),ppid,@amemo);
	           set @accid = LAST_INSERT_ID();
	           -- money_logs  
	           if mflag = 1 then -- 用户余额足够
			INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
	                                VALUES (@accid,uid,'USER_MONEY',1,money,umoney,NOW());
	           elseif mflag = 2 then -- 用户余额+奖金余额足够
	                if umoney>0 then -- 扣用户金额及奖金金额
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'USER_MONEY',1,umoney,umoney,NOW());
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'BONUS_MONEY',1,money-umoney,bmoney,NOW());
	                else -- 只扣奖金
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
	                                        VALUES (@accid,uid,'BONUS_MONEY',1,money,bmoney,NOW());
	                end if;
	           else -- 三种余额总和足够
	                IF umoney>0 THEN -- 用户余额大于0
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'USER_MONEY',1,umoney,umoney,NOW());
				if bmoney>0 then -- 三种资金全扣
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'BONUS_MONEY',1,bmoney,bmoney,NOW());
	                                INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'FREE_MONEY',1,money-umoney-bmoney,fmoney,NOW());
	                        else -- 只扣用户余额及free余额
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'FREE_MONEY',1,money-umoney,fmoney,NOW());
	                        end if;
	                else -- 用户余额为0
	                      IF bmoney>0 THEN --
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'BONUS_MONEY',1,bmoney,bmoney,NOW());
	                        INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'FREE_MONEY',1,money-bmoney,fmoney,NOW());
	                      else 
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'FREE_MONEY',1,money,fmoney,NOW());
	                      end if;
				
	                end if;
		   
	           end if;
	                 
		END IF;
        end if;
	-- 捕获异常
	IF (ferrFlg <> 0) THEN 
		-- 发生数据库异常
		SET result = '数据异常';
	ELSE
		SET result = 'succ';
        END IF;
        
        RETURN result;
 
    END */$$
DELIMITER ;

/* Function  structure for function  `getusermoney` */

/*!50003 DROP FUNCTION IF EXISTS `getusermoney` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `getusermoney`(user_id int) RETURNS decimal(11,2)
BEGIN
    
        DECLARE umoney DECIMAL(11,2); -- 用户余额
        DECLARE bmoney DECIMAL(11,2); -- 用户奖金余额
	DECLARE fmoney DECIMAL(11,2); -- 用户赠送余额
	
	
	DECLARE money DECIMAL(11,2); -- 用户余额
	
	SELECT user_money,bonus_money,free_money INTO umoney,bmoney,fmoney FROM users u WHERE u.id=user_id FOR UPDATE;	
	
	set money = (umoney+bmoney+fmoney);	
	
	RETURN money;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `auto_order` */

/*!50003 DROP PROCEDURE IF EXISTS  `auto_order` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `auto_order`(    -- in lotyid int,-- 彩种ID
							-- in playid int,-- 玩法ID
							-- in pid bigint(11),-- 方案ID
							-- in pordernum bigint,-- 方案编号 
							-- in fuid int,-- 发起人ID
							-- in uid int,-- 定制人ID
							-- IN jobid int-- 自动跟单JOB ID
							IN jobid INT, -- 自动跟单JOB ID
							IN pid INT,-- 方案ID
							IN lotyid INT,-- 彩种ID
							IN playid INT
							
)
BEGIN
	-- user
	DECLARE umoney DECIMAL(11,2) DEFAULT 0.00; -- 用户余额
        DECLARE bmoney DECIMAL(11,2) DEFAULT 0.00; -- 用户奖金余额
	DECLARE fmoney DECIMAL(11,2) DEFAULT 0.00; -- 用户赠送余额
	
	-- jczq jclq
	DECLARE psurplus INT(11);
	DECLARE ppprice_one DECIMAL(12,3); 
	DECLARE ptotal_price  DECIMAL(12,3);
	DECLARE pfriends TEXT;
	DECLARE ptime_end TIMESTAMP;
	DECLARE pordernum BIGINT;
	DECLARE pfuid BIGINT;
	DECLARE pjcases VARCHAR(1000);
	DECLARE pjtypename VARCHAR(255);
	DECLARE pjrate INT;
	DECLARE pjtime_stamp TIMESTAMP ;
	DECLARE pbuyed INT;
	DECLARE bdnum INT;
	DECLARE newumoney DECIMAL(11,2);
	
	-- sfc
	DECLARE pzhushu INT(11);
	DECLARE pexpect INT(10);
	DECLARE pis_open  TINYINT(1);
	DECLARE pis_baodi TINYINT(1);
	DECLARE pis_upload TINYINT(3);
	DECLARE pprogress INT(10);
	DECLARE pis_select_code INT(1);
	DECLARE pdeduct INT(11);
	DECLARE ptype  INT(1);
	DECLARE pcopies INT(11);
	-- bjdc
	DECLARE pissue INT(11);
	
	-- job
	DECLARE _fuid INT;
	DECLARE _funame VARCHAR(50);
	DECLARE _uid INT;
	DECLARE _uname VARCHAR(50);
	DECLARE _money DECIMAL(11,2);
	DECLARE lwitch TINYINT;
	DECLARE maxlimit INT;
	DECLARE minlimit INT;
	DECLARE jnums INT;
	
	DECLARE gordernum BIGINT;
	
	DECLARE nowtime INT;
	DECLARE eflag VARCHAR(200);
	-- DECLARE amemo varchar(200) default '自动跟单扣款';
	
	DECLARE errcode INT;
	DECLARE aerrFlg INT; 
	DECLARE CONTINUE HANDLER FOR SQLWARNING SET aerrFlg = 1;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET aerrFlg = 2;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET aerrFlg = 3;
	SET AUTOCOMMIT=0;
	SET aerrFlg = 0;
	SET errcode = 200;
	SET nowtime = UNIX_TIMESTAMP();
	
	-- 查询订制信息
	SELECT fuid,funame,uid,uname,money,limitswitch,maximum,minimum,nums,allmoney INTO _fuid,_funame,_uid,_uname,_money,lwitch,maxlimit,minlimit,jnums,@all_money
	FROM auto_order_jobs job WHERE job.id = jobid;
	
	
	SET _funame  = IFNULL(_funame,0);
	SET _uname   = IFNULL(_uname,0);
	-- 查询方案信息
	IF lotyid = 1 THEN
		SELECT surplus,price_one,total_price,friends,time_end,basic_id,user_id,codes,typename,rate,time_stamp,buyed,baodinum INTO 
		        psurplus,ppprice_one,ptotal_price,pfriends,ptime_end,pordernum,pfuid,pjcases,pjtypename,pjrate,pjtime_stamp,pbuyed,bdnum FROM plans_jczqs pj WHERE pj.id = pid;
	END IF;
	
	IF lotyid = 2 THEN
		SELECT 	`basic_id`, price_one, `type`, `user_id`, `expect`, `price`,
			  `zhushu`, `rate`, `copies`, `deduct`, `is_open`, `is_baodi`, 
			`end_price`, `progress`, `buyed`,  `is_upload`, `is_select_code`, `codes`, `time_end`,
			(`copies`-`buyed`),`buyed`
			INTO pordernum, ppprice_one,ptype, pfuid,pexpect, ptotal_price,
			 pzhushu, pjrate, pcopies,pdeduct, pis_open, pis_baodi,
			bdnum, pprogress, pbuyed,  pis_upload, pis_select_code, pjcases, ptime_end,pbuyed,psurplus
			FROM `plans_sfcs` ps WHERE ps.id = pid;
	
	END IF;
	IF lotyid = 6 THEN
		SELECT surplus,price_one,total_price,friends,time_end,basic_id,user_id,codes,typename,rate,time_stamp,buyed,baodinum INTO 
		        psurplus,ppprice_one,ptotal_price,pfriends,ptime_end,pordernum,pfuid,pjcases,pjtypename,pjrate,pjtime_stamp,pbuyed,bdnum FROM plans_jclqs pj WHERE pj.id = pid;
	END IF;
	
	IF lotyid = 7 THEN
		SELECT issue,surplus,price_one,total_price,friends,time_end,basic_id,user_id,codes,typename,rate,time_stamp,buyed,baodinum INTO 
		        pissue,psurplus,ppprice_one,ptotal_price,pfriends,ptime_end,pordernum,pfuid,pjcases,pjtypename,pjrate,pjtime_stamp,pbuyed,bdnum FROM plans_bjdcs pj WHERE pj.id = pid;
	END IF;
	
	-- 判断数据正确性
	IF _fuid = pfuid THEN
		-- 查询用户余额信息
		SELECT user_money,bonus_money,free_money INTO umoney,bmoney,fmoney FROM users u WHERE u.id=_uid;
		
		-- 判断用户余额
		IF (umoney+bmoney+fmoney)< _money THEN
			SET errcode = 101;
		END IF;
		
		-- 验证是否满员
		IF psurplus<=0 THEN
			SET errcode = 102;
		END IF;
		
		-- 验证可认够的钱是否够
		IF (psurplus*ppprice_one)< _money THEN
			SET errcode = 103;
		END IF;	
		
		-- 方案是否限定范围
		IF lwitch=1 THEN
			IF maxlimit < _money THEN
				SET errcode = 104;
			END IF;
			IF minlimit >_money THEN
				SET errcode = 105;
			END IF;
		END IF;		
		
		-- 检查方案日期是否结束	
		IF  UNIX_TIMESTAMP(ptime_end)<nowtime  THEN
			SET errcode = 106;	
		END IF;
		
		
		-- 检查是否是合买对象(若用户指定了跟单人，则不做自动跟单处理。)
		IF  LENGTH(TRIM(pfriends))>1  THEN
			SET errcode = 107;	
		END IF;
		
		-- 生成ordernum
		SET gordernum = numberorder(); -- 生成交易流水号
		
		SET @jdu = 0;
		
		
		IF errcode=200 THEN
			-- 扣款
			SET @amemo = '自动跟单扣款';
			SET eflag = expenses(_money,_uid,gordernum,0,0);
			IF eflag = 'succ' THEN
				-- 写入plan_basics表
				INSERT INTO `plans_basics` ( `order_num`, `plan_type`, `start_user_id`,	`user_id`, `ticket_type`,`play_method`, `status`, `date_add`, `date_end`)
				VALUES	(gordernum,'2', pfuid, _uid,lotyid,playid, 1, NOW(), ptime_end);
				
				IF lotyid = 1 THEN 
					-- 写入跟单信息
					INSERT INTO `plans_jczqs` (`basic_id`, `parent_id`,`plan_type`,
					  `user_id`, `play_method`, `codes`, `special_num`, `typename`, `price`, `copies`,
					  `bonus`, `bonus_max`, `rate`, `progress`, `status`, `zhushu`, `total_price`, 
					  `my_copies`, `price_one`, `deduct`, `baodinum`, `buyed`, `surplus`, `match_results`,
					  `title`, `content`, `isset_buyuser`, `friends`, `time_end`, `time_stamp`, `upload_filepath` 	) 
					  VALUES ( gordernum, pid, 2, _uid, playid, pjcases,
					  '', pjtypename, _money, NULL, NULL, NULL, pjrate, '0',
					  '1', '0', '0.000', _money, '1', NULL, NULL,'0', '0', NULL, NULL,
					   NULL, NULL, NULL, ptime_end,NOW(), NULL);
					SET @gdid = LAST_INSERT_ID();
					-- 修改方案进度
					SET @jdu = FLOOR((ptotal_price-(psurplus-_money)*ppprice_one)/ptotal_price*100);
					UPDATE  `plans_jczqs` SET surplus=psurplus-_money,progress = @jdu,buyed=pbuyed+_money WHERE id = pid;
					 
				END IF;
				IF lotyid = 6 THEN 
					-- 写入跟单信息
					INSERT INTO `plans_jclqs` (`basic_id`, `parent_id`,`plan_type`,
					  `user_id`, `play_method`, `codes`, `special_num`, `typename`, `price`, `copies`,
					  `bonus`, `bonus_max`, `rate`, `progress`, `status`, `zhushu`, `total_price`, 
					  `my_copies`, `price_one`, `deduct`, `baodinum`, `buyed`, `surplus`, `match_results`,
					  `title`, `content`, `isset_buyuser`, `friends`, `time_end`, `time_stamp`, `upload_filepath` 	) 
					  VALUES ( gordernum, pid, 2, _uid, playid, pjcases,
					  '', pjtypename, _money, NULL, NULL, NULL, pjrate, '0',
					  '1', '0', '0.000', _money, '1', NULL, NULL,'0', '0', NULL, NULL,
					   NULL, NULL, NULL, ptime_end,NOW(), NULL);
					SET @gdid = LAST_INSERT_ID();
					-- 修改方案进度
					SET @jdu = FLOOR((ptotal_price-(psurplus-_money)*ppprice_one)/ptotal_price*100);
					UPDATE  `plans_jclqs` SET surplus=psurplus-_money,progress = @jdu,buyed=pbuyed+_money WHERE id = pid;
					 
				END IF;
		
				IF lotyid = 7 THEN 
					-- 写入跟单信息
					INSERT INTO `plans_bjdcs` (`basic_id`, `parent_id`,`plan_type`,`issue`,
					  `user_id`, `play_method`, `codes`, `special_num`, `typename`, `price`, `copies`,
					  `bonus`, `rate`, `progress`, `status`, `zhushu`, `total_price`, 
					  `my_copies`, `price_one`, `deduct`, `baodinum`, `buyed`, `surplus`,
					  `title`, `content`, `isset_buyuser`, `friends`, `time_end`, `time_stamp`) 
					  VALUES ( gordernum, pid, 2, _uid, playid, pjcases,
					  '', pjtypename, _money, NULL, NULL, pjrate, '0',
					  '1', '0', '0.000', _money, '1', NULL, NULL,'0', '0',  NULL,
					   NULL, NULL, NULL, ptime_end,NOW());
					SET @gdid = LAST_INSERT_ID();
					-- 修改方案进度
					SET @jdu = FLOOR((ptotal_price-(psurplus-_money)*ppprice_one)/ptotal_price*100);
					UPDATE  `plans_bjdcs` SET surplus=psurplus-_money,progress = @jdu,buyed=pbuyed+_money WHERE id = pid;
					 
				END IF;
				IF lotyid = 2 THEN 
					-- 写入跟单信息
				INSERT INTO `plans_sfcs` (`basic_id`, `parent_id`, `type`, `user_id`, `ticket_type`, `play_method`, 
				`expect`, `price`, `money`, `bonus`, `zhushu`, `rate`, `copies`, `my_copies`, `price_one`, `deduct`, 
				`is_open`, `is_baodi`, `end_price`, `progress`, `buyed`, `status`, `is_buy`, `is_upload`, `is_select_code`,
				`codes`, `upload_filepath`, `title`, `description`, `friends`,`time_end`, `time_stamp`)
				VALUES(gordernum, pid, ptype, _uid, 2, playid, 
				pexpect, ptotal_price, _money,'0.00', pzhushu, pjrate, pcopies, _money, '1', pdeduct, pis_open, pis_baodi, bdnum, 
				pprogress, psurplus, '0', '2', pis_upload, pis_select_code, pjcases, NULL, '', 
				'', '', ptime_end, NOW() );
					SET @gdid = LAST_INSERT_ID();
					-- 修改方案进度
					SET @jdu = FLOOR((ptotal_price-(psurplus-_money)*ppprice_one)/ptotal_price*100);
					UPDATE  `plans_sfcs` SET buyed=psurplus-_money,progress = @jdu WHERE id = pid;
					 
				END IF;
				
				
				
				
				
				-- 写自动跟单log
				INSERT INTO `auto_order_logs` (`lotyid`,`playid`, `fuid`, `funame`, `uid`, `uname`, `rgmoney`, `state`,
				`isuccess`, `errcode`,	`ctime`, `ordernum`,`pid`)
				VALUES	(lotyid, playid,_fuid,_funame,_uid,_uname,_money, '1', '1', errcode,NOW(), pordernum,pid);
				
				-- 修改job表中的nums
				UPDATE auto_order_jobs job SET nums=jnums+1,allmoney=@all_money+_money WHERE job.id = jobid;
			ELSE
				SET errcode = 108;-- 用户资金异常
			END IF;
		
		ELSE
			SET aerrFlg = 5; -- 异常
			/*-- 失败写log
			if eflag <> 'succ' then
				SET errcode = 108; 
			else
				set aerrFlg = 5; -- 
			end if;
			INSERT INTO `auto_order_logs` (`lotyid`,`playid`, `fuid`, `funame`, `uid`, `uname`, `rgmoney`, `state`,
			`isuccess`, `errcode`,	`remarks`,`ctime`, `ordernum`, `pid`)
			VALUES	(lotyid, playid, _fuid,_funame,_uid,_uname,_money, '1','0', errcode, 'remarks',NOW(), pordernum, pid);*/
		
		END IF;
		
	END IF;
	
	-- 满员如果有保底做清保处理
	IF @jdu = 100 && bdnum>0 THEN
		SET @backmoney = bdnum*ppprice_one;
		-- 查询发起人用户余额
		SELECT user_money,bonus_money,free_money INTO @fumoney,@fbmoney,@ffmoney FROM users u WHERE u.id=pfuid;
		--  写交易记录表account_logs
		INSERT INTO account_logs (`order_num`,`user_id`,`log_type`,`is_in`,`price`,`user_money`,`add_time`,`memo`) 
	                              VALUES (gordernum,pfuid,5,0,@backmoney,@fumoney+@fbmoney+@ffmoney,NOW(),'方案满员返还合买保底费用');
	        SET @accid = LAST_INSERT_ID();
	        -- 写money_logs
	        INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,pfuid,'USER_MONEY',0,@backmoney,@fumoney,NOW());
		-- 修改发起人资金
		SET newumoney = @fumoney+@backmoney;
		UPDATE users SET user_money = newumoney WHERE id = pfuid;
	END IF;
	
	
	
	
	IF aerrFlg = 0 THEN
		COMMIT;	
	ELSE	
		ROLLBACK;
		--  写入跟单失败
		IF eflag = 'succ' && errcode=200 THEN
			SET errcode = 109; -- 跟单操作失败	
		END IF;	
	END IF;  
	-- 返回结果
	SELECT  errcode,aerrFlg,@amemo,eflag,@jdu,@gdid,@aaa,@bbb,_fuid,pfuid,pordernum;
END */$$
DELIMITER ;