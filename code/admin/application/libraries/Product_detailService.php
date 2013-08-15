<?php
defined('SYSPATH') or die('No direct access allowed.');

class Product_detailService_Core extends DefaultService_Core{

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

	/**
	 * 根据id和product_id得到配置的seo全局信息模板
	 *
	 * @param int $product_id
	 * @return array
	 */
	public function get_by_product_id($product_id = 0)
	{
		$detail = ORM::factory($this->object_name)->where('product_id', $product_id)->find();
		return $detail->as_array();
	}
    
	public function set_by_product_id($product_id, $detail_data)
	{
        $detail_data['product_id'] = $product_id;
		$detail = $this->get_by_product_id($product_id);
        if($detail['id']>0)
        {
            $detail_data['id'] = $detail['id'];
            $this->update($detail_data);
        }
        else
        {
            $this->create($detail_data);
        }
		return true;
	}
    
}