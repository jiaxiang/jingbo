<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-会员中心-充值</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" /><?php
echo html::script(array
(
 	'media/js/jquery-1.4.2.min.js',
    'media/js/hdm',
	'media/js/jquery.validate',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/style',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/szc',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/mask',
), FALSE);
?>
</head>
<body>
<!--top小目录-->
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36">您所在的位置：<span class="blue"><a href="/">首页</a></span> &gt;&gt; <span class="blue"><a href="/user">会员中心</a></span> &gt;&gt; <span class="blue"><a href="#">资金管理</a></span> &gt;&gt; 充值</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width">
<?php echo View::factory('user/left')->render();?>  
  <div class="member_right fl">
   <?php echo View::factory('user/user_header')->render();?>
<div id="recharge" class="fl mt5">
      <ul>
        <li class="hover" id="two1" onclick="setTab('two',1,2)">网上支付</li>
        <li id="two2" onclick="setTab('two',2,2)" >银行转账</li>
      </ul>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#check_out").validate();
		
		$("input[name=subclassa]").click(function(){
			var name = $('input[name=price]').val();
			if(name == '存入金额至少5元'){
				$('#recharge_paly_txt').html('请填写充值金额');
				return false;
				}
			if(name < 5){
				$('#recharge_paly_txt').html('存入金额至少5元');
				//return false;
			}
			$('.paly_pop_ok').show();
		})
		
		$(".close").click(function(){
				$('.paly_pop_ok').hide();
				$('input[name=price]').val('存入金额至少5元');
		})
		$(".btn_q_org_p").click(function(){
				$('.paly_pop_ok').hide();
		})
		
	});
</script>
<form id='check_out' name='check_out' method="post"  action="/payment/alipay_to" target="_blank">        
<div id="con_two_1" class="recharge_box fl" style="position:relative;">
<?php //充值弹出窗口?>
<div class="paly_pop_ok">
	<div class="tips_b">
        <div class="tips_box">
            <div class="tips_title">
            <h2>充值遇到问题？</h2>
            <span class="close"><a href="javascript:void(0)">关闭</a></span>
            </div>
            <div class="tips_text" style="overflow-y:auto">
           
				充值完成前请不要关闭窗口。完成充值后请根据你的情况点击下面的按钮： <strong>请在新开网上储蓄卡页面完成付款后再选择。</strong>	
			
		    </div>
		    <div class="tips_sbt" style="overflow-y:auto; padding-left:30px;">
			<span class="btn_c_org_p" onclick="parent.document.location = '/user/recharge_records'">我已完成充值</span>
			<span class="btn_q_org_p">选择其他银行充值</span>
            </div>
	    </div>
   </div>
</div>
      <p class="font14 pl15">充值金额：（若需大额充值，请使用专业版网上银行。以免遇到由于网银金额限制而充值失败。）</p>
      <p class="pl15">
        <input type="text" name="price" id="price" class="up_text fl required" maxlength="10"  style="width:200px;" onkeyup="this.value=this.value.replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1');" onfocus="this.value='';" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1'));" value="存入金额至少5元"/>
        <span class="fl" id="recharge_paly_txt" style="padding:0 5px; color:#FF0000;"></span><span class="fl up_tis">充值金额格式错误！ 请输入充值金额！</span>
      </p>
      <br />
      <br />
      <p class="pl15 red">小提示：网上银行已经扣款，但账户余额没有增加？<br />答：这是因为银行的数据没有即时传输给我们，我们会在第二个工作日与银行对账后给予确认，请再耐心等待一下哦。</p>
      <span class="zhangkai"></span>
      <div class="fl cz_bank">
        <p class="font14 bold">选择付款方式</p>
        <table width="100%" border="0" cellspacing="5" cellpadding="0">
          
        <?php
		$i = 0;
        foreach ($pay_banks as $key => $row)
		{
			$i++;
			if ($i % 5 == 1)
			{
				echo '<tr>';
			}
			
			$checked = '';
			if ($i == 1)
			{
				$checked = 'checked="checked"';
			}
			
			echo '<td height="45" width="20%" align="left" valign="middle" >';
			echo '<input type="radio" name="payment_id" id="payment_'.$key.'" value="'.$key.'" '.$checked.' />';
			echo '<label for="payment_'.$key.'"><img src="'.url::base().'media/images/banks/'.$key.'.jpg" title="'.$row.'" alt="'.$row.'" /></label>';
			echo '</td>';
			
			if ($i % 5 == 0)
			{
				echo '</tr>';
			}			
		}
		?>            
          
        </table>
      </div>
      <span class="zhangkai"></span>
      <div class="fl cz_bank tc" style="border-top:dashed 1px #ccc; margin-top:30px;"> 
	
        <input name="subclassa"  type="image" src="<?php echo url::base();?>media/images/zhuf_btn.gif" width="119" height="47" style="cursor:pointer" /></div>
      <div class="fl cz_bank">
      
      
      	<p><span class="font12">·</span>如遇到网上银行限额问题，<a href="http://help.alipay.com/lab/help_detail.htm?help_id=211661&amp;keyword=%D6%A7%B8%B6%CF%DE%B6%EE" target="_blank"><u>请参考此表</u></a>，如有大额支付需求建议使用各大银行专业版（U盾）</p>
        <p><span class="font12">·</span>支持中国工商银行、中国建设银行、中国农业银行、招商银行等九家银行（立刻开通网上支付）</p>
        <p><span class="font12">·</span>查看（支付宝充值帮助）</p>
        <p><span class="font12">·</span>支付宝在线客服（我要提问）</p>
        <p><span class="font12">·</span><span class="red">7*24小时</span> 支付宝客服电话：<span class="red">021-61176880</span></p>
        <p><span class="font12">·</span><span class="red">重要提醒：</span></p>
        <p style="padding-left:10px;"> 1、请务必通过网上的“支付宝按钮”付款，支付宝账户内“直接付款”不能即时充值！<br/>
          2、可免费注册支付宝账户（点击注册）、使用支付宝数字证书，更方便您进行充值和中奖后快速取款。<br/>
          安全又方便,手续费全免</p>
      </div>
    </div>    
</form>    

    
    <div id="con_two_2" class="recharge_box fl" style="display:none;">
      <div class="fl">
        <p class="font14 bold">支持以下银行在线充值</p>
        1.中国建设银行上海曹家渡支行<br />
账号：31001540700050011683<br />
户名：上海竞搏信息科技有限公司 &nbsp;(注意: 竞争的"竞", 搏斗的"搏",提手旁)<br /><br />

2.中国银行上海市普陀支行 <br />
账号：448159757604<br />
户名：上海竞搏信息科技有限公司 &nbsp;(注意: 竞争的"竞", 搏斗的"搏",提手旁)<br />
<br />
3.交通银行上海长寿路支行<br />
账号：310066467018010023391<br />
户名：上海竞搏信息科技有限公司&nbsp;(注意: 竞争的"竞", 搏斗的"搏",提手旁)<br />
<br />
4.中国工商银行上海曹家渡支行<br />
账号：1001261819296978747<br />
户名：上海竞搏信息科技有限公司&nbsp;(注意: 竞争的"竞", 搏斗的"搏",提手旁)<br />
<br />

客服电话:021-61176880转9008 联系人:盛小姐<br />
注意:<br />
您如果采用的是非网上支付方式，为便于用户能及时到帐请将汇款后的汇款单尽快传真给我们。<br />
并在传真后与我们客服联系(7*24H)。<br />
客服电话: 021-61176880<br />
      </div>
    </div>
  </div>
</div>
<!--content1_end-->
<!--copyright-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
</body>
</html>
