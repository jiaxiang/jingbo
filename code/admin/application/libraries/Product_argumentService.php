<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_argumentService_Core extends DefaultService_Core {
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
    
    /*
    public function get_arguments_by_product_id($product_id)
    {
    	$query_struct = array('where' => array(
    		'product_id' => $product_id,
    	));
    	$arguments = $this->query_row($query_struct);
    	if (!empty($arguments) AND !empty($arguments['arguments']))
    	{
    		return json_decode($arguments['arguments'], TRUE);
    	} else {
    		return array();
    	}
    }
    */
}