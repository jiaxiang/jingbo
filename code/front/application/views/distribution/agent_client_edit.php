<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-代理服务-下级用户列表</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/hdm',
	'media/js/tk',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/szc',
	'media/css/mask',
), FALSE);	
?>
<script language="javascript">
</script>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">
	您所在的位置：
	<span class="blue"><a href="<?php echo url::base();?>">首页</a></span> &gt;&gt; 
	<span class="blue"><a href="<?php echo url::base();?>user">会员中心</a></span> &gt;&gt; 
	<span class="blue"><a href="#">代理服务</a></span> &gt;&gt; 下级用户列表</div>
<!--面包屑导航_end-->

<!--content1-->
<div class="width">
	<?php echo View::factory('user/left')->render();?>  

	<div class="member_right fl" style="position:relative">
		<?php //弹出窗口?>
		<div class="paly_pop_ok" style="top:40px; left:120px;">
		<div class="tips_b">
			<div class="tips_box">
				<div class="tips_title">
				<h2>温馨提示</h2>
				<span class="close"><a href="/user/login">关闭</a></span>
				</div>
				<div class="tips_text" style="overflow-y:auto; line-height:30px;">
			   	 	
				</div>
				<div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
					<a class="xg_gg_bf fhxgai" href="/user/login">重新登陆</a>
				</div>
			</div>
		</div>
		</div> 

<!-- Content Core Start -->
<!--**content start**-->
		
	<div class="member_right fl">
		
		<!--**error start**-->
	<?php 
		$remindData = (array)remind::get();
		if (isset($remindData['error'])) 
		{
			$errorData = $remindData['error'];
	?>
    <div style="height:25px; line-height:25px; border:1px solid #cc0a0c; background-color:#FEF6f3; padding-left:15px; color:red;">
    	<span><?php echo $errorData[0]; ?></span>
    </div>
    <?php } ?>
	<!--**error end**-->
		
		<div id="member_tit" class="fl">
			<ul>
				<li class="hover">修改下级用户</li>
			</ul>
		</div>
		<form id="add_form" name="add_form" method="post" onsubmit="return checkForm()"
			action="<?php echo url::base().url::current();?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box" 
			style="border:solid 1px #c5ddf5; ">
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">下级用户</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $client['lastnameMark'].'   ('.$client['id'].')'; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">添加时间</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $client['date_add']; ?></td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">是否返利</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<select name="client_type">
						<option value="1" <?php if($relation['client_type'] == 1){echo 'selected';}?> >是</option>
						<option value="0" <?php if($relation['client_type'] == 0){echo 'selected';}?> >否</option>
					</select>
					<span class="brief-input-state notice_inline">一旦设置成否，则以下返点率则不生效</span>
				</td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">普通返点率</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<input type="hidden" name="client_rate_old" id="client_rate_old" value="<?php echo $relation['client_rate']; ?>" />
					<input type="text" name="client_rate" id="client_rate"
						value="<?php echo $relation['client_rate']; ?>"/>
					<span class="brief-input-state notice_inline">返点率不能为负数，也不能超过代理的即时返点率，最大值为0.1</span>
				</td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">北单返点率</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<input type="hidden" name="client_rate_beidan_old" id="client_rate_beidan_old" value="<?php echo $relation['client_rate_beidan']; ?>" />
					<input type="text" name="client_rate_beidan" id="client_rate_beidan"
						value="<?php echo $relation['client_rate_beidan']; ?>"/>
					<span class="brief-input-state notice_inline">返点率不能为负数，也不能超过代理的即时返点率，最大值为0.1</span>
				</td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo ($relation['flag'] == 2) ? '生效' : '关闭'; ?></td>
			</tr>
		</table>
		
		<div style="float:left; text-align:center; line-height:40px; height:40px; padding:20px;" >
			<input type="button" name="button" class="xg_gg_bf fhxgai" value=" 返回 " 
				onclick="javascript:window.history.go(-1);" />
			<input type="submit" name="submit" class="xg_gg_bf fhxgai" value=" 确认修改 " />
		</div>
		
		</form>
	</div>
	
	<div class="member_right fl">&nbsp;</div><br/>
		
<!--**content end**-->
</div>
</div>
<!--content1_end-->

<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
<script type="text/javascript">
function checkForm()
{
	var rateInput = document.getElementById('client_rate');
	if (rateInput.value == null || rateInput.value == '') 
	{
		alert('(普通)返点率不能为空');
		return false;
	}
	if (rateInput.value < 0 || rateInput.value > 0.1) 
	{
		alert('(普通)返点率超出范围');
		return false;
	}
	
	var rateBeidanInput = document.getElementById('client_rate_beidan');
	if (rateBeidanInput.value == null || rateBeidanInput.value == '') 
	{
		alert('(北单)返点率不能为空');
		return false;
	}
	if (rateBeidanInput.value < 0 || rateBeidanInput.value > 0.1) 
	{
		alert('(北单)返点率超出范围');
		return false;
	}

	var rateOldHidden = document.getElementById('client_rate_old');
	if (rateInput.value < rateOldHidden.value)
	{
		alert('新返点率不能低于旧返点率(普通)');
		return false;
	}
	var rateBeidanOldHidden = document.getElementById('client_rate_beidan_old');
	if (rateBeidanInput.value < rateBeidanOldHidden.value)
	{
		alert('新返点率不能低于旧返点率(北单)');
		return false;
	}
	
	return true;
}

function isNumber(String)
{   
	var Letters = "1234567890"; //可以自己增加可输入值
	var i;
	var c;
	if(String.charAt( 0 )=='-')	return false;
	if( String.charAt( String.length - 1 ) == '-' )		return false;
	for( i = 0; i < String.length; i ++ )
	{   
		c = String.charAt( i );
		if (Letters.indexOf( c ) < 0)
		return false;
	}
	return true;
}
</script>
</html>
