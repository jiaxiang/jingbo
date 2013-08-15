<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 彩票操作
 */
class ticket_Core {
    private static $instance = NULL;
    private $send_server_url = '';                    //发送打印彩票命令接口网址
    private $recive_server_url = '';                  //接收彩票返回命令接口网址  
    private $username = '';                           //接口帐号 
    private $password = '';                           //接口密码
    
    
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    public function __construct()
    {
        $this->send_server_url = '';
        $this->recive_server_url = '';
        $this->username = '';
        $this->password = '';
    }
    
    
    /*
     * 获取打印机返回信息
     */
    public function recive_ticket()
    {
        /*
         * 此处为接受操作,及时更新彩票信息
         */
    }
    
    
    /*
     * 打印彩票命令
     */
    public function send_ticket()
    {
        /*
         * 
         * 此处为发送操作
         * 
         */
    }
    
	public function getNewStyleCode($acode){
//		$acode = '25703|4301[15,04,05]/25704|4302[14]';
		$t_type = '';
		$i = strpos($acode, ';');
		if ($i>1){
			$t_type = substr($acode, $i);
			$acode = substr($acode, 0, $i);
		}
		$t_code1 = explode('/', $acode);
		$t_code2 = array();
		foreach ($t_code1 as $key => $val)
		{
			$val = str_replace(']', '', $val);
			$val = str_replace('[', '|', $val);
			$val = substr($val, strpos($val, '|')+1);
			$val = substr($val, 0, 1) . '|' . substr($val, 1);
			$t_code2[$key] = $val;
		}
		$t_code1 = str_replace('||','|',implode('|', $t_code2));
		if (substr($t_code1,strlen($t_code1)-1) == '|')
			$t_code1 = substr($t_code1,0,strlen($t_code1)-1);
		return $t_code1.$t_type;
	}
    /*
     * 插入彩票表
     * @param  integer  $plan_id  方案id(各大类的方案存储id,非基表id)
     * @param  integer  $ticket_type  彩票id
     * @param  integer  $play_method  玩法id
     * @param  string   $codes	彩票代码 
     * @param  integer  $rate  倍数
     * @return boolean  TRUE OR FALSE
     */
    public function crate_ticket($plan_id, $ticket_type, $play_method, $codes, $rate, $ordernum, $money = 0 )
    {
        if(empty($plan_id) || empty($ticket_type) || empty($play_method) || empty($codes) || empty($rate) || empty($ordernum))
            return FALSE;
        $maxlng = 99;
        
        if ($ticket_type == 6){
        	$codes_print = $this->getNewStyleCode($codes);
        }else{ 
        	$codes_print = $codes;
        }
        //大于99倍时则需要重新设置
        if ($rate > $maxlng)
        {
            $maxloop = intval($rate / $maxlng);
            $surplus = $rate % $maxlng;
            $each_money = $money / $rate;
            
            for ($i = 0; $i < $maxloop; $i++)
            {
                $data = array();    
                $data['plan_id'] = $plan_id;
                $data['ticket_type'] = $ticket_type;
                $data['play_method'] = $play_method;
                $data['codes'] = $codes;
                $data['codes_print'] = $codes_print;
                $data['rate'] = $maxlng;
                $data['money'] = $each_money * $maxlng;
                $data['order_num'] = $ordernum;
                $this->add($data);
            }
            if ($surplus > 0)
            {
                $data = array();
                $data['plan_id'] = $plan_id;
                $data['ticket_type'] = $ticket_type;
                $data['play_method'] = $play_method;
                $data['codes'] = $codes;
                $data['codes_print'] = $codes_print;
                $data['rate'] = $surplus;
                $data['money'] = $each_money * $surplus;
                $data['order_num'] = $ordernum;
                $this->add($data);
            }
        }
        else
        {
            $data = array();    
            $data['plan_id'] = $plan_id;
            $data['ticket_type'] = $ticket_type;
            $data['play_method'] = $play_method;
            $data['codes'] = $codes;
            $data['codes_print'] = $codes_print;
            $data['rate'] = $rate;
            $data['money'] = $money;
            $data['order_num'] = $ordernum;
            $this->add($data);
        }
    }
    
    
    /*
     * 添加入库
     */
    public function add($data)
    {
        $obj = ORM::factory('ticket_num');
	    if (!$obj->validate($data))
	        return FALSE;
		if (empty($data['codes_print'])){
			$data['codes_print'] = $obj->codes;
		}
	    $obj->plan_id = $data['plan_id'];
	    $obj->ticket_type = $data['ticket_type'];
	    $obj->play_method = $data['play_method'];
        $obj->codes = $data['codes'];
        $obj->codes_print = $data['codes_print'];
        $obj->rate = $data['rate'];
        $obj->money = $data['money'];
        $obj->order_num = $data['order_num'];
        $obj->status = 0;
        $obj->save();
        
        if ($obj->saved)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    
    
    /*
     * 兑奖操作作
     * 
     * 对彩票状态为已出票的彩票遍历检查是否中奖
     * 将分别对每种彩票操作,返回结果 奖金:array(), 参数(status:0,未开奖, 1 已开奖; bonus 奖金)
     */
    public function  check_bonus()
    {
        @set_time_limit(300);
        
        $obj = ORM::factory('match_data')->where('status', 2);
        $results = $obj->find_all();
        
        $jczq_obj = Plans_jczqService::get_instance();
        $sfc_obj = Plans_sfcService::get_instance();
        
        
        foreach ($results as $row)
        {
            $data = array();
            switch ($row['ticket_type'])
            {
                case 1:
                    $data = $jczq_obj->check_bonus($row);
                    break;
                case 2:
                    $data = $sfc_obj->check_bonus($row);
                    break;
                case 3:
                    //$data = 
                    break;
                case 4:
                    //$data = 
                    break;
            }
            
            if (!empty($data))
            {
                if ($data['status'] == 1)
                {
                    //更新彩票状态
                    $this->update_ticket($row['id'], $data['bonus']);
                }
            }
            
            
        }
        
        
    }
    
    
    /*
     * 更新彩票状态
     * @param  array  $ids  彩票id
     * @param  integer  $updateto  更新的状态值
     * @param  array  $constatus  状态满足的条件
     * @return integer 成功的数量
     */
    public function update_status($ids, $updateto, $constatus, $manager_id = 0)
    {
        $updateto = intval($updateto);
        if (empty($ids) || empty($constatus))
        {
            return FALSE;
        }
                
        $obj = ORM::factory('ticket_num');
        
        $i = 0;
        foreach ($ids as $rowid)
        {
            $obj->where("id", $rowid)->find();
            if ($obj->loaded)
            {
                if (in_array($obj->status, $constatus))
                {
                    $obj->status = $updateto;
                    
                    switch ($updateto)
                    {
                        case 1:
                           $obj->time_print = tool::get_date();
                        break;
                        case 2:
                           $obj->time_duijiang = tool::get_date();
                        break;
                        case 0:
                            $obj->time_print = NULL;
                        break;
                    }
                    $obj->time_lastaction = tool::get_date();
                    
                    if (!empty($manager_id))
                    {
                        $obj->manager_id = $manager_id;
                    }
                    $obj->save();
                    
                    if ($obj->saved)
                    {
                        $i++;
                    }
                }
            }
        }
        
        return $i;
    }
    
    
    
    /*
     * 更新彩票表状态及奖金
     */
    public function update_ticket($ticket_id, $bonus, $manager_id = 0)
    {
        $obj = ORM::factory('ticket_num', $ticket_id);
        if ($obj->loaded)
        {
            $obj->status = 2;                        //更新为已兑奖
            $obj->bonus = $bonus;
            $obj->manager_id = $manager_id;
            $obj->save();
            
            if ($obj->saved)
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
     * 更新彩票表状态及奖金
     */
    public function update_bonus($ticket_id, $bonus, $manager_id = 0)
    {
        $obj = ORM::factory('ticket_num', $ticket_id);
        if ($obj->loaded)
        {
            $obj->status = 2;                        //更新为已兑奖
            $obj->bonus = $bonus;
            $obj->manager_id = $manager_id;
            $obj->time_duijiang = tool::get_date();
            $obj->time_lastaction = tool::get_date();
            $obj->save();
            if ($obj->saved)
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
     * 根据id获取当前彩票表信息
     */
    public function get($ticket_id)
    {
        $obj = ORM::factory('ticket_num', $ticket_id);
        if ($obj->loaded)
        {
            return $obj->as_array();
        }
        else
        {
            return FALSE;
        }
    } 

    
    /*
     * 提交数据
     */
    function get_url($url){
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_HEADER, 0);
    	curl_setopt($curl, CURLOPT_TIMEOUT, 3);//超时时间
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	$data = curl_exec($curl);
    	if (strpos ($data, "\n") > 0){
    		$data = substr ($data, 0, strpos ($data, "\n"));       	
    	}
    	curl_close($curl);
    	return $data;
    }
    
    /*
     * 获取数据
     */
    function get_request_url($url){
    	$curl = curl_init();
    	curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_HEADER, 0);
    	curl_setopt($curl, CURLOPT_TIMEOUT, 3);//超时时间
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    	$data = curl_exec($curl);
    	curl_close($curl);
    	if ($data === false){
    	    return false;
    	}
    	return $data;
    }
    
	/**
     * 根据方案id获得彩票信息
     * Enter description here ...
     * @param unknown_type $pid
     */
    function getTicketByPlanID($pid, $order_num) {
        $obj = ORM::factory('ticket_num');
    	$obj->select('*');
    	$obj->where('order_num', $order_num);
        $obj->where('plan_id', $pid);
        $obj->orderby('id', 'ASC');
        $results = $obj->find_all();
        $t_info = array();
        foreach ($results as $result) {
        	$t = $result->as_array();
        	$t_info[] = $t;
        }
        return $t_info;
    }
    
    /**
     * 获取北单未出票的数据
     * Enter description here ...
     */
    function getUnPostTicketBjdc() {
    	$obj = ORM::factory('ticket_num');
    	$obj->select('*');
    	$obj->where('ticket_type', 7);
    	$obj->where('status', 0);
    	$obj->where('id', 6090);
        $obj->orderby('id', 'ASC');
        $results = $obj->find_all();
        $t_info = array();
        foreach ($results as $result) {
        	$t = $result->as_array();
        	$t_info[] = $t;
        }
        return $t_info;
    }
    
    /*
     * 根据订单号获得所有彩票
     */
    public function get_results_by_ordernum($order_num)
    {
        $obj = ORM::factory('ticket_num');
    	$obj->where('order_num', $order_num);
        $obj->orderby('id', 'ASC');
        $results = $obj->find_all();
        $return = array();
        foreach ($results as $result) {
        	$return[] = $result->as_array();
        }
        unset($results);
        return $return;
    }
    
    /*
     * 将竞彩足球信息数组扯分成注
     * @param string $code 彩票代码
     * @result array 扯分成的数组
     */
    public function get_jczq_note($code)
    {
        $arrcode = explode(';', $code);
        $type = $arrcode[1];
        $arrtype = explode('串', $type);
        
        $rule_mxn = Kohana::config('rule_mxn.jczq');
                
        $newcodes = array();
        //多串过关
        if ($arrtype[1] > 1)
        {
            $cur_rule = $rule_mxn[$arrtype[0]][$arrtype[1]];
            $cur_types = array();
            $tmpcodes = explode('/', $arrcode[0]);
            foreach ($cur_rule as $rowkey => $rowvalue)
            {
                if ($rowvalue > 0)
                {
                    $cur_types[] = $rowkey;
                }
            }

            //扯分类别
            foreach ($cur_types as $rowtype)
            {
                $arrrowtype = explode('串', $rowtype);
                $tmp_newcode = tool::get_combination($tmpcodes, $arrrowtype[0]);
                $newcodes = array_merge($newcodes, $tmp_newcode);
            }
        }
        else 
        {
            $newcodes[] = $arrcode[0];
        }
        
        
        $returns = array();
        //对每一组再检测是否拆分
        foreach ($newcodes as $rowcode)
        {
            $newchecks = array();
            $tmpcodes = explode('/', $rowcode);
            $curtype = count($tmpcodes);

            foreach ($tmpcodes as $rownewcode)
            {
                $tmprownewcode = explode('[', $rownewcode);
                //检测是否是多个
                $tmprownewcode[1] = substr( $tmprownewcode[1], 0, (strlen($tmprownewcode[1]) - 1));
                $checkrownewcode = explode(',', $tmprownewcode[1]);
                
                //当是多个的时候再重构
                if (count($checkrownewcode) > 1)
                {
                    foreach ($checkrownewcode as $rowcheck)
                    {
                        $newchecks[] = $tmprownewcode[0].'['.$rowcheck.']';
                    }
                }
                else 
                {
                    $newchecks[] = $rownewcode;
                }
            }
            
            //删除重构后的无效选项
            if ($curtype < count($newchecks))
            {
                //重新组合
                $tmparr = tool::get_combination($newchecks, $curtype);

                //过滤无效
                foreach ($tmparr as $rowkey => $rowvalue)
                {
                    $checkarr = array();
                    $rowarr = explode('/', $rowvalue);
                    foreach ($rowarr as $rowsubarr)
                    {
                        $arrrowsub = explode('[', $rowsubarr);
                        $checkarr[] = $arrrowsub[0];
                    }
                    
                    //统计相同值
                    $arrcount = array_count_values($checkarr);
                    $delarr = FALSE;

                    foreach ($arrcount as $rowcount)
                    {
                        //检查到有重复信息标记为删除
                        if ($rowcount > 1)    
                        {
                            $delarr = TRUE;
                            break;
                        }
                    }
                    
                    if ($delarr)
                    {
                        unset($tmparr[$rowkey]);
                    }
                }
                $returns = array_merge($returns, $tmparr);
            }
            else
            {
                $returns = array_merge($returns, array($rowcode));
            }
        }        
        return $returns;
    }
    
	/**
     * 将竞彩篮球信息数组扯分成注
     * @param string $code 彩票代码
     * @result array 扯分成的数组
     */
	public function get_jclq_note($code)
	{
		$arrcode = explode(';', $code);
		$type = $arrcode[1];
		
		$newcodes = array();
		
		//echo '$type = '.$type.'<br/>';
		if ($type == '单关')	//如果是篮球单关的
		{
			$tmpcodes = explode('/', $arrcode[0]);
			$newcodes = array_merge($newcodes, $tmpcodes);
		}
		else if (mb_strpos($type, '串') > 0)	//如果是多串过关
		{
			$arrtype = explode('串', $type);
			
			$rule_mxn = Kohana::config('rule_mxn.jczq');
			
			//多串过关
			if ($arrtype[1] > 1)
			{
				$cur_rule = $rule_mxn[$arrtype[0]][$arrtype[1]];
				$cur_types = array();
				$tmpcodes = explode('/', $arrcode[0]);
				foreach ($cur_rule as $rowkey => $rowvalue)
				{
					if ($rowvalue > 0)
					{
						$cur_types[] = $rowkey;
					}
				}
	
				//扯分类别
	            foreach ($cur_types as $rowtype)
	            {
	                $arrrowtype = explode('串', $rowtype);
	                $tmp_newcode = tool::get_combination($tmpcodes, $arrrowtype[0]);
	                $newcodes = array_merge($newcodes, $tmp_newcode);
	            }
	        }
	        else 
	        {
	            $newcodes[] = $arrcode[0];
	        }
        }
		
		
        $returns = array();
        //对每一组再检测是否拆分
        foreach ($newcodes as $rowcode)
        {
            $newchecks = array();
            $tmpcodes = explode('/', $rowcode);
            $curtype = count($tmpcodes);

            foreach ($tmpcodes as $rownewcode)
            {
                $tmprownewcode = explode('[', $rownewcode);
                //检测是否是多个
                $tmprownewcode[1] = substr( $tmprownewcode[1], 0, (strlen($tmprownewcode[1]) - 1));
                $checkrownewcode = explode(',', $tmprownewcode[1]);
                
                //当是多个的时候再重构
                if (count($checkrownewcode) > 1)
                {
                    foreach ($checkrownewcode as $rowcheck)
                    {
                        $newchecks[] = $tmprownewcode[0].'['.$rowcheck.']';
                    }
                }
                else 
                {
                    $newchecks[] = $rownewcode;
                }
            }
            
            //删除重构后的无效选项
            if ($curtype < count($newchecks))
            {
                //重新组合
                $tmparr = tool::get_combination($newchecks, $curtype);
    
                //过滤无效
                foreach ($tmparr as $rowkey => $rowvalue)
                {
                    $checkarr = array();
                    $rowarr = explode('/', $rowvalue);
                    foreach ($rowarr as $rowsubarr)
                    {
                        $arrrowsub = explode('[', $rowsubarr);
                        $checkarr[] = $arrrowsub[0];
                    }
                    
                    //统计相同值
                    $arrcount = array_count_values($checkarr);
                    $delarr = FALSE;

                    foreach ($arrcount as $rowcount)
                    {
                        //检查到有重复信息标记为删除
                        if ($rowcount > 1)    
                        {
                            $delarr = TRUE;
                            break;
                        }
                    }
                    
                    if ($delarr)
                    {
                        unset($tmparr[$rowkey]);
                    }
                }
                $returns = array_merge($returns, $tmparr);
            }
            else
            {
                $returns = array_merge($returns, array($rowcode));
            }
        }        
        return $returns;
    }
    
    /**
     * 将北京单场信息数组扯分成注
     * @param string $code 彩票代码,14:[平]/16:[负];120402;2串1
     * @result array 扯分成的数组
     */
    public function get_bjdc_note($code)
    {
    	$arrcode = explode(';', $code);
    	$type = $arrcode[1];
    
    	$newcodes = array();
    
    	//echo '$type = '.$type.'<br/>';
    	if ($type == '单关')	//如果是篮球单关的
    	{
    		$tmpcodes = explode('/', $arrcode[0]);
    		$newcodes = array_merge($newcodes, $tmpcodes);
    	}
    	else if (mb_strpos($type, '串') > 0)	//如果是多串过关
    	{
    		$arrtype = explode('串', $type);
    		
    		$rule_mxn = Kohana::config('rule_mxn.bjdc');
    			
    		//多串过关
    		if ($arrtype[1] > 1)
    		{
    			$cur_rule = $rule_mxn[$arrtype[0]][$arrtype[1]];
    			$cur_types = array();
    			$tmpcodes = explode('/', $arrcode[0]);
    			foreach ($cur_rule as $rowkey => $rowvalue)
    			{
    				if ($rowvalue > 0)
    				{
    					$cur_types[] = $rowkey;
    				}
    			}
    			//d($cur_types);
    			//扯分类别
    			foreach ($cur_types as $rowtype)
    			{
    				$arrrowtype = explode('串', $rowtype);
    				if ($rowtype == '单场') {
    					$arrrowtype[0] = 1;
    				}
    				$tmp_newcode = tool::get_combination($tmpcodes, $arrrowtype[0]);
    				$newcodes = array_merge($newcodes, $tmp_newcode);
    			}
    			
    		}
    		else
    		{
    			$newcodes[] = $arrcode[0];
    		}
    	}
    
    
    	$returns = array();
    	//对每一组再检测是否拆分
    	foreach ($newcodes as $rowcode)
    	{
    		$newchecks = array();
    		$tmpcodes = explode('/', $rowcode);
    		$curtype = count($tmpcodes);
    
    		foreach ($tmpcodes as $rownewcode)
    		{
    			$tmprownewcode = explode('[', $rownewcode);
    			//检测是否是多个
    			$tmprownewcode[1] = substr( $tmprownewcode[1], 0, (strlen($tmprownewcode[1]) - 1));
    			$checkrownewcode = explode(',', $tmprownewcode[1]);
    
    			//当是多个的时候再重构
    			if (count($checkrownewcode) > 1)
    			{
    				foreach ($checkrownewcode as $rowcheck)
    				{
    					$newchecks[] = $tmprownewcode[0].'['.$rowcheck.']';
    				}
    			}
    			else
    			{
    				$newchecks[] = $rownewcode;
    			}
    		}
    
    		//删除重构后的无效选项
    		if ($curtype < count($newchecks))
    		{
    			//重新组合
    			$tmparr = tool::get_combination($newchecks, $curtype);
    
    			//过滤无效
    			foreach ($tmparr as $rowkey => $rowvalue)
    			{
    				$checkarr = array();
    				$rowarr = explode('/', $rowvalue);
    				foreach ($rowarr as $rowsubarr)
    				{
    					$arrrowsub = explode('[', $rowsubarr);
    					$checkarr[] = $arrrowsub[0];
    				}
    
    				//统计相同值
    				$arrcount = array_count_values($checkarr);
    				$delarr = FALSE;
    
    				foreach ($arrcount as $rowcount)
    				{
    					//检查到有重复信息标记为删除
    					if ($rowcount > 1)
    					{
    						$delarr = TRUE;
    						break;
    					}
    				}
    
    				if ($delarr)
    				{
    					unset($tmparr[$rowkey]);
    				}
    			}
    			$returns = array_merge($returns, $tmparr);
    		}
    		else
    		{
    			$returns = array_merge($returns, array($rowcode));
    		}
    	}
    	return $returns;
    }
}