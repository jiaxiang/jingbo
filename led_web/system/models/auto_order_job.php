<?php defined('SYSPATH') OR die('No direct access allowed.');

class Auto_order_job_Model extends ORM {
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public static $instance = NULL;

    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }

    public function validate(array & $array, $save = FALSE)
	{
		$fields = parent::as_array();
		
		$array = array_merge($fields, $array);
		
		$array = Validation::factory($array)
			->pre_filter('trim');

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}



	public function getSendorder($uid,$where) {	
		 if($uid<0) return false; 
		 $result=$this->db->from('auto_order_jobs')
			->where(array_merge(array('uid' => $uid),$where))
			->get()->as_array();
		 return $result;
	}
	
	/*
	* Function: 更改状态stat
	* Param   : 
	* Return  : 
	*/
	public function update_auto_order_stat ($id,$stat) {

		return	$this->db -> from('auto_order_jobs')
				-> set(array('stat' => $stat))
				-> where(array('id' =>$id))
				-> update();
	}

	public function disable($id) {
	    return $this->update_auto_order_stat($id,0);
	}

	public function enable($id) {
	    return $this->update_auto_order_stat($id,1);
	}

	public function changstate($id) {
	    
	}


	
	public function add ($data) {
		$code = -1;
		$desc = "未知错误！";
	    $data['ctime'] = date("Y-m-d H:i:s");
		$row = $this->db->query("select * from auto_order_jobs where lotyid='".$data['lotyid']."' and playid='".$data['playid']."' and fuid='".$data['fuid']."' and uid='".$data['uid']."' and lotyid='".$data['lotyid']."'");
		if($row->count()>0) {
			$code = 1;
			$desc = "已经定制！";

		}
		$query = $this->db->insert('auto_order_jobs', $data);
		$insertid = $query->insert_id();
		if($insertid>0){
			$code = 0;
			$desc = "定制成功！";
		}
		return array("code"=>$code,"desc"=>$desc);
	}

	public function edit ($data) {
		$code = -1;
		$desc = "未知错误！";

		if(!count($data)) {
			$code = -2;
			$desc = "参数错误！";
		}
    	$row = $this->db->query("select * from auto_order_jobs where id='".$data['id']."'");
        if($row->count()==0) return -1;


        $id = $data['id'];
    	$query = $this->db->update('auto_order_jobs', $data,array('id'=>$id));

    	if($query->count()>=0){
			$code = 0;
			$desc = "修改成功！";
		}
		return array("code"=>$code,"desc"=>$desc);
	}
	
	
}
