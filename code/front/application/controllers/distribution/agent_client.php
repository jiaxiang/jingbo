<?php
class Agent_client_Controller extends Template_Controller 
{
	private $userDao;
	private $agentDao;
	private $relationDao;
	private $rtCTTDao;
	
	public function __construct()
	{
		parent::__construct();
//        role::check('distribution_system_manage');
		$this->userDao     = user::get_instance();
		$this->agentDao    = Myagent::instance();
		$this->relationDao = Myrelation::instance();
		$this->rtCTTDao    = MyRealtime_contract::instance();
	}
	
	public function index() 
	{
		//权限验证
//		role::check('distribution_system_manage');
		
		$user = $this->_user;
		if(!isset($user))
		{
			remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
		}
		$aAgent = $this->agentDao->get_by_user_id($this->_user['id']);
		if ($aAgent == null) 
		{
			remind::set(Kohana::lang('o_agent.agent_not_exists'),'error',request::referrer());
		}
		
		//排序
		$per_page = controller_tool::per_page();
        $orderby_arr= array
        (
                0   => array('id'=>'DESC'),
                1   => array('id'=>'ASC'),
                2   => array('order'=>'ASC'),
                3   => array('order'=>'DESC')
        );
        $orderby    = controller_tool::orderby($orderby_arr);
        $query_struct = array(
            'where'=>array(
            ),
            'orderby'       => $orderby,
            'limit'         => array(
                                'per_page'  =>$per_page,
                                'offset'    =>0
                                )
        );
        $query_struct['where']['agentid'] = $aAgent['user_id'];
        
		//搜索
		$search_arr = array('lastname','real_name','email','mobile','ip');
		$searchBox =array(
			'search_key' => null,
			'search_value' => null
		);
		$searchBox['search_key'] = $this->input->get('search_key');
		$searchBox['search_value'] = $this->input->get('search_value');
		if(in_array($searchBox['search_key'], $search_arr))
		{
			if($searchBox['search_key'] == 'ip') {
				$query_struct['like'][$value] = tool::myip2long($value);
			}
			elseif(!empty($searchBox['search_value'])) {
//				$query_struct['where'][$key] = $value;
				$query_struct['like'][$searchBox['search_key']] = $searchBox['search_value'];
			}
		}
		
		$total = $this->relationDao->count_agent_client($aAgent['user_id']);
		$this->pagination = new Pagination(array(
			'base_url'			=> url::current(),
			'uri_segment'		=> 'page',
			'total_items'		=> $total,
			'items_per_page'	=> $per_page,
//			'style'				=> 'digg',
			'query_string'      => 'page',
			'directory'			=> ''
		));
		
		$query_struct['limit']['offset'] = $this->pagination->sql_offset;
		$dataList = $this->relationDao->mylists($query_struct);
		for ($i = 0; $i < count($dataList); $i++) {
			$dataList[$i]['lastnameMark']
			= mb_substr($dataList[$i]['lastname'], 0, 2, 'utf-8').'****'
			.mb_substr($dataList[$i]['lastname'], mb_strlen($dataList[$i]['lastname'])-2, 2, 'utf-8');
			if ($dataList[$i]['client_type'] == 12 ) 
			{
				$cttWhere = array();
				$cttWhere['user_id']       = $dataList[$i]['id'];
				$cttWhere['contract_type'] = 0;
				$cttWhere['flag']          = 2;
				$contractList = $this->rtCTTDao->lists($cttWhere);
				foreach ($contractList as $aContract)
				{
					if ($aContract['type'] == 0) {
						$dataList[$i]['client_rate'] = $aContract['rate'];
					} else if ($aContract['type'] == 7) {
						$dataList[$i]['client_rate_beidan'] = $aContract['rate'];
					}
				}
			}
		}
		
		$data = array();
		$data['dataList'] = $dataList;
		$data['searchBox'] = $searchBox;
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$view = new View('distribution/agent_client_list', $data);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'agent_client');
		$view->render(TRUE);
	}
	
	public function edit($relationId)
	{
		$relation = $this->relationDao->get_by_id($relationId);
		if ($relation == null) 
		{
			remind::set(Kohana::lang('o_global.bad_request'),'error',request::referrer());
		}
		$agent = $this->userDao->get($relation['agentid']);
		$client = $this->userDao->get($relation['user_id']);
		
		$client['lastnameMark']
		= mb_substr($client['lastname'], 0, 2, 'utf-8').'****'
		.mb_substr($client['lastname'], mb_strlen($client['lastname'])-2, 2, 'utf-8');
		
		if($_POST) 
		{
			$errBox = array();
//			remind::widget();
			
			$client_rate = $_POST['client_rate'];
			$client_rate_beidan = $_POST['client_rate_beidan'];
			if ($client_rate == null || $client_rate_beidan == null) 
			{
				remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
			}
			
			// 数据范围检查
			if ($client_rate < 0 || $client_rate > 0.1) 
			{
				remind::set('普通返点率超出范围。','error',request::referrer());
			}
			if ($client_rate_beidan < 0 || $client_rate_beidan > 0.1) 
			{
				remind::set('北单返点率超出范围。','error',request::referrer());
			}
			
			// 将下级用户的返点率和代理的合约返点率做比较，client_rate < agent.rate
			$rtCttDao = MyRealtime_contract::instance();
			$query_struct = array(
				'where'=>array(
					'user_id'=>$agent['id'],
					'flag'   => 2
            	)
			);
			$cttList = $rtCttDao->lists($query_struct);
			
			foreach ($cttList as $contract) {
				if ($contract['type'] == 0 && 
					$contract['flag'] == 2 && 
					$contract['rate'] < $client_rate)
				{
					remind::set('普通返点率超出代理返点率。','error',request::referrer());
				}
				else if ($contract['type'] == 7 &&
					$contract['flag'] == 2 && 
					$contract['rate'] < $client_rate_beidan)
				{
					remind::set('北单返点率超出代理返点率。','error',request::referrer());
				}
			}
			
            //标签过滤
            tool::filter_strip_tags($_POST);
            
			if(Myrelation::instance($relationId)->edit($_POST))
			{
				remind::set(Kohana::lang('o_global.update_success'),'success','distribution/agent_client');
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
		
		$view = new View('distribution/agent_client_edit', $data);
		$view->set('client', $client);
		$view->set('relation', $relation);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'agent_client');
		$view->render(TRUE);
	}
}
?>