<?php
class Superplaners {
	
	private $sql;
	private $cron_log;
	
	function __construct() {
		require_once 'SQL.php';
		$this->sql = new SQL();
		require_once 'Crontab_Log.php';
		$this->cron_log = new Crontab_Log();
	}
	
	function set_plan_agstate() {
		$query = 'select user_id from superplaners where flag=2';
		$this->sql->query($query);
		$superplaner_userid = array();
		while ($a = $this->sql->fetch_array()) {
			$superplaner_userid[] = $a['user_id'];
		}
		//var_dump($superplaner_userid);die();
		$mklasttime = mktime(date("H")-1, date("i"), date("s"), date("m"), date("d"), date("Y"));
		$last_time = date('Y-m-d H:i:s', $mklasttime);
		//$query = 'select id,plan_type,start_user_id,status from plans_basics where agmretstatus=3 and agrretstatus=3 and date_end>="'.$last_time.'"';
		$query = 'select id,plan_type,start_user_id,status from plans_basics where agmretstatus=3 and agrretstatus=3 ';
		$this->sql->query($query);
		//var_dump($query);
		$s0_bid = array();
		while ($a = $this->sql->fetch_array()) {
			$basic_id = $a['id'];
			$plan_type = $a['plan_type'];
			$userid = $a['start_user_id'];
			$status = $a['status'];
			if ($plan_type == 0 || in_array($userid, $superplaner_userid) == false || $status == 6) {
				$s0_bid[] = $basic_id;
			}
		}
		//var_dump($s0_bid);die();
		$s0_bid_count = count($s0_bid);
		if ($s0_bid_count > 0) {
			$query = 'update plans_basics set agmretstatus=0, agrretstatus=0 where id in ('.implode(',', $s0_bid).')';
			$this->sql->query($query);
			if (!$this->sql->error()) {
				echo $s0_bid_count.' plans set';
			}
		}
		else {
			echo '0';
		}
	}
}
?>