<?php defined('SYSPATH') OR die('No direct access allowed.');

class News_Controller extends Template_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 新闻详情
	 */
	public function view()
	{
		$news_id = $this->uri->segment(3);
		$news = Mynews::instance($news_id)->get();

		if(!$news['id'])
		{
			url::redirect('404');
		}
		$content = new  View('/news/index');
		$content->data = $news;
		$this->template->content = $content; 
	}

	/**
	 * 得到新闻列表
	 */
	public function index()
	{
		$view = new  View('/news/index');
		$view->set_global('_topnav','is_news');
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);

        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        $view->set('site_config', $data['site_config']);
        
		//新闻页推荐
        $query_struct = array(
            'where'=>array(
                'newstj' => 1,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
            ),
            'limit'=> array(
                'per_page'  =>6,
                'offset'    =>0,
            ),
        );
		$newstj = Mynews::instance()->list_news_num($query_struct);
		$view->set("newstj",$newstj); 
		
		//开奖信息
		$query_struct_kaijiang = array(
				'where'		=>	array('classid'=>20),
				'orderby'	=>	array('order'=>'asc','created'=>'desc'),
				'limit'		=>	array('per_page'=>5,'offset'=>0)
				);
		$kaijiang = Mynews::instance()->lists($query_struct_kaijiang);
		$view->set('kaijiang',$kaijiang);
		
		//彩客名人
		$query_struct = array(
            'where'=>array(
                'classid' => 5,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$news_ck = Mynews::instance()->list_news_num($query_struct);
		$view->set("news_ck",$news_ck);
		//体育新闻
		$query_struct = array(
            'where'=>array(
                'classid' => 6,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
            ),
            'limit'=> array(
                'per_page'  =>10,
                'offset'    =>0,
            ),
        );
		$news_ty = Mynews::instance()->list_news_num($query_struct);
		$view->set("news_ty",$news_ty);
		
		//彩票新闻;
		$news_list=array();
		$news_list_id=array(12,13,14,15,16,17,18,19);
		foreach($news_list_id as $v){
			$query_struct = array(
				'where'=>array(
					'classid' => $v,
				),
				'orderby'   => array(
				   'order'=>'asc',
				    'created'=>'desc',
				),
				'limit'=> array(
					'per_page'  =>10,
					'offset'    =>0,
				),
			);
			$news_list[$v] = Mynews::instance()->list_news_num($query_struct);
		}
		$view->set("news_list",$news_list);
		$view->set("news_list_id",$news_list_id); 
		$view->render(TRUE);
	}
	//新闻详细页
	public function news_detaile($id,$play=''){
		$view = new  View('/news/news_detaile');
		$view->set_global('_topnav','is_news');
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);
        
        $data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$view->set('site_config', $data['site_config']);
		
		$click = Mynews::instance()->news_update($id);
		if(!$click)
		{
			url::redirect('404');
		}
		$query_struct = array(
            'where'=>array(
                'id' =>$id,
            ),
        );
		$news_infor = Mynews::instance()->list_news_num($query_struct);
		//print_r($news_infor);die;
		if($news_infor[0]['classid']==21){
			$view->set_global('_topnav','is_zhuanjia');
		}
		if(count($news_infor)<1)
		{
			url::redirect('404');
		}
		//获取上一条记录
		$query_previous = array(
            'where'=>array(
                'classid' =>$news_infor[0]['classid'],
				'id <'      => $id
            ),
			'orderby'   => array(
				    'created'=>'desc',
				),
        );
		$query_next = array(
            'where'=>array(
                'classid' =>$news_infor[0]['classid'],
				'id >'      => $id
            ),
			'orderby'   => array(
				   'id'=>'asc',
				),
        );
		$previous = Mynews::instance()->list_news_num($query_previous);
		$next=Mynews::instance()->list_news_num($query_next);
		$view->set("news_infor",$news_infor); 
		$view->set("next",$next); 
		$view->set("previous",$previous); 
		//关键字 相关资讯
		$key=explode("|",$news_infor[0]['key']);
		$view->set("key",$key);
		//print_r($key);
		$arr=array();
		if($key){
			$str='';
			foreach($key as $k=>$v){
				if($k==0){
					$str .='title like "%'.$v.'%"';	
					}else{
				$str .='or title like "%'.$v.'%"';	
					}
				$str .='or content like "%'.$v.'%"';	
				}	
		
        $db = new Database();
        $result = $db->query(' SELECT * FROM news where id!="'.$id.'" and ('.$str.') order by id desc limit 0,6')->as_array();
			foreach ($result as $row)
			{
				$arr[] = ((array)$row);
			}
		}		
		$view->set("news_xg",$arr); 
		
		
		//右边列表
		$query_struct = array(
            'where'=>array(
                'list1' => 1,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$list1 = Mynews::instance()->list_news_num($query_struct);
		$view->set("list1",$list1); 
		
		$query_struct = array(
            'where'=>array(
                'list2' => 1,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$list2 = Mynews::instance()->list_news_num($query_struct);
		$view->set("list2",$list2); 
		$view->set("list2",$list2); 
		if($play == 'play') 
		{ 
			echo $view->set_global('_topnav','is_wanfajieshao');
		}
		$view->render(TRUE);
	}
	
	//新闻列表页
	public function news_list($id){
		$view = new  View('/news/news_list');
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);
			
		   $str='';
		   $aa = array(
				'where'=>array(
					'id' => $id,
				),
			);
			$classRow = Mynews_category::instance()->list_news_categories($aa);
			if(count($classRow)){
			 $str=$classRow[0]['category_name'];
				 if($classRow[0]['parent_id']>0){
					 $aa = array(
						'where'=>array(
							'id' => $classRow[0]['parent_id'],
						),
					);
					$cate = Mynews_category::instance()->list_news_categories($aa);
					$str= '<a href="/news/news_list/'.$classRow[0]['parent_id'].'">'.$cate[0]['category_name'].'</a> > '.$str;
				 }
			}
		$view->set("list_title",$str); 	
	
		
		$view->set_global('_topnav','is_news');
		$query_struct = array(
            'where'=>array(
                'list1' => 1,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$list1 = Mynews::instance()->list_news_num($query_struct);
		$view->set("list1",$list1); 
		
		$query_struct = array(
            'where'=>array(
                'list2' => 1,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$list2 = Mynews::instance()->list_news_num($query_struct);
		$view->set("list2",$list2); 
		
		//分页
		$news = Mynews::instance();
		$get_page = intval($this->input->get('page'));	
		$page = !empty( $get_page ) ? intval($get_page) : "1";//页码
		$total_rows="15";//第页显示条数	
        $total = $news->count_site_news($id);
		$config['base_url'] = "/news/news_list/".$id;
		$config['total_items'] = $total;//总数量
		$config['query_string']  = 'page';
		$config['items_per_page']  = $total_rows;	//每页显示多少第		
		$config['uri_segment']  = $page;//当前页码	
		$config['directory']  = "";//样式路径	
		$query_struct = array(
            'where'=>array(
                'classid' => $id,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
            ),
           'limit'=> array(
                'per_page'  =>$total_rows,//每页的数量
                'offset'    =>$page,
            ),

        );			
		$this->pagination = new Pagination($config);
		$this->pagination->initialize();			

		$query_struct['limit']['offset'] = $this->pagination->sql_offset;
        $news = Mynews::instance()->lists($query_struct);
		
		$view->set("news",$news); 
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$view->set('site_config', $data['site_config']);
		
		$view->render(TRUE);
	
	}

	public function news_search(){
		if($_GET){
		$data['keywords'] = $this->input->get('search');
		$keyword = trim($data['keywords']);
		$query_struct_search = array(
					'orlike'	=>array('title'=>$keyword,'content'=>$keyword,'key'=>$keyword),
					'orderby'	=>array('created'=>'desc','id'=>'desc'),
					'limit'		=>array('per_page'=>10,'offset'=>0)
					);
			
		$data['search_result'] = Mynews::instance()->lists($query_struct_search);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$this->template = new View('news/news_search_list',$data);
		$this->template->render(true);
		}
	}
		
	//新闻列表页
	public function zxtj(){
		$zxtj = Mynews::instance();
		$get_page = intval($this->input->get('page'));
		$page = !empty( $get_page ) ? intval($get_page) : "1";//页码
		$total_rows="12";//第页显示条数	
		
		$config['query_string']  = 'page';
		$config['items_per_page']  = $total_rows;	//每页显示多少第		
		$config['uri_segment']  = $page;//当前页码	
		$config['directory']  = "";//样式路径	
		$query_struct = array(
				'where'		=>	array('zxtj'=>1),
				'orderby'	=>	array('created'=>'desc','id'=>'desc'),
				'limit'		=>	array('per_page'=>$total_rows,'offset'=>$page)
				);
		$config['total_items'] = $zxtj->count($query_struct);;//总数量
		
		$this->pagination = new Pagination($config);
		$this->pagination->initialize();
		$query_struct['limit']['offset'] = $this->pagination->sql_offset;
		
		$data['zxtj'] = Mynews::instance()->lists($query_struct);
		
		
		//右边列表
		$query_struct = array(
            'where'=>array(
                'list1' => 1,
            ),
            'orderby'   => array(
			   'order'=>'asc',
                'created'=>'desc',
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
                'created'=>'desc',
            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$data['list2'] = Mynews::instance()->list_news_num($query_struct);
		
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
		$this->template = new View('news/zxtj',$data);
		$this->template->set_global('_topnav','is_zxtj');
		$this->template->set_global('_user', $this->_user);
		$this->template->render(true);
	}
	
	public function free_bonus() {
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->template = new View('news/free_bonus',$data);
		$this->template->set_global('_user', $this->_user);
		$this->template->render(true);
	}
	
	public function jcw() {
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->template = new View('news/jcw',$data);
		$this->template->set_global('_user', $this->_user);
		$this->template->render(true);
	}
		
}
