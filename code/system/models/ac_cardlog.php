<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_cardlog_Model extends ORM 
{
	const TARGET_CARD         = 'Card';
	const TARGET_CARD_SERIAL  = 'Card_Serial';
	const TARGET_CARD_ISSUE   = 'Card_Issue';
	const TARGET_CARD_OPEN    = 'Card_Open';
	const TARGET_CARD_TYPE    = 'Card_Type';
	const TARGET_SALE_CHANNEL = 'Sale_Channel';
	
	const ACTION_CREATE = 'Create';
	const ACTION_CHANGE = 'Change';
	const ACTION_REMOVE = 'Remove';
	
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('userid',   'required', 'numeric')
			->add_rules('apdtime',  'length[0,100]')
			->add_rules('target',   'required', 'length[0,30]')
			->add_rules('targetid', 'numeric')
			->add_rules('action',   'required', 'length[0,20]')
			->add_rules('detail',   'length[0,255]');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>
