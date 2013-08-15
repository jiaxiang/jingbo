<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-用户登录</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" /><?php
echo html::script(array
(
 	'media/js/jquery.js',
 	'media/js/Validform.js',
	
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/alert.css',
	'media/css/validate.css',
), FALSE);
?>
<script type="text/javascript">
$(function(){
	$("#login_index").Validform({
	  tiptype:2
	});
	$("#login_yz_cw").hide();
	$('input').click(function(){
		$("#login_yz_cw").hide();
	})
	function shibai(id){
		$("#login_yz_cw").show();
		$("#login_yz_cw").html(id);
	}
	<?php if(!empty($ok)){?>
	shibai('<?php echo $ok?>');
	<?php }?>
	
})

</script>
</head>
<body>
<?php echo View::factory('header')->render();?>
<div class="width">
	<p id="login_title" class="font14  mt5 fl"><strong>会员登录</strong></p>
    <div class="fl" id="login_box">
    	<div class="fl" id="login_box_l" style="position:relative;">
			<div id="login_yz_cw"></div>
		
		 <form method="post" action="<?php echo url::base();?>user/login" id="login_index">
    	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
    	      <td width="34%" height="50" valign="left" colspan="3"><div class="Validform_checktip"><?php if(!empty($notice)){ print_r ($notice); }?></div></td>
  	      </tr>
    	    <tr>
    	      <td width="12%" height="30" align="right" valign="middle" class="font14">用户名：</td>
    	      <td height="30" colspan="2" valign="middle"><input type="text" name="username" id="username" class="login_text" datatype="s1-18"  nullmsg="请输入用户名！" errormsg="用户名至少为4个字符！"/></td>
    	      <td width="34%" height="30" valign="middle"><div class="Validform_checktip">昵称至少4个字符,最多18个字符</div></td>
  	      </tr>
    	    <tr>
    	      <td height="24" colspan="4" align="right" valign="middle"></td>
   	        </tr>
    	    <tr>
    	      <td align="right" valign="middle" class="font14">密码：</td>
    	      <td colspan="2"><input type="password" name="password" id="password" class="login_text" datatype="*6-16" nullmsg="请设置密码！" errormsg="密码范围在6~16位之间！"/></td>
    	      <td><div class="Validform_checktip">密码范围在6~16位之间</div></td>
  	      </tr>
		   <tr>
    	      <td height="24" colspan="4" align="right" valign="middle"></td>
   	        </tr>
		    <tr>
    	      <td align="right" valign="middle" class="font14">验证码：</td>
    	      <td colspan="2"><input name="secode" id="secode"  type="text"  class="index_login_yzm fl" maxlength="4"  datatype="*"  nullmsg="请输入验证码！" />
			  <span class="fl">
				<img  alt="点击更换图片" onClick="reload_secoder('login_secoder');"  style="cursor: pointer;" src="<?php echo url::base();?>site/secoder?id=login_secoder" id='login_secoder' />
<script language="javascript">
var flag = 0;
function reload_secoder(id,url){
    flag++;
    $('#'+id).attr("src","<?php echo url::base();?>site/secoder?id="+id+"&flag="+flag);
}
</script>
               </span>
		      </td>
    	      <td><div class="Validform_checktip"></div></td>
  	      </tr>
    	    <tr>
    	      <td>&nbsp;</td>
    	      <td width="5%" height="30" align="left" valign="middle"><input type="checkbox" name="checkbox" id="checkbox" /></td>
    	      <td width="49%" height="42" valign="middle" ><font class="gray68">记住登录状态</font>　<font class="graybc">|</font>　<font class="gray68"><a href="<?php echo url::base();?>user/getpassword">找回用户名/密码</a></font> <img src="<?php echo url::base();?>media/images/icon9.jpg" width="12" height="12" /></td>
    	      <td>&nbsp;</td>
  	      </tr>
    	    <tr>
    	      <td>&nbsp;</td>
    	      <td colspan="2" align="left" valign="middle">
    	      <input type="image" src="<?php echo url::base();?>media/images/login_btn.jpg" width="98" height="35" alt="登录" />
    	      <a href="<?php echo url::base();?>alipay" target="_blank"><img src="<?php echo url::base();?>media/images/alipay_fl_m.png" width="100" height="20" /></a>
    	      </td>
    	      <td>&nbsp;</td>
  	      </tr>
  	    </table>
		</form>
    	</div>
<div id="login_box_r" class="fl">
        	<p class="gray6"><strong>还不是<?php echo $site_config['site_title'];?>用户？</strong><br />
       	    现在免费注册成为<?php echo $site_config['site_title'];?>用户</p>
        <p class="pt5"><a href="<?php echo url::base();?>user/register"><img src="<?php echo url::base();?>media/images/up_btn.jpg" width="137" height="36" alt="注册新用户" /></a></p>
      </div>
    </div>
</div>
<!--login_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->

</body>
</html>
