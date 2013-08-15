<?php defined('SYSPATH') OR die("No direct access allowed.");
  
class Mypromotion_Core extends My
{
	protected $object_name = "promotion";
	protected static $instances;
    
    //protected $orm_instance = NULL;
	//protected $data = array();
	
	public static function & instance($id=0)
	{
		if(!isset(self::$instances[$id]))
		{
			$class=__CLASS__;
			self::$instances[$id]=new $class($id);
		}
		return self::$instances[$id];
	}
    
	/**
     * 根据活动ID，删除活动内容 
     */
    public function delete_by_pmtaid($pmta_id) {
    	if ( ORM::factory($this->object_name)
    	    		->where('pmta_id', $pmta_id)
    	    		->delete_all() ) {
    	   	return true;
    	}
    	return false;
    }






    /**
     * Enclose IDs with enclosers (comma by default)
     * @param array $ids
     * @param char $encloser
     */
    public static function enclose_ids($ids, $encloser = ',') {
    	$enclosed_ids = '';
    	foreach ( $ids as $id ) {
        	$enclosed_ids .= $encloser . $id;
    	}
        $enclosed_ids .= $encloser;
        return $enclosed_ids;
    }


    public function list_by_pmtaid($pmta_id) {
        $request_struct = array(
            'where'		=> array( 
                'pmta_id'	=>$pmta_id,
            ),
            'orderby'   => array(
                'id'    => 'DESC',
            ),
        );
        return $this->lists($request_struct);
    }


}
