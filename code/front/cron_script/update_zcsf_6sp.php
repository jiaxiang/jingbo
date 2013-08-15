<?php
set_time_limit ( 600 );
require_once 'ZCSF.php';
require_once 'File_Lock.php';
$zcsf = new ZCSF();
if (!File_Lock::isExists('update_zcsf_6sp')) {
	File_Lock::lockFile();
	$zcsf->update_zc_sp(6);
	File_Lock::unlockFile();
}
?>