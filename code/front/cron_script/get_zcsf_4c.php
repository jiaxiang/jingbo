<?php
set_time_limit ( 3600 );
require_once 'ZCSF.php';
require_once 'File_Lock.php';
$zcsf = new ZCSF();
if (!File_Lock::isExists('zcsf_data_4c')) {
	File_Lock::lockFile();
	$zcsf->add_update_expect_data(4);//抓取4场进球的赛事
	File_Lock::unlockFile();
}
?>
