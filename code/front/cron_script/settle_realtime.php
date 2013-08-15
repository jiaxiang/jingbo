<?php
set_time_limit ( 3600 );
require_once 'SQLi.php';
//require_once 'File_Lock.php';

//if (!File_Lock::isExists('settletime')) {
//	File_Lock::lockFile();
//	settlerealtime();
//	File_Lock::unlockFile($dbsvr);
//}

$ip = GetIP();
echo $ip.'<br/>';

$sql="CALL sp_settle_realtime(@r,@m,'".$ip."')";

$result = $mysqli->query($sql);
if ($result){
	while ($row = $result->fetch_object()){
//		printf('<br/>po_ret:%s', $row->po_ret);
//		printf('<br/>po_msg:%s', $row->po_msg);
    }
    // $result->close();
//    $mysqli->next_result();
var_dump($result);
}
if ($result2 = $mysqli->query("SELECT po_ret, po_msg, date_add FROM caipiao.ag_settle_logs WHERE actname='sp_settle_month' ORDER BY id desc LIMIT 1")) {
    printf("Select returned %d rows.<br/>", $result2->num_rows);
	while ($row = $result2->fetch_object()){
        printf('<br/>po_ret2:%s', $row->po_ret);
        printf('<br/>po_msg2:%s', $row->po_msg);
        printf('<br/>date_add:%s', $row->date_add);
    }
    $result2->close();
}


function GetIP(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
	  $cip = $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
	  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif(!empty($_SERVER["REMOTE_ADDR"])){
	  $cip = $_SERVER["REMOTE_ADDR"];
	}
	else{
	  $cip = "无法获取！";
	}
	return $cip;
}
?>