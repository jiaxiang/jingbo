<?php
/**
 * 自动打票程序分端口，竞彩
 */
set_time_limit(3600);
require_once 'Socket_Ticket.php';
require_once 'File_Lock.php';
$port = '51105';
if (!File_Lock::isExists('jct_'.$port)) {
	File_Lock::lockFile();
	$s = new Socket_Ticket();
	$s->auto_ticket_jczq_port($port);
	File_Lock::unlockFile();
}
?>