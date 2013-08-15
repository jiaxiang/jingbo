<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-取款记录</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/hdm',
	'media/js/My97DatePicker/WdatePicker',	
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
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">资金管理</a></span> &gt;&gt; 取款记录</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
  
<?php echo View::factory('user/left')->render();?>  
  
  <div class="member_right fl">
    <div id="member_tit" class="fl">
      <ul>
        <li class="hover">取款记录</li>
      </ul>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
      <form action="?" method="GET" name="search_form" id="search_form">
      <tr>
        <td width="19" height="33" align="center" valign="middle" bgcolor="#e8f2ff">&nbsp;</td>
        <td width="108" align="left" valign="middle" bgcolor="#e8f2ff"><input name="begintime" id="begintime" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'endtime\')||\'2030-10-01\'}'})" type="text" class="hasDatepicker" value="<?php echo date("Y-m-d",time()-7*24*3600);?>"  style="width:100px;" /></td>
        <td width="23" align="center" valign="middle" bgcolor="#e8f2ff">至</td>
        <td width="118" valign="middle" bgcolor="#e8f2ff"><input name="endtime" id="endtime" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'begintime\')}',maxDate:'2030-10-01'})" type="text" value="<?php echo date("Y-m-d",time());?>"  style="width:100px;" /></td>
        <td width="58" align="left" valign="middle" bgcolor="#e8f2ff"><label>
          <!--select name="select" id="select">
            <option>全部</option>
          </select-->
        </label></td>
        <td width="467" align="left" valign="middle" bgcolor="#e8f2ff"><div class="orange_btn fl white"><span><a href="#" onclick="javascript:document.getElementById('search_form').submit()">查询</a></span></div></td>
      </tr>
      </form>
      <tr>
            <td height="1" colspan="6"  align="left" valign="middle" bgcolor="#ffffff"></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border: solid 1px #c5ddf5; border-bottom:0;">
      <tr>
        <td height="1" colspan="6" align="center" valign="middle" bgcolor="#ffffff"></td>
      </tr>
      <tr>
        <td width="22%" height="33" align="center" valign="middle" bgcolor="#f3f3f3">交易时间</td>
        <td width="14%" align="center" valign="middle" bgcolor="#f3f3f3">收入</td>
        <td width="12%" align="center" valign="middle" bgcolor="#f3f3f3">支出</td>
        <td width="18%" align="center" valign="middle" bgcolor="#f3f3f3">订单号</td>
        <!--td width="10%" align="center" valign="middle" bgcolor="#f3f3f3">状态</td-->
        <td width="34%" align="center" valign="middle" bgcolor="#f3f3f3">备注</td>
      </tr>
      <tr>
        <td height="1" colspan="6" align="center" valign="middle" bgcolor="#ffffff"></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box">
    
<?php
	foreach ($list as $row) 
	{
?>
      <tr>
        <td width="22%" height="36" align="center" valign="middle"><?php echo $row['add_time'];?></td>
        <td width="14%" height="36" align="center" valign="middle"><?php echo $row['is_in'] == 0 ? $row['price'] : 0;?>元</td>
        <td width="12%" height="36" align="center" valign="middle" ><?php echo $row['is_in'] == 1 ? $row['price'] : 0;?>元 </td>
        <td width="18%" align="center" valign="middle" > <?php echo $row['order_num'];?></td>
        <!--td width="10%" align="center" valign="middle" >成功</td-->
        <td width="34%" height="36" align="center" valign="middle"><?php echo $row['memo'];?></td>
      </tr>
<?php
	}
?>
    </table>
    <div class="recharge_box fl" style="padding-top:5px;">
    	<p class="bold blue line36" style="border-bottom: dashed 1px #ccc;">支出交易笔数：<?php echo $count;?>　支出金额合计：<?php echo $outsum['price'];?>元</p>
        <div class="manu mt15">
        <?PHP  echo $this->pagination->render('page_html');?>
        </div>
        <p class="blue bold mt15">说明：</p>
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
