<?php
set_time_limit ( 3600 );
require_once 'JCZQ.php';
require_once 'File_Lock.php';
$jczq = new JCZQ();
if (!File_Lock::isExists('jczq2')) {
	File_Lock::lockFile();
	$jczq->getBFMatch();
	File_Lock::unlockFile();
}
?>