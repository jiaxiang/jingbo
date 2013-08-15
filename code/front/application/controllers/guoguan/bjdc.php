<?php defined('SYSPATH') OR die('No direct access allowed.');

class Bjdc_Controller extends Template_Controller {
	
	public $lotyid = 7;
	
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin:*");
	}
	
	public function  index(){
		$this->template = new View("guoguan/bjdc_rqspf");
		$this->template->render(TRUE);
	}	
	
	public function  rqspf(){
		$this->template = new View("guoguan/bjdc_rqspf");
		$this->template->render(TRUE);
	}
	
	public function  bf(){		
		$this->template = new View("guoguan/bjdc_bf");
		$this->template->render(TRUE);	
	}

	public function  bqc(){
		$this->template = new View("guoguan/bjdc_bqc");
		$this->template->render(TRUE);
	}	
	
	public function  sxds(){
		$this->template = new View("guoguan/bjdc_sxds");
		$this->template->render(TRUE);
	}
	public function  zjqs(){
		$this->template = new View("guoguan/bjdc_zjqs");
		$this->template->render(TRUE);
	}
	
	
	public function expectlist(){	
		header("Content-type: text/xml; charset=utf-8");
		$m_b_i_obj =  Match_bjdc_issue_Model::get_instance();
		$res=$m_b_i_obj->getExpects();	
		echo '<?xml version="1.0" encoding="UTF-8"?><Resp desc="查询成功" code="0">';		
		foreach ($res as $re){
			echo '<row pid="'.$re->number.'" et="'.$re->stop.'" fet="'.$re->stop.'" flag="1" st="108" />';
		}
		echo '</Resp>';
	
	}

	//获奖号码和奖金查询
	public function current(){
		header("Content-type: text/xml; charset=utf-8");
		echo '<?xml version="1.0" encoding="UTF-8"?>
				<rows>
<bjfs total="12" ps="25" tp="1"/>
<bjus total="0" ps="25" tp="0"/>
<bjff total="0" ps="25" tp="0"/>
<bjuf total="0" ps="25" tp="0"/>
</rows>';
	}
	

	
}
?>