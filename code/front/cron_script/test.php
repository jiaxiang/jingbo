<?php
/**
 * 自动打票程序，测试
 */
/*set_time_limit(200);
require_once 'Socket_Ticket.php';
$s = new Socket_Ticket();
$s->auto_ticket_jczq();
//$s->auto_ticket_zcsf();*/
/*if (isset($_FILES['txt'])) {
	//var_dump($_FILES['txt']);
	$file_info = $_FILES['txt'];
	$msg = '上传错误';
	if ($file_info['type'] == 'text/plain') {
		if ($file_info['error'] == 0) {
			$file_name = $file_info['name'];
			$file_name_a = explode('.', $file_name);
			$file_name_a_c = count($file_name_a);
			if (strtolower($file_name_a[$file_name_a_c-1]) == 'txt') {
				$file_size = $file_info['size'];
				if ($file_size <= 800000) {
					$file_tmp = $file_info['tmp_name'];
					$file_content = file_get_contents($file_tmp);
					$file_content_row = explode("\r\n", $file_content);
					$data = array();
					$data_play_type = array();
					$data_match = array();
					$data_gg = array();
					$data_beishu = array();
					for ($i = 0; $i < count($file_content_row); $i++) {
						if ($file_content_row[$i] != '') {
							$tmp = explode('|', $file_content_row[$i]);
							$data[$i]['play_type'] = $tmp[0];
							$matchs = explode(',', $tmp[1]);
							$match_detail = array();
							$match_info = array();
							$match_code = array();
							for ($j = 0; $j < count($matchs); $j++) {
								$tmp2 = explode('=', $matchs[$j]);
								if (!isset($match_detail[$tmp2[0]])) {
									$match_date_y = substr($tmp2[0], 0, 2);
									$match_date_m = substr($tmp2[0], 2, 2);
									$match_date_d = substr($tmp2[0], 4, 2);
									$match_date = date('Y-m-d', strtotime($match_date_y.'-'.$match_date_m.'-'.$match_date_d));
									$match_no = substr($tmp2[0], 6, 3);
									//赛事信息查询
									//$match_detail[$tmp2[0]] = 
									//$match_info[$j]['info'] = 
								}
								else {
									$match_info[$j]['info'] = $match_detail[$tmp2[0]];
								}
								$match_info[$j]['result'] = $tmp2[1];
								$match_code[$j] = $match_info[$j]['info']['match_id'].'|'.$match_info[$j]['info']['match_num'].'['.$match_info[$j]['result'].']';
							}
							$data[$i]['code'] = implode('/', $match_code);
							$data[$i]['match_info'] = $match_info;
							$tmp2 = explode(':', $tmp[2]);
							$data[$i]['typename'] = $tmp2[0];
							$data[$i]['rate'] = $tmp2[1];
						}
					}
				}
				else {
					$msg = '上传文件太大';
				}
			}
			else {
				$msg = '上传格式错误';
			}
		}
		else {
			$msg = '上传错误';
		}
	}
	else {
		$msg = '上传格式错误';
	}
}	*/
/*$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://apps.zs310.com/dz/jc/spf/2011-11-17');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
$result = json_decode($result);
foreach ($result->result->matchs->C->list as $key => $val) {
	var_dump($key);
	var_dump($val);
}*/
//var_dump($result);
/* require_once 'SQl.php';
$sql = new SQL();
$sql1 = new SQL();
for ($i = 0; $i < 10; $i++) {
	$expire = '2011-12-31';
	$card_no = '0000001-'.rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
	$card_pw = rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9);
	$query = 'select id from money_cards where card_id="'.$card_no.'" limit 1';
	$sql->query($query);
	if ($sql->num_rows() > 0) continue;
	
	$query = 'select id from money_cards where card_pw="'.$card_pw.'" limit 1';
	$sql->query($query);
	if ($sql->num_rows() > 0) continue;
	
	$query = 'insert into money_cards (card_id,card_pw,value,expire) values ("'.$card_no.'","'.$card_pw.'",200,"'.$expire.'")';
	$sql->query($query);
	if (!$sql->error()) echo $query;
} */

/* set_time_limit ( 3600 );
require_once 'JCLQ.php';
require_once 'File_Lock.php';
$jclq = new JCLQ();
$r = $jclq->getResultById(26603); */
//var_dump($r);
//var_dump($_SERVER);
/* require_once 'ZCSF.php';
$zcsf = new ZCSF();
$r = $zcsf->get_current_expect_num();
var_dump($r); */
$a = array(0,1,0,1,0,1);
for ($i = 0; $i < count($a); $i++) {
	if ($a[$i] == 0) {
		continue;
	}
	echo '2<br />';
}
?>
