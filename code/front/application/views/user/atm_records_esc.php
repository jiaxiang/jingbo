<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-取款</title>
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
<script type="text/javascript">  

		//设为审核失
		$(function(){
			
			$('#atm_esc').click(function(){
				if(!confirm('取消提现,确认要进行此操作吗？')){
					return false;
				}
				$('#list_form').attr('action','/user/atm_esc');
				$('#list_form').submit();
				return false;
				});	

		});
		
</script>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">资金管理</a></span> &gt;&gt; 取消提现</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
  
<?php echo View::factory('user/left')->render();?>  
  
  <div class="member_right fl">
    <div id="member_tit" class="fl">
      <ul>
        <li class="hover">可取消提现纪录</li>
      </ul>
    </div>
     <form id="list_form" name="list_form" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border-left: solid 1px #c5ddf5; border-right: solid 1px #c5ddf5;">
            <td height="1" colspan="6"  align="left" valign="middle" bgcolor="#ffffff"></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border: solid 1px #c5ddf5; border-bottom:0;">
      <tr>
        <td height="1" colspan="6" align="center" valign="middle" bgcolor="#ffffff"></td>
      </tr>
      <tr>
        <td width="25%" height="33" align="center" valign="middle" bgcolor="#f3f3f3">申请时间</td>
        <td width="25%" align="center" valign="middle" bgcolor="#f3f3f3">金额</td>
        <td width="25%" align="center" valign="middle" bgcolor="#f3f3f3">提现银行</td>
        <td width="25%" align="center" valign="middle" bgcolor="#f3f3f3">选择要取消的提现</td>
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
        <td width="25%" height="36" align="center" valign="middle"><?php echo $row['time_stamp'];?></td>
        <td width="25%" height="36" align="center" valign="middle"><?php echo $row['money']?>元</td>
        <td width="25%" height="36" align="center" valign="middle" ><?php echo $row['bank_name']?> </td>
        
        <td width="25%" height="36" align="center" valign="middle" ><input type="radio" name="order_ids[]" id="radio" value="<?php echo $row['id'];?>">
      </tr>
<?php
	}
?>
    </table>
</form>
    <div class="recharge_box fl" style="padding-top:5px;" align="center">
<?php if(!empty($list)){?>
    <input type="submit" name="button"  id='atm_esc' value="提交" />
    <?php }?>
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
