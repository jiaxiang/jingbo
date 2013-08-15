<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * $Id: order_product.php 169 2009-12-21 02:13:58Z hjy $
 * $Author: hjy $
 * $Revision: 169 $
 */

class Order_product_Model extends ORM {
    protected $belongs_to = array('order','site');

    public function validate(array & $array, $save = FALSE, & $errors) {
        $fields=parent::as_array();
        $array=array_merge($fields,$array);

        $array = Validation::factory($array)
            ->pre_filter('trim')
            ->add_rules('id','numeric')
            ->add_rules('order_id','required','numeric')
            ->add_rules('product_type','numeric')
            ->add_rules('product_id','required','numeric')
            ->add_rules('good_id','required','numeric')
            ->add_rules('quantity','numeric')
            ->add_rules('sendnum','numeric')
			->add_rules('dly_status','length[0,255]')
            ->add_rules('price','numeric')
            ->add_rules('discount_price','numeric')
            ->add_rules('weight','numeric')
            ->add_rules('related_ids','numeric')
            ->add_rules('SKU', 'length[0,255]')
            ->add_rules('name', 'length[0,255]')
            ->add_rules('image','length[0,255]')
            ->add_rules('brief','length[0,255]')
            ->add_rules('link','length[0,512]')
            ->add_rules('attribute_style','length[0,512]');

        if(parent::validate($array, $save)) {
            return TRUE;
        }else {
            $errors = $array->errors();
			log::write('form_error',$errors,__FILE__,__LINE__);
            return FALSE;
        }
    }
}

