<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plans_basic_Model extends ORM {
	public $sorting=array();
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
			->add_rules('plan_type', 'required', 'numeric')
			->add_rules('user_id', 'required', 'numeric')
			->add_rules('start_user_id', 'required', 'numeric')
			->add_rules('order_num', 'required', 'numeric')
			->add_rules('ticket_type', 'required', 'numeric')
			->add_rules('play_method', 'required', 'numeric')
			->add_rules('date_end', 'length[0,50]')
			->add_rules('status', 'numeric');

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	
}
