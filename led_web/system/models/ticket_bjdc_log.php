<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ticket_bjdc_log_Model extends ORM {
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
			->add_rules('ticket_id', 'required', 'numeric')
			->add_rules('betid', 'required', 'numeric')
			->add_rules('issue', 'required', 'numeric')
			->add_rules('playtype', 'required', 'numeric')
			->add_rules('money', 'required', 'numeric')
			->add_rules('amount', 'required', 'numeric')
			->add_rules('code', 'required')
			->add_rules('result', 'required')
			->add_rules('result_name', 'required')
			;

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
?>