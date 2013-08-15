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
	
	ESONCalendar.init().bind("begintime").bind("endtime").splitChar="-";
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
	data += "&" + $_user.key.etime + "=" + etime;
	data += "&" + $_user.key.stime + "=" + stime;

	$("#showdatalist").html("");

	var html = "";
	var tophtml = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"my_tbl\">"+
		 "<colgroup>" +
		"<col width=\"32\" />" +
		"<col width=\"134\" />" +
		"<col width=\"88\" />" +
		"<col width=\"86\" />" +
		"<col width=\"60\" />" +
		"<col width=\"40\" />" +
		"<col width=\"60\" />" +
		"<col width=\"150\" />" +
		"<col width=\"\" />" +
		"</colgroup>" +
		"<TBODY>" +
		"<th>序号</th>" +
		"<th>玩法</th>" +
		"<th>发起人</th>" +
		"<th>方案编号</th>" +
		"<th>认购金额</th>" +
		"<th>状态</th>" +
		"<th>是否成功</th>" +
		"<th>备注</th>" +
		"<th class=\"last_th\">跟单时间</th>" +
		"</tr> ";
	$.ajax({
		url : $_user.url.followhist,
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
					var gameid = $(this).attr("cgameid");
					var lotyid = $(this).attr("lotyid");
					var play_id = $(this).attr("play_id");
					var owner = $(this).attr("cowner");
					var projid = $(this).attr("cprojid");
					var state = $(this).attr("istate");
					var imoney = $(this).attr("imoney");
					var success = $(this).attr("isuccess");
					var reason = $(this).attr("creason");
					var adddate = $(this).attr("cadddate");

					html += "<TR>";
					html += " <TD>"+rec+"</TD>";
					html += " <TD>"+$_sys.getlotyname(lotyid,play_id)+"</TD>";
					html += " <TD>"+owner+"</TD>";
					
					var surl = '/'+$_sys.getViewPath(lotyid)+'/viewdetail/'+projid;
					html += ' <TD><a href=\"' + surl + '\" target=_blank>' +projid+'</a></TD>';
					
					html += " <TD class=tr><SPAN class=\"red eng\">"
							+ parseFloat(imoney).rmb(false)
							+ "</SPAN><SPAN class=gray>元</SPAN></TD>";
					
					if ( state == 0 ) {
						html += " <TD>"+"未处理"+"</TD>";
					} else {
						html += " <TD>"+"已处理"+"</TD>";
					}
					if ( success == 0 ) {
						if ( state == 1 ) {
							html += " <TD style='color:red'>"+"不成功"+"</TD>";
						}
					} else {
						html += " <TD>"+"成功"+"</TD>";
					}
					html += " <TD>"+reason+"</TD>";
					html += " <TD>"+adddate+"</TD>";
					
//					html += " <TD class=last_td><A href=\"#\" target=_blank>查看详情</A> </TD>";
					html += " </TR>";
				});
			} else {
				if (code == "1") {
					parent.window.Y.postMsg('msg_login', function() {						
						window.location.reload();			
					});
				}else{
					html += "<TR><TD colSpan=11 align=middle>没有跟单记录</TD></TR>";
				}
			}

			html += " </TBODY></TABLE>";
			html += "<DIV class=rec_added>";
			html += "<p>说明： <span class=\"gray\">每期自动跟单记录。</span> <a href=\"#\" target=\"_blank\" class=\"blue\">自动跟单规则&gt;&gt;</a> </p></div> ";
			html += "<DIV style=\"HEIGHT: 40px; OVERFLOW: hidden\" class=my_page>";
			html += "<DIV class=page>";
			for (i = 1; i <= tp; i++) {
				if (i == pn) {
					html += "<A class=curpage title=\"\" href=\"javascript:void(0);\">"
							+ i + "</A>";
				} else { // (stime,etime,tid,pn,ps,tp,tr)
					html += "<a href=\"javascript:void(0);\" onclick=\"showinfo("+ lotyid+ ","+ play_id+ ","+ i+ ","+ ps+ ","+ tp+ ","+ tr+ ",'"+$("#begintime").val()+"','"+etime+"');\" class=\"chakan\">" + i + "</a> ";
				}
				
			}

			html += "<SPAN class=gray>共" + tp + "页，" + tr	+ "条记录</SPAN>";
			html += "</DIV>";
			html += "<DIV id=pagesize class=prepage>每页显示 <LABEL class=label_l for=pg10><INPUT id=pg10 class=rdo onclick=\"showinfo("+ lotyid+ ","+ play_id+ ",1,10,0,"+ tr + ",'"+$("#begintime").val()+"','"+etime+"');\" value=10 type=radio name=pages ";
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
