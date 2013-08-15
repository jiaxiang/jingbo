<?php
set_time_limit ( 120 );
require_once 'BJDC.php';
require_once 'File_Lock.php';
$bjdc = new BJDC();
if (!File_Lock::isExists('bjdc_data', 10)) {
	File_Lock::lockFile();
	$bjdc->getIssueByBetid('501');//抓取胜平负期号赛程
	$bjdc->getIssueByBetid('502');//抓取上下单双期号赛程
	$bjdc->getIssueByBetid('503');//抓取总进球数期号赛程
	$bjdc->getIssueByBetid('504');//抓取比分期号赛程
	$bjdc->getIssueByBetid('505');//抓取半全场期号赛程
	File_Lock::unlockFile();
}
?>
