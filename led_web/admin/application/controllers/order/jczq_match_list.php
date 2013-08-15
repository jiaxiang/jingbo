<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jczq_match_list_Controller extends Template_Controller {
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
    
	public function match_list($ticket_type) {	
		$match_detail_obj = match::get_instance();
		$data['match_list'] = $match_detail_obj->get_over_match($ticket_type);
		if ($ticket_type == 1) {
			$view_page = 'order/jczq_match_list';
		}
		if ($ticket_type == 6) {
			$view_page = 'order/jclq_match_list';
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
            $this -> template -> content = new View($view_page, $data);
        }catch(MyRuntimeException $ex){
            $this->_ex($ex, $return_struct, $request_data);
        }
	}
	
	public function match_list_unstart($ticket_type) {
		$match_detail_obj = match::get_instance();
		$data['match_list'] = $match_detail_obj->get_unstart_match($ticket_type);
		if ($ticket_type == 1) {
			$view_page = 'order/jczq_match_list_unstart';
		}
		if ($ticket_type == 6) {
			$view_page = 'order/jclq_match_list_unstart';
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
			$this -> template -> content = new View($view_page, $data);
		}catch(MyRuntimeException $ex){
			$this->_ex($ex, $return_struct, $request_data);
		}
	}
	
	public function set_result() {
        //初始化返回数组
		$return_struct = array(
            'status'        => 0,
            'code'          => 501,
            'msg'           => 'Not Implemented',
            'content'       => array(),
        );
		$request_data = $this->input->get();
       	$id = $request_data['id'];
       	$result = $request_data['order'];
       	if ($result != '') {
			$match_detail_obj = match::get_instance();
       		$r = $match_detail_obj->update_match_result($id, $result);
       		if ($r == false) {
       			$return_struct['msg'] = Kohana::lang('o_global.position_error');
       		}
       		else {
       			$return_struct = array(
                'status'        => 1,
                'code'          => 200,
                'msg'           => Kohana::lang('o_global.position_success'),
                'content'       => array('order'=>$result),
            	);
       		}
       	}
       	else {
       		$return_struct['msg'] = Kohana::lang('o_global.bad_request');
       	}
       	exit(json_encode($return_struct));
	}	
	
	public function set_match_cancel() {
		//初始化返回数组
		$return_struct = array(
				'status'        => 0,
				'code'          => 501,
				'msg'           => 'Not Implemented',
				'content'       => array(),
		);
		$request_data = $this->input->get();
		$id = $request_data['id'];
		$result = $request_data['order'];
		if ($result != '') {
			$match_detail_obj = match::get_instance();
			$r = $match_detail_obj->update_match_pool_id($id, $result);
			if ($r == false) {
				$return_struct['msg'] = Kohana::lang('o_global.position_error');
			}
			else {
				$return_struct = array(
						'status'        => 1,
						'code'          => 200,
						'msg'           => Kohana::lang('o_global.position_success'),
						'content'       => array('order'=>$result),
				);
			}
		}
		else {
			$return_struct['msg'] = Kohana::lang('o_global.bad_request');
		}
		exit(json_encode($return_struct));
	}
}
?>