<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-代理服务-代理信息</title>
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
	<span class="blue"><a href="#">代理服务</a></span> &gt;&gt; 代理信息</div>
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
		<div id="member_tit" class="fl">
			<ul>
				<li class="hover">代理信息详细</li>
			</ul>
		</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box" 
			style="border:solid 1px #c5ddf5; ">
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">代理用户名</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['lastname']; ?></td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">真实姓名</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['realname']; ?></td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">手机</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['mobile']; ?></td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">固话</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['tel']; ?></td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">QQ</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['qq']; ?></td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">邀请码</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['invite_code']; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">类型</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php if ($agent['agent_type'] == 0) echo '普通代理'; ?>
					<?php if ($agent['agent_type'] == 1) echo '超级代理'; ?>
					<?php if ($agent['agent_type'] == 2) echo '二级代理'; ?>
				</td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">创建时间</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['createtime']; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo ($agent['flag'] == 2) ? '生效' : '关闭'; ?></td>
			</tr>
		</table>
	</div>
	<div class="member_right fl">&nbsp;</div>
	<br/>
	
	<div class="member_right fl" style="text-align:center;" >
	<!-- 
		<a href="agent/edit">修改</a>
	 -->
		<input type="button" name="button" class="xg_gg_bf fhxgai" value=" 修改 " 
			onclick="javascript:document.location.href='agent/edit';">
	</div>
		
<!--**content end**-->
</div>
</div>
<!--content1_end-->

<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
</div>