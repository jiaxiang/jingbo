<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-帐户提款</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" /><?php
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
	$('#tq_money').click(function(){
		money=parseInt($('input[name=money]').val());
		max_draw = <?php echo  $draw_money;?>;	
		max_draw_money = <?php echo $max_draw_money;?>;	
		
		var repost1= /^[0-9]{1,10}$/;
		ok1=repost1.test(money);
		if(ok1){
			$('#identity_card_txt').html('');	
		}else{
			$('#identity_card_txt').html('提取金额只能点写数字');	
			return false;
		}
		if(money > max_draw){
			$('#identity_card_txt').html('提取金额不能大于当前可提现金额');
			return false;
		}
		else if(money > max_draw_money)
		{
			$('#identity_card_txt').html('大额提现请联络客服人员');	
			return false;
		}
		else
		{
			$('#identity_card_txt').html('');
		}
		
		password = $('#password').val();
		if (password == '')
		{
			$('#password_txt').html('提现密码不能为空');
			return false;
		}
		else
		{
			$('#password_txt').html('');		
		}

		len=$("#form1 :radio:checked").length;
		if(len<1){
			$('#bank_name_txt').html('必须选择一个银行');
			return false;  	
		}
		else
		{
			$('#bank_name_txt').html('');	
		}
		return true;
	})
})
</script>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">资金管理</a></span> &gt;&gt; 帐户提款</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">	
<?php echo View::factory('user/left')->render();?>
<div class="member_right fl">
<div class="fl" style="position:relative">
 <?php echo View::factory('user/user_header')->render();?>

<div class="paly_pop_ok">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="javascript:void(0)">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px;">
        	<strong> 提现申请成功，请等待！</strong>
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<span class="xg_gg_bf fhxgai">继续提现</span>
				<a class="xg_gg_bf qrxgaia" href="/user/atm_records">提现记录</a>
            </div>
	    </div>
   </div>
</div>

<?php
if (!empty($notices))
{
?>
<div class="recharge_box fl" style="top:150px; left:80px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:200px;">
			首次提现，您需要满足如下条件需要满足如下条件：<br /><br />
			1、完善的个人资料--录入姓名和身份证  <?php if($notices['set_identity_card']) {?><font color=green>已完成</font><?php }else{?> <font color="red">未完成</font>， <a href="/user/user_auth">现在就去填写>></a><?php }?> 	<br />
			2、设置完提现密码--提现操作都需要此密码 <?php if($notices['set_drawpassword']) {?><font color=green>已完成</font><?php }else{?> <font color="red">未完成</font>， <a href="/user/withdrawals_password">现在就去填写>></a><?php }?>	<br />
			3、设置好取款信息--银行帐号 <?php if($notices['set_bank']) {?><font color=green>已完成</font><?php }else{?><font color="red">未完成</font>， <a href="/user/withdrawals_info">现在就去填写>></a><?php }?>	<br />
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
	
            </div>
	    </div>
   </div>
</div>
<?php
}
?>

<?php
if ($msgnotice['showmsg'])
{
?>

<?php
if ($msgnotice['confirm'])
{
?>
<div class="paly_pop_redirect" style="top:0px; left:120px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="/user/withdrawals">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:60px;">
			<?php echo $msgnotice['msg'];?>
            <form id="form2" name="form2" method="post" action="">
            <input name="money" type="hidden" value="<?php echo $msgnotice['money'];?>" />
            <input name="password" type="hidden" value="<?php echo $msgnotice['password'];?>" />
            <input name="bank_name" type="hidden" value="<?php echo $msgnotice['bank_id'];?>" />
            <input name="agreesubmit" type="hidden" value="true" />
            </form>
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="#" onclick="javascript:document.form2.submit();">仍然提现</a>
                <A class="xg_gg_bf fhxgai" href="/user/withdrawals">取消提现</a>
            </div>
	    </div>
   </div>
</div>
<?php
}
else
{
?>

<div class="paly_pop_redirect" style="top:0px; left:120px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="<?php echo $msgnotice['url'];?>">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:50px;">
			<?php echo $msgnotice['msg'];?>
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="<?php echo $msgnotice['url'];?>">确认</a>
            </div>
	    </div>
   </div>
</div>
<?php
	}
}
?>

<?php
if ($draw_money <= 0)
{
?>

<div class="paly_pop_redirect" style="top:0px; left:120px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="/user/">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:50px;">
			您目前没有可提款的金额!
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="/user/">确认</a>
            </div>
	    </div>
   </div>
</div>

<?php
}
?>



<?php
/**
if(!$set_bank)
{
?>
<div class="paly_pop_redirect" style="top:0px; left:120px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="/user/withdrawals_info">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:50px;">
			必须先设置取款信息才可以进行此操作!
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="/user/withdrawals_info">确认</a>
            </div>
	    </div>
   </div>
</div>
<?php
}
elseif ($user_day_count >= $max_day_draw_count)
{
?>

<div class="paly_pop_redirect" style="top:0px; left:120px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="/user/atm_records">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:50px;">
			您今日提款已达到最多次数,请改日再申请!
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="/user/atm_records">确认</a>
            </div>
	    </div>
   </div>
</div>

<?php
}
elseif ($draw_money <= 0)
{
?>

<div class="paly_pop_redirect" style="top:0px; left:120px;display:block;">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>温馨提示</h2>
            <span class="close"><a href="/user/">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto; line-height:30px; height:50px;">
			您目前没有可提款的金额!
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="/user/">确认</a>
            </div>
	    </div>
   </div>
</div>

<?php
}
elseif (empty($_user['draw_password']))
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
			您还没有设置提款密码，请先设置提款密码!
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
				<A class="xg_gg_bf fhxgai" href="/user/withdrawals_password">确认</a>
            </div>
	    </div>
   </div>
</div>
<?php
}
**/
?>



  <div id="member_tit" class="fl mt5">
		<ul>
       	    <li class="hover">帐户提款</li>
      </ul>
    </div>
</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fl" style="border: solid 1px #c5ddf5; border-top:0">
          <tr>
            <td width="4%" height="33" align="left" valign="middle" bgcolor="#e8f2ff">&nbsp;</td>
            <td width="96%" height="22" align="left" valign="middle" bgcolor="#e8f2ff">温馨提示：<br />
1,金额超过<?php echo $max_draw_money;?>元, 请联系客服；<br />
2,每日最多可以提现<?php echo $max_day_draw_count;?>次；<br />
3,<font color="#FF0000">您的提款账户开户姓名必须和真实姓名一致，否则将会被取消提款；</font><br />
4,<font color="#FF0000">针对累计消费金额（购买彩票成功的累计数）小于累计存入金额（不包含奖金）30%的账户提款申请，将加收10%的异常提款处理费用，同时提款到账日自提出申请之日起，不得少于15天；</font> 
            </td>
          </tr>
          <tr>
            <td height="1" colspan="2" align="left" valign="middle" bgcolor="#ffffff"></td>
          </tr>
    </table>
		<div class="recharge_box fl"> <form id="form1" name="form1" method="post" action="">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		        <tr>
		          <td width="16%" height="30" align="right" valign="middle">
                  实际可取金额：</td>
		          <td width="28%" height="30" align="left" valign="middle">&nbsp;<?php  echo $draw_money;?>  元</td>
	              <td align="left" valign="middle" id="real_name_txt" style="color:#FF0000">

<?php
if ($is_show_ratio_notice)
{
	//echo '注意：针对累计消费金额（购买彩票成功的累计数）小于累计存入金额（不包含奖金）30%的账户提款申请，竞波网将加收10%的异常提款处理费用，同时提款到账日自提出申请之日起，不得少于15天；<br />您的比率小于30%';
}
?>                  

                  </td>
		        </tr>
                
		        <tr>
		            <td height="30" align="right" valign="middle">提现金额：</td>
		            <td height="30" align="left" valign="middle"><input name="money" type="text"  class="huiyuan_text_box" id="money" maxlength="10" /> 元</td>
		            <td align="left" valign="middle" id='identity_card_txt' style="color:#FF0000">
                    <?php
                    if ($draw_money < $min_draw_money)
					{
						echo '您的可提款金额小于'.$limit_money.'元, 若需清户,请一次性提取所有剩余金额!<br /> ';	
					}

					?>
                    </td>
		        </tr>
                

		        <tr>
		            <td height="30" align="right" valign="middle">取款密码：</td>
		            <td height="30" align="left" valign="middle"><input name="password" type="password"  class="huiyuan_text_box" id="password" maxlength="20" /></td>
		            <td align="left" valign="middle" id='password_txt' style="color:#FF0000">&nbsp;</td>
		        </tr>
                
                
		        <tr>
		            <td height="30" align="right" valign="middle">选择帐号：</td>
		            <td height="100" align="left" valign="middle">
                    <?php 
						foreach ($banks as $rowbank)
						{  
							print form::radio(array('id'=>'bank_name_'.$rowbank['id'], 'name'=>'bank_name'), $rowbank['id'], $rowbank['default']);
							print form::label('bank_name_'.$rowbank['id'], $bankinfo[$rowbank['bank_name']].$rowbank['account']).'<br />';
						}
					?>
                    </td>
		            <td align="left" valign="middle" id='bank_name_txt' style="color:#FF0000">&nbsp;</td>
		        </tr>                
                
                
		        <tr>
		          <td height="15" colspan="3" align="right" valign="middle"></td> 
		        </tr>
		        <tr>
		          <td align="right" valign="middle">&nbsp;</td>
		          <td colspan="2"><input  type="submit"  alt="提款" value="申请提款" class="btn_c_org_p" id="tq_money"/></td>
                </tr>

		    <tr>
		      <td>&nbsp;</td>
		      <td >&nbsp;</td>
	          <td >&nbsp;</td>
		    </tr>
		    <tr>
		      <td>&nbsp;</td>
		      <td colspan="2" >提款处理需知：（周一至周六处理提款，除法定节日；如果帐户资金低于10元，仍需提款，请一次性提清）<br/>
16点前申请提款：当工作日处理　16点后申请提款：次工作日处理</td>
            </tr>
	      </table>
		 </form>
	</div>
    
    
<?php echo View::factory('user/withdrawals_notice')->render();?>  

  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--copyright_end-->
</body>
</html>
