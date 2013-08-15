<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-竞彩足球-让球胜平负-单式上传</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/tabs',
	'media/js/loginer',
	'media/js/predict',
	'media/js/jczq_buy',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/zc',
	'media/css/mask',
    'media/css/style',
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
		<a href="<?php echo url::base();?>jczq/rqspf"><font class="blue">竞彩足球</font></a> &gt; 让球胜平负
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width jingcai_box">
	<div class="fl" id="jingcai_top">
    	<span class="fl" id="jctop_left"><img src="<?php echo url::base();?>media/images/jczq.gif" width="76" height="63" /></span>
        <div class="fl" id="jctop_right">
       	  <p id="jctop_rheight"><span class="fr gray6">销售时间：周一至周五 09:00～22:40  周六至周日 09:00～00:40</span><font class="font16 black heiti">返奖率高达</font><font class="font24 orange heiti">69%，</font><font class="font16 black heiti">过关固定奖金</font></p>
      <div id="jc_menu" class="font14 bold">
            	<ul>
                	<li <?php if(!empty($play_type) && $play_type ==1) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/rqspf"><span>让球胜平负</span></a></li>
                    <li <?php if(!empty($play_type) && $play_type ==2) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/zjqs"><span>总进球数</span></a></li>
                    <li <?php if(!empty($play_type) && $play_type ==3) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/bf"><span>比分</span></a></li>
                    <li <?php if(!empty($play_type) && $play_type ==4) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/bqc"><span>半全场</span></a></li>
                    <li <?php if(!empty($play_type) && $play_type ==5) {?> class="hover"<?php  }?>><a href="<?php echo url::base();?>jczq/my"><span>我的方案</span></a></li>
                </ul>
          </div>
        </div>
    </div>
     <div id="jingcai_bottom" class="fl">
     <div class="dc_l"> <a href="<?php echo url::base();?>jczq/rqspf" title="普通投注" <?php if (!isset($ds)) echo 'class="on"';?>><em>普通投注</em><s></s></a> <a href="<?php echo url::base();?>jczq/ds_spf" title="单式投注" <?php if (isset($ds) && $ds == 1) echo 'class="on"';?>><em>单式投注</em><s></s></a></div>
     <span class="fr pt5 mr10"><a href="<?php echo url::base();?>buycenter/jczq"><img src="<?php echo url::base();?>media/images/btn3.gif" width="85" height="22" alt="参与合买" /></a></span></div>
    <span class="zhangkai"></span>
</div>
<!--content1 end-->
<!--header end-->
<div id="bd">
  <div id="main" class="main_dc clearfix">
        <div class="box_m2">
        <div class="dc_r_m">
          <h2>上传方案并购买</h2>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                          <tr>
                            <td width="25%" align="center" bgcolor="#eeeeee"><h3>上传方案</h3></td>
                            <td width="75%">
								<p><span>格式说明：（胜→3  平→1  负→0；过关方式支持2串1，3串1，4串1，5串1；最高投注注数100注）</span></p>
								<p><span>SPF|111010011=0,111010012=1|2*1:100（玩法|日期比赛号=结果,...|2串1:倍数）</span></p>
								<p><span>SPF|111010011=0,111010012=1,111010013=1|3*1:20</span></p>
								<p><span>SPF|111010011=0,111010012=1,111010014=1,111010015=1|4*1:10</span></p>
								<p>注：上述格式符必须与您将要上传的文本中的格式符一致。<a href="<?php echo url::base();?>jczq_ds_demo.txt" target="_blank"><b>文本样例</b></a></p>
                            	<div id="upload">
                            	<form style="display:inline" enctype="multipart/form-data" action="<?php echo url::base();?>jczq/ds_tobuy" method="post" name="form">
								<input type="file" name="txt" />
                            	</div>
                            </td>
                          </tr>
                          <tr>
                            <td align="center" bgcolor="#eeeeee"><h3>确认购买</h3></td>
                            <td>
                                <p id="userMoneyInfo">您尚未登录，请先<a href="javascript:void 0" title="" onclick="Yobj.postMsg('msg_login')">登录</a>
									</p>
                                    <p><span><input type="checkbox" checked="checked" /></span>我已阅读并同意《<a href="javascript:void(0)" onclick="Y.openUrl('/doc/webdoc/gmxy',530,500)">用户合买代购协议</a>》 </p>
                                    <p><span>
					              <input type="checkbox" checked="checked" />
					              </span><span class="red">彩票发行中心对竞彩进行<a href="javascript:void%200" title="" class="blue" id="xianhao1" data-help="&lt;h5&gt;限号管理&lt;/h5&gt;&lt;p&gt;为了加强对“竞彩”的销售管理，在销售过程中，根据投注额、突发事件等因素，彩票管理中心销售系统可能会拒绝某些大额投注，或者暂停或提前截止某场比赛的某些特定过关组合、特定结果选项的投注，暂停或提前截止针对某场比赛的所有投注。此种情况下，网站对暂停或提前截止销售不承担任何责任。&lt;/p&gt;&lt;p&gt;&lt;b&gt;限号实例&lt;/b&gt;&lt;/p&gt;&lt;p&gt;官方限号内容：周三001 负 周三002 负 过关方式：2串1&lt;/p&gt;&lt;p&gt;如选择了包含该限号组合的方案，网站将对方案包含的特定组合做部分撤单返款处理。&lt;/p&gt;">限号管理</a>，我已阅读并同意网站<a href="javascript:void%200" class="blue" onclick="Y.openUrl('/doc/webdoc/jctzfxxz',530,500)">《竞彩投注风险须知》</a></span></p>
                                <div class="#"></div>
                            </td>
                          </tr>
   </table>
   <br />
          <p class="dc_r_btn">
          <!-- a href="javascript:;" class="btn_Dora_bs m-r" id="gobuy" onclick="document.form.submit();">确认代购</a-->
          <!-- a href="javascript:void%200" class="btn_Dora_bs" id="gohm" onclick="return false">发起合买</a-->
          </p>
</form>
        </div>
      </div>
  </div>
</div>
<!--提示层-->
<div class="tips_m" style="width: 692px; top: 1000px; display: none; position: absolute;" id="blk1">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2>竞彩足球奖金明细</h2>
        <span class="close"><a href="javascript:void(0)" id="close1">关闭</a></span> </div>
      <div style="height: 470px; overflow-y: auto; overflow-x: hidden;" class="tips_info">
        <div class="mx_tips">
          <p><strong class="red" id="prix_range">奖金范围：0-0元</strong></p>
          <h3>奖金分布</h3>
          <div id="hot_case"></div>
          <div id="hit_split"></div>
          <h3>投注分布</h3>
          <div id="tz_fenbu"></div>
          <p class="p_tb5 red" style="text-align:center">注：预测奖金为投注时的即时奖金，最终奖金以出票时刻的奖金为准。</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!--footer start-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<div id="ft">
  <textarea id="responseJson" style="display: none;">{
	period :      "",   //期号
	serverTime :  "<?php echo date("Y-m-d H:i:s");?>",   //服务器时间
	endTime :     "",    //截止时间
	singlePrice : 0,    //单注金额
	baseUrl : "<?php echo url::base();?>"  //网站根目录
}</textarea>
<!--未登录提示层-->
<?php echo View::factory('login')->render();?>
<!--默认提示层-->
  <div class="tips_m" style="display:none;" id="defLay">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
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
  <div class="tips_m" style="top:300px;display:none;" id="addMoneyLay">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>可用余额不足</h2>
          <span class="close" id="addMoneyClose"><a href="javascript:void%200">关闭</a></span> </div>
        <div class="tips_text">
          <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br>
            (点充值跳到“充值”页面，点“返回”可进行修改)</p>
        </div>
        <div class="tips_sbt">
          <input value="返 回" class="btn_Lora_b" id="addMoneyNo" type="button">
          <input value="充 值" class="btn_Dora_b" id="addMoneyYes" type="button">
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
  <div class="tips_m" style="top:700px;display:none;position:absolute" id="info_dlg">
    <div class="tips_b">
      <div class="tips_box">
        <div class="tips_title">
          <h2>温馨提示</h2>
          <span class="close" id="info_dlg_close"><a href="#">关闭</a></span> </div>
        <div class="tips_text">
          <div class="tips_ts" id="info_dlg_content" style="zoom:1"></div>
        </div>
        <div class="tips_sbt">
          <input value="确 定" class="btn_Dora_b" id="info_dlg_ok" type="button">
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
</div>

<div style="display: none;" id="#title_folat">
  <table class="dc_table" border="0" cellpadding="0" cellspacing="0" width="100%">
    <colgroup>
    <col width="9%">
    <col width="8%">
    <col width="8%">
    <col width="10%">
    <col width="4%">
    <col width="10%">
    <col width="15%">
    <col width="8%">
    <col width="8%">
    <col width="8%">
    <col width="8%">
    <col width="4%">
    </colgroup>
    <tbody>
      <tr>
        <th>赛事编号</th>
        <th>赛事类型</th>
        <th><select id="select_time">
            <option selected="selected" value="0">截止</option>
            <option value="1">开赛</option>
          </select></th>
        <th>主队</th>
        <th>让</th>
        <th>客队</th>
        <th><select id="select_pv" size="1">
            <option selected="selected" value="0">平均赔率</option>
            <option value="1">投注比例</option>
          </select></th>
        <th>数据</th>
        <th>胜</th>
        <th>平</th>
        <th>负</th>
        <th class="last_th">走势</th>
      </tr>
    </tbody>
  </table>
</div>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="<?php echo url::base();?>media/images/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="<?php echo url::base();?>media/images/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="<?php echo url::base();?>media/images/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
<div class="tips_m" style="top: 700px; display: none; position: absolute;" id="yclass_alert">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2 id="yclass_alert_title">温馨提示</h2>
        <span class="close" id="yclass_alert_close"><a href="#">关闭</a></span> </div>
      <div class="tips_text">
        <div class="tips_ts" id="yclass_alert_content" style="zoom:1"></div>
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
      <div class="tips_info" id="yclass_confirm_content" style="zoom:1"></div>
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
<div style="opacity: 0.2;" tabindex="-1" class="yclass_mask_panel"></div>
<div style="position: absolute; z-index: 500000; left: -99999px;">
  <div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51);"></div>
  <div style="position: absolute; left: 0pt; top: 0pt; display: none; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>
</body>
</html>