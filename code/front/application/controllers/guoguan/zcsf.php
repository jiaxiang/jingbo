<?php defined('SYSPATH') OR die('No direct access allowed.');

class Zcsf_Controller extends Template_Controller {
	
	public $lotyid = 2;
	
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin:*");
	}
	
	public function  index(){		
		$this->template = new View("guoguan/zcsf_sfc_14c",$data);
		$this->template->render(TRUE);
	
	}
	public function  sfc_14c(){
		$this->template = new View("guoguan/zcsf_sfc_14c",$data);
		$this->template->render(TRUE);
	
	}
	public function  sfc_9c(){
		$this->template = new View("guoguan/zcsf_sfc_9c",$data);
		$this->template->render(TRUE);
	
	}
	public function  sfc_6c(){
		$this->template = new View("guoguan/zcsf_sfc_6c",$data);
		$this->template->render(TRUE);
	
	}
	public function  sfc_4c(){
		$this->template = new View("guoguan/zcsf_sfc_4c",$data);
		$this->template->render(TRUE);
	
	}
	
	public function expectlist(){	
		header("Content-type: text/xml; charset=utf-8");	
		$sfc = new Zcsf_expect_Model();	
		switch ($this->input->post('lotid')){
			case 80:
			case 81:
				$type='wilo';
			break;
			case 82:
				$type='goal';
			break;
			case 83:
				$type='hafu';
			break;
		}

		$res=$sfc->getExpects($type);

		echo '<?xml version="1.0" encoding="UTF-8"?><Resp desc="查询成功" code="0">';		
		foreach ($res as $re){

			echo '<row pid="'.$re->expect_num.'" et="'.$re->end_time.'" fet="'.$re->end_time.'" flag="1" st="108" />';
		}
		echo '</Resp>';

	}

	//获奖号码和奖金查询
	public function current(){
		header("Content-type: text/xml; charset=utf-8");
		$where = array();
		$expect = $this->input->post('expect');
		$where['expect_num']= $expect;
		switch ($this->input->post('lotid')){
			case 80:
			case 81:
				$type='wilo';
				break;
			case 82:
				$type='goal';
				break;
			case 83:
				$type='hafu';
				break;
		}
		$where['expect_type']= $type;
		$sfc = new Zcsf_expect_Model();		
		$data = $sfc->where($where)->find_all();
		$bh=1;$fg='';
		foreach($data as $re){		
			$gresult=explode(':', $re->game_result);
			$row.= '<row id="'.$bh.'" hn="'.$re->vs1.'" vn="'.$re->vs2.'" hs="'.$gresult[0].'" vs="'.$gresult[1].'"  result="'.$re->cai_result.'"/>';
			if($re->cai_result==''){$re->cai_result= '*';}
			$code .= $fg.$re->cai_result;			
			$fg=',';
			if($bh==1) $endtime=$re->end_time;$opentime=$re->open_time;
			$bh++;
			
			
		}
		echo '<?xml version="1.0" encoding="UTF-8"?>
		<rows gid="'.$this->input->post('lotid').'" pid="'.$expect.'" code="'.$code.'" gsale="" ginfo="" ninfo="" gpool="" etime="'.$endtime.'" atime="'.$opentime.'">';
		echo $row;
		echo '<as total="0" ps="0" tp="0"/>
		</rows>';
	}
	

	
}
?>