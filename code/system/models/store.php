<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 数据DAO
 * @package feedback
 * @author nickfan<nickfan81@gmail.com>
 * @link http://feedback.ketai-cluster.com
 * @version $Id: store.php 35 2010-03-29 02:17:40Z fzx $
 */
class Store_Model extends ORM {
	
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array & $array, $save = FASLE, & $error)
	{
		$fields = parent::as_array();
		$array  = array_merge($fields, $array);
		
		if (!empty($array['stroe_meta'])) {
			$array['store_meta'] = json_encode($array['store_meta']);
		}
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('store_type', 'required', 'chars[1,2,3,4]')
			->add_rules('get_uri', 'required', 'length[0,255]')
			->add_rules('set_uri', 'length[0,255]')
			->add_rules('store_meta', 'length[0,1024]');
			//->add_rules('store_content', );
			
		if (parent::validate($array, $save)) {
			return TRUE;
		} else {
			$error = $array->errors();
			return FALSE;
		}
	}
}