<?php defined('SYSPATH') OR die('No direct access allowed.');

class Expect_list_Controller extends Template_Controller {
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



	
	//首页跳转页面
    public function index()
    {
        header("Location: sfc_14c");
    }

	//14场胜负彩_复式
    public function sfc_14c($expect=""){
		role::check('zcsf_expect');
		$this->sfc_buy($expect,$play_method=1);
	}

	//14场胜负彩_复式
    public function sfc_6c($expect=""){
		role::check('zcsf_expect');
		$this->sfc_buy($expect,$play_method=3);
	}

	//14场胜负彩_复式
    public function sfc_4c($expect=""){
		role::check('zcsf_expect');
		$this->sfc_buy($expect,$play_method=4);
	}


	//胜负彩购买公共逻辑
    public function sfc_buy($cur_expect,$play_method){	
		role::check('zcsf_expect');	
		$data['expect_data']=Zcsf_expectService::get_instance()->get_expect_info($play_method);
		$data['cur_expect'] = empty($cur_expect) ? $data['expect_data']['expect_num'] : $cur_expect;//当前期次	
		$data['expect_list']=$this->get_expect_list($data['expect_data'],$data['cur_expect']);	
		//d($data,false);	
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        
       try {
            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
            $this -> template -> content = new View("order/expect_list",$data);
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }
	}
	
	//人工修改彩果
    public function set_cai_result(){
		role::check('zcsf_expect');	
        //初始化返回数组
        $return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
       $request_data = $this->input->get();
       $id = isset($request_data['id']) ?  $request_data['id'] : '';
       $cai_result = isset($_GET['order']) ?  $_GET['order']: '';
	   //d($_GET);
       if(empty($id) || (empty($cai_result) && $cai_result != 0))
       {
           $return_struct['msg'] = Kohana::lang('o_global.bad_request');
           exit(json_encode($return_struct));
       }
       if(Zcsf_expectService::get_instance()->set_cai_result($id,$cai_result)){
            $return_struct = array(
                'status'        => 1,
                'code'          => 200,
                'msg'           => Kohana::lang('o_global.position_success'),
                'content'       => array('order'=>$cai_result),
            );
       } else {
            $return_struct['msg'] = Kohana::lang('o_global.position_error');
       }
       exit(json_encode($return_struct));
	}	
	
//采集期次数据
    public function get_expect_list($expect_data,$cur_expect){
		role::check('zcsf_expect');	
		/* 初始化默认查询条件 */
		$carrier_query_struct = array(
			'where'=>array(
				'expect_num' => $cur_expect,
				'expect_type' => $expect_data['lotid_key'],
			),
			'like'=>array(),
			'orderby' => array(
				'id' =>'ASC',
			),
			'limit' => array(),
		);
		$Zcsf_expect_obj=Zcsf_expectService::get_instance();				
		$expect_list=$Zcsf_expect_obj->query_data_list($carrier_query_struct);	
		if($expect_list){
			return $expect_list;		
		}
	}	




 }