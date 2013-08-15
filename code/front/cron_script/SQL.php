<?php
	class SQL {

		private $resultHandler = null;
		private $result = null;
		private $db = 'caipiao';
		private $connectServer = '';
		
		private $table_location = array(
			
		);

		private $server = array(
			1=>'127.0.0.1'
		);

		private $server_info = array(
			'127.0.0.1'=>array('root','111111')
		);
				
		function __construct($tablename = '', $keyfield = 0) {
			self::connect($tablename, $keyfield);
		}
		
		function connect($tablename = '',$keyfield = 0) {
			if (!isset($this->table_location[$tablename])) {
				$server = 1;
			}
			else {
				$server = $this->table_location[$tablename];
			}
			$this->connectServer = $this->server[$server];
			global $MySQL_Connection_Handle;
			if (!isset($MySQL_Connection_Handle[$this->connectServer])) {
				$MySQL_Connection_Handle[$this->connectServer]=@mysql_connect($this->connectServer,$this->server_info[$this->connectServer][0],$this->server_info[$this->connectServer][1]) or die ("fails");
				//mysql_query('set character_set_client=binary',$MySQL_Connection_Handle[$this->connectServer]);
				mysql_query('set character_set_connection=utf8, character_set_results=utf8, character_set_client=binary',$MySQL_Connection_Handle[$this->connectServer]);
				mysql_select_db($this->db, $MySQL_Connection_Handle[$this->connectServer]);
			}
			
		}

		function query($query) {
			//global $DEBUG_MODE,$Queries_P,$init;
			global $MySQL_Connection_Handle;
			/*if (!isset($Queries_P)) {
				$Queries_P = 0;
			}*/
			$this->resultHandler = mysql_query($query,$MySQL_Connection_Handle[$this->connectServer]);
			/*if ((isset($DEBUG_MODE) && $DEBUG_MODE == 1) || (isset($_SESSION["USERID"]) && in_array($_SESSION["USERID"],$init['debug_userid']))) {
				global $Queries;
				global $PAGE_time_start;
				if (!isset($Queries)) {
					$Queries=array();
				}
				$Queries[$Queries_P][0] = $this->connectServer.': '.$query;
				$Queries[$Queries_P][1] = self::error();
				$Queries[$Queries_P][2] = getmicrotime() - $PAGE_time_start;
			}
			$Queries_P++;*/
			return $this->resultHandler;
		}

		function fetch_array($both = 0) {
			if ($this->resultHandler) {
				if ($both == 0) {
					$this->result = @mysql_fetch_assoc($this->resultHandler);
				}
				else {
					$this->result = @mysql_fetch_array($this->resultHandler);
				}
				return $this->result;
			} else return false;
		}

		
		function fetch_all() {
			if (!$this->resultHandler) {
				return false;
			}
			$arr_ret = array();
			while(($arr_row = mysql_fetch_assoc($this->resultHandler))) {
				$arr_ret[] = $arr_row;
			}
			return $arr_ret;
		}

		function num_rows() {
			if ($this->resultHandler === null || $this->resultHandler === false) {
				return 0;
			}
			return mysql_num_rows($this->resultHandler);
		}

		function affected_rows() {
			global $MySQL_Connection_Handle;
			return mysql_affected_rows($MySQL_Connection_Handle[$this->connectServer]);
		}

		function insert_id() {
			global $MySQL_Connection_Handle;
			return mysql_insert_id($MySQL_Connection_Handle[$this->connectServer]);
		}

		function error() {
			global $MySQL_Connection_Handle;
			return mysql_error($MySQL_Connection_Handle[$this->connectServer]);
		}

		function __get($var) {
			 if ($this->result[$var]) {
				 return $this->result[$var];
			 }
			 else {
				 return null;
			 }
		}
	}

?>
