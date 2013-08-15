<?php defined('SYSPATH') OR die('No direct access allowed.');

class Superplaners_settle_realtime_dtl_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('rcid', 'required')
			->add_rules('masterid', 'required')
			->add_rules('order_num', 'required', 'numeric')
			->add_rules('settletime', 'length[0,100]')
			->add_rules('user_id', 'numeric')
			->add_rules('agentid', 'numeric')
			->add_rules('flag', 'numeric')
			->add_rules('ticket_type', 'numeric')
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