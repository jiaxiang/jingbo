<?php
class JCZQ {
	
	const MAX_MID = 5;
	const MURL = 'http://118.186.215.50/football/info/fb_match_info.php?m=';
	//const RESULTURL = 'http://info.sporttery.cn/football/pool_result.php?id=';
	const RESULTURL = 'http://118.186.215.50/football/pool_result.php?id=';
	
	const TMP_FILE = '/tmp/t1.txt';
	const XML_URL = 'http://www.jingbo365.com/xml/jczq/';
	const HHAD_URL = 'http://info.sporttery.cn/football/back/hhad_list.php';
	const CRS_URL = 'http://info.sporttery.cn/football/back/crs_list.php';
	const TTG_URL = 'http://info.sporttery.cn/football/back/ttg_list.php';
	const HAFU_URL = 'http://info.sporttery.cn/football/back/hafu_list.php';
	
	const T_TYPE = 1;
	
	public $week_array = array(
		'周一'=>'1',
		'周二'=>'2',
		'周三'=>'3',
		'周四'=>'4',
		'周五'=>'5',
		'周六'=>'6',
		'周日'=>'7'
	);
	
	private $sql;
	
	function __construct() {
		require_once 'SQL.php';
		$this->sql = new SQL();
	}
	
	/**
	 * 让球胜平负
	 * Enter description here ...
	 */
	function getSPFMatch() {
		$play_type = 1;
		$match_list = array();
		$c = file_get_contents(self::HHAD_URL);
		//var_dump($c);
		preg_match_all("/m=(.*)\" style=/", $c, $match_id, PREG_SET_ORDER);
		//var_dump($match_id);
		$match_id_count = count($match_id);
		$match_id_array = array();
		for ($i = 0; $i < $match_id_count; $i++) {
			$mid = $match_id[$i][1];
			$match_id_array[$i] = $mid;
		}
		sort($match_id_array);
		//var_dump($match_id_array);
		
		$first_key = 0;
		$last_key = $match_id_count - 1;
		
		$query = 'select match_id from match_datas where match_id >= "'.$match_id_array[$first_key].'" and 
		match_id <= "'.$match_id_array[$last_key].'" and pool_id = 0 and ticket_type = 1 and play_type = 1';
		$this->sql->query($query);
		$match_id_array_db = array();
		while ($a = $this->sql->fetch_array()) {
			$match_id_array_db[] = $a['match_id'];
		}
		sort($match_id_array_db);
		//var_dump($match_id_array_db);
		
		if (count($match_id_array_db) > $match_id_count) {
			$diff = array_diff($match_id_array_db, $match_id_array);
			foreach ($diff as $key => $val) {
				$query = 'update match_datas set pool_id = 1 where match_id = "'.$val.'"';
				$this->sql->query($query);
				if (!$this->sql->error()) {
					echo $val.' is cancel <br />';
				}
			}
		}
		//echo $query;
		//die();
		
		$match_info_s = $this->getTeamNameByC_rq($c);
		//var_dump($match_info_s);die();
		
		for ($i = 0; $i < $match_id_count; $i++) {
			$mid = $match_id[$i][1];
			//var_dump($mid);
			//var_dump(count($match_id));die();
			//if ($mid == 27812) continue;
			//if ($mid == 27813) continue;
			//if ($mid == 27811) continue;
			
			$no = $i+1;
			if ($no < 10) {
				$no = '00'.$no;
			}
			if ($no >= 10 && $no < 100) {
				$no = '0'.$no;
			}
			
			$p_s_1 = "/\"select_match\('".$no."001'\)\"\/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"50\"><input type=\"checkbox\" id=\"m".$no."002\"/";
			$p_s_2 = "/\"select_match\('".$no."002'\)\"\/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"50\"><input type=\"checkbox\" id=\"m".$no."003\"/";
			$p_s_3 = "/\"select_match\('".$no."003'\)\"\/>(.*)<\/td>		<td class=\"tdWL tdWLL td3\"/";
			preg_match_all($p_s_1, $c, $sp1, PREG_SET_ORDER);
			preg_match_all($p_s_2, $c, $sp2, PREG_SET_ORDER);
			preg_match_all($p_s_3, $c, $sp3, PREG_SET_ORDER);
			if (!isset($sp1[0])) {
				echo 'no:'.$no.',match_id:'.$mid.' error';
			}
			$s_sp = $sp1[0][1];
			$p_sp = $sp2[0][1];
			$f_sp = $sp3[0][1];
			//$match_info = $this->getTeamNameByURL(self::MURL.$mid);
			//var_dump($match_info);
			//echo $no;
			$match_info = $match_info_s[$mid];
			//var_dump($match_info);
			$match_num = $this->week_array[substr($match_info[2], 0, -3)].substr($match_info[2], -3);
			preg_match_all("/line\">\r\n		(.*)<strong/", $c, $home, PREG_SET_ORDER);
			preg_match_all("/\((.*)\)/", $home[$i][1], $home_g, PREG_SET_ORDER);
			if (isset($home_g[0][1])) {
				$goalline = $home_g[0][1];
			}
			else {
				$goalline = 0;
			}
			$ymd = date("Y-m-d", strtotime($match_info[4]));
			$his = date("H:i:s", strtotime($match_info[4]));
			$ymdhis = date("Y-m-d H:i:s", strtotime($match_info[4]));
			//var_dump($ymdhis);die();
			$comb = array();
			$comb['h']['c'] = 'H';//胜
			$comb['h']['v'] = $s_sp;
			$comb['h']['d'] = $ymd;
			$comb['h']['t'] = $his;
			
			$comb['a']['c'] = 'A';//负
			$comb['a']['v'] = $f_sp;
			$comb['a']['d'] = $ymd;
			$comb['a']['t'] = $his;
                    
			$comb['d']['c'] = 'D';//平
			$comb['d']['v'] = $p_sp;
			$comb['d']['d'] = $ymd;
			$comb['d']['t'] = $his;  
                    
			$comb_j = json_encode($comb);
			$this->sql->query('select id,comb from match_datas where ticket_type="'.self::T_TYPE.'" and play_type="'.$play_type.'" and match_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				if ($match_num > 0) {
					$this->sql->query('insert into match_datas (ticket_type,play_type,match_num,match_id,pool_id,goalline,comb) values (
					"'.self::T_TYPE.'","'.$play_type.'","'.$match_num.'","'.$mid.'","0","'.$goalline.'",\''.$comb_j.'\')');
					if (!$this->sql->error()) echo 'spf:insert:'.$mid.'<br />';
				}
			}
			else {
				//更新赔率
				$id = $this->sql->fetch_array();
				if ($id['comb'] != $comb_j) {
					$this->sql->query('update match_datas set last_comb=comb, comb=\''.$comb_j.'\' where id="'.$id['id'].'"');
					if (!$this->sql->error()) echo 'spf:update:'.$mid.'<br />';
				}
			}
			$this->sql->query('select id,host_rank,guest_rank,time,yp_data from match_details where index_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				$this->sql->query('insert into match_details (index_id,ticket_type,host_name,host_url,guest_name,guest_url,match_info,league,time) values 
				("'.$mid.'",1,"'.$match_info[0].'","'.$match_info[5].'","'.$match_info[1].'","'.$match_info[6].'","'.$match_info[2].'","'.$match_info[3].'","'.$ymdhis.'")');
				if (!$this->sql->error()) echo 'match_detail:insert:'.$mid.'<br />';
			}
			else {
				$match_detail = $this->sql->fetch_array();
				if ($match_detail['host_rank'] == null || $match_detail['guest_rank'] == null) {
					$this->sql->query('select home_rank,away_rank from jsbf_datas where jc_id="'.$mid.'" limit 1');
					if ($this->sql->num_rows() > 0) {
						$js_data = $this->sql->fetch_array();
						$this->sql->query('update match_details set host_rank="'.$js_data['home_rank'].'",guest_rank="'.$js_data['away_rank'].'" where index_id="'.$mid.'"');
						if (!$this->sql->error()) echo 'rank:update:'.$mid.'<br />';
					}
				}
				//var_dump($match_detail);die();
				if ($match_detail['yp_data'] == null) {
					$this->sql->query('select yp_data from jsbf_datas where jc_id="'.$mid.'" limit 1');
					if ($this->sql->num_rows() > 0) {
						$yp_data = $this->sql->fetch_array();
						$this->sql->query('update match_details set yp_data="'.$yp_data['yp_data'].'" where index_id="'.$mid.'"');
						if (!$this->sql->error()) echo 'yp_data:update:'.$mid.'<br />';
					}
				}
				if ($ymdhis != $match_detail['time']) {
					$this->sql->query('update match_details set time="'.$ymdhis.'" where index_id="'.$mid.'"');
					if (!$this->sql->error()) echo 'time:update:'.$mid.'<br />';
				}
			}
		}
	}
	
	/**
	 * 比分
	 * Enter description here ...
	 */
	function getBFMatch() {
		$play_type = 3;
		$match_list = array();
		$c = file_get_contents(self::CRS_URL);
		preg_match_all("/m=(.*)\" style=/", $c, $match_id, PREG_SET_ORDER);
		$match_info_s = $this->getTeamNameByC_bf($c);
		for ($i = 0; $i < count($match_id); $i++) {
			$mid = $match_id[$i][1];
			//if ($mid == 27812) continue;
			//if ($mid == 27813) continue;
			//if ($mid == 27811) continue;
			$no = $i+1;
			if ($no < 10) {
				$no = '00'.$no;
			}
			if ($no >= 10 && $no < 100) {
				$no = '0'.$no;
			}
			$p_s_1 = "/\"select_match\('".$no."001'\)\"\/>1:0<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."002\"/";
			$p_s_2 = "/\"select_match\('".$no."002'\)\"\/>2:0<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."003\"/";
			$p_s_3 = "/\"select_match\('".$no."003'\)\"\/>2:1<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."004\"/";
			$p_s_4 = "/\"select_match\('".$no."004'\)\"\/>3:0<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."005\"/";
			$p_s_5 = "/\"select_match\('".$no."005'\)\"\/>3:1<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."006\"/";
			$p_s_6 = "/\"select_match\('".$no."006'\)\"\/>3:2<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."007\"/";
			$p_s_7 = "/\"select_match\('".$no."007'\)\"\/>4:0<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."008\"/";
			$p_s_8 = "/\"select_match\('".$no."008'\)\"\/>4:1<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."009\"/";
			$p_s_9 = "/\"select_match\('".$no."009'\)\"\/>4:2<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."010\"/";
			$p_s_10 = "/\"select_match\('".$no."010'\)\"\/>5:0<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."011\"/";
			$p_s_11 = "/\"select_match\('".$no."011'\)\"\/>5:1<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."012\"/";
			$p_s_12 = "/\"select_match\('".$no."012'\)\"\/>5:2<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."013\"/";
			$p_s_13 = "/\"select_match\('".$no."013'\)\"\/>(.*)<\/p><\/td><\/tr>/";
			
			$p_s_14 = "/\"select_match\('".$no."014'\)\"\/>0:0<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."015\"/";
			$p_s_15 = "/\"select_match\('".$no."015'\)\"\/>1:1<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."016\"/";
			$p_s_16 = "/\"select_match\('".$no."016'\)\"\/>2:2<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."017\"/";
			$p_s_17 = "/\"select_match\('".$no."017'\)\"\/>3:3<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."018\"/";
			$p_s_18 = "/\"select_match\('".$no."018'\)\"\/>(.*)<\/p><\/td><\/tr>/";
			
			$p_s_19 = "/\"select_match\('".$no."019'\)\"\/>0:1<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."020\"/";
			$p_s_20 = "/\"select_match\('".$no."020'\)\"\/>0:2<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."021\"/";
			$p_s_21 = "/\"select_match\('".$no."021'\)\"\/>1:2<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."022\"/";
			$p_s_22 = "/\"select_match\('".$no."022'\)\"\/>0:3<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."023\"/";
			$p_s_23 = "/\"select_match\('".$no."023'\)\"\/>1:3<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."024\"/";
			$p_s_24 = "/\"select_match\('".$no."024'\)\"\/>2:3<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."025\"/";
			$p_s_25 = "/\"select_match\('".$no."025'\)\"\/>0:4<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."026\"/";
			$p_s_26 = "/\"select_match\('".$no."026'\)\"\/>1:4<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."027\"/";
			$p_s_27 = "/\"select_match\('".$no."027'\)\"\/>2:4<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."028\"/";
			$p_s_28 = "/\"select_match\('".$no."028'\)\"\/>0:5<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."029\"/";
			$p_s_29 = "/\"select_match\('".$no."029'\)\"\/>1:5<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."030\"/";
			$p_s_30 = "/\"select_match\('".$no."030'\)\"\/>2:5<p>(.*)<\/p><\/td><td class=\"tdC\"><input type=\"checkbox\" id=\"m".$no."031\"/";
			$p_s_31 = "/\"select_match\('".$no."031'\)\"\/>(.*)<\/p><\/td><\/tr>/";
			
			preg_match_all($p_s_1, $c, $sp1, PREG_SET_ORDER);
			preg_match_all($p_s_2, $c, $sp2, PREG_SET_ORDER);
			preg_match_all($p_s_3, $c, $sp3, PREG_SET_ORDER);
			preg_match_all($p_s_4, $c, $sp4, PREG_SET_ORDER);
			preg_match_all($p_s_5, $c, $sp5, PREG_SET_ORDER);
			preg_match_all($p_s_6, $c, $sp6, PREG_SET_ORDER);
			preg_match_all($p_s_7, $c, $sp7, PREG_SET_ORDER);
			preg_match_all($p_s_8, $c, $sp8, PREG_SET_ORDER);
			preg_match_all($p_s_9, $c, $sp9, PREG_SET_ORDER);
			preg_match_all($p_s_10, $c, $sp10, PREG_SET_ORDER);
			preg_match_all($p_s_11, $c, $sp11, PREG_SET_ORDER);
			preg_match_all($p_s_12, $c, $sp12, PREG_SET_ORDER);
			preg_match_all($p_s_13, $c, $sp13, PREG_SET_ORDER);
			$sp13 = $this->encodeUTF8($sp13);
			$sp13 = substr($sp13[0][1], 12);
			
			preg_match_all($p_s_14, $c, $sp14, PREG_SET_ORDER);
			preg_match_all($p_s_15, $c, $sp15, PREG_SET_ORDER);
			preg_match_all($p_s_16, $c, $sp16, PREG_SET_ORDER);
			preg_match_all($p_s_17, $c, $sp17, PREG_SET_ORDER);
			preg_match_all($p_s_18, $c, $sp18, PREG_SET_ORDER);
			$sp18 = $this->encodeUTF8($sp18);
			$sp18 = substr($sp18[0][1], 12);
			
			preg_match_all($p_s_19, $c, $sp19, PREG_SET_ORDER);
			preg_match_all($p_s_20, $c, $sp20, PREG_SET_ORDER);
			preg_match_all($p_s_21, $c, $sp21, PREG_SET_ORDER);
			preg_match_all($p_s_22, $c, $sp22, PREG_SET_ORDER);
			preg_match_all($p_s_23, $c, $sp23, PREG_SET_ORDER);
			preg_match_all($p_s_24, $c, $sp24, PREG_SET_ORDER);
			preg_match_all($p_s_25, $c, $sp25, PREG_SET_ORDER);
			preg_match_all($p_s_26, $c, $sp26, PREG_SET_ORDER);
			preg_match_all($p_s_27, $c, $sp27, PREG_SET_ORDER);
			preg_match_all($p_s_28, $c, $sp28, PREG_SET_ORDER);
			preg_match_all($p_s_29, $c, $sp29, PREG_SET_ORDER);
			preg_match_all($p_s_30, $c, $sp30, PREG_SET_ORDER);
			preg_match_all($p_s_31, $c, $sp31, PREG_SET_ORDER);
			$sp31 = $this->encodeUTF8($sp31);
			$sp31 = substr($sp31[0][1], 12);
			
			$sp_10 = $sp1[0][1];
			$sp_20 = $sp2[0][1];
			$sp_21 = $sp3[0][1];
			$sp_30 = $sp4[0][1];
			$sp_31 = $sp5[0][1];
			$sp_32 = $sp6[0][1];
			$sp_40 = $sp7[0][1];
			$sp_41 = $sp8[0][1];
			$sp_42 = $sp9[0][1];
			$sp_50 = $sp10[0][1];
			$sp_51 = $sp11[0][1];
			$sp_52 = $sp12[0][1];
			$sp_sqt = $sp13;
			$sp_00 = $sp14[0][1];
			$sp_11 = $sp15[0][1];
			$sp_22 = $sp16[0][1];
			$sp_33 = $sp17[0][1];
			$sp_pqt = $sp18;
			$sp_01 = $sp19[0][1];
			$sp_02 = $sp20[0][1];
			$sp_12 = $sp21[0][1];
			$sp_03 = $sp22[0][1];
			$sp_13 = $sp23[0][1];
			$sp_23 = $sp24[0][1];
			$sp_04 = $sp25[0][1];
			$sp_14 = $sp26[0][1];
			$sp_24 = $sp27[0][1];
			$sp_05 = $sp28[0][1];
			$sp_15 = $sp29[0][1];
			$sp_25 = $sp30[0][1];
			$sp_fqt = $sp31;
			
			//$match_info = $this->getTeamNameByURL(self::MURL.$mid);
			$match_info = $match_info_s[$mid];
			//var_dump($match_info);die();
			$match_num = $this->week_array[substr($match_info[2], 0, -3)].substr($match_info[2], -3);
			/*preg_match_all("/line\">\r\n		(.*)<strong/", $c, $home, PREG_SET_ORDER);
			preg_match_all("/\((.*)\)/", $home[$i][1], $home_g, PREG_SET_ORDER);
			if (isset($home_g[0][1])) {
				$goalline = $home_g[0][1];
			}
			else {
				$goalline = 0;
			}*/
			$goalline = 0;
			$ymd = date("Y-m-d", strtotime($match_info[4]));
			$his = date("H:i:s", strtotime($match_info[4]));
			$ymdhis = date("Y-m-d H:i:s", strtotime($match_info[4]));
			$comb = array();
			$comb['0A']['c'] = '-1:-A';//负其他
			$comb['0A']['s'] = '1';
			$comb['0A']['v'] = $sp_fqt;
			$comb['0A']['d'] = $ymd;
			$comb['0A']['t'] = $his;
			
			$comb['3A']['c'] = '-1:-D';//平其他
			$comb['3A']['s'] = '1';
			$comb['3A']['v'] = $sp_pqt;
			$comb['3A']['d'] = $ymd;
			$comb['3A']['t'] = $his;
                    
			$comb['1A']['c'] = '-1:-H';//胜其他
			$comb['1A']['s'] = '1';
			$comb['1A']['v'] = $sp_sqt;
			$comb['1A']['d'] = $ymd;
			$comb['1A']['t'] = $his;
			
			$comb['00']['c'] = '00:00';
			$comb['00']['s'] = '1';
			$comb['00']['v'] = $sp_00;
			$comb['00']['d'] = $ymd;
			$comb['00']['t'] = $his;
			
			$comb['01']['c'] = '00:01';
			$comb['01']['s'] = '1';
			$comb['01']['v'] = $sp_01;
			$comb['01']['d'] = $ymd;
			$comb['01']['t'] = $his;
			
			$comb['02']['c'] = '00:02';
			$comb['02']['s'] = '1';
			$comb['02']['v'] = $sp_02;
			$comb['02']['d'] = $ymd;
			$comb['02']['t'] = $his;
			
			$comb['03']['c'] = '00:03';
			$comb['03']['s'] = '1';
			$comb['03']['v'] = $sp_03;
			$comb['03']['d'] = $ymd;
			$comb['03']['t'] = $his;
			
			$comb['04']['c'] = '00:04';
			$comb['04']['s'] = '1';
			$comb['04']['v'] = $sp_04;
			$comb['04']['d'] = $ymd;
			$comb['04']['t'] = $his;
			
			$comb['05']['c'] = '00:05';
			$comb['05']['s'] = '1';
			$comb['05']['v'] = $sp_05;
			$comb['05']['d'] = $ymd;
			$comb['05']['t'] = $his;
			
			$comb['10']['c'] = '01:00';
			$comb['10']['s'] = '1';
			$comb['10']['v'] = $sp_10;
			$comb['10']['d'] = $ymd;
			$comb['10']['t'] = $his;
			
			$comb['11']['c'] = '01:01';
			$comb['11']['s'] = '1';
			$comb['11']['v'] = $sp_11;
			$comb['11']['d'] = $ymd;
			$comb['11']['t'] = $his;
			
			$comb['12']['c'] = '01:02';
			$comb['12']['s'] = '1';
			$comb['12']['v'] = $sp_12;
			$comb['12']['d'] = $ymd;
			$comb['12']['t'] = $his;
			
			$comb['13']['c'] = '01:03';
			$comb['13']['s'] = '1';
			$comb['13']['v'] = $sp_13;
			$comb['13']['d'] = $ymd;
			$comb['13']['t'] = $his;
			
			$comb['14']['c'] = '01:04';
			$comb['14']['s'] = '1';
			$comb['14']['v'] = $sp_14;
			$comb['14']['d'] = $ymd;
			$comb['14']['t'] = $his;
			
			$comb['15']['c'] = '01:05';
			$comb['15']['s'] = '1';
			$comb['15']['v'] = $sp_15;
			$comb['15']['d'] = $ymd;
			$comb['15']['t'] = $his;
			
			$comb['20']['c'] = '02:00';
			$comb['20']['s'] = '1';
			$comb['20']['v'] = $sp_20;
			$comb['20']['d'] = $ymd;
			$comb['20']['t'] = $his;
			
			$comb['21']['c'] = '02:01';
			$comb['21']['s'] = '1';
			$comb['21']['v'] = $sp_21;
			$comb['21']['d'] = $ymd;
			$comb['21']['t'] = $his;
			
			$comb['22']['c'] = '02:02';
			$comb['22']['s'] = '1';
			$comb['22']['v'] = $sp_22;
			$comb['22']['d'] = $ymd;
			$comb['22']['t'] = $his;
			
			$comb['23']['c'] = '02:03';
			$comb['23']['s'] = '1';
			$comb['23']['v'] = $sp_23;
			$comb['23']['d'] = $ymd;
			$comb['23']['t'] = $his;
			
			$comb['24']['c'] = '02:04';
			$comb['24']['s'] = '1';
			$comb['24']['v'] = $sp_24;
			$comb['24']['d'] = $ymd;
			$comb['24']['t'] = $his;
			
			$comb['25']['c'] = '02:05';
			$comb['25']['s'] = '1';
			$comb['25']['v'] = $sp_25;
			$comb['25']['d'] = $ymd;
			$comb['25']['t'] = $his;
			
			$comb['30']['c'] = '03:00';
			$comb['30']['s'] = '1';
			$comb['30']['v'] = $sp_30;
			$comb['30']['d'] = $ymd;
			$comb['30']['t'] = $his;
			
			$comb['31']['c'] = '03:01';
			$comb['31']['s'] = '1';
			$comb['31']['v'] = $sp_31;
			$comb['31']['d'] = $ymd;
			$comb['31']['t'] = $his;
			
			$comb['32']['c'] = '03:02';
			$comb['32']['s'] = '1';
			$comb['32']['v'] = $sp_32;
			$comb['32']['d'] = $ymd;
			$comb['32']['t'] = $his;
			
			$comb['33']['c'] = '03:03';
			$comb['33']['s'] = '1';
			$comb['33']['v'] = $sp_33;
			$comb['33']['d'] = $ymd;
			$comb['33']['t'] = $his;
			
			$comb['40']['c'] = '04:00';
			$comb['40']['s'] = '1';
			$comb['40']['v'] = $sp_40;
			$comb['40']['d'] = $ymd;
			$comb['40']['t'] = $his;
			
			$comb['41']['c'] = '04:01';
			$comb['41']['s'] = '1';
			$comb['41']['v'] = $sp_41;
			$comb['41']['d'] = $ymd;
			$comb['41']['t'] = $his;
			
			$comb['42']['c'] = '04:02';
			$comb['42']['s'] = '1';
			$comb['42']['v'] = $sp_42;
			$comb['42']['d'] = $ymd;
			$comb['42']['t'] = $his;
			
			$comb['50']['c'] = '05:00';
			$comb['50']['s'] = '1';
			$comb['50']['v'] = $sp_50;
			$comb['50']['d'] = $ymd;
			$comb['50']['t'] = $his;
			
			$comb['51']['c'] = '05:01';
			$comb['51']['s'] = '1';
			$comb['51']['v'] = $sp_51;
			$comb['51']['d'] = $ymd;
			$comb['51']['t'] = $his;
			
			$comb['52']['c'] = '05:02';
			$comb['52']['s'] = '1';
			$comb['52']['v'] = $sp_52;
			$comb['52']['d'] = $ymd;
			$comb['52']['t'] = $his;
                    
			$comb_j = json_encode($comb);
			$this->sql->query('select id,comb from match_datas where ticket_type="'.self::T_TYPE.'" and play_type="'.$play_type.'" and match_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				if ($match_num > 0) {
					$this->sql->query('insert into match_datas (ticket_type,play_type,match_num,match_id,pool_id,goalline,comb) values (
					"'.self::T_TYPE.'","'.$play_type.'","'.$match_num.'","'.$mid.'","0","'.$goalline.'",\''.$comb_j.'\')');
					echo 'bf:insert:'.$mid.'<br />';
				}
			}
			else {
				//更新赔率
				$id = $this->sql->fetch_array();
				if ($id['comb'] != $comb_j) {
					$this->sql->query('update match_datas set comb=\''.$comb_j.'\' where id="'.$id['id'].'"');
					echo 'bf:update:'.$mid.'<br />';
				}
			}
			/*$this->sql->query('select id from match_details where index_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				$this->sql->query('insert into match_details (index_id,host_name,host_url,guest_name,guest_url,match_info,league,time) values 
				("'.$mid.'","'.$match_info[0].'","'.$match_info[5].'","'.$match_info[1].'","'.$match_info[6].'","'.$match_info[2].'","'.$match_info[3].'","'.$ymdhis.'")');
				echo 'match_detail:insert:'.$mid.'<br />';
			}*/
		}
	}
	
	/**
	 * 总进球数
	 * Enter description here ...
	 */
	function getZJQSMatch() {
		$play_type = 2;
		$match_list = array();
		$c = file_get_contents(self::TTG_URL);
		preg_match_all("/m=(.*)\" style=/", $c, $match_id, PREG_SET_ORDER);
		$match_info_s = $this->getTeamNameByC_jq($c);
		for ($i = 0; $i < count($match_id); $i++) {
			$mid = $match_id[$i][1];
			//if ($mid == 27812) continue;
			//if ($mid == 27813) continue;
			//if ($mid == 27811) continue;
			$no = $i+1;
			if ($no < 10) {
				$no = '00'.$no;
			}
			if ($no >= 10 && $no < 100) {
				$no = '0'.$no;
			}
			$p_s_1 = "/\"select_match\('".$no."001'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."002\"/";
			$p_s_2 = "/\"select_match\('".$no."002'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."003\"/";
			$p_s_3 = "/\"select_match\('".$no."003'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."004\"/";
			$p_s_4 = "/\"select_match\('".$no."004'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."005\"/";
			$p_s_5 = "/\"select_match\('".$no."005'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."006\"/";
			$p_s_6 = "/\"select_match\('".$no."006'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."007\"/";
			$p_s_7 = "/\"select_match\('".$no."007'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."008\"/";
			$p_s_8 = "/\"select_match\('".$no."008'\)\"\/><br \/>(.*)<\/td><\/tr>\r\n		<input type=\"hidden\" id=\"all".$no."\"\/>/";
			
			preg_match_all($p_s_1, $c, $sp1, PREG_SET_ORDER);
			preg_match_all($p_s_2, $c, $sp2, PREG_SET_ORDER);
			preg_match_all($p_s_3, $c, $sp3, PREG_SET_ORDER);
			preg_match_all($p_s_4, $c, $sp4, PREG_SET_ORDER);
			preg_match_all($p_s_5, $c, $sp5, PREG_SET_ORDER);
			preg_match_all($p_s_6, $c, $sp6, PREG_SET_ORDER);
			preg_match_all($p_s_7, $c, $sp7, PREG_SET_ORDER);
			preg_match_all($p_s_8, $c, $sp8, PREG_SET_ORDER);
			
			$sp_0 = $sp1[0][1];
			$sp_1 = $sp2[0][1];
			$sp_2 = $sp3[0][1];
			$sp_3 = $sp4[0][1];
			$sp_4 = $sp5[0][1];
			$sp_5 = $sp6[0][1];
			$sp_6 = $sp7[0][1];
			$sp_7 = $sp8[0][1];
			
			//$match_info = $this->getTeamNameByURL(self::MURL.$mid);
			$match_info = $match_info_s[$mid];
			var_dump($match_info);
			$match_num = $this->week_array[substr($match_info[2], 0, -3)].substr($match_info[2], -3);
			/*preg_match_all("/line\">\r\n		(.*)<strong/", $c, $home, PREG_SET_ORDER);
			preg_match_all("/\((.*)\)/", $home[$i][1], $home_g, PREG_SET_ORDER);
			if (isset($home_g[0][1])) {
				$goalline = $home_g[0][1];
			}
			else {
				$goalline = 0;
			}*/
			$goalline = 0;
			$ymd = date("Y-m-d", strtotime($match_info[4]));
			$his = date("H:i:s", strtotime($match_info[4]));
			$ymdhis = date("Y-m-d H:i:s", strtotime($match_info[4]));
			$comb = array();
			$comb['0']['c'] = '0';
			$comb['0']['s'] = '1';
			$comb['0']['v'] = $sp_0;
			$comb['0']['d'] = $ymd;
			$comb['0']['t'] = $his;
			
			$comb['1']['c'] = '1';
			$comb['1']['s'] = '1';
			$comb['1']['v'] = $sp_1;
			$comb['1']['d'] = $ymd;
			$comb['1']['t'] = $his;
            
			$comb['2']['c'] = '2';
			$comb['2']['s'] = '1';
			$comb['2']['v'] = $sp_2;
			$comb['2']['d'] = $ymd;
			$comb['2']['t'] = $his;  
			
			$comb['3']['c'] = '3';
			$comb['3']['s'] = '1';
			$comb['3']['v'] = $sp_3;
			$comb['3']['d'] = $ymd;
			$comb['3']['t'] = $his;
			
			$comb['4']['c'] = '4';
			$comb['4']['s'] = '1';
			$comb['4']['v'] = $sp_4;
			$comb['4']['d'] = $ymd;
			$comb['4']['t'] = $his;
            
			$comb['5']['c'] = '5';
			$comb['5']['s'] = '1';
			$comb['5']['v'] = $sp_5;
			$comb['5']['d'] = $ymd;
			$comb['5']['t'] = $his;
			
			$comb['6']['c'] = '6';
			$comb['6']['s'] = '1';
			$comb['6']['v'] = $sp_6;
			$comb['6']['d'] = $ymd;
			$comb['6']['t'] = $his;
			
			$comb['7']['c'] = '7';
			$comb['7']['s'] = '1';
			$comb['7']['v'] = $sp_7;
			$comb['7']['d'] = $ymd;
			$comb['7']['t'] = $his;
                    
			$comb_j = json_encode($comb);
			$this->sql->query('select id,comb from match_datas where ticket_type="'.self::T_TYPE.'" and play_type="'.$play_type.'" and match_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				if ($match_num > 0) {
					$this->sql->query('insert into match_datas (ticket_type,play_type,match_num,match_id,pool_id,goalline,comb) values (
					"'.self::T_TYPE.'","'.$play_type.'","'.$match_num.'","'.$mid.'","0","'.$goalline.'",\''.$comb_j.'\')');
					echo 'zjqs:insert:'.$mid.'<br />';
				}
			}
			else {
				//更新赔率
				$id = $this->sql->fetch_array();
				if ($id['comb'] != $comb_j) {
					$this->sql->query('update match_datas set comb=\''.$comb_j.'\' where id="'.$id['id'].'"');
					echo 'zjqs:update:'.$mid.'<br />';
				}
			}
			/*$this->sql->query('select id from match_details where index_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				$this->sql->query('insert into match_details (index_id,host_name,host_url,guest_name,guest_url,match_info,league,time) values 
				("'.$mid.'","'.$match_info[0].'","'.$match_info[5].'","'.$match_info[1].'","'.$match_info[6].'","'.$match_info[2].'","'.$match_info[3].'","'.$ymdhis.'")');
				echo 'match_detail:insert:'.$mid.'<br />';
			}*/
		}
	}
	
	/**
	 * 半全场
	 * Enter description here ...
	 */
	function getBQCMatch() {
		$play_type = 4;
		$match_list = array();
		$c = file_get_contents(self::HAFU_URL);
		preg_match_all("/m=(.*)\" style=/", $c, $match_id, PREG_SET_ORDER);
		$match_info_s = $this->getTeamNameByC_bq($c);
		for ($i = 0; $i < count($match_id); $i++) {
			$mid = $match_id[$i][1];
			//if ($mid == 27812) continue;
			//if ($mid == 27813) continue;
			//if ($mid == 27811) continue;
			$no = $i+1;
			if ($no < 10) {
				$no = '00'.$no;
			}
			if ($no >= 10 && $no < 100) {
				$no = '0'.$no;
			}
			$p_s_1 = "/\"select_match\('".$no."001'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."002\"/";
			$p_s_2 = "/\"select_match\('".$no."002'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."003\"/";
			$p_s_3 = "/\"select_match\('".$no."003'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."004\"/";
			$p_s_4 = "/\"select_match\('".$no."004'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."005\"/";
			$p_s_5 = "/\"select_match\('".$no."005'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."006\"/";
			$p_s_6 = "/\"select_match\('".$no."006'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."007\"/";
			$p_s_7 = "/\"select_match\('".$no."007'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."008\"/";
			$p_s_8 = "/\"select_match\('".$no."008'\)\"\/><br \/>(.*)<\/td><td class=\"tdWL tdWLL\" width=\"35\"><input type=\"checkbox\" id=\"m".$no."009\"/";
			$p_s_9 = "/\"select_match\('".$no."009'\)\"\/><br \/>(.*)<\/td>		<input type=\"hidden\" id=\"all".$no."\"\/>/";
			
			preg_match_all($p_s_1, $c, $sp1, PREG_SET_ORDER);
			preg_match_all($p_s_2, $c, $sp2, PREG_SET_ORDER);
			preg_match_all($p_s_3, $c, $sp3, PREG_SET_ORDER);
			preg_match_all($p_s_4, $c, $sp4, PREG_SET_ORDER);
			preg_match_all($p_s_5, $c, $sp5, PREG_SET_ORDER);
			preg_match_all($p_s_6, $c, $sp6, PREG_SET_ORDER);
			preg_match_all($p_s_7, $c, $sp7, PREG_SET_ORDER);
			preg_match_all($p_s_8, $c, $sp8, PREG_SET_ORDER);
			preg_match_all($p_s_9, $c, $sp9, PREG_SET_ORDER);
			
			$sp_ss = $sp1[0][1];
			$sp_sp = $sp2[0][1];
			$sp_sf = $sp3[0][1];
			$sp_ps = $sp4[0][1];
			$sp_pp = $sp5[0][1];
			$sp_pf = $sp6[0][1];
			$sp_fs = $sp7[0][1];
			$sp_fp = $sp8[0][1];
			$sp_ff = $sp9[0][1];
			
			//$match_info = $this->getTeamNameByURL(self::MURL.$mid);
			$match_info = $match_info_s[$mid];
			//var_dump($match_info);die();
			$match_num = $this->week_array[substr($match_info[2], 0, -3)].substr($match_info[2], -3);
			/*preg_match_all("/line\">\r\n		(.*)<strong/", $c, $home, PREG_SET_ORDER);
			preg_match_all("/\((.*)\)/", $home[$i][1], $home_g, PREG_SET_ORDER);
			if (isset($home_g[0][1])) {
				$goalline = $home_g[0][1];
			}
			else {
				$goalline = 0;
			}*/
			$goalline = 0;
			$ymd = date("Y-m-d", strtotime($match_info[4]));
			$his = date("H:i:s", strtotime($match_info[4]));
			$ymdhis = date("Y-m-d H:i:s", strtotime($match_info[4]));
			$comb = array();
			$comb['cc']['c'] = 'cc';//负负
			$comb['cc']['v'] = $sp_ff;
			$comb['cc']['s'] = '1';
			$comb['cc']['d'] = $ymd;
			$comb['cc']['t'] = $his;
			
			$comb['cb']['c'] = 'cb';//负平
			$comb['cb']['v'] = $sp_fp;
			$comb['cb']['s'] = '1';
			$comb['cb']['d'] = $ymd;
			$comb['cb']['t'] = $his;
                    
			$comb['ca']['c'] = 'ca';//负胜
			$comb['ca']['v'] = $sp_fs;
			$comb['ca']['s'] = '1';
			$comb['ca']['d'] = $ymd;
			$comb['ca']['t'] = $his;  
			
			$comb['bc']['c'] = 'bc';//平负
			$comb['bc']['v'] = $sp_pf;
			$comb['bc']['s'] = '1';
			$comb['bc']['d'] = $ymd;
			$comb['bc']['t'] = $his;
			
			$comb['bb']['c'] = 'bb';//平平
			$comb['bb']['v'] = $sp_pp;
			$comb['bb']['s'] = '1';
			$comb['bb']['d'] = $ymd;
			$comb['bb']['t'] = $his;
                    
			$comb['ba']['c'] = 'ba';//平胜
			$comb['ba']['v'] = $sp_ps;
			$comb['ba']['s'] = '1';
			$comb['ba']['d'] = $ymd;
			$comb['ba']['t'] = $his;
			
			$comb['ac']['c'] = 'ac';//胜负
			$comb['ac']['v'] = $sp_sf;
			$comb['ac']['s'] = '1';
			$comb['ac']['d'] = $ymd;
			$comb['ac']['t'] = $his;
			
			$comb['ab']['c'] = 'ab';//胜平
			$comb['ab']['v'] = $sp_sp;
			$comb['ab']['s'] = '1';
			$comb['ab']['d'] = $ymd;
			$comb['ab']['t'] = $his;
			
			$comb['aa']['c'] = 'aa';//胜胜
			$comb['aa']['v'] = $sp_ss;
			$comb['aa']['s'] = '1';
			$comb['aa']['d'] = $ymd;
			$comb['aa']['t'] = $his;
                    
			$comb_j = json_encode($comb);
			$this->sql->query('select id,comb from match_datas where ticket_type="'.self::T_TYPE.'" and play_type="'.$play_type.'" and match_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				if ($match_num > 0) {
					$this->sql->query('insert into match_datas (ticket_type,play_type,match_num,match_id,pool_id,goalline,comb) values (
					"'.self::T_TYPE.'","'.$play_type.'","'.$match_num.'","'.$mid.'","0","'.$goalline.'",\''.$comb_j.'\')');
					echo 'bqc:insert:'.$mid.'<br />';
				}
			}
			else {
				//更新赔率
				$id = $this->sql->fetch_array();
				if ($id['comb'] != $comb_j) {
					$this->sql->query('update match_datas set comb=\''.$comb_j.'\' where id="'.$id['id'].'"');
					echo 'bqc:update:'.$mid.'<br />';
				}
			}
			/*$this->sql->query('select id from match_details where index_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				$this->sql->query('insert into match_details (index_id,host_name,host_url,guest_name,guest_url,match_info,league,time) values 
				("'.$mid.'","'.$match_info[0].'","'.$match_info[5].'","'.$match_info[1].'","'.$match_info[6].'","'.$match_info[2].'","'.$match_info[3].'","'.$ymdhis.'")');
				echo 'match_detail:insert:'.$mid.'<br />';
			}*/
		}
	}
	
	/**
	 * 把字符串或数组的字符集转换成utf8
	 * Enter description here ...
	 * @param string/array $array
	 * @return 转换后的字符串或数组
	 */
	function encodeUTF8(&$array){
		if(!is_array($array)){
			return iconv('gbk', 'utf-8', $array);
		}
		foreach($array as $key=>$value){
			if(!is_array($value)){
		    	$array[$key]=mb_convert_encoding($value,"UTF-8","GBK"); //由gbk转换到utf8
		    }else{
		        $this->encodeUTF8($array[$key]);
		    }
		}
		return $array;
	}
	
	/**
	 * 根据url获取主队与客队的名称
	 * Enter description here ...
	 * @param string $url
	 * @return 如获取到则返回数组array(0=>主队队名,1=>客队队名,2=>赛事信息,3=>联赛名称,4=>时间,5=>主队url,6=>客队url)，否则返回false
	 */
	public function getTeamNameByURL($url) {
		$name = array();
		$return = array();
		
		$c = file_get_contents($url);
		//$c = iconv('gb2312', 'utf-8', $c);//编码转换
		//var_dump($c);
		//die();
		preg_match_all("/<span class=\"HomeName\">(.*)<\/span>/", $c, $name, PREG_SET_ORDER); //提取名字
		$name = $this->encodeUTF8($name);
		$hostname = $name[0][1];
		$guestname = $name[1][1];
		if ($hostname == '' || $guestname == '') {
			return false;
		}
		$hostname = explode('(', $hostname);
		$guestname = explode('(', $guestname);
		$return[0] = $hostname[0];
		$return[1] = $guestname[0];
		preg_match_all("/<div class=\"CenterTit\">(.*)<br \/>/", $c, $nl, PREG_SET_ORDER); //提取名字
		$nl = $this->encodeUTF8($nl);
		$nl = $nl[0][1];
		$nl = explode(' ', $nl);
		$match_info = $nl[0];
		$league = $nl[1];
		$return[2] = $match_info;
		$return[3] = $league;
		preg_match_all("/<span class=\"Centers\">(.*)<\/span>/", $c, $time, PREG_SET_ORDER); //提取名字
		$time = $this->encodeUTF8($time);
		$time = trim(substr($time[0][1], -16));
		$return[4] = $time;
		$teaminfo_preg = "/<a href=\"(.*)\" target=\"_blank\">/";
		preg_match_all($teaminfo_preg, $c, $teaminfo, PREG_SET_ORDER); //提取名字
		$host_url = $teaminfo[2][1];
		$guest_url = $teaminfo[4][1];
		$return[5] = $host_url;
		$return[6] = $guest_url;
		return $return;
	}
	
	/**
	 * 根据计算器内容获取对阵详细
	 * Enter description here ...
	 * @param string $url
	 * @return 如获取到则返回数组array(0=>主队队名,1=>客队队名,2=>赛事信息,3=>联赛名称,4=>时间,5=>主队url,6=>客队url)，否则返回false
	 */
	public function getTeamNameByC_rq($content) {
		$content = $this->encodeUTF8($content);
		$return = array();
		preg_match_all("/style=\"text-decoration:underline\">
		(.*)<strong>/", $content, $homename, PREG_SET_ORDER); //主队
		for ($i = 0; $i < count($homename); $i++) {
			$hostname = explode('(', $homename[$i][1]);
			$return[$i][0] = $hostname[0];
			$return[$i][5] = 'http://www.sporttery.cn';
		}
		preg_match_all("/<\/strong>(.*)<\/a>/", $content, $awayname, PREG_SET_ORDER); //客队
		for ($i = 0; $i < count($awayname); $i++) {
			$guestname = explode('(', $awayname[$i][1]);
			$return[$i][1] = $guestname[0];
			$return[$i][6] = 'http://www.sporttery.cn';
		}
		preg_match_all("/<td class=\"tdC\" width=\"100\">(.*)<\/td>/", $content, $matchtime, PREG_SET_ORDER); //时间
		for ($i = 0; $i < count($matchtime); $i++) {
			$mdhis = substr($matchtime[$i][1], 3, 12);
			$return[$i][4] = date('Y').'-'.$mdhis;
		}
		preg_match_all("/<td class=\"td1\" width=\"55\"(.*)<\/td>/", $content, $matchinfo, PREG_SET_ORDER); //赛事信息
		for ($i = 0; $i < count($matchinfo); $i++) {
			$t = explode('>', $matchinfo[$i][1]);
			$return[$i][2] = $t[1];
		}
		preg_match_all("/<font color=\"#FFFFFF\">(.*)<\/font>/", $content, $legname, PREG_SET_ORDER); //联赛名称
		for ($i = 0; $i < count($legname); $i++) {
			$return[$i][3] = $legname[$i][1];
		}
		preg_match_all("/m=(.*)\" style=/", $content, $match_id, PREG_SET_ORDER);
		$match_id_count = count($match_id);
		$match_id_array = array();
		$return_n = array();
		for ($i = 0; $i < $match_id_count; $i++) {
			$mid = $match_id[$i][1];
			$return_n[$mid] = $return[$i];
		}
		//var_dump($return_n);
		//die();
		return $return_n;
	}
	
	public function getTeamNameByC_jq($content) {
		$content = $this->encodeUTF8($content);
		$return = array();
		preg_match_all("/style=\"text-decoration:underline\">
				(.*)<br><strong>/", $content, $homename, PREG_SET_ORDER); //主队
		for ($i = 0; $i < count($homename); $i++) {
			$return[$i][0] = $homename[$i][1];
			$return[$i][5] = 'http://www.sporttery.cn';
		}
		preg_match_all("/<\/strong>(.*)<\/a>/", $content, $awayname, PREG_SET_ORDER); //客队
		for ($i = 0; $i < count($awayname); $i++) {
			$return[$i][1] = $awayname[$i][1];
			$return[$i][6] = 'http://www.sporttery.cn';
		}
		preg_match_all("/<td class=\"tdC\" width=\"100\">(.*)<\/td>/", $content, $matchtime, PREG_SET_ORDER); //时间
		for ($i = 0; $i < count($matchtime); $i++) {
			$mdhis = substr($matchtime[$i][1], 3, 12);
			$return[$i][4] = date('Y').'-'.$mdhis;
		}
		preg_match_all("/<td class=\"td1\" width=\"50\"(.*)<\/td>/", $content, $matchinfo, PREG_SET_ORDER); //赛事信息
		for ($i = 0; $i < count($matchinfo); $i++) {
			$t = explode('>', $matchinfo[$i][1]);
			$return[$i][2] = $t[1];
		}
		preg_match_all("/<font color=\"#FFFFFF\">(.*)<\/font>/", $content, $legname, PREG_SET_ORDER); //联赛名称
		for ($i = 0; $i < count($legname); $i++) {
			$return[$i][3] = $legname[$i][1];
		}
		preg_match_all("/m=(.*)\" style=/", $content, $match_id, PREG_SET_ORDER);
		$match_id_count = count($match_id);
		$match_id_array = array();
		$return_n = array();
		for ($i = 0; $i < $match_id_count; $i++) {
			$mid = $match_id[$i][1];
			$return_n[$mid] = $return[$i];
		}
		//var_dump($return_n);
		//die();
		return $return_n;
	}
	
	public function getTeamNameByC_bf($content) {
		$content = $this->encodeUTF8($content);
		$return = array();
		preg_match_all("/style=\"text-decoration:underline\">
		(.*)<strong>/", $content, $homename, PREG_SET_ORDER); //主队
		for ($i = 0; $i < count($homename); $i++) {
			$return[$i][0] = $homename[$i][1];
			$return[$i][5] = 'http://www.sporttery.cn';
		}
		preg_match_all("/<\/strong>(.*)<\/a>/", $content, $awayname, PREG_SET_ORDER); //客队
		for ($i = 0; $i < count($awayname); $i++) {
			$return[$i][1] = $awayname[$i][1];
			$return[$i][6] = 'http://www.sporttery.cn';
		}
		preg_match_all("/停售时间：(.*)<\/h3>/", $content, $matchtime, PREG_SET_ORDER); //时间
		for ($i = 0; $i < count($matchtime); $i++) {
			$mdhis = substr($matchtime[$i][1], 3, 12);
			$return[$i][4] = date('Y').'-'.$mdhis;
		}
		preg_match_all("/alt=\"收起\" \/>
		(.*) <span>/", $content, $matchinfo, PREG_SET_ORDER); //赛事信息
		for ($i = 0; $i < count($matchinfo); $i++) {
			$t = explode('>', $matchinfo[$i][1]);
			$t1 = explode(' ', $t[0]);
			$return[$i][2] = $t1[0];
		}
		preg_match_all("/<\/span> (.*) <span>/", $content, $legname, PREG_SET_ORDER); //联赛名称
		for ($i = 0; $i < count($legname); $i++) {
			$return[$i][3] = $legname[$i][1];
		}
		preg_match_all("/m=(.*)\" style=/", $content, $match_id, PREG_SET_ORDER);
		$match_id_count = count($match_id);
		$match_id_array = array();
		$return_n = array();
		for ($i = 0; $i < $match_id_count; $i++) {
			$mid = $match_id[$i][1];
			$return_n[$mid] = $return[$i];
		}
		//var_dump($return_n);
		//die();
		return $return_n;
	}
	
	public function getTeamNameByC_bq($content) {
		$content = $this->encodeUTF8($content);
		$return = array();
		preg_match_all("/style=\"text-decoration:underline\">
		(.*)<br><strong>/", $content, $homename, PREG_SET_ORDER); //主队
		for ($i = 0; $i < count($homename); $i++) {
			$return[$i][0] = $homename[$i][1];
			$return[$i][5] = 'http://www.sporttery.cn';
		}
		preg_match_all("/<\/strong>(.*)<\/a>/", $content, $awayname, PREG_SET_ORDER); //客队
		for ($i = 0; $i < count($awayname); $i++) {
			$return[$i][1] = $awayname[$i][1];
			$return[$i][6] = 'http://www.sporttery.cn';
		}
		preg_match_all("/<td class=\"tdC\" width=\"100\">(.*)<\/td>/", $content, $matchtime, PREG_SET_ORDER); //时间
		for ($i = 0; $i < count($matchtime); $i++) {
			$mdhis = substr($matchtime[$i][1], 3, 12);
			$return[$i][4] = date('Y').'-'.$mdhis;
		}
		preg_match_all("/<td class=\"td1\" width=\"50\"(.*)<\/td>/", $content, $matchinfo, PREG_SET_ORDER); //赛事信息
		for ($i = 0; $i < count($matchinfo); $i++) {
			$t = explode('>', $matchinfo[$i][1]);
			$return[$i][2] = $t[1];
		}
		preg_match_all("/<font color=\"#FFFFFF\">(.*)<\/font>/", $content, $legname, PREG_SET_ORDER); //联赛名称
		for ($i = 0; $i < count($legname); $i++) {
			$return[$i][3] = $legname[$i][1];
		}
		preg_match_all("/m=(.*)\" style=/", $content, $match_id, PREG_SET_ORDER);
		$match_id_count = count($match_id);
		$match_id_array = array();
		$return_n = array();
		for ($i = 0; $i < $match_id_count; $i++) {
			$mid = $match_id[$i][1];
			$return_n[$mid] = $return[$i];
		}
		//var_dump($return_n);
		//die();
		return $return_n;
	}
	
	/**
	 * 根据赛事id获取赛果
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function getResultById($id) {
		$url = self::RESULTURL.$id;
		
		/* $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:210.22.151.230', 'CLIENT-IP:210.22.151.230'));
		//curl_setopt($ch, CURLOPT_REFERER, " ");
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		var_dump($result);die();
		//echo $url; */
		
		$content = file_get_contents($url);
		//var_dump($content);
		//$content = iconv('gb2312', 'utf-8', $content);//编码转换
		$regex = "/<font color=\"#FF0000\">(.*)<\/font>/";//正则规则
		preg_match_all($regex, $content, $arr);
		$arr = $this->encodeUTF8($arr);
		$re = $arr[1];
		if ($re[0] == '' || $re[1] == '' || $re[2] == '' || $re[3] == '') {
			return false;
		}
		/*if ($re[0] == '' && $re[1] == '' && $re[2] == '' && $re[3] == '') {
			return false;
		}
		$re[0] == '' ? '暂无' : $re[0];
		$re[1] == '' ? '暂无' : $re[1];
		$re[2] == '' ? '暂无' : $re[2];
		$re[3] == '' ? '暂无' : $re[3];*/
		return $re;
	}
	
	/**
	 * 更新赛果
	 * Enter description here ...
	 */
	public function getUnResultMatch() {
		$select_query = 'select id,index_id from match_details where ticket_type=1 and (result = "" or result is null) and time >= "2011-09-01" order by id asc limit 100';
		$this->sql->query($select_query);
		if ($this->sql->num_rows() <= 0) return;
		$re = array();
		while ($a = $this->sql->fetch_array()) {
			$re[$a['id']] = $a['index_id'];
		}
		foreach ($re as $key => $val) {
			$r = $this->getResultById($val);
			if ($r == false) continue;
			if ($r[1] != '胜其他' && $r[1] != '平其他' && $r[1] != '负其他') {
				$score = explode(':', $r[1]);
				if (!isset($score[0]) || intval($score[0]) < 0) continue;
				if (!isset($score[1]) || intval($score[1]) < 0) continue;
				$hs = $score[0];
				$as = $score[1];
				if ($hs == $as) {
					if ($hs > 3 && $as > 3) {
						$r[1] = '平其他';
					}
				}
				else {
					if ($hs > $as && ($hs > 5 || $as > 2)) {
						$r[1] = '胜其他';
					}
					if ($as > $hs && ($as > 5 || $hs > 2)) {
						$r[1] = '负其他';
					}
				}
			}
			
			$r_j = implode('|', $r);
			$update_query = 'update match_details set result=\''.$r_j.'\' where id="'.$key.'"';
			$this->sql->query($update_query);
			if (!$this->sql->error()) echo $key.' result:'.$r_j.' updated<br />';
			else echo $key.' result failed \n';
		}
	}
	
	/**
	 * 更新赛事平均赔率，链接
	 * @var unknown_type
	 */
	const zs_xml_url = 'http://apps.odds.zs310.com/getzcxml.php?lotyid=6';
	function update_jczq_sp() {
		$week_day = array('周日','周一','周二','周三','周四','周五','周六');
		$xml_url = self::zs_xml_url;
		$c = file_get_contents($xml_url);
		$c = str_replace('GB2312', 'gbk', $c);
		$doc = new DOMDocument();
		$r = $doc->loadXML($c);
		if ($r == true) {
			$results = $doc->getElementsByTagName('xml');
			$count = $results->item(0)->getAttribute('count');
			//var_dump($count);
			$data = array();
			foreach ($results as $result) {
				$row = $result->getElementsByTagName('row');
				for ($i = 0; $i < $count; $i++) {
					$data[$i]['oh'] = $row->item($i)->getAttribute('oh');
					$data[$i]['od'] = $row->item($i)->getAttribute('od');
					$data[$i]['oa'] = $row->item($i)->getAttribute('oa');
					$data[$i]['info'] = $row->item($i)->getAttribute('xid');
					$data[$i]['time'] = $row->item($i)->getAttribute('mtime');
					$data[$i]['match_url'] = 'http://info.jingbo365.com/index.php?controller=main&lid='.$row->item($i)->getAttribute('lid').'&sid='.$row->item($i)->getAttribute('sid').'&cid='.$row->item($i)->getAttribute('cid').'&t='.$row->item($i)->getAttribute('t');
					$data[$i]['home_url'] = 'http://info.jingbo365.com/index.php?controller=teaminfo&lid='.$row->item($i)->getAttribute('lid').'&sid='.$row->item($i)->getAttribute('sid').'&tid='.$row->item($i)->getAttribute('htid');
					$data[$i]['away_url'] = 'http://info.jingbo365.com/index.php?controller=teaminfo&lid='.$row->item($i)->getAttribute('lid').'&sid='.$row->item($i)->getAttribute('sid').'&tid='.$row->item($i)->getAttribute('gtid');
					$data[$i]['xi_url'] = 'http://info.jingbo365.com/index.php?controller=analysis&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=4';
					$data[$i]['ya_url'] = 'http://odds.jingbo365.com/index.php?controller=detail&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=2';
					$data[$i]['ou_url'] = 'http://odds.jingbo365.com/index.php?controller=detail&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=1';
					//$data[$i]['hn'] = $row->item($i)->getAttribute('hn');
					//$data[$i]['gn'] = $row->item($i)->getAttribute('gn');
				}
			}
			for ($i = 0; $i < count($data); $i++) {
				$year = substr(date('Y'), 0, 2).substr($data[$i]['info'], 0, 2);
				$month = substr($data[$i]['info'], 2, 2);
				$day = substr($data[$i]['info'], 4, 2);
				$w = date('w', strtotime($year.'-'.$month.'-'.$day));
				$match_info = $week_day[$w].substr($data[$i]['info'], -3);
				$query = 'select id,host_url,guest_url,match_url,avg_sp,xi_url,ya_url,ou_url from match_details where ticket_type=1 and date(`time`)="'.substr($data[$i]['time'], 0, 10).'" and match_info="'.$match_info.'" limit 1';
				//echo $query.'<br />';
				$this->sql->query($query);
				if ($this->sql->num_rows() > 0) {
					$return = $this->sql->fetch_array();
					/* echo $return['host_name'].',';
					echo $return['guest_name'];
					echo '<br />';
					echo $data[$i]['hn'].',';
					echo $data[$i]['gn'];
					echo '<br />'; */
					$sp = array();
					$sp['h'] = $data[$i]['oh'];
					$sp['d'] = $data[$i]['od'];
					$sp['a'] = $data[$i]['oa'];
					$sp = json_encode($sp);
					$update_field = array();
					if ($return['avg_sp'] != $sp) {
						$update_field[] = '`avg_sp`=\''.$sp.'\'';
					}
					if ($return['host_url'] != $data[$i]['home_url']) {
						$update_field[] = 'host_url="'.$data[$i]['home_url'].'"';
					}
					if ($return['guest_url'] != $data[$i]['away_url']) {
						$update_field[] = 'guest_url="'.$data[$i]['away_url'].'"';
					}
					if ($return['match_url'] != $data[$i]['match_url']) {
						$update_field[] = 'match_url="'.$data[$i]['match_url'].'"';
					}
					if ($return['xi_url'] != $data[$i]['xi_url']) {
						$update_field[] = 'xi_url="'.$data[$i]['xi_url'].'"';
					}
					if ($return['ya_url'] != $data[$i]['ya_url']) {
						$update_field[] = 'ya_url="'.$data[$i]['ya_url'].'"';
					}
					if ($return['ou_url'] != $data[$i]['ou_url']) {
						$update_field[] = 'ou_url="'.$data[$i]['ou_url'].'"';
					}
					if (count($update_field) > 0) {
						$update_field_s = implode(',', $update_field);
						$query = 'update match_details set '.$update_field_s.' where id="'.$return['id'].'" ';
						//echo $query.'<br />';
						$this->sql->query($query);
						if (!$this->sql->error()) {
							echo $return['id'].' sp update <br />';
						}
						else {
							return false;
						}
					}
					else {
						echo $return['id'].' sp noupdate <br />';
					}
				}
			}
		}
		else {
			return false;
		}
	}

}
?>