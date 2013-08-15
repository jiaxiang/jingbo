<?php
class Agent_Controller extends Template_Controller 
{
	public function __construct()
	{
		parent::__construct();
//        role::check('distribution_system_manage');
	}
	
	public function index() 
	{
		$user = $this->_user;
		if(!isset($user))
		{
			remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
		}
		$agentDao = Myagent::instance();
		$aAgent = $agentDao->get_by_user_id($this->_user['id']);
		if ($aAgent == null) 
		{
			remind::set(Kohana::lang('o_agent.agent_not_exists'),'error',request::referrer());
		}
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$view = new View('distribution/agent_detail', $data);
		$view->set('agent', $aAgent);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'agent_detail');
		$view->render(TRUE);
	}
	
	public function edit()
	{
		$user = $this->_user;
		if(!isset($user))
		{
			remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
		}
		$agentDao = Myagent::instance();
		$aAgent = $agentDao->get_by_user_id($this->_user['id']);
		if ($aAgent == null) 
		{
			remind::set(Kohana::lang('o_agent.agent_not_exists'),'error',request::referrer());
		}
		
		if($_POST) 
		{
            //标签过滤
            tool::filter_strip_tags($_POST);
            
            
			if(Myagent::instance($aAgent['id'])->edit($_POST))
			{
				remind::set(Kohana::lang('o_global.update_success'),'success','distribution/agent');
			}
			else
			{
				remind::set(Kohana::lang('o_global.update_error'),'error',request::referrer());
			}
		}
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$view = new View('distribution/agent_detail_edit', $data);
		$view->set('agent', $aAgent);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'agent_detail');
		$view->render(TRUE);
		
	}
}
?>