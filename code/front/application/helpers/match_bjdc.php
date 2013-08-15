<?php defined('SYSPATH') or die('No direct script access.');

class match_bjdc_Core {
    private static $instance = NULL;
    //private static $match_detail_url = 'http://info.sporttery.cn/football/info/fb_match_info.php?m=';
    
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
	
    public function getIssuesByBetid($betid) {
    	$obj = ORM::factory('match_bjdc_issue');
    	$obj->select('*');
        $obj->where('betid', $betid);
        $obj->orderby('number', 'DESC');
        $results = $obj->find_all();
        $issue_info = array();
        foreach ($results as $result) {
        	$issue_info[] = $result->as_array();
        }
        return $issue_info;
    }

	public function getMatchsByIssue($betid, $issue, $nodata = NULL) {   
	    $matchs = array();
	    $obj = ORM::factory('match_bjdc_data');
	    $obj->select('*');
        $obj->where('betid', $betid);
	    $obj->where('issue', $issue);
	    if ($nodata == NULL) {
	    	//$obj->where('stoptime >= ', tool::get_date());
	    }
        $obj->orderby('match_no', 'ASC');
        $results = $obj->find_all();
        foreach ($results as $result) {   
            $matchs[] = $result->as_array();;
        }
        return $matchs;
	}
	
	public function getMatchInfoByBetidIssueNo($betid, $issue, $match_no) {
		$matchs = array();
	    $obj = ORM::factory('match_bjdc_data');
	    $obj->select('*');
        $obj->where('betid', $betid);
	    $obj->where('issue', $issue);
	    $obj->where('match_no', $match_no);
        $matchs = $obj->find()->as_array();
        return $matchs;
	}
}
?>