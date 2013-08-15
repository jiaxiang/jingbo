<?php
	class ZCSF {

		private $sql;

		function __construct() {
			require_once 'SQL.php';
			$this->sql = new SQL();
		}


		//采集期次数据入库
		public function add_update_expect_data($play_method="1",$expect=""){
			$new_expect_data=$this->new_expect_data($play_method,$expect);
			//print_r($new_expect_data);
			foreach($new_expect_data['expects'] as $key=>$value){
				$caiji_data = $this->caiji_data($new_expect_data['lotid_key'],$value);
				/* var_dump($caiji_data);
				if (!$caiji_data){
					return false;
				} */
				//print_r($caiji_data);die;
				if ($caiji_data != false && count($caiji_data) > 0) {
					foreach($caiji_data as $k=>$val){
						$expect_data="";
						$expect_data['changci']=$val['changci'];
						$expect_data['vs1']=$val['vs1'];
						$expect_data['vs2']=$val['vs2'];
						$expect_data['game_time']=$val['game_time'];
						$expect_data['game_event']=$val['game_event'];
						$expect_data['expect_num']=$value;
						$expect_data['start_time']=$val['start_time'];
						$expect_data['end_time']=$val['end_time'];
						$expect_data['open_time']=$val['open_time'];
						$expect_data['expect_type']=$new_expect_data['lotid_key'];
						$expect_data['index_id']=$val['index_id'];
						$expect_data['game_result']=$val['game_result'];
						$expect_data['cai_result']=str_replace("<br />",",",$val['cai_result']);
						if($value == $new_expect_data['new_expect']){
							$expect_data['status']=1;
						}
						else{
							$expect_data['status']=0;
						}
						if ($expect_data['expect_num'] > 0 && $expect_data['changci'] > 0) {
							$this->add_update($expect_data);
						}
						//var_dump($expect_data);
						//echo "采集完成 第".$value."期 第".($k+1)."场 <br>";
					}
				}
			}
		}

 		/*
		 * 数据库增加与更新
		 */
		public function add_update($expect_data){
			$this->sql->query('select id,cai_result from zcsf_expects where changci="'.$expect_data['changci'].'" and expect_num="'.$expect_data['expect_num'].'" and expect_type="'.$expect_data['expect_type'].'"');
			if ($this->sql->num_rows() > 0) {
				$re = $this->sql->fetch_array();
				$cai_result = '';
				if ($re['cai_result'] == '' && $expect_data['cai_result'] != '') {
					$cai_result=',`cai_result`="'.$expect_data['cai_result'].'"';
				}
				/*if($expect_data['cai_result']===""){
					$cai_result="";
				}else{
					$cai_result=',`cai_result`="'.$expect_data['cai_result'].'"';
				}*/
				$sql='update zcsf_expects set
									`vs1`="'.$expect_data['vs1'].'",
									`vs2`="'.$expect_data['vs2'].'",
									`game_time`="'.$expect_data['game_time'].'",
									`game_event`="'.$expect_data['game_event'].'",
									`start_time`="'.$expect_data['start_time'].'",
									`end_time`="'.$expect_data['end_time'].'",
									`open_time`="'.$expect_data['open_time'].'",
									`index_id`="'.$expect_data['index_id'].'",
									`status`="'.$expect_data['status'].'"'.$cai_result.' where id="'.$re['id'].'"';
				$this->sql->query($sql);
				//echo $sql.'<br />';
			}else{
				$insertkeysql = $insertvaluesql = $comma = "";
				foreach ($expect_data as $insert_key => $insert_value) {
					$insertkeysql .= $comma.'`'.$insert_key.'`';
					$insertvaluesql .= $comma."'".$insert_value."'";
					$comma = ', ';
				}
				$this->sql->query('insert into zcsf_expects ('.$insertkeysql.') values ('.$insertvaluesql.')');
			}
		}


		/*
		 * 获取最新的期次列表
		 */
		public function new_expect_data($play_method,$expect){
			switch($play_method) {
			case 1:  //14场胜负彩
				$expect_type=14;
				$lotid_key = "wilo";
				break;
			case 2:	//9场任选
				$expect_type=9;
				$lotid_key = "wilo";
				break;
			case 3://6场半
				$expect_type=6;
				$lotid_key = "hafu";
				break;
			case 4://4场半
				$expect_type=4;
				$lotid_key = "goal";
				break;
			default:
				$expect_type=14;
				$lotid_key = "wilo";
				break;
			}
			if ($expect){
				//var_dump($expect);
				$data['new_expect']=$expect;//最新一期
				$data['expects']=array($expect-2,$expect-1,$expect,$expect+1,$expect+2);//三个期列表
			}else{
				//到竞彩网采集最新一期赛事信息
				$url = "http://info.sporttery.cn/iframe/lottery_iframe_2011.php?key=".$lotid_key;
				//var_dump($url);
				$head=@get_headers($url);
				if($head[0]<>"HTTP/1.1 404 Object Not Found") {
					$datas = iconv("GBK", "UTF-8",file_get_contents($url));
					//var_dump($datas);
					$new_expect=$this->getst("a> 第", '</strong>期</span>', $datas);
					$end_time=$this->getst("停售:", '</td>', $datas);
					preg_match_all("/&num=(.*)\" target=\"_self\">下期/", $datas, $n, PREG_SET_ORDER);
					//$n = $this->getst("&num=", '" target="_self">下期', $datas);
					//var_dump($n);
					preg_match_all("/num=(.*)/", $n[0][1], $n1, PREG_SET_ORDER);
					//var_dump($n1);
					$next_expert = $n1[0][1];
					
					preg_match_all("/&num=(.*)\" target=\"_self\">上期/", $datas, $p, PREG_SET_ORDER);
					//$n = $this->getst("&num=", '" target="_self">下期', $datas);
					//var_dump($p);
					$per_expext = $p[0][1];
					//var_dump($per_expext);
					//preg_match_all("/num=(.*)/", $n[0][1], $n1, PREG_SET_ORDER);
				}
				//var_dump($end_time);
				if(time() > strtotime($end_time)){
					$per_expext = $new_expect;
					$cur_expect = $next_expert;
					$url_n = "http://info.sporttery.cn/iframe/lottery_iframe_2011.php?key=".$lotid_key."&num=".$cur_expect;
					$head=@get_headers($url_n);
					if($head[0]<>"HTTP/1.1 404 Object Not Found") {
						$datas = iconv("GBK", "UTF-8",file_get_contents($url_n));
						//var_dump($datas);
						//$cur_expect=$this->getst("a> 第", '</strong>期</span>', $datas);
						//$end_time=$this->getst("停售:", '</td>', $datas);
							
						preg_match_all("/&num=(.*)\" target=\"_self\">下期/", $datas, $n, PREG_SET_ORDER);
						//$n = $this->getst("&num=", '" target="_self">下期', $datas);
						//var_dump($n);
						preg_match_all("/num=(.*)/", $n[0][1], $n1, PREG_SET_ORDER);
						//var_dump($n1);
						$next_expert = $n1[0][1];
					}
					//$data['new_expect'] = $next_expert;//最新一期
				}
				else {
					$cur_expect = $new_expect;
					//$data['new_expect'] = $new_expect;//最新一期
				}
				$data['new_expect'] = $cur_expect;
				$data['expects']=array($per_expext-1, $per_expext, $cur_expect, $next_expert, $next_expert+1);//三个期列表
				//$data['expects']=array($per_expext, $cur_expect, $next_expert);//三个期列表
				//var_dump($data['expects']);
			}
			$data['expect_type']=$expect_type;//玩法
			$data['lotid_key']=$lotid_key;//玩法
			$data['play_method']=$play_method;//玩法
			//var_dump($data);
			return $data;
		}


		/*
		 * 采集赛事数据
		 */
		public function caiji_data($lotid_key,$expect)
		{
			//到竞彩网采集每期赛事信息
			$url = "http://info.sporttery.cn/iframe/lottery_iframe.php?key=".$lotid_key."&num=".$expect;
			//print_r($url);
			$head=@get_headers($url);
			if($head[0]<>"HTTP/1.1 404 Object Not Found") {
				$datas = iconv("GBK", "UTF-8",file_get_contents($url));
				$preg1="/<td class=\"tdWL tdno\"><span class=\"num-box\">(.*)<\/span><\/td>
	<td class=\"tdWL tdWLL tdno\">(.*)VS(.*)<\/td>
	<td class=\"tdC\">(.*)<\/td>
    <td class=\"tdC\">(.*)<\/td>
    <td class=\"tdC\">(.*)<\/td>/";
				preg_match_all($preg1, $datas, $data_arr1);
				//d($data_arr1);
				$preg2="/<td width=\"80\" rowspan=\"(.+?)\" class=\"tdC\" id=\"t001\">(.*)<\/td>/";
				preg_match_all($preg2, $datas, $data_arr2);

				$data_arr3=$this->getst("开售", '停售', $datas);
				$data_arr4=$this->getst("停售", '</td>', $datas);
				$data_arr5=explode(";计奖时间:", $data_arr4);

				$time_arr[]=$data_arr5[1];//开奖时间
				$time_arr[]=str_replace(array("时间:",";"),"",$data_arr3);//开售时间
				$time_arr[]=str_replace("时间:","",$data_arr5[0]);//停售时间

				$time_over=explode(".",((strtotime($time_arr[2])-time())/(24*3600)));
				$time_arr[]=$time_over[0];//剩余天数
				$time_arr[]=intval((".".$time_over[1])*24);//乘余小时
				$data_arr=array();
				foreach($data_arr1[1] as $key=>$value ){
					if(strlen($data_arr1[2][$key])>50){
						$index_id=$this->getst("fb_match_info.php?m=", '"', $data_arr1[2][$key]);
					}else{
						$index_id=0;
					}
					if ($data_arr1['6'][$key] == '*') $data_arr1['6'][$key] = '310';
					$data_arr[]=array(
					'changci'=>$data_arr1[1][$key],//场次
					'vs1'=>str_replace(" ","",strip_tags($data_arr1[2][$key])),//主队
					'vs2'=>str_replace(" ","",strip_tags($data_arr1[3][$key])),//客队
					'index_id'=>$index_id,//竟彩网的赛事信息ID
					'start_time'=>$time_arr[1],//开售时间
					'end_time'=>$time_arr[2],//停销时间
					'open_time'=>$time_arr['0'],//开奖时间
					'game_time'=>$data_arr1[4][$key],//比赛时间
					'game_result'=>$data_arr1['5'][$key],//赛果
					'cai_result'=>$data_arr1['6'][$key]);//彩果
				}
				print_r($data_arr);
				$data_list=$this->arrayMerge($data_arr,$data_arr2);//当前期次赛事列表
				return $data_list;
			}
			//print_r($data_list);
			//return $data_list;
			return false;
		}

		public function arrayMerge($lang,$short){
			$result_arr=array();
			foreach($short[1] as $key => $value){
			   for($i=0;$i<$value;$i++){
					$bmp_arr=array_shift($lang);
					$bmp_arr['game_event']=$short[2][$key];
					$result_arr[] = $bmp_arr;
			   }
			}
			return $result_arr;
		}
		
		public function getst($begin, $end, $str){
			$e = explode($begin, $str);
			$e = explode($end, $e[1]);
			return $e[0];
		}
		
		/**
		 * 更新比赛赔率
		 * @author wunan
		 * @param $ticket_type 彩种id 
		 * @param $play_type 赛事玩法id
		 */
		function updata_sp($ticket_type=1,$play_type=1){
			/*$this->sql->query('select `index_id`,`sp` from zcsf_expects where `status`=1 and `index_id`>0');
			if ($this->sql->num_rows() > 0) {
				$rs=$this->sql->fetch_all();
				foreach($rs as $val){
					$this->sql->query('select `comb` from `match_datas` where ticket_type="'.$ticket_type.'" and play_type="'.$play_type.'" and match_id="'.$val['index_id'].'" limit 1');
					if ($this->sql->num_rows() > 0){
						$result = $this->sql->fetch_array();
						if(!empty($result['comb'])){
							$result=json_decode($result['comb']);
							$sp = array();
							$sp['h']['c'] = $result->h->c;
							$sp['h']['v'] = $result->h->v;
							$sp['d']['c'] = $result->d->c;
							$sp['d']['v'] = $result->d->v;
							$sp['a']['c'] = $result->a->c;
							$sp['a']['v'] = $result->a->v;
							$sp=json_encode($sp);
							if ($sp != $val['sp']) {
								$this->sql->query('update zcsf_expects set `sp`=\''.$sp.'\' where `index_id` = "'.$val['index_id'].'"');
								if (!$this->sql->error()) echo $val['index_id'].' sp '.$sp.' update <br />';
							}
						}
					}
				}
			}*/
		}
		
		const r9_xml = 'http://apps.odds.zs310.com/getzcxml.php?lotyid=1&qh=';
		const j4_xml = 'http://apps.odds.zs310.com/getzcxml.php?lotyid=3&qh=';
		const b6_xml = 'http://apps.odds.zs310.com/getzcxml.php?lotyid=4&qh=';
		
		/**
		 * 更新赔率
		 * Enter description here ...
		 */
		function update_zc_sp($type) {
			switch ($type) {
				case 14: $expert_type = 'wilo';$xml = self::r9_xml; $vs_num = 14;break;
				case 4: $expert_type = 'goal';$xml = self::j4_xml; $vs_num = 4;break;
				case 6: $expert_type = 'hafu';$xml = self::b6_xml; $vs_num = 12;break;
				default: $expert_type = 'wilo';$xml = self::r9_xml; $vs_num = 14;break;
			}
			//$expert_type = 'wilo';
			$query = 'select distinct(expect_num) from zcsf_expects where expect_type="'.$expert_type.'" order by expect_num desc limit 3';
			$this->sql->query($query);
			//echo $query;
			$expert_num = array();
			while($a = $this->sql->fetch_array()) {
				$expert_num[] = $a['expect_num'];
			}
			//var_dump($expert_num);
			//$r = $this->sql->fetch_array();
			//$expert_num = $r['expect_num'];
			foreach ($expert_num as $k => $v) {
				$expert_num = $v;
				$xml_url = $xml.substr(date('Y'), 0, 2).$expert_num;
				//echo $xml_url.'<br />';
				//$doc = new DOMDocument();
				//$r = $doc->load($xml_url);
				$c = file_get_contents($xml_url);
				$c = str_replace('GB2312', 'gbk', $c);
				$doc = new DOMDocument();
				$r = $doc->loadXML($c);
				
				if ($r == true) {
					$results = $doc->getElementsByTagName('xml');
					$data = array();
					foreach ($results as $result) {
						$row = $result->getElementsByTagName('row');
						for ($i = 0; $i < $vs_num; $i++) {
							$data[$i]['oh'] = $row->item($i)->getAttribute('oh');
							$data[$i]['od'] = $row->item($i)->getAttribute('od');
							$data[$i]['oa'] = $row->item($i)->getAttribute('oa');
							$data[$i]['home_url'] = 'http://info.jingbo365.com/index.php?controller=teaminfo&lid='.$row->item($i)->getAttribute('lid').'&sid='.$row->item($i)->getAttribute('sid').'&tid='.$row->item($i)->getAttribute('htid');
							$data[$i]['away_url'] = 'http://info.jingbo365.com/index.php?controller=teaminfo&lid='.$row->item($i)->getAttribute('lid').'&sid='.$row->item($i)->getAttribute('sid').'&tid='.$row->item($i)->getAttribute('gtid');
							$data[$i]['xi_url'] = 'http://info.jingbo365.com/index.php?controller=analysis&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=4';
							$data[$i]['ya_url'] = 'http://odds.jingbo365.com/index.php?controller=detail&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=2';
							$data[$i]['ou_url'] = 'http://odds.jingbo365.com/index.php?controller=detail&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=1';
						}
					}
					//var_dump($data);
					for ($i = 0; $i < count($data); $i++) {
						$changci = $i + 1;
						$sp = array();
						$sp['h']['c'] = 'H';
						$sp['h']['v'] = $data[$i]['oh'];
						$sp['d']['c'] = 'D';
						$sp['d']['v'] = $data[$i]['od'];
						$sp['a']['c'] = 'A';
						$sp['a']['v'] = $data[$i]['oa'];
						$sp = json_encode($sp);
						$query = 'select id,sp,home_url,away_url,xi_url,ya_url,ou_url from zcsf_expects where changci="'.$changci.'" and expect_num="'.$expert_num.'" and expect_type="'.$expert_type.'" limit 1';
						//echo $query;
						$this->sql->query($query);
						$return = $this->sql->fetch_array();
						$update_field = array();
						if ($return['sp'] != $sp) {
							$update_field[] = '`sp`=\''.$sp.'\'';
						}
						if ($return['home_url'] != $data[$i]['home_url']) {
							$update_field[] = 'home_url="'.$data[$i]['home_url'].'"';
						}
						if ($return['away_url'] != $data[$i]['away_url']) {
							$update_field[] = 'away_url="'.$data[$i]['away_url'].'"';
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
							$query = 'update zcsf_expects set '.$update_field_s.' where id="'.$return['id'].'"';
							//echo $query.'<br />';
							$this->sql->query($query);
							if (!$this->sql->error()) {
								echo $expert_num.' '.$expert_type.' '.$changci.' sp update <br />';
							}
							else {
								return false;
							}
						}
						else {
							echo $expert_num.' '.$expert_type.' '.$changci.' sp noupdate <br />';
						}
						//die();
					}
				}
				else {
					return false;
				}
			}
		}
		
		/**
		 * 获得当前期期号
		 */
		function get_current_expect_num() {
			$query = 'SELECT distinct(expect_type),expect_num FROM `zcsf_expects` WHERE status=1';
			$this->sql->query($query);
			$re = array();
			while ($a = $this->sql->fetch_array()) {
				$expect_type = $a['expect_type'];
				$expect_num = $a['expect_num'];
				switch($expect_type) {
					case 'wilo'://14场9场胜负彩
						$re[1] = $expect_num;
						$re[2] = $expect_num;
						break;
					case 'hafu'://6场半
						$re[3] = $expect_num;
						break;
					case 'goal'://4场半
						$re[4] = $expect_num;
						break;
					default:
						$re[1] = $expect_num;
						$re[2] = $expect_num;
						break;
				}
			}
			return $re;
		}
		
	}

?>