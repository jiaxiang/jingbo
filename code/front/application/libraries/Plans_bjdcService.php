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
	public function get_tickets($plan_id, $play_method, $code, $typename, $special_num, $rate, $ordernum, $issue, $ret = FALSE)
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
        
        //ticket_operation::get_instance()->change_code_bjdc(&$arrcode, &$arrtype, $limitnum, $special_num);
        
		//单关最多场数
		switch ($play_method) {
			case '501': $max_num_dg = 15;break;
			case '502': $max_num_dg = 6;break;
			case '503': $max_num_dg = 6;break;
			case '504': $max_num_dg = 3;break;
			case '505': $max_num_dg = 6;break;
			default: $max_num_dg = 3;break;
		}
		
        //多串过关
        if (count($arrtype) == 1 ) {
            $arrtmp = explode('串', $typename);
            if ($arrtmp[0] >= $loop)
            {  
            	$zhushu = $ticket_zhushu->zhushu($code, $typename);
                $money = intval($zhushu) * intval($rate) * 2;
                $code .= ';'.$issue.';'.$typename;
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
            $code .= ';'.$issue.';'.$typename;
            if (!$ret) {
	            if ($loop > $max_num_dg) {
            		for ($i = 0; $i < $loop; $i++) {
            			$zhushu = $ticket_zhushu->zhushu($arrcode[$i], $typename);
			            $money = intval($zhushu) * intval($rate) * 2;
			            $code = $arrcode[$i].';'.$issue.';'.$typename;
            			$ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
            		}
            	}
            	else {
	            	$ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
            	}
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
        		$code .= ';'.$issue.';'.$rowtype;
        		if (!$ret) {
        			if ($loop > $max_num_dg) {
	            		for ($i = 0; $i < $loop; $i++) {
	            			$zhushu = $ticket_zhushu->zhushu($arrcode[$i], $rowtype);
				            $money = intval($zhushu) * intval($rate) * 2;
				            $code = $arrcode[$i].';'.$issue.';'.$rowtype;
	            			$ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
	            		}
	            	}
	            	else {
            			$ticketobj->crate_ticket($plan_id, $ticket_type, $play_method, $code, $rate, $ordernum, $money);
	            	}
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
	            $rownew = $code_chuan[0].';'.$issue.';'.$code_chuan[1];
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
	            $rownew = $code_chuan[0].';'.$issue.';'.$code_chuan[1];
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
	
	/**
	 * 扫描订单，更新赛果
	 * Enter description here ...
	 */
	public function get_plans_result() {
		$bjdc_result_config = Kohana::config('bjdc');
		$db = Database::instance();
		$match_detail_obj = match_bjdc::get_instance();
		$ticketobj = ticket::get_instance();
		d('开始更新赛果', FALSE);
		 
		//$query = 'SELECT id,basic_id,play_method,codes FROM plans_jczqs where parent_id=0 and status=2 and match_results is null';
		$query = 'SELECT id,basic_id,issue,play_method,codes FROM plans_bjdcs where parent_id=0 and match_results is null AND STATUS =2';
		//d($query, FALSE);
		 
		$plans = $db->query($query);
		$match_result = array();
		$match_id = array();
		$ii = 0;
		foreach ($plans as $plan) {
			$plan_id = $plan->id;
			$order_num = $plan->basic_id;
	
			d($order_num, FALSE);
	
			$plan_result = array();
			$play_method = $plan->play_method;
			$issue = $plan->issue;
			$codes = $plan->codes;
			
			d($codes, FALSE);
			
			$matchs = explode('/', $codes);
			
			d($matchs, FALSE);
			
			$matchs_count = count($matchs);
			$flag = 0;
			//订单里的赛事信息
			for ($i = 0; $i < $matchs_count; $i++) {
				$match_info = explode('[', $matchs[$i]);
				$match_info_t = explode(':', $match_info[0]);
				$match_no = $match_info_t[0];
				$choose_match_result = substr($match_info[1], 0, -1); 
				$result = $match_detail_obj->getMatchInfoByBetidIssueNo($play_method, $issue, $match_no);
				
				//d($result, FALSE);
				
				if ($result['code'] !== NULL && $result['sp_r'] != '') {
					$plan_result[] = $match_no.'|'.$result['code'];
					$flag++;
				}
			}
			//echo $flag;
			$plan_result_s = implode(',', $plan_result);
			
			d($plan_result_s, false);
			
			if ($flag == $matchs_count) {
				$ticket_results = $ticketobj->get_results_by_ordernum($order_num);
				foreach ($ticket_results as $ticket_result) {
					$ticket_code = $ticket_result['codes'];
					$ticket_id = $ticket_result['id'];
					$ticket_play_method = $ticket_result['play_method'];
					$this->update_bd_ticket_sp($ticket_id, $ticket_play_method, $ticket_code);
				}
				
				//订单里赛事的赛果已全部更新
				$update_query = 'update plans_bjdcs set match_results="'.$plan_result_s.'" where id="'.$plan_id.'"';
				$db->query($update_query);
				//d($update_query, FALSE);
				$ii++;
				
				
			}
		}
		d('更新了 '.$ii.' 个方案赛果', FALSE);
		return TRUE;
	}
	
	/**
	 * 更新moreinfo
	 * @param unknown_type $id
	 * @param unknown_type $play_method
	 * @param unknown_type $codes
	 * @param unknown_type $ticket_type
	 */
	public function update_bd_ticket_sp($id, $play_method, $codes, $ticket_type=7) {
		require_once WEBROOT.'cron_script/SQL.php';
		$sql_obj = new SQL();
		$return = array();
		$code_a = explode(';', $codes);
		$code = $code_a[0];
		$issue = $code_a[1];
		$match_detail = explode('/', $code);
		for ($i = 0; $i < count($match_detail); $i++) {
			$match_info = explode('[', $match_detail[$i]);
			$match_info_t = explode(':', $match_info[0]);
			$match_info_t1 = '['.$match_info[1];
			$match_no = $match_info_t[0];
			preg_match_all("/\[(.*)\]/", $match_info_t1, $match_result, PREG_SET_ORDER);
			$match_results = $match_result[0][1];
			$match_results_a = explode(',', $match_results);
			$match_result_sp = array();
			$select_match_query = 'select sp,goalline,code,sp_r from match_bjdc_datas where betid="'.$play_method.'" and issue="'.$issue.'" and match_no="'.$match_no.'" limit 1';
			$sql_obj->query($select_match_query);
			$match_data = $sql_obj->fetch_array();
	
			$sp = $match_data['sp'];
			$goalline = $match_data['goalline'];
			$match_code = $match_data['code'];
			$sp_r = $match_data['sp_r'];
	
			$play_config = array();
			$play_result = array();
			switch ($play_method) {
				//让球胜平负
				case '501':
					$play_result = array(
					'3' => '1',
					'1' => '2',
					'0' => '3',
					);
					$play_config = array(
					'胜' => '1',
					'平' => '2',
					'负' => '3',
					);
					break;
					//上下单双
				case '502':
					$play_result = array(
					'3' => '1',
					'2' => '2',
					'1' => '3',
					'0' => '4',
					);
					$play_config = array(
					'上+单' => '1',
					'上+双' => '2',
					'下+单' => '3',
					'下+双' => '4',
					);
					break;
					//总进球数
				case '503':
					$play_result = array(
					'0' => '1',
					'1' => '2',
					'2' => '3',
					'3' => '4',
					'4' => '5',
					'5' => '6',
					'6' => '7',
					'7' => '8',
					);
					$play_config = array(
					'0' => '1',
					'1' => '2',
					'2' => '3',
					'3' => '4',
					'4' => '5',
					'5' => '6',
					'6' => '7',
					'7+' => '8',
					);
					break;
					//比分
				case '504':
					$play_result = array(
					'9' => '25',
					'90' => '10',
					'99' => '15',
					'0' => '11',
					'1' => '16',
					'2' => '17',
					'3' => '18',
					'4' => '24',
					'10' => '1',
					'11' => '12',
					'12' => '19',
					'13' => '20',
					'14' => '21',
					'20' => '2',
					'21' => '4',
					'22' => '13',
					'23' => '22',
					'24' => '23',
					'30' => '3',
					'31' => '5',
					'32' => '7',
					'33' => '14',
					'40' => '9',
					'41' => '6',
					'42' => '8',
					);
					$play_config = array(
					'负其他' => '25',
					'胜其他' => '10',
					'平其他' => '15',
					'0:0' => '11',
					'0:1' => '16',
					'0:2' => '17',
					'0:3' => '18',
					'0:4' => '24',
					'1:0' => '1',
					'1:1' => '12',
					'1:2' => '19',
					'1:3' => '20',
					'1:4' => '21',
					'2:0' => '2',
					'2:1' => '4',
					'2:2' => '13',
					'2:3' => '22',
					'2:4' => '23',
					'3:0' => '3',
					'3:1' => '5',
					'3:2' => '7',
					'3:3' => '14',
					'4:0' => '9',
					'4:1' => '6',
					'4:2' => '8',
					);
					break;
					//半全场
				case '505':
					$play_result = array(
					'33' => '1',
					'31' => '2',
					'30' => '3',
					'13' => '4',
					'11' => '5',
					'10' => '6',
					'3' => '7',
					'1' => '8',
					'0' => '9',
					);
					$play_config = array(
					'胜-胜' => '1',
					'胜-平' => '2',
					'胜-负' => '3',
					'平-胜' => '4',
					'平-平' => '5',
					'平-负' => '6',
					'负-胜' => '7',
					'负-平' => '8',
					'负-负' => '9',
					);
					break;
				default: break;
			}
	
			//$sp = '{"cc":{"c":"cc","v":"4.30","s":"1","d":"2011-09-06","t":"05:59:00"},"cb":{"c":"cb","v":"15.00","s":"1","d":"2011-09-06","t":"05:59:00"},"ca":{"c":"ca","v":"28.00","s":"1","d":"2011-09-06","t":"05:59:00"},"bc":{"c":"bc","v":"6.50","s":"1","d":"2011-09-06","t":"05:59:00"},"bb":{"c":"bb","v":"4.50","s":"1","d":"2011-09-06","t":"05:59:00"},"ba":{"c":"ba","v":"5.40","s":"1","d":"2011-09-06","t":"05:59:00"},"ac":{"c":"ac","v":"34.00","s":"1","d":"2011-09-06","t":"05:59:00"},"ab":{"c":"ab","v":"15.00","s":"1","d":"2011-09-06","t":"05:59:00"},"aa":{"c":"aa","v":"3.85","s":"1","d":"2011-09-06","t":"05:59:00"}}';
			$sp = json_decode($sp);
			$result_sp = array();
			foreach ($sp as $key => $val) {
				$result_sp[$key] = $val;
			}
			//var_dump($match_results_a);die();
			for ($j = 0; $j < count($match_results_a); $j++) {
				$key = $play_config[$match_results_a[$j]];
				if ($play_result[$match_code] == $key) {
					$match_result_sp[] = round($sp_r, 2);;
				}
				else {
					$match_result_sp[] = 0;
				}
			}
			$match_result_sp = implode(',', $match_result_sp);
			//var_dump($match_result_sp);die();
			/* if ($play_method == '501' && $goalline > 0) {
				$goalline = '+'.$goalline;
				$return[] = $match_no.'('.$goalline.'):'.$match_result_sp;
			}
			else { */
			$return[] = $match_no.':'.$match_result_sp;
			//}
		}
		$return = implode('|', $return);
		//var_dump($return);die();
		$sql_obj->query('update ticket_nums set moreinfo="'.$return.'" where id="'.$id.'"');
		if (!$sql_obj->error()) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * 自动兑奖
	 */
	public function bonus_count() {
		$obj = ORM::factory('plans_bjdc');
		$obj->where('status', 2)->where('match_results <>', '');
		$results = $obj->find_all();
		//d($results);
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
			//d($ticket_results, false);
			//所有彩票
			foreach ($ticket_results as $rowticket)
			{
				//更新彩票状态及奖金
				$ticketobj->update_bonus($rowticket['id'], $rowticket['bonus']);
			}
		}
	}
	
	/**
	 * 统计指定方案中中奖的彩票信息,并以数组形式返回
	 * @param unknown_type $plan
	 * @return array  彩票及彩票扯分的组合数据
	 */
	public function bonus_ticket_count($plan) {
		$test_open = true;    //调试开关
		$is_hidden = true;    //隐藏
		//d($plan);
		$matchobj = match_bjdc::get_instance();
		
		if (empty($plan))
			return FALSE;
	
		//无赛果的方案则返回
		if (empty($plan['match_results']))
			return FALSE;
	
		if ($test_open && $is_hidden) {
			echo '<!--';
		}
	
		$test_open && d('方案信息:', FALSE);
		$test_open && d($plan, FALSE);
	
		$match_result = $plan['match_results'];     //赛果
		$match_code = $plan['codes'];               //选项
	
		$arrmatch_result_source = explode(',', $match_result);    //赛果
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
		$arrmatch_result = array();
		foreach ($arrmatch_code as $rowkey => $rowmatch) {
			//14:[上+单,上+双,下+单,下+双]
			$arrtmp = explode('[', $rowmatch);
			$arrtmp2 = '['.$arrtmp[1];
			$arrtmp3 = explode(':', $arrtmp[0]);
			$match_no = $arrtmp3[0];
			
			//$arrtmp = explode('|', $rowmatch);//30078|6017[0] => 30078,6017[0]
			//$arrtmp2 = explode('[', $rowmatch);//30078|6017[0] => 30078|6017,0]
	
			foreach ($arrmatch_result_source as $keyresult => $rowresult) {
				//14|1
				if (strstr($rowresult, $match_no)) {
					$arrmatch_result[$keyresult] = $match_no.'|['.end(explode('|',$rowresult)).']';
					continue;
				}
			}
		}
	
		$test_open && d('重构的赛果:', FALSE);
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
			$issue = $codes[1];
			$test_open && d('检测彩票赔率是否正常:', FALSE);
			$test_open && d($arrcodes, FALSE);
			$test_open && d($arrodds, FALSE);
	
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
			$play_config = array();
			$ticket_play_method = $rowresult['play_method'];
			switch ($ticket_play_method) {
				//让球胜平负
				case '501':
					$play_config = array(
					'胜' => '3',
					'平' => '1',
					'负' => '0',
					);
					break;
					//上下单双
				case '502':
					$play_config = array(
					'上+单' => '3',
					'上+双' => '2',
					'下+单' => '1',
					'下+双' => '0',
					);
					break;
					//总进球数
				case '503':
					$play_config = array(
					'0' => '0',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
					'7+' => '7',
					);
					break;
					//比分
				case '504':
					$play_config = array(
					'负其他' => '9',
					'胜其他' => '90',
					'平其他' => '99',
					'0:0' => '0',
					'0:1' => '1',
					'0:2' => '2',
					'0:3' => '3',
					'0:4' => '4',
					'1:0' => '10',
					'1:1' => '11',
					'1:2' => '12',
					'1:3' => '13',
					'1:4' => '14',
					'2:0' => '20',
					'2:1' => '21',
					'2:2' => '22',
					'2:3' => '23',
					'2:4' => '24',
					'3:0' => '30',
					'3:1' => '31',
					'3:2' => '32',
					'3:3' => '33',
					'4:0' => '40',
					'4:1' => '41',
					'4:2' => '42',
					);
					break;
					//半全场
				case '505':
					$play_config = array(
					'胜-胜' => '33',
					'胜-平' => '31',
					'胜-负' => '30',
					'平-胜' => '13',
					'平-平' => '11',
					'平-负' => '10',
					'负-胜' => '3',
					'负-平' => '1',
					'负-负' => '0',
					);
					break;
				default: break;
			}
			
			$ticket_odds = array();
			$new_plan_codes = array();
			$i = 0;
			foreach ($arrcodes as $rowvalue => $rowcode) {
				//14:[平]
				$t1 = explode('[', $rowcode);
				$t2 = explode(':', $t1[0]);
				$match_no = $t2[0];
				preg_match_all("/\[(.*)\]/", $rowcode, $match_result, PREG_SET_ORDER);
				
				$match_results = $match_result[0][1];
				//d($match_results);
				$match_results_arr = explode(',', $match_results);
				$match_results_arr_new = array();
				foreach ($match_results_arr as $mk => $mr) {
					$match_results_arr_new[] = $play_config[$mr];
				}
				$match_results_new = implode(',', $match_results_arr_new);
				
				$rowcode = $match_no.'|'.'['.$match_results_new.']';
				
				//d($rowcode,false);
				$new_plan_codes[] = $rowcode;
				if (substr_count($rowcode, ',') > 0) {
					$arrtestcode1 = explode('[', $rowcode);
					$arrtestcode[1] = substr($arrtestcode1[1], 0, strlen($arrtestcode1[1])-1);
					$arrtestcode = explode(',', $arrtestcode[1]);
					d($arrtestcode, false);
					
					$arrtestodds = explode(':', $arrodds[$rowvalue]);
					$arrtestodds = explode(',', $arrtestodds[1]);
					d($arrtestodds, false);
					foreach ($arrtestcode as $keypull => $rowpull) {
						if (!isset($arrtestodds[$keypull])) {
							d('data error:', FALSE);
							d($plan['basic_id'], FALSE);
							d($match_code, FALSE);
							continue 3;
						}
						else {
							$ticket_odds[$arrtestcode1[0].'['.$rowpull.']'] = $arrtestodds[$keypull];
						}
					}
				}
				else {
					$ticket_odds[$rowcode] = end(explode(':', $arrodds[$i]));
				}
				$i++;
			}
			$test_open && d('重构的赔率:', FALSE);
			$test_open && d($ticket_odds, false);
			
			/**
			 * 扯分的彩票
			 * 由于所选择的彩票中一场可以有多个彩票,为了计算奖金需要拆分计算
			 * 重新组合 5|[3,0]/7|[3,1]/8|[3,0];3串7
			 */
			$new_plan_codes_s = implode('/', $new_plan_codes).';'.$codes[2];
			//d($new_plan_codes_s);
			//d($rowresult['codes'], false);
			$ticketdetail = array();
			$ticketdetail = $ticketobj->get_bjdc_note($new_plan_codes_s);
	
			$test_open && d('扯分的彩票:', FALSE);
			$test_open && d($ticketdetail,false);
	
			$tickets_bonus_detail = array();
	
			//提取中奖的组合
			foreach ($ticketdetail as $rowdetail)
			{
				$arrdetail = explode('/', $rowdetail);
				$is_bonus = TRUE;
				foreach ($arrdetail as $rowdetaildetail)
				{
					$test_open && d('匹配中奖:', FALSE);
					$test_open && d($rowdetaildetail, FALSE);
					$test_open && d('中奖的信息:', FALSE);
					$test_open && d($arrmatch_result, false);
	
					if (!in_array($rowdetaildetail, $arrmatch_result))
					{
						$is_bonus = FALSE;
						break;
					}
				}
	
				$test_open && d('是否中奖:', FALSE);
				$test_open && d($is_bonus, FALSE);
	
				if ($is_bonus)
				{
					$tickets_bonus_detail[] = $rowdetail;
				}
			}
	
			$tickets_detail_result = array();
			//d($tickets_bonus_detail);
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
}
