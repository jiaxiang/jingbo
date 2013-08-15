<?php defined('SYSPATH') OR die('No direct access allowed.');

class Settle_realtime_dtl_Controller extends Template_Controller 
{
	private $indexView;
	
	private $settleRTRptDtlDao;
	
	public function __construct()
	{
		parent::__construct();
//		role::check('distribution_system_manage');
		$this->indexView = new View("distribution/settle_realtime_dtl_list");
		$this->settleRTRptDtlDao = Mysettlerealtimerptdtl::instance();
	}
	public function index($settleId)
	{
		if (!isset($settleId))
		{
			remind::set(Kohana::lang('o_global.bad_request'), 'error', request::referrer());
		}
		
		$ticket_type = Kohana::config('ticket_type.type');
		
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
        		'masterid' => $settleId
            ),
            'orderby'       => $orderby,
            'limit'         => array(
                                'per_page'  =>$per_page,
                                'offset'    =>0
                                )
        );
        $query_struct['where']['agentid'] = $this->_user['id'];
		
		$sum1list = $this->settleRTRptDtlDao -> sum_items($query_struct);
//		$agentfromamtsum = $sum1list[0]['asum'];
		$clientretsum = $sum1list[0]['bsum'];
		if ($clientretsum == 0){
	        $sum1list = $this->settleRTRptDtlDao -> sum_items($query_struct,0);
//			/$agentfromamtsum = $sum1list[0]['asum'];
			$clientretsum = $sum1list[0]['bsum'];
		}
		
		$total = $this->settleRTRptDtlDao -> count_itmes_with_conditions($query_struct['where']);
        $this->pagination = new Pagination(array(
			'base_url'			=> url::current(),
			'uri_segment'		=> 'page',
			'total_items'		=> $total,
			'items_per_page'	=> $per_page,
//			'style'				=> 'digg'
			'query_string'      => 'page',
			'directory'			=> ''
		));
		$query_struct['limit']['offset'] = $this->pagination->sql_offset;
//        $dataList = Mysettlerealtimerptdtl::instance()->lists($query_struct);
        $dataList = $this->settleRTRptDtlDao->mylists($query_struct);
		
        
		foreach($dataList as $key=>$value)
		{
			if ($value['ticket_type'] != 0 && $value['ticket_type'] != 99){
				$dataList[$key]['ticket_type'] = $ticket_type[$value['ticket_type']];
			}else {
				$dataList[$key]['ticket_type'] = '';	
			}
			foreach($value as $k=>$v)
			{
				if(!is_numeric($v) && empty($v))
				{
					$dataList[$key][$k] = '无';
				}
			}
			
		}
		for ($i = 0; $i < count($dataList); $i++) 
		{
			$dataList[$i]['lastnameMark']
			= mb_substr($dataList[$i]['clientlastname'], 0, 2, 'utf-8').'****'
			.mb_substr($dataList[$i]['clientlastname'], mb_strlen($dataList[$i]['clientlastname'])-2, 2, 'utf-8');
		}
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->indexView->set('site_config', $data['site_config']);
		
		$this->indexView->set('clientretsum', $clientretsum);
		$this->indexView->set('dataList', $dataList);
//		$this->indexView->set('ticket_type', $ticket_type);
//		$this->indexView->set('today', date("Y-m-d",time()));
//		$this->indexView->set('yesterday', date("Y-m-d",time()-24*3600));
		$this->indexView->set_global('_user', $this->_user);
		$this->indexView->set_global('_nav', 'settle_realtime_rpt');
		$this->indexView->render(true);
	}
	public function qry($user_id_client)
	{
		$ticket_type = Kohana::config('ticket_type.type');
		
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
            'orderby'       => $orderby,
            'limit'         => array(
                                'per_page'  =>$per_page,
                                'offset'    =>0
                                )
        );
		/**
		 * 搜索
		 */
        if (isset($user_id_client))
        	$query_struct['where']['user_id'] = $user_id_client;
        $query_struct['where']['agentid'] = $this->_user['id'];
        $query_struct['where']['ag_settle_realtime_dtls.flag <>'] = 90;
        
		$search_arr = array('begintime','endtime','user_id','clientlastname','masterid');
		$query_struct['where']["settletime >"] = date('Y-m') . '-01 00:00:00';
		$query_struct['where']["settletime <"] = date('Y-m-d H:i:s');
		foreach($this->input->get() as $key=>$value)
		{
			if(in_array($key,$search_arr))
			{
				if($key == 'begintime')
				{
					$query_struct['where']["settletime >"] = $value . ' 00:00:00';
				}
				elseif($key == 'endtime')
				{
					$query_struct['where']["settletime <"] = $value . ' 24:00:00';
				}
				elseif($key == 'clientlastname' && !empty($value) )
				{
					$query_struct['where']["uuu.lastname ="] = $value;
				}
				elseif(!empty($value))
				{
					$query_struct['where'][$key] = $value;
				}
			}
		}
		$pre_get = $this->input->get();
		$sum1list = $this->settleRTRptDtlDao -> sum_items($query_struct);
//		$agentfromamtsum = $sum1list[0]['asum'];
		$clientretsum = $sum1list[0]['bsum'];
		if ($clientretsum == 0){
	        $sum1list = $this->settleRTRptDtlDao -> sum_items($query_struct,0);
//			/$agentfromamtsum = $sum1list[0]['asum'];
			$clientretsum = $sum1list[0]['bsum'];
		}
		
		$total = $this->settleRTRptDtlDao -> count_itmes_with_conditions($query_struct['where']);
        $this->pagination = new Pagination(array(
			'base_url'			=> url::current(),
			'uri_segment'		=> 'page',
			'total_items'		=> $total,
			'items_per_page'	=> $per_page,
//			'style'				=> 'digg'
			'query_string'      => 'page',
			'directory'			=> ''
		));
		$query_struct['limit']['offset'] = $this->pagination->sql_offset;
//        $dataList = Mysettlerealtimerptdtl::instance()->lists($query_struct);
        $dataList = $this->settleRTRptDtlDao->mylists($query_struct);
		
        
		foreach($dataList as $key=>$value)
		{
			if ($value['ticket_type'] != 0 && $value['ticket_type'] != 99){
				$dataList[$key]['ticket_type'] = $ticket_type[$value['ticket_type']];
			}else {
				$dataList[$key]['ticket_type'] = '';	
			}
			foreach($value as $k=>$v)
			{
				if(!is_numeric($v) && empty($v))
				{
					$dataList[$key][$k] = '无';
				}
			}
			
		}
		for ($i = 0; $i < count($dataList); $i++) 
		{
			$dataList[$i]['lastnameMark']
			= mb_substr($dataList[$i]['clientlastname'], 0, 2, 'utf-8').'****'
			.mb_substr($dataList[$i]['clientlastname'], mb_strlen($dataList[$i]['clientlastname'])-2, 2, 'utf-8');
		}
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->indexView->set('site_config', $data['site_config']);
		
		$this->indexView->set('clientretsum', $clientretsum);
		$this->indexView->set('dataList', $dataList);
		$this->indexView->set('pre_get', $pre_get);
//		$this->indexView->set('ticket_type', $ticket_type);
//		$this->indexView->set('today', date("Y-m-d",time()));
//		$this->indexView->set('yesterday', date("Y-m-d",time()-24*3600));
		$this->indexView->set_global('_user', $this->_user);
		$this->indexView->set_global('_nav', 'settle_realtime_rpt');
		$this->indexView->render(true);
	}
	public function delete($user_id)
	{
		//权限检查 得到所有可管理站点ID列表
//		role::check('distribution_system_manage');
	}
	public function add($userId)
	{
		//权限验证
//		role::check('distribution_system_manage');
	}
	public function edit($agentId)
	{
		//权限检查 得到所有可管理站点ID列表
//		role::check('distribution_system_manage');
	}
}
?>