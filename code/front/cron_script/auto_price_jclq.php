<?php
 /**
 * 竞彩篮球自动兑奖
 */
set_time_limit(3600);
require_once 'File_Lock.php';
if (!File_Lock::isExists('auto_price_jclq')) 
{
	File_Lock::lockFile();
	file_get_contents('http://'.File_Lock::HOST_NAME.'/jclq/auto_get_price');
	File_Lock::unlockFile();
} 
?>
