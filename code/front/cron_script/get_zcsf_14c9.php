<?php
set_time_limit ( 3600 );
require_once 'ZCSF.php';
require_once 'File_Lock.php';
$zcsf = new ZCSF();
if (!File_Lock::isExists('zcsf_data_14c9')) {
	File_Lock::lockFile();
	$zcsf->add_update_expect_data(1);//抓取14胜负彩和任选9场的赛事
	File_Lock::unlockFile();
}
?>
