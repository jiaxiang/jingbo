<?php
/**
 * 北单自动派奖
 */
set_time_limit(0);
require_once 'File_Lock.php';
if (!File_Lock::isExists('auto_bonus_bjdc')) {
	File_Lock::lockFile();
	file_get_contents('http://'.File_Lock::HOST_NAME.'/auto/bjdc_plan_bonus');
	File_Lock::unlockFile();
}
?>