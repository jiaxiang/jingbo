<?php defined('SYSPATH') OR die('No direct access allowed.');

class Attribute_value_Model extends ORM {
    protected $belongs_to = array('attributes');
	
}