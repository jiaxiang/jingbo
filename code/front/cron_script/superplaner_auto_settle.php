<?php
/**
 * 超级发单人自动结算
 */
set_time_limit(0);
require_once 'File_Lock.php';
if (!File_Lock::isExists('superplaner_auto_settle')) {
	File_Lock::lockFile();
	file_get_contents('http://'.File_Lock::HOST_NAME.'/superplaner/realtime_settle/auto_settle');
	File_Lock::unlockFile();
}
?>