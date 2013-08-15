<?php defined('SYSPATH') OR die('No direct access allowed.');

class Site_menu_Model extends ORM {
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
			->add_rules('type','numeric')
			->add_rules('relation_id','numeric')
			->add_rules('parent_id','numeric')
			->add_rules('level_depth','required','numeric')
			->add_rules('name','required','length[1,255]')
			->add_rules('url','required','length[1,255]')
			->add_rules('title','required','length[1,255]')
			->add_rules('target','required','numeric')
			->add_rules('order','numeric')
			->add_rules('memo','required','length[1,255]');

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
