<?php defined('SYSPATH') OR die('No direct access allowed.');

class Product_bind_goodService_Core extends DefaultService_Core{
	
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
    
    /**
     * 根据商品的ID获取和该商品绑定的货品
     *
     * @param int $product_id
     * @param int $site_id
     * @return array
     */
    public function get_goods_by_product_id($product_id, $site_id){
    	$query_struct = array(
    		'where' => array('product_id' => $product_id, 'site_id' => $site_id),
    	);
    	$rows = $this->query_assoc($query_struct);
    	return $rows;
    }
    
    /**
     * 判断货品和商品是否存在绑定关系
     *
     * @param int $site_id
     * @param int $product_id
     * @param int $goods_id
     * @return bool
     */
    public function good_product_has_ralation($site_id, $product_id, $goods_id){
    	$query_struct = array(
    		'where' => array('product_id' => $product_id, 'site_id' => $site_id, 'goods_id' => $goods_id),
    	);
    	$rows = $this->query_assoc($query_struct);
    	if (empty($rows)) {
    		return 0;
    	}else {
    		return 1;
    	}
    }
}