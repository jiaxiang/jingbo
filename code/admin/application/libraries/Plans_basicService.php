<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plans_basicService_Core extends DefaultService_Core 
{
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
     * 创建数据
     * @param array $data 包含数据 user_id ticket_type play_method
     * @return int
     */
    public function add($data){
        if (empty($data))
            return FALSE;

        $obj = ORM::factory('plans_basic');
        //生成订单号
        $data['order_num'] = $this->get_order_num();
        
        try
        {  
        	if($obj->validate($data))
    		{
    			$obj->save();
    			return $obj->order_num;
    		}
    		else
    		{
    			return FALSE;
		    }
        }
        catch (MyRuntimeException $ex) 
        {
            return FALSE;
            //throw new MyRuntimeException('', 404);
        }
    }
    
    /*
     * 获取订单号
     */
    public function get_order_num()
    {
        do
        {
            $return = date('YmdHis') .rand(0, 99999);
            if(!$this->exist($return))
                break;
        }
        while (1);
        return $return;
    }
    
    /*
     * 检查订单号,存在则返回订单信息
     */
    public function exist($order_num)
    {
        $obj = ORM::factory('plans_basic');
        $result = $obj->where('order_num', $order_num)->find();
        
        if ($obj->loaded)
        {
            return $result->as_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    /*
     * 更新彩票表状态
     */
    public function update_status($id, $status)
    {
        $obj = ORM::factory('plans_basic');
        $result = $obj->where('order_num', $id)->find();
        if ($obj->loaded)
        {
            $obj->status = $status;
            $obj->save();
        }
    }
    

    /*
     * 更新彩票表奖金
     */
    public function update_bonus($ordernum, $bonus)
    {
        $obj = ORM::factory('plans_basic');
        $result = $obj->where('order_num', $ordernum)->find();        
        if ($obj->loaded)
        {
            $obj->bonus = $bonus;
            $obj->save();
        }
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

    
    /*
     * 检查订单号,存在则返回订单信息
     */
    public function get_by_ordernum($order_num)
    {
        $obj = ORM::factory('plans_basic');
        $result = $obj->where('order_num', $order_num)->find();
        
        if ($obj->loaded)
        {
            return $result->as_array();
        }
        else
        {
            return FALSE;
        }
    }    
    
    /*
     * 根据输入状态返回统计信息
     */
    public function get_count_by_status($uid, $status)
    {
        $obj = ORM::factory('plans_basic')->where("user_id", $uid)->where("status", $status);
        return $obj->count_all();
    }
    
    /*
     * 根据输入状态返回统计信息
     */
    public function get_count_notend($uid)
    {
        $obj = ORM::factory('plans_basic')->where("user_id", $uid)->where("status <", 3);
        return $obj->count_all();
    }
    
    /**
     * 获取未结算超级发单人的合买单
     * @param unknown_type $userid
     * @param unknown_type $lasttime
     */
    public function get_hemai_data($userid, $ticket_type, $lasttime) {
    	$db_obj = Database::instance();
    	switch ($ticket_type) {
    		case 0 : $ticket_type = ' and (ticket_type=1 or ticket_type=2 or ticket_type=6 or ticket_type=8)';break;
    		case 7 : $ticket_type = ' and ticket_type=7';break;
    		default: $ticket_type = ''; break;
    	}
    	$query = 'select id,order_num,ticket_type from plans_basics where plan_type=1 and start_user_id="'.$userid.'"'.$ticket_type.' and status=2 and agmretstatus=0 and agrretstatus=0 and date_add>="'.$lasttime.'"';
    	$results = $db_obj->query($query);
    	$data = array();
    	foreach ($results as $result) {
    		$data[] = array('id'=>$result->id, 'order_num'=>$result->order_num, 'ticket_type'=>$result->ticket_type);
	    }
	    return $data;
    }
	
    /**
     *  超级发单人更新结算状态
     */
    public function update_settle_status($id) {
    	if (is_array($id) == true) {
    		$where = 'where id in ('.implode(',', $id).')';
    	}
    	else {
    		$where = 'where id="'.$id.'"';
    	}
    	$db_obj = Database::instance();
    	$query = 'update plans_basics set agmretstatus=1 ,agrretstatus=1 '.$where.' and agmretstatus=0 and agrretstatus=0';
d($query, false);
    	$results = $db_obj->query($query);
    }
}
