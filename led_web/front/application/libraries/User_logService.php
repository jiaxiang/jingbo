<?php
defined('SYSPATH') or die('No direct script access.');

class User_logService_Core
{
	private static $instances;
	private $user_id;

	public static function &instance($user_id = 0)
	{
		if(! isset(self::$instances[$user_id]))
		{
			self::$instances[$user_id] = new self($user_id);
		}
		return self::$instances[$user_id];
	}

	private function __construct($user_id)
	{
		$this->user_id = $user_id;
	}

	public function add($type, $return = 'success')
	{
		if($user_log_type = ORM::factory('ulog_type')->where('type', $type)->find())
		{
			$user_log = ORM::factory('ulog');
			$user_log->user_id = $this->user_id;
			$user_log->type_id = $user_log_type->id;
			$user_log->method = serialize(array('url' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"], 'method' => $_SERVER['REQUEST_METHOD']));
			$user_log->return = $return;
			$user_log->ip = Input::instance()->ip_address();
			$user_log->time = time();
			$user_log->save();
		}
	}
	//TODO 根据操作返回状态执作
}