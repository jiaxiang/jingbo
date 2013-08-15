<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 排列五
 * @author dexin.tang
 *
 */
class Pls_Controller extends Template_Controller {
	
	public static $pdb = null;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index(){
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->template = new View('pls/index',$data);
		$this->template->render(TRUE);
	}
	
	public function agreement() {
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->template = new View('pls/agreement',$data);
		$this->template->render(TRUE);
	}
	
	public function risknotice() {
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->template = new View('pls/risknotice',$data);
		$this->template->render(TRUE);
	}
	
	/*
	* Function: 标准格式
	* Param   : 
	* Return  : 
	*/
	public function zhx(){
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->template = new View('pls/zhx',$data);
		$this->template->render(TRUE);
	}
	
	public function z3(){
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->template = new View('pls/z3',$data);
		$this->template->render(TRUE);
	}
	
	public function z6(){
		$data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		$this->template = new View('pls/z6',$data);
		$this->template->render(TRUE);
	}

	public function view($pid){
		$user = $this->_user;
        $userobj = user::get_instance();
        
        if (empty($pid))
        {
            url::redirect('/error404');
            exit;
        }
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        
        try 
        {
        	$data = array();
        	//方案表
        	$obj = ORM::factory('plans_lotty_order');
			$obj->where('id', $pid);
	        $data = $obj->find()->as_array();
	        if($data['id']!=$pid){
	        	url::redirect('/error404');
            	exit;
	        }
	        if($data['substat']==1){
	        	$objext = ORM::factory('lotty_number_project');
	        	$objext->where('pid',$pid);
	        	$extdata     = $objext->find()->as_array();
	        	$data['ext'] =$extdata;
	        }
	        //期号
	        $objqihao = ORM::factory('qihao');
	        $objqihao->where('lotyid',$data['lotyid'])->where('qihao',$data['qihao']);
	        $issue   = $objqihao->find()->as_array();
	        if($data['ggstat']){
		        $objqhext = ORM::factory('qihao_ext');
		        $objqhext->where('qid',$issue['id']);
		        $issueext  = $objqhext->find()->as_array();
		        $issue     = array_merge($issue,$issueext);
	         }
	        $data['issue'] = $issue;
	        //查询跟单用户
	        $uids = array();
	        $saleobj = ORM::factory('sale_prouser');
	        $saleobj->where('pid',$pid);
	        $allusers   = $saleobj->find_all();
	        foreach ($allusers as $v){
	        	array_push($uids,$v->uid);
	        }
	        $data['uids'] = $uids;
	       	
	        $data['site_config'] = Kohana::config('site_config.site');
	        $host = $_SERVER['HTTP_HOST'];
	        $dis_site_config = Kohana::config('distribution_site_config');
	        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
	        }
	        
        	$this->template = new View('pls/plsrg', $data);
         	$this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
		
	}

	public function succ($pid){
		$user = $this->_user;
        $userobj = user::get_instance();
        
        if (empty($pid))
        {
            url::redirect('/error404');
            exit;
        }
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        try{
			$data=array();
			//方案表
        	$obj = ORM::factory('plans_lotty_order');
			$obj->where('id', $pid);
	        $data = $obj->find()->as_array();
			$data['usermoney'] = user::get_instance()->get_user_money($this->_user['id']);
			
			$data['site_config'] = Kohana::config('site_config.site');
			$host = $_SERVER['HTTP_HOST'];
			$dis_site_config = Kohana::config('distribution_site_config');
			if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
				$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
				$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
				$data['site_config']['description'] = $dis_site_config[$host]['description'];
			}
			
			$this->template = new View('pls/success', $data);
	        $this->template->set_global('_user', $this->_user);
        }
	 	catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	}

	 /*
     * 合买中心数据列表
     */
    public function ajax_data_lists_hm($page_size = "")
    {
    	//当前期
    	$isnowexpect = Qihaoservice::get_instance()->getisnow(8);
    	if(!$isnowexpect) {
    		$new_expect = 10000000;
    	}else{
    		$new_expect = $isnowexpect['qihao'];
    	}
    	
		$get_page = intval($this->input->get('page'));		
		$page = !empty($get_page) ? intval($get_page) : "1";             //页码
		$total_rows = !empty($page_size) ? intval($page_size) : "10";    //第页显示条数
		
		$get_findstr = trim($this->input->get('findstr'));
		$get_playid_term = trim($this->input->get('playid_term'));
		$get_state_term = trim($this->input->get('state_term'));
		$get_orderby = trim($this->input->get('orderby'));
		$get_orderstr = trim($this->input->get('orderstr'));
		$get_expect = trim($this->input->get('expect'));

		/* 初始化默认查询条件 */
		$carrier_query_struct = array(
			'where'=>array(
			),
			'like'=>array(),
			'orderby' => array(
			),
			'limit' => array(
				'per_page' =>$total_rows,//每页的数量
				'page' =>$page //页码
			),
		);
		//玩法
		if (!empty($get_playid_term))
		{
		    $carrier_query_struct['where']['wtype'] = $get_playid_term;
		}
		//用户查询
		if($get_findstr)
		{
			$user = user::get_search($get_findstr);
			if (!empty($user))
			{
			    $carrier_query_struct['where']['uid'] = $user['id'];
			}
			else 
			{
			     $carrier_query_struct['where']['uid'] = 0;
			}
		}		
		//期号
        if(!empty($get_expect)){
				$carrier_query_struct['where']['qihao']=$get_expect;	//期次
		}elseif(!empty($new_expect)){
				$carrier_query_struct['where']['qihao']=$new_expect;	//期次
	    }
 
	    //为空处理
	    if(strlen($get_state_term)==0){
	    	$get_state_term = 1;
	    }
	    
		if($get_state_term == 1)
		{
			$carrier_query_struct['where']['isfull!='] =  2;	//未满员
			$carrier_query_struct['where']['restat'] = 0;	//未撤单
		}
		elseif($get_state_term == 0)
		{
			$carrier_query_struct['where']['isfull'] = 2;	//满员
			$carrier_query_struct['where']['restat'] = 0;	//未撤单
		}
		elseif($get_state_term == 2)
		{
			$carrier_query_struct['where']['restat'] = 1;
		}
		
		if (!empty($get_orderby))
		{
    		if($get_orderby=='allmoney' && !empty($get_orderstr))
    		{
    			$carrier_query_struct['orderby']['allmoney'] = $get_orderstr;	
    		}
    		elseif($get_orderby=='onemoney' && !empty($get_orderstr))
    		{
    			$carrier_query_struct['orderby']['onemoney'] = $get_orderstr;	
    		}
    		elseif($get_orderby=='renqi' && !empty($get_orderstr))
    		{
    			$carrier_query_struct['orderby']['renqi'] = $get_orderstr;	
    		}
    		/*elseif($get_orderby=='snumber' && !empty($get_orderstr))
    		{
    			$carrier_query_struct['orderby']['surplus'] = $get_orderstr;	
    		}*/
    		else
    		{
    			$carrier_query_struct['orderby']['id']="DESC";					
    		}		
		}
		else
		{
		    $carrier_query_struct['orderby']['id']="DESC";	
		}
		
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        try {
			$plan_dlt_obj = Plans_lotty_orderService::get_instance();
			$data_list = $plan_dlt_obj->query_assoc($carrier_query_struct);//数据列表
			$data_count = $plan_dlt_obj->query_count($carrier_query_struct);//总记录数		
			$total_pages = ceil($data_count/$total_rows);//总页数
			//print_R($data_list);
						
			$page_html = "";
			$list_html = "";
			
			if ($data_list)
			{
				foreach($data_list as $key=>$value)
				{
					
					if($value['renqi'] == 100)
					{
						$baodi_text = $value['renqi']."%";   
					}
					else
					{
					   if ($value['baodi'] > 0)
					   {
						   $baodi_text = $value['renqi']."%+".intval(number_format($value['baodimoney']/$value['allmoney']*100,2))."%(<span class='red'>保</span>)";
					   }
					   else
					   {
							$baodi_text = $value['renqi']."%";   
					   }
				   }
				   
				   $c8 = '<input type="text" name="rgfs" class="rec_text" vid="'.$value['id'].'" vlotid="8" vplayid="'.$value['play_method'].'" vonemoney="'.$value['onemoney'].'" vsnumber="'.intval($value['nums']-$value['rgnum']).'" value="1" vexpect="'.$value['basic_id'].'" onkeyup="this.value=Y.getInt(this.value);if(this.value<=0)this.value=1;if(this.value>'.intval($value['nums']-$value['rgnum']).')this.value='.intval($value['nums']-$value['rgnum']).'"/>';
				   $c9 = '<input type="button" value="参与" class="btn_Dora_s m-r" id="b_'.$value['basic_id'].'"/><a href="/dlt/view/'.$value['id'].'" target="_blank">详情</a>';
				   if ($value['isfull'] == 2)
				   {
					   $baodi_text="<span class='red'>满员</span>";
					   $c8 = '-';
					   $c9 = '<a href="/dlt/view/'.$value['id'].'" target="_blank">详情</a>';
				   }
				   if($value['restat'] == 1){
				   		$baodi_text="<span color='#cccccc'>已撤单</span>";
				   		$c8 = '-';
				   		$c9 = '<a href="/dlt/view/'.$value['id'].'" target="_blank">详情</a>';
				   }
				   

				  if($value['showtype']==1){
						$view_url="截止后公开";
				   }elseif($value['showtype']==2||$value['showtype']==3){
						$view_url="仅跟单人可见";
				   }
				   if ($value['substat']==0 and $value['wtype']==3){
					   $text2="单式";
					   $view_url="未上传";
				   }else{
				   	   $text2="复式";
				   	   if($value['wtype']==3) $text2="单式";
					   $view_url="<a href=\"/dlt/view/".$value['id']."\" target=\"_blank\">查看</a>";
				   }
				   
					
					//$user = user::get($value['user_id']);

				if(empty($get_expect) or $get_expect>=$new_expect){
						$list_html[]=array(
						"column0"=>$value['id'],				
						"column1"=>($key+1),
						"column2"=>$value['uname'],	
						"column3"=>"￥".$value['allmoney']." 元",	
						"column4"=>"￥".$value['onemoney']." 元",	
						"column5"=>$view_url,
						"column6"=>$baodi_text,
						"column7"=>intval($value['nums']-$value['rgnum'])."份",
						"column8"=>$c8,	
						"column9"=>$c9,
						
						);
					}else{
						$list_html[]=array(
							"column0"=>$value['id'],
							"column1"=>($key+1),
							"column2"=>$value['uname'],
							"column3"=>"￥".$value['allmoney']." 元",
							"column4"=>"￥".$value['onemoney']." 元",
							"column5"=>$view_url,
							"column6"=>$baodi_text,
							"column7"=>'<a href="/dlt/view/'.$value['id'].'" target="_blank">详情</a>',
							);
					}
									
				}

				$base_url = "dlt/ajax_data_lists_hm/";
				$config['base_url'] = $base_url.$total_rows;		
				$config['total_items'] = $data_count;       //总数量
				$config['query_string'] = 'page';
				$config['items_per_page'] = $total_rows;	//每页显示多少第		
				$config['uri_segment'] = $page;             //当前页码
				$config['directory'] = "";                  //当前页码

				$str_style2 = "";
				$str_style3 = "";
				$str_style1 = "";
				
				switch($total_rows)
				{
					case 20:
					  $str_style1=' class="on"';
					  break;
					case 30:
					  $str_style2=' class="on"';
					  break;	
					case 40:
					  $str_style3=' class="on"';
					  break;	
				}
							
				$this->pagination = new Pagination($config);
				$this->pagination->initialize();			
				//d($this->pagination->render("ajax_page"));
				
				$page_html ='<span class="l c-p-num">单页方案个数:
				<a style="cursor: pointer;"'.$str_style1.' onclick="javascript:loadDataByUrl(\'/'.$base_url.'20?'.http_build_query($_GET).'\',\'list_data\');">20</a>
				<a style="cursor: pointer;"'.$str_style2.' onclick="javascript:loadDataByUrl(\'/'.$base_url.'30?'.http_build_query($_GET).'\',\'list_data\');">30</a>
				<a style="cursor: pointer;"'.$str_style3.' onclick="javascript:loadDataByUrl(\'/'.$base_url.'40?'.http_build_query($_GET).'\',\'list_data\');">40</a>
				</span>
				<span class="r" id="page_wrapper">';
				$page_html .=$this->pagination->render("ajax_page");
				$page_html .='<span class="sele_page">';
				unset($_GET['page']);
				$urlquery = http_build_query($_GET);
				$page_html .='<input id="govalue" name="page" class="" size="3" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\');if(this.value>'.$total_pages.')this.value='.$total_pages.';if(this.value<=0)this.value=1" onkeydown="if(event.keyCode==13){javascript:loadDataByUrl(\'/'.$base_url.$total_rows.'?'.$urlquery.'&page=\' + Y.one(\'#govalue\').value,\'list_data\');return false;}" type="text">';
				$page_html .='<input value="GO" class="btn" onclick="javascript:loadDataByUrl(\'/'.$base_url.'/'.$total_rows.'?page=\' + Y.one(\'#govalue\').value,\'list_data\');return false;" type="button">';
				$page_html .='</span>';
				$page_html .='<span class="gray">共'.$page.'页，'.$data_count.'条记录</span>';
				$page_html .='</span>';
		
				exit(json_encode(array("list_data"=>$list_html,"page_html"=>$page_html)));		
			}
			else
			{
				exit(json_encode(array("list_data" => "没有找到相关的记录！","page_html" => $page_html)));			
			}

            //提交表单和显示
            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;			
		
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
    }  
	
}