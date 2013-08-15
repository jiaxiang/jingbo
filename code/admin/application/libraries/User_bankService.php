<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_bankService_Core extends DefaultService_Core 
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

        $obj = ORM::factory('user_bank');
        //生成订单号
        try
        {  
        	if($obj->validate($data))
    		{
    			$obj->save();
    			return $obj->id;
    		}
    		else
    		{
    			return FALSE;
		    }
        }
        catch (MyRuntimeException $ex) 
        {
            return FALSE;
        }
    }
    
    /*
     * 检查帐号是否存在
     */
    public function exist($account, $user_id)
    {
        $obj = ORM::factory('user_bank');
        $result = $obj->where('account', $account)->where('user_id', $user_id)->find();
        
        if ($obj->loaded)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    /*
     * 设为默认帐号
     */
    public function set_default($id, $user_id)
    {
        $obj = ORM::factory('user_bank');
        $obj = $obj->where('id', $id)->where('user_id', $user_id)->find();
        
        if ($obj->loaded)
        {   
            $obj->default = 1;
            $obj->save();
            
            $results = $obj->where('user_id', $user_id)->where('id <>', $id)->find_all();
            foreach ($results as $row)
            {
                $obj->where('id', $row)->find();
                if ($obj->loaded)
                {
                    $obj->default = 0;
                    $obj->save();
                }                
            }
        }
    }
    
    /*
     * 删除信息
     */
    public function delete_one($id)
    {
        return $this->delete(array('id'=>$id));
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
     * 根据输入条件返回所有信息
     */
    public function get_results_by_uid($uid)
    {
        $obj = ORM::factory('user_bank')
                ->where("user_id", $uid)
                ->orderby("time_stamp", 'DESC');
        $results = $obj->find_all();
        
        $return = array();
        foreach ($results as $row)
        {
            $return[] = $row->as_array();
        }        
        return $return;
    }

}
