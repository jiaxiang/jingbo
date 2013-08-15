<?php
	class JSPL {
		const YP_TABLE = 'odd_yps';
		const OP_TABLE = 'odd_ops';
		const DX_TABLE = 'odd_dxes';
		const ODD_TXT = 'http://vip.bet007.com/xmlvbs/odds.txt';
		const ODD_XML = 'http://vip.bet007.com/xmlvbs/ch_odds.xml';
		//const TXT_PATH = '/usr/local/cp/front/media/js/jsbf_data.js';
		const TXT_PATH = 'C:\code\caipiao2\code\front\odds.txt';
		
		private $sql;
		private $cron_log;
		public $odd_txt_content;
		
		function __construct() {
			require_once 'SQL.php';
			$this->sql = new SQL();
			//require_once 'Crontab_Log.php';
			//$this->cron_log = new Crontab_Log(false);
			//$this->odd_txt_content = $this->get_odd_txt();
		}
		
		/**
		 * 通过接口获取赔率文件
		 * Enter description here ...
		 */
		function get_odd_txt() {
			$c = file_get_contents(self::ODD_TXT);
			if ($c == false) return false;
			file_put_contents(self::TXT_PATH, $c);
			$c = file_get_contents(self::TXT_PATH);
			if ($c == false) return false;
			return $c;
		}
		
		/**
		 * 获取赔率文件内容
		 * Enter description here ...
		 */
		function get_odd_txt_content() {
			return $this->odd_txt_content;
		}
		
		/**
		 * 获取亚盘赔率数据
		 * Enter description here ...
		 */
		function get_odd_yp() {
			$content = $this->get_odd_txt_content();
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
					$replace_query_arr[] = '("'.$t[0].'","'.$t[1].'","'.$t[2].'","'.$t[3].'","'.$t[4].'","'.$t[5].'","'.$t[6].'","'.$t[7].'","'.$t[8].'","'.$t[9].'")';
				}
				$replace_query_data_count = count($replace_query_arr);
				$maxlng = 500;
				if ($replace_query_data_count > 0) {
					if ($replace_query_data_count > $maxlng) {
						$replace_query_arr_t = array_chunk($replace_query_arr, $maxlng);
						for ($i = 0; $i < count($replace_query_arr_t); $i++) {
							$replace_query = 'replace into '.self::YP_TABLE.' (match_id,company_id,first_pk,home_first_sp,away_first_sp,js_pk,home_js_sp,away_js_sp,is_fp,is_zd) values '.implode(',', $replace_query_arr_t[$i]);
							$this->sql->query($replace_query);
							if (!$this->sql->error()) {
								echo $i.'succ<br />';
							}
						}
					}
					else {
						$replace_query = 'replace into '.self::YP_TABLE.' (match_id,company_id,first_pk,home_first_sp,away_first_sp,js_pk,home_js_sp,away_js_sp,is_fp,is_zd) values '.implode(',', $replace_query_arr);
						$this->sql->query($replace_query);
						if (!$this->sql->error()) {
							echo 'succ<br />';
						}
					}
				}
			}
		}
		
		/**
		 * 获取欧赔赔率数据
		 * Enter description here ...
		 */
		function get_odd_op() {
			$content = $this->get_odd_txt_content();
			if ($content != false) {
				$content_arr = explode('$', $content);
				$op_content = $content_arr[3];
				$op_content_arr = explode(';', $op_content);
				$replace_query_arr = array();
				for ($i = 0; $i < count($op_content_arr); $i++) {
					$t = explode(',', $op_content_arr[$i]);
					$replace_query_arr[] = '("'.$t[0].'","'.$t[1].'","'.$t[2].'","'.$t[3].'","'.$t[4].'","'.$t[5].'","'.$t[6].'","'.$t[7].'")';
				}
				$replace_query_data_count = count($replace_query_arr);
				$maxlng = 500;
				if ($replace_query_data_count > 0) {
					if ($replace_query_data_count > $maxlng) {
						$replace_query_arr_t = array_chunk($replace_query_arr, $maxlng);
						for ($i = 0; $i < count($replace_query_arr_t); $i++) {
							$replace_query = 'replace into '.self::OP_TABLE.' (match_id,company_id,first_home3_sp,first_home1_sp,first_home0_sp,js_home3_sp,js_home1_sp,js_home0_sp) values '.implode(',', $replace_query_arr_t[$i]);
							$this->sql->query($replace_query);
							if (!$this->sql->error()) {
								echo $i.'succ<br />';
							}
						}
					}
					else {
						$replace_query = 'replace into '.self::OP_TABLE.' (match_id,company_id,first_home3_sp,first_home1_sp,first_home0_sp,js_home3_sp,js_home1_sp,js_home0_sp) values '.implode(',', $replace_query_arr);
						$this->sql->query($replace_query);
						if (!$this->sql->error()) {
							echo 'succ<br />';
						}
					}
				}
			}
		}
		
		/**
		 * 获取大小球赔率数据
		 * Enter description here ...
		 */
		function get_odd_dx() {
			$content = $this->get_odd_txt_content();
			if ($content != false) {
				$content_arr = explode('$', $content);
				$dx_content = $content_arr[4];
				$dx_content_arr = explode(';', $dx_content);
				$replace_query_arr = array();
				for ($i = 0; $i < count($dx_content_arr); $i++) {
					$t = explode(',', $dx_content_arr[$i]);
					$replace_query_arr[] = '("'.$t[0].'","'.$t[1].'","'.$t[2].'","'.$t[3].'","'.$t[4].'","'.$t[5].'","'.$t[6].'","'.$t[7].'")';
				}
				$replace_query_data_count = count($replace_query_arr);
				$maxlng = 500;
				if ($replace_query_data_count > 0) {
					if ($replace_query_data_count > $maxlng) {
						$replace_query_arr_t = array_chunk($replace_query_arr, $maxlng);
						for ($i = 0; $i < count($replace_query_arr_t); $i++) {
							$replace_query = 'replace into '.self::DX_TABLE.' (match_id,company_id,first_pk,first_d_sp,first_x_sp,js_pk,js_d_sp,js_x_sp) values '.implode(',', $replace_query_arr_t[$i]);
							$this->sql->query($replace_query);
							if (!$this->sql->error()) {
								echo $i.'succ<br />';
							}
						}
					}
					else {
						$replace_query = 'replace into '.self::DX_TABLE.' (match_id,company_id,first_pk,first_d_sp,first_x_sp,js_pk,js_d_sp,js_x_sp) values '.implode(',', $replace_query_arr);
						$this->sql->query($replace_query);
						if (!$this->sql->error()) {
							echo 'succ<br />';
						}
					}
				}
			}
		}
		
		/**
		 * 即时更新赔率
		 * Enter description here ...
		 */
		function update_odd() {
			$doc = new DOMDocument();
			$r = $doc->load(self::ODD_XML);
			if ($r != false) {
				$cs = $doc->getElementsByTagName('c');
				foreach ($cs as $c) {
					//亚盘
					$yps = $c->getElementsByTagName('a')->item(0);
					$hs = $yps->getElementsByTagName('h');
					$yp_content_arr = array();
					$replace_query_arr = array();
					foreach ($hs as $h) {
						$h_v = $h->nodeValue;
						$yp_content_arr[] = $h_v;
					}
					for ($i = 0; $i < count($yp_content_arr); $i++) {
						$t = explode(',', $yp_content_arr[$i]);
						if ($t[5] == 'True') $t[5] = 1;
						else $t[5] = 0;
						if ($t[6] == 'True') $t[6] = 1;
						else $t[6] = 0;
						$replace_query_arr[] = '("'.$t[0].'","'.$t[1].'","'.$t[2].'","'.$t[3].'","'.$t[4].'","'.$t[5].'","'.$t[6].'")';
					}
					$replace_query = 'replace into '.self::YP_TABLE.' (match_id,company_id,js_pk,home_js_sp,away_js_sp,is_fp,is_zd) values '.implode(',', $replace_query_arr);
					$this->sql->query($replace_query);
					if (!$this->sql->error()) {
						echo 'yp succ<br />';
					}
					
					//欧赔
					$ops = $c->getElementsByTagName('o')->item(0);
					$hs = $ops->getElementsByTagName('h');
					$op_content_arr = array();
					$replace_query_arr = array();
					foreach ($hs as $h) {
						$h_v = $h->nodeValue;
						$op_content_arr[] = $h_v;
					}
					for ($i = 0; $i < count($op_content_arr); $i++) {
						$t = explode(',', $op_content_arr[$i]);
						$replace_query_arr[] = '("'.$t[0].'","'.$t[1].'","'.$t[2].'","'.$t[3].'","'.$t[4].'")';
					}
					$replace_query = 'replace into '.self::OP_TABLE.' (match_id,company_id,js_home3_sp,js_home1_sp,js_home0_sp) values '.implode(',', $replace_query_arr);
					$this->sql->query($replace_query);
					if (!$this->sql->error()) {
						echo 'op succ<br />';
					}
					
					//大小球
					$dxs = $c->getElementsByTagName('d')->item(0);
					$hs = $dxs->getElementsByTagName('h');
					$dx_content_arr = array();
					$replace_query_arr = array();
					foreach ($hs as $h) {
						$h_v = $h->nodeValue;
						$dx_content_arr[] = $h_v;
					}
					for ($i = 0; $i < count($dx_content_arr); $i++) {
						$t = explode(',', $dx_content_arr[$i]);
						$replace_query_arr[] = '("'.$t[0].'","'.$t[1].'","'.$t[2].'","'.$t[3].'","'.$t[4].'")';
					}
					$replace_query = 'replace into '.self::DX_TABLE.' (match_id,company_id,js_pk,js_d_sp,js_x_sp) values '.implode(',', $replace_query_arr);
					$this->sql->query($replace_query);
					if (!$this->sql->error()) {
						echo 'dx succ<br />';
					}
				}
				
			}
		}
	}
?>