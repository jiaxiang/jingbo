<?php
/**
 * 一次性更新彩票中sp，竞彩足球
 */
set_time_limit(3600);
require_once 'Socket_Ticket.php';
$s = new Socket_Ticket();
$s->updateJczqUnSPTicket();
?>