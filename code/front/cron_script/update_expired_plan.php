<?php
/**
 * 清保
 */
set_time_limit(0);
require_once 'File_Lock.php';
if (!File_Lock::isExists('update_expired_plan')) {
	File_Lock::lockFile();
	file_get_contents('http://'.File_Lock::HOST_NAME.'/auto/expired_plan');
	File_Lock::unlockFile();
}
?>