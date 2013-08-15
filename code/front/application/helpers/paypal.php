<?php
class Paypal_Core {
	public static function api(){//ec支付
		global $page_protocol;

		$api=array(
			"api_version"=>"3.0",
			"api_pass"=>"1249621380",
			"api_name"=>"tmwond_1249621373_biz_api1.gmail.com",
			"api_signature"=>"AFcWxV21C7fd0v3bYYYRCpSSRl31AmSTeMPDgP7nHRJ5dKcIYGbRKbx9",
			"api_end_point"=>"https://api-3t.sandbox.paypal.com/nvp",
			"api_site_point"=>url::base(false,$page_protocol)."PaypalDoDirectPaymentReceipt.php",
			"api_jump_url"=>"https://www.sandbox.paypal.com/cgi-bin/webscr",
		);
		/*
		$api=array(
			"api_version"=>"3.0",
			"api_pass"=>"EMH58KFU6K8GE5ZD",
			"api_name"=>"payment_api1.mbaobao.com",
			"api_signature"=>"AvAVJ4KcWVkX8EjTE4evMzidBvK7AdVj6eFeAFQm78uNGABjE7DnKQDl",
			"api_end_point"=>"https://api-3t.paypal.com/nvp",
			"api_site_point"=>url::base(false,$page_protocol)."PaypalDoDirectPaymentReceipt.php",
			"api_jump_url"=>"https://www.paypal.com/cgi-bin/webscr",
		);*/
		return $api;
	}

	public static function do_ec(){//ec支付
		global $page_protocol,$site_id;
		$api = paypal::api();
		$nvpstr     =
				"&METHOD=SetExpressCheckout".
				"&RETURNURL=".url::base(false,$page_protocol)."payment/ec_step2".
				"&CANCELURL=".url::base()."cart".
				"&NOTIFYURL=".url::base()."payment/paypal_ipn".
				"&HDRIMG=".url::base(false,$page_protocol)."images/".$site_id."/logo.gif".
				"&CURRENCYCODE=GBP".
				"&AMT=1";
     	$post_to_str=paypal::do_construction_str($nvpstr);
		$res_pp    =tool::curl_pay($api['api_site_point'],$post_to_str);
		$res_array =unserialize($res_pp);
		return $res_array;
	}

	public static function get_ec($token){//ec支付
		$api = paypal::api();
		$nvpstr     =
				"&METHOD=GetExpressCheckoutDetails".
				"&TOKEN=".$token;
     	$post_to_str=paypal::do_construction_str($nvpstr);
		$res_pp    =tool::curl_pay($api['api_site_point'],$post_to_str);
		$res_array =unserialize($res_pp);
		return $res_array;
	}

	public static function go_ec($token,$payerid,$order){//ec支付
		$api = paypal::api();
		$nvpstr     =
				"&METHOD=DoExpressCheckoutPayment".
				"&PAYMENTACTION=sale".
				"&PAYERID=".$payerid.
				"&AMT=".$order['total_real'].
				"&CURRENCYCODE=".$order['currency'].
				"&INVNUM=".$order['order_num'].
				"&NOTIFYURL=".url::base()."payment/paypal_ipn".
				"&TOKEN=".$token;
     	$post_to_str=paypal::do_construction_str($nvpstr);
		$res_pp    =tool::curl_pay($api['api_site_point'],$post_to_str);
		$res_array =unserialize($res_pp);
		return $res_array;
	}

	public static function do_construction_str($nvpstr){
		$api = paypal::api();
		$post_to_str =
			"payment=".urlencode($nvpstr).
			"&VERSION=".$api['api_version'].
			"&PWD=".$api['api_pass'].
			"&SIGNATURE=".$api['api_signature'].
			"&USER=".$api['api_name'].
			"&ENDPOINT=".$api['api_end_point'];
		return $post_to_str;
	}

	public static function pp_ec_cart_img(){//ec支付购物车图片
		global $page_protocol;
		$img = '<div class="button_bar">'.html::anchor('payment/ec_step1',html::image(array('src' =>'https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif')), null, $page_protocol).'</div>';
		return $img;
	}
	public static function pp_ec_payment_img(){//ec支付提交图片
		$img = 'https://www.paypal.com/en_US/i/bnr/bnr_paymentsBy_150x40.gif';
		return $img;
	}
}
?>
