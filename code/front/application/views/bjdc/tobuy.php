<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-单场竞猜-购买交易区</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(   'media/js/yclass.js?v=20110509',
    'media/js/loginer',
	'media/js/buy_form.js',
	'media/js/project_detail.js',
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
		<a href="<?php echo url::base();?>bjdc/rqspf"><font class="blue">单场竞猜</font></a> &gt; 购买交易区
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
      <table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
          <tr>
            <td class="td_title2">方案截止时间</td>
            <td class="con_content"><p><?=$stoptime?></p></td>
          </tr>
          <tr>
            <td class="td_title2">投注内容</td>
            <td class="con_content"><div class="clearfix">
                <div class="aff_l">
                  <div class="tdbback">
                    <table class="tablelay eng" style="table-layout: fixed;" border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tbody id="fangan_table">
                        <tr>
                          <th style="width: 8%;">场次</th>
                          <th style="width: 32%;">比赛</th>
							<?php
								if ($betid == 501) { 
							?>
                          <th style="width: 10%;">让球数</th>
	                          <?php
									} 
	                          ?>
                          <th>您的选择</th>
                          <th class="last_th" style="width: 8%;">胆码</th>
                        </tr>
                        <!-- 循环开始(老代码) !-->
<?php
for ($i = 0; $i < count($match_info); $i++) {
?>
<tr class="tr1">
<td><?=$match_info[$i]['info']['match_no']?></td>
<td><span class="vsl"><?=$match_info[$i]['info']['home']?></span><span class="vs">VS</span><span class="vsr"><?=$match_info[$i]['info']['away']?></span></td>
<?php 
if ($betid == 501) { 
	if ($match_info[$i]['info']['goalline'] == 0) {
		echo '<td>0</td>';
	}
	elseif($match_info[$i]['info']['goalline'] > 0) {
		echo '<td><span class="sp_up">'.$match_info[$i]['info']['goalline'].'</span></td>';
	}
	else {
		echo '<td><span class="sp_down">'.$match_info[$i]['info']['goalline'].'</span></td>';
	}
} 
?>
<?php
	$code1 = '';
	$code2 = '';
	foreach ($match_info[$i]['choose'] as $key => $val) {
		$code1 .= $key.',';
		$code2 .= $key.'('.$val.') ';
	} 
?>
<td codes="<?=substr($code1, 0, -1)?>" style="word-wrap: break-word;"><?=$code2?></td>
<td class="last_td">
<?php 
if (isset($danma[$match_info[$i]['info']['match_no']])) {
	echo '√';
}
else {
	echo '×';
}
?>
</td>
</tr>
<?php
} 
?>

                        <!-- 循环结束(老代码) !-->
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="aff_r">
                  <div class="tdbback">
                    <table class="tablelay eng" border="0" cellpadding="0" cellspacing="0" width="100%">
                      <tbody>
                        <tr>
                          <th colspan="2">自由过关</th>
                        </tr>
                        <tr class="tr1">
                          <td width="50%">过关方式</td>
                          <td class="last_td">倍数</td>
                        </tr>
                        <tr class="tr1">
                          <td><?=$sgtypename?></td>
                          <td class="last_td"><?=$beishu?></td>
                        </tr>
                        <tr class="last_tr">
                          <td class="last_td" colspan="2"><p class="aff_zjr">总金额：<span class="red">￥<?=$totalmoney?></span> 元<br>
                              <a href="javascript:void(0)" id="see_project_detail_fs_ck">查看方案明细</a></p></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div></td>
          </tr>
          <tr>
            <td class="td_title2">方案信息</td>
            <td class="con_content"><p>您选择的方案为<?=count($match_info)?>场比赛<span class="red"><?=$sgtypename?></span>的自由过关。 <br>
                方案注数<span class="eng red"><?=$zhushu?></span>注，倍数<span class="eng red"><?=$beishu?></span>倍，总金额<span class="eng red">￥<?=$totalmoney?></span> 元。</p></td>
          </tr>
<?php
if ($ishm == 0) {
?> 
          <tr class="last_tr">
            <td class="td_title2">我要认购</td>
            <td class="con_content"><div class="buy_btn2 clearfix"> <a onclick="return false" class="btn_buy_m m-r" title="立即购买" id="dg_btn">立即购买</a> 
            <a href="<?=$back_url?>" id="back_btn" title="返回修改" class="btn_modifyFont" >返回修改&gt;&gt;</a> </div>
              <p class="read"> <span class="hide_sp">
                <input checked="checked" id="agreement" type="checkbox">
                </span>我已阅读并同意《<a href="javascript:void(0)" onclick="Yobj.openUrl('/doc/webdoc/gmxy',530,440)">用户合买代购协议</a>》。 </p></td>
          </tr>
<?php
} 
else {
?>
<div id="dd2" style="display:none;">

<table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td class="td_title2">方案金额</td>
              <td class="td_content"><p><span class="hide_sp red eng"></span>￥<?=$totalmoney?> 元</p></td>
            </tr>
            <tr>
              <td class="td_title2">购买形式</td>
              <td class="td_content"><p><span class="hide_sp red eng">*</span><span class="align_sp">我要分为：</span>
                  <input value="20" class="mul" id="allnum" maxlength="6" type="text">
                  份，  每份<span class="red eng" id="allnum_piece">￥1.00</span>元 <span class="gray">每份至少1元</span><span class="tips_sp" id="allnum_tip" style="display:none">！每份金额不能除尽，请重新填写份数</span></p>
                <p> <span class="hide_sp"></span> <span class="align_sp">我要提成：</span>
                  <select id="tcbili" class="selt">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option selected="selected" value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                  </select>
                  % <span class="i-hp i-qw" data-help="&lt;h5&gt;关于提成&lt;/h5&gt;&lt;p&gt;提成比例设定为0%-8%之间，如果方案中奖又有盈利(税后奖金-合买方案总金额&gt;0)，您就可以获得的税后奖金提成.提成金额=税后奖金×提成比例，方案不盈利将没有提成。&lt;/p&gt;&lt;p&gt;例如：合买方案总金额为10000元，税后奖金为20000元，提成比例为8%，20000*8%=1600元，最后您的提成金额是1600元。&lt;/p&gt;"></span> </p></td>
            </tr>
            <tr>
              <td class="td_title2">认购设置</td>
              <td class="td_content"><div class="buy_btn2 fr"> <a title="立即购买" class="btn_buy_m m-r" onclick="return false" id="hm_btn">立即购买</a> <a href="<?=$back_url?>" id="back_btn" title="返回修改" class="btn_modifyFont">返回修改&gt;&gt;</a> </div>
                <p> <span class="hide_sp red eng"></span> </p>
                <div id="userMoneyInfo">您尚未登录，请先<a href="javascript:void 0" title="" onclick="Yobj.postMsg('msg_login')">登录</a>！</div>
                <p></p>
                <p><span class="hide_sp"></span><span class="align_sp">我要认购：</span>
                  <input value="1" class="mul" id="buynum" maxlength="6" type="text">
                  份，<span class="red eng" id="buynum_money">￥1.00</span>元（<span id="buynum_scale">5.00%</span>）<span class="tips_sp" id="buynum_tip" style="display:none">！您需认购<span>x</span>份~<span>x</span>份</span></p>
                <p><span class="hide_sp">
                  <input id="isbaodi" type="checkbox">
                  </span><span class="align_sp">我要保底：</span>
                  <input class="mul" id="baodinum" disabled="disabled" maxlength="6" type="text">
                  份，<span class="red eng" id="baodi_money">￥0.00</span>元（<span id="baodi_scale">0.00%</span>）<span class="i-hp i-qw" data-help="&lt;h5&gt;什么是保底？&lt;/h5&gt;&lt;p&gt;发起人承诺合买截止后，如果方案还没有满员，发起人再投入先前承诺的金额以最大限度让方案成交。最低保底金额为方案总金额的20%。保底时，系统将暂时冻结保底资金，在合买截止时如果方案还未满员的话，系统将会用冻结的保底资金去认购方案。如果在合买截止前方案已经满员，系统会解冻保底资金。&lt;/p&gt;"></span> <span class="tips_sp" id="baodi_tip" style="display:none">！最低保底20%</span></p>
                <p class="gray"><span class="hide_sp"></span>[注]冻结资金将在网站截止销售时，根据该方案的销售情况，返还到您的预付款中。</p>
                <p><span class="hide_sp">
                  <input checked="checked" id="agreement" type="checkbox">
                  </span>我已阅读并同意《<a href="javascript:void(0)" onclick="Yobj.openUrl('/doc/webdoc/gmxy',530,440)">用户合买代购协议</a>》</p></td>
            </tr>
            <tr>
              <td class="td_ge_t">可选信息</td>
              <td class="td_ge"><p class="ge_selt"><span class="hide_sp">
                  <input disabled="disabled" id="optional_info" type="checkbox">
                  </span>方案宣传与合买对象</p>
                <p class="ge_tips" style="width:320px">2011年6月30日起，网站暂停方案宣传内容的录入。</p></td>
            </tr>
            <tr id="optional_info_1" style="display: none;">
              <td class="td_title2">方案宣传</td>
              <td class="td_content"><p><span class="hide_sp"></span><span class="align_sp">方案标题：<?=$title?></span>
                  <input value="<?=$title?>" default="<?=$title?>" class="t_input" id="title" maxlength="20" type="text">
                  <span class="gray">已输入<span id="title_word_count">12</span>个字符，最多20个</span></p>
                <p><span class="hide_sp"></span><span class="align_sp">方案描述：</span>
                  <textarea class="p_input" id="content" default="<?=$content?>"><?=$content?></textarea>
                  <span class="gray">已输入<span id="content_word_count">18</span>个字符，最多200个字符</span></p></td>
            </tr>
            <tr class="last_tr" id="optional_info_2" style="display: none;">
              <td class="td_title2">合买对象</td>
              <td class="td_content"><p><span class="hide_sp"></span>
                  <label class="m_r25">
                  <input name="zgdx" value="1" checked="checked" class="m_r3" type="radio">
                  所有彩友可以合买</label>
                  <label class="m_r25">
                  <input name="zgdx" value="2" class="m_r3" type="radio">
                  只有固定的彩友可以合买</label>
                </p>
                <p id="buyuser" style="display:none"><span class="hide_sp"></span><span class="align_sp"></span>
                  <textarea class="p_input" id="setbuyuser">all</textarea>
                  <span class="gray" style="display:block;padding-left:20px;">[注]限定彩友的格式是：aaaaa,bbbbb,ccccc,ddddd（,为英文状态下的逗号）</span></p></td>
            </tr>
          </tbody>
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
<input name="lotid" id="lotid" value="<?=$play_type?>" type="hidden">
<input name="playid" id="playid" value="<?=$betid?>" type="hidden">
<input name="expect" id="expect" value="<?=$issue?>" type="hidden">
<input name="gggroup" id="gggroup" value="<?=$gggroup?>" type="hidden">
<input name="sgtype" id="sgtype" value="<?=$sgtype?>" type="hidden">
<input name="sgtypename" id="sgtypename" value="<?=$sgtypename?>" type="hidden">
<input name="codes" id="codes" value="<?=$codes?>" type="hidden">
<input name="danma" id="danma" value="<?=$danma_str?>" type="hidden">
<input name="beishu" id="beishu" value="<?=$beishu?>" type="hidden">
<input name="totalmoney" id="totalmoney" value="<?=$totalmoney?>" type="hidden">
<input name="IsCutMulit" id="IsCutMulit" value="<?=$IsCutMulit?>" type="hidden">
<input name="ishm" id="ishm" value="<?=$ishm?>" type="hidden">
<input name="playtype" id="playtype" value="<?=$betid?>" type="hidden">
<input name="ratelist" id="ratelist" value="<?=$ratelist?>" type="hidden">
<input name="zhushu" id="zhushu" value="<?=$zhushu?>" type="hidden">
<input name="endtime" id="endtime" value="<?=$stoptime?>" type="hidden">
<!-- 方案明细弹窗(确认页and认购页) -->
<div id="project_detail" style="display: none; width: 692px; position: absolute;" class="tips_m">
  <div class="tips_b">
    <div class="tips_box">
      <div class="tips_title" style="cursor: move;">
        <h2>足球单场方案明细</h2>
        <span class="close"><a href="javascript:void(0)">关闭</a></span> </div>
      <div class="tips_info" style="height:400px; overflow-y:auto">
        <div class="mx_tips">
          <h3 class="red">投注内容</h3>
          <table class="m-t" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody id="table1">
            </tbody>
          </table>
          <h3 class="red">拆分明细</h3>
          <p class="tc" style="display:none" id="ds_pro_info"> 方案共有[ <span class="red eng"><?=$zhushu?></span> ]注，总金额[ <span class="red eng">￥<?=$totalmoney?></span> ]元&nbsp;&nbsp;&nbsp;&nbsp;<a class="red" href="" target="_blank">下载全部方案</a> </p>
          <table class="m-t" border="0" cellpadding="0" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>序号</th>
                <th>方案拆分</th>
                <th>过关方式</th>
                <th>倍数</th>
                <th>注数</th>
                <th class="last_th">金额</th>
              </tr>
            </thead>
            <tbody id="table2">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<input id="passport_url" value="" type="hidden">
<!--footer start-->
<?php echo View::factory('footer')->render();?>
<!--footer end-->
<div id="ft">
  <textarea id="responseJson" style="display: none;">{
	period :      "<?=$issue?>",   //期号
	serverTime :  "2011-08-11 16:06:21",   //服务器时间
	endTime :     "2011-08-12 03:30:00",    //截止时间
	singlePrice : 0,   //单注金额
	baseUrl : "" , //网站根目录
	showUrl : ""  //晒单根目录
}</textarea>
<?php echo View::factory('login')->render();?>
  <!--默认提示层-->
  <div class="tips_m" style="display: none; position: absolute;" id="defLay">
    <div class="tips_b">
      <div class="tips_box">
        <div style="cursor: move;" class="tips_title">
          <h2>温馨提示</h2>
          <span class="close" id="defTopClose"><a href="javascript:void(0);">关闭</a></span> </div>
        <div class="tips_text" id="defConent" style="padding:18px;text-align:center;"></div>
        <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
          <input class="btn_Lblue_m" value="关闭" id="defCloseBtn" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--号码示例层-->
  <div class="tips_m" style="display:none;" id="codeTpl">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>温馨提示</h2>
          <span class="close" id="codeTplClose"><a href="javascript:void(0);">关闭</a></span> </div>
        <div class="tips_text" id="codeTplConent" style="padding:18px;"></div>
        <div class="tips_sbt" style="padding:8px;text-align:center;height:auto;">
          <input class="btn_Lora_b" value="知道了" id="codeTplYes" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--余额不足内容-->
  <div class="tips_m" style="top: 300px; display: none; position: absolute;" id="addMoneyLay">
    <div class="tips_b">
      <div class="tips_box">
        <div style="cursor: move;" class="tips_title">
          <h2>可用余额不足</h2>
          <span class="close" id="addMoneyClose"><a href="javascript:void%200">关闭</a></span> </div>
        <div class="tips_text">
          <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br />
            (点充值跳到“充值”页面，点“返回”可进行修改)</p>
        </div>
        <div class="tips_sbt">
          <input value="返 回" class="btn_Lora_b" id="addMoneyNo" type="button" />
          <input value="充 值" class="btn_Dora_b" id="addMoneyYes" type="button" />
        </div>
      </div>
    </div>
  </div>
  <!--代购确认-->
  <div class="tips_m" style="display:none" id="b2_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2 id="b2_dlg_title">确认投注内容</h2>
          <span class="close" id="b2_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_info" id="b2_dlg_content"></div>
        <div class="tips_sbt">
          <input value="取 消" class="btn_Lora_b" id="b2_dlg_no" type="button">
          <input value="确 定" class="btn_Dora_b" id="b2_dlg_yes" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--机选号码列表-->
  <div class="tips_m" style="top:300px;width:300px;display:none;position:absolute" id="jx_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>机选号码列表</h2>
          <span class="close" id="jx_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_text">
          <ul class="tips_text_list" id="jx_dlg_list">
          </ul>
        </div>
        <div class="tips_sbt">
          <input value="重新机选" class="btn_gray_b m-r" id="jx_dlg_re" type="button">
          <input value="选好了" class="s-ok s-ok-sp" id="jx_dlg_ok" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--查看胆拖明细列表-->
  <div class="tips_m" style="top:300px;width:300px;display:none;position:absolute" id="split_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>查看投注明细</h2>
          <span class="close" id="split_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_text">
          <ul class="tips_text_list" id="split_dlg_list" style="height:284px;overflow:auto;">
          </ul>
        </div>
        <div class="tips_sbt">
          <input value="关 闭" class="s-ok" id="split_dlg_ok" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--温馨提示-->
  <div style="top:700px;display:none;position:absolute;width: 500px;" class="tips_m" id="info_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>温馨提示</h2>
          <span class="close" id="info_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="alert_c">
          <div class="state error">
            <div class="stateInfo f14 p_t10" id="info_dlg_content"></div>
          </div>
        </div>
        <div class="tips_sbt">
          <input class="btn_Dora_b" value="确 定" id="info_dlg_ok" type="button">
        </div>
      </div>
    </div>
  </div>
  <!-- 确认投注内容 -->
  <div class="tips_m" style="width:700px;display:none;" id="ishm_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2 id="ishm_dlg_title">方案合买</h2>
          <span class="close"><a href="javascript:void%200" id="ishm_dlg_close">关闭</a></span> </div>
        <div class="tips_info tips_info_np" id="ishm_dlg_content"></div>
        <div class="tips_sbt">
          <input value="确认投注" class="btn_Dora_b" id="ishm_dlg_yes" type="button">
          <a href="javascript:void(0);" class="btn_modifyFont" title="返回修改" id="ishm_dlg_no">返回修改&gt;&gt;</a> </div>
      </div>
    </div>
  </div>
  <!--提示确认-->
  <div class="tips_m" style="display:none" id="confirm_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2 id="confirm_dlg_title">温馨提示</h2>
          <span class="close" id="confirm_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_info" id="confirm_dlg_content"></div>
        <div class="tips_sbt">
          <input value="取 消" class="btn_Lora_b" id="confirm_dlg_no" type="button">
          <input value="确 定" class="btn_Dora_b" id="confirm_dlg_yes" type="button">
        </div>
      </div>
    </div>
  </div>
  <!--我要晒单-->
  <div class="tips_m" style="width:520px;display:none;" id="saidandlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>分享晒单</h2>
          <span class="close"><a href="#" id="saidandlg_close">关闭</a></span> </div>
        <div class="state2">
          <div class="alert_c">
            <div class="sh-alert">
              <div class="hd" id="saidandlg_btn">
                <!--s-r  s-b s-x s-y-->
                <span class="a-l">我要晒：</span><a href="javascript:void(0)" title="" class="s-r" data-val="red">红单</a>|<a href="javascript:void(0)" title="" data-val="black">黑单</a>|<a href="javascript:void(0)" title="" data-val="lucky">幸运</a>|<a href="javascript:void(0)" title="" data-val="unlucky">遗憾</a><span id="notestr" class="gray" style="padding-left:55px">红单：泛指盈利了的方案</span> </div>
              <div class="bd"> <span class="a-l l">晒单理由：</span>
                <div class="d-comment l">
                  <textarea style="height: 60px;" class="c-n-t" rows="10" cols="10" id="saidandlg_text"></textarea>
                  <div class="clearfix"><span class="l gray">
                    <input id="saidandlg_isshare" value="on" checked="checked" type="checkbox">
                    同时发布到论坛 <span id="saidansize" style="padding-left:5px">还能输入140个字</span></span><span class="r"><a href="#" title="saidandlg_isshare" class="m-r" id="saidandlg_no">取消</a>
                    <input value="发布" class="btn_Dora_m" name="" id="saidandlg_yes" type="button">
                    </span></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--成功层-->
  <div class="tips_m" style="width:520px;display:none" id="saidansuc">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>分享晒单</h2>
          <span class="close"><a href="#" id="saidansuc_close">关闭</a></span> </div>
        <div class="alert_c">
          <div class="state2">
            <div class="alert_c">
              <div class="state suc">
                <div class="t">晒单成功，您的晒单已提交审核中，稍后将显示！</div>
                <div style="font-size:14px;">您可以 <a href="/mysd/mysd.php" title="" target="_blank">立即查看自己的晒单</a> 或 <a href="" title="" target="_blank">访问晒单专区首页</a></div>
              </div>
              <div class="btn"><a href="" class="btn_Dora_m" id="saidansuc_yes">确 定</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <!--幸运彩蛋-->
  <div class="tips_m" style="width: 548px; display: none; position: absolute;" id="luckegg_win">
    <div class="tips_b">
      <div class="tips_box cd_bg" style="border:0;">
        <div class="tips_title" style="background: none repeat scroll 0% 0% transparent; border: 0pt none; padding-left: 0pt; height: 38px; cursor: move;"> <i class="cd_title">幸运彩蛋</i> <span class="close"><a href="javascript:void(0)" id="luckegg_kill" onclick="return false">关闭</a></span> </div>
        <div class="tips_text">
          <div class="cd_pic2" id="luckegg_msg">恭喜您获得充值30元送5元购彩金</div>
          <a class="cd_btn" target="_bank" href="" id="lubkegg_add"></a>
          <div class="cd_start" id="luck_info_a"> </div>
          <div class="cd_start" id="luck_info_b"> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="bjdc_qrdg_files/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="bjdc_qrdg_files/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="bjdc_qrdg_files/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
<div style="opacity: 0.2; display: none; z-index: 500000;" tabindex="-1" class="yclass_mask_panel"></div>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>
<div class="tips_m" style="top: 700px; width: 500px; display: none; position: absolute;" id="yclass_alert">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_alert_title">温馨提示</h2>
        <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span> </div>
      <div class="alert_c">
        <div class="state error">
          <div class="stateInfo f14 p_t10" id="yclass_alert_content"></div>
        </div>
      </div>
      <div class="tips_sbt">
        <input value="确 定" class="btn_Dora_b" id="yclass_alert_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div class="tips_m" style="display: none; position: absolute;" id="yclass_confirm">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_confirm_title">温馨提示</h2>
        <span class="close" id="yclass_confirm_close"><a href="#">关闭</a></span> </div>
      <div class="tips_info">
        <div class="stateInfo f14 p_t10" id="yclass_confirm_content" style="zoom:1"></div>
      </div>
      <div class="tips_sbt">
        <input value="取 消" class="btn_Lora_b" id="yclass_confirm_no" type="button">
        <input value="确 定" class="btn_Dora_b" id="yclass_confirm_ok" type="button">
      </div>
    </div>
  </div>
</div>
<div style="display:none;" id="open_iframe">
  <div id="open_iframe_content"></div>
</div>
<div style="z-index: 500001; position: absolute; top: 140px; left: -99999px;">
  <div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51); padding: 0pt; width: 530px; height: 440px;"></div>
  <div style="position: absolute; left: 0pt; top: 0pt; display: block; z-index: 9; width: 470px; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
</body>
</html>