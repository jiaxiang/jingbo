 //联盟数据统计
function     GetQueryString(name)
{
     var     reg     =   new   RegExp("(^|&)"+     name     +"=([^&]*)(&|$)");
     var     r     =     window.location.search.substr(1).match(reg);
     if     (r!=null)   return     unescape(r[2]);   return   null;
}
function un_Request() {
  var un_iframe=document.createElement("iframe");
  un_iframe.style.display='none';
  var u_cpid=GetQueryString('u_cpid');
  var u_aid = GetQueryString('u_aid');
  if(u_aid != null && u_cpid != null)
  {
    var p = '?u_cpid='+u_cpid+'&u_aid='+u_aid;
    var u_ref = GetQueryString('u_ref');
    if(u_ref != null)
    {
      p += '&u_ref='+u_ref;
    }
    un_iframe.src='http://union..com/pages/cooperate/cooperate.php'+p;
    var un_body=document.getElementsByTagName("body")[0];
    un_body.appendChild(un_iframe);
  }
}
window.onload=function(){
    //un_Request();
}
//联盟数据统计结束

$.ajax({
		   type: "POST",
		   url: "some.php",
		   data: "name=John&location=Boston",
		   success: function(msg){
		     alert( "Data Saved: " + msg );
		   }
		}); 