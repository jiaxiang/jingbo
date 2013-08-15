<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_charge_order_Model extends ORM {
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
			->add_rules('status', 'required', 'numeric')
			->add_rules('user_id', 'required', 'numeric')	
			->add_rules('money', 'required', 'numeric')
			->add_rules('pay_type_id', 'numeric')
			->add_rules('ip', 'required', 'length[0,10]')
			->add_rules('order_num', 'required', 'length[0,20]')
			->add_rules('pay_name', 'length[0,255]');

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	
}
