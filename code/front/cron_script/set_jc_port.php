<?php
/**
 * 竞彩足球，自动分端口
 */
set_time_limit(3600);
require_once 'Socket_Ticket.php';
require_once 'File_Lock.php';
if (!File_Lock::isExists('set_jczq_port')) {
	File_Lock::lockFile();
	$s = new Socket_Ticket();
	$s->set_jczq_port();
	File_Lock::unlockFile();
}
?>