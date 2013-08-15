<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_wholesaleService_Core extends DefaultService_Core {
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
    
    protected $serv_route_instance = NULL;
    
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    /* 兼容php5.2环境 End */
    
	/**
     * 获取路由实例管理实例
     */
    private function get_serv_route_instance()
    {
        if($this->serv_route_instance === NULL){
            $this->serv_route_instance = ServRouteInstance::getInstance(ServRouteConfig::getInstance());
        }
        return $this->serv_route_instance;
    }
    
    public function cache_remove($product_id)
    {
    	$serv_route_instance = $this->get_serv_route_instance();
		$cache_instance      = $serv_route_instance->getMemInstance($this->object_name, array('id' => $product_id))->getInstance();
        $route_key           = $this->object_name . '_' . $product_id;
        $cache_instance->set($route_key, NULL);
    }
}