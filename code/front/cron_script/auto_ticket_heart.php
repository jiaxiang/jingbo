<?php
/**
 * 自动打票程序-心跳
 */
set_time_limit(60);
require_once 'Socket_Ticket.php';
require_once 'File_Lock.php';
if (!File_Lock::isExists('auto_ticket_heart')) {
	File_Lock::lockFile();
	//$s = new Socket_Ticket();
	//$s->heart_socket('51101');
	//$s->heart_socket('51102');
	File_Lock::unlockFile();
}
?>