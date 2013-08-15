<?php
set_time_limit ( 3600 );
require_once 'JCLQ.php';
require_once 'File_Lock.php';
$jclq = new JCLQ();
if (!File_Lock::isExists('jclq_res')) {
	File_Lock::lockFile();
	$jclq->getUnResultMatch();
	File_Lock::unlockFile();
}
?>