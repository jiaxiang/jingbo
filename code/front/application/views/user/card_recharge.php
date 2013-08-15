<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>竞波网</title>
<meta name="Keywords" content="彩票,足彩,体彩,福彩,caipiao" />
<meta name="Description" content="竞波网是一家服务于中国彩民的互联网彩票合买代购交易平台，是当前中国彩票互联网交易行业的领导者。竞波网以服务中国彩民为己任，为彩民提供全国各大联销型彩票的在线合买、代购和彩票软件开发、彩票增值短信业务、彩票WAP移动业务等服务。覆盖了足球彩票，体育彩票，福利彩票等各类中国彩票." />
<?php
echo html::script(array
(
 	'media/js/jquery-1.4.2.min.js',
    'media/js/hdm',
	'media/js/jquery.validate',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/szc',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/mask',
), FALSE);
?>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">资金管理</a></span> &gt;&gt; 点卡充值</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
<?php echo View::factory('user/left')->render();?>  
	<div class="member_right fl">
	<?php echo View::factory('user/user_header')->render();?>
	
	<?php if (isset($remind_data) && isset($remind_data['error'])) { ?>
	<div style="float:left; border:1px solid red; width:780px; background-color:#fef2ee; padding-left:10px; margin-top:10px; font-size:10px; ">
		<span class="ui-icon ui-icon-alert">&nbsp;</span>
		出错了: <?php echo $remind_data['error'][0]; ?>
	</div>
	<?php }else if (isset($remind_data) && isset($remind_data['success'])) { ?>
	<div style="float:left; border:1px solid green; width:780px; background-color:#ceefde; padding-left:10px; margin-top:10px; font-size:10px; ">
		<?php echo $remind_data['success'][0]; ?>
	</div>
	<?php } ?>
	<div style="height:3px;"></div>
	
	<div id="recharge" class="fl mt5">
	      <ul>
	        <li id="two3" >点卡充值</li>
	      </ul>
	</div>
	<form action="/card/recharge" method="POST" onsubmit="return CheckForm()" >
	<div class="recharge_box fl" style="">
		<div class="fl">
			<p class="font14 bold">请输入您的充值卡卡号和相应的密码</p>
	      	<br/>
	      	<div>
		      	<table>
		      		<tr style="height:30px;">
		      			<td>卡号：</td>
		      			<td><input type="text" name="mgrNum" id="mgrNum" maxlength="15"/>(请输入15位卡号)</td>
		      		</tr>
		      		<tr style="height:30px;">
		      			<td>密码：</td>
		      			<td><input type="text" name="passWord" id="passWord" maxlength="10"/>(请输入密码)</td>
		      		</tr>
		      		<tr style="height:30px;">
		      			<td></td>
		      			<td>
			      			<input type="reset" value="清除" />
		    	  			<input type="submit" value="确认" />
		      			</td>
		      		</tr>
		      	</table>
	      	</div>
		</div>
	</div>
	</form>
    
  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
</body>

<script type="text/javascript">
	$(document).ready(function() {});
</script>
<script type="text/javascript">
function CheckForm()
{
	var mgrNumInput = document.getElementById("mgrNum");
	if (mgrNumInput.value == null || mgrNumInput.value == '') {
		alert("请填入卡号");
		return false;
	}
	if (mgrNumInput.value.length != 15) {
		alert("卡号不满15位");
		return false;
	}
	if (isNaN(mgrNumInput.value) == true) {
		alert("卡号必须是数字");
		return false;
	}
	
	var passWordInput = document.getElementById("passWord");
	if (passWordInput.value == null || passWordInput.value == '') {
		alert("请填入密码");
		return false;
	}
	
	return true;
}
</script>
</html>
