-- MySQL dump 10.10
--
-- Host: jbdbhost    Database: caipiao
-- ------------------------------------------------------
-- Server version	5.0.51a-3ubuntu5.8-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ag_errorcodes`
--

DROP TABLE IF EXISTS `ag_errorcodes`;
CREATE TABLE `ag_errorcodes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `scode` varchar(30) NOT NULL,
  `title` varchar(100) default NULL,
  `textmsg` varchar(255) default NULL,
  `sfrom` varchar(45) default NULL,
  `textmsg2` varchar(255) default NULL,
  `date_add` timestamp NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `scode_UNIQUE_x` (`scode`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ag_errorcodes`
--


/*!40000 ALTER TABLE `ag_errorcodes` DISABLE KEYS */;
LOCK TABLES `ag_errorcodes` WRITE;
INSERT INTO `ag_errorcodes` VALUES (9,'sp_settle_realtime','','即时结算','sp_settle_realtime',' ','2011-11-09 02:38:50'),(10,'sp_settle_month','','月度结算','sp_settle_month',' ','2011-11-09 02:48:04'),(11,'sp_settle_realtime_1','','超代即时结算','sp_settle_realtime_1',' ','2011-11-09 02:48:04'),(12,'sp_settle_month_1','','超代月度结算','sp_settle_month_1',' ','2011-11-09 02:48:04'),(13,'2011','用户余额操作错误信息','参数错误','sp_money_add','parament error ','2011-11-09 02:48:04'),(14,'2012','用户余额操作错误信息','参数错误','sp_money_add','parament error: pi_money sum ','2011-11-09 02:48:22'),(15,'2013','用户余额操作错误信息','用户所有钱小于零','sp_money_add','user_all_money < 0 error  ','2011-11-09 02:48:22'),(16,'2014','用户余额操作错误信息','用户本金小于零','sp_money_add','user_money < 0 error ','2011-11-09 02:48:22'),(17,'2015','用户余额操作错误信息','增加帐户日志错误','sp_money_add','account_logs insert error ','2011-11-09 02:48:22'),(18,'2021','用户余额操作错误信息','帐户日志错误','sp_account_dtl_log','money_logs insert error','2011-11-09 02:47:43'),(19,'2022','用户余额操作错误信息','帐户日志错误','sp_account_dtl_log','money_logs insert error','2011-11-09 02:47:43'),(20,'2023','用户余额操作错误信息','帐户日志错误','sp_account_dtl_log','money_logs insert error','2011-11-09 02:47:43'),(21,'2031','用户余额操作错误信息','参数错误','sp_update_money','parament error','2011-11-09 02:47:43'),(22,'2032','用户余额操作错误信息','参数错误','sp_update_money','pi_money_type error','2011-11-09 02:47:43'),(23,'2033','用户余额操作错误信息','用户所有钱小于零','sp_update_money','user_all_money < 0 error','2011-11-09 02:47:43'),(24,'2034','用户余额操作错误信息','用户所有钱小于零','sp_update_money','user_all_money < 0 error','2011-11-09 02:47:43'),(25,'2035','用户余额操作错误信息','用户本金小于零','sp_update_money','t_user_money < 0 error','2011-11-09 02:47:43'),(26,'2036','用户余额操作错误信息','用户奖金小于零','sp_update_money','t_bonus_money < 0 error','2011-11-09 02:47:43'),(27,'2037','用户余额操作错误信息','用户彩金小于零','sp_update_money','t_free_money < 0 error','2011-11-09 02:47:43'),(28,'2038','用户余额操作错误信息','用户彩金小于零','sp_update_money','t_free_money < 0 error','2011-11-09 02:47:43'),(29,'2039','用户余额操作错误信息','增加帐户日志错误','sp_update_money','account_logs insert error','2011-11-09 02:47:43'),(30,'2041','即时结错误信息','该代理无有效合约','sp_settle_realtime','','2011-11-09 02:47:43'),(31,'2042','即时结错误信息','未知彩票类型','sp_settle_realtime','Unknow ticket_type','2011-11-09 02:47:43'),(32,'2043','即时结错误信息','该代理无有效合约','sp_settle_realtime','','2011-11-09 02:47:43'),(33,'2051','即时结错误信息','没有可以使用的当前帐期','sp_settle_month','','2011-11-09 02:47:43'),(34,'2052','即时结错误信息','订单彩种信息异常','sp_settle_month','ticket_type error','2011-11-09 02:47:43'),(35,'2053','即时结错误信息','该代理无有效合约','sp_settle_month','','2011-11-09 02:47:43'),(36,'2054','即时结错误信息','该代理无有效合约','sp_settle_month','','2011-11-09 02:47:43'),(37,'2061','结算锁定错误信息','处理过程被其他处理锁定，请先完成其他处理，或联系管理员解除锁定','sp_lock','','2011-11-09 02:47:43'),(38,'2071','结算锁定错误信息','记录插入异常','sp_settle_realtime_1','','2011-11-09 02:47:43'),(39,'sp_settle_tax','税务结算','月度税务结算','sp_settle_tax','sp_settle_tax','2011-11-01 03:11:11');
UNLOCK TABLES;
/*!40000 ALTER TABLE `ag_errorcodes` ENABLE KEYS */;

--
-- Table structure for table `ag_bdtypes`
--

DROP TABLE IF EXISTS `ag_bdtypes`;
CREATE TABLE `ag_bdtypes` (
  `id` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ag_bdtypes`
--


/*!40000 ALTER TABLE `ag_bdtypes` DISABLE KEYS */;
LOCK TABLES `ag_bdtypes` WRITE;
INSERT INTO `ag_bdtypes` VALUES (0),(7);
UNLOCK TABLES;
/*!40000 ALTER TABLE `ag_bdtypes` ENABLE KEYS */;

--
-- Table structure for table `ag_taxrate`
--

DROP TABLE IF EXISTS `ag_taxrate`;
CREATE TABLE `ag_taxrate` (
  `id` smallint(6) unsigned NOT NULL,
  `lowx` int(11) unsigned NOT NULL default '0',
  `highx` int(11) unsigned NOT NULL default '0',
  `taxrate` decimal(6,3) unsigned NOT NULL default '0.000',
  `subm` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ag_taxrate`
--


/*!40000 ALTER TABLE `ag_taxrate` DISABLE KEYS */;
LOCK TABLES `ag_taxrate` WRITE;
INSERT INTO `ag_taxrate` VALUES (1,0,1500,'0.030',0),(2,1500,4500,'0.050',105),(3,4500,9000,'0.200',555),(4,9000,35000,'0.250',1005),(5,35000,55000,'0.300',2755),(6,55000,80000,'0.350',5505),(7,80000,99999999,'0.450',13505);
UNLOCK TABLES;
/*!40000 ALTER TABLE `ag_taxrate` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

