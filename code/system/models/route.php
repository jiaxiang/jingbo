<?php defined('SYSPATH') OR die('No direct access allowed.');

class Route_Model extends ORM {

	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array & $array, $save = FALSE, & $errors)
	{
		$fields = parent::as_array();
		$array = array_merge($fields,$array);

		$array = Validation::factory($array)
			->pre_filter('trim')
			->add_rules('login', 'length[0,255]')
			->add_rules('logout', 'length[0,255]')
			->add_rules('register', 'length[0,255]')
			->add_rules('cart', 'length[0,255]')
			->add_rules('find_password', 'length[0,255]')
			->add_rules('get_password', 'length[0,255]')
			->add_rules('profile', 'length[0,255]')
			->add_rules('wishlists', 'length[0,255]')
			->add_rules('addresses', 'length[0,255]')
			->add_rules('password', 'length[0,255]')
			->add_rules('orders', 'length[0,255]')
			->add_rules('product', 'length[0,255]')
			->add_rules('promotion', 'length[0,255]')
			->add_rules('faq', 'length[0,255]')
			->add_rules('user', 'length[0,255]')
			->add_rules('contact_us', 'length[0,255]')
			->add_rules('product_suffix', 'length[0,255]')
			->add_rules('category_suffix', 'length[0,255]')

			->add_rules('login_name', 'length[0,255]')
			->add_rules('logout_name', 'length[0,255]')
			->add_rules('register_name', 'length[0,255]')
			->add_rules('cart_name', 'length[0,255]')
			->add_rules('find_password_name', 'length[0,255]')
			->add_rules('get_password_name', 'length[0,255]')
			->add_rules('profile_name', 'length[0,255]')
			->add_rules('wishlists_name', 'length[0,255]')
			->add_rules('addresses_name', 'length[0,255]')
			->add_rules('password_name', 'length[0,255]')
			->add_rules('orders_name', 'length[0,255]')
			->add_rules('product_name', 'length[0,255]')
			->add_rules('promotion_name', 'length[0,255]')
			->add_rules('faq_name', 'length[0,255]')
			->add_rules('user_name', 'length[0,255]')
			->add_rules('contact_us_name', 'length[0,255]')

			->add_rules('type', 'numeric');

		if(parent::validate($array, $save)) {
			return TRUE;
		}else {
			$errors = $array->errors();
			return FALSE;
		}
	}
} 

