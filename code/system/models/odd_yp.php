<?php defined('SYSPATH') OR die('No direct access allowed.');

class Odd_yp_Model extends ORM {
    //protected $belongs_to = array('match_details');
    
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	/*public function validate(array & $array, $save = FALSE)
	{
		$fields = parent::as_array();
		$array = array_merge($fields,$array);
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('play_type', 'numeric')
			->add_rules('match_num', 'numeric')
			->add_rules('match_id', 'numeric')
			->add_rules('goalline', 'numeric')
			->add_rules('comb','required', 'length[0,65535]');

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}   */
}
?>