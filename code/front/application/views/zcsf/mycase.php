<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo $site_config['site_title'];?>-足彩胜负-我的方案</title>
<meta name="Keywords" content="<?php echo $site_config['keywords'];?>" />
<meta name="Description" content="<?php echo $site_config['description'];?>" />

<?php
echo html::script(array
(
 	'media/js/yclass',
 	'media/js/loginer',	
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
<body id="dzgd">
<?php echo View::factory('header')->render();?>
<!--menu和列表_end-->
<!--面包屑导航-->
<div class="width line36 gray68">
	<div style="float:left; margin-left:20px;">
		您所在的位置：
		<a href="<?php echo url::base();?>"><font class="blue">首页</font></a> &gt; 
		<a href="<?php echo url::base();?>zcsf/sfc_14c"><font class="blue">足彩胜负</font></a> &gt; 我的方案
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
                    <a data-val="<?php echo $value;?>"<?php if ($value==$expect_data['expect_num']) {?> class="on"<?php } ?> title="" href="/zcsf/mycase_<?php echo $expect_data['expect_type'];?>c/<?php echo $value;?>/0">当前期<?php echo $value;?>期</a>|
				<?php }else{ ?>    
                    <a data-val="<?php echo $value;?>"<?php if ($value==$expect_data['expect_num']) {?> class="on"<?php } ?> title="" href="/zcsf/mycase_<?php echo $expect_data['expect_type'];?>c/<?php echo $value;?>/0">预售期<?php echo $value;?>期</a>|
				<?php }} ?>
                			
				</span><span>单注最高奖金<b class="red">5,000,000</b>元<b class="kj"></b></span></dt>
			</dl>
      <div id="jc_menu" class="font14 bold">
            	<ul>
                	<li<?php if($expect_data['expect_type']==14){?> class="hover"<?php }?>><a href="/zcsf/sfc_14c"><span>十四场胜负彩</span></a></li>
                    <li<?php if($expect_data['expect_type']==4){?> class="hover"<?php }?>><a href="/zcsf/sfc_4c"><span>进球彩</span></a></li>
				    <li<?php if($expect_data['expect_type']==9){?> class="hover"<?php }?>><a href="/zcsf/sfc_9c"><span>九场胜负彩</span></a></li>
       				<li<?php if($expect_data['expect_type']==6){?> class="hover"<?php }?>><a href="/zcsf/sfc_6c"><span>六场半全</span></a></li>                                       
                    <li class="hover"><a href="/zcsf/mycase_<?php echo $expect_data['expect_type'];?>c"><span>我的方案</span></a></li>
                </ul>
          </div>
        </div>
    </div>
     <div id="jingcai_bottom" class="fl"> 
	     <div class="dc_l"> 
             <a href="/zcsf/mycase_<?php echo $expect_data['expect_type'];?>c_ok" title="已结算交易"<?php if ($status==1) echo ' class="on"';?>><em>已结算交易</em><s></s>
             </a> <a href="/zcsf/mycase_<?php echo $expect_data['expect_type'];?>c" title="未结算交易"<?php if ($status==0) echo ' class="on"';?>><em>未结算交易</em><s></s></a> 
         </div>
	     <span class="fr pt5"><a href="/buycenter/sfc_<?php echo $expect_data['expect_type'];?>c"><img src="<?php echo url::base();?>media/images/btn3.gif" width="85" height="22" alt="参与合买" /></a></span></div>
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
            <h2>我的方案</h2>  <span class="fr pt5">截止时间：<?php echo date("Y-m-d H:i",strtotime($expect_list[0]['end_time'])-1800);?></span>	
          </div>
          <table class="rec_table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <colgroup>
            <col width="6%">
            <col width="5%">
            <col width="18%">
            <col width="10%">
            <col width="8%">
            <col width="10%">
            <col width="10%">
            <col width="12%">
            <col width="12%">
            <col width="12%">
            </colgroup>
            <tbody id="list_data">
              <tr class="">
                <th>排序</th>
                 <th>期号</th>               
                <th>玩法</th>
                <th class="th_name">发起人</th>
                <th>投注内容</th>
                <th>进度</th>
                <th class="fa_money">认购金额</th>
                <th class="fa_money">我的奖金</th>
                <th>认购时间</th>
                <th>操作</th>
              </tr>
    
              <tr class="form_tr2">
                <td colspan="10" class="error_ts5">没有找到相关的记录！</td>
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
            <span><a href="#" target="_blank">我关注的发起人</a></span> </div>
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
				<th><a href="javascript:do_order('1')">战绩<span class="asc_pub" id="sort1_img"></span></a></th>                
                <th>玩法</th>
                <th class="th_name">发起人</th>
                <th class="fa_money"><a href="javascript:do_order('2')">方案金额<span class="asc_pub" id="sort2_img"></span></a></th>
                <th class="fa_money"><a href="javascript:do_order('3')">每份金额<span class="des_pub" id="sort3_img"></span></a></th>
                <th><a href="javascript:do_order('4')">进度<span class="asc_pub" id="sort4_img"></span></a></th>
                <th><a href="javascript:do_order('5')">发起时间<span class="des_pub" id="sort5_img"></span></a></th>
                <th>操作</th>
              </tr>
              <tr class="form_tr2">
                <td colspan="10" class="error_ts5">没有找到相关的记录！</td>
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
  <input name="lotid" id="lotid" value="1" type="hidden">
  <input name="playid" id="playid" value="1" type="hidden">
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
	function autoLoad_list(){
	   loadDataByUrl('<?php echo $ajax_url;?>','list_data');
	}
	autoLoad_list();
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
							oRow.cells[0].innerHTML = "您尚未登录，请先<a href=\"javascript:void(0)\" onclick=\"Y.postMsg('msg_login');\" style=\"font-weight:bold\">登录</a>。如果您不是会员，请先<a href=\"/user/register\" target=\"_blank\">注册</a>成为会员！";
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
		var url = '<?php echo $ajax_url;?>';
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
  <textarea id="responseJson" style="display: none;">{
	period :      "<?php echo $expect_data['expect_num'];?>",   //期号
	serverTime :  "<?php echo date("Y-m-d H:m:s");?>",   //服务器时间
	endTime :     "<?php echo date("Y-m-d H:i",strtotime($expect_list[0]['end_time'])-1800);?>",    //截止时间
	singlePrice : 2,   //单注金额
	baseUrl : "<?php echo url::base();?>"  //网站根目录
}</textarea>  
  
  
<?php echo View::factory('zcsf/public_div')->render();?>

</body>
</html>