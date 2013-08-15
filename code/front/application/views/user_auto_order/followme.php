<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-定制我的用户</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::stylesheet(array
(
 	'media/auto_order/css/mycenter',
), FALSE);
echo html::script(array
(
 	'media/auto_order/js/jquery-1.5.2',
	'media/auto_order/js/base',
	'media/auto_order/js/ESONCalendar',
	'media/auto_order/js/autoiframe',
	'media/auto_order/js/followme',
), FALSE);
?>
<style>
/* *html {_background:url(about:blank) fixed;} */
/* #msgDiv {z-index:10001;left:44%;top:200px;margin-left:-225px;display: none;z-index:99999;position:fixed;_position:absolute;_top:expression(document.documentElement.scrollTop+(this.x||195))} */
/* #bgDiv,#loadingMask {display: none;position: absolute;top: 0px;left: 0px;right:0px;z-index:10000;} */
</style>
</head>
<body class="none_bg">
<div class="buy_rec">
                	<ul class="my_tab">
                    	<li><a href="/user_auto_order/myfollow" >我定制的跟单</a></li>
                    	<li><a href="/user_auto_order/followme" class="cur">定制我的用户</a></li>
                    	<li><a href="/user_auto_order/followhist">自动跟单记录</a></li>
                    </UL>
<!-- 	<div class="my_title"> -->
<!--     	<h2>我定制的跟单</h2> -->
<!--     </div>                     -->                 
                    <div>
                        <div class="filter_s"><span class="m_r25">我要筛选 
				        <SELECT name="lotid" id="lotid">
						  <OPTION value=0  selected>全部彩种</OPTION>
						</SELECT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!-- 				        <SELECT name="seltype" id="seltype" > -->
<!-- 				          <OPTION value="0" selected>进行中</OPTION>           -->
<!-- 				          <OPTION value="1">已结束</OPTION> -->
<!-- 				          <OPTION value="2">已取消</OPTION> -->
<!-- 				        </SELECT> -->
				         </span>
				         <span class="m_r25">
<!-- 				         起始日期  -->
<!--     <input type="text" name="begintime" id="begintime" class="date_txt" value="" />  -->
<!--     终止日期 -->
<!--      <input type="text" class="date_txt" name="endtime" id="endtime" value="" />  -->
				        <input type="button" name="submit" id="submit" class="btn_Lblue_s" value="查询" />
				        </span>
                        </div>
                        
                            
                          <div id="showdatalist"></div>
    </div>
</div>
<div id="msgDiv" class=""></div><div id="bgDiv"></div>
</body>
</html>
