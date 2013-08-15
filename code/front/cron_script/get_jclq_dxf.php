<?php
set_time_limit ( 3600 );
require_once 'JCLQ.php';
require_once 'File_Lock.php';
$jclq = new JCLQ();
if (!File_Lock::isExists('jclq4')) {
	File_Lock::lockFile();
	$jclq->getHafuMatch();	//大小分
	File_Lock::unlockFile();
}
?>