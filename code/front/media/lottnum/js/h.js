(function(){
	var c = {
	siteid:"32ee1b68bd85cc237c55bdf6314d909a",
	domain:["jingbo365.com"],
	listener:[],
	_js_path:"tongji.baidu.com/hm-web/js/",
	icon:'',
	bridge:false,
	clickTracker:false,
	pageAlign:-1,
	hour:1800000,
	_curh:0,
	year:31536000000,
	se:[[1,'baidu.com','(word|wd)',1,'news,tieba,zhidao,mp3,image,video,hi,baike,wenku,open,jingyan'],[2,'google.com','q',0,'tbm=isch,tbm=vid,tbm=nws,tbm=blg'],[3,'google.cn','q',0,'tbm=isch,tbm=vid,tbm=nws,tbm=blg'],[4,'sogou.com','query',1,'news,mp3,pic,v,zhishi,blogsearch'],[5,'zhongsou.com','w',1,'p,z,gouwu,bbs,mp3'],[6,'search.yahoo.com','p',1,'news,images,video'],[7,'one.cn.yahoo.com','p',1,'news,image,music'],[8,'soso.com','w',1,'image,video,music,sobar,wenwen,news,life,baike,blog'],[9,'114search.118114.cn','kw',0,''],[10,'search.live.com','q',0,''],[11,'youdao.com','q',1,'image,news,gouwu,mp3,video,blog,reader'],[12,'gougou.com','search',1,'movie,mp3,book,soft,game'],[13,'bing.com','q',2,'images,videos,news']],version:"1.0",swBlacklist:["cpro.baidu.com"],iconLink:"http://tongji.baidu.com/hm-web/welcome/ico",apiName:"",rcv:"hm.baidu.com/hm.gif",allowDomain:"baidu.com",hmmd:"hmmd",hmpl:"hmpl",hmkw:"hmkw",hmci:"hmci",hmsr:"hmsr",_n:(new Date).getTime(),isSent:0,clicksMaxTime:6E5,clicksMaxLength:10,clicksUrlMaxLength:1024,clicksInclueEmbedObject:1,maxInt:2147483647,_t:["cc","cf","ci","ck","cl","cm","cp","cw","ds","ep","et","fl","ja","ln","lo","lt","nv","rnd","sb","se","si","st","su","sw","sse"]},D=document,L=D.location,R=D.referrer,W=window,E=encodeURIComponent;function on(a,b,d){b=b.replace(/^on/i,"").toLowerCase();a.attachEvent?a.attachEvent("on"+b,function(b){d.call(a,b)}):a.addEventListener&&a.addEventListener(b,d,!1)}function G(a){return D.getElementById(a)||null}function Tracker(){this.tags={};this.clicks=[];this.getTracker()}Tracker.prototype={getValue:function(a,b){var d=b.match(RegExp("(^|&|\\?)"+a+"=([^&]*)(&|$|#)"));return d?d[2+(a.indexOf("(")>-1?1:0)]:""},swf:function(a,b,d,e,g){var f='<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'+d+'" height="'+e+'" id="'+a+'" align="middle">';f+='<param name="allowscriptaccess" value="always">';f+='<param name="quality" value="high">';f+='<param name="movie" value="'+b+'">';f+='<param name="flashvars" value="'+g+'">';f+='<embed src="'+b+'" flashvars="'+g+'" quality="high" width="'+d+'" height="'+e+'" name="'+a+'" align="middle" allowscriptaccess="always" wmode="window" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">';f+="</object>";return f},setCookie:function(a,b,d,e,g){var f=new Date;f.setTime(f.getTime()+g);D.cookie=a+"="+b+(g==null?"":"; expires="+f.toGMTString())+"; domain="+d+(e?"; path="+e:"")},getCookie:function(a){if(a=RegExp("(^| )"+a+"=([^;]*)(;|$)").exec(D.cookie))return a[2]||"";return""},getDs:function(){this.tags.ds=W.screen.width+"x"+W.screen.height},getCl:function(){this.tags.cl=W.screen?W.screen.colorDepth+"-bit":""},getSb:function(){this.tags.sb="0";try{external.twGetVersion(external.twGetSecurityID(window))&&external.twGetRunPath.toLowerCase().indexOf("360se")>-1&&(this.tags.sb=17)}catch(a){}},getCk:function(){this.tags.ck=navigator.cookieEnabled?"1":"0"},getFl:function(){if(navigator.plugins&&typeof navigator.plugins["Shockwave Flash"]=="object"){var a=navigator.plugins["Shockwave Flash"].description;if(a&&(!navigator.mimeTypes||!navigator.mimeTypes["application/x-shockwave-flash"]||navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin))this.tags.fl=a.replace(/^.*\s+(\S+)\s+\S+$/,"$1")}else if(W.ActiveXObject)try{if(a=new ActiveXObject("ShockwaveFlash.ShockwaveFlash"))(version=a.GetVariable("$version"))&&(this.tags.fl=version.replace(/^.*\s+(\d+),(\d+).*$/,"$1.$2"))}catch(b){}},getJa:function(){this.tags.ja=navigator.javaEnabled()?"1":"0"},getLn:function(){var a=navigator;this.tags.ln=(a.systemLanguage?a.systemLanguage:a.browserLanguage?a.browserLanguage:a.language?a.language:a.userLanguage?a.userLanguage:"-").toLowerCase()},getSi:function(){this.tags.si=this.siteid},getSu:function(){var a=R;this.tags.su=a?a:""},samDom:function(a,b){if(b.constructor==String){var a=a.replace(/:\d+/,""),b=b.replace(/:\d+/,""),d=a.indexOf(b);return d>=0&&d+b.length==a.length?!0:!1}else for(var d=b.length,e=0;e<d;e++){var g=b[e],f=g.length,h=a.indexOf(g);if(h>=0&&h+f==a.length)return g}return a},samDir:function(a,b){if(b.constructor==String){var d=a.indexOf(b);return d>=0&&d<=8?!0:!1}else{for(var e=b.length,g=0;g<e;g++){var f=b[g];if(f.indexOf("/")>-1&&(d=a.indexOf(f),d>=0&&d<=8))return f}return!1}},isRight:function(){for(var a=this.domain,b=a.length,d=0;d<b;d++){var e=a[d];if(e.indexOf("/")>-1){if(this.samDir(L.href,e))return!0}else if(this.samDom(L.hostname,e))return!0}return!1},getDom:function(){return this.samDom(L.hostname,this.domain)},getPath:function(){var a=this.samDir(L.href,this.domain);return a?a.replace(/^(https?:\/\/)?[^\/]+(\/.*)/,"$2")+"/":"/"},getSt:function(){var a=R;if(a){for(var b=function(a){for(var b=0,d=a[3]==2?a[1]+"/":"",e=a[3]==1?"."+a[1]:"",a=a[4].split(","),f=0;f<a.length;f++)if(a[f]!==""&&document.referrer.indexOf(d+a[f]+e)>-1){b=f+1;break}return b},d=function(a){if(/google.(com|cn)/.test(document.referrer)&&/(%25[0-9a-fA-F]{2}){2}/.test(a))try{a=decodeURIComponent(a)}catch(b){}if(/sogou.com/.test(document.referrer)&&/%u[0-9a-fA-F]{4}/.test(a))try{a=unescape(a)}catch(d){}for(var e=0,f=c.swBlacklist.length;e<f;e++)document.referrer.indexOf(c.swBlacklist[e])>-1&&(a="");return a},e=0;e<c.se.length;e++)if(RegExp(c.se[e][1]).test(document.referrer)){var g=this.getValue(c.se[e][2],document.referrer);if(g){this.tags.se=c.se[e][0];this.tags.sse=b(c.se[e]);this.tags.sw=d(g);this.tags.st="2";return}}b=!1;if(this.isRight()){d=this.domain;g=d.length;for(e=0;e<g;e++){var f=d[e];f.indexOf("/")>-1?this.samDir(a,f)&&(b=!0):this.samDom(a.replace(/^(http|https):\/\//i,"").split("/")[0],f)&&(b=!0)}}else b=this.samDir(a,L.hostname);this.tags.st=b?c._n-c._curh>this.hour?"1":"4":"3"}else this.tags.st=c._n-c._curh>this.hour?"1":"4"},getCmpwi:function(){var a=L.href;this.tags.cm=this.getValue(c.hmmd,a)||"";this.tags.cp=this.getValue(c.hmpl,a)||"";this.tags.cw=this.getValue(c.hmkw,a)||"";this.tags.ci=this.getValue(c.hmci,a)||"";this.tags.cf=this.getValue(c.hmsr,a)||""},getNvLt:function(){var a="";c._curh=this.getCookie("Hm_lpvt_"+this.siteid)||0;this.getSt();a+=this.tags.st!="4"||!c._curh?1:0;this.setCookie("Hm_lpvt_"+this.siteid,c._n,this.getDom(),this.getPath());var b=this.getCookie("Hm_lvt_"+this.siteid);a=="1"&&this.setCookie("Hm_lvt_"+this.siteid,c._n,this.getDom(),this.getPath(),this.year);this.tags.cc=this.getCookie("Hm_lpvt_"+this.siteid)==c._n?"1":"0";this.tags.lt=b?Math.round((b-0)/1E3):"";this.tags.nv=a},getRnd:function(){this.tags.rnd=Math.round(Math.random()*c.maxInt)},getTop:function(){this.tags.lo=typeof _bdhm_top=="number"?"1":"0"},JTQ:function(a){for(var b=[],d=c._t,e=0,g=d.length;e<g;e++){var f=d[e],h=a[f];switch(f){case "se":(f=h?f+"="+E(h):!1)&&b.push(f);break;case "sse":(f=typeof h!="undefined"?f+"="+E(h):!1)&&b.push(f);break;case "sw":(f=h?f+"="+E(h):!1)&&b.push(f);break;default:f=a[f]?f+"="+E(a[f]):f+"=",b.push(f)}}return b.join("&")},getPar:function(){this.getNvLt();this.getCmpwi();this.getSu();this.getSi();this.getLn();this.getJa();this.getFl();this.getCk();this.getCl();this.getDs();this.getSb();this.getTop();this.tags.et="0";this.tags.ep=""},protocol:function(){return L.protocol=="https:"?"https://":"http://"},init:function(){try{this.initBridge(),DurationController.init(),this.getPar(),this.postData(),this.addLocLis(),this.addIcon(),this.addEvtLis(),this.adDocEvt()}catch(a){var b=[];b.push("si="+this.siteid);b.push("m="+E(a.message));b.push("n="+E(a.name));(new Image(1,1)).src=this.protocol()+this.rcv+"?"+b.join("&")}},initBridge:function(){if(this.bridge){var a=this.getH(this.siteid)%1E3;D.write(unescape("%3Cscript charset='utf-8' src='"+this.protocol()+"rqiao.baidu.com/site/"+a+"/"+this.siteid+"/b.js' type='text/javascript'%3E%3C/script%3E"))}},getH:function(a){for(var b=5381,d=a.length,e=0;e<d;e++)var g=new Number(a.charCodeAt(e)),b=(b*33+g)%4294967296;b>2147483648&&(b-=2147483648);return b},adDocEvt:function(){this.clickTracker&&(on(D,"mouseup",this.trackClickHandler()),on(W,"beforeunload",this.sendClickHandler()),setInterval(this.sendClickHandler(),c.clicksMaxTime));on(D,"click",this.evHandle());on(W,"beforeunload",this.sendDurationHandler())},evHandle:function(){var a=this;return function(b){var b=b||W.event,d=b.clientX+":"+b.clientY,e=b.srcElement||b.target,g=e.getAttribute("HM_fix");if(g&&g==d)e.removeAttribute("HM_fix");else if(d=a.listener.length,d>0){for(g={};e&&e!=D.body;)e.id&&(g[e.id]=""),e=e.parentNode;for(e=0;e<d;e++){var f=a.listener[e];if(g.hasOwnProperty(f.id))a.tags.et="1",a.tags.ep="{id:"+f.id+",eventType:"+b.type+"}",a.postData()}}}},ie:function(){return/msie (\d+\.\d)/i.test(navigator.userAgent)},trackClickHandler:function(){var a=this;return function(b){b=a.getClickData(b);if(""!=b){var d=(a.protocol()+a.rcv+"?"+a.JTQ(a.tags).replace(/ep=[^&]*/,"ep="+encodeURIComponent("["+b+"]"))).length;d+(c.maxInt+"").length>c.clicksUrlMaxLength||(d+encodeURIComponent(a.clicks.join(",")+(a.clicks.length?",":"")).length+(c.maxInt+"").length>c.clicksUrlMaxLength&&a.sendClickHandler()(),a.clicks.push(b),(a.clicks.length>=c.clicksMaxLength||/t:a/.test(b))&&a.sendClickHandler()())}}},getClickData:function(a){a=a||W.event;if(!c.clicksInclueEmbedObject){var b=a.target||a.srcElement,d=b.tagName.toLowerCase();if(d=="embed"||d=="object")return""}this.ie()?(b=Math.max(D.documentElement.scrollTop,D.body.scrollTop),d=a.clientX+Math.max(D.documentElement.scrollLeft,D.body.scrollLeft),b=a.clientY+b):(d=a.pageX,b=a.pageY);var e=W.innerWidth||document.documentElement.clientWidth||document.body.offsetWidth;switch(this.pageAlign){case 1:d-=e/2;break;case 2:d-=e}d="{x:"+d+",y:"+b+",";b=a.target||a.srcElement;a=this.getAncestor(b,"a",!0);d+=a?"t:a,u:"+encodeURIComponent(a.href)+"}":"t:b}";return d},getAncestor:function(a,b,d){for(a=d?a:a.parentNode;a&&a.tagName;)if(a.tagName.toLowerCase()==b)return a;else a=a.parentNode;return!1},sendClickHandler:function(){var a=this;return function(){if(a.clicks.length!=0)a.tags.et=2,a.tags.ep="["+a.clicks.join(",")+"]",a.postData(),a.clicks=[]}},sendDurationHandler:function(){var a=this;return function(){a.tags.et=3;a.tags.ep=DurationController.getPageDuration()+","+DurationController.getFocusDuration();a.postData()}},postData:function(){this.getRnd();var a=new Image(1,1);a.onload=function(){c.isSent=1};a.src=this.protocol()+this.rcv+"?"+this.JTQ(this.tags)},addIcon:function(){if(this.icon!=""){var a;a=this.icon.split("|");var b=this.iconLink+"?s="+this.siteid,d=a[0]+"."+a[1];switch(a[1]){case "swf":a=this.swf("HolmesIcon"+c._n,d,a[2],a[3],"s="+b);break;case "gif":a='<a href="'+b+'" target="_blank"><img border="0" src="'+d+'" width="'+a[2]+'" height="'+a[3]+'"></a>';break;default:a='<a href="'+b+'" target="_blank">'+a[0]+"</a>"}D.write(a)}},addEvtLis:function(){var a=this.listener.length;if(a>0)for(var b=0;b<a;b++){var d=this.listener[b],e=G(d.id);e&&on(e,d.eventType,this.evtH())}},evtH:function(){var a=this;return function(b){b=b||W.event;(b.target||b.srcElement).setAttribute("HM_fix",b.clientX+":"+b.clientY);a.tags.et="1";a.tags.ep="{id:"+this.id+",eventType:"+b.type+"}";a.postData()}},getTracker:function(){for(var a in c)a.indexOf("_")!=0&&(this[a]=c[a]);c.apiName==""&&typeof window["hm_loaded_"+c.siteid]=="undefined"&&(window["hm_loaded_"+c.siteid]=!0,this.init())},addLocLis:function(){var a=L.hash.substring(1),b=RegExp(this.siteid),d=R.indexOf(c.allowDomain)>-1?!0:!1;a&&b.test(a)&&d&&(b=D.createElement("script"),b.setAttribute("charset","utf-8"),b.setAttribute("type","text/javascript"),b.setAttribute("src",this.protocol()+c._js_path+this.getValue("jn",a)+"."+this.getValue("sx",a)+"?"+this.tags.rnd),D.getElementsByTagName("head")[0].appendChild(b))}};var DurationController={pageBeginTime:0,currentFocusBeginTime:0,previousFocusDuration:0,hasFocus:!1,init:function(){this.handleEvents();this.currentFocusBeginTime=this.pageBeginTime=(new Date).getTime()},getPageDuration:function(){return(new Date).getTime()-this.pageBeginTime},getFocusDuration:function(){return(new Date).getTime()-this.currentFocusBeginTime+this.previousFocusDuration},eventsHandler:function(){var a=this;return function(b){var b=b||window.event,d=b.srcElement||b.target;if(b.type=="focus"&&d==window||b.type=="focusin")a.hasFocus=!0,a.currentFocusBeginTime=(new Date).getTime();else if(b.type=="blur"&&d==window||b.type=="focusout")a.hasFocus=!1,a.previousFocusDuration+=(new Date).getTime()-a.currentFocusBeginTime,a.currentFocusBeginTime=(new Date).getTime()}},handleEvents:function(){typeof document.onfocusin=="object"?(document.attachEvent("onfocusin",this.eventsHandler()),document.attachEvent("onfocusout",this.eventsHandler())):(window.addEventListener("focus",this.eventsHandler(),!1),window.addEventListener("blur",this.eventsHandler(),!1))}},hm=new Tracker;c.apiName!=""&&(W[c.apiName]=Tracker);})();
