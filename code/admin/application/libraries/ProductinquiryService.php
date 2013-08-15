<?php defined('SYSPATH') OR die('No direct access allowed.');

class ProductinquiryService_Core extends DefaultService_Core {
	CONST DEFAULT_POSITION = 0;
	CONST SHOW_NOTIN_FRONT = 0;
	CONST SHOW_IN_FRONT = 1;
	protected $serv_route_instance = NULL;
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
    // 获取单态实例
    public static function get_instance()
    {
        if(self::$instance === null)
        {
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
     /**
	 * 根据id修改指定的咨询
	 * 
	 * @param  int $id
	 * @param  array $data
	 * @return 
	 */
	public function set($id, $data)
	{
        $request_data = $data;
        $request_data['id'] = $id;
        $inquiry = $this->get($request_data['id']);
        if(!isset($inquiry) || empty($inquiry))
        {
        	die('error');
        }
        $this->update($request_data);
        
        $servRouteInstance = $this->get_serv_route_instance();
        $cacheInstance = $servRouteInstance->getMemInstance($this->object_name,array('product_id'=>$inquiry['product_id']))->getInstance();
        $routeKey = $this->object_name.'_'.$inquiry['product_id'];
        // 清理单体cache
        $cacheInstance->delete($routeKey,0);
    }
    
    /**
	 * 根据删除指定的咨询
	 * 
	 * @param  int $id
	 * @return boolean
	 */
	public function delete_by_id($id)
	{
		$inquiry = $this->get($id);
		if(!isset($inquiry) || empty($inquiry))
        {
        	die('error');
        }
        $this->remove($inquiry['id']);
		$servRouteInstance = $this->get_serv_route_instance();
        $cacheInstance = $servRouteInstance->getMemInstance($this->object_name,array('product_id'=>$inquiry['product_id']))->getInstance();
        $routeKey = $this->object_name.'_'.$inquiry['product_id'];
        // 清理单体cache
        $cacheInstance->delete($routeKey,0);
		return TRUE;
	}
}