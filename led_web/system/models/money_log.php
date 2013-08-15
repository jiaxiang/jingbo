<?php defined('SYSPATH') OR die('No direct access allowed.');

class Money_log_Model extends ORM {
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
		
		$array = array_merge($fields, $array);
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('account_log_id', 'required', 'numeric')
			->add_rules('user_id', 'required', 'numeric')
			->add_rules('log_type', 'required', 'length[0,20]')
			->add_rules('price', 'required', 'numeric')
			->add_rules('user_money', 'required', 'numeric')
			->add_rules('is_in', 'numeric')
			->add_rules('memo', 'length[0,65535]');

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	
}
