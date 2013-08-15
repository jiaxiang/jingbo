<?php defined('SYSPATH') or die('No direct script access.');

class ticket_bjdc_log_Core {
	
	private static $instance = NULL;
	
	// 获取单态实例
    public static function get_instance() {
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
	/*
     * 添加入库
     */
    public function add($data) {
        $obj = ORM::factory('ticket_bjdc_log');
	    if (!$obj->validate($data))
	        return FALSE;
        $obj->save();
        if ($obj->saved)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
	
}
?>