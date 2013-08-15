<?php defined('SYSPATH') or die('No direct script access.');

class Delivery_Core
{
	/**
	 * 根据参数获得最终价格
	 * 
	 * @param string $exp
	 * @param int $weight
	 * @param float $totalmoney
	 * @param int $defPrice default '0'
	 * @return float $dprice
	 */
	function cal_fee($exp,$weight,$totalmoney,$defPrice=0)
	{
	    if($str=trim($exp))
	    {
	        $dprice = 0;
	        $weight = $weight + 0;
	        $totalmoney = $totalmoney + 0;
	        $str = str_replace("[", "self::getceil(", $str);
	        $str = str_replace("]", ")", $str);
	        $str = str_replace("{", "self::getval(", $str);
	        $str = str_replace("}", ")", $str);
	
	        $str = str_replace("w", $weight, $str);
	        $str = str_replace("W", $weight, $str);
	        $str = str_replace("p", $totalmoney, $str);
	        $str = str_replace("P", $totalmoney, $str);
            
	        eval("\$dprice = $str;");
	        if($dprice === 'failed'){
	            return $defPrice;
	        }else{
	            return $dprice;
	        }
	    }
	    else
	    {
	        return $defPrice;
	    }
	}
	
	/**
	 * 获取{}里面的值
	 * 
	 * @param string $exp
	 * @return float
	 */
	function getval($expval)
	{
	    $expval = trim($expval);
	    if($expval !== '')
	    {
		    eval("\$expval = $expval;");
		    if ($expval > 0)
		    {
		        return 1;
		    }
		    else if ($expval == 0)
		    {
		        return 1/2;
		    }
		    else
		    {
		        return 0;
		    }
	    }
	    else
	    {
	        return 0;
	    }
	}
	
	/**
	 * 获取[]里面的值
	 * 
	 * @param string $exp
	 * @return float
	 */
	function getceil($expval)
	{
	    if($expval = trim($expval))
	    {
		    eval("\$expval = $expval;");
		    if ($expval > 0)
		    {
		        return ceil($expval);
		    }
		    else
		    {
		        return 0;
		    }
	    }
	    else
	    {
	        return 0;
	    }
	}
	
	function get_delivery_name($id){
		return DeliveryService::get_delivery_name($id);
	}
}
