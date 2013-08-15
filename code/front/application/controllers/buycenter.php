<?php defined('SYSPATH') OR die('No direct access allowed.');

class Buycenter_Controller extends Template_Controller {
	public function __construct()
	{
		parent::__construct();
		$view = new View();
		$view->set_global('_topnav', "is_hemai");//全局变量 彩种
	}

	//首页跳转页面
    public function index()
    {
        header("Location: /buycenter/jczq");
    }
    
	public function jczq()
	{
		$view = new View();
		$view->set_global('ticket_type', 1);//全局变量 彩种
		$view->set_global('play_method', 1);//全局变量 彩种

    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

       try {
            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
			
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
			$data['ajax_url'] ="/jczq/ajax_data_lists_hm/20/";
            
			//echo $data['ajax_url'];
			$this->template = new View("buycenter_jczq",$data);
			$this->template->set_global('_user', $this->_user);

        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
		}
        $this->template->render(TRUE);
	}

	public function lottnumpub($lottid='8'){
		$view = new View();
		$view->set_global('ticket_type', $lottid);//全局变量 彩种
		$view->set_global('play_method', 1);//全局变量 彩种
	
		$return_struct = array(
				'status'        => 0,
				'code'          => 501,
				'msg'           => 'Not Implemented',
				'content'       => array(),
		);
	
		try {
			$return_data = array();
			//* 补充&修改返回结构体 */
			$return_struct['status']  = 1;
			$return_struct['code']    = 200;
			$return_struct['msg']     = '';
			$return_struct['content'] = $return_data;
			
			$data['expect_data']=Qihaoservice::get_instance()->get_expect_info($lottid);
			
			$data['site_config'] = Kohana::config('site_config.site');
			$host = $_SERVER['HTTP_HOST'];
			$dis_site_config = Kohana::config('distribution_site_config');
			if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
				$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
				$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
				$data['site_config']['description'] = $dis_site_config[$host]['description'];
			}
			
			//$data['expect_data']=Qihaoservice::get_instance()->get_expect_info(8);
			$data['isnow'] = array();
			foreach ($data['expect_data'] as $v){
				if($v['isnow']==1) {
					$data['isnow'] = $v;
					break;
				}
			}
			//$data['play_method'] = $play_method;//玩法
			$data['play_method'] = isset($play_method)?$play_method:1;//玩法
			$data['ajax_url'] ="/lottnumpub/ajax_data_lists_hm/20/$lottid/";
			if($lottid==11){
				$this->template = new View("buycenter_pls",$data);
			}
			else{
			 $this->template = new View("buycenter_dlt",$data);   
			}
			$this->template->set_global('_user', $this->_user);
		}
		catch(MyRuntimeException $ex){
			$this->_ex($ex, $return_struct, $data);
		}
		$this->template->render(TRUE);
	}
	
	public function sfc_14c()
	{
		$this->sfc($play_method=1);
	}

	public function sfc_9c()
	{
		$this->sfc($play_method=2);
	}

	public function sfc_6c()
	{
		$this->sfc($play_method=3);
	}

	public function sfc_4c()
	{
		$this->sfc($play_method=4);
	}


	public function sfc($play_method)
	{
		$view = new View();
		$view->set_global('ticket_type', 2);//全局变量 彩种
		$view->set_global('play_method', $play_method);//全局变量 玩法

    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

       try {
            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
            
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
			$data['expect_data']=Zcsf_expectService::get_instance()->get_expect_info($play_method);
			$data['play_method'] = $play_method;//玩法
			$data['ajax_url'] ="/zcsf/ajax_data_lists_hm_".$data['expect_data']['expect_type']."c/".$data['expect_data']['expect_num']."/20/";
			//echo $data['ajax_url'];
			$this->template = new View("buycenter_zcsf",$data);
			$this->template->set_global('_user', $this->_user);
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
		}
        $this->template->render(TRUE);
	}

	public function jclq()
	{
		$view = new View();
		$play_method = 1;
		$view->set_global('ticket_type', 6);//全局变量 彩种
		$view->set_global('play_method', $play_method);//全局变量 玩法 $play_method

    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

       try {
            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
			
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
			$data['ajax_url'] ="/jclq/ajax_data_lists_hm/20/";
            
			//echo $data['ajax_url'];
			$this->template = new View("buycenter_jclq",$data);
			$this->template->set_global('_user', $this->_user);

        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
		}
        $this->template->render(TRUE);
	}

}
