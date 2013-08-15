<?php defined('SYSPATH') OR die('No direct access allowed.');

class Site_Controller extends Template_Controller {

    public function index($lan = 'cn') {
    	if ($lan == 'cn') {
    		$view_url = 'index';
    	}
    	else {
    		$view_url = 'index_'.$lan;
    	}
        $view = new View($view_url);
        $view->set_global('is_home', TRUE);
        $view->set_global('_user', $this->_user);
        //$view->set('language', $lan);
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

       try {
            $return_data = array();
            $post = $this->input->post();
            $request_data = $this->input->get();
            if(isset($request_data['ex'])){
                throw new MyRuntimeException('异常处理测试', 400);
            }

            //* 补充&修改返回结构体 */
            $return_struct['status'] = 1;
            $return_struct['code']   = 200;
            $return_struct['msg']    = '';
            $return_struct['content']= $return_data;

            $this->template = new View('index',
                                array(
                                    'name'=>'abc',
                                    'bbc'=>$request_data,
                                )
            );

            //* 请求类型 */
            if($this->is_ajax_request()){
                // ajax 请求
                // json 输出
                $this->template->content = $return_struct;
            }
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }
        
        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        $view->set("site_config",$data['site_config']);
		
		//友情链接
		$query_struct_link = array(
				'where'		=>array('status'=>1),
				'orderby'	=>array('order'=>'desc','created'=>'desc'),
				'limit'		=>array('per_page'=>100,'offset'=>0)
				);
		$site_link = Mysite_link::instance()->lists($query_struct_link);
		$view->set('site_link',$site_link);

		/**
			最新产品26,27,36,37
		 */
		$product_classify = array(26,27,36,37);
		$product_news = array();
		$product_news = Mynews::instance()->get_news_data($product_classify, 3);
		$view->set("product_news",$product_news);
        $view->render(TRUE);
    }

    public function error404() {
        $data = array();
        $data['msg'] = $this->input->get('msg', '404');
        $view = new View('404', $data);
        $view->render(TRUE);
    }

	/**
	 * show secode
	 */
	public function secoder()
	{
        $id = $this->input->get('id');
		secoder::$seKey = 'front.secoder.'.$id;
		secoder::entry();
	}
	
	public function secoder_regisiter($id, $flag) {
		//$id = $this->input->get('id');
		secoder::$useCurve = true;
		secoder::$useNoise = true;
		secoder::$imageL = 120;
		secoder::$length = 6;
		secoder::$seKey = 'front.secoder.'.$id;
		secoder::entry();
	}
	
	/**
	 * show sysmsg
	 */
	function sysmsg(){
        $msg = remind::get();
        $msgstr = isset($msg['success'])?implode('，', $msg['success']):'';
        $msgstr .= isset($msg['error'])?implode('，', $msg['error']):'';
        exit($msgstr);
	}
	
	public function header($_topnav = NULL) {
		$data = array('_topnav'=>$_topnav,'_user'=>$this->_user);
		echo View::factory('header_api',$data)->render();
	}
	
	public function footer() {
		$data = array('_user'=>$this->_user);
		echo View::factory('footer_api',$data)->render();
	}
	
	public function header_test($_topnav = NULL) {
		$data = array('_topnav'=>$_topnav,'_user'=>$this->_user);
		echo View::factory('header_',$data)->render();
	}
	
	public function header_p($name, $_topnav = NULL) {
		$data = array('_topnav'=>$_topnav,'_user'=>$this->_user);
		echo View::factory('headers/'.$name, $data)->render();
	}
	
	public function footer_p($name) {
		$data = array('_user'=>$this->_user);
		echo View::factory('footers/'.$name, $data)->render();
	}
}
