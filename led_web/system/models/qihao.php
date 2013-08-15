<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: acl.php 1 2010-01-08 01:19:27 $
 * $Author: zhu $
 * $Revision: 1 $
 */

class Qihao_Model extends ORM {
	public $sorting=array();
    /**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
    public function validate(array & $array, $save = FALSE)
	{
		$fields = parent::as_array();
		
		$array = array_merge($fields, $array);
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('qihao', 'required')
			->add_rules('lotyid', 'required','numeric')
			->add_rules('endtime','required')
			->add_rules('ktime', 'required')
			->add_rules('dendtime', 'required')
			->add_rules('fendtime', 'required')
			->add_rules('isnow', 'required','numeric')
			->add_rules('buystat', 'required','numeric')
			;

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
}