<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 表单令牌(防止表单恶意提交)
 */
class Form_token_Core{
	const SESSION_KEY_TOKEN = 'SESSION_KEY_TOKEN';
	/**
	 * 生成一个当前的token
	 * @return string
	 */
	public static function grante_token(){
		$session = Session::instance();
        $ss = $session->get();
        foreach($ss as $k=>$v){
            if(!strstr($k, self::SESSION_KEY_TOKEN)==FALSE)$session->delete($k);
        }
		$key = self::grante_key();
		$token = md5(substr(time(), 0, 3).$key);
		//储存token
		$session->set(self::SESSION_KEY_TOKEN.$token,$key);
		return $token;
	}
	
	/**
	 * 验证一个当前的token
	 * @param string $token
	 * @return string
	 */
	public static function is_token($token)
	{
		$session = Session::instance();
		$key = $session->get(self::SESSION_KEY_TOKEN.$token);
		if(!empty($key))
		{
			$old_token = md5(substr(time(), 0, 3).$key);
			if($old_token == $token)
			{
				return true;
			} else {
				return false;
			}
		}else{
			return false;
		}
	}

	/**
	 * 删除一个token
	 * @param string $token
	 * @return boolean
	 */
	public static function drop_token($token)
	{
		Session::instance()->delete(self::SESSION_KEY_TOKEN.$token);
		return true;
	}

	/**
	 * 生成一个密钥
	 * @return string
	 */
	public static function grante_key()
	{
		$encrypt_key = md5(((float) date("YmdHis") + rand(100,999)).rand(1000,9999));
		return $encrypt_key;
	}
}