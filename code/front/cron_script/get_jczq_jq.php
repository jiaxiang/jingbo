<?php
set_time_limit ( 3600 );
require_once 'JCZQ.php';
require_once 'File_Lock.php';
$jczq = new JCZQ();
if (!File_Lock::isExists('jczq3')) {
	File_Lock::lockFile();
	$jczq->getZJQSMatch();
	File_Lock::unlockFile();
}
?>