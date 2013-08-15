<?php
set_time_limit ( 3600 );
class Get_match_detail_Controller {
	
	const MAX_MID = 1000;
	const MURL = 'http://info.sporttery.cn/basketball/info/bk_match_info.php?m=';
	//const TMP_FILE = 'C:\code\caipiao_code\code\front\t2.txt';
	const TMP_FILE = '/tmp/t2.txt';
	const XML_URL = 'http://www.jingbo365.com/xml/jclq/';
	
	/**
	 * 把字符串或数组的字符集转换成utf8
	 * Enter description here ...
	 * @param string/array $array
	 * @return 转换后的字符串或数组
	 */
	protected function encodeUTF8(&$array){
		if(!is_array($array)){
			return iconv('gbk', 'utf-8', $array);
		}
		foreach($array as $key=>$value){
			if(!is_array($value)){
		    	$array[$key]=mb_convert_encoding($value,"UTF-8","GBK"); //由gbk转换到utf8
		    }else{
		        $this->encodeUTF8($array[$key]);
		    }
		}
		return $array;
	}
	
	/**
	 * 根据url获取主队与客队的名称
	 * Enter description here ...
	 * @param string $url
	 * @return 如获取到则返回数组array(0=>主队队名,1=>客队队名,2=>赛事信息,3=>联赛名称,4=>时间,5=>主队url,6=>客队url)，否则返回false
	 */
	public function getTeamNameByURL($url) {
		$name = array();
		$return = array();
		$c = file_get_contents($url);
		preg_match_all("/<div class=\"GuestBoxTopText\">(.*)<\/div>/", $c, $name, PREG_SET_ORDER); //提取名字
		
		$name = $this->encodeUTF8($name);
		$guestname = $name[0][1];
		$hostname = $name[1][1];
		if ($hostname == '' || $guestname == '') {
			return false;
		}
		$return[0] = $hostname;
		$return[1] = $guestname;
		
		preg_match_all("/<div>(.*)<br \/>/", $c, $nl, PREG_SET_ORDER); //提取名字
		$nl = $this->encodeUTF8($nl);
		
		$nl = $nl[0][1];
		$nl = explode(' ', $nl);
		$match_info = $nl[0];
		$league = $nl[1];
		
		$return[2] = $match_info;
		$return[3] = $league;
		preg_match_all("/<span class=\"Centers\">(.*)<\/span>/", $c, $time, PREG_SET_ORDER); //提取名字
		$time = $this->encodeUTF8($time);
		$time = trim(substr($time[0][1], -16));
		
		$return[4] = $time;
		
		preg_match_all("/<div class=\"HomeBoxLogo\"><a href=\"(.*)\" target=\"_blank\">/", $c, $guest_url, PREG_SET_ORDER); //提取名字
		$guest_url = $guest_url[0][1];
		
		preg_match_all("/<div class=\"GuestBoxLogo\"><a href=\"(.*)\" target=\"_blank\">/", $c, $host_url, PREG_SET_ORDER); //提取名字
		$host_url = $host_url[0][1];
		
		$return[5] = $host_url;
		$return[6] = $guest_url;
		return $return;
	}
	
	/**
	 * 扫描url并取得数据插入数据库中
	 * Enter description here ...
	 */
	public function scanURL() {
		require 'SQL.php';
		$sql = new SQL();
		$sql->query('select max(index_id) as mid from match_bk_details ');
		$t = $sql->fetch_array();
		$r = $t['mid'];
		if ($r == false) {
			$start = 21934;
		}
		else {
			$start = intval($r) + 1;
		}
		$end = $start + self::MAX_MID;
		for ($i = $start; $i < $end; $i++) {
			
			$matchinfo = $this->getTeamNameByURL(self::MURL.$i);
			if ($matchinfo == false) {
				continue;
			}
			else {
				$sql->query('insert into match_bk_details(index_id,host_name,host_url,guest_name,guest_url,match_info,league,time) values ("'.$i.'","'.$matchinfo[0].'","'.$matchinfo[5].'","'.$matchinfo[1].'","'.$matchinfo[6].'","'.$matchinfo[2].'","'.$matchinfo[3].'","'.$matchinfo[4].'")');
			}
			echo $i.'_';
		}
	}
	
	
	
}
$g = new Get_match_detail_Controller();
if (!file_exists(Get_match_detail_Controller::TMP_FILE)) {
	file_put_contents(Get_match_detail_Controller::TMP_FILE,'running');
	$g->scanURL();
	file_get_contents(Get_match_detail_Controller::XML_URL.'xml_2_6');
	echo 'rfsf is ok';
	file_get_contents(Get_match_detail_Controller::XML_URL.'xml_2_7');
	echo 'sf is ok';
	file_get_contents(Get_match_detail_Controller::XML_URL.'xml_2_8');
	echo 'sfc is ok';
	file_get_contents(Get_match_detail_Controller::XML_URL.'xml_2_9');
	echo 'dxf is ok';
	unlink(Get_match_detail_Controller::TMP_FILE);
}
?>