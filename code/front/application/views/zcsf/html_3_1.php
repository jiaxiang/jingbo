<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足彩胜负-6场半全场</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />
<?php
echo html::script(array
(
 	'media/js/yclass',
 	'media/js/loginer',	
 	'media/js/choose_zc',	
 	'media/js/index',			
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
<!--6场半全场-复式(现在选号)-->
<?php echo View::factory('header')->render();?> 
<!--menu和列表_end--> 
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>zcsf/sfc_14c"><font class="blue">足彩胜负</font></a> &gt; 6场半全场
	</div>
	<div style="float:right; margin-right:20px;">
		<span style="float:right">客服电话：<?php echo $site_config['kf_phone_num'];?></span>
	</div>
	<div style="clear:both;"></div>
</div>
<!--面包屑导航_end-->
<!--content1-->
<div class="width jingcai_box ">
  <div class="fl" id="jingcai_top"> <span class="fl" id="jctop_left"><img src="<?php echo url::base();?>media/images/zcsf.gif" width="76" height="63" /></span>
    <div class="fl" id="jctop_right">
      <dl class="b-top-info">
        <dt><span id="expect_tab">
<?php
	foreach($expect_data['expects'] as $value) { 
		if ($value==$expect_data['expect_num']) {
?>
<a data-val="<?php echo $value;?>"<?php if ($value==$cur_expect) {?> class="on"<?php } ?> title="当前期<?php echo $value;?>期" href="/zcsf/sfc_6c/<?php echo $value;?>">当前期<?php echo $value;?>期</a>|
<?php 
		}
		else { 
			if ($value == '12007') $expect_name = '当前'; else $expect_name = '预售';
?>    
<a data-val="<?php echo $value;?>"<?php if ($value==$cur_expect) {?> class="on"<?php } ?> title="<?php echo $expect_name;?>期<?php echo $value;?>期" href="/zcsf/sfc_6c/<?php echo $value;?>"><?php echo $expect_name;?>期<?php echo $value;?>期</a>|
<?php 
		}
	} 
?>          </span><span>单注最高奖金<b class="red">5,000,000</b>元<b class="kj"></b></span></dt>
      </dl>
      <div id="jc_menu" class="font14 bold">
        <ul>
          <li><a href="/zcsf/sfc_14c"><span>十四场胜负彩</span></a></li>
          <li ><a href="/zcsf/sfc_4c"><span>进球彩</span></a></li>
          <li><a href="/zcsf/sfc_9c"><span>九场胜负彩</span></a></li>
          <li class="hover"><a href="/zcsf/sfc_6c/<?php echo $cur_expect;?>"><span>六场半全</span></a></li>
          <li ><a href="/zcsf/mycase_6c"><span>我的方案</span></a></li>
        </ul>
      </div>
    </div>
  </div>
  <div id="jingcai_bottom" class="fl">
    <div class="dc_l"> <a href="<?php echo url::base();?>zcsf/sfc_6c/<?php echo $cur_expect;?>" title="普通投注" class="on"><em>普通投注</em><s></s></a> <a href="<?php echo url::base();?>zcsf/sfc_6c_ds/<?php echo $cur_expect;?>" title="单式投注" ><em>单式投注</em><s></s></a> </div>
    <span class="fr pt5 gray6 mr10">截止时间：<?php echo $time_arr[2];?> 还剩 <?php echo $time_arr[3];?>天<?php echo $time_arr[4];?>小时</span></div>
  <span class="zhangkai"></span> </div>
<!--content1 end--> 
<!--header end-->
<div id="bd">
  <div id="main">
    <div class="box_top">
      <div class="box_top_l"></div>
    </div>
    <div class="box_m">
      <div class="top_selt"> <span>选号方式：</span>
        <label onclick="self.location='<?php echo url::base();?>zcsf/sfc_6c/<?php echo $cur_expect;?>'" class="cur_lab">
          <input name="isyt" id="radio" value="0" checked="checked" class="rdo" type="radio">
          现在选号 </label>
        <label onclick="self.location='<?php echo url::base();?>zcsf/sfc_6c_shxh/<?php echo $cur_expect;?>'">
          <input name="isyt" id="radio2" value="1" class="rdo" type="radio">
          稍后选号 </label>
      </div>
      <div id="xx1" style="display:;"> 
        <!------选号begin------>
        <table class="pub_table" id="vsTable" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <th width="35">场次</th>
              <th width="70">赛事</th>
              <th width="80">比赛时间</th>
              <th width="190">对阵</th>
              <th width="70">数据</th>
              <th width="60">半/全场</th>
              <th width="134">平均赔率</th>
              <th width="137"> <table class="th_table" border="0" cellpadding="0" cellspacing="0" width="120">
                  <tbody>
                    <tr>
                      <th colspan="3">选号区</th>
                    </tr>
                    <tr>
                      <td>胜</td>
                      <td>平</td>
                      <td>负</td>
                    </tr>
                  </tbody>
                </table></th>
              <th width="43">全包</th>
              <th class="last_th" width=""> <table class="th_table" border="0" cellpadding="0" cellspacing="0" width="120">
                  <tbody>
                    <tr>
                      <th colspan="3">投注比率</th>
                    </tr>
                    <tr>
                      <td>胜</td>
                      <td>平</td>
                      <td>负</td>
                    </tr>
                  </tbody>
                </table></th>
            </tr>
            <?php 
            $i=0; 
            foreach($expect_list as $key=>$value){ 
            ?>
            <?php 
            if($key==0 or $key==2 or $key==4 or $key==6 or $key==8 or $key==10) { 
            	$i=$i+1;
            ?>
            <tr data-vs="<?php echo $value['vs1'];?>,<?php echo $value['vs2'];?> 半">
              <td rowspan="2"><?php echo $i;?></td>
              <td rowspan="2" style="background:			  <?php 
			  if (array_key_exists($value['game_event'],$color_list))
			  { 		  
			  	echo $color_list[$value['game_event']];
			  }else{
				  echo $color_list['default'];
			  } 
			  ?>; color: rgb(255, 255, 255);" class="league"><?php echo $value['game_event'];?></td>
              <td rowspan="2"><span class="eng"><?php echo substr($value['game_time'],5,11);?></span></td>
              <td rowspan="2">
              <?php 
              	if ($value['home_url'] != NULL) {
              		echo '<a href="'.$value['home_url'].'" target="_blank">'.$value['vs1'].'</a>';
              	}
              	else {
              		echo $value['vs1'];
              	}
              ?>
               VS 
               <?php 
              	if ($value['away_url'] != NULL) {
              		echo '<a href="'.$value['away_url'].'" target="_blank">'.$value['vs2'].'</a>';
              	}
              	else {
              		echo $value['vs2'];
              	}
              ?>
              </td>
              <td rowspan="2">
              <?php 
              	if ($value['xi_url'] != NULL) {
					echo '<a href="'.$value['xi_url'].'" target="_blank">析</a> ';              	
              	} 
              	else {
              		echo '析 ';
              	}
				if ($value['ya_url'] != NULL) {
					echo '<a href="'.$value['ya_url'].'" target="_blank">亚</a> ';              	
              	} 
              	else {
              		echo '亚 ';
              	}
				if ($value['ou_url'] != NULL) {
					echo '<a href="'.$value['ou_url'].'" target="_blank">欧</a> ';              	
              	} 
              	else {
              		echo '欧 ';
              	}
              ?>
              </td>
              <td>半场</td>
              <?php 
              //var_dump($value);
		        if(!empty($value['sp'])){
	        		$sp=json_decode($value['sp']);
					$zcsf_h=$sp->h->v;
					$zcsf_d=$sp->d->v;
					$zcsf_a=$sp->a->v;
        		}else{
        			$zcsf_h=$zcsf_d=$zcsf_a="-";
        		}
        		
            	if(!empty($expect_list[$key+1]['sp'])){
	        		$sp=json_decode($expect_list[$key+1]['sp']);
					$zcsf_hq=$sp->h->v;
					$zcsf_dq=$sp->d->v;
					$zcsf_aq=$sp->a->v;
        		}else{
        			$zcsf_hq=$zcsf_dq=$zcsf_aq="-";
        		}
              ?>
              <td><span class="sp_w38 eng"><?php echo $zcsf_h?></span><span class="sp_w38 eng"><?php echo $zcsf_d?></span><span class="sp_w38 eng"><?php echo $zcsf_a?></span></td>
              <td><span class="sp_w40"><span class="sp_nxz">3</span></span><span class="sp_w40"><span class="sp_nxz">1</span></span><span class="sp_w40"><span class="sp_nxz">0</span></span></td>
              <td><input type="checkbox"></td>
              <td class="last_td"><span class="sp_w40 eng">52%</span><span class="sp_w40 eng">48%</span><span class="sp_w40 eng">0%</span></td>
            </tr>
            <?php }else{?>
            <tr data-vs="<?php echo $value['vs1'];?>,<?php echo $value['vs2'];?> 全">
              <td>全场</td>
              <td><span class="sp_w38 eng"><?php echo $zcsf_hq?></span><span class="sp_w38 eng"><?php echo $zcsf_dq?></span><span class="sp_w38 eng"><?php echo $zcsf_aq?></span></td>
              <td><span class="sp_w40"><span class="sp_nxz">3</span></span><span class="sp_w40"><span class="sp_nxz">1</span></span><span class="sp_w40"><span class="sp_nxz">0</span></span></td>
              <td><input type="checkbox"></td>
              <td class="last_td"><span class="sp_w40 eng">100%</span><span class="sp_w40 eng">0%</span><span class="sp_w40 eng">0%</span></td>
            </tr>
            <?php }?>
            <?php }?>
          </tbody>
        </table>
        <!------选号end------>
        <div class="pick">您选择了：<span class="eng" id="zsSpan">0</span> 注，
          <input name="" class="mul" value="1" id="bsInput" type="text">
          倍　　金额：<strong class="red eng" id="moneySpan">￥0.00</strong>元 </div>
        <div class="buy_sort" id="all_form"> <span class="title">购买形式</span> <span class="sort">
          <label for="rd3" class="cur_lab">
            <input name="radio_g2" id="rd3" value="1" checked="checked" class="rdo" type="radio">
            代购</label>
          <label for="rd4">
            <input name="radio_g2" id="rd4" value="0" class="rdo" type="radio">
            合买</label>
          </span> <em class="r i-qw" style="margin-top: 8px;"></em><span class="r gray">由购买人自行全额购买彩票</span> </div>
        <div>
          <div id="dd1" style="display:;">
            <table class="buy_table" border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr class="last_tr">
                  <td class="td_title">确认购买</td>
                  <td class="td_content"><div class="buy_info">
                      <p id="userMoneyInfo">您尚未登录，请先<a href="javascript:void%200" title="" onclick="Yobj.postMsg('msg_login')">登录</a>!</p>
                      <p>本次投注金额为<strong class="red eng" id="buyMoneySpan">￥0.00</strong>元<span class="if_buy_yue" style="display:none">， 购买后您的账户余额为 <strong class="red eng" id="buySYSpan">￥0.00</strong>元</span></p>
                      <p><span class="hide_sp">
                        <input checked="checked" id="agreement_dg" type="checkbox">
                        </span>我已阅读并同意《<a href="javascript:void%200" onclick="Y.openUrl('/doc/webdoc/gmxy',530,550)">用户合买代购协议</a>》</p>
                    </div>
                    <div class="buy_btn"> <!-- a href="javascript:void%200" class="btn_buy_m" title="立即购买" id="buy_dg">立即购买</a--> </div></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="dd2" style="display:none;">
            <?php echo View::factory('zcsf/public_form')->render();?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!------------配置信息begin------------>
<!--系统及配置信息-->
<input name="ticket_type" id="ticket_type" value="2" type="hidden">
<!--彩种Id-->
<input name="play_method" id="play_method" value="<?php echo $play_method;?>" type="hidden">
<!--玩法Id-->    
<input name="expect" id="expect" value="<?php echo $cur_expect;?>" type="hidden">
<!--期号-->
<input name="end_time" id="end_time" value="<?php echo $time_arr[2];?>" type="hidden">
<!--结束时间-->
<input name="isupload" id="isupload" value="0" type="hidden">
<input name="is_select_code" id="is_select_code" value="1" type="hidden">
<input name="usertype" id="usertype" value="0" type="hidden">
<!--需要JS提供-->
<input name="zhushu" id="zhushu" value="" type="hidden">
<!--注数-->
<input name="totalmoney" id="totalMoney" value="" type="hidden">
<!--足彩购买总钱数-->
<input name="codes" id="codes" value="" type="hidden">
<!--号码-->
<input name="isset_buyuser" id="isset_buyuser" value="" type="hidden">
<!--招股对象 所有：1 部分：2-->
<!--其他-->
<input name="ishm" id="ishm" value="0" type="hidden"> 
<!------------配置信息end------------> 
<!--footer start--> 
<span class="zhangkai"></span> <?php echo View::factory('footer')->render();?> 
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
