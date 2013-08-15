<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_auto_order_Controller extends Template_Controller {
	public static $pdb = null;
	public  $useroby = null;
	public  $autoorder = null;
	public $errorDesc=array();
	
	public function __construct()
	{
		parent::__construct();
		$this->userobj = user::get_instance();
		$this->userobj->check_login();		
		$this->autoorder = Auto_order_job_Model::get_instance();
		$this->errorDesc = Kohana::config('errorcode.error');
	}
	
	/*
	* Function: 我定制的自动跟单
	* Param   : 
	* Return  : 
	*/
	public function index()
	{	  
		$this->lists(array());	
    } 
	/*
	* Function: 启动自动跟单
	* Param   : 
	* Return  : 
	*/
	public function start_auto_order ($id) {
	    $this->autoorder->update_auto_order_stat($id,1);
		$this->template->render(false);
	}
    /*
    * Function: 禁用自动跟单
    * Param   : 
    * Return  : 
    */
	public function end_auto_order ($id) {
	    $this->autoorder->update_auto_order_stat($id,0);
		$this->template->render(false);
	}

	public function add($lotyid,$play_id,$fid) {
		$data = array();
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$fuser = ORM::factory('user')
				->where('id',$fid)
				->find()->as_array();
		$this->template = new View('user_auto_order/add',$data);
		$this->template->set_global('lotyid',$lotyid);
		$this->template->set_global('play_id',$play_id);
		$this->template->set_global('fid',$fid);
		$this->template->set_global('uid',$this->_user['id']);
		$this->template->set_global('ower',$fuser['lastname']);
		$this->template->render(TRUE);
	    
	}
	public function getuidfuid () {
	    exit(json_encode(array('uid'=>$this->_user['id'])));
	}
	/*
	* Function: 编辑自动跟单方案
	* Param   : 
	* Return  : 
	*/
	public function edit($id) {
		$data = array();
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
	    $auto_order_array = $this->autoorder->get_by_id($id);

		$this->template = new View('user_auto_order/edit',$data);
		$this->template->set_global('_user',$this->_user);
		$this->template->render(TRUE);

	}

	public function search ($lotyid) {
		$where = array();
	    if($lotyid>0)
		$where = array('lotyid'=>$lotyid);
		$this->lists($where);
	}
	/*
	* Function: 得到发起人的所有被跟单记录
	* Param   : 
	* Return  : 
	*/
	public function lists ($where) {
		$data = array();
	    $data = $this->autoorder->getSendorder($this->_user['id'],$where);	
		
	    $data['site_config'] = Kohana::config('site_config.site');
	    $host = $_SERVER['HTTP_HOST'];
	    $dis_site_config = Kohana::config('distribution_site_config');
	    if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	    	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	    	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	    	$data['site_config']['description'] = $dis_site_config[$host]['description'];
	    }
	    
		$this->template = new View('user_auto_order/index',$data);
		$this->template->set_global('_user',$this->_user);
		$this->template->set_global('_nav', 'auto_order');
		$this->template->render(TRUE);
	}


	/*
	* Function: 查询跟单信息
	* Param   : 
	* Return  : 
	*/
	public function search_auto_order () {
		//header("Content-type: text/xml; charset=utf-8");

		$fid=$this->input->post('fid');
		$lotyid=$this->input->post('lotyid');
		$play_id=$this->input->post('play_id');
		$uid=$this->_user['id'];
		$playtype=Kohana::config('ticket_type.method');
		$lotytype=Kohana::config('ticket_type.type');
		$lotyname = $lotytype[$lotyid].$playtype[$lotyid][$play_id];
		//得到发起人相关信息
		$ishaveme = false;
		$alluser = ORM::factory('auto_order_job')						
					->where(array('fuid'=>$this->input->post('fid'),
									'lotyid'=>$lotyid,
									'playid'=>$play_id))->find_all();

		//跟单总金额
		$allm=$allc = 0;
		
		foreach($alluser as $value) {
			$a = $value->as_array();
			
			$allm+=$a['allmoney'];
			//判断是不是首次定制跟单
			if($a['uid']==$this->_user['id']){
				$ishaveme=true;
				$auto_id  = $a['id'];
			}
			//得到跟单总人数
			$allc++;
		}
		
		if(!$ishaveme){
				echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="未知错误[0]" lotyname="'.$lotyname.'"><count allm="'.$allm.'" allc="'.$allc.'" />
				</Resp>';
		}else{

				
				$userArray = ORM::factory('user')
					->where('id',$this->_user['id'])->find()->as_array();
				$auto_order_array = ORM::factory('auto_order_job')
							->where(array('fuid'=>$fid,
										  'lotyid'=>$lotyid,
										  'playid'=>$play_id,
										  'uid'=>$uid)
									)
							->find()
							->as_array();
				//根据发起人和跟单人，来得到跟单人已经参与的所以发起人的关于该彩种的记录
				/*$auto_order_log_Obj = ORM::factory('auto_order_log')
									  ->where(array('fuid'=>$fid,
													'lotyid'=>$lotyid,
													'playid'=>$play_id,
													'uid'=>$uid
													)
										);
							
				$inums = $auto_order_log_Obj->count_all();
				$itmoney=0;
				$auto_order_logs = $auto_order_log_Obj->find_all();
				foreach($auto_order_logs as $value) {
					$a = $value->as_array();
					$itmoney+=$a['rgmoney'];
				}*/
				echo	'<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="未知错误[0]"><row auto_id="'.$auto_id.'" cnickid="'.$userArray['lastname'].'" lotyname = "'.$lotyname.'" cowner="'.$this->input->post('ower').'" istate="'.$auto_order_array['stat'].'" ilimit="'.$auto_order_array['limitswitch'].'" iminmoney="'.$auto_order_array['minimum'].'" imaxmoney="'.$auto_order_array['maximum'].'" cadddate="'.$auto_order_array['ctime'].'" ibmoney="'.$auto_order_array['money'].'" inums="'.$auto_order_array['nums'].'" itmoney="'.$auto_order_array['allmoney'].'" />
				<count allm="'.$allm.'" allc="'.$allc.'" />
				</Resp>';

			}
	}

	/*
	* Function: 定制和修改跟单信息
	* Param   : 
	* Return  : 
	*/
	public function do_auto_order () {
	    header("Content-type: text/xml; charset=utf-8");
	
		$data['id'] = $this->input->post('id');
		$data['lotyid'] = $this->input->post('lotyid');
		$data['playid'] = $this->input->post('play_id');
		$data['fuid'] = $this->input->post('fid');
		$data['uid'] = $this->_user['id'];
		$data['uname'] = $this->_user['lastname'];
		$data['lastname'] = $this->input->post('lastname');
		$data['funame'] = $this->input->post('lastname');
		$data['money'] = $this->input->post('money');
		$data['maximum'] = $this->input->post('max')?$this->input->post('max'):0;
		$data['minimum'] = $this->input->post('min')?$this->input->post('min'):0;
		$data['limitswitch'] = $this->input->post('limit');
		if($this->input->post('id')>0){
			$result=$this->autoorder->edit($data);
		}
		else{
	
		    $result=$this->autoorder->add($data);
		}
	
		echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="'.$result['code'].'" desc="'.$result['desc'].'" >
				</Resp>';

	}

	/*
	* Function: 我定制的跟单
	* Param   : 
	* Return  : 
	*/
	public function myfollow() {
		$data = array();
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
	    $this->template = new View('user_auto_order/myfollow',$data);
		$this->template->render(TRUE);
	}

	/*
	* Function: 定制我的用户
	* Param   : 
	* Return  : 
	*/
	public function followme() {
		$data = array();
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
	    $this->template = new View('user_auto_order/followme',$data);
		$this->template->render(TRUE);
	}

	/*
	* Function: 自动跟单记录
	* Param   : 
	* Return  : 
	*/
	public function followhist() {
		$data = array();
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
	    $this->template = new View('user_auto_order/followhist',$data);
		$this->template->render(TRUE);
	}

	public function modify ($do) {
	    switch ($do) {
	    case 'changestat':
			header("Content-type: text/xml; charset=utf-8");		
			$this->autoorder->update_auto_order_stat($this->input->post('id'),$this->input->post('state'));	
			echo '<?xml version="1.0" encoding="UTF-8"?>
			<Resp code="0" desc="设置自动跟单状态成功"></Resp>';
	    break;
	    }
	}

	public function query ($do) {
	    switch ($do) {
	    case 'myfollow':
			header("Content-type: text/xml; charset=utf-8");
			$where = array();

			$where['uid']=$this->_user['id'];
			$lotyid = $this->input->post('lotyid');
			$play_id = $this->input->post('play_id');		
			if($lotyid>0)
			$where['lotyid']=$lotyid;	
			 if($play_id>0)
			$where['playid']=$play_id;

			$currentPage = $this->input->post('pn');
			$currentPage = $currentPage?$currentPage:1;
			$showNum = $this->input->post('ps')?$this->input->post('ps'):10;

			$recsObj = $this->autoorder->where($where)->find_all();
			$recs=count($recsObj->as_array());
			$pageNums = ceil($recs/$showNum);

			$offset = ($currentPage-1)*$showNum;
			$limit = $showNum;		

			$data = $this->autoorder->where($where)->find_all($limit,$offset);
			$bh = $offset+1;
			//tr 总记录数  tp 总页数  ps 每页显示个数 pn 当前页码
			//rec 每条显示编号
			echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="查询成功">
				<rows tr="'.$recs.'" tp="'.$pageNums.'" ps="'.$showNum.'" pn="'.$currentPage.'">';
			foreach ($data as $val){
				$re = $val->as_array();
				$fu = ORM::factory('user')->where('id',$re['fuid'])->find()->as_array();
				echo '<row rec="'.$bh.'" id="'.$re['id'].'" nickid="'.$re['uid'].'" lotyid="'.$re['lotyid'].'" fid="'.$re['fuid'].'" play_id="'.$re['playid'].'"  owner="'.$fu['lastname'].'" state="'.$re['stat'].'" limit="'.$re['limitswitch'].'" minmoney="'.$re['minimum'].'" maxmoney="'.$re['maximum'].'" adddate="'.$re['ctime'].'" bmoney="'.$re['money'].'" nums="'.$re['nums'].'" tmoney="'.$re['allmoney'].'"></row>';
				$bh++;
			}
			echo '</rows></Resp>';


	    break;
		case 'followme':
			header("Content-type: text/xml; charset=utf-8");
			$where = array();
			$where['fuid']=$this->_user['id'];



			$lotyid = $this->input->post('lotyid');
			$play_id = $this->input->post('play_id');		
			if($lotyid>0)
			$where['lotyid']=$lotyid;	
			 if($play_id>0)
			$where['playid']=$play_id;

			$currentPage = $this->input->post('pn');
			$currentPage = $currentPage?$currentPage:1;
			$showNum = $this->input->post('ps')?$this->input->post('ps'):10;

			$recsObj = $this->autoorder->where($where)->find_all();
			$recs=count($recsObj->as_array());
			$pageNums = ceil($recs/$showNum);

			$offset = ($currentPage-1)*$showNum;
			$limit = $showNum;		
			$bh = $offset+1;	
			$data = $this->autoorder->where($where)->find_all($limit,$offset);

			//tr 总记录数  tp 总页数  ps 每页显示个数 pn 当前页码
			//rec 每条显示编号
			echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="查询成功">
				<rows tr="'.$recs.'" tp="'.$pageNums.'" ps="'.$showNum.'" pn="'.$currentPage.'">';
			foreach ($data as $val){
				$re = $val->as_array();
				$fu = ORM::factory('user')->where('id',$re['uid'])->find()->as_array();
				echo '<row rec="'.$bh.'" nickid="'.$re['uid'].'" lotyid="'.$re['lotyid'].'" play_id="'.$re['playid'].'"  nickname="'.$fu['lastname'].'" state="'.$re['stat'].'" limit="'.$re['limitswitch'].'" minmoney="'.$re['minimum'].'" maxmoney="'.$re['maximum'].'" adddate="'.$re['ctime'].'" bmoney="'.$re['money'].'" nums="'.$re['nums'].'" tmoney="'.$re['allmoney'].'"></row>';
				$bh++;
			}
			echo '</rows></Resp>';
	    break;
		case 'followhist':

			header("Content-type: text/xml; charset=utf-8");
			$where = array();
			$where['uid']=$this->_user['id'];

			$lotyid = $this->input->post('lotyid');
			$play_id = $this->input->post('play_id');		
			if($lotyid>0)
			$where['lotyid']=$lotyid;	
			 if($play_id>0)
			$where['playid']=$play_id;
			 
			 
			 /*if ($this->input->post('stime')) {
			  $where['UNIX_TIMESTAMP(`ctime`) > '] = strtotime($this->input->post('stime')." 00:00:00");
			 }
			 if ($this->input->post('etime')) {
			 $where['UNIX_TIMESTAMP(`ctime`) < '] = strtotime($this->input->post('etime')." 23:59:59");
			 }*/
			 
			$currentPage = $this->input->post('pn');
			$currentPage = $currentPage?$currentPage:1;
			$showNum = $this->input->post('ps')?$this->input->post('ps'):10;

			$recsObj = ORM::factory('auto_order_log')->where($where)->find_all();
			$recs=count($recsObj->as_array());
			$pageNums = ceil($recs/$showNum);

			$offset = ($currentPage-1)*$showNum;
			$limit = $showNum;		
			$bh = $offset+1;

			$data = ORM::factory('auto_order_log')->where($where)->find_all($limit,$offset);

			//tr 总记录数  tp 总页数  ps 每页显示个数 pn 当前页码
			//rec 每条显示编号
			echo '<?xml version="1.0" encoding="UTF-8"?><Resp code="0" desc="查询成功">
				<rows tr="'.$recs.'" tp="'.$pageNums.'" ps="'.$showNum.'" pn="'.$currentPage.'">';
			foreach ($data as $val){
				$re = $val->as_array();
				$fu = ORM::factory('user')->where('id',$re['fuid'])->find()->as_array();

				if ($re['isuccess']==0) {
				echo '<row rec="'.$bh.'" cnickid="'.$re['uname'].'" cprojid="'.$re['ordernum'].'" ibnum="1" imoney="'.$re['rgmoney'].'"   lotyid="'.$re['lotyid'].'" play_id="'.$re['playid'].'" istate="1" isuccess="0" creason="'.$this->errorDesc[$re['errcode']].'" cadddate="'.$re['ctime'].'" cgameid="1" ibuyid="" ierrcode="6" cerrdesc="'.$this->errorDesc[$re['errcode']].'" cowner="'.$re['funame'].'" />';

				}
				else{
				    echo '<row rec="'.$bh.'" lotyid="'.$re['lotyid'].'" play_id="'.$re['playid'].'"  cnickid="'.$re['uname'].'" cprojid="'.$re['ordernum'].'" ibnum="'.$re['rgmoney'].'" imoney="'.$re['rgmoney'].'" istate="1" isuccess="1" creason="'.$this->errorDesc[$re['errcode']].'('.$re['ordernum'].')" cadddate="'.$re['ctime'].'" cgameid="85" ibuyid="11934207" ierrcode="0" cerrdesc="'.$this->errorDesc[$re['errcode']].'('.$re['ordernum'].')" cowner="'.$re['funame'].'" />';
				}
				$bh++;
			}
			echo '</rows></Resp>';

	    break;
	    }
	}


}
