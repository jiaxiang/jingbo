<?php defined('SYSPATH') OR die('No direct access allowed.');

class Faqs_Controller extends Template_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 得到新闻列表
	 */
	public function index()
	{
		
	}
	
	//新闻详细页
	public function faq_detail($id,$play='') {
		$view = new  View('/faqs/faq_detail');
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
		$news_classify = Mynews_category::instance()->get_categories($news_infor[0]['classid']);
		//d($news_classify);
		$view->set("news_classify",$news_infor[0]['classid']);
		$view->set("news_classify_name",$news_classify['category_name']);
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
	public function faqs_list($id){
		$view = new  View('/faqs/faqs_list');
		$view->set_global('_user', $this->_user);
        $view->set_global('_nav', NULL);
			
	   	$str='';
	   	$aa = array(
			'where'=>array(
				'id' => $id,
			),
		);
		$classRow = Mynews_category::instance()->list_news_categories($aa);
		//d($classRow);
		if(count($classRow)){
		 $str=$classRow[0]['category_name'];
			 if($classRow[0]['parent_id']>0){
				 $aa = array(
					'where'=>array(
						'id' => $classRow[0]['parent_id'],
						//'parent_id' => $classRow[0]['parent_id'],
					),
				);
				$cate = Mynews_category::instance()->list_news_categories($aa);
				$str= '<a href="#">'.$cate[0]['category_name'].'</a> > '.$str;
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
		$config['base_url'] = "/faqs/faqs_list/".$id;
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
		$view->set("news_classify",$id);
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
}