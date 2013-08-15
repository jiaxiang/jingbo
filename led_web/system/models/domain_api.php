<?php defined('SYSPATH') OR die('No direct access allowed.');

class Domain_api_Model extends ORM {
    protected $has_many = array('domains','domain_api_prices');
}
