<?php
set_time_limit ( 600 );
require_once 'BJDC.php';
require_once 'File_Lock.php';
$bjdc = new BJDC();
if (!File_Lock::isExists('update_bjdc_sp')) {
	File_Lock::lockFile();
	$bjdc->update_bjdc_sp();
	File_Lock::unlockFile();
}
?>