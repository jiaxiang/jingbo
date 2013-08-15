<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ag_month_contract_dtl_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('contract_id', 'required', 'numeric')
			->add_rules('grade', 'required', 'numeric')
			->add_rules('createtime',  'required', 'length[0,100]')
			->add_rules('minimum',     'required', 'length[0,100]')
			->add_rules('maximum',     'required', 'length[0,100]')
			->add_rules('rate',        'required', 'numeric');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>