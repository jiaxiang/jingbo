<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-充值送彩金活动</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/jquery',
	'media/js/jquery.validate',
    'media/js/hdm',
	'media/js/tk',
	'media/js/validate_card',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
	'media/css/alert.css',
	'media/css/validate.css',
    'media/css/public.css',
	'media/css/extension',
	'media/css/szc',
	'media/css/mask',
	
), FALSE);
?>
<script>
$(function(){
		shj= /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/;
		$('#sent_phone').click(function(){
			if(!shj.test($("#mobile").val())){
				$('.paly_pop_ok').show();
				$('.pop_ts_title').html('请填写正确的手机号码');
				return false;
			}
			$("#yzlist").html('<input  type="button"  value="发送验证码" alt="0" class="xg_gg_bf fhxgai" style="margin:0px;"/>');
				var data=new Array();
				data['mobile'] = $("#mobile").val();
				$("#shoujinum").val(data['mobile']);
				$.ajax({
				  url: '/user/send_sms/'+data['mobile'],
				  success: function(data){
					$('input[name=shoujiyz]').val(data);
					// alert(data);
				  }
				});	
			})
		
		//表单验证
		$('.up_tis').css({"width":"150px"});
		$('input[name=oks]').click(function(){
			
			$('.suc_def').removeClass().addClass('suc_def pop_cw')
			//姓名验证
			real_name=$('input[name=real_name]').val();
			rename= /^[\u4E00-\u9FA5\uf900-\ufa2d\w]{2,4}$/;
			if(!rename.test(real_name)){
				$('.paly_pop_ok').show();
				$('.pop_ts_title').html('请填写您的真实姓名');
				return false;
			}
			//身份证验证
			//sfzhm= /^[0-9]{17}[xX]{1}$/;
			identity_card=$('input[name=identity_card]').val();
			
			var isok=IdCardValidate(identity_card);
			
			if(!isok){
				$('.paly_pop_ok').show();
				$('.pop_ts_title').html('请正确填写身份证号码');
				return false;
			}
			//手机验证
			//shj= /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/;
			mobile=$("#mobile").val();
			if(!shj.test(mobile)){
				$('.paly_pop_ok').show();
				$('.pop_ts_title').html('请填写正确的手机号码');
				return false;
			}
			//手机验证码
			code=$("#code").val();
			shoujiyz=$("#shoujiyz").val();
			shoujinum=$("#shoujinum").val();
			mobile=$("#mobile").val();
			if(code==''){
				$('.paly_pop_ok').show();
				$('.pop_ts_title').html('请输入您的手机验证码');
				return false;
			}
			if(mobile!= shoujinum){
				$('.paly_pop_ok').show();
				$('.pop_ts_title').html('发送验证码后请不要修改手机号码');
				return false;
			}
			document.myformname.submit;
		})

})


</script>
</head>
<body>
<?php //d($action_open);?>
<!--top小目录--><?php
echo View::factory ( 'header' )->render ();
?>
<!--menu和列表_end-->
<div class="width line36">您所在的位置：<span class="blue"><a href="<?php echo url::base ();?>">首页</a></span> &gt;&gt; <span class="blue"><a href="<?php echo url::base ();?>user">会员中心</a></span> &gt;&gt; <span class="blue">个人信息管理</span>
&gt;&gt; 修改个人资料</div>
<!--注册-->
<div class="width">
<div id="huodong" class="fl mt5">
<p><img src="<?php echo url::base();?>media/images/home_03.jpg" width="986" height="80" /></p>
<div id="hd_ts" class="fl" style="position:relative;">
<?php
if ( $action_open == 0 )
{
?>   
      <div id="hd_tsbg" class="fl  red">
                      <p>彩金活动已经关闭!</p>
                  </div>
      </div>

<?php
}
elseif($action_open == 1)
{
?>  
    <div id="hd_tsbg" class="fl  red">
                    <p>彩金活动已经过期!</p>
                </div>
    </div>  

<?php
}
elseif($action_open == 2)
{
?>  
      <div id="hd_tsbg" class="fl  red">
                      <p>你已经领取过彩金，请勿重复领取彩金！</p>
                  </div>
      </div> 
      
<?php
}
elseif($action_open == 3)
{
?>  
      <div id="hd_tsbg" class="fl  red">
                      <p>需充值50元就可免费领取100元彩金！马上去<a href="<?php echo url::base();?>user/recharge" style="color:#00F; font-size:18px;">激活</a>哦！</p>
                  </div>
      </div> 

<?php
}
elseif($action_open == 4)
{
?>  
<div id="hd_tsbg" class="fl  red">
            	<p>你已经领取过彩金，请勿重复领取彩金！</p>
            </div>
</div> 

<?php
}
elseif($action_open == 5)
{
?>  
<div id="hd_tsbg" class="fl  red">
            	<p>你已经领取过彩金，请勿重复领取彩金！</p>
            </div>
</div> 

<?php
}
elseif($action_open == 6)
{
?>  
<div id="hd_tsbg" class="fl  red">
            	<p>你已经领取过彩金，请勿重复领取彩金！</p>
            </div>
</div>

<?php
}
elseif($action_open == 7)
{
?>  
<div id="hd_tsbg" class="fl  red">
            	<p>你已经领取过彩金，请勿重复领取彩金！</p>
            </div>
</div>

<?php
}
elseif($action_open == 8)
{
?>  
<div id="hd_tsbg" class="fl  red">
            	<p>你已经领取过彩金，请勿重复领取彩金！</p>
            </div>
</div>

<?php
}
elseif($action_open == 9)
{
?>  
<div id="hd_tsbg" class="fl  red">
            	<p>你已经领取过彩金，请勿重复领取彩金！<?php echo $data['password'];?></p>
            </div>
</div>

<?php
}
elseif($action_open == 10)
{
?>  
<div id="hd_tsbg" class="fl  red">
            	<p>你的资料在审核中，审核通过后彩金会自动到账，请耐心等待！<?php echo $data['password'];?></p>
            </div>
</div>
<?php
}
elseif($action_open == -2)
{
?>
<div id="hd_tsbg" class="fl  red">
<p>请先进行身份实名认证！<a href="<?php echo url::base();?>user/user_auth" style="color:#00F; font-size:18px;">马上去认证</a></p>
</div>
</div>
<?php 
}
else{
?>  
  <?php //充值弹出窗口?>
<div class="paly_pop_ok" style=" left:300px;top:100px;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="javascript:void(0)">关闭</a></span>
            </div>
               <div class="tips_text" style="overflow-y:auto; line-height:30px;">
           			<span class="suc_def pop_cw"></span>
					<span class="pop_ts_title">232323</span>
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px; padding-left:150px;">
				<span class="xg_gg_bf fhxgai">关闭</span>
            </div>
	    </div>
   </div>
</div>


  	<div id="hd_tsbg" class="fl  red">
            	<p>1、请填写真实的姓名和身份证信息，提款身份证需与此一致！</p>
                <p>2、请填写正确的手机和邮件地址，只有通过实名验证才能领取彩金！</p>
                <!-- p>3、5元激活彩金领取将于9月17日中午12点前截止，广大彩民踊跃注册！</p-->
                <p>注：一人仅限领取一次彩金！</p>
            </div>
      </div>
      
      
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl">
      <form name="myformname" action="/user/check_mobi_email" method="post">
  <tr>
    <td width="39%" height="44">&nbsp;</td>
    <td width="0%"></td>
    <td width="27%" style="color:blue; font-size:14px; font-family:Verdana, Geneva, sans-serif;"><div class="up_tis" style="display:none" id="mobile_err">&nbsp;</div><label><?php print $_notice; ?></label></td>
    <td width="34%">&nbsp;</td>
  </tr>
  <?php if(!empty($notice)):?>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td></td>
    <td height="30" valign="middle" class="graybc"><?php echo $notice;?></td>
    <td></td>
  </tr>
  <?php endif;?>
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">您的姓名：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" valign="middle">
    <?php if(!empty($user['real_name'])){?>
    <label><?php print $user['real_name'];?></label>
    <input type="hidden" name="real_name" id="real_name"  value="<?php print $user['real_name'];?>"/>
    <?php }else{?>
    <input type="text" name="real_name" id="real_name" class="up_text"  value=""/>
    <?php }?>
    </td>
    <td height="26" valign="middle"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="30" valign="middle" class="graybc">您的真实姓名，例如：张三</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">身份证号码：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" valign="middle">
    <?php if(!empty($user['identity_card'])){?>
   <?php print $user['identity_card'];?>
    <input type="hidden" name="identity_card" id="identity_card"  value="<?php print $user['identity_card'];?>"/>
    <?php }else{?>
    <input type="text" name="identity_card" id="identity_card" class="up_text" />
     <?php }?>
    </td>
    <td height="26" valign="middle"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td></td>
    <td height="30" valign="middle" class="graybc">请填写正确的身份证号码，否则将不能提款！</td>
    <td><input type="hidden" name="shoujiyz" id="shoujiyz" value="" /></td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">手机号码：</span></td>
    <td height="26" valign="middle"></td>
    <td height="26" valign="middle"><input type="text" name="mobile" id="mobile" class="up_text fl" style="width:160px;" value="<?php if(!empty($user['mobile'])){print $user['mobile'];}?>"/>
    <input type="text" name="code" id="code" class="up_text fl" style="width:80px; margin-left:10px;" /></td>
    <td height="26" valign="middle" id="yzlist"><input  type="button"  value="发送验证码" id="sent_phone" alt="0" class="xg_gg_bf fhxgai" style="margin:0px;"/>  
    </td>
    <td height="26" valign="middle"></td>
  </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="30" valign="middle" class="graybc" >手机号码!如果未收到短信,请刷新页面重新验证!</td>
    <td><input type="hidden" name="shoujinum" id="shoujinum" value="" /></td>
  </tr>
  <tr>
    <td height="26" align="right" valign="middle" class="font14"><span class="red">*</span><span class="black pl10">邮件地址：</span></td>
    <td height="26" valign="middle">&nbsp;</td>
    <td height="26" valign="middle"><?php print $user['email'];?><input type="hidden" name="email" id="email" value="<?php echo $user['email'];?>"></td>
    <td height="26" valign="middle">&nbsp;</td>
  </tr>
 <tr>
   <td align="right" valign="middle">&nbsp;</td>
   <td>&nbsp;</td>
   <td height="30" valign="middle" class="graybc">您的邮箱，将不会被公开</td>
   <td>&nbsp;</td>
 </tr>
  <tr>
    <td height="5" colspan="4" align="right" valign="middle"></td>
    </tr>
  <tr>
    <td align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td>
    <input  type="submit"  alt="验  证" value="马上验证" name="oks" class="btn_c_org_p" />
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="31" align="right" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
    <td height="50" align="left" valign="middle">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </form>
  </table>
  
  <?php }?>
 	</div>
</div>
<!--注册-->
<!--copyright-->
<span class="zhangkai"></span>
<?php
echo View::factory ( 'footer' )->render ();
?>
<!--copyright_end-->
</body>
</html>