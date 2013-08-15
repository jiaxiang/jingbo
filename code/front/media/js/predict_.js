/**
 * 预测奖金生成器
 */
Class( 'prizePrediction', {
	ready : true,
	typeMap : {
		'3串3' :['2串1'],
		'3串4' :['2串1','3串1'],
		'4串6' :['2串1'],
		'4串11':['2串1','3串1','4串1'],
		'5串10':['2串1'],
		'5串20':['2串1','3串1'],
		'5串26':['2串1','3串1','4串1','5串1'],
		'6串15':['2串1'],
		'6串35':['2串1','3串1'],
		'6串50':['2串1','3串1','4串1'],
		'6串57':['2串1','3串1','4串1','5串1','6串1'],
		'4串4' :['3串1'],
		'4串5' :['3串1','4串1'],
		'5串16':['3串1','4串1','5串1'],
		'6串20':['3串1'],
		'6串42':['3串1','4串1','5串1','6串1'],
		'5串5' :['4串1'],
		'5串6' :['4串1','5串1'],
		'6串22':['4串1','5串1','6串1'],
		'6串6' :['5串1'],
		'6串7' :['5串1','6串1'],

		'7串7'  :['6串1'],
		'7串8'  :['6串1','7串1'],
		'7串21' :['5串1'],
		'7串35' :['4串1'],
		'7串120':['2串1','3串1','4串1','5串1','6串1','7串1'],
		'8串8'  :['7串1'],
		'8串9'  :['7串1','8串1'],
		'8串28' :['6串1'],
		'8串56' :['5串1'],
		'8串70' :['4串1'],
		'8串247':['2串1','3串1','4串1','5串1','6串1','7串1','8串1']
	},
	index : function() {
		new this.lib.DcPrix();
		this.onMsg('msg_predict_max_prize', function(max_sp, gg_name, dan_sp, new_round) {
			return this.predictMaxPrize(max_sp, gg_name, dan_sp, new_round);
		});
		this.onMsg('msg_predict_min_prize', function(min_sp, gg_name, dan_sp, new_round) {
			return this.predictMinPrize(min_sp, gg_name, dan_sp, new_round);
		});
	},
	/**
	 * 预测最大奖金
	 *
	 * @param Array  max_sp  最大赔率构成的数组
	 * @param Stirng gg_name 过关方式(单关或m串n)
	 * @param String new_round 是否采用4舍6入5进双规则
	 * @return Number 最大奖金
	 */
	predictMaxPrize : function(max_sp, gg_name, dan_sp, new_round) {
		var max_prize = 0, hasDan = dan_sp && dan_sp.length > 0;
		if (gg_name == '单关' && !this.C('dggp')) {//浮动单关
			max_prize = max_sp.reduce( function(a,b){return ~~a+~~b} );
		} else if (/串1$/.test(gg_name) || (gg_name == '单关' && this.C('dggp'))) {  //自由
			gg_name = gg_name.split(',');
			gg_name.each( function(_gg_name) {
				var _n = parseInt(_gg_name)||1;
                if (hasDan) {
                	Math.dtl(dan_sp, max_sp, _n).each( function(sp) {
                    	max_prize += parseFloat(sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000}));
                    }, this );                        
                }else{
                    Math.cl(max_sp, _n).each( function(sp) {
                        max_prize += parseFloat(sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000}));
                    }, this );                    
                }
			}, this );
		} else {  //多串(不去重)
			var _n = parseInt(gg_name);
			var mz = this.typeMap[gg_name].map(function(x){
				return parseInt(x);
			});
			var max_hit = max_sp.length+dan_sp.length;//全中
            dan_sp = dan_sp ? (typeof(dan_sp) == 'string' ? dan_sp.split(',') : dan_sp) : [];
			max_prize = this.postMsg('msg_get_split_info', max_sp,_n,max_hit,mz,false,'',dan_sp).data.value/2;
			/*spList, ggName, hitCount, ggArr, ismin, mindan, maxdan
			*/
		}
		if (gg_name != '单关' || this.C('dggp')) {
			max_prize *= 2;
		}
		return max_prize = new_round ? this.newRound(max_prize) : (+max_prize).toFixed(2);
	},
	/**
	 * 预测最小奖金
	 *
	 * @param Array  min_sp  最小赔率构成的数组
	 * @param Stirng gg_name 过关方式(单关或m串n)
	 * @param String new_round 是否采用4舍6入5进双规则
	 * @return Number 最小奖金
	 */
	predictMinPrize : function(min_sp, gg_name, dan_sp, new_round) {
		var min_prize = 0, hasDan = dan_sp && dan_sp.length > 0;
		if (gg_name == '单关' && !this.C('dggp')) {
			min_prize = min_sp.sort(Array.up)[0];
		} else if (/串1$/.test(gg_name) || (gg_name == '单关' && this.C('dggp'))) {  //自由
			gg_name = gg_name.split(',');
			gg_name.each( function(_gg_name) {
				var _n = parseInt(_gg_name)||1;
                if (hasDan) {
                	Math.dtl(dan_sp, min_sp, _n).each( function(sp) {
                		min_prize += sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000} );
                    }, this );                        
                }else{
                    Math.cl(min_sp, _n).each( function(sp) {
                        min_prize += sp.reduce( function(a,b){return (a*10000)*(b*10000)/100000000} );
                    }, this );                    
                }
			}, this );
		} else {  //多串(不去重)
			var _n = parseInt(gg_name);
			var mz = this.typeMap[gg_name].map(function(x){
				return parseInt(x);
			});
			var min_hit = Math.min.apply(Math, mz);
            dan_sp = dan_sp ? (typeof(dan_sp) == 'string' ? dan_sp.split(',') : dan_sp) : [];
			min_prize = this.postMsg('msg_get_split_info', min_sp,_n,min_hit,mz,true,dan_sp).data.value/2;
		}
		if (gg_name != '单关' || this.C('dggp')) {
			min_prize *= 2;
		}
		return min_prize = new_round ? this.newRound(min_prize) : (+min_prize).toFixed(2);
	},
	/**
	 * 4舍6入5进双
	 */
	newRound : function(n) {
		if (/\d+\.\d\d5/.test(n.toString())) {
			var match_ret = n.toString().match(/\d+\.\d(\d)/);
			if (match_ret[1] % 2 == 1) {
				return parseFloat(n).toFixed(2);
			} else {
				return match_ret[0];
			}
		} else {
			return parseFloat(n).toFixed(2);
		}
	}

} );


/*
* 功能: 计算多串的胆拖方案的拆分与奖金
*/
Class('DcPrix', {
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
            value: sum*2//奖金
        }; 
        return ret
	}
} );

