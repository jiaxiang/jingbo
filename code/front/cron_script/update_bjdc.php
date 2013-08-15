<?php
set_time_limit ( 600 );
require_once 'BJDC.php';
require_once 'File_Lock.php';
$bjdc = new BJDC();
if (!File_Lock::isExists('bjdc_res_update', 10)) {
	File_Lock::lockFile();
	$bjdc->getUndoMatch();//更新比赛结果
	File_Lock::unlockFile();
}
?>