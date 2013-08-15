Class.C('buy_type', 1);
Class.C('lot-ch-name', '胜负彩');
Class.C('isEnd', false);
Class.C('price', 2);
Class.C('play_name', 'pt');
Class.C('min-rengou', .1);
Class.C('isbx', true);
Class.extend('getPlayText', function (play_name){
    var map, map2;
    map = {
        'pt': '普通',
        'lr': '单式',
        'sc': '单式'
    };
    return map[Class.C('play_name')] + ['代购','合买'][Class.C('buy_type')];
});
// 自动生成playid
Class.extend('getPlayId', function (play_name){
    return Class.C('buy_type') == 0 ? 2 : 1
});
Class.extend('qUrl', function (key){
    vals = location.search.match(key+'=([^=&]+)')
    return vals ? vals[1] : ''
});
Class('Application',{
    ready: true,
    use: 'tabs,dataInput',
    index:function (){
        this.lib.Dlg();
        this.C('pid', this.qUrl('pid'));
        this.lib.BuySender();
        this._setBuyFlow();
        this.lib.SfcChoose();
    },
   _setBuyFlow: function (){
       this.get('#buy_dg,#buy_hm').click(function (e, O){
           var data, msg;
           O.postMsg('msg_login', function (){
               if (Class.config('play_name') == 'sc' && y.postMsg('msg_check_sc_err').data) {
                   return false// 上传额外检测
               }else if (data = O.postMsg('msg_get_list_data').data) {//索取要提交的参数
                    if (data.msg ) {
                        O.alert(data.msg)
                    }else{
                        delete data.msg;
                        O.postMsg('msg_buy_hm', data)                
                    }                            
               }                   
           });
           e.end();
           return false;
       }) 
    }
});