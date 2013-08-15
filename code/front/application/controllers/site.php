<?php defined('SYSPATH') OR die('No direct access allowed.');

class Site_Controller extends Template_Controller {

	public function phpinfo() {
		echo phpinfo();
	}

    public function index() {
    	$view_url = Site_Service::get_instance()->echo_index();
        $view = new View($view_url);
        $view->set_global('is_home', TRUE);
        $view->set_global('_user', $this->_user);

    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

       try {
            $return_data = array();
            $post = $this->input->post();
            $request_data = $this->input->get();
            if(isset($request_data['ex'])){
                throw new MyRuntimeException('异常处理测试', 400);
            }

            //* 补充&修改返回结构体 */
            $return_struct['status'] = 1;
            $return_struct['code']   = 200;
            $return_struct['msg']    = '';
            $return_struct['content']= $return_data;

            $this->template = new View('index',
                                array(
                                    'name'=>'abc',
                                    'bbc'=>$request_data,
                                )
            );

            //* 请求类型 */
            if($this->is_ajax_request()){
                // ajax 请求
                // json 输出
                $this->template->content = $return_struct;
            }
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }

        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        $view->set("site_config",$data['site_config']);
		//网站公告
        $query_struct = array(
            'where'=>array(
                'classid' => 1,
            ),
            'orderby'   => array(
				'id'=>'DESC',
			   'order'=>'asc',

            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$news_gg = Mynews::instance()->list_news_num($query_struct);
		$view->set("news_gg",$news_gg);

		//最新推荐
        $query_struct = array(
            'where'=>array(
                'zxtj' => 1,
            ),
            'orderby'   => array(
				'id'=>'DESC',
			   'order'=>'asc',

            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$zxtj = Mynews::instance()->list_news_num($query_struct);
		$view->set("zxtj",$zxtj);
		//专家推荐
		$query_struct = array(
            'where'=>array(
                'classid' => 21,
            ),
            'orderby'   => array(
				'id'=>'DESC',
			   'order'=>'asc',

            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$news_zj = Mynews::instance()->list_news_num($query_struct);
		$view->set("news_zj",$news_zj);

		//玩法推荐
		$query_struct = array(
            'where'=>array(
                'classid' => 3,
            ),
            'orderby'   => array(
			  'id'=>'DESC',
			   'order'=>'asc',

            ),
            'limit'=> array(
                'per_page'  =>5,
                'offset'    =>0,
            ),
        );
		$news_wj = Mynews::instance()->list_news_num($query_struct);
		$view->set("news_wj",$news_wj);

		//友情链接
		$query_struct_link = array(
				'where'		=>array('status'=>1),
				'orderby'	=>array('order'=>'desc','created'=>'desc'),
				'limit'		=>array('per_page'=>100,'offset'=>0)
				);
		$site_link = Mysite_link::instance()->lists($query_struct_link);
		$view->set('site_link',$site_link);

		//开奖信息
		$query_struct_kaijiang = array(
				'where'		=>	array('classid'=>20),
				'orderby'	=>	array('order'=>'asc','created'=>'desc'),
				'limit'		=>	array('per_page'=>3,'offset'=>0)
				);
		$kaijiang = Mynews::instance()->lists($query_struct_kaijiang);
		$view->set('kaijiang',$kaijiang);

		//首页推荐
		$index_tj=array();
		for($i=1;$i<=3;$i++){
			$query_struct = array(
				'where'=>array(
					'indextj' => $i,
				),
				'orderby'   => array(
				 'id'=>'DESC',
				   'order'=>'asc',

				),
				'limit'=> array(
					'per_page'  =>5,
					'offset'    =>0,
				),
			);
			$index_tj[$i] = Mynews::instance()->list_news_num($query_struct);
		}
		$view->set("index_tj",$index_tj);
		//彩票新闻;
		$news_caipiao=array();
		$news_classid=array(10,9,8,7);
		foreach($news_classid as $v){
			$query_struct = array(
				'where'=>array(
					'classid' => $v,
				),
				'orderby'   => array(
				   'id'=>'DESC',
				   'order'=>'asc',

				),
				'limit'=> array(
					'per_page'  =>6,
					'offset'    =>0,
				),
			);
			$news_caipiao[$v] = Mynews::instance()->list_news_num($query_struct);
		}
		$view->set("news_caipiao",$news_caipiao);
		$view->set("news_classid",$news_classid);

		$mklasttime = mktime(date("H"), date("i"), date("s"), date("m"), date("d")-14, date("Y"));
		$lasttime = date('Y-m-d H:i:s', $mklasttime);

		//足彩胜负合买列表
		/* 初始化默认查询条件 */
		$expect_data = Zcsf_expectService::get_instance()->get_expect_info(1);
		//d($expect_data);
		$carrier_query_struct = array(
			'where'=>array(
				'expect' => $expect_data['expect_num'],//期次
				'parent_id' =>0,//发起的
				'is_buy' =>1,//合买
				'time_stamp >= ' => $lasttime,
			),
			'like'=>array(),
			'orderby' => array(
				'id' =>'DESC',
			),
			'limit' => array(
				'per_page' =>5,//每页的数量
				'page' =>1 //页码
			),
		);

		//中奖
		$plan_basic = Plans_basicService::get_instance();
		//初始化默认查询结构体
        $query_struct_default = array (
            'where' => array (
                'bonus >' => 0,
                'status' => 5,
        		'date_add >= ' => $lasttime,
            ),
            /*'notin' => array (
                //'user_id' => array(91,92,93),
            	//'id' => array(2608, 2606, 2610),
            ),     */
            'orderby' => array (
                'bonus' => 'DESC'
            ),
            'limit' => array (
                'per_page' => 0,
                'page' => 1
            )
        );

        $plans_win = array();
        $plans_win['wins'] = $plan_basic->query_assoc($query_struct_default);
        //print_r($plans_win);
        $plans_win['users'] = array();
        foreach ($plans_win['wins'] as $rowwin)
        {
            $plans_win['users'][$rowwin['user_id']] = $rowwin['user_id'];
        }

        $userobj = user::get_instance();
        foreach ($plans_win['users'] as $rowuser)
        {
            $plans_win['users'][$rowuser] = $userobj->get($rowuser);
        }
        $view->set('plans_win', $plans_win);

		$Plans_sfc_obj = Plans_sfcService::get_instance();
		$data_list = $Plans_sfc_obj->query_data_list($carrier_query_struct);//数据列表
		$view->set('Plans_sfc_data_list',$data_list);



		//竟彩足球合买列表
		$carrier_query_struct_jczq = array(
			'where'=>array(
				'plan_type' => 1,	//合买
				'parent_id' => 0,	//发起的
				'time_stamp >= ' => $lasttime,
			),
			'like'=>array(),
			'orderby' => array(
				'id' =>'DESC',
			),
			'limit' => array(
				'per_page' =>5,         //每页的数量
				'page' =>1              //页码
			),
		);
		$Plans_jczq_obj = Plans_jczqService::get_instance();
		$data_list = $Plans_jczq_obj->query_data_list($carrier_query_struct_jczq);//数据列表
		//d($data_list);
		$view->set('Plans_jczq_data_list',$data_list);

		//竟彩篮球合买列表
		$carrier_query_struct_jclq = array(
			'where'=>array(
				'plan_type' => 1,	//合买
				'parent_id' => 0,	//发起的
				'time_stamp >= ' => $lasttime,
			),
			'like'=>array(),
			'orderby' => array(
				'id' =>'DESC',
			),
			'limit' => array(
				'per_page' =>5,         //每页的数量
				'page' =>1              //页码
			),
		);
		$Plans_jclq_obj = Plans_jclqService::get_instance();
		$data_list = $Plans_jclq_obj->query_data_list($carrier_query_struct_jczq);//数据列表
		//d($data_list);
		$view->set('Plans_jclq_data_list',$data_list);
        $view->render(TRUE);
    }

    public function error404() {
        $data = array();
        $data['msg'] = $this->input->get('msg', '404');
        $view = new View('404', $data);
        $view->render(TRUE);
    }

	/**
	 * show secode
	 */
	public function secoder()
	{
        $id = $this->input->get('id');
		secoder::$seKey = 'front.secoder.'.$id;
		secoder::entry();
	}

	public function secoder_regisiter($id, $flag) {
		//$id = $this->input->get('id');
		secoder::$useCurve = true;
		secoder::$useNoise = true;
		secoder::$imageL = 120;
		secoder::$length = 6;
		secoder::$seKey = 'front.secoder.'.$id;
		secoder::entry();
	}

	public function secoder_cn_regisiter($id) {
		//d($_SESSION);
		secoder_cn::$seKey = 'front.secodercn.'.$id;
		secoder_cn::entry();
		//var_dump($_SESSION);
	}

	/**
	 * show sysmsg
	 */
	function sysmsg(){
        $msg = remind::get();
        $msgstr = isset($msg['success'])?implode('，', $msg['success']):'';
        $msgstr .= isset($msg['error'])?implode('，', $msg['error']):'';
        exit($msgstr);
	}

	public function header($_topnav = NULL) {
		$data = array('_topnav'=>$_topnav,'_user'=>$this->_user);
		echo View::factory('header_api',$data)->render();
	}

	public function footer() {
		$data = array('_user'=>$this->_user);
		echo View::factory('footer_api',$data)->render();
	}

	public function header_test($_topnav = NULL) {
		$data = array('_topnav'=>$_topnav,'_user'=>$this->_user);
		echo View::factory('header_',$data)->render();
	}

	public function header_p($name, $_topnav = NULL) {
		$data = array('_topnav'=>$_topnav,'_user'=>$this->_user);
		echo View::factory('headers/'.$name, $data)->render();
	}

	public function footer_p($name) {
		$data = array('_user'=>$this->_user);
		echo View::factory('footers/'.$name, $data)->render();
	}
}
