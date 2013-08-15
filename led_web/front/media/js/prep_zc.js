Class.C('buy_type', 1);
Class.C('lot-ch-name', '胜负彩');
Class.C('isEnd', false);
Class.C('price', 2);
Class.C('play_name', 'pt');
Class.C('min-rengou', .05);
Class.C('isyt', true);
Class.extend('getPlayText', function (){
    return this.getLotInfo().name+ ['代购','合买'][Class.C('buy_type')];
});
// 自动生成playid
Class.extend('getPlayId', function (play_name){
    var lotid = this.getInt(this.get('#lotid').val());
    switch(lotid){
        case 10000:
            return 43
        case 1:
            return Class.C('buy_type') == 0 ? 2 : 1
        default:
            return 1;
    }
});
Class('Application',{
    ready: true,
    use: 'tabs,dataInput',
    index:function (){
        this.lib.Dlg();
        this._addTabs();
        this.lib.HmOptions();
        this.lib.BuySender();
        this._setBuyFlow();
        this.lib.SfcYtChoose();
        setTimeout((function() {
            var x1 = Math.max(document.documentElement.scrollTop = document.body.scrollTop), x2 = this.get('#vsTable').getXY().y;
            this.fx(function (f){
                document.documentElement.scrollTop = document.body.scrollTop = f(x1,x2)
            },{end: function (){
                this.get('#prevInput :text').eq(0).doProp('select');
            }})            
        }).proxy(this),200)
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
               if (Class.config('play_name') == 'sc' && y.postMsg('msg_check_sc_err').data) {
                   return false// 上传额外检测
               }else if (data = O.postMsg('msg_get_list_data').data) {//索取要提交的参数
                    if (data.msg ) {
                        O.alert(data.msg)
                    }else if (data.zhushu === 0 ) {
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
        //购买方式
        //购买方式
        var tipTpl =  '<h5 style="{1}">代购：</h5>'+
            '是指方案发起人自己一人全额认购方案的购彩形式。若中奖，奖金也由发起人一人独享。<br/><br/>'+
            '<h5 style="{2}">合买：</h5>'+
            '由多人共同出资购买同一个方案，如果方案中奖，则按投入比例分享奖金。合买能够实现利益共享、风险共担，是网络购彩的一大优势。'
        this.get('#all_form em.i-qw').tip(false, 5, function (){
            var hm = this.C('buy_type') == 1;
            return tipTpl.format(hm? '' : 'color:red', hm?'color:red':'')
        });

        Class.config('buy_type', 1 );
        this.get('#ishm').val(1);
    }
});