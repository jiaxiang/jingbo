<?php
/**
 * 足彩胜负结果
 */
set_time_limit(0);
require_once 'File_Lock.php';
if (!File_Lock::isExists('get_zcsf_res')) {
	File_Lock::lockFile();
	file_get_contents('http://'.File_Lock::HOST_NAME.'/zcsf/auto_compare');
	File_Lock::unlockFile();
}
?>