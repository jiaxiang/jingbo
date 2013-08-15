<?php defined('SYSPATH') OR die('No direct access allowed.');

class Buylog_Model extends ORM {
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array & $array, $save = FALSE)
	{
		$fields = parent::as_array();
		$array = array_merge($fields,$array);
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('uid', 'required', 'numeric')
			->add_rules('plan_id', 'required', 'numeric')
			->add_rules('fromuid', 'required', 'numeric')
			->add_rules('plan_id', 'required', 'numeric')
			->add_rules('price', 'required', 'numeric')
			->add_rules('status', 'required', 'numeric')
			->add_rules('bonus', 'required', 'numeric')
			->add_rules('time_stamp', 'numeric');

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}   
}
