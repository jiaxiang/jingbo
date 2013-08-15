<?php defined('SYSPATH') OR die('No direct access allowed.');
class Auto_Controller extends Template_Controller {
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {

    }
    
    /**
     * 清保
     */
    public function expired_plan() {
    	plan::get_instance()->expired_plan();    //过期自动返还
    	echo '处理了过期自动返还<br>';
    }
    
    /**
     * 北单自动派奖
     */
    public function bjdc_plan_bonus() {
    	$bjdc_obj = Plans_bjdcService::get_instance();
    	$results = $bjdc_obj->get_unpaijiang_id();
    	if(empty($results))
    	{
    		echo '北单无需要派奖订单...<br>';
    		return ;
    	}
    	$i = 0;
    	foreach ($results as $row)
    	{
    		$bjdc_obj->bonus_plan($row);
    		$i++;
    	}
    	echo '北单自动兑奖: '.$i.' 条...';
    }
    
    
}
