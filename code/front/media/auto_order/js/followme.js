/**
 * 
 */
$(function() {
	var d_e = new Date();
	var d_s = d_e.dateadd("m", -1);
	$("#begintime").val(d_s.format("YY-M-D"));
	$("#endtime").val(d_e.format("YY-M-D"));
	var html="";
	for (var i=0; i<$_sys.lottype.length;i++){
//		if ($_sys.lottype[i][1]=="gpc"){continue;}
		html+="<OPTGROUP label=\""+$_sys.lottype[i][0]+"\" id=\""+$_sys.lottype[i][1]+"\">";
		var tmp=$_sys.lottype[i][2].split(",");
		for (var j=0; j<tmp.length;j++){
			html+="	<OPTION value="+$_sys.lottype[i][3]+"_"+tmp[j]+" >"+$_sys.getlotyname($_sys.lottype[i][3],tmp[j]).replace("单场竞猜-","").replace("足彩胜负-","").replace("竞彩蓝球-","").replace("竞彩足球-","")+"</OPTION>";
		}
		html+="</OPTGROUP>";
	}
	$("#lotid").append(html);
	var pn = 1;// 页码
	var ps = 10;// 页面大小
	var tp = 0;// 总页数
	var tr = 0;// 总记录数
	showinfo(0,0, pn, ps, tp, tr,$("#begintime").val(),$("#endtime").val());
	$("#submit").bind({
		click : function() {
			var pn = 1;// 页码
			var ps = $("input[name='pages']:checked").val();// 页面大小
			var tp = 0;// 总页数
			var tr = 0;// 总记录数
			var tmplotid = 0;
			var tmpplayid = 0;
			var lotplay = $("#lotid").val().split('_');
			if(lotplay.length==2){
			 tmplotid = lotplay[0];
			 tmpplayid = lotplay[1];
			}

			showinfo(tmplotid,tmpplayid,pn, ps, tp, tr,$("#begintime").val(),$("#endtime").val());
		}
	});
});

var showinfo = function(lotyid,play_id, pn, ps, tp, tr,stime,etime) {// 页码 页面大小 总页数 总记录数
	var data = "";
	if (tr % ps == 0) {
		tp = tr / ps;
	} else {
		tp = Math.ceil(tr / ps);
	}


	data += "&" + $_user.key.lotyid + "=" + lotyid;
	data += "&" + $_user.key.play_id + "=" + play_id;

	data += "&" + $_user.key.pn + "=" + pn;
	data += "&" + $_user.key.ps + "=" + ps;
	data += "&" + $_user.key.tp + "=" + tp;
	data += "&" + $_user.key.tr + "=" + tr;
//	data += "&" + $_user.key.etime + "=" + etime;
//	data += "&" + $_user.key.stime + "=" + stime;

	$("#showdatalist").html("");

	var html = "";
	var tophtml = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"my_tbl\">"+
		"<colgroup>" +
		"<col width=\"32\" />" +
		"<col width=\"134\" />" +
		"<col width=\"108\" />" +
		"<col width=\"100\" />" +
		"<col width=\"100\" />" +
		"<col width=\"100\" />" +
		"<col width=\"120\" />" +
		"<col width=\"60\" />" +
		"</colgroup>" +
		"<TBODY>" +
		"<th>序号</th>" +
		"<th>玩法</th>" +
		"<th>跟单人</th>" +
		"<th>每次认购金额</th>" +
		"<th>已跟单数</th>" +
		"<th>跟单总金额</th>" +
		"<th>定制时间</th>" +
		"<th class=\"last_th\">状态</th>" +
		"</tr> ";
	$.ajax({
		url : $_user.url.followme,
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
				tr = rs.attr("tr");
				tp = rs.attr("tp");
				ps = rs.attr("ps");
				pn = rs.attr("pn");
				if (tr % ps == 0) {
					tp = tr / ps;
				} else {
					tp = Math.ceil(tr / ps);
				}


				r.each(function() {
					var rec = $(this).attr("rec");
					var nickid = $(this).attr("nickid");
					var nickname = $(this).attr("nickname");
					var gameid = $(this).attr("gameid");
					var lotyid = $(this).attr("lotyid");
					var play_id = $(this).attr("play_id");
					var owner = $(this).attr("owner");
					var state = $(this).attr("state");
					var limit = $(this).attr("limit");
					var minmoney = $(this).attr("minmoney");
					var maxmoney = $(this).attr("maxmoney");
					var adddate = $(this).attr("adddate");
					var bmoney = $(this).attr("bmoney");
					var nums = $(this).attr("nums");
					var tmoney = $(this).attr("tmoney");


					html += "<TR>";
					html += " <TD>"+rec+"</TD>";
					html += " <TD>"+$_sys.getlotyname(lotyid,play_id)+"</TD>";
					html += " <TD>"+nickname+"</TD>";
					html += " <TD><SPAN class=\"red eng\">"
							+ parseFloat(bmoney).rmb(false)
							+ "</SPAN><SPAN class=gray>元</SPAN></TD>";
					html += " <TD>"+nums+"</TD>";
					html += " <TD class=tr><SPAN class=\"red eng\">"
						+ parseFloat(tmoney).rmb(false)
						+ "</SPAN><SPAN class=gray>元</SPAN></TD>";
					html += " <TD>"+adddate+"</TD>";
					if ( state == 1 ) {
						html += " <TD class=last_td>启用</TD>";
					} else {
						html += " <TD class=last_td>禁用</TD>";
					}
					
					html += " </TR>";

				});
			} else {
				if (code == "1") {
					parent.window.Y.postMsg('msg_login', function() {						
						window.location.reload();			
					});
				}else{
					html += "<TR><TD colSpan=11 align=middle>没有定制记录</TD></TR>";
				}
			}

			html += " </TBODY></TABLE>";
			html += "<DIV class=rec_added>";
			html += "<p>说明：<span class=\"gray\">本站所有用户均可发起自动跟单方案，无方案个数限制；跟单人制定后，系统将根据发起人的发单时间依次认购。</span> <a href=\"#\" target=\"_blank\" class=\"blue\">自动跟单规则&gt;&gt;</a> </p></div> ";
			html += "<DIV style=\"HEIGHT: 40px; OVERFLOW: hidden\" class=my_page>";
			html += "<DIV class=page>";
			for (i = 1; i <= tp; i++) {
				if (i == pn) {
					html += "<A class=curpage title=\"\" href=\"javascript:void(0);\">"
							+ i + "</A>";
				} else { // (stime,etime,tid,pn,ps,tp,tr)
					html += "<a href=\"javascript:void(0);\" onclick=\"showinfo("+ lotyid+ ","+ play_id+ ","+ i+ ","+ ps+ ","+ tp+ ","+ tr+ ",'"+stime+"','"+etime+"');\" class=\"chakan\">" + i + "</a> ";
				}
			}

			html += "<SPAN class=gray>共" + tp + "页，" + tr	+ "条记录</SPAN>";
			html += "</DIV>";
			html += "<DIV id=pagesize class=prepage>每页显示 <LABEL class=label_l for=pg10><INPUT id=pg10 class=rdo onclick=\"showinfo("+ lotyid+ ","+ play_id+ ",1,10,0,"+ tr + ",'"+stime+"','"+etime+"');\" value=10 type=radio name=pages ";
			if (ps == 10) {
				html += " CHECKED=\"checked\"";
			}
			html += " />10条</LABEL>";
			html += "<LABEL for=pg50><INPUT id=pg50 class=rdo onclick=\"showinfo("+ lotyid+ ","+ play_id+ ",1,50,0,"+ tr + ",'"+stime+"','"+etime+"');\" value=50 type=radio name=pages ";
			if (ps == 50) {
				html += " CHECKED=\"checked\"";
			}
			html += " />50条</LABEL></DIV>";
			html += "</DIV>";
			html += "</DIV>";

			html = tophtml + html;
			$("#showdatalist").html(html);
			autoHeight();

		},
		error : function() {
			alert("您所请求的页面有异常！");
			return false;
		}
	});
};
