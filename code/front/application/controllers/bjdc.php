<?php defined('SYSPATH') OR die('No direct access allowed.');

class Bjdc_Controller extends Template_Controller {
    
	const PLAY_TYPE = 7;
	
	public $play_type_array = array(9=>'7');
   	public $betid_array = array(
   		34=>'501',
   		40=>'503',
   		41=>'502',
   		42=>'504',
   		51=>'505'
   	);
   	public $back_url = array('501'=>'rqspf','502'=>'sxds','503'=>'zjqs','504'=>'bf','505'=>'bqc');
   	public $play_method_array = array(
   		27=>1,
   		1=>21,
   		2=>23,
   		3=>31,
   		5=>34,
   		6=>37,
   		7=>41,
   		9=>45,
   		12=>411,
   		13=>415,
   		14=>51,
   		28=>56,
   		29=>516,
   		18=>526,
   		19=>531,
   		20=>61,
   		30=>67,
   		31=>622,
   		32=>642,
   		25=>657,
   		26=>663,
   		35=>71,
   		36=>81,
   		37=>91,
   		38=>101,
   		39=>111,
   		40=>121,
   		41=>131,
   		42=>141,
   		43=>151	
   	);
   	
	/**
	 * 根据彩种id获得期号
	 * Enter description here ...
	 * @param unknown_type $betid
	 */
	private function getCurrentIssuesByBetid($betid) {
		$objmatch = match_bjdc::get_instance();
		$result = $objmatch->getIssuesByBetid($betid);
		return $result;
	}
	
	public function getBjdcDate($betid, $issue = NULL, $search_date = NULL) {
		$objmatch = match_bjdc::get_instance();
        $issues = array();
        $issues = $this->getCurrentIssuesByBetid($betid);
        if ($issue != NULL) {
        	$default_issue_number = $issue;
        }
        else {
        	$default_issue_number = $issues[0]['number'];
        }
        $matchs_data = array();
        $matchs_data['data'] = $objmatch->getMatchsByIssue($betid, $default_issue_number);
        //var_dump($matchs_data['data']);die();
        if (count($matchs_data['data']) <= 0) {
        	$default_issue_number = $issues[1]['number'];
        	$matchs_data['data'] = $objmatch->getMatchsByIssue($betid, $default_issue_number, 1);
        }
        
        $matchs_data['current_issue'] = $default_issue_number;
        
        foreach ($matchs_data['data'] as $row) {
        	if (!isset($match_last_stoptime)) $match_last_stoptime = $row['stoptime'];
        	if ($row['stoptime'] > $match_last_stoptime) $match_last_stoptime = $row['stoptime'];
        	if (!isset($matchs_data['match_league'][$row['league']])) {
        		$matchs_data['match_league'][$row['league']] = 0;
        	}
        	if (array_key_exists($row['league'], $matchs_data['match_league'])) {
        		$matchs_data['match_league'][$row['league']]++;
        	}
        	$ymd = date("Y-m-d", strtotime($row['playtime']));
        	$matchs_data['match_datetime'][$ymd] = tool::get_weekday($ymd);
        }
        $matchs_data['issues'] = $issues;
        $matchs_data['match_last_stoptime'] = $match_last_stoptime;
        return $matchs_data;
	}
	
    /**
     * 让球胜平负
     * Enter description here ...
     */
	public function rqspf($issue = NULL, $search_date = NULL) {
		$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
		$betid = 501;
		$matchs_data = $this->getBjdcDate($betid, $issue, $search_date);
		
		$matchs_data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$matchs_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$matchs_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$matchs_data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $viewpage = 'bjdc/rqspf';
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
            $this->template = new View($viewpage, $matchs_data);
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	}
    
	/**
	 * 上下单双
	 * Enter description here ...
	 */
	public function sxds($issue = NULL, $search_date = NULL) {
		$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
		$betid = 502;
		$matchs_data = $this->getBjdcDate($betid, $issue, $search_date);
		
		$matchs_data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$matchs_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$matchs_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$matchs_data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $viewpage = 'bjdc/sxds';
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
            $this->template = new View($viewpage, $matchs_data);
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
		
	}
	
	/**
	 * 比分
	 * Enter description here ...
	 */
	public function bf($issue = NULL, $search_date = NULL) {
		$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
		$betid = 504;
		$matchs_data = $this->getBjdcDate($betid, $issue, $search_date);
		
		$matchs_data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$matchs_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$matchs_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$matchs_data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $viewpage = 'bjdc/bf';
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
            $this->template = new View($viewpage, $matchs_data);
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	}
	
	/**
	 * 半全场
	 * Enter description here ...
	 * @param int $type 投注方式：单式投注、复式投注、倍投、过关投注
	 */
    public function bqc($issue = NULL, $search_date = NULL) {
    	$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
		$betid = 505;
		$matchs_data = $this->getBjdcDate($betid, $issue, $search_date);
		
		$matchs_data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$matchs_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$matchs_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$matchs_data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $viewpage = 'bjdc/bqc';
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
            $this->template = new View($viewpage, $matchs_data);
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    }
    
    /**
     * 总进球数
     * Enter description here ...
     * @param int $type 投注方式：单式投注、复式投注、倍投、过关投注
     */
    public function zjqs($issue = NULL, $search_date = NULL) {
    	$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
		$betid = 503;
		$matchs_data = $this->getBjdcDate($betid, $issue, $search_date);
		
		$matchs_data['site_config'] = Kohana::config('site_config.site');
		$host = $_SERVER['HTTP_HOST'];
		$dis_site_config = Kohana::config('distribution_site_config');
		if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
			$matchs_data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
			$matchs_data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
			$matchs_data['site_config']['description'] = $dis_site_config[$host]['description'];
		}
		
        $viewpage = 'bjdc/zjqs';
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
            $this->template = new View($viewpage, $matchs_data);
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    }
    
	/**
	 * 订单验证或详细设置
	 * Enter description here ...
	 */
    public function toBuy() {
    	//header("Location: /bjdc/rqspf");
    	//exit();
        $session = Session::instance();
        if (empty($_POST))
        {
            $_POST = $session->get('plans_infos_bjdc');  
            if (empty($_POST))
            {
                exit('Error submit!');
            }
        }
        else 
        {
            $session->set('plans_infos_bjdc', $_POST);  //存储信息到session
        }
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        
        try {
        	    /*
        	     * [play_type] => 7
			    [betid] => 501
			    [issue] => 110808
			    [codes] => 13:[胜]/14:[胜]/15:[胜]/16:[胜]
			    [danma] => 
			    [gggroup] => 3
			    [sgtypename] => 2串1,3串1,4串1
			    [sgtype] => 1,3,7
			    [zhushu] => 11
			    [beishu] => 1
			    [totalmoney] => 22
			    [IsCutMulit] => 1
			    [ishm] => 0
			    
			    [play_type] => 7
			    [betid] => 502
			    [issue] => 110707
			    [codes] => 1:[上+单]/3:[上+单,上+双,下+单,下+双]/4:[上+双,下+单,下+双]
			    [danma] => 
			    [danma_str] => 
			    [gggroup] => 3
			    [sgtypename] => 2串1
			    [sgtype] => 1
			    [zhushu] => 19
			    [beishu] => 1
			    [totalmoney] => 38
			    [IsCutMulit] => 1
			    [ishm] => 0
			    *
			    */
            $data = array();
            $data['site_config'] = Kohana::config('site_config.site');
            $data['ticket'] = Kohana::config('ticket_type');            
            $data['play_type'] = $this->play_type_array[$this->input->post('lotid')];
            $data['betid'] = $this->betid_array[$this->input->post('playid')];//彩种id
            $data['issue'] = $this->input->post('expect');//期数
            $data['codes'] = $this->input->post('codes');//购买信息
            $data['danma'] = $this->input->post('danma');//胆码
            $data['danma_str'] = $this->input->post('danma');//胆码
            $data['gggroup'] = $this->input->post('gggroup');
            $data['sgtypename'] = $this->input->post('sgtypename');//串法名称
            $data['sgtype'] = $this->input->post('sgtype');//串法编号
            $data['zhushu'] = $this->input->post('zhushu');//注数
            $data['beishu'] = $this->input->post('beishu');//倍数
            $data['totalmoney'] = $this->input->post('totalmoney');//总金额
            $data['IsCutMulit'] = $this->input->post('IsCutMulit');//复式/单式投注
            $data['ishm'] = $this->input->post('ishm');//是否合买
            $data['title'] = $data['issue'].'期'.$data['ticket']['method'][$data['play_type']][$data['betid']];
            $data['content'] = '随缘！买彩票讲的是运气、缘分和坚持。';
            $plans_obj = Plans_bjdcService::get_instance();
        	//检查参数,验证客户端提交的价格,数量等是否正确
            //彩票拆分
            $testarr = array();
            $testarr = $plans_obj->get_tickets(999, $data['play_type'], $data['codes'], $data['sgtypename'], $data['danma'], $data['beishu'], '999', $data['issue'], TRUE);
            $testmoney = 0;
            foreach ($testarr as $rowarr)
            {
                $testmoney += $rowarr['money'];
            }
			$data['totalmoney'] = $testmoney;
            $data['zhushu'] = $testmoney / ($data['beishu']*2);
            $objmatch = match_bjdc::get_instance();
            $matchs_info = array();
            $stop_time = array();
            $code_t1 = explode('/', $data['codes']);
            $ratelist = array();
            for ($i = 0; $i < count($code_t1); $i++) {
            	$t1 = explode(':', $code_t1[$i]);
            	$match_no = $t1[0];
            	
            	$no_len = strlen($match_no)+2;
            	$t2 = substr(substr($code_t1[$i], $no_len), 0, -1);

            	$matchs_info[$i]['info'] = $objmatch->getMatchInfoByBetidIssueNo($data['betid'], $data['issue'], $match_no);
            	$stop_time[$i] = $matchs_info[$i]['info']['stoptime'];
            	$sp = json_decode($matchs_info[$i]['info']['sp']);
            	
            	$t3 = explode(',', $t2);
            	$my_choose = array();
            	$result_sp = array();
            	$bjdc_config = Kohana::config('bjdc');
            	for ($j = 0; $j < count($t3); $j++) {
            		switch ($data['betid']) {
            			case '501': $choose_sp = $sp->{$bjdc_config['spf_result'][$t3[$j]]};break;
            			case '502': $choose_sp = $sp->{$bjdc_config['sxds_result'][$t3[$j]]};break;
            			case '503': $choose_sp = $sp->{$bjdc_config['zjqs_result'][$t3[$j]]};break;
            			case '504': $choose_sp = $sp->{$bjdc_config['bf_result'][$t3[$j]]};break;
            			case '505': $choose_sp = $sp->{$bjdc_config['bqc_result'][$t3[$j]]};break;
            		}
            		$my_choose[$t3[$j]] = $choose_sp;
            		$result_sp[$j] = $t3[$j].'#'.$choose_sp;
            	}
            	$matchs_info[$i]['choose'] = $my_choose;
            	//1:[胜#3.23]/2:[胜#5.09,平#4.05,负#1.80]/3:[负#2.15]"
            	$ratelist[$i] = $match_no.':['.implode(',', $result_sp).']';
            }
            $data['ratelist'] = implode('/', $ratelist);
            array_multisort($stop_time, SORT_ASC);
            $data['stoptime'] = $stop_time[0];
            $data['match_info'] = $matchs_info;
            $danma = array();
            if (isset($data['danma']) && $data['danma'] != '') {
            	$dm_t1 = explode('/', $data['danma']);
            	for ($i = 0; $i < count($dm_t1); $i++) {
            		$t1 = explode(':', $dm_t1[$i]);
            		$match_no = $t1[0];
            		$danma[$match_no] = 1;
            	}
            }
            $data['danma'] = $danma;
            $data['back_url'] = $this->back_url[$data['betid']];
            $this->template = new View('bjdc/tobuy', $data);
            $this->template->set_global('_user', $this->_user);

            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
            
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }

        $this->template->render(TRUE);
    }
	
    /**
     * 提交订单
     * Enter description here ...
     */
    public function pute() {
    	$msg = array();
        /*$msg['errcode'] = -1;
        $msg['headerurl'] = '';*/
    	$msg['error'] = 1;
    	$msg['url'] = '';
        $msg['msg'] = '提交时发生了一个错误!';
        if (empty($_POST))
            exit(json_encode($msg));
        
		//$msg['msg'] = '暂不可以投注';
	    //exit(json_encode($msg));
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        try {
            $databasic = array();
            $data = array();
            /**
				lotid:7
				playid:501
				playtype:501
				expect:110809
				beishu:5
				codes:46:[胜]/47:[胜]/48:[胜]/49:[胜]
				danma:
				totalmoney:70
				ratelist:46:[胜#2.48]/47:[胜#2.21]/48:[胜#2.68]/49:[胜#2.0]
				IsCutMulit:1
				gggroup:3
				sgtype:1,7
				sgtypename:2串1,4串1
				ishm:0
             */
            $databasic['user_id'] = $this->_user['id'];
            $databasic['start_user_id'] = $this->_user['id'];
            $databasic['ticket_type'] =  $this->input->post('lotid');
            $databasic['play_method'] = $this->input->post('playtype');
            $databasic['date_end'] = $this->input->post('endtime');
            $databasic['plan_type'] = $this->input->post('ishm');
            
            $data['price'] = $this->input->post('totalmoney');
            $data['is_hemai'] = $this->input->post('ishm');
            $data['issue'] = $this->input->post('expect');
            //exit(json_encode($data));
            //再次验证价格
            $userobj = user::get_instance();
            $usermoney = $userobj->get_user_money($this->_user['id']);
            $create_ticket = TRUE;
            
        	//验证赛事是否过期
        	$match_bjdc_obj = match_bjdc::get_instance();
        	$data['codes'] = $this->input->post('codes');
        	$match_no_arr = array();
        	$code_t1 = explode('/', $data['codes']);
			for ($i = 0; $i < count($code_t1); $i++) {
				$t1 = explode(':', $code_t1[$i]);
				$match_no = $t1[0];
				$match_info = $match_bjdc_obj->getMatchInfoByBetidIssueNo($databasic['play_method'], $data['issue'], $match_no);
				$stoptime = $match_info['stoptime'];
				$stoptime_str = strtotime($stoptime);
				if (time() >= $stoptime_str) {
					$msg['msg'] = '您所选的有过期的赛事， 请重新选择下注';
                	exit(json_encode($msg));
				}
			}
            
			$totalmoney = $this->input->post('totalmoney');
        	//合买操作
            if ($data['is_hemai'] == 1) 
            {
                $data['plan_type'] = 1;                     //是否合买
                $data['status'] = 1;                        //方案状态
                $data['zhushu'] = $this->input->post('zhushu');
                $data['my_copies'] = $this->input->post('buynum');
                $data['deduct'] = $this->input->post('tcbili');
                $data['baodinum'] = $this->input->post('baodinum');
               	$data['copies'] = $this->input->post('allnum');
                $data['price_one'] = $data['price'] / $data['copies'];
                
                $data['title'] = $this->input->post('title', NULL);
                $data['content'] = $this->input->post('content', NULL);
                $data['friends'] = $this->input->post('buyuser', NULL);
                $data['isset_buyuser'] = $this->input->post('isset_buyuser');
                $data['total_price'] = $totalmoney;
                $data['price'] = $data['price_one'] * $data['my_copies'] + $data['price_one'] * $data['baodinum'];
                $data['progress'] = intval($data['my_copies']/$data['copies'] * 100);
                $data['buyed'] = $data['my_copies'];
                $data['surplus'] = $data['copies'] - $data['buyed'];
                
           	 	if ($data['isset_buyuser'] == 1)
                {
                    $data['friends'] = '';
                } 
                if($data['zhushu'] != $data['my_copies'])
                {
                    $create_ticket = FALSE;
                    $data['status'] = 0;
                }
            }
        	else
            {
                $data['plan_type'] = 0;          //是否合买
                $data['status'] = 1;             //方案状态
                $data['progress'] = 100;         
                $myprice = $data['price'];
                $data['price_one'] = $myprice;
                $data['total_price'] = $myprice;
                $data['zhushu'] = $this->input->post('zhushu');
                $data['buyed'] = 1;
                $data['my_copies'] = 1;
                $data['copies'] = 1;
                $data['surplus'] = 0;
            }
            
            if ($usermoney < $data['price'])
            {   
                $msg['msg'] = '余额不足，请先充值后再购买！';
                exit(json_encode($msg));
            }
            
        	//检查限号
            $data['time_end'] = $this->input->post('endtime');
            if (strtotime($data['time_end']) < time())
            {
                $msg['msg'] = '方案已截止，请检查是否有截止的赛事！';
                exit(json_encode($msg));
            }
            
            $data['ticket_type'] =  $databasic['ticket_type'];
            $data['play_method'] = $databasic['play_method'];
            $data['issue'] = $this->input->post('expect');
            $data['user_id'] = $this->_user['id'];
            $data['codes'] = $this->input->post('codes');
            $data['start_user_id'] = $this->_user['id'];
            $data['user_id'] = $this->_user['id'];
            $data['special_num'] = $this->input->post('danma');
            $data['typename'] = $this->input->post('sgtypename');
            $data['gggroup'] = $this->input->post('gggroup');
            $data['is_hemai'] = $this->input->post('ishm');
            $data['rate'] = $this->input->post('beishu');
            $data['gggroup'] == 2 && $data['special_num'] = NULL;
            
            $plans_basic_obj = Plans_basicService::get_instance();
            $plans_obj = Plans_bjdcService::get_instance();
            
        	//检查参数,验证客户端提交的价格,数量等是否正确
            //彩票拆分
            $testarr = array();
            $testarr = $plans_obj->get_tickets(999, $data['play_method'], $data['codes'], $data['typename'], $data['special_num'], $data['rate'], '999', $data['issue'], TRUE);
            $testmoney = 0;
            foreach ($testarr as $rowarr)
            {
                $testmoney += $rowarr['money'];
            }
			//$msg['msg'] = $testmoney.'|'.$data['price'];
           	//exit(json_encode($msg));
            if ($testmoney != $totalmoney)
            {
                $msg['msg'] = '数据异常！'.$testmoney.'+'.$totalmoney;
                exit(json_encode($msg));
            }
            
            $basic_id = $plans_basic_obj->add($databasic);
            if (!$basic_id) {
            	$msg['msg'] = '添加基表出错!';
                exit(json_encode($msg));
            }
            $data['basic_id'] = $basic_id;
            
            
            if (!($id = $plans_obj->add($data))) {
                $msg['msg'] = '添加订单出错!';
                exit(json_encode($msg));
            }
            else 
            {
                $session = Session::instance();           
                $session->set('buywin_id', $id);
                //购买成功则扯分彩票存入彩票表,打印彩票的格式
                if ($create_ticket) {
                	//$codes = $data['codes'].';'.$data['issue'];
                	$res_ticket = $plans_obj->get_tickets($id, $data['play_method'], $data['codes'], $data['typename'], $data['special_num'], $data['rate'], $data['basic_id'], $data['issue']);
                	if ($res_ticket == false) {
                		//$msg['error'] = 0;
		            	//$msg['success'] = 0;
		                $msg['msg'] = '存入打票表失败!';
		                exit(json_encode($msg));
                	}
                }
                
                //记录日志
	            $data_log = array();
	            $data_log['order_num'] = $basic_id; 
	            $data_log['user_id'] = $this->_user['id']; 
	            $data_log['log_type'] = 2;	//参照config acccount_type 设置
	            $data_log['is_in'] = 1;
	            $data_log['price'] = $data['price'];
	            $data_log['user_money'] = $usermoney;
	            $lan = Kohana::config('lan');
	            $data_log['memo'] = $lan['money'][4];
	            if (!empty($data['baodinum'])) {
	            	$data_log['memo'] .= ','.$lan['money'][5];
	            }
	            $acc_log_re = account_log::get_instance()->add($data_log);
                
	            if ($acc_log_re == true) {
	                $ticketobj = ticket::get_instance();
	                $tickets = $ticketobj->getTicketByPlanID($id, $data['basic_id']);
	                //$post_ticket_fail = $plans_obj->post_ticket_happypool($tickets, $data['issue']);
	                $post_ticket_fail = true;
	                $msg['error'] = 0;
		            $msg['success'] = 1;
		            $msg['url'] = '/bjdc/buyok/';
		            $plans_obj->update_status($id, $data['status']);
		            if (is_array($post_ticket_fail) && count($post_ticket_fail) > 0) {
		            	$ticket_id = array();
		            	for ($i = 0; $i < count($post_ticket_fail); $i++) {
		            		$ticket_id[] = $post_ticket_fail[$i]['id'];
		            	}
		            	$u = $ticketobj->update_status($ticket_id, -1, array('0'), $this->_user['id']);
		            }
	            }
	            else {
	            	$msg['msg'] = '帐号异常!';
	            }
            }
            exit(json_encode($msg));
            
            //提交表单和显示
            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
            
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }
    }
    
    /**
     * 成功提交订单
     * Enter description here ...
     */
    public function buyok()
    {
    	
        $session = Session::instance();           
        $id = $session->get('buywin_id');
        
        if (empty($id))
        {
            url::redirect('/error404?msg=该页面已过期');
            exit;
        }
        
        $plans_obj = Plans_bjdcService::get_instance();
        $data = $plans_obj->get_by_id($this->_user['id'], $id);
        $data['usermoney'] = user::get_instance()->get_user_money($this->_user['id']);
        $data['back_url'] = $this->back_url[$data['play_method']];
        $data['site_config'] = Kohana::config('site_config.site');
        if (empty($data))
        {
            url::redirect('/error404?msg=页面已过期');
            exit;
        }
                
        $session->delete('buywin_id');
        $session->delete('plans_infos');
        
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

            $this->template = new View('bjdc/buy_success', $data);
            $this->template->set_global('_user', $this->_user);
            
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }        
        
        $this->template->render(TRUE);
    }    
    
	public function my($status='ing') {
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );   
        
        if ($status != 'ing')
        {
            $status = 'end';
        }
        
        try 
        {
            $data = array();
            $data['site_config'] = Kohana::config('site_config.site');
            $data['status'] = $status;            
            $viewpage = 'bjdc/my';

            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
    		
            $this->template = new View($viewpage, $data);
            $this->template->set_global('_user', $this->_user);
        
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    }
    
    public function my_ajax($status='ing', $page_size = 10)
    {
        $user = $this->_user;
        $userobj = user::get_instance();
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );   
        
        $get_page = intval($this->input->get('page'));
  		$page = !empty( $get_page ) ? intval($get_page) : "1";//页码
		$total_rows = !empty( $page_size ) ? intval($page_size) : "10";//第页显示条数      
        
        if ($status != 'ing')
        {
            $status = 'end';
        }
        
        try 
        {
            $request_data = $this->input->get();
            
            //初始化默认查询结构体 
            $query_struct_default = array (
                'where' => array (
                    'user_id' => $this->_user['id']
                ), 
                'orderby' => array (
                    'id' => 'DESC'
                ), 
                'limit' => array (
                    'per_page' => $total_rows,
                    'page' => 1
                )
            );
            
            if ($status=='ing')
            {
                $query_struct_default['where']['status <='] = 2;
                $base_url = '/bjdc/my';
            }            
            else 
            {
                $query_struct_default['where']['status >'] = 2;
                $base_url = '/bjdc/my/end/';
            }
            
            $data = array();
            $data['status'] = $status;
            
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
            $planobj = Plans_bjdcService::get_instance();
            $data['count'] = $planobj->count($query_struct_current);    //统计数量
            
            // 模板输出 分页
            $this->pagination = new Pagination(array (
                'base_url' => $base_url,
                'query_string' => 'page',
                //'uri_segment' => 'page',
                'total_items' => $data['count'],
                'items_per_page' => $query_struct_current['limit']['per_page'],
                'directory' => '',
            ));
    
            $query_struct_current['limit']['page'] = $this->pagination->current_page;
            $data['list'] = $planobj->query_assoc($query_struct_current);
            
            $list_html = array();
            $pagesize =  $query_struct_default['limit']['per_page'];
            $total_pages = ceil($data['count'] / $pagesize);//总页数
            
            $ticket_type = Kohana::config('ticket_type');
            $ticket_type = $ticket_type['method'][7];
            
            $i = 1;
            if ($this->pagination->current_page > 1)
            {
                $i = $this->pagination->current_page * $pagesize + 1;
            }

            $j = 0;
            foreach ($data['list'] as $row)
            {
                $parents = array();
                $start_user_name = $this->_user['lastname'];
                if ($row['parent_id'] > 0)
                {
                    $parents = $planobj->get_parent_id($row['parent_id']);
                    if (empty($parents))
                        continue;
                        
                    $start_user = $userobj->get($parents['user_id']);
                    
                    if(empty($start_user))
                    {
                        $start_user_name = '';
                    }
                    else 
                    {
                        $start_user_name = $start_user['lastname'];
                    }
                }
                
                $list_html[$j]['column0'] = $i;
                $list_html[$j]['column1'] = empty($ticket_type[$row['play_method']]) ? '' : $ticket_type[$row['play_method']];
                $list_html[$j]['column2'] = $start_user_name;
                $list_html[$j]['column3'] = $row['typename'];
                $list_html[$j]['column4'] = $row['parent_id'] > 0 ? $parents['progress'].'%' : $row['progress'].'%';
                if ($row['status'] == 1) $bonus = '未结算';
                else {
                	if ($row['bonus'] == NULL) $bonus = '0￥';
                	else $bonus = $row['bonus'].'￥';
                }
                $list_html[$j]['column5'] = $row['price'];
                $list_html[$j]['column6'] = $bonus;
                $list_html[$j]['column7'] = $row['time_stamp'];
                $list_html[$j]['column8'] = "<a href=\"/bjdc/viewdetail/".$row['basic_id']."\" target=\"_blank\">详情</a>";
                $j++;
            }
            
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
            
        	$str_style2 = "";
			$str_style3 = "";
			$str_style1 = "";
			switch($pagesize){
				case 20:
				  $str_style1 = ' class="on"';
				  break;
				case 30:
				  $str_style2 = ' class="on"';
				  break;	
				case 40:
				  $str_style3 = ' class="on"';
				  break;
			}
			
			$page_html = '';
			
			if ($data['count'] > 0)
			{
    			$page_html ='<span class="l c-p-num">单页方案个数：
    			<a style="cursor: pointer;"'.$str_style1.' onclick="javascript:loadDataByUrl(\''.$base_url.'/20\',\'list_data\');">20</a>
    			<a style="cursor: pointer;"'.$str_style2.' onclick="javascript:loadDataByUrl(\''.$base_url.'/30\',\'list_data\');">30</a>
    			<a style="cursor: pointer;"'.$str_style3.' onclick="javascript:loadDataByUrl(\''.$base_url.'/40\',\'list_data\');">40</a>
    			</span>
    			<span class="r" id="page_wrapper">';
    			$page_html .=$this->pagination->render("ajax_page");
    			$page_html .='<span class="sele_page">';
    			$page_html .='<input id="govalue" name="page" class="num" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\');if(this.value>'.$total_pages.')this.value='.$total_pages.';if(this.value<=0)this.value=1" onkeydown="if(event.keyCode==13){javascript:loadDataByUrl(\''.$base_url.$data['count'].'?page=\' + Y.one(\'#govalue\').value,\'list_data\');return false;}" type="text">';
    			$page_html .='<input value="GO" class="btn" onclick="javascript:loadDataByUrl(\''.$base_url.'/'.$data['count'].'?page=\' + Y.one(\'#govalue\').value,\'list_data\');return false;" type="button">';
    			$page_html .='</span>';
    			$page_html .='<span class="gray">共'.$total_pages.'页，'.$data['count'].'条记录</span>';
    			$page_html .='</span>';	
			}
			
			exit(json_encode(array("list_data"=>$list_html,"page_html"=>$page_html)));                       
            
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    }    
    
    public function viewdetail($orderid,$html_file="")
    {
        $user = $this->_user;
        $userobj = user::get_instance();
        
        if (empty($orderid))
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
            $obj = Plans_bjdcService::get_instance();
            $matchobj = match_bjdc::get_instance();
            $detail = $obj->get_by_order_id($orderid);
            //d($detail);
            $ticket_type = Kohana::config('ticket_type');

            if (empty($detail))
            {
                url::redirect('/error404');
                exit;
            }
            
            if ($detail['parent_id'] > 0)
            {
                $detail = $obj->get_parent_id($detail['parent_id']);
            }
            
            $arrcode = explode('/', $detail['codes']);            //扯分选项
            if (!empty($detail['special_num']))
            {
				//echo  $detail['special_num'];//44:[1:0,2:1,1:1] 
                $arrspenum = explode('/', $detail['special_num']);
                foreach ($arrspenum as $rowspenum)
                {
					//echo $rowspenum;//44:[1:0,2:1,1:1] 
                    $curspenum = explode(':', $rowspenum);
					//var_dump($curspenum);
                    //$curspenumselect = explode('[', $curspenum[1]);
                    $data['spenums'][$curspenum[0]] = true;
                }
            }
                        
            //获取赛事信息33:[胜]/34:[胜,平]/35:[平]
            foreach ($arrcode as $rowcode)
            {
                $curcode = explode(':', $rowcode);
                $curmatch_id = $curcode[0];            //当前赛事详细标识no
                
                $data['matchs'][$curmatch_id] = $matchobj->getMatchInfoByBetidIssueNo($detail['play_method'], $detail['issue'], $curmatch_id);
                
                $no_len = strlen($curmatch_id)+2;
				$t2 = substr(substr($rowcode, $no_len), 0, -1);//去掉左右[]
				
                //$curmatch_sele = explode("[", $curcode[1]);
                //$data['codes'][$curmatch_id] = substr($curmatch_sele[1], 0, strlen($curmatch_sele[1])-1);
                $data['codes'][$curmatch_id] = $t2;
                
                //unset($curmatch_sele);
                
                if (empty($data['time_end']))
                    $data['time_end'] = $data['matchs'][$curcode[0]]['playtime'];
                
                if (strtotime($data['matchs'][$curcode[0]]['playtime']) < strtotime($data['time_end']))
                    $data['time_end'] = $data['matchs'][$curcode[0]]['playtime'];
                
                //显示当前选择项
                $cur_code = $data['codes'][$curmatch_id];
                $data['select'][$curmatch_id] = $cur_code;
            	$final_sp = $data['matchs'][$curmatch_id]['sp_r'];
                if ($final_sp != null && $final_sp > 0) {
                	$data['final_sp'][$curmatch_id] = round($final_sp, 2);
                }
                else {
                	$data['final_sp'][$curmatch_id] = 0;
                }
            }
           
            $site_config = Kohana::config('site_config');
            
            $data['time_end'] = date("Y-m-d H:i:s", strtotime($data['time_end']) - $site_config['match']['bjdc_endtime']);
            $data['ratelist'] = NULL;
            
            $data['detail'] = $detail;
            $data['user'] = $userobj->get($detail['user_id']);
            
            //是否可以合买
            $data['is_open'] = FALSE;
            
            if ($detail['plan_type'] == 1)
            {
                if ($detail['status'] == 0 && $detail['copies'] > $detail['buyed'] && strtotime($detail['time_end']) > time())
                {
                    if (!empty($detail['friends']))
                    {
                        if (!empty($this->_user))
                        {
                            $arruser = explode(',', $detail['friends']);
                            if(in_array($this->_user['lastname'], $arruser))
                            {
                                $data['is_open'] = TRUE;
                            }
                        }
                        else 
                        {
                            $data['is_open'] = TRUE;
                        }
                    }
                    else
                    {
                        $data['is_open'] = TRUE;
                    }
                }
            }

            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;

			$data['buynum'] = $this->input->get('buynum');
			$data['totalbuymoney'] = $this->input->get('totalbuymoney');
			$data['site_config'] = Kohana::config('site_config.site');
			if($html_file==""){
            	$this->template = new View('bjdc/viewdetail', $data);	
			}elseif($html_file=="join"){
            	$this->template = new View('bjdc/viewdetail_join', $data);			
			}            

            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    } 
    
	/*
     * 提交合买订单
     */
    public function submit_buy_join()
    {
        $msg = array();
        $msg['error'] = -1;
        $msg['headerurl'] = '';
        $msg['state'] = 0;
        $msg['msg'] = '提交时发生了一个错误!';
        
        $msg2 = array();
        $msg2['errcode'] = -20;
        $msg2['msgmode'] = 1;
        $msg2['msg'] = '提交时发生了一个错误!';        
        
        $showmsg = array();
        
        if (empty($_GET))
            exit(json_encode($msg));

        //$msg['msg'] = tool::debu_array($_GET, "<br>");    
        //exit(json_encode($msg));
        //tool::debu_array($_GET, "<br>");    
            
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        try {
            
            $pid = $this->input->get('pid');
            $buynum = intval($this->input->get('buynum'));
            $frompage = $this->input->get('from');
            
            if (empty($frompage))
            {
                $showmsg = $msg;
            }
            else 
            {
                $showmsg = $msg2;
            }
            
            //$msg['msg'] = $buynum;    
            //exit(json_encode($msg));
            
            if ($pid <= 0 || $buynum <= 0)
            {
                exit(json_encode($showmsg));
            }
            
            $plans_basic_obj = Plans_basicService::get_instance();
            $plans_obj = Plans_bjdcService::get_instance();
            
            if (empty($frompage))
            {
                $result = $plans_obj->get($pid);
            }
            else
            {
                $result = $plans_obj->get_by_order_id($pid);
            }
            
            //$msg['msg'] = tool::debu_array($result, "<br>");
            //exit(json_encode($msg));

            if (empty($result))
            {
                exit(json_encode($showmsg));
            }
            else 
            {
                if (!empty($frompage))
                {
                     $pid = $result['id'];
                }
            }
            
            $databasic = array();
            $data = array();
            
            $databasic['user_id'] = $this->_user['id'];
            $databasic['start_user_id'] = $result['user_id'];
            $databasic['ticket_type'] =  1;
            $databasic['play_method'] = $result['play_method'];
            $databasic['plan_type'] = 2;    //参与合买标识
            
            $data['price'] = $buynum * $result['price_one'];
            
            //再次验证余额
            $userobj = user::get_instance();
            $usermoney = $userobj->get_user_money($this->_user['id']);
            if ($usermoney < $data['price'])
            {
                $showmsg['msg'] = '余额不足，请先充值后再购买！';
                exit(json_encode($showmsg));
            }
            
            //再次验证是否满员
            if ($result['surplus'] <= 0)
            {
                $showmsg['msg'] = '此方案已满员无法购买！';
                exit(json_encode($showmsg));
            }
            
            //验证数量是否够
            if ($result['surplus'] < $buynum)
            {
                $showmsg['msg'] = '您好，认购份数不能大于剩余份数！';
                exit(json_encode($showmsg));
            }
            
            //检查方案日期是否结束
            if (strtotime($result['time_end']) < time())
            {
                $showmsg['msg'] = '此方案已到期无法购买！';
                exit(json_encode($showmsg));
            }
            //再次检查是否是合买对象
            if (!empty($result['friends']))
            {
                $arruser = explode(',', $result['friends']);
                if (!in_array($this->_user['lastname'], $arruser))
                {
                    $showmsg['msg'] = '此方案只有固定的彩友可以合买！';
                    exit(json_encode($showmsg));
                }
            }

            $basic_id = $plans_basic_obj->add($databasic);
            
            $data['ticket_type'] =  $databasic['ticket_type'];
            $data['play_method'] = $databasic['play_method'];
            $data['parent_id'] = $result['id'];
            $data['basic_id'] = $basic_id;
            $data['user_id'] = $this->_user['id'];
            $data['codes'] = $result['codes'];
            $data['special_num'] = $result['special_num'];
            $data['typename'] = $result['typename'];
            $data['price_one'] = $data['price'];
            $data['my_copies'] = $buynum;
            $data['rate'] = 1;
            $data['plan_type'] = 2;
            $data['issue'] = $result['issue'];
            $data['status'] = 1;
            $data['time_end'] = $result['time_end'];
            
            $create_ticket = FALSE;
            
            if (!($id = $plans_obj->add($data)))
            {            
                $showmsg['msg'] = '提交时发生了一个错误2!';
                exit(json_encode($showmsg));
            }
            else 
            {
                $msg['error'] = 0;
                $msg['state'] = 100;
                $msg['msg'] = '提交成功!';
                $msg['headerurl'] = '/bjdc/buyok/';
                
                $session = Session::instance();
                $session->set('buywin_id', $id);
                
                //记录日志
                $data_log = array();
                $data_log['order_num'] = $basic_id;
                $data_log['user_id'] = $this->_user['id']; 
                $data_log['log_type'] = 2;                 //参照config acccount_type 设置
                $data_log['is_in'] = 1;
                $data_log['price'] = $data['price'];
                $data_log['user_money'] = $usermoney;
                
                $lan = Kohana::config('lan');
                $data_log['memo'] = $lan['money'][7];
                account_log::get_instance()->add($data_log);
                
                //更新父类进度
                $parent_num = $buynum + $result['buyed'];
                $parent_progress = intval($parent_num / $result['copies'] * 100);
                $plans_obj->update_parent_progress($pid, $parent_num, $parent_progress);

                //满员操作
                if ($parent_num >= $result['copies'])
                {
                    //扯分彩票存入彩票表,打印彩票的格式/更新状态
                    $plans_obj->get_tickets($pid, $result['play_method'], $result['codes'], $result['typename'], $result['special_num'], $result['rate'], $result['basic_id']);
                    $ticketobj = ticket::get_instance();
                	$tickets = $ticketobj->getTicketByPlanID($pid, $result['basic_id']);
                	$post_ticket_fail = $plans_obj->post_ticket_happypool($tickets, $result['issue']);
                    //更新方案状态为未出票(是父类的方案)
                    if ($post_ticket_fail === true) {
	                    $plans_obj->update_status($pid, 1);
	                    //返还发起人保底金额
	                    if ($result['baodinum'] > 0)
	                    {
	                        $backmoney = $result['baodinum'] * $result['price_one'];
	                        $usermoney = $userobj->get_user_money($result['user_id']);
	                        
	                        //记录日志
	                        $data_log = array();
	                        $data_log['order_num'] = date('YmdHis').rand(0, 99999);
	                        $data_log['user_id'] = $result['user_id'];
	                        $data_log['log_type'] = 5;                 //参照config acccount_type 设置
	                        $data_log['is_in'] = 0;
	                        $data_log['price'] = $backmoney;
	                        $data_log['user_money'] = $usermoney;
	                        
	                        $lan = Kohana::config('lan');
	                        $data_log['memo'] = $lan['money'][8];
	                        account_log::get_instance()->add($data_log);                        
	                    }
                    }
                    else {
	                    if (is_array($post_ticket_fail) && count($post_ticket_fail) > 0) {
			            	$ticket_id = array();
			            	for ($i = 0; $i < count($post_ticket_fail); $i++) {
			            		$ticket_id[] = $post_ticket_fail[$i]['id'];
			            		//plan::get_instance()->refund_plan(7, $post_ticket_fail[$i]['order_num'], $post_ticket_fail[$i]['money']);
			            	}
			            	$u = $ticketobj->update_status($ticket_id, -1, array('0'), $result['user_id']);
		            	}
                    }
                    
                }
                exit(json_encode($msg));
            }
            exit(json_encode($msg));
            
            //提交表单和显示
            $return_data = array();
            //* 补充&修改返回结构体 */
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
            
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }
    }    
    
 
     /*
     * 提交合买订单
     */
    public function viewdetail_join($id="")
    {		
		$this->viewdetail($id,"join");
	}
    
    public function check_bonus($result) {
		//$result  为ticket_nums表中的一条记录
	
		//逻辑各写各的
	
		$result['status']=1; //状态(0,未开奖 1,已开奖)
		$result['bonus']=0; //奖金(默认为0)  	
		return $result;
	}
	
	/**
	 * 
	 * 将46:[胜]/47:[胜]/48:[胜]/49:[胜]转换成接口格式
	 * @param unknown_type $play_method
	 * @param unknown_type $codes
	 */
	public function transJkCodeByCodes($play_method, $codes) {
		$bjdc_config = Kohana::config('bjdc');
		$code_result = array();
		$code_t1 = explode('/', $codes);
		for ($i = 0; $i < count($code_t1); $i++) {
			$t1 = explode(':', $code_t1[$i]);
			$match_no = $t1[0];
			$no_len = strlen($match_no)+2;
			$t2 = substr(substr($code_t1[$i], $no_len), 0, -1);
			$t3 = explode(',', $t2);
			$match_result = array();
			for ($j = 0; $j < count($t3); $j++) {
				switch ($play_method) {
					case '501': $match_result[$j] = $bjdc_config['spf_result'][$t3[$j]];break;
					case '502': $match_result[$j] = $bjdc_config['sxds_result'][$t3[$j]];break;
					case '503': $match_result[$j] = $bjdc_config['zjqs_result'][$t3[$j]];break;
					case '504': $match_result[$j] = $bjdc_config['bf_result'][$t3[$j]];break;
					case '505': $match_result[$j] = $bjdc_config['bqc_result'][$t3[$j]];break;
				}
			}
			$match_result_str = $match_no.':'.implode(',', $match_result);
			$code_result[$i] = $match_result_str;
		}
		$code_result_str = implode('/', $code_result);
		return $code_result_str;
	}
	
	public function rePostTicket() {
		$ticketobj = ticket::get_instance();
                $tickets = $ticketobj->getUnPostTicketBjdc();
                //var_dump($tickets);
                /**
                 * <ticket id="彩票唯一标示" betid="彩种编号" issue="期号" playtype="玩法编号" 
                 * money="单张彩票金额" amount="倍数" code="投注内容" />
                 */
                require_once WEBROOT.'cron_script/BJDC.php';
                $bjdc_jk = new BJDC();
                $r = array();
                for ($i = 0; $i < count($tickets); $i++) {
                	$codes = explode(';', $tickets[$i]['codes']);
                	if ($codes[1] == '单关') {
                		$chuan = 1;
                	}
                	else {
                		$chuan_array = explode('串', $codes[1]);
                		$chuan = $chuan_array[0].$chuan_array[1];
                	}
                	
                	$code = $this->transJkCodeByCodes($tickets[$i]['play_method'], $codes[0]);
                	//echo $code;die();
                	$r = $bjdc_jk->postAction_new($tickets[$i]['id'], $tickets[$i]['play_method'], 
                	'110915', $chuan, $tickets[$i]['money'], $tickets[$i]['rate'], $code);
                	echo $r.'<br />';
                	
                }
	}
	
	/**
	 * 自动更新赛果
	 */
	public function update_plans_match_result() {
		Plans_bjdcService::get_instance()->get_plans_result();
	}
	
	/**
	 * 兑奖
	 */
	public function auto_get_price() {
		Plans_bjdcService::get_instance()->bonus_count();
	}
	
	/**
	 * 奖金明细
	 * @param unknown_type $order_num
	 */
	public function bonus_info($order_num)
	{
		$user = $this->_user;
		$site_config = $this->_site_config;
		if (empty($order_num))
		{
			exit('无奖金明细');
		}
		 
		$planobj = Plans_bjdcService::get_instance();
		$result = $planobj->get_by_order_id($order_num);
		 
		if (empty($result))
		{
			exit('无奖金明细');
		}
		 
		$data = $planobj->bonus_ticket_count($result);
		//d($data);
		if (empty($data))
		{
			exit('无奖金明细');
		}
		$config = Kohana::config('bjdc');
		$data['config'] = $config;
		$this->template = new View('bjdc/bonus_info');
		$this->template->set('data', $data);
		$this->template->set('results', $result);
		$this->template->set_global('_user', $this->_user);
		$this->template->set('site_config', $site_config['site_config']);
		$this->template->render(TRUE);
	}
}
?>