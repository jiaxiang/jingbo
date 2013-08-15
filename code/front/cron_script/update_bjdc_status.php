<?php
set_time_limit ( 600 );
require_once 'BJDC.php';
require_once 'File_Lock.php';
$bjdc = new BJDC();
if (!File_Lock::isExists('bjdc_status_update', 10)) {
	File_Lock::lockFile();
	$bjdc->getResultByTicketId();//更新彩票状态和奖金
	File_Lock::unlockFile();
}
?>