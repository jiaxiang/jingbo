<?php
class Settle_realtime_rpt_Controller extends Template_Controller 
{
	public function __construct()
	{
		parent::__construct();
//        role::check('distribution_system_manage');
	}
	public function index()
	{
		$settlerealtimerptDao = Mysettlerealtimerpt::instance();
		$agent_type = Kohana::config('settle.agent_type');
		$isbeidan = Kohana::config('settle.isbeidan');
		
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
        $query_struct['where']['user_id'] = $this->_user['id'];
        $query_struct['where']['fromamt !='] = 0;
        
		/**
		 * 搜索
		 */
//		$search_arr = array('type','agent_type','date_begin','date_end','user_id','lastname');
//		foreach($this->input->get() as $key=>$value)
//		{
//			if(in_array($key,$search_arr))
//			{
//				if($key == 'date_begin')
//				{
//					$query_struct['where']["settletime >"] = $value . ' 00:00:00';
//				}
//				elseif($key == 'date_end')
//				{
//					$query_struct['where']["settletime <"] = $value . ' 24:00:00';
//				}
//				elseif($key == 'isbeidan')
//				{
//					$query_struct['where']["type"] = $value;
//				}
//				elseif(!empty($value))
//				{
//					$query_struct['where'][$key] = $value;
//				}
//			}
//		}
		
        $total = $settlerealtimerptDao -> count_itmes_with_condition($query_struct['where']);
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
//        $dataList = Mysettlerealtimerpt::instance()->lists($query_struct);
        $dataList = Mysettlerealtimerpt::instance()->mylists($query_struct);
		
		foreach($dataList as $key=>$value)
		{
			$dataList[$key]['agent_type'] = $agent_type[$value['agent_type']];
			$dataList[$key]['type'] = $isbeidan[$value['type']];
			foreach($value as $k=>$v)
			{
				if(!is_numeric($v) && empty($v))
				{
					$dataList[$key][$k] = '无';
				}
			}
		}
//		$this->template->content = new View("distribution/settle_realtime_rpt");
//		$this->template->content->data = $dataList;
//		$this->template->content->agent_type = $agent_type;
//		$this->template->content->isbeidan = $isbeidan;
//		$this->template->content->today = date("Y-m-d",time());
//		$this->template->content->yesterday = date("Y-m-d",time()-24*3600);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$view = new View('distribution/settle_realtime_rpt_list', $data);
		$view->set('dataList', $dataList);
//		$view->set('agent_type', $agent_type);
//		$view->set('isbeidan', $isbeidan);
//		$view->set('today', date("Y-m-d",time()));
//		$view->set('yesterday', date("Y-m-d",time()-24*3600));
		$view->set_global('_user', $this->_user);
		$view->set_global('_nav', 'settle_realtime_rpt');
		$view->render(TRUE);
	}

}
?>