<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足彩胜负-合买大厅</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js',
	'media/js/loginer',
), FALSE);
echo html::stylesheet(array
(
 	'media/css/hemai',
	'media/css/mask',
    'media/css/style',
    'media/css/css1',
), FALSE);
?>
<style>
.ie6hide select {
	_visibility:hidden;
}
</style>
<script type="text/javascript">
var submit_url="zcsf/viewdetail_join/";
var submit_url_join="zcsf/submit_buy_join";
function dingzhi(fuid,lotyid,playid){		
	Y.postMsg('msg_login', function (){
		var url = baseUrl+"/user_auto_order/getuidfuid/";
		Y.ajax(
		{
			url: url,
			type:'GET',
			end:function(data)
			{
				var json = Y.dejson(data.text);			
				if(json.uid!=fuid){
					var h = 307;
					if (Y.ie == 6) {
						h = 332;
					}
					Y.openUrl("/user_auto_order/add/"+lotyid+"/"+playid+"/"+fuid,475,h)
				}					
			}
		});
	})
}
</script>
</head>
<body>
<?php echo View::factory('header')->render();?> 
<!--menu和列表_end--> 
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>zcsf/sfc_14c"><font class="blue">足彩胜负</font></a> &gt; 合买大厅
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--header end-->
<div id="bd" class="clearfix m-t"> <?php echo View::factory('buycenter_menu')->render();?>
  <div class="fl mt15" id="buy_right">
    <div id="jc_menu" class="font14 bold buy_rmenu">
      <ul>
        <li<?php if($play_method==1){echo ' class="hover"'; } ?>><span><a href="/buycenter/sfc_14c">十四场胜负彩</a></span></li>
        <li<?php if($play_method==4){echo ' class="hover"'; } ?>><span><a href="/buycenter/sfc_4c">进球彩</a></span></li>
        <li<?php if($play_method==2){echo ' class="hover"'; } ?>><span><a href="/buycenter/sfc_9c">九场胜负彩</a></span></li>
        <li<?php if($play_method==3){echo ' class="hover"'; } ?>><span><a href="/buycenter/sfc_6c">六场半全</a></span></li>
      </ul>
    </div>
  </div>
  <div id="container">
    <div class="hmzx-top"><span class="l"><strong>足彩胜负合买方案</strong><span>第<b><?php echo $expect_data['expect_num'];?></b>期&nbsp;&nbsp;<span id="endtimelist">截止时间：<?php echo date("m-d H:i",strtotime($expect_data['end_time']))?>（单式：<?php echo date("H:i",strtotime($expect_data['end_time'])-1200)?>）
    <?php /*<a href="javascript:void 0" class="jy_more" id="xianhao1" data-help="≥20万以上方案：<span >08-12 21:30</span><br>≥5万以上方案：<span >08-12 22:15</span><br>">更多截止时间</a>*/ ?>
    </span></span></span>
    <a href="/zcsf/sfc_<?php echo $expect_data['expect_type'];?>c" title="" class="r" target="_blank">发起合买&gt;&gt;</a></div>
    <div class="hm-plan">
      <div class="content">
        <div class="c-wrap">
          <div class="c-inner">
            <div class="an_title p-l0">
              <ul class="l" id="stype_t">
                <li onclick="javascript:do_change(1,1);showalla();" class="an_cur" >全部方案</li>
                <li onclick="javascript:do_search(2,3,2);" class="" >单式方案</li>
                <li onclick="javascript:do_search(2,1,3);" class="" >复式方案</li>
              </ul>
              <em class="an_top" style="_padding-top:5px;"></em> <span>
              <select id="periodSelection" name="periodSelection" onchange="do_search(3,'')">
                
                <?php rsort($expect_data['expects']);
						 foreach($expect_data['expects'] as $value) { if ($value==$expect_data['expect_num']) {?>
               			 <option value="<?php echo $value;?>|2011-08-14 19:50:00|2" style="color:#FF0000" selected="selected"><?php echo $value;?> 当前期</option>
				<?php }else{ ?>    
                		<option value="<?php echo $value;?>|2011-08-14 19:50:00|2" style="color:#FF0000"><?php echo $value;?> 预售期</option>	
				<?php }} ?>                
              
                <?php for($i=1;$i<=7;$i++) { ?>
                		 <option value="<?php echo ($expect_data['expect_num']-$i);?>|2011-07-29 22:50:00|1"  style="color:#888888"><?php echo ($expect_data['expect_num']-$i);?></option>
				<?php } ?>            

              </select>
              </span> </div>
            <div class="c-search"> <span class="l">
              <input type="text" id="findstr" class="c-s-txt" value="请输入用户名" onfocus="this.value=='请输入用户名'?this.value='':this.value" onblur="this.value==''?this.value='请输入用户名':this.value" onkeydown='enter_search(event)'/>
              <input type="button" name="srearch" class="m-r btn_Lblue_s" value="搜索" onclick="do_search(1,Y.one('#findstr').value)"/>
              <span class="c-s-hot"><?php /*?>热门搜索：<a href='javascript:void(0)' onclick="do_search(1,'傻帽')">傻帽</a><?php */?> </span></span> <span class="r">
              <select name="playid_term" id="playid_term" class="m-r" onchange="do_search(2,'')">
                <option selected="selected" value="0">全部玩法</option>
                <option value="1">复式</option>
                <option value="3">单式</option>
              </select>
              <select name="state_term" id="state_term" class="m-r" onchange="do_search(2,'')">
                <option value="0">满员</option>
                <option value="1" selected="selected">未满员</option>
                <option value="2">已撤单</option>
                <option value="-1">全部</option>
              </select>
              </span> </div>
            <div id="title_folat" style="display:none"">
              <table width="100%" cellspacing="0" cellpadding="0" border="0" class="rec_table">
                <colgroup>
                <col width="6%" />
                <col width="18%" />
                <col width="12%" />
                <col width="10%" />
                <col width="10%" />
                <col width="8%" />
                <col width="10%" />
                <col width="8%" />
                <col width="18%" />
                </colgroup>
                <tbody>
                  <tr class="">
                    <th>排序</th>
                    <th class="th_name">发起人</th>
                    <th class="fa_money"><a href="#" title="">方案金额<span class="asc_pub"></span></a></th>
                    <th class="fa_money"><a href="#" title="">每份金额<span class="des_pub"></span></a></th>
                    <th>方案内容</th>
                    <th><a href="#" title="">进度<span class="des_time"></span></a></th>
                    <th><a href="#" title="">剩余份数<span class="asc_pub"></span></a></th>
                    <th>认购份数</th>
                    <th>操作</th>
                  </tr>
                </tbody>
              </table>
            </div>
            <div id="list_data">
              <table width="100%" cellspacing="0" cellpadding="0" border="0" class="rec_table">
                <colgroup>
                <col width="5%"/>
                <col width="18%"/>
                <col width="10%"/>
                <col width="11%"/>
                <col width="10%"/>
                <col width="10%"/>
                <col width="10%"/>
                <col width="10%"/>
                <col width="10%"/>
                </colgroup>
                <tbody>
                  <tr class="">
                    <th>排序</th>
                    <th class="th_name">发起人</th>
                    <th class="fa_money"><a href="#" title="">方案金额<span class="asc_pub"></span></a></th>
                    <th class="fa_money"><a href="#" title="">每份金额<span class="des_pub"></span></a></th>
                    <th>方案内容</th>
                    <th><a href="#" title="">进度<span class="des_time"></span></a></th>
                    <th><a href="#" title="">剩余份数<span class="asc_pub"></span></a></th>
                    <th>认购份数</th>
                    <th>操作</th>
                  </tr>
                  <tr class="">
                    <td colspan="9"></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="page clearfix" id="changesize"> <span id="page_wrapper"></span> </div>
            <div class="c-intro">
              <dl class="clearfix m-t20">
                <!--<dt>*%+*%保： </dt>-->
                <dd>
                  <ol class="c-i-list">
                    <li>1）保指保底，保底是由发起人设定在合买截止时，如果方案尚未满员，将以保底时所承诺的金额最大限度的促进方案满员。保底金额最低为方案总金额的20%。</li>
                    <li>2）*%+*%保，指进度百分比+保底百分比。</li>
                  </ol>
                </dd>
              </dl>
            </div>
          </div>
        </div>
        <b class="c-tl"></b> <b class="c-tr"></b> </div>
    </div>
  </div>
</div>
<!--footer start--> 
<span class="zhangkai"></span> <?php echo View::factory('footer')->render();?> 
<!--footer end-->
<div id="ft">
<input name="currentkey" id="currentkey" value="renqi" type="hidden">
<input name="currentsort" id="currentsort" value="DESC" type="hidden">
<input name="stype" id="stype" value="1" type="hidden">
<input name="ttype" id="ttype" value="0" type="hidden">
<input name="lotid" id="lotid" value="9" type="hidden">
<textarea id="responseJson" style="display: none;">{
	period :      "<?php echo $expect_data['expect_num'];?>",   //期号
	serverTime :  "<?php echo date("Y-m-d H:m:s");?>",   //服务器时间
	endTime :     "<?php echo $expect_data['end_time'];?>",    //截止时间
	singlePrice : 2,   //单注金额
	baseUrl : "<?php echo url::base();?>"  //网站根目录
}</textarea>
<?php echo View::factory('zcsf/public_div')->render();?>
<div class="tips_m" style="top: 315px; display: none; position: absolute;" id="dlg_buysuc">
  <div class="tips_b">
    <div class="tips_box">
      <div class="tips_title">
        <h2>购买成功</h2>
        <span class="close"><a href="javascript:void%200" id="dlg_buysuc_close">关闭</a></span> </div>
      <div class="tips_info">
        <div class="icon_suc">
          <div class="txt_suc" id="dlg_buysuc_content">您好，恭喜您购买成功!</div>
          祝您中大奖！</div>
        <div class="suc_link">您还可以选择：
        <a href="javascript:void%200" id="dlg_buysuc_back">返回继续购买</a> 
        | <a href="/buycenter/" target="_blank">购买其它玩法</a><br>
          查看我的帐户：<a href="/user/capital_changes" target="_blank">帐户明细</a> 
        | <a href="/user/betting" target="_blank">投注记录</a> 
        | <a href="/user/recharge" target="_blank">在线充值</a>
        </div>
      </div>
      <div class="tips_sbt">
        <input value="关　闭" class="btn_Lora_b" id="dlg_buysuc_close2" type="button">
      </div>
    </div>
  </div>
</div>
<div class="tips_m" style="position:absolute; top:200px; width:600px;left:400px;display:none;" id="cFfilter">
  <div class="tips_b">
    <div class="tips_box">
      <div style="cursor: move;" class="tips_title">
        <h2>方案筛选</h2>
        <span class="close"><a href="javascript:void%200" id="cFfilter_close" onclick="Y.one('#cFfilter').style.display='none';document.body.className=''">关闭</a></span> </div>
      <div class="c-filter">
        <ul id="cFfilterin">
          <li ref="playid_s">方案类型：<span id="bxspan"><a href="javascript:void(0)" title="" class="c-f-on" data-val="0">不限</a> | </span> <a href="#" title="" data-val="150">单式</a><a href="#" title="" data-val="34">复式</a> </li>
          <li ref="state_s">方案状态：<a href="javascript:void(0)" title="" data-val="-1">不限</a> | <a href="javascript:void(0)" title="" data-val="1" class="c-f-on">未满员</a><a href="javascript:void(0)" title="" data-val="0">满员</a><a href="javascript:void(0)" title="" data-val="2">已撤单</a></li>
          <li ref="promoney_s">方案金额：<a href="#" title="" data-val="0" class="c-f-on">不限</a> | <a href="#" title="" data-val="1">100元以下</a><a href="#" title="" data-val="2">100元-500元</a><a href="#" title="" data-val="3">501元-1000元</a><a href="#" title="" data-val="4">1000元以上</a></li>
          <li ref="proplan_s">方案进度：<a href="#" title="" data-val="0" class="c-f-on">不限</a> | <a href="#" title="" data-val="1">50%以下</a><a href="#" title="" data-val="2">50%-90%</a><a href="#" title="" data-val="3">90%以上</a></li>
          <li ref="onemoney_s">每份金额：<a href="#" title="" data-val="0" class="c-f-on">不限</a> | <a href="#" title="" data-val="1">1元</a><a href="#" title="" data-val="2">1元以上-5元</a><a href="#" title="" data-val="3">5元以上</a></li>
          <li ref="baodi_s">是否保底：<a href="javascript:void(0)" title="" data-val="-1" class="c-f-on">不限</a> | <a href="javascript:void(0)" title="" data-val="0">已保底</a><a href="javascript:void(0)" title="" data-val="1">未保底</a></li>
          <li ref="tichen_s" style="display:">方案提成：<a href="#" title="" data-val="-1" class="c-f-on">不限</a> | <a href="#" title="" data-val="0">0</a><a href="#" title="" data-val="1">1%-4%</a> </li>
        </ul>
        <ul id="cFfilterxin">
        </ul>
        <span class="c-f-ok"><a href="javascript:do_search(4,'');" title="" class="public_Dblue"><b>开始筛选</b></a><a href="javascript:void(0)" title="" class="gray m-l" onclick="clearAll()">重置条件</a></span> </div>
    </div>
  </div>
</div>
<input value="0|全部玩法,34|胜平负复式,40|总进球数复式,41|上下单双复式,42|比分复式,51|半全场复式,150|胜平负单式,151|总进球数单式,152|上下单双单式,153|比分单式,154|半全场单式" name="selval" id="selval" type="hidden">
<!--认购成功层-->

<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control"><img src="buy_center_files/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77"> <img src="buy_center_files/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;"> <img id="monitor-play-button" src="buy_center_files/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div>
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
<div style="z-index: 500001; position: absolute; top: 167px; left: -99999px;">
  <div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51);"><img alt="正在加载..." src="images/loading.gif"></div>
  <div style="position: absolute; left: 0pt; top: 0pt; display: none; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
<div class="notifyicon tip-2">
  <div class="notifyicon_content"></div>
  <div class="notifyicon_arrow"><s></s><em></em></div>
  <div class="notifyicon_space"></div>
</div>
</body>
</html>
<script type="text/javascript">
    var baseUrl = "<?php echo url::base();?>";
    var imgurl = '<?php echo url::base();?>media/images';
    var lotid = '2';
    var url = '<?php echo $ajax_url;?>';
    </script>
<?php
echo html::script(array
(
    'media/js/list.js',
), FALSE);
?>
</body>
</html>
