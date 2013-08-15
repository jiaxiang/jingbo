<?php defined('SYSPATH') or die('No direct script access.');

class UlogService_Core extends DefaultService_Core 
{
    private static $instance = NULL;

    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }

	public function add($user_id, $type, $return = 'success')
	{
	    $user_id = intval($user_id);
	    if ($user_id <= 0)
	        return FALSE;
	    
		if($user_log_type = ORM::factory('ulog_type')->where('type', $type)->find())
		{
			$user_log = ORM::factory('ulog');
			$user_log->user_id = $user_id;
			$user_log->type_id = $user_log_type->id;
			$user_log->method = serialize(array('url' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"], 'method' => $_SERVER['REQUEST_METHOD']));
			$user_log->return = $return;
			$user_log->ip = Input::instance()->ip_address();
			$user_log->time = time();
			$user_log->save();
		}
	}
}




