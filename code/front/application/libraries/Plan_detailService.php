<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plan_detailService_Core extends DefaultService_Core {
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
     * 根据产品ID获取批发数据
     * 
     * @param $product_id  产品ID
     * @return array
     */
    public function get($product_id)
    {	
    	if (Mysite::instance()->get('wholesale') == 0 OR Mysite::instance()->get('is_wholesale') == 0)
    	{
    		return array();
    	}
    	
        $wholesales = Cache::get('product_wholesales.'.$product_id);
        if (!$wholesales AND !is_array($wholesales)) {
        	$wholesales = $this->query_assoc(array(
        		'where' => array(
        			'product_id' => $product_id,
        		),
        		'orderby' => array(
        			'num_begin' => 'ASC',
        		),
        	));
        	if (!empty($wholesales)) {
        		foreach ($wholesales as $key => $wholesale) {
        			unset($wholesale['id']);
        			unset($wholesale['product_id']);
        			$wholesales[$key] = $wholesale;
        		}
        	}
        	
        	Cache::set('product_wholesales.'.$product_id, $wholesales);
        }
        
        // 计算币种价格
        /*
        if (!empty($wholesales))
        {
        	foreach ($wholesales as $index => $wholesale)
        	{
        		if ($wholesale['type'] == 1 OR $wholesale['type'] == 2)
        		{
        			$wholesale['value'] = BLL_Currency::get_price($wholesale['value']);
        			
        			$wholesales[$index] = $wholesale;
        		}
        	}
        }
        */
        
        return $wholesales;
    }
    
    
    /**
     * author zhubin
     * 取得货品的促销信息
     * @param $good_infoes   array(good_id=>array('good_id'=>  ,'product_id'=>  ,'quantity'=>))
     * 返回促销信息数字
     */
    /*
    public function whole_sale(&$good_infoes)
    {
        //初始化返回数组
        $return_struct = array();
        if(!Mysite::instance()->get('is_wholesale'))
        {
            return $return_struct;
        }
        $products = array();
        $product_service = ProductService::get_instance();
        //得出产品列表以及该产品的数量
        foreach($good_infoes as $good_info)
        {
        	if(!isset($products[$good_info['product_id']]))
        	{
	        	try {
	                $product_info = $product_service->get($good_info['product_id']);
	        	}catch (MyRuntimeException $e){
	                continue;
	        	}
	        	$products[$good_info['product_id']] = $product_info;
        	}
        	!isset($products[$good_info['product_id']]['count']) && 
                $products[$good_info['product_id']]['count'] = 0;
        	$products[$good_info['product_id']]['count'] += $good_info['quantity'];
        	$products[$good_info['product_id']]['goods'][$good_info['good_id']] = $good_info['product_id'];
        }
        //得到相关的批发信息
        foreach($products as $key=>$product)
        {
            if($product['is_wholesale'])
            {
                if($product['lowest_wholesale_num'] <= $product['count'])
                {
                    $discount_info = $this->get_price($key,$product['count']);
                    $_promotion = array();
                    $_promotion['discount_value']   = $discount_info['value'];
                    $_promotion['discount_type']    = $discount_info['type'];
                    $_promotion['description']      = $product['title'].' wholesale.';
                    $_promotion['related_ids']      = $product['goods'];
                    $return_struct['wholesale'][]   = $_promotion;
                    
                    //批发添加成功标识，用于提醒操作  TODO
                    foreach($product['goods'] as $good_id=>$product_id)
                    {
                        $good_infoes[$good_id]['status'] = 0;
                    }
                }else{
                    if($product['is_wholesale'] == 1)
                    {
                        //批发添加成功标识，用于提醒操作  TODO
                        //可以零售，但是没有达到批发数量
                        foreach($product['goods'] as $good_id=>$product_id)
                        {
                            $good_infoes[$good_id]['status'] = 1;
                        }
                    }
                    if($product['is_wholesale'] == 2)
                    {
                        //批发添加成功标识，用于提醒操作
                        //禁止零售，没有达到批发数量
                        foreach($product['goods'] as $good_id=>$product_id)
                        {
                            $good_infoes[$good_id]['status'] = 2;
                        }
                    }
                }
            }
        }
        return $return_struct;
    }
    */
    
    /**
     * 根据产品ID以及购买数量获取产品批发单价
     * 
     * @param $product_id  产品ID
     * @param $quantiry    购买数量
     * @return array
     */
    public function get_price($product_id, $quantiry)
    {
    	$wholesales = $this->get($product_id);
    	if (!empty($wholesales)) {
    		foreach ($wholesales as $key => $wholesale) {
    			if ($quantiry >= $wholesale['num_begin'] AND ($quantiry <= $wholesale['num_end'] OR $wholesale['num_end'] == 0)) {
    				return array(
    					'type'  => $wholesale['type'],
    					'value' => $wholesale['value'],
    				);
    			}
    		}
    	}
    	return FALSE;
    }
    /**
     * 获取最低的批发数量
     * TODO 此处还有问题，有些批发数量不连贯
     * @param $product_id 产品ID
     * @return int
     */
    public function get_min_num($product_id)
    {
        $wholesales = $this->get($product_id);
        foreach($wholesales as $wholesale ){
            return $wholesale['num_begin'];
        }
    }
}
