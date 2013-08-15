
/* ProjectDetail 北单方案明细
------------------------------------------------------------------------------*/
Class( 'ProjectDetail', {

	ready : true,
	use : 'mask',

	ggm2num : {
		'单关':[1], '2串1':[2], '2串3':[2, 1], '3串1':[3], '3串4':[3, 2], '3串7':[3, 2, 1], '4串1':[4], '4串5':[4, 3], '4串11':[4, 3, 2], '4串15':[4, 3, 2, 1], '5串1':[5], '5串6':[5, 4], '5串16':[5, 4, 3], '5串26':[5, 4, 3, 2], '5串31':[5, 4, 3, 2, 1], '6串1':[6], '6串7':[6, 5], '6串22':[6, 5, 4], '6串42':[6, 5, 4, 3], '6串57':[6, 5, 4, 3, 2], '6串63':[6, 5, 4, 3, 2, 1], '7串1':[7], '8串1':[8], '9串1':[9], '10串1':[10], '11串1':[11], '12串1':[12], '13串1':[13], '14串1':[14], '15串1':[15]
	},
	num2ggm : { 
		'1':'单关', '2':'2串1', '3':'3串1', '4':'4串1', '5':'5串1', '6':'6串1', '7':'7串1', '8':'8串1', '9':'9串1', '10':'10串1', '11':'11串1', '12':'12串1', '13':'13串1', '14':'14串1', '15':'15串1' 
	},
	type2nm : {
		'单关':{'n':1, 'm':1}, '2串1':{'n':2, 'm':1}, '2串3':{'n':2, 'm':3}, '3串1':{'n':3, 'm':1}, '3串4':{'n':3, 'm':4}, '3串7':{'n':3, 'm':7}, '4串1':{'n':4, 'm':1}, '4串5':{'n':4, 'm':5}, '4串11':{'n':4, 'm':11}, '4串15':{'n':4, 'm':15}, '5串1':{'n':5, 'm':1}, '5串6':{'n':5, 'm':6}, '5串16':{'n':5, 'm':16}, '5串26':{'n':5, 'm':26}, '5串31':{'n':5, 'm':31}, '6串1':{'n':6, 'm':1}, '6串7':{'n':6, 'm':7}, '6串22':{'n':6, 'm':22}, '6串42':{'n':6, 'm':42}, '6串57':{'n':6, 'm':57}, '6串63':{'n':6, 'm':63}, '7串1':{'n':7, 'm':1}, '8串1':{'n':8, 'm':1}, '9串1':{'n':9, 'm':1}, '10串1':{'n':10, 'm':1}, '11串1':{'n':11, 'm':1}, '12串1':{'n':12, 'm':1}, '13串1':{'n':13, 'm':1}, '14串1':{'n':14, 'm':1}, '15串1':{'n':15, 'm':1}
	},

	index : function() {

		var Y = this;
        
		this.playId = +this.need('#playid').val();  //玩法id
		this.baseUrl = this.get('#base_url').val();
		
		this.table1 = this.need('#table1');
		this.table2 = this.need('#table2');

		this.projectDetailWrapper = this.need('#project_detail');
		this.projectDetailDialog  = this.lib.MaskLay(this.projectDetailWrapper);
		this.projectDetailDialog.addClose('#project_detail .close a');
		this.projectDetailWrapper.find('.tips_title').drag(this.projectDetailWrapper);

		this.get('#see_project_detail_fs_ck').click( function() {
			Y.showFromCkCodes();
		} );
		this.get('#see_project_detail_fs_info').click( function() {
			Y.showFromCodes();
		} );
		this.get('#see_project_detail_ds_ck').click( function() {
			Y.showFromFile();
		} );
		this.get('#see_project_detail_ds_info').click( function() {
			Y.showFromFile();
		} );

		this.beishu = +this.need('#beishu').val();
		
		this.theadHtml = this.rqHtml = '';
		if (this.playId == 34 || this.playId == 150) {  //表头让球列
			this.rqHtml = '<th>让球数</th>';
		} else if (this.playId == 51 || this.playId == 154) {  //表头半场比分
			this.rqHtml = '<th>半场比分</th>';
		}

		this.mr = ({						//mr=mathResult
			"34" : ["胜", "平", "负"],
			"41" : ["上+单", "上+双", "下+单", "下+双"],
			"40" : ["0", "1", "2", "3", "4", "5", "6", "7+"],
			"51" : ["胜-胜", "胜-平", "胜-负", "平-胜", "平-平", "平-负", "负-胜", "负-平", "负-负"],
			"42" : ["胜其他", "1:0", "2:0", "2:1", "3:0", "3:1", "3:2", "4:0", "4:1", "4:2", "平其他", "0:0", "1:1", "2:2", "3:3", "负其他", "0:1", "0:2", "1:2", "0:3", "1:3", "2:3", "0:4", "1:4", "2:4"]
		})[{150:34,151:40,152:41,153:42,154:51}[this.playId]||this.playId];
		this.idx2mr = function(n){return Y.mr[n]};
		this.mr2idx = {};
		this.mr.each( function(s,i){Y.mr2idx[s]=i} );

		//创建一个公共弹窗, 使用msg_show_dlg进行调用
		this.infoLay = this.lib.MaskLay('#defLay', '#defConent');
		this.infoLay.addClose('#defCloseBtn', '#defTopClose a');
		this.get('#defLay div.tips_title').drag(this.get('#defLay'));

		// 提供弹窗服务
		this.onMsg('msg_show_dlg', function (msg, fn, forbid_close) {
			this.infoLay.pop(msg, fn, forbid_close);
		} );
	},

	showDialog : function() {
		this.projectDetailDialog.pop(this.projectDetailWrapper.html());
	},

	//从确认页隐藏域显示
	showFromCkCodes : function() {
		var Y = this;
		this.ggt = this.need('#gggroup').val();			//过关类型
		this.ggm = this.need('#sgtypename').val();		//过关方式
		this.isre = true;		//是否去重复
		this.ggmlist = this.ggt==3 ? this.arrayEach(this.ggm.split(","), function(s){return Y.type2nm[s].n}).reverse() : Y.ggm2num[Y.ggm];
		this.nb = [];
		var aa = this.parse(this.need('#codes').val(), this.need('#danma').val());
		var rows = this.need('#fangan_table').one().rows;
		var a;
		
		aa.each( function(o, i) {
			a = rows[i+1].cells;
			switch(this.playId){
				case 34:
					this.nb[i] = {row:o.row, vs:a[1].innerHTML, rq:a[2].innerHTML, rt:(a[3].getAttribute('codes')||a[3].innerHTML), dan:o.dan, colspan_num:5};
					break;
				default:
					this.nb[i] = {row:o.row, vs:a[1].innerHTML, rt:(a[2].getAttribute('codes')||a[2].innerHTML), dan:o.dan, colspan_num:4};
			}

		}, this );
		if (this.ggt==3) this.isre=true;
		this.theadHtml = '<tr><th>场次</th><th>比赛</th>' + (this.playId == 34 ? this.rqHtml : '') + '<th>您的选择</th><th class="last_th">胆码</th></tr>';
		this.showCodes();
	},

	//从认购页隐藏域显示
	showFromCodes : function(){
		var Y = this;
		this.ggt = +this.need('#gggroup').val();		//过关类型
		this.ggm = this.need('#ggtypename').val();		//过关方式
		this.isre = true;                       		//是否去重复
		this.ggmlist = this.ggt==3 ? this.arrayEach(this.ggm.split(","), function(s){return Y.type2nm[s].n}).reverse() : this.ggm2num[this.ggm];
		this.nb = [];
		var aa = this.parse(this.need('#codes').val(), this.need('#danma').val());
		var rows = this.need('#fangan_table').one().rows;
		var a;
		aa.each( function(o, i) {
			a = rows[i+1].cells;
			switch(this.playId){
				case 34:
					this.nb[i] = {row:o.row, vs:a[1].innerHTML, rq:a[2].innerHTML, bf:a[3].innerHTML, rt:a[6].innerHTML, sp:a[5].innerHTML, dan:o.dan, colspan_num:7};
					break;
				case 51:
					this.nb[i] = {row:o.row, vs:a[1].innerHTML, bcbf:a[2].innerHTML, bf:a[3].innerHTML, sp:a[5].innerHTML, rt:a[6].innerHTML, dan:o.dan, colspan_num:7};
					break;
				default:
					this.nb[i] = {row:o.row, vs:a[1].innerHTML, bf:a[2].innerHTML, sp:a[4].innerHTML, rt:a[5].innerHTML, dan:o.dan, colspan_num:6};
			}
		}, this );
		this.theadHtml = '<tr><th>场次</th><th>比赛</th>' + this.rqHtml + '<th>全场比分</th><th>您的选择</th><th>开奖sp值</th><th class="last_th">胆码</th></tr>';
		this.showCodes();
	},

	//从文件显示
	showFromFile : function(){
		var Y = this, file = '';;
		if (/project_fqck_ds.php/i.test(document.URL)) {
			file = this.baseUrl + '/bjdc/inc/readfile.php?step=ck&filename=' + this.get('#rand').val();
			this.theadHtml = '<tr><th>场次</th><th>比赛</th>' + (this.playId == 150 ? this.rqHtml : '') + '</tr>';
		} else {
			file = this.baseUrl + '/bjdc/inc/readfile.php?step=rh&pid=' + this.get('#pid').val();
			this.theadHtml = '<tr><th>场次</th><th>比赛</th>' + this.rqHtml + '<th>全场比分</th><th>赛果</th><th class="last_th">开奖sp值</th></tr>';
		}
		this.viewMore = this.viewMore2;
		//if (fw.getId("matchList").tagName=="TABLE") sg_split.showCodes=sg_split.showCodes2;
		this.showCodes = this.showCodes2;
		this.ajax( {
			url : file,
			end : function(data) {
				str = data.text;
				if (/保密/.test(str)) { 
					Y.postMsg('msg_show_dlg', str);
					return;
				}
				Y.ggm = Y.need('#ggtypename').val();	//过关方式
				Y.ggmlist = Y.ggm2num[Y.ggm];
				Y.nb = [];
				Y.singlelist = Y.arrayEach(str.split(/\n/),function(s){if(s.trim()!="")return s},[]);
				Y.showCodes();
			}
		} );
	},

	viewMore : function() {
		var Y = this;
		var dn = this.d.length;
		var ad = function(t){return Y.d.concat(t)};
		
		var f = function(d, t){
			var a = [];
			Y.ggmlist.each( function(n){
				a = a.concat( n>dn ? Y.arrayEach(Y.mathCR(t,n-dn),ad) : Y.mathCR(d,n) );
			});
			return a;
		}
	    
		var m = this.ggt==3 ? this.ggm2num[this.ggm.split(",")[0]][0] : this.ggm2num[this.ggm][0];
		
		var r = this.isre ? f(Y.d, Y.t) : this.arrayEach(Y.mathCR(Y.t,m-dn),ad);
	   
		var ll = r.length - 4;
		var html = [];
		var count = 0;
		var g, tt, n;
		
		r.each( function(a,i){
			tt = this.arrayEach(a, function (s){return s.split(",").length}, []);
			n = this.isre ? this.arrayMultiple(tt) : this.esunjsC(tt, Y.ggmlist);
			if (i<100||i>ll){
				g = this.isre ? this.num2ggm[a.length] : this.ggm;
				
				html[i] = '\
				<tr>\
					<td>' + (i+1) + '</td>\
					<td>' + a.join("/") + '</td>\
					<td>' + g + '</td>\
					<td>' + this.beishu + '</td>\
					<td>' + n + '</td>\
					<td class="last_td">' + (n*this.beishu*2).rmb() + '</td>\
				</tr>';
			}else if(i==100){
				html[i] = '<tr><td class="td6" colspan="6" align="center">.................................</td></tr>';
			}
			count += n;
		}, this );
		html.push('\
		<tr class="last_tr">\
			<td>合计：</td>\
			<td></td>\
			<td></td>\
			<td><span class="eng red">'+this.beishu+'</span>倍</td>\
			<td><span class="eng red">'+count+'</span>注</td>\
			<td class="last_td"><span class="eng">'+(count*this.beishu*2).rmb()+'</span>元</td>\
		</tr>');
		this.table2.empty();
		this.get(html.join('')).insert(this.table2);
		this.showDialog();
	},

	//显示拆分明细2
	viewMore2 : function(){
		var html=[], count=this.singlelist.length, n=1;
		this.singlelist.each( function(s, i){
			html.push('\
				<tr>\
					<td>' + (i+1) + '</td>\
					<td>' + s.split(" ").join("/") + '</td>\
					<td>' + this.ggm + '</td>\
					<td>' + this.beishu + '</td>\
					<td>' + n + '</td>\
					<td class="last_td">' + (n*this.beishu*2).rmb() + '</td>\
				</tr>');
		}, this );
		this.table2.empty();
		this.get(html.join('')).insert(this.table2);
		this.get('#ds_pro_info').show();
		this.showDialog();
	},

	//反向分析
	parse : function(codeStr, danStr) {
		var Y = this;
		if (codeStr=="") return [];
		var d = danStr.split("/"), a, rt;
		return this.arrayEach(codeStr.split("/"),function(txt){
			a = txt.split(":[");
			rt = a[1].slice(0,-1).split(",")
			return { row:a[0], dan:Y.arrayGetIdx(d,txt)>-1, rt:rt, rtx:Y.arrayEach(rt,function(s){return Y.mr2idx[s]},[]) };
		});
	},

	//显示投注内容
	showCodes : function(){
		var html = [];
		this.d = [];
		this.t = [];
	
		var fd = function(isd){return isd ? '<span class="red">√</span>' : '×'};
		
		this.nb.each( function(o, i){
			o.rq = o.rq?'</td><td>'+o.rq:'';
			o.bcbf  = o.bcbf?'</td><td>'+o.bcbf:'';
			o.bf = o.bf?'</td><td>'+o.bf:'';
			o.sp = o.sp?'</td><td>'+o.sp:'';
			colspan_num = o.colspan_num?o.colspan_num:6;
			html[i] = '<tr><td>'+o.row+'</td><td>'+o.vs+o.rq+o.bcbf+o.bf+'</td><td>'+o.rt+o.sp+'</td><td class="last_td">'+fd(o.dan)+'</td></tr>';
			this[o.dan?"d":"t"].push(o.row + ":[" + o.rt + "]");
		}, this );
		
		var s = this.ggt==1 ? " -- " : (this.isre?"是":"否");
		html.push('<tr class="last_tr"><td colspan="'+colspan_num+'" class="last_td">过关方式：<span class="red">'+this.ggm+'</span></td></tr>');
		html = this.theadHtml + html.join("");
		this.table1.empty();
		this.get(html).insert(this.table1);
		this.viewMore();
	},

	//显示投注内容2
	showCodes2 : function(){
		this.table1.empty();
		this.get(this.theadHtml).insert(this.table1);
        var cols = this.table1.find('tr').one().cells.length;
		for (var i=0,a = this.need('#fangan_table').one().rows; i<a.length-1; i++){
            var tr = a[i+1].cloneNode(1),
            	cells = tr.getElementsByTagName('td'),
            	j = cells.length-1;
            for (; j>=cols; j--) {
                tr.removeChild(cells[j])
            }            
			this.table1.one().appendChild(tr);
		};
		this.viewMore();
	},

	//fw老框架中的一些方法:

	arrayEach : function(a, cb, r){
		if(r) for(var i=0,t,l=a.length;i<l;i++)(t=cb(a[i],i))!=undefined&&r.push(t);
		else for(var i=a.length-1;i>=0;i--)(a[i]=cb(a[i],i))==undefined&&a.splice(i,1);
		return r||a;
	},

	//数组相加
	arrayAdd : function(a){
		var n = 0;
		for (var i=0,l=a.length;i<l;i++) n+=a[i];
		return n;
	},

	//数组相乘
	arrayMultiple : function(a){
		var n = 1;
		for (var i=0,l=a.length;i<l;i++) n*=a[i];
		return n;
	},

	//获取索引号
	arrayGetIdx : function(a, v){
		for (var i=0,l=a.length;i<l&&a[i]!=v;i++);
		return i<l ? i : -1;
	},

	//组合结果
	mathCR : function (arr, num){
		var r = [];
		(function f(t,a,n){
			if(n==0) return r.push(t);
			for(var i=0,l=a.length-n; i<=l; i++){
				f(t.concat(a[i]), a.slice(i+1), n-1);
			}
		})([],arr,num);
		return r;
	},
	
	esunjsC : function (a, num) {
		var Y = this;
		if (typeof(a[0])=="number") a=this.arrayGetNum(a);
		if (typeof(num)=="number") num=[num];
		var r = 0;
		var n = a.length;
		var ff = function (n,i){ return Math.pow(a[i][0],n) * Math.c(a[i][1],n) };
		(function f(t,i){
			if(i==n){
				if (Y.arrayGetIdx(num, Y.arrayAdd(t))>-1) r += Y.arrayMultiple(Y.arrayEach(t,ff,[]));
				return;
			}
			for(var j=0; j<=a[i][1]; j++) f(t.concat(j), i+1);
		})([], 0);
		return r;
	}

} );