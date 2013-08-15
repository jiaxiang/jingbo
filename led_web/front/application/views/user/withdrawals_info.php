<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-修改提现信息</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
    'media/js/hdm',
	'media/js/city',
	'media/js/banklist',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/szc',
	'media/css/mask',
), FALSE);
?>
<style>
.tblase td{ padding:5px; line-height:18px;}
</style>
</head>
<body>
<!--top小目录--><?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">资金管理</a></span> &gt;&gt; 提现</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
	<?php echo View::factory('user/left')->render();?>
<div class="member_right fl">
 <?php echo View::factory('user/user_header')->render();?>
  <div id="member_tit" class="fl mt5">
<ul>
       	    <li class="hover">取款信息管理</li>
      </ul>
    </div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border: solid 1px #c5ddf5; border-top:0">
          <tr>
            <td width="4%" height="33" align="left" valign="middle" bgcolor="#e8f2ff">&nbsp;</td>
            <td width="96%" height="22" align="left" valign="middle" bgcolor="#e8f2ff">您需要填写真实的身份证信息和绑定银行卡之后，才能提款！银行卡户名必须与本站真实姓名一致！</td>
          </tr>
          <tr>
            <td height="1" colspan="2" align="left" valign="middle" bgcolor="#ffffff"></td>
          </tr>
    </table>
	
<div class="recharge_box fl" style="position:relative">
<div class="paly_pop_ok" >
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="javascript:void(0)">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px;">
           			<span class="suc_def pop_cw"></span>
					<span class="pop_ts_title"></span>
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<span class="xg_gg_bf xg_gb" id="xg_gg_bf">关闭</span>
            </div>
	    </div>
   </div>
</div>

<?php
if (!$set_profile)
{
?>
<div class="paly_pop_redirect" style="top:0px; left:120px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="/user/profile">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:50px;">
			必须先完善您的个人资料才可以进行此操作!
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="/user/profile">确认</a>
            </div>
	    </div>
   </div>
</div>
<?php
}
elseif(!$set_drawpassword)
{
?>
<div class="paly_pop_redirect" style="top:0px; left:120px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="/user/withdrawals_password">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:50px;">
			必须先设置提现密码才可以进行此操作!
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="/user/withdrawals_password">确认</a>
            </div>
	    </div>
   </div>
</div>
<?php
}
?>
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <form name="myform" id="myform" action="/user/withdrawals_info/sub_bank" method="post" >
		    <tr>
		      <td height="10" colspan="4"></td>
	        </tr>
		    <tr>
		      <td width="2%">&nbsp;</td>
		      <td width="98%" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		        <tr>
		          <td width="13%" height="30" align="right" valign="middle">开户银行名称：</td>
		          <td height="30" colspan="2" align="left" valign="middle">
		            <select name="province" id="province" onchange="getCity(this.options[this.selectedIndex].value)">
		              <option value="">-请选择省份-</option> 
	                </select>
		          <select name="city" id="city" onchange="getBank(this.options[this.selectedIndex].value)">
		              <option value="">-----</option>
	              </select></td>
	            </tr>
		        <tr>
<td height="30" align="right" valign="middle">&nbsp;</td>
<td height="30" colspan="2" align="left" valign="middle">
  <select name="bank_name" id="bank_name" onchange="getBranch(this.options[this.selectedIndex].value,document.getElementById('city')[document.getElementById('city').selectedIndex].value)">
  <option value="">-----</option> 
  </select>
  <select name="bank_found" id="bank_found" onchange="">
    <option value="">-----</option>
  </select>
</td>
</tr>
<tr>
                
		          <td height="30" align="right" valign="middle">银行卡号码：</td>
		          <td height="30" colspan="2" align="left" valign="middle">
				  <input type="text" name="account" id="account"  class="huiyuan_text_box" value=""/>    <span class="gray68">此项业务只支持借记卡，不支持信用卡，如需修改银行卡号，请联系<a href="/doc/doc_detail/43" style="color:#f00; text-decoration:underline;">在线客服</a></span> </td>
	            </tr>
		        <tr>
		          <td height="30" align="right" valign="middle">请输入取款密码：</td>
		          <td height="30" colspan="2" align="left" valign="middle"><input name="password" type="password"  class="huiyuan_text_box" id="password" value=""  maxlength="10" datatype="*" nullmsg="请输入取款密码" /> 此密码为网站提现密码，非银行取款密码</td>
	            </tr>
		        <tr>
		          <td height="15" colspan="3" align="right" valign="middle"></td>
	            </tr>
		        <tr>
		          <td align="right" valign="middle">&nbsp;</td>
		          <td colspan="2"><input name="button" type="submit" value="绑定银行卡" class="xg_gg_bf fhxgai" style="margin:0px; border:none;"/></td>
	            </tr>
	          </table></td>
	        </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="3">&nbsp;</td>
	        </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="3">提款处理需知：（周一至周日每日处理提款，除法定节日；如果帐户资金低于10元，仍需提款，请一次性提清）<br/>
16点前申请提款：当日处理　16点后申请提款：次日处理</td>
	        </tr>
            </form>
	      </table>
		</div>
		

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl member_box mt5">
    <TR>
      <TD  align="center" valign="middle" bgcolor="#e8f2ff"  class="blue bold" >银行/(第三方)</TD>
      <TD align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" width="11%" >真实姓名</TD>
      <TD height="50" align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" >银行卡号/(第三方账户名)</TD>
      <TD height="28" align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" >默认选择</TD>
      <TD height="28" align="center" valign="middle" bgcolor="#e8f2ff" class="blue bold" >删除</TD>
    </TR>

<?php 
foreach ($results as $row)
{
?>
    <TR>
      <TD align="center" height="25" ><?php echo $bankinfo[$row['bank_name']];?></TD>
      <TD align="center" ><?php echo $_user['real_name'];?></TD>
      <TD align="center" ><?php echo $row['account'];?></TD>
      <TD align="center" ><?php
	  if ($row['default'] == 1)
	  {
		   echo '<font color=green>默认</font>';
      }
	  else
	  {
			echo '<a href="/user/withdrawals_info/default/'.$row['id'].'">设为默认</a>';  
	  }
	  ?></TD>
      <TD align="center"><?php echo '<a href="/user/withdrawals_info/delete/'.$row['id'].'">删除</a>';?></TD>
    </TR>    
<?php 
}
?>    
    
</TABLE>
              
         
<?php echo View::factory('user/withdrawals_notice')->render();?>  


  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?><script language="javascript">
$(function(){
	<?php
	if ($submit_ok)
	{
	?>	   
		$('.paly_pop_ok').show();
		$('#xg_gg_bf').hide();
		$('.pop_cw').removeClass().addClass('suc_def pop_zq')
		$('#xg_submit').show();
		$('.pop_ts_title').html('<?php echo $submit_msg;?>');
	<?php
	}
	?>
	$('.xg_gb,.close').click(function(){
		if($('#xx_gg_bf').html()=='确认'){
			$('myform').submit();
		}else{ 
		 	$('.paly_pop_ok').hide();
		}
    })
	$("input[name=button]").click(function(){
		$('.suc_def').removeClass().addClass('suc_def pop_cw')
		bank_name=$('select[name=bank_name]').val();
		if(bank_name==''){
			$('.paly_pop_ok').show();
			$('.pop_ts_title').html('请选择开户银行');
			return false;
		}
		province=$('#province').val();
		if(province==''){
			$('.paly_pop_ok').show();
			$('.pop_ts_title').html('请选择请开户行的省份');
			return false;
		}
		bank_found=$('#bank_found').val();
		if(bank_found==''){
			$('.paly_pop_ok').show();
			$('.pop_ts_title').html('请填写开户支行名称');
			return false;
		}
		account=$('#account').val();
		if(account==''){
			$('.paly_pop_ok').show();
			$('.pop_ts_title').html('请填写银行卡号码');
			return false;
		}
		password=$('#password').val();
		if(password==''){
			$('.paly_pop_ok').show();
			$('.pop_ts_title').html('请填写取款密码');
			return false;
		}
	})	
})
</script>
<!--copyright_end-->
</body>
</html>
