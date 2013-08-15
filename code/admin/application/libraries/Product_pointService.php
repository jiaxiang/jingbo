<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_pointService_Core extends DefaultService_Core {
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
    
	public function get_point_by_product_id($product_id)
    {
    	$point = $this->query_row(array('where' => array(
			'product_id' => $product_id,
		)));
		
		if (!empty($point))
		{
			$this->set($point['id'], array(
				'point' => ++ $point['point'],
			));
			$point = $point['point'];
		} else {
			$this->create(array(
				'product_id' => $product_id,
				'point'      => 1,
			));
			$point = 1;
		}
		
		return $point;
    }
}