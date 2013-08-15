<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_cardtype_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('name', 'required', 'length[0,50]')
			->add_rules('apdtime', 'required', 'length[0,50]');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>
