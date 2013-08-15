<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jspl_Controller extends Template_Controller {
	
	/**
	 * 亚盘页面数据
	 * Enter description here ...
	 * @param unknown_type $match_id
	 */
	public function odd_yp($match_id) {
		$obj_jspl = jspl::get_instance();
		$obj_match = jsbf::get_instance();
		$jspl_data = $jspl_data_sel = $obj_jspl->getPLData(1, $match_id);
		$first_pk = $js_pk = $company_id = $home_js_sp = $away_js_sp = $home_first_sp = $away_first_sp = array();
		foreach ($jspl_data_sel as $key => $value) {
			$company_id[$key] = $value['company_id'];
			$home_js_sp[$key] = $value['home_js_sp'];
			$away_js_sp[$key] = $value['away_js_sp'];
			$home_first_sp[$key] = $value['home_first_sp'];
			$away_first_sp[$key] = $value['away_first_sp'];
			$first_pk[$key] = $value['first_pk'];
			$js_pk[$key] = $value['js_pk'];
		}
		array_multisort($first_pk, SORT_DESC, $jspl_data_sel);
		$first_pk_max = $jspl_data_sel[0];
		$first_pk_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($js_pk, SORT_DESC, $jspl_data_sel);
		$js_pk_max = $jspl_data_sel[0];
		$js_pk_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($home_js_sp, SORT_DESC, $jspl_data_sel);
		$home_js_sp_max = $jspl_data_sel[0];
		$home_js_sp_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($away_js_sp, SORT_DESC, $jspl_data_sel);
		$away_js_sp_max = $jspl_data_sel[0];
		$away_js_sp_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($home_first_sp, SORT_DESC, $jspl_data_sel);
		$home_first_sp_max = $jspl_data_sel[0];
		$home_first_sp_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($away_first_sp, SORT_DESC, $jspl_data_sel);
		$away_first_sp_max = $jspl_data_sel[0];
		$away_first_sp_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$match_data = $obj_match->getMatchInfoById($match_id);
		$result = array('pl'=>$jspl_data, 
		'first_pk_max'=>$first_pk_max,
		'first_pk_min'=>$first_pk_min,
		'js_pk_max'=>$js_pk_max,
		'js_pk_min'=>$js_pk_min,
		'home_js_sp_max'=>$home_js_sp_max,
		'home_js_sp_min'=>$home_js_sp_min,
		'away_js_sp_max'=>$away_js_sp_max,
		'away_js_sp_min'=>$away_js_sp_min,
		'home_first_sp_max'=>$home_first_sp_max,
		'home_first_sp_min'=>$home_first_sp_min,
		'away_first_sp_max'=>$away_first_sp_max,
		'away_first_sp_min'=>$away_first_sp_min,
		'match'=>$match_data);
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
			
            $this->template = new View('jspl/odd_yp', $result);
            $this->template->set_global('_topnav','is_jsbf');
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	}
	
	/**
	 * 欧赔页面数据
	 * Enter description here ...
	 * @param unknown_type $match_id
	 */
	public function odd_op($match_id) {
		$obj_jspl = jspl::get_instance();
		$obj_match = jsbf::get_instance();
		$jspl_data = $jspl_data_sel = $obj_jspl->getPLData(2, $match_id);
		$match_data = $obj_match->getMatchInfoById($match_id);
		$result = array('pl'=>$jspl_data, 'match'=>$match_data);
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
			
            $this->template = new View('jspl/odd_op', $result);
            $this->template->set_global('_topnav','is_jsbf');
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	}
	
	/**
	 * 大小球页面数据
	 * Enter description here ...
	 * @param unknown_type $match_id
	 */
	public function odd_dx($match_id) {
		$obj_jspl = jspl::get_instance();
		$obj_match = jsbf::get_instance();
		$jspl_data = $jspl_data_sel = $obj_jspl->getPLData(3, $match_id);
		$first_pk = $js_pk = $company_id = $first_d_sp = $first_x_sp = $js_d_sp = $js_x_sp = array();
		foreach ($jspl_data_sel as $key => $value) {
			$company_id[$key] = $value['company_id'];
			$first_d_sp[$key] = $value['first_d_sp'];
			$first_x_sp[$key] = $value['first_x_sp'];
			$js_d_sp[$key] = $value['js_d_sp'];
			$js_x_sp[$key] = $value['js_x_sp'];
			$first_pk[$key] = $value['first_pk'];
			$js_pk[$key] = $value['js_pk'];
		}
		array_multisort($first_pk, SORT_DESC, $jspl_data_sel);
		$first_pk_max = $jspl_data_sel[0];
		$first_pk_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($js_pk, SORT_DESC, $jspl_data_sel);
		$js_pk_max = $jspl_data_sel[0];
		$js_pk_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($first_d_sp, SORT_DESC, $jspl_data_sel);
		$first_d_sp_max = $jspl_data_sel[0];
		$first_d_sp_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($first_x_sp, SORT_DESC, $jspl_data_sel);
		$first_x_sp_max = $jspl_data_sel[0];
		$first_x_sp_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($js_d_sp, SORT_DESC, $jspl_data_sel);
		$js_d_sp_max = $jspl_data_sel[0];
		$js_d_sp_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$jspl_data_sel = $jspl_data;
		array_multisort($js_x_sp, SORT_DESC, $jspl_data_sel);
		$js_x_sp_max = $jspl_data_sel[0];
		$js_x_sp_min = $jspl_data_sel[count($jspl_data_sel)-1];
		
		$match_data = $obj_match->getMatchInfoById($match_id);
		$result = array('pl'=>$jspl_data, 
		'first_pk_max'=>$first_pk_max,
		'first_pk_min'=>$first_pk_min,
		'js_pk_max'=>$js_pk_max,
		'js_pk_min'=>$js_pk_min,
		'first_d_sp_max'=>$first_d_sp_max,
		'first_d_sp_min'=>$first_d_sp_min,
		'first_x_sp_max'=>$first_x_sp_max,
		'first_x_sp_min'=>$first_x_sp_min,
		'js_d_sp_max'=>$js_d_sp_max,
		'js_d_sp_min'=>$js_d_sp_min,
		'js_x_sp_max'=>$js_x_sp_max,
		'js_x_sp_min'=>$js_x_sp_min,
		'match'=>$match_data);
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
			
            $this->template = new View('jspl/odd_dx', $result);
            $this->template->set_global('_topnav','is_jsbf');
            $this->template->set_global('_user', $this->_user);
        }
        catch(MyRuntimeException $ex)
        {
            $this->_ex($ex, $return_struct, $request_data);
        }
        $this->template->render(TRUE);
	}
}
?>