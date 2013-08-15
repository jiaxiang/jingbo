<?php defined('SYSPATH') or die('No direct script access.');

class jsbf_Core {
    private static $instance = NULL;
   	static public $status_name = array(
    	'0' => '未开',
    	'1' => '上半场',
    	'2' => '中场',
    	'3' => '下半场',
   		'4' => '加时赛',
   		'-10' => '取消',
    	'-11' => '待定',
    	'-12' => '腰斩',
    	'-13' => '中断',
    	'-14' => '推迟',
    	'-1' => '完场'
    );
    static public $status_color = array(
    	'0' => '#808080',
    	'1' => '#FF0000',
    	'2' => '#0000FF',
    	'3' => '#FF0000',
    	'4' => '#FF0000',
    	'-10' => '#808080',
    	'-11' => '#808080',
    	'-12' => '#808080',
    	'-13' => '#808080',
    	'-14' => '#808080',
    	'-1' => '#000000'
    );
    //事件类型 1、入球 2、红牌 3、黄牌 7、点球 8、乌龙 9、两黄变红
    static public $event_info = array(
    	'1' => '攻入一球',
    	'2' => '领到一张红牌被罚出场',
    	'3' => '被黄牌警告',
    	'7' => '获得一个点球',
    	'8' => '打入一记乌龙球',
    	'9' => '领到本场比赛的第二张黄牌被罚出场',
    );
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    public static function getMatchStatusName($status) {
    	if (isset(self::$status_name[$status])) {
    		return self::$status_name[$status];
    	}
    	else {
    		return '完场';
    	}
    }
    
	public static function getMatchStatusColor($status) {
    	if (isset(self::$status_color[$status])) {
    		return self::$status_color[$status];
    	}
    	else {
    		return '#000000';
    	}
    }	
	
    /**
     * 获取及时比分数据
     * Enter description here ...
     * @param unknown_type $date
     * @param unknown_type $type
     * @param unknown_type $status
     */
	public function getJSBFByDate($date, $type, $status) {
		$week_arr = array('Mon'=>'周一', 'Tue'=>'周二', 'Wed'=>'周三', 'Thu'=>'周四', 'Fri'=>'周五', 'Sat'=>'周六', 'Sun'=>'周日');
    	$obj = ORM::factory('jsbf_data');
    	$obj->select('*');
    	$date = date('Y-m-d');
    	$obj->where('match_date >= ', $date);
       	$obj->where('match_status != ', -1);
        switch ($type) {
        	case 'zc': 
        		$obj->where('is_zc', 1); 
        		$obj->orderby('match_open_time', 'ASC');
        		break;
        	case 'jc': 
        		$obj->where('is_jc', 1); 
        		$obj->orderby('jc_id', 'ASC');
        		break;
        	case 'bd': 
        		$obj->where('is_bd', 1); 
        		$obj->orderby('match_open_time', 'ASC');
        		break;
        	default: 
        		$obj->orderby('match_open_time', 'ASC');
        		break;
        }
        //$obj->orderby('match_open_time', 'ASC');
        $results = $obj->find_all();
		$jsbf_info_start = array();
        foreach ($results as $result) {
        	$t = $result->as_array();
        	$getweek = date("D", strtotime($t['match_open_time']));
        	$t['week'] = $t['week'] = $week_arr[$getweek];
        	if ($t['match_status'] == 1 || $t['match_status'] == 2 || $t['match_status'] == 3) {
        		$t['match_ing_gif'] = '<img src="/media/images/bf_ing.gif" />';
        	}
        	else {
        		$t['match_ing_gif'] = '';
        	}
        	if ($t['match_status'] == 0 || $t['match_status'] == -10 || $t['match_status'] == -11 || $t['match_status'] == -14) {
        		$t['home_score'] = '-';
        		$t['away_score'] = '-';
        		$t['home_first_half_score'] = '-';
        		$t['away_first_half_score'] = '-';
        		$t['home_red_card'] = '-';
        		$t['away_red_card'] = '-';
        		$t['home_yellow_card'] = '-';
        		$t['away_yellow_card'] = '-';
        	}
        	/**
        	 * 更新竞彩赔率
        	 */
        	if($type == 'jc'){
        		if(!empty($t['sp'])){
	        	$sp=json_decode($t['sp']);
					$t['sp_h']=$sp->h->v;
					$t['sp_d']=$sp->d->v;
					$t['sp_a']=$sp->a->v;
					
	        		if($t['match_status'] == 1 || $t['match_status'] == 2 || $t['match_status'] == 3 || $t['match_status'] == 4 || $t['match_status'] == -1){
						if(($t['home_score'] + $t['goalline']) > $t['away_score']) {
							$t['sp_h'] = "<b><font color='#FF0000'>".$t['sp_h']."</font></b>";
						}
						if(($t['home_score'] + $t['goalline']) == $t['away_score']){
							$t['sp_d'] = "<b><font color='#FF0000'>".$t['sp_d']."</font></b>";
						}
						if(($t['home_score'] + $t['goalline']) < $t['away_score']){
							$t['sp_a'] = "<b><font color='#FF0000'>".$t['sp_a']."</font></b>";
						}
					}
        		}
        		else{
        			$t['sp_h']=null;
					$t['sp_d']=null;
					$t['sp_a']=null;
        		}
        	}
        	$jsbf_info_start[] = $t;
        }
        
        $obj->select('*');
        $mklasttime = mktime(date("H")-8, date("i"), date("s"), date("m"), date("d"), date("Y"));
        $lasttime = date('Y-m-d H:i:s', $mklasttime);
    	$obj->where('match_open_time >= ', $lasttime);
       	$obj->where('match_status = ', -1);
        switch ($type) {
        	case 'zc': $obj->where('is_zc', 1); break;
        	case 'jc': $obj->where('is_jc', 1); break;
        	case 'bd': $obj->where('is_bd', 1); break;
        	default: break;
        }
        $obj->orderby('match_open_time', 'ASC');
        $results = $obj->find_all();
		$jsbf_info_over = array();
		
		foreach ($results as $result) {
        	$t = $result->as_array();
        	$getweek = date("D", strtotime($t['match_open_time']));
        	$t['week'] = $week_arr[$getweek];
			if ($t['match_status'] == 1 || $t['match_status'] == 2 || $t['match_status'] == 3) {
        		$t['match_ing_gif'] = '<img src="/media/images/bf_ing.gif" />';
        	}
        	else {
        		$t['match_ing_gif'] = '';
        	}
        	if ($t['match_status'] == 0 || $t['match_status'] == -10 || $t['match_status'] == -11 || $t['match_status'] == -14) {
        		$t['home_score'] = '-';
        		$t['away_score'] = '-';
        		$t['home_first_half_score'] = '-';
        		$t['away_first_half_score'] = '-';
        		$t['home_red_card'] = '-';
        		$t['away_red_card'] = '-';
        		$t['home_yellow_card'] = '-';
        		$t['away_yellow_card'] = '-';
        	}
        	/**
        	 * 更新竞彩赔率
        	 */
			if($type == 'jc'){
        		if(!empty($t['sp'])){
	        	$sp=json_decode($t['sp']);
					$t['sp_h']=$sp->h->v;
					$t['sp_d']=$sp->d->v;
					$t['sp_a']=$sp->a->v;
        			if(($t['home_score'] + $t['goalline']) > $t['away_score']) {
						$t['sp_h'] = "<b><font color='#FF0000'>".$t['sp_h']."</font></b>";
					}
					if(($t['home_score'] + $t['goalline']) == $t['away_score']){
						$t['sp_d'] = "<b><font color='#FF0000'>".$t['sp_d']."</font></b>";
					}
					if(($t['home_score'] + $t['goalline']) < $t['away_score']){
						$t['sp_a'] = "<b><font color='#FF0000'>".$t['sp_a']."</font></b>";
					}
        		}
        	}
        	$jsbf_info_over[] = $t;
        }
		$return = array_merge($jsbf_info_over, $jsbf_info_start);
        return $return;
    }
    
    /**
     * 获取赛果
     * Enter description here ...
     * @param unknown_type $date
     * @param unknown_type $type
     * @param unknown_type $status
     */
    public function getBFByDate($date, $type, $status) {
    	$obj = ORM::factory('jsbf_data');
    	$obj->select('*');
    	if ($date == NULL) {
    		$date = date('Y-m-d');
    		$obj->where('match_date >= ', $date);
    	}
    	else {
    		//已经结束
    		if ($status == -1) {
    			$obj->where('match_date >= ', $date);
    		}
    		else {
    			$obj->where('match_date', $date);
    		}
    	}
        if ($status != NULL) {
        	$obj->where('match_status', $status);
        }
        else {
        	$obj->where('match_status != ', -1);
        }
        switch ($type) {
        	case 'zc': $obj->where('is_zc', 1); break;
        	case 'jc': $obj->where('is_jc', 1); break;
        	case 'bd': $obj->where('is_bd', 1); break;
        	default: break;
        }
        
        $obj->orderby('match_open_time', 'ASC');
        $results = $obj->find_all();

        $jsbf_info = array();
        foreach ($results as $result) {
        	$t = $result->as_array();
        	if ($t['match_status'] == 0 || $t['match_status'] == -10 || $t['match_status'] == -11 || $t['match_status'] == -14) {
        		$t['home_score'] = '-';
        		$t['away_score'] = '-';
        		$t['home_first_half_score'] = '-';
        		$t['away_first_half_score'] = '-';
        		$t['home_red_card'] = '-';
        		$t['away_red_card'] = '-';
        		$t['home_yellow_card'] = '-';
        		$t['away_yellow_card'] = '-';
        	}
        	$jsbf_info[] = $t;
        }
        return $jsbf_info;
    }
	
    public function getJSBFByAjax($date, $type, $status) {
    	$obj = ORM::factory('jsbf_data');
    	$obj->select('id,home_name_chs,away_name_chs,match_open_time,match_status,home_score,away_score,home_first_half_score,away_first_half_score,home_red_card
    	,away_red_card,home_yellow_card,away_yellow_card,sp,goalline');
   		if ($date == NULL) {
    		//$date = date('Y-m-d');
    		$mklasttime = mktime(date("H")-1, date("i"), date("s"), date("m"), date("d"), date("Y"));
    		$mkfirsttime = mktime(date("H")+1, date("i"), date("s"), date("m"), date("d"), date("Y"));
        	$lasttime = date('Y-m-d H:i:s', $mklasttime);
        	$firsttime = date('Y-m-d H:i:s', $mkfirsttime);
    		$obj->where('match_open_time >= ', $lasttime);
    		$obj->where('match_open_time <= ', $firsttime);
    	}
    	else {
    		$obj->where('match_date', $date);
    	}
    	/*$obj->where('match_status != ', 0);
    	$obj->where('match_status != ', -10);
    	$obj->where('match_status != ', -11);
    	$obj->where('match_status != ', -12);
    	$obj->where('match_status != ', -13);
    	$obj->where('match_status != ', -14);
    	$obj->where('match_status != ', -1);*/
    	$obj->where('match_status != ', 0);
        switch ($type) {
        	case 'zc': $obj->where('is_zc', 1); break;
        	case 'jc': $obj->where('is_jc', 1); break;
        	case 'bd': $obj->where('is_bd', 1); break;
        	default: break;
        }
        $obj->orderby('match_time', 'ASC');
        $results = $obj->find_all();
        //var_dump($obj->last_query());
        $jsbf_info = array();
        foreach ($results as $result) {
        	$t = $result->as_array();
        	$rand_num = rand(1000, 9999);
        	$t['rand_num'] = $t['id'].$rand_num;
        	$t['match_status_color'] = self::$status_color[$t['match_status']];
        	if ($t['match_status'] == 1 || $t['match_status'] == 2 || $t['match_status'] == 3) {
        		$t['match_ing_gif'] = '<img src="/media/images/bf_ing.gif" />';
        	}
        	else {
        		$t['match_ing_gif'] = '';
        	}
        	if ($t['match_status'] == 0 || $t['match_status'] == -10 || $t['match_status'] == -11 || $t['match_status'] == -14) {
        		$t['home_score'] = '-';
        		$t['away_score'] = '-';
        		$t['home_first_half_score'] = '-';
        		$t['away_first_half_score'] = '-';
        		$t['home_red_card'] = '-';
        		$t['away_red_card'] = '-';
        		$t['home_yellow_card'] = '-';
        		$t['away_yellow_card'] = '-';
        	}
        	/**
        	 * 更新赔率
        	 */
			if(!empty($t['sp'])){
				$sp=json_decode($t['sp']);
				$t['sp_h']=$sp->h->v;
				$t['sp_d']=$sp->d->v;
				$t['sp_a']=$sp->a->v;
	        	if($t['match_status'] == 1 || $t['match_status'] == 2 || $t['match_status'] == 3 || $t['match_status'] == 4 || $t['match_status'] == -1){
	        		if(($t['home_score'] + $t['goalline']) > $t['away_score']) {
						$t['sp_h'] = "<b><font color='#FF0000'>".$t['sp_h']."</font></b>";
					}
					if(($t['home_score'] + $t['goalline']) == $t['away_score']){
						$t['sp_d'] = "<b><font color='#FF0000'>".$t['sp_d']."</font></b>";
					}
					if(($t['home_score'] + $t['goalline']) < $t['away_score']){
						$t['sp_a'] = "<b><font color='#FF0000'>".$t['sp_a']."</font></b>";
					}
				}
        	}
			$t['sp']=null;
        	$jsbf_info[] = $t;
        }
        return $jsbf_info;
    }
    
    public function getMatchEvent($match_id) {
    	$obj = ORM::factory('jsbf_event_data');
    	$obj->select('home_or_away,match_event_type,match_event_time,player_name');
    	$obj->where('match_id', $match_id);
    	$obj->orderby('id', 'ASC');
        $results = $obj->find_all();
        //var_dump($obj->last_query());
        $return = array();
        foreach ($results as $result) {
        	$t = $result->as_array();
        	$return[] = $t;
        }
        return $return;
    }
    
    public function getMatchInfoById($match_id) {
    	$obj = ORM::factory('jsbf_data');
    	$obj->select('*');
    	$obj->where('match_id', $match_id);
    	$matchs = array();
    	$matchs = $obj->find()->as_array();
        return $matchs;
    }
    
    /**
     * 比赛时间状态显示
     * Enter description here ...
     * @param unknown_type $start_time
     * @param unknown_type $status
     */
    static public function getTimeStatus($start_time, $status) {
    	$return = '';
    	$ing_time = intval((time()-strtotime($start_time))/60);
    	switch ($status) {
    		//上半场
    		case '1': 
    			if ($ing_time > 45) $return = '45+\'';
    			else $return = $ing_time.'\'';
    			break;
    		//下半场
    		case '3':
    			if ($ing_time+45 > 90) $return = '90+\'';
    			else $return = ($ing_time+45).'\'';
    			break;
    		default: break;
    	}
    	return $return;
    }
	
}
?>