<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 商品搜索Service
 * 
 * @author bin
 */
class ProductsearchService_Core extends DefaultService_Core {
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
    
    //路由实例管理实例
    private $serv_route_instance = NULL;
    
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
     * 更新搜索索引
     * @param int $product_id
     * @param array $param('category_id','brand_id','title','brief','description') productsearch结构
     */
    public function update_single($product_id = 0,$param = array())
    {
    	$productsearch_struct = array();
    	
    	if($product_id < 1)
    	{
    		return false;
    	}
    	
    	if(count($param) > 0)
    	{
			$productsearch_struct['product_id']  = (!empty($param['product_id']))?$param['product_id']:'';
			$productsearch_struct['category_id'] = (!empty($param['category_id']))?$param['category_id']:'';
			$productsearch_struct['brand_id']    = (!empty($param['brand_id']))?$param['brand_id']:'';
			$productsearch_struct['title']       = (!empty($param['title']))?$param['title']:'';
			$productsearch_struct['brief']       = (!empty($param['brief']))?$param['brief']:'';
			$productsearch_struct['description'] = (!empty($param['description']))?$param['description']:'';
			
			self::add($productsearch_struct);
    	} else {
    		$product = ProductService::get_instance()->get($product_id);
    		if(is_array($product) && $product['id'] > 0)
    		{
				$productsearch_struct['product_id']  = $product['id'];
				$productsearch_struct['category_id'] = $product['category_id'];
				$productsearch_struct['brand_id']    = $product['brand_id'];
				$productsearch_struct['title']       = $product['title'];
				$productsearch_struct['brief']       = $product['brief'];
				$productsearch_struct['description'] = '';
    		    /* 获取产品描述 */
	            $query_struct = array (
	                'where' => array (
	            		'product_id' => $product['id']
	                ) 
	            );
	            
	            $productdescsection_service = ProductdescsectionService::get_instance();
	            $descsections = $productdescsection_service->query_assoc($query_struct);
	            if(!empty($descsections)){
	                foreach($descsections as $val){
	                	$productsearch_struct['description'] .= ' ' . $val['content'];
	                }
	            }
	            $productsearch = $this->get_by_product_id($product_id);
	            if(!empty($productsearch) && $productsearch['id'] > 0)
	            {
	            	self::set($productsearch['id'],$productsearch_struct);
	            } else {
	            	self::add($productsearch_struct);
	            }
    		}
    	}
    }
    
	/**
	 * 添加单条到产品搜索索引表 
	 * @param int $product_id 产品ID
	 * @param array $param('site_id','category_id','brand_id','title','brief','description') productsearch结构
	 * @return boolean
	 */
    public function add_single($product_id = 0,$param = array())
    {
    	$productsearch_struct = array();
    	
    	if($product_id < 1)
    	{
    		return false;
    	}
    	if(count($param) > 0)
    	{
			$productsearch_struct['product_id']  = (!empty($param['product_id']))?$param['product_id']:'';
			$productsearch_struct['category_id'] = (!empty($param['category_id']))?$param['category_id']:'';
			$productsearch_struct['brand_id']    = (!empty($param['brand_id']))?$param['brand_id']:'';
			$productsearch_struct['title']       = (!empty($param['title']))?$param['title']:'';
			$productsearch_struct['brief']       = (!empty($param['brief']))?$param['brief']:'';
			$productsearch_struct['description'] = (!empty($param['description']))?$param['description']:'';
			
			self::add($productsearch_struct);
    	} else {
    		$product = ProductService::get_instance()->get($product_id);
    		if(is_array($product) && $product['id'] > 0)
    		{
				$productsearch_struct['product_id']  = $product['id'];
				$productsearch_struct['category_id'] = $product['category_id'];
				$productsearch_struct['brand_id']    = $product['brand_id'];
				$productsearch_struct['title']       = $product['title'];
				$productsearch_struct['brief']       = $product['brief'];
				$productsearch_struct['description'] = '';
    		    /* 获取产品描述 */
	            $query_struct = array (
	                'where' => array (
	            		'product_id' => $product['id']
	                ) 
	            );
	            
	            $productdescsection_service = ProductdescsectionService::get_instance();
	            $descsections = $productdescsection_service->query_assoc($query_struct);
	            if(!empty($descsections)){
	                foreach($descsections as $val){
	                	$productsearch_struct['description'] .= ' ' . $val['content'];
	                }
	            }
	            
	            self::add($productsearch_struct);
    		}
    	}
    }
    
    public function set_single($param)
    {
    	/*
    	static $attributes = array();
    	if (!empty($param['attributes']))
    	{
    		$aids = array();
    		foreach ($param['attributes'] as $aid => $oids)
    		{
    			if (!isset($attributes[$aid]))
    			{
    				$aids[] = $aid;
    			}
    		}
    		
    		if (!empty($aids))
    		{
	    		$records = AttributeService::get_instance()->get_attribute_options(array('where' => array(
	    			'id' => $aids,
	    		)));
	    		foreach ($records as $record)
	    		{
	    			$attributes[$record['id']] = $record;
	    		}
    		}
    		
    		foreach ($param['attributes'] as $aid => $oids)
    		{
    			if (isset($attributes[$aid]))
    			{
    				$options = $attributes[$aid]['options'];
    				foreach ($oids as $oid)
    				{
    					if (isset($options[$oid]))
    					{
    						$param['title'] .= ' '.$options[$oid]['name'];
    					}
    				}
    			}
    		}
    	}
    	if (!empty($param['features']))
    	{
    		// TODO 标题中加入特性值
    	}
    	*/
    	
    	$search = ProductsearchService::get_instance()->query_row(array('where'=>array(
    		'product_id' => $param['product_id'],
    	)));
    	if (empty($search))
    	{
    		ProductsearchService::get_instance()->create($param);
    	} else {
    		ProductsearchService::get_instance()->set($search['id'], $param);
    	}
    }
    
    /**
     * 根据商品搜索ID删除搜索内容
     * @param int $id
     * @return throw
     */
    public function delete_by_productsearch_id($id)
    {
        try{
            $this->remove($id);
        }catch(MyRuntimeException $ex){
            throw $ex;
        }
    }

    /**
     * 根据商品ID删除搜索内容
     * @param int $id
     * @return throw
     */
    public function delete_by_product_id($product_id)
    {
		$productsearch = ORM::factory('productsearch')
			->where('product_id', $product_id)
			->delete_all();
		return $productsearch;
    }

	/**
	 * 根据商品ID得到端口搜索详情
	 * @param int $product_id
	 * @return array
	 */
    public function get_by_product_id($product_id)
    {
    	$productsearch = ORM::factory('productsearch')->where(array('product_id'=>$product_id))->find();
    	return $productsearch->as_array();
    }
}
