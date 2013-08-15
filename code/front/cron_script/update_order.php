<?php
/**
 * 自动派奖，自动取消
 */
set_time_limit(0);
require_once 'File_Lock.php';
if (!File_Lock::isExists('update_order')) {
	File_Lock::lockFile();
	file_get_contents('http://www.jingbo365.com/auto/update_order');
	File_Lock::unlockFile();
}
?>