<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_money_detail_Model extends ORM 
{
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
			->add_rules('income', 'required', 'numeric')
			->add_rules('expenditure', 'required', 'numeric')
			->add_rules('balance', 'required', 'numeric')
			->add_rules('transtype', 'required', 'numeric')
			->add_rules('ordernum', 'numeric', 'length[0,50]')
			->add_rules('remark', 'length[1,65535]')
			->add_rules('status', 'required', 'numeric')
			->add_rules('ip', 'required', 'length[0,20]')
			->add_rules('time_stamp', 'required', 'numeric');

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
