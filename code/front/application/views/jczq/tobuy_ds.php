<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-竞彩足球-让球胜平负-单式上传-购买交易区</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(   'media/js/yclass.js?v=20110509',
    'media/js/loginer',
	'media/js/detail',
	'media/js/jczq_buy_ds.js',
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
<div id="bd">
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>jczq/rqspf"><font class="blue">竞彩足球</font></a> &gt; 购买交易区
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
	<div id="main">
		<div class="box_top">
			<div class="box_top_l"></div>
		</div>

		<div class="box_m">
			<div class="an_title">
				<h2 class="f14">确认投注内容</h2>
			</div>
                    
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="buy_table">

			<tbody>
				<tr>
					<td class="td_title2">方案截止时间</td>
					<td class="con_content"><p><?php echo $time_end;?></p></td>
				</tr>

				<tr>
					<td class="td_title2">投注内容</td>

					<td class="con_content">
						<div class="clearfix">
						
<?php
$d_count = count($d);
$total_price = 0;
for ($i = 0; $i < $d_count; $i++) { 
?>
<div class="aff_l">
<div class="tdbback">
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="tablelay eng" id="buyTable">
<tbody>
<tr>
<th>赛事</th>
<th>对阵</th>
<?php
$play_method = $d[$i]['play_type'];
$typename = $d[$i]['typename'];
$rate = $d[$i]['rate'];
$allprice = $d[$i]['money'];
$total_price += $allprice;
if ($play_method == 1)
{
?>
<th>让球数</th>
<?php
}
?>
<th>您的选择</th>
<th class="last_th">胆码</th>

</tr>
<?php
$match_info = $d[$i]['match_info'];
for ($j = 0; $j < count($match_info); $j++) {
	$match_detail = $match_info[$j]['info'];
	$match_select = $match_info[$j]['result'];
?>
<tr class="tr1" mid="<?php echo $match_detail['id'];?>">
<td><?php echo $match_detail['match_info'];?></td>
<td><?php echo $match_detail['host_name'];?> VS <?php echo $match_detail['guest_name'];?></td>

<?php
if ($play_method == 1)
{
?>
<td><?php echo intval($match_detail['goalline']);?></td>
<?php
}
?>
<td style="width:200px;word-wrap: break-word;" ><?php echo $match_select;?></td>
<td class="last_td">×</td>
</tr>
<?
	}
?>
<tr class="last_tr">
<td colspan="5">
<span class="red" style="display:none">注：单关投注奖金以官方最终公布的奖金为准。</span>
<span class="red">注：过关投注奖金以方案最终出票时刻的奖金为准。</span>
</td>
</tr>
</tbody>
</table>
</div>
</div>

<div class="aff_r">
<div class="tdbback">
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablelay eng">
<tbody>
<tr>
<th class="last_th" colspan="2"></th>
</tr>
<tr class="tr1">
<td width="50%">过关方式</td>
<td class="last_td">倍数</td>
</tr>
<tr class="tr1">
<td><?php echo $typename;?></td>
<td class="last_td"><?php echo $rate;?></td>
</tr>
<tr class="last_tr">
<td colspan="2" class="last_td">
<p class="aff_zjr">
总金额：<span class="red">￥<?php echo $allprice;?></span> 元<br />
</p>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<?php
}
?>
</div>
</td>
</tr>
                
<!-----此处将会通过合买来判断---->
<tr>
<td class="td_title2">方案信息</td>
<td class="con_content">
<p>
方案注数<span class="eng red"><?php echo $d_count;?></span>注，总金额<span class="eng red">￥<?php echo $total_price;?></span> 元。
</p>
</td>
</tr>		      
<?php
if (!isset($is_hemai) || $is_hemai == 0) {
	if ($m == 'ok') {
?>                      
          <tr class="last_tr">
            <td class="td_title2">我要认购</td>
            <td class="con_content"><div class="buy_btn2 clearfix"> <a title="立即购买" class="btn_buy_m m-r" href="javascript:void%200" id="dobuy">立即购买</a> <a title="返回修改" class="btn_modifyFont" href="javascript:void%200" id="backedit" onclick="return false">返回修改&gt;&gt;</a> </div>
              <p class="read"> <span class="hide_sp">
                <input checked="checked" id="isagree" type="checkbox">
                </span>我已阅读并同意《<a href="javascript:void(0)" onclick="Y.openUrl('/doc/webdoc/gmxy',530,500)">用户合买代购协议</a>》 </p>
              <p><span class="hide_sp">
                <input checked="checked" id="isoverflow" type="checkbox">
                </span><span class="red">彩票发行中心对竞彩进行<a href="javascript:void%200" title="" class="blue" id="xianhao1" data-help="&lt;h5&gt;限号管理&lt;/h5&gt;&lt;p&gt;为了加强对“竞彩”的销售管理，在销售过程中，根据投注额、突发事件等因素，彩票管理中心销售系统可能会拒绝某些大额投注，或者暂停或提前截止某场比赛的某些特定过关组合、特定结果选项的投注，暂停或提前截止针对某场比赛的所有投注。此种情况下，网站对暂停或提前截止销售不承担任何责任。&lt;/p&gt;&lt;p&gt;&lt;b&gt;限号实例&lt;/b&gt;&lt;/p&gt;&lt;p&gt;官方限号内容：周三001 负 周三002 负 过关方式：2串1&lt;/p&gt;&lt;p&gt;如选择了包含该限号组合的方案，网站将对方案包含的特定组合做部分撤单返款处理。&lt;/p&gt;">限号管理</a>，我已阅读并同意网站<a href="javascript:void%200" class="blue" onclick="Y.openUrl('/doc/webdoc/jctzfxxz',530,500)">《竞彩投注风险须知》</a></span></p>
              <p></p></td>
          </tr>                      
                      
<?php
	}
	else {
?>
<tr class="last_tr">
<td class="td_title2">无法认购</td>
<td class="con_content"><p>原因：<?php echo $m;?> <a title="返回修改" class="btn_modifyFont" href="javascript:void%200" id="backedit" onclick="return false">返回修改&gt;&gt;</a></p>
<p></p></td>
</tr>     
<?php
	}
}
else
{
?>                      
 
                  
                      <div id="dd2" style="display:none;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="buy_table">

                          <tr>
                            <td class="td_title2">方案金额</td>
                            <td class="td_content">
                                <p><span class="hide_sp red eng"></span>￥<?php echo $allprice;?>元</p>
                            </td>
                          </tr>
                          <tr>
                            <td class="td_title2">购买形式</td>

                            <td class="td_content">
                                <p><span class="hide_sp red eng">*</span><span class="align_sp">我要分为：</span><input name="" class="mul" type="text" value="1" id="uFs" />份，  每份<span class="red eng" id="uFsM">￥2.00</span>元  <span class="gray">每份至少1元</span><span class="tips_sp" id="uFsE">！每份金额不能除尽，请重新填写份数</span></p>
                                <!--<p><span class="hide_sp"></span><span class="align_sp">我要提成：</span><select name="" class="selt"><option selected="selected">1</option><option>2</option><option>3</option><option>10</option></select>% <span class="i-hp i-qw"></span></p>-->
                                <p><span class="hide_sp"></span><span class="align_sp">我要提成：</span><select id="uTc">
                                    <option value="0">0</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4" selected>4</option>
                                </select>&nbsp;%&nbsp;<s class="i-qw" data-help="<h5>什么是提成？</h5><p>您在发起合买时，可以设置合买方案的提成(0%-4%)，如果方案中奖又有盈利(税后奖金-合买方案总金额>0)，您就可以获得的盈利提成。</p><p>合买方案在盈利的情况下，提成金额计算公式：(税后奖金-合买方案总金额)*提成比例=提成金额。</p><p>例如：合买方案总金额为1000，税后奖金为2000，提成比例为4%，(2000-1000)*4%=40元，最后您的提成金额是40元。</p>"></s></p>   
                            </td>
                          </tr>

                          <tr>
                            <td class="td_title2">认购设置</td>
                            <td class="td_content">
                                <div class="buy_btn2 fr">
                                   <a href="javascript:void 0" class="btn_buy_m m-r" title="立即购买" id="dobuy">立即购买</a><a href="javascript:void 0" class="btn_modifyFont" title="返回修改" id="backedit" onclick="return false">返回修改&gt;&gt;</a>
                                </div>
                                <p id="userMoneyInfo" style="padding-left:15px">您尚未登录，请先<a href="javascript:void 0" title="" onclick="Yobj.postMsg('msg_login')">登录</a>！</p>

                                <p><span class="hide_sp"></span><span class="align_sp">我要认购：</span><input name="" class="mul" type="text" value="1" id="uRg" />份，<span class="red eng" id="uRgM">￥0.00</span>元（<span id="uRgS">0</span>%）<span class="tips_sp" id="uRgE">！至少需要认购3份</span></p>
                                <p><span class="hide_sp"><input type="checkbox" id="uBdC" /></span><span class="align_sp">我要保底：</span><input name="" class="mul" type="text" value="1" id="uBd" />份，<span class="red eng" id="uBdM">￥0.00</span>元（<span id="uBdS">0</span>%）<s class="i-qw" data-help="<h5>什么是保底？</h5><p>发起人承诺合买截止后，如果方案还没有满员，发起人再投入先前承诺的金额以最大限度让方案成交。最低保底金额为方案总金额的20%。保底时，系统将暂时冻结保底资金，在合买截止时如果方案还未满员的话，系统将会用冻结的保底资金去认购方案。如果在合买截止前方案已经满员，系统会解冻保底资金。</p>"></s> <span class="tips_sp" id="uBdE">！最低保底20%</span></p>

                                <p class="gray"><span class="hide_sp"></span>[注]冻结资金将在网站截止销售时，根据该方案的销售情况，返还到您的预付款中。</p>
                                <p><span class="hide_sp"><input type="checkbox" checked="checked" id="uAgree" /></span>我已阅读并同意《<a href="javascript:void(0)" onclick="Y.openUrl('/doc/webdoc/gmxy',530,500)">用户合买代购协议</a>》</p>
                               <p style="display:none">
								<span class="hide_sp"><input type="checkbox" checked="checked" id="isoverflow" /></span><span class="red">您的投注倍数超过99倍，系统将把您的方案拆分为多个方案分别发起、出票。</span><a href="javascript:void(0)" onclick="Yobj.showSplit();return false">示例说明</a><br />
									---如果在出票过程中过关投注奖金发生变化，则以每个方案出票时刻的奖金为准。<br />

									---如果遇到意外情况需要撤单，网站将对拆分后的方案分别撤单。
								</p>
                            </td>
                          </tr>
                          <tr>
                            <td class="td_ge_t">可选信息</td>
                            <td class="td_ge">
                                <p class="ge_selt p-l0"><span class="hide_sp"><input type="checkbox"  id="uAd" /></span>方案宣传与合买对象</p>

                            </td>
                          </tr>
                          <tr id="case_ad" style="display:none">
                            <td class="td_title2">方案宣传</td>
                            <td class="td_content">
                                <p><span class="hide_sp"></span><span class="align_sp">方案标题：</span><input type="text" class="t_input" value="竞彩足球合买" id="uAdT" /><span class="gray">已输入8个字符，最多20个</span></p>
                                <p><span class="hide_sp"></span><span class="align_sp">方案描述：</span><textarea class="p_input" cols="" rows="" id="uAdCo">随缘！买彩票讲的是运气、缘分和坚持。</textarea><span class="gray">已输入0个字符，最多200个字符</span></p>

                                </td>
                          </tr>
                          <tr class="last_tr" id="uT" style="display:none">
                            <td class="td_title2">合买对象</td>
                            <td class="td_content">
                                <p><span class="hide_sp"></span><label class="m_r25" for="uT1"><input type="radio" class="m_r3" checked="checked" name="zgdx" id="uT1" />所有彩友可以合买</label><label class="m_r25" for="uT2"><input type="radio" class="m_r3" name="zgdx" id="uT2"/>只有固定的彩友可以合买</label></p>
								<div id="uFixedbox" style="display:none;">

                                <p><span class="hide_sp"></span><span class="align_sp"></span><textarea class="p_input" cols="" rows="" id="uFixed"></textarea></p>
                                <p><span class="hide_sp"></span><span class="gray">[注]限定彩友的格式是：aaaaa,bbbbb,ccccc,ddddd（,为英文状态下的逗号）</span></p></div>
                            </td>
                          </tr>
                        </table>
                    </div>
                                 
<?php
}
?>                    
                    
                </tbody>
			</table>
		</div>
	</div>
</div>
<form method="post" action="<?php echo url::base();?>jczq/pute_ds" id="buyform">
<input name="tmp_path" id="" value="<?php echo $tp;?>" type="hidden" />
<input name="totalmoney" id="totalmoney" value="<?php echo $total_price;?>" type="hidden" />
<input name="rate" id="zhushu" value="0" type="hidden" />
  <input name="typename" id="sgtypestr" value="<?php echo $typename;?>" type="hidden" />
  <input name="copies" id="beishu" value="<?php echo $d_count;?>" type="hidden" />
  <input name="code_data" id="codes" value="" type="hidden" />
  <input name="special_num" id="danma" value="" type="hidden" />
  <input name="IsCutMulit" id="IsCutMulit" value="0" type="hidden" />
  <input name="ticket_type" id="playtype" value="<?php echo $ticket_type?>" type="hidden" />
  <input name="play_method" id="play_method" value="<?php echo $play_method?>" type="hidden" />
  <input name="ticket_id" id="playid" value="<?php echo $ticket_type?>" type="hidden" />
  <input name="lotid" id="lotid" value="<?php echo $ticket_type?>" type="hidden" />
  <input name="is_hemai" id="ishm" value="<?php echo $is_hemai;?>" type="hidden" />
  <input name="ratelist" id="ratelist" value="" type="hidden" />
  <input name="bonus_max" id="imaxmoney" value="" type="hidden" />
  <input name="zhushu" id="allnum" value="1" type="hidden" />
  <input name="my_copies" id="buynum" value="1" type="hidden" />  
  <input name="is_baodi" id="isbaodi" value="0" type="hidden" />
  <input name="time_end" id="time_end" value="<?php echo $time_end;?>" type="hidden" />
  <input name="baodinum" id="baodinum" value="0" type="hidden" />
  <input name="sgtype" id="sgtype" value="" type="hidden" />
  <input name="gggroup" id="gggroup" value="" type="hidden" />
  <input name="title" id="title" value="" type="hidden" />
  <input name="content" id="content" value="" type="hidden" />
  <input name="deduct" id="tc_bili" value="0" type="hidden" />
  <input name="isset_buyuser" id="isset_buyuser" value="1" type="hidden" />
  <input name="buyuser" id="buyuser" value="all" type="hidden" />
</form>
<div id="split_example" style="position: absolute; display:none;" class="tips_m">
  <div class="tips_b">
    <div class="tips_box">
      <div class="tips_title">
        <h2>方案拆分示例</h2>
        <span class="close"><a href="javascript:void 0" id="split_close">关闭</a></span> </div>
      <div class="tips_info">
      <div class="jcBeiTou">
        <div class="t">单张彩票官方最高投注倍数为99倍，网站将把超过99倍的方案拆分为多个方案分别发起、出票。 例如： </div>

        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablelay eng">
          <tbody>
            <tr class="trt">
              <th>赛事编号</th>
              <th class="tb_line">主队</th>
              <th class="tb_line">让球</th>
              <th class="tb_line">客队</th>

              <th class="tb_line">您的选择</th>
            </tr>
            <tr>
              <td>周四001</td>
              <td>拉瓦尔</td>
              <td>-1</td>
              <td class="td_line">勒芒</td>

              <td class="td_line">胜</td>
            </tr>
            <tr>
              <td>周四002</td>
              <td>色当</td>
              <td>0</td>
              <td class="td_line">萨托鲁</td>

              <td class="td_line">平</td>
            </tr>
            <tr>
              <td>周四003</td>
              <td>梅斯</td>
              <td>0</td>
              <td class="td_line">伊斯特</td>

              <td class="td_line">负</td>
            </tr>
            <tr>
              <td class="td_line" colspan="5">过关方式：<span class="red">3串1</span>&nbsp;&nbsp;&nbsp; 注数：<span class="red">1</span>注 <br>
                倍数：<span class="red">200</span>倍 &nbsp;&nbsp;&nbsp;方案总金额：<span class="red">￥400</span></td>

            </tr>
          </tbody>
        </table>
        <br>
        <div class="t">系统将上述方案拆分为3个方案出票： 2个99倍+1个2倍。</div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablelay eng">
          <tbody>
            <tr class="trt">

              <th>编号</th>
              <th class="tb_line">过关方式</th>
              <th class="tb_line">注数</th>
              <th class="tb_line">倍数</th>
              <th class="tb_line">金额</th>
            </tr>

            <tr>
              <td>1</td>
              <td>3串1</td>
              <td>1</td>
              <td>99</td>
              <td align="left" class="td_line" style="padding-left: 35px;">￥198</td>

            </tr>
            <tr>
              <td>2</td>
              <td>3串1</td>
              <td>1</td>
              <td>99</td>
              <td align="left" class="td_line" style="padding-left: 35px;">￥198</td>

            </tr>
            <tr>
              <td>3</td>
              <td>3串1</td>
              <td>1</td>
              <td>2</td>
              <td align="left" class="td_line" style="padding-left: 35px;">￥4</td>

            </tr>
            <tr>
              <td>合计</td>
              <td>-</td>
              <td>-</td>
              <td>200</td>
              <td align="left" class="td_line" style="padding-left: 35px;">￥400</td>

            </tr>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!--余额不足内容--> 
<div class="tips_m" style="top:300px;display:none;" id="addMoneyLay"> 
	<div class="tips_b"> 
        <div class="tips_box"> 
            <div class="tips_title"> 
                <h2>可用余额不足</h2> 
                <span class="close" id="addMoneyClose"><a href="javascript:void 0">关闭</a></span> 
            </div> 
            <div class="tips_text"> 
                <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br/>(点充值跳到“充值”页面，点“返回”可进行修改)</p> 
            </div> 
            <div class="tips_sbt"> 
                <input type="button" value="返 回" class="btn_Lora_b" id="addMoneyNo"/><input type="button" value="充 值" class="btn_Dora_b" id="addMoneyYes" /> 
            </div> 
        </div> 
    </div> 
</div> 

<!--提示层-->
<div class="tips_m" style="width:692px; top:1000px; display:none;" id="blk1">
	<div class="tips_b">
		<div class="tips_box">
			<div class="tips_title">
				<h2>竞彩足球奖金明细</h2>
				<span class="close"><a href="javascript:void(0)" id="close1">关闭</a></span>
			</div>

			<div class="tips_info">
				<div class="mx_tips">
					<p><strong class="red" id="prix_range">奖金范围：0-0元</strong></p>
					<h3>奖金分布</h3>
					<div id="hot_case"></div>
					<h3>投注分布</h3>
					<div id="tz_fenbu"></div> 
					<p class="p_tb5">注：奖金预测SP值为投注时即时SP值，最终奖金以开奖SP值为准。</p>

				</div>
			</div>
		</div>
	</div>
</div>

<!--提示确认--> 
<div class="tips_m" style="display:none" id="confirm_dlg"> 
	<div class="tips_b"> 
        <div class="tips_box"> 
            <div class="tips_title"> 
                <h2 id="confirm_dlg_title">温馨提示</h2> 
                <span class="close" id="confirm_dlg_close"><a href="#">关闭</a></span> 
            </div> 
            <div class="tips_info"  id="confirm_dlg_content"></div> 
            <div class="tips_sbt"> 
                <input type="button" value="取 消" class="btn_Lora_b"  id="confirm_dlg_no" /><input type="button" value="同  意" class="btn_Dora_b"  id="confirm_dlg_yes" /> 
            </div> 
        </div> 
    </div> 
</div>

<div style="display:none;" id="open_iframe">
  <div id="open_iframe_content"></div>
</div>

<?php echo View::factory('footer')->render();?>
<!--未登录提示层-->
<?php echo View::factory('login')->render();?>
<!--默认提示层-->

</body>
</html>