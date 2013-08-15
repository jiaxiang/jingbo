<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_issuebilldtl_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('mstid',  'required', 'numeric')
			->add_rules('num',    'required', 'length[0,20]')
			->add_rules('mgrnum', 'required', 'numeric');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>
