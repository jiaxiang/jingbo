

/* Function  structure for function  `clearbd` */

/*!50003 DROP FUNCTION IF EXISTS `clearbd` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `clearbd`(pid int) RETURNS smallint(6)
BEGIN
	declare result smallint;
	DECLARE bdflag TINYINT;
	DECLARE bdmoney DECIMAL(11,2);
	DECLARE omoney DECIMAL(11,2);
	DECLARE allnum INT;
	DECLARE allrgnum INT;
	declare fquid int;
	DECLARE logtype TINYINT DEFAULT 11; -- 记录类型
	DECLARE umoney DECIMAL(10,2); -- 用户余额
        DECLARE bmoney DECIMAL(10,2); -- 用户奖金余额
	DECLARE fmoney DECIMAL(10,2); -- 用户赠送余额
	DECLARE mprice DECIMAL(10,2);
	DECLARE mlogtype VARCHAR(20);
	DECLARE misin TINYINT;
	-- account_log
	declare bprice decimal(10,2);
	declare atype decimal(10,2);
	declare isin tinyint;
	declare aid int;
	DECLARE errFlg TINYINT; 
	DECLARE CONTINUE HANDLER FOR SQLWARNING SET errFlg = 1;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET errFlg = 2;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET errFlg = 3;
	-- 错误代码，0:无错误;1:SQL警告;2:SELECT无数据;3:数据库异常;
	SET errFlg = 0;
	-- 查询方案信息
	SELECT baodi,baodimoney,onemoney,nums,rgnum,uid INTO bdflag,bdmoney,omoney,allnum,allrgnum,fquid FROM plans_lotty_orders o WHERE o.id = pid;
	IF errFlg = 0 THEN
		IF bdflag=1 THEN -- 有保底
	                -- account_logs
			SELECT price,log_type,is_in,id INTO bprice,atype,isin,aid FROM account_logs a WHERE a.pmid=pid and a.log_type=10 and a.is_in=1;
	                IF bprice = bdmoney AND isin = 1 THEN
				set @ordernum = numberorder();
				-- 查询用户余额
				SELECT user_money,bonus_money,free_money INTO umoney,bmoney,fmoney FROM users u WHERE u.id=fquid FOR UPDATE;
				--  写交易记录表account_logs
				INSERT INTO account_logs (`order_num`,`user_id`,`log_type`,`is_in`,`price`,`user_money`,`add_time`,`pmid`) 
						      VALUES (@ordernum,fquid,logtype,0,bprice,umoney+bmoney+fmoney,NOW(),pid);
				SET @accid = LAST_INSERT_ID();
	                        -- money_logs
				SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs m WHERE m.account_log_id=aid AND m.log_type='USER_MONEY';
				IF errFlg=0 THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,fquid,'USER_MONEY',0,mprice,umoney,NOW());
					SET umoney = umoney + mprice;
				ELSEIF errFlg=2 THEN
					SET errFlg=0;
				END IF;
				
				SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs m WHERE m.account_log_id=aid AND m.log_type='BONUS_MONEY';
				IF errFlg=0 THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,fquid,'BONUS_MONEY',0,mprice,bmoney,NOW());
					SET bmoney = bmoney + mprice;
				ELSEIF errFlg=2 THEN
					SET errFlg=0;
				END IF;
	
				SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs m WHERE m.account_log_id=aid AND m.log_type='FREE_MONEY';
				IF errFlg=0 THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,fquid,'FREE_MONEY',0,mprice,fmoney,NOW());
					SET fmoney = fmoney + mprice;
				ELSEIF errFlg=2 THEN
					SET errFlg=0;
				END IF;
	
	                        -- 给用户加值
				UPDATE users SET user_money=umoney,bonus_money=bmoney,free_money=fmoney WHERE id = fquid;
				-- 修改方案表baodi 状态为已清保
				set @jd = allrgnum/allnum;
				if (@jd<0.9) then -- 实际进度小于0.9
					set @ifull = 0;
					UPDATE plans_lotty_orders SET baodi=2,isfull=@ifull WHERE id = pid; 
				else
					UPDATE plans_lotty_orders SET baodi=2 WHERE id = pid; 
				end if;
			else
				set errFlg = 6; -- 数据异常
			end if;
	        else
			SET errFlg = 7; -- 无保底无需清保
		END IF;
	END IF; 
	-- 捕获异常
	IF (errFlg <> 0) THEN 
		-- 发生数据库异常
		SET result = 0;
	ELSE
		SET result = 1;
	END IF; 
	return result;
    END */$$
DELIMITER ;

/* Function  structure for function  `excrg` */

/*!50003 DROP FUNCTION IF EXISTS `excrg` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `excrg`(pid INT, -- 方案编号
                                rnum INT, -- 认购份数
                                uid INT, -- 认购用户
				uname VARCHAR(30), -- 认购用户名
				-- in rgtype tinyint, -- 认购类型
				ordernum BIGINT, -- 流水号
				source TINYINT -- 来源
	) RETURNS smallint(6)
BEGIN
	/*
	  方案认购
	  author: lenayin
        */
	DECLARE omoney DECIMAL(11,2);
	DECLARE allnum INT;
	DECLARE allrgnum INT;
	DECLARE qh VARCHAR(20);
	DECLARE lottid SMALLINT;
	DECLARE etime TIMESTAMP;
	DECLARE errFlg TINYINT; 
	DECLARE isfull TINYINT DEFAULT 0;
	DECLARE fulltime TIMESTAMP DEFAULT 0;
	DECLARE revstat TINYINT;
	DECLARE fquid INT;
	DECLARE wftype INT;
	DECLARE cpvstat TINYINT;
	declare _bdflag tinyint;
	declare _bdmoney decimal(11,2);
	DECLARE basicstat TINYINT DEFAULT 0;
	DECLARE stat smallint;
	DECLARE CONTINUE HANDLER FOR SQLWARNING SET errFlg = 1;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET errFlg = 2;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET errFlg = 3;
	-- 错误代码，0:无错误;1:SQL警告;2:SELECT无数据;3:数据库异常;
	SET errFlg = 0;
	if rnum>0 and pid>0 and uid>0 then
		-- 查询方案
		SELECT onemoney,nums,rgnum,qihao,lotyid,restat,uid,wtype,cpstat,baodi,baodimoney INTO omoney,allnum,allrgnum,qh,lottid,revstat,fquid,wftype,cpvstat,_bdflag,_bdmoney FROM plans_lotty_orders o WHERE o.id = pid;
		IF errFlg = 0 THEN
			SET revstat = IFNULL(revstat,0);
			SET cpvstat = IFNULL(cpvstat,0);
			-- 查询期号表
			SELECT endtime INTO etime FROM qihaos q WHERE q.lotyid=lottid AND q.qihao=qh;
			/*IF NOW()>etime THEN
				SET errFlg = 4; -- 当期已截止不可认购
			ELSE*/
				-- 认购处理。
				SET ordernum = numberorder(); -- 生成交易流水号
				IF (allrgnum+rnum) <= allnum AND revstat <> 1 THEN
					SET @jindu = (allrgnum+rnum)/allnum;
					IF @jindu=1 THEN -- 实际满员
						SET isfull = 2;
						SET fulltime = NOW();
						SET basicstat = 1;
					ELSEIF @jindu>=0.9 THEN -- 理论满员
						SET isfull = 1;
						SET fulltime = NOW();
						SET basicstat = 1;
					END IF;
					if _bdflag = 1 and isfull = 0 then -- 保底
						set @alljd = ((_bdmoney/omoney)+allrgnum+rnum)/allnum;
						if @alljd >=0.9 then
							SET isfull = 1;
							SET fulltime = NOW();
	                                                SET basicstat = 1;
						end if;
	                                end if;
					-- 已出票
					IF cpvstat = 2 THEN
						SET basicstat = 2;
					END IF;
					-- 修改方案表
					UPDATE plans_lotty_orders SET rgnum=allrgnum+rnum,renqi=FLOOR(@jindu*100),isfull=isfull,fulltime=fulltime WHERE id =pid;
					-- 写基础表
					INSERT INTO plans_basics (`order_num`,`plan_type`,`start_user_id`,`user_id`,`ticket_type`,`play_method`,`status`,`date_add`) 
								 VALUES (ordernum,2,fquid,uid,lottid,wftype,basicstat,NOW());
					SET @pbid = LAST_INSERT_ID();
					-- 写根单表
					INSERT INTO sale_prousers (`pbid`,`pid`,`uid`,`uname`,`nums`,`rgmoney`,`buytype`,`ctime`) 
					    VALUES (@pbid,pid,uid,uname,rnum,rnum*omoney,0,NOW());
					SET @ppid = LAST_INSERT_ID();
					-- 认购扣款操作
					SET @rgext = expenses(rnum*omoney,uid,ordernum,@ppid,0);
					IF @rgext<>'succ' THEN
						SET errFlg = 6;
					END IF;
					
				ELSE
				    SET errFlg = 5; -- 认购份数已超出剩余份数或已撤单
				END IF;
			-- END IF;
		END IF;
	else
		set errFlg = 5; -- 认购份数不合法。
	end if;
	-- 错误捕获
	IF (errFlg <> 0) THEN 
		-- 发生数据库异常
		SET stat = 1000;
	ELSE
		SET stat = isfull; -- 2 实际满员 1 理论满员 0 未满员
        END IF;
	return stat;
    END */$$
DELIMITER ;

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
	           insert into account_logs (`order_num`,`user_id`,`log_type`,`is_in`,`price`,`user_money`,`add_time`,`pmid`) 
	                             values (ordernum,uid,logtype,1,money,umoney+bmoney+fmoney,now(),ppid);
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

/* Function  structure for function  `func_test` */

/*!50003 DROP FUNCTION IF EXISTS `func_test` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `func_test`() RETURNS varchar(30) CHARSET utf8
BEGIN
       declare result varchar(30);
       set result = 'sfsfsdsfdfs';
       return result;
    END */$$
DELIMITER ;

/* Function  structure for function  `income` */

/*!50003 DROP FUNCTION IF EXISTS `income` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `income`(gid INT,money DECIMAL(11,2),ordernum BIGINT) RETURNS varchar(30) CHARSET utf8
BEGIN
	DECLARE result VARCHAR(30);
	DECLARE price DECIMAL(11,2);
	DECLARE uid INT;
	DECLARE isin TINYINT;
	DECLARE aid BIGINT;
	DECLARE logtype TINYINT DEFAULT 5; -- 记录类型
	DECLARE umoney DECIMAL(11,2); -- 用户余额
        DECLARE bmoney DECIMAL(11,2); -- 用户奖金余额
	DECLARE fmoney DECIMAL(11,2); -- 用户赠送余额
	DECLARE s INT DEFAULT 0; 
	DECLARE mprice DECIMAL(11,2);
	DECLARE mlogtype VARCHAR(20);
	DECLARE misin TINYINT;
	DECLARE ferrFlg INT;
        DECLARE CONTINUE HANDLER FOR SQLWARNING SET ferrFlg = 1;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET ferrFlg = 2;
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET ferrFlg = 3;
	-- 查询accont_log
	SELECT price,user_id,is_in,aid INTO price,uid,isin,aid FROM account_logs a WHERE a.pmid = gid;
	IF price = money AND isin = 1 THEN 
	        -- 查询用户余额
		SELECT user_money,bonus_money,free_money INTO umoney,bmoney,fmoney FROM users u WHERE u.id=uid FOR UPDATE;
		--  写交易记录表account_logs
		INSERT INTO account_logs (`order_num`,`user_id`,`log_type`,`is_in`,`price`,`user_money`,`add_time`,`pmid`) 
	                              VALUES (ordernum,uid,logtype,0,money,umoney+bmoney+fmoney,NOW(),gid);
		SET @accid = LAST_INSERT_ID();
	        -- 查询money_logs
		-- select price,log_type,is_in into @mprice,@mlogtype,@misin from money_logs where account_log_id=aid;           
                SELECT COUNT(*) INTO @tatal FROM money_logs m WHERE m.account_log_id=aid;
		IF @tatal>0 THEN
	                SET @j = 0;
			WHILE @j<@tatal DO
				SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs m WHERE m.account_log_id=aid LIMIT 1;
	                        IF mlogtype = 'USER_MONEY' THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'USER_MONEY',0,mprice,umoney,NOW());
					SET umoney = umoney + mprice;
	                        ELSEIF mlogtype='BONUS_MONEY' THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'BONUS_MONEY',0,mprice,bmoney,NOW());
					SET bmoney = bmoney + mprice;
	                        ELSE
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'FREE_MONEY',0,mprice,fmoney,NOW());
					SET fmoney = fmoney + mprice;
	                        END IF;
				SET @j = @j + 1;
	                END WHILE;
	        END IF;
	
	
                /*DECLARE mlogs CURSOR FOR select price,log_type,is_in FROM money_logs WHERE account_log_id=aid;      
                DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET s=1; 
                OPEN mlogs;
		fetch  mlogs into mprice,mlogtype,misin;
			while s <> 1 do   
	                     -- 本金:USER_MONEY,奖金:BONUS_MONEY,彩金:FREE_MONEY
			     if mlogtype='USER_MONEY' then
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
	                                VALUES (@accid,uid,'USER_MONEY',0,mprice,umoney,NOW());
				set umoney = umoney + mprice;
	                     elseif mlogtype='BONUS_MONEY' then
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
	                                VALUES (@accid,uid,'BONUS_MONEY',0,mprice,bmoney,NOW());
				SET bmoney = bmoney + mprice;
	                     else
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
	                                VALUES (@accid,uid,'FREE_MONEY',0,mprice,fmoney,NOW());
				SET fmoney = fmoney + mprice;
	                     end if;
			     #读取下一行的数据   
			     fetch  mlogs into mprice,mlogtype,misin;   
			end while;  
                CLOSE mlogs;*/
                -- 给用户加值
                UPDATE users SET user_money=umoney,bonus_money=bmoney,free_money=fmoney WHERE uid = uid;
                -- set result ='succ';
	ELSE
		SET result = '数据异常';
	END IF;
	
	RETURN result;
    END */$$
DELIMITER ;

/* Function  structure for function  `numberorder` */

/*!50003 DROP FUNCTION IF EXISTS `numberorder` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `numberorder`() RETURNS bigint(20)
BEGIN
	declare ordernum varchar(50);
	set ordernum = concat(DATE_FORMAT(NOW(),'%Y%m%d%H%i%s'),FLOOR(10000 + (RAND() * 89999)));
	return ordernum; 
    END */$$
DELIMITER ;

/* Procedure structure for procedure `clearbaodi` */

/*!50003 DROP PROCEDURE IF EXISTS  `clearbaodi` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `clearbaodi`(in pid int, -- 方案编号
                                                    in stype tinyint,OUT `result` int)
BEGIN
        /**
         方案清保操作
         author lenayin
        **/
	declare result int; -- 返回了串
	DECLARE bdmoney DECIMAL(11,2); -- 保底金额
	declare omoney decimal(11,2); -- 单份金额
	declare allnum int; -- 总份数
	declare argnum int; -- 总认购份数
	declare fquid int; -- 发起用户
	declare usern varchar(30); -- 发起用户名
	declare _rgnum int; -- 认购份数
	declare companyrgnum int default 0; -- 公司认购份数
	DECLARE errFlg TINYINT; 
	DECLARE CONTINUE HANDLER FOR SQLWARNING SET errFlg = 1;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET errFlg = 2;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET errFlg = 3;
	-- 设置为手动提交
	SET AUTOCOMMIT=0;
	-- 错误代码，0:无错误;1:SQL警告;2:SELECT无数据;3:数据库异常;
	SET errFlg = 0;
	-- 查询方案信息
	SET @ifull = 100;
	set @clearflag = clearbd(pid);
	if (@clearflag<>1) then
		set errFlg = 4;
	end if;
	
	if stype = 1 then 
		-- 查询方案信息
		SELECT baodimoney,onemoney,nums,rgnum,uid,uname INTO bdmoney,omoney,allnum,argnum,fquid,usern FROM plans_lotty_orders o WHERE o.id = pid;
		set _rgnum = allnum-argnum;
		set @bdnum = ceil(bdmoney/omoney);
		if _rgnum > @bdnum then
			set _rgnum = @bdnum;
			set companyrgnum = allnum-argnum-@bdnum;
		end if;
		set @_ext = excrg(pid,_rgnum,fquid,usern,2011,0);
		if @_ext<>1000 then 
			/*-- 公司认购操作
			if companyrgnum <> 0 then 
				-- 正式上线换成公司收底帐户
				SET @ext2 = excrg(pid,companyrgnum,73,'liuhaihua',2011,0);
				if @ext2 = 1000 then
					set errFlg = 3;
				end if;
			end if;*/
			SET errFlg = errFlg;
			set @thejindu = (argnum+_rgnum)/allnum;
			set @ifull = 0;
			if @thejindu = 1 then -- 实际满员
				SET @ifull = 2;
			elseif @thejindu>=0.9 then -- 理论满员
				set @ifull = 1;
	                end if;	
		else
			set errFlg = 5;
		end if;
	end if;
	
	if (errFlg <> 0) then
		set result = -1; 
	        rollback;
	else
		set result = @ifull; 
		commit;
	end if;
	
	select  result; -- 0 未满员 1 理论满员 2 实际满员 100 撤销保底成功 -1 失败
	
END */$$
DELIMITER ;

/* Procedure structure for procedure `grantbonus` */

/*!50003 DROP PROCEDURE IF EXISTS  `grantbonus` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `grantbonus`(in money decimal(11,2), -- 金额
				     in uid int, -- 用户编号
                                     in pmid int, -- 源id
                                     in stype tinyint, -- 1 方案提成 2 奖金派送
				     out `result` varchar(50)
                                     )
BEGIN
	DECLARE result VARCHAR(30);
	declare umoney decimal(11,2);
	declare bmoney decimal(11,2);
	declare fmoney decimal(11,2);
	declare logtype smallint default 3;
	declare ordernum bigint;
	DECLARE ferrFlg tinyint;
        DECLARE CONTINUE HANDLER FOR SQLWARNING SET ferrFlg = 1;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET ferrFlg = 2;
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET ferrFlg = 3;
	-- 错误代码，0:无错误;1:SQL警告;2:SELECT无数据;3:数据库异常;
	SET ferrFlg = 0;
	if stype = 1 then
		set logtype = 12;
	end if;
	-- 查询用户余额
	set ordernum = numberorder();
	SELECT user_money,bonus_money,free_money INTO umoney,bmoney,fmoney FROM users u WHERE u.id=uid FOR UPDATE;
	--  写交易记录表account_logs
	INSERT INTO account_logs (`order_num`,`user_id`,`log_type`,`is_in`,`price`,`user_money`,`add_time`,`pmid`) 
	                          VALUES (ordernum,uid,logtype,0,money,umoney+bmoney+fmoney,NOW(),pmid);
	SET @accid = LAST_INSERT_ID();
	-- money_logs			
	INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
				VALUES (@accid,uid,'BONUS_MONEY',0,money,bmoney,NOW());
	SET bmoney = bmoney + money;
         -- 给用户加值
        UPDATE users SET bonus_money=bmoney WHERE `id` = uid;
        if ferrFlg = 0 then
		set result = 'succ';
	else
		set result = 'failure';
	end if;
	select result;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `income` */

/*!50003 DROP PROCEDURE IF EXISTS  `income` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `income`(in gid INT,in money DECIMAL(11,2),in ordernum BIGINT)
BEGIN
	DECLARE result VARCHAR(30);
	DECLARE price DECIMAL(11,2);
	DECLARE uid INT;
	DECLARE isin TINYINT;
	DECLARE aid BIGINT;
	DECLARE logtype TINYINT DEFAULT 5; -- 记录类型
	DECLARE umoney DECIMAL(11,2); -- 用户余额
        DECLARE bmoney DECIMAL(11,2); -- 用户奖金余额
	DECLARE fmoney DECIMAL(11,2); -- 用户赠送余额
	DECLARE s INT DEFAULT 0; 
	DECLARE mprice DECIMAL(11,2);
	DECLARE mlogtype VARCHAR(20);
	DECLARE misin TINYINT;
	DECLARE ferrFlg INT;
        DECLARE CONTINUE HANDLER FOR SQLWARNING SET ferrFlg = 1;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET ferrFlg = 2;
        DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET ferrFlg = 3;
	-- 查询accont_log
	SELECT price,user_id,is_in,aid INTO price,uid,isin,aid FROM account_logs a WHERE a.pmid = gid;
	IF price = money AND isin = 1 THEN 
	        -- 查询用户余额
		SELECT user_money,bonus_money,free_money INTO umoney,bmoney,fmoney FROM users u WHERE u.id=uid FOR UPDATE;
		--  写交易记录表account_logs
		INSERT INTO account_logs (`order_num`,`user_id`,`log_type`,`is_in`,`price`,`user_money`,`add_time`,`pmid`) 
	                              VALUES (ordernum,uid,logtype,0,money,umoney+bmoney+fmoney,NOW(),gid);
		SET @accid = LAST_INSERT_ID();
	        -- 查询money_logs
		-- select price,log_type,is_in into @mprice,@mlogtype,@misin from money_logs where account_log_id=aid;           
                SELECT COUNT(*) INTO @tatal FROM money_logs m WHERE m.account_log_id=aid;
		IF @tatal>0 THEN
	                SET @j = 0;
			WHILE s<@tatal DO
				SET @sqlstr = CONCAT('SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs WHERE account_log_id=',aid,' LIMIT ',@j,',1');
	                        PREPARE   stmt   FROM   @sqlstr; 
				EXECUTE   stmt3; 
				DEALLOCATE   PREPARE   stmt; 
	                        IF mlogtype = 'USER_MONEY' THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'USER_MONEY',0,mprice,umoney,NOW());
					SET umoney = umoney + mprice;
	                        ELSEIF mlogtype='BONUS_MONEY' THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'BONUS_MONEY',0,mprice,bmoney,NOW());
					SET bmoney = bmoney + mprice;
	                        ELSE
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
						VALUES (@accid,uid,'FREE_MONEY',0,mprice,fmoney,NOW());
					SET fmoney = fmoney + mprice;
	                        END IF;
				SET @j = @j + 1;
	                END WHILE;
	        END IF;
	
	
                /*DECLARE mlogs CURSOR FOR select price,log_type,is_in FROM money_logs WHERE account_log_id=aid;      
                DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET s=1; 
                OPEN mlogs;
		fetch  mlogs into mprice,mlogtype,misin;
			while s <> 1 do   
	                     -- 本金:USER_MONEY,奖金:BONUS_MONEY,彩金:FREE_MONEY
			     if mlogtype='USER_MONEY' then
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
	                                VALUES (@accid,uid,'USER_MONEY',0,mprice,umoney,NOW());
				set umoney = umoney + mprice;
	                     elseif mlogtype='BONUS_MONEY' then
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
	                                VALUES (@accid,uid,'BONUS_MONEY',0,mprice,bmoney,NOW());
				SET bmoney = bmoney + mprice;
	                     else
				INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
	                                VALUES (@accid,uid,'FREE_MONEY',0,mprice,fmoney,NOW());
				SET fmoney = fmoney + mprice;
	                     end if;
			     #读取下一行的数据   
			     fetch  mlogs into mprice,mlogtype,misin;   
			end while;  
                CLOSE mlogs;*/
                -- 给用户加值
                UPDATE users SET user_money=umoney,bonus_money=bmoney,free_money=fmoney WHERE uid = uid;
                -- set result ='succ';
	END IF;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `rev_order` */

/*!50003 DROP PROCEDURE IF EXISTS  `rev_order` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `rev_order`(IN gid INT, -- 根单编号 
                                    IN revtype TINYINT, -- 撤单类型 1 方案撤单 2 跟单人撤销
				    in ordernum bigint, OUT  `result` varchar(50))
BEGIN
        /*
         根据认购编号进行撤销
         desc: 存储过程中没有校验是否是发起认购
               需在程序内做校验
               交易流水号有可以不传
         author: lenayin
        */
        DECLARE uid INT;
        DECLARE revstat TINYINT;
        DECLARE result VARCHAR(50);
	DECLARE rgm DECIMAL(10,2);
	declare bid int; -- 基础表ID
	declare ppid int; -- 方案编号
	declare grgnum int; -- 认购份数
	declare aprice decimal(11,2);
	declare isin tinyint;
	declare aid bigint;
	DECLARE logtype TINYINT DEFAULT 5; -- 记录类型
	DECLARE umoney DECIMAL(10,2); -- 用户余额
        DECLARE bmoney DECIMAL(10,2); -- 用户奖金余额
	DECLARE fmoney DECIMAL(10,2); -- 用户赠送余额
	declare btype tinyint;
	-- money_logs
	DECLARE mprice DECIMAL(10,2);
	DECLARE mlogtype VARCHAR(20);
	DECLARE misin TINYINT;
        DECLARE errFlg TINYINT; 
	DECLARE CONTINUE HANDLER FOR SQLWARNING SET errFlg = 1;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET errFlg = 2;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET errFlg = 3;
	-- 设置为手动提交
	SET AUTOCOMMIT=0;
	-- 错误代码，0:无错误;1:SQL警告;2:SELECT无数据;3:数据库异常;
	SET errFlg = 0;
        -- 查询跟单信息
	SELECT rgmoney,restat,pbid,uid,buytype,pid,nums INTO rgm,revstat,bid,uid,btype,ppid,grgnum FROM sale_prousers s WHERE s.id = gid;
	IF errFlg <> 0 THEN
		SET errFlg = 2;
	ELSE
		if revstat <> 0 then
			set errFlg = 1;
		else
			set ordernum = numberorder(); -- 生成交易流水号
			-- 查询accont_log
			SELECT price,user_id,is_in,id INTO aprice,uid,isin,aid FROM account_logs a WHERE a.pmid = gid and a.is_in=1;
			IF aprice = rgm AND isin = 1 THEN
				-- 查询用户余额
				SELECT user_money,bonus_money,free_money INTO umoney,bmoney,fmoney FROM users u WHERE u.id=uid FOR UPDATE;
				--  写交易记录表account_logs
				INSERT INTO account_logs (`order_num`,`user_id`,`log_type`,`is_in`,`price`,`user_money`,`add_time`,`pmid`) 
						      VALUES (ordernum,uid,logtype,0,aprice,umoney+bmoney+fmoney,NOW(),gid);
				SET @accid = LAST_INSERT_ID();
				-- 查询money_logs
				-- select price,log_type,is_in into @mprice,@mlogtype,@misin from money_logs where account_log_id=aid;           
				/*SELECT COUNT(*) INTO @tatal FROM money_logs WHERE account_log_id=aid;
				IF @tatal>0 THEN
					SET @j = 0;
					WHILE @j<@tatal DO
						SET @sqlstr = CONCAT('SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs WHERE account_log_id=',aid,' LIMIT ',@j,',1');
						PREPARE stmt2 FROM @sqlstr; 
						EXECUTE stmt2; 
						-- DEALLOCATE PREPARE stmt; 
						IF mlogtype = 'USER_MONEY' THEN
							INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,uid,'USER_MONEY',0,mprice,umoney,NOW());
							SET umoney = umoney + mprice;
						ELSEIF mlogtype='BONUS_MONEY' THEN
							INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,uid,'BONUS_MONEY',0,mprice,bmoney,NOW());
							SET bmoney = bmoney + mprice;
						ELSE
							INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,uid,'FREE_MONEY',0,mprice,fmoney,NOW());
							SET fmoney = fmoney + mprice;
						END IF;
						SET @j = @j + 1;
					END WHILE;
				END IF;*/	
				SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs m WHERE m.account_log_id=aid and m.log_type='USER_MONEY';
				if errFlg=0 then
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,uid,'USER_MONEY',0,mprice,umoney,NOW());
					SET umoney = umoney + mprice;
				elseif errFlg=2 then
					set errFlg=0;
				end if;
				
				SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs m WHERE m.account_log_id=aid AND m.log_type='BONUS_MONEY';
				IF errFlg=0 THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,uid,'BONUS_MONEY',0,mprice,bmoney,NOW());
					SET bmoney = bmoney + mprice;
				ELSEIF errFlg=2 THEN
					SET errFlg=0;
				END IF;
	
				SELECT price,log_type,is_in INTO mprice,mlogtype,misin FROM money_logs m WHERE m.account_log_id=aid AND m.log_type='FREE_MONEY';
				IF errFlg=0 THEN
					INSERT INTO money_logs (account_log_id,user_id,log_type,is_in,price,user_money,add_time) 
								VALUES (@accid,uid,'FREE_MONEY',0,mprice,fmoney,NOW());
					SET fmoney = fmoney + mprice;
				ELSEIF errFlg=2 THEN
					SET errFlg=0;
				END IF;
				
				-- 给用户加值
				UPDATE users SET user_money=umoney,bonus_money=bmoney,free_money=fmoney WHERE id = uid;
				-- 修改根单状态
				update sale_prousers set restat=revtype where id=gid;
				update plans_basics set `status`=6 where id=bid;
	                        if revtype = 2 then
					-- 重新计算进度
					select rgnum,nums,baodimoney,baodi,onemoney into @prgnums,@pallnums,@bmoney,@bflag,@omoney from plans_lotty_orders o where o.id = ppid;
					set @jindu = floor((@prgnums-grgnum)/@pallnums*100);
					if @jindu = 1 then
						set @ifull = 2;
						set @iftime = now();
					elseif @jindu >=90 then
						SET @ifull = 1;
						SET @iftime = null;
					else
						SET @ifull = 0;
						SET @iftime = null;
					end if;
					update plans_lotty_orders set rgnum=@prgnums-grgnum,renqi=@jindu,isfull=@ifull,fulltime=@iftime where id=ppid;
	                        end if;
			else
				set errFlg = 1;
			end if;
		end if;
	END IF;
	
	-- 异常捕获
	if errFlg<>0 then
		set result = '操作失败';
		ROLLBACK; 
	else
		set result = 'succ';
		COMMIT;
	end if;
		
	SELECT result;
    
    END */$$
DELIMITER ;

/* Procedure structure for procedure `subgd` */

/*!50003 DROP PROCEDURE IF EXISTS  `subgd` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `subgd`(in pid int, -- 方案编号
                                in rnum int, -- 认购份数
                                in uid int, -- 认购用户
				in uname varchar(30), -- 认购用户名
				-- in rgtype tinyint, -- 认购类型
				in ordernum bigint, -- 流水号
				in source tinyint, -- 来源
				out `stat` varchar(50)
                               )
BEGIN
        /*
	  方案认购
	  author: lenayin
        */
	declare result smallint;
	declare stat varchar(30);
	declare ext smallint;
	-- 设置为手动提交
	SET AUTOCOMMIT=0;
	-- 调用认购通用function 
	set  result = excrg(pid,rnum,uid,uname,ordernum,source);
	-- 实际满员做清保处理
	if result=2 then
		select baodi into @bdflag from plans_lotty_orders p where p.id = pid;
	        if @bdflag=1 then
			set ext = clearbd(pid);
			if (ext <> 1) then
				set result=1000; -- 请保失败则做回滚处理
			end if;
	         end if;
	end if;
	-- 查询方案是否已
	-- 错误捕获
	IF (result = 1000) THEN 
		-- 发生数据库异常
		SET stat = '数据异常';
		ROLLBACK; 
	ELSE
		SET stat = 'succ';
		COMMIT;
        END IF;
	select stat;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `sub_order` */

/*!50003 DROP PROCEDURE IF EXISTS  `sub_order` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `sub_order`(IN lotyid INT, -- 彩种
                                    IN wtype TINYINT, -- 玩法
                                    IN ordernum bigINT,  -- 方案编号 
                                    in ishm tinyint, -- 是否是合买 0 代购 1 合买 2 参与合买
                                    IN qihao varchar(30), -- 彩种期号
                                    IN uid INT, -- 用户ID
                                    IN uname VARCHAR(40), -- 用户名
                                    IN lotmulti INT,  -- 倍数
                                    IN allmoney DECIMAL(10,2), -- 总金额
                                    IN pmoney DECIMAL(10,2), -- 单注金额
                                    IN source TINYINT,  -- 发起来源
                                    IN ordertype TINYINT, -- 购买类型 0 代购投注 1 合买投注 2 追号投注
                                    IN title VARCHAR(100), -- 方案标题
                                    in description varchar(500), -- 方案描述
                                    IN content TEXT,  -- 方案内容
                                    IN showtype TINYINT, -- 显示类型
                                    IN tctype TINYINT,  -- 提成类型
                                    IN tcratio INT,  -- 提成比例
                                    IN totalnum INT,  -- 总份数
                                    IN buynum INT,  -- 发起认识份数
                                    IN onemoney DECIMAL(10,2),  -- 单份价格
                                    IN bdflag TINYINT, -- 保底标识
                                    IN bdnum INT,out prid int)
BEGIN
   /**
    author : lenayin
    desc: 通用方案发起流程
   */
   declare basicstat tinyint default 0; -- plans_basics 表中status
   declare fend timestamp; -- 复式截止时间
   declare dend timestamp; -- 单式截止时间
   declare fulltime timestamp default null; -- 方案满员时间
   declare stat varchar(100); -- 返回字串
   declare jindu smallint; -- 进度 
   declare isfull tinyint default 0; -- 满员标识
   DECLARE errFlg INT; 
   DECLARE CONTINUE HANDLER FOR SQLWARNING SET errFlg = 1;
   DECLARE CONTINUE HANDLER FOR NOT FOUND SET errFlg = 2;
   DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET errFlg = 3;
   -- 设置为手动提交
   SET AUTOCOMMIT=0;
   -- 错误代码，0:无错误;1:SQL警告;2:SELECT无数据;3:数据库异常;
   SET errFlg = 0;
   -- 发起方案
   SELECT fendtime,dendtime INTO fend,dend FROM qihaos q WHERE q.lotyid=lotyid  and q.qihao=qihao;
   if errFlg <> 0 then
	set stat = '期号异常';
	ROLLBACK;
   else
	   set ordernum = numberorder(); -- 生成交易流水呈。
           IF (buynum+bdnum)/totalnum >= 0.9 THEN
		SET basicstat = 1;
	        set isfull = 1; -- 理论满员
	   end if;
	   if wtype = 1 then
		 SET @endtime  = fend;
	   else
	         set @endtime  = dend;
	   end if;
	   -- 先向方案基础表插入信息
	   iNSERT INTO plans_basics (`order_num`,`plan_type`,`start_user_id`,`user_id`,`ticket_type`,`play_method`,`status`,`date_end`) 
		    VALUES (ordernum,ishm,uid,uid,lotyid,wtype,basicstat,@endtime);
	   set @pbid = LAST_INSERT_ID();
	   -- 进度计算
	   set jindu = floor(buynum/totalnum*100);
	   
	   if ordertype = 0 then
	       SET isfull = 2;
	       set fulltime = now();
	   end if;
	
	   if wtype = 1 then
		-- 复式方案处理
		insert into plans_lotty_orders (
	                                      `basic_id`,`wtype`,`uid`,`uname`,`lotyid`,`qihao`,`title`,`description`,
	                                      `allmoney`,`lotmulti`,`onemoney`,`nums`,`renqi`,`rgnum`,`pmoney`,`baodi`,
	                                      `baodimoney`,`subtime`,`substat`,`tcratio`,`showtype`,`isfull`,`fulltime`,
	                                      `buytype`,`ctime`) values (ordernum,wtype,uid,uname,lotyid,qihao,title,description,
	                                       allmoney,lotmulti,onemoney,totalnum,jindu,buynum,pmoney,bdflag,
	                                       bdnum*onemoney,now(),1,tcratio,showtype,isfull,fulltime,ordertype,now());
	       set @pid = LAST_INSERT_ID();
	       set prid = @pid;
	       INSERT INTO lotty_number_projects (`pid`,`content`,`ctime`) VALUE (@pid,content,now());
	   else
		-- 单式方案处理
		set @substat = 1;
		set @subtm = now();
		if content = '' then
			set @substat = 0;
			set @subtm = null;
		end if;
		INSERT INTO plans_lotty_orders (
	                                      `basic_id`,`wtype`,`uid`,`uname`,`lotyid`,`qihao`,`title`,`description`,
	                                      `allmoney`,`lotmulti`,`onemoney`,`nums`,`renqi`,`rgnum`,`pmoney`,`baodi`,
	                                      `baodimoney`,`subtime`,`substat`,`tcratio`,`showtype`,`isfull`,`fulltime`,
	                                      `buytype`,`ctime`) VALUES (ordernum,wtype,uid,uname,lotyid,qihao,title,description,
	                                       allmoney,lotmulti,onemoney,totalnum,jindu,buynum,pmoney,bdflag,
	                                       bdnum*onemoney,@subtm,@substat,tcratio,showtype,isfull,fulltime,ordertype,NOW());
	       SET @pid = LAST_INSERT_ID();
	       SET prid = @pid;
	       if content <> '' then
		       INSERT INTO lotty_number_projects (`pid`,`content`,`ctime`) VALUE (@pid,content,NOW());
		end if;
	 
	   end if;
	   -- 操作认购表
	   insert into sale_prousers (`pbid`,`pid`,`uid`,`uname`,`nums`,`rgmoney`,`buytype`,`ctime`) 
	                            values (@pbid,@pid,uid,uname,buynum,buynum*onemoney,1,now());
	   set @ppid = LAST_INSERT_ID();
	   -- 认购扣款操作
	   set @ext = expenses(buynum*onemoney,uid,ordernum,@ppid,0);
	   if @ext<>'succ' then
	      set errFlg = 6;
	   end if;
	   -- 保底扣款操作
	   if bdflag = 1 then
		   set @bordernum = numberorder(); -- 生成交易流水呈。 
		   set @bdext = expenses(bdnum*onemoney,uid,@bordernum,@pid,1);
		   IF @bdext<>'succ' THEN
		      SET errFlg = 6;
		   END IF;
	   end if;
	   -- 错误捕获
	   IF (errFlg <> 0) THEN 
		-- 发生数据库异常
		SET stat = '数据异常';
		ROLLBACK; 
	   ELSE
              SET stat = 'succ';
	      COMMIT;
            END IF;
    end if;
    select stat;
    -- select @ext;
  END */$$
DELIMITER ;

/* Procedure structure for procedure `test` */

/*!50003 DROP PROCEDURE IF EXISTS  `test` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `test`(in s text)
BEGIN
	#declare stat tinyint default 1;
	#select stat;
	-- insert into lotty_number_project (`content`,`pid`) values (s,12);
	-- select numberorder();
	set @res = expenses(1,128,20112435,1000,0);
	select @res;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `teste` */

/*!50003 DROP PROCEDURE IF EXISTS  `teste` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `teste`(in pid int,OUT `result` varchar(50))
BEGIN
	#Routine body goes here...
       /**
         方案清保操作
         author lenayin
        **/
	
	DECLARE bdmoney DECIMAL(11,2); -- 保底金额
	declare omoney decimal(11,2); -- 单份金额
	declare allnum int; -- 总份数
	declare argnum int; -- 总认购份数
	declare fquid int; -- 发起用户
	declare usern varchar(30); -- 发起用户名
	declare _rgnum int; -- 认购份数
	declare companyrgnum int default 0; -- 公司认购份数
	DECLARE errFlg TINYINT; 
	DECLARE CONTINUE HANDLER FOR SQLWARNING SET errFlg = 1;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET errFlg = 2;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET errFlg = 3;
	-- 设置为手动提交
	SET AUTOCOMMIT=0;
	-- 错误代码，0:无错误;1:SQL警告;2:SELECT无数据;3:数据库异常;
	SET errFlg = 0;
	-- 查询方案信息
	SET @ifull = 100;
	set @clearflag = clearbd(pid);
	if (@clearflag<>1) then
		set errFlg = 3;
	end if;
	update lotty_jobs set stat=pid;
SET result = 'SUC';
SELECT result;
END */$$
DELIMITER ;
