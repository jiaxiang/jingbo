<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ag_settle_month_dtl_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('mcid', 'required', 'digt')
			->add_rules('masterid', 'required', 'digt')
			->add_rules('order_num', 'required', 'numeric')
	//		->add_rules('order_date_add', 'numeric')
			->add_rules('ticket_type', 'digt')
			->add_rules('user_id', 'numeric')
			->add_rules('agentid', 'digt')
			->add_rules('flag', 'digt')
			->add_rules('rate', 'numeric')
			->add_rules('fromamt', 'numeric');
			
		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>