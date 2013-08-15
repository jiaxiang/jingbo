<?php
set_time_limit ( 120 );
require_once 'JSPL.php';
//require_once 'File_Lock.php';
$jspl = new JSPL();
//if (!File_Lock::isExists('jspl_data')) {
	//File_Lock::lockFile();
	
	$jspl->update_odd();
	//File_Lock::unlockFile();
//}
?>