<?php defined('SYSPATH') OR die('No direct access allowed.');

class Site_link_Model extends ORM {

	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array $array, $save = FALSE) {

		$fields = parent::as_array();
		$array = array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name','required','length[1,255]')
			->add_rules('url','required','length[1,255]')
			->add_rules('email' ,'length[1,100]')
			->add_rules('logo' ,'length[1,255]')
			->add_rules('title' ,'length[1,255]')
			->add_rules('target', 'numeric')
			->add_rules('status', 'numeric')
			->add_rules('order','numeric');

		if(parent::validate($array, $save)) 
		{
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
}
