<?php
require 'SQL.php';
$sql = new SQL();
$sql2 = new SQL();
$sql3 = new SQL();
$query = 'SELECT id,match_results FROM `plans_jclqs` WHERE `match_results` IS NOT NULL and (play_method=4 or play_method=2)';
$sql->query($query);
while ($a = $sql->fetch_array()) {
	$id = $a['id'];
	$match_results = $a['match_results'];
	$t1 = explode('|', $match_results);
	$n_match_results = array();
	for ($i = 0; $i < count($t1); $i++) {
		$t2 = explode(':', $t1[$i]);
		$match_id_sp = $t2[0];
		$match_res = $t2[1];
		$t3 = explode('(', $match_id_sp);
		$match_id = $t3[0];
		$sp = substr($t3[1], 0, -1);
		//var_dump($sp);
		$t4 = explode('/', $sp);
		$n_sp = array();
		for ($j = 0; $j < count($t4); $j++) {
			$n_sp[$j] = $t4[$j].':'.$match_res;
		}
		$n_sp_s = implode('/', $n_sp);
		$n_match_results[$i] = $match_id.'('.$n_sp_s.')';
	}
	$n_match_results_s = implode('|', $n_match_results);
	echo 'id:'.$id.' 原:'.$match_results.' 现:'.$n_match_results_s.'<br />';
	$query = "update plans_jclqs set match_results='$n_match_results_s' where id=".$id;
	$sql3->query($query);
	if (!$sql3->error()) {
		echo 'id:'.$id.' updated!<br />';
	}
}
/* $query = 'select id,play_method,moreinfo from ticket_nums where id <= 46727 and ticket_type=6 and (play_method=2 or play_method=4)';
$sql->query($query);
while ($a = $sql->fetch_array()) {
	$id = $a['id'];
	$play_method = $a['play_method'];
	$moreinfo = $a['moreinfo'];
	//26395:1.65|26397:1.74,1.57
	$new_moreinfo = $moreinfo;
	$t1 = explode('|', $moreinfo);
	$t3 = array();
	for ($i = 0; $i < count($t1); $i++) {
		$t2 = explode(':', $t1[$i]);
		$match_index_id = $t2[0];
		$query = 'select goalline from match_datas where ticket_type=6 and play_type="'.$play_method.'" and match_id="'.$match_index_id.'" limit 1';
		$sql2->query($query);
		$r1 = $sql2->fetch_array();
		$t3[$i] = $match_index_id.'('.$r1['goalline'].'):'.$t2[1];
	}
	$new_moreinfo = implode('|', $t3);
	echo 'id:'.$id.' 原:'.$moreinfo.' 现:'.$new_moreinfo.'<br />';
	$query = "update ticket_nums set moreinfo='$new_moreinfo' where id=".$id;
	$sql3->query($query);
	if (!$sql3->error()) {
		echo 'id:'.$id.' updated!<br />';
	}
} */

/* $query = 'select id,play_method,match_results from plans_jclqs where match_results is not null';
$sql->query($query);
while ($a = $sql->fetch_array()) {
	$id = $a['id'];
	$play_method = $a['play_method'];
	$match_results = $a['match_results'];
	$new_match_results = $match_results;
	switch ($play_method) {
		//胜负 26396|1,26398|1 26843:1|26844:2|26845:1
		case 1 : 
			$t = str_replace('|', ':', $match_results);
			$new_match_results = str_replace(',', '|', $t);
			break;
		//让分胜负 26391|1,26392|2 26843(-11.5/-10.5):1|26844(+1.5/+2.5):2|26845(-6.5/-5.5):2
		case 2 :
			$t = explode(',', $match_results);
			$t5 = array();
			for ($i = 0; $i < count($t); $i++) {
				$r = $t[$i];
				$t1 = explode('|', $r);
				$match_index_id = $t1[0];
				$match_index_result = $t1[1];
				$query = 'select result from match_details where ticket_type=6 and index_id="'.$match_index_id.'" limit 1';
				$sql2->query($query);
				$r1 = $sql2->fetch_array();
				$t2 = explode('|', $r1['result']);
				//让分主负-0.5/让分主负+1.5
				$match_detail_res = $t2[1];
				$t3 = explode('/', $match_detail_res);
				$t4 = array();
				for ($j = 0; $j < count($t3); $j++) {
					$r2 = $t3[$j];
					$t4[$j] = mb_substr($r2, 8);
				}
				//-0.5/+1.5
				$match_detail_res = implode('/', $t4);
				$t5[$i] = $match_index_id.'('.$match_detail_res.'):'.$match_index_result;
			}
			$new_match_results = implode('|', $t5);
			break;
		//胜分差 26395|06 26843:04|26844:12|26845:01
		case 3 :
			$t = str_replace('|', ':', $match_results);
			$new_match_results = str_replace(',', '|', $t);
			break;
		//大小分 26396|2,26399|1,26401|2 26843(152.5):1|26844(151.5):2|26845(148.5):2|26846(150.5/151.5/152.5/153.5/154.5):2
		case 4 :
			$t = explode(',', $match_results);
			$t5 = array();
			for ($i = 0; $i < count($t); $i++) {
				$r = $t[$i];
				$t1 = explode('|', $r);
				$match_index_id = $t1[0];
				$match_index_result = $t1[1];
				$query = 'select result from match_details where ticket_type=6 and index_id="'.$match_index_id.'" limit 1';
				$sql2->query($query);
				$r1 = $sql2->fetch_array();
				$t2 = explode('|', $r1['result']);
				//小157.5/小158.5
				$match_detail_res = $t2[3];
				$t3 = explode('/', $match_detail_res);
				$t4 = array();
				for ($j = 0; $j < count($t3); $j++) {
					$r2 = $t3[$j];
					$t4[$j] = mb_substr($r2, 2);
				}
				//157.5/158.5
				$match_detail_res = implode('/', $t4);
				$t5[$i] = $match_index_id.'('.$match_detail_res.'):'.$match_index_result;
			}
			$new_match_results = implode('|', $t5);
			break;
		default:break;
	}
	echo 'id:'.$id.' 原:'.$match_results.' 现:'.$new_match_results.'<br />';
	$query = "update plans_jclqs set match_results='$new_match_results' where id=".$id;
	$sql3->query($query);
	if (!$sql3->error()) {
		echo 'id:'.$id.' updated!<br />';
	}
} */
?>