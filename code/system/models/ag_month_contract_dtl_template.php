<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ag_month_contract_dtl_template_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('contract_id', 'required', 'numeric')
			->add_rules('grade',       'required', 'numeric')
			->add_rules('minimum',     'required', 'numeric')
			->add_rules('maximum',     'required', 'numeric')
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
