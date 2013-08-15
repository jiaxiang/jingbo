<?php
class Socket_Ticket {
	
	const IP = '112.65.16.46';
	const TIMEOUT = 2;
	const QUEUE_NAME_JCZQ = 'jctq_';
	
	const JC_PORT_TOTAL = 500;
	const ZC_PORT_TOTAL = 800;
	
	const JC_TICKET_TYPE = 1;
	const ZC_TICKET_TYPE = 2;
	
	//竞彩足球端口
	public static $jczq_port_pool = array(
		'51101',
	);
	
	//竞彩足球每个端口对应的一次最多彩票数量
	public static $jczq_port_limit = array(
		'51101' => 3,
	);
	
	/**
	 * 端口号 => 彩票机类型（1=>竞彩，2=>传统足彩），一次最多彩票数量6/48/96/172/250，init命令
	 * 14比分，12本全场，23胜分差走老
	 * Enter description here ...
	 * @var unknown_type
	 */
	public static $posts_info = array(
		//120
		'51107' => array(2, 120, 'xcs_init 1 2'),
		'51108' => array(2, 120, 'xcs_init 1 2'),
		'51104' => array(2, 120, 'xcs_init 1 3'),
		'51103' => array(2, 120, 'xcs_init 1 3'),
		'51102' => array(2, 120, 'xcs_init 1 3'),
		//'51101' => array(2, 120, 'xcs_init 1 8'),
		//80
		'51106' => array(1, 80, 'xcs_init 1 2'),
		'51105' => array(1, 80, 'xcs_init 1 2'),
	);
	
	//竞彩足球玩法对应关系，11：足球胜平负；12：足球半全场；13：足球总进球；14：足球比分
	public static $jczq_play_type = array(
		'1' => '11',
        '2' => '13',
        '3' => '14',
        '4' => '12'
	);
	
	//竞彩篮球玩法对应关系，21：篮球胜负；22：篮球让分胜负；23：篮球胜分差；24：篮球大小分
	public static $jclq_play_type = array(
		'1' => '21',
        '2' => '22',
        '3' => '23',
        '4' => '24'
	);
	
	//足彩胜负玩法对应关系,31：14场；32：任9；33：6场半全场；34：4场进球
	public static $zcsf_play_type = array(
		'1' => '31',
        '2' => '32',
       	'3' => '33',
        '4' => '34'
	);
	
	//足彩胜负单式复式对应关系
	public static $zcsf_dsfs = array(
		'1' => '2',
		'3' => '1'
	);
	
	//足彩玩法对应机器界面编号,02：4场进球；08：14场任9；09：6场半全场；51：竞彩
	public static $zcsf_play_main = array(
		'31' => '08',
		'32' => '08',
		'33' => '09',
		'34' => '02'
	);
	
	private $sql;
	private $memcacheq;
	private $cron_log;
	private $zcsf;
	
	function __construct() {
		require_once 'SQL.php';
		$this->sql = new SQL();
		///require_once 'MemcacheQ.php';
		//$this->memcacheq = new MemcacheQ();
		require_once 'Crontab_Log.php';
		$this->cron_log = new Crontab_Log();
		require_once 'ZCSF.php';
		$this->zcsf = new ZCSF();
	}
	
	/**
	 * 根据彩票类型返回端口号数组
	 * Enter description here ...
	 * @param unknown_type $ticket_type
	 */
	public static function get_port_num($ticket_type) {
		$return = array();
		$t = self::$posts_info;
		foreach ($t as $k => $v) {
			if ($v[0] == $ticket_type) {
				$return[] = $k;
			}
		}
		return $return;
	}
	
	/**
	 * 根据端口号返回每个端口一次打票数量
	 * Enter description here ...
	 * @param unknown_type $port
	 */
	public static function get_port_limit($port) {
		$return = 0;
		$t = self::$posts_info;
		if (isset($t[$port]) && is_array($t[$port])) {
			$i = $t[$port];
			$return = $i[1];
		}
		return $return;
	}
	
	/**
	 * 根据端口号返回init命令 
	 * Enter description here ...
	 * @param unknown_type $port
	 */
	public static function get_port_initcmd($port) {
		$return = '';
		$t = self::$posts_info;
		if (isset($t[$port]) && is_array($t[$port])) {
			$i = $t[$port];
			$return = $i[2];
		}
		return $return;
	}
	
	/**
	 * 根据机器端口返回足彩编号数据
	 * @param unknown_type $port
	 */
	public static function get_port_zc_play_main($port) {
		switch ($port) {
			case '51102':
				$return = array(
				'31' => '07',
				'32' => '07',
				'33' => '08',
				'34' => '02',
				);
				break;
				
			case '51103':
				$return = array(
				'31' => '07',
				'32' => '07',
				'33' => '08',
				'34' => '02',
				);
				break;
				
			case '51104':
				$return = array(
				'31' => '07',
				'32' => '07',
				'33' => '08',
				'34' => '02',
				);
				break;
				
			case '51107':
				$return = array(
				'31' => '07',
				'32' => '07',
				'33' => '08',
				'34' => '02',
				);
				break;
				
			case '51108':
				$return = array(
				'31' => '08',
				'32' => '08',
				'33' => '09',
				'34' => '02',
				);
				break;
			
			default:
				$return = self::$zcsf_play_main;
				break;
		}
		return $return;
	}
	
	/**
	 * 根据机器端口返回七星彩编号数据
	 * @param unknown_type $port
	 */
	public static function get_port_qxc_play_main($port) {
		switch ($port) {
			case '51102':
				$return = '05';
				break;
				
			case '51103':
				$return = '05';
				break;
	
			case '51104':
				$return = '05';
				break;
	
			case '51107':
				$return = '05';
				break;
	
			case '51108':
				$return = '06';
				break;
					
			default:
				$return = '06';
				break;
		}
		return $return;
	}
	
	/**
	 * 竞彩足球让球胜平负代码转换
	 * Enter description here ...
	 * @param unknown_type $result
	 */
 	public static function trans_rqspf($result) {
        if (empty($result))
        {
            return FALSE;    
        }
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        $codeto = array();
        foreach($arrcode2 as $row)
        {
            $arrrow = explode("|", $row);
            $select = substr($arrrow[1], 5);
            $select = substr($select,0,strlen($select)-1);
            $codeto[] = substr($arrrow[1], 0, 1).'|'.substr($arrrow[1], 1, 3).'|'.$select;
        }
        
        $result['tocodes'] = implode('|',$codeto);
        
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    }
    
    /**
     * 竞彩足球比分代码转换
     * Enter description here ...
     * @param unknown_type $result
     */
    public static function trans_bf($result) {
    	if (empty($result))
        {
            return FALSE;    
        }
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        $codeto = array();
        foreach($arrcode2 as $row)
        {
            $arrrow = explode("|", $row);
            $select = substr($arrrow[1], 5);
            $select = substr($select,0,strlen($select)-1);
            $codeto[] = substr($arrrow[1], 0, 1).'|'.substr($arrrow[1], 1, 3).'|'.$select;
        }
        
        $result['tocodes'] = implode('|',$codeto);
        $result['tocodes'] = str_replace(':', '', $result['tocodes']);
        $result['tocodes'] = str_replace('平其它', '99', $result['tocodes']);
        $result['tocodes'] = str_replace('负其它', '09', $result['tocodes']);
        $result['tocodes'] = str_replace('胜其它', '90', $result['tocodes']);
        
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    }
    
    /**
     * 竞彩足球半全场代码转换
     * Enter description here ...
     * @param unknown_type $result
     */
	public static function trans_bqc($result) {
    	if (empty($result))
        {
            return FALSE;    
        }
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        $codeto = array();
        foreach($arrcode2 as $row)
        {
            $arrrow = explode("|", $row);
            $select = substr($arrrow[1], 5);
            $select = substr($select,0,strlen($select)-1);
            $codeto[] = substr($arrrow[1], 0, 1).'|'.substr($arrrow[1], 1, 3).'|'.$select;
        }
        
        $result['tocodes'] = implode('|',$codeto);
        $result['tocodes'] = str_replace('-', '', $result['tocodes']);
        
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    }
    
    /**
     * 竞彩足球总进球数代码转换
     * Enter description here ...
     * @param unknown_type $result
     */
	public static function trans_zjqs($result) {
		if (empty($result))
        {
            return FALSE;    
        }
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        $codeto = array();
        foreach($arrcode2 as $row)
        {
            $arrrow = explode("|", $row);
            $select = substr($arrrow[1], 5);
            $select = substr($select,0,strlen($select)-1);
            $codeto[] = substr($arrrow[1], 0, 1).'|'.substr($arrrow[1], 1, 3).'|'.$select;
        }
        
        $result['tocodes'] = implode('|',$codeto);
        
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    }
    
    /**
     * 竞彩篮球代码转换
     * Enter description here ...
     * @param unknown_type $result
     */
    public static function trans_jclq($result) {
    	if (empty($result)) {
            return FALSE;    
        }
        
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        
        $arrcode = explode(";" ,$result['codes_print']);
        $result['tocodes'] = $arrcode[0];
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    }
    
    /**
     * socket连接初始化
     * Enter description here ...
     * @param unknown_type $xcs_init
     * @param unknown_type $port
     */
    function socket_connect_init($xcs_init, $port=NULL) {
		if ($port == NULL) {
			$port = '51101';
		}
		$socket = @socket_create(AF_INET, SOCK_STREAM, 0);
		if ($socket == false) {
			//echo 'socket_create() failed: reason: '.socket_strerror(socket_last_error()).'\n';
			$this->cron_log->writeLog('socket_create() failed: reason: '.socket_strerror(socket_last_error()));
			return false;
		}
		$result = @socket_connect($socket, self::IP, $port);
		if ($result == false) {
			//echo self::IP.':'.$port.' socket_connect() failed: reason: '.socket_strerror(socket_last_error()).'\n';
			$this->cron_log->writeLog(self::IP.':'.$port.' socket_connect() failed: reason: '.socket_strerror(socket_last_error()));
			return false;
		}
    	$output = 'Pwd=aaa888';
		$output_len = pack('V', strlen($output));
		socket_write($socket,$output_len);
		socket_write($socket,$output);
		$this->cron_log->writeLog('send '.$output.' ok!');
		//echo 'send ok \n';
		$conn_h = socket_read($socket, 4);
		$conn_msg = socket_read($socket, 10);
		//echo $conn_msg;
		$this->cron_log->writeLog($conn_msg);
		if ($conn_msg == 'Accepted') {
			$xcs_init_len = pack('V', strlen($xcs_init));
			socket_write($socket, $xcs_init_len);
			socket_write($socket, $xcs_init);
			//echo 'send init ok \n';
			$this->cron_log->writeLog('send init ok!');
			$init_h = socket_read($socket, 4);
			$init_msg = socket_read($socket, 10);
			//echo 'recv init '.$init_msg.' \n';
			$this->cron_log->writeLog('recv init '.$init_msg);
			$init_msg_a = explode(' ', $init_msg);
			if ($init_msg_a[0] == 'OK' && $init_msg_a[1] == 4) {
				return $socket;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
    }
    
    /**
     * socket发出指令
     * Enter description here ...
     * @param unknown_type $socket
     * @param unknown_type $cmd
     */
    function socket_action($socket, $cmd) {
    	$xcs_hao = $cmd;
		$xcs_hao_len = pack('V', strlen($xcs_hao));
		socket_write($socket, $xcs_hao_len);
		socket_write($socket, $xcs_hao);
		//echo 'send cmd:'.$cmd.' ok \n';
		$this->cron_log->writeLog('send cmd:'.$cmd.' ok!');
		$hao_h = socket_read($socket, 4);
		//echo intval($hao_h);
		//var_dump(unpack('V', $hao_h));
		$hao_h = unpack('V', $hao_h);
		if (isset($hao_h[1])) $hao_h = $hao_h[1];
		else $hao_h = 4096;
		//var_dump($hao_h);
		$hao_msg = socket_read($socket, $hao_h);
		//var_dump($hao_msg);
		//echo $hao_msg;
		//echo 'recv '.$hao_msg.' \n';
		$this->cron_log->writeLog('recv '.$hao_msg);
		$hao_msg_a = explode(' ', $hao_msg);
		if ($hao_msg_a[0] == 'OK' && $hao_msg_a[1] == 1) {
			return true;
		}
		else {
			return false;
		}
    	/*if ($hao_msg_a[0] == 'OK' && $hao_msg_a[1] == '0') {
			return false;
		}
		else {
			return true;
		}*/
    }
	
	/**
	 * 分配竞彩打票端口
	 * Enter description here ...
	 */
	function set_jczq_port() {
		$ticket_type = self::JC_TICKET_TYPE;
		$port_array = self::get_port_num($ticket_type);
		$port_count = count($port_array);
		$this->sql->query('select id,play_method from ticket_nums where (ticket_type=1 or ticket_type=6) 
		 and status=0 and port is null order by id asc limit '.self::JC_PORT_TOTAL);
		$re = array();
		$sql_update = new SQL();
		$i = 0;
		while ($a = $this->sql->fetch_array()) {
			$tid = $a['id'];
			$t = $i % $port_count;
			$print_port = $port_array[$t];
			
			/* $play_method = $a['play_method'];
			//如果是比分直接到51101
			if ($play_method == 3) {
				$print_port = '51101';
			}
			else {
				$t = $i % $port_count;
				
				if ($t == 0) {
					$t += 1;
				}
				
				$print_port = $port_array[$t];
			} */
			
			$update_port_q = 'update ticket_nums set port="'.$print_port.'" where id="'.$tid.'"';
			$sql_update->query($update_port_q);
			if (!$sql_update->error()) { 
				echo $tid.':'.$print_port.'<br />';
				$i++;
			}
		}
	}
	
	/**
	 * 根据端口取未出票的竞彩彩票
	 * Enter description here ...
	 * @param unknown_type $port
	 */
	function get_jczq_by_port($port) {
		$ticket_type = self::JC_TICKET_TYPE;
		$port_limit = self::get_port_limit($port);
		
		$hour_limit_num = array(
			0 => 80,
			1 => 80,
			18 => 80,
			19 => 80,
			20 => 80,
			21 => 80,
			22 => 80,
			23 => 80,
		);
		$current_hour = date('G');
		if (!isset($hour_limit_num[$current_hour])) {
			$limit_num = $port_limit;
		}
		else {
			$limit_num = $hour_limit_num[$current_hour];
		}
		$this->sql->query('select id,ticket_type,codes,codes_print,rate,money,play_method from ticket_nums where (ticket_type=1 or ticket_type=6)  
		 and status=0 and port="'.$port.'" order by id asc limit '.$limit_num);
		$re = array();
		while ($a = $this->sql->fetch_array()) {
			$re[] = $a;
		}
		return $re;
	}
	
	/**
	 * 分配足彩打票端口，传统型打票机，包括数字彩
	 * Enter description here ...
	 */
	function set_zcsf_port() {
		$ticket_type = self::ZC_TICKET_TYPE;
		$port_array = self::get_port_num($ticket_type);
		$port_count = count($port_array);
		$this->sql->query('select id,ticket_type,play_method,codes from ticket_nums 
				where (ticket_type=2 or ticket_type=8 or ticket_type=9 or ticket_type=10 or ticket_type=11)  
		 and status=0 and port is null order by id asc limit '.self::ZC_PORT_TOTAL);
		$re = array();
		$sql_update = new SQL();
		$i = 0;
		while ($a = $this->sql->fetch_array()) {
			$ticket_type = $a['ticket_type'];
			$play_method = $a['play_method'];			
			$tid = $a['id'];
			$t = $i % $port_count;
			$print_port = $port_array[$t];
			$update_port_q = 'update ticket_nums set port="'.$print_port.'" where id="'.$tid.'"';
			$sql_update->query($update_port_q);
			if (!$sql_update->error()) { 
				echo $tid.':'.$print_port.'<br />';
				$i++;
			}
		}
	}
	
	/**
	 * 根据端口取未出票的足彩彩票
	 * Enter description here ...
	 * @param unknown_type $port
	 * or ticket_type=8 or ticket_type=9 or ticket_type=10
	 */
	function get_zcsf_by_port($port) {
		$ticket_type = self::ZC_TICKET_TYPE;
		$port_limit = self::get_port_limit($port);
		$query = 'select id,ticket_type,codes,codes_print,rate,money,play_method,zjstat from ticket_nums where 
		(ticket_type=2 or ticket_type=8 or ticket_type=9 or ticket_type=10 or ticket_type=11)  
		 and status=0 and port="'.$port.'" order by id asc limit '.$port_limit;
		//var_dump($query);
		$this->sql->query($query);
		$re = array();
		while ($a = $this->sql->fetch_array()) {
			$re[] = $a;
		}
		return $re;
	}

	
	/**
	 * 竞彩足球自动打票，分端口号
	 * Enter description here ...
	 */
	function auto_ticket_jczq_port($port) {
		$is2dai = true;
		if ($port == null || $port <=0) {
			return false;
		}
		$passwd = '888888';
		/* if ($is2dai == false) {
			$zhuzhu_delay = '100';//100,50
			$chupiao_check_delay = '40';//40,2
			//出票检查
			//$chupiao_check_delay = '300';
			$choose_playtype_delay = '1000';//1000,500
		}
		else {
			$zhuzhu_delay = '50';//100,50
			$chupiao_check_delay = '2';//40,2
			$choose_playtype_delay = '500';//1000,500
			//打票失败最大的等待时间
			$fail_max_wait_time = '25';
		} */
		$jczq = $this->get_jczq_by_port($port);
		$jczq_count = count($jczq);
		if ($jczq_count <= 0) return;
		//$ticket_info = array();
		//$xcs_init = 'xcs_init 1 8';
		$xcs_init = $this->get_port_initcmd($port);
		$socket_init = $this->socket_connect_init($xcs_init, $port);
		if ($socket_init == false) return ;
		$flag = 0;
		for ($i = 0; $i < $jczq_count; $i++) {
			$ticket_info = array();
			$trans_info = array();
			if ($jczq[$i]['ticket_type'] == 1) { 
				$play_type = self::$jczq_play_type[$jczq[$i]['play_method']];
			}
			elseif ($jczq[$i]['ticket_type'] == 6) {
				$play_type = self::$jclq_play_type[$jczq[$i]['play_method']];
			}
			else {
				continue;
			}
			switch ($play_type) {
				case '11':
				$trans_info = self::trans_rqspf($jczq[$i]);
				break;
				case '12':
				$trans_info = self::trans_bqc($jczq[$i]);
				break;
				case '13':
				$trans_info = self::trans_zjqs($jczq[$i]);
				break;
				case '14':
				$trans_info = self::trans_bf($jczq[$i]);
				break;
				case '21':
				$trans_info = self::trans_jclq($jczq[$i]);
				break;
				case '22':
				$trans_info = self::trans_jclq($jczq[$i]);
				break;
				case '23':
				$trans_info = self::trans_jclq($jczq[$i]);
				break;
				case '24':
				$trans_info = self::trans_jclq($jczq[$i]);
				break;
				default:
				break;
			}
			//var_dump($trans_info);die();
			if ($is2dai == false) {
				$print_line_code = 'xcs_hao';
				$zhuzhu_delay = '100';
				$chupiao_check_delay = '40';
				//出票检查
				//$chupiao_check_delay = '300';
				$choose_playtype_delay = '1000';
				$fail_max_wait_time = false;
			}
			else {
				//14比分，12半全场，23胜分差走老的
				if ($play_type == '12' || $play_type == '14' || $play_type == '23') {
					$print_line_code = 'xcs_hao';
					$zhuzhu_delay = '100';
					$chupiao_check_delay = '40';
					//出票检查
					//$chupiao_check_delay = '300';
					$choose_playtype_delay = '1000';
					$fail_max_wait_time = false;
				}
				else {
					$print_line_code = 'xcs_hao_2dai';
					$zhuzhu_delay = '100';
					$chupiao_check_delay = '2';
					$choose_playtype_delay = '500';
					//打票失败最大的等待时间
					$fail_max_wait_time = '35';
				}
			}
			$ticket_info[0] = $print_line_code;
			$ticket_info[1] = $play_type;
			$ticket_info[2] = $trans_info['rate'];
			$ticket_info[3] = $trans_info['match_num'];
			$ticket_info[4] = $trans_info['typename'];
			$ticket_info[5] = $trans_info['tocodes'];
			$ticket_info[6] = intval($trans_info['money']);
			$ticket_info[7] = $passwd;
			$ticket_info[8] = $zhuzhu_delay;
			$ticket_info[9] = $chupiao_check_delay;
			$ticket_info[10] = $choose_playtype_delay;
			if ($fail_max_wait_time != false) {
				$ticket_info[11] = $fail_max_wait_time;
			}
			$ticket_info_s = implode(' ', $ticket_info);
			//$r = $this->ticket_socket($ticket_info_s, $port);
			//echo $ticket_info_s; die();
			$r = $this->socket_action($socket_init, $ticket_info_s);
			if ($r == true) {
				$u = $this->update_ticket_status($trans_info['id'], $port);
				if ($u == true) {
					$flag++;
					//echo $trans_info['id'].' status updated \n';
					$this->cron_log->writeLog('auto_jczq_ticket_id:'.$trans_info['id'].' status updated!');
					$update_sp_r = $this->update_ticket_sp($trans_info['id'], $jczq[$i]['play_method'], $jczq[$i]['codes'], $jczq[$i]['ticket_type']);
					if ($update_sp_r == true) {
						//echo $trans_info['id'].' sp updated \n';
						$this->cron_log->writeLog('auto_jczq_ticket_id:'.$trans_info['id'].' sp updated!');
					}
				}
				else {
					//echo $trans_info['id'].' status updated failed \n';
					$this->cron_log->writeLog('auto_jczq_ticket_id:'.$trans_info['id'].' status updated failed!');
				}
			}
			else {
				//echo $ticket_info_s.' failed \n';
				$this->cron_log->writeLog('auto_jczq_ticket_id:'.$trans_info['id'].' failed!'.$ticket_info_s);
			}
			sleep(1);
			$this->cron_log->writeLog('sleep!');
		}
		if ($flag == $jczq_count) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * 传统打票机自动打票，分端口号
	 * Enter description here ...
	 */
	function auto_ticket_ct_port($port) {
		if ($port == null || $port <=0) {
			return false;
		}
		$passwd = '888888';
		$zhuzhu_delay = '40';
		$chupiao_check_delay = '20';
		$choose_playtype_delay = '500';
		$max_pass_money = '500';
		$zcsf = $this->get_zcsf_by_port($port);
		//var_dump($zcsf);
		$zcsf_count = count($zcsf);
		if ($zcsf_count <= 0) return ;
		//$xcs_init = 'xcs_init 1 3';
		$xcs_init = $this->get_port_initcmd($port);
		$socket_init = $this->socket_connect_init($xcs_init, $port);
		if ($socket_init == false) return ;
		$flag = 0;
		//最后一张
		$last_key = $zcsf_count - 1;
		//获取足彩胜负当前期期号
		$zcsf_cur_expect_num = $this->zcsf->get_current_expect_num();
		
		for ($i = 0; $i < $zcsf_count; $i++) {
			//上一张
			$pre_ticket_key = $i-1;
			//下一张
			$next_ticket_key = $i+1;
			
			//参考system/config/ticket_type，2足彩，8大乐透
			$ticket_type = $zcsf[$i]['ticket_type'];
			
			//上一张彩票的彩种
			$pre_ticket_type = false;
			if ($pre_ticket_key >= 0) {
				$pre_ticket_type = $zcsf[$pre_ticket_key]['ticket_type'];
			}
			//下一张彩票的彩种
			$next_ticket_type = false;
			if ($next_ticket_key < $zcsf_count) {
				$next_ticket_type = $zcsf[$next_ticket_key]['ticket_type'];
			}
			
			//参考system/config/ticket_type
			$ticket_play_method = $zcsf[$i]['play_method'];
			
			//上一张彩票的玩法
			$pre_ticket_play_method = false;
			if ($pre_ticket_key >= 0) {
				$pre_ticket_play_method = $zcsf[$pre_ticket_key]['play_method'];
			}
			//下一张彩票的玩法
			$next_ticket_play_method = false;
			if ($next_ticket_key < $zcsf_count) {
				$next_ticket_play_method = $zcsf[$next_ticket_key]['play_method'];
			}
			
			$ticket_code = $zcsf[$i]['codes'];
			
			//上一张彩票的代码
			$pre_ticket_code = false;
			if ($pre_ticket_key >= 0) {
				$pre_ticket_code =$zcsf[$pre_ticket_key]['codes'];
			}
			
			$ticket_code_print = $zcsf[$i]['codes_print'];
			$ticket_rate = $zcsf[$i]['rate'];
			$ticket_money = $zcsf[$i]['money'];
			$ticket_mode = false;
			$pre_ticket_mode = false;
			$ticket_info = array();
			//是否处理打票
			$is_continue = false;
			switch ($ticket_type) {
				case 2: 
					//31，32，33，34
					$play_type = self::$zcsf_play_type[$ticket_play_method];
					$code_r = explode(';', $ticket_code);
					
					$pre_code_r = explode(';', $pre_ticket_code);
					$pre_ticket_expect_num = $pre_code_r[2];
					
					//判断是否当前期
					$current_expect_num = $zcsf_cur_expect_num[$ticket_play_method];
					$ticket_expect_num = $code_r[2];
					if ($current_expect_num > 0 && $ticket_expect_num > 0 && $ticket_expect_num >= $current_expect_num) {
						//差几期
						$expect_num_m = $ticket_expect_num - $current_expect_num;
						$expect_num_m += 1;
						$next_expext = true;
					}
					
					$zhushu = 1;
					$ticket_mode = self::$zcsf_dsfs[$code_r[1]];
					if ($pre_ticket_code != false) {
						$pre_code_r = explode(';', $pre_ticket_code);
						$pre_ticket_mode = self::$zcsf_dsfs[$pre_code_r[1]];
					}
					$ticket_info[0] = 'xcs_hao_ctzc';
					$ticket_info[1] = $play_type;
					$ticket_info[2] = $ticket_rate;
					$ticket_info[3] = $zhushu;
					$ticket_info[4] = $ticket_mode;
					$ticket_info[5] = $code_r[0];
					$ticket_info[6] = intval($ticket_money);
					$ticket_info[7] = $passwd;
					$ticket_info[8] = $zhuzhu_delay;
					$ticket_info[9] = $chupiao_check_delay;
					$ticket_info[10] = $choose_playtype_delay;
					break;
				case 8: 
					$play_type = '03';
					//1追加，0不追加
					$is_zj = $zcsf[$i]['zjstat'];
					
					//复式1，单式3
					$ticket_play_method_zj = $ticket_play_method.$is_zj;
					
					//1：单式；2：复式；3：单式追加；4：复式追加
					switch ($ticket_play_method_zj) {
						case '10': $ticket_mode = '2';break;
						case '11': $ticket_mode = '4';break;
						case '30': $ticket_mode = '1';break;
						case '31': $ticket_mode = '3';break;
						case '130': $ticket_mode = '2';break;
						case '131': $ticket_mode = '4';break;
						default: break;
					}
					
					if ($pre_ticket_key >= 0) {
						$pre_is_zj = $zcsf[$pre_ticket_key]['zjstat'];
						$pre_ticket_play_method_zj = $pre_ticket_play_method.$pre_is_zj;
						switch ($pre_ticket_play_method_zj) {
							case '10': $pre_ticket_mode = '2';break;
							case '11': $pre_ticket_mode = '4';break;
							case '30': $pre_ticket_mode = '1';break;
							case '31': $pre_ticket_mode = '3';break;
							case '130': $pre_ticket_mode = '2';break;
							case '131': $pre_ticket_mode = '4';break;
							default: break;
						}
					}
					
					$zhushu = 1;
					$ticket_code_print = str_replace(' ', '', $ticket_code_print);
					$ticket_info[0] = 'xcs_hao_dlt';
					$ticket_info[1] = $play_type;
					$ticket_info[2] = $ticket_rate;
					$ticket_info[3] = $zhushu;
					$ticket_info[4] = $ticket_mode;
					$ticket_info[5] = $ticket_code_print;
					$ticket_info[6] = intval($ticket_money);
					$ticket_info[7] = $passwd;
					$ticket_info[8] = $zhuzhu_delay;
					$ticket_info[9] = $chupiao_check_delay;
					$ticket_info[10] = $choose_playtype_delay;
					$ticket_info[11] = $max_pass_money;
					break;
				case 9:
					$ticket_play_method_array = array('1'=>2,'3'=>1);
					$play_type = '0101';
					$ticket_mode = $ticket_play_method_array[$ticket_play_method];
					//1：单式；2：复式；
											
					if ($pre_ticket_key >= 0) {
						$pre_ticket_mode = $ticket_play_method_array[$pre_ticket_play_method];
					}
					$zhushu = 1;
					//$ticket_code_print = str_replace(' ', '', $ticket_code_print);
					$ticket_info[0] = 'xcs_hao_p5';
					$ticket_info[1] = $play_type;
					$ticket_info[2] = $ticket_rate;
					$ticket_info[3] = $zhushu;
					$ticket_info[4] = $ticket_mode;
					$ticket_info[5] = $ticket_code_print;
					$ticket_info[6] = intval($ticket_money);
					$ticket_info[7] = $passwd;
					$ticket_info[8] = $zhuzhu_delay;
					$ticket_info[9] = $chupiao_check_delay;
					$ticket_info[10] = $choose_playtype_delay;
					$ticket_info[11] = $max_pass_money;
					break;
				case 10:
					$ticket_play_method_array = array('1'=>2,'3'=>1);
					$play_type = '06';
					//$play_type = self::get_port_qxc_play_main($port);
					$ticket_mode = $ticket_play_method_array[$ticket_play_method];
					//1：单式；2：复式；
						
					if ($pre_ticket_key >= 0) {
						$pre_ticket_mode = $ticket_play_method_array[$pre_ticket_play_method];
					}
					$zhushu = 1;
					//$ticket_code_print = str_replace(' ', '', $ticket_code_print);
					$ticket_info[0] = 'xcs_hao_p7';
					$ticket_info[1] = $play_type;
					$ticket_info[2] = $ticket_rate;
					$ticket_info[3] = $zhushu;
					$ticket_info[4] = $ticket_mode;
					$ticket_info[5] = $ticket_code_print;
					$ticket_info[6] = intval($ticket_money);
					$ticket_info[7] = $passwd;
					$ticket_info[8] = $zhuzhu_delay;
					$ticket_info[9] = $chupiao_check_delay;
					$ticket_info[10] = $choose_playtype_delay;
					$ticket_info[11] = $max_pass_money;
					break;
				case 11:
					/**
						'1'=>'直选复式',
			    		'3'=>'直选单式',
			    		'4'=>'直选和值',
			    		'5'=>'组六复式',
			    		'6'=>'组六单式',
			    		'7'=>'组六组选和值',
			    		'8'=>'组六胆拖',
			    		'9'=>'组三复式',
			    		'10'=>'组三单式',
			    		'11'=>'组三组选和值',
			    		'12'=>'组三胆拖',
					 */
					$ticket_play_method_array = array(
						'1'=>'2',
						'3'=>'1',
						'4'=>'05',
						'5'=>'04',
						'6'=>'3',
						'7'=>'06',
						'8'=>'10',
						'9'=>'03',
						'10'=>'3',
						'11'=>'06',
						'12'=>'09',
					);
					$play_type = '01';
					$ticket_mode = $ticket_play_method_array[$ticket_play_method];
					
					if ($pre_ticket_key >= 0) {
						$pre_ticket_mode = $ticket_play_method_array[$pre_ticket_play_method];
					}
					$zhushu = 1;
					//$ticket_code_print = str_replace(' ', '', $ticket_code_print);
					$ticket_info[0] = 'xcs_hao_p3';
					$ticket_info[1] = $play_type;
					$ticket_info[2] = $ticket_rate;
					$ticket_info[3] = $zhushu;
					$ticket_info[4] = $ticket_mode;
					$ticket_info[5] = $ticket_code_print;
					$ticket_info[6] = intval($ticket_money);
					$ticket_info[7] = $passwd;
					$ticket_info[8] = $zhuzhu_delay;
					$ticket_info[9] = $chupiao_check_delay;
					$ticket_info[10] = $choose_playtype_delay;
					$ticket_info[11] = $max_pass_money;
					break;
				default: break;
			}
			
			if ($is_continue == true) {
				continue;
			}
			
			$ticket_info_s = implode(' ', $ticket_info);
			//echo $ticket_info_s;die();
			//打票前是否进入选择彩种界面
			$is_enter_main = true;
			
			//打票后是否返回彩种主界面
			$is_return_main = true;
			
			//不是第一张的情况
			if ($i > 0) {
				//上一张彩票的彩种和本次相同
				if ($pre_ticket_type == $ticket_type) {
					switch ($ticket_type) {
						case 2: 
							//判断玩法是否相同
							if ($pre_ticket_play_method == $ticket_play_method) {
								$is_enter_main = false;
								//足彩是否是下一期
								if ($pre_ticket_expect_num == $ticket_expect_num) {
									$next_expext = false;
								}
							}
							//判断上一张模式是否是复式
							if ($pre_ticket_mode != false && $pre_ticket_mode == 2) {
								//如果上一张是复式进入彩种主界面
								$is_enter_main = true;
							}
							break;
						
						case 8: 
							//上一张彩票的模式和本次相同
							if ($ticket_mode != false && $pre_ticket_mode != false && $ticket_mode == $pre_ticket_mode) {
								$is_enter_main = false;
							}
							//判断上一张模式是否是复式
							if ($pre_ticket_mode != false && ($pre_ticket_mode == 2 || $pre_ticket_mode == 4)) {
								//如果上一张是复式进入彩种主界面
								$is_enter_main = true;
							}
							break;
							
						case 9:
							//上一张彩票的模式和本次相同
							if ($ticket_mode != false && $pre_ticket_mode != false && $ticket_mode == $pre_ticket_mode) {
								$is_enter_main = false;
							}
							//判断上一张模式是否是复式
							if ($pre_ticket_mode != false && $pre_ticket_mode == 2) {
								//如果上一张是复式进入彩种主界面
								$is_enter_main = true;
							}
							break;
						
						case 10:
							//上一张彩票的模式和本次相同
							if ($ticket_mode != false && $pre_ticket_mode != false && $ticket_mode == $pre_ticket_mode) {
								$is_enter_main = false;
							}
							//判断上一张模式是否是复式
							if ($pre_ticket_mode != false && $pre_ticket_mode == 2) {
								//如果上一张是复式进入彩种主界面
								$is_enter_main = true;
							}
							break;
							
						case 11:
							//上一张彩票的模式和本次相同
							if ($ticket_mode != false && $pre_ticket_mode != false && $ticket_mode == $pre_ticket_mode) {
								$is_enter_main = false;
							}
							//判断上一张模式是否是复式
							if ($pre_ticket_mode != false && ($pre_ticket_mode == 2 || $pre_ticket_mode == '03' || 
									$pre_ticket_mode == '04' || $pre_ticket_mode == '07' || $pre_ticket_mode == '11' || 
									$pre_ticket_mode == '12' || $pre_ticket_mode == '13')) {
								//如果上一张是复式进入彩种主界面
								$is_enter_main = true;
							}
							break;
						default: break;
					}
					
				}
				//上一张彩票的彩种和本次不同
				else {
					$is_enter_main = true;
				}
			}
			
			//不是最后一张的情况
			if ($i < $last_key) {
				//下一张彩票的彩种和本次相同
				if ($next_ticket_type == $ticket_type) {
					switch ($ticket_type) {
						case 2: 
							//玩法相同不返回主界面
							if ($next_ticket_play_method == $ticket_play_method) {
								$is_return_main = false;
							}
							else {
								$is_return_main = true;
							}
							break;
						
						case 8: 
							$is_return_main = false;
							break;
						
						case 9:
							$is_return_main = false;
							break;

						case 10:
							$is_return_main = false;
							break;
							
						case 11:
							$is_return_main = false;
							break;
						default: break;
					}
				}
				else {
					$is_return_main = true;
				}
			}
			
			if ($is_enter_main == true) {
				//进入彩种选择界面
				switch ($ticket_type) {
					case 2: 
						$zcsf_play_main = self::get_port_zc_play_main($port);
						$caizhong = $this->returnCaiZhong($zcsf_play_main[$play_type]);
						//$caizhong = $this->returnCaiZhong(self::$zcsf_play_main[$play_type]);
						$this->socket_action($socket_init, $caizhong);
						//判断任9
						if ($play_type == 32) {
							$ren9 = $this->selectRen9();
							$this->socket_action($socket_init, $ren9);
						}
						break;
					
					case 8: 
						$caizhong = $this->returnCaiZhong('03', '40');
						$this->socket_action($socket_init, $caizhong);
						break;
						
					case 9:
						$caizhong = $this->returnCaiZhong('01', '40');
						$this->socket_action($socket_init, $caizhong);
						$duoqi = $this->duoqi_ct('F2', '02');
						$this->socket_action($socket_init, $duoqi);
						break;
						
					case 10:
						$cz = self::get_port_qxc_play_main($port);
						$caizhong = $this->returnCaiZhong($cz, '40');
						$this->socket_action($socket_init, $caizhong);
						break;
						
					case 11:
						$caizhong = $this->returnCaiZhong('01', '40');
						$this->socket_action($socket_init, $caizhong);
						break;
					default: break;
				}
			}
			
			//足彩是否是下一期
			if (isset($next_expext) && $next_expext === true) {
				$not_current_expect_cmd = $this->selectExpect_ct($expect_num_m);
				$this->socket_action($socket_init, $not_current_expect_cmd);
			}
			
			//判断是否复式
			switch ($ticket_type) {
				case 2: 
					if ($ticket_mode == 2) {
						$fushi = $this->selectFuShi();
						$this->socket_action($socket_init, $fushi);
						//返回主界面
						$is_return_main = true;
					}
					break;
				
				case 8: 
					//复式或复式追加的情况返回主界面
					if ($ticket_mode == 2 || $ticket_mode == 4) {
						$fushi = $this->selectFuShi();
						$this->socket_action($socket_init, $fushi);
						$is_return_main = true;
					}
					break;
				
				case 9:
					//复式的情况返回主界面
					if ($ticket_mode == 2) {
						$fushi = $this->selectFuShi();
						$this->socket_action($socket_init, $fushi);
						$is_return_main = true;
					}
					break;
				
				case 10:
					//复式的情况返回主界面
					if ($ticket_mode == 2) {
						$fushi = $this->selectFuShi();
						$this->socket_action($socket_init, $fushi);
						$is_return_main = true;
					}
					break;
					
				case 11:
					//组选
					if ($ticket_mode == '3') {
						$zuxuan = $this->selectFuShi();
						$this->socket_action($socket_init, $zuxuan);
						$is_return_main = true;
					}
					//直选复式
					if ($ticket_mode == '2') {
						$zhixuan = $this->selectFuShi();
						$this->socket_action($socket_init, $zhixuan);
						$this->socket_action($socket_init, $zhixuan);
						$is_return_main = true;
					}
					//组3复式,组6复式,直选和值,组选和值,直选组合复式,直选组合胆拖,组3胆拖,组6胆拖,直选跨度复式,组3跨度复式,组6跨度复式
					if ($ticket_mode === '03' || $ticket_mode == '04' || $ticket_mode == '05'
							|| $ticket_mode == '06' || $ticket_mode == '07' || $ticket_mode == '08'
							|| $ticket_mode == '09' || $ticket_mode == '10' || $ticket_mode == '11'
							|| $ticket_mode == '12' || $ticket_mode == '13') {
						$duoqi = $this->duoqi_ct('F2', $ticket_mode);
						$this->socket_action($socket_init, $duoqi);
						$is_return_main = true;
					}
				default: break;
			}

			$r = $this->socket_action($socket_init, $ticket_info_s);
			
			if ($is_return_main == true) {
				//返回主界面
				$main = $this->returnMain();
				$this->socket_action($socket_init, $main);
			}
			
			if ($r == true) {
				$u = $this->update_ticket_status($zcsf[$i]['id'], $port);
				if ($u == true) {
					$flag++;
					//echo $zcsf[$i]['id'].' status updated \n';
					$this->cron_log->writeLog('auto_zcsf_ticket_id:'.$zcsf[$i]['id'].' status updated!');
				}
				else {
					//echo $zcsf[$i]['id'].' status updated failed \n';
					$this->cron_log->writeLog('auto_zcsf_ticket_id:'.$zcsf[$i]['id'].' status updated failed!');
				}
			}
			else {
				//echo $ticket_info_s.' failed \n';
				$this->cron_log->writeLog('auto_zcsf_ticket_id:'.$zcsf[$i]['id'].' failed!'.$ticket_info_s);
			}
		}
		if ($flag == $zcsf_count) {
			return true;
		}
		else {
			return false;
		}
	}
	
	
	/**
	 * 发送心跳包
	 * Enter description here ...
	 */
	function heart_socket($port=NULL) {
		if ($port == NULL) {
			$port = '51101';
		}
		$socket = @socket_create(AF_INET, SOCK_STREAM, 0);
		if ($socket == false) {
			echo 'socket_create() failed: reason: '.socket_strerror(socket_last_error()).'\n';
			return false;
		}
		$result = @socket_connect($socket, self::IP, $port);
		if ($result == false) {
			echo self::IP.':'.$port.' socket_connect() failed: reason: '.socket_strerror(socket_last_error()).'\n';
			return false;
		}
		$output = 'Pwd=aaa888';
		$output_len = pack('V', strlen($output));
		socket_write($socket, $output_len);
		socket_write($socket, $output);
		echo 'send ok \n';
		$conn_h = socket_read($socket, 4);
		$conn_msg = socket_read($socket, 10);
		//echo $conn_msg;
		if ($conn_msg == 'Accepted') {
			$heart = 'ka';
			$heart_len = pack('V', strlen($heart));
			socket_write($socket, $heart_len);
			socket_write($socket, $heart);
			echo 'send ka ok \n';
		}
		else {
			echo 'passwd wrong \n';
		}
		socket_close($socket);
	}	
	
	
	/**
	 * 更新彩票状态
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	function update_ticket_status($id, $port) {
		$this->sql->query('update ticket_nums set status=1,time_print=now(),port="'.$port.'" where id="'.$id.'"');
		if (!$this->sql->error()) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * 更新彩票sp
	 * 23115|7015[0]/23107|7007[3,0];胜平负
	 * 22951|3002[2,3]/22953|3004[3,4]/22954|3005[1,2];总进球数
	 * 23121|1005[1-1,0-0]/23107|7007[3-3,1-1];半全场
	 * 23029|5010[1:0]/23033|5014[0:3]/23042|5023[0:2]/23048|5029[1:0]/23054|5035[1:2];比分
	 * Enter description here ...
	 * @param unknown_type $codes
	 */
	function update_ticket_sp($id, $play_method, $codes, $ticket_type=1) {
		$return = array();
		$code_a = explode(';', $codes);
		$code = $code_a[0];
		$match_detail = explode('/', $code);
		for ($i = 0; $i < count($match_detail); $i++) {
			$match_info = explode('|', $match_detail[$i]);
			$match_id = $match_info[0];
			preg_match_all("/\[(.*)\]/", $match_info[1], $match_result, PREG_SET_ORDER);
			$match_results = $match_result[0][1];
			$match_results_a = explode(',', $match_results);
			$match_result_sp = array();
			$select_match_query = 'select comb,goalline from match_datas where ticket_type="'.$ticket_type.'" and play_type="'.$play_method.'" and match_id="'.$match_id.'" limit 1';
			$this->sql->query($select_match_query);
			$match_data = $this->sql->fetch_array();
			$sp = $match_data['comb'];
			$goalline = $match_data['goalline'];
			//var_dump($sp);
			$play_config = array();
			if ($ticket_type == 1) {
				switch ($play_method) {
					case 1:
						$play_config = array(
							'3' => 'H',
					        '1' => 'D',
					        '0' => 'A',
						);
						break;
					case 2:
						$play_config = array(
							'0' => '0',
					        '1' => '1',
					        '2' => '2',
							'3' => '3',
							'4' => '4',
							'5' => '5',
							'6' => '6',
							'7' => '7',
						);
						break;
					case 3:
						$play_config = array(
							'负其它' => '-1:-A',
					        '胜其它' => '-1:-H',
					        '平其它' => '-1:-D',
							'0:0' => '00:00',
							'0:1' => '00:01',
							'0:2' => '00:02',
							'0:3' => '00:03',
							'0:4' => '00:04',
							'0:5' => '00:05',
							'1:0' => '01:00',
							'1:1' => '01:01',
							'1:2' => '01:02',
							'1:3' => '01:03',
							'1:4' => '01:04',
							'1:5' => '01:05',
							'2:0' => '02:00',
							'2:1' => '02:01',
							'2:2' => '02:02',
							'2:3' => '02:03',
							'2:4' => '02:04',
							'2:5' => '02:05',
							'3:0' => '03:00',
							'3:1' => '03:01',
							'3:2' => '03:02',
							'3:3' => '03:03',
							'4:0' => '04:00',
							'4:1' => '04:01',
							'4:2' => '04:02',
							'5:0' => '05:00',
							'5:1' => '05:01',
							'5:2' => '05:02',
						);
						break;
					case 4:
						$play_config = array(
							'0-0' => 'cc',
					        '0-1' => 'cb',
					        '0-3' => 'ca',
							'1-0' => 'bc',
							'1-1' => 'bb',
							'1-3' => 'ba',
							'3-0' => 'ac',
							'3-1' => 'ab',
							'3-3' => 'aa',
						);
						break;
					default: break;
				}
			}
			if ($ticket_type == 6) {
				switch ($play_method) {
					case 1:
						$play_config = array(
							'2' => 'H',
					        '1' => 'D',
						);
						break;
					case 2:
						$play_config = array(
							'2' => 'H',
					        '1' => 'D',
						);
						break;
					case 3:
						$play_config = array(
							'01' => 'u4e3bu80dc1-5',//主胜1-5
					        '02' => 'u4e3bu80dc6-10',//主胜6-10
							'03' => 'u4e3bu80dc11-15',//主胜11-15
							'04' => 'u4e3bu80dc16-20',//主胜16-20
							'05' => 'u4e3bu80dc21-25',//主胜21-25
							'06' => 'u4e3bu80dc26+',//主胜26+
					        '11' => 'u5ba2u80dc1-5',//客胜1-5
					        '12' => 'u5ba2u80dc6-10',//客胜6-10
							'13' => 'u5ba2u80dc11-15',//客胜11-15
							'14' => 'u5ba2u80dc16-20',//客胜16-20
							'15' => 'u5ba2u80dc21-25',//客胜21-25
							'16' => 'u5ba2u80dc26+',//客胜26+
						);
						break;
					case 4:
						$play_config = array(
							'1' => 'H',
					        '2' => 'D',
						);
						break;
					default: break;
				}
			}
			//$sp = '{"cc":{"c":"cc","v":"4.30","s":"1","d":"2011-09-06","t":"05:59:00"},"cb":{"c":"cb","v":"15.00","s":"1","d":"2011-09-06","t":"05:59:00"},"ca":{"c":"ca","v":"28.00","s":"1","d":"2011-09-06","t":"05:59:00"},"bc":{"c":"bc","v":"6.50","s":"1","d":"2011-09-06","t":"05:59:00"},"bb":{"c":"bb","v":"4.50","s":"1","d":"2011-09-06","t":"05:59:00"},"ba":{"c":"ba","v":"5.40","s":"1","d":"2011-09-06","t":"05:59:00"},"ac":{"c":"ac","v":"34.00","s":"1","d":"2011-09-06","t":"05:59:00"},"ab":{"c":"ab","v":"15.00","s":"1","d":"2011-09-06","t":"05:59:00"},"aa":{"c":"aa","v":"3.85","s":"1","d":"2011-09-06","t":"05:59:00"}}';
			$sp = json_decode($sp);
			$result_sp = array();
			foreach ($sp as $key => $val) {
				if (isset($val->c)) {
					
					$result_sp[$val->c] = $val->v;
				} 
				else {
					$result_sp[] = $val->v;
				}
			}
			//var_dump($result_sp);
			for ($j = 0; $j < count($match_results_a); $j++) {
				$key = $play_config[$match_results_a[$j]];
				if (array_key_exists($key, $result_sp)) {
					$match_result_sp[] = $result_sp[$key];
				}
			}
			$match_result_sp = implode(',', $match_result_sp);
			//$return[] = $match_id.':'.$match_result_sp;
			if ($ticket_type == 6 && ($play_method == 2 || $play_method == 4)) {
				if ($play_method == 2 && $goalline > 0) {
					$goalline = '+'.$goalline;
				}
				$return[] = $match_id.'('.$goalline.'):'.$match_result_sp;
			}
			else {
				$return[] = $match_id.':'.$match_result_sp;
			}
			//var_dump($return);
			//echo $i;
		}
		$return = implode('|', $return);
		//var_dump($return);
		$this->sql->query('update ticket_nums set moreinfo="'.$return.'" where id="'.$id.'"');
		if (!$this->sql->error()) {
			return true;
		}
		else {
			return false;
		}
	}
	
	function updateJczqUnSPTicket() {
		$this->sql->query('select id,ticket_type,play_method,codes from ticket_nums where ticket_type=1 and status=1 and moreinfo is NULL ');
		$re = array();
		while ($a = $this->sql->fetch_array()) {
			$re[] = $a;
		}
		for ($i = 0; $i < count($re); $i++) {
			$r = $this->update_ticket_sp($re[$i]['id'], $re[$i]['play_method'], $re[$i]['codes'], $re[$i]['ticket_type']);
			if ($r == true) {
				echo $re[$i]['id'].' sp updated <br />';
			}
		}
	}
	
	function returnMain($delay = '100') {
		//$delay = '100';
		$return = 'xcs_hao_return '.$delay;
		return $return;
	}
	
	function returnCaiZhong($cz, $delay = '100') {
		//$delay = '100';
		$return = 'xcs_hao_caizhong '.$cz.' '.$delay;
		return $return;
	}
	
	function selectFuShi($delay = '100') {
		if ($delay == '') {
			$return = 'xcs_hao_ctzc_fushi';
		}
		else {
			$delay = '100';
			$return = 'xcs_hao_ctzc_fushi '.$delay;
		}
		return $return;
	}
	
	function selectRen9() {
		$delay = '100';
		$return = 'xcs_hao_ctzc_renjiu '.$delay;
		return $return;
	}
	
	function activeMachine() {
		$delay = '100';
		$return = 'xcs_hao_jihuo '.$delay;
		return $return;
	}
	
	function selectExpect_ct($num = '2') {
		$return = 'xcs_hao_ctzc_duoqi - 300 '.$num.' 50';
		return $return;
	}
	
	function duoqi_ct($p1 = 'F2', $p2 = '02') {
		$return = 'xcs_hao_ctzc_duoqi '.$p1.' 300 '.$p2.' 50';
		return $return;
	}
}
?>