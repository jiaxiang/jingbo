<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 数字彩号码检验
 * 
 */
class autoorder_Core {
    private static $instance = NULL;
	public static $pdb = null;
    private static $lott = array(
		8=>array('name'=>'dlt','fg'=>';'),
		9=>array('name'=>'plw','fg'=>'$'),	
		10=>array('name'=>'qxc','fg'=>'$'),
		11=>array('name'=>'pls','fg'=>'$'),
	);
	public function loaddb(){
		if(!self::$pdb){
		 	self::$pdb = Database::instance();
		}
	}
    // 获取单态实例
    public static function get_instance(){
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }
    
    	
}