<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plans_lotty_orderService_Core extends DefaultService_Core 
{
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
    private static $pdb = null;
	   
    // 获取单态实例
    public static function get_instance()
    {
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    
    public function query_data_list($query_struct){
        if (empty($query_struct))
            return FALSE;
        try
        {  
        	$data_list = $this->query_assoc($query_struct);
			return $data_list;
        }
        catch (MyRuntimeException $ex) 
        {
            return FALSE;
            //throw new MyRuntimeException('', 404);
        }
    }
    
    public function get_by_order_id($id){
        if (empty($id))
            return  FALSE;
        $obj1 = ORM::factory('sale_prouser');
        $obj1->where('pbid', $id);
        $result1 = $obj1->find();
        if($obj1->loaded){
        	$re =$result1->as_array();
	        $obj = ORM::factory('plans_lotty_order');
	                
	        $obj->where('id', $re['pid']);
	        $result = $obj->find();
	                
	        if ($obj->loaded)
	        {
	        	$res = $result->as_array();
	        	$res['sale'] = $re;
	            return $res;
	        }
	        else 
	        {
	            return FALSE;
	        }
        }else{
        	return false;
        }
    }
    
    public function get_by_plan_id($id){
       if (empty($id))
            return  FALSE;

        $obj = ORM::factory('plans_lotty_order');

        $obj->where('id', $id);
        $result = $obj->find();
        
        if ($obj->loaded)
        {
            return $result->as_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    /**
     * 根据基表订单号获取数据
     * @param unknown_type $id
     */
    public  function get_by_basic_id($id)
    {
    	if (empty($id))
    		return  FALSE;
    
    	$obj = ORM::factory('plans_lotty_order');
    	$obj->select('id,basic_id,uid as user_id,uname,allmoney as total_price,nums,onemoney,rgnum,afterbonus,renqi as progress');
    	$obj->where('basic_id', $id);
    	$result = $obj->find();
    
    	if ($obj->loaded)
    	{
    		return $result->as_array();
    	}
    	else
    	{
    		return FALSE;
    	}
    }
    
    /**
     * 合买获取认购信息
     * @param unknown_type $id
     */
    public  function get_son_by_pid($id)
    {
    	if (empty($id))
    		return  FALSE;
    
    	$obj = ORM::factory('sale_prouser')->where('pbid', $id);
    	$results = $obj->find_all();
    	$return = array();
    	foreach ($results as $result)
    	{
    		$return[] = $result->as_array();
    	}
    
    	return $return;
    }
    
}