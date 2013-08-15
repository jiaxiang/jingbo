<?php defined('SYSPATH') OR die('No direct access allowed.');

class Plans_sfc_Model extends ORM {
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
		$array = array_merge($fields,$array);
		
		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('basic_id', 'required', 'length[0,100]')//基础表的ID		
			->add_rules('is_buy', 'required', 'length[0,10]')//合买 1为合买，0为代买						
			->add_rules('parent_id', 'length[0,10]')//父ID	
			->add_rules('user_id', 'required', 'length[0,10]')//用户ID				
			->add_rules('ticket_type', 'required', 'numeric')//彩种
			->add_rules('play_method', 'required', 'length[0,10]')//玩法(单式，复式)
			->add_rules('codes', 'required')//选择的结果							
			->add_rules('expect', 'required', 'numeric')//期号
			
			->add_rules('zhushu', 'required', 'numeric')//总注数			
			->add_rules('rate', 'required', 'numeric')//倍数
			->add_rules('price', 'required', 'numeric')//总金额
			->add_rules('money', 'required', 'numeric')//总金额			

			->add_rules('copies', 'required', 'numeric')//份数
			->add_rules('price_one', 'required')//每份数的价格
			->add_rules('my_copies', 'required', 'numeric')	//我要认购份数*/
			->add_rules('is_baodi', 'required')//是否保底
			->add_rules('end_price', 'required')//保底金额
			->add_rules('is_open', 'required')//是否公开


			->add_rules('title', 'length[0,200]')//方案宣传标题
			->add_rules('description', 'length[0,500]')//方案宣传描述	*/
			->add_rules('friends', 'length[0,500]')//合买对像(all为所有用户,彩友用，号隔开)		
				//->add_rules('isset_buyuser', 'required', 'numeric')//合买对像(1为所有，2为指定彩友)	
				//->add_rules('code', 'required')//  未知参数 ['单', '双', '三', '四'];
				
			->add_rules('is_upload', 'required')//是否上传	
			->add_rules('upload_filepath', 'length[0,300]')//上传文件路径
			->add_rules('progress', 'required')//进度
			->add_rules('deduct', 'required')//提成比例			
			->add_rules('time_end', 'required')//结束时间	
			->add_rules('buyed', 'required')//已卖份数			
			->add_rules('type', 'required')//单式，复式
			->add_rules('is_select_code', 'required')//是否选号										
			;

		if(parent::validate($array, $save))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	
}
