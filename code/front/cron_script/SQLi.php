<?php
	$db = 'caipiao';
	$server = '10.99.0.10';
	$user = 'root';
	$pass = 'jbDB365#';
	$port = '3306';
	$mysqli = new mysqli($server, $user, $pass, $db, $port);
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit ();
	}
	$mysqli->autocommit(false);
	$mysqli->query('set names utf8;');
	if ($mysqli->errno) {
		die("Execution failed: ".$mysqli->errno.": ".$mysqli->error);
	}
?>
