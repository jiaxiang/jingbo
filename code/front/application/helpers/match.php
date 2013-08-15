<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 赛事操作(竞彩足球,竞彩篮球)
 */
class match_Core {
    private static $instance = NULL;
    private static $match_jczq_detail_url = 'http://info.sporttery.cn/football/info/fb_match_info.php?m=';
    private static $match_jclq_detail_url = 'http://info.sporttery.cn/basketball/info/bk_match_info.php?m=';

    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    
	/**
	 * 更新或添加信息
	 *
	 * @param  	array 	$data
	 * @return 	bool true or false
	 */
	public function update($data)
	{
	    $obj = ORM::factory('match_data');
	    if (!$obj->validate($data))
	        return FALSE;
	   
		$obj->where('play_type', $data['play_type'])
		    ->where('ticket_type', $data['ticket_type'])
		    ->where('match_num', $data['match_num'])
			->where('match_id', $data['match_id'])
			//->where('pool_id', $data['pool_id'])
			->find();
        
		if($obj->loaded)
		{
            $obj->comb = $data['comb'];
		    $obj->update_time = $data['update_time'];
		}
		else
		{
		    $obj->match_num = $data['match_num'];
		    $obj->match_id = $data['match_id'];
		    $obj->pool_id = $data['pool_id'];
            $obj->goalline = $data['goalline'];
            $obj->comb = $data['comb'];
            $obj->ticket_type = $data['ticket_type'];
            $obj->play_type = $data['play_type'];
            $obj->update_time = $data['update_time'];
		}
		return $obj->save();
	}
	
	/**
	 * 获取正在进行中的赛事完整数据
	 * 此处将预留接口获取更为合法的数据
	 * @param unknown_type $ticket_type
	 * @param unknown_type $play_type
	 * @param unknown_type $curtime
	 * @param unknown_type $league_name
	 */
	public function get_results($ticket_type, $play_type, $curtime = NULL, $league_name = NULL) 
	{
	    $matchs = array();
	    $timebeg = date("Y-m-d H:i:s", time() - 100000*60);
	    $matchtime_set = Kohana::config('site_config.match');

	    //今日结束时间设置
        $timeend = $this->count_end_time(tool::get_date());
        
        //print $timeend;
        
	    if ($ticket_type == 1)        //竞彩足球
	    {
    	    $obj = ORM::factory('match_data')
    	        ->select('match_details.*,match_datas.*')
    	        ->join('match_details', 'match_details.index_id', 'match_datas.match_id', 'LEFT')
                ->where('match_datas.ticket_type', $ticket_type)
    	        ->where('match_datas.play_type', $play_type)
    	        ->where('match_datas.pool_id', 0)
    	        ->where('match_details.status', 0);
    	    if ($league_name != NULL) {
    	    	switch ($league_name) {
    	    		case 'yc':
    	    			$obj->like('match_details.league', '英格兰超级联赛');
    	    			break;
    	    		case 'xj':
    	    			$obj->like('match_details.league', '西班牙甲级联赛');
    	    			break;
    	    		case 'yj':
    	    			$obj->like('match_details.league', '意大利甲级联赛');
    	    			break;
					case 'dj':
    	    			$obj->like('match_details.league', '德国甲级联赛');
    	    			break;
					case 'fj':
    	    			$obj->like('match_details.league', '法国甲级联赛');
    	    			break;
					case 'og':
    	    			$obj->like('match_details.league', '欧洲冠军联赛');
    	    			break;
					case 'oj':
    	    			$obj->like('match_details.league', '欧洲锦标赛');
    	    			break; 
    	    		default:break;   	    	
    	    	}
    	    }
            if (!empty($curtime))
            {
                $obj->like('match_details.time', $curtime);
            }
            else
            {
                $obj->where('match_details.time > ', tool::get_date());
            }
            $obj->orderby('match_details.time', 'ASC');
            
	    }
	    elseif ($ticket_type == 6)    //竞彩篮球
	    {
    	    $obj = ORM::factory('match_data')
    	        ->select('match_details.*,match_datas.*')
    	        ->join('match_details', 'match_details.index_id', 'match_datas.match_id', 'LEFT')
                ->where('match_datas.ticket_type', $ticket_type)
    	        ->where('match_datas.play_type', $play_type)
    	        ->where('match_details.status', 0);
    	        
            if (!empty($curtime))
            {
                $obj->like('match_details.time', $curtime);
            }
            else
            {
                $obj->where('match_details.time > ', tool::get_date());
            }
            $obj->orderby('match_details.time', 'ASC');
	    }
	    
        $results = $obj->find_all();
        $groups_dates = array();
        $end_dates = array();
        
        foreach ($results as $result) {
            $tmp = array();
            $tmp = $result->as_array();
                        
            if (empty($tmp['index_id']))
                continue;
            
            $timeend_stamp = strtotime($tmp['time']);//赛事开始时间
            $weekday = substr($tmp['match_info'], 0, 6);
			//echo substr($tmp['time'], 0, 10).'<br />';
			//echo $weekday.'<br />';
			$weekday_key = substr($tmp['time'], 0, 10).$weekday;
            if (empty($groups_dates[$weekday_key]))
            {
                $groups_dates[$weekday_key] = date("Y-m-d", strtotime(tool::get_date_byweek($weekday, 1, $tmp['time'])));               
                $end_dates[$weekday_key] = $this->count_end_time($groups_dates[$weekday_key]);
            }
            //var_dump($groups_dates);
            $tmp['match_weekday'] = $weekday;
            $tmp['match_date'] = $groups_dates[$weekday_key];        //销售的赛事日期
            $tmp['time_beg'] = date("Y-m-d H:i:s", $timeend_stamp + 60);    //比赛开始时间
            
            $tmp['time_end'] = $this->get_end_time($tmp['time'], $end_dates[$weekday_key], $matchtime_set['jczq_endtime']); //销售截止时间
            
            /* $xiushi_time = '2012-01-21 22:40:00';
            if ($tmp['time_end'] >= $xiushi_time) {
            	$tmp['time_end'] = '2012-01-21 22:40:00';
            } */
            
            if ($tmp['time_end'] == 'delay') {
            	$nweekday = $this->delay_weekday($weekday);
            	$nweekday_key = substr($tmp['time'], 0, 10).$nweekday;
            	$tmp['match_weekday'] = $nweekday;
            	$tmp['match_date'] = $groups_dates[$nweekday_key];
            	$tmp['time_end'] = $this->get_end_time($tmp['time'], $end_dates[$nweekday_key], $matchtime_set['jczq_endtime']); //销售截止时间
            }
            
            $tmp['match_end'] = 0;    //赛事结束或开始
            
            if (strtotime($tmp['time_end']) < time() || time() > strtotime($tmp['time_beg']))
            {
                $tmp['match_end'] = 1;
            }
            if ($tmp['match_url'] == null) {
            	$tmp['match_url'] = $this->get_match_detail_url($tmp['match_id'], $ticket_type);
            }
            $tmp['color'] = $this->get_match_color($tmp['league']);
            $tmp['league'] = $this->get_league_abb($tmp['league']);
            $matchs[] = $tmp;
        }
		//d($groups_dates);
        return $matchs;
	}


	/*
	 * 根据输入的赛事id返回当前信息
	 * @param  	integer  $id 	赛事id
	 * @return array
	 */
	public function get_match_detail($id , $ticket_type = 1)
	{
	    $return = array();
	    
	    if ($ticket_type == 1)
	    {
	        $obj = ORM::factory('match_detail');
            $results = $obj->where('index_id', $id)->find();	        
	    }
	    elseif ($ticket_type == 6) 
	    {
	        $obj = ORM::factory('match_detail');
            $results = $obj->where('index_id', $id)->find();	        
	    }

        
        if ($obj->loaded)
        {
            return $results->as_array();
        }
        else 
        {
            return  $return;
        }
	}	
	
	
	/*
	 * 根据输入的赛事id返回所有信息
	 */
	public function get_match_datas($ids ,$ticket_type =1)
	{
	    $matchs = array();
	    $obj = ORM::factory('match_detail');
        $results = $obj->in('index_id', $ids)
                    ->find_all();
                          
	    foreach ($results as $result) 
        {   
            $tmp = array();
            $matchs[$result->index_id] = $result->as_array();
            if ($result->match_url != null) {
            	$matchs[$result->index_id]['match_url'] = $result->match_url;
            }
            else {
            	$matchs[$result->index_id]['match_url'] = $this->get_match_detail_url($result->index_id, $ticket_type);
            }
        }
        
        return $matchs;
	}
	
	/*
	 * 根据输入的赛事id返回赛事详细的url链接地址
	 * @param  	integer  $match_id  赛事id
	 * return string 赛事链接地址
	 */	
	public function get_match_detail_url($match_id, $ticket_type) 
	{
	    if ($ticket_type == 1)
	    {
	        return self::$match_jczq_detail_url.$match_id;
	    }
	    elseif ($ticket_type == 6)
	    {
	        return self::$match_jclq_detail_url.$match_id;
	    }
	}
	
	/*
	 * 根据输入的赛事id,彩种和玩法,返回赛事所有信息
	 * @param  	integer  $id 	赛事id
	 * @return array
	 */
	public function get_match($id, $ticket_type, $play_type, $ds=false)
	{
	    $return = array();
	    $obj = ORM::factory('match_data');
	    
	    if ($ticket_type == 1)
	    {
	        $obj->select('match_details.*,match_datas.*');
	        $obj->join('match_details', 'match_details.index_id', 'match_datas.match_id', 'LEFT');
            $obj->where('match_datas.match_id', $id);
            $obj->where('match_datas.ticket_type', $ticket_type);
            $obj->where('match_datas.play_type', $play_type);	    
	    }
	    else 
	    {
	        $obj->select('match_details.*,match_datas.*');
	        $obj->join('match_details', 'match_details.index_id', 'match_datas.match_id', 'LEFT');
            $obj->where('match_datas.match_id', $id);
            $obj->where('match_datas.ticket_type', $ticket_type);
            $obj->where('match_datas.play_type', $play_type);
	    }

        $result = $obj->find();
	            
        if ($obj->loaded)
        {
            $matchtime_set = Kohana::config('site_config.match');
            $return = $result->as_array();
            $timeend_stamp = strtotime($return['time']);            //赛事开始时间
            $weekday = substr($return['match_info'], 0, 6);
            $return['groups_date'] = date("Y-m-d", strtotime(tool::get_date_byweek($weekday, 1, $return['time'])));
            $return['end_date'] = $this->count_end_time($return['groups_date']);
            $return['time_beg'] = date("Y-m-d H:i:s", $timeend_stamp + 60);
            $return['time_end'] = $this->get_end_time($return['time'], $return['end_date'], $matchtime_set['jczq_endtime']);
        	if ($ds == true) {
            	$return['time_end'] = $this->get_end_time($return['time'], $return['end_date'], $matchtime_set['jczq_endtime_ds']);
            }
            
            if ($return['time_end'] == 'delay') {
            	$nweekday = $this->delay_weekday($weekday);
            	$return['groups_date'] = date("Y-m-d", strtotime(tool::get_date_byweek($nweekday, 1, $return['time'])));
            	$return['end_date'] = $this->count_end_time($return['groups_date']);
            	$return['time_end'] = $this->get_end_time($return['time'], $return['end_date'], $matchtime_set['jczq_endtime']); //销售截止时间
            }
            
            $return['match_end'] = 0;    //赛事结束或开始
            if (strtotime($return['time_end']) < time()  || time() > strtotime($return['time_beg']))
            {
                $return['match_end'] = 1;
            }
            return $this->get_comb($return);
        }
        else
        {
            return  $return;
        }
	}	
	
	
	/*
	 * 转换comb数据为数组
	 */
	function get_comb($result)
	{
        $return  = array();
        if(empty($result))
            return $return;
        
        if ($result['ticket_type'] == 1)
        {
    	    if ($result['play_type'] == 1)
    	    {
                $result['comb'] = json_decode($result['comb']);
                $result['A'] = $result['comb']->a->v;
                $result['D'] = $result['comb']->d->v;
                $result['H'] = $result['comb']->h->v;
                unset($result['comb']);
    	    }
    	    elseif ($result['play_type'] == 2)
    	    {
    	        $result['comb'] = json_decode($result['comb']);
    	        $result['0'] = $result['comb'][0]->v;
    	        $result['1'] = $result['comb'][1]->v;
    	        $result['2'] = $result['comb'][2]->v;
    	        $result['3'] = $result['comb'][3]->v;
    	        $result['4'] = $result['comb'][4]->v;
    	        $result['5'] = $result['comb'][5]->v;
    	        $result['6'] = $result['comb'][6]->v;
    	        $result['7'] = $result['comb'][7]->v;
    	        unset($result['comb']);
    	    }
    	    elseif ($result['play_type'] == 3)
    	    {
    	        //$result['comb_detail'] = json_decode($result['comb']);
    	    }
    	    elseif ($result['play_type'] == 4)
    	    {
    	        //$result['comb_detail'] = json_decode($result['comb']);
    	    }
	    }
	    elseif ($result['ticket_type'] == 6) 
	    {
			if ($result['play_type'] == 1)  ///如果是胜负的话，如何拆分comb
			{
				$result['comb'] = json_decode($result['comb']);
				$result['A'] = $result['comb']->a->v;
				$result['H'] = $result['comb']->h->v;
				unset($result['comb']);
			}
	    	else if ($result['play_type'] == 2)  ///让分胜负，如何拆分comb
			{
				// TODO: 让分胜负，如何拆分comb
			}
	    	else if ($result['play_type'] == 3)  ///省分差，如何拆分comb
			{
				// TODO: 省分差，如何拆分comb
			}
	    	else if ($result['play_type'] == 4)  ///大小分，如何拆分comb
			{
				// TODO: 大小分，如何拆分comb
			}
	    }
	    
	    return $result;
	    
	}
	
	
	/*
	 * 更新赛事详细表
	 * 从match_bjdc_datas 更新结果数据到  match_details 表
	 */
	public function refresh_match()
	{
	    $obj_from = ORM::factory('match_bjdc_data');
	    $obj_to = ORM::factory('match_detail');
	    
	    $results = $obj_to->where('status', 0)->find_all();
	    
	    //检查数据是否更新
	    $update = array();
	    foreach ($results as $result)
	    {
	        $tmp = $result->as_array();
	        
	        $check = $obj_from->where('home', $tmp['host_name'])
	                         ->where('away', $tmp['guest_name'])
	                         ->where('code <> ', '')
	                         ->where('sp_r <> ', '')
	                         ->where('bf <> ', '')
	                         ->find();
	        if ($obj_from->loaded)
	        {
	            $update[$tmp['id']] = $check['bf'];
	        }
	    }
        
	    //更新数据
	    foreach ($update as $key => $value)
	    {
	        $obj_to->where('id', $key)->find();
	        
	        if ($obj_to->loaded)
	        {
	            $obj_to->result = $value;
	            $obj_to->status = 1;
	            $obj_to->save();
	        }
	    }
	}
	
	
	/*
	 * 获取赛事颜色
	 * @param  string  $match_name  赛事名称
	 * @return string 颜色
	 */
	public function  get_match_color($match_name)
	{
	    $colors = Kohana::config('match_color');
	    if (!empty($colors['matchs'][$match_name]))
	    {
	        return $colors['matchs'][$match_name];
	    }

	    return '#004d00';	    
	}
	
	/**
	 * 获取联赛缩写名称
	 * @param unknown_type $match_name
	 */
	public function get_league_abb($match_name) {
		$abb_name = Kohana::config('match_league_abb');
		if (isset($abb_name['matchs'][$match_name])) {
			return $abb_name['matchs'][$match_name];
		}
		else {
			return $match_name;
		}
	}
	
	/*
	 * 根据输入日期计算结束售票时间
	 * @param  date  $date  日期
	 * @return date 当前日期的结束售票时间
	 */
	public function count_end_time($date)
	{
	    //print $date.'<br>';
	    $weekdate = tool::get_weekday($date, 2);
	    $time_stamp = strtotime($date);
	    
	    if ($weekdate == 6 || $weekdate == 7)
        {
            $timeend = date("Y-m-d H:i:s", mktime (0, 40, 0, date("m", $time_stamp), date("d", $time_stamp)+1, date("Y", $time_stamp)));
        }
        else
        {
            $timeend = date("Y-m-d H:i:s", mktime (23, 40, 0, date("m", $time_stamp), date("d", $time_stamp), date("Y", $time_stamp)));
        }
	    return $timeend;
	}
	
	/*
	 * 根据输入的日期获得截止时间
	 * @param  date  $date  赛事截止日期
	 * @param  date  $datecheck  本期截止日期
	 * @param  integer  $sysendreduce  售票截止购买时间秒数
	 */
	public function get_end_time($date, $datecheck, $sysendreduce) {
	    $return = '';
	    $time_sec = strtotime($date) - strtotime($datecheck);
	    $time_hour = intval($time_sec / 3600);
	    //echo $sysendreduce.'+'.$time_sec.'<br />';
	    if ($time_sec > 0 && $time_sec >= $sysendreduce) {
	    	if ($time_hour < 18) {
	    		if ($time_hour >= 8 && (date('H', strtotime($date)) > 9 || (date('H', strtotime($date)) == 9 && date('i', strtotime($date)) >= 20))) {
	    		//if ((date('H', strtotime($date)) > 9 || (date('H', strtotime($date)) == 9 && date('i', strtotime($date)) >= 20))) {
	    			$return = date("Y-m-d H:i:s", strtotime($date) - $sysendreduce);
	    			//var_dump($return);
	    		}
	    		else {
	        		$return = $datecheck;
	    		}
	    	}
	    	else {
	    		$return = 'delay';
	    	}
	    }
	    else {
			$return = date("Y-m-d H:i:s", strtotime($date) - $sysendreduce);
	    }
	    return $return;
	}
	
	/**
	 * 根据001，日期取得比赛信息
	 * Enter description here ...
	 * @param unknown_type $match_info
	 * @param unknown_type $time
	 */
	public function get_match_detail_by_infotime($match_info, $time) {
		$stime = strtotime($time);
		$mk_next_time = mktime(11, 0, 0, date("m", $stime), date("d", $stime)+1, date("Y", $stime));
		$next_time = date('Y-m-d H:i:s', $mk_next_time);
		$obj = ORM::factory('match_detail');
		$obj->like('match_info', $match_info);
		$obj->where('time >= ', $time);
		$obj->where('time < ', $next_time);
		$obj->orderby('id', 'DESC');
		$results = $obj->find();
		$return = array();
		$return = $results->as_array();
        return $return;
	}
	
	/**
	 * 获取已取消比赛的信息
	 * Enter description here ...
	 */
	public function get_cancel_matchs($ticket_type = 1) {
		$obj = ORM::factory('match_detail');
		$obj->where('result', 'cancel');
		$obj->where('ticket_type', $ticket_type);
		$obj->orderby('id', 'DESC');
		$results = $obj->find_all();
		$return = array();
        foreach ($results as $result) {
        	$tmp = array();
            $tmp = $result->as_array();
			$return[] = $tmp;
        }
        return $return;
	}
	
	/**
	 * 推迟一天
	 * @param unknown_type $weekday
	 */
	public function delay_weekday($weekday) {
		switch ($weekday) {
			case '周一': {
				$nweekday = '周二';
				break;
			}
			case '周二': {
				$nweekday = '周三';
				break;
			}
			case '周三': {
				$nweekday = '周四';
				break;
			}
			case '周四': {
				$nweekday = '周五';
				break;
			}
			case '周五': {
				$nweekday = '周六';
				break;
			}
			case '周六': {
				$nweekday = '周日';
				break;
			}
			case '周日': {
				$nweekday = '周一';
				break;
			}
			default: $nweekday = false; break;
		}
		return $nweekday;
	}

}