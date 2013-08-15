<?php defined('SYSPATH') OR die('No direct access allowed.');

class GameService_Core extends DefaultService_Core {
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
        
        return $wholesales;
    }
    
}
