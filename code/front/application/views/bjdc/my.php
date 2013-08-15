<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-单场竞猜-我的方案</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
    'media/js/yclass.js?v=20110509',
	'media/js/loginer',
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
<body id="dzgd">
<?php echo View::factory('header')->render();?>
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>bjdc/rqspf"><font class="blue">单场竞猜</font></a> &gt; 我的方案
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
    	<span class="fl" id="jctop_left"><img src="<?php echo url::base();?>media/images/danchang.gif" width="76" height="63" /></span>
        <div class="fl" id="jctop_right">
<p id="jctop_rheight"><span class="fr gray6">销售时间：周一至周五 09:00～22:40  周六至周日 09:00～00:40</span><font class="font16 black heiti">5种玩法，30种过关方式，每天最多</font><font class="font24 orange heiti">99</font><font class="font16 black heiti">场赛事不间断，奖金天天派。</font></p>
      <div id="jc_menu" class="font14 bold">
            	<ul>
<li ><a href="<?php echo url::base();?>bjdc/rqspf"><span>让球胜平负</span></a></li>
<li ><a href="<?php echo url::base();?>bjdc/zjqs"><span>总进球数</span></a></li>
<li ><a href="<?php echo url::base();?>bjdc/sxds"><span>上下单双</span></a></li>
<li ><a href="<?php echo url::base();?>bjdc/bf"><span>比分</span></a></li>
<li ><a href="<?php echo url::base();?>bjdc/bqc"><span>半全场</span></a></li>
<li class="hover"><a href="<?php echo url::base();?>bjdc/my"><span>我的方案</span></a></li>
                </ul>
          </div>
        </div>
    </div>
     <div id="jingcai_bottom" class="fl"> 
	     <div class="dc_l"> <a href="/bjdc/my/end" title="已结算交易" <?php if($status == 'end'){echo 'class="on"';}?>><em>已结算交易</em></a> <a href="/bjdc/my/" <?php if($status == 'ing'){echo 'class="on"';}?> title="未结算交易"><em>未结算交易</em></a> </div>
	     <!-- span class="fr pt5"><a href="/buycenter/bjdc/"><img src="<?php echo url::base();?>media/images/btn3.gif" width="85" height="22" alt="参与合买" /></a></span-->
	     </div>
    <span class="zhangkai"></span>	
</div>
<!--content1 end-->
<!--header end-->
<div id="hd">
  <div id="main">
    <div class="content">
      <div class="c-wrap">
        <div class="c-inner">
          <div class="an_title">
            <h2>我参与的方案</h2>
          </div>
          <table class="rec_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="5%">
            <col width="20%">
            <col width="8%">
            <col width="13%">
            <col width="8%">
            <col width="10%">
            <col width="11%">
            <col width="13%">
            <col width="13%">
            <col width="12%">
            </colgroup>
            <tbody id="list_data">
              <tr class="">
                <th>排序</th>
                <th>玩法</th>
                <th class="th_name">发起人</th>
                <th>过关方式</th>
                <th>进度</th>
                <th class="fa_money">认购金额</th>
                <th class="fa_money">我的奖金</th>
                <th>认购时间</th>
                <th>操作</th>
              </tr>
              <tr class="form_tr2">
                <td colspan="9" class="error_ts5">没有找到相关的记录！</td>
              </tr>
            </tbody>
          </table>
          <div class="page" id="page_wrapper"></div>
        </div>
      </div>
      <b class="c-tl"></b> <b class="c-tr"></b> </div>
    <div class="content m-t" style="display:none">
      <div class="c-wrap">
        <div class="c-inner">
          <div class="an_title">
            <h2>我关注的方案</h2>
            <span><a href="http://zc.trade..com/useraccount/default.php?url=http://space..com/pages/useraccount/my_care.php" target="_blank">我关注的发起人</a></span> </div>
          <table class="rec_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="8%">
            <col width="8%">
            <col width="8%">
            <col width="8%">
            <col width="12%">
            <col width="12%">
            <col width="12%">
            <col width="8%">
            <col width="16%">
            <col width="8%">
            </colgroup>
            <tbody id="list_mydata">
              <tr class="">
                <th>排序</th>
                <th><a href="javascript:do_order('0')">期号<span class="asc_pub" id="sort0_img"></span></a></th>
                <th>玩法</th>
                <th class="th_name">发起人</th>
                <th class="fa_money"><a href="javascript:do_order('2')">方案金额<span class="asc_pub" id="sort2_img"></span></a></th>
                <th class="fa_money"><a href="javascript:do_order('3')">每份金额<span class="des_pub" id="sort3_img"></span></a></th>
                <th><a href="javascript:do_order('4')">进度<span class="asc_pub" id="sort4_img"></span></a></th>
                <th><a href="javascript:do_order('5')">发起时间<span class="des_pub" id="sort5_img"></span></a></th>
                <th>操作</th>
              </tr>
              <tr class="form_tr2">
                <td colspan="9" class="error_ts5">没有找到相关的记录！</td>
              </tr>
            </tbody>
          </table>
          <div class="page" id="page_mywrapper"></div>
        </div>
      </div>
      <b class="c-tl"></b> <b class="c-tr"></b> </div>
  </div>
</div>

  <input neme="search_detail_value" id="search_detail_value" value="" type="hidden">
  <!--用于保荐隐藏详细搜索的值-->
  <input name="currentkey" id="currentkey" value="1" type="hidden">
  <input name="currentsort" id="currentsort" value="asc" type="hidden">
  <input name="lotid" id="lotid" value="46" type="hidden">
  <input name="playid" id="playid" value="269" type="hidden">
  <input name="expect" id="expect" value="" type="hidden">
  <input name="pagesize" id="pagesize" value="8" type="hidden">
  <input name="reload" id="reload" value="1" type="hidden">
  <input name="currentkey2" id="currentkey2" value="renqi2" type="hidden">
  <input name="currentsort2" id="currentsort2" value="asc" type="hidden">
  <input name="currentkey_favor" id="currentkey_favor" value="favor_proid" type="hidden">
  <input name="currentsort_favor" id="currentsort_favor" value="desc" type="hidden">
  <input name="reload" id="reload" value="1" type="hidden">
  <script type="text/javascript">
	/**
	 * AJAX方式载入列表内容
	 */
	loadDataByUrl('/bjdc/my_ajax/<?php if($status == 'end'){echo 'end/';}?>','list_data');
	var lotid=Y.one('#lotid').value;
	function loadDataByUrl(url,idname)	{
		var list_table = Y.one('#'+idname);
		Y.ajax(
		{
			url:url,
			type:'GET',
			end:function(data)
			{
				var json;
				
				if(!data.error)
				{
					
					var max = 10;
					if(lotid==46 || lotid== 47)max = 9;
					if(json = Y.dejson(data.text))
					{
						if(json.islogin==0){
							if (list_table.rows[1] && /登录/.test(list_table.rows[1].innerHTML)) {
								return;
							}
							var oRow = list_table.insertRow(1);
							oRow.className = 'form_tr2';
							oRow.insertCell(0);
							oRow.cells[0].className = 'error_ts5';
							oRow.cells[0].colSpan   = max;
							oRow.cells[0].innerHTML = "您尚未登录，请先<a href=\"javascript:void(0)\" onclick=\"Y.postMsg('msg_login');\" style=\"font-weight:bold\">登录</a>。如果您不是会员，请先<a href=\"http://passport..com/pages/info/user/\" target=\"_blank\">注册</a>成为会员！";
							return;
						}							
						var oList = json.list_data;
						if(Y.isArray(oList))
						{
							Y.get('#'+idname+' tr').each(function(item, i){
								if(i>0){
									Y.removeNode(item)	
								}
							});
							if (typeof oList == 'object')
							{
							    oList.each(function(item, i){
									var oRow = list_table.insertRow(i+1);
									oRow.className = '';
									oRow.setAttribute('onmouseover','mouse_over(this)');
									oRow.setAttribute('onmouseout','mouse_out(this)');
									for (var j = 0; j < max; j++)
									{	
										oRow.insertCell(j);
										var classstr = '';
										if(lotid!=46 && lotid!= 47){
										    if(j==3)classstr = 'th_name';
										}else{
											if(j==2)classstr = 'th_name';
										}
										if(lotid!=46 && lotid!= 47){
											if(j==4)classstr = 'eng record';
										    if(j>=6 && j<=7)classstr = 'eng fa_money';
										}else{
											if(j>=5 && j<=6)classstr = 'eng fa_money';
										}
										oRow.cells[j].className = classstr;
										if ((Y.get('#lotid').val() == 9 || Y.get('#lotid').val() == 1 || Y.get('#lotid').val() == 10000 || Y.get('#lotid').val() == 15 || Y.get('#lotid').val() == 17 || Y.get('#lotid').val() == 46) && j == 4) {
											oRow.cells[j].style.textAlign = 'center'; //北单以及足彩居中显示
										}else if(j == 4){
											oRow.cells[j].style.textAlign = 'left'; //数字彩左边对齐
										}
										if(eval('oList[' + i + '].column' + j)){
										    oRow.cells[j].innerHTML = eval('oList[' + i + '].column' + j);
										}   
									}
								})
							} else {
								var oRow = list_table.insertRow(1);
								oRow.className = 'form_tr2';
								oRow.insertCell(0);
								oRow.cells[0].className = 'error_ts5';
								oRow.cells[0].colSpan   = max;
								oRow.cells[0].innerHTML = oList;
							}
							if(idname=='list_data'){
								Y.one('#page_wrapper').innerHTML = json.page_html;
							}else{
								Y.one('#page_mywrapper').innerHTML = json.page_html;
							}
						}else{
							Y.get('#'+idname+' tr').each(function(item, i){
								if(i>0){
									Y.removeNode(item)	
								}
							});							
							var oRow = list_table.insertRow(1);
							oRow.className = 'form_tr2';
							oRow.insertCell(0);
							oRow.cells[0].className = 'error_ts5';
							oRow.cells[0].colSpan   = max;
							oRow.cells[0].innerHTML = oList;
						}
					}
				}
			}
		});		
	}
	
	/**
	 * 列表排序
	 */
	function do_order(order_by) {
		var url = 'project_mycare_in.php?lotid=46';
		var sort = "asc";
		var img_obj_name = '#sort'+order_by+"_img";
		var currentkey = Y.one("#currentkey").value;
		var current_img = '#sort'+currentkey+"_img";
		if(currentkey != order_by){
			Y.one("#currentkey").value = order_by;
		}
		if(Y.one(current_img).className=="asc_time"){
			Y.one(img_obj_name).className = "des_time";
			if(order_by == currentkey){
			    Y.one(current_img).className = "des_time";
			}else{
				Y.one(current_img).className = "asc_pub";
			}
			var sort = "desc";
		}else{
			Y.one(img_obj_name).className = "asc_time";
			if(order_by == currentkey){
			    Y.one(current_img).className = "asc_time";
			}else{
				Y.one(current_img).className = "asc_pub";
			}
			var sort = "asc";			
		}
		if (/orderby=/i.test(url)) {
			url = url.replace(/(orderby=)\w+/i, '$1' + order_by);
		} else {
			url += '&orderby=' + order_by;
		}
		if (/sort=/i.test(url)) {
			url = url.replace(/(orderstr=)\w+/i, '$1' + sort);
		} else {
			url += '&orderstr=' + sort;
		}
		//alert(url);
		loadDataByUrl(url,'list_mydata');
	}
	do_order('1');
	

function mouse_over(obj) {
	obj.className    = 'th_on';
}
function mouse_out(obj) {
	obj.className    = '';
}
//显示更多
showMoreDiv = function (num){
	objname = "more_code"+num;
	objname2 = "more_str"+num;
	if(Y.one('#'+objname).style.display=='none'){
		Y.one('#'+objname2).innerHTML = "隐藏";
		Y.one('#'+objname).style.display = 'block';
	}else{
		Y.one('#'+objname2).innerHTML = "更多";
		Y.one('#'+objname).style.display = 'none';
	}
}
Y.ready(function(){
	Y.get('#list_data').live('a[data-help]','mouseover',function(){
		Y.getTip().show(this, this.getAttribute('data-help')); 
	}).live('a[data-help]','mouseout',function(){
		Y.getTip().hide()
	})
})
</script>
  <!--footer start-->
  <span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
  <!--footer end-->
 <div id="ft">
  <textarea id="responseJson" style="display: none;">{
	period :      "",   //期号
	serverTime :  "2011-06-30 10:42:50",   //服务器时间
	endTime :     "",    //截止时间
	singlePrice : 0,   //单注金额
	baseUrl : "http://zc.trade..com"  //网站根目录
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
