<?php
set_time_limit ( 600 );
require_once 'JCZQ.php';
require_once 'File_Lock.php';
$jczq = new JCZQ();
if (!File_Lock::isExists('update_jczq_sp')) {
	File_Lock::lockFile();
	$jczq->update_jczq_sp();
	File_Lock::unlockFile();
}
?>