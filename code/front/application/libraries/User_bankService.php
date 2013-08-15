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
    
	/**
     *@author wunan
     * 取得银行列表数据库
     * @param $date
     * @param $type
     * @param $status
     */
	public function getBankListAjax($province = null , $city = null , $bank_name = null) {
    	if($province == null && $city == null && $bank_name == null){
    		$db = Database::instance(); 
    		$sql="SELECT province FROM `user_generation_datas` WHERE char_length( province ) >2 
    		AND province != '黑龙江' GROUP BY province";
        	$results = $db->query($sql);
	    	foreach ($results as $result) {
	    		$rs[]=$result->province;
    		}
    		return $rs;
    	}
        if($province != null && $city == null && $bank_name == null){
        	$db = Database::instance(); 
        	$province = mb_substr($province,0,2,'utf-8');
    		$sql='SELECT city FROM `user_generation_datas` WHERE left(province, 2) = "'.$province.'"
    		GROUP BY  left(city,2)';
        	$results = $db->query($sql);
	    	foreach ($results as $result) {
	    		$rs[]=$result->city;
	    	}
	    	return $rs;
    	}
        if($province == null && $city != null && $bank_name == null){
        	$db = Database::instance(); 
        	$city=str_replace("市","",$city);
    		$sql='SELECT bank_name FROM `user_generation_datas` where `city` like "'.$city.'%" 
    		GROUP BY bank_name';
        	$results = $db->query($sql);
	    	foreach ($results as $result) {
	    		$rs[]=$result->bank_name;
	    	}
	    	return $rs;
    	}
		if($province == null && $city != null && $bank_name != null){
			$db = Database::instance(); 
        	$city=str_replace("市","",$city);
    		$sql='SELECT branch_name FROM `user_generation_datas` where `bank_name`="'.$bank_name.'" and `city` like "'.$city.'%" 
    		GROUP BY branch_name';
			$results = $db->query($sql);
	    	foreach ($results as $result) {
	    		$rs[]=$result->branch_name;
	    	}
	    	return $rs;
    	}

    }
    

}
