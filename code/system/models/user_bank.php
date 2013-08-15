<?php defined('SYSPATH') OR die('No direct access allowed.');

class User_bank_Model extends ORM {
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
			->add_rules('user_id', 'required', 'numeric')
			->add_rules('bank_type', 'required', 'numeric')
			->add_rules('account', 'required', 'length[0,20]')
			->add_rules('bank_name', 'numeric')
			->add_rules('default', 'numeric')			
			->add_rules('province', 'length[0,50]')
			->add_rules('city', 'length[0,50]')
			->add_rules('bank_found', 'length[0,50]')
			->add_rules('turename', 'length[0,32]')
			;
            
		if(parent::validate($array, $save))
		{    
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	
}
