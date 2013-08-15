Class.C('buy_type', 0);
Class.C('lot-ch-name', '胜负彩');
Class.C('isEnd', false);
Class.C('price', 2);
Class.C('play_name', 'pt');
Class.C('min-rengou', .05);
Class.C('isds', true);
Class.C('shownowtime', true);
Class.C('play_name', 'sc');
Class.extend('getPlayText', function (play_name){
    return '单式' + ['代购','合买'][Class.C('buy_type')];
});
// 自动生成playid
/*Class.extend('getPlayId', function (play_name){
    var ticket_type = this.get('#ticket_type').val()
    if (ticket_type == '10000') {
        return 44
    }else if(ticket_type == '1'){//胜负使用playid识别合买与代购
        return Class.C('buy_type') == 0 ? 4 : 3;
    }else{
        return  3
    }    
});*/
Class('Application',{
    ready: true,
    use: 'tabs,dataInput',
    index:function (){
        this.lib.Dlg();
        this._addTabs();
        this.lib.HmOptions();
        this.lib.BuySender();
        this._setBuyFlow();
        this.lib.DsUpload({
            
        });
    },
   _setBuyFlow: function (){
       this.get('#buy_dg,#buy_hm').click(function (e, O){
           var data, msg;
           var lot = O.getLotInfo();
            if (Yobj.C('isEnd')) {
                Yobj.alert('您好，'+lot.name+Yobj.C('expect')+'期已截止！');
                return false
            }
           O.postMsg('msg_login', function (){
               if (O.postMsg('msg_check_sc_err').data) {
                   return false// 上传额外检测
               }else if (data = O.postMsg('msg_get_list_data').data) {//索取要提交的参数
                    if (data.zhushu === 0 ) {
                        O.alert('您好，胜负彩复式选择要满足14个不同场次选号才能投注！')
                    }else if(data.beishu === 0){
                        O.alert('对不起，请您至少要购买 <strong class="red">1</strong> 倍！')                    
                    }else if(data.totalmoney <= 0){
                        O.alert('发起方案的金额不能为 <strong class="red">0</strong> ！')                       
                    }else{
                        O.C('buy_type') == 0 ? O.postMsg('msg_buy_dg', data) : O.postMsg('msg_buy_hm', data)                
                    }                            
               }                   
           });
           e.end();
           return false;
       }) 
    },
    _addTabs: function (){
        var buyTabs = this.lib.Tabs({
            items: '#all_form label',
            contents: '#dd1,#dd2',
            focusCss: 'b'
        });
		
        //购买方式
        this.get('#all_form em.i-qw').tip(false, 5, '<h5>代购：</h5>'+
            '是指方案发起人自己一人全额认购方案的购彩形式。若中奖，奖金也由发起人一人独享。<br/><br/>'+
            '<h5>合买：</h5>'+
            '由多人共同出资购买同一个方案，如果方案中奖，则按投入比例分享奖金。合买能够实现利益共享、风险共担，是网络购彩的一大优势。');
        buyTabs.onchange = function (a, b, c){
			 Class.config('buy_type', b );
             this.get('#ishm').val(b==1? 1 : 0);
             this.get('#sc2').prop('disabled', b==0);
			 if (b==0) {
                this.get('#sc1').prop('checked', true);
                this.get('#upfile').prop('disabled', false);
             }
			 
             !c && this.moveToBuy()
             this.get('#all_form span.r').html(['由购买人自行全额购买彩票','由多人共同出资购买彩票'][b]);
        };
        buyTabs.focus(1);
		if (this.get('#isprocess').val() != '1') {//对阵未确定
		    Y.get('#dd1').hide();
            Y.get('#upfile').prop('disabled', true);
            Y.get('#all_form label').one(0).disabled = true;
            this.get('#sc1').prop('disabled', true);
            this.get('#sc2').prop('checked', true);
        }else{
			 this.get('#sc1,#sc2').click(function (e, Y){
                Y.get('#upfile').prop('disabled', this.id == 'sc2');
                Y.get('#all_form label').one(0).disabled = this.id == 'sc2'
            });            
        }
    }
});
