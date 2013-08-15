<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ticket_num_Model extends ORM {
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
			->add_rules('plan_id', 'required', 'numeric')
			->add_rules('ticket_type', 'required', 'numeric')
			->add_rules('play_method', 'required', 'length[0,10]')
			->add_rules('codes', 'required')
			->add_rules('order_num', 'numeric')
			->add_rules('money', 'numeric')
			->add_rules('status', 'numeric')
			->add_rules('bonus', 'numeric')
			->add_rules('rate', 'numeric')
			->add_rules('num', 'length[0,50]')
			->add_rules('port', 'length[0,50]')
			->add_rules('password', 'length[0,50]')
			;

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	
}
