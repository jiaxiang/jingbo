<?php defined('SYSPATH') or die('No direct access allowed.');

class Playmethod_Controller extends Template_Controller{
	
	public function __construct(){
		parent::__construct();
		}
	
	public function index(){
		
		$playmethod = Mynews::instance();
		$get_page = intval($this->input->get('page'));
		$page = !empty( $get_page ) ? intval($get_page) : "1";//页码
		$total_rows="12";//第页显示条数	
        $total = $playmethod->count_site_news(22);
		//$config['base_url'] = "/news/recommend/";
		$config['total_items'] = $total;//总数量
		$config['query_string']  = 'page';
		$config['items_per_page']  = $total_rows;	//每页显示多少第		
		$config['uri_segment']  = $page;//当前页码	
		$config['directory']  = "";//样式路径	
		
		$query_struct = array(
				'where'		=>	array('classid'=>22),
				'orderby'	=>	array('created'=>'desc','id'=>'desc'),
				'limit'		=>	array('per_page'=>$total_rows,'offset'=>$page)
				);
		$this->pagination = new Pagination($config);
		$this->pagination->initialize();
		$query_struct['limit']['offset'] = $this->pagination->sql_offset;
		
		$data['recommend'] = Mynews::instance()->lists($query_struct);
		
		//start
		$query_struct = array(
            'where'=>array(
                'list1' => 1,
            ),
            'orderby'   => array(
			   'order'=>'asc',
               'id'=>'DESC',
            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$data['list1'] = Mynews::instance()->list_news_num($query_struct);
		
		$query_struct = array(
            'where'=>array(
                'list2' => 1,
            ),
            'orderby'   => array(
			   'order'=>'asc',
               'id'=>'DESC',
            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$data['list2'] = Mynews::instance()->list_news_num($query_struct);
		//end
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$this->template = new View('news/playmethod',$data);
		$this->template ->set_global('_topnav','is_wanfajieshao');
		$this->template->set_global('_user', $this->_user);
		$this->template->render(true);
		}
	
	} 