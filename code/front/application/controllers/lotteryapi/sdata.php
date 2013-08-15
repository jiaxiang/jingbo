<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 数字彩非交易数据api
 * @author lenayin
 *
 */
class Sdata_Controller extends Template_Controller {
	public static $pdb = null;
	public static $cache = null;
	/**
	 * 取期号
	 */
	public function lotissue(){
		$lottid  = $this->input->get('lottid'); //方案编号
		if(!$lottid) {
			$lottid = 8;
		}
		
		$this->loaddb();
		/* $this->loadcache();
		$filekey = $this->getkey($lottid);
		$rows = self::$cache->get($filekey);
		if(!$rows){ 
			$rows = self::$pdb->query("select qihao as lotissue,endtime as etime,dendtime as detime,fendtime as fetime,isnow,buystat as allowbuy from qihaos where lotyid='".$lottid."' and (buystat='1' or isnow='1')")
			                  ->result_array(false);
			self::$cache->set($filekey,$rows,array('issue'),600);
		} */
		
		$rows = self::$pdb->query("select qihao as lotissue,endtime as etime,dendtime as detime,fendtime as fetime,isnow,buystat as allowbuy from qihaos where lotyid='".$lottid."' and (buystat='1' or isnow='1')")
			->result_array(false);
			
		header("Access-Control-Allow-Origin:*");
	    exit(json_encode($rows));
	}
	/**
	 * 取近10期开奖信息
	 */
	public function lotnotice(){
		$lottid  = $this->input->get('lottid'); //方案编号
		if(!$lottid) {
			$lottid = 8;
		}
		$this->loaddb();
		/* $this->loadcache();
		$filekey = $this->getkey($lottid,'notice');
		$rows = self::$cache->get($filekey);
		if(!$rows){
			$rows = array();
			$datas = self::$pdb->query("select salesacc,qihao,awardnum from qihao_exts where lotyid='".$lottid."' and awardnum!='' order by id desc limit 0,11")
			                  ->result_array(false);
			foreach ($datas as $val){
				if(!$val) continue;
				$sales = explode('|',$val['salesacc']);
				$tem = array('sales'=>$sales[0],'acc'=>$sales[1],'issue'=>$val['qihao'],'awardnum'=>$val['awardnum']);
				array_push($rows,$tem);
			}
			self::$cache->set($filekey,$rows,array('issue'),600);
		}  */
		
		
		$rows = array();
		$datas = self::$pdb->query("select salesacc,qihao,awardnum from qihao_exts where lotyid='".$lottid."' and awardnum!='' order by id desc limit 0,11")
		->result_array(false);
		foreach ($datas as $val){
			if(!$val) continue;
			$sales = explode('|',$val['salesacc']);
			$tem = array('sales'=>$sales[0],'acc'=>$sales[1],'issue'=>$val['qihao'],'awardnum'=>$val['awardnum']);
			array_push($rows,$tem);
		}
		header("Access-Control-Allow-Origin:*");
	    exit(json_encode($rows));
		
	}
	
	public function loaddb(){
		if(!self::$pdb){
		 	self::$pdb = Database::instance();
		}
	}
	
	public function loadcache(){
		if(!self::$cache){
		 	self::$cache =  Cache::factory('file');
		}
	}
	/**
	 * 
	 * 取文件key
	 * @param  $lottid 彩种编号
	 * @param  $ext 附加标识
	 */
	public function getkey($lottid=8,$type='issue'){
		$keys = array(8=>'dlt', //大乐透
		9=>'plw', //排列五
		10=>'qxc', //七星彩
		11=>'pls' //排列三
		              );
		return isset($keys[$lottid])?$keys[$lottid].$type:$keys[8].$type;
	}
}