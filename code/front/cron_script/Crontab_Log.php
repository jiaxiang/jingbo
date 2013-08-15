<?php

class Crontab_Log {
	
	const LOG_PATH = '/usr/local/cp/front/cron_script/log/';
	//const LOG_PATH = 'C:\code\jingbo365\trunk\code\front\cron_script\log';
	private $log_enable = true;
	
	function __construct($enable = true) {
		if ($enable == false) {
			$this->log_enable = false;
		}
	}
	
	function writeLog($content) {
		if ($this->log_enable == false) {
			return false;
		}
		$filename = 'log_'.date('Y-m-d').'.log';
		$data = '['.date('Y-m-d H:i:s').'] : '.$content."\n";
		//$filename = '\log_'.date('Y-m-d').'.log';
		$log_filename = self::LOG_PATH.$filename;
		if (file_exists($log_filename)) {
			$s = file_get_contents($log_filename);
			$data = $data.$s;
		}
		$r = file_put_contents($log_filename, $data);
		if ($r == false) {
			return false;
		}
		return true;
	}
}
?>