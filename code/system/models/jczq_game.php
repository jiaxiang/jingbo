<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jczq_game_Model extends ORM {
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	//public function validate(array & $array, $save = FALSE)
	//{
	//	$fields = parent::as_array();
	//	$array = array_merge($fields,$array);
    //
	//	$array = Validation::factory($array)
	//		->pre_filter('trim')
	//		->add_rules('uid', 'required', 'numeric')
	//		->add_rules('ticket_type', 'required', 'numeric')
	//		->add_rules('play_method', 'required', 'numeric')
	//		->add_rules('issue_number', 'required', 'length[0,50]')
	//		->add_rules('price', 'required')
	//		->add_rules('rate', 'required', 'numeric')
	//		->add_rules('copies', 'required', 'numeric')
	//		->add_rules('price_one', 'required', 'numeric')
	//		->add_rules('deduct', 'required', 'numeric')
	//		->add_rules('ticket_mark', 'required')
	//		->add_rules('buy_status', 'required')
	//		->add_rules('price', 'required', 'numeric')
	//		;
    //
	//	if(parent::validate($array, $save))
	//	{
	//		return TRUE;
	//	}else{
	//		return FALSE;
	//	}
	//}   
}
