<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jclq_Controller extends Template_Controller {
	
	public $lotyid = 6;
	
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin:*");
	}
	
	public function  index(){		
		$this->template = new View("guoguan/jclq_sf",$data);
		$this->template->render(TRUE);	
	}
	
	public function  dxf(){	
		$this->template = new View("guoguan/jclq_dxf",$data);
		$this->template->render(TRUE);	
	}
	
	public function  rfsf(){	
		$this->template = new View("guoguan/jclq_rfsf",$data);
		$this->template->render(TRUE);	
	}
	
	public function  sf(){	
		$this->template = new View("guoguan/jclq_sf",$data);
		$this->template->render(TRUE);	
	}
	public function  sfc(){	
		$this->template = new View("guoguan/jclq_sfc",$data);
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
			<jcfs total="84" ps="25" tp="4"/>
			
			</rows>';
	}
	

	
}
?>