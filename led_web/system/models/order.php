<?php defined('SYSPATH') OR die('No direct access allowed.');

class Order_Model extends ORM {
    protected $belongs_to = array('order_status','user_id');
    /**
     * Validates and optionally saves a new user record from an array.
     *
     * @param  array    values to check
     * @param  boolean  save the record when validation succeeds
     * @return boolean
     */
    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('order_num', 'length[1,200]')
            ->add_rules('user_id', 'length[1,200]')
            ->add_rules('email', 'length[1,200]')
            ->add_rules('total', 'length[1,200]')
            ->add_rules('currency', 'length[1,200]')
            ->add_rules('conversion_rate', 'length[1,200]')
            ->add_rules('total_products', 'length[1,200]')
            ->add_rules('total_shipping', 'length[1,200]')
            ->add_rules('total_real', 'length[1,200]')
            ->add_rules('total_paid', 'length[1,200]')
            ->add_rules('order_status','numeric')
			->add_rules('pay_status','numeric')
			->add_rules('ship_status','numeric')
			->add_rules('user_status','length[1,200]')
			->add_rules('order_source', 'length[1,200]')

            ->add_rules('shipping_firstname','length[1,200]')
            ->add_rules('shipping_lastname','length[1,200]')
            ->add_rules('shipping_country','length[1,200]')
            ->add_rules('shipping_state','length[1,200]')
            ->add_rules('shipping_city','length[1,200]')
            ->add_rules('shipping_address','length[1,200]')
            ->add_rules('shipping_zip','length[1,200]')
            ->add_rules('shipping_phone','length[1,200]')
            ->add_rules('shipping_mobile','length[1,200]')

            ->add_rules('billing_firstname','length[0,200]')
            ->add_rules('billing_lastname','length[0,200]')
            ->add_rules('billing_country','length[0,200]')
            ->add_rules('billing_state','length[0,200]')
            ->add_rules('billing_city','length[0,200]')
            ->add_rules('billing_address','length[0,200]')
            ->add_rules('billing_zip','length[0,200]')
            ->add_rules('billing_phone','length[0,200]')
            ->add_rules('billing_mobile','length[0,200]')

            ->add_rules('trans_id','length[1,200]')
            ->add_rules('ems_num','length[1,200]')
            ->add_rules('carrier', 'length[1,200]')
            ->add_rules('message', 'length[1,200]')
            ->add_rules('supplier','length[1,200]')
            ->add_rules('date_upd','length[1,200]')
            ->add_rules('date_pay','length[1,200]')
            ->add_rules('date_verify','length[1,200]')
            ->add_rules('is_receive', 'numeric')
            ->add_rules('payment_id', 'numeric')
            ->add_rules('mark', 'length[1,65535]')
            ->add_rules('ip', 'length[1,50]')
            ->add_rules('active', 'numeric');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}
?>
