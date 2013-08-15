<?php defined('SYSPATH') OR die('No direct access allowed.');

class Attribute_Model extends ORM 
{
    protected $has_many = array('attribute_values');
   
}
?>