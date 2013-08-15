<?php
set_time_limit ( 3600 );
require_once 'ZCSF.php';
require_once 'File_Lock.php';
$zcsf = new ZCSF();
if (!File_Lock::isExists('zcsf_data_6c')) {
	File_Lock::lockFile();
	$zcsf->add_update_expect_data(3);//抓取6场半全场的赛事
	File_Lock::unlockFile();
}
?>
