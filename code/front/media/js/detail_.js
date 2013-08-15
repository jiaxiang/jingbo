//奖金明细
    Class('PrixList', {
        index:function (){
            var dlg = this.lib.MaskLay('#blk1');
            dlg.addClose('#close1');
			this.get('#blk1 div.tips_title').drag(this.get('#blk1'));
            dlg.panel.find('div.tips_info').setStyle('height:470px; overflow-y:auto; overflow-x:hidden; _width:632px');
            this.bs = 1;
            this.get('#seemore').click(function (e, Y){
                var data = Y.C('choose_data'),
                    ggData =  Y.C('-all-gg-type'),
                    duoc = ggData.dc,
                    minVs = Y.C('dggp') ? 1 : 2;
                if (!data || (data.length < minVs)) {
                    return Y.alert('您好，请至少选取'+minVs+'场比赛！');
                }else if(!duoc && ggData.zy.length === 0){
                    return Y.alert('您好，请选择过关方式！')
                }
                var tbody = [], tpl = Y.tz_tpl[1];
                Y.isduoc = duoc ? parseInt(duoc) : false;
                for (var i = 0, j = data.length; i < j; i++) {
                    data[i].danStr = data[i].dan ? '<span class="red">√</span>': '×';//显示胆
                    tbody.push(tpl.tpl(data[i]))
                }
                Y.bs = Y.get('#bs').val()||Y.get('#beishu').val();
                Y.get('#tz_fenbu').html(Y.tz_tpl['0']+tbody.join('')+Y.tz_tpl[2].tpl({
                    ggtype: Y.C('_current_gg_type'),
                    bs: Y.bs,
                    totalmoney: Y.get('#buy_money').html()||Y.get('#totalmoney').val()
                }));//投注分布
                Y.get('#hot_case').html(Y.getSplitHtml(data));
                Y.get('#hit_split').html('');//clear
                dlg.pop();
            });
            this.onMsg('msg_get_top_prix', function (data, hardhanded){// data, 是否点击显示隐藏奖金
			   var max_prix, bs = Y.get('#bs').val()||Y.get('#beishu').val();
			   max_prix = this.predictMaxPrize(data);
			   Y.C('max_prix_prize', max_prix);
			   return !hardhanded && (data.length > 10 || max_prix * bs > 5000000) ? undefined : max_prix;
            });
            this.onMsg('msg_hit_split', function (span, hitNum, isMax){//命中场数, 是否是求最大sp
                var btn = this.get(span);
                if (btn.html().indexOf('明细') > -1) {
                    btn.parent('table').find('span').show().html('(明细)').setStyle('color:#005ebb');
                    btn.html('(收起)').setStyle('color:red');
                    var ggData =  Y.C('-all-gg-type'),
                    duoc = ggData.dc;
                    duoc ? this._getDCHitSplit(hitNum, isMax)  : this._getHitSplit(hitNum, isMax)                    
                }else{//点击'收起'
                    btn.parent('table').find('span').show().html('(明细)').setStyle('color:#005ebb');
                    this.get('#hit_split').html('');             
                }
            })
        },
		predictMaxPrize : function(data) {
			var gg_name = Y.C('_current_gg_type'),
				max_pl  = data.map(function(o) {
					return +o.maxSP;
				});
			gg_name = typeof gg_name == 'string' ? gg_name : gg_name.join(',');
			if (!max_pl.length || !gg_name) {
				return 0;
			} else {
				return this.postMsg('msg_predict_max_prize', max_pl, gg_name).data;
			}
		},
		predictMaxPrize : function(data) {
			var gg_name = Y.C('_current_gg_type'), d = [], max_pl=[];
            data.each(function (o){
                if (o.dan) {
                    d.push(+o.maxSP)//胆pl
                }else{
                    max_pl.push(+o.maxSP)
                }
            });
			gg_name = typeof gg_name == 'string' ? gg_name : gg_name.join(',');
			if (!max_pl.length || !gg_name) {
				return 0;
			} else {
                var pz = this.postMsg('msg_predict_max_prize', max_pl, gg_name, d).data;
                return pz
			}
		},
        getSplitHtml: function (data){
            var ggType = this._getHitType(),
                obj = {
                    splitnum: ggType.length,
                    bs: this.bs,
                    title: ggType.html
                };
            return this.cf_tpl[0].tpl(obj) + this._getHitHtml(data, ggType.n_1, obj.bs) + '</table>'
        },
        _getHitHtml: function (data, c1, bs){//填充奖金分布
            var min_num = c1[c1.length-1], self = this,
                tpl = this.cf_tpl[1],// 最大最小行
                html = [], duoc = this.isduoc,
                rlist = this._getMinMaxList(data, c1),
                caseLen = data.length,
                prixsDown = rlist[1],//每个串的奖金表
                prixsUp = rlist[0], dan = 0,
                allprix = [];
            data.each(function (o){
                dan+=o.dan?1:0
            });
           for (var i = data.length; i >= min_num; i-- ) {//假定命中场数 从全到2,  i 是命中, n 是拆成串几
               var ini = {
                    hotCount: i,
                    hottd: c1.map(function (n){return '<td>'+ (duoc ? Yobj.postMsg('msg-get-dc-zs', dan, caseLen-dan,duoc,n, i).data : Math.dt(dan,(i-dan), n))+'</td>'}).join(''),//不同的串的中奖注数
                    bs: bs,
                    num: i,
                    min: duoc ? (this._getDCPrixs(duoc, i, rlist[3], c1, true, rlist[5],rlist[4])*bs).toFixed(2) : Math.round(c1.reduce(function (s, n){
                        var zs = Math.dt(dan, i-dan, n);//注数
                        return s + (zs ? prixsDown[n].slice(0, zs).reduce(function (ss, m){
                            return ss + m[1]
                        }, 0) : 0)//从最低表中剪切出前zs个进行相加
                    }, 0)*200*bs)/100,//200 = 2.00*100
                    max:  duoc ? (this._getDCPrixs(duoc, i, rlist[2], c1, false, rlist[5],rlist[4])*bs).toFixed(2) : Math.round(c1.reduce(function (s, n){
                        var zs = Math.dt(dan, i-dan, n);//注数
                        return s + (zs ? prixsUp[n].slice(-zs).reduce(function (ss, m){
                            return ss + m[1]
                        }, 0) : 0)
                    }, 0)*200*bs)/100
                };
                allprix.push(ini.min, ini.max);
                html.push(tpl.tpl(ini))
            }
            allprix.sort(Array.up);
			allprix[allprix.length - 1] = Y.C('max_prix_prize') * bs;
            this.get('#prix_range').html('奖金范围: '+parseFloat(allprix[0]).rmb(false)+' - '+parseFloat(allprix.pop()).rmb(false)+'元');
            return html.join('')
        },
        _getDCPrixs: function (ggName, hitCount, spList, ggArr, ismin, mindan, maxdan){// 一场参与数, 命中数, sp表, 过关组合表
            return this.postMsg('msg_get_split_info', spList, ggName, hitCount, ggArr, ismin, mindan, maxdan).data.value
        },
        _getHitSplit: function (hitNum, isMax){//生成不同命中的(明细)
            var c1 = this._getHitType().n_1,//[3'c1',2'c1']
                data = Y.C('choose_data'), spData,
                allData = this._getMinMaxList(data, c1);
            var t = this.mx_tpl[0], 
                f = this.mx_tpl[2], 
                bm = this.mx_tpl[1],
                totalMoney = 0,
                totalZs = 0, dan = 0,
                b = [];
            data.each(function (o){
                dan+=o.dan?1:0
            });
            spData = isMax ? allData[0] : allData[1];
            var ggData =  Y.C('-all-gg-type'),
                duoc = ggData.dc ?  parseInt(ggData.dc) : false;
            for (var i = 0, j = c1.length; i < j; i++) {
                var n = c1[i], money = 0 ,zs = 0;
                if (n <= hitNum) {//应该以最大的n-1个为胆，进行组合
                    zs = Math.dt(dan, hitNum-dan, n);
                    var clip = isMax ? [-zs] : [0, zs];
                    var expr = spData[n].slice.apply(spData[n], clip).map(function (d){
                        money +=  d[1];
                        return d[0].join('×') + '×'+ this.bs +'倍×2元=<strong style="color:#005ebb">' + (d[1]*2*this.bs).toFixed(2) +'</strong>'
                    }, this).join('<br/>');
                    b.push(bm.tpl({
                        ggtype: n + '串1',
                        zs: zs + '注',
                        expr: expr,
                        money: (money*2*this.bs).toFixed(2) + '元'
                    }));
                    totalMoney += money*2*this.bs;
                    totalZs += zs
                }
            }
            b.push(bm.tpl({
                ggtype: '合  计',
                zs: totalZs + '注',
                expr: '&nbsp;',
                money: totalMoney.toFixed(2) + '元'
            }));
            this.get('#hit_split').html(t.tpl({
                num: hitNum,
                ch: isMax?'大':'小'
            }) + b.join('') + f)
        },
       _getDCHitSplit: function (hitNum, isMax){//生成不同命中的(明细)
            var c1 = this._getHitType().n_1,//[3'c1',2'c1']
                data = Y.C('choose_data'), spData,
                allData = this._getMinMaxList(data, c1);
            var t = this.mx_tpl[0], 
                f = this.mx_tpl[2], 
                bm = this.mx_tpl[1],
                totalMoney = 0,
                totalZs = 0,
                b = [];
            spData = isMax ? allData[0] : allData[1];
            var ggData =  Y.C('-all-gg-type'),
                duoc = ggData.dc ?  parseInt(ggData.dc) : false;
            var list = this.postMsg('msg_get_split_info', allData[isMax ? 2 : 3], duoc, hitNum, c1, !isMax, allData[4], allData[5]).data.list;
            var tableData = {};
            list.each(function (p, i){
                p.remove(-1);
                if (!tableData[p.length]) {
                    tableData[p.length] = []
                }
                tableData[p.length].push(p)
            });
             for(var k in tableData){
                var  money = 0, c = tableData[k];
                b.push(bm.tpl({
                    ggtype: k + '串1',
                    zs: c.length + '注',
                    expr: c.map(function (p){
                         money +=eval(p.join('*'));
                        return p.join('×') + '×'+ this.bs +'倍×2元=<strong style="color:#005ebb">' + ((eval(p.join('*')))*2*this.bs).toFixed(2) +'</strong>'
                    }, this).join('<br/>'),
                    money: (money*2*this.bs).toFixed(2) + '元'
                }));
                totalMoney += money*2*this.bs;
                totalZs += c.length                
             }
            b.push(bm.tpl({
                ggtype: '合  计',
                zs: totalZs + '注',
                expr: '&nbsp;',
                money: totalMoney.toFixed(2) + '元'
            }));
            this.get('#hit_split').html(t.tpl({
                num: hitNum,
                ch: isMax?'大':'小'
            }) + b.join('') + f)
        },
        _getHitType: function (){//生成过关方式表头和数据
            var ggTitle = [], tmp = [], ggtype, c1=[], curGg = Y.C('_current_gg_type');
            if (this.isString(curGg)) {//如果是多串(固定组合)过关,先进行转换
                ggtype = this.splitMap[curGg];
                for(var k in ggtype){//命中表头
                    tmp[tmp.length] = k;
                }
            }else{
                tmp = curGg
            }
            tmp.sort(function (a, b){//含有"单关", 不能转为数字
                return (parseInt(a)||1)> (parseInt(b)||1)? 1 : -1
            });
            for (var i =  tmp.length; i--;) {
                ggTitle.push('<td>'+tmp[i]+'</td>');
                c1.push(parseInt(tmp[i])||1);//固赔单关为1                           
            }
            return {
                length: c1.length,
                n_1: c1,//[3,2,1]
                html:ggTitle.join('')//'<td>3串1</td>...'
            }
        },
        _getMinMaxList: function (data, c1){//返回一个数组存放最大
           var  prixsUp = {}, prixsDown = {}, del = /,/g, dan_sp_max=[], dan_sp_min=[], maxs = [], mins = [];
           data.each(function (a){//每个对阵的最大SP值
               var sp=a.maxSP.replace(del,''),
                 sp_min = a.minSP.replace(del,'');
               if (a.dan) {
                   dan_sp_max.push(sp);
                   dan_sp_min.push(sp_min)//每个对阵的最小SP值
               }else{
                   maxs.push(sp);
                   mins.push(sp_min)
               }
           });
           for (var n =  c1.length; n--;) {//c1 = [4, 5]分别代表几串1
                var zh = Math.dtl(dan_sp_max, maxs, c1[n]);
                prixsUp[c1[n]] = zh.map(function (a){//所有单注最高奖金表
                    return [a, a.reduce(function (s, o){
                        return s*parseFloat(o)
                    }, 1)]
                }).sort(function (a, b){
                    return parseFloat(a[1]) > parseFloat(b[1]) ? 1 : -1
                });
                zh = Math.dtl(dan_sp_min,mins, c1[n]);
                prixsDown[c1[n]] = zh.map(function (a){//最低奖金表
                    return [a, a.reduce(function (s, o){
                        return s*parseFloat(o)
                    }, 1)]
                }).sort(function (a, b){
                    return parseFloat(a[1]) > parseFloat(b[1]) ? 1 : -1
                });
           };
            return [prixsUp, prixsDown, maxs, mins, dan_sp_max, dan_sp_min]//maxs和mins是不含胆的
        },
        cf_tpl:['<table width="100%" border="0" cellspacing="0" cellpadding="0">'+
            '<tr><th rowspan="2">命中场数</th><th colspan="{$splitnum}">中奖注数/注</th>'+
            '<th rowspan="2">倍数</th><th colspan="2" class="last_th">奖金</th>'+
            '</tr><tr class="trone">{$title}<th>最小</th><th class="last_td">最大</th></tr>',
            '<tr><td>{$hotCount}</td>'+
            '{$hottd}<td>{$bs}</td>'+
            '<td><strong class="eng">{$min}</strong>元<span style="cursor:pointer;color:#005ebb" onclick="Yobj.postMsg(\'msg_hit_split\',this,{$num},false)">(明细)</span></td>'+
            '<td class="last_td"><strong class="eng red">{$max}</strong>元<span style="cursor:pointer;color:#005ebb" onclick="Yobj.postMsg(\'msg_hit_split\',this,{$num},true)">(明细)</span></td></tr>'],
        mx_tpl:['<h3>拆分明细</h3><table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed">'+
            '<tr><th width="65">过关方式</th><th width="65">中奖注数</th><th>中{$num}场 最{$ch}奖金 中奖明细</th>'+
            '<th class="last_th" width="80">奖金</th></tr>',
            '<tr><td>{$ggtype}</td><td>{$zs}</td>'+
            '<td class="tl">{$expr}</td>'+
            '<td class="last_td"><span class="red">{$money}</span></td></tr>',
            '<tr class="last_tr">'+
            '</table>'],
        tz_tpl:['<table width="100%" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed">'+
            '<tr><th width="65">赛事编号</th><th width="153">对阵</th><th width="210">您的选择(奖金)</th>'+
            '<th>最小奖金</th><th>最大奖金</th><th class="last_th">胆码</th></tr>',
            '<tr><td>{$date}</td><td>{$vs}</td>'+
            '<td class="tl">{$choose}</td>'+
            '<td>{$minSP}</td><td><span class="_red">{$maxSP}</span></td><td class="last_td">{$danStr}</td></tr>',
            '<tr class="last_tr">'+
            '<td colspan="6" class="last_td">过关方式：<span class="red">{$ggtype}</span> 倍数：<span class="red">{$bs}</span>倍 '+
            '方案总金额：<span class="red">{$totalmoney}</span>元</td></tr></table>'],
        splitMap:{
            '单关':{'单关':1},
            '2串1':{'2串1':1},
            '3串1':{'3串1':1},
            '4串1':{'4串1':1},
            '5串1':{'5串1':1},
            '6串1':{'6串1':1},
			'7串1':{'7串1':1},
			'8串1':{'8串1':1}, 
            '3串3':{'2串1':3},
            '3串4':{'3串1':1,'2串1':3},
            '4串6':{'2串1':6},
            '4串11':{'4串1':1,'3串1':4,'2串1':6},
            '5串10':{'2串1':10},
            '5串20':{'2串1':10,'3串1':10},
            '5串26':{'5串1':1,'4串1':5,'3串1':10,'2串1':10},
            '6串15':{'2串1':15},
            '6串35':{'2串1':15,'3串1':20},
            '6串50':{'2串1':15,'3串1':20,'4串1':15},
            '6串57':{'6串1':1,'5串1':6,'4串1':15,'3串1':20,'2串1':15},
            '4串4':{'3串1':4},
            '4串5':{'4串1':1,'3串1':4},
            '5串16':{'5串1':1,'4串1':5,'3串1':10},
            '6串20':{'3串1':20},
            '6串42':{'6串1':1,'5串1':6,'4串1':15,'3串1':20},
            '5串5':{'4串1':5},
            '5串6':{'5串1':1,'4串1':5},
            '6串22':{'6串1':1,'5串1':6,'4串1':15},
            '6串6':{'5串1':6},
            '6串7':{'6串1':1,'5串1':6},
			'7串7' : {'6串1':7},
			'7串8' : {'6串1':7, '7串1':1},
			'7串21' : {'5串1':21},
			'7串35' : {'4串1':35},
			'7串120': {'2串1':21, '3串1':35, '4串1':35, '5串1':21, '6串1':7, '7串1':1},
			'8串8' : {'7串1':8},
			'8串9' : {'7串1':8, '8串1':1},
			'8串28' : {'6串1':28},
			'8串56' : {'5串1':56},
			'8串70' : {'4串1':70},
			'8串247': {'2串1':28, '3串1':56, '4串1':70, '5串1':56, '6串1':28, '7串1':8, '8串1':1}
		}
    });

/*
* 功能: 计算多串的胆拖方案的拆分与奖金
*/
Class( {
	ready : true,
    index: function (){
        this.onMsg('msg_get_split_info', function (spList, ggName, hitCount, ggArr, ismin, mindan, maxdan){
            var dan = ismin ? mindan : maxdan;
            return this.doSplit(spList, ggName, hitCount, ggArr, ismin, mindan, maxdan)       
        });
        //计算多串的注数
        this.onMsg('msg-get-dc-zs', function (dan, tuo, gg, n, hit){//胆的个数,拖的个数,过关数,几串一,命中数
            var dArr = this.repeat(dan,function (i){
                   return i<hit?1:0
               }),
               tArr = this.repeat(tuo, function (i){
                   return i<(hit-dan)?1:0
               });
            var num=0, dtl = Math.dtl(dArr, tArr, gg);//转成套票
            dtl.each(function (code){
                Math.cl(code, n).each(function (c){
                    if (c.indexOf(0)==-1) {
                        num++//过滤掉没命中的单票
                    }                    
                })
            });
            return num
        });
    },
	doSplit : function(spList, ggName, hitCount, ggArr, ismin, mindan, maxdan) {
		var dan = ismin ? mindan : maxdan, pl, num = hitCount,
            ggtype = parseInt(ggName),
			split_pl = [];
        //从大到小
		spList.sort(Array.up);
        dan.sort(Array.up);
        if (!ismin) {//如果取最小,从小到大
           spList.reverse();
           dan.reverse();
        }
        dan = dan.map(function (item, i){
            return i<hitCount ? item : 0//未命中置0
        });
        num-=dan.length;
        spList = spList.map(function (item, i){//如果胆命中后还有拖被命中
            return i<num ? item : 0;//未命中置0
        });
		pl = Math.dtl(dan, spList, ggtype);//转成基本套票
		pl.each(function(_pl) {
			ggArr.each(function(n) {
				split_pl = split_pl.concat(Math.cl(_pl, n));//转成串一的小票
			})
		} );
		return this.prizeDetail(split_pl, hitCount);
	},
	prizeDetail : function(arr_pl, hit_num) {
		var ret = [], hp = [], sum = 0;
        arr_pl = arr_pl.filter(function (xp){
            if (xp.indexOf(0) == -1) {//有效票(全命中)
                sum += eval('('+xp.join('*')+')');//每个元素的sp乘积相加
                return true
            }
        });
        var ret = {
            list: arr_pl,//数组
            value: (sum*2).toFixed(2)//奖金
        }; 
        return ret
	}
}); 