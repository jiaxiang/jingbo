//框架高度自适应
//document.domain = location.host.split('.').slice(-2).join('.');
//alert(document.domain);
//window.onload = function (){
//    autoHeight();
//};
function autoHeight(){
    var h, div, ws;
    h = Math.max(document.body.clientHeight,document.documentElement.clientHeight);   
    try{
        ws = $("iframe",parent.window.document);
        for (var i =  ws.length; i--;) {
            if (ws[i].contentWindow === window ||ws[i].contentWindow === self) {
                ws[i].style.height = '400px';
				h = Math.max(document.body.clientHeight,document.documentElement.clientHeight);
                ws[i].style.height = (h+16)+'px';			
                break;
            }
        }            
    }catch(e){}
 
};