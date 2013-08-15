<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plans_jclqService_Core extends DefaultService_Core 
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
        //if (empty($data))
        //    return FALSE;
        
        $obj = ORM::factory('plans_jclq');
        
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
    
    /*
     * 获取数据
     * 
     */
    public  function  get_by_id($user_id, $id)
    {
        $user_id = intval($user_id);
        $id = intval($id);
        
        if (empty($user_id) || empty($id))
            return  FALSE;

        $obj = ORM::factory('plans_jclq');

        $obj->where('id', $id)->where('user_id', $user_id);
        
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
     * 根据基表订单id获取数据
     * 
     */
    public  function get_by_order_id($id)
    {        
        if (empty($id))
            return  FALSE;
        
        $obj = ORM::factory('plans_jclq');
                
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
    
    
    /*
     * 根据基表订单id获取数据
     * 
     */
    public  function get_son_by_pid($id)
    {
        if (empty($id))
            return  FALSE;
        
        $obj = ORM::factory('plans_jclq')->where('parent_id', $id);
        $results = $obj->find_all();
        $return = array();
        foreach ($results as $result)
        {
            $return[] = $result->as_array();
        }
        
        return $return;
    }


    /*
     * 根据方案id获取数据
     * 
     */
    public  function  get_by_plan_id($id)
    {
        if (empty($id))
            return  FALSE;

        $obj = ORM::factory('plans_jclq');

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
    
    
    /*
     * 通过父ID获取数据
     * 
     */
    public  function  get_parent_id($id)
    {
        return $this->get_by_plan_id($id);
    }

    
    /*
     * 更改父类进度
     */
    public function update_parent_progress($id, $num, $progress)
    {
        $obj = ORM::factory('plans_jclq');
        $obj->where('id', $id);
        $result = $obj->find();
        
        if ($obj->loaded)
        {
            $obj->buyed = $num;
            $obj->surplus = $obj->zhushu - $num;
            $obj->progress = $progress;
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
     * 兑奖
     */
    public function check_bonus($result)	
	{	
	    $result['status'] = 1;     //状态(0,未开奖 1,已开奖)
	    $result['bonus'] = 0;      //奖金(默认为0)
	    return $result;
	}
    
    
	/*
	 * 根据输入的参数扯分彩票并存入彩票表
	 * @return true or false 
	 */
	public function get_tickets($plan_id, $play_method, $code, $typename, $special_num, $rate, $ordernum, $ret = FALSE)
	{
	    $ticket_type = 1;            //彩种
	    $tickets = array();
	    $arrtype = explode(',', $typename);
        $arrcode = explode("/", $code);
        $loop = count($arrcode);     //参数个数
        $price_count = 0;

        //d($special_num);
        //d($loop);
        //重构彩票尝试多张是否能转换成更少的彩票张数
        
        $limitnum = 0;
        if ($play_method == 3 || $play_method == 4)
        {
            $limitnum = 3;
        }
        elseif ($play_method == 2)
        {
            $limitnum = 6;
        }

        //当胆码不为空时开始过滤
        
        //d($arrcode, false);
        //d($arrtype, false);
        
        ticket_operation::get_instance()->change_code_jclq(&$arrcode, &$arrtype, $limitnum, $special_num);
        $ticketobj = ticket::get_instance();
        
        //d($arrcode, false);
        //d($arrtype, false);
        //d(true);
        //比分和半全场是特殊情况最多3串N
        
        //多串过关
        if (count($arrtype) == 1)
        {
            $typename = implode('串', $arrtype);
            $arrtmp = $arrtype;
            $arrtmp = explode('串', $typename);
            
            if ($arrtmp[0] >= $loop)
            {
                $code .= ';'.$typename;
                $money = $this->ticket_count($code) * 2 * $rate;
                
                if (!$ret)
                {
                    $ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
                    return TRUE;
                }
                else
                {
                    $return = array();
                    $return[0]['money'] = $money;
                    $return[0]['rate'] = $rate;
                    $return[0]['code'] = $code;
                    return $return;
                }
            }
        }
        elseif ($typename == '单关')        //单关投注
        {
            $code .= ';'.$typename;
            $money = $this->ticket_count($code) * 2 * $rate;

            if (!$ret)
            {
                $ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
                return TRUE;
            }
            else
            {
                $return = array();
                $return[0]['money'] = $money;
                $return[0]['rate'] = $rate;
                $return[0]['code'] = $code;
                return $return;
            }
        }
        else 
        {
            
        }

        $arrtmp = explode('串', $arrtype[0]);
        $bx = $arrtmp[0];
        $ex = $arrtmp[1];
        
        
        $results = array();
        foreach ($arrtype as $rowtype)
        {
            $arrtmp = explode('串', $rowtype);
            $bx = $arrtmp[0];
            $ex = $arrtmp[1];
            $results[$rowtype] = tool::get_combination($arrcode, $bx);
        }
                
		$arrnew = array();
        //当选择胆码时过滤
        if (!empty($special_num))
        {
            $arrspe = explode('/', $special_num);

            foreach ($results as $key => $value)
            {                    
                foreach ($value as $rowvalue)
                {
                    $check = TRUE;
                    foreach ($arrspe as $rowspe)
                    {   
                        $search = strstr($rowvalue, $rowspe);
                        if(empty($search))
                        {
                            $check = FALSE;
                            break; 
                        }
                    }
                    if ($check)
                        $arrnew[] = $rowvalue.";".$key;
                }
            }
        }
                        
        if (empty($arrnew))
        {
            $tmp = array();
            foreach ($results as $keyres => $rowres)
            {
                foreach ($rowres as $row)
                {
                    $tmp[] = $row.";".$keyres;
                }
            }
            $arrnew = $tmp;
            unset($tmp);
        }
                
        if (!$ret)
        {
            foreach ($arrnew as $rownew)
            {
                //计算价格
                $money = $this->ticket_count($rownew) * 2 * $rate;
                //d($money);
                $ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $rownew, $rate, $ordernum, $money);
            }
            return TRUE;
        }
        else
        {
            $return = array();
            $i = 0;
            foreach ($arrnew as $rownew)
            {
                //计算价格
                $money = $this->ticket_count($rownew) * 2 * $rate;
                $return[$i]['money'] = $money;
                $return[$i]['rate'] = $rate;
                $return[$i]['code'] = $rownew;
                $i++;
            }
            return $return;
        }
	}
	
	//
	public function ticket_count($code)
	{
        $arrcode = explode(";", $code);
        $arrcode[0] = str_replace("],", "]/", $arrcode[0]);
        $arrcode[0] = str_replace("[", ":[", $arrcode[0]);
        $return = ticket_operation::get_instance()->zhushu($arrcode[0], $arrcode[1]);
        return $return;
	}
	
	
    /*
     * 更改状态同时更改子类状态,更改合买中的参与人状态
     */
    public function update_status($id, $status)
    {
        $obj = ORM::factory('plans_jclq');
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
                
                //更新子方案的状态
                $son_results = $this->get_son_by_pid($id);
                if (!empty($son_results))
                {
                    foreach ($son_results as $rowson)
                    {
                        $obj_son = ORM::factory('plans_jclq', $rowson['id']);
                        $obj_son->status = $status;
                        $obj_son->save();
                        $basicobj->update_status($obj_son->basic_id, $status);
                    }
                }
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
     * 彩票退款处理
     * @param  integer  $ordernum  订单号码 <正常只为代购或合买的方案,若有参与合买则是错的>
     * @param  integer  $money  退还金额
     * @return array 以用户id为索引,所返还的金额为值
     */
    public function refund_by_ticket($ordernum, $money)
    {
        $result = $this->get_by_order_id($ordernum);
        if (empty($result))
            return FALSE;
        
        $return = array();    
        
        if ($result['plan_type'] == 0)
        {
            $return[$result['user_id']] = $money;
        }
        else 
        {
            $money_one = $money / $result['zhushu'];        	    //每份价格
            $return[$result['user_id']] = $result['my_copies'] * $money_one;
            
            $plans = $this->get_son_by_pid($result['id']);
            
            foreach ($plans as $rowplan)
            {
                if (!empty($return[$rowplan['user_id']]))
                {
                    $return[$rowplan['user_id']] += $rowplan['my_copies'] * $money_one;
                }
                else 
                {
                    $return[$rowplan['user_id']] = $rowplan['my_copies'] * $money_one;
                }
            }
        }
        
        return $return;
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
        //当保底数量小于剩余数量此处不做处理
        if ($result['baodinum'] < $result['surplus'])
        {
            return FALSE;
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

        //将保底数量移除剩余的数量加入到我购买的份数中,并将剩余的金额返回
        $obj = ORM::factory('plans_jclq', $result['id']);
        
        $obj->my_copies = $obj->my_copies + $result['surplus'];
        $obj->buyed = $obj->buyed + $result['surplus'];
        
        $backnum = $obj->baodinum - $result['surplus'];        //多余的保底数量
        
        $obj->surplus = $obj->surplus - $result['surplus'];
        $obj->baodinum = $result['surplus'];	               //只是个记录
        $obj->save();
        
        if ($obj->saved)
        {
            $lan = Kohana::config('lan');
            $moneyobj = user_money::get_instance();
            //返回多余的保底金额
            $retmoney = $backnum * $obj->price_one;
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys['USER_MONEY'] = $retmoney;
            $moneyobj->add_money($result['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][10].',方案ID:'.$result['basic_id']);              

            //生成彩票
            $this->get_tickets($obj->id, $obj->play_method, $obj->codes, $obj->typename, $obj->special_num, $obj->rate, $obj->basic_id);
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
/*        if ($result['status'] != 0 || $result['status'] != 1 )
        {
            return FALSE;
        }*/
        
        $userobj = user::get_instance();
        $total_price = $result['total_price'];
        
        //退还保底及购买份数金额
        $moneyobj = user_money::get_instance();
        $moneys = $moneyobj->get_con_by_order_num($ordernum);
        
        if (empty($moneys))
            return FALSE;
            
        $lan = Kohana::config('lan');
        $retmoney = $result['price_one'] * $result['baodinum'] + $result['price_one'] * $result['my_copies'];
        $order_num = date('YmdHis').rand(0, 99999);
        $flagret = $moneyobj->add_money($result['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][9].',方案ID:'.$result['basic_id']);
        
        if ($flagret < 0)
            return FALSE;
        
        //返还参与合买的
        $plans = $this->get_son_by_pid($result['id']);
        
        foreach ($plans as $rowplan)
        {
            $retmoney = $rowplan['my_copies'] * $result['price_one'];
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys = $moneyobj->get_con_by_order_num($rowplan['basic_id']);
            $moneyobj->add_money($rowplan['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][9].',方案ID:'.$result['basic_id']);            
        }
        
        $this->update_status($result['id'], 6);    //更新方案状态
        
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
        
        $total_price = $result['total_price'];            //总金额
        $total_bonus = $result['bonus'];                  //总奖金
        $bonus_one = $total_bonus / $result['zhushu'];    //单份奖金
        
        $userobj = user::get_instance();
        
        $lan = Kohana::config('lan');
        $moneyobj = user_money::get_instance();
        
		//中奖送彩金
        $add_money_obj = add_money::get_instance();
        $add_money_total = $add_money_obj->get_bonus_add_money_jclq($total_bonus);
        $add_money_one = $add_money_total / $result['zhushu'];
        //$add_money_one = 0;
        
        //发起人提成派发;
        $deduct_retmoney = 0 ;
        if ($result['deduct'] > 0)
        {
            $profitmoney = $total_bonus - $total_price;        //利润
            if ($profitmoney > 0)
            {
                //$deduct_retmoney =  $profitmoney * $result['deduct'] / 100;       //提成
                $deduct_retmoney =  $total_bonus * $result['deduct'] / 100;       //若方案盈利(即税后奖金大于方案本金)，则发起人先提成税后奖金的x％作为方案制作佣金
                $total_bonus = $total_bonus - $deduct_retmoney;                   //重构总奖金,总奖金减去提成金额
                $bonus_one = $total_bonus / $result['zhushu'];                    //重构单份奖金
            }
        }
        
        //d($result, false);
        
        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        $basic_id_url = '<a href="http://'.$data['site_config']['name'].'/jclq/viewdetail/'.$result['basic_id'].'" target="_blank">'.$result['basic_id'].'</a>';
        //当提成大于0则添加记录
        if ($deduct_retmoney > 0)
        {
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys['BONUS_MONEY'] = $deduct_retmoney;
            $flagret = $moneyobj->add_money($result['user_id'], $deduct_retmoney, $moneys, 5, $order_num, $lan['money'][17].',方案ID:'.$basic_id_url);
            if ($flagret < 0)
                return  FALSE;
        }
        
        //d($deduct_retmoney, false);
        
        //发起人奖金发放 
        $retmoney = 0;
        $retmoney = $result['my_copies'] * $bonus_one;

        $order_num = date('YmdHis').rand(0, 99999);
        $moneys['BONUS_MONEY'] = $retmoney;
        $flagret = $moneyobj->add_money($result['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][11].',方案ID:'.$basic_id_url);
        
        //更新发起方案的方案奖金
        $plan_basic = Plans_basicService::get_instance();
        $plan_basic->update_bonus($result['basic_id'], $retmoney+$deduct_retmoney);
        //$plan_basic_info = $plan_basic->get_by_ordernum($result['basic_id']);
        
		//中奖送彩金        
		$add_money_obj->bonus_add_money($result['user_id'], $result['my_copies'] * $add_money_one, $result['basic_id']);
        
        //d($retmoney);
        
        //参与合买人奖金发放
        $plans = $this->get_son_by_pid($result['id']);
        
        $retmoney = 0;
        foreach ($plans as $rowplan)
        {
            $retmoney = $rowplan['my_copies'] * $bonus_one;
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys['BONUS_MONEY'] = $retmoney;
            $flagret = $moneyobj->add_money($rowplan['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][11].',方案ID:'.$basic_id_url);            
            $plan_basic->update_bonus($rowplan['basic_id'], $retmoney);    //更新到基表存入个人奖金
            //中奖送彩金        
			$add_money_obj->bonus_add_money($rowplan['user_id'], $rowplan['my_copies'] * $add_money_one, $result['basic_id']);
        }
        
        $this->update_status($result['id'], 5);    //更新方案状态
        
        return TRUE;
       
    }
    
    /**
     * 扫描竞彩足球，更新赛果
     * Enter description here ...
     */
    public function get_plans_result() {
    	$jclq_result_config = Kohana::config('jclq');
    	$db = Database::instance(); 
    	$match_detail_obj = match::get_instance();
    	
    	d('======开始更新赛果', FALSE);
    	
    	//$query = 'SELECT id,basic_id,play_method,codes FROM plans_jclqs where parent_id=0 and status=2 and match_results is null';
    	$query = 'SELECT id,basic_id,play_method,codes FROM plans_jclqs where parent_id=0 and match_results is null';
    	//d($query, FALSE);
    	
    	$plans = $db->query($query);
    	$match_result = array();
    	$match_id = array();
    	//$return = array();
    	//$result_config = array();
    	$ii = 0;
    	
	    foreach ($plans as $plan) {
	        //$ii++;
	    	$plan_id = $plan->id;
	    	$order_num = $plan->basic_id;
	    	
	    	d($plan_id, FALSE);
	    	
	    	$plan_result = array();
	    	$play_method = $plan->play_method;
	    	switch ($play_method) {
	    		case '1': $result_key = 0; $result_config = array_flip($jclq_result_config['spf']['result_cn']); break;
	    		case '2': $result_key = 2; $result_config = $jclq_result_config['zjqs']['result_type']; break;
	    		case '3': $result_key = 1; break;
	    		case '4': $result_key = 3; $result_config = $jclq_result_config['bqc']['result_type_r']; break;
	    		default: break;
	    	}
	    	$codes = $plan->codes;
		    $matchs = explode('/', $codes);
		    $matchs_count = count($matchs);
		    $flag = 0;
		    //订单里的赛事信息
		    for ($i = 0; $i < $matchs_count; $i++) {
		    	$match_info = explode('|', $matchs[$i]);
		    	$match_index_id = $match_info[0];
		    	//echo $match_index_id;
		    	//d($match_result);
		    	//var_dump($match_result);
		    	$result = $match_detail_obj->get_match_detail($match_index_id);
		    	//赛果已经存在
		    	if (!array_key_exists($match_index_id, $match_result)) {
		    	    //d($match_result);
			    	//$result = $match_detail_obj->get_match_detail($match_index_id);
			    	if ($result['result'] != NULL) {
			    		$match_result[$result['index_id']] = $result['result'];
			    		$match_result_array = explode('|', $result['result']);
			    		if (isset($result_key)) {
			    			$match_result_value = $match_result_array[$result_key];
			    			if (isset($result_config)) {
			    				if (!isset($result_config[$match_result_value])) {
			    					$match_result_value_r = $match_result_value;
			    				}
			    				else {
			    					$match_result_value_r = $result_config[$match_result_value];
			    				}
			    			}
			    			else {
			    				$match_result_value_r = $match_result_value;
			    			}
			    			$plan_result[] = $match_index_id.'|'.$match_result_value_r;
			    			$flag++;
			    		}
			    	}
		    	}
		    	//赛果已经存在
		    	else {
		    		$t = $match_result[$result['index_id']];
		    		$match_result_array = explode('|', $t);
		    		if (isset($result_key)) {
		    			$match_result_value = $match_result_array[$result_key];
		    			if (isset($result_config)) {
		    				if (!isset($result_config[$match_result_value])) {
		    					$match_result_value_r = $match_result_value;
		    				}
		    				else {
		    					$match_result_value_r = $result_config[$match_result_value];
		    				}
		    			}
		    			else {
		    				$match_result_value_r = $match_result_value;
		    			}
		    			$plan_result[] = $match_index_id.'|'.$match_result_value_r;
		    			$flag++;
		    		}
		    	}
		    }
		    $plan_result_s = implode(',', $plan_result);
		    //echo $plan_result_s;
		    $ii = 0;
		    if ($flag == $matchs_count) {
		    	$ii++;
		    	//订单里赛事的赛果已全部更新
		    	$update_query = 'update plans_jclqs set match_results="'.$plan_result_s.'" where id="'.$plan_id.'"';
    			$db->query($update_query);
    			d($update_query, FALSE);
    			//$return[$order_num] = $plan_result;
		    }
		}
	    
		d('更新了 '.$ii.' 个方案赛果', FALSE);
		return TRUE;
    }

  
    
    /*
     * 自动兑奖
     * @param  integer  $plan_id  方案id
     * @param  string	$match_result 赛果
     * @return TRUE OR FALSE
     */
    public function bonus_count()
    {
        $obj = ORM::factory('plans_jclq');
        $obj->where('status', 2)->where('match_results <>', '');
        $results = $obj->find_all();
                
        $ticketobj = ticket::get_instance();        
        
        $plans = array();
        foreach($results as $row)
        {
            $plans[] = $row->as_array();
        }

        if (empty($plans))
            return FALSE;

        foreach ($plans as $rowplan)
        {
            $ticket_results = $this->bonus_ticket_count($rowplan);
            //d($ticket_results, FALSE);
            //所有彩票
            foreach ($ticket_results as $rowticket)
            {
                //d($rowticket);
                //更新彩票状态及奖金
                $ticketobj->update_bonus($rowticket['id'], $rowticket['bonus']);
            }
            //d($ticket_results, false);
        }
    }  
    
    /*
     * 统计指定方案中中奖的彩票信息,并以数组形式返回
     * @param  array  $plan  方案信息数组
     * @return array  彩票及彩票扯分的组合数据
     */
    public function bonus_ticket_count($plan)
    {
        $test_open = FALSE;    //调试开关
        $is_hidden = FALSE;    //隐藏

        if (empty($plan))
            return FALSE;

        //无赛果的方案则返回
        if (empty($plan['match_results']))
            return FALSE;
        
        if ($test_open && $is_hidden)
        {
            echo '<!--';
        }
            
        $test_open && d('=======方案信息:', FALSE); 
        $test_open && d($plan, FALSE);   
            
        $match_result = $plan['match_results'];     //赛果       
        $match_code = $plan['codes'];               //选项
        
        $arrmatch_result = explode(',', $match_result);    //赛果       
        $arrmatch_code = explode('/', $match_code);        //选项

        /*
         * 重构赛果 重构成格式如下,用于中奖匹配
         *  Array
            (
                [0] => 23509|3012[0-0]
                [1] => 23510|3013[1-1]
                [2] => 23511|3014[1-0]
                [3] => 23512|3015[3-1]
                [4] => 23515|3018[1-1]
            )
         */
        foreach ($arrmatch_code as $rowkey => $rowmatch)
        {
            $arrtmp = explode('|', $rowmatch);
            $arrtmp2 = explode('[', $rowmatch);
                        
            foreach ($arrmatch_result as $keyresult => $rowresult)
            {
                if (strstr($rowresult, $arrtmp[0]))
                {
                    $arrmatch_result[$keyresult] = $arrtmp2[0].'['.end(explode('|',$rowresult)).']';
                    continue;
                }    
            }
        }
        
        $test_open && d('=======重构的赛果:', FALSE);
        $test_open && d($arrmatch_result, FALSE);
        
        $ticketobj = ticket::get_instance();
        $results = $ticketobj->get_results_by_ordernum($plan['basic_id']);    //获取彩票
                
        if (empty($results))
            return FALSE;
        
        $return = array();
        $ii = 0;
        foreach ($results as $rowresult)
        {
            if(empty($rowresult))
                continue;
            
            $arrodds = explode('|', $rowresult['moreinfo']);    //赔率
            $codes = explode(';', $rowresult['codes']);         //彩票代码
            $arrcodes = explode('/', $codes[0]);                
            
            $test_open && d('=======检测彩票赔率是否正常:', FALSE);
            $test_open && d(count($arrcodes).'****'.count($arrcodes), FALSE);
            
            if (count($arrcodes) != count($arrodds))            //当赔率的数量与投注彩票的数量不为空为异常跳出
                continue;
                
            /*
             * 重构赔率,用于兑奖计算
             * 重构成 格式如:
             * 		Array
					(
    					[23509|3012[0:2]] => 10.50
    					[23510|3013[3:0]] => 7.50
					)
             * 
             * 
             */   
            $ticket_odds = array();                            
            $i = 0;
            foreach ($arrcodes as $rowvalue => $rowcode)
            {  
                if (substr_count($rowcode, ',') > 0)
                {
                    $arrtestcode1 = explode('[', $rowcode);
                    $arrtestcode[1] = substr($arrtestcode1[1], 0, strlen($arrtestcode1[1])-1);
                    $arrtestcode = explode(',', $arrtestcode[1]);
                    
                    $arrtestodds = explode(':', $arrodds[$rowvalue]);
                    $arrtestodds = explode(',', $arrtestodds[1]);

                    foreach ($arrtestcode as $keypull => $rowpull)
                    {
                        if (empty($arrtestodds[$keypull]))
                        {
                            d('data error:', FALSE);
                            d($plan['basic_id'], FALSE);
                            d($match_code, FALSE);
                            continue 3;
                        }
                        else 
                        {
                            $ticket_odds[$arrtestcode1[0].'['.$rowpull.']'] = $arrtestodds[$keypull];
                        }
                    }
                }
                else
                {
                    $ticket_odds[$rowcode] = end(explode(':', $arrodds[$i]));
                }
                $i++;
            }
            $test_open && d('=======重构的赔率:', FALSE);
            $test_open && d($ticket_odds, FALSE);
            
            /*
             * 扯分的彩票
             * 由于所选择的彩票中一场可以有多个彩票,为了计算奖金需要拆分计算
             * 重新组合
             */
            $ticketdetail = array();
            $ticketdetail = $ticketobj->get_jczq_note($rowresult['codes']);
            
            $test_open && d('=======扯分的彩票:', FALSE);
            $test_open && d($ticketdetail, FALSE);
            
            $tickets_bonus_detail = array();
            
            //提取中奖的组合
            foreach ($ticketdetail as $rowdetail)
            {
                $arrdetail = explode('/', $rowdetail);
                $is_bonus = TRUE;
                foreach ($arrdetail as $rowdetaildetail)
                {
                    $test_open && d('=======匹配中奖:', FALSE);
                    $test_open && d($rowdetaildetail, FALSE);
                    $test_open && d('=======中奖的信息:', FALSE);
                    $test_open && d($arrmatch_result, FALSE);
                    
                    if (!in_array($rowdetaildetail, $arrmatch_result))
                    {
                        $is_bonus = FALSE;
                        break;                    
                    }
                }
                
                $test_open && d('=======是否中奖:', FALSE);
                $test_open && d($is_bonus, FALSE);
                
                if ($is_bonus)
                {
                    $tickets_bonus_detail[] = $rowdetail;
                }
            }
            
            $tickets_detail_result = array();
            
            //对中奖的组合兑奖
            $i = 0;
            $allbonus = 0;
            foreach ($tickets_bonus_detail as $bonus_detail)
            {
                $bonus = 2;
                $arrdetails = explode('/', $bonus_detail);
                foreach ($arrdetails as $rowdetails)
                {
                    $bonus *= $ticket_odds[$rowdetails];
                }
                $bonus *= $rowresult['rate'];        //剩上倍数
                $tickets_detail_result[$i][0] = $bonus_detail;
                $tickets_detail_result[$i][1] = $bonus;
                
                $allbonus += $bonus;
                $i++;
            }
            
            if ($allbonus > 0 && $rowresult['rate'] > 1)
            {
                $return[$ii]['bonus_one'] = $allbonus/$rowresult['rate'];
            }
            else 
            {
                $return[$ii]['bonus_one'] = $allbonus;
            }
            
            //控制最高奖金额度(2场或3场过关投注，单注最高奖金限额20万元。4场或5场过关投注，单注最高奖金限额50万元。6场及6场以上过关投注，单注最高奖金限额100万元。)
            if ($return[$ii]['bonus_one'] > 200000)
            {
                $selecount = count($arrcodes);
                switch ($selecount)
                {
                    case 2:
                    case 3:
                        $return[$ii]['bonus_one'] = 200000;
                        break;
                    case 4:
                    case 5:
                        if ($return[$ii]['bonus_one'] > 500000)
                        {
                            $return[$ii]['bonus_one'] = 500000;
                        }
                        break;
                    default:
                        if ($return[$ii]['bonus_one'] > 1000000)
                        {
                            $return[$ii]['bonus_one'] = 1000000;
                        }
                }
            }
            
            //个人所得税
            if ($return[$ii]['bonus_one'] > 10000)
            {
                $return[$ii]['bonus_one'] *= 0.8;
            }
            $allbonus = $return[$ii]['bonus_one'] * $rowresult['rate'];

            $return[$ii]['detail'] = $tickets_detail_result;    //中奖扯分明细
            $return[$ii]['bonus'] = $allbonus;                  //当前彩票总奖金
            $return[$ii]['result'] = $rowresult;                //当前彩票记录
            $return[$ii]['odds'] = $ticket_odds;                //当前彩票赔率
            $return[$ii]['id'] = $rowresult['id'];              //当前彩票id
            $return[$ii]['plan'] = $plan;                       //当前彩票的方案信息
            $ii++;
        }
        
        //$test_open && d('=======返回结果:', FALSE);
        //$test_open && d($return);
        
        if ($test_open && $is_hidden)
        {
            echo '-->';
        }
        
        return $return;
    }
    
    
    /*
     * 扫描彩票表赔率
     * @param  array  $plan  方案信息数组
     * @return array  赔率的组合
     */
    public function get_odds_by_ordernum($plan)
    {
        if (empty($plan))
            return FALSE;
            
        $ticketobj = ticket::get_instance();
        $results = $ticketobj->get_results_by_ordernum($plan['basic_id']);
        
        if (empty($results))
            return FALSE;
                
        $retodds = array();
        foreach ($results as $result)
        {
            $arrcode = explode(';', $result['codes']);
            $arrcode = explode('/', $arrcode[0]);
            $arrodds = explode('|', $result['moreinfo']);
            
            if (count($arrcode) != count($arrodds))
                continue;

            foreach ($arrcode as $keycode => $valuecode)
            {
                $retodds[$valuecode] = end(explode(':', $arrodds[$keycode]));
            }
            
        }
                
        $return = array();
        //再次扯分选项
        foreach ($retodds as $keyodds => $valueodds)
        {
            $tmpkey = explode('[', $keyodds);
            $tmpkey[1] = substr($tmpkey[1], 0, strlen($tmpkey[1])-1);
            $arrkey = explode(',', $tmpkey[1]);
            $arrvalue = explode(',', $valueodds);
            
            foreach ($arrkey as $arrkeykey => $arrkeyvalue)
            {
                if (empty($arrvalue[$arrkeykey]))
                    continue 2;
                $return[$tmpkey[0].'['.$arrkeyvalue.']'] = $arrvalue[$arrkeykey];
            }
        }
        

        return $return;      
    }
    
    
}
