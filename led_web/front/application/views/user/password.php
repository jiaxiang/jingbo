<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-修改登录密码</title>
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
$(function(){
	$('.up_tis').css({"width":"180px"});
	$('.btn_c_org_p').click(function(){
	
			//老密码
			current_password=$("#current_password").val();
			if(current_password==""){
				$('#current_password_err').show().html('请输入旧密码');
				return false;
			}else{
				$.ajax({
					type: "post",
					url: "/user/password_old",
					data: "current_password="+current_password,
					timeout: 10000,
					error: function(){
						alert("超时");
					},
					success:function(name){
						if(name==2){
							$('#current_password_err').hide();
						}else{
							$('#current_password_err').show().html('输入密码错误');
							return false;
						}
					}
				});
			}
			//新密码
		 repost= /^[^\s]{6,16}/;
		 password=$("#password").val();
		 password_confirm=$("#password_confirm").val();
		 if(repost.test(password)){
		 	$('#password_err').hide();
		 }else{
			$('#password_err').show().html('输入新密码');
			return false;
		 }
		  if(password==password_confirm){
		 	$('#password_confirm_err').hide();
		 }else{
			$('#password_confirm_err').show().html('两次密码输入不一致');
			return false;
		 }
		$.ajax({
			type: "post",
			url: "/user/password",
			data: $('#draw_password_changes').serialize(),
			timeout: 10000,
			error: function(){
				alert("超时");
			},
			success:function(name){
				$(".paly_pop_ok").show();
				$(".tips_text").html('您的新密码:'+password);
			}
		});
		return false;	
	})


})
</script>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="<?php echo url::base();?>">首页</a></span> &gt;&gt; <span class="blue"><a href="<?php echo url::base();?>user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">个人信息管理</a></span> &gt;&gt; 修改登录密码</div>
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
  
  
    <div id="recharge" class="fl">
      <ul>
        <li class="hover">修改登录密码</li>
      </ul>
    </div>
    <div class="recharge_box fl">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
		 <form name="draw_password_changes" id="draw_password_changes" >
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" colspan="3" align="left" valign="middle" class="red">为了最大限度保障您的账户安全，请如实填写以下信息：</td>
	      </tr>
          <tr>
		      <td>&nbsp;</td>
		      <td height="30" colspan="3" align="left" valign="middle" class="font14 bold blue"><?php print_r($notice); ?></td>
	      </tr>
          
           <tr>
		      <td height="10" colspan="4"></td>
	        </tr>
		    <tr>
		      <td width="0%">&nbsp;</td>
		      <td width="14%" height="30" align="right" valign="middle"><span class="orange">* </span><span class="black">旧密码：</span></td>
		      <td width="26%" height="30" align="left" valign="middle"><input type="password" name="current_password" id="current_password" class="huiyuan_text_box" /></td>
	          <td width="60%" align="left" valign="middle"><div class="up_tis" style="display:none" id="current_password_err"></div></td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle">&nbsp;</td>
		      <td height="30" colspan="2" align="left" valign="top" class="graybc">请输入旧的密码</td>
           </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle"><span class="orange">*</span><span class="black"> 新密码：</span></td>
		      <td height="30" align="left" valign="middle"><input type="password" name="password" id="password" class="huiyuan_text_box" /></td>
	          <td align="left" valign="middle"><div class="up_tis" style="display:none" id="password_err"></div></td>
	       </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle">&nbsp;</td>
		      <td height="30" colspan="2" align="left" valign="top" class="graybc">推荐同时使用包含字母、数字及特殊符号的密码，不能输入空格；长度在6－16之间</td>
           </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle"><span class="orange">*</span><span class="black"> 确认新密码：</span></td>
		      <td height="30" align="left" valign="middle"><input type="password" name="password_confirm" id="password_confirm" class="huiyuan_text_box" /></td>
	          <td align="left" valign="middle"><div class="up_tis" style="display:none" id="password_confirm_err"></div></td>
		    </tr>
            <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle">&nbsp;</td>
		      <td height="30" colspan="2" align="left" valign="top" class="graybc">推荐同时使用包含字母、数字及特殊符号的密码，不能输入空格；长度在6－16之间</td>
           </tr>
		    <tr>
		      <td height="10" colspan="4"></td>
	        </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td><input name="submit"  type="submit" value="修 改" class="btn_c_org_p"/></td>
	          <td>&nbsp;</td>
		    </tr>
		    <tr>
		      <td height="50" colspan="4">&nbsp;</td>
	        </tr>
            </form>
	      </table>
    </div>
    
  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
