<?php defined('SYSPATH') OR die('No direct access allowed.');

class Ac_cardchargelog_Model extends ORM 
{
	public function validate(array & $array, $save = FALSE, & $errors) 
	{
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('userid',      'required', 'numeric')
			->add_rules('cardnum',     'required', 'numeric')
			->add_rules('chargetime',  'required', 'length[0,100]')
			->add_rules('user_money',  'required', 'numeric')
			->add_rules('bonus_money', 'required', 'numeric')
			->add_rules('free_money',  'required', 'numeric');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}

?>
