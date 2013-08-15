<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_saleschannel_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('code',    'required', 'length[0,20]')
			->add_rules('name',    'required', 'length[0,50]')
			->add_rules('des',     'required', 'length[0,200]')
			->add_rules('apdtime', 'required', 'length[0,100]')
			->add_rules('updtime', 'required', 'length[0,100]')
			->add_rules('flag',    'required', 'numeric');
			

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>
