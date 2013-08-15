<?php
class File_Lock {
	
	const PATH = '/usr/local/cp/filelock/';
	const HOST_NAME = 'www.jingbo365.com';
	public static $filename;
	
    public static function getFullPath() {
    	return self::PATH.self::$filename.'.lock';
    }
    
    /**
     * 存在返回true, 不存在返回false
     * Enter description here ...
     */
    public static function isExists($filename, $creat_time=false) {
    	self::$filename = $filename;
    	$fullpath = self::getFullPath();
    	if (!file_exists($fullpath)) {
    		return false;
    	}
    	else {
    		if ($creat_time == false) {
    			return true;
    		}
    		else {
    			$min_time = $creat_time * 60;
    			$locktime = time() - filemtime($fullpath);
    			//echo $locktime;
    			if ($locktime >= $min_time) {
    				self::unlockFile();
    				return false;
    			}
    			else {
    				return true;
    			}
    		}
    	}
    }
    
    public static function lockFile() {
    	$fullpath = self::getFullPath();
    	file_put_contents($fullpath,'locked');
    }
    
    public static function unlockFile() {
    	$fullpath = self::getFullPath();
    	if (file_exists($fullpath)) {
    		unlink($fullpath);
    	}
    }
    
}
?>