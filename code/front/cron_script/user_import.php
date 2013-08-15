<?php
require_once 'SQL.php';
$sql = new SQL();
$sql1 = new SQL();
$query = 'select id,mobile,real_name,lastname,ip,email,identity_card from users where active=1 and register_mail_active=1 and check_status=2';
$sql->query($query);
while ($a = $sql->fetch_array()) {
	$insert_query = 'insert into users_handsels (uid,identity_card,email,mobile,ip,real_name,lastname) values 
	("'.$a['id'].'","'.$a['identity_card'].'","'.$a['email'].'","'.$a['mobile'].'","'.$a['ip'].'","'.$a['real_name'].'","'.$a['lastname'].'")';
	$sql1->query($insert_query);
	if (!$sql1->error()) {
		echo $a['id'].'is ok<br />';
	}
	else {
		echo $insert_query.'<br />';
	}
}
?>