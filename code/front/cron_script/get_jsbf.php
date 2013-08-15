<?php
set_time_limit ( 120 );
require_once 'JSBF.php';
require_once 'File_Lock.php';
$jsbf = new JSBF();
if (!File_Lock::isExists('jsbf_data', 5)) {
	File_Lock::lockFile();
	$jsbf->getTodayBf();
	File_Lock::unlockFile();
}
?>