<?php
class Month_contract_Controller extends Template_Controller 
{
	public function __construct()
	{
		parent::__construct();
//        role::check('distribution_system_manage');
	}
	
	public function index() 
	{
		$user = user::get_instance()->get($this->_user['id']);
		
		$contractDao = MyMonth_contract::instance();
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
        		'user_id' => $user['id'],
        		'flag'    => 2
            ),
            'orderby'       => $orderby,
            'limit'         => array(
                                'per_page'  =>$per_page,
                                'offset'    =>0
                                )
        );
//        $total = $contractDao -> count_contracts();
        $total = $contractDao -> count_contracts_with_condition($query_struct['where']);
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
        $contractList = MyMonth_contract::instance()->lists($query_struct);
		
//		$this->template->content = new View("distribution/month_contract_list");
//		$this->template->content->data = $contractList;
//		$this->template->content->user = $user;
		
        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        
        $view = new View('distribution/month_contract_list', $data);
		$view->set('dataList', $contractList);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'month_contact');
		$view->render(TRUE);
	}
	
	public function detail($contractId)
	{
		$contractDao = MyMonth_contract::instance();
		$contract = $contractDao->get_by_id($contractId);
		
		$cttDtlDao = MyMonth_contract_detail::instance();
		$detailSearchStruct = array();
		$detailSearchStruct['where'] = array(
			'contract_id' => $contractId
		);
		$cttDtlList = $cttDtlDao->lists($detailSearchStruct);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$view = new View('distribution/month_contract_dtl', $data);
		$view->set('contract', $contract);
		$view->set('cttDtlList', $cttDtlList);
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'month_contact');
		$view->render(TRUE);
	}
	
}
?>