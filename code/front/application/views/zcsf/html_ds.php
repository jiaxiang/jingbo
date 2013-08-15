<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足彩胜负-单式上传</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/yclass',
 	'media/js/loginer',	
 	'media/js/choose_zc',	
 	'media/js/zcds.js',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
 	'media/css/style',
	'media/css/mask',
	'media/css/css1',		
), FALSE);
?>
</head>
<body>
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>zcsf/sfc_14c"><font class="blue">足彩胜负</font></a> &gt; 单式上传
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width jingcai_box ">
	<div class="fl" id="jingcai_top">
    	<span class="fl" id="jctop_left"><img src="<?php echo url::base();?>media/images/zcsf.gif" width="76" height="63" /></span>

        <div class="fl" id="jctop_right">
       	     <dl class="b-top-info">
				<dt><span id="expect_tab">
                
                <?php foreach($expect_data['expects'] as $value) { if ($value==$expect_data['expect_num']) {?>
                    <a data-val="<?php echo $value;?>"<?php if ($value==$cur_expect) {?> class="on"<?php } ?> title="" href="/zcsf/sfc_<?php echo $expect_data['expect_type'];?>c/<?php echo $value;?>">当前期<?php echo $value;?>期</a>|
				<?php }else{ ?>    
                    <a data-val="<?php echo $value;?>"<?php if ($value==$cur_expect) {?> class="on"<?php } ?> title="" href="/zcsf/sfc_<?php echo $expect_data['expect_type'];?>c/<?php echo $value;?>/2">预售期<?php echo $value;?>期</a>|
				<?php }} ?>                
                			
				</span><span>单注最高奖金<b class="red">5,000,000</b>元<b class="kj"></b></span></dt>
			</dl>
      <div id="jc_menu" class="font14 bold">
            	<ul>
                	<li<?php if($expect_data['expect_type']==14){?> class="hover"<?php }?>><a href="/zcsf/sfc_14c/<?php echo $cur_expect;?>"><span>十四场胜负彩</span></a></li>
                    <li<?php if($expect_data['expect_type']==4){?> class="hover"<?php }?>><a href="/zcsf/sfc_4c/<?php echo $cur_expect;?>"><span>进球彩</span></a></li>
				    <li<?php if($expect_data['expect_type']==9){?> class="hover"<?php }?>><a href="/zcsf/sfc_9c/<?php echo $cur_expect;?>"><span>九场胜负彩</span></a></li>
       				<li<?php if($expect_data['expect_type']==6){?> class="hover"<?php }?>><a href="/zcsf/sfc_6c/<?php echo $cur_expect;?>"><span>六场半全</span></a></li>                                           
                    <li><a href="/zcsf/mycase_<?php echo $expect_data['expect_type'];?>c"><span>我的方案</span></a></li>
                </ul>
          </div>
        </div>
    </div>
     <div id="jingcai_bottom" class="fl"> 
	     <div class="dc_l">
		     <a href="<?php echo url::base();?>zcsf/sfc_<?php echo $expect_data['expect_type'];?>c/<?php echo $cur_expect;?>" title="普通投注" ><em>普通投注</em><s></s></a>
			 <a href="<?php echo url::base();?>zcsf/sfc_<?php echo $expect_data['expect_type'];?>c_ds/<?php echo $cur_expect;?>" title="单式投注" class="on"><em>单式投注</em><s></s></a>
		 </div>
	     <span class="fr pt5 gray6 mr10">截止时间：<?php echo $time_arr[2];?> 还剩 <?php echo $time_arr[3];?>天<?php echo $time_arr[4];?>小时</span></div>
    <span class="zhangkai"></span>	
</div>
<!--content1 end-->
<!--header end-->
<div id="bd">
  <div id="main">
    <div class="box_top">
      <div class="box_top_l"></div>
    </div>
    <div class="box_m">
      <div id="xx1">
        <table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td class="td_title p_tb8">方案金额</td>
              <td class="td_content p_tb8"><p><span class="hide_sp"></span><span class="align_sp">发起方案</span>
                  <input maxlength="6" name="" class="amount" value="5" id="dsInput" type="text">
                  注，共<span class="red">￥<span id="dsMoney">10</span>.00</span> 元<span class="tips_sp" id="moneyError" style="display:none">单倍金额必须是2的倍数！</span></p></td>
            </tr>
            <tr>
<?php
if($cur_expect!=$expect_data['expects'][0] && strtotime($expect_list[0]['start_time'])>time()) {
	$sh = true;
}
else {
	$sh = false;
} 
//var_dump($sh);
?>
              <td class="td_title">上传方案</td>
              <td class="td_content"><form name="project_form" id="suc_form" action="/zcsf/submit_buy" method="post" enctype="multipart/form-data">
                  <p><span class="hide_sp"></span>
                    <label class="m_r25 cur_lab" for="sc1">
                    <input class="m_r3" id="sc1" name="sc" type="radio" <?php if($sh == false) echo 'checked="checked"'; else echo 'disabled="true"';?> />
                    现在上传</label>
                    <label class="m_r25" for="sc2">
                    <input class="m_r3" id="sc2" name="sc" type="radio" <?php if($sh == true) echo 'checked="checked"';?> />
                    稍后上传</label>
                  </p>
                  <p><span class="hide_sp"></span>
                    <input <?php if ($sh == true) echo 'disabled="disabled"';?> name="upfile" class="upfile" id="upfile" type="file">
                    <a href="javascript:void%200" onclick="Y.openUrl('/doc/webdoc/upload_<?php echo $expect_data['expect_type'];?>c',530,550)">查看标准格式样本</a> <span class="gray">上传时间：2011-08-02 14:29:53</span></p>
                  <p class="upfile_sm"><b class="i-tp"></b>上传说明：<br>
                    <span class="red">1、上传的方案注数必须跟填写的一致，否则可能无法出票。</span><br>
                    2、请严格参照"标准格式样本"格式上传方案，否则网站不保证为您做过关统计以及历史战绩统计。<br>
                    3、文件格式必须是文本文件。<br>
                    4、由于上传的文件较大，会导致上传时间及在本页停留时间较长，请耐心等待。</p>
                </form></td>
            </tr>
          </tbody>
        </table>
        <div class="buy_sort" id="all_form"> <span class="title">购买形式</span> <span class="sort">

<?php 
	if($sh == true) { 
?>
           <label for="rd3" class="cur_lab" style="padding-right:15px;">
          <input name="radio_g2" id="rd3" value="1" class="rdo" type="radio" disabled="true">
          代购</label> 
<?php 
	}
	else {?>          
          <label for="rd3" class="cur_lab">
          <input name="radio_g2" id="rd3" value="1" class="rdo" type="radio"<?php if($sh == true) {echo 'disabled="true"';}?>>
          代购</label>  
<?php }?>                     
          <label class="b" for="rd4">
          <input checked="checked" name="radio_g2" id="rd4" value="0" class="rdo" type="radio">
          合买</label>
          </span> <em class="r i-qw" style="margin-top: 8px;"></em><span class="r gray">由多人共同出资购买彩票</span> </div>
        <div>
          <div id="dd1" style="display: none;">
            <table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr class="last_tr">
                  <td class="td_title">确认购买</td>
                  <td class="td_content"><div class="buy_info">
                      <!--<p><span class="hide_sp"></span>"<a href="javascript:void 0">esun_hejw</a>"，您的账户余额为<
span class="red eng">￥2.94</span>元．【<b class="i-jb"></b><a href="javascript:void 0">账户充值</a>】</p>-->
                      <p id="userMoneyInfo">您尚未登录，请先<a href="javascript:void%200" title="" onclick="Yobj.postMsg('msg_login')">登录</a></p>
                      <p>本次投注金额为<strong class="red eng" id="buyMoneySpan">￥10.00</strong>元<span class="if_buy_yue" style="display:none">， 购买后您的账户余额为 <strong class="red eng" id="buySYSpan">￥NaN</strong>元</span></p>
                      <p><span class="hide_sp">
                        <input checked="checked" id="agreement_dg" type="checkbox">
                        </span>我已阅读并同意《<a href="javascript:void%200" onclick="Y.openUrl('/doc/webdoc/gmxy',530,550)">用户合买代购协议</a>》</p>
                    </div>
                    <div class="buy_btn"> <!-- a href="javascript:void%200" class="btn_buy_m" title="立即购买" id="buy_dg">立即购买</a--> </div></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="dd2" style="display: block;">
            <table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                  <tr>
                    <td class="td_title">合买设置</td>
                    <td class="td_content">
                        <p><span class="hide_sp red eng">*</span><span class="align_sp">我要分为：</span><input name="" class="mul" type="text" id="fsInput" />份，  每份<span class="red eng" id="fsMoney">￥2.00</span>元  <span class="tips_sp" id="fsErr" style="display:none">！每份金额不能除尽，请重新填写份数</span></p>
                        <p><span class="hide_sp"></span><span class="align_sp">我要提成：</span><select name="" class="selt" id="tcSelect">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4" selected="selected">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        </select>% <s class="i-hp i-qw" data-help="<h5>关于提成</h5><p>提成比例设定为0%-8%之间，如果方案中奖又有盈利(税后奖金-合买方案总金额>0)，您就可以获得的税后奖金提成.提成金额=税后奖金×提成比例，方案不盈利将没有提成。</p><p>例如：合买方案总金额为10000元，税后奖金为20000元，提成比例为8%，20000*8%=1600元，最后您的提成金额是1600元。</p>"></s></p>
                        <p><span class="hide_sp"></span><span class="align_sp">是否公开：</span><label class="m_r25" for="gk1"><input type="radio" class="m_r3" checked="checked" id="gk1" name="gk" value="0">完全公开</label><label class="m_r25" for="gk2"><input type="radio" class="m_r3" id="gk2" name="gk" value="1">截止后公开</label><label class="m_r25" for="gk3"><input type="radio" class="m_r3" id="gk3" name="gk" value="2">仅对跟单用户公开</label></p>
                    </td>
                  </tr>
                <tr>
                  <td class="td_title">认购设置</td>
                  <td class="td_content"><div class="buy_btn"> <a href="javascript:void%200" class="btn_buy_hm" title="发起合买" id="buy_hm">发起合买</a> </div>
                    <!--<p><span class="hide_sp red eng">*</span>您尚未登录，请先<a href="javascript:void 0">登录</a></p>-->
                    <p><span class="hide_sp"></span><span id="userMoneyInfo2">您尚未登录，请先<a href="javascript:void%200" title="" onclick="Yobj.postMsg('msg_login')">登录</a></span></p>
                    <p><span class="hide_sp"></span><span class="align_sp">我要认购：</span>
                      <input name="" class="mul" id="rgInput" value="1" type="text">
                      份，<span class="red eng" id="rgMoney">￥1.00</span>元（<span id="rgScale">10.00%</span>）<span class="tips_sp" id="rgErr" style="display:none">！至少需要认购3份</span></p>
                    <p><span class="hide_sp">
                      <input name="isbaodi" id="isbaodi" type="checkbox">
                      </span><span class="align_sp">我要保底：</span>
                      <input name="" class="mul" value="0" disabled="disabled" id="bdInput" type="text">
                      份，<span class="red eng" id="bdMoney">￥0.00</span>元（<span id="bdScale">0.00%</span>）<s class="i-hp i-qw" data-help="&lt;h5&gt;什么是保底？&lt;/h5&gt;&lt;p&gt;发起人承诺合买截止后，如果方案还没有满员，发起人再投入先前承诺的金额以最大限度让方案成交。最低保底金额为方案总金额的20%。保底时，系统将暂时冻结保底资金，在合买截止时如果方案还未满员的话，系统将会用冻结的保底资金去认购方案。如果在合买截止前方案已经满员，系统会解冻保底资金。&lt;/p&gt;"></s> <span class="tips_sp" id="bdErr" style="display:none">！最低保底20%</span></p>
                    <p class="gray"><span class="hide_sp"></span>[注]冻结资金将在网站截止销售时，根据该方案的销售情况，&gt;
                      返还到您的预付款中。</p>
                    <p><span class="hide_sp">
                      <input checked="checked" id="agreement_hm" type="checkbox">
                      </span>我已阅读并同意《<a href="javascript:void%200" onclick="Y.openUrl('/doc/webdoc/gmxy',530,550)">用户合买代购协议</a>》</p></td>
                </tr>
                <tr>
                  <td class="td_ge_t">可选信息</td>
                  <td class="td_ge"><p class="ge_selt"><span class="hide_sp">
                      <input id="moreCheckbox" type="checkbox">
                      </span>方案宣传与合买对象</p>
                    <p style="width: 320px;" class="ge_tips">2011年6月30日起，网站暂停方案宣传内容的录入。</p></td>
                </tr>
                <tr id="case_ad" style="display: none;">
                  <td class="td_title">方案宣传</td>
                  <td class="td_content"><p><span class="hide_sp"></span><span class="align_sp">方案标题：</span>
                      <input maxlength="20" id="caseTitle" class="t_input" value="大奖神马都不是浮云，只要有你参与！" type="text">
                      <span class="gray">已输入8个字符，最多20个</span></p>
                    <p><span class="hide_sp"></span><span class="align_sp">方案描述：</span>
                      <textarea id="caseInfo" class="p_input">说点什么吧，让您的方案被更多彩民认可．．．</textarea>
                      <span class="gray">已输入0个字符，最多200个字符</span></p></td>
                </tr>
                <tr class="last_tr" id="hm_target" style="display: none;">
                  <td class="td_title">合买对象</td>
                  <td class="td_content"><p><span class="hide_sp"></span>
                      <label class="m_r25" for="dx1">
                      <input class="m_r3" checked="checked" id="dx1" name="zgdx" value="1" type="radio">
                      彩友可以合买</label>
                      <label class="m_r25" for="dx2">
                      <input class="m_r3" id="dx2" name="zgdx" value="2" type="radio">
                      只有固定的彩友可以合买</label>
                    </p>
                    <div style="display:none" id="fixobj">
                      <p><span class="hide_sp"></span><span class="align_sp"></span>
                        <textarea name="buyuser" class="p_input" rows="10" cols="10">最多输入500个字符</textarea>
                      </p>
                      <p><span class="hide_sp"></span><span class="gray">[注]限定彩友的格式是：aaaaa,bbbbb,ccccc,ddddd（,为英文状态下的逗号）</span></p>
                    </div></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <input name="lotid" id="lotid" value="1" type="hidden">
    
    <input name="playid" id="playid" value="4" type="hidden">


    <input name="ticket_type" id="ticket_type" value="2" type="hidden">
    <!--彩种Id-->
    <input name="play_method" id="play_method" value="<?php echo $play_method;?>" type="hidden">
    <!--玩法Id-->    
    <input name="expect" id="expect" value="<?php echo $cur_expect;?>" type="hidden">
    <!--期号-->
    <input name="end_time" id="end_time" value="<?php echo $time_arr[2];?>" type="hidden">
    <!--结束时间-->
    <input name="totalmoney" id="totalMoney" value="" type="hidden">
    <!--足彩购买总钱数-->
    <input name="isupload" id="isupload" value="1" type="hidden">
	<input name="is_select_code" id="is_select_code" value="0" type="hidden">    
    <input name="codes" id="codes" value="" type="hidden">
    <input name="usertype" id="usertype" value="0" type="hidden">
    <input name="isprocess" id="isprocess" value="<?php if($sh == true) {echo '0';}else{echo '1';}?>" type="hidden">
    <!--需要JS提供-->
    <input name="allnum" id="allnum" value="0" type="hidden">
    <!--注数-->
    <input name="isbaodi" id="isbaodi2" value="0" type="hidden">
    <!--注数-->
    <input name="baodinum" id="baodinum" value="0" type="hidden">
    <!--注数-->
    <input name="buynum" id="buynum" value="0" type="hidden">
    <!--提成比例-->
    <input name="tc_bili" id="tc_bili" value="0" type="hidden">
    <!--注数-->
    <input name="zhushu" id="zhushu" value="0" type="hidden">
    <!--注数-->
    <input name="beishu" id="beishu" value="1" type="hidden">
    <!--注数-->
    <input name="isset_buyuser" id="isset_buyuser" value="1" type="hidden">
    <!--招股对象 所有：1 部分：2-->
    <!--其他-->
    <input name="money_limit" id="money_limit" value="10.00,600000,," type="hidden">
    <!--金额限制 格式:最小金额,最大金额,加注最小金额,加注最大多金额(加注的只有大乐透有-->
    <input name="ishm" id="ishm" value="1" type="hidden">
  </div>
</div>

 <!--footer start-->
  <span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--footer end-->

<textarea id="responseJson" style="display: none;">{
	period :      "<?php echo $cur_expect;?>",   //期号
	serverTime :  "<?php echo date("Y-m-d H:m:s");?>",   //服务器时间
	endTime :     "<?php echo $time_arr[2];?>",    //截止时间
	singlePrice : 2,   //单注金额
	baseUrl : "<?php echo url::base();?>"  //网站根目录
}</textarea>

<?php echo View::factory('zcsf/public_div')->render();?>

</body>
</html>
