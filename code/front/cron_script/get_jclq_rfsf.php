<?php
set_time_limit ( 3600 );
require_once 'JCLQ.php';
require_once 'File_Lock.php';
$jclq = new JCLQ();
if (!File_Lock::isExists('jclq2')) {
	File_Lock::lockFile();
	$jclq->getBetMatch();	//rang fen sheng fu bi fen
	File_Lock::unlockFile();
}
?>