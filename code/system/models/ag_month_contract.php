<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ag_month_contract_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('user_id', 'required', 'numeric')
			->add_rules('flag',    'required', 'numeric')
			->add_rules('type',    'required', 'numeric')
			->add_rules('createtime',     'required', 'length[0,100]')
			->add_rules('starttime',      'required', 'length[0,100]')
			->add_rules('lastsettletime', 'required', 'length[0,100]')
			->add_rules('taxrate',        'required', 'numeric')
			->add_rules('note',     'length[0,255]');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>