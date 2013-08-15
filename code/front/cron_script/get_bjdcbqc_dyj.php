<?php
set_time_limit ( 120 );
require_once 'BJDC.php';
require_once 'File_Lock.php';
$bjdc = new BJDC();
if (!File_Lock::isExists('bjdc_data_bqc_dyj', 10)) {
	File_Lock::lockFile();
	$bjdc->getBQCbydyj();
	File_Lock::unlockFile();
}
?>
