<?php defined('SYSPATH') or die('No direct access allowed.');

class Product_rushService_Core extends DefaultService_Core {
    protected $serv_route_instance = NULL;
    /* 兼容php5.2环境 Start */
    private static $instance = NULL;
    // 获取单态实例
    public static function get_instance()
    {
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    /* 兼容php5.2环境 End */
     
    public function set($id, $data)
    {
        $request_data = $data;
        $request_data['id'] = $id;
        $this->update($request_data); 
    }
    
    public function remove($id)
    {
        $this->delete(array (
            'id' => $id 
        ));
    }
    
}