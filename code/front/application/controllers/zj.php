<?php defined('SYSPATH') OR die('No direct access allowed.');
class Zj_Controller extends Template_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function view ($uid) {
		$u = ORM::factory('user')->where('id',$uid)->find()->as_array();
		$data = $this->_site_config;
		$this->template = new View("zj/view",$data);
		$this->template->set_global('uid',$uid);
		$this->template->set_global('uname',$u['lastname']);
		$this->template->render(TRUE);
	}
	
	public function tquery(){
		header("Content-type: text/xml; charset=utf-8");
		$where = array();
		$uid = $this->input->post('uid')?$this->input->post('uid'):0;
		$where['start_user_id']=$uid;
		$where['plan_type <> ']=2;
		$lotyid = $this->input->post('lotyid');
		$play_id = $this->input->post('playid');
		if($lotyid>0)
			$where['ticket_type']=$lotyid;
		if($play_id>0)
			$where['play_method']=$play_id;	
		if($this->input->post('func')=='zj')	
		$where['bonus > ']=0;
		
		$currentPage = $this->input->post('pn');
		$currentPage = $currentPage?$currentPage:1;
		$showNum = $this->input->post('ps')?$this->input->post('ps'):10;

		
		$recsObj = ORM::factory('plans_basic')->where($where)->find_all();
		$recs=count($recsObj->as_array());
		$pageNums = ceil($recs/$showNum);
		
		$offset = ($currentPage-1)*$showNum;
		$limit = $showNum;
		
		
		$p_b_obj = new Plans_basic_Model();
		$p_b_obj->sorting=array('bonus'=>'desc');
		$data = $p_b_obj->where($where)->find_all($limit,$offset);
		$bh = $offset+1;
		
		
		//tr 总记录数  tp 总页数  ps 每页显示个数 pn 当前页码
		//rec 每条显示编号
		echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="查询成功">
		<rows tr="'.$recs.'" tp="'.$pageNums.'" ps="'.$showNum.'" pn="'.$currentPage.'">';
		foreach ($data as $val){
			$re = $val->as_array();
			if(empty($re['bonus'])){
				$re['bonus']=0.00;
				
			}
			$u = ORM::factory('user')->where('id',$uid)->find()->as_array();
			$planinfo = $this->getPlanInfo($re['ticket_type'],$re['order_num']);
			$periodid = '';
			switch($re['ticket_type']){
				case'2':
					$total_price = $planinfo['price'];
					$periodid =$planinfo['expect'];
				break;				
				case '1':
				case '6':
				case '7':
					$total_price = $planinfo['total_price'];
					if($re['ticket_type']==7){
						$periodid =$planinfo['issue'];
					}					
				break;
				case '8':
				case '9':
				case '10':
				case '11':
					$total_price = $planinfo['allmoney'];
					$periodid = $planinfo['qihao'];
				break;
					
			}
			echo '
				<row rec="'.$bh.'" planid="'.$planinfo['id'].'" irecid="'.$re['order_num'].'" cnickid="'.$u['lastname'].'" lotyid="'.$re['tick_type'].'" playid="'.$re['play_method'].'" cgameid="" cperiodid="'.$periodid.'" cprojid="'.$re['order_num'].'" iplay="0" ipmoney="'.$total_price.'" iwmoney="'.$re['bonus'].'" iaunum="1" iagnum="0" cadddate="'.$re['date_add'].'" isuccess="0"/>
			';
			$bh++;

		}
		echo '</rows></Resp>';
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
}
