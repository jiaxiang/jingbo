<?php
class Get_match_detail_Controller {
	
	const MAX_MID = 5;
	const MURL = 'http://info.sporttery.cn/football/info/fb_match_hhad.php?m=';
	const ZSK_URL = 'http://www.sporttery.cn/ZSK/index.html';
	static public $league = array(
	'英超'=>'http://www.sporttery.cn/ZSK/Premierleague.html',
	'西甲'=>'http://www.sporttery.cn/ZSK/LaLiga.html',
	'意甲'=>'http://www.sporttery.cn/ZSK/SerieA.html',
	'德甲'=>'http://www.sporttery.cn/ZSK/Bundesliga.html',
	'法甲'=>'http://www.sporttery.cn/ZSK/Ligue1.html',
	'荷甲'=>'http://www.sporttery.cn/ZSK/Eredivisie.html',
	'阿甲'=>'http://www.sporttery.cn/ZSK/Primeradivision.html',
	'日职'=>'http://www.sporttery.cn/ZSK/Jleague.html',
	'韩职'=>'http://www.sporttery.cn/ZSK/Kleague.html',
	'美职'=>'http://www.sporttery.cn/ZSK/MLS.html',
	'日乙'=>'http://www.sporttery.cn/ZSK/Jleague2.html',
	'瑞超'=>'http://www.sporttery.cn/ZSK/Allsvenskan.html',
	'澳超'=>'http://www.sporttery.cn/ZSK/Aleague.html',
	'英冠'=>'http://www.sporttery.cn/ZSK/FLC.html',
	'英甲'=>'http://www.sporttery.cn/ZSK/Footballleague1.html'
	);
	
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
	 * 根据知识库中内容，球队名称对应url
	 * @return 如获取到则返回数组array(0=>主队,1=>客队)，否则返回false
	 */
	public function getTeamDetailByURL() {
		require 'SQL.php';
		$sql = new SQL();
		$return = array();
		foreach (self::$league as $key => $val) {
			$name = array();
			$c = file_get_contents($val);
			preg_match_all("/<td valign=\"top\" width=\"10%\">(.*)<\/td>/", $c, $name, PREG_SET_ORDER); //提取名字
			if ($name == false || $name == '' || count($name) == 0) {
				preg_match_all("/<td valign=\"top\" width=\"11%\">(.*)<\/td>/", $c, $name, PREG_SET_ORDER); //提取名字
				if ($name == false || $name == '' || count($name) == 0) {
					preg_match_all("/<td valign=\"top\" width=\"12%\">(.*)<\/td>/", $c, $name, PREG_SET_ORDER); //提取名字
					if ($name == false || $name == '' || count($name) == 0) {
						preg_match_all("/<td valign=\"top\" valign=\"top\" width=\"16%\">(.*)<\/td>/", $c, $name, PREG_SET_ORDER); //提取名字
						if ($name == false || $name == '' || count($name) == 0) {
							preg_match_all("/<td valign=\"top\" width=\"8%\">(.*)<\/td>/", $c, $name, PREG_SET_ORDER); //提取名字
						}
					}
				}
			}
			
			preg_match_all("/<td valign=\"top\" style=\"text-align:left;padding-left:5px;\">(.*)<\/td>/", $c, $ex_name, PREG_SET_ORDER); //提取名字
			//var_dump($c);
			$name = array_merge($name,$ex_name);
			//var_dump($name);die();
			
			$name = $this->encodeUTF8($name);
			for ($i = 0;$i < count($name); $i++) {
				if ($name[$i][1] != '') {
					preg_match_all("/<a href=\"(.*)\" target=\"_blank\" title=\"\">/", $name[$i][1], $url, PREG_SET_ORDER);
					preg_match_all("/<br \/>(.*)<\/a>/", $name[$i][1], $team_name, PREG_SET_ORDER);
					//var_dump($url[0][1]);
					$t = explode('/', $url[0][1]);
					$t_key = count($t) - 1;
					//var_dump($t);
					$team_name_e = substr($t[$t_key], 0, -5);
					//var_dump($team_name_e);
					//var_dump($team_name[0][1]);
					//var_dump($key);
					$sql->query('insert into team_info_links(ch_name,en_name,url,league) values ("'.$team_name[0][1].'","'.$team_name_e.'","'.$url[0][1].'","'.$key.'")');
					echo $team_name_e.'.';
				}
			}
		}
	}
	
}
$g = new Get_match_detail_Controller();
$g->getTeamDetailByURL();
?>