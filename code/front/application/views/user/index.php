<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/hdm',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
), FALSE);
?>
</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>user"><font class="blue">会员中心</font></a>
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
<?php echo View::factory('user/left')->render();?>
<div class="member_right fl">
<?php echo View::factory('user/user_header')->render();?>         
        <div id="member_tit" class="fl mt5">
        	<span class="fr blue"><a href="#">更多记录</a>&gt;&gt;</span>
        	<ul>
       	    <li class="hover" id="one1" onmousemove="setTab('one',1,4)">未结投注</li>
                <li id="one2" onmousemove="setTab('one',2,4)">已结投注</li>
                <li id="one3" onmousemove="setTab('one',3,4)">最近中奖</li>
                <li id="one4" onmousemove="setTab('one',4,4)">追号记录</li>
            </ul>
        </div>
        <div id="con_one_1">
        
        
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
          <tr>
            <td width="9%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">彩种</td>
            <td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">期号</td>
            <td width="16%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">发起人</td>
            <td width="14%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案金额</td>
            <td width="13%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">认购金额</td>
            <td width="12%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案进度</td>
            <td width="14%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">认购时间</td>
            <td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">投注内容</td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
          <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
          
        </table>
        </div>
        <div id="con_one_2" style="display:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
          <tr>
            <td width="9%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">彩种</td>
            <td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">期号</td>
            <td width="16%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">发起人</td>
            <td width="14%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案金额</td>
            <td width="13%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">认购金额</td>
            <td width="12%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案进度</td>
            <td width="14%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">认购时间</td>
            <td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">投注内容</td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
          <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
          
        </table>
        </div>
        <div id="con_one_3" style="display:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
          <tr>
            <td width="9%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">彩种</td>
            <td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">期号</td>
            <td width="16%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">发起人</td>
            <td width="14%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案金额</td>
            <td width="13%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">认购金额</td>
            <td width="12%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案进度</td>
            <td width="14%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">认购时间</td>
            <td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">投注内容</td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
          <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
          
        </table>
        </div>
        <div id="con_one_4" style="display:none;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
          <tr>
            <td width="9%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">彩种</td>
            <td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">期号</td>
            <td width="16%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">发起人</td>
            <td width="14%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案金额</td>
            <td width="13%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">认购金额</td>
            <td width="12%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">方案进度</td>
            <td width="14%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">认购时间</td>
            <td width="11%" height="33" align="center" valign="middle" bgcolor="#e8f2ff">投注内容</td>
          </tr>
        </table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
          <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
           <tr>
            <td width="9%" height="36" align="center" valign="middle">胜负彩</td>
            <td width="11%" height="36" align="center" valign="middle">11060</td>
            <td width="16%" height="36" align="center" valign="middle" class="blue">火爆球王</td>
            <td width="14%" height="36" align="center" valign="middle">￥50000.00 </td>
            <td width="13%" height="36" align="center" valign="middle">￥2.00 </td>
            <td width="12%" height="36" align="center" valign="middle"> 15%</td>
            <td width="14%" height="36" align="center" valign="middle">06-13 13:29 </td>
            <td width="11%" height="36" align="center" valign="middle" class="blue"><div class="look_btn fl ml20"><span><a href="member_detail.html">查看</a></span></div></td>
          </tr>
          
        </table>
        
        
        
        </div>
    </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
