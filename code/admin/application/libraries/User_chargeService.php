<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_chargeService_Core extends My 
{
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
    protected $object_name = 'user_charge_order';

    // 获取单态实例
    public static function get_instance()
    {
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    public function __construct()
    {
        
    }
 
}
