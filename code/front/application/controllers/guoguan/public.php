<?php defined('SYSPATH') OR die('No direct access allowed.');

class Public_Controller extends Template_Controller {
	
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin:*");
	}
	public function bjdc(){
		header("Content-type: text/xml; charset=utf-8");
		$where = array();		
		$play_id = $this->input->post('playid');
		$expect=$this->input->post('expect');
		if($play_id>0)
		$where['play_method']=$play_id;					
		$where['issue']=$expect;	
		$where['parent_id']=0;

		
		$currentPage = $this->input->post('pn');
		$currentPage = $currentPage?$currentPage:1;
		$showNum = $this->input->post('ps')?$this->input->post('ps'):20;

		
		$recsObj = ORM::factory('plans_bjdc')->where($where)->find_all();
		$recs=count($recsObj->as_array());
		$pageNums = ceil($recs/$showNum);
		$offset = ($currentPage-1)*$showNum;
		$limit = $showNum;	

		
		$p_b_obj = new Plans_bjdc_Model();
		$p_b_obj->sorting=array('bonus'=>'desc');
		$data = $p_b_obj->where($where)->find_all($limit,$offset);		
		$bh = $offset+1;
		
		
		echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="查询成功">
		<rows tr="'.$recs.'" tp="'.$pageNums.'" ps="'.$showNum.'" pn="'.$currentPage.'">';		
		foreach ($data as $val) {
			$re = $val->as_array();
			if(empty($re['bonus'])){$re['bonus']=0.00;}
			$u = ORM::factory('user')->where('id',$re['user_id'])->find()->as_array();
			$total_price = $re['total_price'];
			//<row uname="用户名" ag="金星" au="银星" info="中奖注数，选择的场次，过关方式" bonus="奖金" betnum="投注注数" mnums="选择场数" zhushu="中奖注数" gnames="几串几" hid="方案id" />
			$munms=count(explode('/',$re['codes'] ));				
			if($re['plan_type']!=1){
				echo '<row uname="******"  uid="'.$u['id'].'" ';
			}
			else{
				echo '<row uname="'.$u['lastname'].'" uid="'.$u['id'].'" ';
			}				
			echo ' info="36|'.$munms.'|'.$re['typename'].'" bonus="'.$re['bonus'].'" betnum="'.$total_price.'" mnums="'.$munms.'" bnums="36" gnames="'.$re['typename'].'" hid="'.$re['basic_id'].'"/>
			';
		}
		echo '</rows></Resp>';		
		
	}
	
	public function szc(){
		header("Content-type: text/xml; charset=utf-8");
		$where = array();
		$lotyid = $this->input->post('lotyid');
		$expect=$this->input->post('expect');
		$where['lotyid']=$lotyid;
		$where['qihao']=$expect;		
		
		$currentPage = $this->input->post('pn');
		$currentPage = $currentPage?$currentPage:1;
		$showNum = $this->input->post('ps')?$this->input->post('ps'):20;
		
		
		$recsObj = ORM::factory('plans_lotty_order')->where($where)->find_all();
		$recs=count($recsObj->as_array());
		$pageNums = ceil($recs/$showNum);
		$offset = ($currentPage-1)*$showNum;
		$limit = $showNum;
		
		
		$p_b_obj = new Plans_lotty_order_Model();
		$p_b_obj->sorting=array('afterbonus'=>'desc');
		$data = $p_b_obj->where($where)->find_all($limit,$offset);
		$bh = $offset+1;
		
		
		echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="查询成功">
		<rows tr="'.$recs.'" tp="'.$pageNums.'" ps="'.$showNum.'" pn="'.$currentPage.'">';
		foreach ($data as $val) {
			$re = $val->as_array();
			if(empty($re['bonus'])){
				$re['bonus']=0.00;
			}
			$u = ORM::factory('user')->where('id',$re['uid'])->find()->as_array();
			$total_price = $re['allmoney'];
			$periodid = $re['qihao'];
			//<row uname="用户名" ag="金星" au="银星" info="中奖注数，选择的场次，过关方式" bonus="奖金" betnum="投注注数" mnums="选择场数" zhushu="中奖注数" gnames="几串几" hid="方案id" />
			$munms=count(explode('/',$re['codes'] ));
			
			$info = $this->getZJinfo($lotyid,$re['zjinfo']);
			
			if($re['plan_type']!=1){
				echo '<row uname="******" ';
			}
			else{
				echo '<row uname="'.$u['lastname'].'" ';
			}
			echo ' uid="'.$u['id'].'"  info="'.$info.'" bonus="'.$re['prebonus'].'" betnum="'.$total_price.'" mnums="'.$munms.'" bnums="36" gnames="'.$re['typename'].'" hid="'.$re['basic_id'].'"/>
			';
		}
		echo '</rows></Resp>';
	
	}
		
	public function zcsf(){
		header("Content-type: text/xml; charset=utf-8");
		$where = array();
		$playid = $this->input->post('playid');
		$expect=$this->input->post('expect');
		//$expect='11088';
		$where['play_method']=$playid;
		$where['expect']=$expect;		
		
		$currentPage = $this->input->post('pn');
		$currentPage = $currentPage?$currentPage:1;
		$showNum = $this->input->post('ps')?$this->input->post('ps'):20;
		
		
		$recsObj = ORM::factory('plans_sfc')->where($where)->find_all();
		$recs=count($recsObj->as_array());
		$pageNums = ceil($recs/$showNum);
		$offset = ($currentPage-1)*$showNum;
		$limit = $showNum;
		
		
		$p_s_obj = new Plans_sfc_Model();
		$p_s_obj->sorting=array('bonus'=>'desc');
		$data = $p_s_obj->where($where)->find_all($limit,$offset);
		$bh = $offset+1;
		
		
		echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="查询成功">
		<rows tr="'.$recs.'" tp="'.$pageNums.'" ps="'.$showNum.'" pn="'.$currentPage.'">';
		foreach ($data as $val) {
			$re = $val->as_array();
			if(empty($re['bonus'])){
				$re['bonus']=0.00;
			}
			$u = ORM::factory('user')->where('id',$re['user_id'])->find()->as_array();
			$total_price = $re['price'];
			$periodid = $re['qihao'];
			//<row uname="用户名" ag="金星" au="银星" info="中奖注数，选择的场次，过关方式" bonus="奖金" betnum="投注注数" mnums="选择场数" zhushu="中奖注数" gnames="几串几" hid="方案id" />
			$munms=count(explode('/',$re['codes'] ));
			if($re['is_buy']!=1){
				echo '<row uname="******"  ';
			}
			else{
				echo '<row uname="'.$u['lastname'].'" ';
			}
			echo '  uid="'.$u['id'].'" info="36|'.$munms.'|'.$re['typename'].'" bonus="'.$re['bonus'].'" betnum="'.$total_price.'" mnums="'.$munms.'" bnums="36" gnames="'.$re['typename'].'" hid="'.$re['basic_id'].'"/>
			';
					
		}
		echo '</rows></Resp>';
		
		
	}
	
	public function search(){
		//header("Content-type: text/xml; charset=utf-8");
		$where = array();		
		$lotyid = $this->input->post('lotyid');
		$play_id = $this->input->post('playid');
		$expect=$this->input->post('expect');
		if($lotyid>0)
			$where['ticket_type']=$lotyid;
		if($play_id>0)
			$where['play_method']=$play_id;			
		//$where['bonus > ']=0;			
		switch ($lotyid){
			case 1:
			case 6:
				$edate = $this->stod($expect);
				$where['date_end >']= $edate[0];
				$where['date_end <']= $edate[1];
			break;
			default:				
			break;
		}
		
		$currentPage = $this->input->post('pn');
		$currentPage = $currentPage?$currentPage:1;
		$showNum = $this->input->post('ps')?$this->input->post('ps'):20;
		
		$recsObj = ORM::factory('plans_basic')->where($where)->find_all();
		$recs=count($recsObj->as_array());
		$pageNums = ceil($recs/$showNum);		
		$offset = ($currentPage-1)*$showNum;
		$limit = $showNum;

		
		$p_b_obj = new Plans_basic_Model();
		$p_b_obj->sorting=array('bonus'=>'desc');
		$data = $p_b_obj->where($where)->find_all($limit,$offset);		
		$bh = $offset+1;

		
		echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="查询成功">
			<rows tr="'.$recs.'" tp="'.$pageNums.'" ps="'.$showNum.'" pn="'.$currentPage.'">';
		
		foreach ($data as $val) {
			$re = $val->as_array();
			if(empty($re['bonus'])){
				$re['bonus']=0.00;
			}
			$u = ORM::factory('user')->where('id',$re['start_user_id'])->find()->as_array();
			$planinfo = $this->getPlanInfo($re['ticket_type'],$re['order_num']);
			$periodid = '';
			
			switch($re['ticket_type']){
				case '1':
				case '6':
					$total_price = $planinfo['total_price'];
					$periodid =$planinfo['issue'];
					$munms=count(explode('/',$planinfo['codes'] ));
					
					if($re['plan_type']!=1){			
					echo '<row uname="******" uid="'.$u['id'].'" ';
					}
					else{
					echo '<row uname="'.$u['lastname'].'"  uid="'.$u['id'].'" ';
					}
					
					echo ' info="36|'.$munms.'|'.$planinfo['typename'].'" bonus="'.$re['bonus'].'" betnum="'.$total_price.'" mnums="'.$munms.'" bnums="36" gnames="'.$planinfo['typename'].'" hid="'.$planinfo['basic_id'].'"/>
					';
				break;		
			}		

		}	
		echo '</rows></Resp>';
	}
	
	public function getZJinfo($lotyid,$zjinfo){
	    switch ($lotyid){
	        case 8:
	            $info='0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0';
	            $c = explode(',', $info);
	            if($zjinfo!=''){
	                $a =explode(',', $zjinfo);
	                foreach($a as $val){
	                    $b = explode('=', $val);	                    
	                    if($b[0]!=16){
	                        if(fmod($b[0], 2)>0){
	                            $c[((($b[0]+1)/2)-1)]=$b[1];	                            
	                        }
	                        else{
	                            $c[9+($b[0]/2)]=$b[1];
	                        }	                        
	                    }
	                    else{
	                        $c[8]=$b[1];
	                    }
	                                           
	                }
	                $info=(implode(',', $c));
	            }	            
	        break;
	        case 9:
	            $info='0';
	            $b = explode('=', $zjinfo);
	            if($b[1]>0){
	              $info='$b[1]';  
	            }	            
	        break;
	        case 10:	           
	        case 11:
	            $info=$lotyid==11?'0,0,0':'0,0,0,0,0,0';
	            $c = explode(',', $info);
	            if($zjinfo!=''){
	                $a =explode(',', $zjinfo);
	                foreach($a as $val){
	                    $b = explode('=', $val);
	                    $c[($b[0]-1)]=$b[1];
	                     
	                }
	                $info=(implode(',', $c));
	            }    
	        break;
	  
	    }
	    
	    return $info;
	}
	
	public function getPlanInfo($lotyid,$order_num){
		$table_name=$this->getPlanTable($lotyid);
		$p = ORM::factory($table_name)->where('basic_id',$order_num)->find()->as_array();
		return $p;
	}
	
	
	public function getPlanTable($lotyid){
		switch($lotyid){
			case '1':
				$table_name = 'plans_jczq';
				break;
			case '2':
				$table_name = 'plans_sfc';
				break;
			case '6':
				$table_name = 'plans_jclq';
				break;
			case '7':
				$table_name = 'plans_bjdc';
				break;
			case '8':
			case '9':
			case '10':
			case '11':
				$table_name = 'plans_lotty_order';
				break;
		}
		return $table_name;
	}
	
	
	public function stod($str){
		$y = substr($str, 0,4);
		$m = substr($str, 4,2);
		$d = substr($str, 6,2);	
		$d2 = $d+1;
		if(strlen($d2)==1) $d2 = strval('0'.$d2) ;	
		return array($y.'-'.$m.'-'.$d." 12:00:00",$y.'-'.$m.'-'.($d2)." 12:00:00");
		
	}
	
}
?>