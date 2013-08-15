<?php
set_time_limit ( 120 );
require_once 'JSPL.php';
require_once 'File_Lock.php';
$jspl = new JSPL();
if (!File_Lock::isExists('jspl_data')) {
	File_Lock::lockFile();
	$jspl->odd_txt_content = $jspl->get_odd_txt();
	$jspl->get_odd_yp();
	$jspl->get_odd_op();
	$jspl->get_odd_dx();
	File_Lock::unlockFile();
}
?>