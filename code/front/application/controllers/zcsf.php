<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 足彩胜负控制器
 */
class Zcsf_Controller extends Template_Controller {

    public function __construct()
    {
        parent::__construct();

        $view = new View('index');
        $view->set_global('is_zcsf', TRUE);
        $view->set_global('_user', $this->_user);

	    $user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
    }

	//首页跳转页面
    public function index()
    {
        header("Location: sfc_14c");
    }

	//14场胜负彩_复式
    public function sfc_14c($expect=""){
		$this->sfc_buy($expect,$type=1,$play_method=1);
	}
    public function sfc_14c_shxh($expect=""){
		$this->sfc_buy($expect,$type=2,$play_method=1);
	}
	//14场胜负彩—单式
    public function sfc_14c_ds($expect=""){
		$this->sfc_buy($expect,$type="ds",$play_method=1);
	}

	//9场任选_复式
    public function sfc_9c($expect=""){
		$this->sfc_buy($expect,$type=1,$play_method=2);
	}
    public function sfc_9c_shxh($expect=""){
		$this->sfc_buy($expect,$type=2,$play_method=2);
	}
	//9场任选_单式
    public function sfc_9c_ds($expect=""){
		$this->sfc_buy($expect,$type="ds",$play_method=2);
	}

	//6场半全场
    public function sfc_6c($expect=""){
		$this->sfc_buy($expect,$type=1,$play_method=3);
	}
    public function sfc_6c_shxh($expect=""){
		$this->sfc_buy($expect,$type=2,$play_method=3);
	}
	//6场半全场_单式
    public function sfc_6c_ds($expect=""){
		$this->sfc_buy($expect,$type="ds",$play_method=3);
	}

	//4场进球彩
    public function sfc_4c($expect=""){
		$this->sfc_buy($expect,$type=1,$play_method=4);
	}
    public function sfc_4c_shxh($expect=""){
		$this->sfc_buy($expect,$type=2,$play_method=4);
	}
	//4场进球彩_单式
    public function sfc_4c_ds($expect=""){
		$this->sfc_buy($expect,$type="ds",$play_method=4);
	}


	//本站的销售结束时间的计算
    public function buy_end_time($endtime,$type=""){
		$site_config = Kohana::config('site_config');	
		if($type=="ds"){
			$buy_end_time=date("Y-m-d H:i:s",strtotime($endtime)-$site_config['match']['zcsf_endtime_ds']);//停售时间
		}else{
			$buy_end_time=date("Y-m-d H:i:s",strtotime($endtime)-$site_config['match']['zcsf_endtime']);//单式停售时间			
		}
		return $buy_end_time;						
	}

	//胜负彩购买公共逻辑
    public function sfc_buy($cur_expect,$type,$play_method,$id=""){
    	$data['site_config'] = Kohana::config('site_config.site');
    	$host = $_SERVER['HTTP_HOST'];
    	$dis_site_config = Kohana::config('distribution_site_config');
    	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
    		$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
    		$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
    		$data['site_config']['description'] = $dis_site_config[$host]['description'];
    	}
		$data['expect_data']=Zcsf_expectService::get_instance()->get_expect_info($play_method);
		//d($cur_expect,false);
		//d($data['expect_data']);
		$next_expect_num = $data['expect_data']['expects'][1];
		$data['cur_expect'] = empty($cur_expect) ? $data['expect_data']['expect_num'] : $cur_expect;//当前期次
		//d($data['cur_expect']);
		//d($data['expect_data']);
		$expect_list = $this->get_expect_list($data['expect_data'],$data['cur_expect']);
		//var_dump($expect_list);
		//d($data['cur_expect'],false);d($data['expect_data']['expects'][0]);
		
		//判断选号方式的权权限
		/* if($play_method==1 and $type==1 and ($data['cur_expect']!=$data['expect_data']['expects'][0] or strtotime($data['expect_data']['start_time'])>time())){
        	header("Location: /zcsf/sfc_14c_shxh/".$data['cur_expect']);
			exit();
		}elseif($play_method==2 and $type==1 and ($data['cur_expect']!=$data['expect_data']['expects'][0] or strtotime($data['expect_data']['start_time'])>time())){
        	header("Location: /zcsf/sfc_9c_shxh/".$data['cur_expect']);
			exit();
		}elseif($play_method==3 and $type==1 and ($data['cur_expect']!=$data['expect_data']['expects'][0] or strtotime($data['expect_data']['start_time'])>time())){
        	header("Location: /zcsf/sfc_6c_shxh/".$data['cur_expect']);
			exit();
		}elseif($play_method==4 and $type==1 and ($data['cur_expect']!=$data['expect_data']['expects'][0] or strtotime($data['expect_data']['start_time'])>time())){
			header("Location: /zcsf/sfc_4c_shxh/".$data['cur_expect']);
			exit();
		} */
		//d($data['cur_expect'],false);
		//d($data['expect_data']['expects'][0],false);
		//d($expect_list[0]['start_time']);
		if($play_method==1 && $type==1 && strtotime($expect_list[0]['start_time'])>time()) {
			header("Location: /zcsf/sfc_14c_shxh/".$data['cur_expect']);
			exit();
		}elseif($play_method==2 && $type==1 && strtotime($expect_list[0]['start_time'])>time()) {
			header("Location: /zcsf/sfc_9c_shxh/".$data['cur_expect']);
			exit();
		}elseif($play_method==3 && $type==1 && strtotime($expect_list[0]['start_time'])>time()) {
			header("Location: /zcsf/sfc_6c_shxh/".$data['cur_expect']);
			exit();
		}elseif($play_method==4 && $type==1 && strtotime($expect_list[0]['start_time'])>time()) {
			header("Location: /zcsf/sfc_4c_shxh/".$data['cur_expect']);
			exit();
		}
		
		//判断是否开销或停售
		if($expect_list){
			$site_config = Kohana::config('site_config');			
			$time_arr[0]=$expect_list[0]['open_time'];//开奖时间
			$time_arr[1]=$expect_list[0]['start_time'];//开售时间
			if($type=="ds"){
				$time_arr[2]=$this->buy_end_time($expect_list[0]['end_time'],"ds");
			}else{
				$time_arr[2]=$this->buy_end_time($expect_list[0]['end_time']);				
			}
			$time_over=explode(".",((strtotime($time_arr[2])-time())/(24*3600)));
			$time_arr[3]=$time_over[0];//剩余天数
			$time_arr[4]=intval((".".$time_over[1])*24);//乘余小时
			
			if(strtotime($time_arr[2])<time()){
				if($play_method==1){
					header("Location: /zcsf/sfc_14c_shxh/".$next_expect_num);
					exit();
				}elseif($play_method==2){
					header("Location: /zcsf/sfc_9c_shxh/".$next_expect_num);
					exit();
				}elseif($play_method==3){
					header("Location: /zcsf/sfc_6c_shxh/".$next_expect_num);
					exit();
				}elseif($play_method==4){
					header("Location: /zcsf/sfc_4c_shxh/".$next_expect_num);
					exit();
				}
				//exit("<script type='text/javascript'>alert('您好，该期已经过期');history.go(-1);</script>");
			}

		}else{
			exit("<script type='text/javascript'>alert('您好，该期暂未开始');history.go(-1);</script>");
		}

		$data['time_arr']	=	$time_arr;//当前期次赛事时间列表
		$data['expect_list']	=	$expect_list;//当前期次赛事列表
		/* $config_league_matches = kohana::config('league_matches');//获取联赛配置
		$data['color_list'] = $config_league_matches['color_list'];//颜色配置
		d($data['color_list'],false); */
		$config_league_matches = kohana::config('match_color');//获取联赛配置
		$data['color_list'] = $config_league_matches['matchs'];//颜色配置
		//d($data['color_list']);
		$data['play_method'] = $play_method;

		if ($type=="ds"){
			$viewpage = 'zcsf/html_ds';//单式页面
		}elseif($type=="shxh"){
			$viewpage = 'zcsf/html_'.$play_method."_shxh";//复式页面
		}elseif($type=="shsc"){
			$viewpage = 'zcsf/html_shsc';//复式页面
		}else{
			$type_id= $type==2 ? "2" : "1";
			$viewpage = 'zcsf/html_'.$play_method."_".$type_id;//复式页面
		}

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
            $this->template = new View($viewpage,$data);
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    }



	//立即购买表单提交
    public function submit_buy()
    {
    	exit(json_encode(array("errcode"=>-20,"msg"=>"无法投注！","msgmode"=>1)));
        if (empty($_POST)){
            exit(json_encode(array("errcode"=>-20,"msg"=>"提交时发生了一个错误！","msgmode"=>1)));
		}

		$expect_data=Zcsf_expectService::get_instance()->get_expect_info($this->input->post('play_method'));
		$cur_expect = $this->input->post('expect');//当前选择的期次
		$current_expect = $expect_data['expects'][0];//当前期
		$expect_list=$this->get_expect_list($expect_data,$cur_expect);

		if($this->input->post('codes')=="稍后上传" or $this->input->post('codes')=="文本文件上传"){
			$buy_end_time=$this->buy_end_time($expect_list[0]['end_time'],"ds");
		}else{
			$buy_end_time=$this->buy_end_time($expect_list[0]['end_time']);				
		}
		if(strtotime($buy_end_time)<time()){
			exit("<script type='text/javascript'>alert('您好，该期已经过期');history.go(-1);</script>");
		}

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

			$data['is_upload'] =$this->input->post('isupload');//是否上传
			$data['upload_filepath']="";//上传文件路径
			//* 收集请求数据 ==单式数据== *
			if($data['is_upload']==1){
				//单式上传方案
				if(!empty($_FILES['upfile'])){
					$upfile = $_FILES['upfile'];
					$time_path=date("Ymd",time());
					$data['upload_filepath']="media/upload_txt_file/".$time_path."/".rand_str(30).".txt";
					if (($upfile["type"] == "text/plain") && ($upfile["size"] < 500000))	{
						if ($upfile["error"] > 0){
						exit(json_encode(array("errcode"=>-20,"msg"=>"上传内容含有非法字符（".$upfile["error"]."）！","msgmode"=>1)));
						}else{
							$handle=file_get_contents($upfile["tmp_name"]);
							$buffer = explode("\r\n", Plans_sfcService::get_instance()->formatnumber($handle));
							$arr=preg_match('/[^(3|1|0|*|\r\n)]+/',$handle);
							if($arr==1){
								exit(json_encode(array("errcode"=>-20,"msg"=>"上传的内容不正确，请对照上传！","msgmode"=>1)));
							}elseif(count($buffer)==$this->input->post('zhushu')){
								mkdirs("media/upload_txt_file/".$time_path."/");//建立文件夹
								move_uploaded_file($upfile["tmp_name"],	$data['upload_filepath']);
							}else{
								exit(json_encode(array("errcode"=>-20,"msg"=>"上传的注数(".count($buffer)."注)与你填写注数(".$this->input->post('zhushu')."注)不对应！","msgmode"=>1)));
							}
						}
					}else{
						exit(json_encode(array("errcode"=>-20,"msg"=>"上传文件太大，请分段上传！","msgmode"=>1)));
					}
				}
			}

            //* 收集请求数据 ==基础表== *
			$data_basic['ticket_type'] =$this->input->post('ticket_type');//彩种
			$data_basic['play_method'] =$this->input->post('play_method');//玩法(单式，复式)
			$data_basic['start_user_id'] =$this->_user['id'];//发起人ID
			$data_basic['user_id'] =$this->_user['id'];//用户ID
			$site_config = Kohana::config('site_config');
			$data_basic['date_end'] =date("Y-m-d H:i:s",strtotime($expect_list[0]['end_time'])-$site_config['match']['zcsf_endtime']);//结束时间
			$data_basic['plan_type'] =$this->input->post('ishm');//方案种类(0,代购;1,合买;2,参与合买)


            //* 收集请求数据 ==基本数据== */
			$data['is_buy'] =$this->input->post('ishm');//合买 1为合买，0为代买
			$data['user_id'] =$this->_user['id'];//用户ID
			$data['ticket_type'] =$this->input->post('ticket_type');//彩种
			$data['play_method'] =$this->input->post('play_method');//玩法(单式，复式)
			$data['codes'] =$this->input->post('codes');//选择的结果
			$data['expect'] =$this->input->post('expect');//期号
			
            //* 收集请求数据 ==复式（代购数据）== */
			$data['zhushu'] =$this->input->post('zhushu');//总注数
			$data['rate'] =$this->input->post('beishu');//倍数
			$data['price'] =$this->input->post('totalmoney');//总金额
			$data['deduct'] =$this->input->post('tc_bili');//单式的提成自动为4%, 如未指定
				//$data['isset_buyuser'] =$this->input->post('isset_buyuser');//合买对像(1为所有，2为指定彩友)
				//$data['code'] =$this->input->post('code');//  未知参数 ['单', '双', '三', '四'];

			//* 收集请求数据 ==复式（合买数据）== */
			if ($data['is_buy']==1){
				//$data['copies'] =$this->input->post('allnum');//总分份数
				$data['copies'] = $data['price'];
				//$data['price_one'] = $data['price']/$data['copies'];//每份数的价格
				$data['price_one'] = 1;
				$data['my_copies'] =$this->input->post('buynum');//我要认购份数
				$data['is_baodi'] =$this->input->post('isbaodi');//是否保底
				$data['end_price'] =$this->input->post('baodinum');//保底份数
				$data['is_open'] =$this->input->post('isshow');//是否公开
				//d($data);
				$data['title'] =$this->input->post('title');//方案宣传标题
				$data['description'] =$this->input->post('content');//方案宣传标题
				$data['friends'] =$this->input->post('buyuser');//合买对像(all为所有用户,彩友用，号隔开)
				if($data['friends']=="最多输入500个字符"){
					$data['friends']="all";
				}
				$data['progress'] =intval(number_format($data['my_copies']/$data['copies']*100,2));//进度
			}else{
				//代购给默认值
				$data['copies'] ="1";//份数
				$data['price_one'] = $data['price'];//每份数的价格
				$data['my_copies'] ="1";//我要认购份数
				$data['is_baodi'] ="0";//是否保底
				$data['end_price'] ="0";//保底金额
				$data['is_open'] ="0";//是否公开
				$data['title'] ="";//方案宣传标题
				$data['description'] ="";//方案宣传描述
				$data['friends'] ="";//合买对像(all为所有用户,彩友用，号隔开)
				$data['progress'] ="100";//进度
			    $data['deduct'] =0;//单式的提成自动为4%, 如未指定
			}
			$data['buyed'] =($data['copies']-$data['my_copies']);//剩余份数
			$data['money'] = ($data['price_one']*$data['my_copies']);//我购买的总金额
			$data['time_end'] =$this->input->post('end_time');//结束时间
			$data['is_select_code'] =$this->input->post('is_select_code');//是否选号

           if ($data['codes']=="稍后上传" or $data['codes']=="文本文件上传"){
               $data['type'] =3;//单式
		   }else{
			   $data['type'] =1;//复式
		   }

			$baodi_price=0;
		   if($data['is_baodi']==1){
			 $baodi_price=($data['price_one']*$data['end_price']);
		   }

            //再次验证价格
            $userobj = user::get_instance();
            $usermoney = $userobj->get_user_money($this->_user['id']);

            if ($usermoney < $data['money'])
				exit(array("errcode"=>-20,"msg"=>"余额不足，请先充值后再购买！","msgmode"=>1));

            //标签过滤
            //tool::filter_strip_tags($data_basic, array('buyuser'));
			//for($i=0;$i<=200;$i++){
				$Plans_sfc_obj = Plans_sfcService::get_instance();
				$data['basic_id'] = Plans_basicService::get_instance()->add($data_basic);//添加到基础表
				$plans_sfc_id = $Plans_sfc_obj->add($data);//添加到方案表
			//}
			if($plans_sfc_id>0){
							//金额流向操作记录日志
							$data_log = array();
							$data_log['order_num'] = $data['basic_id'];
							$data_log['user_id'] = $this->_user['id'];
							$data_log['log_type'] = 2;  //参照config acccount_type 设置
							$data_log['is_in'] = 1;   //收入0,支出1
							$data_log['price'] = ($data['money']+$baodi_price);
							$data_log['user_money'] = $usermoney;
							$lan = Kohana::config('lan');
							$data_log['memo'] = $lan['money'][3];
							account_log::get_instance()->add($data_log);
                $session = Session::instance();
                $session->set('buywin_id', $plans_sfc_id);

				if($data['buyed']==0){
					//更新方案状态为未出票
                    $Plans_sfc_obj->update_status($plans_sfc_id, 1);
					$ticketobj = ticket::get_instance();
					if($data['type']==1 and $data['is_select_code']==1){
						if($data['zhushu']==1){
							$ticketobj->crate_ticket($plans_sfc_id, $data['ticket_type'], $data['play_method'], $Plans_sfc_obj->transform_codes1($data['codes']).";3;".$data['expect'], $data['rate'], $data['basic_id'], $data['price']);
						}else{
							$ticketobj->crate_ticket($plans_sfc_id, $data['ticket_type'], $data['play_method'], $Plans_sfc_obj->transform_codes($data['codes']).";".$data['type'].";".$data['expect'], $data['rate'], $data['basic_id'], $data['price']);
						}
					}elseif($data['type']==3 and $data['is_upload']==1){
						$handle=file_get_contents($data['upload_filepath']);
						$buffer = explode("\r\n", $Plans_sfc_obj->formatnumber($handle));
						$buffer=array_chunk($buffer,5);
						foreach($buffer as $key=>$value){
							$ticketobj->crate_ticket($plans_sfc_id, $data['ticket_type'], $data['play_method'], implode("|",$value).";".$data['type'].";".$data['expect'], $data['rate'], $data['basic_id'],count($value)*2);
						}
					}
				}
				$msg="提交成功！";
				$headerurl="zcsf/buyok";
				//$msg = tool::debu_array($data, "<br>");
				exit(json_encode(array("errcode"=>0,"headerurl"=>$headerurl,"msg"=>$msg)));
				 //errcode:0,      //没有错误返回0
				 //headerurl:"",   //跳转地址
				 //msg:'',         //有headerurl 这个就没用了
			}else{
				$msg="提交失败";
				//$msg = tool::debu_array($data, "<br>");
				exit(json_encode(array("errcode"=>-20,"msg"=>$msg,"msgmode"=>1)));
				//errcode:-20,
				//msg:'取配置信息错误！',
				//msgmode:1
				//如果提交失败(问题出在system/mode/plans_sfc.php中字段过滤问题)
			}
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
        }
	}

	//稍候上传表单提交
    public function submit_upload()
    {
    	exit(json_encode(array("errcode"=>-20,"msg"=>"无法投注！","msgmode"=>1)));
		$pid =$this->input->post('pid');//合买 1为合买，0为代买
        if (empty($pid))
            exit(json_encode(array("errcode"=>-20,"msg"=>"提交时发生了一个错误！","msgmode"=>1)));

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

			$Plans_sfc_obj = Plans_sfcService::get_instance();
			$up_data = $Plans_sfc_obj->get_by_basic_id($pid);


			$expect_data=Zcsf_expectService::get_instance()->get_expect_info($up_data['play_method']);
			$cur_expect = $up_data['expect'];//当前期次
			$expect_list=$this->get_expect_list($expect_data,$cur_expect);


			$buy_end_time=$this->buy_end_time($expect_list[0]['end_time'],"ds");
			if(strtotime($buy_end_time)<time()){
				exit("<script type='text/javascript'>alert('您好，该期已经过期');history.go(-1);</script>");
			}

			//单式上传方案
            if ($up_data['user_id']==$this->_user['id'] and $up_data['parent_id']==0){
				$data['upload_filepath']="";//上传文件路径
				if(!empty($_FILES['upfile'])){
					$upfile = $_FILES['upfile'];
					$tmp_filename = $upfile['tmp_name'];
					$time_path=date("Ymd",time());
					$data['upload_filepath']="media/upload_txt_file/".$time_path."/".rand_str(30).".txt";
					if (is_uploaded_file($tmp_filename) && ($upfile["type"] == "text/plain") && ($upfile["size"] < 20000))	{
						if ($upfile["error"] > 0){
							exit("<script type='text/javascript'>alert('上传出错!');history.go(-1);</script>");
						}else{
							$handle=file_get_contents($tmp_filename);
							$buffer = explode("\r\n", $Plans_sfc_obj->formatnumber($handle));
							$arr=preg_match('/[^(3|1|0|*|\r\n)]+/',$handle);
							if($arr==1){
								exit("<script type='text/javascript'>alert('上传的内容不正确，请对照上传！');history.go(-1);</script>");
							}elseif(count($buffer)==$up_data['zhushu']){
								mkdirs("media/upload_txt_file/".$time_path."/");//建立文件夹
								move_uploaded_file($tmp_filename,	$data['upload_filepath']);
							}else{
								exit("<script type='text/javascript'>alert('上传的注数(".count($buffer)."注)与你填写注数(".$up_data['zhushu']."注)不对应');history.go(-1);</script>");
							}
						}
					}else{
						exit("<script type='text/javascript'>alert('上传文件无效!');history.go(-1);</script>");
					}
				}
		   		$data['is_upload'] =1;//选号
		  		$data['basic_id'] =$pid;//id
		  		$data['user_id'] =$this->_user['id'];//id

				$result = $Plans_sfc_obj->up_data_upload($data);
				if($result){
					$up_data = $Plans_sfc_obj->get_by_basic_id($pid);
					if($up_data['buyed']==0){
						//更新方案状态为未出票
						$Plans_sfc_obj->update_status($up_data['id'], 1);
						$ticketobj = ticket::get_instance();
						if($up_data['type']==1 and $up_data['is_select_code']==1){
							exit("<script type='text/javascript'>alert('非法提交');parent.window.location.reload();</script>");
						}elseif($up_data['type']==3 and $up_data['is_upload']==1){
							$handle=file_get_contents($data['upload_filepath']);
							$buffer = explode("\r\n", $Plans_sfc_obj->formatnumber($handle));
							$buffer=array_chunk($buffer,5);
							foreach($buffer as $key=>$value){
								$ticketobj->crate_ticket($up_data['id'], $up_data['ticket_type'], $up_data['play_method'], implode("|",$value).";".$up_data['type'].";".$up_data['expect'], $up_data['rate'], $up_data['basic_id'],count($value)*2);
							}
						}
					}
					exit("<script type='text/javascript'>alert('上传成功');parent.window.location.reload();</script>");
				}else{
					exit("<script type='text/javascript'>alert('上传失败');parent.window.location.reload();</script>");
				}
			}else{
				exit("<script type='text/javascript'>alert('非法提交');parent.window.location.reload();</script>");
			}

        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
        }
	}

	//稍候选号表单提交
    public function submit_updata()
    {
    	exit(json_encode(array("errcode"=>-20,"msg"=>"无法投注！","msgmode"=>1)));
		$pid =$this->input->post('pid');//合买 1为合买，0为代买
        if (empty($pid))
            exit(json_encode(array("errcode"=>-20,"msg"=>"提交时发生了一个错误！","msgmode"=>1)));

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

			$Plans_sfc_obj = Plans_sfcService::get_instance();
			$up_data = $Plans_sfc_obj->get_by_basic_id($pid);


			$expect_data=Zcsf_expectService::get_instance()->get_expect_info($up_data['play_method']);
			$cur_expect = $up_data['expect'];//当前期次
			$expect_list=$this->get_expect_list($expect_data,$cur_expect);

			$buy_end_time=$this->buy_end_time($expect_list[0]['end_time'],"ds");
			if(strtotime($buy_end_time)<time()){
				exit("<script type='text/javascript'>alert('您好，该期已经过期');history.go(-1);</script>");
			}


            if ($up_data['user_id']==$this->_user['id'] and $up_data['parent_id']==0){

		   		$data['codes'] =$this->input->post('codes');//选号
		   		$data['is_select_code'] =1;//选号
		  		$data['basic_id'] =$pid;//id
		  		$data['user_id'] =$this->_user['id'];//id

				$result = $Plans_sfc_obj->up_data($data);
				if($result){
					if($up_data['buyed']==0){
						//更新方案状态为未出票
						$Plans_sfc_obj->update_status($up_data['id'], 1);
						$ticketobj = ticket::get_instance();
						if($up_data['type']==1){
							if($up_data['zhushu']==1){
								$ticketobj->crate_ticket($up_data['id'], $up_data['ticket_type'], $up_data['play_method'], $Plans_sfc_obj->transform_codes1($data['codes']).";3;".$up_data['expect'], $up_data['rate'], $up_data['basic_id'], $up_data['price']);
							}else{
								$ticketobj->crate_ticket($up_data['id'], $up_data['ticket_type'], $up_data['play_method'], $Plans_sfc_obj->transform_codes($data['codes']).";".$up_data['type'].";".$up_data['expect'], $up_data['rate'], $up_data['basic_id'], $up_data['price']);
							}
						}elseif($up_data['type']==3 and $up_data['is_upload']==1){
							exit(json_encode(array("state"=>"-1","msg"=>"非法提交","msgmode"=>1)));
						}
					}
					$msg="提交成功！";
					//$msg = tool::debu_array($data, "<br>");
					$headerurl="zcsf/viewdetail/".$up_data['basic_id']."";//跳转地址
					exit(json_encode(array("errcode"=>0,"headerurl"=>$headerurl,"msg"=>$msg)));
				}else{
					$msg="提交失败！";
					//$msg = tool::debu_array($result, "<br>");
					exit(json_encode(array("state"=>"-1","msg"=>$msg,"msgmode"=>1)));
				}

			}else{
				exit(json_encode(array("state"=>"-1","msg"=>"非法提交","msgmode"=>1)));
			}

        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
        }
	}


	//参与合买表单提交
    public function submit_buy_join()
    {
    	exit(json_encode(array("errcode"=>-20,"msg"=>"无法投注！","msgmode"=>1)));
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );		
		
		$pid =$this->input->get('pid');
		$buynum=$this->input->get('buynum');
        if (empty($pid) or empty($buynum)){
            exit(json_encode(array("state"=>-20,"msg"=>"提交时发生了一个错误！","msgmode"=>1)));
		}
		
       try {
            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;

			$Plans_sfc_obj = Plans_sfcService::get_instance();
			$join_data = $Plans_sfc_obj->get_by_basic_id($pid);

			$expect_data=Zcsf_expectService::get_instance()->get_expect_info($join_data['play_method']);
			$cur_expect = $join_data['expect'];//当前期次
			$expect_list=$this->get_expect_list($expect_data,$cur_expect);

			if($join_data['type']==3){
				$buy_end_time=$this->buy_end_time($expect_list[0]['end_time'],"ds");
			}else{
				$buy_end_time=$this->buy_end_time($expect_list[0]['end_time']);				
			}
			if(strtotime($buy_end_time)<time()){
				exit(json_encode(array("state"=>-20,"msg"=>"您好，该期已经过期","msgmode"=>1)));
			}
			
			if(intval($buynum) > intval($join_data['buyed'])){
				exit(json_encode(array("state"=>-20,"msg"=>"您好，购买份数超出了剩余份数","msgmode"=>1)));
			}
			
			if($join_data['friends']=="all"){ //判断是否是有参与合买权限
				$is_hmr=1;
			}else{
				if(in_array($this->_user['lastname'],explode(",",$join_data['friends']))){
					$is_hmr=1;
				}else{
					$is_hmr=0;
				}
			}

			if($is_hmr==0){
				exit(json_encode(array("state"=>-20,"msg"=>"您好，您没有权限购买本方案","msgmode"=>1)));
			}

            //* 收集请求数据 ==基础表== *
			$data_basic['ticket_type'] =$this->input->get('lotid');//彩种
			$data_basic['play_method'] =$this->input->get('playid');//玩法(单式，复式)
			$data_basic['start_user_id'] =$join_data['user_id'];//发起人ID
			$data_basic['user_id'] =$this->_user['id'];//用户ID
			$data_basic['date_end'] =$join_data['time_end'];//结束时间
			$data_basic['plan_type'] =2;//方案种类(0,代购;1,合买;2,参与合买)

            //* 收集请求数据 ==基本数据== */
			$data['is_buy'] =2;//方案种类(0,代购;1,合买;2,参与合买)
			$data['parent_id'] =$join_data['id'];//单式
			$data['user_id'] =$this->_user['id'];//用户ID
			$data['ticket_type'] =$this->input->get('lotid');//彩种
			$data['play_method'] =$this->input->get('playid');//玩法(单式，复式)
			$data['codes'] =$join_data['codes'];//选择的结果
			$data['expect'] =$join_data['expect'];//期号

            //* 收集请求数据 ==复式（代购数据）== */
			$data['zhushu'] =$join_data['zhushu'];//总注数
			$data['rate'] =$join_data['rate'];//倍数
			$data['price'] =$join_data['price'];//总金额
			$data['deduct'] =$join_data['deduct'];//单式的提成自动为4%, 如未指定
			$data['copies'] =$join_data['copies'];//总分份数
			$data['price_one'] =$join_data['price_one'];//每份数的价格
			$data['my_copies'] =$this->input->get('buynum');//我要认购份数
			$data['is_baodi'] =$join_data['is_baodi'];//是否保底
			$data['end_price'] =$join_data['end_price'];//保底数量
			$data['is_open'] =$join_data['is_open'];//是否公开
			$data['title'] ="";//方案宣传标题
			$data['description'] ="";//方案宣传标题
			$data['friends'] ="";//合买对像(all为所有用户,彩友用，号隔开)
			$data['buyed'] =$join_data['buyed']-$data['my_copies'];//剩余份数
			$data['progress'] =intval(number_format(($data['copies']-$data['buyed'])/$data['copies']*100,2));//进度
			$data['is_upload'] =$join_data['is_upload'];//是否上传
			$data['money'] = ($join_data['price_one']*$data['my_copies']);//我购买的总金额
			$data['time_end'] =$join_data['time_end'];//结束时间
			$data['type'] =$join_data['type'];//单式
			$data['is_select_code'] =$join_data['is_select_code'];//是否选号

            //再次验证价格
            $userobj = user::get_instance();
            $usermoney = $userobj->get_user_money($this->_user['id']);
            if ($usermoney < $data['money']){
				exit(json_encode(array("state"=>"-1","msg"=>"余额不足","msgmode"=>1)));
			}
			if($join_data){//更新方案表
				$up_data['basic_id'] = $pid;
				$up_data['buyed']=$data['buyed'];
				$up_data['progress'] =$data['progress'];//进度
				$Plans_sfc_obj->up_data_progress($up_data);
				$data['parent_id'] =$join_data['id'];//复式
			}

            //标签过滤
            //tool::filter_strip_tags($data_basic, array('buyuser'));
			$plans_basic_id = Plans_basicService::get_instance()->add($data_basic);//添加到基础表
			$data['basic_id'] =$plans_basic_id;//方案号码
			$plans_sfc_id = $Plans_sfc_obj->add($data);//添加到方案表
			if(is_int($plans_sfc_id)){
							//金额流向操作记录日志
							$data_log = array();
							$data_log['order_num'] = $plans_basic_id;
							$data_log['user_id'] = $this->_user['id'];
							$data_log['log_type'] = 2;  //参照config acccount_type 设置
							$data_log['is_in'] = 1;   //收入0,支出1
							$data_log['price'] = $data['money'];
							$data_log['user_money'] = $usermoney;
							$lan = Kohana::config('lan');
							$data_log['memo'] = $lan['money'][18].',订单ID:'.$join_data['basic_id'];
							account_log::get_instance()->add($data_log);
                $session = Session::instance();
                $session->set('buywin_id', $plans_sfc_id);
				if($data['buyed']==0 and ($data['is_select_code']==1 or $data['is_upload']==1)){
					//更新方案状态为未出票
                    $Plans_sfc_obj->update_status($data['parent_id'], 1);
					$ticketobj = ticket::get_instance();
					if($data['type']==1 and $data['is_select_code']==1){
						if($data['zhushu']==1){
							$ticketobj->crate_ticket($data['parent_id'], $data['ticket_type'], $data['play_method'], $Plans_sfc_obj->transform_codes1($data['codes']).";3;".$data['expect'], $data['rate'], $join_data['basic_id'], $join_data['price']);
						}else{
							$ticketobj->crate_ticket($data['parent_id'], $data['ticket_type'], $data['play_method'], $Plans_sfc_obj->transform_codes($data['codes']).";".$data['type'].";".$data['expect'], $data['rate'], $join_data['basic_id'], $join_data['price']);
						}
					}elseif($data['type']==3 and $data['is_upload']==1){
							$handle=file_get_contents($join_data['upload_filepath']);
							$buffer = explode("\r\n", $Plans_sfc_obj->formatnumber($handle));
							$buffer=array_chunk($buffer,5);
							foreach($buffer as $key=>$value){
								$ticketobj->crate_ticket($data['parent_id'], $data['ticket_type'], $data['play_method'], implode("|",$value).";".$data['type'].";".$data['expect'], $data['rate'], $join_data['basic_id'],count($value)*2);
							}
					}

                    //返还保底金额
                    if ($data['end_price'] > 0)
                    {
                        $backmoney = $data['end_price'] * $data['price_one'];
                        $usermoney = $userobj->get_user_money($join_data['user_id']);
                        //记录日志
                        $data_log = array();
                        $data_log['order_num'] = date('YmdHis').rand(0, 99999);
                        $data_log['user_id'] = $join_data['user_id'];
                        $data_log['log_type'] = 5;                 //参照config acccount_type 设置
                        $data_log['is_in'] = 0;
                        $data_log['price'] = $backmoney;
                        $data_log['user_money'] = $usermoney;

                        $lan = Kohana::config('lan');
                        $data_log['memo'] = $lan['money'][8];
                        account_log::get_instance()->add($data_log);
						$Plans_sfc_obj->update_end_price($data['parent_id']);	
                    }
				}
				$headerurl="/zcsf/viewdetail/".$join_data['basic_id']."";//跳转地址			
				exit(json_encode(array("state"=>100,"headerurl"=>$headerurl)));
			}else{
				$msg="提交失败";
				//$msg = tool::debu_array($data, "<br>");
				exit(json_encode(array("state"=>-20,"msg"=>$msg,"msgmode"=>1)));
			}
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
        }
	}


   /*
     * 成功提交订单
     */
    public function buyok()
    {
        $session = Session::instance();
        $plans_sfc_id = $session->get('buywin_id');

        if (empty($plans_sfc_id))
        {
            url::redirect('/error404?msg=页面已过期');
            exit;
        }

        $data = Plans_sfcService::get_instance()->get_by_id($plans_sfc_id);
        $data['usermoney'] = user::get_instance()->get_user_money($this->_user['id']);
        $data['plans_sfc_id'] = $plans_sfc_id;

        if (empty($data))
        {
            url::redirect('/error404?msg=页面已过期');
            exit;
        }
        $data['site_config'] = Kohana::config('site_config.site');
        $host = $_SERVER['HTTP_HOST'];
        $dis_site_config = Kohana::config('distribution_site_config');
        if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
        	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
        	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
        	$data['site_config']['description'] = $dis_site_config[$host]['description'];
        }
        $session->delete('buywin_id');

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

            $this->template = new View('zcsf/buy_success', $data);
            $this->template->set_global('_user', $this->_user);

        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }

        $this->template->render(TRUE);
    }



	//胜负彩14场 我的方案
    public function mycase_14c(){
		$this->sfc_mycase($status="0",$play_method=1);
	}
    public function mycase_14c_ok($status=0){
		$this->sfc_mycase($status="1",$play_method=1);
	}

	//胜负彩9场 我的方案
    public function mycase_9c(){
		$this->sfc_mycase($status="0",$play_method=2);
	}
    public function mycase_9c_ok(){
		$this->sfc_mycase($status="1",$play_method=2);
	}
	//胜负彩6场 我的方案
    public function mycase_6c(){
		$this->sfc_mycase($status="0",$play_method=3);
	}
    public function mycase_6c_ok(){
		$this->sfc_mycase($status="1",$play_method=3);
	}
	//胜负彩4场 我的方案
    public function mycase_4c(){
		$this->sfc_mycase($status="0",$play_method=4);
	}
    public function mycase_4c_ok(){
		$this->sfc_mycase($status="1",$play_method=4);
	}
	//我的方案公共逻辑
    public function sfc_mycase($status,$play_method=1)
    {
		//$status=0		结算状态（1为已结算交易 0为未结算交易）
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

       try {
	       	$data['site_config'] = Kohana::config('site_config.site');
	       	$host = $_SERVER['HTTP_HOST'];
	       	$dis_site_config = Kohana::config('distribution_site_config');
	       	if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
	       		$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
	       		$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
	       		$data['site_config']['description'] = $dis_site_config[$host]['description'];
	       	}
			$data['expect_data']=Zcsf_expectService::get_instance()->get_expect_info($play_method);
			$data['status'] = $status;//结算状态
			$data['expect_list'] = $this->get_expect_list($data['expect_data'],$data['expect_data']['expect_num']);
			$data['ajax_url'] ="/zcsf/ajax_data_lists_".$data['expect_data']['expect_type']."c/".$status."/20";
			//print_r($data);
            $this->template = new View("zcsf/mycase",$data);
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
        }
        $this->template->render(TRUE);
	}



	//数据列表_我的方案
    public function ajax_data_lists_14c($status=0,$page_size="")
    {
		$this->ajax_data_list("",'my',$play_method=1,$status,$page_size);
	}
    public function ajax_data_lists_9c($status=0,$page_size="")
    {
		$this->ajax_data_list("",'my',$play_method=2,$status,$page_size);
	}
    public function ajax_data_lists_6c($status=0,$page_size="")
    {
		$this->ajax_data_list("",'my',$play_method=3,$status,$page_size);
	}
    public function ajax_data_lists_4c($status=0,$page_size="")
    {
		$this->ajax_data_list("",'my',$play_method=4,$status,$page_size);
	}

	//数据列表_合买
    public function ajax_data_lists_hm_14c($new_expect="",$page_size="")
    {
		$this->ajax_data_list($new_expect,'hm',$play_method=1,$status=0,$page_size);
	}
    public function ajax_data_lists_hm_9c($new_expect="",$page_size="")
    {
		$this->ajax_data_list($new_expect,'hm',$play_method=2,$status=0,$page_size);
	}
    public function ajax_data_lists_hm_6c($new_expect="",$page_size="")
    {
		$this->ajax_data_list($new_expect,'hm',$play_method=3,$statu=0,$page_size);
	}
    public function ajax_data_lists_hm_4c($new_expect="",$page_size="")
    {
		$this->ajax_data_list($new_expect,'hm',$play_method=4,$status=0,$page_size);
	}

	//数据列表公共逻辑
    public function ajax_data_list($new_expect="",$type,$play_method,$status=0,$page_size)
    {
		//$play_method		玩法
		//$status		结算状态（1为已结算交易 0为未结算交易）

		$get_page = intval($this->input->get('page'));
		$get_findstr = trim($this->input->get('findstr'));
		$get_playid_term = trim($this->input->get('playid_term'));
		$get_state_term = trim($this->input->get('state_term'));
		$pid = trim($this->input->get('pid'));
		$get_status = trim($this->input->get('status'));
		$get_expect = trim($this->input->get('expect'));

		$get_orderby = trim($this->input->get('orderby'));
		$get_orderstr = trim($this->input->get('orderstr'));

		$page = !empty( $get_page ) ? intval($get_page) : "1";//页码
		$total_rows=!empty( $page_size ) ? intval($page_size) : "20";//第页显示条数

		/* 初始化默认查询条件 */
		$carrier_query_struct = array(
			'where'=>array(
				'play_method' => $play_method,//玩法
			),
			'like'=>array(),
			'orderby' => array(
				//'id' =>'DESC',
			),
			'limit' => array(
				'per_page' =>$total_rows,//每页的数量
				'page' =>$page //页码
			),
		);

		if ($type=="hm"){//合买
			  $carrier_query_struct['where']['is_buy']=1;
			  $carrier_query_struct['where']['parent_id']=0;
				if($get_findstr){
					$user = user::get_search($get_findstr);
					$carrier_query_struct['where']['user_id']=$user['id'];
				}

				if($get_playid_term==1){
					$carrier_query_struct['where']['type']=1;	//复式
				}elseif($get_playid_term==3){
					$carrier_query_struct['where']['type']=3;	//单式
				}
				if($get_expect!=NULL){
					$carrier_query_struct['where']['expect']=$get_expect;	//期次
				}elseif($new_expect!=NULL){
					$carrier_query_struct['where']['expect']=$new_expect;	//期次
				}

				if($get_state_term==NULL){
					$get_state_term=100;
				}

				if($get_state_term==1 or $get_state_term==100){
					$carrier_query_struct['where']['progress<']="100";	//未满员
				}elseif($get_state_term==0){
					$carrier_query_struct['where']['progress']=100;	//满员
				}elseif($get_state_term==2){
					$carrier_query_struct['where']['status']=6;
				}

				if($get_orderby=='allmoney' and !empty($get_orderstr)){
					$carrier_query_struct['orderby']['price']=$get_orderstr;
				}elseif($get_orderby=='onemoney' and !empty($get_orderstr)){
					$carrier_query_struct['orderby']['price_one']=$get_orderstr;
				}elseif($get_orderby=='renqi' and !empty($get_orderstr)){
					$carrier_query_struct['orderby']['progress']=$get_orderstr;
				}elseif($get_orderby=='snumber' and !empty($get_orderstr)){
					$carrier_query_struct['orderby']['buyed']=$get_orderstr;
				}else{
					$carrier_query_struct['orderby']['id']="DESC";
				}

		}elseif ($type=="my"){//我的
			  //判断登陆
			  if (empty($this->_user['id'])){
				  echo json_encode(array("islogin"=>0,"pagestr"=>""));
				  exit();
			  }
			  $carrier_query_struct['orderby']['id']="DESC";
			  $carrier_query_struct['where']['user_id']=$this->_user['id'];
			  if($status==1){
    		     $carrier_query_struct['where']['status'] = array(3,4,5);
			  }elseif($status==0){
			  	$carrier_query_struct['where']['status'] = array(0,1,2);
			  }
		}

		$Plans_sfc_obj = Plans_sfcService::get_instance();
		$data_list = $Plans_sfc_obj->query_data_list($carrier_query_struct);//数据列表
		$data_count = $Plans_sfc_obj->query_count($carrier_query_struct);//总记录数
		$total_pages = ceil($data_count/$total_rows);//总页数
		//d($carrier_query_struct,false);
		//echo $data_count;

		$page_html="";
		$list_html="";
		if ($data_list){
			foreach($data_list as $key=>$value){
				if($value['parent_id']>0){
					$parent_plan = $Plans_sfc_obj->get_by_id($value['parent_id']);
					$user = user::get($parent_plan['user_id']);
					$value['buyed']=$parent_plan['buyed'];
					$value['progress']=$parent_plan['progress'];
				}else{
					$user = user::get($value['user_id']);
				}

				//d($user['lastname'],false);

				if($value['is_buy']==1){
					$text1="合买";
				}else{
					$text1="代购";
				}
				
				if ($value['parent_id'] > 0) {
					$data['detail'] = $parent_plan;
				}else{
					$data['detail']	= $value;
				}
				if ($this->_user['id'] == $data['detail']['user_id']) {
					$data['join_data'] = true;
				}
				else {
					$data['join_data'] = $Plans_sfc_obj->find_join_data($this->_user['id'],$value['id']); //是否有参与过本方案
				}
				$data['is_public'] = $Plans_sfc_obj->plan_open($data['detail'], $data['join_data']);
				
				/* if($value['is_open']==1){
					$view_url="截止后公开";
				}elseif($value['is_open']==2){
					$view_url="仅跟单人可看";
				} */
			   if ($value['is_upload']==0 and $value['type']==3){
				   $text2="单式";
				   $view_url="未上传";
			   }elseif ($value['is_select_code']==1 and $value['type']==3){
				   $text2="单式";
				   $view_url="<a href=\"/".$value['upload_filepath']."\" target=\"_blank\">查看</a>";
			   }else{
				   $text2="复式";
				   $view_url="<a onclick=\"Y.openUrl('/zcsf/viewdetail_codes/".$value['basic_id']."',525,460);return false\" href=\"javascript:void(0)\">查看</a>";
			   }
			   if ($value['is_select_code']==0 and $value['type']==1){
				   $view_url="未选号";
			   }
			   if ($value['status']==6){
				   $view_url="作废";
			   }
				if ($data['is_public'] !== true) {
					$view_url = $data['is_public'];
				}
				if($value['buyed']==0){
					$baodi_text="<span class='red'>满员</span>";
				}else{
				   if ($value['is_baodi']=="1"){
					   $baodi_text=$value['progress']."%+".intval(number_format($value['end_price']/$value['copies']*100,2))."%(<span class='red'>保</span>)";
				   }else{
						$baodi_text=$value['progress']."%";
				   }
				}
				$col_username = "<span style='float:left;display:block;width:70px;height:25px;overflow:hidden;' title='".$user['lastname']."'>".$user['lastname']."</span><a style='float:right;*float:right;margin-right:5px;display:block;color:#db8a19' href='javascript:return 0;' onclick='dingzhi(".$value['user_id'].",2,".$value['play_method'].");'>定制跟单</a>";
				if($type=="hm"){
					if(empty($get_expect) or $get_expect>=$new_expect){
						$list_html[]=array(
							"column0"=>$value['id'],
							"column1"=>($key+1),
							"column2"=>$col_username,
							"column3"=>"￥".$value['price']." 元",
							"column4"=>"￥".$value['price_one']." 元",
							"column5"=>$view_url,
							"column6"=>$baodi_text,
							"column7"=>$value['buyed']."份",
							//if(this.value<=0)this.value=1;
							"column8"=>'<input type="text" name="rgfs" class="rec_text" vid="'.$value['basic_id'].'" vlotid="2" vplayid="'.$value['play_method'].'" vonemoney="'.$value['price_one'].'" vsnumber="'.$value['buyed'].'" value="1" vexpect="'.$value['expect'].'" onkeyup="this.value=Y.getInt(this.value);if(this.value>'.$value['buyed'].')this.value='.$value['buyed'].'"/>',
							"column9"=>'<input type="button" value="参与" class="btn_Dora_s m-r" id="b_13262136"/><a href="/zcsf/viewdetail/'.$value['basic_id'].'" target="_blank">详情</a>',
							);
					}else{
						$list_html[]=array(
							"column0"=>$value['id'],
							"column1"=>($key+1),
							"column2"=>$col_username,
							"column3"=>"￥".$value['price']." 元",
							"column4"=>"￥".$value['price_one']." 元",
							"column5"=>$view_url,
							"column6"=>$baodi_text,
							"column7"=>'<a href="/zcsf/viewdetail/'.$value['basic_id'].'" target="_blank">详情</a>',
							);
					}
						//参与提交地址在list.js 781行
				}else{
					$list_html[]=array(
						"column0"=>($key+1),
						"column1"=>$value['expect'],
						"column2"=>$text2.$text1,
						"column3"=>$col_username,
						"column4"=>$view_url,
						"column5"=>$baodi_text,
						"column6"=>"￥".$value['my_copies']*$value['price_one']." 元",
						"column7"=>"<em class=\"red\">".$value['bonus']."</em><span class=\"gray\"></span>",
						"column8"=>substr($value['time_stamp'],0,16),
						"column9"=>"<a href=\"/zcsf/viewdetail/".$value['basic_id']."\" target=\"_blank\">详情</a>",
						);
				}
			}

			switch($play_method) {
			case 1:
				$expect_type = "14";
				break;
			case 2:
				$expect_type = "9";
				break;
			case 3:
				$expect_type = "6";
				break;
			case 4:
				$expect_type = "4";
				break;
			default:
				$sorts = "14";
				break;
			}

			if ($type=="hm"){//合买
				$base_url = "zcsf/ajax_data_lists_hm_".$expect_type."c/".$new_expect;
			}elseif ($type=="my"){//我的
				$base_url = "zcsf/ajax_data_lists_".$expect_type."c/".$status;
			}

			$config['base_url'] = $base_url."/".$total_rows;
			$config['total_items'] = $data_count;//总数量
			$config['query_string']  = 'page';
			$config['items_per_page']  = $total_rows;	//每页显示多少第
			$config['uri_segment']  = $page;//当前页码
			$config['directory']  = "";//当前页码

			$this->pagination = new Pagination($config);
			$this->pagination->initialize();
			//d($this->pagination->render("ajax_page"));

			$str_style2="";
			$str_style3="";
			$str_style1="";
			switch($total_rows){
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

			$page_html ='<span class="l c-p-num">单页方案个数:
			<a style="cursor: pointer;"'.$str_style1.' onclick="javascript:loadDataByUrl(\'/'.$base_url.'/20\',\'list_data\');">20</a>
			<!--<a style="cursor: pointer;"'.$str_style2.' onclick="javascript:loadDataByUrl(\'/'.$base_url.'/30\',\'list_data\');">30</a>-->
			<a style="cursor: pointer;"'.$str_style3.' onclick="javascript:loadDataByUrl(\'/'.$base_url.'/40\',\'list_data\');">40</a>
			</span>
			<span class="r" id="page_wrapper">';
			$page_html .=$this->pagination->render("ajax_page");
			$page_html .='<span class="sele_page">';
			$page_html .='<input id="govalue" name="page" class="" size="3" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\');if(this.value>'.$total_pages.')this.value='.$total_pages.';if(this.value<=0)this.value=1" onkeydown="if(event.keyCode==13){javascript:loadDataByUrl(\'/'.$base_url.'/'.$total_rows.'?page=\' + Y.one(\'#govalue\').value,\'list_data\');return false;}" type="text">';
			$page_html .='<input value="GO" class="btn" onclick="javascript:loadDataByUrl(\'/'.$base_url.'/'.$total_rows.'?page=\' + Y.one(\'#govalue\').value,\'list_data\');return false;" type="button">';
			$page_html .='</span>';
			$page_html .='<span class="gray">共'.$page.'页，'.$data_count.'条记录</span>';
			$page_html .='</span>';
			//d($page_html);
			exit(json_encode(array("list_data"=>$list_html,"page_html"=>$page_html)));
		}else{
			exit(json_encode(array("list_data"=>"没有找到相关的记录！","page_html"=>$page_html)));
		}
	}



	//14场胜负彩—稍候选号
    public function shxh_14c($id=""){
		$this->	sfc_shxh($id,$play_method=1);
	}
	//9场任选—稍候选号
    public function shxh_9c($id=""){
		$this->	sfc_shxh($id,$play_method=2);
	}
	//6场半全场—稍候选号
    public function shxh_6c($id=""){
		$this->	sfc_shxh($id,$play_method=3);
	}
	//4场进球彩—稍候选号
    public function shxh_4c($id=""){
		$this->	sfc_shxh($id,$play_method=4);
	}
	//稍候选号
    public function sfc_shxh($id="",$play_method=""){
		$detail_data=$this->viewdetails($id);
	    if ($detail_data['detail']['is_select_code']==0 and $detail_data['detail']['type']==1){
			$this->template = new View("zcsf/html_".$play_method."_shxh",$detail_data);
			$config_league_matches = kohana::config('league_matches');//获取联赛配置
			$this->template->set("color_list",$config_league_matches['color_list']);
			$this->template->render(TRUE);
		}else{
			exit("<script type='text/javascript'>alert('号码已经选择，无需再选');history.go(-1);</script>");
		}
    }

	//稍候上传
    public function sfc_shsc($id=""){
		$detail_data=$this->viewdetails($id);
	    if ($detail_data['detail']['is_upload']==0 and $detail_data['detail']['type']==3){
			$this->template = new View("zcsf/html_ds_shsc",$detail_data);
			$config_league_matches = kohana::config('league_matches');//获取联赛配置
			$this->template->set("color_list",$config_league_matches['color_list']);
			$this->template->render(TRUE);
		}else{
			exit("<script type='text/javascript'>alert('号码已经上传');history.go(-1);</script>");
		}
    }

	//查看方案详情
    public function viewdetail($id){
		$this->template = new View("zcsf/viewdetail",$this->viewdetails($id));
		$this->template->render(TRUE);
    }

	//查看方案选号(小窗口)
    public function viewdetail_codes($id){
		$this->template = new View("zcsf/viewdetail_codes",$this->viewdetails($id));
		$this->template->render(TRUE);
    }
	//查看彩票编号(小窗口)
    public function viewdetail_number($id){
		$this->template = new View("zcsf/viewdetail_number",$this->viewdetails($id));
		$this->template->render(TRUE);
    }
	//参与合买(小窗口)
    public function viewdetail_join($id=""){
		$data=$this->viewdetails($id);
		$data['buynum'] = $this->input->get('buynum');
		$data['totalbuymoney'] = $this->input->get('totalbuymoney');
		$this->template = new View("zcsf/viewdetail_join",$data);
		$this->template->render(TRUE);
    }

	//查看方案详情
    public function viewdetails($basic_id){

		if(empty($basic_id)){
			 exit("<script type='text/javascript'>alert('错误的ID号');history.go(-1);</script>");
		}

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
			$Plans_sfc_obj =Plans_sfcService::get_instance();
			$data['detail_parent'] = $Plans_sfc_obj->get_by_basic_id($basic_id);
			//d($data['detail_parent']);
			$data['lottery_numbers'] = "";
			//d($data['detail_parent']);

			if(empty($data['detail_parent'])){
			  exit("<script type='text/javascript'>alert('获取数据出错！');history.go(-1);</script>");
			}
			//$data['ticket_numbers']=ticket::get_instance()->get_results_by_ordernum($data['detail_parent']['basic_id']);
			//d($data['ticket_numbers'],false);//获取方案的彩标数据

			if($data['detail_parent']['parent_id']>0){
				$data['detail'] = $Plans_sfc_obj->get_by_id($data['detail_parent']['parent_id']);
			}else{
				$data['detail']	= $data['detail_parent'];
			}

			$data['expect_data'] = Zcsf_expectService::get_instance()->get_expect_info($data['detail']['play_method'],$data['detail']['expect']);
			$data['expect_list']=$this->get_expect_list($data['expect_data'],$data['detail_parent']['expect']);


			if($data['detail_parent']['type']==3){
				$data['buy_end_time']=$this->buy_end_time($data['expect_list'][0]['end_time'],"ds");
			}else{
				$data['buy_end_time']=$this->buy_end_time($data['expect_list'][0]['end_time']);				
			}

			$data['user'] = user::get($data['detail']['user_id']);
			$data['_user'] = $this->_user;
			if ($this->_user['id'] == $data['detail']['user_id']) {
				$data['join_data'] = true;
			}
			else {
				$data['join_data'] = $Plans_sfc_obj->find_join_data($this->_user['id'],$data['detail']['id']); //是否有参与过本方案
			}
			if ($this->_user['id'] == $data['detail']['user_id']) {
				$data['is_public'] = true;
			}
			else {
				$data['is_public'] = $Plans_sfc_obj->plan_open($data['detail'], $data['join_data']);
			}
			//d($data['is_public']);
			
			$data['site_config'] = Kohana::config('site_config.site');
			$host = $_SERVER['HTTP_HOST'];
			$dis_site_config = Kohana::config('distribution_site_config');
			if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
				$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
				$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
				$data['site_config']['description'] = $dis_site_config[$host]['description'];
			}
			//d($data);
			return $data;

        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $data);
        }
    }

	//采集期次数据
    public function get_expect_list($expect_data,$cur_expect,$js=1) {
		//判断是否开销或停售
		if($cur_expect>$expect_data['expects'][count($expect_data['expects'])-1] or $cur_expect<$expect_data['expects'][0]){
			if ($js == 1) {
				echo "<script type='text/javascript'>alert('您好，该期暂未开售，或者已经停止！');history.go(-1);</script>";
			}
		}
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
		return $expect_list;
	}

	//自动兑奖（跟据彩标表里的数据和彩果比较查看是否已经中奖）
    public function auto_compare(){

		/* 初始化默认查询条件 */
		$query_struct_current = array(
			'where'=>array(
				'ticket_type' => 2,//彩种
				'status' => 1,//状态
				//'play_method' => $play_method,//玩法
			),
			'like'=>array(),
			'orderby' => array(
				'id' =>'DESC',
			),
			'limit' => array(
				'per_page' =>10000,//每页的数量
				'page' =>1 //页码
			),
		);

		$ticketobj = Ticket_numService::get_instance();
        $return_data_list = $ticketobj->query_assoc($query_struct_current);
		//d($return_data_list);
		$zj_num=0;
		//找出任9中8场
		$r98_plan_basic_id = array();
		foreach($return_data_list as $key=>$value) {//循环兑奖
			$order_num_ticket = $value['order_num'];
			$play_method=$value['play_method'];
			$codes_data=explode(";",$value['codes']);
			$codes=$codes_data[0];
			$type=$codes_data[1];
			$expect=$codes_data[2];
			$Zcsf_expect_obj=Zcsf_expectService::get_instance();
			$expect_data=$Zcsf_expect_obj->get_expect_info($play_method);
			$expect_list=$this->get_expect_list($expect_data,$expect,0);	//赛事场次列表
			$cai_result_status=1;
			$cai_result="";
			//d($expect_list);
			$r98_flag = false;
			foreach($expect_list as $k=>$val){//获得彩果
				if ($play_method==1 or $play_method==2 or $play_method==3) {
					$cai_result[]=$val['cai_result'];
				}
				elseif($play_method==4) {
					$tmp_data=explode(",",str_replace("+","",$val['cai_result']));
					if($val['cai_result']===""){
						$cai_result[]="";
						$cai_result[]="";
					}else{
						$cai_result[]=$tmp_data[0];
						$cai_result[]=$tmp_data[1];
					}
				}
				if($val['cai_result']==="") {
					$cai_result_status=0;
				}
			}
			//d($type);
			if($cai_result_status==1) {
				if($type==1) {
					$compare_res = $this->compare($codes,$cai_result,$play_method,$type);
					//d($compare_res,false);
					if ($compare_res === 1) {
						$ticketobj->update_ticket_zcsf($value['id'],-9999);
						$zj_num++;
						$zj_status=" 中奖";
					}
					else {
						if ($compare_res === 'r98') {
							$r98_flag = true;
						}
						$ticketobj->update_ticket_zcsf($value['id'],0);
						$zj_status=" 未中奖";
					}
				}
				else {
					$codes_list=explode("|",$codes);
					$ds_price_num = 0;
					foreach($codes_list as $k=>$val){//获得彩果
						$ds_compare_res = $this->compare($val,$cai_result,$play_method,$type);
						//d($ds_compare_res);
						if ($ds_compare_res === 1) {
							$zj_num++;
							$zj_status=" 中奖";
							$ds_price_num++;
						}
						else {
							if ($ds_compare_res === 'r98') {
								$r98_flag = true;
							}
							$zj_status=" 未中奖";
						}
					}
					if ($ds_price_num > 0) {
						$ticketobj->update_ticket_zcsf($value['id'],-9999);
					}
					else {
						$ticketobj->update_ticket_zcsf($value['id'],0);
					}
				}
				echo "ID:".$value['id'].$zj_status."<br>";
			}
			else {
				echo "ID:".$value['id']." 未开奖<br>";
			}
			//if ($zj_num > 0) die();
			//d($r98_flag);
			if ($r98_flag == true && in_array($order_num_ticket, $r98_plan_basic_id) == false) {
				$r98_plan_basic_id[] = $order_num_ticket;
			}
		}
		if($zj_num>0) {
			echo "共扫描了".count($return_data_list)."条数据，有".$zj_num."条中奖<br>";
		}
		else {
			echo "没有要兑奖的彩票";
		}
		//d($r98_plan_basic_id);
		if (count($r98_plan_basic_id) > 0) {
			$planobj = Plans_sfcService::get_instance();
			for ($i = 0; $i < count($r98_plan_basic_id); $i++) {
				$planobj->add_bonus_r98($r98_plan_basic_id[$i]);
			}
		}
	}

	//14场单式兑奖
    public function compare($codes="",$cai_result="",$play_method="1",$type="1"){

		//$cai_result=array(0,1,3,1,0,3,0,1,3,0,1,0,3,3);//彩果测试数据
		//$codes="01310301301033";//中奖测试数据
		//$codes="31031030100021";//未中奖测试数据

		//$cai_result=array(0,1,3,1,0,3,0,1,3,0,1,0,3,3);//彩果测试数据
		//$codes="10-1-3-31-0-3-310-1-3-0-1-310-3-31";//中奖测试数据
		//$codes="310-1-0-3-1-30-3-0-1-310-0-0-3-1";//未中奖测试数据

		switch($play_method) {
		case 1:
			$max_num = "14";
			break;
		case 2:
			$max_num = "9";
			break;
		case 3:
			$max_num = "12";
			break;
		case 4:
			$max_num = "8";
			break;
		}

		$num_ok=0;
		$dj_2=0;
		$dj_1=0;

		if($type==1) {
			//复式
			$arr_codes = explode("-",str_replace("*","9",$codes));//将*号转成数字9否则判断会出错
			foreach($arr_codes as $key=>$value){
				 $arr_code_value = str_split($value);
				 if($cai_result[$key]=="*"){
					 $num_ok++;
				 }
				 else{
					 if(in_array($cai_result[$key],$arr_code_value) || ($cai_result[$key] == '310' && !in_array('9', $arr_code_value))) {
						 $num_ok++;
					 }
				}
			}
		}
		elseif($type==3) {
			//单式
			$arr_codes = str_split(str_replace("*","9",$codes));//将*号转成数字9否则判断会出错
			foreach($arr_codes as $key=>$value){
				if($cai_result[$key]=="*"){
					$num_ok++;
				}else{
					 if($value==$cai_result[$key]  || ($cai_result[$key] == '310' && $value != 9)) {
						  $num_ok++;
					 }
				}
			}
		}
		//var_dump($num_ok);
		if ($num_ok == $max_num) {
			$dj_1++;//一等奖中奖注数
		}
		if ($max_num == 14) {
			if($num_ok == 13) {
				$dj_2++;//二等奖中奖注数
			}
		}
		//d($play_method);
		//任9中8场
		if ($play_method == 2 && $num_ok == 8) {
			return 'r98';
		}
		
		if($dj_1>0 or $dj_2>0){
			return 1;//中奖
		}else{
			return 0;//未中奖
		}
	}


	/*
	 * 参与合买人员
	 */
	public function join_users($type = 'all')
	{
		$get_page = intval($this->input->get('page'));
		$order_num = $this->input->get('pid');                     //订单号码
		$page = !empty($get_page) ? intval($get_page) : "1";             //页码
		$pagesize = intval($this->input->get('pagesize'));
		$orderstr = intval($this->input->get('orderstr'));
		$orderby = $this->input->get('orderby');
		$total_rows = 10;
		$total_rows = !empty($pagesize) ? $pagesize : $total_rows; //页码
        
        $return = array();        
	    $user = $this->_user;
        //echo $order_num;
	    if (empty($order_num))
            exit();

        $planobj = Plans_sfcService::get_instance();
        $planbasicobj = Plans_basicService::get_instance();
        $userobj = user::get_instance();
        
        $result_parent = $planobj->get_by_order_id($order_num); 
                
        if (empty($result_parent))
            exit();
        
		/* 初始化默认查询条件 */
		$query_struct = array(
			'where'=>array(
		        'parent_id' => $result_parent['id'],
			),
			'orwhere'=>array(
		        'id' => $result_parent['id'],
			),			
			'like' => array(),
			'orderby' => array(),
			'limit' => array(
				'per_page' =>$total_rows,//每页的数量
				'page' =>$page //页码
			),
		);

		if (!empty($orderstr))
		{
		    switch ($orderstr)
		    {
		        case 1:
		            $orderstr = 'my_copies';
		            break;
		        case 2:
		            $orderstr = 'time_stamp';
		            break;
		        default:
		            $orderstr = '';
		    }
		}
				
		if (!empty($orderby))
		{
		    switch ($orderby)
		    {
		        case 'desc':
		           $orderby = 'DESC'; 
		           break;
		        case 'asc':
		           $orderby = 'ASC';
		           break;
		        default:
		           $orderby ='';
		    }
		}
		
		if (!empty($orderstr) && !empty($orderby))
		{
		    $query_struct['orderby'] = array($orderstr=>$orderby);
		}
		else
		{
		    $query_struct['orderby'] = array('time_stamp'=>'DESC');
		}
        
		$totalcount = $planobj->query_count($query_struct);        //总记录数	
		
		if ($type == 'my')
		{
		    if (empty($this->_user))
		    {
		        $query_struct['where'] = array(
		        							'user_id'=>-1000,
		                                );
		        $query_struct['orwhere'] = array();
		    }
		    else
		    {
		        $query_struct['or_where'] = array(
                                            	'parent_id' => $result_parent['id'],
                                            	'id' => $result_parent['id'],        		                                        
		                                    );
                $query_struct['where'] = array(
                                            	'user_id' => $this->_user['id'],
		                                    );
		        $query_struct['orwhere'] = array();
		    }	
			
			
		}
		
		//d($query_struct);
		
		$data_list = array();
		$results = $planobj->query_assoc($query_struct);           //数据列表
		$data_count = $planobj->query_count($query_struct);        //总记录数		
		$total_pages = ceil($data_count / $total_rows);            //总页数  
        
		$data_list['totalrows'] = $data_count;
		$data_list['pagecount'] = $total_pages;
        $data_list['totalcount'] = $totalcount;
        $data_list['buymumber'] = $result_parent['copies']-$result_parent['buyed'];  //认购份数
		//$data_list['buymoney'] = $result_parent['buyed'] * $result_parent['price_one'] - $result_parent['my_copies'] * $result_parent['price_one']; //认购金额
  
		$data_list['buymoney'] = ($result_parent['copies']-$result_parent['buyed']) * $result_parent['price_one']; //认购金额
  
        
		$i = 0;
		foreach ($results as $rowlist)
		{   
		    $basics = $planbasicobj->get_by_ordernum($rowlist['basic_id']); 
		    
		    if ($result_parent['bonus'] > 0)
		    {
		        if (empty($basics['bonus']))
		        {
		            $basics['bonus'] = '暂未派奖';
		        }
		    }
		    $curuser = $userobj->get($rowlist['user_id']);
		    $data_list['data'][$i]['username'] = $curuser['lastname'];
		    $data_list['data'][$i]['getnum'] = $rowlist['my_copies'];
		    $data_list['data'][$i]['getmoney'] = $basics['bonus'];
		    $data_list['data'][$i]['paymoney'] = $result_parent['price_one'] * $rowlist['my_copies'];
		    $data_list['data'][$i]['rgperstr'] = sprintf("%01.2f", ($rowlist['my_copies'] / $result_parent['copies']));
		    $data_list['data'][$i]['addtime'] = $rowlist['time_stamp'];
		    $i++;
		}
		//d($data_list);
        exit(json_encode($data_list));
	}
	
	public function cancel_plan($order_num) {
		$plan_basic_obj = Plans_basicService::get_instance();
		$userid = $this->_user['id'];
		if ($plan_basic_obj->is_cancel_plan($order_num, $userid) == true) {
			$planobj = plan::get_instance();
			$planobj->cancel_plan($order_num);
		}
		header("Location: /zcsf/viewdetail/".$order_num);
		exit();
	}

}


//生成随机验证码
function rand_str($len=6) {
	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; // characters to build the password from
    mt_srand((double)microtime()*1000000*getmypid()); // seed the
    $password='';
    while(strlen($password)<$len)
        $password.=substr($chars,(mt_rand()%strlen($chars)),1);
    return $password;
}

function mkdirs($dir, $mode = 0777)
{
	if (is_dir($dir) || @mkdir($dir, $mode)) return TRUE;
	if (!mkdirs(dirname($dir), $mode)) return FALSE;
	return @mkdir($dir, $mode);
}