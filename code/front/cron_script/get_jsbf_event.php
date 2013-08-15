<?php
set_time_limit ( 120 );
require_once 'JSBF.php';
require_once 'File_Lock.php';
$jsbf = new JSBF();
if (!File_Lock::isExists('jsbf_event')) {
	File_Lock::lockFile();
	$jsbf->getTodayEventBf();
	File_Lock::unlockFile();
}
?>