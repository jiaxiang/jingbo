<?php defined('SYSPATH') or die('No direct script access.');

class order_Core {

    /*
     * zhu add
     * 依据货品信息，处理订单的单次商品image，attribute_style信息
     */
    public function do_order_product_detail_data_by_good(&$order_product_detail_data, $good_full_data, $attach_id)
    {
	    /* 得到规格属性*/
        $picture_id = 0;
        $attri = array();
	    $attri['meta_struct'] = array(
	    		'items' => BLL_Product_Attribute::get_pdtattrrs($good_full_data['id']),
	    );
	    $decode_attributeoption = coding::decode_attributeoption($attri);
	    if(isset($decode_attributeoption['meta_struct']['items']) && is_array($decode_attributeoption['meta_struct']['items']) && count($decode_attributeoption['meta_struct']['items']))
	    {
	    	$attribute_style_temp = '';
	    	foreach($decode_attributeoption['meta_struct']['items'] as $attribute_id=>$attributeoption_id)
	    	{
	    		$attribute = AttributeService::get_instance()->get($attribute_id);
                $attribute['name_manage'] = $attribute['alias']?$attribute['alias']:$attribute['name'];
                $attribute_style_temp = $attribute['name_manage'];

                $attributeoption_id = is_array($attributeoption_id)?$attributeoption_id[0]:$attributeoption_id;
                if($attributeoption_id>0)
                {
    	    		$attributeoption = Attribute_valueService::get_instance()->get($attributeoption_id);
                    $attributeoption['name_manage'] = $attributeoption['alias']?$attributeoption['alias']:$attributeoption['name'];
    	    		$attribute_style_temp .= ':'.$attributeoption['name_manage'].',';
                }
                else
                {
                    $attribute_style_temp .= '(用户填写),';
                }
	    	}
	    	$attribute_style_temp = trim($attribute_style_temp,',');
	    	$order_product_detail_data['attribute_style'] = $attribute_style_temp;
	    }
        
	    /* 得到产品图片*/
	    $pic['meta_struct'] = $good_full_data['goods_productpic_relation_struct'];
	    $decode_pic = coding::decode_productpic($pic);
	    if(isset($decode_pic['meta_struct']['items']) && is_array($decode_pic['meta_struct']['items']) && count($decode_pic['meta_struct']['items']))
	    {
	    	$picture_id = array_shift($decode_pic['meta_struct']['items']);
	    }
	    elseif($attach_id)
	    {
	    	$query_struct = array('where'=>array('image_id'=>$attach_id, 'product_id'=>$good_full_data['id']));
	    	$data = array_shift(ProductpicService::get_instance()->index($query_struct));
	    	$picture_id = $data['id'];
	    }
	    if($picture_id > 0)
	    {
            $imgag_t = ProductpicService::PRODUCTPIC_STANDARDS_THUMBNAIL;
            $image = ProductpicService::get_instance() -> get_stand_pic_by_pic_id($picture_id, $imgag_t);
            
	    	//foreach(ProductpicService::get_instance() -> get_stand_pic_by_pic_id($picture_id) as $image){
	    	//	$order_product_detail_data['image'] = $image;
	    	//}
            $order_product_detail_data['image'] = $image['picurl_'.$imgag_t];
	    }
        
    }
        
	/**
	 * 判断订单状态的互斥关系
	 * @param int $current_status 当前订单状态
	 * @param int $last_status 要更改的订单状态
	 */
	public static function order_status_exclusion($current_status=0,$last_status=0)
	{
		if($current_status == 0 || $last_status == 0)
		{
			return false;
		}
		
		$order_status = Kohana::config('order.order_status');
		if(empty($order_status) || count($order_status) < 1)
		{
			return false;
		}
		
		if(isset($order_status[$current_status]['flow']))
		{
			$status_flow = $order_status[$current_status]['flow'];
			if(in_array($last_status,$status_flow))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return true;
		}
	}
	
	/**
	 * 判断订单支付状态的互斥关系
	 * @param int $current_status 当前订单状态
	 * @param int $last_status 要更改的订单状态
	 */
	public static function pay_status_exclusion($current_status=0,$last_status=0)
	{
		if($current_status == 0 || $last_status == 0)
		{
			return false;
		}
		
		$pay_status = Kohana::config('order.pay_status');
		if(empty($pay_status) || count($pay_status) < 1)
		{
			return false;
		}
		
		if(isset($pay_status[$current_status]['flow']))
		{
			$status_flow = $pay_status[$current_status]['flow'];
			if(in_array($last_status,$status_flow))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * 判断订单发货状态的互斥关系
	 * @param int $current_status 当前订单状态
	 * @param int $last_status 要更改的订单状态
	 */
	public static function ship_status_exclusion($current_status=0,$last_status=0)
	{
		if($current_status == 0 || $last_status == 0)
		{
			return false;
		}
		
		$ship_status = Kohana::config('order.ship_status');
		if(empty($ship_status) || count($ship_status) < 1)
		{
			return false;
		}
		
		if(isset($ship_status[$current_status]['flow']))
		{
			$status_flow = $ship_status[$current_status]['flow'];
			if(in_array($last_status,$status_flow))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}