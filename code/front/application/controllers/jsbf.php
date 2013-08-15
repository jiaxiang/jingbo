<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jsbf_Controller extends Template_Controller {
	
	public function index($date=NULL) {
		$this->show($date, 'jc');
	}
	
	public function all($date=NULL) {
		$this->show($date);
	}
	
	public function zcsf($date=NULL) {
		$this->show($date, 'zc');
	}
	
	public function jczq($date=NULL) {
		$this->show($date, 'jc');
	}
	
	public function bjdc($date=NULL) {
		$this->show($date, 'bd');
	}
	
	public function sg_select($type='jc', $date=NULL) {
		if ($date == NULL) {
			$date = date('Y-m-d');
		}
		$this->showSG($date, $type, -1);
	}
	
	public function showByAjax() {
		$date = NULL;
		$type = NULL;
		$status = NULL;
		$objmatch = jsbf::get_instance();
		$result = array();
		$data = $objmatch->getJSBFByAjax($date, $type, $status);
		for ($i = 0; $i < count($data); $i++) {
			$data[$i]['match_status'] = jsbf::$status_name[$data[$i]['match_status']].' '.jsbf::getTimeStatus($data[$i]['match_open_time'], $data[$i]['match_status']);
			$data[$i]['match_open_time'] = substr($data[$i]['match_open_time'], 5, 11);
			$result[$i] = $data[$i];
		}
		echo json_encode($result);
	}
	
	public function showEventByAjax() {
		$return = array();
		$match_id = $this->input->post('match_id');
		if ($match_id > 0) {
			$objmatch = jsbf::get_instance();
			$data = $objmatch->getMatchEvent($match_id);
			if (count($data) > 0) {
				for ($i = 0; $i < count($data); $i++) {
					if ($data[$i]['home_or_away'] == 1) {
						$data[$i]['home_or_away'] = '主队';
					}
					else {
						$data[$i]['home_or_away'] = '客队';
					}
					$data[$i]['match_event_type'] = jsbf::$event_info[$data[$i]['match_event_type']];
					$return[$i] = $data[$i];
				}
			}
		}
		echo json_encode($return);
	}
	
	public function show($date=NULL, $type=NULL, $status=NULL) {
		$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
		$objmatch = jsbf::get_instance();
		$result = array();
		/*$result['data'] = $objmatch->getBFByDate($date, $type, $status);
		if (count($result['data']) <= 0 && $date==NULL) {
			$mk = mktime(0, 0, 0, date('m')  , date('d')-1, date("Y"));
			$result['data'] = $objmatch->getBFByDate(date('Y-m-d',$mk), $type, -1);
		}*/
		$result['data'] = $objmatch->getJSBFByDate($date, $type, $status);
		switch ($type) {
        	case 'zc': $viewpage = 'jsbf/zcsf'; break;
        	case 'jc': $viewpage = 'jsbf/jczq'; break;
        	case 'bd': $viewpage = 'jsbf/bjdc'; break;
        	default: $viewpage = 'jsbf/all'; break;
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
			
            $result['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$result['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$result['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$result['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $this->template = new View($viewpage, $result);
            $this->template->set_global('_topnav','is_live');
            $this->template->set_global('_user', $this->_user);
            $this->template->set_global('NO_KF',1);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	} 
	
	public function showSG($date=NULL, $type=NULL, $status=NULL) {
		$user = $this->_user;
        $userobj = user::get_instance();
        $userobj->get_user_money($user['id']);
		$objmatch = jsbf::get_instance();
		$result = array();
		$result['datetime'] = $date;
		$result['data'] = $objmatch->getBFByDate($date, $type, $status);
		switch ($type) {
        	case 'zc': $viewpage = 'jsbf/zcsf_sg'; break;
        	case 'jc': $viewpage = 'jsbf/jczq_sg'; break;
        	case 'bd': $viewpage = 'jsbf/bjdc_sg'; break;
        	default: $viewpage = 'jsbf/all_sg'; break;
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
			
            $result['site_config'] = Kohana::config('site_config.site');
            $host = $_SERVER['HTTP_HOST'];
            $dis_site_config = Kohana::config('distribution_site_config');
            if (array_key_exists($host, $dis_site_config) == true && isset($dis_site_config[$host])) {
            	$result['site_config']['site_title'] = $dis_site_config[$host]['site_name'];
            	$result['site_config']['keywords'] = $dis_site_config[$host]['keywords'];
            	$result['site_config']['description'] = $dis_site_config[$host]['description'];
            }
            
            $this->template = new View($viewpage, $result);
            $this->template->set_global('_topnav','is_sgcx');
            $this->template->set_global('_user', $this->_user);
            $this->template->set_global('NO_KF',1);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	} 
	
}
?>