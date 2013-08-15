<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jczq_Controller extends Template_Controller {
	
	public $lotyid = 1;
	public $playid = 1;
	
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin:*");
	}
	public function  index(){
		$this->playid = 1;
		$data = $this->_site_config;
		$this->template = new View("guoguan/jczq_rqspf",$data);
		$this->template->render(TRUE);
	}
	public function  rqspf(){		
		$this->playid = 1;
		$data = $this->_site_config;
		$this->template = new View("guoguan/jczq_rqspf",$data);
		$this->template->render(TRUE);	
	}
	
	public function  bf(){
		$this->playid = 3;
		$this->template = new View("guoguan/jczq_bf",$data);
		$this->template->render(TRUE);	
	}
	public function  bqc(){
		$this->playid = 4;
		$this->template = new View("guoguan/jczq_bqc",$data);
		$this->template->render(TRUE);	
	}
	public function  zjqs(){
		$this->playid = 2;
		$this->template = new View("guoguan/jczq_zjqs",$data);
		$this->template->render(TRUE);	
	}	
	
	public function expectlist(){	
		header("Content-type: text/xml; charset=utf-8");
		$i=date(G)>12?0:1;
		echo '<Resp desc="查询成功" code="0">';		
		for (; $i < 365 ;$i++) {
			echo '<row did="'.date('ymd', strtotime("-$i day")).'"/>';
		}		
		echo '</Resp>';
	}

	//获奖号码和奖金查询
	public function current(){
		header("Content-type: text/xml; charset=utf-8");
		echo '<?xml version="1.0" encoding="UTF-8"?>
			<rows>
			<jcfs total="2" ps="25" tp="4"/>
			</rows>';
	}
	

	
}
?>