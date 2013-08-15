<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-修改密码保护</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
	'media/js/jquery.validate',
    'media/js/hdm',
	'media/js/tk',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/extension',
	'media/css/szc',
	'media/css/mask',
), FALSE);
?>
<script language="javascript">
	$(function(){
		//添加密码保护
		$('.up_tis').css({"width":"150px"});
		$('input[name=oks]').click(function(){
			question=$("#question").val();
			if(question==""){
				$('#question_err').show().html('请选择密码问题');
				return false;
			}else{
				$('#question_err').hide();
			}
			
			wenti=$("#question").find("option:selected").text();
			answer=$("#answer").val();
			if(answer==""){
				$('#answer_err').show().html('请输入答案');
				return false;
			}else{
				$('#answer_err').hide();
			}
			$.ajax({
				type: "post",
				url: "/user/password_protection",
				data: $('#protection_form').serialize(),
				timeout: 10000,
				error: function(){
					alert("超时");
				},
				success:function(name){
					$(".paly_pop_ok").show();
					$(".tips_text").html('您的密码保护问题:'+wenti+'<br />您的密码保护答案：'+answer);
				}
			});
			return false;
		})
		
		
		$('input[name=submitOK]').click(function(){
			old_answer=$("#old_answer").val();
			if(old_answer==""){
				$('#old_answer_err').show().html('请输入答案');
				return false;
			}else{
				if($('#type').val()==old_answer){
					$('#old_answer_err').hide();
				}else{
					$('#old_answer_err').show().html('老答案输入不正确');
					return false;
				}	
			}
		
			question=$("#question").val();
			if(question==""){
				$('#question_err').show().html('请选择密码保护问题');
				return false;
			}else{
				$('#question_err').hide();
			}
			
			wenti=$("#question").find("option:selected").text();
			answer=$("#answer").val();
			if(answer==""){
				$('#answer_err').show().html('请输入答案');
				return false;
			}else{
				$('#answer_err').hide();
			}
			$.ajax({
				type: "post",
				url: "/user/password_protection",
				data: $('#protection_form').serialize(),
				timeout: 10000,
				error: function(){
					alert("超时");
				},
				success:function(name){
					$(".paly_pop_ok").show();
					$(".tips_text").html('您的密码保护问题:'+wenti+'<br />您的密码保护答案：'+answer);
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
<div class="width line36">您所在的位置：<span class="blue"><a href="<?php echo url::base();?>">首页</a></span> &gt;&gt; <span class="blue"><a href="<?php echo url::base();?>user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">个人信息管理</a></span> &gt;&gt; 修改密码保护</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
  
<?php echo View::factory('user/left')->render();?>  
  
  <div class="member_right fl" style="position:relative;">
<?php //弹出窗口?>
<div class="paly_pop_ok" style="top:40px; left:120px;">
<div class="tips_b">
	<div class="tips_box">
		<div class="tips_title">
		<h2>温馨提示</h2>
		<span class="close"><a href="/user/password_protection">关闭</a></span>
		</div>
		<div class="tips_text" style="overflow-y:auto; line-height:30px;">
	   	 	
		</div>
		<div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
			<a class="xg_gg_bf fhxgai" href="/user/password_protection">确认</a>
			<a class="xg_gg_bf qrxgai" href="/user/password_protection">关闭</a>
		</div>
	</div>
</div>
</div>

  
  
    <div id="recharge" class="fl">
      <ul>
        <li class="hover">修改密码保护</li>
      </ul>
    </div>
    <div class="recharge_box fl">
   	  <p class="pl15 gray6">

      </p>
  
 <?php 
// d($userinfo['question']);
 if (!empty($userinfo['question']))
 {
 ?>     

<!--问题不为空start-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <form name="name" id="protection_form" action="/user/password_protection" method="post">
      	  <input type="hidden" name="type" id="type" value="<?php echo $userinfo['answer']?>" />
        	<tr>
		      <td>&nbsp;</td>
		      <td width="50%" height="30" align="center" valign="middle" colspan="3" class="font14 bold blue"><?php print_r($notice);?></td>
              </td>
	        </tr>
		    <tr>
		      <td width="2%">&nbsp;</td>
		     <td width="18%" height="30" align="right" valign="middle"><span class="orange">* </span><span class="black">老问题：</span></td>
		      <td width="25%" height="30" align="left" valign="middle">
                     <?php echo $passwordquestion['default'][$userinfo['question']];?>
              </td>
		      <td width="55%" align="left" valign="middle">
              </td>
	        </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle"><span class="orange">*</span><span class="black"> 老答案：</span></td>
		      <td height="30" align="left" valign="middle">
             <input name="old_answer" id="old_answer" value="" /></input>
              </td>
		      <td height="30" align="left" valign="middle">
              <div class="up_tis" style="display:none" id="old_answer_err">&nbsp;</div>
              </td>
	        </tr>
            
            <tr>
		      <td width="2%">&nbsp;</td>
		     <td width="18%" height="30" align="right" valign="middle"><span class="orange">* </span><span class="black">新问题：</span></td>
		      <td width="25%" height="30" align="left" valign="middle">
               <?php if(!empty($userinfo['question'])): ?>
			 <select name="question" id="question" style="width:150px;">
		              <option value="" title="">请选择密码保护问题</option>
                      <?    foreach($passwordquestion['default'] as $k => $v):?>
                      <option value="<?php echo $k;?>" title="<?php echo $v;?>"><?php echo $v;?></option>
                    <?php endforeach;?>
	         </select>
			<?php endif;?>
              </td>
		      <td width="55%" align="left" valign="middle">
              <div class="up_tis" style="display:none" id="question_err">&nbsp;</div>
              </td>
	        </tr>
            <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle"><span class="orange">*</span><span class="black"> 新答案：</span></td>
		      <td height="30" align="left" valign="middle">
             <input name="answer" id="answer" value="" /></input>
              </td>
		      <td height="30" align="left" valign="middle">
              <div class="up_tis" style="display:none" id="answer_err">&nbsp;</div>
              </td>
	        </tr>
            
		    <tr>
		      <td height="10" colspan="4"></td>
	        </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td colspan="2"><input name="submitOK"  type="submit" value="确  定"  alt="确  定"/></td>
	        </tr>
		    <tr>
		      <td height="50" colspan="4">&nbsp;</td>
	        </tr>
            </form>
	      </table>
 <!--问题不为空end-->

      
      
<?php
 }
  else
 {
?>
 
 
 <!--问题为空start-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <form name="name" action="/user/password_protection" method="post" id="protection_form">
        <input type="hidden" name="type" id="type" value="" />
         	<tr>
		      <td>&nbsp;</td>
		      <td width="50%" height="30" align="left" valign="middle" colspan="3"><span style="color:#F00;"><?php echo $notice;?></span></td>
              </td>
	        </tr>
		    <tr>
		      <td width="2%">&nbsp;</td>
		      <td width="18%" height="30" align="right" valign="middle"><span class="orange">* </span><span class="black">您的密码保护问题：</span></td>
		      <td width="25%" height="30" align="left" valign="middle">
			 <select name="question" id="question" style="width:150px;">
                  <option value="">请选择密码保护问题</option>
                  <?php   foreach($passwordquestion['default'] as $k => $v):?>
                  <option value="<?php echo $k;?>" ><?php echo $v;?></option>
                 <?php endforeach;?>
	         </select>
              </td>
		      <td width="55%" align="left" valign="middle">
              <div class="up_tis" style="display:none" id="question_err"></div>
              </td>
	        </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td height="30" align="right" valign="middle"><span class="orange">*</span><span class="black"> 您的答案：</span></td>
		      <td height="30" align="left" valign="middle">
             <input name="answer" id="answer" value="" /></input>
              </td>
		      <td height="30" align="left" valign="middle">
              <div class="up_tis" style="display:none" id="answer_err">&nbsp;</div>
              </td>
	        </tr>
		    <tr>
		      <td height="10" colspan="4"></td>
	        </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td>&nbsp;</td>
		      <td colspan="2"><input name="oks"  type="submit" value="确  定"  alt="确  定" /></td>
	        </tr>
		    <tr>
		      <td height="50" colspan="4">&nbsp;</td>
	        </tr>
            </form>
	      </table>
 <!--问题为空end-->
 
 
<?php
 }
?>     
      
      
        
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
