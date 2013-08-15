<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plans_bjdcService_Core extends DefaultService_Core 
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
        
        $obj = ORM::factory('plans_bjdc');
        
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

        $obj = ORM::factory('plans_bjdc');

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
     * 根据方案id获取数据
     * 
     */
    public  function  get_by_plan_id($id)
    {
        if (empty($id))
            return  FALSE;

        $obj = ORM::factory('plans_bjdc');

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
     * 根据基表订单id获取数据
     * 
     */
    public  function get_son_by_pid($id)
    {
        if (empty($id))
            return  FALSE;
        
        $obj = ORM::factory('plans_bjdc')->where('parent_id', $id);
        $results = $obj->find_all();
        $return = array();
        foreach ($results as $result)
        {
            $return[] = $result->as_array();
        }
        
        return $return;
    }
    
    /*
     * 根据基表订单id获取数据
     * 
     */
    public  function  get_by_order_id($id)
    {
    	if (empty($id))
            return  FALSE;
        
        $obj = ORM::factory('plans_bjdc');

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
        $obj = ORM::factory('plans_bjdc');
        $obj->where('id', $id);
        $result = $obj->find();
        
        if ($obj->loaded)
        {
            $obj->buyed = $num;
            $obj->surplus = $obj->copies - $num;
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
	    $ticket_type = 7;            //彩种
	    $tickets = array();
	    $arrtype = explode(',', $typename);
        $arrcode = explode("/", $code);
        $loop = count($arrcode);     //参数个数
        
		//重构彩票尝试多张是否能转换成更少的彩票张数
        $limitnum = 0;
        if ($play_method == '503' || $play_method == '502' || $play_method == '505')
        {
            $limitnum = 6;
        }
		elseif ($play_method == '504')
        {
            $limitnum = 3;
        }
        
        $ticketobj = ticket::get_instance();
        $ticket_zhushu = ticket_operation::get_instance();
        
        //ticket_operation::get_instance()->change_code_bjdc(&$arrcode, &$arrtype, $limitnum);
        
        //多串过关
        if (count($arrtype) == 1 ) {
            $arrtmp = explode('串', $typename);
            if ($arrtmp[0] >= $loop)
            {  
            	$zhushu = $ticket_zhushu->zhushu($code, $typename);
                $money = intval($zhushu) * intval($rate) * 2;
                $code .= ';'.$typename;
                if (!$ret) {
	                $ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
	                return TRUE;
                }
            	else {
                    $return = array();
                    $return[0]['money'] = $money;
                    $return[0]['rate'] = $rate;
                    $return[0]['code'] = $code;
                    return $return;
                }
            }
        }
        elseif ($typename =='单关') {  //单关投注
        	$zhushu = $ticket_zhushu->zhushu($code, $typename);
            $money = intval($zhushu) * intval($rate) * 2;
            $code .= ';'.$typename;
            if (!$ret) {
	            $ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
	            return TRUE;
            }
            else {
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
        
        $results = array();
        foreach ($arrtype as $rowtype)
        {
        	if ($rowtype == '单关') {
        		$zhushu = $ticket_zhushu->zhushu($code, $rowtype);
            	$money = intval($zhushu) * intval($rate) * 2;
        		$code .= ';'.$rowtype;
        		if (!$ret) {
            		$ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
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
        
        if (!$ret) {
	        foreach ($arrnew as $rownew)
	        {
	        	$code_chuan = explode(';', $rownew);
	        	$zhushu = $ticket_zhushu->zhushu($code_chuan[0], $code_chuan[1]);
	            $money = intval($zhushu) * intval($rate) * 2;
	            $ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $rownew, $rate, $ordernum, $money);
	        }
	        return TRUE;
        }
        else {
        	$return = array();
            $i = 0;
            foreach ($arrnew as $rownew)
            {
                $code_chuan = explode(';', $rownew);
	        	$zhushu = $ticket_zhushu->zhushu($code_chuan[0], $code_chuan[1]);
	            $money = intval($zhushu) * intval($rate) * 2;
                $return[$i]['money'] = $money;
                $return[$i]['rate'] = $rate;
                $return[$i]['code'] = $rownew;
                $i++;
            }
            return $return;
        }
	}
	
	/*
     * 彩票退款处理
     * @param  integer  $ordernum  订单号码
     * @param  integer  $money  退还金额
     * @return array 以用户id为索引,所返还的金额为值
     */
    public function refund_by_ticket($ordernum, $money) {
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
            $money_one = $money / $result['copies'];//每份价格,竞彩和北单，zhushu与copies相反
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
     * 更改父类状态
     */
    public function update_status($id, $status)
    {
        $obj = ORM::factory('plans_bjdc');
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
                        $obj_son = ORM::factory('plans_bjdc', $rowson['id']);
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
     * 过期未满员方案处理
     * 此处针对过期未满员的合买方案进行处理,当方案过期发起人保底数量能够填满剩余数量则方案有效
     * 有效方案的会加入生成彩票加入彩票表;否则不做任何处理
     * @param  integer  $ordernum  订单号码 
     * @return TRUE OR FALSE	有效或无效
     */
    public function expired_plan($ordernum) {
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
        $obj = ORM::factory('plans_bjdc', $result['id']);
        
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
        
        $total_price = $result['total_price'];        //总金额
        $total_bonus = $result['bonus'];              //总奖金
        $bonus_one = $total_bonus / $result['copies'];//zhushu和copies与竞彩足球是反的
        
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
                $deduct_retmoney =  $total_bonus * $result['deduct'] / 100;       //若方案盈利(即税后奖金大于方案本金)，则发起人先提成税后奖金的x％作为方案制作佣金
                $total_bonus = $total_bonus - $deduct_retmoney;                   //重构总奖金,总奖金减去提成金额
                $bonus_one = $total_bonus / $result['copies'];                    //重构单份奖金
            }
        }
        //当提成大于0则添加记录
        if ($deduct_retmoney > 0)
        {
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys['BONUS_MONEY'] = $deduct_retmoney;
            $flagret = $moneyobj->add_money($result['user_id'], $deduct_retmoney, $moneys, 5, $order_num, $lan['money'][17].',方案ID:'.$result['basic_id']);
            
            if ($flagret < 0)
                return  FALSE;
            
        }
        //发起人奖金发放 
        $retmoney = 0;
        $retmoney = $result['my_copies'] * $bonus_one;

        $order_num = date('YmdHis').rand(0, 99999);
        $moneys['BONUS_MONEY'] = $retmoney;
        $flagret = $moneyobj->add_money($result['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][11].',方案ID:'.$result['basic_id']);                
        
        //更新发起方案的方案奖金
        $plan_basic = Plans_basicService::get_instance();
        $plan_basic->update_bonus($result['basic_id'], $retmoney+$deduct_retmoney);
        
        //参与合买人奖金发放
        $plans = $this->get_son_by_pid($result['id']);
        
        $retmoney = 0;
        foreach ($plans as $rowplan)
        {
            $retmoney = $rowplan['my_copies'] * $bonus_one;
            $order_num = date('YmdHis').rand(0, 99999);
            $moneys['BONUS_MONEY'] = $retmoney;
            $flagret = $moneyobj->add_money($rowplan['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][11].',方案ID:'.$rowplan['basic_id']);            
            $plan_basic->update_bonus($rowplan['basic_id'], $retmoney);    //更新到基表存入个人奖金            
        }
        
        $this->update_status($result['id'], 5);    //更新方案状态
        
        return TRUE;
    }
    
    /**
     * 获取已经中奖还没有派奖的数据，返回basic_id
     * Enter description here ...
     */
    public function get_unpaijiang_id() {
    	$limit = 100;
    	$offset = 0;
    	$obj = ORM::factory('plans_bjdc');
        $obj->where('status', 4);
        $obj->where('bonus > ', 0);
        $obj->orderby('id', 'ASC');
        $result = $obj->find_all($limit, $offset);
        $return = array();
        foreach ($result as $key => $val) {
        	$return[] = $val->basic_id;
        }
        if (count($return) <= 0) {
        	return false;
        }
        else {
        	return $return;
        }
    }
    
    /**
     * 调用彩乐宝接口下注
     * Enter description here ...
     * @param array $tickets 彩票表取出的数组
     * <ticket id="彩票唯一标示" betid="彩种编号" issue="期号" playtype="玩法编号"  money="单张彩票金额" amount="倍数" code="投注内容" />
     */
    public function post_ticket_happypool($tickets, $issue) {
    	require_once WEBROOT.'cron_script/BJDC.php';
        $bjdc_jk = new BJDC();
        $ticket_count = count($tickets);
        if (!is_array($tickets) || $ticket_count <= 0) {
        	return false;
        }
        $data['issue'] = $issue;
        $post_ticket_fail = array();
        for ($i = 0; $i < $ticket_count; $i++) {
        	if ($tickets[$i]['ticket_type'] != 7) continue;
			$codes = explode(';', $tickets[$i]['codes']);
            if ($codes[1] == '单关') {
				$chuan = 1;
            }
            else {
                $chuan_array = explode('串', $codes[1]);
                $chuan = $chuan_array[0].$chuan_array[1];
            }
            $code = $this->transJkCodeByCodes($tickets[$i]['play_method'], $codes[0]);
			$post_start_key = 0;
			$post_max = 5;
			while (true) {
				$r = $bjdc_jk->postAction_new($tickets[$i]['id'], $tickets[$i]['play_method'], 
                $data['issue'], $chuan, $tickets[$i]['money'], $tickets[$i]['rate'], $code);
				if($r != false) {
					break;
				}
				else {
					if ($post_start_key >= $post_max) {
						$r = '999';
						break;
					}
					$post_start_key++;
				}
			}
            if ($r != '000') {
				$ticket_bjdc_obj = ticket_bjdc_log::get_instance();
                $log = array();
                $log['ticket_id'] = $tickets[$i]['id'];
                $log['betid'] = $tickets[$i]['play_method'];
                $log['issue'] = $data['issue'];
                $log['playtype'] = $chuan;
                $log['money'] = $tickets[$i]['money'];
                $log['amount'] = $tickets[$i]['rate'];
                $log['code'] = $code;
                $log['result'] = $r;
                $log['result_name'] = BJDC::showResultCode($r);
                $ticket_bjdc_obj->add($log);
                if ($r != '999') {
                	$post_ticket_fail[] = $tickets[$i];
                }
            }
		}
		if (count($post_ticket_fail) > 0) {
			return $post_ticket_fail;
		}
		else {
			return true;
		}
    }
    
	/**
	 * 
	 * 将46:[胜]/47:[胜]/48:[胜]/49:[胜]转换成接口格式
	 * @param unknown_type $play_method
	 * @param unknown_type $codes
	 */
	public function transJkCodeByCodes($play_method, $codes) {
		$bjdc_config = Kohana::config('bjdc');
		$code_result = array();
		$code_t1 = explode('/', $codes);
		for ($i = 0; $i < count($code_t1); $i++) {
			$t1 = explode(':', $code_t1[$i]);
			$match_no = $t1[0];
			$no_len = strlen($match_no)+2;
			$t2 = substr(substr($code_t1[$i], $no_len), 0, -1);
			$t3 = explode(',', $t2);
			$match_result = array();
			for ($j = 0; $j < count($t3); $j++) {
				switch ($play_method) {
					case '501': $match_result[$j] = $bjdc_config['spf_result'][$t3[$j]];break;
					case '502': $match_result[$j] = $bjdc_config['sxds_result'][$t3[$j]];break;
					case '503': $match_result[$j] = $bjdc_config['zjqs_result'][$t3[$j]];break;
					case '504': $match_result[$j] = $bjdc_config['bf_result'][$t3[$j]];break;
					case '505': $match_result[$j] = $bjdc_config['bqc_result'][$t3[$j]];break;
				}
			}
			$match_result_str = $match_no.':'.implode(',', $match_result);
			$code_result[$i] = $match_result_str;
		}
		$code_result_str = implode('/', $code_result);
		return $code_result_str;
	}

}
