<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plans_bjdc_Model extends ORM {
	
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
		
		$array = array_merge($fields, $array);
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('basic_id', 'required', 'numeric')
			->add_rules('parent_id', 'numeric')
			->add_rules('plan_type', 'numeric')
			->add_rules('issue', 'required', 'numeric')
			->add_rules('user_id', 'required', 'numeric')
			->add_rules('play_method', 'required', 'numeric')
			->add_rules('codes', 'required')
			->add_rules('typename', 'required')
			->add_rules('special_num', 'length[0,255]')
			->add_rules('price', 'required', 'numeric')
			->add_rules('rate', 'required', 'numeric')
			->add_rules('time_end', 'required', 'length[0,20]')
			->add_rules('copies', 'numeric')
			->add_rules('rate', 'numeric')
			->add_rules('progress', 'numeric')
			->add_rules('status', 'numeric')
			->add_rules('zhushu', 'numeric')
			->add_rules('buyed', 'numeric')
			->add_rules('surplus', 'numeric')
			->add_rules('total_price', 'numeric')
			->add_rules('my_copies', 'numeric')
			->add_rules('price_one', 'numeric')
			->add_rules('deduct', 'numeric')
			->add_rules('baodinum', 'numeric')
			->add_rules('isset_buyuser', 'numeric')
			->add_rules('bonus', 'numeric')
			->add_rules('title', 'length[0,255]')
			->add_rules('content', 'length[0,65535]')
			->add_rules('friends', 'length[0,65535]')
			;

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	
}
