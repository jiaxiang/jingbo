<?php defined('SYSPATH') OR die('No direct access allowed.');

class Block_Model extends ORM {

	protected $belongs_to = array('theme');

	public function validate(array & $array, $save = FALSE, & $errors) {
		$fields=parent::as_array();
		$array=array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('tag','required','length[1,255]')
			->add_rules('content','required','length[1,65535]')
			->add_rules('brief','required','length[1,255]')
			->add_rules('type','required','numeric')
			->add_rules('theme_id','required','numeric');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
}
?>
