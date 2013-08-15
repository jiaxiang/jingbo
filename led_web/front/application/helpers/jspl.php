<?php defined('SYSPATH') or die('No direct script access.');

class jspl_Core {
	
	private static $instance = NULL;
	static public $company_name = array(
			1 => '澳门',
			2 => '波音',
			3 => 'ＳＢ/皇冠',
			4 => '立博',
			5 => '云鼎',
			7 => 'SNAI',
			8 => 'Bet365',
			9 => '威廉希尔',
			12 => '易胜博',
			14 => '韦德',
			17 => '明陞',
			18 => 'Eurobet',
			19 => 'Interwetten',
			22 => '10BET',
			23 => '金宝博',
			24 => '12bet/沙巴',
			29 => '乐天堂',
			31 => '利记',
			33 => '永利高',
			35 => '盈禾',
	);
	static public $goal_name = array(
		'平手','平手/半球','半球','半球/一球','一球','一球/球半','球半','球半/两球','两球','两球/两球半','两球半','两球半/三球','三球','三球/三球半','三球半','三球半/四球','四球','四球/四球半','四球半','四球半/五球','五球','五球/五球半','五球半','五球半/六球','六球','六球/六球半','六球半','六球半/七球','七球','七球/七球半','七球半','七球半/八球','八球','八球/八球半','八球半','八球半/九球','九球','九球/九球半','九球半','九球半/十球','十球'
	);
		
	// 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
	public static function getCompanyName($id) {
    	if (isset(self::$company_name[$id])) {
    		return self::$company_name[$id];
    	}
    	else {
    		return '未知';
    	}
    }
    
    public static function getGoalName($goal) {
    	$goal_name = '';
    	if ($goal >= 0) {
    		$goal_name = self::$goal_name[$goal * 4];
    	}
    	else {
    		$goal_name = '受'.self::$goal_name[$goal * -1 * 4];
    	}
    	return $goal_name;
    }
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $pl 1亚盘2欧赔3大小球
     * @param unknown_type $match_id
     * @param unknown_type $ajax
     */
    public function getPLData($pl, $match_id, $ajax=0) {
    	switch ($pl) {
    		case 1: $table = 'odd_yp';break;
    		case 2: $table = 'odd_op';break;
    		case 3: $table = 'odd_dx';break;
    		default: $table = 'odd_yp';break;
    	}
    	$obj = ORM::factory($table);
    	$obj->select('*');
    	$obj->where('match_id', $match_id);
    	$obj->orderby('company_id', 'ASC');
    	$results = $obj->find_all();
    	$return = array();
    	foreach ($results as $result) {
        	$t = $result->as_array();
        	$return[] = $t;
    	}
    	if ($ajax == 1) {
    		$return = json_encode($return);
    	}
    	return $return;
    }
    
	
}
?>