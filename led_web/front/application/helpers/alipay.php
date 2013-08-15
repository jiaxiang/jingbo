<?php
/**
 *功能：支付宝接口公用函数
 *详细：该页面是请求、通知返回两个文件所调用的公用函数核心处理文件，不需要修改
 *版本：3.1
 *修改日期：2010-11-23
 '说明：
 '该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
*/
 
class Alipay_Core {
    
    /**生成签名结果
     *$array要签名的数组
     *return 签名结果字符串
    */
    public static function build_mysign($sort_array, $key, $sign_type = "MD5") {
        $prestr = self::create_linkstring($sort_array);         //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = $prestr.$key;                                 //把拼接后的字符串再与安全校验码直接连接起来
        $mysgin = self::sign($prestr,$sign_type);               //把最终的字符串签名，获得签名结果
        return $mysgin;
    }

    /* 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
     * $array 需要拼接的数组
     * return 拼接完成以后的字符串
     */
    public static function create_linkstring($array) {
        $arg  = array();
        foreach($array as $key => $val){
            $arg[] = $key."=".$val;
        }
        return implode('&', $arg);
    }

    /* 除去数组中的空值和签名参数
     * $parameter 签名参数组
     * return 去掉空值与签名参数后的新签名参数组
     */
    public static function para_filter($parameter) {
        $para = array();
        foreach($parameter as $key => $val){
            if($key == "sign" || $key == "sign_type" || $val == "")continue;
            $para[$key] = $parameter[$key];
        }
        return $para;
    }

    /* 对数组排序
     * $array 排序前的数组
     * return 排序后的数组
     */
    public static function arg_sort($array) {
        ksort($array);
        reset($array);
        return $array;
    }

    /**签名字符串
     * $prestr 需要签名的字符串
     * return 签名结果
     */
    public static function sign($prestr,$sign_type) {
        $sign='';
        if($sign_type == 'MD5') {
            $sign = md5($prestr);
        }else {
            die("支付宝暂不支持".$sign_type."类型的签名方式，请先使用MD5签名方式");
        }
        return $sign;
    }

    // 日志消息,把支付宝返回的参数记录下来
    public static function  log_result($word) {
        log::write('alipay_return_data', "执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n", __FILE__, __LINE__);
        /*$fp = fopen("log.txt","a");
        flock($fp, LOCK_EX) ;
        fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
        flock($fp, LOCK_UN);
        fclose($fp);*/
    }
    
    /* 实现多种字符编码方式
     * $input 需要编码的字符串
     * $_output_charset 输出的编码格式
     * $_input_charset 输入的编码格式
     * return 编码后的字符串
     */
    public static function charset_encode($input,$_output_charset ,$_input_charset) {
        $output = "";
        if(!isset($_output_charset) )$_output_charset  = $_input_charset;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset change.");
        return $output;
    }

    /* 实现多种字符解码方式
     * $input 需要解码的字符串
     * $_output_charset 输出的解码格式
     * $_input_charset 输入的解码格式
     * return 解码后的字符串
     */
    public static function charset_decode($input,$_input_charset ,$_output_charset) {
        $output = "";
        if(!isset($_input_charset) )$_input_charset  = $_input_charset ;
        if($_input_charset == $_output_charset || $input ==null ) {
            $output = $input;
        } elseif (function_exists("mb_convert_encoding")) {
            $output = mb_convert_encoding($input,$_output_charset,$_input_charset);
        } elseif(function_exists("iconv")) {
            $output = iconv($_input_charset,$_output_charset,$input);
        } else die("sorry, you have no libs support for charset changes.");
        return $output;
    }

    /**用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
    注意：由于低版本的PHP配置环境不支持远程XML解析，因此必须服务器、本地电脑中装有高版本的PHP配置环境。建议本地调试时使用PHP开发软件
    *$partner 合作身份者ID
    *return 时间戳字符串
    */
    public static function query_timestamp($partner) {
        $URL = "https://mapi.alipay.com/gateway.do?service=query_timestamp&partner=".$partner;
        $encrypt_key = "";
        $doc = new DOMDocument();
        $doc->load($URL);
        $itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
        $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
        return $encrypt_key;
    }
    
}