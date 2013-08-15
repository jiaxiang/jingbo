<?php defined('SYSPATH') or die('No direct script access.');

class Currency_Core {
    
    /**
     * 计算币种实际价格
     *
     * @param     Float   $price
     * @param     String  $currency_code
     * @param     Float   $conversion_rate
     * @return     Array
     */
    public static function get_price($price, $currency_code = '', $conversion_rate = 0)
    {
        return BLL_Currency::get_price($price, $currency_code, $conversion_rate);
    }
    
    
    /**
     * 设置币种
     *
     * @param     String  $currency_code
     * @return  String
     */
    public static function set_currency_code($currency_code = '')
    {
        $session = Session::instance();
        $session->set('currency_code', $currency_code);
        cookie::set('currency_code', $currency_code);
        return TRUE;
    }
    
    /**
     * 得到当前币种
     *
     * @return  String
     */
    public static function get_current_currency()
    {
        return BLL_Currency::get_current();
    }
    
    public static function quote_xe($from = 'USD', $to = 'CNY')
    {
        $rate = false;
        @set_time_limit(600);
        $url = 'http://www.xe.net/ucc/convert.cgi';
        $data = 'Amount=1&From=' . $from . '&To=' . $to;
        
        $page = tool::curl_pay($url, $data);
        //$page = explode("\n", $page);
        
        if (is_object($page) || $page != '')
        {
            $match = array ();
            //preg_match('/[0-9.]+\s*' . $from . '\s*=\s*([0-9.]+)\s*' . $to . '/', implode('', $page), $match);
            preg_match('/[0-9.]+\s*' . $from . '\s*=\s*([0-9.]+)\s*' . $to . '/', $page, $match);

            if (sizeof($match) > 0)
            {
                $rate = $match[1];
            } else
            {
                $rate = false;
            }
        }
        return $rate;
    
    }

}
