<?php
set_time_limit ( 600 );
require_once 'JSBF.php';
require_once 'File_Lock.php';
$jsbf = new JSBF();
if (!File_Lock::isExists('update_jsbf_sp')) {
	File_Lock::lockFile();
	$jsbf->refresh_sp();
	File_Lock::unlockFile();
}
?>