<?php defined('SYSPATH') OR die('No direct access allowed.');

class WxService_Core extends DefaultService_Core
{
	/* 兼容php5.2环境 Start */
    private static $instance = NULL;

    public static $team_logo = array(
    		'西甲' => 'xj.jpg',
    		'意甲' => 'yj.jpg',
    		'法甲' => 'fj.jpg',
    		'英超' => 'yc.jpg',
    		'德甲' => 'dj.jpg',
    		'欧冠杯' => 'og.jpg',
    		'中超' => 'zc.jpg',

    		'西汉姆联' => 'xhml.jpg',
    		'维冈竞技' => 'wgjj.jpg',
    		'托特纳姆热刺' => 'ttnmrc.jpg',
    		'埃弗顿' => 'efd.jpg',
    		'女王公园巡游者' => 'nwgy.jpg',
    		'阿森纳' => 'asn.jpg',
    		'曼彻斯特城' => 'mc.jpg',
    		'利物浦' => 'lwp.jpg',
    		'切尔西' => 'qex.jpg',
    		'曼彻斯特联' => 'mu.jpg',

    		'巴塞罗那' => 'bs.jpg',
    		'皇家马德里' => 'hm.jpg',

    		'尤文图斯' => 'uvts.jpg',
    		'AC米兰' => 'acml.jpg',
    		'国际米兰' => 'gjml.jpg',

    		'巴黎圣日尔曼' => 'bali.jpg',

    		'上海申花' => 'shenhua.jpg',
    		'上海东亚' => 'shanghai.jpg',
    		'上海申鑫' => 'shenxin.jpg',
    		'贵州人和' => 'guizhourenhe.jpg',
    		'广州恒大' => 'guangzhouhengda.jpg',
    		'辽宁宏远' => 'liaoning.jpg',
    		'武汉卓尔' => 'wuhan.jpg',
    		'大连阿尔滨' => 'dalian.jpg',
    		'青岛中能' => 'qingdao.jpg',
    		'广州富力' => 'fuli.jpg',
    		'山东鲁能' => 'shandong.jpg',
    		'天津泰达' => 'tianjing.jpg',
    		'江苏舜天' => 'jiangsu.jpg',
    		'北京国安' => 'beijing.jpg',
    		'长春亚太' => 'changchun.jpg',

    );

    public static $team_alise = array(
    		'曼联' => '曼彻斯特联',
    		'曼城' => '曼彻斯特城',
    		'A米' => 'AC米兰',
    		'a米' => 'AC米兰',
    		'国米' => '国际米兰',
    		'上港' => '上海东亚',
    		'巴萨' => '巴塞罗那',
    		'皇马' => '皇家马德里',
    		'马竞' => '马德里竞技',
    );
  	const TEAM_PIC = 'http://180.153.223.69/media/images/wx/';

    // 获取单态实例
    public static function get_instance()
    {
        if(self::$instance === null){
            $classname = __CLASS__;
            self::$instance = new $classname();
        }
        return self::$instance;
    }

    public function valid()
    {
    	$echoStr = $_GET["echostr"];
    	//return TRUE;
    	//valid signature , option
    	if($this->checkSignature()){
    		echo $echoStr;
    		//exit;
    		return TRUE;
    	}
    	return FALSE;
    }

    public static function show_pic($name) {
    	$array = self::$team_logo;
    	if (isset($array[$name])) {
    		return $array[$name];
    	}
    	else {
    		return FALSE;
    	}
    }

    public static function get_teamname_alise($name) {
    	$array = self::$team_alise;
    	if (isset($array[$name])) {
    		return $array[$name];
    	}
    	else {
    		return FALSE;
    	}
    }

    public function responseMsg()
    {
    	//get post data, May be due to the different environments
    	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

    	//extract post data
    	if (!empty($postStr)) {

    		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    		$fromUsername = $postObj->FromUserName;
    		$toUsername = $postObj->ToUserName;
    		$msgType = $postObj->MsgType;
    		$keyword = trim($postObj->Content);
    		$time = time();
    		$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
    		switch ($msgType) {
    			case 'text':
    				$keyword = trim($postObj->Content);
    				if(!empty( $keyword )) {
    					$msgType = "text";
    					$contentStr = "回答：".$keyword;
    				}
    				break;
    			case 'image':
    				$picurl = $postObj->PicUrl;
    				$msgType = "text";
    				$contentStr = "图片：".$picurl;
    				break;
    			case 'location':
    				$lx = $postObj->Location_X;
    				$ly = $postObj->Location_Y;
    				$scale = $postObj->Scale;
    				$label = $postObj->Label;
    				//if(!empty( $lx ) && !empty( $ly )
    				//&& !empty( $scale ) && !empty( $label )) {
    				$msgType = "text";
    				$contentStr = '位置：'.$label;
    				break;
    			case 'link':
    				$title = $postObj->Title;
    				$desp = $postObj->Description;
    				$url = $postObj->Url;
    				$msgType = "text";
    				$contentStr = '标题：'.$title.',描述：'.$desp.',链接：'.$url;
    				break;
    			default:
    				$msgType = "text";
    				$contentStr = '[疑问]';
    				break;

    		}
    		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    		echo $resultStr;

    	}else {
    		echo "";
    		exit;
    	}
    }

    public function showJsbf() {
    	//get post data, May be due to the different environments
    	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

    	//extract post data
    	if (!empty($postStr)) {

    		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    		$fromUsername = $postObj->FromUserName;
    		$jialei = 'o2b6OjmrWdf-BDTFlg08KEq0T_8E';
    		$jiawei = 'o2b6OjkjjnBrTkqTsJWfL5b0bUVQ';
    		$toUsername = $postObj->ToUserName;
    		$msgType = $postObj->MsgType;
    		$keyword = trim($postObj->Content);
    		$time = time();
    		$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
    		switch ($msgType) {
    			case 'text':
    				$keyword = trim($postObj->Content);
    				if(!empty( $keyword )) {
    					if ($keyword == 'nihao') {
    						$msgType = "text";
		    				$contentStr = $fromUsername;
		    				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		    				echo $resultStr;
		    				return;
    					}
    					if ($keyword == 'jialei') {
    						$msgType = "text";
    						$contentStr = '收到了伐？';
    						$resultStr = sprintf($textTpl, $jialei, $toUsername, $time, $msgType, $contentStr);
    						echo $resultStr;
    						return;
    					}
    					if ($keyword == 'jiawei') {
    						$msgType = "text";
    						$contentStr = '收到了伐？';
    						$resultStr = sprintf($textTpl, $jiawei, $toUsername, $time, $msgType, $contentStr);
    						echo $resultStr;
    						return;
    					}
    					if ($this->get_teamname_alise($keyword) != FALSE) {
    						$keyword = $this->get_teamname_alise($keyword);
    					}
    					$objmatch = jsbf::get_instance();
    					$matcho = $objmatch->getOverMatchByName($keyword, 2);
    					$matchs = $objmatch->getStartMatchByName($keyword, 7);
    					$matchleg = $objmatch->getMatchListByLeg($keyword, 9);
    					$matcho_num = count($matcho);
    					$matchs_num = count($matchs);
    					$matchleg_num = count($matchleg);
    					$count = $matcho_num + $matchs_num;
    					if ($count > 0) {
    						$msgType = "news";
    						$resultStr = "<xml>
							 <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
							 <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
							 <CreateTime>".$time."</CreateTime>
							 <MsgType><![CDATA[".$msgType."]]></MsgType>
							 <ArticleCount>".($count+1)."</ArticleCount>
							 <Articles>
							 <item>
							 <Title><![CDATA[与".$keyword."相关的赛事]]></Title>
							 <Description><![CDATA[]]></Description>
							 <PicUrl><![CDATA[".self::TEAM_PIC."news1.jpg]]></PicUrl>
							 <Url><![CDATA[]]></Url>
							 </item>";
    						if ($matcho_num > 0) {
    							for ($i = 0; $i < $matcho_num; $i++) {
    								$picurl = '';
    								if ($this->show_pic($matcho[$i]['home']) != FALSE) {
    									$picurl = self::TEAM_PIC.$this->show_pic($matcho[$i]['home']);
    								}
    								elseif ($this->show_pic($matcho[$i]['away']) != FALSE) {
    									$picurl = self::TEAM_PIC.$this->show_pic($matcho[$i]['away']);
    								}
    								else {

    								}
    								$match_content = $matcho[$i]['match'].' '.$matcho[$i]['time'].'
('.$matcho[$i]['home_rank'].')'.$matcho[$i]['home'].' '.$matcho[$i]['home_score'].' : '.$matcho[$i]['away_score'].' '.$matcho[$i]['away'].'('.$matcho[$i]['away_rank'].')';
    								$resultStr .= "<item>
										 <Title><![CDATA[".$match_content."]]></Title>
										 <Description><![CDATA[]]></Description>
										 <PicUrl><![CDATA[".$picurl."]]></PicUrl>
										 <Url><![CDATA[]]></Url>
										 </item>";
    							}
    						}
    						if ($matchs_num > 0) {
    							for ($i = 0; $i < $matchs_num; $i++) {
    								$picurl = '';
    								if ($this->show_pic($matchs[$i]['home']) != FALSE) {
    									$picurl = self::TEAM_PIC.$this->show_pic($matchs[$i]['home']);
    								}
    								elseif ($this->show_pic($matchs[$i]['away']) != FALSE) {
    									$picurl = self::TEAM_PIC.$this->show_pic($matchs[$i]['away']);
    								}
    								else {

    								}
    								if ($matchs[$i]['status_code'] == 0) {
    									$match_content = $matchs[$i]['match'].' '.$matchs[$i]['time'].'
('.$matchs[$i]['home_rank'].')'.$matchs[$i]['home'].' VS '.$matchs[$i]['away'].'('.$matchs[$i]['away_rank'].')';
    								}
    								else {
    									$match_content = $matchs[$i]['match'].' '.$matchs[$i]['time'].'['.$matchs[$i]['status'].']
('.$matchs[$i]['home_rank'].')'.$matchs[$i]['home'].' '.$matchs[$i]['home_score'].' : '.$matchs[$i]['away_score'].' '.$matchs[$i]['away'].'('.$matchs[$i]['away_rank'].')';
    								}
    								$resultStr .= "<item>
										 <Title><![CDATA[".$match_content."]]></Title>
										 <Description><![CDATA[]]></Description>
										 <PicUrl><![CDATA[".$picurl."]]></PicUrl>
										 <Url><![CDATA[]]></Url>
										 </item>";
    							}
    						}
    						$resultStr .= "</Articles>
							 <FuncFlag>1</FuncFlag>
							 </xml>";
    						echo $resultStr;
    					}
    					elseif ($matchleg_num > 0) {
    						$msgType = "news";
    						$item_str = "";
    						for ($i = 0; $i < $matchleg_num; $i++) {
    							$legname = $matchleg[$i]['match'];
    							$picurl = '';
    							if ($this->show_pic($matchleg[$i]['home']) != FALSE) {
    								$picurl = self::TEAM_PIC.$this->show_pic($matchleg[$i]['home']);
    							}
    							elseif ($this->show_pic($matchleg[$i]['away']) != FALSE) {
    								$picurl = self::TEAM_PIC.$this->show_pic($matchleg[$i]['away']);
    							}
    							else {

    							}
    							if ($matchleg[$i]['status_code'] == -1) {
    								$match_content = $matchleg[$i]['match'].' '.$matchleg[$i]['time'].'
('.$matchleg[$i]['home_rank'].')'.$matchleg[$i]['home'].' '.$matchleg[$i]['home_score'].' : '.$matchleg[$i]['away_score'].' '.$matchleg[$i]['away'].'('.$matchleg[$i]['away_rank'].')';
    							}
    							elseif ($matchleg[$i]['status_code'] == 0) {
    								$match_content = $matchleg[$i]['match'].' '.$matchleg[$i]['time'].'
('.$matchleg[$i]['home_rank'].')'.$matchleg[$i]['home'].' VS '.$matchleg[$i]['away'].'('.$matchleg[$i]['away_rank'].')';
    							}
    							else {
    								$match_content = $matchleg[$i]['match'].' '.$matchleg[$i]['time'].'['.$matchleg[$i]['status'].']
('.$matchleg[$i]['home_rank'].')'.$matchleg[$i]['home'].' '.$matchleg[$i]['home_score'].' : '.$matchleg[$i]['away_score'].' '.$matchleg[$i]['away'].'('.$matchleg[$i]['away_rank'].')';
    							}
    							$item_str .= "<item>
									 <Title><![CDATA[".$match_content."]]></Title>
									 <Description><![CDATA[]]></Description>
									 <PicUrl><![CDATA[".$picurl."]]></PicUrl>
									 <Url><![CDATA[]]></Url>
									 </item>";
    						}
    						$picurl = '';
    						if ($this->show_pic($legname) != FALSE) {
    							$picurl = self::TEAM_PIC.$this->show_pic($legname);
    						}
    						else {

    						}
    						$resultStr = "<xml>
							 <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
							 <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
							 <CreateTime>".$time."</CreateTime>
							 <MsgType><![CDATA[".$msgType."]]></MsgType>
							 <ArticleCount>".($matchleg_num+1)."</ArticleCount>
							 <Articles>
							 <item>
							 <Title><![CDATA[".$keyword."的最近赛事]]></Title>
							 <Description><![CDATA[]]></Description>
							 <PicUrl><![CDATA[".$picurl."]]></PicUrl>
							 <Url><![CDATA[]]></Url>
							 </item>".$item_str;
    						$resultStr .= "</Articles>
							 <FuncFlag>1</FuncFlag>
							 </xml>";
    						echo $resultStr;
    					}
    					else {
    						$match_default = $objmatch->getDefaultMatch(9);
    						$match_default_num = count($match_default);
    						if ($match_default_num > 0) {
    							$msgType = "news";
	    						$resultStr = "<xml>
								 <ToUserName><![CDATA[".$fromUsername."]]></ToUserName>
								 <FromUserName><![CDATA[".$toUsername."]]></FromUserName>
								 <CreateTime>".$time."</CreateTime>
								 <MsgType><![CDATA[".$msgType."]]></MsgType>
								 <ArticleCount>".($match_default_num+1)."</ArticleCount>
								 <Articles>
								 <item>
								 <Title><![CDATA[找不到".$keyword."相关！看看其他赛事]]></Title>
								 <Description><![CDATA[]]></Description>
								 <PicUrl><![CDATA[".self::TEAM_PIC."news2.jpg]]></PicUrl>
								 <Url><![CDATA[]]></Url>
								 </item>";

	    						for ($i = 0; $i < $match_default_num; $i++) {
	    							$picurl = '';
	    							if ($this->show_pic($match_default[$i]['home']) != FALSE) {
	    								$picurl = self::TEAM_PIC.$this->show_pic($match_default[$i]['home']);
	    							}
	    							elseif ($this->show_pic($match_default[$i]['away']) != FALSE) {
	    								$picurl = self::TEAM_PIC.$this->show_pic($match_default[$i]['away']);
	    							}
	    							else {

	    							}
		    						if ($match_default[$i]['status_code'] == -1) {
	    								$match_content = $match_default[$i]['match'].' '.$match_default[$i]['time'].'
('.$match_default[$i]['home_rank'].')'.$match_default[$i]['home'].' '.$match_default[$i]['home_score'].' : '.$match_default[$i]['away_score'].' '.$match_default[$i]['away'].'('.$match_default[$i]['away_rank'].')';
	    							}
	    							elseif ($match_default[$i]['status_code'] == 0) {
	    								$match_content = $match_default[$i]['match'].' '.$match_default[$i]['time'].'
('.$match_default[$i]['home_rank'].')'.$match_default[$i]['home'].' VS '.$match_default[$i]['away'].'('.$match_default[$i]['away_rank'].')';
	    							}
	    							else {
	    								$match_content = $match_default[$i]['match'].' '.$match_default[$i]['time'].'['.$match_default[$i]['status'].']
('.$match_default[$i]['home_rank'].')'.$match_default[$i]['home'].' '.$match_default[$i]['home_score'].' : '.$match_default[$i]['away_score'].' '.$match_default[$i]['away'].'('.$match_default[$i]['away_rank'].')';
	    							}
	    							$resultStr .= "<item>
										 <Title><![CDATA[".$match_content."]]></Title>
										 <Description><![CDATA[]]></Description>
										 <PicUrl><![CDATA[".$picurl."]]></PicUrl>
										 <Url><![CDATA[]]></Url>
										 </item>";
	    						}

	    						$resultStr .= "</Articles>
								 <FuncFlag>1</FuncFlag>
								 </xml>";
	    						echo $resultStr;
    						}
    						else {
	    						$msgType = "text";
	    						$contentStr = '最近好像没什么比赛...';
	    						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	    						echo $resultStr;
    						}
    					}
    				}
    				break;
    			case 'image':
    				$picurl = $postObj->PicUrl;
    				$msgType = "text";
    				$contentStr = "喜欢哪个球队[疑问]";
    				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    				echo $resultStr;
    				break;
    			case 'location':
    				$lx = $postObj->Location_X;
    				$ly = $postObj->Location_Y;
    				$scale = $postObj->Scale;
    				$label = $postObj->Label;
    				//if(!empty( $lx ) && !empty( $ly )
    				//&& !empty( $scale ) && !empty( $label )) {
    				$msgType = "text";
    				$contentStr = "喜欢哪个球队[疑问]";
    				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    				echo $resultStr;
    				break;
    			case 'link':
    				$title = $postObj->Title;
    				$desp = $postObj->Description;
    				$url = $postObj->Url;
    				$msgType = "text";
    				$contentStr = "喜欢哪个球队[疑问]";
    				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    				echo $resultStr;
    				break;
    			case 'event':
    				if ($postObj->Event == 'subscribe') {
    					$msgType = "text";
	    				$contentStr = '欢迎加入EJ！（此微信平台纯属娱乐[微笑]）';
	    				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
	    				echo $resultStr;
    				}
    				break;
    			default:
    				$msgType = "text";
    				$contentStr = '快来输入你喜欢的球队吧！（此微信平台纯属娱乐[微笑]）';
    				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    				echo $resultStr;
    				break;

    		}
    		//$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    		//echo $resultStr;

    	}else {
    		echo "";
    		exit;
    	}
    }

    private function checkSignature()
    {
    	//var_dump($_GET);
    	$signature = $_GET["signature"];
    	$timestamp = $_GET["timestamp"];
    	$nonce = $_GET["nonce"];

    	$token = TOKEN;
    	$tmpArr = array($token, $timestamp, $nonce);
    	sort($tmpArr);
    	$tmpStr = implode( $tmpArr );
    	$tmpStr = sha1( $tmpStr );

    	if( $tmpStr == $signature ){
    		return true;
    	}else{
    		echo $tmpStr.'<br />';
    		echo $signature;
    		return false;
    	}
    }

}
