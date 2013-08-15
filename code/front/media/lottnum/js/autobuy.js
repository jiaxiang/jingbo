function yesselect() {
	$("#settxt").hide();	
}

function noselect() {
	$("#settxt").show();
}

$(function() {
var auto_id = 0;
	
	if (lotyid == "" || ower == "") {
		$_sys.showerr('参数错误');
		return ;
	}
	
	var data = {
		lotyid:lotyid,
		ower:ower,
		fid:fid,
		play_id:play_id
	};

	$.ajax({
		url : '/user_auto_order/search_auto_order',
		type : "POST",
		dataType : "xml",
		data : data,
		success : function(xml) {
			var R = $(xml).find("Resp");
			var code = R.attr("code");
			var desc = R.attr("desc");
			var lotyname = R.attr("lotyname");
			if (code == "0") {
				var r = R.find("row");

				var istate = "";// 状态
				var ilimit = "";// 是否有限制
				var iminmoney = "";// 方案最小金额
				var imaxmoney = "";// 方案最大金额
				var cadddate = "";// 添加时间
				var ibmoney = "";// 认购金额
				var inums = "";// 已购买次数
				var itmoney = "";// 已购买金额

				r.each(function() {
					istate = $(this).attr("istate");// 状态
					ilimit = $(this).attr("ilimit");// 是否有限制
					iminmoney = $(this).attr("iminmoney");// 方案最小金额
					imaxmoney = $(this).attr("imaxmoney");// 方案最大金额
					cadddate = $(this).attr("cadddate");// 添加时间
					ibmoney = $(this).attr("ibmoney");// 认购金额
					inums = $(this).attr("inums");// 已购买次数
					itmoney = $(this).attr("itmoney");// 已购买金额
					lotyname = $(this).attr("lotyname");
					auto_id = $(this).attr("auto_id");
				});

				var allm = "";
				var allc = "";
				var c = R.find("count");
				c.each(function() {
					allm = $(this).attr("allm");// 状态
					allc = $(this).attr("allc");// 状态
				});
				var isfirst=false;
				isfirst=ibmoney==''?true:false;
				
				var title = '';
     			title +=isfirst?'定制':'修改';
				title += ' '+ower +'  '+ lotyname +'的自动跟单  '  ;
				
				$(".tips_title h2").html(title);
				if (isfirst){
					$("#btnAuto").val('首次定制');
					$("#history").hide();
				}else{
					$("#btnAuto").val('修改定制');
					$("#history").show();
				}
				
				var html='';
				html = '发起人：<span class="red">' + ower + '</span>&nbsp; &nbsp; 彩种 <span class="red">' + lotyname + '</span> <br/> ';
				html += '  定制总人数：<span class="red">' + allc + '</span>人 跟单总金额：<span class="red">' + allm + '</span>元  ';
				$("#title_m").html(html);
				
				$("#anum").html(inums);
				$("#amoney").html(itmoney);
				
				$("#bmoney").val(ibmoney);
				$("#minm").val(iminmoney);
				$("#maxm").val(imaxmoney);
				
				$("input[name=ra][value=" + ilimit + "]").attr("checked",true);
				if (ilimit==1){
					$("#settxt").show();
				}else{
					$("#settxt").hide();
				}

				if(play_id=="new"){
					$("#tclose").bind({
						click:function(){
							window.close();
						}
					});
				}
			} else {
				alert(desc);
				if (history.length == 0) {
					window.opener = '';
					window.location="/";
				} else {
					history.go(-1);
				}
			}
		},
		error : function() {
			alert("您所请求的页面有异常！");
			return false;
		}
	});
	
	
	
	$("#btnAuto").bind({
		click : function() {
			var data = {
				id:auto_id,
				lotyid:lotyid,
				play_id:play_id,
				lastname:ower,
				fid:fid,
				min:$("#minm").val(),
				max:$("#maxm").val(),
				money:$("#bmoney").val(),
				limit:$("#ra0").attr("checked")?0:1
			};
			
			$.ajax({
				url : '/user_auto_order/do_auto_order/',
				type : "POST",
				dataType : "xml",
				data : data,
				success : function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");

					if (code == "0") {
						alert(desc);
						parent.Y.closeUrl();
					} else {
						alert(desc);
						parent.Y.closeUrl();
						/*if (history.length == 0) {
							window.opener = '';
							window.close();
						} else {
							history.go(-1);
						}*/
					}
				},
				error : function() {
					alert("您所请求的页面有异常！");
					return false;
				}
			});
		}
	});
});