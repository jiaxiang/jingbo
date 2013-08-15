<?php defined('SYSPATH') OR die('No direct access allowed.');

class Qihaoservice_Core extends DefaultService_Core 
{
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;
    private static $pdb = null;
	   
    // 获取单态实例
    public static function get_instance()
    {
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
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
    
    public function get_expect_info($lottid=8){
        $result = array();
    	if(empty($lottid))
		{
			$lottid=8;
		}
		$this->loaddb();
    	 //select 
    	 $rows = self::$pdb->query("select * from qihaos where lotyid='".$lottid."' order by id desc limit 0,10 ");
    	 return $rows->result_array(false);
    }
    
    
    public function getisnow($lottid=8){
        $result = array();
    	if(empty($lottid))
		{
			return false;
		}
		$qhobj = ORM::factory('qihao');
		$where = array();
		$where['isnow'] = 1;
		$where['lotyid'] = $lottid;
		$qihao = $qhobj->where($where)->find();
		if($qihao->loaded)
		{
			$result = $qihao->as_array();
			return $result;
		} else {
			//如果没有当前期取可销售的期号。
			$where['buystat'] = 1;
		    $where['lotyid'] = $lottid;
		    $qihao = $qhobj->where($where)->find();
		    if($qihao->loaded){
		    	$result = $qihao->as_array();
				return $result;
		    }
			return false;
		}
    }
    
    
    
    public function loaddb(){
		if(!self::$pdb){
		 	self::$pdb = Database::instance();
		}
	}
}