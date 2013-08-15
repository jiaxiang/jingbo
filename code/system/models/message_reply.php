<?php defined('SYSPATH') OR die('No direct access allowed.');

class Message_reply_Model extends ORM {
	  protected $belongs_to = array('message','site');
}
?>
