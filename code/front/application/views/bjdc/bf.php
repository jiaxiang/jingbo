<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-单场竞猜-比分</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<style type="text/css">
#vs_table label, #vs_table input { cursor:pointer; }
#league_selector { width:180px; }
#league_selector li { width:90px; }
table { border-collapse:separate;  }
</style>
<?php
echo html::script(array
(
    'media/js/yclass.js?v=20110509',
	'media/js/loginer',
	'media/js/bjdc.js?v=201109270',
	'media/js/bjdc_bf',
	'media/js/confirm_form',
	'media/js/zhushu_calculator',
	'media/js/prize_predict',
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
		<a href="<?php echo url::base();?>bjdc/rqspf"><font class="blue">单场竞猜</font></a> &gt; 比分
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width jingcai_box ">
  <div class="fl" id="jingcai_top"> <span class="fl" id="jctop_left"><img src="<?php echo url::base();?>media/images/danchang.gif"  /></span>
    <div class="fl" id="jctop_right">
<p id="jctop_rheight"><span class="fr gray6"></span><font class="font16 black heiti">5种玩法，30种过关方式，每天最多</font><font class="font24 orange heiti">130</font><font class="font16 black heiti">场赛事不间断，奖金天天派。</font></p>
      <div id="jc_menu" class="font14 bold">
        <ul>
<li ><a href="<?php echo url::base();?>bjdc/rqspf"><span>让球胜平负</span></a></li>
<li ><a href="<?php echo url::base();?>bjdc/zjqs"><span>总进球数</span></a></li>
<li ><a href="<?php echo url::base();?>bjdc/sxds"><span>上下单双</span></a></li>
<li class="hover"><a href="<?php echo url::base();?>bjdc/bf"><span>比分</span></a></li>
<li ><a href="<?php echo url::base();?>bjdc/bqc"><span>半全场</span></a></li>
<li ><a href="<?php echo url::base();?>bjdc/my"><span>我的方案</span></a></li>
        </ul>
      </div>
    </div>
  </div>
  <div id="jingcai_bottom" class="fl">
    <div class="dc_l"> <a href="<?php echo url::base();?>bjdc/bf" title="普通投注" class="on" ><em>普通投注</em><s></s></a> <!-- a href="zqdc_spf_ds.html" title="单式投注" ><em>单式投注</em><s></s></a--> </div>
    <span class="fr pt5 gray6 mr10" style="color: rgb(255, 0, 0); ">截止时间：赛前20分钟</span></div>
  <span class="zhangkai"></span> </div>
<!--content1 end-->
<!--header end-->
<div id="bd">
  <div id="main" class="main_dc clearfix">
		<div class="dc_l">
			<div class="box_top">
				<div class="box_top_l"></div><a name="top"></a>
			</div>

			<div class="box_m">
				
				<div class="dc_l_t">
	<div class="dc_l_tl">

		<div class="dc_all_w" style="display:none;">
			<a href="javascript:void(0)" id="match_show" class="dc_all_s">全部比赛<s class="c_down"></s></a>
			<div class="hide_bs" style="display:none" id="match_filter">
				<ul>
					<li><a href="javascript:void(0)" value="all">全部比赛</a></li>
										<li><a href="javascript:void(0)" value="rank">排名相差10</a></li>
				</ul>
			</div>
		</div>
		<span class="mie7">
						<label><input id="ck_out_of_date" type="checkbox">已截止[<span class="red" id="out_of_date_tag">0场</span>]</label>&nbsp;
			已隐藏 <span class="eng"><a href="javascript:void(0)" class="a_num" id="hidden_matches_num">0</a></span> 场
		</span>
	</div>
	
	<div class="dc_l_tr">
		<div class="dc_ls_w">
			<div class="dc_ls_n" style="display: none;" id="league_selector">
				<ul class="clearfix">
				<?php 
				$objmatch = match::get_instance();
				if (!isset($match_league)) $match_league = array();
				foreach ($match_league as $key => $val) {
				?>
				<li><label><input class="chbox" checked="checked" value="<?=$key?>" type="checkbox">
				<span style="padding:2px 4px;color:#FFF;background:<?=$objmatch->get_match_color($key)?>"><?=$key?></span>[<?=$val?>]</label></li>
				<?php 
				}
				?>
				</ul>
				<div class="ls_n_b" style="text-align:center">
					<a href="javascript:void(0)" class="btn_Lblue_s" id="select_all_league">全选</a>
					<a href="javascript:void(0)" class="btn_Lblue_s" id="select_opposite_league">反选</a>
				</div>
			</div>
			<a href="javascript:void(0)" id="league_show" class="ls_s_btn">联赛选择</a>
		</div>
	</div>
</div>

				<div class="dc_l_m">
					
					<!-- bof 比赛对阵表头 -->
					<table class="dc_table" id="vs_table_header" border="0" cellpadding="0" cellspacing="0" width="100%">
						<colgroup>
								<col width="40">
								<col width="60">
								<col width="40">
								<col width="80">
								<col width="27">
								<col width="80">
								<col width="64">
								<col width="50">
                                <col width="178">
						</colgroup>
						<tbody>
							<tr class="">
								<th>场次</th>
								<th>赛事</th>
								<th>截止</th>
								<th>主队</th>
								<th>让</th>
								<th>客队</th>
								<th>数据</th>
								<th>开奖sp</th>
								<th class="last_th">选择投注</th>
							</tr>
						</tbody>
					</table>
					<!-- eof 比赛对阵表头 -->
<div class="left_overflow"> 
					<table class="dc_table" id="vs_table" border="0" cellpadding="0" cellspacing="0" width="100%">
						<colgroup>
								<col width="41">
								<col width="61">
								<col width="41">
								<col width="79">
								<col width="28">
								<col width="79">
								<col width="65">
								<col width="50">
								<col width="178">
						</colgroup>
<?php 
if (!isset($match_datetime)) $match_datetime = array();
foreach ($match_datetime as $key => $val) {
?>
<tbody>
<tr id="switch_for_<?=$key?>">
	<td colspan="10" class="dc_hs" style="line-height: 16px; height: 16px; ">
		<strong><?=$key?> <?=$val?> (10：00--次日10：00)</strong>&nbsp;
		<a href="javascript:void(0)" onclick="Yobj.postMsg('msg_show_or_hide_matches', '<?=$key?>', this)">隐藏<s class="c_up"></s></a>
	</td>
</tr>
</tbody>
<tbody id="<?=$key?>">
<?php
	for ($i = 0; $i < count($data); $i++) {
		if (date("Y-m-d", strtotime($data[$i]['playtime'])) != $key) continue;
		if ($data[$i]['stoptime'] >= tool::get_date()) {
			$disable = 'no';
			$style = '';
		}
		else {
			$disable = 'yes';
			$style = 'display:none';
		}
		$goalclass = $data[$i]['goalline'];
		if ($data[$i]['goalline'] > 0) {
			$goalclass = '<strong class="eng red">+'.$data[$i]['goalline'].'</strong>';
		}
		if ($data[$i]['goalline'] < 0) {
			$goalclass = '<strong class="eng green">'.$data[$i]['goalline'].'</strong>';
		}
		$sp = json_decode($data[$i]['sp']);
		//if ($sp == NULL) continue;
?>
<tr style="<?=$style?>" class="vs_lines" value="{index:'<?=$data[$i]['match_no']?>',leagueName:'<?=$data[$i]['league']?>',homeTeam:'<?=$data[$i]['home']?>',guestTeam:'<?=$data[$i]['away']?>',endTime:'<?=substr($data[$i]['stoptime'], 0, -3)?>',rangqiuNum:<?=$data[$i]['goalline']?>,scheduleDate:'<?=$key?>',disabled:'<?=$disable?>',bgColor:'<?=$objmatch->get_match_color($data[$i]['league'])?>'}">
<td><!-- 场次编号 -->
<input checked="checked" class="chbox" style="cursor: default;" type="checkbox">
<span class="chnum"><?=$data[$i]['match_no']?></span>
</td>
<td style="background: none repeat scroll 0% 0% <?php if ($data[$i]['match_color'] != null) echo $data[$i]['match_color'];else echo $objmatch->get_match_color($data[$i]['league']);?>; color: rgb(255, 255, 255);" class="league">
<!-- 赛事类型 -->
<a href="<?php if($data[$i]['match_url'] != null) echo $data[$i]['match_url'];?>" target="_blank"><?=$data[$i]['league']?></a>
</td>
<td title="比赛时间：<?=$data[$i]['playtime']?>">
<span class="eng"><?=substr($data[$i]['stoptime'], 10, 6)?></span>
<!-- 截止时间 -->
</td>
<td class="tr"><span class="gray"></span><!-- 主队 -->
<a href="<?php if($data[$i]['home_url'] != null) echo $data[$i]['home_url'];?>" title="<?=$data[$i]['home']?>" target="_blank"><?=$data[$i]['home']?></a>
</td>
<td><!-- 让球数 -->
<strong><?=$goalclass?></strong></td>								
<td class="tl"><!-- 客队 -->
<a href="<?php if($data[$i]['away_url'] != null) echo $data[$i]['away_url'];?>" title="<?=$data[$i]['away']?>" target="_blank"><?=$data[$i]['away']?></a>
<span class="gray"></span>
</td>

<td class="h_br">
<a href="<?php if($data[$i]['xi_url'] != null) echo $data[$i]['xi_url'];?>" target="_blank">析</a> 
<a href="<?php if($data[$i]['ya_url'] != null) echo $data[$i]['ya_url'];?>" target="_blank">亚</a> 
<a href="<?php if($data[$i]['ou_url'] != null) echo $data[$i]['ou_url'];?>" target="_blank">欧</a>
</td>

<td class="h_br"><!-- 开奖SP -->
<span class="eng red"><?php if ($data[$i]['sp_r'] != NULL) echo $data[$i]['sp_r'];?></span>
</td>
<td>
<a class="<?php if ($i > 0) echo 'public_Lblue'; else echo 'public_Dora';?> bf_btn expand_sp" href="javascript:void(0)"><b><?php if ($i > 0) echo '展开SP值'; else echo '隐藏SP值';?><s class="<?php if ($i > 0) echo 'c_down'; else echo 'c_up';?>"></s></b></a>
</td>
</tr>

<tr class="hide_b" style="<?php if ($style == '') {if ($i > 0) echo 'display:none;';} else echo $style;?>" id="sp_lines_<?=$data[$i]['match_no']?>">
<td colspan="10">
<table class="hide_table" border="0" cellpadding="0" cellspacing="0" width="100%">
<colgroup>
<col width="37">
<col width="64">
<col width="64">
<col width="64">
<col width="64">
<col width="64">
<col width="64">
<col width="64">
<col width="64">
<col width="64">
<col width="64">
<col width="">											
</colgroup>
<tbody>
<tr class="sheng">
<td>胜</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="胜其他" onclick="return false" type="checkbox"><span class="f_bf">胜其他</span><br>
(<span class="sp_value"><?=$sp->{'10'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="1:0" onclick="return false" type="checkbox"><span class="f_bf">1:0</span><br>
(<span class="sp_value"><?=$sp->{'1'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="2:0" onclick="return false" type="checkbox"><span class="f_bf">2:0</span><br>
(<span class="sp_value"><?=$sp->{'2'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="2:1" onclick="return false" type="checkbox"><span class="f_bf">2:1</span><br>
(<span class="sp_value"><?=$sp->{'4'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="3:0" onclick="return false" type="checkbox"><span class="f_bf">3:0</span><br>
(<span class="sp_value"><?=$sp->{'3'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="3:1" onclick="return false" type="checkbox"><span class="f_bf">3:1</span><br>
(<span class="sp_value"><?=$sp->{'5'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="3:2" onclick="return false" type="checkbox"><span class="f_bf">3:2</span><br>
(<span class="sp_value"><?=$sp->{'7'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="4:0" onclick="return false" type="checkbox"><span class="f_bf">4:0</span><br>
(<span class="sp_value"><?=$sp->{'9'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="4:1" onclick="return false" type="checkbox"><span class="f_bf">4:1</span><br>
(<span class="sp_value"><?=$sp->{'6'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="4:2" onclick="return false" type="checkbox"><span class="f_bf">4:2</span><br>
(<span class="sp_value"><?=$sp->{'8'}?></span>)
</label>
</td>
<td class="last_td" style="cursor: pointer;">
<input class="chbox vs_check_all_win" onclick="return false" type="checkbox">包</td>
</tr>
<tr class="ping">
<td>平</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="平其他" onclick="return false" type="checkbox"><span class="f_bf">平其他</span><br>
(<span class="sp_value"><?=$sp->{'15'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="0:0" onclick="return false" type="checkbox"><span class="f_bf">0:0</span><br>
(<span class="sp_value"><?=$sp->{'11'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="1:1" onclick="return false" type="checkbox"><span class="f_bf">1:1</span><br>
(<span class="sp_value"><?=$sp->{'12'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="2:2" onclick="return false" type="checkbox"><span class="f_bf">2:2</span><br>
(<span class="sp_value"><?=$sp->{'13'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="3:3" onclick="return false" type="checkbox"><span class="f_bf">3:3</span><br>
(<span class="sp_value"><?=$sp->{'14'}?></span>)
</label>
</td>
<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<td class="last_td" style="cursor: pointer;">
<input class="chbox vs_check_all_draw" onclick="return false" type="checkbox">包</td>
</tr>
<tr class="fu">
<td>负</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="负其他" onclick="return false" type="checkbox"><span class="f_bf">负其他</span><br>
(<span class="sp_value"><?=$sp->{'25'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="0:1" onclick="return false" type="checkbox"><span class="f_bf">0:1</span><br>
(<span class="sp_value"><?=$sp->{'16'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="0:2" onclick="return false" type="checkbox"><span class="f_bf">0:2</span><br>
(<span class="sp_value"><?=$sp->{'17'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="1:2" onclick="return false" type="checkbox"><span class="f_bf">1:2</span><br>
(<span class="sp_value"><?=$sp->{'18'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="0:3" onclick="return false" type="checkbox"><span class="f_bf">0:3</span><br>
(<span class="sp_value"><?=$sp->{'18'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="1:3" onclick="return false" type="checkbox"><span class="f_bf">1:3</span><br>
(<span class="sp_value"><?=$sp->{'20'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="2:3" onclick="return false" type="checkbox"><span class="f_bf">2:3</span><br>
(<span class="sp_value"><?=$sp->{'22'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="0:4" onclick="return false" type="checkbox"><span class="f_bf">0:4</span><br>
(<span class="sp_value"><?=$sp->{'24'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="1:4" onclick="return false" type="checkbox"><span class="f_bf">1:4</span><br>
(<span class="sp_value"><?=$sp->{'21'}?></span>)
</label>
</td>
<td class="vs_td ">
<label class="eng">
<input class="chbox" value="2:4" onclick="return false" type="checkbox"><span class="f_bf">2:4</span><br>
(<span class="sp_value"><?=$sp->{'23'}?></span>)
</label>
</td>
<td class="last_td" style="cursor: pointer;">
<input class="chbox vs_check_all_lose" onclick="return false" type="checkbox">包</td>
</tr>

</tbody>
</table>
</td>
</tr>
<?php
	} 
?>
</tbody>
<?php
	
} 
?>
</table>
</div>
				</div>
			</div>
			<a style="left: 992px; position: fixed; bottom: 10px; display: none;" title="回到顶部" class="back_top" href="#top" hidefocus="true">回到顶部</a>
		</div>
		<input id="stop_sale" value="no" type="hidden">
		<input id="all_matches" value="52" type="hidden">
		<input id="out_of_date_matches" value="0" type="hidden">
<div class="dc_r" id="right_area">
	<div class="box_top">
		<div class="box_top_l"></div>
	</div>

	<div class="box_m">
		<div class="dc_r_t" style="text-align:left;padding-left:5px">
			方案截止时间：<span class="eng red" id="endtime"></span>
		</div>
		<div class="dc_r_m">
			<h2>1、确认投注信息</h2>
			<table class="dcr_table" border="0" cellpadding="0" cellspacing="0" width="100%">
				<colgroup>
					<col width="40">
										<col>
										<col width="26">
				</colgroup>
				<thead>
					<tr>
						<th>场次</th>
						<th>比赛</th>
												<th>胆</th>
					</tr>
				</thead>
				<tbody id="touzhu_table">
					
				</tbody>
			</table>
		</div>
		
		<div class="dc_r_m">
			<h2>2、选择过关类型</h2>
			<div class="an_title" id="gg_type">
				<ul>
					<li id="a1" class="an_cur" value="自由过关">自由过关</li>
					<li id="a2" value="多串过关">多串过关</li>
				</ul>
			</div>
			<table class="dcr_table marb" id="gg_table" border="0" cellpadding="0" cellspacing="0" width="100%">
				<colgroup>
					<col width="66">
					<col width="66">
					<col width="66">
				</colgroup>
				<tbody>

				</tbody>
			</table>
		</div>

		<div class="dc_r_m">
			<h2>3、确认投注结果</h2>
			<p class="dc_qr">
				投注&nbsp;<input class="mul" id="beishu_input" value="1" maxlength="6" type="text">倍(必须为整数)<br>
				您选择了 <span class="eng red" id="match_num">0</span> 场比赛，共 <span class="eng red" id="zhushu">0</span> 注，<br>
				总金额 <strong class="eng red" id="total_sum">￥0</strong>元<br>
				奖金预测：<span style="display:none" id="jiangjinYS" class="red">0-0</span> <!-- a href="javascript:void(0)" id="see_prize_predict">查看明细</a--><a href="#ckmx" >查看明细</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" id="clear_all">清空所选</a>
			</p>
			<p class="dc_r_btn" style="position:relative">
			<a href="#" onclick="return false" class="btn_Dora_bs m-r" id="dg_btn">确认代购</a>
			<!-- a href="#" onclick="return false" class="btn_Dora_bs" id="hm_btn">发起合买</a--></p>
			<div style="clear:both"></div>
		</div>
		<div style="clear:both"></div>
	</div>
	<div style="clear:both"></div>
</div>
<input id="max_money" value="200000" type="hidden">
<input id="min_money" value="2.000000" type="hidden">	</div>
<div class="width zzdetail" id="zzdetail"><a name="ckmx"></a>
  <table width="100%" cellspacing="0" cellpadding="0" border="0" style="table-layout:fixed">
      <tr>
        <th width="100">注号</th>
        <th width="120">过关方式</th>
        <th>注项内容</th>
        <th width="200" class="last_th">奖金</th>
      </tr>
      <tr style="display: none;" id="zzchoose_tpl">
        <td>1</td>
        <td>3串1</td>
        <td class="tl">周四003(胜)x周四004(胜)</td>
        <td class="last_td">53.23元</td>
      </tr>
  </table>
  </div>
</div><!-- eof "bd" -->

<!-- 奖金预测弹窗 -->
<div id="prize_predict" style="display: none; width: 692px; position: absolute;" class="tips_m">
	<div class="tips_b">
		<div class="tips_box">
			<div class="tips_title" style="cursor: move;">
				<h2>足球单场奖金预测</h2>
				<span class="close"><a href="javascript:void(0)">关闭</a></span>
			</div>
			<div class="tips_info" style="height:400px; overflow-y:auto">
				<div class="mx_tips">
					
					<h3 class="red">投注内容</h3>
					<table class="m-t" border="0" cellpadding="0" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>场次</th>
								<th>比赛</th>
																<th>您的选择</th>
								<th>最大SP值</th>
								<th>最小SP值</th>
								<th class="last_th">胆码</th>
							</tr>
						</thead>
						<tbody id="table1">
						</tbody>
					</table>

					<table class="m-t" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody id="table2">
						</tbody>
					</table>

					<table class="m-t" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tbody id="table3">
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
<input id="lotid" name="lotid" value="9" type="hidden">
<input id="playid" name="playid" value="42" type="hidden">
<input id="expect" name="expect" value="<?=$current_issue?>" type="hidden">
<input id="ishm" name="ishm" value="0" type="hidden">
<!--footer start-->
<span class="zhangkai"></span>
<?php echo View::factory('footer')->render();?>
<!--footer end-->
<div id="ft">
<textarea id="responseJson" style="display: none;">{
	period :      "110707",   //期号
	serverTime :  "2011-07-12 17:59:30",   //服务器时间
	endTime :     "2011-07-14 03:30:00",    //截止时间
	singlePrice : 2,   //单注金额
	baseUrl : "http://zc.trade..com"  //网站根目录
}</textarea>
<!--未登录提示层-->
<?php echo View::factory('login')->render();?>
<!--默认提示层-->
<div class="tips_m" style="display: none; position: absolute;" id="defLay">
	<div class="tips_b">
		<div class="tips_box">
			<div style="cursor: move;" class="tips_title">
				<h2>温馨提示</h2>
				<span class="close" id="defTopClose"><a href="javascript:void(0);">关闭</a></span>
			</div>
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
				<span class="close" id="codeTplClose"><a href="javascript:void(0);">关闭</a></span>
			</div>
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
                <span class="close" id="addMoneyClose"><a href="javascript:void%200">关闭</a></span>
            </div>
            <div class="tips_text">
                <p class="pd_l tc f14" id="addMoneyContent">您的可投注余额不足，请充值<br>(点充值跳到“充值”页面，点“返回”可进行修改)</p>
            </div>
            <div class="tips_sbt">
                <input value="返 回" class="btn_Lora_b" id="addMoneyNo" type="button"><input value="充 值" class="btn_Dora_b" id="addMoneyYes" type="button">
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
                <span class="close" id="b2_dlg_close"><a href="#">关闭</a></span>
            </div>
            <div class="tips_info" id="b2_dlg_content"></div>
            <div class="tips_sbt">
                <input value="取 消" class="btn_Lora_b" id="b2_dlg_no" type="button"><input value="确 定" class="btn_Dora_b" id="b2_dlg_yes" type="button">
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
                <span class="close" id="jx_dlg_close"><a href="#">关闭</a></span>
            </div>
            <div class="tips_text">
                <ul class="tips_text_list" id="jx_dlg_list"></ul>
            </div>
            <div class="tips_sbt">
                <input value="重新机选" class="btn_gray_b m-r" id="jx_dlg_re" type="button"><input value="选好了" class="s-ok s-ok-sp" id="jx_dlg_ok" type="button">
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
                <span class="close" id="split_dlg_close"><a href="#">关闭</a></span>
            </div>
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
                <span class="close" id="info_dlg_close"><a href="#">关闭</a></span>
            </div>
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
        <a href="javascript:void(0);" class="btn_modifyFont" title="返回修改" id="ishm_dlg_no">返回修改&gt;&gt;</a>
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
            <div class="tips_info" id="confirm_dlg_content"></div>
            <div class="tips_sbt">
                <input value="取 消" class="btn_Lora_b" id="confirm_dlg_no" type="button"><input value="确 定" class="btn_Dora_b" id="confirm_dlg_yes" type="button">
            </div>
        </div>
    </div>
</div>
</div>
<div style="position: absolute; display: none; z-index: 9999;" id="livemargins_control">
<img src="zqdc_bf_files/monitor-background-horizontal.png" style="position: absolute; left: -77px; top: -5px;" height="5" width="77">	<img src="zqdc_bf_files/monitor-background-vertical.png" style="position: absolute; left: 0pt; top: -5px;">	<img id="monitor-play-button" src="zqdc_bf_files/monitor-play-button.png" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.5" style="position: absolute; left: 1px; top: 0pt; opacity: 0.5; cursor: pointer;"></div><div class="tips_m" style="top: 700px; width: 500px; display: none; position: absolute;" id="yclass_alert">	<div class="tips_b">        <div class="tips_box">            <div style="cursor: move;" class="tips_title">                <h2 id="yclass_alert_title">温馨提示</h2>                
<span class="close" id="yclass_alert_close"><a href="#">关闭</a></span>            
</div>            
<div class="alert_c">              
<div class="state error">               
<div class="stateInfo f14 p_t10" id="yclass_alert_content"></div>              
</div>            
</div>            
<div class="tips_sbt">                
<input value="确 定" class="btn_Dora_b" id="yclass_alert_ok" type="button">            
</div>        
</div>    
</div></div>
<div class="tips_m" style="display: none; position: absolute;" id="yclass_confirm">	
<div class="tips_b">        
<div class="tips_box">            
<div style="cursor: move;" class="tips_title">                
<h2 id="yclass_confirm_title">温馨提示</h2>                
<span class="close" id="yclass_confirm_close"><a href="#">关闭</a></span>           
</div>            
<div class="tips_info" id="yclass_confirm_content" style="zoom:1"></div>            
<div class="tips_sbt">                
<input value="取 消" class="btn_Lora_b" id="yclass_confirm_no" type="button">
<input value="确 定" class="btn_Dora_b" id="yclass_confirm_ok" type="button">            
</div>        
</div>    
</div>
</div>
<div style="display:none;" id="open_iframe">  
<div id="open_iframe_content"></div></div>
<div style="opacity: 0.2;" tabindex="-1" class="yclass_mask_panel"></div>
<div style="position: absolute; z-index: 500000; left: -99999px;">
<div style="min-width: 120px; text-align: center; font: 12px/1.5 verdana; color: rgb(51, 51, 51);"></div>
<div style="position: absolute; left: 0pt; top: 0pt; display: none; z-index: 9; width: 88%; height: 30px; background: none repeat scroll 0% 0% rgb(238, 238, 238); opacity: 0.1; cursor: move;"></div>
</div>
<div class="notifyicon tip-2"><div class="notifyicon_content"></div>
<div class="notifyicon_arrow"><s></s><em></em></div><div class="notifyicon_space"></div>
</div>
</body>
</html>