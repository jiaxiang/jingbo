<?php defined('SYSPATH') OR die('No direct access allowed.');

class Pls_Controller extends Template_Controller {
	
	public $lotyid = 11;
	
	public function __construct()
	{
		parent::__construct();
		header("Access-Control-Allow-Origin:*");
	}
	
	public function  index(){

		
		$this->template = new View("guoguan/pls",$data);
		$this->template->render(TRUE);
	
	}
	
	public function expectlist(){	
		header("Content-type: text/xml; charset=utf-8");
		$where = array();		
		$where['lotyid']=$this->lotyid;
		$p_l_o_obj = new Qihao_Model();
		$p_l_o_obj->sorting=array('id'=>'desc');
		$data = $p_l_o_obj->where($where)->find_all();
		$bh = 1;	
		echo '<?xml version="1.0" encoding="UTF-8"?><Resp desc="查询成功" code="0">';		
		foreach ($data as $val){
			$re = $val->as_array();
			echo '<row pid="'.$re['qihao'].'" et="'.$re['endtime'].'" fet="'.$re['fendtime'].'" flag="1" st="108" />';
		}
		echo '</Resp>';
		
	}

	//获奖号码和奖金查询
	public function current(){
		header("Content-type: text/xml; charset=utf-8");
		$where = array();
		$expect = $this->input->post('expect');
		//$expect = '2012034';
		$where['qihao']= $expect;
		$where['lotyid']= $this->lotyid;
		$p_l_o_obj = new Qihao_Model();
		$p_l_o_obj->sorting=array('id'=>'desc');
		$data = $p_l_o_obj->where($where)->find()->as_array();
		$p_l_o_e_obj = new Qihao_ext_Model();
		$data_e = $p_l_o_e_obj->where("qid='".$data['id']."'")->find()->as_array();
		
		$jiangjin = explode(';', $data_e['salesacc']);
		
		$jiangxiang = explode(';', $data_e['bonusinfo']);
		$fg='';
		foreach($jiangxiang as $jx){
			$jxa = explode(',', $jx);
			$ginfo.=$fg.$jxa[2];
			$ninfo.=$fg.$jxa[1];
			$fg=",";
		}
		echo '<?xml version="1.0" encoding="UTF-8"?>
				<rows gid="53" pid="'.$expect.'"  code="'.$data_e['awardnum'].'"   gsale="'.$jiangjin['0'].'"   ginfo="'.$ginfo.'" ninfo="'.$ninfo.'" gpool="'.$jiangjin['1'].'" etime="" atime="'.$data['ktime'].'">
<as total="27" ps="25" tp="2"/>
<af total="0" ps="25" tp="0"/>
<ds total="0" ps="25" tp="0"/>
<fs total="27" ps="25" tp="2"/>
<df total="0" ps="25" tp="0"/>
<ff total="0" ps="25" tp="0"/>
</rows>';
	}
	

	
}
?>