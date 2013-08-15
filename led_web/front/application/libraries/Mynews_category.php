<?php 
defined('SYSPATH') or die('No direct script access.');

class Mynews_category_Core extends My{
	//�������(����)
    protected $object_name = 'news_category';
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

    /**
     * �������
     *
     * @param <Int> $id ID
     * @return Array
     */
    public function news_categories($id = 0)
    {
        $result = array();

        $list = ORM::factory('news_category');
		$list->where('parent_id',$id);
        $list->orderby(array('p_order'=>'ASC'));
        $list = $list->find_all();
        
        foreach($list as $item)
        {
            $result[] = $item->as_array();
            $temp = $this->news_categories($item->id);
            if(is_array($temp) && count($temp))
            {
                $result = array_merge($result,$temp);
            }			
        }
        return $result;
    }
    
    public function get_categories($id) {
    	$obj = ORM::factory('news_category');
    	$result = $obj->where('id', $id)->find();
    	
    	if ($obj->loaded)
    	{
    		return $result->as_array();
    	}
    	else
    	{
    		return FALSE;
    	}
    }
    
    //public $result = array();
    public function list_news_categories($query_assoc)
    {
    	$result = array();
    	//$query_assoc['where']['parent_id'] = 25;
        $list = $this->lists($query_assoc);
        //d($list);
        //d($this->result, false);
        foreach($list as $item)
        {
        	//d($item);
            //$this->result[] = $item;
            $result[] = $item;
            //$query_assoc['where']['parent_id'] = $item['id'];
            $query_assoc = array(
            		'where'=>array(
            				'parent_id' => $item['id'],
            		),
            );
            $temp = $this->list_news_categories($query_assoc);
            //d($this->result);
            if(is_array($temp) && count($temp))
            {
                //$this->result = array_merge($this->result,$temp);
                $result = array_merge($result,$temp);
            }           
        }
        //d($this->result);
		//return $this->result;
        return $result;
    }
   
    public function list_category_num($query_assoc){
    	$list = $this->lists($query_assoc);
    	return $list;
    }
}
