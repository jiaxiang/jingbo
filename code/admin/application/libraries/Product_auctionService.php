<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 商品竞拍管理 Service
 */
class Product_auctionService_Core extends DefaultService_Core {
	const PRODUCT_STATUS_DELETE  = 1;  // 删除
	const PRODUCT_STATUS_PUBLISH = 0;  // 正常
	
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
