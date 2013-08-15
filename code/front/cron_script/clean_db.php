<?php
set_time_limit(3600);
require_once 'Clean.php';
require_once 'File_Lock.php';
$c = new Clean();
if (!File_Lock::isExists('clean')) {
	$c->cleanTables('caipiao');
	$c->optimizeTables('caipiao');
	$c->optimizeTables('caipiao_bbs');
}
?>