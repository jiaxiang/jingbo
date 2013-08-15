<?php
set_time_limit ( 3600 );
require_once 'BJDC.php';
require_once 'File_Lock.php';
$bjdc = new BJDC();
if (!File_Lock::isExists('bjdc_repost')) {
	File_Lock::lockFile();
	$bjdc->getLosePostTickets();//重新对未投注成功的彩票投注
	File_Lock::unlockFile();
}
?>