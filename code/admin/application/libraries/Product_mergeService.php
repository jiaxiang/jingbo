<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_mergeService_Core extends DefaultService_Core {
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    /* 兼容php5.2环境 End */
}