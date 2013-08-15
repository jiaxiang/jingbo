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
		for (var i=10;i<17;i++){
			if (info[i]>0){
				return true;
			}
		}
	}
	return false;
};

$(function() {

//	var lotid = location.search.getParam('lotid');
	var lotid = $_sys.lotid;	
	var expect = location.search.getParam('expect');
	if (lotid == "") {
		lotid = "90";
	}
	// alert($_sys.getlotname(lotid));
	var lotimg = "";
	switch (lotid) {

	case "90":
	lotyid='1';playid='1';
		break;
	case "91":
	lotyid='1';playid='4';
		break;
	case "92":
	lotyid='1';playid='2';
		break;
	case "93":
	lotyid='1';playid='3';
		break;	

	case "100":
	lotyid='6';playid='1';
		break;
	case "101":
	lotyid='6';playid='2';
		break;
	case "102":
	lotyid='6';playid='3';
		break;
	case "103":
	lotyid='6';playid='4';
		break;
	}
	$("#lotid").val(lotid);

	$("#seltype").val("fs");
	
	showinfo($("#lotid").val(), expect,"jcfs");
	
	$("#expect").bind({
		change : function() {
			if ($("#seltype").val()=="my"){
				var pn=1;//页码
				var ps = 25;//页面大小
				var tp = 0;//总页数
				var tr = 0;//总记录数		
				myguoguan($("#lotid").val(), $("#expect").val(),pn,ps,tp,tr);
			}else{
				loadmain($("#lotid").val(), $("#expect").val(),"jcfs");
			}
		}
	});	

	$("#menu1").bind({
		click:function(){
			$("#seltype").val("fs");
			omenu(1);
			var seltype=$("#seltype").val();
			var pn=1;//页码
			var ps = $("#"+seltype+"_ps").val();//页面大小
			var tp = $("#"+seltype+"_tp").val();//总页数
			var tr = $("#"+seltype+"_tr").val();//总记录数	
            loadpage($("#lotid").val(), $("#expect").val(),$("#seltype").val(),pn,ps,tp,tr);
		}	
	});
		
});

var myguoguan = function(lotid,expect,pn,ps,tp,tr){
	var colSpan=9;
	var html='<table class="table_list01" border="0" cellpadding="0" cellspacing="0" width="100%" >'+
	'<tbody>'+
	'<tr>'+
	'<td class="td_t01" height="25" >排序</td>'+
	'<td class="td_t01 td_left" >发起人</td>'+

	'<td class="td_t01" >方案金额</td>'+
	'<td class="td_t01" >场数</td>'+
		'<td class="td_t01" >过关类型</td>';
	//'<td class="td_t01" >中奖注数</td>';
	
	html+='<td class="td_t01" >税前奖金</td>'+
	//'<td class="td_t01" >自动跟单</td>'+
	'</tr>'+
	'</tbody>';
	
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
					var uname = $(this).attr("uname");
					var uid = $(this).attr("nickid");
					var ag = $(this).attr("ag");
				
					var info = $(this).attr("info");
					var bonus = $(this).attr("bonus");
					var betnum = $(this).attr("betnum");	
					var hid = $(this).attr("hid");	
					
					info=info.split("|");
					
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
					html+='</td>';
					html+=isdg?'<td>'+betnum+'</td>':'<td><a href="'+$_sys.url.viewpath+'?lotid='+lotid+'&projid='+hid+'" target="_blank">'+betnum+'</a></td>';
					if (info.length>1){
						
						html+='<td>'+info[1]+'</td>';			
						
						html+='<td title="'+info[2].replaceAll("\\*","串")+'">'+info[2].split(",")[0].replaceAll("\\*","串")+'</td>';

						if(info[0]>0){
							html+='<td class="red_b">'+info[0]+'</td>';
						}else{
							html+='<td>'+info[0]+'</td>';
						}
					}else{
						html+='<td></td>';			
						
						html+='<td></td><td>未过关</td>';
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
			html+='<tr class="bg_01"><td  colSpan='+colSpan+' style="color:red">文件尚未生成</td></tr></table>';
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
        pagehtml+='<A class=h_l title="" onclick="myguoguan(\''+lotid+'\', \''+expect+'\',1,'+ps+','+tp+','+ tr+');"  href="javascript:void(0)">首页</A>'+ 
    	'<A class=pre title=上一页  onclick="myguoguan(\''+lotid+'\', \''+expect+'\','+(pn-1>0?(pn-1):1)+','+ps+','+tp+','+ tr+');" href="javascript:void(0)"></A>';
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
			pagehtml+='<A title="" onclick="myguoguan(\''+lotid+'\', \''+expect+'\','+i+','+ps+','+tp+','+ tr+');" href="javascript:void(0)">'+i+'</A>';
		}	     
	}
    pagehtml+='<A class=next title=下一页   onclick="myguoguan(\''+lotid+'\', \''+expect+'\','+(pn+1>tp?tp:(pn+1))+','+ps+','+tp+','+ tr+');"  href="javascript:void(0)">下一页</A>'+
    '<A class=h_l title="" onclick="myguoguan(\''+lotid+'\', \''+expect+'\','+tp+','+ps+','+tp+','+ tr+');" href="javascript:void(0)">尾页</A>'+
    	'<SPAN class=sele_page><INPUT onkeydown="if(event.keyCode==13){myguoguan(\''+lotid+'\', \''+expect+'\',Y.getInt(this.value),'+ps+','+tp+','+ tr+');return false;}" id=govalue class=num onkeyup="this.value=this.value.replace(/[^\\d]/g,\'\');if(this.value>'+tp+')this.value='+tp+';if(this.value<=0)this.value=1"  name=page>'+
    '<INPUT class=btn  onclick="myguoguan(\''+lotid+'\', \''+expect+'\',Y.getInt($(\'#govalue\').val()),'+ps+','+tp+','+ tr+');" value=GO type=button> </SPAN><SPAN class=gray>共'+tp+'页，'+tr+'条记录</SPAN></span></div></div>';

	$('#showlist').append(pagehtml);		
	
};

var showinfo = function(lotid, expect,type) {
	$.ajax({
		//url : $_trade.url.cacheperiod,
		url : "/guoguan/"+$_sys.loty+"/expectlist",
		type : "get",
		dataType : "xml",
		cache : false,
		success : function(xml) {
			var r = $(xml).find("row");
			var expectlist = [];
			
			r.each(function() {
				var pid = $(this).attr("did");
				expectlist[expectlist.length] = ["20"+pid];
			});
			
			var html='';
			if (expectlist.length>0){
				for ( var i = 0; i < expectlist.length; i++) {
					html+='<option value="'+expectlist[i][0]+'">'+expectlist[i][0].substr(0,4)+'-'+expectlist[i][0].substr(4,2)+'-'+expectlist[i][0].substr(6,2)+'</option>';
				}		
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
			lotyid:lotyid,
			playid:playid,
			expect : expect
		},
		cache : false,
		success : function(xml) {
			var rs = $(xml).find("rows");		

			$("#fs_ps").val(rs.find("jcfs").attr("ps"));
			$("#fs_tp").val(rs.find("jcfs").attr("tp"));
			$("#fs_tr").val(rs.find("jcfs").attr("total"));
			
			$("#us_ps").val(rs.find("jcus").attr("ps"));
			$("#us_tp").val(rs.find("jcus").attr("tp"));
			$("#us_tr").val(rs.find("jcus").attr("total"));

			$("#ff_ps").val(rs.find("jcff").attr("ps"));
			$("#ff_tp").val(rs.find("jcff").attr("tp"));
			$("#ff_tr").val(rs.find("jcff").attr("total"));
			
			$("#uf_ps").val(rs.find("jcuf").attr("ps"));
			$("#uf_tp").val(rs.find("jcuf").attr("tp"));
			$("#uf_tr").val(rs.find("jcuf").attr("total"));
		 
			loadpage(lotid, expect, $("#seltype").val(),1,rs.find(type).attr("ps"),rs.find(type).attr("tp"),rs.find(type).attr("total"));
		},
		error : function() {
			var html='<table class="table_list01" border="0" cellpadding="0" cellspacing="0" width="100%" >'+
			'<tbody>'+
			'<tr>'+
			'<td class="td_t01" height="25" >排序</td>'+
			'<td class="td_t01 td_left" >发起人</td>'+
			'<td class="td_t01 td_left">战绩</td>'+
			'<td class="td_t01" >方案金额</td><td class="td_t01" >场数</td><td class="td_t01" >过关类型</td><td class="td_t01" >中奖注数</td>';
			
			html+='<td class="td_t01" >税前奖金</td>';
			if(lotyid==1)
			html+='<td class="td_t01" >自动跟单</td>';

			html+='</tr>'+
			'</tbody>';
			html+='<tr class="bg_01"><td  colSpan=9 style="color:red">该玩法无方案存在</td></tr></table>';
			$('#showlist').html(html);
			return false;
		}
	});
};

var loadpage = function(lotid, expect, type ,pn,ps,tp,tr) {
	var html='<table class="table_list01" border="0" cellpadding="0" cellspacing="0" width="100%" >'+
	'<tbody>'+
	'<tr>'+
	'<td class="td_t01" height="25" >排序</td>'+
	'<td class="td_t01 td_left" >发起人</td>'+

	'<td class="td_t01" >方案金额</td><td class="td_t01" >场数</td><td class="td_t01" >过关类型</td>';
	//+'<td class="td_t01" >中奖注数</td>';
	
	html+='<td class="td_t01" >税前奖金</td>';
	if(lotyid==1)
	html+='<td class="td_t01" >自动跟单</td>';
	html+='</tr>'+
	'</tbody>';

	$.ajax({
		url : "/guoguan/public/search",
		type : "POST",
		dataType : "xml",
		data : {
			lotyid:lotyid,
			playid:playid,
			expect : expect,
			pn: pn
		},
		cache : false,
		success : function(xml) {
			//<row uname="用户名" ag="金星" au="银星" info="中奖注数，选择的场次，过关方式" bonus="奖金" betnum="投注注数" mnums="选择场数" zhushu="中奖注数" gnames="几串几" hid="方案id" />
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
				var info = $(this).attr("info");
				var bonus = $(this).attr("bonus");
				var betnum = $(this).attr("betnum");
				var mnums = $(this).attr("mnums");//场数
				var zhushu = $(this).attr("bnums");//中奖注数
				var gnames = $(this).attr("gnames");
				var hid = $(this).attr("hid");	
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
					html+='<a href="javascript: void 0" onclick="Y.openUrl(\'/zj/view/'+uid+'\',525,466)" >'+uname+'</a>';
				}					
				html+='</td>';
				html+=isdg?'<td>'+betnum+'</td>':'<td><a href="'+$_sys.url.viewpath+'?lotid='+lotid+'&projid='+hid+'" target="_blank">'+betnum+'</a>'+(lotid=="50"?(isadd(info)?'<strong class="addTo" title="此方案为追加投注方案">+</strong>':''):'')+'</td>';
						
				html+='<td>'+mnums+'</td>';			
				/*var gstr="";
				if(gnames.split(",").length>1){
					gstr=gnames.split(",")[0].replaceAll("\\*","串")+","+gnames.split(",")[1].replaceAll("\\*","串");
					if(gnames.split(",").length>2){gstr=gstr+"..";}
				}else{
					gstr=gnames.replaceAll("\\*","串");
				}
				html+='<td title="'+gnames.replaceAll("\\*","串")+'">'+gstr+'</td>';*/
				html+='<td title="'+gnames+'">'+gnames+'</td>';
				/*if(zhushu>0){
					html+='<td class="red_b">'+zhushu+'</td>';
				}else{
					html+='<td>'+zhushu+'</td>';
				}*/

				html+='<td class="bg_01">'+(parseFloat(bonus)>0?('<font color=red>'+parseFloat(bonus).rmb(false)+'</font>'):(parseFloat(bonus).rmb(false)))+'</td>';
				if(lotyid==1){
					html+='<td>';
					html+=isdg?uname:'<a href="javascript: void 0" onclick="Y.postMsg(\'msg_login\',function(){Y.openUrl(\'/user_auto_order/add/1/'+playid+'/'+uid+'\',475,307)});" >定制</a>';
					'</td>';
				}
				html+='</tr>';				
				
			});
			html+='</table>';
			$('#showlist').html(html);		
			showpageno(lotid, expect, type ,pn,ps,tp,tr);				
		},
		error : function() {
			html+='<tr class="bg_01"><td  colSpan="9" style="color:red">该玩法无方案存在</td></tr></table>';
			$('#showlist').html(html);
			return false;			
		}
	});		
	
};

var showpageno=function(lotid, expect,  type ,pn,ps,tp,tr){

	var maxshow=10;
	var pagehtml='<div class="my_page" style="HEIGHT: 40px; OVERFLOW: hidden"><div class="page"><span class="r">';
        pagehtml+='<A class=h_l title="" onclick="loadpage(\''+lotid+'\', \''+expect+'\',\''+type+'\',1,'+ps+','+tp+','+ tr+');"  href="javascript:void(0)">首页</A>'+ 
    	'<A class=pre title=上一页  onclick="loadpage(\''+lotid+'\', \''+expect+'\',\''+type+'\','+(pn-1>0?(pn-1):1)+','+ps+','+tp+','+ tr+');" href="javascript:void(0)"></A>';
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
			pagehtml+='<A title="" onclick="loadpage(\''+lotid+'\', \''+expect+'\',\''+type+'\','+i+','+ps+','+tp+','+ tr+');" href="javascript:void(0)">'+i+'</A>';
		}	     
	}
    pagehtml+='<A class=next title=下一页   onclick="loadpage(\''+lotid+'\', \''+expect+'\',\''+type+'\','+(pn+1>tp?tp:(pn+1))+','+ps+','+tp+','+ tr+');"  href="javascript:void(0)">下一页</A>'+
    '<A class=h_l title="" onclick="loadpage(\''+lotid+'\', \''+expect+'\',\''+type+'\','+tp+','+ps+','+tp+','+ tr+');" href="javascript:void(0)">尾页</A>'+
    	'<SPAN class=sele_page><INPUT onkeydown="if(event.keyCode==13){loadpage(\''+lotid+'\', \''+expect+'\',\''+type+'\',Y.getInt(this.value),'+ps+','+tp+','+ tr+');return false;}" id=govalue class=num onkeyup="this.value=this.value.replace(/[^\\d]/g,\'\');if(this.value>'+tp+')this.value='+tp+';if(this.value<=0)this.value=1"  name=page>'+
    '<INPUT class=btn  onclick="loadpage(\''+lotid+'\', \''+expect+'\',\''+type+'\',Y.getInt($(\'#govalue\').val()),'+ps+','+tp+','+ tr+');" value=GO type=button> </SPAN><SPAN class=gray>共'+tp+'页，'+tr+'条记录</SPAN></span></div></div>';
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