<?php
/**
 * 超级发单人返点，分销返点过滤程序
 */
set_time_limit(200);
require_once 'Superplaners.php';
require_once 'File_Lock.php';
if (!File_Lock::isExists('superplaner_init')) {
	File_Lock::lockFile();
	$s = new Superplaners();
	$s->set_plan_agstate();
	File_Lock::unlockFile();
} 
?>