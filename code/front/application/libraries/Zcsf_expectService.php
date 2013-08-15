<?php defined('SYSPATH') OR die('No direct access allowed.');

class Zcsf_expectService_Core extends DefaultService_Core 
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
        if (empty($data))
            return FALSE;
            
        $obj = ORM::factory($this->object_name);
        
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
     * 获取数据
     * 
     */
    public  function  get_by_id($expect,$changci)
    {
        $expect = intval($expect);
        $changci = intval($changci); 
	       
        if (empty($expect) || empty($changci))
            return  FALSE;

        $obj = ORM::factory($this->object_name);

        $obj->where('expect_num', $expect)->where('changci', $changci);
        
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
     * 获取数据
     * 
     */
    public  function  get_expect_info($play_method=1,$expect="")
    {
        $expect = intval($expect);

		switch($play_method) {
			case 1:  //14场胜负彩
				$expect_type=14;
				$lotid_key = "wilo";
				break;
			case 2:	//9场任选
				$expect_type=9;
				$lotid_key = "wilo";
				break;
			case 3://6场半
				$expect_type=6;
				$lotid_key = "hafu";
				break;
			case 4://4场半
				$expect_type=4;
				$lotid_key = "goal";
				break;
			default:
				$expect_type=14;
				$lotid_key = "wilo";
				break;
		}
        $obj = ORM::factory($this->object_name);
        if (empty($expect)){
			$obj->where('status', 1)->where('expect_type', $lotid_key)->where('expect_num > ', 0)->where('changci > ', 0);		
		}else{
			$obj->where('expect_num', $expect)->where('expect_type', $lotid_key);
		}
      
        $result = $obj->find();
        
        if ($obj->loaded)
        {
			$result_data=$result->as_array();
			//d($result_data);
			//if (empty($expect)){
			$e = array();
			$db = Database::instance();
			$query='select distinct(expect_num) from zcsf_expects where expect_type="'.$lotid_key.'" and expect_num>"'.$result_data['expect_num'].'"';
			$results = $db->query($query);
			foreach ($results as $r) {
				$e[]=$r->expect_num;
			}
			//d($e);
			array_unshift($e, $result_data['expect_num']);
			//d($e);
			//$result_data['expects']=array($result_data['expect_num'],$result_data['expect_num']+1,$result_data['expect_num']+2);
			$result_data['expects'] = $e;
			$result_data['expect_type']=$expect_type;
			$result_data['lotid_key']=$lotid_key;
			if(time()>strtotime(date("Y-m-d",time())." 09:00:00") and time()<strtotime(date("Y-m-d",time())." 22:40:00")){
				$result_data['buy_status']=1;
			}else{
				$result_data['buy_status']=0;
			}
			//}
			return $result_data;			
        }
        else 
        {
            return FALSE;
        }
        
    }

	public function add_update($data)
	{
	    $obj = ORM::factory($this->object_name);
	    if (!$obj->validate($data))//数据验证，如果去掉就不会验证了
	        return FALSE;
	   
		$obj->where('expect_num', $data['expect_num'])
		    ->where('changci', $data['changci'])
			->find();
        
		if($obj->loaded)
		{
		    $obj->changci = $data['changci'];
		    $obj->vs1 = $data['vs1'];
		    $obj->vs2 = $data['vs2'];
            $obj->game_time = $data['game_time'];
            $obj->game_event = $data['game_event'];
            $obj->expect_num = $data['expect_num'];
            $obj->start_time = $data['start_time'];			
            $obj->end_time = $data['end_time'];			
            $obj->open_time = $data['open_time'];
            $obj->expect_type = $data['expect_type'];	
            $obj->index_id = $data['index_id'];	
            $obj->game_result = $data['game_result'];	
            $obj->cai_result = $data['cai_result'];	
		}
		else
		{
		    $obj->changci = $data['changci'];
		    $obj->vs1 = $data['vs1'];
		    $obj->vs2 = $data['vs2'];
            $obj->game_time = $data['game_time'];
            $obj->game_event = $data['game_event'];
            $obj->expect_num = $data['expect_num'];
            $obj->start_time = $data['start_time'];			
            $obj->end_time = $data['end_time'];			
            $obj->open_time = $data['open_time'];
            $obj->expect_type = $data['expect_type'];	
            $obj->index_id = $data['index_id'];		
            $obj->game_result = $data['game_result'];	
            $obj->cai_result = $data['cai_result'];									
		}
		return $obj->save();
	}  
	
	public function get_current_expect($lotid_key) {
		$db = Database::instance();
		$query='select distinct(expect_num) from zcsf_expects where expect_type="'.$lotid_key.'" and status=1 and expect_num > 0 limit 1';
		$results = $db->query($query);
		$e = array();
		foreach ($results as $r) {
			$e[]=$r->expect_num;
		}
		return $e[0];
	}
}
