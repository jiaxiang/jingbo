<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-修改提现密码</title>
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

<?php
if($set_draw_password)
{
?>
		//老密码
		old_draw_password=$("#old_draw_password").val();
		if(old_draw_password==""){
			$('#old_draw_password_err').show().html('请输入旧密码');
			return false;
		}else{
			$.ajax({
				type: "post",
				url: "/user/withdrawals_password/checkold/",
				data: "old_draw_password="+old_draw_password,
				timeout: 10000,
				error: function(){
					alert("超时");
				},
				success:function(status){
					if(status==1){
						$('#old_draw_password_err').hide();
					}else{
						$('#old_draw_password_err').show().html('输入密码错误');
						return false;
					}
				}
			});
		}
<?php
}
?>		

		//新密码
		 repost= /^[^\s]{6,20}/;
		 draw_password=$("#draw_password").val();
		 re_draw_password=$("#re_draw_password").val();
		 if(repost.test(draw_password)){
		 	$('#draw_password_err').hide();
		 }else{
			$('#draw_password_err').show().html('输入新密码，长度6－20之间');
			return false;
		 }
		  if(draw_password==re_draw_password){
		 	$('#re_draw_password_err').hide();
		 }else{
			$('#re_draw_password_err').show().html('两次密码输入不一致');
			return false;
		 }
		 $.ajax({
			type: "post",
			url: "/user/withdrawals_password",
			data: $('#draw_password_changes').serialize(),
			timeout: 10000,
			error: function(){
				alert("超时");
			},
			success:function(status){
				if (status==0)
				{
					$(".paly_pop_ok").show();	
					$(".tips_text").html('旧密码输入错误!');
				}
				else if (status==2)
				{
					$(".paly_pop_ok").show();	
					$(".tips_text").html('异常错误!');					
				}		
				else
				{
					$(".paly_pop_ok").show();	
					$(".tips_text").html('提现密码修改成功!');	
					document.draw_password_changes.reset();
				}
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
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">个人信息管理</a></span> &gt;&gt; 修改取款信息</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
<?php echo View::factory('user/left')->render();?>
<div class="member_right fl" style="position:relative">


<div class="paly_pop_ok" style="top:40px; left:120px;">
<div class="tips_b">
	<div class="tips_box">
		<div class="tips_title">
		<h2>温馨提示</h2>
		<span class="close"><a href="javascript:void(0)">关闭</a></span>
		</div>
		<div class="tips_text" style="overflow-y:auto; line-height:30px;">
	   	 	
		</div>
		<div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
			<a class="xg_gg_bf fhxgai" href="javascript:void(0)">确定</a>
		</div>
	</div>
</div>
</div>


    <div id="recharge" class="fl">
      <ul>
        <li class="hover">修改提现密码</li>
      </ul>
    </div>
    <div class="recharge_box fl">
    
    
    
    
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><form id="draw_password_changes" name="draw_password_changes" action="/user/withdrawals_password" method="post">
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" colspan="3" align="left" valign="middle" class="red">为了最大限度保障您的账户安全，请如实填写以下信息：</td>
	      </tr>
           <tr>
		      <td>&nbsp;</td>
		      <td height="30" colspan="3" align="left" valign="middle" class="font14 bold blue"></td>
	      </tr>
           <tr>
		      <td height="10" colspan="4"></td>
	        </tr>
		    <tr>
		      <td width="1%">&nbsp;</td>
		      <td width="14%" height="30" align="right" valign="middle"><span class="orange">* </span><span class="black">旧密码：</span></td>
		      <td width="26%" height="30" align="left" valign="middle"><input type="password" name="old_draw_password" id="old_draw_password" class="huiyuan_text_box" value=""/></td>
	          <td width="59%" align="left" valign="middle"><div class="up_tis" style="display:none" id="old_draw_password_err"></div></td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle">&nbsp;</td>
		      <td height="30" colspan="2" align="left" valign="top" class="graybc">如果第一次设置不需要填写原取款密码</td>
          </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle"><span class="orange">*</span><span class="black"> 新密码：</span></td>
		      <td height="30" align="left" valign="middle"><input type="password" name="draw_password" id="draw_password"  class="huiyuan_text_box" value=""/></td>
	          <td align="left" valign="middle"><div class="up_tis" style="display:none" id="draw_password_err"></div></td>
	      </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle">&nbsp;</td>
		      <td height="30" colspan="2" align="left" valign="top" class="graybc">推荐同时使用包含字母、数字及特殊符号的密码，不能输入空格；长度在6－20之间</td>
          </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle"><span class="orange">*</span><span class="black"> 确认新密码：</span></td>
		      <td height="30" align="left" valign="middle"><input type="password" name="re_draw_password" id="re_draw_password" class="huiyuan_text_box" value=""/></td>
	          <td align="left" valign="middle"><div class="up_tis" style="display:none" id="re_draw_password_err"></div></td>
		    </tr>
            <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle">&nbsp;</td>
		      <td height="30" colspan="2" align="left" valign="top" class="graybc">推荐同时使用包含字母、数字及特殊符号的密码，不能输入空格；长度在6－20之间</td>
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
