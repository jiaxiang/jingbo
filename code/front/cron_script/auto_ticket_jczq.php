<?php
/**
 * 自动打票程序，竞彩足球
 */
set_time_limit(200);
require_once 'Socket_Ticket.php';
require_once 'File_Lock.php';
if (!File_Lock::isExists('auto_ticket_jczq')) {
	File_Lock::lockFile();
	$s = new Socket_Ticket();
	//$s->auto_ticket_jczq();
	File_Lock::unlockFile();
}
?>