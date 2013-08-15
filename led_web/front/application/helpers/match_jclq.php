<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 竞彩篮球
 * @author jiaxianglu
 */
class match_jclq_Core {
	
    private static $instance = NULL;
	private static $match_detail_url = 'http://info.sporttery.cn/basketball/info/bk_match_info.php?m=';
	
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
	/*
	 * 获取正在进行中的赛事完整数据
	 * 此处将预留接口获取更为合法的数据
	 * @param  	integer  $play_type  玩法id
	 * 
	 * @return array
	 * 
	 */
	public function get_results($play_type, $curtime = NULL) 
	{   
	    $matchs = array();
	    $timebeg = date("Y-m-d H:i:s", time() - 100*60);	   
	     
	    $obj = ORM::factory('match_data');
	    $obj->select('match_bk_details.*,match_datas.*');
	    $obj->join('match_bk_details', 'match_bk_details.index_id', 'match_datas.match_id', 'LEFT');
        $obj->where('match_datas.play_type', $play_type);
        
        if (!empty($curtime))
        {
            $obj->like('match_bk_details.time', $curtime);
        }
        else 
        {
            $obj->where('match_bk_details.time > ', tool::get_date());
        }
        
        $obj->orderby('match_bk_details.time', 'ASC');
        $results = $obj->find_all();

        foreach ($results as $result) 
        {   
            $tmp = array();
            $tmp = $result->as_array();
            
            if (empty($tmp['index_id']))
                continue;

            $tmp['match_url'] = $this->get_match_detail_url($tmp['match_id']);
            $matchs[] = $tmp;
        }

        return $matchs;
	}


	/*
	 * 根据输入的赛事id返回当前信息
	 * @param  	integer  $id 	赛事id
	 * @return array
	 */
	public function get_match_detail($id)
	{
	    $return = array();
	    
	    $obj = ORM::factory('match_bk_detail');
        $results = $obj->where('index_id', $id)->find();
        
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
	public function get_match_datas($ids)
	{
	    $matchs = array();
	    $obj = ORM::factory('match_bk_detail');
        $results = $obj->in('index_id', $ids)
                    ->find_all();
                          
	    foreach ($results as $result) 
        {   
            $tmp = array();
            $matchs[$result->index_id] = $result->as_array();
            $matchs[$result->index_id]['match_url'] = $this->get_match_detail_url($result->index_id);
        }
        
        return $matchs;
	}
	
	/*
	 * 根据输入的赛事id返回赛事详细的url链接地址
	 * @param  	integer  $match_id  赛事id
	 * return string 赛事链接地址
	 */	
	public function get_match_detail_url($match_id) 
	{
	    return self::$match_detail_url.$match_id;
	}
	
	
	/*
	 * 根据输入的赛事id返回赛事所有信息
	 * @param  	integer  $id 	赛事id
	 * @return array
	 */
	public function get_match($id)
	{
	    $return = array();
	    $obj = ORM::factory('match_data');
	    $obj->select('match_bk_details.*,match_datas.*');
	    $obj->join('match_bk_details', 'match_bk_details.index_id', 'match_datas.match_id', 'LEFT');
        $obj->where('match_datas.match_id', $id);
        $result = $obj->find();
	    
        if ($obj->loaded)
        {
            $return = $result->as_array();
            $return['comb'] = json_decode($return['comb']);
            
            $return['A'] = $return['comb']->a->v;
            $return['D'] = $return['comb']->d->v;
            $return['H'] = $return['comb']->h->v;
            
            unset($return['comb']);
            
            return $return;
        }
        else 
        {
            return  $return;
        }
	}	
	
    
}
?>