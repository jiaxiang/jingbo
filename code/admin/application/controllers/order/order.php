<?php defined('SYSPATH') OR die('No direct access allowed.');

class Order_Controller extends Template_Controller {
    // Set the name of the template to use
    public $template_ = 'layout/common_html';

    public function __construct()
    {
        parent::__construct();
        if($this->is_ajax_request()==TRUE)
        {
            $this->template = new View('layout/default_json');
        }
    }

	/**
	 * 订单列表
	 */
	public function index($status = NULL) {
	    /* 权限检查 订单列表 */
	    if ($status == 'invalid')
	    {
	        role::check('ticket_num_invalid');
	    }
	    else
	    {
	        role::check('order_list');
	    }
	    
	    $time_expired = 60*60*2;    //将要过期时间
	    $time_delay = 5*60;         //过期延迟显示时间
        
	    //$mklasttime = mktime(date("H"), date("i"), date("s"), date("m"), date("d")-5, date("Y"));
	    //$last_time = date('Y-m-d H:i:s', $mklasttime);
	    
        //初始化默认查询结构体 
        $query_struct_default = array (
            'where' => array (
                'plan_type' => array(0,1),
            	//'date_end >=' => tool::get_date(),
            ),
            'orderby' => array (
                'id' => 'DESC' 
            ), 
            
            'limit' => array (
                'per_page' => 10,
                'page' => 1
            )
        );
        
        if (!empty($status))
        {
            switch ($status)
            {
                case 'hasbuy':
                    $query_struct_default['where']['status'] = 0;
                    break;
                case 'noprint':
                    $query_struct_default['where']['status'] = 1;
                    break;
                case 'beexpired':
                    $query_struct_default['where']['date_end <'] = date("Y-m-d H:i:s", (time() + $time_expired));  //当离方案截止时间小于2小时时为将要到期  
                    $query_struct_default['where']['date_end >'] = tool::get_date();
                    break;
                case 'hasexpired':
                    $query_struct_default['where']['date_end <'] = date("Y-m-d H:i:s", (time() + $time_delay));
                    $query_struct_default['where']['status'] = array(0);
                    break;
                case 'hasprint':
                    $query_struct_default['where']['status'] = 2;
                    break;
                case 'nobonus':
                    $query_struct_default['where']['status'] = 3;
                    break;
                case 'hasbonus':
                    $query_struct_default['where']['status'] = 4;
                    break;
                case 'givehonus':
                    $query_struct_default['where']['status'] = 5;
                    break;
                case 'cancel':
                    $query_struct_default['where']['status'] = 6;
                    break;
                default:
            }
        }
        
        //d($query_struct_default);
        
        
		/* 搜索功能 */
		$search_arr      = array('id','order_num','lastname','plan_type','ticket_type');
		$search_value    = $this->input->get('search_value');
		$search_type     = $this->input->get('search_type');
		$where_view      = array();
		//$query_struct_default['where']['date_end >='] = tool::get_date();
		if (strlen($this->input->get('start_time')) > 0) {
			$query_struct_default['where']['date_add >='] = $this->input->get('start_time').' 00:00:00';
			$where_view['start_time'] = $this->input->get('start_time');
		}
		if (strlen($this->input->get('end_time')) > 0) {
			$query_struct_default['where']['date_add <='] = $this->input->get('end_time').' 00:00:00';
			$where_view['end_time'] = $this->input->get('end_time');
		}
		if($search_arr)
		{
			foreach($search_arr as $value)
			{
				if($search_type == $value && strlen($search_value) > 0)
				{
					if ($value == 'lastname') {
						$userobj = user::get_instance();
						$userinfo = $userobj->get_search($search_value);
						$userid = $userinfo['id'];
						$query_struct_default['where']['start_user_id'] = $userid;
						$query_struct_default['where']['user_id'] = $userid;
					}
					else {
					 	$query_struct_default['like'][$value] = $search_value;
					}
				}
			}
			$where_view['search_type'] = $search_type;
			$where_view['search_value'] = $search_value;
		}
		
		$request_data = $this->input->get();
        
        //初始化当前查询结构体 
        $query_struct_current = array();
                
        //设置合并默认查询条件到当前查询结构体 
        $query_struct_current = array_merge($query_struct_current, $query_struct_default);

        //列表排序
        $orderby_arr = array (
            0 => array (
                'id' => 'DESC' 
            ), 
            1 => array (
                'id' => 'ASC' 
            ),
        );
        $orderby = controller_tool::orderby($orderby_arr);
        // 排序处理 
        if(isset($request_data['orderby']) && is_numeric($request_data['orderby'])){
            $query_struct_current['orderby'] = $orderby;
        }
        $query_struct_current['orderby'] = $orderby;
        
        //每页条目数
        controller_tool::request_per_page($query_struct_current, $request_data);
        
        //调用服务执行查询
        $plan_basicobj = Plans_basicService::get_instance();
        $return_data['count'] = $plan_basicobj->count($query_struct_current);        //统计数量
        
		/* 调用分页 */
		$this->pagination = new Pagination(array(
			'total_items'    => $return_data['count'],
			'items_per_page' => $query_struct_current['limit']['per_page'],    
		));

        $query_struct_current['limit']['page'] = $this->pagination->current_page;
        $return_data['list'] = $plan_basicobj->query_assoc($query_struct_current);
        $return_data['ticket_type'] = Kohana::config('ticket_type');

        $planobj = plan::get_instance();
        
        $i = 0;
        foreach ($return_data['list'] as $rowlist)
        {
            $planobj->get_result($return_data['list'][$i]);
            if(empty($return_data['list'][$i]['detail'])) {
                unset($return_data['list'][$i]);
            }
            $i++;
        }
        //d($return_data['list']);
        
        $return_data['status'] = $status;
        $return_data['time_expired'] = $time_expired;
        
        //d($return_data['list']);
        
        $return_data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$return_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$return_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$return_data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        
		$this->template->content = new View("order/order_index", $return_data);
		$this->template->content->where = $where_view;
	}
	
	
	/*
	 * 设置彩票为已作废
	 */
	public function set_invalid()
	{
	    /* 权限检查 订单列表 */
        role::check('order_cancel');
        $request_data = $this->input->post();
        
        if (empty($_POST))
        {
            remind::set(Kohana::lang('o_global.bad_request'),'/order/order/index/'.$request_data['backurl']);
        }
        
        if (empty($request_data['order_ids'][0]))
        {
            remind::set(Kohana::lang('o_global.bad_request'),'order/order/index/'.$request_data['backurl']);
        }
        $id = $request_data['order_ids'][0];
        
        $planobj = plan::get_instance();
        
        $result = Plans_basicService::get_instance()->get($id);
        
        //d($result, false);
        //$planobj->get_result($result);
        //d($result);
        
        if ($result['status'] != 0  &&  (strtotime($result['date_end']) > time()))
        {
            remind::set(Kohana::lang('o_global.bad_request'),'order/order/index/'.$request_data['backurl']);
        }
        $planobj->cancel_plan($result['order_num']);
        //$money = $result['plan_buyed'] * $result['plan_priceone'];
        //退款操作
        //$num = $planobj->refund_plan($result['ticket_type'], $result['order_num'], $money);
        //更新状态
        //$planobj->update_status_by_ordernum($result['order_num'], 6);

        //添加日志
        $logs_data = array();
        $logs_data['manager_id'] = $this->manager_id;
        $logs_data['user_log_type'] = 28;
        $logs_data['ip'] = tool::get_long_ip();
        $logs_data['memo'] = "成功取消订单{$result['order_num']}";
        ulog::instance()->add($logs_data);
        
        remind::set("成功取消订单{$result['order_num']}",'/order/order/index/'.$request_data['backurl'],'success');
	}


	/*
	 * 派奖
	 */
	public function set_givebonus()
	{
	    /* 权限检查 订单列表 */
        role::check('order_givehonus');
        $request_data = $this->input->post();
        
        if (empty($_POST))
        {
            remind::set(Kohana::lang('o_global.bad_request'),'/order/order/index/'.$request_data['backurl']);
        }
        
        if (empty($request_data['order_ids'][0]))
        {
            remind::set(Kohana::lang('o_global.bad_request'),'order/order/index/'.$request_data['backurl']);
        }
        $id = $request_data['order_ids'][0];
        
        $planobj = plan::get_instance();
        
        $result = Plans_basicService::get_instance()->get($id);
        $planobj->get_result($result);
        
        if ($result['status'] != 4)
        {
            remind::set(Kohana::lang('o_global.bad_request'),'order/order/index/'.$request_data['backurl']);
        }
        
	    if ($result['status'] <= 0)
        {
            remind::set(Kohana::lang('o_global.bad_request'),'order/order/index/'.$request_data['backurl']);
        }
        
        //退款操作
        $num = $planobj->bonus_plan($result['order_num']);
        
        //更新状态
        ///$planobj->update_status_by_ordernum($result['order_num'], 5);
 
        //添加日志
        $logs_data = array();
        $logs_data['manager_id'] = $this->manager_id;
        $logs_data['user_log_type'] = 28;
        $logs_data['ip'] = tool::get_long_ip();
        $logs_data['memo'] = "成功派奖{$result['order_num']}";
        ulog::instance()->add($logs_data);
        
        remind::set("成功派奖{$result['order_num']}",'/order/order/index/'.$request_data['backurl'],'success');
	}	
	
	public function zc_r98() {
		/* 权限检查 订单列表 */
		role::check('order_list');
		$time_expired = 60*60*2;    //将要过期时间
		$time_delay = 5*60;         //过期延迟显示时间
		//初始化默认查询结构体
		$query_struct_default = array (
				'where' => array (
						'parent_id' => 0,
						'r98_jj' => 1,
						'ticket_type' => 2,
						'play_method' => 2,
				),
				'orderby' => array (
						'id' => 'DESC'
				),
	
				'limit' => array (
						'per_page' => 10,
						'page' => 1
				)
		);
		/* 搜索功能 */
		$search_arr      = array('id','order_num','lastname','plan_type','ticket_type');
		$search_value    = $this->input->get('search_value');
		$search_type     = $this->input->get('search_type');
		$where_view      = array();
		//$query_struct_default['where']['date_end >='] = tool::get_date();
		if (strlen($this->input->get('start_time')) > 0) {
			$query_struct_default['where']['date_add >='] = $this->input->get('start_time').' 00:00:00';
			$where_view['start_time'] = $this->input->get('start_time');
		}
		if (strlen($this->input->get('end_time')) > 0) {
			$query_struct_default['where']['date_add <='] = $this->input->get('end_time').' 00:00:00';
			$where_view['end_time'] = $this->input->get('end_time');
		}
		if($search_arr)
		{
			foreach($search_arr as $value)
			{
				if($search_type == $value && strlen($search_value) > 0)
				{
					if ($value == 'lastname') {
						$userobj = user::get_instance();
						$userinfo = $userobj->get_search($search_value);
						$userid = $userinfo['id'];
						$query_struct_default['where']['start_user_id'] = $userid;
						$query_struct_default['where']['user_id'] = $userid;
					}
					else {
						$query_struct_default['like'][$value] = $search_value;
					}
				}
			}
			$where_view['search_type'] = $search_type;
			$where_view['search_value'] = $search_value;
		}
	
		$request_data = $this->input->get();
	
		//初始化当前查询结构体
		$query_struct_current = array();
	
		//设置合并默认查询条件到当前查询结构体
		$query_struct_current = array_merge($query_struct_current, $query_struct_default);
	
		//列表排序
		$orderby_arr = array (
				0 => array (
						'id' => 'DESC'
				),
				1 => array (
						'id' => 'ASC'
				),
		);
		$orderby = controller_tool::orderby($orderby_arr);
		// 排序处理
		if(isset($request_data['orderby']) && is_numeric($request_data['orderby'])){
			$query_struct_current['orderby'] = $orderby;
		}
		$query_struct_current['orderby'] = $orderby;
	
		//每页条目数
		controller_tool::request_per_page($query_struct_current, $request_data);
		//d($query_struct_current);
		//调用服务执行查询
		$plan_basicobj = Plans_sfcService::get_instance();
		$return_data['count'] = $plan_basicobj->count($query_struct_current);        //统计数量
	
		/* 调用分页 */
		$this->pagination = new Pagination(array(
				'total_items'    => $return_data['count'],
				'items_per_page' => $query_struct_current['limit']['per_page'],
		));
	
		$query_struct_current['limit']['page'] = $this->pagination->current_page;
		$return_data['list'] = $plan_basicobj->query_assoc($query_struct_current);
		$return_data['ticket_type'] = Kohana::config('ticket_type');
	
		$planobj = plan::get_instance();
	
		$i = 0;
		foreach ($return_data['list'] as $rowlist)
		{
			$return_data['list'][$i]['order_num'] = $return_data['list'][$i]['basic_id'];
			$return_data['list'][$i]['date_add'] = $return_data['list'][$i]['time_stamp'];
			$return_data['list'][$i]['date_end'] = $return_data['list'][$i]['time_end'];
			$planobj->get_result($return_data['list'][$i]);
			if(empty($return_data['list'][$i]['detail'])) {
				unset($return_data['list'][$i]);
			}
			$i++;
		}
	
		$return_data['status'] = 'r98';
		$return_data['time_expired'] = $time_expired;
	
		//d($return_data['list']);
	
		$return_data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$return_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$return_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$return_data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		//var_dump($return_data);
		$this->template->content = new View("order/order_index", $return_data);
		$this->template->content->where = $where_view;
	}
	
}