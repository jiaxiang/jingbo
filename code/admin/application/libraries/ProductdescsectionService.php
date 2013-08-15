<?php defined('SYSPATH') OR die('No direct access allowed.');

class ProductdescsectionService_Core extends DefaultService_Core {
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
    
    const DESC_SECTION_POSITION_DEFAULT = 0;
	public function get_desc_list_by_product_id($product_id,$site_id=0){
        $query_struct = array(
            'where'=>array(
                'product_id'=>$product_id,
            ),
            'orderby'=>array(
                'position' => 'ASC',
            ),
        );
        !empty($site_id) && $query_struct['where']['site_id'] = $site_id;
        return $this->index($query_struct);
	}
	
	public function get_desc_list_by_product_id_count($product_id,$site_id=0){
        $query_struct = array(
            'where'=>array(
                'product_id'=>$product_id,
            ),
            'orderby'=>array(
                'position' => 'ASC',
            ),
        );
        !empty($site_id) && $query_struct['where']['site_id'] = $site_id;
        return $this->count($query_struct);
	}
	
    /**
     * 删除商品描述
     * @param int $productdescsec_id
     * @param int $product_id
     * @param int $site_id
     */
    public function delete_productdescsec($productdescsec_id,$product_id,$site_id){
        $this->remove($productdescsec_id);
    }
    
	/**
	 * 通过 product.id 获取该 product 所派生的 good
	 * 
	 * @param  int $product_id  商品ID
	 * @return array
	 * @throws MyRuntimeException
	 */
	public function get_sections_by_product_id($product_id)
	{
		// 初始化默认查询条件
        $request_struct = array(
            'where'		=> array(
                'product_id' => (int)$product_id,
			),
        );
        
        try {
        	return $this->query_assoc($request_struct);
        } catch (MyRuntimeException $ex) {
        	throw $ex;
        }
	}
	
	public function get_default_by_product_id($product_id)
	{
		$query_struct = array(
			'where' => array(
				'product_id' => $product_id,
			),
			'orderby' => array(
				'position' => 'ASC',
			),
		);
		try
		{
			return $this->query_row($query_struct);
		} catch (MyRuntimeException $ex) {
			throw $ex;
		}
	}
}