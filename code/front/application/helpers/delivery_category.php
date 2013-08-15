<?php
class Delivery_category_Core{
	
	public static function get_name_by_id($cat_id){
		return Bll_delivery::get_category_name_by_id($cat_id);
	}
	
	/**
	 * 根据物流类型的ID、国家ISO码、重量、物流中货品总价，获得不同物流的数组
	 *
	 * @param int     $cat_id
	 * @param string  $country_iso
	 * @param float   $weight
	 * @param float   $total_price
	 * @return string $cat_deliveries;
	 */
	public static function get_deliveries_arr_by_cat_id($cat_id,$country_iso,$weight,$total_price){
		$country = Mycountry::instance()->get_by_iso($country_iso);
		if (empty($country)) {
			return array();
		}
		$country_id = $country['id'];
		$site_id = $country['site_id'];
		
		$condition = array(
			'site_id'              => $site_id,
			'delivery_category_id' => $cat_id,
			'country_id'           => $country_id,
			'weight'               => $weight,
			'total_price'          => $total_price,
		);
		$cat_deliveries = Bll_delivery::get_deliveries_by_condition($condition);
		return $cat_deliveries;
	}
	
	/**
	 * 根据物流类型的ID、国家ISO码、重量、物流中货品总价，获得不同物流的select选框
	 *
	 * @param int     $cat_id
	 * @param string  $country_iso
	 * @param float   $weight
	 * @param float   $total_price
	 * @return string $html;
	 */
	public static function get_deliveries_select_html_by_cat_id($cat_id,$country_iso,$weight,$total_price){
		$cat_deliveries = self::get_deliveries_arr_by_cat_id($cat_id,$country_iso,$weight,$total_price);
		if (empty($cat_deliveries)) {
			return '';
		}else {
			$html = '<select name="carrier_id[' . $cat_id . ']" class="valid">';
			foreach ($cat_deliveries as $delivery){
				$html.= '<option value="'.$delivery['id'].'">' . $delivery['name'] . '&nbsp;&nbsp;&nbsp;'. $delivery['currency_sign'].$delivery['delivery_price'] . '</option>';
			}
			$html .= '</select>';
			return $html;
		}
	}
}