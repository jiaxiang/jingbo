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
    
    /*
     * 设为已审核
     */
    public function set_hasreview($id, $manager_id)
    {
        $obj = ORM::factory('user_draw_money', $id);
        if ($obj->loaded)
        {
            if ($obj->status == 0)
            {
                $obj->status = 1;
                $obj->memo = $obj->memo.'设为审核通过'."\n时间:".tool::db_date()."\n\n";
                $obj->manager_id = $manager_id;
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

    
    /*
     * 设为审核失败
     */
    public function set_reviewfail($id, $manager_id)
    {
        $obj = ORM::factory('user_draw_money', $id);
        if ($obj->loaded)
        {
            if ($obj->status == 0)
            {
                $lan = Kohana::config('lan');
                //提现金额
    			$withdrawals_moneys = array();
    			$withdrawals_moneys['USER_MONEY'] = $obj->money;    
    			$withdrawals_moneys['BONUS_MONEY'] = 0;
    			$withdrawals_moneys['FREE_MONEY'] = 0;
    			
    			//手续费
    			$fee_moneys = array();
    			$fee_moneys['USER_MONEY'] = 0;    
    			$fee_moneys['BONUS_MONEY'] = 0;    
    			$fee_moneys['FREE_MONEY'] = 0;
        
    			if (!empty($obj->other))
    			{
    			    $objother = json_decode($obj->other);
    			    $withdrawals_moneys['USER_MONEY'] = $objother->withdrawals_moneys->USER_MONEY;    
    			    $withdrawals_moneys['BONUS_MONEY'] = $objother->withdrawals_moneys->BONUS_MONEY;    
    			    $withdrawals_moneys['FREE_MONEY'] = $objother->withdrawals_moneys->FREE_MONEY;

    			    $fee_moneys['USER_MONEY'] = $objother->fee_moneys->USER_MONEY;
    			    $fee_moneys['BONUS_MONEY'] = $objother->fee_moneys->BONUS_MONEY;
    			    $fee_moneys['FREE_MONEY'] = $objother->fee_moneys->FREE_MONEY;
    			}    			
                
    			$order_num = date('YmdHis').rand(0, 99999);
    			
                $user_money_obj = user_money::get_instance();
                $user_money_obj->add_money($obj->user_id, $obj->money, $withdrawals_moneys, 4, $order_num, $lan['money'][14]);
                
                $fee = $fee_moneys['USER_MONEY'] + $fee_moneys['BONUS_MONEY'] + $fee_moneys['FREE_MONEY'];
                if ($fee > 0)
                {
                    $user_money_obj->add_money($obj->user_id, $fee, $fee_moneys, 4, $order_num, $lan['money'][20]);    
                }
                
                $obj->status = 2;
                $obj->memo = $obj->memo.$lan['money'][14]."\n时间:".tool::db_date()."\n\n";
                $obj->manager_id = $manager_id;
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
    
    
    /*
     * 设为打款失败
     */
    public function set_chargefail($id, $memo, $manager_id)
    {
        $obj = ORM::factory('user_draw_money', $id);
        if ($obj->loaded)
        {
            if ($obj->status == 1)
            {

                $lan = Kohana::config('lan');
                
                //提现金额
    			$withdrawals_moneys = array();
    			$withdrawals_moneys['USER_MONEY'] = $obj->money;    
    			$withdrawals_moneys['BONUS_MONEY'] = 0;
    			$withdrawals_moneys['FREE_MONEY'] = 0;
    			
    			//手续费
    			$fee_moneys = array();
    			$fee_moneys['USER_MONEY'] = 0;    
    			$fee_moneys['BONUS_MONEY'] = 0;    
    			$fee_moneys['FREE_MONEY'] = 0;
                    			
    			if (!empty($obj->other))
    			{
    			    $objother = json_decode($obj->other);
    			    $withdrawals_moneys['USER_MONEY'] = $objother->withdrawals_moneys->USER_MONEY;    
    			    $withdrawals_moneys['BONUS_MONEY'] = $objother->withdrawals_moneys->BONUS_MONEY;    
    			    $withdrawals_moneys['FREE_MONEY'] = $objother->withdrawals_moneys->FREE_MONEY;

    			    $fee_moneys['USER_MONEY'] = $objother->fee_moneys->USER_MONEY;
    			    $fee_moneys['BONUS_MONEY'] = $objother->fee_moneys->BONUS_MONEY;
    			    $fee_moneys['FREE_MONEY'] = $objother->fee_moneys->FREE_MONEY;
    			}    			
                $order_num = date('YmdHis').rand(0, 99999);
                $user_money_obj = user_money::get_instance();
                $user_money_obj->add_money($obj->user_id, $obj->money, $withdrawals_moneys, 4, $order_num, $lan['money'][15].';操作员备注:'.$memo);
                
                $fee = $fee_moneys['USER_MONEY'] + $fee_moneys['BONUS_MONEY'] + $fee_moneys['FREE_MONEY'];
                if ($fee > 0)
                {
                    $user_money_obj->add_money($obj->user_id, $fee, $fee_moneys, 4, $order_num, $lan['money'][21].';操作员备注:'.$memo);    
                }
                
                $obj->status = 4;
                $obj->memo = $obj->memo.$lan['money'][15]."\n".$memo."\n时间:".tool::db_date()."\n\n";
                $obj->manager_id = $manager_id;
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
    
    /*
     * 设为提现成功
     */
    public function set_chargewin($id, $manager_id)
    {
        $obj = ORM::factory('user_draw_money', $id);
        if ($obj->loaded)
        {
            if ($obj->status == 3)
            {
                $lan = Kohana::config('lan');
                
                //提现金额
    			$withdrawals_moneys = array();
    			$withdrawals_moneys['USER_MONEY'] = 0;    
    			$withdrawals_moneys['BONUS_MONEY'] = 0;
    			$withdrawals_moneys['FREE_MONEY'] = 0;
                
                $user_money_obj = user_money::get_instance();
                $user_money_obj->add_money($obj->user_id, 0, $withdrawals_moneys, 4, date('YmdHis').rand(0, 99999), $lan['money'][16]);    			
                
                $obj->status = 5;
                $obj->memo = $obj->memo.$lan['money'][16]."\n时间:".tool::db_date()."\n\n";
                $obj->manager_id = $manager_id;
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
    
    /*
     * 财务录入流水号设为提现成功
     */
    public function set_hascharge($id, $memo, $manager_id)
    {
        $obj = ORM::factory('user_draw_money', $id);
        if ($obj->loaded)
        {
            if ($obj->status == 1)
            {
                $obj->status = 3;
                $obj->memo = $obj->memo."设为已打款\n".$memo."\n时间:".tool::db_date()."\n\n";
                $obj->manager_id = $manager_id;
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
