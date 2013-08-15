<?php defined('SYSPATH') OR die('No direct access allowed.');

class Money_card_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('card_id', 'required', 'length[0,50]')
			->add_rules('card_pw', 'required', 'length[0,50]')
			->add_rules('value', 'required', 'numeric')
			->add_rules('status', 'numeric');
		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>