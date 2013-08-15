<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-代理服务-月结合约详细</title>
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

<div class="width">

<!--**content start**-->
	<br/>
	<div class="member_right fl">
		<div id="member_tit" class="fl">
			<ul>
				<li class="hover">月结合约详细</li>
			</ul>
		</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box" 
			style="border:solid 1px #c5ddf5; ">
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">代理用户名</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $_user['lastname']; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">类型</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo ($contract['type'] == 7) ? '北单' : '普通'; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">合约创建时间</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $contract['createtime']; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">合约生效时间</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $contract['starttime']; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">最后一次结算</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $contract['lastsettletime'];?></td>
			</tr>
			<!-- 
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">返利税率</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $contract['taxrate'];?></td>
			</tr>
			 -->
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo ($contract['flag'] == 2) ? '生效' : '关闭'; ?></td>
			</tr>
			<!-- 
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">备注：</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<textarea maxlength="255" type="textarea" class="text valid" rows="5" cols="56" name="note" readonly><?php echo $contract['note']; ?></textarea>
				</td>
			</tr>
			 -->
		</table>
	</div>
	<div class="member_right fl">&nbsp;</div>
	<br/>
	
	<div class="member_right fl">
		<div id="member_tit" class="fl">
			<ul>
				<li class="hover">合约细则</li>
			</ul>
		</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border: solid 1px #c5ddf5; border-bottom:0;">
			<tr height="33">
				<td width="5%"  align="center" valign="middle" bgcolor="#f3f3f3">合约细则ID</td>
				<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">返点范围下限(达到)</td>
				<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">返点范围上限(不超过)</td>
				<td width="15%" align="center" valign="middle" bgcolor="#f3f3f3">返点率</td>
			</tr>
	    </table>
	    <?php if (is_array($cttDtlList) && count($cttDtlList)) {?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
			<?php foreach ($cttDtlList as $cttDtl) { ?>
			<tr height="33">
				<td width="5%"  align="center" valign="middle"><?php echo $cttDtl['id'];?>&nbsp;</td>
				<td width="15%" align="center" valign="middle"><?php echo $cttDtl['minimum'];?>&nbsp;</td>
				<td width="15%" align="center" valign="middle"><?php echo $cttDtl['maximum'];?>&nbsp;</td>
				<td width="15%" align="center" valign="middle"><?php echo $cttDtl['rate'];?>&nbsp;</td>
			</tr>
			<?php };?>
		</table>
		<?php }else {?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
			<tr><td height="33" align="left" valign="middle" style="padding-left:20xp;">&nbsp;没有相应的记录&nbsp;</td></tr>
		</table>
		<?php }?>
	</div>
	<div class="member_right fl">&nbsp;</div>
	<br/>
	
	<div class="member_right fl" style="text-align:center;" >
		<input type="button" name="button" class="ui-button" value=" 关闭 " onclick="javascript:window.close()">
	</div>
		
<!--**content end**-->

</div>