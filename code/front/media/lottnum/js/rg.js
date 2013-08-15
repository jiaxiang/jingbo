function getrglist(uri){
	$.ajax({
	    url: uri,
	    type: 'GET',
	    dataType: 'json',
	    timeout: 5000,
	    error: function(){
	        alert('请求数据出错！');
	    },
	    success: function(data){
	        // do something with xml
	    	alert(data.stat);
	    }
	});
}


window.init = function(){
	Y.get("#submitCaseBtn3").click(checkForm);
	fw_getUserInfo.init(1);
    //tab change 
	window.reload = function(){
		fw_getUserInfo.pagePos=1;
		Y.one("#meyBuy").className=Y.one("#joinCount").className='';
		this.className="an_cur";
		fw_getUserInfo.url="/lotteryapi/orderprocess/getrg/my";
		if(this.id=="joinCount"){
			fw_getUserInfo.url="/lotteryapi/orderprocess/getrg/all";
		}
		fw_getUserInfo.getDate();
	}

	Y.one("#meyBuy").onclick=Y.one("#joinCount").onclick=reload;
	$("#yhhmxy").click(function(){
		openDiv($("#xydiv"));
	});
	$("#closeXy2").bind("click",closeXyDiv);
	$("#closeXy1").bind("click",closeXyDiv);
	//reload.call(Y.one("#meyBuy"));
}

rreload = function(){
	
}


//打开格式窗口
var openDiv = function(div_){
	var height = parseInt((div_).css("height"))/2;
	var x=$(window).width()/2;
	var sleft=$("body").scrollLeft();
	var width = $("#info_dlg").width()/2;
	var left=x-width+sleft+"px";
	var scrollTop = $(document).scrollTop();
	div_.css("top",scrollTop+140).css("left",left)
		.draggable(".move").show();
	showBgdiv();
}

//显示背景色
var showBgdiv = function(){
     var set = document.getElementById("bgdiv");
	 //var height = window.screen.availHeight;
	 var height = document.body.scrollHeight;
     set.style.cssText="display:block;width:100%; height:"+height+"px; background:#666666; filter: Alpha(Opacity=20); -moz-opacity:0.2; opacity: 0.2; position:absolute;top:0; z-index:99999; left:0;";     
}
//隐藏背景色
var hideBgdiv = function(){
	$("#bgdiv").hide();
}

var closeXyDiv = function(){
	$("#xydiv").hide();
	hideBgdiv();
}


checkForm = function(){
	function comfirmxieyi(){
		Y.one('#agreement').checked = true;
		Y.one('#agreement2').checked = true;
		Y.postMsg('msg_login', function (){	
			var buynum = Y.one('#buynum').value;      //方案金额
			var onemoney = Y.one('#onemoney').value;  //每份金额
			var totalbuymoney = buynum * onemoney;    //认购总金额
			var pid = Y.one('#pid').value;    //认购总金额
			var lotid = Y.one('#lotid').value;    //认购总金额
			var playid = Y.one('#playid').value;    //认购总金额		
			Y.one('#permoney').innerHTML = totalbuymoney.toFixed(2);
			if(buynum == ''){
				Y.alert('您好，认购份数不能为空！')
				return false
			}
			if(buynum <= 0 || Y.getInt(buynum) != buynum){
				Y.alert('您好，认购份数必须为大于等于1的整数！')
				return false
			}
			if(Y.getInt(buynum) > Y.one('#senumber').value){
				Y.alert('您好，认购份数不能大于剩余份数！')
				return false
			}
			var totalmoney = buynum * onemoney;
		    function regou(){
				var url = submit_url+"?pid="+pid+"&rnum="+buynum;
				Y.alert('您好， 正在提交您的请求，请稍等...', false, true);
				Y.postMsg('msg_login', function (){	
			        Y.ajax(
			        {
			            url: url,
			            type:'GET',
			            end:function(data)
			            {
			                var json;
			                Y.alert.close();
			                	if(!data.error)
				                {
									//log(data);
				                    if(json = Y.dejson(data.text))
				                    {
				                       if(json.stat==200){										
				                    	   Y.alert("认购成功！");
				                    	   setTimeout( function()
				    	              	           {
				    	              	               location.reload();
				    	              	           }, 3000);
				                       }else{
				                       	   if(json.info == '余额不足'){
											 return Y.addMoney()
				                       	   }
				                           Y.alert(json.info); 
				                       }
				              }    
			                }else{
								//alert('认购失败');
			                	Y.alert(data.info);
								//跑到这一步一定是程序出错了
			                }
			            }
			        });        
				});
			}
		    Y.confirm("您好，本次认购份数为"+buynum+"份，总金额为"+totalbuymoney+"元，请确认！",regou,''); 
		});
	}
	if(!Y.one('#agreement').checked || (!Y.one('#agreement2').checked && Y.one('#agreement2').value!=true)){
		var lotid = Y.one('#lotid').value;    //认购总金额
		var error = "您是否同意《用户合买代购协议》？";
		if(lotid == 5 ){
			error = "您是否同意《用户合买代购协议》和《排列三投注风险须协议》？";
		}
		if(lotid == 7 ){
			error = "您是否同意《用户合买代购协议》和《福彩3D投注风险须协议》？";
		}
		Y.confirm(error,comfirmxieyi,''); 
	}else{
		comfirmxieyi();
	}
}

fw_getUserInfo={
	    uid:"",
		url:false,
		lotid:-1,
		//playid:-1,
		pid:-1,
		expect:-1,
		withbak:0,
		pageSize:"auto",
		pagePos:1,
		pageCount:-1,
		recordCount:0,
		isFirst:true,
		getDate:function(isToal){
			var total="";
			if(isToal){total="&psize="+this.pageSize;};	
			var param = "uid="+this.uid+"&pid="+this.pid+"&lottid="+this.lotid+"&p="+this.pagePos+total;
			Y.ajax(
	        {
	            url:this.url+"?"+param,
	            type:'GET',
	            end:function(data)
	            {
	                var list=Y.dejson(data.text);
					Y.one("#totalCount").innerHTML=list.enablerows;
					if(!list.data){
						if(Y.one("#meyBuy").className=="an_cur"){
						    Y.one("#show_list_div").innerHTML="<div style='padding-top:10px;'>暂时没有您的认购信息</div>";
						}else{
						    Y.one("#show_list_div").innerHTML="<div style='padding-top:10px;'>暂时没有相关数据...</div>";
						}
						return false ;
					};
					
					var tbody=[];
					fw_getUserInfo.pageCount=list.pagecount;
					fw_getUserInfo.recordCount=list.totalrows;
					
					var isjprizesuc=0;
					isjprizesuc = Y.one("#isjprizesuc")?Y.one("#isjprizesuc").value:0;
					if(Y.one("#isend").value == 1 && Y.one("#pregetmoney").value>0)
					{
						tbody.push("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hm_tb_t\">\ <tr>\<th class=\"hm_name\">用户名</th><th class=\"text_r\">认购份数（<span class=\"red\">"+list.buymumber+"份</span>）</th> <th class=\"text_r\">认购金额（<span class=\"red\">"+list.buymoney+"元</span>）</th><th class=\"text_r\">奖金</th> <th>购买时间</th></tr>");
					}
					else
					{
						if(Y.one("#meyBuy").className=="")
						{
							//tbody.push("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hm_tb_t\">\ <tr>\<th class=\"hm_name\">用户名</th><th class=\"text_r\">认购份数（<span class=\"red\">"+list.buymumber+"份</span>）</th> <th class=\"text_r\"><a href=\"javascript:void(0)\" onclick=\"user_order(1);\">认购金额（<span class=\"red\">"+list.buymoney+"元</span>）</a><span id=\"ico_1\" class=\""+getClass(1)+"\"/></th><th> <a href=\"javascript:void(0)\" onclick=\"user_order(2);\">购买时间</a><span id=\"ico_2\" class=\""+getClass(2)+"\"/></th></tr>");
						    tbody.push("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hm_tb_t\">\ <tr>\<th class=\"hm_name\">用户名</th><th class=\"text_r\">认购份数（<span class=\"red\">"+list.buymumber+"份</span>）</th> <th class=\"text_r\"><a href=\"javascript:void(0)\" onclick=\"user_order(1);\">认购金额（<span class=\"red\">"+list.buymoney+"元</span>）</a><span id=\"ico_1\" class=\""+getClass(1)+"\"/></th><th> <a href=\"javascript:void(0)\" onclick=\"user_order(2);\">购买时间</a><span id=\"ico_2\" class=\""+getClass(2)+"\"/></th><th>操作</th></tr>");
						}
						else
						{
							//tbody.push("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hm_tb_t\">\ <tr>\<th class=\"hm_name\">用户名</th><th class=\"text_r\">认购份数（<span class=\"red\">"+list.buymumber+"份</span>）</th> <th class=\"text_r\">认购金额（<span class=\"red\">"+list.buymoney+"元</span>）</th><th> 购买时间</th></tr>");
							tbody.push("<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"hm_tb_t\">\ <tr>\<th class=\"hm_name\">用户名</th><th class=\"text_r\">认购份数（<span class=\"red\">"+list.buymumber+"份</span>）</th> <th class=\"text_r\">认购金额（<span class=\"red\">"+list.buymoney+"元</span>）</th><th> 购买时间</th><th>操作</th></tr>");
						}
					}
					var anumber=Y.one("#anumber").value;
					for(var i=0,L=list.data.length;i<L;i++)
					{
						var rgper = parseInt(list.data[i].getnum/anumber*10000)/100;
						var rgperstr='';
						if(rgper>=0.01)
						{
							rgperstr="（"+rgper+"%）";
						}
						tbody.push("<tr "+list.data[i].trclass+">");
						tbody.push("<td class=\"hm_name\"><span class=\"eng record\" "+list.data[i].wordclass+">"+list.data[i].username+"</span></td>");
						tbody.push("<td class=\"text_r\"><span class=\"eng\" "+list.data[i].wordclass+">"+list.data[i].getnum+"</span></td>");
						tbody.push("<td class=\"text_r\"><span class=\"eng\" "+list.data[i].wordclass+">"+list.data[i].paymoney+" 元"+rgperstr+"</span></td>");
						
						if(Y.one("#isend").value==1 && Y.one("#pregetmoney").value>0)
						{
						//if((Y.one("#isend").value==1 || isjprizesuc==1) && Y.one("#pregetmoney").value>0){    
							tbody.push("<td class=\"text_r\"><span class=\"eng\" "+list.data[i].wordclass+">"+list.data[i].getmoney+"</span></td>");
							tbody.push("<td class=\"text_r\"><span class=\"eng\" "+list.data[i].wordclass+">"+list.data[i].addtime+"</span></td>");
						}
						else
						{
							tbody.push("<td><span class=\"eng\" "+list.data[i].wordclass+">"+list.data[i].addtime+"</span></td>");
							tbody.push("<td "+list.data[i].wordclass+">"+list.data[i].userreturn+"</td>");
						}

					};
					tbody.push("</table>");
					var pageBar='';
					if("auto"!=fw_getUserInfo.pageSize)
					{
						pageBar="<div style=\"padding:15px;padding-bottom:5px;text-align:right\"><a href=\"javascript:void 0;\" onclick=\"fw_getUserInfo.turnPage()\">分页查看</a></div>"
					}
					else
					{
						pageBar="<div style=\"padding:15px;padding-bottom:5px;text-align:right\">记录"+list.totalrows+"条　共"+list.pagecount+"页  第"+fw_getUserInfo.pagePos+"页 <a href=\"javascript:void 0;\" onclick=\"fw_getUserInfo.first()\">首页</a>　<a href=\"javascript:void 0;\" onclick=\"fw_getUserInfo.prev()\">上一页</a>　<a href=\"javascript:void 0;\" onclick=\"fw_getUserInfo.next()\">下一页</a>　<a href=\"javascript:void 0;\" onclick=\"fw_getUserInfo.last()\">尾页</a>";
						if(list.totalrows <500)
						{
							pageBar +="　<a href=\"javascript:void 0;\" onclick=\"fw_getUserInfo.showAll()\">查看全部</a></div>";
						}
					};
					tbody.push(pageBar);
					Y.one("#show_list_div").innerHTML=tbody.join("");
	            }
	        });
	        Y.get('#buynum').keyup(function(){
			    var buynum = Y.one('#buynum').value;      //方案金额
				var onemoney = Y.one('#onemoney').value;  //每份金额
				var totalbuymoney = buynum * onemoney;    //认购总金额
				Y.one('#permoney').innerHTML = totalbuymoney.toFixed(2);
			});
		},
		next:function(){
			this.pagePos++;
			this.pagePos>this.pageCount&&(this.pagePos=this.pageCount);
			this.getDate();
		},
		prev:function(){
			this.pagePos--;
			this.pagePos<1&&(this.pagePos=1);
			this.getDate();
		},
		first:function(){
			this.pagePos=1;
			this.getDate();
		},
		last:function(){
			this.pagePos=this.pageCount;
			this.getDate();
		},
		showAll:function(){
			this.pageSize=this.recordCount;
			this.getDate(true);
		},
		turnPage:function(){
			this.pageSize="auto";
			this.getDate();
		},
		init:function(pos){
		    this.uid=Y.one("#main_uid").value;
			!this.url&&(this.url= "/lotteryapi/orderprocess/getrg/my");
			this.pid=Y.one("#pid").value;
			this.lotid=Y.one("#lotid").value;
			this.expect=Y.one("#expect").value;
			this.pagePos=pos||1;
			this.getDate();
		}
	};

getClass = function(id){
	var orderid = Y.one('#orderstr').value;
	var orderby = Y.one('#orderby').value;
	if(id==orderid){
		if(orderby=="desc"){
			return "des_time";
		}else{
			return "asc_time";
		}
	}else{
		return "des_pub";		
	}
}

user_order = function(orderid){
	Y.one('#orderstr').value = orderid;
	if(Y.one('#orderby').value == "desc"){
		Y.one('#orderby').value = "asc";
	}else{
		Y.one('#orderby').value = "desc";
	}
	//fw_getUserInfo.url=baseUrl + join_user_forder + "join_users/all";
	if("auto"!=fw_getUserInfo.pageSize){
		fw_getUserInfo.showAll();
	}else{
		fw_getUserInfo.getDate();
	}
}

main_return_confirm = function (){
	Y.postMsg('msg_login', function (){	
		var pid = Y.one('#pid').value;    //方案编号
		//var lotid = Y.one('#lotid').value;    //彩种编号
	    function main_return(){
			var url = "/lotteryapi/orderprocess/cancelplan?pid="+pid;
			Y.alert('您好， 正在提交您的请求，请稍等...', false, true);	
	        Y.ajax(
	        {
	            url: url,
	            type:'GET',
	            end:function(data)
	            {
	                var json;
	                if(!data.error)
	                {
	                    if(json = Y.dejson(data.text))
	                    { 
	                       if(json.stat==200){
	              	           //重新初始化刷新UI
	              	           Y.alert(json.info);
	              	           setTimeout( function()
	              	           {
	              	               location.reload();
	              	           }, 3000);
	                       }else{	
	                           Y.alert(json.info); 
	                       }
	                    }    
	                }else{
	                	Y.alert('您好，撤单失败,请重新操作！');
	                }
	            }
	        });        
		}
		Y.postMsg('msg_login', function (){	
	        Y.confirm("您好，您确定要撤单吗？",main_return,'');  
		});
	});   
}

user_return_confirm=function(id,_this){
	Y.postMsg('msg_login', function (){	
		var lotid = Y.one('#lotid').value;    //认购总金额
		//var playid = Y.one('#playid').value;    //认购总金额
	    function main_return(){
			var url = "/lotteryapi/orderprocess/cancelorder?lotid="+lotid+"&gid="+id;
			Y.alert('您好， 正在提交您的请求，请稍等...', false, true);	
	        Y.ajax(
	        {
	            url: url,
	            type:'GET',
	            end:function(data)
	            {
	                var json;
	                if(!data.error)
	                {
	                    if(json = Y.dejson(data.text))
	                    { 
	                       if(json.stat == 200){
	                          //重新初始化刷新UI
	                           Y.alert(json.info);
	                           reloadrglist();
	                       }else{
	                           Y.alert(json.info);
	                       }
	                    }    
	                }else{
	                	Y.alert('您好，撤单失败,请重新操作！');
	                }
	            }
	        });        
		}
		Y.postMsg('msg_login', function (){	
	        Y.confirm("您好，确定对您的认购方案撤单吗？",main_return,'');  
		});    
	});
};

reloadrglist = function(){
	//重新初始化刷新UI
	Y.one("#meyBuy").className="an_cur";
	fw_getUserInfo.url= "/lotteryapi/orderprocess/getrg/my";
	fw_getUserInfo.init(1);
}

showMoreDiv = function (num){
	objname = "#more_code"+num;
	objname2 = "#more_str"+num;
	if(Y.one(objname).style.display=='none'){
		Y.one(objname2).innerHTML = "隐藏";
		Y.one(objname).style.display = 'block';
	}
	else
	{
		Y.one(objname2).innerHTML = "更多";
		Y.one(objname).style.display = 'none';
	}
}

uploadorder = function (){
	Y.postMsg('msg_login', function (){	
		Y.alert('您好， 正在提交您的请求，请稍等...');	
	     Y.one("#suc_form").submit();
	});   
}
