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
    
    public function get_qihao_by_id($id){
    	$result = array();
    	if(empty($id))
		{
			return false;
		}
		$where = array();
		$where['id'] = $id;
		$qihao = ORM::factory('qihao')->where($where)->find();
		if($qihao->loaded)
		{
			$result = $qihao->as_array();
			$qhext = ORM::factory('qihao_ext')->where('qid',$id)->find();
			if($qhext->loaded){
				$ext = $qhext->as_array();				$ext['limitcode']=str_replace(",",PHP_EOL,$ext['limitcode']);
				$result['ext'] = $ext;
			}
			return $result;
		} else {
			return false;
		}
    }
    
    public function addqihao($data){
    	 $this->loaddb();
    	 if(!count($data)) return -2;
    	 //select 
    	 $row = self::$pdb->query("select * from qihaos where qihao='".$data['qihao']."' and lotyid='".$data['lotyid']."'");
         if($row->count()>0) return -1;
    	 $query = self::$pdb->insert('qihaos', $data);
    	 $insertid = $query->insert_id();
    	 //当前期设置
    	 if(isset($data['isnow'])){
    	 	$this->changeisnow($insertid,$data['lotyid']);
    	 }
    	 return $insertid;
    }
    
    public function addext($data){
    	 $this->loaddb();
    	 if(!count($data)) return -2;
    	 //select 
    	 $row = self::$pdb->query("select * from qihao_exts where qid='".$data['qid']."'");
         if($row->count()>0) return -1;
    	 $query = self::$pdb->insert('qihao_exts', $data);
    	 return $query->insert_id();
    }
    
    public function updateqihao($data){
    	$this->loaddb();
    	if(!count($data)) return -2;
    	$row = self::$pdb->query("select * from qihaos where id='".$data['id']."'");
        if($row->count()==0) return -1;
        $id = $data['id'];
    	$query = self::$pdb->update('qihaos', $data,array('id'=>$id));
    	$count = count($query);
        //当前期设置
    	if(isset($data['isnow'])&&$count){
    	 	$this->changeisnow($id,$data['lotyid']);
    	}
        return $count;
    }
    
    public function updateext($data){
    	$this->loaddb();
    	if(!count($data)) return -2;
    	$row = self::$pdb->query("select * from qihao_exts where qid='".$data['qid']."'");
        if($row->count()==0) return -1;
        $id = $data['qid'];

    	$query = self::$pdb->update('qihao_exts', $data,array('qid'=>$id));
        return count($query);
    	 
    }
    
    public function  changeisnow($id,$lotyid='8'){
    	$this->loaddb();
    	self::$pdb->from('qihaos')->set(array('isnow' => 0))->where(array('id!=' => $id,'lotyid'=>$lotyid))->update();
    }
    
    public function del($id){
    	$this->loaddb();
    	$qhstat = self::$pdb->delete('qihaos', array('id' => $id));
    	$extstat = self::$pdb->delete('qihao_exts', array('qid' => $id));
    	return count($qhstat);
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