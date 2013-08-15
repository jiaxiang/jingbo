<?php defined('SYSPATH') OR die("No direct access allowed.");
  
class Mypromotion_activity_Core extends My
{
	protected $object_name = "promotion_activity";
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
     * Overload lists() method
     *
     * @param array $request_struct
     * @return array
     */
    /*
    public function lists($request_struct) {
        $orm_list = parent::lists($request_struct);

        foreach ( $orm_list as $key => $value )
        {
            $list[$key] = $value;
            $list[$key]['site_name'] = Mysite::instance($value['site_id'])->get('name');
            $promotion_list    = Mypromotion::instance()->list_by_pmtaid($value['id']);
            
            $list[$key]['promotions'] = array();
            foreach ( $promotions as $keyp => $_promotion ) {
                $list[$key]['promotions'][$keyp]['id']          = $_promotion['id'];
                $list[$key]['promotions'][$keyp]['description'] = $_promotion['pmt_description'];
                $list[$key]['promotions'][$keyp]['time_begin']  = $_promotion['time_begin'];
                $list[$key]['promotions'][$keyp]['time_end']    = $_promotion['time_end'];
            }
        }
        //$list['count']  = count($orm_list);
        return $list;
    }
    */
    
    /**
     * Overload delete() method
     * @param integer $id
     */
    public function delete()
    {
        $id = $this->data['id'];
        $banner = $this->data['banner'];
        if($id && $this->orm->delete())
        {
            $banner && $this->delete_banner($banner);
            Mypromotion::instance()->delete_by_pmtaid($id);
            return true;
        } else {
            return false;
        }
    }

    /** 
     * 删除对应的附件数据和存储文件 
     * @param int $picurl 附件pic 
     */ 
    public function delete_banner($banner) 
    {
        $img = explode("_", $banner);
        $id = substr($img[0], strrpos($img[0], '/')+1);
        $id && AttService::get_instance("promotion")->delete_img($id);
    } 
        
    /**
     * update a promotion activity image name
     *
     * @param Int       $id         activity ID
     * @param String    $image      picture name
     * @return Array
     */
    /*
    public function update_img_name($id, $image)
    {
        $activity = self::instance($id)->get();

        if (!$activity['id']) {
            $error          = 'record not exists';
            $this->error[]  = $error;
            Mylog::instance()->error($error,__FILE__,__LINE__);
            return FALSE;
        }
        $orm = ORM::factory($this->object_name, $id);
        $orm->banner = $image;
        $orm->save();
        return TRUE;
    }
    */
}
