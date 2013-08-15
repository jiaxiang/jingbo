<?php defined('SYSPATH') OR die('No direct access allowed.');

class ProductcommentService_Core extends DefaultService_Core {
	const COMMENT_NOT_EXAMINE   = 0;
	const COMMENT_EXAMINE_TRUE  = 1;
	const COMMENT_EXAMINE_FALSE = 2;
	
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