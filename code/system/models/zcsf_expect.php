<?php defined('SYSPATH') OR die('No direct access allowed.');

class Zcsf_expect_Model extends ORM {
	
	public function getExpects($expect_type){
		$result=$this->db->query("SELECT DISTINCT expect_num,end_time FROM zcsf_expects where expect_type='".$expect_type."' ORDER BY expect_num desc");
	
		return $result;
	}
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
		$array = array_merge($fields,$array);
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('changci', 'length[0,10]')//场次
			->add_rules('vs1', 'length[0,50]')//主队
			->add_rules('vs2', 'length[0,50]')//客队			
			->add_rules('game_time', 'length[0,50]')//客队				
			->add_rules('game_event', 'length[0,50]')//赛事						
			->add_rules('expect_num', 'length[0,50]')//期次	
			->add_rules('open_time', 'length[0,50]')//结束时间				
			->add_rules('status', 'length[0,50]')//结束时间
			->add_rules('expect_type', 'length[0,50]')//结束时间
			->add_rules('index_id', 'length[0,300]')//结束时间
			->add_rules('game_result', 'length[0,50]')//结束时间
			->add_rules('cai_result', 'length[0,300]')//结束时间
			;
		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	
}
