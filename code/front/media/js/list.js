    var sel = Y.one("#playid_term").options;
   	var selstr = "";
    var lotstr = ',1,15,17,10000,';
   	for(var i=0;i<sel.length;i++){
   		var opstr = sel[i].value+'|'+ sel[i].text;
   		selstr = selstr + ',' + opstr;
   	}
   	selstr = selstr.substring(1,selstr.length);
   	Y.one("#selval").value = selstr;    
    /**
     * AJAX方式载入列表内容
     */
    var lotid = Y.one("#lotid").value;
    Y.use('mask',function(){
    	Y.loading = Y.lib.MaskLay();
    	Y.loading.noMask = true;
    	var dlg_buy_end = Y.lib.MaskLay('#dlg_buysuc', '#dlg_buysuc_content');
    	dlg_buy_end.addClose('#dlg_buysuc_back','#dlg_buysuc_close','#dlg_buysuc_close2');
    	Y.extend('popBuyOk', function(user){
    		dlg_buy_end.pop('您好，'+user+'，恭喜您购买成功!')
    	})
    	Y.get('#cFfilter div.tips_title').drag('#cFfilter');
		loadDataByUrl(url);
    })
    Class.C('url-addmoney', baseUrl+'/useraccount/default.php?url='+Class.C('url-passport')+'/useraccount/addmoney/add.php');
	Y.use('mask', function(){
		var addMoneyDlg =  this.lib.MaskLay('#addMoneyLay');
		addMoneyDlg.addClose('#addMoneyClose a','#addMoneyNo','#addMoneyYes');
		Y.get('#addMoneyLay div.tips_title').drag('#addMoneyLay');
		Y.extend('addMoney', function(){
			addMoneyDlg.pop('', function(e, btn){
				if(btn.id === 'addMoneyYes'){
					window.open(Class.C('url-addmoney'))
				}			
			})
		})
	}) 
	Y.ready(function(){
		Y.get('#list_data').live('a[data-help]','mouseover',function(){
			Y.getTip().show(this, this.getAttribute('data-help')); 
		}).live('a[data-help]','mouseout',function(){
			Y.getTip().hide()
		})
	});   
    function loadDataByUrl(url){
    	if(Yobj.C('loading')){
    		return
    	}
    	Yobj.C('loading', true);
        var list_table = Y.one('#list_data');
        var stype = Y.one('#stype').value
        var rand = new Date;
        url = setUrlParam(url,'rand',rand);
        url = setUrlParam(url,'ttype',Y.one("#ttype").value);
        Y.loading && Y.loading.pop('<img alt="正在加载..." src="'+imgurl+'/loading.gif">')
        Y.ajax(
        {
            url:url,
            type:'GET',
            end:function(data)
            {
                var json;
                var currentkey = Y.one("#currentkey").value;
                var currentsort = Y.one("#currentsort").value;
                if(stype==1)currentkey = currentkey!=''?currentkey:'renqi';
                if(stype==2)currentkey = currentkey!=''?currentkey:'zhanji';
                if(stype==3)currentkey = currentkey!=''?currentkey:'prize';
                var fananstr = (lotid==9 || lotid==46 || lotid==47)?'过关方式':'方案内容';
                var classstr = currentsort=='DESC'?'des_time':'asc_time';
                var zhanji = currentkey=="zhanji"?classstr:'asc_pub';
                var prize = currentkey=="prize"?classstr:'asc_pub';
                var getmoney = currentkey=="getmoney"?classstr:'asc_pub';               
                var allmoney = currentkey=="allmoney"?classstr:'asc_pub';
                var onemoney = currentkey=="onemoney"?classstr:'asc_pub';
                var renqi = currentkey=="renqi"?classstr:'asc_pub';
                var snumber = currentkey=="snumber"?classstr:'asc_pub';
				var beishu = currentkey=="beishu"?classstr:'asc_pub';
                var getstr = '操作';
                var isallow = 0;
                var colgroup = '';
                var periodSelection = Y.get("#periodSelection");
				if(periodSelection.size() && periodSelection.one().options[periodSelection.one().selectedIndex].text.indexOf('期') == -1 && periodSelection.one().options[periodSelection.one().selectedIndex].text != periodSelection.one().options[0].text){//当前,预售	
					getstr = "<th><a href=\"javascript:do_order('getmoney')\" title=\"\">奖金</a><span class=\""+getmoney+"\"></span></a></th>";
					$tdnum = (stype==3)?9:8;
                }else{
                	isallow = 1;
                	$tdnum = (stype==3)?11:10;
                	getstr = "<th><a href=\"javascript:do_order('snumber')\" title=\"\">剩余份数<span class=\""+snumber+"\"></span></a></th><th>认购份数</th><th>操作</th>";	
                }
                if(stype==3){
                	colgroup = "<colgroup><col width=\"4%\" /><col/><col width=\"10%\"/><col/><col width=\"10%\" /><col width=\"10%\" /><col width=\"10%\"/><col width=\"13%\"/><col width=\"8%\" /><col width=\"7%\" /><col width=\"11%\" /></colgroup>";
                	if(!isallow){
                		colgroup = "<colgroup><col width=\"4%\" /><col/><col width=\"10%\"/><col/><col width=\"10%\" /><col width=\"10%\" /><col width=\"12%\"/><col width=\"13%\"/><col width=\"14%\" /></colgroup>";
                	}
                    var outhtml = "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"rec_table\">"+colgroup+"<tbody><tr class=\"\" id=\"lbtitle\"><th>排序</th><th class=\"th_name\">发起人</th><th class=\"fa_money\"><a href=\"javascript:do_order('prize')\" title=\"\">近期中奖<span class=\""+prize+"\"></span></a></th><th class=\"fa_money\"><a href=\"javascript:do_order('allmoney')\" title=\"\">方案金额<span class=\""+allmoney+"\"></span></a></th><th class=\"fa_money\"><a href=\"javascript:do_order('onemoney')\" title=\"\">每份金额<span class=\""+onemoney+"\"></span></a></th><th>方案内容</th><th><a href=\"javascript:do_order('renqi')\" title=\"\">进度<span class=\""+renqi+"\"></span></a></th>"+getstr+"</tr>";
		    	}else{
		    		colgroup = "<colgroup><col width=\"5%\" /><col width=\"18%\" /><col width=\"11%\" /><col width=\"10%\" /><col width=\"10%\" /><col width=\"14%\" /><col width=\"10%\" /><col width=\"10%\" /><col width=\"12%\" /></colgroup>";
                	if(!isallow){
                		colgroup = "<colgroup><col width=\"5%\" /><col width=\"15%\" /><col width=\"10%\" /><col width=\"11%\" /><col width=\"20%\" /><col width=\"18%\" /><col width=\"21%\" /></colgroup>";
                	}
		    		var outhtml = "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"rec_table\">"+colgroup+"<tbody><tr class=\"\" id=\"lbtitle\"><th>排序</th> <th class=\"th_name\" >发起人</th><th class=\"fa_money\"><a href=\"javascript:do_order('allmoney')\" title=\"\">方案金额<span class=\""+allmoney+"\"></span></a></th><th class=\"fa_money\"><a href=\"javascript:do_order('onemoney')\" title=\"\">每份金额<span class=\""+onemoney+"\"></span></a></th><th>方案内容</th><th><a href=\"javascript:do_order('renqi')\" title=\"\">进度<span class=\""+renqi+"\"></span></a></th>"+getstr+"</tr>";
		    	}
                var temphtml = '';
                if(!data.error)
                {
                    if(json = Y.dejson(data.text))
                    {
                        var oList = json.list_data;
                        if(Y.isArray(oList))
                        {
                            if (typeof oList == 'object')
                            {
                                
                                oList.each(function(item, i){
                                	var trclass = "";
                                	if(eval('oList[' + i + '].column0')>=1){
                                		trclass = "th_top";
                                	}else{	
	                                	if(i%2 == 1){
	                                		trclass = "th_even";
	                                	}
                                	}
                                    temphtml += "<tr class=\""+trclass+"\" vclass=\""+trclass+"\" onmouseover='mouse_over(this)' onmouseout='mouse_out(this)'>";
                                    for (var j = 1; j <= 11; j++)
                                    {
                                        var classstr = 'eng';
                                        if(stype==3){
	                                        if(j==2)classstr = 'th_name';
	                                        if(j==4){
	                                        	if(lotid==5 || lotid==7){
	                                        		classstr = 'eng gold-cup';
	                                        	}else{
	                                        		classstr = 'eng record';
	                                        	}
	                                        }
	                                        if(j==3 || j==5 || j==6)classstr = 'eng fa_money';
	                                        if($tdnum != 9 && j==9)classstr = 'eng fa_money';
                                        }else{
                                        	if(j==2)classstr = 'th_name';
                                        	if(j==3){
                                        		if(lotid==5 || lotid==7){
		                                    		classstr = 'eng gold-cup';
		                                    	}else{
		                                    		classstr = 'eng record';
		                                    	}
	                                        }
                                        	if(j==4 || j==5)classstr = 'eng fa_money';
                                        	if($tdnum != 8 && j==8)classstr = 'eng fa_money';
                                        }
                                        if(eval('oList[' + i + '].column' + j)){
										    temphtml += "<td class=\""+classstr+"\">"+eval('oList[' + i + '].column' + j)+"</td>";
                                        }
                                    }
                                })
                                temphtml += "</tr>";
                            }
                        }
                    }
                }
                if(temphtml){
		            outhtml = outhtml+temphtml+"</tbody></table> ";
		            Y.one('#page_wrapper').innerHTML = json.page_html;
                }else{
                	temphtml = "<tr class=\"\"><td colspan=\""+$tdnum+"\">抱歉！没有找到符合条件的结果！</td></tr>";
                	outhtml = outhtml+temphtml+"</tbody></table> ";
                    Y.one('#page_wrapper').innerHTML = '';
                }
		        list_table.innerHTML = outhtml; 
		        Yobj.C('loading', false);  
		        Y.loading && Y.loading.close()
            }
        });
    }
    
    /**
     * 列表排序
     */
    getsvalue = function(){
	    Y.get('#cFfilterin li a.c-f-on').each(function(a){
	        var xname = Y.get(a).parent('li').attr('ref');
	        searchstr[xname] = a.getAttribute('data-val')    		
	    });
    }
    getxinsvalue = function(){
    	searchstr['xin1_s']='';searchstr['xin2_s']='';searchstr['xin3_s']='';searchstr['xin4_s']='';
    	searchstr['xin5_s']='';searchstr['xin6_s']='';searchstr['xin7_s']='';searchstr['xin8_s']='';
    	searchstr['xin9_s']='';searchstr['xin10_s']='';searchstr['xin11_s']='';searchstr['xin12_s']='';
    	searchstr['xin13_s']='';searchstr['xin14_s']='';
    	if(lotid==3 || lotid==28){
	    	var classstr_r = document.getElementById('cFfilterxin').getElementsByTagName('ul')[0].getAttribute('codeclass');
	    	var classstr_b = document.getElementById('cFfilterxin').getElementsByTagName('ul')[1].getAttribute('codeclass');
		    Y.get('#cFfilterxin li b.'+classstr_r).each(function(a){
		        var xname = a.parentNode.getAttribute('ref');
		        if(a.getAttribute('data-val')!=-1){
		        	searchstr[xname] = searchstr[xname]?searchstr[xname]+","+a.getAttribute('data-val') :a.getAttribute('data-val')
		        }  	
		    });
		    Y.get('#cFfilterxin li b.'+classstr_b).each(function(a){
		        var xname = a.parentNode.getAttribute('ref');
		        if(a.getAttribute('data-val')!=-1){
		        	searchstr[xname] = searchstr[xname]?searchstr[xname]+","+a.getAttribute('data-val') :a.getAttribute('data-val')
		        }  	
		    });
    	}else{
    		if(lotid!=9 && lotid!=46 && lotid!=47){
	    		var classstr = document.getElementById('cFfilterxin').getElementsByTagName('ul')[0].getAttribute('codeclass');
			    Y.get('#cFfilterxin li b.'+classstr).each(function(a){
			        var xname = a.parentNode.getAttribute('ref');
			        if(a.getAttribute('data-val')!=-1){
			        	searchstr[xname] = searchstr[xname]?searchstr[xname]+","+a.getAttribute('data-val') :a.getAttribute('data-val')
			        }  	
			    });
    		}   
    	}
        var findxs = '';
        switch(lotid){
        	case '5':
            case '7':
                if(searchstr['xin2_s']!='' || searchstr['xin3_s']!='' || searchstr['xin4_s']!=''){
                	findxs = searchstr['xin2_s']+"|"+searchstr['xin3_s']+"|"+searchstr['xin4_s'];
                }
                if(searchstr['xin1_s']!=-1 && searchstr['xin1_s']!=''){
                	findxs = searchstr['xin1_s'];
                }
                break;
            case '10001':  
                if(searchstr['xin1_s']!='' || searchstr['xin2_s']!='' || searchstr['xin3_s']!='' || searchstr['xin4_s']!='' || searchstr['xin5_s']!=''){
                	findxs = searchstr['xin1_s']+"|"+searchstr['xin2_s']+"|"+searchstr['xin3_s']+"|"+searchstr['xin4_s']+"|"+searchstr['xin5_s'];
                }
                break;
             case '4':  
                if(searchstr['xin1_s']!='' || searchstr['xin2_s']!='' || searchstr['xin3_s']!='' || searchstr['xin4_s']!='' || searchstr['xin5_s']!='' || searchstr['xin6_s']!='' || searchstr['xin7_s']!=''){
                	findxs = searchstr['xin1_s']+"|"+searchstr['xin2_s']+"|"+searchstr['xin3_s']+"|"+searchstr['xin4_s']+"|"+searchstr['xin5_s']+"|"+searchstr['xin6_s']+"|"+searchstr['xin7_s'];
                }
                break;    
            case '3':
            case '28':
                var findxs_r = '';
                var findxs_b = '';
                if(searchstr['xin1_s']!='' || searchstr['xin2_s']!='' || searchstr['xin3_s']!=''){

                	findxs_r = searchstr['xin1_s']?searchstr['xin1_s']:'';
                	findxs_r = findxs_r?searchstr['xin2_s']?findxs_r+","+searchstr['xin2_s']:findxs_r:searchstr['xin2_s'];
                	findxs_r = findxs_r?searchstr['xin3_s']?findxs_r+","+searchstr['xin3_s']:findxs_r:searchstr['xin3_s'];
                }
                
                if(searchstr['xin4_s']!='' || searchstr['xin5_s']!='' || searchstr['xin6_s']!=''){
                	findxs_b = searchstr['xin4_s']?searchstr['xin4_s']:'';
                	findxs_b = findxs_b?searchstr['xin5_s']?findxs_b+","+searchstr['xin5_s']:findxs_b:searchstr['xin5_s'];
                	findxs_b = findxs_b?searchstr['xin6_s']?findxs_b+","+searchstr['xin6_s']:findxs_b:searchstr['xin6_s'];
                }
                if(findxs_r!='' || findxs_b!='')findxs =findxs_r+"|"+findxs_b;
                break;
            case '8': 
            case '11':
                if(searchstr['xin1_s']!='' || searchstr['xin2_s']!=''){
                	findxs = searchstr['xin1_s']?searchstr['xin1_s']:'';
                	findxs = findxs?searchstr['xin2_s']?findxs+","+searchstr['xin2_s']:findxs:searchstr['xin2_s'];
                }
                break;
            case '1':
            case '15':
            case '17':
            case '10000':
                var nums = '';
                var nullnum = 0;
                var jmax = 14;
                var findxs_d = '';
              	var findxs_t = '';
                if(lotid==15)jmax=12;
                if(lotid==17)jmax=8;
                getsvalue();
                var playid = searchstr['playid_s'];
                for(var j=1;j<=jmax;j++){
              	    nums = 'xin'+j+'_s';
              	    searchstr[nums] = searchstr[nums].replace(/,/g,"");
              	    searchstr[nums]==''?nullnum++:'';
              	    if(lotid==10000 && playid==123){
              	    	if(searchstr[nums].indexOf('4')!=-1){
              	    	    if(findxs_d==''){
              	    	        findxs_d = searchstr[nums].replace(/4/g,"")?searchstr[nums].replace(/4/g,""):'*';
              	    	    }else{
              	    	    	findxs_d = searchstr[nums].replace(/4/g,"")==''?findxs_d+',*':findxs_d+','+searchstr[nums].replace(/4/g,"");
              	    	    }
              	    	    findxs_t = findxs_t==''?'*':findxs_t+',*';
              	    	}else{  
              	    		findxs_d = findxs_d==''?'*':findxs_d+',*';
              	    	    if(findxs_t==''){
              	    	    	findxs_t = searchstr[nums].replace(/4/g,"")?searchstr[nums].replace(/4/g,""):'*';
              	    	    }else{
              	    	    	findxs_t = searchstr[nums].replace(/4/g,"")==''?findxs_t+',*':findxs_t+','+searchstr[nums].replace(/4/g,"");
              	    	    }
              	    	} 
              	    	findxs = '[D:'+findxs_d+'][T:'+findxs_t+']';
              	    }else{
              	    	searchstr[nums] = searchstr[nums].replace(/4/g,"");
              	    	searchstr[nums] = searchstr[nums]==''?'*':searchstr[nums];
              	        findxs = j==1?searchstr[nums]:findxs+","+ searchstr[nums];
              	    }
                }
                if(nullnum==jmax)findxs='';
        }
        searchstr['findxs'] = findxs;
    } 
    enter_search = function (event){
	   if(event.keyCode==13){
           do_search(1,Y.one('#findstr').value);
	   }
    }
    var searchstr = new Array();
    Y.get('#cFfilterin li').each(function(li,i){
    	Y.get('a', li).click(function(){
    		Y.get(this).parent('li').find('a').removeClass('c-f-on');
        	Y.get(this).addClass('c-f-on');
        	if(this.parentNode.getAttribute('ref')=='playid_s' || this.parentNode.parentNode.getAttribute('ref')=='playid_s' || this.parentNode.getAttribute('ref')=='playid_s2' || this.parentNode.parentNode.getAttribute('ref')=='playid_s2'){
        		if(lotid==3 || lotid==7 || lotid==5 ||lotid==28 ){
        			getsvalue();
        		}
        		var temp = (lotid==7) && (searchstr['playid_s']==2 || searchstr['playid_s']==3);
        		var temp1 = (lotid==28) && (searchstr['playid_s']==3);
        		var temp2 = (lotid==5) && (this.innerHTML=='组选三'||this.innerHTML=='组选六');
        		var temp3 = (lotid==7 || lotid==5) && searchstr['playid_s']==1 ;
				var temp4 = (this.innerHTML=='和值' || this.innerHTML=='单式' || this.innerHTML=='跨度' || this.innerHTML=='组合' || this.innerHTML=='生肖乐（12选2）') 
	    	    var temp5 = (lotid!=10000 && lotid!=3 && lotid!=28) && (this.innerHTML=='胆拖');
        		var temp6 = (lotid==10000) && (this.innerHTML=='胆拖');
        		var temp7 = (lotid==7 || lotid==5) && (searchstr['playid_s2']==2 || searchstr['playid_s2']==3 || searchstr['playid_s2']==4 || searchstr['playid_s2']==5 || searchstr['playid_s2']==6) || (lotid==28) && (searchstr['playid_s2']==2) ;
        		if(lotid==10000){
	        		clearAllxin()
	        		Y.one('#xinsui1').style.display='';
	        		Y.one('#xinsui2').style.display='none'
	        		if(temp6){
	        			Y.one('#xinsui1').style.display='none';
	        			Y.one('#xinsui2').style.display=''
	        			clearAllxin()
	        		}
        		}
        		if(lotid==7 || lotid==5){
	        		clearAllxin()
	        		Y.one('#xinsui1').style.display='';
	        		Y.one('#xinsui2').style.display='none'
	        		if(temp3){
	        			Y.one('#xinsui1').style.display='none';
	        			Y.one('#xinsui2').style.display=''
	        			clearAllxin()
	        		}
        		}
        		if(lotid==7 || lotid==28){
        			Y.get('#cFfilterin a[innerHTML=胆拖]').hide(temp);
        			Y.get('#cFfilterin a[innerHTML=胆拖]').hide(temp1);
        		}
        		Y.get('#cFfilterin a[innerHTML=组合]').hide(temp2)
        		if(temp)Y.get('#cFfilterin a[innerHTML=胆拖]').removeClass('c-f-on');
        		if(temp2)Y.get('#cFfilterin a[innerHTML=组合]').removeClass('c-f-on');
	    	    if(lotid==3){
	    	    	if(searchstr['playid_s']==135){
	    	    		Y.one('#rednote').innerHTML='选择红球胆码<em>（单次最多可选5个）</em>';
	    	    	}else{
	    	    		Y.one('#rednote').innerHTML='选择红球<em>(单次最多可选16个)</em>';
	    	    	}
	    	    }
	    	    if(lotid==28){
	    	    	if(searchstr['playid_s2']==3){
	    	    		Y.one('#rednote').innerHTML='选择前区胆码';
	    	    		Y.one('#bluenote').innerHTML='选择后区胆码';
	    	    	}else{
	    	    		Y.one('#rednote').innerHTML='选择前区号码';
	    	    		Y.one('#bluenote').innerHTML='选择后区号码';
	    	    	}
	    	    }
	    	    Y.one('#cFfilterxin').style.display='';
	    		clearAllxin()
	    	    if(temp4 || temp5 || temp1 || temp7){
	    			Y.one('#cFfilterxin').style.display='none';
	    			clearAllxin()
	    		}
    		}
            getsvalue()
        }); 
    })
    Y.get('#cFfilterxin li').each(function(li,i){
    	var findxs = '';
    	if(lotid==3 || lotid==28){
    		var rcodeclass = Y.one('#r_div').getAttribute('codeclass')
    		var bcodeclass = Y.one('#b_div').getAttribute('codeclass')
    	    var classstr = Y.one('#r_div').getAttribute('overclass');
     	    if(Y.get(li).parent('[id=b_div]').size()){
    	    	classstr = Y.one('#b_div').getAttribute('overclass')
    	    }
	        Y.get('b', li).mouseover(function(){
				Y.get(this).addClass(classstr);
	        }).mouseout(function(){
				Y.get(this).removeClass(classstr)
	        }).click(function(){
				Y.get(this).toggleClass(Y.get(this).parent('ul').attr('codeclass'))
				getxinsvalue();
	        	if(lotid==3){
	        		var red = searchstr['findxs'].split('|');
		        	var n=(red[0].split(',')).length;
	        		if(searchstr['playid_s'] != 135){
	                    if(n>16){
	                    	Y.get(this).removeClass(rcodeclass)
	                    	return Y.alert('您好，红球最多可选16个！');
	                    }
	        		}else{
	                    if(n>5){
	                    	Y.get(this).removeClass(rcodeclass)
	                    	return Y.alert('您好，红球胆码个数最多可选5个！');
	                    }
	        		}
	        	}				
	        	if(lotid==28){
	        		var red = searchstr['findxs'].split('|');
		        	var n=(red[0].split(',')).length;
	        		if(searchstr['playid_s2'] != 3){
	                    if(n>18){
	                    	Y.get(this).removeClass(rcodeclass)
	                    	return Y.alert('您好，前区号码最多可选18个！');
	                    }
	        		}else{
	                    if(n>4){
	                    	Y.get(this).removeClass(rcodeclass)
	                    	return Y.alert('您好，前区胆码最多可选4个！');
	                    }
	                    var n2=red[1]?(red[1].split(',')).length:0;
	                    if(n2>1){
	                    	Y.get(this).removeClass(bcodeclass)
	                    	return Y.alert('您好，后区胆码最多可选1个！');
	                    }
	        		}
	        	}
	        })
    	}else{
    		var classstr = document.getElementById('cFfilterxin').getElementsByTagName('ul')[0].getAttribute('overclass');
	        Y.get('b', li).mouseover(function(){
				Y.get(this).addClass(classstr);
	        }).mouseout(function(){
				Y.get(this).removeClass(classstr)
	        }).click(function(){
	        	if(lotid==10000){
	        		getxinsvalue();
        			if(this.innerHTML=='胆'){
        				var xx = this.parentNode.getAttribute('ref');
        			}
        			if(searchstr[xx]==''){
        				return Y.alert('您好，请先选择号码再定胆！');
        			}
        		}
				Y.get(this).toggleClass(this.parentNode.parentNode.getAttribute('codeclass'))
	        });
    	} 
    })
    Y.get('#detail_search').click(function(type){
    	if(Y.one('#cFfilter').style.display==""){
    	    Y.one('#cFfilter').style.display = "none";
    	    document.body.className="";
        }else{
        	Y.one('#cFfilter').style.display = "";
        	document.body.className="ie6hide";
        }
    });
    Y.get('#changesize a').click(function(){
    	var pagesize = 20;
    	Y.get('a', this.parentNode).removeClass('on');
    	Y.get(this).addClass('on');
    	Y.get('#changesize  a.on').each(function(a){
    		pagesize = a.getAttribute('s_val')    		
    	});
    	url = setUrlParam(url,'pagesize',pagesize);
    	loadDataByUrl(url);
    });
    
    function do_order(orderby) {
    	if(orderby=='')orderby='renqi';
    	var orderstr = "DESC";
        var rand = new Date;
        var currentkey = Y.one("#currentkey").value;
        var currentsort = Y.one("#currentsort").value; 
	    if(currentkey === orderby){
	        if(currentsort === 'DESC'){
	            orderstr = "ASC";
	        }else{
	            orderstr = "DESC";
	        }
	    }else{
	       Y.one("#currentkey").value = orderby;
	       orderstr = "DESC";
	    }
        Y.one("#currentsort").value = orderstr;  
        var b=new Array("orderby","orderstr","rand");
        b.each(function(item, i){
            url = setUrlParam(url,item,eval(item));
        });
		//alert(url);
        loadDataByUrl(url);
    }
    
    function do_search(type,findstr,point){
    	var titletype =0;
        switch(type){
            case 1:
                if(findstr == '请输入用户名'){
                    findstr = ' ';
                }
                Y.one("#findstr").value = findstr;
                url = setUrlParam(url,'findstr',encodeURIComponent(findstr));
                resetAll()
                clearAll(1)
                var movestr = new Array('playid_s','playid_s2','state_s','promoney_s','proplan_s','onemoney_s','baodi_s','tichen_s','findxs');
                movestr.each(function(item, i){
                    url = setUrlParam(url,item,'')
                });
                loadDataByUrl(url);
                break;
            case 2:
                clearAll(1);
                Y.one("#findstr").value = '请输入用户名';
                var playid_term = 0;
                var state_term = 1;
                var orderstr = 'renqi';
                if(findstr){
                    playid_term = findstr;
	                var periodSelection = Y.get("#periodSelection");
					if(periodSelection.size() && periodSelection.one().options[periodSelection.one().selectedIndex].text.indexOf('期') == -1 && periodSelection.one().options[periodSelection.one().selectedIndex].text != periodSelection.one().options[0].text){//当前,预售	
						state_term = 0;
						orderstr = 'getmoney';
					}
			        list = Y.get('#stype_t li');
			        list.each(function(item,i){
			        	item.className = (i+1==point)?"an_cur":'';
			        });
                    url = setUrlParam(url,'stype','1')
                    Y.one('#stype').value = 1;
                    resetAll(1);
                }else{
                	playid_term = Y.one("#playid_term").value;
                    state_term = Y.one("#state_term").value;
                }
                if(type==2){
                	if(point){
                	    var xinsui1 = Y.get('#xinsui1');
		                var xinsui2 = Y.get('#xinsui2');
            		    Y.get('#playid_term').one().options.length=0;
                		if(point==2){
                			Y.get('#playid_term').one().options[0]= new Option('单式',playid_term);
                			Y.get('#cFfilter li a').each(function(a){
                				if(a.parentNode.getAttribute('ref') == 'playid_s'){
                					a.style.display = (a.innerHTML=='单式' || a.innerHTML=='不限')?'':'none';
	            					Y.get('#bxspan').hide();
	            					Y.get(a).parent('li').find('a').removeClass('c-f-on');
	            					Y.get('#cFfilterin a[innerHTML=单式]').addClass('c-f-on');
	            					Y.one('#cFfilterxin').style.display='none';
	            					if(xinsui1.size())Y.one('#xinsui1').style.display='none';
				        			if(xinsui2.size())Y.one('#xinsui2').style.display='none'; 
                				}
                			})
                			titletype = 1;
                		}else if(point==3){
                			Y.get('#playid_term').one().options[0]= new Option('复式',playid_term);
                			Y.get('#cFfilter li a').each(function(a){
                				if(a.parentNode.getAttribute('ref') == 'playid_s'){
                					a.style.display = (a.innerHTML=='复式' || a.innerHTML=='不限')?'':'none';
	            					Y.get('#bxspan').hide();
	            					Y.get(a).parent('li').find('a').removeClass('c-f-on');
	            					Y.get('#cFfilterin a[innerHTML=复式]').addClass('c-f-on');
	            					Y.one('#cFfilterxin').style.display='';
	            					if(xinsui1.size())Y.one('#xinsui1').style.display='';
				        			if(xinsui2.size())Y.one('#xinsui2').style.display='none';
                				}
                			})
                			titletype = 2;
                		}else if(point==4){
                			Y.get('#playid_term').one().options[0]= new Option('胆拖',playid_term);
                			Y.get('#cFfilter li a').each(function(a){
                				if(a.parentNode.getAttribute('ref') == 'playid_s'){
                					a.style.display = (a.innerHTML=='胆拖' || a.innerHTML=='不限')?'':'none';
	            					Y.get('#bxspan').hide();
	            					Y.get(a).parent('li').find('a').removeClass('c-f-on');
	            					Y.get('#cFfilterin a[innerHTML=胆拖]').addClass('c-f-on');
	            					Y.one('#cFfilterxin').style.display='';
	            					if(xinsui1.size())Y.one('#xinsui1').style.display='none';
				        			if(xinsui2.size())Y.one('#xinsui2').style.display=''
				        			clearAllxin()
                				}
                			})
                			titletype = 3;
                		}
                	}
                	Y.one("#ttype").value = titletype;
                }                  
                var periodSelection = Y.get("#periodSelection");
                var expectstr = periodSelection.val().split( "|");
                var expect = expectstr[0];
                var b=new Array('playid_term','state_term','expect');
                var movestr = new Array('playid_s','playid_s2','state_s','promoney_s','proplan_s','onemoney_s','baodi_s','tichen_s','findstr','findxs');
                movestr.each(function(item, i){
                    url = setUrlParam(url,item,'')
                });
                b.each(function(item, i){
                    url = setUrlParam(url,item,eval(item));
                }); 
                url = setUrlParam(url,'orderstr','DESC');
                url = setUrlParam(url,'orderby',orderstr);
                state_term = state_term==-1?3:state_term;
                Y.get('#state_term').one().options[state_term].selected = true;	
				//log(url); //搜索url
                loadDataByUrl(url);
                break;
           case 3:
                Y.one("#findstr").value = '请输入用户名';
                resetAll()
                clearAll()
                var periodSelection = Y.get("#periodSelection");
                var currentkey ='renqi';
                var currentsort = 'DESC';
                var state_term = 1;
				if(periodSelection.size() && periodSelection.one().options[periodSelection.one().selectedIndex].text.indexOf('期') == -1 && periodSelection.one().options[periodSelection.one().selectedIndex].text != periodSelection.one().options[0].text){//当前,预售
					Y.get('#state_term').one().options[0].selected = true;	
					state_term = 0;
				    currentkey = 'getmoney';
				    currentsort = 'ASC';
				}else{
                    state_term = 1;
			        currentkey = 'renqi';
				    currentsort = 'ASC';
				}
				Y.one("#currentkey").value = currentkey;
				Y.one("#currentsort").value = currentsort;
				var expectstr = periodSelection.val().split( "|");
                var expect = expectstr[0];
                var b=new Array('playid_term','state_term','expect');
                var movestr = new Array('playid_s','playid_s2','state_s','promoney_s','proplan_s','onemoney_s','baodi_s','tichen_s','findstr','findxs');
                movestr.each(function(item, i){
                    url = setUrlParam(url,item,'')
                });
				url = setUrlParam(url,'expect',expect);
				url = setUrlParam(url,'state_term',state_term);
                do_order(currentkey);
                break;    
            case 4:
                Y.one('#cFfilter').style.display='none'
                Y.one("#findstr").value = '请输入用户名';
                var detailstr = new Array('playid_s','playid_s2','state_s','promoney_s','proplan_s','onemoney_s','baodi_s','tichen_s');
                var movestr = new Array('playid_term','state_term','findstr');
                movestr.each(function(item, i){
                    url = setUrlParam(url,item,'')
                });
                getsvalue();
                getxinsvalue();
                detailstr.each(function(item, i){
                	if(searchstr[item]!= 'undifine'){
                        url = setUrlParam(url,item,searchstr[item]);
                    }
                });
                var findxs = searchstr['findxs'];
                url = setUrlParam(url,'findxs',findxs);
                loadDataByUrl(url);
                document.body.className='';
                resetAll();
                break;
        } 
						//log(url); //搜索url   
    }
    
    function do_change(stype,point){
    	Y.get('#bxspan').show();
    	resetplay();
    	clearAll(1);
        resetAll(1);
    	var titlestr = '';
    	Y.one('#stype').value = stype;   
        list = Y.get('#stype_t li');
        list.each(function(item,i){
        	item.className = (i+1==point)?"an_cur":'';
        });
        var state_term = 1;
        orderstr = 'DESC';
        if(stype==1)orderby = 'renqi';
        if(stype==2)orderby = 'zhanji';
        if(stype==3)orderby = 'prize';
        
        var periodSelection = Y.get("#periodSelection");
		if(periodSelection.size() && periodSelection.one().options[periodSelection.one().selectedIndex].text.indexOf('期') == -1 && periodSelection.one().options[periodSelection.one().selectedIndex].text != periodSelection.one().options[0].text){//当前,预售	
			state_term = 0;
			orderby = 'getmoney';
		}
		var movestr = new Array('playid_term','state_term','findstr','playid_s','state_s','promoney_s','proplan_s','onemoney_s','baodi_s','tichen_s','findxs');
        movestr.each(function(item, i){
            url = setUrlParam(url,item,'')
        });
    	var b=new Array("state_term","orderby","orderstr","stype");
        b.each(function(item, i){
            url = setUrlParam(url,item,eval(item));
        });
        Y.one("#currentkey").value = orderby;
        Y.one("#currentsort").value = orderstr;
    	loadDataByUrl(url);
    	state_term = state_term==-1?3:state_term;
    	//Y.get('#state_term').one().options[state_term].selected = true;	
    	clearAll(); //清空详细搜索
    }
	function mouse_over(obj) {
	    obj.className    = 'th_on';
	}
	function mouse_out(obj) {
	    obj.className    = obj.getAttribute('vclass');
	}
    function setUrlParam(oldurl,paramname,pvalue){   
        var reg = new RegExp("(\\?|&)"+paramname+"=([^&]*)(&|$)","gi");  
        if(!(pvalue === '')){   
	        var pst=oldurl.match(reg);     
	        if((pst==undefined) || (pst==null)){    
	            return oldurl+((oldurl.indexOf("?")==-1)?"?":"&")+paramname+"="+pvalue;     
	        }   
	        var t=pst[0];     
	        var retxt=t.substring(0,t.indexOf("=")+1)+pvalue; 
	        if(t.charAt(t.length-1)=='&') retxt+="&";   
        }else{
        	retxt = '&';
        }
        return oldurl.replace(reg,retxt);     
    }
Y.get('#list_data').live(':text','focus',function(){  
	Y.get(this).addClass('rec_t_on')
}).live(':text','blur',function(){  
	Y.get(this).removeClass('rec_t_on')
})    
    
Y.get('#list_data').live(':button','click',function(){
	var buynum = Y.get(this).parent('tr').find(':text').val();
	var lotid = Y.get(this).parent('tr').find(':text').attr('vlotid');
	var playid = Y.get(this).parent('tr').find(':text').attr('vplayid');
	var expect = Y.get(this).parent('tr').find(':text').attr('vexpect');
	var onemoney = Y.get(this).parent('tr').find(':text').attr('vonemoney');  
	var snumber = Y.get(this).parent('tr').find(':text').attr('vsnumber');  
	var totalbuymoney = buynum * onemoney;    //认购总金额
	var pid = Y.get(this).parent('tr').find(':text').attr('vid');
	var hx = this;
	if(buynum == ''){
		Y.alert('您好，认购份数不能为空！')
		return false
	}
    if(buynum <= 0 || Y.getInt(buynum) != buynum){
		Y.alert('您好，认购份数必须为大于等于1的整数！')
		return false
	}
	if(Y.getInt(buynum) > snumber){
		Y.alert('您好，认购的份数不能大于剩余份数！'+buynum+snumber,function(){Y.get(hx).parent('tr').find(':text').val(snumber);});
		return false
	}
	regou = function (){
		
		var buyurl = baseUrl+submit_url_join+"?lotid="+lotid+"&playid="+playid+"&pid="+pid+"&buynum="+buynum+"&from=buycenter";
		//alert(buyurl);
		Y.alert('您好， 正在提交您的请求，请稍等...', false, true);
        Y.ajax(
        {
            url: buyurl,
            type:'GET',
            end:function(data)
            {
            	Y.alert.close();
                var json;
				
                if(!data.error)
                {
                    if(json = Y.dejson(data.text))
                    {
                       if(json.state==100){
                       	   Y.alert.close();
                           Y.popBuyOk(Y.C('userName'));
                       }else{
                       	   if(json.msg == '余额不足'){
							   return Y.addMoney()
                       	   }else{
                               Y.alert(json.msg); 
                       	   }
                       }
                    }    
                }else{
					//log(data);
                	Y.alert('对不起，认购失败,请重新认购！');
                }
            }
        });        
	};
	
	regoudlt = function (){
		
		var buyurl = baseUrl+submit_url_join+"?lotid="+lotid+"&playid="+playid+"&pid="+pid+"&buynum="+buynum+"&from=buycenter";
		//alert(buyurl);
		Y.alert('您好， 正在提交您的请求，请稍等...', false, true);
        Y.ajax(
        {
            url: buyurl,
            type:'GET',
            end:function(data)
            {
            	Y.alert.close();
                var json;
				
                if(!data.error)
                {
                    if(json = Y.dejson(data.text))
                    {
                       if(json.state==200){
                    	   Y.alert("认购成功！");
                       }else{
                    	   Y.alert(json.msg); 
                       }
                    }    
                }else{
					//log(data);
                	Y.alert('对不起，认购失败,请重新认购！');
                }
            }
        });        
	};
	view = function(){
		Y.openUrl(baseUrl+submit_url+pid+"?buynum="+buynum+"&totalbuymoney="+totalbuymoney,700,560);
		//alert(baseUrl+submit_url+pid+"?buynum="+buynum+"&totalbuymoney="+totalbuymoney);
	};
	if(lotid!=8){
		Y.postMsg('msg_login',view);
	}
	else{
		Y.postMsg('msg_login',regoudlt);
	}
		
})

function clearAll(type){
	if(type==1){
    	Y.one('#cFfilter').style.display = "none";
	}
	Y.get('#cFfilter a.c-f-on').removeClass('c-f-on');
	if(Y.one("#ttype").value >=1 ){
		Y.get('#cFfilter a[innerHTML=不限]').addClass('c-f-on')
        if(Y.one("#ttype").value==1)Y.get('#cFfilter a[innerHTML=单式]').addClass('c-f-on');
		if(Y.one("#ttype").value==2)Y.get('#cFfilter a[innerHTML=复式]').addClass('c-f-on');
		if(Y.one("#ttype").value==3)Y.get('#cFfilter a[innerHTML=胆拖]').addClass('c-f-on');
	}else{
	    Y.get('#cFfilter a[innerHTML=不限]').addClass('c-f-on')
	}
	Y.get('#cFfilter a[innerHTML=未满员]').addClass('c-f-on')
	Y.get('#cFfilter a[innerHTML=未满员]').prev('a').prop('className', '');
	clearAllxin(1);
	getsvalue();
}
function clearAllxin(type){
	if(type==1){
		var xinsui1 = Y.get('#xinsui1');
		var xinsui2 = Y.get('#xinsui2');
		Y.get('#cFfilterin a[innerHTML=胆拖]').show()
		Y.get('#cFfilterin a[innerHTML=组合]').show()
		getsvalue();
        if((lotid==7 || lotid==5) && (searchstr['playid_s']==1)){
        	if(xinsui1.size())Y.one('#xinsui1').style.display='';;
		    if(xinsui2.size())Y.one('#xinsui2').style.display='none';
        }
    	if(searchstr['playid_s']==123 || searchstr['playid_s']==3){
    	    if(xinsui1.size())Y.one('#xinsui1').style.display='none';
	        if(xinsui2.size())Y.one('#xinsui2').style.display='';
    	}
    	if(searchstr['playid_s']==43 || searchstr['playid_s']==0){
    	    if(xinsui1.size())Y.one('#xinsui1').style.display='';
	        if(xinsui2.size())Y.one('#xinsui2').style.display='none';
    	}
    	if(searchstr['playid_s']==44){
    	    if(xinsui1.size())Y.one('#xinsui1').style.display='none';
	        if(xinsui2.size())Y.one('#xinsui2').style.display='none';
    	}
		if(lotid==3){
	    	Y.one('#rednote').innerHTML='选择红球<em>(单次最多可选16个)</em>';
	    }
	    if(lotid==28){
			Y.one('#rednote').innerHTML='选择前区号码';
			Y.one('#bluenote').innerHTML='选择后区号码';
		}
		Y.one('#cFfilterxin').style.display='';		
	}
	Y.get('#cFfilterxin b.o-b').removeClass('o-b');
	Y.get('#cFfilterxin b.r-b').removeClass('r-b');
	Y.get('#cFfilterxin b.b-b').removeClass('b-b');
	Y.get('#cFfilterxin b.spf_on').removeClass('spf_on');
}
function resetAll(type){
	Y.get('#playid_term').one().options[0].selected = true;
	var periodSelection = Y.get("#periodSelection");
	if(periodSelection.size() && periodSelection.one().options[periodSelection.one().selectedIndex].text.indexOf('期') == -1 && periodSelection.one().options[periodSelection.one().selectedIndex].text != periodSelection.one().options[0].text){//当前,预售			
	    Y.get('#state_term').one().options[0].selected = true;
	}else{
		Y.get('#state_term').one().options[1].selected = true;
	}
}
function resetplay(){
	var valsel = Y.one('#selval').value;
	var arr_sel = valsel.split(",");
	Y.get('#playid_term').one().options.length=0;
	for(var j=0;j<arr_sel.length;j++){
		var po = arr_sel[j].split("|");
		Y.get('#playid_term').one().options[j]= new Option(po[1],po[0]);
	}
}
function showalla(){
	Y.get('#cFfilter li a').each(function(a){
		a.style.display = '';
	})
}
setTimeout(function(){
	resetAll();
	Y.one("#findstr").value = '请输入用户名';
}, 200);