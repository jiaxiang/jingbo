<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-代理服务-月结合约</title>
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
	<span class="blue"><a href="#">代理服务</a></span> &gt;&gt; 月结合约</div>
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
		<div class="member_right fl">
			<div id="member_tit" class="fl">
				<ul>
					<li class="hover">月结合约列表</li>
				</ul>
			</div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border: solid 1px #c5ddf5; border-bottom:0;">
				<tr height="33">
					<!-- 
					<td width="5%"  align="center" valign="middle" bgcolor="#f3f3f3">合约ID</td>
					 -->
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">合约类型</td>
					<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">合约创建日期</td>
					<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">合约生效日期</td>
					<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">最后一次结算日期</td>
					<!-- 
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">返点税率</td>
					 -->
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">查看详细</td>
				</tr>
		    </table>
			<?php if (is_array($dataList) && count($dataList)) {?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
				<?php foreach ($dataList as $contract) { ?>
				<tr height="33">
					<!-- 
					<td width="5%"  align="center" valign="middle"><?php //echo $contract['id'];?>&nbsp;</td>
					 -->
					<td width="10%" align="center" valign="middle"><?php echo ($contract['type'] == 7) ? '北单' : '普通';?>&nbsp;</td>
					<td width="15%" align="center" valign="middle"><?php echo $contract['createtime'];?>&nbsp;</td>
					<td width="15%" align="center" valign="middle"><?php echo $contract['starttime'];?>&nbsp;</td>
					<td width="15%" align="center" valign="middle"><?php echo $contract['lastsettletime'];?>&nbsp;</td>
					<!-- 
					<td width="10%" align="center" valign="middle"><?php //echo $contract['taxrate'];?>&nbsp;</td>
					 -->
					<td width="10%" align="center" valign="middle">
						<?php echo ($contract['flag'] == 2) ? '生效' : '关闭';?>
					</td>
					<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">
						<a href="month_contract/detail/<?php echo $contract['id'];?>" target="_blank">详细</a>
					</td>
				</tr>
				<?php };?>
			</table>
			<?php }else {?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
				<tr><td height="33" align="left" valign="middle" style="padding-left:20xp;">&nbsp;没有相应的记录&nbsp;</td></tr>
			</table>
            <?php }?>
            
            <div class="recharge_box fl" style="padding-top:5px;">
	        <div class="manu mt15">
			<?PHP  echo $this->pagination->render('page_html');?>
	        </div>
	        </div>
		</div>
<!-- Content Core End -->
	</div>
</div>
<!--content1_end-->

<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>