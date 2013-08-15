<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ag_relation_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('agentid', 'required', 'numeric')
			->add_rules('user_id', 'required', 'numeric')
			->add_rules('flag',    'required', 'numeric')
			->add_rules('client_type', 'required', 'numeric')
			->add_rules('client_rate', 'required', 'numeric')
			->add_rules('client_rate_beidan', 'required', 'numeric')
			->add_rules('date_add', 'length[0,100]')
			->add_rules('date_end', 'length[0,100]')
			->add_rules('adminid', 'numeric');
			

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>