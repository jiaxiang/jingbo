<?php
class Clean {
	
	private $sql;
	
	function __construct() {
		require_once 'SQL.php';
		$this->sql = new SQL();
	}
	
	function showTables($db) {
		$this->sql->query('show tables from '.$db);
		$re = array();
		while ($a = $this->sql->fetch_array()) {
			$re[] = $a['Tables_in_'.$db];
		}
		return $re;
	}
	
	/**
	 * 优化表
	 * Enter description here ...
	 * @param unknown_type $db
	 */
	function optimizeTables($db) {
		$tables = $this->showTables($db);
		for ($i = 0; $i < count($tables); $i++) {
			$op_query = 'OPTIMIZE TABLE '.$db.'.`'.$tables[$i].'`';
			$this->sql->query($op_query);
			if (!$this->sql->error()) {
				echo $op_query.' queryed <br />';
			}
			else {
				echo $op_query.' error <br />';
			}
		}
	}
	
	/**
	 * 清理信息
	 * Enter description here ...
	 * @param unknown_type $db
	 */
	function clean_info($db) {
		$today_date = date('Y-m-d');
		$return = array(
			'caipiao' => array(
				'ag_settle_logs' => 'to_days(now())-to_days(date_add)>30',
				'lotty_jobs' => 'to_days(now())-to_days(ctime)>30',
				'jsbf_datas' => 'to_days(now())-to_days(match_time)>30',
				'jsbf_event_datas' => 'to_days(now())-to_days(time)>7',
				'mail_logs' => 'to_days(now())-to_days(add_time)>30',
				//'match_bjdc_datas' => 'to_days(now())-to_days(stoptime)>30 and code is not null',
				//'match_bjdc_issues' => 'to_days(now())-to_days(stop)>30',
				//'match_datas' => 'to_days(now())-to_days(update_time)>30',
				//'match_details' => 'to_days(now())-to_days(time)>30',
				//SELECT * FROM `users` where active=0 and mobile is null and real_name is null and identity_card is null and is_auth=1 and to_days(now())-to_days(login_time)>30				
				'ulogs' => 'to_days(now())-to_days(FROM_UNIXTIME(time))>30',
				'user_charge_orders' => '(status=0 and to_days(now())-to_days(add_time)>2) or (to_days(now())-to_days(add_time)>30)',
				'user_logs' => 'to_days(now())-to_days(add_time)>30',
				//'zcsf_expects' => 'to_days(now())-to_days(open_time)>30 and cai_result != ""',
			),
			'caipiao_bbs' => array(
			),
		);
		if (isset($return[$db]) && is_array($return[$db])) {
			return $return[$db];
		}
		else {
			return false;
		}
	}
	
	/**
	 * 清理表数据
	 * Enter description here ...
	 * @param unknown_type $db
	 */
	function cleanTables($db) {
		$tables = $this->showTables($db);
		$clean_tables_info = $this->clean_info($db);
		if (is_array($clean_tables_info) && count($clean_tables_info) > 0) {
			foreach ($clean_tables_info as $key => $val) {
				if (in_array($key, $tables) && $val != '') {
					$clean_query = 'delete from '.$db.'.`'.$key.'` where '.$val;
					$this->sql->query($clean_query);
					if (!$this->sql->error()) {
						echo $clean_query.' queryed '.$this->sql->affected_rows().' del<br />';
					}
					else {
						echo $clean_query.' error <br />';
					}
				}
			}
		}
	}
}