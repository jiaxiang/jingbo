<?php defined('SYSPATH') or die('No direct access allowed.');
//http://180.153.223.69/wx/
define("TOKEN", "dQXC3p5v9sQ64RKf");
class Wx_Controller extends Template_Controller {

	public function test() {
		$wechatObj = WxService::get_instance();
		$wechatObj->valid();
	}

	public function index() {
		$wechatObj = WxService::get_instance();
		if ($wechatObj->valid() == TRUE) {
			//$wechatObj->responseMsg();
			$wechatObj->showJsbf();
		}
		else {
			die('what\'s the fuck!');
		}
	}
}