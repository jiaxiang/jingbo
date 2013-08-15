<?php
	class JSBF {
		const JSBF_TABLE_NAME = 'jsbf_datas';
		const TODAY_BF_DATA_JS = 'http://bf.bet007.com/vbsxml/bfdata.js';
		const JS_PATH = '/usr/local/cp/front/media/js/jsbf_data.js';
		//const JS_PATH = 'C:\code\caipiao_code\code\front\media\js\jsbf_data.js';
		const JSBF_EVENT_TABLE_NAME = 'jsbf_event_datas';
		const TODAY_BF_EVENT_DATA_JS = 'http://bf.bet007.com/vbsxml/detail.js';
		const EVENT_JS_PATH = '/usr/local/cp/front/media/js/jsbf_event_data.js';
		//const EVENT_JS_PATH = 'C:\code\caipiao_code\code\front\media\js\jsbf_event_data.js';
		const BF_XML_PATH = 'http://bf.bet007.com/BF_XML.aspx?date=';
		
		private $sql;
		private $bf_xml = array();
		private $cron_log;
		
		function __construct() {
			require_once 'SQL.php';
			$this->sql = new SQL();
			$this->bf_xml = $this->getBfXmldata();
			require_once 'Crontab_Log.php';
			$this->cron_log = new Crontab_Log(false);
		}
		
		protected function encodeUTF8(&$array){
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
		 * 获得比赛事件
		 * Enter description here ...
		 */
		function getTodayEventBf(){
			$c = file_get_contents(self::TODAY_BF_EVENT_DATA_JS);
			if ($c == false) return false;
			file_put_contents(self::EVENT_JS_PATH, $c);
			$c = file_get_contents(self::EVENT_JS_PATH);
			if ($c == false) return false;
			preg_match_all("/rq(.*)=\"(.*)\"/",$c,$match_info,PREG_SET_ORDER);
			$match_info = $this->encodeUTF8($match_info);
			for($i = 0;$i < count($match_info);$i++){
				$t1 = explode('^',$match_info[$i][2]);
				$match_id = $t1[0];//比赛ID
				$home_or_away = $t1[1];//主队还是客队
				$match_event_type = $t1[2];//事件类型  1、入球 2、红牌  3、黄牌   7、点球  8、乌龙  9、两黄变红
				$match_event_time = $t1[3];//事件时间
				$player_name = $t1[4];//球员名字
				if ($player_name == '' || $player_name == NULL) continue;
				$name_id = $t1[5];//球员ID
				$this->sql->query('select id from '.self::JSBF_EVENT_TABLE_NAME.' where match_id="'.$match_id.'" 
				and home_or_away="'.$home_or_away.'" and match_event_type = "'.$match_event_type.'" and
				 match_event_time="'.$match_event_time.'" and player_name="'.$player_name.'"');
				if($this->sql->num_rows() == 0){
					$insert_query = 'INSERT INTO '.self::JSBF_EVENT_TABLE_NAME.' (`match_id`,`home_or_away`,
					`match_event_type`,`match_event_time`,`player_name`,`name_id`) VALUES
					 ("'.$match_id.'","'.$home_or_away.'","'.$match_event_type.'","'.$match_event_time.'","'.$player_name.'","'.$name_id.'");';
					$this->sql->query($insert_query);
					if ($this->sql->error()) {
						$this->cron_log->writeLog('match_id:'.$match_id.' event insert error!'.$insert_query);
						//echo $match_id.$home_or_away.$match_event_type.$match_event_time.$player_name.$name_id.' insert error '.$insert_query.'<br />';						
					}
					else {
						$this->cron_log->writeLog('match_id:'.$match_id.' event insert success!');
						//echo $match_id.$home_or_away.$match_event_type.$match_event_time.$player_name.$name_id.' inserted <br />';	
					}
				}
			}
		}
		
		function getTodayBf() {
			$c = file_get_contents(self::TODAY_BF_DATA_JS);
			if ($c == false) return false;
			file_put_contents(self::JS_PATH, $c);
			$c = file_get_contents(self::JS_PATH);
			if ($c == false) return false;
			preg_match_all("/A(.*)=\"(.*)\"/", $c, $match_info, PREG_SET_ORDER);
			$match_info = $this->encodeUTF8($match_info);
			//var_dump($match_info);die();
			$match_jsyp = $this->get_match_yp();
			for ($i = 0; $i < count($match_info); $i++) {
				//var_dump($i);
				$t1 = explode('^', $match_info[$i][2]);
				/**
				 * array(42) { [0]=> string(6) "602413" [1]=> string(7) "#15DBAE" [2]=> string(8) "大运女足" 
				 * [3]=> string(8) "大運女足" [4]=> string(5) "WWUFT" [5]=> string(45) "韩国大学生女足(中)" 
				 * [6]=> string(45) "南韓大學生女足(中)" [7]=> string(29) "Korea Republic University (w)" 
				 * [8]=> string(16) "俄罗斯大学生女足" [9]=> string(16) "俄羅斯大學生女足" 
				 * [10]=> string(21) "Russia University (w)" [11]=> string(5) "16:30" 
				 * [12]=> string(18) "2011,7,15,16,31,17" [13]=> string(1) "1" [14]=> string(1) "0" 
				 * [15]=> string(1) "0" [16]=> string(0) "" [17]=> string(0) "" [18]=> string(1) "0" 
				 * [19]=> string(1) "0" [20]=> string(1) "0" [21]=> string(1) "0" [22]=> string(0) "" 
				 * [23]=> string(0) "" [24]=> string(1) "1" [25]=> string(1) "0" [26]=> string(0) "" 
				 * [27]=> string(0) "" [28]=> string(4) "True" [29]=> string(4) "0.25" [30]=> string(0) "" 
				 * [31]=> string(50) "/cup_match/2011-2012/cupmatch_vs/cupmatch_1180.htm" [32]=> string(0) "" 
				 * [33]=> string(0) "" [34]=> string(0) "" [35]=> string(0) "" [36]=> string(4) "8-15" 
				 * [37]=> string(5) "17719" [38]=> string(5) "17721" [39]=> string(0) "" [40]=> string(2) "52" 
				 * [41]=> string(1) "0" }
				 */
				//var_dump($t1);die();
				$match_id = $t1[0];//比赛ID
				$color = $t1[1];//颜色值
				$match_name_chs = $t1[2];//赛事类型 简体名
				$match_name_chf = $t1[3];//赛事类型 繁体名
				$match_name_eng = $t1[4];//赛事类型 英文名
				$home_name_chs = strip_tags($t1[5]);//主队 简体名
				$home_name_chf = $t1[6];//主队 繁体名
				$home_name_eng = $t1[7];//主队 英文名
				$away_name_chs = strip_tags($t1[8]);//客队 简体名
				$away_name_chf = $t1[9];//客队 繁体名
				$away_name_eng = $t1[10];//客队 英文名
				$match_time = $t1[11];//只有小时和分数 20:30 格式
				$match_open_time = $t1[12];//开场时间 (上半场时为开上半场的时间,下半场时为开下半场的时间）js日期时间格式
				$match_status = $t1[13];//比赛状态 0:未开,1:上半场,2:中场,3:下半场,-11:待定,-12:腰斩,-13:中断,-14:推迟,-1:完场
				$home_score = $t1[14];//主队比分
				$away_score = $t1[15];//客队比分
				$t1[16] = $t1[16] == '' ? 0 : $t1[16];
				$home_first_half_score = $t1[16];//主队上半场比分
				$t1[17] = $t1[17] == '' ? 0 : $t1[17];
				$away_first_half_score = $t1[17];//客队上半场比分
				$home_red_card = $t1[18];//主队红牌
				$away_red_card = $t1[19];//客队红牌
				$home_yellow_card = $t1[20];//主队黄牌
				$away_yellow_card = $t1[21];//客队黄牌
				$t1[22] = $t1[22] == '' ? 0 : $t1[22];
				$home_rank = $t1[22];//主队排名
				$t1[23] = $t1[23] == '' ? 0 : $t1[23];
				$away_rank = $t1[23];//客队排名
				$is_sample_score = $t1[24];//是否是精简版比分 0 /1表示，1表示精简版（即重要赛事）
				$is_zc_score = $t1[25];//是否是足彩比分 0：非足彩，1:胜负彩，2：北京单场，3：胜负彩+北京单场
				$tv_live_channel = $t1[26];//电视直播频道: CCTV5 广东体育
				$t1[27] = $t1[27] == '' ? 0 : $t1[27];
				$is_formation = $t1[27];//是否有阵容: 1为有
				$t1[28] = $t1[28] == 'True' ? 1 : 0;
				$is_groud = $t1[28];//是否是走地比赛 True or False
				$t1[29] = $t1[29] == '' ? 0 : $t1[29];
				$crown_sp = $t1[29];//皇冠初盘
				$match_intro = $t1[30];//比赛说明
				$match_url = $t1[31];//联赛资料库超链接 (可不理会)
				$var32 = $t1[32];$var33 = $t1[33];$var34 = $t1[34];$var35 = $t1[35];//空(有变动)
				$match_date = $t1[36];//比赛日期  m-d， 月-日
				$home_id = $t1[37];//主队ID
				$away_id = $t1[38];//客队ID
				$var39 = $t1[39];//空(有变动)
				$country_id = $t1[40];//国家ID (有变动)
				
				if (array_key_exists($match_id, $this->bf_xml)) {
				//if(@is_array($this->bf_xml[$match_id])){
					$rs=$this->bf_xml[$match_id];
					$match_round = $rs[0];
					$match_site = $rs[1];
					$match_weather_icon = $rs[2];
					$match_weather = $rs[3];
					$match_temperature = $rs[4];
					$match_season = $rs[5];
				}
				else{
					$match_round =null;
					$match_site = null;
					$match_weather_icon = null;
					$match_weather = null;
					$match_temperature = null;
					$match_season = null;	
				}
				
				$match_date_t = explode('-', $match_date);
				
				$match_date_t_d = date("Y-m-d", mktime(0, 0, 0, $match_date_t[0], $match_date_t[1], date('Y')));
				//var_dump($match_date_t_d);
				$js_datetime_array = explode(',', $match_open_time);
				$match_date_js = $js_datetime_array[0].'-'.($js_datetime_array[1]+1).'-'.$js_datetime_array[2];
				$match_time_js = $js_datetime_array[3].':'.$js_datetime_array[4].':'.$js_datetime_array[5];
				$match_open_time = $match_date_js.' '.$match_time_js;
				$match_open_time = date("Y-m-d H:i:s", strtotime($match_open_time));
				
				$str_matchtime = strtotime($match_date_t_d.' '.$match_time);
				$match_time = date("Y-m-d H:i:s", $str_matchtime);
				$match_time_1 = date('Y-m-d H:i:s', mktime(date("H", $str_matchtime)-4,date("i", $str_matchtime),date("s", $str_matchtime),date("m", $str_matchtime),date("d", $str_matchtime),date("Y", $str_matchtime)));
				$match_time_2 = date('Y-m-d H:i:s', mktime(date("H", $str_matchtime)+4,date("i", $str_matchtime),date("s", $str_matchtime),date("m", $str_matchtime),date("d", $str_matchtime),date("Y", $str_matchtime)));
				
				$match_date = date("Y-m-d", strtotime($match_date_js));
				$this->sql->query('select id, `match_time`,`match_open_time`, `match_status`, `home_score`, 
				`away_score`, `home_first_half_score`, `away_first_half_score`, `home_red_card`, 
				`away_red_card`, `home_yellow_card`, `away_yellow_card`, `match_date`, `yp_data` from '.self::JSBF_TABLE_NAME.' where match_id="'.$match_id.'"');
				if ($this->sql->num_rows() > 0) {
					//update
					$result = $this->sql->fetch_array();
					$update_field = array();
					if ($match_time != $result['match_time']) {
						$update_field[] = ' `match_time`="'.$match_time.'"';
					}
					if ($match_open_time != $result['match_open_time']) {
						$update_field[] = ' `match_open_time`="'.$match_open_time.'"';
					}
					if ($match_status != $result['match_status']) {
						$update_field[] = ' `match_status`="'.$match_status.'"';
					}
					if ($home_score != $result['home_score']) {
						$update_field[] = ' `home_score`="'.$home_score.'"';
					}
					if ($away_score != $result['away_score']) {
						$update_field[] = ' `away_score`="'.$away_score.'"';
					}
					if ($home_first_half_score != $result['home_first_half_score']) {
						$update_field[] = ' `home_first_half_score`="'.$home_first_half_score.'"';
					}
					if ($away_first_half_score != $result['away_first_half_score']) {
						$update_field[] = ' `away_first_half_score`="'.$away_first_half_score.'"';
					}
					if ($home_red_card != $result['home_red_card']) {
						$update_field[] = ' `home_red_card`="'.$home_red_card.'"';
					}
					if ($away_red_card != $result['away_red_card']) {
						$update_field[] = ' `away_red_card`="'.$away_red_card.'"';
					}
					if ($home_yellow_card != $result['home_yellow_card']) {
						$update_field[] = ' `home_yellow_card`="'.$home_yellow_card.'"';
					}
					if ($away_yellow_card != $result['away_yellow_card']) {
						$update_field[] = ' `away_yellow_card`="'.$away_yellow_card.'"';
					}
					if ($match_date != $result['match_date']) {
						$update_field[] = ' `match_date`="'.$match_date.'"';
					}
					if ($match_jsyp[$match_id] != $result['yp_data']) {
						$update_field[] = ' `yp_data`="'.$match_jsyp[$match_id].'"';
					}
					if (count($update_field) > 0) {
						$update_field_str = implode(',', $update_field);
						$update_query = 'update '.self::JSBF_TABLE_NAME.' set '.$update_field_str.'  where id="'.$result['id'].'"';
						$this->sql->query($update_query);
						if ($this->sql->error()) {
							$this->cron_log->writeLog('match_id:'.$result['id'].' data update error!'.$update_query);
							//echo $update_field_str.' update error <br />';
						}
						else {
							$this->cron_log->writeLog('match_id:'.$result['id'].' data updats success!');
							//echo $update_field_str.' updated <br />';
						}
					}
				}
				else {
					
					$home_name_arr = $this->team_name($home_name_chs);//开始查询主队别名球队
					$away_name_arr = $this->team_name($away_name_chs);//开始查询客队别名球队
					//足彩赛事匹配
					$is_zc = 0;
					$zf_query = 'select id,vs1,vs2 from zcsf_expects where 
					(vs1 = "'.$home_name_arr[0].'" or vs2 = "'.$away_name_arr[0].'") and 
					(date(game_time)="'.substr($match_time, 0, 10).'" or 
					date(game_time)="'.substr($match_time_1, 0, 10).'" or
					date(game_time)="'.substr($match_time_2, 0, 10).'") limit 1';
					$this->sql->query($zf_query);
					if ($this->sql->num_rows() > 0) {
						$is_zc = 1;
						$result = $this->sql->fetch_array();
						$this->add_name($result,"1",$home_name_chs,$away_name_chs);//添加别名
						$this->cron_log->writeLog('match_id:'.$match_id.' '.$home_name_arr[0].' vs '.$away_name_arr[0].' is zcsf !');
						//echo 'zc come<br />';
					}
					else {
						//$this->cron_log->writeLog('match_id:'.$match_id.' '.$home_name_arr[0].' vs '.$away_name_arr[0].' not match zcsf !');
						//echo $zf_query;
					}
					//竞彩赛事匹配
					$is_jc = 0;
					$jc_id = 0;
					$goalline = 0;
					$match_info_jczq = null;
					$jc_query = 'select match_info,index_id,match_details.host_name as vs1,match_details.guest_name as vs2, goalline
					 from match_details  LEFT JOIN match_datas ON match_details.index_id=match_datas.match_id where match_details.ticket_type=1 and 
					(match_details.host_name = "'.$home_name_arr[1].'" or match_details.guest_name = "'.$away_name_arr[1].'") and 
					(date(match_details.time)="'.substr($match_time, 0, 10).'" or 
					date(match_details.time)="'.substr($match_time_1, 0, 10).'" or 
					date(match_details.time)="'.substr($match_time_2, 0, 10).'") order by match_details.id desc limit 1';
					echo $jc_query;
					$this->sql->query($jc_query);
					if ($this->sql->num_rows() > 0) {
						$is_jc = 1;
						$jc_r = $this->sql->fetch_array();
						$jc_id = $jc_r['index_id'];
						$match_info_jczq = $jc_r['match_info'];
						$goalline = $jc_r['goalline'];
						$this->add_name($jc_r,"2",$home_name_chs,$away_name_chs);//添加别名
						$this->cron_log->writeLog('match_id:'.$match_id.' '.$home_name_arr[1].' vs '.$away_name_arr[1].' is jczq !');
						//echo 'jc come<br />';
					}
					else {
						//$this->cron_log->writeLog('match_id:'.$match_id.' '.$home_name_arr[1].' vs '.$away_name_arr[1].' not match jczq !');
						//echo $jc_query;
					}
					//北单赛事匹配
					$is_bd = 0;
					$goalline_bd = 0;
					$bd_query = 'select id,home as vs1,away as vs2,goalline from match_bjdc_datas where 
					(home = "'.$home_name_arr[2].'" or away = "'.$away_name_arr[2].'") and 
					(date(playtime)="'.substr($match_time, 0, 10).'" or 
					date(playtime)="'.substr($match_time_1, 0, 10).'" or 
					date(playtime)="'.substr($match_time_2, 0, 10).'") limit 1';
					$this->sql->query($bd_query);
					if ($this->sql->num_rows() > 0) {
						$is_bd = 1;
						$result=$this->sql->fetch_array();
						$goalline_bd = $result['goalline'];
						$this->add_name($result,"3",$home_name_chs,$away_name_chs);//添加别名
						$this->cron_log->writeLog('match_id:'.$match_id.' '.$home_name_arr[2].' vs '.$away_name_arr[2].' is bjdc !');
						//echo 'bd come<br />';
					}
					else {
						//echo $bd_query;
						//$this->cron_log->writeLog('match_id:'.$match_id.' '.$home_name_arr[2].' vs '.$away_name_arr[2].' not match bjdc !');
					}
					$sp = '';
					if ($is_jc == 1) {
						$sp = $this->get_sp($match_id);
						if ($sp == false) $sp = '';
					}
					if (!isset($jc_id)) $jc_id = 0;
					$insert_query = 'INSERT INTO '.self::JSBF_TABLE_NAME.' ( `match_id`, `color`, 
					`match_name_chs`, `match_name_chf`, `match_name_eng`, `home_name_chs`, `home_name_chf`, 
					`home_name_eng`, `away_name_chs`, `away_name_chf`, `away_name_eng`, `match_time`, 
					`match_open_time`, `match_status`, `home_score`, `away_score`, `home_first_half_score`, 
					`away_first_half_score`, `home_red_card`, `away_red_card`, `home_yellow_card`, 
					`away_yellow_card`, `home_rank`, `away_rank`, `is_sample_score`, `is_zc_score`, 
					`tv_live_channel`, `is_formation`, `is_groud`, `crown_sp`, `match_info`, `match_url`, 
					`var32`, `var33`, `var34`, `var35`, `match_date`, `home_id`, `away_id`, `var39`, 
					`country_id`, `is_zc`,`is_jc`,`is_bd`, `sp`, `jc_id`,`match_round`,`match_site`,
					`match_weather_icon`,`match_weather`,`match_temperature`,`match_season`,`match_info_jczq`,
					`goalline`,`goalline_bd`,`yp_data`) VALUES ( "'.$match_id.'", "'.$color.'", "'.$match_name_chs.'", 
					"'.$match_name_chf.'", "'.$match_name_eng.'", "'.$home_name_chs.'", "'.$home_name_chf.'", 
					"'.$home_name_eng.'", "'.$away_name_chs.'", "'.$away_name_chf.'", "'.$away_name_eng.'", 
					"'.$match_time.'", "'.$match_open_time.'", "'.$match_status.'", "'.$home_score.'", 
					"'.$away_score.'", "'.$home_first_half_score.'", "'.$away_first_half_score.'", "'.$home_red_card.'", 
					"'.$away_red_card.'", "'.$home_yellow_card.'", "'.$away_yellow_card.'", "'.$home_rank.'", "'.$away_rank.'", 
					"'.$is_sample_score.'", "'.$is_zc_score.'", "'.$tv_live_channel.'", "'.$is_formation.'", 
					"'.$is_groud.'", "'.$crown_sp.'", "'.$match_intro.'", "'.$match_url.'", NULL, NULL, NULL, NULL, 
					"'.$match_date.'", "'.$home_id.'", "'.$away_id.'", NULL, "'.$country_id.'", 
					"'.$is_zc.'", "'.$is_jc.'", "'.$is_bd.'", "'.$sp.'", "'.$jc_id.'","'.$match_round.'","'.$match_site.'","'
					.$match_weather_icon.'","'.$match_weather.'","'.$match_temperature.'","'.$match_season.'",
					"'.$match_info_jczq.'","'.$goalline.'","'.$goalline_bd.'","'.$match_jsyp[$match_id].'");';
					$this->sql->query($insert_query);
					if ($this->sql->error()) {
						//echo $match_id.' insert error '.$insert_query.'<br />';
						$this->cron_log->writeLog('match_id:'.$match_id.' insert error!'.$insert_query);
						die();
					}
					else {
						$this->cron_log->writeLog('match_id:'.$match_id.' insert success!');
						//echo $match_id.' inserted <br />';
					}
				}
			}
		}
	
		
		/**
		 * 获取别名
		 * Enter description here ...
		 * @param unknown_type $name
		 */
		function team_name($name) {
			$type=array($name,$name,$name);
			$this->sql->query('select type,team from `jsbf_teamname_maps` where team_alias="'.$name.'"');//搜索球队
			if ($this->sql->num_rows() > 0) {
				$result = $this->sql->fetch_all();
				for($i=0;$i<count($result);$i++){
					switch($result[$i]['type']){
						case 1 :$type[0]=$result[$i]['team'];
						break;
						case 2 :$type[1]=$result[$i]['team'];
						break;
						case 3 :$type[2]=$result[$i]['team'];
						break;
					}
				}
			}
			return $type;
		}
		
		/**
		 * 别名添加方法
		 * Enter description here ...
		 * @param unknown_type $result
		 * @param unknown_type $type
		 * @param unknown_type $home_name_chs
		 * @param unknown_type $away_name_chs
		 */
		function add_name($result,$type,$home_name_chs,$away_name_chs) {
			if($result['vs1']!=$home_name_chs){
				$team=$result['vs1'];
				$this->sql->query('select team from `jsbf_teamname_maps` where type='.$type.' and team_alias="'.$home_name_chs.'"');
				if ($this->sql->num_rows() == 0) {
					$insert_query ='INSERT INTO `jsbf_teamname_maps` (`type`,`team`,`team_alias`) VALUES ("'.$type.'","'.$team.'","'.$home_name_chs.'")';
					$this->sql->query($insert_query);	
				}
			}
		    //客队别名添加
			if($result['vs2']!=$away_name_chs){
				$team=$result['vs2'];
				$this->sql->query('select team from `jsbf_teamname_maps` where type='.$type.' and team_alias="'.$away_name_chs.'"');
					if ($this->sql->num_rows() == 0) {
						$insert_query ='INSERT INTO `jsbf_teamname_maps` (`type`,`team`,`team_alias`) VALUES ("'.$type.'","'.$team.'","'.$away_name_chs.'")';
						$this->sql->query($insert_query);
					}
			}
		}
		
		/**
		 * 获取比赛数据
		 * Enter description here ...
		 * @return multitype:unknown
		 */
	    function getBfXmldata(){
			//date_default_timezone_set('Asia/Chongqing');
			$url=self::BF_XML_PATH.date("Y-m-d");
			$xml=file_get_contents($url);
			if ($xml == false) return false;
			$doc = new DOMDocument();
			$doc->loadXML($xml);
			$rs = $doc->getElementsByTagName('match');
			foreach( $rs as $match ){
				$match_id = $match->getElementsByTagName( "a" );
				$match_id = $match_id->item(0)->nodeValue;	
				$match_round = $match->getElementsByTagName( "s" );
				$match_round = $match_round->item(0)->nodeValue;
				$match_site = $match->getElementsByTagName( "t" );
				$match_site = $match_site->item(0)->nodeValue;
				$match_weather_icon = $match->getElementsByTagName( "u" );
				$match_weather_icon = $match_weather_icon ->item(0)->nodeValue;
				$match_weather = $match->getElementsByTagName( "v" );
				$match_weather = $match_weather->item(0)->nodeValue;
				$match_temperature = $match->getElementsByTagName( "w" );
				$match_temperature = $match_temperature->item(0)->nodeValue;
				$match_season = $match->getElementsByTagName( "x" );
				$match_season = $match_season->item(0)->nodeValue;
				$bf_xml[$match_id]=array($match_round,$match_site,$match_weather_icon,$match_weather,$match_temperature,$match_season); 
			}
			return  $bf_xml;		
         }
         
		/**
		 * 获得比赛赔率
		 * @author wunan
		 * @param $match_id 比赛id 
		 * @param $ticket_type 彩种id
		 * @param $ticket_type  赛事玩法id
		 * @return $sp：单场胜平负赔率
		 * 
		 */
		function get_sp($match_id,$ticket_type=1,$play_type=1){
			$this->sql->query('select `comb` from `match_datas` where ticket_type="'.$ticket_type.'" and play_type="'.$play_type.'" and match_id="'.$match_id.'" limit 1');
			if ($this->sql->num_rows() > 0){
				$result = $this->sql->fetch_array();
				$result=json_decode($result['comb']);
				$sp = array();
				$sp['h']['c'] = $result->h->c;
				$sp['h']['v'] = $result->h->v;
				$sp['d']['c'] = $result->d->c;
				$sp['d']['v'] = $result->d->v;
				$sp['a']['c'] = $result->a->c;
				$sp['a']['v'] = $result->a->v;
				$sp=json_encode($sp);
				return $sp;
			}
			else {
				return false;
			}
		}
		
		/**
		 * 更新竞彩胜平负赔率
		 * @author wunan
		 * 
		 */
		function refresh_sp(){
			$mklasttime = mktime(date("H")-3, date("i"), date("s"), date("m"), date("d"), date("Y"));
	        $lasttime = date('Y-m-d H:i:s', $mklasttime);
			$this->sql->query('SELECT `id`,`jc_id`,`sp` FROM `jsbf_datas` WHERE `match_time`>"'.$lasttime.'" and is_jc=1');
			if ($this->sql->num_rows() > 0){
				$result = $this->sql->fetch_all();
				foreach($result as $rs){
					$get_sp= $this->get_sp($rs['jc_id']);
					if($get_sp != false && $rs['sp'] != $get_sp){
						$this->sql->query('update '.self::JSBF_TABLE_NAME.' set `sp`=\''.$get_sp.'\'  where id="'.$rs['id'].'"');
						if (!$this->sql->error()) {
							echo $rs['id'].' sp update<br />';
						}
					}
				}	
			}	
		}
		
		function get_match_yp() {
			$odd_txt = 'http://vip.bet007.com/xmlvbs/odds.txt';
			$content = file_get_contents($odd_txt);
			$return = array();
			if ($content != false) {
				$content_arr = explode('$', $content);
				$yp_content = $content_arr[2];
				$yp_content_arr = explode(';', $yp_content);
				$replace_query_arr = array();
				for ($i = 0; $i < count($yp_content_arr); $i++) {
					$t = explode(',', $yp_content_arr[$i]);
					if ($t[8] == 'True') $t[8] = 1;
					else $t[8] = 0;
					if ($t[9] == 'True') $t[9] = 1;
					else $t[9] = 0;
					$return[$t[0]] = $t[5].','.$t[6].','.$t[7];
				}
				return $return;
			}
		}
         
	}
?>