<?php
require_once 'SQL.php';
$sql1 = new SQL();
$sql2 = new SQL();
$query1 = 'SELECT id  FROM `users` WHERE `user_money` > 100 and `user_money` <= 150';
$sql1->query($query1);
while ($a = $sql1->fetch_array()) {
	$query2 = 'update users set user_money=user_money-100,free_money=free_money+100 where id="'.$a['id'].'"';
	$sql2->query($query2);
	if (!$sql2->error()) echo $a['id'].' update<br />';
}
?>