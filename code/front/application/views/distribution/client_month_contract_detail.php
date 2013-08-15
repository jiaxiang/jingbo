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
				<li class="hover">下级用户月结合约详细</li>
			</ul>
		</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box" 
			style="border:solid 1px #c5ddf5; ">
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">上级代理</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $agent['lastname']; ?></td>
			</tr>
			<tr height="33">
				<td width=15% align="center" valign="middle" bgcolor="#f3f3f3">下级用户</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $client['lastname']; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">合约类型</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php 
						if ($contract['contract_type'] == 0) {
							echo '普通返利';
						}else if($contract['contract_type'] == 1) {
							echo '下线返利';
						}else if($contract['contract_type'] == 2) {
							echo '超级代理返利';
						}
					?>
				</td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">彩种分类</td>
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
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">状态</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo ($contract['flag'] == 2) ? '生效' : '关闭'; ?></td>
			</tr>
			<tr height="33">
				<td align="center" valign="middle" bgcolor="#f3f3f3">备注：</td>
				<td align="left" valign="middle" style="padding-left:10px;">
					<?php echo $contract['note']; ?>
				</td>
			</tr>
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
				<td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">销售层级</td>
				<td width="20%" align="left" valign="middle" bgcolor="#f3f3f3" style="padding-left:20px;">
					销售额范围:下限(达到)&nbsp;~&nbsp;上限(不超过)</td>
				<td width="12%" align="left" valign="middle" bgcolor="#f3f3f3" style="padding-left:20px;">返点率</td>
			</tr>
	    </table>
	    <?php if (is_array($contractDetailList) && count($contractDetailList)) {?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
			<?php foreach ($contractDetailList as $cttDtl) { ?>
			<tr height="33">
				<td width="10%" align="center" valign="middle">销售层级 <?php echo $cttDtl['grade'];?>&nbsp;</td>
				<td width="25%" align="left" valign="middle" style="padding-left:20px;">
					￥<?php echo $cttDtl['minimum'];?>
					&nbsp;~&nbsp;
					￥<?php echo $cttDtl['maximum'];?>&nbsp;
				</td>
				<td width="15%" align="left" valign="middle" style="padding-left:20px;"><?php echo $cttDtl['rate'];?>&nbsp;</td>
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