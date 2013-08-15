function g(o) { 
	return document.getElementById(o); 
}
function HoverLi(n) {
    //如果有N个标签,就将i<=N;
    for (var i = 1; i <= 5; i++) { 
    	g('tb_' + i).className = 'normaltab'; 
    	g('tbc_0' + i).className = 'undis'; 
    } 
    g('tbc_0' + n).className = 'dis'; 
    g('tb_' + n).className = 'hovertab';
    
    
    if ( n == 1 ) {
    	gid = '9';
    	$("input[name=as][value=9]").attr("checked",true);
    } else if (n==5) {
    	gid = '13';
    	$("input[name=as][value=13]").attr("checked",true);
    }else  if (n==3){
    	gid = '1';
    	$("input[name=as][value=1]").attr("checked",true);
    }else  if (n==4){
    	gid = '5';
    	$("input[name=as][value=5]").attr("checked",true);
    }
	else  if (n==2){
    	gid = '18';
    	$("input[name=as][value=18]").attr("checked",true);
    }
	else{
    	gid = '1';
    	$("input[name=as][value=1]").attr("checked",true);
    }
    showinfo();
}
//如果要做成点击后再转到请将<li>中的onmouseover 改成 onclick;

function gameClick(_gid) {
	//ps = 25;
	pn = 1;
	tp = 0;
	tr = 0;
	//lotyid = _lotyid;
	//playid = _playid;
	gid = _gid;

	showinfo();
}




function jpAwardClick(_func) {
	//ps = 25;
	pn = 1;
	tp = 0;
	tr = 0;
	func = _func ;
	showinfo();
}

var ps = 10;
var pn = 1;
var tp = 0;
var tr = 0;
var gid = '';

var gopage = function(p) {
	pn = p;
	showinfo();
};

var jump = function() {
	pn = $("#pselect").val();
	showinfo();
};

var showinfo = function() {// 页码 页面大小 总页数 总记录数
	if (gid == "" || uid == "") {
		$_sys.showerr('参数错误');
		return ;
	}
	switch (gid)
	{
	case '1':
		lotyid='1';playid='1';
	break;
		case '2':
		lotyid='1';playid='2';
	break;
		case '3':
		lotyid='1';playid='3';
	break;
		case '4':
		lotyid='1';playid='4';
	break;
		case '5':
		lotyid='6';playid='1';
	break;
		case '6':
		lotyid='6';playid='2';
	break;
		case '7':
		lotyid='6';playid='3';
	break;
		case '8':
		lotyid='6';playid='4';
	break;
		case '9':
		lotyid='2';playid='1';
	break;
		case '10':
		lotyid='2';playid='4';
	break;
		case '11':
		lotyid='2';playid='2';
	break;
		case '12':
		lotyid='2';playid='3';
	break;
		case '13':
		lotyid='7';playid='501';
	break;
		case '14':
		lotyid='7';playid='503';
	break;
		case '15':
		lotyid='7';playid='502';
	break;
		case '16':
		lotyid='7';playid='504';
	break;
		case '17':
		lotyid='7';playid='505';
	break;
		case '18':
		lotyid='8';playid='0';
	break;
		case '19':
		lotyid='11';playid='0';
	break;
		case '20':
		lotyid='10';playid='0';
	break;
		case '21':
		lotyid='9';playid='0';
	break;

	}

	var viewpath='';
	switch(lotyid){
	case '1':
		viewpath = '/jczq/viewdetail/';
	break;
	case '2':
		viewpath= '/zcsf/viewdetail/';
	break;
	case '6':
		viewpath = '/jclq/viewdetail/';
	break;
	case '7':
		viewpath = '/bjdc/viewdetail/';
	break;
	case '8':
		viewpath = '/dlt/view/';
	break;
	case '9':
		viewpath = '/plw/view/';
	break;
	case '10':
		viewpath = '/qxc/view/';
	break;
	case '11':
		viewpath = '/pls/view/';
	break;		
	}

	var data = {
		func:func,	
		lotyid:lotyid,
		playid:playid,
		gid:gid,
		uid:uid,
		ps:ps,
		pn:pn,
		tp:tp,
		tr:tr
	};

	$("#suid").html(uname);
	//$("#showdatalist").html("");
	var tophtml = '<table width="100%" border="0" bgcolor="#FFFFFF"  cellpadding="0"  cellspacing="0">' ;
	tophtml += 		'<tr align="center" class="d_tabletitle">' ;
	if(lotyid!=1&&lotyid!=6)
	tophtml += '<td width="60">期号</td>' ;

	tophtml += '<td width="80">方案编号</td>' ;
	tophtml += '<td width="80">方案金额</td>' ; 
	tophtml += '<td width="80">中奖金额</td>' ;
	tophtml += '<td width="80">盈利金额</td>' ;
	tophtml += '<td width="60">回报率</td>' ;
	tophtml += '</tr>';

	var html = "";
	$.ajax({
		url : "/zj/tquery",
		type : "POST",
		dataType : "xml",
		data : data,
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			var innum = incount = outnum = outcount = 0;
			rows = "";
			if (code == "0") {
				var r = R.find("row");
				var rs = R.find("rows");
				tr = parseInt(rs.attr("tr"));
				tp = parseInt(rs.attr("tp"));
				ps = parseInt(rs.attr("ps"));
				pn = parseInt(rs.attr("pn"));
				var cc = 0;
				r.each(function() {
					var planid = $(this).attr("planid");
					var order_num = $(this).attr("irecid");
					var hid = $(this).attr("cprojid");
					var pid = $(this).attr("cperiodid");
					var ipmoney = $(this).attr("ipmoney");
					var iwmoney = $(this).attr("iwmoney");
					var imoney = iwmoney - ipmoney;
					var wrate = parseFloat(iwmoney / ipmoney).rmb(false) ;
					if ( imoney <= 0 ) {
						imoney = 0;
						wrate = 0;
					} 
					
					var iaunum = $(this).attr("iaunum");

					html += "<TR>";
					if(lotyid!=1&&lotyid!=6)
					html += ' <TD>'+pid+'</TD>';
					html += ' <TD><a class=pr href="';

					if(lotyid==8||lotyid==9||lotyid==10||lotyid==11)
					html += viewpath+planid;
					else
					html += viewpath+order_num;

					html += '" target=_blank title="点击查看">'+hid+'</a></TD>';
					html += '<td style=" color:#F00">￥' + parseFloat(ipmoney).rmb(false) + '</td>';
					html += '<td style=" color:#F00">￥' + parseFloat(iwmoney).rmb(false) + '</td>';
					html += '<td style=" color:#F00">￥' + parseFloat(imoney).rmb(false) + '</td>';
					html += " <TD>"+wrate+"倍</TD>";
					html += " </TR>";
					cc++;
				});
				
				for ( var i=0;i<ps-cc;i++) {
					html += "<TR>";
					if(lotyid!=1&&lotyid!=6)
					html += " <TD>&nbsp;</TD>";
			
					html += " <TD>&nbsp;</TD>";
					html += " <TD>&nbsp;</TD>";
					html += " <TD>&nbsp;</TD>";
					html += " <TD>&nbsp;</TD>";
					html += " <TD>&nbsp;</TD>";
					html += " </TR>";
				}
				
				html += '<tr align="left">';
			
					html += '<td colspan="6">总数<span class="red">' + tp + '</span>页&nbsp;&nbsp;分页';
			
				html += '[<a href="#" onclick="gopage(1);" title="首页">&lt;&lt;</a>]&nbsp;&nbsp;';
				if ( pn == 1 ) {
					html += '[&lt;]&nbsp;&nbsp;&nbsp;';
				} else {
					html += '[<a href="#" onclick="gopage(pn-1);" title="上一页">&lt;</a>]&nbsp;&nbsp;&nbsp;';
				}
				if ( pn == tp ) {
					html += '[&gt;]&nbsp;&nbsp;';
				} else {
					html += '[<a href="#" onclick="gopage(pn+1)" title="下一页">&gt;</a>]&nbsp;&nbsp;';
				}
				html += '[<a href="#" onclick="gopage(tp)" title="尾页">&gt;&gt;</a>]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				html += '<span class="su_page"> 跳转至<select id="pselect" style="height:20px; border:1px solid #09C;" onchange="jump()">';
				for (var i=1;i<=tp;i++) {
					if ( i == pn ) {
						html += '<option selected="true" value="' + i + '">' +i+'</option>';
					} else {
						html += '<option value="' + i + '">' +i+'</option>';
					}
				}
				html += '</select></span>页</td>';
			    html += '</tr>';
			} else {
				if (code == "1") {
					parent.window.Y.postMsg('msg_login', function() {						
						window.location.reload();			
					});
				}
			}

			html += " </TBODY></TABLE>";
			html = tophtml + html;
			$("#dzgd").attr('href','/main/autobuy.html?type=new&lotid='+gid+'&owner='+uid);
			$("#showdatalist").html(html);
		},
		error : function() {
			alert("您所请求的页面有异常！");
			return false;
		}
	});

};


$(function() {

	gid = location.search.getParam('lotyid');
	lotyid = location.search.getParam('lotyid');
	playid = location.search.getParam('playid');

	func = location.search.getParam('func');
	
	if ( func == '') {
		func = 'zj';
	}
	$("input[name=ss][value=" + func + "]").attr("checked",true);
	$("input[name=as][value=" + gid + "]").attr("checked",true);

	
	if ( gid == '1' || gid == '2' || gid == '3' || gid == '4') {
		HoverLi(3);
	}else if ( gid == '5' || gid == '6' || gid == '7' || gid == '8'){
		HoverLi(4);
	}else if ( gid == '9' || gid == '10' || gid == '11' || gid == '12'){
		HoverLi(1);
	}else if ( gid == '13' || gid == '14' || gid == '15' || gid == '16'){
		HoverLi(5);
	}
	else if (gid == '18' || gid == '19' || gid == '20' || gid == '21')
	{
		HoverLi(2);
	}
	else {
		HoverLi(3);
	}
	
	
//	showinfo();
});

