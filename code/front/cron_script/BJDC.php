<?php
class BJDC {
	
	/*const USER_NO = '00000003';
	const USER_PWD = '123456';
	const POST_URL = 'http://114.242.136.172/happypoolonline/out/outrequest.jsp';*/
	
	const USER_NO = '05022165';
	const USER_PWD = 'jingbo365';
	const POST_URL = 'http://www.happypool.net/happypoolonline/out/outrequest.jsp';
	
	const SP_URL = 'http://www.happypool.net/spxml/a';
	const LOG_TABLE = 'ticket_bjdc_logs';
	const TICKET_TABLE = 'ticket_nums';
	
	/**
	 * 接口说明：0作废1处理中2-已出票3-中奖4未中奖
	 * 
	 * 状态(0,未出票,1已出票,2已兑奖,-1作废,-2确认作废,-3处理中（北单用）
	 * Enter description here ...
	 * @var unknown_type
	 */
	public $tz_res_code = array(
		0 => -2,
		1 => 0,
		2 => 1,
		3 => 2,
		4 => 2
	);
	
	private $sql;
	private $cron_log;
	
	function __construct() {
		require_once 'SQL.php';
		$this->sql = new SQL();
		require_once 'Crontab_Log.php';
		$this->cron_log = new Crontab_Log();
	}
	
	/**
	 * 获取期号数据和赛程，根据期号获取赛程
	 * Enter description here ...
	 * @param unknown_type $betid 彩种编号
	 */
	public function getIssueByBetid($betid) {
		$type_id = 3;
		$post_body = '<betid>'.$betid.'</betid>';
		$message = $this->getPostString($type_id, $post_body);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::POST_URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'message='.$message);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		if ($result == false) return false;
		curl_close($ch);
		$doc = new DOMDocument();
		//var_dump($result);die();
		$doc->loadXML($result);
		$response = $doc->getElementsByTagName('response');
		$status = $response->item(0)->getAttribute('status');
		if ($status == '000') {
			$lists = $doc->getElementsByTagName('list');
			$list_num = $lists->item(0)->getAttribute('number');
			$issues = $doc->getElementsByTagName('issue');
			foreach ($issues as $issue) {
				$issue_id = intval($issue->getAttribute('number'));
				$start_time = $issue->getAttribute('start').':00';
				$stop_time = $issue->getAttribute('stop').':00';
				$this->sql->query('select id from match_bjdc_issues where betid="'.$betid.'" and number="'.$issue_id.'"');
				if ($this->sql->num_rows() <= 0) {
					$this->sql->query('insert into match_bjdc_issues (betid,number,start,stop) values ("'.$betid.'","'.$issue_id.'","'.$start_time.'","'.$stop_time.'")');
					//echo 'betid: '.$betid.', number: '.$issue_id.' inserted!<br />';
					//$this->cron_log->writeLog('betid: '.$betid.', number: '.$issue_id.' inserted!');
					//$this->getMatchs($betid, $issue_id);
				}
				$this->getMatchs($betid, $issue_id);
			}
		}
		else {
			//echo 'type: '.$type_id.' is error!error code: '.$status.'<br />';
			$this->cron_log->writeLog('type: '.$type_id.' is error!error code: '.$status);
			return;
			//echo $message;
		}
	}
	
	/**
	 * 根据彩种编号和期号获取赛程
	 * Enter description here ...
	 * @param unknown_type $betid 彩种编号
	 * @param unknown_type $issue 期号
	 */
	public function getMatchs($betid, $issue) {
		$type_id = 4;
		$post_body = '<betid>'.$betid.'</betid><issue>'.$issue.'</issue>';
		$message = $this->getPostString($type_id, $post_body);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::POST_URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'message='.$message);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		if ($result == false) return false;
		curl_close($ch);
		$doc = new DOMDocument();
		$doc->loadXML($result);
		$response = $doc->getElementsByTagName('response');
		$status = $response->item(0)->getAttribute('status');
		if ($status == '000') {
			$lists = $doc->getElementsByTagName('list');
			$list_num = $lists->item(0)->getAttribute('number');
			$races = $doc->getElementsByTagName('race');
			$sp_data = $this->getSP($betid, $issue);
			foreach ($races as $race) {
				$goalline = 0;
				$race_no = intval($race->getAttribute('no'));
				$league = $race->getAttribute('league');
				$home = $race->getAttribute('home');
				$away = $race->getAttribute('away');
				$playtime = $race->getAttribute('playtime').':00';
				$stoptime = $race->getAttribute('stoptime').':00';
				$str_stoptime = strtotime($stoptime);
				$stoptime = date('Y-m-d H:i:s', mktime(date("H", $str_stoptime),date("i", $str_stoptime)-10,date("s", $str_stoptime),date("m", $str_stoptime),date("d", $str_stoptime),date("Y", $str_stoptime)));
				//echo $race_no.'<br />';
				//echo $stoptime1.'<br />';
				preg_match_all("/\((.*)\)/", $home, $home_g, PREG_SET_ORDER); //提取名字
				if (isset($home_g[0][1])) {
					$goalline = $home_g[0][1];
					if ($goalline > 0) {
						$home = substr($home, 0, -3);
					}
					else {
						$home = substr($home, 0, -4);
					}
				}
				if (!isset($sp_data[$race_no])) {
					$sp = array();
					switch ($betid) {
						case '501': 
							for ($i = 1; $i < 4; $i++) $sp[$i] = '--';
							break;
						case '502':
							for ($i = 1; $i < 5; $i++) $sp[$i] = '--';
							break;
						case '503':
							for ($i = 1; $i < 9; $i++) $sp[$i] = '--';
							break;
						case '504':
							for ($i = 1; $i < 26; $i++) $sp[$i] = '--';
							break;
						case '505':
							for ($i = 1; $i < 10; $i++) $sp[$i] = '--';
							break;
						default:break;
					}
					$sp = json_encode($sp);
				}
				else {
					$sp = $sp_data[$race_no];
				}
				$this->sql->query('select id,sp from match_bjdc_datas where betid="'.$betid.'" and issue="'.$issue.'" and match_no="'.$race_no.'"');
				if ($this->sql->num_rows() <= 0) {
					$insert_query = 'insert into match_bjdc_datas (betid,issue,match_no,league,goalline,home,away,playtime,stoptime,sp) values 
					("'.$betid.'","'.$issue.'","'.$race_no.'","'.$league.'","'.$goalline.'","'.$home.'","'.$away.'","'.$playtime.'","'.$stoptime.'",\''.$sp.'\')';
					$this->sql->query($insert_query);
					if (!$this->sql->error()) {
						//$this->cron_log->writeLog('betid: '.$betid.', number: '.$issue.', match_no: '.$race_no.' inserted!');
						//echo 'betid: '.$betid.', number: '.$issue.', match_no: '.$race_no.' inserted!<br />';
					}
					else {
						$this->cron_log->writeLog($insert_query.' error!');
						//echo $insert_query.' error';
					}
				}
				else {
					$match_info = $this->sql->fetch_array();				
					//update
					if ($match_info['sp'] != $sp) {
						$this->sql->query('update match_bjdc_datas set sp=\''.$sp.'\' where id="'.$match_info['id'].'"');
						//$this->cron_log->writeLog('id: '.$match_info['id'].' sp updated!');
						//echo 'id: '.$match_info['id'].' sp updated!<br />';
					}
					if ($match_info['stoptime'] != $stoptime) {
						$this->sql->query('update match_bjdc_datas set stoptime="'.$stoptime.'" where id="'.$match_info['id'].'"');
						//$this->cron_log->writeLog('id: '.$match_info['id'].' stoptime updated!');
						//echo 'id: '.$match_info['id'].' stoptime updated!<br />';
					}
				}
			}
		}
	}
	
	/**
	 * 根据彩种编号和期号获取赔率
	 * Enter description here ...
	 * @param unknown_type $betid
	 * @param unknown_type $issue
	 */
	public function getSP($betid, $issue) {
		$xml_url = self::getSPXMLURL($betid, $issue);
		$doc = new DOMDocument();
		$res_loadxml = $doc->load($xml_url);
		if ($res_loadxml == false) {
			echo $xml_url.' load error!';
			return false;
		}
		$sp = array();
		$ws = $doc->getElementsByTagName('w');
		$data = array();
		foreach ($ws as $w) {
			$n = intval($w->getAttribute('n'));
			switch ($betid) {
				case '501': 
					$sp[1] = $w->getAttribute('c1');
					$sp[2] = $w->getAttribute('c3');
					$sp[3] = $w->getAttribute('c5');
					break;
				case '502':
					$sp[1] = $w->getAttribute('c1');
					$sp[2] = $w->getAttribute('c3');
					$sp[3] = $w->getAttribute('c5');
					$sp[4] = $w->getAttribute('c7');
					break;
				case '503':
					$sp[1] = $w->getAttribute('c1');
					$sp[2] = $w->getAttribute('c3');
					$sp[3] = $w->getAttribute('c5');
					$sp[4] = $w->getAttribute('c7');
					$sp[5] = $w->getAttribute('c9');
					$sp[6] = $w->getAttribute('c11');
					$sp[7] = $w->getAttribute('c13');
					$sp[8] = $w->getAttribute('c15');
					break;
				case '504':
					for ($i = 1; $i < 26; $i++) {
						$sp[$i] = $w->getAttribute('c'.$i);
					}
					break;
				case '505':
					$sp[1] = $w->getAttribute('c1');
					$sp[2] = $w->getAttribute('c3');
					$sp[3] = $w->getAttribute('c5');
					$sp[4] = $w->getAttribute('c7');
					$sp[5] = $w->getAttribute('c9');
					$sp[6] = $w->getAttribute('c11');
					$sp[7] = $w->getAttribute('c13');
					$sp[8] = $w->getAttribute('c15');
					$sp[9] = $w->getAttribute('c17');
					break;
				default:break;
			}
			$sp1 = array();
			foreach ($sp as $k => $v) {
				$v = round($v, 2);
				if ($v < 0) {
					$v *= -1;
				}
				$sp1[$k] = $v;
			}
			$sp_en = json_encode($sp1);
			$data[$n] = $sp_en;
		}
		return $data;
	}
	
	public function updateMatchSP() {
		
	}
	
	/**
	 * 根据彩种编号和期号获取开奖结果
	 * Enter description here ...
	 * @param unknown_type $betid
	 * @param unknown_type $issue
	 */
	public function getMatchResult($betid, $issue) {
		$type_id = 6;
		$post_body = '<betid>'.$betid.'</betid><issue>'.$issue.'</issue>';
		$message = $this->getPostString($type_id, $post_body);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::POST_URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'message='.$message);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		if ($result == false) return false;
		curl_close($ch);
		$doc = new DOMDocument();
		$doc->loadXML($result);
		$response = $doc->getElementsByTagName('response');
		$status = $response->item(0)->getAttribute('status');
		if ($status == '000') {
			$lists = $doc->getElementsByTagName('list');
			$list_num = $lists->item(0)->getAttribute('number');
			$races = $doc->getElementsByTagName('race');
			foreach ($races as $race) {
				$race_no = intval($race->getAttribute('no'));
				$code = intval($race->getAttribute('code'));
				$sp = $race->getAttribute('sp');
				$bf = $race->getAttribute('bf');
				$this->sql->query('select id from match_bjdc_datas where betid="'.$betid.'" and issue="'.$issue.'" and match_no="'.$race_no.'"');
				if ($this->sql->num_rows() > 0) {
					$re = $this->sql->fetch_array();
					$this->sql->query('update match_bjdc_datas set code="'.$code.'",sp_r="'.$sp.'",bf="'.$bf.'" where id="'.$re['id'].'"');
					//echo 'betid: '.$betid.', number: '.$issue.', match_no: '.$race_no.' updated!<br />';
					//$this->cron_log->writeLog('betid: '.$betid.', number: '.$issue.', match_no: '.$race_no.' updated!');
				}
			}
		}
	}
	
	/**
	 * 获取当前未更新赛果的赛事信息
	 * Enter description here ...
	 */
	public function getUndoMatch() {
		$this->sql->query('select distinct betid,issue from match_bjdc_datas where code is null');
		$re = array();
		while ($a = $this->sql->fetch_array()) {
			$re[] = $a;
		}
		for ($i = 0; $i < count($re); $i++) {
			$this->getMatchResult($re[$i]['betid'], $re[$i]['issue']);
		}
	}
	
	/**
	 * 提交投注信息
	 * Enter description here ...
	 * <ticketlist>
		<ticket id="彩票唯一标示" betid="彩种编号" issue="期号" playtype="玩法编号" money="单张彩票金额" amount="倍数" code="投注内容" />
			…..可以多张
		</ticketlist>
	 */
	public function postAction_new($ticket_id, $betid, $issue, $playtype, $money, $amount, $code) {
		$type_id = 9;
		$post_body = '<ticketlist><ticket id="'.$ticket_id.'" betid="'.$betid.'" issue="'.$issue.'" playtype="'.$playtype.'" money="'.$money.'" amount="'.$amount.'" code="'.$code.'" /></ticketlist>';
		$message = $this->getPostString($type_id, $post_body);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::POST_URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'message='.$message);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		if ($result == false) return false;
		curl_close($ch);
		$doc = new DOMDocument();
		$doc->loadXML($result);
		$response = $doc->getElementsByTagName('response');
		$status = $response->item(0)->getAttribute('status');
		$return = '';
		if ($status == '000') {
			$tickets = $doc->getElementsByTagName('ticket');
			foreach ($tickets as $ticket) {
				$ticket_id = $ticket->getAttribute('id');
				//$result = self::showResultCode($ticket->getAttribute('status'));
				$result = $ticket->getAttribute('status');
				$return = $result;
			}
		}
		else {
			//$result = self::showResultCode($status);
			$return = $status;
		}
		$this->cron_log->writeLog('ticket_id: '.$ticket_id.', status: '.$return.' !');
		return $return;
	}
	
	/**
	 * 批量彩票查询
	 * Enter description here ...
	 */
	public function getResultByTicketId() {
		$this->sql->query('select id,status from ticket_nums where ticket_type=7 and (status=0 or status=1) order by id');
		$re = array();
		$ticket_id = '';
		while ($a = $this->sql->fetch_array()) {
			$re[$a['id']] = $a;
			$ticket_id .= '<ticket id="'.$a['id'].'" />';
		}
		var_dump($ticket_id);
		if ($ticket_id != '') {
			$type_id = 10;
			$post_body = '<ticketlist>'.$ticket_id.'</ticketlist>';
			$message = $this->getPostString($type_id, $post_body);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, self::POST_URL);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'message='.$message);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result = curl_exec($ch);
			var_dump($result);
			if ($result == false) return false;
			curl_close($ch);
			$doc = new DOMDocument();
			$doc->loadXML($result);
			$response = $doc->getElementsByTagName('response');
			$status = $response->item(0)->getAttribute('status');
			$return = array();
			if ($status == '000') {
				$tickets = $doc->getElementsByTagName('ticket');
				foreach ($tickets as $ticket) {
					$err = $ticket->getAttribute('err');
					if ($err == '000') {
						$ticket_id = $ticket->getAttribute('id');
						$status = $ticket->getAttribute('status');
						$prize = $ticket->getAttribute('prize');
						if (isset($re[$ticket_id]['status']) && ($this->tz_res_code[$status] != $re[$ticket_id]['status'])) {
							$update_field = 'status="'.$this->tz_res_code[$status].'",bonus='.$prize;
							switch ($status) {
								//已出票
								case 2: $update_field .= ',time_print=now()';break;
								//中奖
								case 3: $update_field .= ',time_duijiang=now()';break;
								//未中奖
								case 4: $update_field .= ',time_duijiang=now()';break;
								default: break;
							}
							$update_query = 'update ticket_nums set '.$update_field.' where id="'.$ticket_id.'"';
							//$this->sql->query('update ticket_nums set status="'.$this->tz_res_code[$status].'",bonus='.$prize.' where id="'.$ticket_id.'"');
							$this->sql->query($update_query);
							///echo $update_query;
							echo 'ticket:'.$ticket_id.' status updated<br />';
							//$this->cron_log->writeLog('get_result_ticket_id:'.$ticket_id.' status updated!');
						}
						else {
							echo $ticket_id.' '.$status.'<br />';
						}
					}
					else {
						echo $ticket->getAttribute('id').' '.$err.'t<br />';
					}
				}
			}
			else {
				echo $status.'<br />';
			}
		}
	}
	
	/**
	 * 重新投注
	 * Enter description here ...
	 */
	public function getLosePostTickets() {
		$this->sql->query('select * from '.self::LOG_TABLE.' where result="999" order by id ASC limit 100');
		$return = array();
		while ($a = $this->sql->fetch_array()) {
			$r = $this->postAction_new($a['ticket_id'], $a['betid'], $a['issue'], $a['playtype'], $a['money'], $a['amount'], $a['code']);
			if ($r == '000') {
				$return[$a['ticket_id']] = $a['id'];
			}
		}
		foreach ($return as $k => $v) {
			$this->sql->query('update '.self::TICKET_TABLE.' set status=0 where id="'.$k.'"');
			$this->sql->query('delete from '.self::LOG_TABLE.' where id="'.$v.'"');
			//echo 'ticket:'.$k.' status updated<br />';
			//$this->cron_log->writeLog('lost_ticket_id:'.$ticket_id.' status updated!');
		}
	}
	
	/**
	 * 更新北单平均赔率，链接
	 * @var unknown_type
	 */
	const zs_xml_url = 'http://apps.odds.zs310.com/getzcxml.php?lotyid=5&qh=';
	public function update_bjdc_sp() {
		$query = 'select number from match_bjdc_issues order by id desc limit 1';
		$this->sql->query($query);
		$r = $this->sql->fetch_array();
		$qh = $r['number'];
		$xml_url = self::zs_xml_url.$qh;
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
					$data[$i]['match_no'] = $row->item($i)->getAttribute('xid');
					$data[$i]['match_color'] = $row->item($i)->getAttribute('cl');
					$data[$i]['match_url'] = 'http://info.jingbo365.com/index.php?controller=main&lid='.$row->item($i)->getAttribute('lid').'&sid='.$row->item($i)->getAttribute('sid').'&cid='.$row->item($i)->getAttribute('cid').'&t='.$row->item($i)->getAttribute('t');
					$data[$i]['home_url'] = 'http://info.jingbo365.com/index.php?controller=teaminfo&lid='.$row->item($i)->getAttribute('lid').'&sid='.$row->item($i)->getAttribute('sid').'&tid='.$row->item($i)->getAttribute('htid');
					$data[$i]['away_url'] = 'http://info.jingbo365.com/index.php?controller=teaminfo&lid='.$row->item($i)->getAttribute('lid').'&sid='.$row->item($i)->getAttribute('sid').'&tid='.$row->item($i)->getAttribute('gtid');
					$data[$i]['xi_url'] = 'http://info.jingbo365.com/index.php?controller=analysis&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=4';
					$data[$i]['ya_url'] = 'http://odds.jingbo365.com/index.php?controller=detail&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=2';
					$data[$i]['ou_url'] = 'http://odds.jingbo365.com/index.php?controller=detail&action=index&mid='.$row->item($i)->getAttribute('oddsmid').'&sit=1';
				}
			}
			//var_dump($data);
			for ($i = 0; $i < count($data); $i++) {
				$query = 'select id,home_url,away_url,match_url,avg_sp,xi_url,ya_url,ou_url from match_bjdc_datas where betid=501 and issue="'.$qh.'" and match_no="'.$data[$i]['match_no'].'" limit 1';
				//echo $query.'<br />';
				$this->sql->query($query);
				if ($this->sql->num_rows() > 0) {
					$return = $this->sql->fetch_array();
					$sp = array();
					$sp['h'] = $data[$i]['oh'];
					$sp['d'] = $data[$i]['od'];
					$sp['a'] = $data[$i]['oa'];
					$sp = json_encode($sp);
					$update_field = array();
					if ($return['avg_sp'] != $sp) {
						$update_field[] = '`avg_sp`=\''.$sp.'\'';
					}
					if ($return['home_url'] != $data[$i]['home_url']) {
						$update_field[] = 'home_url="'.$data[$i]['home_url'].'"';
					}
					if ($return['away_url'] != $data[$i]['away_url']) {
						$update_field[] = 'away_url="'.$data[$i]['away_url'].'"';
					}
					if ($return['match_url'] != $data[$i]['match_url']) {
						$update_field[] = 'match_url="'.$data[$i]['match_url'].'"';
					}
					if ($return['match_color'] != $data[$i]['match_color']) {
						$update_field[] = 'match_color="'.$data[$i]['match_color'].'"';
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
						$query = 'update match_bjdc_datas set '.$update_field_s.' where issue="'.$qh.'" and match_no="'.$data[$i]['match_no'].'" ';
						//echo $query.'<br />';
						$this->sql->query($query);
						if (!$this->sql->error()) {
							echo $qh.' '.$data[$i]['match_no'].' sp update <br />';
						}
						else {
							return false;
						}
					}
					else {
						echo $qh.' '.$data[$i]['match_no'].' sp noupdate <br />';
					}
				}
			}
		}
		else {
			return false;
		}
	}
	
	/**
	 * 
	 * 获得sp值的xml文件的url
	 * @param unknown_type $betid 彩种id
	 * @param unknown_type $issue 期号
	 */
	static public function getSPXMLURL($betid, $issue) {
		return self::SP_URL.$betid.'_'.$issue.'.xml';
	}
	
	/**
	 * <?xml version="1.0" encoding="GBK"?><request><head><id>00000003</id><type>3</type><digest>6888be4f926298c4db5309266b4ff58d</digest></head><body><betid>501</betid></body></request>
	 * Enter description here ...
	 * @param unknown_type $type_id 请求类型
	 */
	static public function getPostString($type_id, $body) {
		$digest = md5(self::USER_NO.self::USER_PWD.'<body>'.$body.'</body>');
		$return = '<?xml version="1.0" encoding="GBK"?><request><head><id>'.self::USER_NO.'</id><type>'.$type_id.'</type><digest>'.$digest.'</digest></head><body>'.$body.'</body></request>';
		return $return;
	}
	
	/**
	 * 返回应答码
	 * Enter description here ...
	 * @param unknown_type $code
	 */
	static public function showResultCode($code) {
		$return = '';
		//$code = intval($code);
		if ($code >= 900) {
			$return = '服务器发生异常';
		}
		else {
			switch ($code) {
				case '000': $return = '成功';break;
				case '001': $return = '从请求中无法获得消息体';break;
				case '002': $return = '请求信息不完整';break;
				case '003': $return = '商户id不存在';break;
				case '004': $return = '摘要不匹配';break;
				case '005': $return = '无效的请求类型';break;
				case '006': $return = '无效的请求参数';break;
				case '007': $return = '无效的期号';break;
				case '008': $return = '交易号不存在';break;
				case '009': $return = '查询的彩票不存在';break;
				case '201': $return = '商户号余额不足';break;
				case '202': $return = '投注内容无效';break;
				case '203': $return = '奖期未开始';break;
				case '204': $return = '投注奖期或投注场次已过期';break;
				case '205': $return = '单场投注选择了无效场次';break;
				case '206': $return = '存在重复投注的彩票';break;
				case '207': $return = '单张票金额超过上限';break;
				default: $return = '投注中的其他异常';break;
			}
		}
		return $return;
	}
	
	/**
	 * 获取北单胜平负大赢家接口
	 * @return boolean
	 */
	function getSPFbydyj() {
		$betid = '501';
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=SPF&expectId=';
		$current_match_url = $url.$current_number;
		$doc = new DOMDocument();
		$doc->load($current_match_url);
		$resp = $doc->getElementsByTagName("Resp");
		$code = $resp->item(0)->getAttribute("code");
		$desc = $resp->item(0)->getAttribute("desc");
		if ($code == 0) {
			$matchs = $doc->getElementsByTagName("match");
			/*
			 * <match itemid="1" matchname="捷克杯" hostteam="雅布罗" 
			 * visitteam="布德约" lotlose="-1" 
			 * matchtime="2012-03-29 22:30:00" 
			 * lotendtime="2012-03-29 21:30:00" 
			 * sp3="2.1000" sp1="4.1000" sp0="3.5600" 
			 * bet3="0.0000" bet1="0.0000" bet0="0.0000" 
			 * rzspf="3" rsspf="2.101476" win="5" lose="0"/>
			 */
			$match_data = array();
			$i = 0;
			$j = 0;
			foreach($matchs as $match) {
				$match_data[$i]['itemid'] = $match->getAttribute("itemid");
				$match_data[$i]['matchname'] = $match->getAttribute("matchname");
				$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
				$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
				$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
				$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
				$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
				$match_data[$i]['sp3'] = $match->getAttribute("sp3");
				$match_data[$i]['sp1'] = $match->getAttribute("sp1");
				$match_data[$i]['sp0'] = $match->getAttribute("sp0");
				$match_data[$i]['bet3'] = $match->getAttribute("bet3");
				$match_data[$i]['bet1'] = $match->getAttribute("bet1");
				$match_data[$i]['bet0'] = $match->getAttribute("bet0");
				$match_data[$i]['rzspf'] = $match->getAttribute("rzspf");//开奖结果
				$match_data[$i]['rsspf'] = $match->getAttribute("rsspf");//开奖sp
				$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
				$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
				
				$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
				if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
					$bf = '';
				}
				
				if ($match_data[$i]['rzspf'] == '' || $match_data[$i]['rsspf'] == '') {
					$j++;
				}
				
				$sp = array();
				$sp[1] = round($match_data[$i]['sp3'], 2);
				$sp[2] = round($match_data[$i]['sp1'], 2);
				$sp[3] = round($match_data[$i]['sp0'], 2);
				//var_dump($sp);die();
				$sp = json_encode($sp);
				$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
				if ($this->sql->num_rows() <= 0) {
					$insert_query = 'insert into match_bjdc_datas (betid,issue,match_no,league,goalline,home,away,playtime,stoptime,sp) values
					("'.$betid.'","'.$current_number.'","'.$match_data[$i]['itemid'].'","'.$match_data[$i]['matchname'].'","'.$match_data[$i]['lotlose'].'","'.$match_data[$i]['hostteam'].'","'.$match_data[$i]['visitteam'].'","'.$match_data[$i]['matchtime'].'","'.$match_data[$i]['lotendtime'].'",\''.$sp.'\')';
					$this->sql->query($insert_query);
					if (!$this->sql->error()) {
						echo '!';
					}
					else {
						echo '*';
					}
				}
				else {
					$match_info = $this->sql->fetch_array();
					//update
					if ($match_info['sp'] != $sp) {
						$this->sql->query('update match_bjdc_datas set sp=\''.$sp.'\' where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' sp updated!<br />';
					}
					if ($match_info['stoptime'] != $match_data[$i]['lotendtime']) {
						$this->sql->query('update match_bjdc_datas set stoptime="'.$match_data[$i]['lotendtime'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' stoptime updated!<br />';
					}
					if ($match_info['code'] != $match_data[$i]['rzspf']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzspf'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rsspf']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rsspf'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
				}
				$i++;
			}
			
		}
		else {
			return false;
		}
		
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1,1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'" AND `code` IS NOT NULL';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_r = $re['n'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'"';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_c = $re['n'];
		
		if ($match_c != $match_r) {
			echo 'update last data...<br />';
			$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=SPF&expectId=';
			$current_match_url = $url.$current_number;
			$doc = new DOMDocument();
			$doc->load($current_match_url);
			$resp = $doc->getElementsByTagName("Resp");
			$code = $resp->item(0)->getAttribute("code");
			$desc = $resp->item(0)->getAttribute("desc");
			if ($code == 0) {
				$matchs = $doc->getElementsByTagName("match");
				$match_data = array();
				$i = 0;
				$j = 0;
				foreach($matchs as $match) {
					$match_data[$i]['itemid'] = $match->getAttribute("itemid");
					$match_data[$i]['matchname'] = $match->getAttribute("matchname");
					$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
					$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
					$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
					$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
					$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
					$match_data[$i]['sp3'] = $match->getAttribute("sp3");
					$match_data[$i]['sp1'] = $match->getAttribute("sp1");
					$match_data[$i]['sp0'] = $match->getAttribute("sp0");
					$match_data[$i]['bet3'] = $match->getAttribute("bet3");
					$match_data[$i]['bet1'] = $match->getAttribute("bet1");
					$match_data[$i]['bet0'] = $match->getAttribute("bet0");
					$match_data[$i]['rzspf'] = $match->getAttribute("rzspf");//开奖结果
					$match_data[$i]['rsspf'] = $match->getAttribute("rsspf");//开奖sp
					$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
					$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
			
					$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
					if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
						$bf = '';
					}
			
					if ($match_data[$i]['rzspf'] == '' || $match_data[$i]['rsspf'] == '') {
						$j++;
					}
			
					$sp = array();
					$sp[1] = round($match_data[$i]['sp3'], 2);
					$sp[2] = round($match_data[$i]['sp1'], 2);
					$sp[3] = round($match_data[$i]['sp0'], 2);
					$sp = json_encode($sp);
					$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
					
					$match_info = $this->sql->fetch_array();
					//update
					
					if ($match_info['code'] != $match_data[$i]['rzspf']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzspf'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rsspf']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rsspf'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
					$i++;
				}
			}
			else {
				return false;
			}
		}
	}
	
	/**
	 * 获取北单上下单双大赢家接口
	 * @return boolean
	 */
	function getSXDSbydyj() {
		$betid = '502';
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=SXP&expectId=';
		$current_match_url = $url.$current_number;
		$doc = new DOMDocument();
		$doc->load($current_match_url);
		$resp = $doc->getElementsByTagName("Resp");
		$code = $resp->item(0)->getAttribute("code");
		$desc = $resp->item(0)->getAttribute("desc");
		if ($code == 0) {
			$matchs = $doc->getElementsByTagName("match");
			$match_data = array();
			$i = 0;
			$j = 0;
			foreach($matchs as $match) {
				$match_data[$i]['itemid'] = $match->getAttribute("itemid");
				$match_data[$i]['matchname'] = $match->getAttribute("matchname");
				$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
				$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
				$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
				$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
				$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
				$match_data[$i]['sxp3'] = $match->getAttribute("sxp3");
				$match_data[$i]['sxp2'] = $match->getAttribute("sxp2");
				$match_data[$i]['sxp1'] = $match->getAttribute("sxp1");
				$match_data[$i]['sxp0'] = $match->getAttribute("sxp0");
				$match_data[$i]['bet3'] = $match->getAttribute("bet3");
				$match_data[$i]['bet1'] = $match->getAttribute("bet1");
				$match_data[$i]['bet0'] = $match->getAttribute("bet0");
				$match_data[$i]['rzsxp'] = $match->getAttribute("rzsxp");//开奖结果
				$match_data[$i]['rssxp'] = $match->getAttribute("rssxp");//开奖sp
				$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
				$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
	
				$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
				if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
					$bf = '';
				}
	
				if ($match_data[$i]['rzsxp'] == '' || $match_data[$i]['rssxp'] == '') {
					$j++;
				}
	
				$sp = array();
				$sp[1] = round($match_data[$i]['sxp3'], 2);
				$sp[2] = round($match_data[$i]['sxp2'], 2);
				$sp[3] = round($match_data[$i]['sxp1'], 2);
				$sp[4] = round($match_data[$i]['sxp0'], 2);

				$sp = json_encode($sp);
				$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
				if ($this->sql->num_rows() <= 0) {
					$insert_query = 'insert into match_bjdc_datas (betid,issue,match_no,league,goalline,home,away,playtime,stoptime,sp) values
					("'.$betid.'","'.$current_number.'","'.$match_data[$i]['itemid'].'","'.$match_data[$i]['matchname'].'","'.$match_data[$i]['lotlose'].'","'.$match_data[$i]['hostteam'].'","'.$match_data[$i]['visitteam'].'","'.$match_data[$i]['matchtime'].'","'.$match_data[$i]['lotendtime'].'",\''.$sp.'\')';
					$this->sql->query($insert_query);
					if (!$this->sql->error()) {
						echo '!';
					}
					else {
						echo '*';
					}
				}
				else {
					$match_info = $this->sql->fetch_array();
					//update
					if ($match_info['sp'] != $sp) {
						$this->sql->query('update match_bjdc_datas set sp=\''.$sp.'\' where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' sp updated!<br />';
					}
					if ($match_info['stoptime'] != $match_data[$i]['lotendtime']) {
						$this->sql->query('update match_bjdc_datas set stoptime="'.$match_data[$i]['lotendtime'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' stoptime updated!<br />';
					}
					if ($match_info['code'] != $match_data[$i]['rzsxp']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzsxp'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rssxp']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rssxp'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
				}
				$i++;
			}
		}
		else {
			return false;
		}
		
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1,1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'" AND `code` IS NOT NULL';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_r = $re['n'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'"';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_c = $re['n'];
		
		if ($match_c != $match_r) {
			echo 'update last data...<br />';
			$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=SXP&expectId=';
			$current_match_url = $url.$current_number;
			$doc = new DOMDocument();
			$doc->load($current_match_url);
			$resp = $doc->getElementsByTagName("Resp");
			$code = $resp->item(0)->getAttribute("code");
			$desc = $resp->item(0)->getAttribute("desc");
			if ($code == 0) {
				$matchs = $doc->getElementsByTagName("match");
				$match_data = array();
				$i = 0;
				$j = 0;
				foreach($matchs as $match) {
					$match_data[$i]['itemid'] = $match->getAttribute("itemid");
					$match_data[$i]['matchname'] = $match->getAttribute("matchname");
					$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
					$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
					$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
					$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
					$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
					$match_data[$i]['sxp3'] = $match->getAttribute("sxp3");
					$match_data[$i]['sxp2'] = $match->getAttribute("sxp2");
					$match_data[$i]['sxp1'] = $match->getAttribute("sxp1");
					$match_data[$i]['sxp0'] = $match->getAttribute("sxp0");
					$match_data[$i]['bet3'] = $match->getAttribute("bet3");
					$match_data[$i]['bet1'] = $match->getAttribute("bet1");
					$match_data[$i]['bet0'] = $match->getAttribute("bet0");
					$match_data[$i]['rzsxp'] = $match->getAttribute("rzsxp");//开奖结果
					$match_data[$i]['rssxp'] = $match->getAttribute("rssxp");//开奖sp
					$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
					$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
			
					$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
					if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
						$bf = '';
					}
			
					if ($match_data[$i]['rzsxp'] == '' || $match_data[$i]['rssxp'] == '') {
						$j++;
					}
			
					$sp = array();
					$sp[1] = round($match_data[$i]['sxp3'], 2);
					$sp[2] = round($match_data[$i]['sxp2'], 2);
					$sp[3] = round($match_data[$i]['sxp1'], 2);
					$sp[4] = round($match_data[$i]['sxp0'], 2);
			
					$sp = json_encode($sp);
					$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
					
					$match_info = $this->sql->fetch_array();
					//update
					
					if ($match_info['code'] != $match_data[$i]['rzsxp']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzsxp'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rssxp']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rssxp'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
					
					$i++;
				}
			}
			else {
				return false;
			}
		}
	}
	
	/**
	 * 获取北单进球数大赢家接口
	 */
	function getZJQSbydyj() {
		$betid = '503';
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=JQS&expectId=';
		$current_match_url = $url.$current_number;
		$doc = new DOMDocument();
		$doc->load($current_match_url);
		$resp = $doc->getElementsByTagName("Resp");
		$code = $resp->item(0)->getAttribute("code");
		$desc = $resp->item(0)->getAttribute("desc");
		if ($code == 0) {
			$matchs = $doc->getElementsByTagName("match");
			$match_data = array();
			$i = 0;
			$j = 0;
			foreach($matchs as $match) {
				$match_data[$i]['itemid'] = $match->getAttribute("itemid");
				$match_data[$i]['matchname'] = $match->getAttribute("matchname");
				$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
				$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
				$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
				$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
				$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
				$match_data[$i]['jqs0'] = $match->getAttribute("jqs0");
				$match_data[$i]['jqs1'] = $match->getAttribute("jqs1");
				$match_data[$i]['jqs2'] = $match->getAttribute("jqs2");
				$match_data[$i]['jqs3'] = $match->getAttribute("jqs3");
				$match_data[$i]['jqs4'] = $match->getAttribute("jqs4");
				$match_data[$i]['jqs5'] = $match->getAttribute("jqs5");
				$match_data[$i]['jqs6'] = $match->getAttribute("jqs6");
				$match_data[$i]['jqs7'] = $match->getAttribute("jqs7");
				$match_data[$i]['bet3'] = $match->getAttribute("bet3");
				$match_data[$i]['bet1'] = $match->getAttribute("bet1");
				$match_data[$i]['bet0'] = $match->getAttribute("bet0");
				$match_data[$i]['rzjqs'] = $match->getAttribute("rzjqs");//开奖结果
				$match_data[$i]['rsjqs'] = $match->getAttribute("rsjqs");//开奖sp
				$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
				$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
	
				$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
				if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
					$bf = '';
				}
	
				if ($match_data[$i]['rzjqs'] == '' || $match_data[$i]['rsjqs'] == '') {
					$j++;
				}
	
				$sp = array();
				$sp[1] = round($match_data[$i]['jqs0'], 2);
				$sp[2] = round($match_data[$i]['jqs1'], 2);
				$sp[3] = round($match_data[$i]['jqs2'], 2);
				$sp[4] = round($match_data[$i]['jqs3'], 2);
				$sp[5] = round($match_data[$i]['jqs4'], 2);
				$sp[6] = round($match_data[$i]['jqs5'], 2);
				$sp[7] = round($match_data[$i]['jqs6'], 2);
				$sp[8] = round($match_data[$i]['jqs7'], 2);
				$sp = json_encode($sp);
				$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
				if ($this->sql->num_rows() <= 0) {
					$insert_query = 'insert into match_bjdc_datas (betid,issue,match_no,league,goalline,home,away,playtime,stoptime,sp) values
					("'.$betid.'","'.$current_number.'","'.$match_data[$i]['itemid'].'","'.$match_data[$i]['matchname'].'","'.$match_data[$i]['lotlose'].'","'.$match_data[$i]['hostteam'].'","'.$match_data[$i]['visitteam'].'","'.$match_data[$i]['matchtime'].'","'.$match_data[$i]['lotendtime'].'",\''.$sp.'\')';
					$this->sql->query($insert_query);
					if (!$this->sql->error()) {
						echo '!';
					}
					else {
						echo '*';
					}
				}
				else {
					$match_info = $this->sql->fetch_array();
					//update
					if ($match_info['sp'] != $sp) {
						$this->sql->query('update match_bjdc_datas set sp=\''.$sp.'\' where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' sp updated!<br />';
					}
					if ($match_info['stoptime'] != $match_data[$i]['lotendtime']) {
						$this->sql->query('update match_bjdc_datas set stoptime="'.$match_data[$i]['lotendtime'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' stoptime updated!<br />';
					}
					if ($match_info['code'] != $match_data[$i]['rzjqs']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzjqs'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rsjqs']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rsjqs'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
				}
				$i++;
			}
		}
		else {
			return false;
		}
		
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1,1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'" AND `code` IS NOT NULL';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_r = $re['n'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'"';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_c = $re['n'];
		
		if ($match_c != $match_r) {
			echo 'update last data...<br />';
			$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=JQS&expectId=';
			$current_match_url = $url.$current_number;
			$doc = new DOMDocument();
			$doc->load($current_match_url);
			$resp = $doc->getElementsByTagName("Resp");
			$code = $resp->item(0)->getAttribute("code");
			$desc = $resp->item(0)->getAttribute("desc");
			if ($code == 0) {
				$matchs = $doc->getElementsByTagName("match");
				$match_data = array();
				$i = 0;
				$j = 0;
				foreach($matchs as $match) {
					$match_data[$i]['itemid'] = $match->getAttribute("itemid");
					$match_data[$i]['matchname'] = $match->getAttribute("matchname");
					$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
					$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
					$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
					$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
					$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
					$match_data[$i]['jqs0'] = $match->getAttribute("jqs0");
					$match_data[$i]['jqs1'] = $match->getAttribute("jqs1");
					$match_data[$i]['jqs2'] = $match->getAttribute("jqs2");
					$match_data[$i]['jqs3'] = $match->getAttribute("jqs3");
					$match_data[$i]['jqs4'] = $match->getAttribute("jqs4");
					$match_data[$i]['jqs5'] = $match->getAttribute("jqs5");
					$match_data[$i]['jqs6'] = $match->getAttribute("jqs6");
					$match_data[$i]['jqs7'] = $match->getAttribute("jqs7");
					$match_data[$i]['bet3'] = $match->getAttribute("bet3");
					$match_data[$i]['bet1'] = $match->getAttribute("bet1");
					$match_data[$i]['bet0'] = $match->getAttribute("bet0");
					$match_data[$i]['rzjqs'] = $match->getAttribute("rzjqs");//开奖结果
					$match_data[$i]['rsjqs'] = $match->getAttribute("rsjqs");//开奖sp
					$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
					$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
			
					$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
					if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
						$bf = '';
					}
			
					if ($match_data[$i]['rzjqs'] == '' || $match_data[$i]['rsjqs'] == '') {
						$j++;
					}
			
					$sp = array();
					$sp[1] = round($match_data[$i]['jqs0'], 2);
					$sp[2] = round($match_data[$i]['jqs1'], 2);
					$sp[3] = round($match_data[$i]['jqs2'], 2);
					$sp[4] = round($match_data[$i]['jqs3'], 2);
					$sp[5] = round($match_data[$i]['jqs4'], 2);
					$sp[6] = round($match_data[$i]['jqs5'], 2);
					$sp[7] = round($match_data[$i]['jqs6'], 2);
					$sp[8] = round($match_data[$i]['jqs7'], 2);
					$sp = json_encode($sp);
					$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
					
					$match_info = $this->sql->fetch_array();
					//update
					
					if ($match_info['code'] != $match_data[$i]['rzjqs']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzjqs'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rsjqs']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rsjqs'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
					$i++;
				}
			}
			else {
				return false;
			}
		}
	}
	
	/**
	 * 获取北单比分大赢家接口
	 * @return boolean
	 */
	function getBFbydyj() {
		$betid = '504';
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=CBF&expectId=';
		$current_match_url = $url.$current_number;
		$doc = new DOMDocument();
		$doc->load($current_match_url);
		$resp = $doc->getElementsByTagName("Resp");
		$code = $resp->item(0)->getAttribute("code");
		$desc = $resp->item(0)->getAttribute("desc");
		if ($code == 0) {
			$matchs = $doc->getElementsByTagName("match");
			$match_data = array();
			$i = 0;
			$j = 0;
			foreach($matchs as $match) {
				$match_data[$i]['itemid'] = $match->getAttribute("itemid");
				$match_data[$i]['matchname'] = $match->getAttribute("matchname");
				$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
				$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
				$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
				$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
				$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
				$match_data[$i]['spcbf10'] = $match->getAttribute("spcbf10");
				$match_data[$i]['spcbf20'] = $match->getAttribute("spcbf20");
				$match_data[$i]['spcbf21'] = $match->getAttribute("spcbf21");
				$match_data[$i]['spcbf30'] = $match->getAttribute("spcbf30");
				$match_data[$i]['spcbf31'] = $match->getAttribute("spcbf31");
				$match_data[$i]['spcbf32'] = $match->getAttribute("spcbf32");
				$match_data[$i]['spcbf40'] = $match->getAttribute("spcbf40");
				$match_data[$i]['spcbf41'] = $match->getAttribute("spcbf41");
				$match_data[$i]['spcbf42'] = $match->getAttribute("spcbf42");
				$match_data[$i]['spcbf90'] = $match->getAttribute("spcbf90");
				$match_data[$i]['spcbf01'] = $match->getAttribute("spcbf01");
				$match_data[$i]['spcbf02'] = $match->getAttribute("spcbf02");
				$match_data[$i]['spcbf12'] = $match->getAttribute("spcbf12");
				$match_data[$i]['spcbf03'] = $match->getAttribute("spcbf03");
				$match_data[$i]['spcbf13'] = $match->getAttribute("spcbf13");
				$match_data[$i]['spcbf23'] = $match->getAttribute("spcbf23");
				$match_data[$i]['spcbf04'] = $match->getAttribute("spcbf04");
				$match_data[$i]['spcbf14'] = $match->getAttribute("spcbf14");
				$match_data[$i]['spcbf24'] = $match->getAttribute("spcbf24");
				$match_data[$i]['spcbf09'] = $match->getAttribute("spcbf09");
				$match_data[$i]['spcbf00'] = $match->getAttribute("spcbf00");
				$match_data[$i]['spcbf11'] = $match->getAttribute("spcbf11");
				$match_data[$i]['spcbf22'] = $match->getAttribute("spcbf22");
				$match_data[$i]['spcbf33'] = $match->getAttribute("spcbf33");
				$match_data[$i]['spcbf99'] = $match->getAttribute("spcbf99");
				$match_data[$i]['bet3'] = $match->getAttribute("bet3");
				$match_data[$i]['bet1'] = $match->getAttribute("bet1");
				$match_data[$i]['bet0'] = $match->getAttribute("bet0");
				$match_data[$i]['rzcbf'] = $match->getAttribute("rzcbf");//开奖结果
				$match_data[$i]['rscbf'] = $match->getAttribute("rscbf");//开奖sp
				$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
				$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
	
				$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
				if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
					$bf = '';
				}
	
				if ($match_data[$i]['rzcbf'] == '' || $match_data[$i]['rscbf'] == '') {
					$j++;
				}
	
				$sp = array();
				$sp[1] = round($match_data[$i]['spcbf10'], 2);
				$sp[2] = round($match_data[$i]['spcbf20'], 2);
				$sp[3] = round($match_data[$i]['spcbf30'], 2);
				$sp[4] = round($match_data[$i]['spcbf21'], 2);
				$sp[5] = round($match_data[$i]['spcbf31'], 2);
				$sp[6] = round($match_data[$i]['spcbf41'], 2);
				$sp[7] = round($match_data[$i]['spcbf32'], 2);
				$sp[8] = round($match_data[$i]['spcbf42'], 2);
				$sp[9] = round($match_data[$i]['spcbf40'], 2);
				$sp[10] = round($match_data[$i]['spcbf90'], 2);
				
				$sp[11] = round($match_data[$i]['spcbf00'], 2);
				$sp[12] = round($match_data[$i]['spcbf11'], 2);
				$sp[13] = round($match_data[$i]['spcbf22'], 2);
				$sp[14] = round($match_data[$i]['spcbf33'], 2);
				$sp[15] = round($match_data[$i]['spcbf99'], 2);
				
				$sp[16] = round($match_data[$i]['spcbf01'], 2);
				$sp[17] = round($match_data[$i]['spcbf02'], 2);
				$sp[18] = round($match_data[$i]['spcbf03'], 2);
				$sp[19] = round($match_data[$i]['spcbf12'], 2);
				$sp[20] = round($match_data[$i]['spcbf13'], 2);
				$sp[21] = round($match_data[$i]['spcbf14'], 2);
				$sp[22] = round($match_data[$i]['spcbf23'], 2);
				$sp[23] = round($match_data[$i]['spcbf24'], 2);
				$sp[24] = round($match_data[$i]['spcbf04'], 2);
				$sp[25] = round($match_data[$i]['spcbf09'], 2);
				
				$sp = json_encode($sp);
				$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
				if ($this->sql->num_rows() <= 0) {
					$insert_query = 'insert into match_bjdc_datas (betid,issue,match_no,league,goalline,home,away,playtime,stoptime,sp) values
					("'.$betid.'","'.$current_number.'","'.$match_data[$i]['itemid'].'","'.$match_data[$i]['matchname'].'","'.$match_data[$i]['lotlose'].'","'.$match_data[$i]['hostteam'].'","'.$match_data[$i]['visitteam'].'","'.$match_data[$i]['matchtime'].'","'.$match_data[$i]['lotendtime'].'",\''.$sp.'\')';
					$this->sql->query($insert_query);
					if (!$this->sql->error()) {
						echo '!';
					}
					else {
						echo '*';
					}
				}
				else {
					$match_info = $this->sql->fetch_array();
					//update
					if ($match_info['sp'] != $sp) {
						$this->sql->query('update match_bjdc_datas set sp=\''.$sp.'\' where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' sp updated!<br />';
					}
					if ($match_info['stoptime'] != $match_data[$i]['lotendtime']) {
						$this->sql->query('update match_bjdc_datas set stoptime="'.$match_data[$i]['lotendtime'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' stoptime updated!<br />';
					}
					if ($match_info['code'] != $match_data[$i]['rzcbf']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzcbf'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rscbf']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rscbf'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
				}
				$i++;
			}
		}
		else {
			return false;
		}
		
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1,1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'" AND `code` IS NOT NULL';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_r = $re['n'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'"';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_c = $re['n'];
		
		if ($match_c != $match_r) {
			echo 'update last data...<br />';
			$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=CBF&expectId=';
			$current_match_url = $url.$current_number;
			$doc = new DOMDocument();
			$doc->load($current_match_url);
			$resp = $doc->getElementsByTagName("Resp");
			$code = $resp->item(0)->getAttribute("code");
			$desc = $resp->item(0)->getAttribute("desc");
			if ($code == 0) {
				$matchs = $doc->getElementsByTagName("match");
				$match_data = array();
				$i = 0;
				$j = 0;
				foreach($matchs as $match) {
					$match_data[$i]['itemid'] = $match->getAttribute("itemid");
					$match_data[$i]['matchname'] = $match->getAttribute("matchname");
					$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
					$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
					$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
					$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
					$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
					$match_data[$i]['spcbf10'] = $match->getAttribute("spcbf10");
					$match_data[$i]['spcbf20'] = $match->getAttribute("spcbf20");
					$match_data[$i]['spcbf21'] = $match->getAttribute("spcbf21");
					$match_data[$i]['spcbf30'] = $match->getAttribute("spcbf30");
					$match_data[$i]['spcbf31'] = $match->getAttribute("spcbf31");
					$match_data[$i]['spcbf32'] = $match->getAttribute("spcbf32");
					$match_data[$i]['spcbf40'] = $match->getAttribute("spcbf40");
					$match_data[$i]['spcbf41'] = $match->getAttribute("spcbf41");
					$match_data[$i]['spcbf42'] = $match->getAttribute("spcbf42");
					$match_data[$i]['spcbf90'] = $match->getAttribute("spcbf90");
					$match_data[$i]['spcbf01'] = $match->getAttribute("spcbf01");
					$match_data[$i]['spcbf02'] = $match->getAttribute("spcbf02");
					$match_data[$i]['spcbf12'] = $match->getAttribute("spcbf12");
					$match_data[$i]['spcbf03'] = $match->getAttribute("spcbf03");
					$match_data[$i]['spcbf13'] = $match->getAttribute("spcbf13");
					$match_data[$i]['spcbf23'] = $match->getAttribute("spcbf23");
					$match_data[$i]['spcbf04'] = $match->getAttribute("spcbf04");
					$match_data[$i]['spcbf14'] = $match->getAttribute("spcbf14");
					$match_data[$i]['spcbf24'] = $match->getAttribute("spcbf24");
					$match_data[$i]['spcbf09'] = $match->getAttribute("spcbf09");
					$match_data[$i]['spcbf00'] = $match->getAttribute("spcbf00");
					$match_data[$i]['spcbf11'] = $match->getAttribute("spcbf11");
					$match_data[$i]['spcbf22'] = $match->getAttribute("spcbf22");
					$match_data[$i]['spcbf33'] = $match->getAttribute("spcbf33");
					$match_data[$i]['spcbf99'] = $match->getAttribute("spcbf99");
					$match_data[$i]['bet3'] = $match->getAttribute("bet3");
					$match_data[$i]['bet1'] = $match->getAttribute("bet1");
					$match_data[$i]['bet0'] = $match->getAttribute("bet0");
					$match_data[$i]['rzcbf'] = $match->getAttribute("rzcbf");//开奖结果
					$match_data[$i]['rscbf'] = $match->getAttribute("rscbf");//开奖sp
					$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
					$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
			
					$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
					if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
						$bf = '';
					}
			
					if ($match_data[$i]['rzcbf'] == '' || $match_data[$i]['rscbf'] == '') {
						$j++;
					}
			
					$sp = array();
					$sp[1] = round($match_data[$i]['spcbf10'], 2);
					$sp[2] = round($match_data[$i]['spcbf20'], 2);
					$sp[3] = round($match_data[$i]['spcbf30'], 2);
					$sp[4] = round($match_data[$i]['spcbf21'], 2);
					$sp[5] = round($match_data[$i]['spcbf31'], 2);
					$sp[6] = round($match_data[$i]['spcbf41'], 2);
					$sp[7] = round($match_data[$i]['spcbf32'], 2);
					$sp[8] = round($match_data[$i]['spcbf42'], 2);
					$sp[9] = round($match_data[$i]['spcbf40'], 2);
					$sp[10] = round($match_data[$i]['spcbf90'], 2);
			
					$sp[11] = round($match_data[$i]['spcbf00'], 2);
					$sp[12] = round($match_data[$i]['spcbf11'], 2);
					$sp[13] = round($match_data[$i]['spcbf22'], 2);
					$sp[14] = round($match_data[$i]['spcbf33'], 2);
					$sp[15] = round($match_data[$i]['spcbf99'], 2);
			
					$sp[16] = round($match_data[$i]['spcbf01'], 2);
					$sp[17] = round($match_data[$i]['spcbf02'], 2);
					$sp[18] = round($match_data[$i]['spcbf03'], 2);
					$sp[19] = round($match_data[$i]['spcbf12'], 2);
					$sp[20] = round($match_data[$i]['spcbf13'], 2);
					$sp[21] = round($match_data[$i]['spcbf14'], 2);
					$sp[22] = round($match_data[$i]['spcbf23'], 2);
					$sp[23] = round($match_data[$i]['spcbf24'], 2);
					$sp[24] = round($match_data[$i]['spcbf04'], 2);
					$sp[25] = round($match_data[$i]['spcbf09'], 2);
			
					$sp = json_encode($sp);
					$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
					
					$match_info = $this->sql->fetch_array();
					//update
					if ($match_info['code'] != $match_data[$i]['rzcbf']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzcbf'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rscbf']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rscbf'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
					
					$i++;
				}
			}
			else {
				return false;
			}
		}
	}
	
	/**
	 * 获取北单半全场大赢家接口
	 * @return boolean
	 */
	function getBQCbydyj() {
		$betid = '505';
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=BQC&expectId=';
		$current_match_url = $url.$current_number;
		$doc = new DOMDocument();
		$doc->load($current_match_url);
		$resp = $doc->getElementsByTagName("Resp");
		$code = $resp->item(0)->getAttribute("code");
		$desc = $resp->item(0)->getAttribute("desc");
		if ($code == 0) {
			$matchs = $doc->getElementsByTagName("match");
			$match_data = array();
			$i = 0;
			$j = 0;
			foreach($matchs as $match) {
				$match_data[$i]['itemid'] = $match->getAttribute("itemid");
				$match_data[$i]['matchname'] = $match->getAttribute("matchname");
				$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
				$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
				$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
				$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
				$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
				$match_data[$i]['spbqc33'] = $match->getAttribute("spbqc33");
				$match_data[$i]['spbqc31'] = $match->getAttribute("spbqc31");
				$match_data[$i]['spbqc30'] = $match->getAttribute("spbqc30");
				$match_data[$i]['spbqc13'] = $match->getAttribute("spbqc13");
				$match_data[$i]['spbqc11'] = $match->getAttribute("spbqc11");
				$match_data[$i]['spbqc10'] = $match->getAttribute("spbqc10");
				$match_data[$i]['spbqc03'] = $match->getAttribute("spbqc03");
				$match_data[$i]['spbqc01'] = $match->getAttribute("spbqc01");
				$match_data[$i]['spbqc00'] = $match->getAttribute("spbqc00");
				$match_data[$i]['bet3'] = $match->getAttribute("bet3");
				$match_data[$i]['bet1'] = $match->getAttribute("bet1");
				$match_data[$i]['bet0'] = $match->getAttribute("bet0");
				$match_data[$i]['rzbqc'] = $match->getAttribute("rzbqc");//开奖结果
				$match_data[$i]['rsbqc'] = $match->getAttribute("rsbqc");//开奖sp
				$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
				$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
	
				$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
				if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
					$bf = '';
				}
	
				if ($match_data[$i]['rzbqc'] == '' || $match_data[$i]['rsbqc'] == '') {
					$j++;
				}
	
				$sp = array();
				$sp[1] = round($match_data[$i]['spbqc33'], 2);
				$sp[2] = round($match_data[$i]['spbqc31'], 2);
				$sp[3] = round($match_data[$i]['spbqc30'], 2);
				$sp[4] = round($match_data[$i]['spbqc13'], 2);
				$sp[5] = round($match_data[$i]['spbqc11'], 2);
				$sp[6] = round($match_data[$i]['spbqc10'], 2);
				$sp[7] = round($match_data[$i]['spbqc03'], 2);
				$sp[8] = round($match_data[$i]['spbqc01'], 2);
				$sp[9] = round($match_data[$i]['spbqc00'], 2);
				$sp = json_encode($sp);
				$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
				if ($this->sql->num_rows() <= 0) {
					$insert_query = 'insert into match_bjdc_datas (betid,issue,match_no,league,goalline,home,away,playtime,stoptime,sp) values
					("'.$betid.'","'.$current_number.'","'.$match_data[$i]['itemid'].'","'.$match_data[$i]['matchname'].'","'.$match_data[$i]['lotlose'].'","'.$match_data[$i]['hostteam'].'","'.$match_data[$i]['visitteam'].'","'.$match_data[$i]['matchtime'].'","'.$match_data[$i]['lotendtime'].'",\''.$sp.'\')';
					$this->sql->query($insert_query);
					if (!$this->sql->error()) {
						echo '!';
					}
					else {
						echo '*';
					}
				}
				else {
					$match_info = $this->sql->fetch_array();
					//update
					if ($match_info['sp'] != $sp) {
						$this->sql->query('update match_bjdc_datas set sp=\''.$sp.'\' where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' sp updated!<br />';
					}
					if ($match_info['stoptime'] != $match_data[$i]['lotendtime']) {
						$this->sql->query('update match_bjdc_datas set stoptime="'.$match_data[$i]['lotendtime'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' stoptime updated!<br />';
					}
					if ($match_info['code'] != $match_data[$i]['rzbqc']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzbqc'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rsbqc']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rsbqc'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
				}
				$i++;
			}
		}
		else {
			return false;
		}
		
		$query = 'select number from match_bjdc_issues where betid="'.$betid.'" order by id desc limit 1,1';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$current_number = $re['number'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'" AND `code` IS NOT NULL';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_r = $re['n'];
		
		$query = 'SELECT count(*) as n  FROM `match_bjdc_datas` WHERE `betid` = "'.$betid.'" AND `issue` = "'.$current_number.'"';
		$this->sql->query($query);
		$re = $this->sql->fetch_array();
		$match_c = $re['n'];
		
		if ($match_c != $match_r) {
			$url = 'http://518.cpdyj.com/trade/bjvsdpf.go?playId=BQC&expectId=';
			$current_match_url = $url.$current_number;
			$doc = new DOMDocument();
			$doc->load($current_match_url);
			$resp = $doc->getElementsByTagName("Resp");
			$code = $resp->item(0)->getAttribute("code");
			$desc = $resp->item(0)->getAttribute("desc");
			if ($code == 0) {
				$matchs = $doc->getElementsByTagName("match");
				$match_data = array();
				$i = 0;
				$j = 0;
				foreach($matchs as $match) {
					$match_data[$i]['itemid'] = $match->getAttribute("itemid");
					$match_data[$i]['matchname'] = $match->getAttribute("matchname");
					$match_data[$i]['hostteam'] = $match->getAttribute("hostteam");
					$match_data[$i]['visitteam'] = $match->getAttribute("visitteam");
					$match_data[$i]['lotlose'] = $match->getAttribute("lotlose");
					$match_data[$i]['matchtime'] = $match->getAttribute("matchtime");
					$match_data[$i]['lotendtime'] = $match->getAttribute("lotendtime");
					$match_data[$i]['spbqc33'] = $match->getAttribute("spbqc33");
					$match_data[$i]['spbqc31'] = $match->getAttribute("spbqc31");
					$match_data[$i]['spbqc30'] = $match->getAttribute("spbqc30");
					$match_data[$i]['spbqc13'] = $match->getAttribute("spbqc13");
					$match_data[$i]['spbqc11'] = $match->getAttribute("spbqc11");
					$match_data[$i]['spbqc10'] = $match->getAttribute("spbqc10");
					$match_data[$i]['spbqc03'] = $match->getAttribute("spbqc03");
					$match_data[$i]['spbqc01'] = $match->getAttribute("spbqc01");
					$match_data[$i]['spbqc00'] = $match->getAttribute("spbqc00");
					$match_data[$i]['bet3'] = $match->getAttribute("bet3");
					$match_data[$i]['bet1'] = $match->getAttribute("bet1");
					$match_data[$i]['bet0'] = $match->getAttribute("bet0");
					$match_data[$i]['rzbqc'] = $match->getAttribute("rzbqc");//开奖结果
					$match_data[$i]['rsbqc'] = $match->getAttribute("rsbqc");//开奖sp
					$match_data[$i]['win'] = $match->getAttribute("win");//主队进球  客队进球
					$match_data[$i]['lose'] = $match->getAttribute("lose");//客队进球
			
					$bf = $match_data[$i]['win'].':'.$match_data[$i]['lose'];
					if ($match_data[$i]['win'] == '' || $match_data[$i]['lose'] == '') {
						$bf = '';
					}
			
					if ($match_data[$i]['rzbqc'] == '' || $match_data[$i]['rsbqc'] == '') {
						$j++;
					}
			
					$sp = array();
					$sp[1] = round($match_data[$i]['spbqc33'], 2);
					$sp[2] = round($match_data[$i]['spbqc31'], 2);
					$sp[3] = round($match_data[$i]['spbqc30'], 2);
					$sp[4] = round($match_data[$i]['spbqc13'], 2);
					$sp[5] = round($match_data[$i]['spbqc11'], 2);
					$sp[6] = round($match_data[$i]['spbqc10'], 2);
					$sp[7] = round($match_data[$i]['spbqc03'], 2);
					$sp[8] = round($match_data[$i]['spbqc01'], 2);
					$sp[9] = round($match_data[$i]['spbqc00'], 2);
					$sp = json_encode($sp);
					$this->sql->query('select id,sp,stoptime,code,sp_r,bf from match_bjdc_datas where betid="'.$betid.'" and issue="'.$current_number.'" and match_no="'.$match_data[$i]['itemid'].'"');
					
					$match_info = $this->sql->fetch_array();
					//update
					
					if ($match_info['code'] != $match_data[$i]['rzbqc']) {
						$this->sql->query('update match_bjdc_datas set code="'.$match_data[$i]['rzbqc'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' saiguo updated!<br />';
					}
					if ($match_info['sp_r'] != $match_data[$i]['rsbqc']) {
						$this->sql->query('update match_bjdc_datas set sp_r="'.$match_data[$i]['rsbqc'].'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' kaijiang_sp updated!<br />';
					}
					if ($match_info['bf'] != $bf) {
						$this->sql->query('update match_bjdc_datas set bf="'.$bf.'" where id="'.$match_info['id'].'"');
						echo 'id: '.$match_info['id'].' bf updated!<br />';
					}
					
					$i++;
				}
			}
			else {
				return false;
			}
		}
	}
	
	/**
	 * 获取北单期号大赢家接口
	 * @return boolean
	 */
	function getIssuebydyj() {
		$url = 'http://518.cpdyj.com/trade/getexpect.dyj?lottype=25';
		$doc = new DOMDocument();
		$doc->load($url);
		$resp = $doc->getElementsByTagName("Resp");
		$code = $resp->item(0)->getAttribute("code");
		$desc = $resp->item(0)->getAttribute("desc");
		if ($code == 0) {
			$issues = $doc->getElementsByTagName("row");
			$issue_data = array();
			$i = 0;
			foreach ($issues as $issue) {
				$issue_data[$i]['number'] = $issue->getAttribute("lotissue");
				$issue_data[$i]['start'] = $issue->getAttribute("starttime");
				$issue_data[$i]['stop'] = $issue->getAttribute("endtime");
				$i++;
			}
			$current_issue = $issue_data[0];
			$query = 'select * from match_bjdc_issues where number="'.$current_issue['number'].'"';
			$this->sql->query($query);
			if ($this->sql->num_rows() <= 0) {
				$this->sql->query('insert into match_bjdc_issues (betid,number,start,stop) values ("501","'.$current_issue['number'].'","'.$current_issue['start'].'","'.$current_issue['stop'].'")');
				$this->sql->query('insert into match_bjdc_issues (betid,number,start,stop) values ("502","'.$current_issue['number'].'","'.$current_issue['start'].'","'.$current_issue['stop'].'")');
				$this->sql->query('insert into match_bjdc_issues (betid,number,start,stop) values ("503","'.$current_issue['number'].'","'.$current_issue['start'].'","'.$current_issue['stop'].'")');
				$this->sql->query('insert into match_bjdc_issues (betid,number,start,stop) values ("504","'.$current_issue['number'].'","'.$current_issue['start'].'","'.$current_issue['stop'].'")');
				$this->sql->query('insert into match_bjdc_issues (betid,number,start,stop) values ("505","'.$current_issue['number'].'","'.$current_issue['start'].'","'.$current_issue['stop'].'")');
				echo '!!!!!';
			}
		}
		else {
			return false;
		}
	}
}
?>