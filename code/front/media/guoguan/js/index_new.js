/**
 * 
 */
$_sys.grade_def = [];
$_sys.grade_def.push([ 80, "一等奖,二等奖" ]);
$_sys.grade_def.push([ 81, "一等奖" ]);
$_sys.grade_def.push([ 82, "一等奖" ]);
$_sys.grade_def.push([ 83, "一等奖" ]);

$_sys.grade_def.push([ 01, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖" ]);
$_sys.grade_def.push([ 03, "直选,组三,组六" ]);
$_sys.grade_def.push([ 04, "五星奖,三星奖,二星奖,一星奖,大小单双,二星组选,五星通选一等奖,五星通选二等奖,五星通选三等奖" ]);
$_sys.grade_def.push([ 07, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖,七等奖" ]);

$_sys.grade_def.push([ 50, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖,七等奖,八等奖,生肖乐,追加一等奖,追加二等奖,追加三等奖,追加四等奖,追加五等奖,追加六等奖,追加七等奖" ]);
$_sys.grade_def.push([ 51, "一等奖,二等奖,三等奖,四等奖,五等奖,六等奖" ]);
$_sys.grade_def.push([ 52, "一等奖" ]);
$_sys.grade_def.push([ 53, "直选,组三,组六" ]);
$_sys.grade_def.push([ 54, "前一直选,任选二,任选三,任选四,任选五,任选六,任选七,任选八,前二直选,前三直选,前二组选,前三组选" ]);
var lotyid=0,playid=0;
$_sys.getgrade = function(f, n) {
	if (typeof (n) == 'undefined') {
		n = 1;
	}
	;
	for ( var i = 0; i < $_sys.grade_def.length; i++) {
		if ($_sys.grade_def[i][0] == f) {
			return $_sys.grade_def[i][n].split(",");
		}
	}
};

//alert($_sys.lottype.istype(01,"szc")==true);

var getmax = function(info){
	var max=0;
	for (var i=0;i<info.length;i++){
		max=i;
		if (info[i]>0){			
			break;
		}
	}
	return info.length-max-1;
};

var isadd = function (info){
	if (info.length==17){
		for (var i=9;i<17;i++){
			if (info[i]>0){
				return true;
			}
		}
	}
	return false;
}

$(function() {
//	var lotid = location.search.getParam('lotid');
	var lotid  = $_sys.lotid;





	var expect = location.search.getParam('expect');

	if (lotid == "") {
		lotid = "01";
	}
	// alert($_sys.getlotname(lotid));
	var lotimg = "";
	switch (lotid) {
	case "85":
		lotyid='7';playid='501';
		lotimg = "sfc_t.jpg";
		break;
	case "86":
			lotyid='7';playid='504';
		lotimg = "sfc_t.jpg";
		break;
	case "87":
			lotyid='7';playid='501';
		lotimg = "sfc_t.jpg";
		break;
	case "88":
			lotyid='7';playid='501';
		lotimg = "sfc_t.jpg";
		break;
	case "89":
			lotyid='7';playid='501';
		lotimg = "sfc_t.jpg";
		break;

	case "80":
		lotyid='2';playid='1';
		lotimg = "sfc_t.jpg";
		break;
	case "81":
		lotyid='2';playid='2';
		lotimg = "rj_t.jpg";
		break;
	case "82":
		lotyid='2';playid='4';
		lotimg = "4cjq_t.jpg";
		break;
	case "83":
		lotyid='2';playid='3';
		lotimg = "6cbq_t.jpg";
		break;
	case "01":
		lotimg = "ssq_t.jpg";
		break;
	case "03":
		lotimg = "sd_t.jpg";
		break;
	case "07":
		lotimg = "qlc_t.jpg";
		break;
	case "50":
		lotimg = "dlt_t.jpg";
		lotyid='8';playid='0';
		break;
	case "51":
		lotimg = "qxc_t.jpg";
		lotyid='10';playid='0';
		break;
	case "52":
		lotimg = "plw_t.jpg";
		lotyid='9';playid='0';
		break;
	case "53":
		lotimg = "pls_t.jpg";
		lotyid='11';playid='0';
		break;
	default:
		$_sys.showerr('对不起，该期暂未开售或者已经过期!');
		break;
	}
	$("#lotimg").attr('src', "/media/guoguan/img/" + lotimg);
	$("#lotid").val(lotid);

	$("#seltype").val("as");
	
	showinfo($("#lotid").val(), expect,$("#seltype").val());

	$("#expect").bind({
		change : function() {
			if ($("#seltype").val()=="my"){
				var pn=1;//页码
				var ps = 25;//页面大小
				var tp = 0;//总页数
				var tr = 0;//总记录数		
				myguoguan($("#lotid").val(), $("#expect").val(),pn,ps,tp,tr);
			}else{
				loadmain($("#lotid").val(), $("#expect").val(),$("#seltype").val());
			}
		}
	});
	
	$("#menu0").bind({
		click:function(){
			$("#seltype").val("my");
			omenu(0);
			var pn=1;//页码
			var ps = 25;//页面大小
			var tp = 0;//总页数
			var tr = 0;//总记录数		
			myguoguan(lotid, $("#expect").val(),pn,ps,tp,tr);
		}	
	});
	$("#menu1").bind({
		click:function(){
			$("#seltype").val("as");
			omenu(1);
			var seltype=$("#seltype").val();
			var pn=1;//页码
			var ps = $("#"+seltype+"_ps").val();//页面大小
			var tp = $("#"+seltype+"_tp").val();//总页数
			var tr = $("#"+seltype+"_tr").val();//总记录数	
//			alert('lotid='+$("#lotid").val()+'\rexpect='+$("#expect").val()+'\rseltype='+$("#seltype").val()+'\rpn='+pn+'\rps='+ps+'\rtp='+tp+'\rtr='+tr);
			loadpage($("#lotid").val(), $("#expect").val(),$("#seltype").val(),pn,ps,tp,tr);
		}	
	});	
	$("#menu4").bind({
		click:function(){
			$("#seltype").val("af");
			omenu(4);
			var seltype=$("#seltype").val();
			var pn=1;//页码
			var ps = $("#"+seltype+"_ps").val();//页面大小
			var tp = $("#"+seltype+"_tp").val();//总页数
			var tr = $("#"+seltype+"_tr").val();//总记录数	
//			alert('lotid='+$("#lotid").val()+'\rexpect='+$("#expect").val()+'\rseltype='+$("#seltype").val()+'\rpn='+pn+'\rps='+ps+'\rtp='+tp+'\rtr='+tr);
			loadpage($("#lotid").val(), $("#expect").val(),$("#seltype").val(),pn,ps,tp,tr);

		}	
	});		
	// parent.window.Y.postMsg('msg_login', function() {
	// showinfo();
	// });

});




var myguoguan = function(lotid,expect,pn,ps,tp,tr){
	var colSpan=6;
	var html='<table class="table_list01" border="0" cellpadding="0" cellspacing="0" width="100%" >'+
	'<tbody>'+
	'<tr>'+
	'<td class="td_t01" height="25" width="6%">排序</td>'+
	'<td class="td_t01 td_left" width="16%">发起人</td>'+
	'<td class="td_t01 td_left" >战绩</td>'+
	'<td class="td_t01" >方案金额</td>';
	if ($_sys.lottype.istype(lotid,"szc")==true){
		for (var i=0;i<$_sys.getgrade(lotid).length;i++){
			colSpan++;
			html+='<td class="td_t01" >'+$_sys.getgrade(lotid)[i]+'</td>';
		}
	}else{
		html+='<td class="td_t01" >全对注数</td>';
		colSpan++;
		if (lotid==80||lotid==81){
			html+='<td class="td_t01" >错一注数</td>';
			colSpan++;
		}	
		html+='<td class="td_t01" >正确场次</td>'+
		'<td class="td_t01" >投注分布</td>';
		colSpan++;
		colSpan++;
	}
	html+='<td class="td_t01" >税前奖金</td>'+
	//'<td class="td_t01" >自动跟单</td>'+
	'</tr>'+
	'</tbody>';
	colSpan++;	
	colSpan++;	
	var data = "";
	if (tr%ps==0){tp=tr/ps;}else{tp=Math.ceil(tr/ps);}	

	data = $_user.key.gid+"=" + lotid + "&"+$_user.key.tid+"=" + expect; 
	data += "&"+$_user.key.pn+"="+pn;
	data += "&"+$_user.key.ps+"="+ps;
	data += "&"+$_user.key.tp+"="+tp;
	data += "&"+$_user.key.tr+"="+tr;	
	$.ajax({
		url : $_user.url.myguoguan,
		type : "POST",
		dataType : "xml",
		data : data,
		success : function(xml) {
			var R = $(xml).find("Resp");			
			
			var code = R.attr("code");
			var desc = R.attr("desc");
			if (code == "0") {
				var r = $(xml).find("row");
				var rs =R.find("rows");
				tr=rs.attr("tr");
				tp=rs.attr("tp");
				ps=rs.attr("ps");
				pn=rs.attr("pn");	
				if (tr%ps==0){tp=tr/ps;}else{tp=Math.ceil(tr/ps);}							
				r.each(function() {
					var rec = $(this).attr("rec");
					var uname = $(this).attr("nickid");
					var ag = $(this).attr("ag");
					var au = $(this).attr("au");
					var info = $(this).attr("info");
					var bonus = $(this).attr("bonus");
					var betnum = $(this).attr("betnum");	
					var hid = $(this).attr("hid");	
					
					info=info.split(",");
					
					html+=''+
						'<tr class="bg_02" >'+
					'<td height="20">'+((pn*1-1)*ps+rec*1)+'</td>'+
					'<td class="td_left">';
					
					var isdg=false;
					if (uname=='******'){
						isdg=true;					
					}
					
					if (isdg){
						html+=''+uname+'';
					}else{
						html+='<a href="javascript:vh(\''+uid+'\',1)">'+uname+'</a>';
					}					
					html+='</td>'+
					'<td class="td_left"><a href="#">'+$_sys.showzhanji(ag,au)+'</a></td>';
					html+=isdg?'<td>'+betnum+'</td>':'<td><a href="'+$_sys.url.viewpath+'?lotid='+lotid+'&projid='+hid+'" target="_blank">'+betnum+'</a></td>';
					if (info.length>1){
						if ($_sys.lottype.istype(lotid,"szc")==true){
							for (var i=0;i<$_sys.getgrade(lotid).length;i++){
								html+='<td class="td_t01" >'+info[i]+'</td>';
							}							
						}else{	
							html+='<td class="red_b " >'+info[0]+'</td>';
							if (lotid==80||lotid==81){
								html+='<td class="cfont1">'+info[1]+'</td>';
							}			
							
							html+='<td class="cfont1">'+getmax(info)+'</td>';
							if (isdg){
								html+='<td>'+uname+'</td>';
							}else{
								html+='<td><a href="zcfb.html?lotid='+lotid+'&expect='+expect+'&projid='+hid+'" target="_blank">查看</a></td>';
							}								
						}
					}else{
						if ($_sys.lottype.istype(lotid,"szc")==true){
							for (var i=0;i<$_sys.getgrade(lotid).length;i++){
								html+='<td class="td_t01">0</td>';
							}							
						}else{						
							html+='<td class="red_b " ></td>';
							if (lotid==80||lotid==81){
								html+='<td class="cfont1"></td>';
							}								
							html+='<td class="cfont1"></td>';
							
							if (isdg){
								html+='<td>'+uname+'</td>';
							}else{
								html+='<td><a href="zcfb.html?lotid='+lotid+'&expect='+expect+'&projid='+hid+'" target="_blank">查看</a></td>';
							}	
						}
					}
					
					
					html+='<td class="bg_01">'+(parseFloat(bonus)>0?('<font color=red>'+parseFloat(bonus).rmb(false)+'</font>'):(parseFloat(bonus).rmb(false)))+'</td>';
					//html+=isdg?uid:'<a href="" target="_blank">定制</a>';
					'</tr>';				
					
				});
				html+='</table>';
				$('#showlist').html(html);		
				showmypageno(lotid, expect, pn, ps, tp , tr);
			} else {
				if (code=="1"){
					parent.window.Y.postMsg('msg_login', function() {						
						myguoguan(lotid,expect,pn,ps,tp,tr);		
					});
				}else{
					html+='<tr class="bg_01"><td  colSpan='+colSpan+' style="color:red">本期无购买记录</td></tr></table>';
					$('#showlist').html(html);
					return false;
				}
			}
			
		},
		error : function() {
			html+='<tr class="bg_01"><td  colSpan='+colSpan+' style="color:red">分布文件尚未生成</td></tr></table>';
			$('#showlist').html(html);
			return false;			
		}
	});	
};

//var pn=1;//页码
//var ps = 25;//页面大小
//var tp = 0;//总页数
//var tr = 0;//总记录数	

var showmypageno=function(lotid, expect, pn, ps, tp , tr){

	var maxshow=10;
	var pagehtml='<div class="my_page" style="HEIGHT: 40px; OVERFLOW: hidden"><div class="page"><span class="r">';
        pagehtml+='<A class=h_l title="" onclick="myguoguan(\''+lotid+'\', '+expect+',1,'+ps+','+tp+','+ tr+');"  href="javascript:void(0)">首页</A>'+ 
    	'<A class=pre title=上一页  onclick="myguoguan(\''+lotid+'\', '+expect+','+(pn-1>0?(pn-1):1)+','+ps+','+tp+','+ tr+');" href="javascript:void(0)"></A>';
    var min=0;
    var max=0; 
    if (tp > maxshow){
		var pageTemp=parseInt(pn*1/maxshow);
		max	= pageTemp*maxshow+maxshow;
	    min	= pageTemp*maxshow;
		if(max>tp){
			max=tp;
		}
		if(pn>min){min=min+1;}
    }else{
    	min = 1;
    	max = tp;
    }

	for (var i=min;i<max*1+1;i++){
		if (i==pn){
			pagehtml+='<A class=curpage title="" href="javascript:void(0)">'+i+'</A>';
		}else{
			pagehtml+='<A title="" onclick="myguoguan(\''+lotid+'\', '+expect+','+i+','+ps+','+tp+','+ tr+');" href="javascript:void(0)">'+i+'</A>';
		}	     
	}
    pagehtml+='<A class=next title=下一页   onclick="myguoguan(\''+lotid+'\', '+expect+','+(pn+1>tp?tp:(pn+1))+','+ps+','+tp+','+ tr+');"  href="javascript:void(0)">下一页</A>'+
    '<A class=h_l title="" onclick="myguoguan(\''+lotid+'\', '+expect+','+tp+','+ps+','+tp+','+ tr+');" href="javascript:void(0)">尾页</A>'+
    	'<SPAN class=sele_page><INPUT onkeydown="if(event.keyCode==13){myguoguan(\''+lotid+'\', '+expect+',Y.getInt(this.value),'+ps+','+tp+','+ tr+');return false;}" id=govalue class=num onkeyup="this.value=this.value.replace(/[^\\d]/g,\'\');if(this.value>'+tp+')this.value='+tp+';if(this.value<=0)this.value=1"  name=page>'+
    '<INPUT class=btn  onclick="myguoguan(\''+lotid+'\', '+expect+',Y.getInt($(\'#govalue\').val()),'+ps+','+tp+','+ tr+');" value=GO type=button> </SPAN><SPAN class=gray>共'+tp+'页，'+tr+'条记录</SPAN></span></div></div>';

	$('#showlist').append(pagehtml);		
	
};

var showinfo = function(lotid, expect,type) {

	$.ajax({
		//url : $_trade.url.cacheperiod,
		url : "/guoguan/"+$_sys.loty+"/expectlist",
		type : "post",
		dataType : "xml",
		data : {
		lotid : lotid
		},
		cache:false,
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			if (code == "0") {
				var r = R.find("row");
				var expectlist = [];
				r.each(function() {
					var pid = $(this).attr("pid");
					var et = $(this).attr("et");
					var fet = $(this).attr("fet");
					var flag = $(this).attr("flag");
					var st = Y.getInt($(this).attr("st"));
					//判断数字彩
					if ($_sys.lottype.istype(lotid,"szc")==true){
						if (st >= 5) {
							expectlist[expectlist.length] = [ pid, et, fet, flag ];
						}
					}else{
						if (st >= 4) {
							expectlist[expectlist.length] = [ pid, et, fet, flag ];
						}
					}
				});

				var html = "";
				for ( var i = 0; i < expectlist.length; i++) {
					html += "<OPTION value=" + expectlist[i][0] + " >" + expectlist[i][0] + "</OPTION>";
				}
				$("#expect").html('');
				$("#expect").append(html);
				if (expect == "") {
					expect = expectlist[0][0];
				}
				if (expect != "") {
					$("#expect").attr("value",expect);
					if ($("#expect").val() != expect) {
						$_sys.showerr('对不起，该期暂未开售或者已经过期!');
					}
				}

				loadmain(lotid, expect,type);
				
			} else {
				alert(desc);
			}
		},
		error : function() {
			alert("您所请求的页面有异常！");
			return false;
		}
	});
};

var loadmain = function(lotid, expect,type) {
	$('#kjdate').html("");
	$('#zcdz').html("");
	$("#ckxxdz").html("");
	$('#szckj').html("");
	$('#zckj').html("");
	$('#showlist').html("");
	
	$.ajax({
		url : "/guoguan/"+$_sys.loty+"/current",
		type : "POST",
		dataType : "xml",
		data : {
			lotid:lotid,
			lotyid:lotyid,
			playid:playid,
			expect : expect
		},

		cache : false,
		success : function(xml) {
			var rs = $(xml).find("rows");
			var gid = rs.attr("gid");
			var pid = rs.attr("pid");
			var code = rs.attr("code");// 开奖号码
			var gsale = rs.attr("gsale");// 全国销售
			var ginfo = rs.attr("ginfo");// 开奖公告
			var ninfo = rs.attr("ninfo");// 中奖注数
			var gpool = rs.attr("gpool");// 奖池
			var etime = rs.attr("etime");// 兑奖截止时间
			var atime = rs.attr("atime").substr(0,10);// //开奖时间			

			$("#as_ps").val(rs.find("as").attr("ps"));
			$("#as_tp").val(rs.find("as").attr("tp"));
			$("#as_tr").val(rs.find("as").attr("total"));			

			$("#af_ps").val(rs.find("af").attr("ps"));
			$("#af_tp").val(rs.find("af").attr("tp"));
			$("#af_tr").val(rs.find("af").attr("total"));

			
			// 开奖时间
			if (atime) {
				$("#kjdate").html('<span style="padding-left:10px;">开奖日期:</span> <span style=" font-weight:bold;color:#F00">' + atime + '</span>');
			}

			if (gid == lotid && pid == expect) {
				var r = rs.find("row");
				if (lotid == "80" || lotid == "81" || lotid == "82" || lotid == "83") {
					var ml = [];
					r.each(function() {
						var id = $(this).attr("id");
						var hn = $(this).attr("hn");
						hn= lotid=="83"?hn.substr(3):hn;
						var vn = $(this).attr("vn");
						var hs = $(this).attr("hs");
						var vs = $(this).attr("vs");
			
						var result = $(this).attr("result");
						ml[ml.length] = [ id, hn, vn, hs, vs, result ];
					});
					var html="";
					if (lotid == "80" || lotid == "81"){//sfc rxjc
						html = '<table class="table_list01 table_list02" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#D1E5FE">'
								+ '<tr><td height="25" width="35" class="td_t01">场次</td>';
						for ( var i = 0; i < ml.length; i++) {
							html += '<td class="td_t02" width="33">' + ml[i][0] + '</td>';
						}
						html += '<tr id="tr_vs1"><td height="58" class="td_t01">主队</td>';
	
						for ( var i = 0; i < ml.length; i++) {
							html += '<td class="bg_01 td_shu"><div class="tt">' + ml[i][1].replace('　', '<BR>&nbsp;&nbsp;<BR>') + '</div></td>';
						}
						html += '</tr>';
						html += '<tr id="tr_vs2" style="display:none"><td height="120" class="td_t01">对阵</td>';
						for ( var i = 0; i < ml.length; i++) {
							html += '<td class="bg_01 td_shu"><div class="tt">' + ml[i][1].replace('　', '<BR>&nbsp;&nbsp;<BR>') + '</div><div class="vs">';
							if (ml[i][3] != "" && ml[i][4] != "") {
								html += ml[i][3] + ':' + ml[i][4];
							} else {
								html += 'VS';
							}
							html += '</div><div class="tt">' + ml[i][2].replace('　', '<BR>&nbsp;&nbsp;<BR>') + '</div></td>';
						}
						html += '</tr>';
						html += '<tr><td height="25" class="td_t01">彩果</td>';
						for ( var i = 0; i < ml.length; i++) {
							html += '<td class="red_b">';
							if (ml[i][5] != "") {
								html += ml[i][5];
							} else {
								html += '*';
							}
							html += '</td>';
						}
						html += '</tr>';
						html += '</table>';		
						$('#zcdz').html(html);
						$("#ckxxdz").html('<span style="padding-left:10px;"><input type="checkbox" onclick="javascript:shiftvs(this)" /> 查看详细对阵</span>');
					}else if (lotid=="83"){//bqc
						html='<TABLE class="table_list01 table_list02" border=1 cellSpacing=0 borderColor=#d1e5fe cellPadding=0 width="100%"><TBODY>'+
							'<TR><TD class=td_t01 height=25 width=35>场次</TD><TD class=td_t02 colSpan=2>1</TD><TD class=td_t02 colSpan=2>2</TD><TD class=td_t02 colSpan=2>3</TD><TD class=td_t02 colSpan=2>4</TD><TD class=td_t02 colSpan=2>5</TD><TD class=td_t02 colSpan=2>6</TD></TR>';
						html += '<TR>'+
							'<TD class=td_t01 height=90 rowSpan=2>对阵</TD>';
						for (var i=0;i<6;i++){		
							html += '<TD class="bg_01 td_shu" colSpan=2>'+
							'<DIV class=t1>'+ml[i*2][1].replace('　', '<BR>&nbsp;&nbsp;<BR>')+'</DIV>'+
							'<DIV class=vs>&nbsp;&nbsp;<BR>';
							if (ml[i*2][3] != "" && ml[i*2][4] != "") {
								html += ml[i*2][3] + ':' + ml[i*2][4];
							} else {
								html += 'VS';
							}
							html+='</DIV>'+
							'<DIV class=t2>'+ml[i*2][2].replace('　', '<BR>&nbsp;&nbsp;<BR>')+'</DIV></TD>';
						}
						html += '</TR>';
						html+='<TR height=20><TD class="bg_01 zc6">半</TD><TD class="bg_01 zc6">全</TD><TD class="bg_01 zc6">半</TD><TD class="bg_01 zc6">全</TD><TD class="bg_01 zc6">半</TD><TD class="bg_01 font001 zc6">全</TD><TD class="bg_01 zc6">半</TD><TD class="bg_01 zc6">全</TD><TD class="bg_01 zc6">半</TD><TD class="bg_01 zc6">全</TD><TD class="bg_01 zc6">半</TD><TD class="bg_01 zc6">全</TD></TR>'+
						'<TR>'+
						'<TD class=td_t01 height=20>彩果</TD>';
						for ( var i = 0; i < ml.length; i++) {
							html += '<td class="red_b">';
							if (ml[i][5] != "") {
								html += ml[i][5];
							} else {
								html += '*';
							}
							html += '</td>';
						}						
						html+='</TR></TBODY></TABLE>';	
						$('#zcdz').html(html);
					}else if (lotid=="82"){//jqc
						html='<TABLE class="table_list01 table_list02" border=1 cellSpacing=0 borderColor=#d1e5fe cellPadding=0 width="100%"><TBODY>'+
							'<TR>'+
							'<TD class=td_t01 height=25 width=35>场次</TD><TD class=td_t02 width=50>1</TD><TD class=td_t02 width=50>2</TD><TD class=td_t02 width=50>3</TD><TD class=td_t02 width=50>4</TD><TD class=td_t02 width=50>5</TD><TD class=td_t02 width=50>6</TD><TD class=td_t02 width=50>7</TD><TD class=td_t02 width=50>8</TD></TR>'+
							'<TR><TD class=td_t01 height=65>对阵</TD>';
						for ( var i = 0; i < ml.length; i++) {
							html+='<TD class="bg_01 td_shu" colSpan=2>'+
							'<DIV class=t1>'+ml[i][1].replace('　', '<BR>&nbsp;&nbsp;<BR>')+'</DIV>'+
							'<DIV class=vs>&nbsp;&nbsp;<BR>';
							if (ml[i][3] != "" && ml[i][4] != "") {
								html += ml[i][3] + ':' + ml[i][4];
							} else {
								html += 'VS';
							}
							html+='</DIV>'+
							'<DIV class=t2>'+ml[i][2].replace('　', '<BR>&nbsp;&nbsp;<BR>')+'</DIV></TD>';
						}
						html+='</TR>'+
							'<TR>'+
							'<TD class=td_t01 height=25>彩果</TD>';							
						for ( var i = 0; i < ml.length; i++) {
							if (ml[i][5] != ""&&ml[i][5].split(",").length==2) {								
								html += '<TD class=red_b>'+ml[i][5].split(",")[0]+'</td><TD class=red_b>'+ml[i][5].split(",")[1]+'</TD>';
							} else {
								html += '<TD class=red_b>*</td><TD class=red_b>*</TD>';
							}	
						}	
						html+='</TR></TBODY></TABLE>';
						$('#zcdz').html(html);
					}			
					

					/*html = '<ul id="ul_kj" class="mini">';
					
					var aginfo = ginfo.split(",");
					var aninfo = ninfo.split(",");
					
					if (lotid=="80"){
						html += '<li>一等奖：<span class="red_b">';
						html += aninfo.length == 2 ? aninfo[0] : '--';
						html += '</span> 注，每注奖金 <span class="red_b">';
						html += aginfo.length == 2 ? parseFloat(aginfo[0]).rmb(false, 0) : '--';
						html += '</span> 元</li>';
					
						html += '<li>二等奖：<span class="red_b">';
						html += aninfo.length == 2 ? aninfo[1] : '--';
						html += '</span> 注，每注奖金 <span class="red_b">';
						html += aginfo.length == 2 ? parseFloat(aginfo[1]).rmb(false, 0) : '--';
						html += '</span> 元</li>';
					}else{
						html += '<li>一等奖：<span class="red_b">';
						html += aninfo[0] ? aninfo[0] : '--';
						html += '</span> 注，每注奖金 <span class="red_b">';
						html += aginfo[0] ? parseFloat(aginfo[0]).rmb(false, 0) : '--';
						html += '</span> 元</li>';						
					}

					html += '<li>全国销量：<span class="red_b">';
					html += gsale == '' ? '--' : parseFloat(gsale).rmb(false, 0);
					html += '</span> 元</li>';
					if (parseFloat(gpool)>0){
						html += '<li>奖池滚存：<span class="red_b">';
						html += gpool == '' ? '--' : parseFloat(gpool).rmb(false, 0);
						html += '</span> 元</li>';
					}				
					html += '</ul>';

					$('#zckj').html(html);*/
				}else{
					szckj(lotid,expect,code,gsale,ginfo,ninfo,gpool,etime,atime);					
				}
							
				loadpage(lotid, expect, $("#seltype").val(),1,rs.find(type).attr("ps"),rs.find(type).attr("tp"),rs.find(type).attr("total"));

			} else {
				alert(desc);
			}
		},
		error : function() {
			var html='<span style="color:red">过关文件尚未生成</span>';
			$('#szckj').html(html);
			return false;
		}
	});
};

var szckj=function(lotid,expect,code,gsale,ginfo,ninfo,gpool,etime,atime){
	var html='<DIV class="nr pls_t">'+
	'<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">'+
	'<TBODY>'+
	'<TR>'+
	'<TD vAlign=top width=80>开奖号码：</TD>'+
	'<TD vAlign=top >'+
	'<DIV class=ball_box01>'+
	'<UL>';
	var acode = code.split("|");	

	if (acode.length==2){
		var a_r=acode[0].split(",");
		var a_b=acode[1].split(",");
		for (var i=0;i<a_r.length;i++){
			html+='<LI class=ball_red>'+a_r[i]+'</LI>';
		}
		for (var i=0;i<a_b.length;i++){
			html+='<LI class=ball_blue>'+a_b[i]+'</LI>';
		}						
	}else{
		acode= code.split(",");
		if (acode.length>1){
			for (var i=0;i<acode.length;i++){
				if (lotid=="03"||lotid=="52"||lotid=="53"){									
					html+='<LI class=ball_orange>'+acode[i]+'</LI>';
				}else{
					html+='<LI class=ball_red>'+acode[i]+'</LI>';
				}								
			}
		}						
	}

	html+='</UL>'+
	'</DIV>'+
	'</TD>'+
	'<TD vAlign=top>';
	
	var uniqlen=$_base_s.uniq(code.split(",")).length;
	if (lotid=="03"||lotid=="53"){		
		if (uniqlen==2){
			html+='号码类型：<FONT class=cfont1>组三</FONT>';
		}else if (uniqlen==3){
			html+='号码类型：<FONT class=cfont1>组六</FONT>';
		}else if (uniqlen==1){
			html+='号码类型：<FONT class=cfont1>豹子</FONT>';
		}
	}else{
		html+='&nbsp';
	}	
	html+='</TD>'+
	'<TD style="FONT-SIZE: 12px; PADDING-TOP: 7px" vAlign=top align=right></TD>'+
	'</TR>'+
	'</TBODY>'+
	'</TABLE>'+
	'</DIV>';
	
	html+='<DIV style="PADDING-TOP: 15px" class=nr>'+
	'<TABLE border=0 cellSpacing=0 cellPadding=0 width="100%">'+
	'<TBODY>'+
	'<TR>'+
	'<TD>'+
		'<TABLE class=ggtj border=0 cellSpacing=0 cellPadding=0 width=350>'+
		'<TBODY>'+
		'<TR>';

	html+='<TH scope=col>奖项</TH>';
	html+='<TH scope=col>中奖注数</TH>'+
		'<TH scope=col>每注奖金</TH></TR>';
	var aginfo = ginfo.split(",");
	var aninfo = ninfo.split(",");
	
	if (lotid=="01"||lotid=="07"||lotid=="51"){
		var g=0;
		if (lotid=="01"||lotid=="51"){
			g=6;
		}else if (lotid=="07"){
			g=7;
		}	
		html+=showgrade(lotid,g,aninfo,aginfo,0);	
		html+=showgrade(lotid,g,aninfo,aginfo,1);	
	}else if (lotid=="03"||lotid=="53"){//sd pls

		html+=showgrade(lotid,3,aninfo,aginfo,0);	
		if (uniqlen==2||uniqlen==3){
			html+=showgrade(lotid,3,aninfo,aginfo,uniqlen-1);	
		}	
	}else if (lotid=="52"){//plw	
		html+=showgrade(lotid,1,aninfo,aginfo,0);	
	}else if (lotid=="50"){//dlt
		html+=showgrade(lotid,16,aninfo,aginfo,0);	
		html+=showgrade(lotid,16,aninfo,aginfo,9);	
		html+=showgrade(lotid,16,aninfo,aginfo,1);	
		html+=showgrade(lotid,16,aninfo,aginfo,10);	
		html+=showgrade(lotid,16,aninfo,aginfo,8);	
	}
	
	html +='</TBODY>'+
		'</TABLE>'+
	'</TD>'+
	'<TD>&nbsp;</TD>'+
	'<TD vAlign=top>'+
	'<UL class=ggList>'+
	'<LI>全国销量：<SPAN class=cfont1>';
	html+= gsale == '' ? '--' : parseFloat(gsale).rmb(false, 0);
	html+='</SPAN>元</LI>';
	if (lotid=="03"||lotid=="53"||lotid=="52"){
		
	}else{
		html+='<LI>奖池滚存：<SPAN class="red_b">';
		html+= gpool == '' ? '--' : parseFloat(gpool).rmb(false, 0);
		html+='</SPAN>元</LI>';
	}
	
	html+='</UL>'+
	'</TD>'+
	'</TR>'+
	'<TR>'+
	'<TD>&nbsp;</TD>'+
	'<TD>&nbsp;</TD>'+
	'<TD height=20></TD></TR></TBODY></TABLE>'+
	'</DIV>';
	$("#szckj").html(html);		
};

var showgrade=function(lotid,g,aninfo,aginfo,num){
	html='<TR>'+
	'<TD>'+$_sys.getgrade(lotid)[num]+'</TD>'+
	'<TD><SPAN class=cfont1>';
	html += aninfo.length == g ? aninfo[num] : '--';
	html+='</SPAN>&nbsp;注</TD>'+
		'<TD class=dr><SPAN class=cfont1>';
	html += aginfo.length == g ? parseFloat(aginfo[num]).rmb(false, 0) : '--';
	html+='</SPAN>&nbsp;元 </TD></TR>';		
	return html;	
};

var loadpage = function(lotid, expect, type ,pn,ps,tp,tr) {
	var colSpan=6;
	var html='<table class="table_list01" border="0" cellpadding="0" cellspacing="0" width="100%" >'+
	'<tbody>'+
	'<tr>'+
	'<td class="td_t01" height="25" >排序</td>'+
	'<td class="td_t01 td_left" >发起人</td>'+

	'<td class="td_t01" >方案金额</td>';
	if ($_sys.lottype.istype(lotid,"szc")==true){
		if (lotid=="50"){
			for (var i=0;i<9;i++){
				colSpan++;
				html+='<td class="td_t01" >'+$_sys.getgrade(lotid)[i]+'</td>';
			}	
		}else{
			for (var i=0;i<$_sys.getgrade(lotid).length;i++){
				colSpan++;
				html+='<td class="td_t01" >'+$_sys.getgrade(lotid)[i]+'</td>';
			}			
		}
	}else{
		/*html+='<td class="td_t01" >全对注数</td>';
		colSpan++;
		if (lotid==80||lotid==81){
			html+='<td class="td_t01" >错一注数</td>';
			colSpan++;
		}	
		html+='<td class="td_t01" >正确场次</td>'+
		'<td class="td_t01" >投注分布</td>';*/
		colSpan++;
		colSpan++;
	}	
	html+='<td class="td_t01" >税前奖金</td>';
	if(lotyid==1)
	html+='<td class="td_t01" >自动跟单</td>';
	html+='</tr>'+
	'</tbody>';
	colSpan++;	
	colSpan++;
	var purl="/guoguan/public/search";

	switch(lotyid){
		case '8':
		case '9':
		case '10':
		case '11':
			purl = "/guoguan/public/szc";
		break;
		case '2':
			purl = "/guoguan/public/zcsf";
		break;

	}

	$.ajax({
		url:purl,
		type : "post",
		dataType : "xml",
		data : {
			lotyid:lotyid,
			playid:playid,
			expect : expect,
			pn: pn
		},
		cache : false,
		success : function(xml) {
			//<row uname="******" ag="0" au="0" info="0,0,0,0,0,0,0,0,0,8,40,64,32,0,0" bonus="0.0" betnum="288" />
			var R = $(xml).find("Resp");
			var r = $(xml).find("row");
				var rs = R.find("rows");
				tr = parseInt(rs.attr("tr"));
				tp = parseInt(rs.attr("tp"));
				ps = parseInt(rs.attr("ps"));
				pn = parseInt(rs.attr("pn"));


			var j=0;
			
			r.each(function() {
				j=j+1;
				
				var uname = $(this).attr("uname");
				var uid = $(this).attr("uid");
				var ag = $(this).attr("ag");
				var au = $(this).attr("au");
				var info = $(this).attr("info");
				var bonus = $(this).attr("bonus");
				var betnum = $(this).attr("betnum");	
				var hid = $(this).attr("hid");	
				//alert(betnum);
				info=info.split(",");

				html+=''+
					'<tr class="bg_02" >'+
				'<td height="20">'+((pn*1-1)*ps+j)+'</td>'+
				'<td class="td_left">';
				
				var isdg=false;
				if (uname=='******'){
					isdg=true;					
				}
				
				if (isdg){
					html+=''+uname+'';
				}else{
					
					html+='<a href="javascript: void 0" onclick="Y.openUrl(\'/zj/view/'+uid+'\',525,465)" >'+uname+'</a>';
				}					
				html+='</td>';
				html+=(isdg?'<td>'+betnum+'':'<td><a href="'+$_sys.url.viewpath+'?lotid='+lotid+'&projid='+hid+'" target="_blank">'+betnum+'</a>')+(lotid=="50"?(isadd(info)?'<strong class="addTo" title="此方案为追加投注方案">+</strong>':''):'')+'</td>';

				if (info.length>1){
					if ($_sys.lottype.istype(lotid,"szc")==true){
						if (lotid=="50"){
//							if (isadd(info)){
//								for (var i=9;i<17;i++){
//									html+='<td class="td_t01" >'+info[i]+'</td>';
//								}		
//								html+='<td class="td_t01" >0</td>';
//								//html+='<td class="td_t01" >0</td>';
//							}else{
								for (var i=0;i<9;i++){
									html+='<td class="td_t01" >'+info[i]+'</td>';
								}
//							}	
						}else{
							for (var i=0;i<$_sys.getgrade(lotid).length;i++){
								html+='<td class="td_t01" >'+info[i]+'</td>';
							}	
						}						
					}else{	
						/*html+='<td class="red_b " >'+info[0]+'</td>';
						if (lotid==80||lotid==81){
							html+='<td class="cfont1">'+info[1]+'</td>';
						}			
						
						html+='<td class="cfont1">'+getmax(info)+'asdf</td>';
						if (isdg){
							html+='<td>'+uname+'</td>';
						}else{
							html+='<td><a href="zcfb.html?lotid='+lotid+'&expect='+expect+'&projid='+hid+'" target="_blank">查看</a></td>';
						}*/
					}
				}else{
					if ($_sys.lottype.istype(lotid,"szc")==true){
						if (lotid=="50"){
							for (var i=0;i<9;i++){
								html+='<td class="td_t01" >0</td>';
							}	
						}else{
							for (var i=0;i<$_sys.getgrade(lotid).length;i++){
								html+='<td class="td_t01" >0</td>';
							}
						}
												
					}else{	
						/*html+='<td class="red_b " ></td>';
						if (lotid==80||lotid==81){
							html+='<td class="cfont1"></td>';
						}			
						
						html+='<td class="cfont1"></td>';
						if (isdg){
							html+='<td>'+uname+'</td>';
						}else{
							html+='<td><a href="zcfb.html?lotid='+lotid+'&expect='+expect+'&projid='+hid+'" target="_blank">查看</a></td>';
						}*/						
					}
				}

				
				html+='<td class="bg_01">'+(parseFloat(bonus)>0?('<font color=red>'+parseFloat(bonus).rmb(false)+'</font>'):(parseFloat(bonus).rmb(false)))+'</td>';
				if(lotyid==1){
				html+='<td>';
				html+=isdg?uname:'<a href="javascript: void 0" onclick="Y.openUrl(\'/zj/view/'+uid+'\',525,466)" >定制</a>';
				'</td>';
				}
				html+='</tr>';				
				
			});
			html+='</table>';
			$('#showlist').html(html);		
			showpageno(lotid, expect, type ,pn,ps,tp,tr);				
		},
		error : function() {
			html+='<tr class="bg_01"><td  colSpan='+colSpan+' style="color:red">过关文件尚未生成</td></tr></table>';
			$('#showlist').html(html);
			return false;			
		}
	});		
	
};

var showpageno=function(lotid, expect,  type ,pn,ps,tp,tr){

	var maxshow=10;
	var pagehtml='<div class="my_page" style="HEIGHT: 40px; OVERFLOW: hidden"><div class="page"><span class="r">';
        pagehtml+='<A class=h_l title="" onclick="loadpage(\''+lotid+'\', '+expect+',\''+type+'\',1,'+ps+','+tp+','+ tr+');"  href="javascript:void(0)">首页</A>'+ 
    	'<A class=pre title=上一页  onclick="loadpage(\''+lotid+'\', '+expect+',\''+type+'\','+(pn-1>0?(pn-1):1)+','+ps+','+tp+','+ tr+');" href="javascript:void(0)"></A>';
    var min=0;
    var max=0; 
    if (tp > maxshow){
		var pageTemp=parseInt(pn*1/maxshow);
		max	= pageTemp*maxshow+maxshow;
	    min	= pageTemp*maxshow;
		if(max>tp){
			max=tp;
		}
		if(pn>min){min=min+1;}
    }else{
    	min = 1;
    	max = tp;
    }

	for (var i=min;i<max*1+1;i++){
		if (i==pn){
			pagehtml+='<A class=curpage title="" href="javascript:void(0)">'+i+'</A>';
		}else{
			pagehtml+='<A title="" onclick="loadpage(\''+lotid+'\', '+expect+',\''+type+'\','+i+','+ps+','+tp+','+ tr+');" href="javascript:void(0)">'+i+'</A>';
		}	     
	}
    pagehtml+='<A class=next title=下一页   onclick="loadpage(\''+lotid+'\', '+expect+',\''+type+'\','+(pn+1>tp?tp:(pn+1))+','+ps+','+tp+','+ tr+');"  href="javascript:void(0)">下一页</A>'+
    '<A class=h_l title="" onclick="loadpage(\''+lotid+'\', '+expect+',\''+type+'\','+tp+','+ps+','+tp+','+ tr+');" href="javascript:void(0)">尾页</A>'+
    	'<SPAN class=sele_page><INPUT onkeydown="if(event.keyCode==13){loadpage(\''+lotid+'\', '+expect+',\''+type+'\',Y.getInt(this.value),'+ps+','+tp+','+ tr+');return false;}" id=govalue class=num onkeyup="this.value=this.value.replace(/[^\\d]/g,\'\');if(this.value>'+tp+')this.value='+tp+';if(this.value<=0)this.value=1"  name=page>'+
    '<INPUT class=btn  onclick="loadpage(\''+lotid+'\', '+expect+',\''+type+'\',Y.getInt($(\'#govalue\').val()),'+ps+','+tp+','+ tr+');" value=GO type=button> </SPAN><SPAN class=gray>共'+tp+'页，'+tr+'条记录</SPAN></span></div></div>';
	$('#showlist').append(pagehtml);		
	
};

var omenu = function(id) {
	var lis = document.getElementById("mymenu").getElementsByTagName('LI');
	var len = lis.length;
	for ( var a = 0; a < len; a++) {
		lis[a].className = "menu01";
	}
	document.getElementById('menu' + id).className = "menu02";
};

var shiftvs = function(obj) {
	if (obj.checked == false) {
		document.getElementById('tr_vs1').style.display = '';
		document.getElementById('tr_vs2').style.display = 'none';
		document.getElementById('ul_kj').className = 'mini';
	} else {
		document.getElementById('tr_vs1').style.display = 'none';
		document.getElementById('tr_vs2').style.display = '';
		document.getElementById('ul_kj').className = 'normal';
	}
};