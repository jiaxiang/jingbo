<?php 
defined('SYSPATH') or die('No direct script access.');

class Mynews_category_Core extends My{
	//对象名称(表名)
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
     * 遍历操作
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
    
    public function list_news_categories($query_assoc)
    {
        
		$result = array();
        $list = $this->lists($query_assoc);
        foreach($list as $item)
        {
            $result[] = $item;
            $query_assoc['where']['parent_id'] = $item['id'];
            $temp = $this->list_news_categories($query_assoc);
            if(is_array($temp) && count($temp))
            {
                $result = array_merge($result,$temp);
            }           
        }
		return $result;
		
    }
   
    
   
    
  
    



}
