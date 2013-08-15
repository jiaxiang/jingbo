<?php
class Agent_realtime_contract_Controller extends Template_Controller 
{
	private $userDao;
	private $agentDao;
	private $relationDao;
	private $contractDao;
	
	public function __construct()
	{
		parent::__construct();
		$this->userDao = user::get_instance();
		$this->agentDao = Myagent::instance();
		$this->relationDao = Myrelation::instance();
		$this->contractDao = MyRealtime_contract::instance();
	}
	
	public function index() 
	{
		$relationId = null;
		$relation   = null;
		$client = null;
		$agent  = null;
        // set the query condition
		if ($_GET) 
		{
			$relationId = $_GET['relationId'];
		}
		if ($relationId == null || $relationId == '') 
		{
			remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
		}
		
		$relation = $this->relationDao->get_by_id($relationId);
		if ($relation == null) 
		{
			remind::set(Kohana::lang('o_relation.relation_not_exists'),'error',request::referrer());
		}
		
		$client = $this->userDao->get($this->_user['id']);
		$agent  = $this->userDao->get($relation['agentid']);
		
		$per_page = controller_tool::per_page();
        $orderby_arr = array
		(
			0   => array('id'=>'DESC'),
			1   => array('id'=>'ASC'),
			2   => array('order'=>'ASC'),
			3   => array('order'=>'DESC')
		);
        $orderby = controller_tool::orderby($orderby_arr);
        $query_struct = array(
            'where'   => array(),
            'orderby' => $orderby,
            'limit'   => array(
                                'per_page'  =>$per_page,
                                'offset'    =>0
                                )
        );
		$query_struct['where']['relation_id'] = $relationId;
		$query_struct['where']['contract_type'] = 2;
        
		$total = $this->contractDao->count_contracts_with_condition($query_struct['where']);
        $this->pagination = new Pagination(array(
			'base_url'			=> url::current(),
			'uri_segment'		=> 'page',
			'total_items'		=> $total,
			'items_per_page'	=> $per_page,
			'style'				=> 'digg',
			'query_string'      => 'page',
			'directory'			=> ''
		));
		$query_struct['limit']['offset'] = $this->pagination->sql_offset;
        $contractList = $this->contractDao->lists($query_struct);
        
		$data = array();
		$data['contractList'] = $contractList;
		$data['relation']     = $relation;
		$data['agent']        = $agent;
		$data['client']       = $client;
		
		$view = new View('distribution/agent_realtime_contract_list', $data);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'month_contact');
		$view->render(TRUE);
	}
	
	public function add($relationId)
	{
		//权限检查 得到所有可管理站点ID列表
		
		if ($relationId == null || $relationId == '') 
		{
			remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
		}
		
		$theRelation = $this->relationDao->get_by_id($relationId);
		if ($theRelation == null) 
		{
			remind::set(Kohana::lang('o_relation.relation_not_exists'),'error',request::referrer());
		}
		
		$client = $this->userDao->get($theRelation['user_id']);
		$agent  = $this->userDao->get($theRelation['agentid']);
		
		//确定 agent还可以给下级用户分配多少返点率
		$rate_ability_array = $this->getAgentRateAbility($agent['id']);
		if($rate_ability_array == null){
			remind::set('请为上级代理设置合约','error',request::referrer());
		}
		
		if($_POST) 
		{
			$data = $_POST;
			$data['relation_id']   = $_POST['relationId']; 
			$data['agent_id']      = $_POST['agentId']; 
			$data['user_id']       = $_POST['clientId']; 
			$data['contract_type'] = $_POST['contractType']; 
			$data['type']          = $_POST['type'];
			$data['rate_ability']  = $_POST['rateAbility'];
			$data['rate']          = $_POST['rate'];
			$data['taxrate']       = 0.000;
			$data['flag']          = 0;
			$data['createtime']    = date("Y-m-d H:i:s",time());
			$data['starttime']     = date("Y-m-d H:i:s",time());
			$data['lastsettletime'] = date("Y-m-d H:i:s",time());
			
			//标签过滤
            tool::filter_strip_tags($data);
            
			if($this->contractDao->add($data))
			{
				remind::set(Kohana::lang('o_global.add_success'),'success','distribution/agent_realtime_contract/index?relationId='.$relationId);
			}
			else
			{
				remind::set(Kohana::lang('o_global.add_error'),'error',request::referrer());
			}
		}
		
		$data = array();
		$data['relation'] = $theRelation;
		$data['agent']    = $agent;
		$data['client']   = $client;
		$data['rate_ability_array'] = $rate_ability_array;
		
		//设置异常警告
		$remind_data = remind::get();
		if($remind_data){
			$error_data = $remind_data['error'];
			$data['error'] = $error_data[0];
		}
		
		$view = new View('distribution/agent_realtime_contract_add', $data);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'month_contact');
		$view->render(TRUE);
	}
	
	public function detail($contractId)
	{
		//权限检查 得到所有可管理站点ID列表
//		role::check('distribution_system_manage');
		
		$contractDao = MyMonth_contract::instance();
		$contract = $contractDao->get_by_id($contractId);
		if ($contract == null) 
		{
			remind::set(Kohana::lang('o_contract.contract_not_exists'),request::referrer(),'error');
		}
		$agent  = user::get_instance()->get($contract['agent_id']);
		$client = user::get_instance()->get($contract['user_id']);
		
		$cttDetailDao = MyMonth_contract_detail::instance();
		$detailSearchStruct = array();
		$detailSearchStruct['where'] = array(
			'contract_id' => $contractId
		);
		$contactDetailList = $cttDetailDao->lists($detailSearchStruct);
		for ($i=0; $i<count($contactDetailList); $i++) 
		{
			$contactDetailList[$i]['index'] = $i;
		}
		
//		$this->template->content = new View("distribution/client_month_contract_detail");
//		$this->template->content->contract = $contract;
//		$this->template->content->agent    = $agent;
//		$this->template->content->client   = $client;
//		$this->template->content->data = $contactDetailList;
		
		$data = array();
		$data['contract'] = $contract;
		$data['contractDetailList'] = $contactDetailList;
		$data['agent']    = $agent;
		$data['client']   = $client;
		
		$view = new View('distribution/client_month_contract_detail', $data);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'month_contact');
		$view->render(TRUE);
	}
	
	public function delete($contractId)
	{
		//权限检查 得到所有可管理站点ID列表
//		role::check('distribution_system_manage');
		
		$contract = $this->contractDao->get_by_id($contractId);
		if ($contract == null) 
		{
			remind::set('合约不存在','error',request::referrer());
		}
		if ($contract['flag'] == 2) {
			remind::set('不能删除生效中的合约','error',request::referrer());
		}
		
		if($this->contractDao->delete($contractId))
		{
			remind::set(Kohana::lang('o_global.delete_success'),'success','distribution/agent_realtime_contract/?relationId='.$contract['relation_id']);
		}
		else 
		{
			remind::set(Kohana::lang('o_global.delete_error'),'error','distribution/agent_realtime_contract/?relationId='.$contract['relation_id']);
		}
	}

	public function open($contractId)
	{
		//权限验证
//		role::check('distribution_system_manage');
		if(!$contractId)
		{
			remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
		}
		$aContract = $this->contractDao->get_by_id($contractId);
		if ($aContract == null) {
			remind::set(Kohana::lang('o_contract.contract_not_exists'), 'error', request::referrer());
		}
		
		//检查月结合约 （类型与当前合约一致）
		$searchStruct = array();
		$searchStruct['where'] = array(
			'agent_id' => $aContract['agent_id'],
			'user_id'  => $aContract['user_id'],
			'type'     => $aContract['type'],
			'flag'     => 2
		);
		$contractList = $this->contractDao->lists($searchStruct);
		if ( count($contractList) > 0 ) {
			remind::set('合约已经存在', 'error', request::referrer());
		}
		
		$aContract['flag'] = 2;
		if ($this->contractDao->edit($aContract))
		{
			remind::set(Kohana::lang('o_global.update_success'),'success',request::referrer());
		}
		else 
		{
			remind::set(Kohana::lang('o_global.update_error'),'error',request::referrer());
		}
	}
	
	public function close($contractId)
	{
		//权限验证
//		role::check('distribution_system_manage');
		if(!$contractId)
		{
			remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
		}
		$aContract = $this->contractDao->get_by_id($contractId);
		if ($aContract == null) {
			remind::set('合约不存在', 'error', request::referrer());
		}
		
		$aContract['flag'] = 0;
		if ($this->contractDao->edit($aContract))
		{
			remind::set(Kohana::lang('o_global.update_success'),'success',request::referrer());
		}
		else 
		{
			remind::set(Kohana::lang('o_global.update_error'),'error',request::referrer());
		}
	}
	
	/**
	 * get the agent's rate return ability.
	 * Return the MAX rate which the agent can give to his client. 
	 * @param int $agentId
	 * @return 
	 * array() => 
	 * {
	 * 		0 => 0.02	//普通返点率
	 * 		7 => 0.03	//北单返点率
	 * }
	 */
	public function getAgentRateAbility($agentId)
	{
		$query_struct = array(
			'where' => array()
		);
		$query_struct['where']['user_id'] = $agentId;
		$query_struct['where']['flag'] = 2;
		$contractList = $this->contractDao->lists($query_struct);
		
		$return = array();
		foreach ($contractList as $aContract)
		{
			$return[$aContract['type']] = $aContract['rate'];
		}
		return $return;
	}
	
	public function template_reference($userId)
	{
		$templateDao = MyMonth_contract_template::instance();
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
            'where'=>array(),
            'orderby'       => $orderby,
            'limit'         => array(
                                'per_page'  =>$per_page,
                                'offset'    =>0
                                )
        );
        $total = $templateDao -> count_templates();
        $this->pagination = new Pagination(array(
			'base_url'			=> url::current(),
			'uri_segment'		=> 'page',
			'total_items'		=> $total,
			'items_per_page'	=> $per_page,
			'style'				=> 'digg'
		));
		$query_struct['limit']['offset'] = $this->pagination->sql_offset;
        $contractList = $templateDao->lists($query_struct);
		
		$this->template->content = new View("distribution/month_template_reference");
		$this->template->content->data = $contractList;
		$this->template->content->userId = $userId;
	}
	
	public function template_use($userId, $templateId)
	{
		$agentDao = Myagent::instance();
		$agent = $agentDao->get_by_user_id($userId);
		if ($agent == null) 
		{
			remind::set(Kohana::lang('o_agent.agent_not_exists'),'error',request::referrer());;
		}
		
		$mtTemplateDao = MyMonth_contract_template::instance();
		$template = $mtTemplateDao->get_by_id($templateId);
		if ($template == null) 
		{
			remind::set(Kohana::lang('o_contract.contract_not_exists'),'error',request::referrer());;
		}
		
		$mtDtlTemplateDao = MyMonth_contract_detail_template::instance();
		$searchStruct = array();
		$searchStruct['where'] = array(
			'contract_id' => $templateId
		);
		$dtlTemplateList = $mtDtlTemplateDao->lists($searchStruct);
		
//		tool::filter_strip_tags($data);
            
		$mtContractDao = MyMonth_contract::instance();
		$mtContractDtlDao = MyMonth_contract_detail::instance();
		
		$contract = array();
		$contract['user_id'] = $agent['user_id'];
		$contract['flag']    = 0;
		$contract['type']    = $template['type'];
		$contract['taxrate'] = $template['taxrate'];
		$contract['createtime'] = date("Y-m-d H:i:s",time());
		$contract['starttime']  = date("Y-m-d H:i:s",time());
		$contract['lastsettletime'] = date("Y-m-d H:i:s",time());
		$contract['note']    = null;
		
		if($contractId = $mtContractDao->add($contract))
		{
			foreach ($dtlTemplateList as $aDtlTemplate) 
			{
				$contractDtl = array();
				$contractDtl['contract_id'] = $contractId;
				$contractDtl['createtime'] = date("Y-m-d H:i:s",time());
				$contractDtl['minimum'] = $aDtlTemplate['minimum'];
				$contractDtl['maximum'] = $aDtlTemplate['maximum'];
				$contractDtl['rate']    = $aDtlTemplate['rate'];
				$mtContractDtlDao->add($contractDtl);
			}
			remind::set(Kohana::lang('o_global.add_success'),'success','distribution/client_month_contract/index/'.$userId);
		}
		else
		{
			remind::set(Kohana::lang('o_global.add_error'),'error',request::referrer());
		}
		
	}
}
?>