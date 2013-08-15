<?php
set_time_limit ( 3600 );
require_once 'JCLQ.php';
require_once 'File_Lock.php';
$jclq = new JCLQ();
if (!File_Lock::isExists('jclq')) {
	File_Lock::lockFile();
	
	$jclq->getSPFMatch();	//胜负比分
	$jclq->getBetMatch();	//rang fen sheng fu bi fen
	$jclq->getBFMatch();	//胜分差
	$jclq->getHafuMatch();	//大小分
	
	File_Lock::unlockFile();
}
?>