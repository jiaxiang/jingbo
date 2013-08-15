<?php defined('SYSPATH') OR die('No direct access allowed.');

class Index_Controller extends Template_Controller {

    public function index() {
    	$this->_language = 'en';
    	$site = new Site_Controller();
    	$site->index($this->_language);
    }

}
?>