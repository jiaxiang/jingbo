<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-资金变动明细</title>
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
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">资金管理</a></span> &gt;&gt; 资金变动明细</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
  <?php echo View::factory('user/left')->render();?>
  <div class="member_right fl">
    <div id="member_tit" class="fl">
      <ul>
        <li class="hover"><a href="<?php echo url::base();?>user/capital_changes">资金变动明细</a></li>
        <li><a href="<?php echo url::base();?>user/virtual_capital_changes">竞波币明细</a></li>
      </ul>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
      <tr>
        <td height="5" colspan="4" align="center" valign="middle" bgcolor="#e8f2ff"></td>
      </tr>
      <tr>
        <td width="22" height="25" align="center" valign="middle" bgcolor="#e8f2ff">&nbsp;</td>
        <td height="25" align="left" valign="middle" bgcolor="#e8f2ff">支出交易笔数：<span class="blue"><?php echo $outcount;?></span></td>
        <td height="25" align="left" valign="middle" bgcolor="#e8f2ff">收入交易笔数：<span class="blue"><?php echo $incount;?></span></td>
        <td width="388" height="25" valign="middle" bgcolor="#e8f2ff">收入金额：<span class="blue"><?php if (isset($insum['price'])) echo $insum['price']; else echo 0;?>元</span></td>
      </tr>
      <tr>
        <td width="22" height="25" align="center" valign="middle" bgcolor="#e8f2ff">&nbsp;</td>
        <td width="185" height="25" align="left" valign="middle" bgcolor="#e8f2ff">充值次数：<span class="blue"><?php echo $rechargecount;?></span></td>
        <td width="198" height="25" align="left" valign="middle" bgcolor="#e8f2ff">支出金额：<span class="blue"><?php if (isset($outsum['price'])) echo $outsum['price']; else echo 0;?>元</span> </td>
        <td height="25" valign="middle" bgcolor="#e8f2ff">账户资金：<span class="font14 bold red"><?php echo $_user['user_money'];?>元(资金:<?php echo $_user['user_moneys']['user_money']+$_user['user_moneys']['bonus_money'];?> + 彩金:<?php echo $_user['user_moneys']['free_money'];?>)</span></td>
      </tr>
      <tr>
        <td height="5" colspan="4" align="center" valign="middle" bgcolor="#e8f2ff"></td>
      </tr>
      <tr>
            <td height="1" colspan="4"  align="left" valign="middle" bgcolor="#ffffff"></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border: solid 1px #c5ddf5; border-bottom:0;">
      <tr>
        <td height="1" colspan="7" align="center" valign="middle" bgcolor="#ffffff"></td>
      </tr>
      <tr>
        <td width="17%" height="33" align="center" valign="middle" bgcolor="#f3f3f3">交易时间</td>
        <td width="11%" align="center" valign="middle" bgcolor="#f3f3f3">收入</td>
        <td width="11%" align="center" valign="middle" bgcolor="#f3f3f3">支出</td>
        <td width="11%" align="center" valign="middle" bgcolor="#f3f3f3">余额</td>
        <td width="13%" align="center" valign="middle" bgcolor="#f3f3f3">交易类型</td>
        <td width="19%" align="center" valign="middle" bgcolor="#f3f3f3">订单号</td>
        <td width="18%" align="center" valign="middle" bgcolor="#f3f3f3">备注</td>
      </tr>
      <tr>
        <td height="1" colspan="7" align="center" valign="middle" bgcolor="#ffffff"></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
    

<?php
	foreach ($list as $row) 
	{
?>
      <tr>
        <td width="17%" height="36" align="center" valign="middle"><?php echo $row['add_time'];?></td>
        <td width="11%" height="36" align="center" valign="middle"><?php echo $row['is_in'] == 0 ? $row['price'] : 0;?>元</td>
        <td width="11%" height="36" align="center" valign="middle" ><?php echo $row['is_in'] == 1 ? $row['price'] : 0;?>元 </td>
        <td width="11%" align="center" valign="middle" > <?php echo $row['user_money'];?>元</td>
        <td width="13%" align="center" valign="middle" > <?php echo $row['type_name'];?></td>
        <td width="19%" height="36" align="center" valign="middle"><?php echo $row['order_num'];?></td>
        <td width="18%" align="center" valign="middle"><?php echo $row['memo'];?></td>
      </tr>
<?php
	}
?>      
    </table>
    <div class="recharge_box fl" style="padding-top:5px;">
        <div class="manu mt15">
		<?PHP  echo $this->pagination->render('page_html');?>        
        </div>
        <p class="blue bold mt15" style="border-top: dashed 1px #ccc; padding-top:15px;">说明：</p>
        <p style="padding-left:30px;" class="gray6"> 1.您可以查询您的账户最近3个月内的账户明细。<br/>
     2.如果您添加了预付款，银行账户钱扣了，账户还没有加上，请及时与我们联系，我们将第一时间为您处理！<br/>
     3.如需要查询全部明细，请联系网站客服：021-61176880。</p>
    </div>
  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
</body>
</html>
