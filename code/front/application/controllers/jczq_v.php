<?php defined('SYSPATH') OR die('No direct access allowed.');
class Jczq_v_Controller extends Template_Controller {
    /*
     * 让球胜平负
     */
    public function rqspf($search_date = NULL)
    {
        //d(user_money::get_instance()->get_con_by_order_num('2011093013505329718'), false);
        $user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
        
        $play_type = 1;
        $ticket_type = 1;
        
        //d(user_money::get_instance()->get_stru_by_order_num('2011102414434663763'));
        

    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        
        try 
        {
            $data = array();
            
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $data['play_type'] = $play_type;
            $objmatch = match::get_instance();
            $data['matchs'] = $objmatch->get_results($ticket_type, $play_type);
                        
            $data['groups'] = array();
            $data['matchnames'] = array();
            $data['groups_date'] = array();
            $data['match_end'] = 0;
            
            foreach ($data['matchs'] as $row)
            {
                $time = date("Y-m-d", strtotime($row['time']));
                //$weekday = substr($row['match_info'], 0, 6);
                $weekday = $row['match_weekday'];
                $data['groups'][$weekday][] = $row;
                                
                $data['groups_date'][$weekday] = $row['match_date'];
                $data['matchnames'][$row['league']] = $row['league'];
                
                if ($row['match_end'])
                {
                    $data['match_end']++;
                }
            }
            
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
    		
            $this->template = new View('jczq_v/rangqiushengpingfu', $data);
            $this->template->set_global('_user', $this->_user);
        
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    }

    /*
     * 总进球数
     */
    public function zjqs($search_date = NULL)
    {
        $user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
        $play_type = 2;
        $ticket_type = 1;
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        try 
        {
            $data = array();
			
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $data['play_type'] = $play_type;
            $objmatch = match::get_instance();
            $data['matchs'] = $objmatch->get_results($ticket_type, $play_type);
            
            //d($data['matchs']);
            
            $data['groups'] = array();
            $data['matchnames'] = array();
            $data['groups_date'] = array();
            $data['match_end'] = 0;
            
            foreach ($data['matchs'] as $row) 
            {
                $time = date("Y-m-d", strtotime($row['time']));
                //$weekday = substr($row['match_info'], 0, 6);
                $weekday = $row['match_weekday'];
                $data['groups'][$weekday][] = $row;
                
                $data['groups_date'][$weekday] = $row['match_date'];
                $data['matchnames'][$row['league']] = $row['league'];
                
                if ($row['match_end'])
                {
                    $data['match_end']++;
                }                
                
            }
            
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
    		
            $this->template = new View('jczq/zongjinqiushu', $data);
            $this->template->set_global('_user', $this->_user);
        
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    } 

    /*
     * 比分
     */
    public function bf($search_date = NULL)
    {
        $user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
        $play_type = 3;
        $ticket_type = 1;
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        try 
        {
            $data = array();
			
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $data['play_type'] = $play_type;
            $objmatch = match::get_instance();
            $data['matchs'] = $objmatch->get_results($ticket_type, $play_type);
            
            $data['groups'] = array();
            $data['matchnames'] = array();
            $data['groups_date'] = array();
            $data['match_end'] = 0;
            
            foreach ($data['matchs'] as $row) 
            {
                $time = date("Y-m-d", strtotime($row['time']));
                //$weekday = substr($row['match_info'], 0, 6);
                $weekday = $row['match_weekday'];
                $data['groups'][$weekday][] = $row;
                
                $data['groups_date'][$weekday] = $row['match_date'];
                $data['matchnames'][$row['league']] = $row['league'];
                
                if ($row['match_end'])
                {
                    $data['match_end']++;
                }
            }
            
            
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
    		
            $this->template = new View('jczq/bifen', $data);
            $this->template->set_global('_user', $this->_user);
        
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    } 

    /*
     * 半全场
     */
    public function bqc($search_date = NULL)
    {
        $user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
        $play_type = 4;
        $ticket_type = 1;
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );

        try 
        {
            $data = array();
			
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $data['play_type'] = $play_type;
            $objmatch = match::get_instance();
            $data['matchs'] = $objmatch->get_results($ticket_type, $play_type);
                        
            $data['groups'] = array();
            $data['matchnames'] = array();
            $data['groups_date'] = array();
            $data['match_end'] = 0;
            
            foreach ($data['matchs'] as $row) 
            {
                $time = date("Y-m-d", strtotime($row['time']));
                //$weekday = substr($row['match_info'], 0, 6);
                $weekday = $row['match_weekday'];
                $data['groups'][$weekday][] = $row;
                
                $data['groups_date'][$weekday] = $row['match_date'];
                $data['matchnames'][$row['league']] = $row['league'];
                
                if ($row['match_end'])
                {
                    $data['match_end']++;
                }                
            }
                        
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
    		
            $this->template = new View('jczq/banquanchang', $data);
            $this->template->set_global('_user', $this->_user);
        
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    }   
    

    /*
     * 订单验证或详细设置
     */
    public function tobuy()
    {
        $session = Session::instance();
        if (empty($_POST))
        {
            $_POST = $session->get('plans_infos');  
            if (empty($_POST))
            {
                exit('Error submit!');
            }
        }
        else 
        {
            $session->set('plans_infos', $_POST);  //存储信息到session
        }
        
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        
        try {
            $data = array();
            $codes = array();
			
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $data['ticket'] = Kohana::config('ticket_type');            
            $data['guoguantypes'] = $this->input->post('guoguantypes');
            $data['typename'] = $this->input->post('sgtypename');
            $data['typeids'] = $this->input->post('sgtype');
            $data['is_hemai'] = $this->input->post('is_hemai');
            $data['ticket_type'] = $this->input->post('ticket_type');
            $data['play_method'] = $this->input->post('play_method');
            $data['ticket_id'] = $this->input->post('ticket_id');
            $data['playtype'] = $this->input->post('playtype');
            $data['is_duochuan'] = $this->input->post('is_duochuan');
            $data['code_data'] = $this->input->post('code_data');
            $data['special_num'] = $this->input->post('special_num');
            $data['copies'] = $this->input->post('copies');
            $data['rate'] = $this->input->post('rate');
            $data['allprice'] = $this->input->post('allprice');
            $data['sgtype'] = $this->input->post('sgtype');
            $data['gggroup'] = $this->input->post('gggroup');
            $data['imaxmoney'] = $this->input->post('imaxmoney');
            
            $data['codes'] = array();             //选号
            $data['matchs'] = array();            //赛事
            $data['spenums'] = array();           //胆码

            
            $arrcode = explode('/', $data['code_data']);    //扯分选项
            
            if (!empty($data['special_num']))
            {
                $arrspenum = explode('/', $data['special_num']);
                foreach ($arrspenum as $rowspenum)
                {    
                    $curspenum = explode('|', $rowspenum);
                    $curspenumselect = explode('[', $curspenum[1]);
                    $data['spenums'][$curspenum[0]] = intval($curspenumselect[1]);
                }
            }
            
            $data['time_end'] = NULL;
            $matchobj = match::get_instance();
            $data['select'] = NULL; 

                        
            //获取赛事信息
            foreach ($arrcode as $rowcode)
            {
                $curcode = explode('|', $rowcode);
                $curmatch_id = $curcode[0];            //当前赛事详细标识id
                
                $data['matchs'][$curmatch_id] = $matchobj->get_match($curmatch_id, $data['ticket_type'], $data['play_method']);
                $curmatch_sele = explode("[", $curcode[1]);
                $data['codes'][$curmatch_id] = substr($curmatch_sele[1], 0, strlen($curmatch_sele[1])-1);
                
                unset($curmatch_sele);
                
                if (empty($data['time_end']))
                    $data['time_end'] = $data['matchs'][$curcode[0]]['time_end'];
                
                if (strtotime($data['matchs'][$curcode[0]]['time']) < strtotime($data['time_end']))
                    $data['time_end'] = $data['matchs'][$curcode[0]]['time_end'];
                
                //显示当前选择项
                $cur_code = $data['codes'][$curmatch_id];
                if ($data['play_method'] == 1)
                {
                    $data['result_type'] = Kohana::config('jczq');
                    $spf_type = $data['result_type']['spf'];
                    
                    $arr_cur_code = explode(",", $cur_code);
                    
                    $arr_select = array();
                    foreach ($arr_cur_code as $rowcur_code)
                    {
                        $code_value = $spf_type['result_type'][$rowcur_code];
                        $curnum = $data['matchs'][$curmatch_id][$code_value];
                        $arr_select[] = $spf_type['result_cn'][$rowcur_code]."(".$curnum.")";
                    }
                    $data['select'][$curmatch_id] = implode(",", $arr_select);
                }
                elseif ($data['play_method'] == 2)
                {
                    $arr_cur_code = explode(",", $cur_code);
                    $arr_select = array();
                    foreach ($arr_cur_code as $rowcur_code)
                    {
                        $arr_select[] = $data['codes'][$curmatch_id]."(".$data['matchs'][$curmatch_id][$rowcur_code].")";;
                    }
                    $data['select'][$curmatch_id] = implode(",", $arr_select);                    
                }
                elseif ($data['play_method'] == 3)
                {
                    $data['result_type'] = Kohana::config('jczq');
                    $bf_type = $data['result_type']['bf']['result_type'];
                    $curcomb = json_decode($data['matchs'][$curmatch_id]['comb']);
                    
                    $arr_cur_code = explode(",", $cur_code);
                    $arr_select = array();
                    foreach ($arr_cur_code as $rowcur_code)
                    {
                        $curnum = $curcomb->$bf_type[$rowcur_code]->{'v'};
                        $arr_select[] = $data['codes'][$curmatch_id]."(".$curnum.")";
                    }                    
                    $data['select'][$curmatch_id] = implode(",", $arr_select);
                }
                elseif ($data['play_method'] == 4)
                {
                    $data['result_type'] = Kohana::config('jczq');
                    $bqc_type = $data['result_type']['bqc']['result_type'];
                    $bqc_type_r = array_flip($data['result_type']['bqc']['result_type_r']);
                    
                    $curcomb = json_decode($data['matchs'][$curmatch_id]['comb']);
                    
                    //d($bqc_type_r, FALSE);
                    
                    $arr_cur_code = explode(",", $cur_code);
                    $arr_select = array();
                    foreach ($arr_cur_code as $rowcur_code)
                    {
                        $curnum = $curcomb->$bqc_type[$rowcur_code]->{'v'};
                        //$arr_select[] = $data['codes'][$curmatch_id]."(".$curnum.")";
                        $arr_select[] = $bqc_type_r[$rowcur_code]."(".$curnum.")";
                        //$arr_select[] = $bqc_type_r[$data['codes'][$curmatch_id]]."(".$curnum.")";
                    } 
                    //d($arr_select);
                    $data['select'][$curmatch_id] = implode(",", $arr_select);                    
                }
            }
                        
            $data['ratelist'] = NULL;
            
            if ($data['play_method'] == 1) 
            {
                $i = 0;
                foreach ($data['codes'] as $key => $value)
                {
                    $str = '/';
                    if ($i == 0)
                        $str = '';
                    //$data['ratelist'] .= $str.$key.'|'.$data['matchs'][$key]['match_num'].'['.$value.'#'.$data['matchs'][$key][$spf_type['result_type'][$value]].']';
                    $i++;
                }
            }
            elseif ($data['play_method'] == 2)
            {
                $i = 0;
                foreach ($data['codes'] as $key => $value)
                {
                    $str = '/';
                    if ($i == 0)
                        $str = '';
                    //$data['ratelist'] .= $str.$key.'|'.$data['matchs'][$key]['match_num'].'['.$value.'#'.$data['matchs'][$key][$value].']';
                    $i++;
                }
            }
            elseif ($data['play_method'] == 3)
            {
                $i = 0;
            }
            elseif ($data['play_method'] == 4)
            {
                $i = 0;
            }

            $this->template = new View('jczq_v/tobuy', $data);
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
    
    
    /*
     * 提交订单
     */
    public function pute()
    {
        //error_reporting(E_ALL);
        $msg = array();
        $msg['errcode'] = -1;
        $msg['headerurl'] = '';
        $msg['msg'] = '提交时发生了一个错误!';
        //exit(json_encode($msg));
        if (empty($_POST))
            exit(json_encode($msg));
            
        //$msg['msg'] = '暂不可以投注';
        //exit(json_encode($msg));
        //d($_POST);
        //$msg['msg'] = tool::debu_array($_POST, "<br>");    
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
            
            $databasic['user_id'] = $this->_user['id'];
            $databasic['start_user_id'] = $this->_user['id'];
            $databasic['ticket_type'] =  $this->input->post('ticket_type');
            $databasic['play_method'] = $this->input->post('play_method');
            $databasic['date_end'] = $this->input->post('time_end');
            $databasic['plan_type'] = $this->input->post('is_hemai');
            
            $data['price'] = $this->input->post('totalmoney');            //默认价格,合买会有所不同
            $data['is_hemai'] = $this->input->post('is_hemai');
            
            //再次验证余额
            $userobj = user::get_instance();
            //$usermoney = $userobj->get_user_money($this->_user['id']);
            $usermoney = $this->_user['virtual_money'];
            $create_ticket = TRUE;
            
            //验证赛事是否过期
            $code_data = $this->input->post('code_data');
            $arr_codes = explode('/', $code_data);
            $matchobj = match::get_instance();
            foreach ($arr_codes as $row_codes)
            {
                $cur_match_id = explode('|', $row_codes);
                $check_match = $matchobj->get_match($cur_match_id[0], $databasic['ticket_type'], $databasic['play_method']);
                
                if ($check_match['match_end'])
                {
                    $msg['msg'] = "您所选的有过期的赛事，不可以提交！";
                    exit(json_encode($msg));
                }
            }
            
            if ($data['is_hemai'] == 1)
            {
                $data['plan_type'] = 1;                     //是否合买
                $data['status'] = 1;                        //方案状态
                $totalmoney = $this->input->post('totalmoney');
                //$data['zhushu'] = $this->input->post('zhushu');
                $data['zhushu'] = $totalmoney;
                $data['my_copies'] = $this->input->post('my_copies');
                $data['baodinum'] = $this->input->post('baodinum');
                //$data['price_one'] = $totalmoney / $data['zhushu'];
                $data['price_one'] = 1;
                $myprice = $data['price_one'] * $data['my_copies'] + $data['price_one'] * $data['baodinum'];
                $data['deduct'] = $this->input->post('deduct');            
                $data['total_price'] = $totalmoney;
                $data['price'] = $myprice;
                $data['progress'] = intval($data['my_copies']/$data['zhushu'] * 100);
                $data['buyed'] = $data['my_copies'];
                $data['title'] = $this->input->post('title', NULL);
                $data['content'] = $this->input->post('content', NULL);
                $data['friends'] = $this->input->post('buyuser', NULL);
                $data['isset_buyuser'] = $this->input->post('isset_buyuser');
                $data['surplus'] = $data['zhushu']- $data['buyed'];
                
                if ($data['isset_buyuser'] == 1)
                {
                    $data['friends'] = '';
                } 
                if($data['zhushu'] != $data['my_copies'])
                {
                    $create_ticket = FALSE;
                    $data['status'] = 0;
                }
                $data['is_open'] = $this->input->post('public');
            }
            else
            {
                $data['plan_type'] = 0;          //是否合买
                $data['status'] = 1;             //方案状态
                $data['progress'] = 100;         
                $myprice = $data['price'];
                $data['price_one'] = $myprice;
                $data['total_price'] = $myprice;
                $data['zhushu'] = 1;
                $data['buyed'] = 1;
                $data['surplus'] = 0;
                $data['my_copies'] = 1;
                $data['is_open'] = 0;
            }

            //检查余额
            if ($usermoney < $myprice)
            {
                $msg['msg'] = '竞波币不足，无法购买！';
                exit(json_encode($msg));
            }
            
            //检查限号
            $data['time_end'] = $this->input->post('time_end');
            if (strtotime($data['time_end']) < time())
            {
                $msg['msg'] = '方案已截止，请检查是否有截止的赛事！';
                exit(json_encode($msg));
            }
            
            $data['ticket_type'] = $databasic['ticket_type'];
            $data['play_method'] = $databasic['play_method'];
            $data['start_user_id'] = $this->_user['id'];
            $data['user_id'] = $this->_user['id'];
            $data['codes'] = $this->input->post('code_data');
            $data['special_num'] = $this->input->post('special_num');
            $data['typename'] = $this->input->post('typename');
            $data['gggroup'] = $this->input->post('gggroup');
            $data['copies'] = $this->input->post('copies');
            $data['rate'] = $this->input->post('rate');
            $data['bonus_max'] = $this->input->post('bonus_max');
            
            
            $plans_obj = Plans_jczqService::get_instance();
            
            //检查参数,验证客户端提交的价格,数量等是否正确
            //彩票拆分
            $testarr = array();
            $testarr = $plans_obj->get_tickets(999, $data['play_method'], $data['codes'], $data['typename'], $data['special_num'], $data['rate'], '999', TRUE);

            $testmoney = 0;
            foreach ($testarr as $rowarr)
            {
                $testmoney += $rowarr['money'];
            }
                        
            if ($testmoney != $this->input->post('totalmoney'))  
            {
                $msg['msg'] = '数据异常！';
                exit(json_encode($msg));
            }
            
            if (!is_numeric($data['bonus_max']))
            {
                $data['bonus_max'] = 0;
            }
            
            $data['gggroup'] == 2 && $data['special_num'] = NULL;            //多串过关清空胆码
            
            $plans_basic_obj = Plans_basicService::get_instance();           //方案基表类
            $basic_id = $plans_basic_obj->add($databasic);
            $data['basic_id'] = $basic_id;
                        
            if (!($id = $plans_obj->add($data)))
            {
                $msg['msg'] = '提交时发生了一个错误!';
                exit(json_encode($msg));
            }
            else 
            {
                $msg['errcode'] = 0;
                $msg['msg'] = '提交成功!';
                $msg['headerurl'] = '/jczq_v/buyok/';
                
                $session = Session::instance();           
                $session->set('buywin_id', $id);
                
                //购买成功则扯分彩票存入彩票表,打印彩票的格式
                if ($create_ticket)
                {
                    $plans_obj->get_tickets($id, $data['play_method'], $data['codes'], $data['typename'], $data['special_num'], $data['rate'], $basic_id);
                    //$msg['errcode'] = -1;
                    //$msg['msg'] = tool::debu_array($tmp, "<br>");
                    ///exit(json_encode($msg));
                }
                
                //记录日志
                $data_log = array();
                $data_log['order_num'] = $basic_id;
                $data_log['user_id'] = $this->_user['id']; 
                $data_log['log_type'] = 2;                 //参照config acccount_type 设置
                $data_log['is_in'] = 1;
                $data_log['price'] = $myprice;
                $data_log['user_money'] = $usermoney;
                
                $lan = Kohana::config('lan');
                $data_log['memo'] = $lan['money'][1];
                
                if (!empty($data['baodinum']))
                    $data_log['memo'] .= ','.$lan['money'][5];
                
                account_virtual_log::get_instance()->add($data_log);
                
                 //当是代购时更新方案基表状态
                if ($data['is_hemai'] == 0)
                {
                    
                }
                $plans_obj->update_status($id, $data['status']);
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
     * 成功提交订单
     */
    public function buyok()
    {
        $session = Session::instance();           
        $id = $session->get('buywin_id');
        
        if (empty($id))
        {
            url::redirect('/error404?msg=页面已过期');
            exit;
        }
        
        $plans_obj = Plans_jczqService::get_instance();
        $data = $plans_obj->get_by_id($this->_user['id'], $id);
        $data['usermoney'] = $this->_user['virtual_money'];
        
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
        //$session->delete('buywin_id');
        //$session->delete('plans_infos');

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

            $this->template = new View('jczq_v/buy_success', $data);
            $this->template->set_global('_user', $this->_user);
            
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }        
        
        $this->template->render(TRUE);
    }    

    

    /*
     * 我的方案
     */    
    /*
     * 我的方案ajax输出
     */
    public function my($status='ing')
    {
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
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $data['status'] = $status;            
            $viewpage = 'jczq/my';
            $data['ajax_url'] ="/jczq/my_ajax/".$status."/20";
            
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
    
    
    
    /*
     * 我的方案ajax输出
     */
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
        
		$get_findstr = trim($this->input->get('findstr'));
		$get_playid_term = trim($this->input->get('playid_term'));
		$get_state_term = trim($this->input->get('state_term'));		
		$pid = trim($this->input->get('pid'));
		$get_status = trim($this->input->get('status'));
		$get_expect = trim($this->input->get('expect'));
		$get_orderby = trim($this->input->get('orderby'));
		$get_orderstr = trim($this->input->get('orderstr'));
        
        $get_page = intval($this->input->get('page'));
        
        //d($get_page);
        
  		$page = !empty( $get_page ) ? intval($get_page) : "1";//页码
		$total_rows = !empty( $page_size ) ? intval($page_size) : "20";//第页显示条数      
        
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
                    'page' => $page
                )
            );
            
            $base_url = url::base().'jczq/my_ajax/ing';
            if ($status=='ing')
            {
                $query_struct_default['where']['status <='] = 2;
                $query_struct_default['where']['progress<'] = 100;
                $base_url = url::base().'jczq/my_ajax/ing';
            }            
            else 
            {
                $query_struct_default['where']['status >'] = 2;
                $base_url = url::base().'jczq/my_ajax/end';
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
            $planobj = Plans_jczqService::get_instance();
            $data_count = $planobj->count($query_struct_current);    //统计数量
            
            
			$config['base_url'] = $base_url."/".$total_rows;		
			$config['total_items'] = $data_count;//总数量
			$config['query_string']  = 'page';
			$config['items_per_page']  = $total_rows;	//每页显示多少第		
			$config['uri_segment']  = $page;//当前页码	
			$config['directory']  = "";//当前页码	
			$this->pagination = new Pagination($config);
			$this->pagination->initialize();            

            //$query_struct_current['limit']['page'] = $this->pagination->current_page;
            
            //d($query_struct_current);
            
            $data['list'] = $planobj->query_assoc($query_struct_current);
            
            $list_html = array();
            $pagesize =  $query_struct_default['limit']['per_page'];
            $total_pages = ceil($data_count / $pagesize);//总页数
            
            $ticket_type = Kohana::config('ticket_type');
            $ticket_type = $ticket_type['method'][1];
            
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
                    {
                        continue;
                    }
                    else 
                    {
                        if ($data['status'] == 'ing')
                        {
                            if ($parents['progress'] == 100)
                            {
                                continue;
                            }
                        }
                        else 
                        {
                           if ($parents['progress'] < 100)
                            {
                                continue;
                            }                        
                        }
                    }
                     
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
                $list_html[$j]['column5'] = $row['price'];
                $list_html[$j]['column6'] = $row['bonus'];
                $list_html[$j]['column7'] = $row['time_stamp'];
                $list_html[$j]['column8'] = "<a href=\"/jczq/viewdetail/".$row['basic_id']."\" target=\"_blank\">详情</a>";
                $j++;
                $i++;
            }
            
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
            
        	$str_style2 = "";
			$str_style3 = "";
			$str_style1 = "";
			switch($total_rows){
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
			
			$page_html ='<span class="l c-p-num">单页方案个数:
			<a style="cursor: pointer;"'.$str_style1.' onclick="javascript:loadDataByUrl(\''.$base_url.'/20\',\'list_data\');">20</a>
			<!--<a style="cursor: pointer;"'.$str_style2.' onclick="javascript:loadDataByUrl(\''.$base_url.'/30\',\'list_data\');">30</a>-->
			<a style="cursor: pointer;"'.$str_style3.' onclick="javascript:loadDataByUrl(\''.$base_url.'/40\',\'list_data\');">40</a>
			</span>
			<span class="r" id="page_wrapper">';
			$page_html .=$this->pagination->render("ajax_page");
			$page_html .='<span class="sele_page">';
			$page_html .='<input id="govalue" name="page" class="num" onkeyup="this.value=this.value.replace(/[^\d]/g,\'\');if(this.value>'.$total_pages.')this.value='.$total_pages.';if(this.value<=0)this.value=1" onkeydown="if(event.keyCode==13){javascript:loadDataByUrl(\'/'.$base_url.'/'.$total_rows.'?page=\' + Y.one(\'#govalue\').value,\'list_data\');return false;}" type="text">';
			$page_html .='<input value="GO" class="btn" onclick="javascript:loadDataByUrl(\'/'.$base_url.'/'.$total_rows.'?page=\' + Y.one(\'#govalue\').value,\'list_data\');return false;" type="button">';
			$page_html .='</span>';
			$page_html .='<span class="gray">共'.$page.'页，'.$data_count.'条记录</span>';
			$page_html .='</span>';
			
			//d(array("list_data"=>$list_html,"page_html"=>$page_html));
			exit(json_encode(array("list_data"=>$list_html,"page_html"=>$page_html)));                       
            
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
    }    
    

    /*
     * 显示详细
     */
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
            
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $obj = Plans_jczqService::get_instance();
            $matchobj = match::get_instance();
            $detail = $obj->get_by_order_id($orderid);
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
            
            //胆码
            if (!empty($detail['special_num']))
            {
                $arrspenum = explode('/', $detail['special_num']);
                foreach ($arrspenum as $rowspenum)
                {
                    /*$curspenum = explode('|', $rowspenum);
                    $curspenumselect = explode('[', $curspenum[1]);
                    $data['spenums'][$curspenum[0]] = intval($curspenumselect[1]);*/
                	$curspenum = explode('|', $rowspenum);
                	$data['spenums'][$curspenum[0]] = true;
                }
            }
            
            $emptyodds = FALSE;
            $data['odds'] = $obj->get_odds_by_ordernum($detail);    //获取所选的赔率,当无最新赔率时下面从赛事表获取            
            
            if (empty($data['odds']))
                $emptyodds = TRUE;
            
            $jczq_config = Kohana::config('jczq');
            
            $data['match_cnchar'] = array();        //赛事选择参数对应的显示文字 key value格式
            $data['match_cnchar_r'] = array();      //赛事赛果参数对应的显示文字 key value格式
            if ($detail['play_method'] == 1)
            {
                $data['match_cnchar'] = $jczq_config['spf']['result_cn'];
                $data['match_cnchar_r'] = ($data['match_cnchar']);
            }
            elseif ($detail['play_method'] == 2)
            {
                $data['match_cnchar'] = $jczq_config['zjqs']['result_type'];
                $data['match_cnchar_r'] = array_flip($data['match_cnchar']);
            }
            elseif ($detail['play_method'] == 3)
            {
                $data['match_cnchar'] = array();
                $data['match_cnchar_r'] = array();
                $data['match_cnchar'] = array();
            }
            elseif ($detail['play_method'] == 4)
            {
                $data['match_cnchar'] = array_flip($jczq_config['bqc']['result_type_r']);
                $data['match_cnchar_r'] = $data['match_cnchar'];
            }
            
            $data['match_groups'] = array();
            foreach ($arrcode as $rowcode)
            {
                $curcode = explode('|', $rowcode);
                $curmatch_id = $curcode[0];
                $curarr_sele = explode("[", $curcode[1]);
                $curarr_sele = explode(',', substr($curarr_sele[1], 0, strlen($curarr_sele[1])-1));                
                $data['match_groups'][$curmatch_id]['match'] = $matchobj->get_match($curmatch_id, 1, $detail['play_method']);   //存储赛事信息
                
                if ($emptyodds)
                {
                    if ($detail['play_method'] == 1) 
                    {
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[3]'] = $data['match_groups'][$curmatch_id]['match']['H'];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[1]'] = $data['match_groups'][$curmatch_id]['match']['D'];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[0]'] = $data['match_groups'][$curmatch_id]['match']['A'];
                    }
                    elseif ($detail['play_method'] == 2) 
                    {
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[0]'] = $data['match_groups'][$curmatch_id]['match'][0];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[1]'] = $data['match_groups'][$curmatch_id]['match'][1];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[2]'] = $data['match_groups'][$curmatch_id]['match'][2];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[3]'] = $data['match_groups'][$curmatch_id]['match'][3];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[4]'] = $data['match_groups'][$curmatch_id]['match'][4];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[5]'] = $data['match_groups'][$curmatch_id]['match'][5];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[6]'] = $data['match_groups'][$curmatch_id]['match'][6];
                        $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'[7]'] = $data['match_groups'][$curmatch_id]['match'][7];
                    }
                    elseif ($detail['play_method'] == 3) 
                    {
                        $result_type = $jczq_config['bf']['result_type'];
                        $comb = json_decode($data['match_groups'][$curmatch_id]['match']['comb']);
                        foreach ($result_type as $rowkey => $rowtype)
                        {
                            $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'['.$rowkey.']'] = $comb->$rowtype->v;
                        }
                    }
                    elseif ($detail['play_method'] == 4) 
                    {
                        $result_type = $jczq_config['bqc']['result_type'];
                        $comb = json_decode($data['match_groups'][$curmatch_id]['match']['comb']);
                        foreach ($result_type as $rowkey => $rowtype)
                        {
                            $data['odds'][$curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'['.$rowkey.']'] = $comb->$rowtype->v;
                        }
                    }                    
                    
                }
                
                
                //赛果转成可匹配的参数
                $data['match_groups'][$curmatch_id]['match_results'] = array();
                if (!empty($data['match_groups'][$curmatch_id]['match']['result']))
                {
                    $data['match_groups'][$curmatch_id]['match_results'] = explode('|', $data['match_groups'][$curmatch_id]['match']['result']);        
                }
               
                //对已选项操作
                foreach ($curarr_sele as $rowsele)
                {
                    if (!empty($data['match_cnchar_r']))
                    {
                        $rowselechar = $data['match_cnchar_r'][$rowsele];
                    }
                    else
                    {
                        $rowselechar = $rowsele;
                    }
                    if (isset($data['match_groups'][$curmatch_id]['match']['match_num'])) {
                    	$data['match_groups'][$curmatch_id]['sele'][$rowselechar] = $curmatch_id.'|'.$data['match_groups'][$curmatch_id]['match']['match_num'].'['.$rowsele.']';    //存储标识以作对比是否选对及赔率
                    }
                }
            }
            
            //echo '<!--'."\n";
            //d($data['match_groups'], FALSE);
            //echo '-->'."\n";
            if ($detail['upload_filepath'] != null) {
            	$detail['is_ds'] = true;
            	$file_path = WEBROOT.$detail['upload_filepath'];
            	$file_content = file_get_contents($file_path);
            	$ds_data = $obj->ds_jiexi1($file_content);
            	$data['ds_data'] = $ds_data;
            }
            else {
            	$detail['is_ds'] = false;
            }
            $data['detail'] = $detail;
            $data['user'] = $userobj->get($detail['user_id']);
            
            //是否可以合买
            $data['is_open'] = FALSE;
            if ($detail['plan_type'] == 1)
            {
                if ($detail['status'] == 0 && $detail['zhushu'] > $detail['buyed'] && strtotime($detail['time_end']) > time())
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
            
            if ($this->_user['id'] == $detail['user_id']) {
            	$data['join_data'] = true;
            }
            else {
            	$data['join_data'] = $obj->find_join_data($this->_user['id'],$detail['id']); //是否有参与过本方案
            }
            $data['is_public'] = $obj->plan_open($data['detail'], $data['join_data']);
            
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;

			$data['buynum'] = $this->input->get('buynum');
			$data['totalbuymoney'] = $this->input->get('totalbuymoney');
			//d($data);
			if($html_file==""){
            	$this->template = new View('jczq_v/viewdetail', $data);	
			}elseif($html_file=="join"){
            	$this->template = new View('jczq/viewdetail_join', $data);			
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
    	$msg['msg'] = '无法投注！';
    	exit(json_encode($msg));
    	
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
            $plans_obj = Plans_jczqService::get_instance();
            
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
                $msg['headerurl'] = '/jczq/buyok/';
                
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
                $data_log['memo'] = $lan['money'][7].',订单ID:'.$result['basic_id'];
                account_log::get_instance()->add($data_log);
                
                //更新父类进度
                $parent_num = $buynum + $result['buyed'];
                $parent_progress = intval($parent_num / $result['zhushu'] * 100);
                $plans_obj->update_parent_progress($pid, $parent_num, $parent_progress);

                //满员操作
                if ($parent_num >= $result['zhushu'])
                {
                    //扯分彩票存入彩票表,打印彩票的格式/更新状态
                    $plans_obj->get_tickets($pid, $result['play_method'], $result['codes'], $result['typename'], $result['special_num'], $result['rate'], $result['basic_id']);
                    
                    //更新方案状态为未出票(是父类的方案)
                    $plans_obj->update_status($pid, 1);
                    
                    //返还发起人保底金额
                    if ($result['baodinum'] > 0)
                    {
                        $backmoney = $result['baodinum'] * $result['price_one'];
                        $usermoney = $userobj->get_user_money($result['user_id']);
                        
                        //记录日志
						/*$data_log = array();
                        $data_log['order_num'] = date('YmdHis').rand(0, 99999);
                        $data_log['user_id'] = $result['user_id'];
                        $data_log['log_type'] = 5;                 //参照config acccount_type 设置
                        $data_log['is_in'] = 0;
                        $data_log['price'] = $backmoney;
                        $data_log['user_money'] = $usermoney;
                        $lan = Kohana::config('lan');
                        $data_log['memo'] = $lan['money'][8];
                        account_log::get_instance()->add($data_log);  */                     
                        
                        $lan = Kohana::config('lan');
                        $moneyobj = user_money::get_instance();
                        $retmoney = $backmoney;
                        $order_num = date('YmdHis').rand(0, 99999);
                        $retmoneystru = $moneyobj->get_stru_by_order_num($result['basic_id']); //获取资金结构体
                        if (empty($retmoneystru))
                        {
                            $retmoneystru['USER_MONEY'] = 1;
                            $retmoneystru['BONUS_MONEY'] = 0;
                            $retmoneystru['FREE_MONEY'] = 0;
                        }
                        $moneys['USER_MONEY'] = $retmoney * $retmoneystru['USER_MONEY'];
                        $moneys['BONUS_MONEY'] = $retmoney * $retmoneystru['BONUS_MONEY'];
                        $moneys['FREE_MONEY'] = $retmoney * $retmoneystru['FREE_MONEY'];
                        $moneyobj->add_money($result['user_id'], $retmoney, $moneys, 5, $order_num, $lan['money'][8]);                        
                         
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
 
    
    /*
     * 合买中心数据列表
     */
    public function ajax_data_lists_hm($page_size = "")
    {
		$get_page = intval($this->input->get('page'));		
		$page = !empty($get_page) ? intval($get_page) : "1";             //页码
		$total_rows = !empty($page_size) ? intval($page_size) : "10";    //第页显示条数
		
		$get_findstr = trim($this->input->get('findstr'));
		$get_playid_term = trim($this->input->get('playid_term'));
		$get_state_term = trim($this->input->get('state_term'));
		$get_orderby = trim($this->input->get('orderby'));
		$get_orderstr = trim($this->input->get('orderstr'));

		$mklasttime = mktime(date("H"), date("i"), date("s"), date("m"), date("d")-7, date("Y"));
		$lasttime = date('Y-m-d H:i:s', $mklasttime);
		
		/* 初始化默认查询条件 */
		$carrier_query_struct = array(
			'where'=>array(
		        'plan_type' => 1,
				'time_stamp >= ' => $lasttime,
			),
			'like'=>array(),
			'orderby' => array(
			),
			'limit' => array(
				'per_page' =>$total_rows,//每页的数量
				'page' =>$page //页码
			),
		);
		
		if (!empty($get_playid_term))
		{
		    switch ($get_playid_term)
		    {
    		    case '单关':
    		    case '2串1':
    		    case '3串1':
                case '4串1':
    		    case '5串1':    
    		    case '6串1':
    		        $carrier_query_struct['like']['typename'] = $get_playid_term;
    		        break;
		    }
		}
		
		if($get_findstr)
		{
			$user = user::get_search($get_findstr);
			if (!empty($user))
			{
			    $carrier_query_struct['where']['user_id'] = $user['id'];
			}
			else 
			{
			     $carrier_query_struct['where']['user_id'] = 0;
			}
		}
		
		if(!isset($get_state_term)) {
			$get_state_term = 100;
		}
		switch ($get_state_term) {
			case '0': 
				$carrier_query_struct['where']['progress'] = 100;//满员
				$carrier_query_struct['where']['surplus'] = 0;
				break;
			case '1':
				$carrier_query_struct['where']['progress < '] = 100;//未满员
				$carrier_query_struct['where']['surplus > '] = 0;
				$carrier_query_struct['where']['status'] = 0;
				break;
			case '2':
				$carrier_query_struct['where']['status'] = 6;
				break;
			case '-1':
				break;
			default:
				//$carrier_query_struct['where']['progress < '] = 100;//未满员
				//$carrier_query_struct['where']['surplus > '] = 0;
				//$carrier_query_struct['where']['status'] = 0;
				break;
		}
    	
		if (!empty($get_orderby))
		{
    		if($get_orderby=='allmoney' && !empty($get_orderstr))
    		{
    			$carrier_query_struct['orderby']['price'] = $get_orderstr;	
    		}
    		elseif($get_orderby=='onemoney' && !empty($get_orderstr))
    		{
    			$carrier_query_struct['orderby']['price_one'] = $get_orderstr;	
    		}
    		elseif($get_orderby=='renqi' && !empty($get_orderstr))
    		{
    			$carrier_query_struct['orderby']['progress'] = $get_orderstr;	
    		}
    		elseif($get_orderby=='snumber' && !empty($get_orderstr))
    		{
    			$carrier_query_struct['orderby']['surplus'] = $get_orderstr;	
    		}
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
        	//d($carrier_query_struct);
        	$_user = $this->_user;
			$Plans_jczq_obj = Plans_jczqService::get_instance();
			$data_list = $Plans_jczq_obj->query_assoc($carrier_query_struct);//数据列表
			$data_count = $Plans_jczq_obj->query_count($carrier_query_struct);//总记录数		
			$total_pages = ceil($data_count/$total_rows);//总页数	
						
			$page_html = "";
			$list_html = "";
			
			if ($data_list)
			{
				foreach($data_list as $key=>$value)
				{
					if($value['progress'] == 100)
					{
						$baodi_text = $value['progress']."%";   
					}
					else
					{
					   if ($value['baodinum'] > 0)
					   {
						   $baodi_text = $value['progress']."%+".intval(number_format($value['baodinum']/$value['zhushu']*100,2))."%(<span class='red'>保</span>)";
					   }
					   else
					   {
							$baodi_text = $value['progress']."%";   
					   }
				   }
				   
				   if ($value['surplus'] == 0)
				   {
					   $baodi_text="<span class='red'>满员</span>";
				   }					
					
					$user = user::get($value['user_id']);
					//d($_user);
					//if ($_user['lastname'] != $user['lastname']) {
						$col_username = "<span style='float:left;display:block;width:70px;height:25px;overflow:hidden;' title='".$user['lastname']."'>".$user['lastname']."</span><a style='float:right;*float:right;margin-right:5px;display:block;color:#db8a19' href='javascript:return 0;' onclick='dingzhi(".$value['user_id'].",1,".$value['play_method'].");'>定制跟单</a>";
					//}
					//else {
						//$col_username = $user['lastname'];
					//}
					$list_html[]=array(
						"column0"=>$value['id'],				
						"column1"=>($key+1),
						"column2"=>$col_username,
						"column3"=>"￥".$value['total_price']." 元",	
						"column4"=>"￥".$value['price_one']." 元",	
						"column5"=>'<a href="/jczq/viewdetail/'.$value['basic_id'].'" target="_blank">查看</a>',
						"column6"=>$baodi_text,
						"column7"=>intval($value['surplus'])."份",
						"column8"=>'<input type="text" name="rgfs" class="rec_text" vid="'.$value['basic_id'].'" vlotid="1" vplayid="'.$value['play_method'].'" vonemoney="'.$value['price_one'].'" vsnumber="'.intval($value['surplus']).'" value="1" vexpect="'.$value['basic_id'].'" onkeyup="this.value=Y.getInt(this.value);if(this.value<=0)this.value=1;if(this.value>'.intval($value['surplus']).')this.value='.intval($value['surplus']).'"/>',			
						"column9"=>'<input type="button" value="参与" class="btn_Dora_s m-r" id="b_'.$value['basic_id'].'"/><a href="/jczq/viewdetail/'.$value['basic_id'].'" target="_blank">详情</a>',
						);				
				}

				$base_url = "jczq/ajax_data_lists_hm/";
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
				<a style="cursor: pointer;"'.$str_style1.' onclick="javascript:loadDataByUrl(\'/'.$base_url.'/20\',\'list_data\');">20</a>
				<a style="cursor: pointer;"'.$str_style2.' onclick="javascript:loadDataByUrl(\'/'.$base_url.'/30\',\'list_data\');">30</a>
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

    /*
     * 更新赛果
     */
	public function get_plans_result() 
	{
	    //更新赛果
	    Plans_jczqService::get_instance()->get_plans_result();
	}    
    
    
    /*
     * 自动兑奖
     */
	public function auto_get_price() 
	{
	    //更新方案结果
	    Plans_jczqService::get_instance()->get_plans_result();
	    
	    //兑奖
		Plans_jczqService::get_instance()->bonus_count();
	}
	
	
	/*
	 * 奖金明细
	 */
	public function bonus_info($order_num)
	{
	    $user = $this->_user;
	    $site_config = $this->_site_config;
        if (empty($order_num))
        {
            exit('无奖金明细');
        }
	    
	    $planobj = Plans_jczqService::get_instance();
	    $result = $planobj->get_by_order_id($order_num);
	    
	    if (empty($result))
	    {
            exit('无奖金明细');
	    }
	    
	    $data = $planobj->bonus_ticket_count($result);
	    
	    if (empty($data))
	    {
	        exit('无奖金明细');
	    }

	    //$data = $data[0];
	    $config = Kohana::config('jczq');
	    
	    if ($result['play_method'] == 1)
	    {
	        $data['config'] = $config['spf']['result_cn'];
	    }
	    else 
	    {
	        $data['config'] = array();
	    }
        $this->template = new View('jczq/bonus_info');
        $this->template->set('data', $data);
        $this->template->set('results', $result);
        $this->template->set_global('_user', $this->_user);
        $this->template->set('site_config', $site_config['site_config']);
        $this->template->render(TRUE);
	}
	
	
	/*
	 * 参与合买人员
	 */
	public function join_users($type = 'all')
	{
		$get_page = intval($this->input->get('page'));
		$order_num = $this->input->get('order_num');                     //订单号码
		$page = !empty($get_page) ? intval($get_page) : "1";             //页码
		$pagesize = intval($this->input->get('pagesize'));
		$orderstr = intval($this->input->get('orderstr'));
		$orderby = $this->input->get('orderby');
		$total_rows = 10;
		$total_rows = !empty($pagesize) ? $pagesize : $total_rows; //页码
        
        $return = array();        
	    $user = $this->_user;
	    if (empty($order_num))
            exit();
        
        $planobj = Plans_jczqService::get_instance();
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
				'per_page' =>$total_rows,      //每页的数量
				'page' =>$page                 //页码
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

		$totalallcount = $planobj->query_count($query_struct);            //总记录数,用于显示总参与人数	
		
		if ($type == 'my')
		{
		    if (empty($this->_user))
		    {
		        //$query_struct['orwhere'] = array('id' => $result_parent['id'],); 
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
		
		$totalcount = $planobj->query_count($query_struct);            //记录数	
		
		$data_list = array();
		
		if ($type == 'my')
		{ 		    
    		$results = $planobj->query_assoc($query_struct);           //数据列表
    		$data_count = $result_parent['buyed'];        	           //总记录数
    		$total_pages = ceil($totalcount / $total_rows);            //总页数
    		
    		unset($query_struct['limit']);
    		$resultcount = $planobj->query_assoc($query_struct);       //用于统计份数,金额
    		$data_list['buymumber'] = 0;
    		$data_list['buymoney'] = 0;
    		foreach ($resultcount as $rowcount)
    		{
    		    $data_list['buymumber'] += $rowcount['my_copies'];
    		    $data_list['buymoney'] += $rowcount['my_copies'] * $result_parent['price_one'];
    		}
    		$data_list['totalrows'] = $totalcount;
    		$data_list['pagecount'] = $total_pages;
            $data_list['totalcount'] = $totalallcount;
		}
		else
		{
    		$results = $planobj->query_assoc($query_struct);           //数据列表
    		$data_count = $result_parent['buyed'];        	           //总记录数
    		$total_pages = ceil($totalcount / $total_rows);            //总页数  
            
    		$data_list['totalrows'] = $totalcount;
    		$data_list['pagecount'] = $total_pages;
            $data_list['totalcount'] = $totalcount;
            $data_list['buymumber'] = $data_count;
    		$data_list['buymoney'] = $result_parent['buyed'] * $result_parent['price_one'];		    
		}
		
        
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
		    $data_list['data'][$i]['rgperstr'] = sprintf("%01.2f", ($rowlist['my_copies'] / $result_parent['zhushu']));
		    $data_list['data'][$i]['addtime'] = $rowlist['time_stamp'];
		    $i++;
		}
		//d($data_list);
        exit(json_encode($data_list));
	}	
	
	/**
	 * 胜平负单式上传
	 * Enter description here ...
	 */
	public function ds_spf() {
		$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
        
        $play_type = 1;
        $ticket_type = 1;
        $ds = 1;

    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        
        try 
        {
            $data = array();
            
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $data['play_type'] = $play_type;
            $data['ds'] = $ds;
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
    		
            $this->template = new View('jczq/rqspf_ds', $data);
            $this->template->set_global('_user', $this->_user);
        
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	} 
	
	/**
	 * 单式上传确认
	 * Enter description here ...
	 */
	public function ds_tobuy() {
		header("Location: /jczq/rqspf");
		exit();
		$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
    	$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
        try 
        {
            $data = array();
            
            $data['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$data['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$data['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$data['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $planobj = Plans_jczqService::get_instance();
			$data = $planobj->ds_upload($user['id']);
			$data['time_end'] = null;
        	for ($i = 0; $i < count($data['d']); $i++) {
				$match_info = $data['d'][$i]['match_info'];
				for ($j = 0; $j < count($match_info); $j++) {
					if (empty($data['time_end']))
						$data['time_end'] = $match_info[$j]['info']['time_end'];
					if (strtotime($match_info[$j]['info']['time_end']) < strtotime($data['time_end']))
						$data['time_end'] = $match_info[$j]['info']['time_end'];
				}
			}
			
			$data['ticket'] = Kohana::config('ticket_type');
			$data['ticket_type'] = 1;
			$data['is_hemai'] = 0;
            $return_data = array();
            $return_struct['status']  = 1;
            $return_struct['code']    = 200;
            $return_struct['msg']     = '';
            $return_struct['content'] = $return_data;
            $this->template = new View('jczq/tobuy_ds', $data);
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	} 
	
	/**
	 * 单式上传提交
	 * Enter description here ...
	 */
	public function pute_ds() {
        $msg = array();
        $msg['errcode'] = -1;
        $msg['headerurl'] = '';
        $msg['msg'] = '提交时发生了一个错误!';
        
        if (empty($_POST))
            exit(json_encode($msg));
            
        //$msg['msg'] = '暂不可以投注';
        //exit(json_encode($msg));
            
        //$msg['msg'] = tool::debu_array($_POST, "<br>");    
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
            
            $databasic['user_id'] = $this->_user['id'];
            $databasic['start_user_id'] = $this->_user['id'];
            $databasic['ticket_type'] =  $this->input->post('ticket_type');
            $databasic['play_method'] = $this->input->post('play_method');
            $databasic['date_end'] = $this->input->post('time_end');
            $databasic['plan_type'] = $this->input->post('is_hemai');
            
            $data['price'] = $this->input->post('totalmoney');            //默认价格,合买会有所不同
            $data['is_hemai'] = $this->input->post('is_hemai');
            $tmp_path = $this->input->post('tmp_path');
            
            //$msg['msg'] = tool::debu_array($databasic, "<br>");    
        	//exit(json_encode($msg));
            
            //再次验证余额
            $userobj = user::get_instance();
            $usermoney = $userobj->get_user_money($this->_user['id']);
            $create_ticket = TRUE;
            
            //验证赛事是否过期
            $plans_obj = Plans_jczqService::get_instance();
            $file_content = @file_get_contents($tmp_path);
            if ($file_content == false) {
            	$msg['msg'] = '投注内容过期，请重新上传';
				exit(json_encode($msg));
            }
			$file_data = $plans_obj->ds_jiexi1($file_content);
			if ($file_data == false) {
				$msg['msg'] = '投注内容有误，请重新上传';
				exit(json_encode($msg));
			}
			
        	$data_count = count($file_data);
        	$totalrate = 0;
        	$totalcodes = array();
        	$totaltypename = array();
			for ($i = 0; $i < $data_count; $i++) {
				$match_info = $file_data[$i]['match_info'];
				$totalcodes[] = $file_data[$i]['code'];
				if (!in_array($file_data[$i]['typename'], $totaltypename)) {
					$totaltypename[] = $file_data[$i]['typename'];
				}
				$totalrate += $file_data[$i]['rate'];
				for ($j = 0; $j < count($match_info); $j++) {
					if ($match_info[$j]['info']['match_end']) {
						$msg['msg'] = '有赛事过期，请重新上传';
						exit(json_encode($msg));
					}
				}
			}
			$totalcodes = implode('/', $totalcodes);
			$totaltypename = implode(',', $totaltypename);
			$upload_filepath = $plans_obj->ds_upload_save($this->_user['id'], $tmp_path);
			if ($upload_filepath == false) {
				$msg['msg'] = '文件上传错误';
				exit(json_encode($msg));
			}
			//$msg['msg'] = tool::debu_array($upload_filepath, "<br>");    
        	//exit(json_encode($msg));
			
            if ($data['is_hemai'] == 1)
            {
                $data['plan_type'] = 1;                     //是否合买
                $data['status'] = 1;                        //方案状态
                $totalmoney = $this->input->post('totalmoney');
                $data['zhushu'] = $this->input->post('zhushu');
                $data['my_copies'] = $this->input->post('my_copies');
                $data['baodinum'] = $this->input->post('baodinum');
                $data['price_one'] = $totalmoney / $data['zhushu'];                
                $myprice = $data['price_one'] * $data['my_copies'] + $data['price_one'] * $data['baodinum'];
                $data['deduct'] = $this->input->post('deduct');            
                $data['total_price'] = $totalmoney;
                $data['price'] = $myprice;
                $data['progress'] = intval($data['my_copies']/$data['zhushu'] * 100);
                $data['buyed'] = $data['my_copies'];
                $data['title'] = $this->input->post('title', NULL);
                $data['content'] = $this->input->post('content', NULL);
                $data['friends'] = $this->input->post('buyuser', NULL);
                $data['isset_buyuser'] = $this->input->post('isset_buyuser');
                $data['surplus'] = $data['zhushu']- $data['buyed'];
                
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
                $data['zhushu'] = 1;
                $data['buyed'] = 1;
                $data['surplus'] = 0;
                $data['my_copies'] = 1;
            }

            //检查余额
            if ($usermoney < $myprice)
            {
                $msg['msg'] = '余额不足，请先充值后再购买！';
                exit(json_encode($msg));
            }
            
        	//检查限号
            $data['time_end'] = $this->input->post('time_end');
            if (strtotime($data['time_end']) < time())
            {
                $msg['msg'] = '方案已截止，请检查是否有截止的赛事！';
                exit(json_encode($msg));
            }
            
            $data['ticket_type'] = $databasic['ticket_type'];
            $data['play_method'] = $databasic['play_method'];
            $data['start_user_id'] = $this->_user['id'];
            $data['user_id'] = $this->_user['id'];
            $data['codes'] = $totalcodes;
            $data['special_num'] = $this->input->post('special_num');
            $data['typename'] = $totaltypename;
            $data['gggroup'] = $this->input->post('gggroup');
            $data['copies'] = $data_count;
            $data['rate'] = $totalrate;
            $data['bonus_max'] = $this->input->post('bonus_max');
            
            if (!is_numeric($data['bonus_max']))
            {
                $data['bonus_max'] = 0;
            }
            
            $data['gggroup'] == 2 && $data['special_num'] = NULL;            //多串过关清空胆码
            
            $plans_basic_obj = Plans_basicService::get_instance();           //方案基表类
            $basic_id = $plans_basic_obj->add($databasic);
            $data['basic_id'] = $basic_id;
            $data['upload_filepath'] = $upload_filepath;
            //$msg['msg'] = tool::debu_array($data, "<br>");    
        	//exit(json_encode($msg));
        	
            if (!($id = $plans_obj->add($data)))
            {
                $msg['msg'] = '提交时发生了一个错误!';
                exit(json_encode($msg));
            }
            else 
            {
                $msg['errcode'] = 0;
                $msg['msg'] = '提交成功!';
                $msg['headerurl'] = '/jczq/buyok/';
                
                $session = Session::instance();           
                $session->set('buywin_id', $id);
                
                //购买成功则扯分彩票存入彩票表,打印彩票的格式
                if ($create_ticket) {
	                for ($i = 0; $i < $data_count; $i++) {
						$play_method = $file_data[$i]['play_type'];
						$codes = $file_data[$i]['code'];
						$typename = $file_data[$i]['typename'];
						$rate = $file_data[$i]['rate'];
						$plans_obj->get_tickets($id, $play_method, $codes, $typename, null, $rate, $basic_id);
					}
                    //$plans_obj->get_tickets($id, $data['play_method'], $data['codes'], $data['typename'], $data['special_num'], $data['rate'], $basic_id);
                }
                
                //记录日志
                $data_log = array();
                $data_log['order_num'] = $basic_id;
                $data_log['user_id'] = $this->_user['id']; 
                $data_log['log_type'] = 2;                 //参照config acccount_type 设置
                $data_log['is_in'] = 1;
                $data_log['price'] = $myprice;
                $data_log['user_money'] = $usermoney;
                
                $lan = Kohana::config('lan');
                $data_log['memo'] = $lan['money'][1];
                
                if (!empty($data['baodinum']))
                    $data_log['memo'] .= ','.$lan['money'][5];
                
                account_log::get_instance()->add($data_log);
                
                 //当是代购时更新方案基表状态
                if ($data['is_hemai'] == 0)
                {
                    
                }
                $plans_obj->update_status($id, $data['status']);
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
	
    public function cancel_plan($order_num) {
    	$plan_basic_obj = Plans_basicService::get_instance();
    	$userid = $this->_user['id'];
    	if ($plan_basic_obj->is_cancel_plan($order_num, $userid) == true) {
    		$planobj = plan::get_instance();
    		$planobj->cancel_plan($order_num);
    	}
    	header("Location: /jczq/viewdetail/".$order_num);
    	exit();
    }
}
