<?php
class JCLQ 
{
	const MAX_MID = 5;
	const MURL = 'http://info.sporttery.cn/basketball/info/bk_match_info.php?m=';
	//const RESULTURL = 'http://info.sporttery.cn/basketball/pool_result.php?id=';
	const RESULTURL = 'http://118.186.215.50/basketball/pool_result.php?id=';

	const TMP_FILE = '/tmp/t1.txt';
	const XML_URL  = 'http://www.jingbo365.com/xml/jclq/';
	const HHAD_URL = 'http://info.sporttery.cn/basketball/mnl_list.php';  //胜负 
	const CRS_URL  = 'http://info.sporttery.cn/basketball/hdc_list.php';  //让分胜负
	const TTG_URL  = 'http://info.sporttery.cn/basketball/wnm_list.php';  //胜分差
	const HAFU_URL = 'http://info.sporttery.cn/basketball/hilo_list.php'; //大小分
	
	const T_TYPE = 6;
	
	public $week_array = array(
		'周一'=>'1',
		'周二'=>'2',
		'周三'=>'3',
		'周四'=>'4',
		'周五'=>'5',
		'周六'=>'6',
		'周日'=>'7'
	);
	
	private $sql;
	
	function __construct() {
		require_once 'SQL.php';
		$this->sql = new SQL();
	}
	
	/**
	 * 胜负比分
     * http://info.sporttery.cn/basketball/mnl_list.php
	 * 获得篮球胜负数据
	 */
	function getSPFMatch() 
	{
		$play_type = 1;
		$c = file_get_contents(self::HHAD_URL);

        $html =$this->cut($c,"box-tbl-a","box-search-r");  //进行切分
		
		$rowList = explode("<tr>",$html);// 按行分割
//var_dump($html); 

		//开始按行读取数据
		for ($index=1; $index<count($rowList); $index++) 
        {
            $odd_detail_array=explode("</td>", $rowList[$index]);

            $s_sp = trim(strip_tags($odd_detail_array[4]));	//主胜
            $f_sp = trim(strip_tags($odd_detail_array[5]));	//主负
            //获得matchid
			preg_match_all("/m=(.*)\' target=/", $odd_detail_array[2], $match_id, PREG_SET_ORDER);  //获得当天比赛的matchid的数组
            $mid = $match_id[0][1];
           	$match_num = $this->week_array[$this->encodeUTF8(trim(substr(strip_tags($odd_detail_array[0]), 0, -3)))]
           	.substr(strip_tags($odd_detail_array[0]), -3);
            $matchtime = strip_tags($odd_detail_array[3]); //获得比赛时间;
            $ymd = date("Y-m-d", strtotime($matchtime));
			$his = date("H:i:s", strtotime($matchtime));
			$ymdhis = date("Y-m-d H:i:s", strtotime($ymd));
			
			$comb = array();
			$comb['h']['c'] = 'H';//胜
			$comb['h']['v'] = $s_sp;
			$comb['h']['d'] = $ymd;
			$comb['h']['t'] = $his;
			
			$comb['a']['c'] = 'D';//负
			$comb['a']['v'] = $f_sp;
			$comb['a']['d'] = $ymd;
			$comb['a']['t'] = $his;
  	        $comb_j = json_encode($comb);       //json 赔率数据
			$goalline =0;
           //更新matchdata数据
          
           	$this->sql->query('SELECT id FROM match_datas WHERE ticket_type="'.self::T_TYPE.'" AND play_type="'.$play_type.'" AND match_num="'.$match_num.'" AND match_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				if ($match_num > 0) {
					$this->sql->query('INSERT INTO match_datas (ticket_type,play_type,match_num,match_id,pool_id,goalline,comb) values (
					"'.self::T_TYPE.'","'.$play_type.'","'.$match_num.'","'.$mid.'","0","'.$goalline.'",\''.$comb_j.'\')');
					echo 'spf:insert:'.$mid.'<br />';
				}
			}
			else {
				//更新赔率
				$id = $this->sql->fetch_array();
				$this->sql->query('update match_datas set comb=\''.$comb_j.'\' where id="'.$id['id'].'"');
				echo 'spf:update:'.$mid.'<br />';
			}
            $this->sql->query('SELECT id FROM match_details WHERE index_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) //如果没有数据 
			{
                $matchteam_array =explode("VS ", $this->encodeUTF8(strip_tags($odd_detail_array[2])));
                $league = $this->encodeUTF8(strip_tags($odd_detail_array[1]));
                $match_info = $this->encodeUTF8(strip_tags($odd_detail_array[0]));
                $match_team_url = $this->getTeamNameByURL(self::MURL.$mid);
            	
                $host_name     = trim($matchteam_array[1]);
				$host_team_url = trim($match_team_url[0]);
				$guest_name    = trim($matchteam_array[0]);
				$guest_team_url = trim($match_team_url[1]);
				$match_info     = trim($match_info);
				$league         = trim($league);
                
		  		$this->sql->query("INSERT INTO match_details "
		  		."(index_id, ticket_type, host_name, host_url, guest_name, guest_url, match_info, league, time) "
           		."VALUES " 
				."($mid, ".self::T_TYPE.", '$host_name', '$host_team_url', '$guest_name', '$guest_team_url', "
				."'$match_info', '$league', '$matchtime')");
				echo 'match_detail:insert:'.$mid.'<br />';
			}
        }// end of loop
	}
    
    
    /**
	 * 让分胜负比分
     * http://info.sporttery.cn/basketball/hdc_list.php
	 * Enter description here ...
	 */
	function getBetMatch() 
	{
		$play_type = 2;	//从ticket_type获得
		$c = file_get_contents(self::CRS_URL);

        $html =$this->cut($c,"box-tbl-a","box-search-r");  //进行切分
 
        $rowList = explode("</tr>",$html);	//按行分割

        //开始按行读取数据
        for ($intI=1;$intI<count($rowList)-1;$intI++) 
        {
            $odd_detail_array=explode("</td>",$rowList[$intI]);

            $s_sp = trim(strip_tags($odd_detail_array[4]));
            $f_sp = trim(strip_tags($odd_detail_array[5])); 
            //获得matchid
            preg_match_all("/m=(.*)\' target=/", $odd_detail_array[2], $match_id, PREG_SET_ORDER);  //获得当天比赛的matchid的数组
            $mid = $match_id[0][1];
           	$match_num = $this->week_array[$this->encodeUTF8(trim(substr(strip_tags($odd_detail_array[0]), 0, -3)))].
               substr(strip_tags($odd_detail_array[0]), -3);
            $matchtime = strip_tags($odd_detail_array[3]); //获得比赛时间;
            
            
            preg_match_all("/\((.*)\)/", $odd_detail_array[2], $home_g, PREG_SET_ORDER);

			if (isset($home_g[0][1])) {
				$goalline = floatval($home_g[0][1]);
			}
			else {
				$goalline = 0;
			}
var_dump($goalline);
            $ymd = date("Y-m-d", strtotime($matchtime));
			$his = date("H:i:s", strtotime($matchtime));
			$ymdhis = date("Y-m-d H:i:s", strtotime($ymd));
			$comb = array();
			$comb['h']['c'] = 'H';//胜
			$comb['h']['v'] = $s_sp;
			$comb['h']['d'] = $ymd;
			$comb['h']['t'] = $his;
			
			$comb['a']['c'] = 'D';//负
			$comb['a']['v'] = $f_sp;
			$comb['a']['d'] = $ymd;
			$comb['a']['t'] = $his;
  	        $comb_j = json_encode($comb);       //json 赔率数据
              
           //更新matchdata数据
          
           	$this->sql->query('SELECT id FROM match_datas WHERE ticket_type="'.self::T_TYPE
           	.'" AND play_type="'.$play_type
           	.'" AND match_num="'.$match_num
           	.'" AND match_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				if ($match_num > 0) {
					$this->sql->query('insert into match_datas (ticket_type,play_type,match_num,match_id,pool_id,goalline,comb) values (
					"'.self::T_TYPE.'","'.$play_type.'","'.$match_num.'","'.$mid.'","0","'.$goalline.'",\''.$comb_j.'\')');
					echo 'rfsf:insert:'.$mid.'<br />';
				}
			}
			else {
				//更新赔率
				$id = $this->sql->fetch_array();
				//$this->sql->query('update match_datas set comb=\''.$comb_j.'\' where id="'.$id['id'].'"');
				$this->sql->query("update match_datas set goalline=$goalline, comb='$comb_j' where id=".$id['id']);
				if (!$this->sql->error()) {
					echo 'rfsf:update:'.$mid.'<br />';
				}
				else {
					echo 'rfsf:update error<br />';
				}
			}
            $this->sql->query('select id from match_details where index_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) //如果数据库中没有数据 
			{
				$matchteam_array =explode("VS ", $this->encodeUTF8(strip_tags($odd_detail_array[2])));
				$league = $this->encodeUTF8(strip_tags($odd_detail_array[1]));
				$match_info = $this->encodeUTF8(strip_tags($odd_detail_array[0]));
				$match_team_url = $this->getTeamNameByURL(self::MURL.$mid);
				
				$host_name     = trim($matchteam_array[1]);
				$host_team_url = trim($match_team_url[0]);
				$guest_name    = trim($matchteam_array[0]);
				$guest_team_url = trim($match_team_url[1]);
				$match_info     = trim($match_info);
				$league         = trim($league);
				
				$this->sql->query("INSERT INTO match_details "
				."(index_id, ticket_type, host_name, host_url, guest_name, guest_url, match_info, league, time) "
				."VALUES " 
				."($mid, ".self::T_TYPE.", '$host_name', '$host_team_url', '$guest_name', '$guest_team_url', "
				."'$match_info', '$league', '$matchtime')");
				echo 'match_detail:insert:'.$mid.'<br />';
                
			}
        }// end of loop
	}// end of function getBetMatch() 
    
    
	
	/**
	 * 胜分差 胜分差 
     * http://info.sporttery.cn/basketball/wnm_list.php
	 * Enter description here ...
	 */
	function getBFMatch() 
	{
		echo '<div>bfmatach in</div>';
		$play_type = 3;  //从ticket_type获得
		$match_list = array();
		$c = file_get_contents(self::TTG_URL);
		$html =$this->cut($c,"box-tbl-a","box-search-r");  //进行切分
//var_dump($html); 
        $rowList = explode("</tr>",$html);

        //开始按行读取数据
        for ($index=1; $index<count($rowList)-1; $index++) 
        {
            $odd_detail_array=explode("</td>", $rowList[$index]);
			
//var_dump($odd_detail_array);
			
			$sp_1_5 = explode("<br />",$odd_detail_array[5]);
			$sp_11 = trim(strip_tags($sp_1_5[0]));		//客胜
			$sp_01 = trim(strip_tags($sp_1_5[1]));		//主胜

			$sp_6_10 = explode("<br />",$odd_detail_array[6]);
			$sp_12 = trim(strip_tags($sp_6_10[0]));
			$sp_02 = trim(strip_tags($sp_6_10[1]));
			
			$sp_11_15 = explode("<br />",$odd_detail_array[7]);
			$sp_13 = trim(strip_tags($sp_11_15[0]));
			$sp_03 = trim(strip_tags($sp_11_15[1]));
			
			$sp_16_20 = explode("<br />",$odd_detail_array[8]);
			$sp_14 = trim(strip_tags($sp_16_20[0]));
			$sp_04 = trim(strip_tags($sp_16_20[1]));
			
			$sp_21_25 = explode("<br />",$odd_detail_array[9]);
			$sp_15 = trim(strip_tags($sp_21_25[0]));
			$sp_05 = trim(strip_tags($sp_21_25[1]));

			$sp_26p = explode("<br />",$odd_detail_array[10]);
			$sp_16 = trim(strip_tags($sp_26p[0]));
			$sp_06 = trim(strip_tags($sp_26p[1]));
			
            //获得matchid
            preg_match_all("/m=(.*)\' target=/", $odd_detail_array[2], $match_id, PREG_SET_ORDER);  //获得当天比赛的matchid的数组
            $mid = $match_id[0][1];
           	$match_num = $this->week_array[$this->encodeUTF8(trim(substr(strip_tags($odd_detail_array[0]), 0, -3)))].
               substr(strip_tags($odd_detail_array[0]), -3);
            $matchtime = strip_tags($odd_detail_array[3]); //获得比赛时间;
            
            
            preg_match_all("/\((.*)\)/", $odd_detail_array[2], $home_g, PREG_SET_ORDER);

//			if (isset($home_g[0][1])) {
//				$goalline = floatval($home_g[0][1]);
//				var_dump($goalline);
//			}
//			else {
//			}
			$goalline = 0;
            $ymd = date("Y-m-d", strtotime($matchtime));
			$his = date("H:i:s", strtotime($matchtime));
			$ymdhis = date("Y-m-d H:i:s", strtotime($ymd));
			
			$comb = array();
			
			$comb['01']['c'] = '主胜1-5';//主胜1-5
			$comb['01']['s'] = '1';
			$comb['01']['v'] = $sp_01;
			$comb['01']['d'] = $ymd;
			$comb['01']['t'] = $his;
			
			$comb['02']['c'] = '主胜6-10';//主胜6-10
			$comb['02']['s'] = '1';
			$comb['02']['v'] = $sp_02;
			$comb['02']['d'] = $ymd;
			$comb['02']['t'] = $his;
			
			$comb['03']['c'] = '主胜11-15';//主胜11-15
			$comb['03']['s'] = '1';
			$comb['03']['v'] = $sp_03;
			$comb['03']['d'] = $ymd;
			$comb['03']['t'] = $his;
			
			$comb['04']['c'] = '主胜16-20';//主胜16-20
			$comb['04']['s'] = '1';
			$comb['04']['v'] = $sp_04;
			$comb['04']['d'] = $ymd;
			$comb['04']['t'] = $his;
			
			$comb['05']['c'] = '主胜21-25';//主胜21-25
			$comb['05']['s'] = '1';
			$comb['05']['v'] = $sp_05;
			$comb['05']['d'] = $ymd;
			$comb['05']['t'] = $his;

			$comb['06']['c'] = '主胜26+';//主胜26+
			$comb['06']['s'] = '1';
			$comb['06']['v'] = $sp_06;
			$comb['06']['d'] = $ymd;
			$comb['06']['t'] = $his;
			
			$comb['11']['c'] = '客胜1-5';//客胜1-5
			$comb['11']['s'] = '1';
			$comb['11']['v'] = $sp_11;
			$comb['11']['d'] = $ymd;
			$comb['11']['t'] = $his;

			$comb['12']['c'] = '客胜6-10';//客胜6-10
			$comb['12']['s'] = '1';
			$comb['12']['v'] = $sp_12;
			$comb['12']['d'] = $ymd;
			$comb['12']['t'] = $his;
			
			$comb['13']['c'] = '客胜11-15';//客胜11-15
			$comb['13']['s'] = '1';
			$comb['13']['v'] = $sp_13;
			$comb['13']['d'] = $ymd;
			$comb['13']['t'] = $his;
			
			$comb['14']['c'] = '客胜16-20';//客胜16-20
			$comb['14']['s'] = '1';
			$comb['14']['v'] = $sp_14;
			$comb['14']['d'] = $ymd;
			$comb['14']['t'] = $his;
			
			$comb['15']['c'] = '客胜21-25';//客胜21-25
			$comb['15']['s'] = '1';
			$comb['15']['v'] = $sp_15;
			$comb['15']['d'] = $ymd;
			$comb['15']['t'] = $his;

			$comb['16']['c'] = '客胜26+';//客胜26+
			$comb['16']['s'] = '1';
			$comb['16']['v'] = $sp_16;
			$comb['16']['d'] = $ymd;
			$comb['16']['t'] = $his;
			
  	        $comb_j = json_encode($comb);       //json 赔率数据
              
           //更新matchdata数据
          
           	$this->sql->query('select id from match_datas where ticket_type="'.self::T_TYPE.'" and play_type="'.$play_type.'" and match_num="'.$match_num.'" and match_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				if ($match_num > 0) 
				{
					echo "play_type:$play_type, match_num:$match_num, match_id:$mid, goalline:$goalline";
					$insertSQL = 'INSERT INTO match_datas '
					.'(ticket_type, play_type, match_num, match_id, pool_id, goalline, comb) '
					.'VALUES '
					.'('.self::T_TYPE.", $play_type, $match_num, $mid, 0, $goalline, '$comb_j')";
					$this->sql->query($insertSQL);
					echo 'sfc:insert:'.$mid.' | '.$play_type.'<br />';
				}
			}
			else {
				//更新赔率
				$id = $this->sql->fetch_array();
				$this->sql->query('update match_datas set comb=\''.$comb_j.'\' where id="'.$id['id'].'"');
				echo 'sfc:update:'.$mid.'<br />';
			}
            $this->sql->query('select id from match_details where index_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0)  //如果没有数据
			{
				$matchteam_array =explode("VS ", $this->encodeUTF8(strip_tags($odd_detail_array[2])));
				$league = $this->encodeUTF8(strip_tags($odd_detail_array[1]));
				$match_info = $this->encodeUTF8(strip_tags($odd_detail_array[0]));
				$match_team_url = $this->getTeamNameByURL(self::MURL.$mid);
				
				$host_name      = trim($matchteam_array[1]);
				$host_team_url  = trim($match_team_url[0]);
				$guest_name     = trim($matchteam_array[0]);
				$guest_team_url = trim($match_team_url[1]);
				$match_info     = trim($match_info);
				$league         = trim($league);
				
				$this->sql->query("INSERT INTO match_details "
				."(index_id, host_name, host_url, guest_name, guest_url, match_info, league, time)"
				."VALUES "
				."($mid, ".self::T_TYPE.", '$host_name', '$host_team_url', '$guest_name', '$guest_team_url', "
                ."'$match_info', '$league', '$matchtime')");
				echo 'match_detail:insert:'.$mid.'<br />';
                
			}
        }	// end of loop
	}
	
	/**
	 * 大小分
     * http://info.sporttery.cn/basketball/hilo_list.php
	 * Enter description here ...
	 */
	function getHafuMatch() 
	{
		$play_type = 4;
		$c = file_get_contents(self::HAFU_URL);
		$html =$this->cut($c,"box-tbl-a","box-search-r");  //进行切分
		$odd_array = explode("<tr>", $html);
          

        //开始按行读取数据
        for ($intI=1; $intI<count($odd_array); $intI++) 
        {
            $odd_detail_array=explode("</td>",$odd_array[$intI]);

            $s_sp = trim(strip_tags($odd_detail_array[4]));	//大
            $f_sp = trim(strip_tags($odd_detail_array[5])); //小
            //获得matchid
            preg_match_all("/m=(.*)\' target=/", $odd_detail_array[2], $match_id, PREG_SET_ORDER);  //获得当天比赛的matchid的数组
            $mid = $match_id[0][1];
            
           	$match_num = $this->week_array[$this->encodeUTF8(trim(substr(strip_tags($odd_detail_array[0]), 0, -3)))].
               substr(strip_tags($odd_detail_array[0]), -3);
            $matchtime = strip_tags($odd_detail_array[3]); //获得比赛时间;
            
           //取得大小分
            preg_match_all("/d/", strip_tags($odd_detail_array[2]), $home_g, PREG_SET_ORDER);
            $goalline = mb_substr(strip_tags($odd_detail_array[2]),-5);
            if (is_numeric(mb_substr($goalline,0,1))) {
                $goalline=$goalline;
            }else {
                $goalline = mb_substr(strip_tags($odd_detail_array[2]),-4);
            }


            $ymd = date("Y-m-d", strtotime($matchtime));
			$his = date("H:i:s", strtotime($matchtime));
			$ymdhis = date("Y-m-d H:i:s", strtotime($ymd));
			$comb = array();
			$comb['h']['c'] = 'H';//大
			$comb['h']['v'] = $s_sp;
			$comb['h']['d'] = $ymd;
			$comb['h']['t'] = $his;
			
			$comb['a']['c'] = 'D';//小
			$comb['a']['v'] = $f_sp;
			$comb['a']['d'] = $ymd;
			$comb['a']['t'] = $his;
  	        $comb_j = json_encode($comb);       //json 赔率数据
              
           //更新matchdata数据
          
           	$this->sql->query('select id from match_datas where ticket_type="'.self::T_TYPE.'" and play_type="'.$play_type.'" and match_num="'.$match_num.'" and match_id="'.$mid.'"');
			if ($this->sql->num_rows() <= 0) {
				if ($match_num > 0) {
					$this->sql->query('insert into match_datas (ticket_type,play_type,match_num,match_id,pool_id,goalline,comb) values (
					"'.self::T_TYPE.'","'.$play_type.'","'.$match_num.'","'.$mid.'","0","'.$goalline.'",\''.$comb_j.'\')');
					echo 'dxf:insert:'.$mid.'<br />';
				}
			}
			else {
				//更新赔率
				$id = $this->sql->fetch_array();
//				$this->sql->query('update match_datas set comb=\''.$comb_j.'\' where id="'.$id['id'].'"');
				$this->sql->query("update match_datas set goalline=$goalline, comb='$comb_j' where id=".$id['id']);
				if (!$this->sql->error()) {
					echo 'dxf:update:'.$mid.'<br />';
				}
				else {
					echo 'dxf:update error<br />';
				}
			}
			$this->sql->query('select id from match_details where index_id="'.$mid.'"');
			
			if ($this->sql->num_rows() <= 0)  //如果没有数据 
			{
                $match_team = substr(strip_tags($odd_detail_array[2]),0,strlen(strip_tags($odd_detail_array[2]))-5);

                $matchteam_array =explode("VS ", $this->encodeUTF8($match_team));

                $league = $this->encodeUTF8(strip_tags($odd_detail_array[1]));
                $match_info = $this->encodeUTF8(strip_tags($odd_detail_array[0]));
                $match_team_url = $this->getTeamNameByURL(self::MURL.$mid);
            	
                $host_name      = trim($matchteam_array[1]);
				$host_team_url  = trim($match_team_url[0]);
				$guest_name     = trim($matchteam_array[0]);
				$guest_team_url = trim($match_team_url[1]);
				$match_info     = trim($match_info);
				$league         = trim($league);
            
				$this->sql->query("INSERT INTO match_details "
				."(index_id, host_name, host_url, guest_name, guest_url, match_info, league, time)"
				."VALUES "
				."($mid, ".self::T_TYPE.", '$host_name', '$host_team_url', '$guest_name', '$guest_team_url', "
                ."'$match_info', '$league', '$matchtime')");
				echo 'match_detail:insert:'.$mid.'<br />';
                
			}
        }// end of loop
	}
	
	
	/**
	 * 把字符串或数组的字符集转换成utf8
	 * Enter description here ...
	 * @param string/array $array
	 * @return 转换后的字符串或数组
	 */
	function encodeUTF8(&$array){
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
	 * @return 如获取到则返回数组array(0=>主队url,1=>客队url)，否则返回false
	 */
	public function getTeamNameByURL($url) 
	{
//		echo 'jclq get team info in.';
		$name = array();
		$return = array();
 		
		$c = file_get_contents($url);

		$teaminfo_preg = "/<a href=\"(.*)\" target=\"_blank\">/";
		preg_match_all($teaminfo_preg, $c, $teaminfo, PREG_SET_ORDER); //提取名字
		
//		for ($i=0; $i<count($teaminfo); $i++)
//		{
//			$subArray = $teaminfo[$i];
//			for ($j=0; $j<count($subArray); $j++)
//			{
//				echo "teaminfo[$i][$j] = ".$teaminfo[$i][$j]."<br/>";
//			}
//		}
 
		$guest_url = $teaminfo[1][1];	// guest url
		$host_url = $teaminfo[2][1];	// host url

		$return[0] = $host_url;
		$return[1] = $guest_url;
		return $return;
	}
	
	/**
	 * 根据赛事id获取赛果
	 * Enter description here ...
	 * @param unknown_type $id
	 * @return array{0=>胜负,1=>让分胜负,2=>胜分差,3=>大小分,4=>比分(客:主) }
	 */
	public function getResultById($id) {
		$content = file_get_contents(self::RESULTURL.$id);
		$content = iconv('gb2312', 'utf-8', $content);//编码转换
//var_dump ($content);
		
		$scorePart = $this->cut($content, "<p", "</p>");	//进行切分比分
		$scoreParts = explode(' ', $scorePart);
		$score = $scoreParts[count($scoreParts) -1];
//		echo 'score = '.$score.'<br/>';
//var_dump ($content);
		
		$html = $this->cut($content, "<table ", "</table>");  //进行切分
//var_dump($html);
		
		$tableArray = array();
		$rowList = explode("<tr ",$html);// 按行分割
		for ($index=0; $index<count($rowList); $index++) 
		{
			$colList = explode("</td>", $rowList[$index]);
			for ($colIndex=0; $colIndex<count($colList); $colIndex++)
			{
				$tableArray[$index][$colIndex] = trim(strip_tags($colList[$colIndex]));
//				echo "table[$index][$colIndex] = ".$tableArray[$index][$colIndex].'<br/>';
			}
        }
        
        $rfsf_results = null;	// 让分胜负结果集
        $dxf_results  = null;	// 大小分结果集
        
		$result = array();
		$result[0] = null;
		$result[1] = null;
		$result[2] = null;
		$result[3] = null;
		$result[4] = null;
		for ($rowIndex=0; $rowIndex<count($tableArray); $rowIndex ++)
		{
			$aRow = $tableArray[$rowIndex];
			if      (mb_strpos($aRow[0], '>胜负', 0) > 0) {
				$result[0] = $aRow[6];	//胜负
			} 
			elseif	(
						(mb_strpos($aRow[0], '让分胜负', 0) <= 0) &&
						(
							(mb_strpos($aRow[0], '让分主胜', 0) > 0) || 
							(mb_strpos($aRow[0], '让分主负', 0) > 0)
						) 
					)
			{
//				echo "让分胜负 in  / $aRow[0]<br/>";
				$rfsfParts = explode("zebra\">", $aRow[0]);
				$rfsf_results = $rfsf_results.$rfsfParts[1].'/';	//让分胜负
				
			}
			elseif	(mb_strpos($aRow[0], '胜分差', 0) > 0) {
				$result[2] = $aRow[6];	//胜分差
			}
			elseif	(
						(mb_strpos($aRow[0], '大小分', 0) <= 0) &&
					 	(
					 		(mb_strpos($aRow[0], '大', 0) > 0) || 
					 		(mb_strpos($aRow[0], '小', 0) > 0)
					 	)
					) 
			{
				$dxfParts = explode("zebra\">", $aRow[0]);
				$dxf_results = $dxf_results.$dxfParts[1].'/';	//大小分
			}
		}
		$result[1] = mb_substr($rfsf_results, 0, mb_strlen($rfsf_results)-1 );
		$result[3] = mb_substr($dxf_results,  0, mb_strlen($dxf_results)-1 );
		$result[4] = $score;	//append the score at the end
//		echo "$result[0]|$result[1]|$result[2]|$result[3]|$result[4]<br/>";
		
		if (($result[0] == '' || $result[0] == null) &&		//胜负
			($result[1] == '' || $result[1] == null) &&		//让分胜负
			($result[2] == '' || $result[2] == null) &&		//胜分差
			($result[3] == '' || $result[3] == null))  		//大小分
		{
			return false;
		}
//		echo 'get a match result out.<br/>';
		
		if ($result[0] == '' || $result[0] == null) {
			$result[0] = '无';
		}
		if ($result[1] == '' || $result[1] == null) {
			$result[1] = '无';
		}
		if ($result[2] == '' || $result[2] == null) {
			$result[2] = '无';
		}
		if ($result[3] == '' || $result[3] == null) {
			$result[3] = '无';
		}
		if ($result[4] == '' || $result[4] == null) {
			$result[4] = '无';
		}
		
		return $result;
	}
	
	/**
	 * 更新赛果
	 * Enter description here ...
	 */
	public function getUnResultMatch() 
	{
		$select_query = "SELECT id, index_id FROM match_details "
		."WHERE (result = '' or result is null) AND time >= '2011-09-01' AND ticket_type=6 "
		."ORDER BY id ASC LIMIT 100";
		
		$this->sql->query($select_query);
		if ($this->sql->num_rows() <= 0) return;
		$re = array();
		while ($a = $this->sql->fetch_array()) 
		{
			$re[$a['id']] = $a['index_id'];
		}
		foreach ($re as $key => $val) 
		{
			$r = $this->getResultById($val);

//var_dump($r);
//echo '<br/>';
			if ($r == false){
				continue;
			}

			$r_j = implode('|', $r);
//var_dump($r_j);
//echo '<br/>';
			$update_query = 'UPDATE match_details SET result=\''.$r_j.'\' WHERE id="'.$key.'"';
			$this->sql->query($update_query);
			if (!$this->sql->error()) echo $key.' '.$val.' result:'.$r_j.' updated<br />';
			else echo $key.' result failed \n';
		}
	}
    
    public 	function cut($file,$from,$end){
             $message=explode($from,$file);
			 $message=explode($end,$message[1]);
			 return         $message[0];
			 
		}

}
?>