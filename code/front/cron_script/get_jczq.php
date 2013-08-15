<?php
set_time_limit ( 3600 );
require_once 'JCZQ.php';
require_once 'File_Lock.php';
$jczq = new JCZQ();
if (!File_Lock::isExists('jczq')) {
	File_Lock::lockFile();
	$jczq->getSPFMatch();
	$jczq->getBFMatch();
	$jczq->getZJQSMatch();
	$jczq->getBQCMatch();
	File_Lock::unlockFile();
}
?>