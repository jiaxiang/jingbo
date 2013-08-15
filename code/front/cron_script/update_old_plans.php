<?php
require_once 'SQL.php';
$sql1 = new SQL();
$sql2 = new SQL();
$query1 = 'SELECT id,order_num,status FROM `plans_basics` WHERE `plan_type` = 2 AND `status` = 0 and ticket_type=2 ORDER BY `plans_basics`.`id` ASC';
$sql1->query($query1);
while ($a = $sql1->fetch_array()) {
	echo 'order_num:'.$a['order_num'].'<br />';
	echo 'status:'.$a['status'].'<br />';
	$query2 = 'SELECT id,parent_id,status FROM `plans_sfcs` WHERE basic_id="'.$a['order_num'].'"';
	$sql2->query($query2);
	$b = $sql2->fetch_array();
	echo 'status:'.$b['status'].'<br />';
	$query3 = 'SELECT status FROM `plans_sfcs` WHERE id="'.$b['parent_id'].'"';
	$sql2->query($query3);
	if ($sql2->num_rows() > 0) {
		$c = $sql2->fetch_array();
		$status = $c['status'];
	}
	else {
		$status = 6;
	}
	$sql2->query('update plans_sfcs set status="'.$status.'" where id="'.$b['id'].'"');
	$sql2->query('update plans_basics set status="'.$status.'" where id="'.$a['id'].'"');
	echo 'status:'.$status.'<br />';
}