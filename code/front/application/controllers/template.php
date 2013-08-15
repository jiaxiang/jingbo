<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Template_Controller extends Controller {
    
    // Default to do auto-rendering
    public $auto_render = FALSE;
    
    public $ajax_request = FALSE;
    
    public $_user = NULL;
    public $_agent = NULL;
    public $_site_config = NULL;
    
    public function is_ajax_request()
    {
        return $this->ajax_request;
    }
    
    public function set_ajax_request($bool)
    {
        $this->ajax_request = $bool == TRUE;
    }
    
    /**
     * Template loading and setup routine.
     */
    public function __construct()
    {
		parent::__construct();

        // checke request is ajax
        $this->ajax_request = request::is_ajax();
        
        if ($this->auto_render == TRUE)
        {
            Event::add('system.post_controller', array($this, '_render'));
        }
        
        $session = Session::instance();
        $user = array();              
        $user = $session->get('user');

        if ( !empty($user))
        {
            $userobj = user::get_instance();
            $this->_user = $userobj->get($user['id']);
            $this->_user['user_money'] = $userobj->get_user_money($this->_user['id']);
            $this->_user['user_moneys'] = $userobj->get_user_moneys($this->_user['id']); 
            $this->_user['outstanding_plan'] = Plans_basicService::get_instance()->get_count_notend($this->_user['id']);
            if ($this->_user != null) {
            	$agentDao = Myagent::instance();
            	$this->_agent = $agentDao->get_by_user_id($this->_user['id']);
            	if ($this->_agent['flag'] == 2){
	            	$this->_user['agent'] = $this->_agent;
            	}
            }
//            print_r($this->_user);
        }
        unset($user);
        $data = array();
        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        $this->_site_config = $data;
    }
    
    /**
     * Render the loaded template.
     */
    public function _render(){
        if ($this->auto_render == TRUE && isset($this->template))
        {
			// Render the template when the class is destroyed
            $this->template->render(TRUE);
        }
    }
    
    protected function _ex(&$ex, $return_struct=array(), $request_data=array(), $view = 'info'){
        $return_struct['code'] = $ex->getCode();
        $return_struct['msg'] = $ex->getMessage();
        $return_struct['status'] = $return_struct['code']==200?1:0;
        
        $this->template = new View($view);
 
        //TODO 异常处理
        if($this->is_ajax_request()){
            $this->template->content = $return_struct;
        }else{
            $this->template->return_struct = $return_struct;
            $this->template->request_data = $request_data;
        }
    }
    
    /**
     *
     * 登录判断
     */
    public function islogin(){
    	$userobj = user::get_instance();
    	$check = $userobj->check_user_login();
    	return $check;
    }
    
} // End Template_Controller
