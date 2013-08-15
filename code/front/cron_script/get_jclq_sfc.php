<?php
set_time_limit ( 3600 );
require_once 'JCLQ.php';
require_once 'File_Lock.php';
$jclq = new JCLQ();
if (!File_Lock::isExists('jclq3')) {
	File_Lock::lockFile();
	$jclq->getBFMatch();	//胜分差
	File_Lock::unlockFile();
}
?>