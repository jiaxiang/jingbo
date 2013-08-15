<?php defined('SYSPATH') OR die('No direct access allowed.');

class Log_Model extends ORM {

	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array & $array, $save = FALSE)
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('type', 'required', 'length[0,255]')
			->add_rules('log','required', 'length[0,65535]')
			->add_rules('created', 'length[0,255]');

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

