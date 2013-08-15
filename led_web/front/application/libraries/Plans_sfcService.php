<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plans_sfcService_Core extends DefaultService_Core 
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
            
        $obj = ORM::factory('plans_sfc');
        
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
            //throw new MyRuntimeException('', 404);
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



	//兑奖方法
    public function check_bonus($result)	
	{
	//$result  为ticket_nums表中的一条记录
	
	//逻辑各写各的
	
	$result['status']=1; //状态(0,未开奖 1,已开奖)
	$result['bonus']=0; //奖金(默认为0)  	
	return $result;
	}	
	
    /*
     * 获取数据
     * 
     */
    public  function  get_by_basic_id($basic_id)
    {
        
        if (empty($basic_id))
            return  FALSE;

        $obj = ORM::factory('plans_sfc');

        $obj->where('basic_id', $basic_id);
        
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
    /*
     * 获取数据
     * 
     */
    public  function  get_by_id($id)
    {
        
        if (empty($id))
            return  FALSE;

        $obj = ORM::factory('plans_sfc');

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


	
	public function up_data($data)
	{
	    $obj = ORM::factory('plans_sfc');
		$obj->where('basic_id', $data['basic_id'])
		    ->where('user_id', $data['user_id'])
			->find();
		if($obj->loaded)
		{
		    $obj->codes = $data['codes'];
		    $obj->is_select_code = $data['is_select_code'];			
		}
		return $obj->save();
	}
	public function up_data_upload($data)
	{
	    $obj = ORM::factory('plans_sfc');
		$obj->where('basic_id', $data['basic_id'])
		    ->where('user_id', $data['user_id'])
			->find();
		if($obj->loaded)
		{
		    $obj->upload_filepath = $data['upload_filepath'];
		    $obj->is_upload = $data['is_upload'];			
		}
		return $obj->save();
	}
	public function up_data_progress($data)
	{
	    $obj = ORM::factory('plans_sfc');
		$obj->where('basic_id', $data['basic_id'])
			->find();
		if($obj->loaded)
		{
		    $obj->buyed = $data['buyed'];
		    $obj->progress = $data['progress'];	
		}
		return $obj->save();
	}


	public function find_join_data($user_id,$pid)
	{
	    $obj = ORM::factory('plans_sfc');
	   
		$obj->where('user_id', $user_id)
			->where('parent_id', $pid)
			->find();
        
		if($obj->loaded)
		{
		    return true;
		}else{
		    return false;			
		}
	}




    /*
     * 退还保底金额后把保底份数更新为0
     */
    public function update_end_price($id)
    {
        $obj = ORM::factory('plans_sfc');
        $obj->where('id', $id);
        $result = $obj->find();
        
        if ($obj->loaded)
        {
            $obj->end_price = 0;
            $obj->save();
            
            if($obj->saved)
            {
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
     * 更改父类状态
     */
    public function update_status($id, $status)
    {
        $obj = ORM::factory('plans_sfc');
        $obj->where('id', $id);
        $result = $obj->find();
        
        if ($obj->loaded)
        {
            $obj->status = $status;
            $obj->save();
            
            if($obj->saved)
            {
                $basicobj = Plans_basicService::get_instance();
                $basicobj->update_status($obj->basic_id, $status);
                
                //更新参与合买的状态
                $son_results = $this->get_son_by_pid($id);
                if (!empty($son_results))
                {
                    foreach ($son_results as $rowson)
                    {
                        $obj_son = ORM::factory('plans_sfc', $rowson['id']);
                        $obj_son->status = $status;
                        $obj_son->save();
                        $basicobj->update_status($obj_son->basic_id, $status);
                    }
                }
                /*else
                {
                    $basicobj->update_status($obj->basic_id, $status);
                }*/
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
     * 根据基表订单id获取数据
     * 
     */
    public  function get_son_by_pid($id)
    {
        if (empty($id))
            return  FALSE;
        
        $obj = ORM::factory('plans_sfc')->where('parent_id', $id);
        $results = $obj->find_all();
        $return = array();
        foreach ($results as $result)
        {
            $return[] = $result->as_array();
        }
        
        return $return;
    }
 
 
    /*
     * 彩票退款处理
     * @param  integer  $ordernum  订单号码
     * @param  integer  $money  退还金额
     * @return array 以用户id为索引,所返还的金额为值
     */
    public function refund_by_ticket($ordernum, $money)
    {
		$plan_info=$this->get_by_basic_id($ordernum);
		
		/* 初始化默认查询条件 */
		$query_struct = array(
			'where'=>array(
				'ticket_type' => 2,//玩法	
				'parent_id' => $plan_info['id'],//父id				
			),
			'like'=>array(),
			'orderby' => array(
				'id' =>'DESC',
			),
			'limit' => array(
				//'per_page' =>$total_rows,//每页的数量
				//'page' =>$page //页码
			),
		);		
		
		$plan_list=$this->query_assoc($query_struct);
		$data_list[$plan_info['user_id']]=($plan_info['my_copies']/$plan_info['copies'])*$money;
		foreach($plan_list as $key=>$value){
			if(empty($data_list[$value['user_id']])){
				$data_list[$value['user_id']]=($value['my_copies']/$value['copies'])*$money;
			}else{
				$data_list[$value['user_id']]=(($value['my_copies']/$value['copies'])*$money)+$data_list[$value['user_id']];	
			}
			
		}
   		return $data_list;
    } 
 



    /*
     * 过期未满员方案处理
     * 此处针对过期未满员的合买方案进行处理,当方案过期发起人保底数量能够填满剩余数量则方案有效
     * 有效方案的会加入生成彩票加入彩票表;否则不做任何处理
     * @param  integer  $ordernum  订单号码 
     * @return TRUE OR FALSE 有效或无效
     */    
    public function expired_plan($ordernum)
    {
        $result = $this->get_by_order_id($ordernum);
        if (empty($result))
        {
            return FALSE;
        }
        
        if ($result['end_price'] < $result['buyed'])
        {
            //return FALSE;
            $sd_config = Kohana::config('site_config.hm_sd');
            $buyed = $result['copies'] - $result['buyed'] + $result['end_price'];
            $sd_limit = $result['copies'] * $sd_config['sd_limit_buyed'];
            if ($buyed >= $sd_limit) {
            	$sd_num = $result['copies'] - $buyed;
            	$sd_money = $sd_num * $result['price_one'];
            	$sd_userid = $sd_config['sd_userid'];//wysd08
            	$userobj = user::get_instance();
            	$sd_usermoney = $userobj->get_user_money($sd_userid);
            	if ($sd_usermoney < $sd_money) {
            		return false;
            	}
            
            	$databasic = array();
            	$data = array();
            	$databasic['user_id'] = $sd_userid;
            	$databasic['start_user_id'] = $result['user_id'];
            	$databasic['ticket_type'] =  2;
            	$databasic['play_method'] = $result['play_method'];
            	$databasic['plan_type'] = 2;
            	$databasic['date_end'] = $result['time_end'];
            	$plans_basic_obj = Plans_basicService::get_instance();
            	$basic_id = $plans_basic_obj->add($databasic);
            	
            	$data['basic_id'] = $basic_id;
            	$data['is_buy'] = 2;
            	$data['parent_id'] = $result['id'];
            	$data['user_id'] = $sd_userid;
            	$data['ticket_type'] = 2;
            	$data['play_method'] = $result['play_method'];
            	$data['codes'] = $result['codes'];
            	$data['expect'] = $result['expect'];
            	$data['zhushu'] =$result['zhushu'];
            	$data['rate'] = $result['rate'];
            	$data['price'] = $result['price'];
            	$data['deduct'] = $result['deduct'];
            	$data['copies'] = $result['copies'];
            	$data['price_one'] = $result['price_one'];
            	$data['my_copies'] = $sd_num;
            	$data['is_baodi'] = $result['is_baodi'];
            	$data['end_price'] = $result['end_price'];
            	$data['is_open'] = $result['is_open'];
            	$data['title'] = "";
            	$data['description'] = "";
            	$data['friends'] = "";
            	$data['buyed'] = $result['buyed'] - $data['my_copies'];
            	$data['progress'] = intval(number_format(($data['copies']-$data['buyed'])/$data['copies']*100,2));
            	$data['is_upload'] = $result['is_upload'];
            	$data['money'] = $sd_money;
            	$data['time_end'] = $result['time_end'];
            	$data['type'] = $result['type'];
            	$data['is_select_code'] = $result['is_select_code'];
            	if (!($id = $this->add($data))) {
            		return FALSE;
            	}
            	else {
            		$data_log = array();
            		$data_log['order_num'] = $basic_id;
            		$data_log['user_id'] = $sd_userid;
            		$data_log['log_type'] = 2;                 //参照config acccount_type 设置
            		$data_log['is_in'] = 1;
            		$data_log['price'] = $data['money'];
            		$data_log['user_money'] = $sd_usermoney;
            		 
            		$lan = Kohana::config('lan');
            		$data_log['memo'] = $lan['money'][18].',订单ID:'.$result['basic_id'];
            		account_log::get_instance()->add($data_log);
            		 
            		//更新父类进度            		
            		$up_data['basic_id'] = $result['basic_id'];
            		$up_data['buyed'] = $data['buyed'];
            		$up_data['progress'] = $data['progress'];
            		$this->up_data_progress($up_data);
            	}
            	$result = $this->get_by_order_id($ordernum);
            }
            else {
            	return FALSE;
            }
        }


        //当方案时间没过期时不做处理
        if (strtotime($result['time_end']) > time())
        {
            return FALSE;
        }
        //当方案状态不为0时不做处理
        if ($result['status'] != 0 && $result['status'] != 1)
        {
            return FALSE;
        }

        //当方案状态不为0时不做处理
        if ($result['is_upload'] == 0 && $result['is_select_code'] == 0)
        {
            return FALSE;
        }

        //将保底数量移除剩余的数量加入到我购买的份数中,并将剩余的金额返回
        $obj = ORM::factory('plans_sfc', $result['id']);
        $obj->my_copies = $obj->my_copies + $result['buyed'];
        $obj->money = $obj->money + $result['buyed']*$result['price_one'];	
        $obj->progress = 100;
        $obj->buyed = 0;
        $obj->end_price = $result['buyed'];
        $obj->save();
        
        if ($obj->saved)
        {
            //返回保底金额
            //$backmoney = ($result['end_price']-$result['buyed']) * $obj->price_one;
            //$usermoney = user::get_instance()->get_user_money($obj->user_id);
                        
			/*            //记录日志
            $data_log = array();
            $data_log['order_num'] = $obj->basic_id;
            $data_log['user_id'] = $obj->user_id;
            $data_log['log_type'] = 5;                 //参照config acccount_type 设置
            $data_log['is_in'] = 0;
            $data_log['price'] = $backmoney;
            $data_log['user_money'] = $usermoney;
            
            $lan = Kohana::config('lan');
            $data_log['memo'] = $lan['money'][10];
            account_log::get_instance()->add($data_log); */

            $lan = Kohana::config('lan');
            $moneyobj = user_money::get_instance();
            //返回多余的保底金额
            $retmoney = ($result['end_price']-$result['buyed']) * $obj->price_one;
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys['USER_MONEY'] = $retmoney;
            $moneyobj->add_money($result['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][10]);             
            
            //生成彩票
			$ticketobj = ticket::get_instance();
			
			if($obj->type==1){
				if($obj->zhushu==1){
					$ticketobj->crate_ticket($obj->id, $obj->ticket_type, $obj->play_method, $this->transform_codes1($obj->codes).";3;".$obj->expect, $obj->rate, $obj->basic_id, $obj->price);
				}else{
					$ticketobj->crate_ticket($obj->id, $obj->ticket_type, $obj->play_method, $this->transform_codes($obj->codes).";".$obj->type.";".$obj->expect, $obj->rate, $obj->basic_id, $obj->price);
				}							
			}elseif($obj->type==3 and $obj->is_upload==1){
				$handle=file_get_contents($obj->upload_filepath);
				$buffer = explode("\r\n", $this->formatnumber($handle));
				$buffer=array_chunk($buffer,5);
				foreach($buffer as $key=>$value){
					$ticketobj->crate_ticket($obj->id, $obj->ticket_type, $obj->play_method, implode("|",$value).";".$obj->type.";".$obj->expect, $obj->rate, $obj->basic_id,count($value)*2);
				}
			}			
			
            return TRUE;
            
        }
        else
        {
            return FALSE;
        } 

	}




    /*
     * 取消订单
     * 当订单的彩票未被打印,未满员,取消订单时将会根据比例将钱退还给用户,包含保底等在内
     * @param  integer  $ordernum  订单号码 
     * @return TRUE OR FALSE 有效或无效
     */    
    public function cancel_plan($ordernum)
    {
        $result = $this->get_by_order_id($ordernum);
        if (empty($result))
        {
            return FALSE;
        }
        
        if ($result['parent_id'] > 0)    //只能操作父类方案
        {
            return FALSE;    
        }
        
        $userobj = user::get_instance();
        $total_price = $result['price'];
        
		/*        //退还保底及购买份数金额
        $retmoney = $result['price_one'] * $result['end_price'] + $result['price_one'] * $result['my_copies'];
        $data_log = array();
        $lan = Kohana::config('lan');
        $usermoney = $userobj->get_user_money($result['user_id']);
        $data_log['order_num'] = date('YmdHis').rand(0, 99999);
        $data_log['user_id'] = $result['user_id'];
        $data_log['log_type'] = 5;                 //参照config acccount_type 设置
        $data_log['is_in'] = 0;
        $data_log['price'] = $retmoney;
        $data_log['user_money'] = $usermoney;
        $data_log['memo'] = $lan['money'][9];
        account_log::get_instance()->add($data_log);

        //返还参与合买的
        $plans = $this->get_son_by_pid($result['id']);
        
        foreach ($plans as $rowplan)
        {
            $retmoney = $rowplan['my_copies'] * $result['price_one'];
            $data_log = array();
            $usermoney = $userobj->get_user_money($rowplan['user_id']);
            $data_log['order_num'] = date('YmdHis').rand(0, 99999);
            $data_log['user_id'] = $rowplan['user_id'];
            $data_log['log_type'] = 5;                 //参照config acccount_type 设置
            $data_log['is_in'] = 0;
            $data_log['price'] = $retmoney;
            $data_log['user_money'] = $usermoney;
            $data_log['memo'] = $lan['money'][9];
            account_log::get_instance()->add($data_log);
        }*/        
        
        
        //退还保底及购买份数金额
        $moneyobj = user_money::get_instance();
        $moneys = $moneyobj->get_con_by_order_num($ordernum);
                
        if (empty($moneys))
            return FALSE;
            
        $lan = Kohana::config('lan');
        $retmoney = $result['price_one'] * $result['end_price'] + $result['price_one'] * $result['my_copies'];
        $order_num = date('YmdHis').rand(0, 99999);
        $flagret = $moneyobj->add_money($result['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][9]);
        
        if ($flagret < 0)
            return FALSE;
        
        //返还参与合买的
        $plans = $this->get_son_by_pid($result['id']);
        
        foreach ($plans as $rowplan)
        {
            $retmoney = $rowplan['my_copies'] * $result['price_one'];
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys = $moneyobj->get_con_by_order_num($rowplan['basic_id']);
            $moneyobj->add_money($rowplan['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][9]);            
        }
        
        $this->update_status($result['id'], 6);    //更新彩票状态
        
        return TRUE;
       
    }  
    

    /*
     * 派奖
     * 当方案处于已中奖的状态时则可以进行派奖操作 注意发起人的奖金,提成
     * @param  integer  $ordernum  订单号码 
     * @return TRUE OR FALSE 有效或无效
     */    
    public function bonus_plan($ordernum)
    {
        $result = $this->get_by_order_id($ordernum);
                
        if (empty($result))
        {
            return FALSE;
        }
        
        if ($result['parent_id'] > 0)    //只能操作父类方案
        {
            return FALSE;    
        }
        
        if ($result['status'] != 4)    //只能操作已中奖的方案
        {
            return FALSE;    
        }
        
        $total_price = $result['price'];        //总金额
        $total_bonus = $result['bonus'];        //总奖金
        $bonus_one = $total_bonus / $result['copies'];////单份奖金

        $userobj = user::get_instance();
        
        
        //发起人提成派发;
        
        $lan = Kohana::config('lan');
        $moneyobj = user_money::get_instance();        
        
        $deduct_retmoney = 0 ;
        if ($result['deduct'] > 0)
        {
            $profitmoney = $total_bonus - $total_price;        //利润
            if ($profitmoney > 0)
            {
                //$deduct_retmoney =  $profitmoney * $result['deduct'] / 100;       //提成
                $deduct_retmoney =  $total_bonus * $result['deduct'] / 100;       //提成
                $total_bonus = $total_bonus - $deduct_retmoney;                   //重构总奖金,总奖金减去提成金额
                $bonus_one = $total_bonus / $result['copies'];                    //重构单份奖金
            }
        }
        
        $lan = Kohana::config('lan');

        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        $basic_id_url = '<a href="http://'.$data['site_config']['name'].'/zcsf/viewdetail/'.$result['basic_id'].'" target="_blank">'.$result['basic_id'].'</a>';
        //当提成大于0则添加记录
        if ($deduct_retmoney > 0)
        {
			/*            $data_log = array();
            $usermoney = $userobj->get_user_money($result['user_id']);
            $data_log['order_num'] = date('YmdHis').rand(0, 99999);
            $data_log['user_id'] = $result['user_id'];
            $data_log['log_type'] = 5;                 //参照config acccount_type 设置
            $data_log['is_in'] = 0;
            $data_log['price'] = $deduct_retmoney;
            $data_log['user_money'] = $usermoney;
            $data_log['memo'] = $lan['money'][17].',方案ID:'.$result['basic_id'];
            account_log::get_instance()->add($data_log);*/

            $order_num = date('YmdHis').rand(0, 99999);
            $moneys['BONUS_MONEY'] = $deduct_retmoney;
            $flagret = $moneyobj->add_money($result['user_id'], $deduct_retmoney, $moneys, 5, $order_num, $lan['money'][17].',方案ID:'.$basic_id_url);
            
            if ($flagret < 0)
                return  FALSE;            
        }

        
        //发起人奖金发放 
        $retmoney = 0;
        $retmoney = $result['my_copies'] * $bonus_one;
        
        /*$data_log = array();
        $usermoney = $userobj->get_user_money($result['user_id']);
        $data_log['order_num'] = date('YmdHis').rand(0, 99999);
        $data_log['user_id'] = $result['user_id'];
        $data_log['log_type'] = 5;                 //参照config acccount_type 设置
        $data_log['is_in'] = 0;
        $data_log['price'] = $retmoney;
        $data_log['user_money'] = $usermoney;
        $data_log['memo'] = $lan['money'][11].',方案ID:'.$result['basic_id'];
        account_log::get_instance()->add($data_log);*/
        $order_num = date('YmdHis').rand(0, 99999);
        $moneys['BONUS_MONEY'] = $retmoney;
        $flagret = $moneyobj->add_money($result['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][11].',方案ID:'.$basic_id_url);
        
        //更新发起方案的方案奖金
        $plan_basic = Plans_basicService::get_instance();
        $plan_basic->update_bonus($result['basic_id'], $retmoney+$deduct_retmoney);
        
        //d($retmoney);
        
        //参与合买人奖金发放
        $plans = $this->get_son_by_pid($result['id']);
        
        $retmoney = 0;
        foreach ($plans as $rowplan)
        {
			/*            $retmoney = $rowplan['my_copies'] * $bonus_one;
            $data_log = array();
            $usermoney = $userobj->get_user_money($rowplan['user_id']);
            $data_log['order_num'] = date('YmdHis').rand(0, 99999);
            $data_log['user_id'] = $rowplan['user_id'];
            $data_log['log_type'] = 5;                 //参照config acccount_type 设置
            $data_log['is_in'] = 0;
            $data_log['price'] = $retmoney;
            $data_log['user_money'] = $usermoney;
            $data_log['memo'] = $lan['money'][11].',方案ID:'.$rowplan['basic_id'];
            account_log::get_instance()->add($data_log);
            $plan_basic->update_bonus($rowplan['basic_id'], $retmoney);    //更新到基表存入个人奖金*/
        
            $retmoney = $rowplan['my_copies'] * $bonus_one;
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys['BONUS_MONEY'] = $retmoney;
            $flagret = $moneyobj->add_money($rowplan['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][11].',方案ID:'.$basic_id_url);                    
        
        }
        
        $this->update_status($result['id'], 5);    //更新方案状态
        
        return TRUE;
       
    }



    
    /*
     * 根据订单号获取信息
     */
    public function get_by_order_id($id)
    {
        return $this->get_by_basic_id($id);
    }
    
    /*
     * 根据方案id获取数据
     */
    public function get_by_plan_id($id)
    {
        return $this->get_by_id($id);
    }
	
	
	
	public function formatnumber($str) //格式化手机号码
	{ 
		$str = trim($str); 
		$str = strip_tags($str,"\r\n"); //函数剥去 HTML、XML 以及 PHP 的标签。
		$str = str_replace(" ","\r\n",$str);
		$str = str_replace(",","\r\n",$str);
		$str = str_replace("，","\r\n",$str);
		$str = str_replace(";","\r\n",$str);
		$str = str_replace("；","\r\n",$str);
		$str = str_replace("\t","\r\n",$str); 
		$str = str_replace("\r\n\r\n","\r\n",$str); 	
		return trim($str); 
	}
	
	
	//选择结果转换
	public function transform_codes($codes) {
		return str_replace(",","-",$codes);
	}
	//只有一注的情况下
	public function transform_codes1($codes) {
		return str_replace(",","",$codes);
	}	
	
	/**
	 * 方案是否公开0完全公开,1截止后公开,2仅跟单人可看
	 * @param unknown_type $plan_data
	 * @param unknown_type $is_join
	 */
	public function plan_open($plan_data, $is_join) {
		$r = '方案未公开';
		if ($plan_data != false) {
			$is_open = $plan_data['is_open'];
			$time_end = $plan_data['time_end'];
			$time_cur = time();
			switch($is_open) {
				case 0 : 
					$r = true;
					break;
				case 1 :
					if ($time_cur > strtotime($time_end)) {
						$r = true;
					}
					else {
						$r = '截止后公开';
					}
					break;
				case 2 :
					if ($is_join == true) {
						$r = true;
					}
					else {
						$r = '仅对参与者公开';
					}
					break;
				default:break;
			}
		}
		return $r;
	}
	
	/**
	 * 任9中8场，标记加奖状态
	 * 0不加1已加
	 * @param unknown_type $data
	 */
	public function update_r98_by_id($id, $status) {
		if (is_array($id) == true) {
			$where = ' id in ('.implode(',', $id).')';
		}
		else {
			$where = ' id="'.$id.'"';
		}
		$db = Database::instance();
		$query='update plans_sfcs set r98_jj="'.$status.'" where'.$where;
		$results = $db->query($query);
	}
	
	/**
	 * 任9中8场加奖
	 */
	public function add_bonus_r98($basic_id) {
		$add_money_obj = add_money::get_instance();
		$plan_info = $this->get_by_basic_id($basic_id);
		//d($plan_info);
		if ($plan_info != false) {
			$id = $plan_info['id'];
			$basic_id = $plan_info['basic_id'];
			$pid = $plan_info['parent_id'];
			$play_method = $plan_info['play_method'];
			$price = $plan_info['price'];
			$copies = $plan_info['copies'];
			$user_id = $plan_info['user_id'];
			$my_copies = $plan_info['my_copies'];
			
			//任9中奖送彩金
			if ($play_method == 2) {
				$add_money_total = $add_money_obj->get_bonus_add_money_zcr9_2($price);
			}
			else {
				$add_money_total = 0;
			}
			$add_money_one = $add_money_total / $copies;
			//$add_money_one = 0;
			$add_money_obj->bonus_add_money($user_id, $my_copies * $add_money_one, $basic_id);
			$this->update_r98_by_id($id, 1);
			
			$plans_son = $this->get_son_by_pid($id);
			if (count($plans_son) > 0) {
				for ($j = 0; $j < count($plans_son); $j++) {
					$id = $plans_son[$j]['id'];
					$user_id = $plans_son[$j]['user_id'];
					$my_copies = $plans_son[$j]['my_copies'];
					$add_money_obj->bonus_add_money($user_id, $my_copies * $add_money_one, $basic_id);
					//$this->update_r98_by_id($id, 1);
				}
			}
		}
	}
}


