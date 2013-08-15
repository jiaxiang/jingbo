<?php defined('SYSPATH') OR die('No direct access allowed.');
class Guoguan_Controller extends Template_Controller {

	public function __construct()
	{
		
		parent::__construct();
		
	}
	
	public function index(){
		url::redirect('/guoguan/jczq/rqspf');
	}
}
