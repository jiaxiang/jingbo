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
	    $ticket_type = 6;            //彩种
	    $tickets = array();
	    $arrtype = explode(',', $typename);
        $arrcode = explode("/", $code);
        $loop = count($arrcode);     //参数个数
        $price_count = 0;

        //d($special_num);
        //d($loop);
        //重构彩票尝试多张是否能转换成更少的彩票张数
        
        //比赛限制场次
        $limitnum = 0;
        if ($play_method == 3)
        {
            $limitnum = 4;
        }
        elseif ($play_method == 2 || $play_method == 4)
        {
            $limitnum = 8;
        }
//d($limitnum.'/'.$play_method, false);
        //当胆码不为空时开始过滤
        
        //d($arrcode, false);
//d($arrtype, false);
        $ticket_zhushu = ticket_operation::get_instance();
        $ticket_zhushu->change_code_jclq(&$arrcode, &$arrtype, $limitnum, $special_num);
        $ticketobj = ticket::get_instance();
        
        //d(true);
        //比分和半全场是特殊情况最多3串N
//d($typename, false);
//d($arrtype, true);
        //多串过关
        if (count($arrtype) == 1 && $typename != '单关')
        {
            $typename = implode('串', $arrtype); //这句话无用
            $arrtmp = $arrtype;   //这句话无用
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
//d($code.'<br/>'.$money);
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
        //$arrtmp = explode('串', $arrtype[0]); //这句话无用
        //$bx = $arrtmp[0]; //这句话无用
        //$ex = $arrtmp[1]; //这句话无用
        
        $results = array();
        foreach ($arrtype as $rowtype)
        {
			if ($rowtype == '单关') {
        		$zhushu = $ticket_zhushu->zhushu($code, $rowtype);
            	$money = intval($zhushu) * intval($rate) * 2;
        		$code .= ';'.$rowtype;
        		if (!$ret) {
//        			if ($loop > $max_num_dg) {  //参考bjdcService
//	            		for ($i = 0; $i < $loop; $i++) {
//	            			$zhushu = $ticket_zhushu->zhushu($arrcode[$i], $rowtype);
//				            $money = intval($zhushu) * intval($rate) * 2;
//				            $code = $arrcode[$i].';'.$rowtype;
//	            			$ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
//	            		}
//	            	}
//	            	else {
            		$ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
//	            	}
        		}
        		else {
        			$results[$rowtype] = tool::get_combination($arrcode, 1, '/');
        		}
        	}
        	else {
	            $arrtmp = explode('串', $rowtype);
	            $bx = $arrtmp[0];
	            $ex = $arrtmp[1];
	            $results[$rowtype] = tool::get_combination($arrcode, $bx, '/');
        	}
		}
//d($results, false);
		$arrnew = array();
        //当选择胆码时过滤
        if (!empty($special_num))
        {
            $arrspe = explode('/', $special_num);

            foreach ($results as $key => $value)
            {   
            	if ($key === '单关') {continue;}              
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
//d($arrnew, false);
        if (!$ret)
        {
            foreach ($arrnew as $rownew)
            {
                //计算价格
                $money = $this->ticket_count($rownew) * 2 * $rate;
//d($rownew, false);
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
            //return FALSE;
        	$sd_config = Kohana::config('site_config.hm_sd');
        	$buyed = $result['buyed'] + $result['baodinum'];
        	$sd_limit = $result['zhushu'] * $sd_config['sd_limit_buyed'];
        	if ($buyed >= $sd_limit) {
        		$sd_num = $result['zhushu'] - $buyed;
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
        		$databasic['ticket_type'] =  6;
        		$databasic['play_method'] = $result['play_method'];
        		$databasic['plan_type'] = 2;
        		$data['price'] = $sd_money;
        		$plans_basic_obj = Plans_basicService::get_instance();
        		$basic_id = $plans_basic_obj->add($databasic);
        		$data['ticket_type'] =  $databasic['ticket_type'];
        		$data['play_method'] = $databasic['play_method'];
        		$data['parent_id'] = $result['id'];
        		$data['basic_id'] = $basic_id;
        		$data['user_id'] = $sd_userid;
        		$data['codes'] = $result['codes'];
        		$data['special_num'] = $result['special_num'];
        		$data['typename'] = $result['typename'];
        		$data['price_one'] = $data['price'];
        		$data['my_copies'] = $sd_num;
        		$data['rate'] = 1;
        		$data['plan_type'] = 2;
        		$data['status'] = 1;
        		$data['time_end'] = $result['time_end'];
        		if (!($id = $this->add($data))) {
        			return FALSE;
        		}
        		else {
        			$data_log = array();
        			$data_log['order_num'] = $basic_id;
        			$data_log['user_id'] = $sd_userid;
        			$data_log['log_type'] = 2;                 //参照config acccount_type 设置
        			$data_log['is_in'] = 1;
        			$data_log['price'] = $data['price'];
        			$data_log['user_money'] = $sd_usermoney;
        			 
        			$lan = Kohana::config('lan');
        			$data_log['memo'] = $lan['money'][26].',订单ID:'.$result['basic_id'];
        			account_log::get_instance()->add($data_log);
        			 
        			//更新父类进度
        			$parent_num = $sd_num + $result['buyed'];
        			$parent_progress = intval($parent_num / $result['zhushu'] * 100);
        			$this->update_parent_progress($result['id'], $parent_num, $parent_progress);
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
            //$moneys['USER_MONEY'] = $retmoney;
            
            $retmoneystru = $moneyobj->get_stru_by_order_num($result['basic_id']); //获取资金结构体
            if (empty($retmoneystru))
            {
                $retmoneystru['USER_MONEY'] = 1;
                $retmoneystru['BONUS_MONEY'] = 0;
                $retmoneystru['FREE_MONEY'] = 0;
            }
            
            d($retmoneystru, false);
            
            $moneys['USER_MONEY'] = $retmoney * $retmoneystru['USER_MONEY'];
            $moneys['BONUS_MONEY'] = $retmoney * $retmoneystru['BONUS_MONEY'];
            $moneys['FREE_MONEY'] = $retmoney * $retmoneystru['FREE_MONEY'];
            
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
        }
        
        $this->update_status($result['id'], 5);    //更新方案状态
        
        return TRUE;
       
    }
    
    /**
     * 扫描竞彩篮球，更新赛果
     * 更新plans_jclqs 的 match_results 字段
     * 格式：
     * 	sf:   26183:1|26184:2|26185:2
     * 	rfsf: 26183(+1.5:2/+2.5:2/+3.5:2)|26184(+3.5:1/+4.5:1)|26185(+12.5:2/+13.5:2)
     * 	sfc:  26183:12|26184:01|26185:16
     * 	dxf:  26183(158.5:2/159.5:2)|26184(153.5:2/154.5:2)|26185(154.5:1/155.5:2)
     */
    public function get_plans_result() 
    {
		$jclq_result_config = Kohana::config('jclq');
		$db = Database::instance();
		$match_detail_obj = match::get_instance();
		
d('======开始更新赛果', FALSE);
		
		//$query = 'SELECT id,basic_id,play_method,codes FROM plans_jclqs where parent_id=0 and status=2 and match_results is null';
		$query = 'SELECT id, basic_id, play_method, codes FROM plans_jclqs '
		.'WHERE parent_id=0 AND match_results IS NULL AND status =2';
//d($query, FALSE);
    	
		$plans = $db->query($query);
		$match_detail_cache = array();
		$match_id = array();
		//$return = array();
		//$result_config = array();
		$ii = 0;
		
//		echo 'plans count = '.count($plans).'<br/>';
		
		$updateCount = 0;	// count of updated plans
	    foreach ($plans as $plan) 
	    {
	        //$ii++;
			$plan_id = $plan->id;
	    	$order_num = $plan->basic_id;
	    	
	    	d($order_num, FALSE);
	    	
	    	$plan_result = array();
	    	$play_method = $plan->play_method;
//d($play_method, FALSE);
	    	switch ($play_method) 
	    	{
	    		case '1': $result_key = 0; $result_config = array_flip($jclq_result_config['spf']['result_cn']); break;
	    		case '2': $result_key = 1; $result_config = $jclq_result_config['rfsf']['result_cn2']; break;
	    		case '3': $result_key = 2; $result_config = array_flip($jclq_result_config['sfc']['result_type']); break;
	    		case '4': $result_key = 3; $result_config = $jclq_result_config['dxf']['result_cn2']; break;
	    		default: break;
	    	}
	    	
//d($result_config, false);
	    	$codes = $plan->codes;
//d($codes, FALSE);
		    $matchs = explode('/', $codes);
		    $matchs_count = count($matchs);
		    $flag = 0;
			//订单里的赛事信息
			for ($i = 0; $i < $matchs_count; $i++) 
		    {
		    	$match_info = explode('|', $matchs[$i]);
		    	$match_index_id = $match_info[0];
//d($match_index_id, false);
		    	$choose_match_res = explode('[', $match_info[1]);
		    	$choose_match_result = substr($choose_match_res[1], 0, -1);
		    	
//d($choose_match_result, false);
		    	
		    	// get match_detail
		    	$aMatchDtl = null;
		    	if (array_key_exists($match_index_id, $match_detail_cache)) {
					$aMatchDtl = $match_detail_cache[$match_index_id];
		    	} 
		    	else {
			    	$aMatchDtl = $match_detail_obj->get_match_detail($match_index_id);
			    	if ($aMatchDtl == NULL) {
			    		echo 'down: get_match_detail null. <br/>';
			    		continue;
			    	}
					$match_detail_cache[$aMatchDtl['index_id']] = $aMatchDtl;
		    	}
		    	
//d($aMatchDtl, FALSE);
		    	if ($aMatchDtl['result'] == NULL || $aMatchDtl['result'] == ''){
		    		echo 'mid='.$aMatchDtl['index_id'].'match result is null.  <br/>';
		    		continue;
		    	}
		    	
				//d($match_result);
//d($result_key, false);
		    	$aSubResult = null;	// codes中一场match对应的赛果
				if (isset($result_key)) 
	    		{
	    			if ($aMatchDtl['result'] == 'cancel') {
	    				$choose_match_result_arr = explode(',', $choose_match_result);
	    				$match_result_value_r = $choose_match_result_arr[0];
	    				$aSubResult = $match_index_id.':'.$match_result_value_r;
					}
					else 
					{
						$match_result_array = explode('|', $aMatchDtl['result']);
		    			$match_result_value = $match_result_array[$result_key];
						
		    			$goallineString = '';
		    			//对比赛结果进行处理，以匹配$result_config
						if ($play_method == 1) {	// 胜负
							$match_result_value_r = $match_result_value;
							if (isset($result_config) && 
								isset($result_config[$match_result_value])) 
							{
								$match_result_value_r = $result_config[$match_result_value];
			    			}
			    			$aSubResult = $match_index_id.':'.$match_result_value_r;
						}
						
		    			elseif ($play_method == 2 ) { //让分胜负
		    				//保存多个赛果
		    				$rfsf_result_array = explode('/', $match_result_value);
		    				//处理goalline
		    				$goallineString = '';
		    				foreach ($rfsf_result_array as $aMatchResult)
		    				{
		    					$theGoalline = mb_substr($aMatchResult, 4);
		    					$theCnResult = mb_substr($aMatchResult, 0, 4);
								if (isset($result_config) && 
									isset($result_config[$theCnResult])) 
								{
									$theCnResult = $result_config[$theCnResult];
				    			}
				    			$goallineString .= $theGoalline.':'.$theCnResult.'/';
		    				}
		    				$goallineString = mb_substr($goallineString, 0, mb_strlen($goallineString)-1);
		    				$aSubResult = $match_index_id.'('.$goallineString.')';
						}
						
						elseif ($play_method == 3 ) {	//胜分差
							$match_result_value_r = $match_result_value;
							if (isset($result_config) && 
								isset($result_config[$match_result_value])) 
							{
								$match_result_value_r = $result_config[$match_result_value];
			    			}
			    			$aSubResult = $match_index_id.':'.$match_result_value_r;
						}
						
		    			elseif ($play_method == 4) {	//大小分
		    				//保存多个赛果
		    				$dxf_result_array = explode('/', $match_result_value);
		    				//处理goalline
		    				$goallineString = '';
		    				foreach ($dxf_result_array as $aMatchResult)
		    				{
		    					$theGoalline = mb_substr($aMatchResult, 1);
		    					$theCnResult = mb_substr($aMatchResult, 0, 1);
								if (isset($result_config) && 
									isset($result_config[$theCnResult])) 
								{
									$theCnResult = $result_config[$theCnResult];
				    			}
				    			$goallineString .= $theGoalline.':'.$theCnResult.'/';
		    				}
		    				$goallineString = mb_substr($goallineString, 0, mb_strlen($goallineString)-1);
			    			$aSubResult = $match_index_id.'('.$goallineString.')';
		    			}
	    			}
					$plan_result[] = $aSubResult;
					$flag++;
	    		}
		    	
		    }// end of for loop
		    $plan_result_s = implode('|', $plan_result);
//d($plan_result_s, FALSE);
		    
		    if ($flag == $matchs_count) {
		    	$updateCount++;
		    	//订单里赛事的赛果已全部更新
		    	$update_query = "UPDATE plans_jclqs SET match_results='$plan_result_s' WHERE id=$plan_id ";
    			$db->query($update_query);
    			d($update_query, FALSE);
    			//$return[$order_num] = $plan_result;
		    }
		}// end of foreach
	    
d('更新了 '.$updateCount.' 个方案赛果', FALSE);
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
        	// 根据一个plan找出它生成的而且中奖的ticket,
        	// $ticket_results是一个中间数据结构
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

        /**
         * 若遇比赛取消，sp设置为1的比赛
         * array('23509|3012')
         * @var unknown_type
         */
        $matchobj = match::get_instance();
        $cancel_matchs = $matchobj->get_cancel_matchs(6);
        
        $week_array = array(
			'周一'=>'1',
			'周二'=>'2',
			'周三'=>'3',
			'周四'=>'4',
			'周五'=>'5',
			'周六'=>'6',
			'周日'=>'7'
		);
		$sp_1_match = array();
		for ($i = 0; $i < count($cancel_matchs); $i++) {
			$match_id = $cancel_matchs[$i]['index_id'];
			$match_num = $week_array[substr($cancel_matchs[$i]['match_info'], 0, -3)].substr($cancel_matchs[$i]['match_info'], -3);
			$tmp = $match_id.'|'.$match_num;
			$sp_1_match[$i] = $tmp;
		}
        //d($sp_1_match);
        //$sp_1_match = array('25745|6019');

        if (empty($plan))
            return FALSE;

        //无赛果的方案则返回
        if (empty($plan['match_results']))
            return FALSE;
        
        if ($test_open && $is_hidden) {
            echo '<!--';
        }
            
        $test_open && d('=======方案信息:', FALSE); 
        $test_open && d($plan, FALSE);   
            
        $match_results = $plan['match_results'];     //赛果: 26174(-0.5/+1.5):1|26175(+4.5/+5.5/+6.5):1|26176(+8.5):1
        $plan_codes = $plan['codes'];               //选项: 26174|3301[2,1]/26175|3302[1]/26176|3303[2]
        
        $arrmatch_result_source = explode('|', $match_results);    //赛果       
        $plan_code_array = explode('/', $plan_codes); 

        /*
         * 重构赛果 重构成格式如下,用于中奖匹配
         *  Array
            (
                [0] => 23509|3012[1]
                [1] => 23510|3013[2]
                [2] => 23511|3014[01]
                [3] => 23512|3015(+4.5)[2]
                [4] => 23515|3018(-8.5)[1]
            )
         */
        $arrmatch_result = array();
    	foreach ($plan_code_array as $aPlanCode)
        {
            $codeParts = explode('|', $aPlanCode);
            $matchId = $codeParts[0];
            $codeParts = explode('[', $aPlanCode);
            $matchIdAndTime = $codeParts[0];
            
// $aMatchResult 's ex: 26183(+1.5:2/+2.5:2/+3.5:2) or 26184:02
            foreach ($arrmatch_result_source as $aMatchResult)
            {
                if (strstr($aMatchResult, $matchId))
                {
                	if($plan['play_method'] == 2 || $plan['play_method'] == 4)
                	{
						$start = strpos($aMatchResult, '(');
						$end   = strpos($aMatchResult, ')');
                		$goallines = substr($aMatchResult, 0, $end);
                		$goallines = substr($goallines, $start+1);
                		$goallineResultPairList = explode('/', $goallines);
                		foreach ($goallineResultPairList as $aGoallineResultPair)
                		{
                			$pairParts = explode(':', $aGoallineResultPair);
                			if (count($pairParts) == 2) {
	                			$theGoalline = $pairParts[0];
			                	$theResultValue = $pairParts[1];
                			}
                			else {
	                			$theGoalline = $pairParts[0];
	                			$theResultValue = end(explode(':', $aMatchResult));
                			}
                			$arrmatch_result[] = $matchIdAndTime.'('.$theGoalline.')['.$theResultValue.']';
                		}
                	}
					else 
                	{
                		$theResultValue = end(explode(':', $aMatchResult));
                    	$arrmatch_result[] = $matchIdAndTime.'['.$theResultValue.']';
                	}
                }
            }
        }
//d('赛果数组:', false);
//d($arrmatch_result, false);

        $test_open && d('=======重构的赛果:', FALSE);
        $test_open && d($arrmatch_result, FALSE);
        
		$ticketobj = ticket::get_instance();
        $ticketList = $ticketobj->get_results_by_ordernum($plan['basic_id']);    //获取彩票
                
        if (empty($ticketList)){
            return FALSE;
		}
		
		/**
		 * 重新设置ticket的codes
		 * 对于rfsf & dxf 这两种情况的ticket，添加让分值和总比分
		 * 格式: 23512|3015(+4.5)[2]/23512|3015(+4.5)[1]/
		 */
		$play_method = $plan['play_method'];
		if($play_method == 2 || $play_method == 4)
		{
			for ($index=0; $index<count($ticketList); $index++) 
			{
				$theTicket = $ticketList[$index];
				$moreInfo  = $theTicket['moreinfo'];
				$odd_array = explode('|',$moreInfo);
				
				$ticket_codes = $theTicket['codes'];
				$ticket_code_array = explode('/', $ticket_codes);
		
				//$ticket_code_array 和 $odd_array 一一对应
				if (count($ticket_code_array) != count($odd_array))
				{
					echo 'check moreinfo & codes, count(odd)!=count(code), ticketId='.$theTicket['id'];
					return false;
				}
		
				for ($j=0; $j<count($ticket_code_array); $j++)
				{
					$theCode = $ticket_code_array[$j];
					$theOdd  = $odd_array[$j];
					// get goaline
					$goalline = null;
					$start = strpos($theOdd, '(');
					$end   = strpos($theOdd, ')');
					if($start > 0 && $end > 0 )
					{
						$goalline = substr($theOdd, 0, $end);
						$goalline = substr($goalline, $start+1);
						$goalline = '('.$goalline.')';
					}
					$theCodeParts = explode('[', $theCode);
					$ticket_code_array[$j] = $theCodeParts[0].$goalline.'['.$theCodeParts[1];
				}
				//回写ticketList
				$ticketList[$index]['codes'] = implode('/',$ticket_code_array);
			}
		}
//d($ticketList);
		
		$return = array();
		for ($index=0; $index<count($ticketList); $index++)
		{
//d('=========== one ticket start ============', false);
			$aTicket = $ticketList[$index];
			if(empty($aTicket)) {
				continue;
			}
		
			$arrodds = explode('|', $aTicket['moreinfo']);    //赔率
//d($arrodds, false);
			$codes = explode(';', $aTicket['codes']);         //彩票代码
			$codeList = explode('/', $codes[0]);
		
			$test_open && d('=======检测彩票赔率是否正常:', FALSE);
			$test_open && d(count($codeList).'****'.count($codeList), FALSE);
		
			if (count($codeList) != count($arrodds))            //当赔率的数量与投注彩票的数量不为空为异常跳出
				continue;
		
            /*
             * 重构赔率,用于兑奖计算
             * 重构成 格式如:
             * 		Array
					(
    					[23509|3012(+4.5)[1]] => 10.50
    					[23510|3013(+3.5)[2]] => 7.50
					)
             * 
             * 
             */   
            $ticket_odds = array();                            
            for ($i=0; $i < count($codeList); $i++)
            {
            	$aCode = $codeList[$i];
                if (substr_count($aCode, ',') > 0)
                {
                    $arrtestcode1 = explode('[', $aCode);
                    $arrtestcode[1] = substr($arrtestcode1[1], 0, strlen($arrtestcode1[1])-1);
                    $arrtestcode = explode(',', $arrtestcode[1]);
                    
                    $arrtestodds = explode(':', $arrodds[$i]);
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
                        	if (in_array($arrtestcode1[0], $sp_1_match)) {
                        		$ticket_odds[$arrtestcode1[0].'['.$rowpull.']'] = count($arrtestcode);
                        	}
                        	else {
                            	$ticket_odds[$arrtestcode1[0].'['.$rowpull.']'] = $arrtestodds[$keypull];
                        	}
                        }
                    }
                }
                else {
                	$arrtestcode1 = explode('[', $aCode);
					if (in_array($arrtestcode1[0], $sp_1_match)) {
						$ticket_odds[$aCode] = 1;
					}
					else {
                    	$ticket_odds[$aCode] = end(explode(':', $arrodds[$i]));
					}
                }
            } // end of codeList loop 
//d('赔率数组:', false);
//d($ticket_odds, FALSE);
            $test_open && d('=======重构的赔率:', FALSE);
            $test_open && d($ticket_odds, FALSE);
            
            /*
             * 扯分的彩票
             * 由于所选择的彩票中一场可以有多个彩票,为了计算奖金需要拆分计算
             * 重新组合
             * $ticketdetail 是彩票以 几窜几的 排列组合
             */
            $ticketdetail = array();
            $ticketdetail = $ticketobj->get_jclq_note($aTicket['codes']);
            
            $test_open && d('=======扯分的彩票:', FALSE);
            $test_open && d($ticketdetail, FALSE);
//d('排列组合:', false);
//d($ticketdetail, FALSE);            

            //初始化中奖彩票的队列
            $tickets_bonus_detail = array();
            
            //提取中奖的组合
            // $rowdetail 是排列组合中的一个
//d($arrmatch_result, false);
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
//d('中奖组合数组:', false);
//d($tickets_bonus_detail, false);

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
                $bonus *= $aTicket['rate'];        //剩上倍数
                $tickets_detail_result[$i][0] = $bonus_detail;
                $tickets_detail_result[$i][1] = $bonus;
                
                $allbonus += $bonus;
                $i++;
            }
            
            if ($allbonus > 0 && $aTicket['rate'] > 1)
            {
                $return[$index]['bonus_one'] = $allbonus/$aTicket['rate'];
            }
            else 
            {
                $return[$index]['bonus_one'] = $allbonus;
            }
            
            //控制最高奖金额度(2场或3场过关投注，单注最高奖金限额20万元。4场或5场过关投注，单注最高奖金限额50万元。6场及6场以上过关投注，单注最高奖金限额100万元。)
            if ($return[$index]['bonus_one'] > 200000)
            {
                $selecount = count($codeList);
                switch ($selecount)
                {
                    case 2:
                    case 3:
                        $return[$index]['bonus_one'] = 200000;
                        break;
                    case 4:
                    case 5:
                        if ($return[$index]['bonus_one'] > 500000)
                        {
                            $return[$index]['bonus_one'] = 500000;
                        }
                        break;
                    default:
                        if ($return[$index]['bonus_one'] > 1000000)
                        {
                            $return[$index]['bonus_one'] = 1000000;
                        }
                }
            }
            
            //个人所得税
            if ($return[$index]['bonus_one'] > 10000)
            {
                $return[$index]['bonus_one'] *= 0.8;
            }
            $allbonus = $return[$index]['bonus_one'] * $aTicket['rate'];

            $return[$index]['detail'] = $tickets_detail_result;    //中奖扯分明细
            $return[$index]['bonus'] = $allbonus;                  //当前彩票总奖金
            $return[$index]['ticket'] = $aTicket;                //当前彩票记录
            $return[$index]['odds'] = $ticket_odds;                //当前彩票赔率
            $return[$index]['id'] = $aTicket['id'];              //当前彩票id
            $return[$index]['plan'] = $plan;                       //当前彩票的方案信息
        }// end of loop
        
        //$test_open && d('=======返回结果:', FALSE);
        //$test_open && d($return);
        
        if ($test_open && $is_hidden)
        {
            echo '-->';
        }
        return $return;
    }
    /*
     * 统计指定方案中中奖的彩票信息,并以数组形式返回
     * @param  array  $plan  方案信息数组
     * @return array  彩票及彩票扯分的组合数据
     */
    public function bonus_ticket_count_old($plan)
    {
        $test_open = TRUE;    //调试开关
        $is_hidden = FALSE;    //隐藏
        
        /**
         * 若遇比赛取消，sp设置为1的比赛
         * array('23509|3012')
         * @var unknown_type
         */
        $sp_1_match = array('25510|1004');

        if (empty($plan))
            return FALSE;

        //无赛果的方案则返回
        if (empty($plan['match_results']))
            return FALSE;
        
        if ($test_open && $is_hidden) {
            echo '<!--';
        }
            
        $test_open && d('=======方案信息:', FALSE); 
        $test_open && d($plan, FALSE);   
            
        $match_result = $plan['match_results'];     //赛果       
        $match_code = $plan['codes'];               //选项
        
		$matchResultList = explode(',', $match_result);    //赛果       
		$userChoiceList = explode('/', $match_code);        //选项
//d($matchResultList, false);
//d($userChoiceList, true);
        
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
        $arrmatch_result = array();
        foreach ($userChoiceList as $aChoice)
        {
            $arrtmp = explode('|', $aChoice);
            $arrtmp2 = explode('[', $aChoice);
                        
            foreach ($matchResultList as $keyresult => $aTicket)
            {
                if (strstr($aTicket, $arrtmp[0]))
                {
                    $arrmatch_result[$keyresult] = $arrtmp2[0].'['.end(explode('|',$aTicket)).']';
                    continue;
                }
            }
        }
        
        $test_open && d('=======重构的赛果:', FALSE);
		$test_open && d($arrmatch_result, FALSE);
        
        $ticketobj = ticket::get_instance();
        $ticketList = $ticketobj->get_results_by_ordernum($plan['basic_id']);    //获取彩票
                
        if (empty($ticketList))
            return FALSE;
        
        $test_open && d($ticketList,false);
        
        $return = array();
        $index = 0;
        foreach ($ticketList as $aTicket)
        {
            if(empty($aTicket)){
                continue;
            }
            if ($aTicket['status'] == 2) {	//已兑奖的彩票
            	continue;
            }
            
            $arrodds = explode('|', $aTicket['moreinfo']);    //赔率
            $codes = explode(';', $aTicket['codes']);         //彩票代码
            $arrcodes = explode('/', $codes[0]);                
            
            $test_open && d('=======检测彩票赔率是否正常:', FALSE);
            $test_open && d(count($arrcodes).'****'.count($arrcodes), FALSE);
            
            if (count($arrcodes) != count($arrodds)) {            //当赔率的数量与投注彩票的数量不为空为异常跳出
                continue;
            }
                
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
//            $i = 0;
//            echo '$arrcodes ='.count($arrcodes); 
//d($arrcodes, true);
			for ($codeIndex = 0; $codeIndex<count($arrcodes); $codeIndex++)
//            foreach ($arrcodes as $rowvalue => $rowcode)
            {
            	$rowcode = $arrcodes[$codeIndex];
                if (substr_count($rowcode, ',') > 0)
                {
                    $arrtestcode1 = explode('[', $rowcode);
                    $arrtestcode[1] = substr($arrtestcode1[1], 0, strlen($arrtestcode1[1])-1);
                    $arrtestcode = explode(',', $arrtestcode[1]);
                    
                    $arrtestodds = explode(':', $arrodds[$codeIndex]);
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
                        	if (in_array($arrtestcode1[0], $sp_1_match)) {
                        		$ticket_odds[$arrtestcode1[0].'['.$rowpull.']'] = count($arrtestcode);
                        	}
                        	else {
                            	$ticket_odds[$arrtestcode1[0].'['.$rowpull.']'] = $arrtestodds[$keypull];
                        	}
                        }
                    }
                }
                else {
                	$arrtestcode1 = explode('[', $rowcode);
					if (in_array($arrtestcode1[0], $sp_1_match)) {
						$ticket_odds[$rowcode] = 1;
					}
					else {
                    	$ticket_odds[$rowcode] = end(explode(':', $arrodds[$codeIndex]));
					}
                }
//                $i++;
            }
            $test_open && d('=======重构的赔率:', FALSE);
            $test_open && d($ticket_odds, FALSE);
//            echo '$ticket_odds = ';
//d($ticket_odds, FALSE);
            
            /*
             * 扯分的彩票
             * 由于所选择的彩票中一场可以有多个彩票,为了计算奖金需要拆分计算
             * 重新组合
             */
			$ticketdetail = array();
			$ticketdetail = $ticketobj->get_jclq_note($aTicket['codes']);
//			 echo '$ticketdetail = ';
//d($ticketdetail, FALSE);
            
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
                $bonus *= $aTicket['rate'];        //剩上倍数
                $tickets_detail_result[$i][0] = $bonus_detail;
                $tickets_detail_result[$i][1] = $bonus;
                
                $allbonus += $bonus;
                $i++;
            }
            
            if ($allbonus > 0 && $aTicket['rate'] > 1)
            {
                $return[$index]['bonus_one'] = $allbonus/$aTicket['rate'];
            }
            else 
            {
                $return[$index]['bonus_one'] = $allbonus;
            }
            
            //控制最高奖金额度(2场或3场过关投注，单注最高奖金限额20万元。4场或5场过关投注，单注最高奖金限额50万元。6场及6场以上过关投注，单注最高奖金限额100万元。)
            if ($return[$index]['bonus_one'] > 200000)
            {
                $selecount = count($arrcodes);
                switch ($selecount)
                {
                    case 2:
                    case 3:
                        $return[$index]['bonus_one'] = 200000;
                        break;
                    case 4:
                    case 5:
                        if ($return[$index]['bonus_one'] > 500000)
                        {
                            $return[$index]['bonus_one'] = 500000;
                        }
                        break;
                    default:
                        if ($return[$index]['bonus_one'] > 1000000)
                        {
                            $return[$index]['bonus_one'] = 1000000;
                        }
                }
            }
            
            //个人所得税
            if ($return[$index]['bonus_one'] > 10000)
            {
                $return[$index]['bonus_one'] *= 0.8;
            }
            $allbonus = $return[$index]['bonus_one'] * $aTicket['rate'];

            $return[$index]['detail'] = $tickets_detail_result;    //中奖扯分明细
            $return[$index]['bonus'] = $allbonus;                  //当前彩票总奖金
            $return[$index]['result'] = $aTicket;                //当前彩票记录
            $return[$index]['odds'] = $ticket_odds;                //当前彩票赔率
            $return[$index]['id'] = $aTicket['id'];              //当前彩票id
            $return[$index]['plan'] = $plan;                       //当前彩票的方案信息
            $index++;
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
    
    /**
     * 扫描彩票表赔率
     * @param  array  $plan  方案信息数组
     * @return array  goalline的组合
     * array (
     * 		'26920|3301' => '+5.5'
     * 		'26921|3302' => '-6.5'
     * 		'26921|3302' => '155'
     * );
     */
    public function get_goallines_by_ordernum($plan)
    {
    	if (empty($plan))
    		return FALSE;
    
    	$ticketobj = ticket::get_instance();
    	$ticketList = $ticketobj->get_results_by_ordernum($plan['basic_id']);
    	if (empty($ticketList))
    		return FALSE;
    
    	$goalline_array = array();
    	foreach ($ticketList as $aTicket)
    	{
    		$arrcode = explode(';', $aTicket['codes']);
    		$arrcode = explode('/', $arrcode[0]);
    		$arrodds = explode('|', $aTicket['moreinfo']);
    
    		if (count($arrcode) != count($arrodds))
    			continue;
    
    		foreach ($arrcode as $keycode => $valuecode)
    		{
    			$goalline = '';
    			$start = strpos($arrodds[$keycode], '(');
    			$end   = strpos($arrodds[$keycode], ')');
    			if ($start > 0 && $end > 0) {
    				$goalline = substr($arrodds[$keycode], 0, $end);
    				$goalline = substr($goalline, $start+1);
    			}
    			$choiceStart = strpos($valuecode, '[');
    			$choiceEnd   = strpos($valuecode, ']');
    			$matchIdAndTime = substr($valuecode, 0, $choiceStart);
    			
    			$userChoices = substr($valuecode, 0, $choiceEnd);
    			$userChoices = substr($userChoices, $choiceStart+1);
    			$userChoiceArray = explode(',', $userChoices);
    			
    			foreach ($userChoiceArray as $aChoice) 
    			{
	   				$goalline_array[$matchIdAndTime.'['.$aChoice.']'] = $goalline;
    			}
    		}
    
    	}
    
    	return $goalline_array;
    }
    
	/**
     * 单式上传文件从临时目录转移到正式目录
     * Enter description here ...
     * @param unknown_type $userid
     * @param unknown_type $tmpname
     */
    public function ds_upload_save($userid, $tmpname) {
    	$path = 'media/jclq_ds_upload/';
    	$md5_masterId = md5($userid);
		$dir1 = substr($md5_masterId, 0,2);
		if (!is_dir($path.$dir1)){
			@mkdir($path.$dir1);		
		}
		$dir2 = substr($md5_masterId, 2,2);
		if (!is_dir($path.$dir1.'/'.$dir2)){
			@mkdir($path.$dir1.'/'.$dir2);		
		}
		$SaveName = md5($userid).rand(0,999);
		$r = @rename($tmpname, $path.$dir1.'/'.$dir2.'/'.$SaveName);
		$return = false;
		if ($r == true) {
			$return = $path.$dir1.'/'.$dir2.'/'.$SaveName;
		}
		return $return;
    }
    
    /**
     * 单式上传文件保存到临时目录
     * Enter description here ...
     * @param unknown_type $userid
     * @param unknown_type $filename
     * @param unknown_type $tmpname
     */
	public function ds_upload_save_tmp($userid, $filename, $tmpname) {
    	$path = 'media/jclq_ds_upload_tmp/';
		$FileName = $filename;
		$SaveName = md5($FileName).rand(0,999).'.tmp';
		$r = @copy($tmpname,$path.$SaveName);
		$return = false;
		if ($r == true) {
			$return = $path.$SaveName;
		}
		return $return;
    }
    
    /**
     * 单式上传处理，胜平负
     * Enter description here ...
     */
    public function ds_upload($userid) {
    	if (isset($_FILES['txt'])) {
			$file_info = $_FILES['txt'];
			$msg = '上传错误';
			$data = false;
			$tmp_path = '';
			if ($file_info['type'] == 'text/plain') {
				if ($file_info['error'] == 0) {
					$file_name = $file_info['name'];
					$file_name_a = explode('.', $file_name);
					$file_name_a_c = count($file_name_a);
					if (strtolower($file_name_a[$file_name_a_c-1]) == 'txt') {
						$file_size = $file_info['size'];
						if ($file_size <= 800000) {
							$file_tmp = $file_info['tmp_name'];
							$file_content = file_get_contents($file_tmp);
							$data = $this->ds_jiexi1($file_content);
							//var_dump($data);
							if ($data == false) {
								$msg = '上传格式错误或注数超过限制';
							}
							else {
								$data_count = count($data);
								if ($data_count <= 0) {
									$msg = '上传内容不能为空';
								}
								else {
									$match_end = array();
									for ($i = 0; $i < $data_count; $i++) {
										$match_info = $data[$i]['match_info'];
										for ($j = 0; $j < count($match_info); $j++) {
											//var_dump($match_info[$j]['info']);
											if ($match_info[$j]['info']['match_end']) {
												if (!in_array($match_info[$j]['info']['match_info'], $match_end)) {
													$match_end[] = $match_info[$j]['info']['match_info'];
												}
											}
										}
									}
									if (count($match_end) > 0) {
										$msg = '赛事已过期';
									}
									else {
										$msg = 'ok';
										$tmp_path = $this->ds_upload_save_tmp($userid, $file_name, $file_tmp);
										//$tmp_path = $file_tmp;
									}
								}
							}
						}
						else {
							$msg = '上传文件太大';
						}
					}
					else {
						$msg = '上传格式错误';
					}
				}
				else {
					$msg = '上传错误';
				}
			}
			else {
				$msg = '上传格式错误';
			}
			return array('m'=>$msg, 'd'=>$data, 'tp'=>$tmp_path);
		}
    }
    
    /**
     * 单式投注，上传解析方式一
     * 格式：SPF|110930002=0,110930024=1|2*1:1109
     * Enter description here ...
     */
    public function ds_jiexi1($file_content) {
    	$max_zhushu = 50;
    	$objmatch = match::get_instance();
    	$play_type = array('SPF'=>'1');
    	$file_content_row = explode("\r\n", $file_content);
		$data = array();
		$data_play_type = array();
		$data_match = array();
		$data_gg = array();
		$data_beishu = array();
		$zhushu = 0;
		for ($i = 0; $i < count($file_content_row); $i++) {
			if ($file_content_row[$i] != '') {
				if ($zhushu > $max_zhushu) return false;
				$zhushu ++;
				$tmp = explode('|', $file_content_row[$i]);
				if (!isset($tmp[0]) || $tmp[0] == null) return false;
				if (!isset($play_type[$tmp[0]]) || $play_type[$tmp[0]] == null) return false;
				$data[$i]['play_type'] = $play_type[$tmp[0]];
				if (!isset($tmp[1]) || $tmp[1] == null) return false;
				$matchs = explode(',', $tmp[1]);
				$match_detail = array();
				$match_info = array();
				$match_code = array();
				for ($j = 0; $j < count($matchs); $j++) {
					$tmp2 = explode('=', $matchs[$j]);
					if (!isset($tmp2[0]) || $tmp2[0] == null) return false;
					if (!isset($match_detail[$tmp2[0]])) {
						$match_date_y = substr($tmp2[0], 0, 2);
						$match_date_m = substr($tmp2[0], 2, 2);
						$match_date_d = substr($tmp2[0], 4, 2);
						$match_date = date('Y-m-d', strtotime($match_date_y.'-'.$match_date_m.'-'.$match_date_d));
						$match_no = substr($tmp2[0], 6, 3);
						//赛事信息查询
						$match_detail_tmp = $objmatch->get_match_detail_by_infotime($match_no, $match_date);
						if ($match_detail_tmp == false || count($match_detail_tmp) <= 0) return false;
						$check_match = $objmatch->get_match($match_detail_tmp['index_id'], 1, $data[$i]['play_type'], true);
						if ($check_match == false || count($check_match) <= 0) return false;
						$match_detail[$tmp2[0]] = $check_match;
						$match_info[$j]['info'] = $check_match;
					}
					else {
						$match_info[$j]['info'] = $match_detail[$tmp2[0]];
					}
					if (!isset($tmp2[1]) || $tmp2[1] == null) return false;
					$match_info[$j]['result'] = $tmp2[1];
					$match_code[$j] = $match_info[$j]['info']['index_id'].'|'.$match_info[$j]['info']['match_num'].'['.$match_info[$j]['result'].']';
				}
				$data[$i]['code'] = implode('/', $match_code);
				$data[$i]['match_info'] = $match_info;
				if (!isset($tmp[2]) || $tmp[2] == null) return false;
				$tmp2 = explode(':', $tmp[2]);
				if (!isset($tmp2[0]) || $tmp2[0] == null) return false;
				$tmp3 = explode('*', $tmp2[0]);
				if (!isset($tmp3[0]) || $tmp3[0] == null || $tmp3[0] < 2 || $tmp3[0] > 5) return false;
				if (!isset($tmp3[1]) || $tmp3[1] == null || $tmp3[1] != 1) return false;
				$data[$i]['typename'] = $tmp3[0].'串'.$tmp3[1];
				if (!isset($tmp2[1]) || $tmp2[1] == null) return false;
				$data[$i]['rate'] = $tmp2[1];
				$data[$i]['money'] = $data[$i]['rate'] * 2;
			}
		}
		return $data;
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
    
    public function find_join_data($user_id, $pid) {
    	$obj = ORM::factory('plans_jclq');
    	$obj->where('user_id', $user_id)
    	->where('parent_id', $pid)
    	->find();
    	if($obj->loaded) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    
}
