<?php
require_once 'SQL.php';
$sql1 = new SQL();
$sql2 = new SQL();
$query1 = 'select id,user_id,is_in,price,user_money,memo,add_time from 
account_logs order by id';
$sql1->query($query1);
while ($a = $sql1->fetch_array()) {
	$query2 = 'insert into money_logs (account_log_id,user_id,log_type,is_in,
	price,user_money,memo,add_time) values ("'.$a['id'].'","'.$a['user_id'].'",
	"USER_MONEY","'.$a['is_in'].'","'.$a['price'].'","'.$a['user_money'].'",
	"'.$a['memo'].'","'.$a['add_time'].'")';
	$query3 = 'select id from money_logs where account_log_id="'.$a['id'].'"';
	$sql2->query($query3);
	if ($sql2->num_rows() <= 0) {
		$sql2->query($query2);
		if (!$sql2->error()) echo $a['id'].'<br />';
		else echo $query2.'<br />';
	}
}
?>