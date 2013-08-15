<?php defined('SYSPATH') or die('No direct script access.');

class Mynews_Core extends My
{
    protected $object_name = 'news';

	private static $instances;
	public static function & instance($id = 0)
	{
		if (!isset(self::$instances[$id]))
		{
			$class = __CLASS__;
			self::$instances[$id] = new $class($id);
		}

		return self::$instances[$id];
	}
	
	public function site_news($site_id,$limit,$offset)
	{
		$news = ORM::factory('news')
			->where('site_id',$site_id)	
			->find_all($limit,$offset);
		$data = array();
		foreach($news as $item)
		{
			$data[] = $item->as_array();
		}
		return $data;
	}


	public function count_site_news($cid)
	{
		return ORM::factory('news')->where('classid',$cid)->count_all();
	}
	
	

    public function set_order($id ,$order)
    {
        $where = array('id'=>$id);
        $obj = ORM::factory('news')->where($where)->find();
        if($obj->loaded)
        {
            $obj->order = $order;
            return $obj->save();
        }
        return false;
    }
	
	public function list_news_num($query_assoc)
    {
        $list = $this->lists($query_assoc);
		return $list;
		
    }
    public function news_update($id)
	{
	    $obj = ORM::factory($this->object_name);
		$obj->where('id', $id)
			->find();
	    if ($obj->loaded)
	    {
	        $obj->click = $obj->click + 1;
	        return $obj->save();
	    }
		else
		{
		    return FALSE;
		}
		
	}
	
	
	public function list_news_xg($key,$id)
    {	
		$likekey=array();
		foreach($key as $v){
			$likekey['title']=$v;
			$likekey['content']=$v;
		}
		
		$obj = ORM::factory($this->object_name);	
		$obj->where('id !=', $id);
		$obj->orlike($likekey)
			->find();
        $list = $obj->lists();
		print_r($list);die;
		return $list;
		
    }
    
    public function get_news_data($classify, $limit=5) {
    	$db_obj = Database::instance();
    	if (is_array($classify) == true) {
    		$query_classify = 'classid in ('.implode(',', $classify).')';
    	}
    	else {
    		$query_classify = 'classid="'.$classify.'"';
    	}
    	$query = 'select * from news where '.$query_classify.' and zxtj=1 order by id DESC limit '.$limit;
    	$results = $db_obj->query($query);
    	$data = array();
    	foreach ($results as $result) {
    		$data[] = array('id'=>$result->id, 'title'=>$result->title, 'title_en'=>$result->title_en, 'time'=>$result->created, 'pic'=>$result->newpic);
    	}
    	return $data;
    }

}