<?php defined('SYSPATH') OR die('No direct access allowed.');

class Test_Controller extends Template_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
	    $userobj = user::get_instance();
	    $data['email'] = 'asdsaa@gmail.com';
	    if ($userobj->email_available($data['email']) == false) {
	    	echo 'f';
	    	d($data['email']);
	    }
	    else {
	    	echo 't';
	    	d($data['email']);
	    }
	}
	
	function bMap() {
		$view = new View('bmap');
		$view->render(TRUE);
	}
}
