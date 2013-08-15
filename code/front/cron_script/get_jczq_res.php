<?php
set_time_limit ( 3600 );
require_once 'JCZQ.php';
require_once 'File_Lock.php';
$jczq = new JCZQ();
if (!File_Lock::isExists('jczq_res')) {
	File_Lock::lockFile();
	$jczq->getUnResultMatch();
	File_Lock::unlockFile();
}
?>