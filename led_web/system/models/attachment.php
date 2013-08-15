<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 数据DAO
 * @package feedback
 * @author nickfan<nickfan81@gmail.com>
 * @link http://feedback.ketai-cluster.com
 * @version $Id: attachment.php 35 2010-03-29 02:17:40Z fzx $
 */
class Attachment_Model extends ORM {
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array & $array, $save = FALSE, & $error)
	{
		$fields = parent::as_array();
		$array  = array_merge($fields, $array);
		
		if (!empty($array['attach_meta'])) {
			$array['attach_meta'] = json_encode($array['attach_meta']);
		}
		
		if (!empty($array['ref_array'])) {
			$array['ref_array'] = json_encode($array['ref_array']);
		}
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('store_id', 'required', 'digt')
			->add_rules('file_postfix', 'required', 'length[0,32]')
			->add_rules('file_mimetype', 'required', 'length[0,32]')
			->add_rules('file_size', 'required', 'digt')
			->add_rules('file_name', 'required', 'length[0,100]')
			->add_rules('attach_meta', 'length[0,1024]')
			->add_rules('src_ip', 'length[0,50]')
			->add_rules('file_type', 'digt')
			->add_rules('ref_count', 'required', 'digt')
			->add_rules('ref_array', 'required', 'length[0,1024]')
			->add_rules('create_timestamp', 'digt')
			->add_rules('modify_timestamp', 'digt')
			->add_rules('access_timestamp', 'digt');
			
		if (parent::validate($array, $save)) {
			return TRUE;
		} else {
			$error = $array->errors();
			return FALSE;
		}
	}
}