<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_draw_moneyService_Core extends DefaultService_Core 
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

        $obj = ORM::factory('user_draw_money');
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
     * 检查每日申请的次数
     */
    public function get_day_count($uid)
    {
        $time_beg = date("Y-m-d H:i:s", mktime (0,0,0,date("m") ,date("d"),date("Y")));
        $time_end = date("Y-m-d H:i:s", mktime (0,0,0,date("m") ,date("d")+1,date("Y")));
        $obj = ORM::factory('user_draw_money')->where("user_id", $uid)->where("time_stamp >", $time_beg)->where("time_stamp <", $time_end);
        $count = $obj->count_all();
        return $count;
    }
    
    /**
     * 
     * @author wunan
     * 取消提现申请
     * @param unknown_type $id
     * @param unknown_type $user
     * @param unknown_type $user_id
     */
  	public function atm_esc($id,$user,$user_id)
    {
    	echo $user;
    	echo $user;
        $obj = ORM::factory('user_draw_money', $id);
       
        if ($obj->loaded)
        {
        	 
            if ($obj->status == 0)
            {
                //返还冻结金额
                $usermoney = user::get_instance()->get_user_money($obj->user_id);
                //记录日志
                $data_log = array();
                $data_log['order_num'] = date('YmdHis').rand(0, 99999);
                $data_log['user_id'] = $obj->user_id; 
                $data_log['log_type'] = 4;                 //参照config acccount_type 设置
                $data_log['is_in'] = 0;
                $data_log['price'] = $obj->money;
                $data_log['user_money'] = $usermoney;
                $lan = Kohana::config('lan');
                $data_log['memo'] = $lan['money'][14];
                account_log::get_instance()->add($data_log);
                
                $obj->status = 2;
                var_dump($obj->status);
                $obj->memo = "用户".$user."取消提现\n时间:".date('Y-m-d H:i:s',time())."\n\n";
                $obj->manager_id = $user_id;
                $obj->save();
                
                return TRUE;
            }
            else 
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }    

}
