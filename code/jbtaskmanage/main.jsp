<%@ page contentType="text/html; charset=utf-8" isELIgnored="false"%>
<%@ page import="java.util.ArrayList,java.util.List,java.lang.StringBuffer,com.fwprj.common.user.pojos.Pri;"%>
<%
	List list = (ArrayList)request.getAttribute("level1");
%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">

<TITLE>出票集成系统</TITLE>
<link rel="stylesheet" type="text/css" href="extjs/resources/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="css/frame.css" />
</HEAD>
<body scroll="no" id="docs">
  <div id="loading-mask" style=""></div>
  <div id="loading">
    <div class="loading-indicator"><img src="images/extanim32.gif" width="32" height="32" style="margin-right:8px;" align="absmiddle"/>Loading...</div>
  </div>
<script type="text/javascript" src="extjs/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="extjs/ext-all.js"></script>
<script type="text/javascript" src="js/frame.js"></script>
<script type="text/javascript">
Ext.onReady(function(){

	function onClick(node,event){
		if(node.isLeaf()){
            event.stopEvent();
            var tab = Ext.getCmp('tab1');
			//tab.getUpdater().update(node.attributes.url);
			Ext.get("mainFrame").dom.src = node.attributes.url;
    		tab.setTitle(node.text);
         }
	}

<%	StringBuffer sb =  new StringBuffer();
	for(int i=0,size=list.size();i<size;i++){
		Pri pri = (Pri)list.get(i);
%>
		var tree<%=pri.getId()%> = new MenuPanel('<%=pri.getId()%>','<%=pri.getPriname()%>');
		tree<%=pri.getId()%>.on("click",onClick);
		tree<%=pri.getId()%>.root.expand();
<%		sb.append("tree").append(pri.getId()).append(",");
	}
	if(sb.length() > 1)	sb.setLength(sb.length()-1);
%>
	
	var tabs = new Ext.TabPanel({
		region:'center',
		deferredRender:false,
		activeTab:0,
		items:[{
			id:'tab1',
			contentEl:'center',
			title: 'Welcome',
			//closable:true,
			autoScroll:true,
			//autoLoad:{url:'ajax1.htm', scripts:true}
			html:'<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="ajax1.htm" id="mainFrame"></iframe>'
		}]
	});

	var viewport = new Ext.Viewport({
		layout:'border',
		items:[
			new Ext.BoxComponent({
				region:'north',
				el:'north-div',
				height:26
				}),
		win = {	id: 'menu',
                title: '系统菜单',
					region:'west',
		contentEl:'west-div',
                width:250,
                height:400,

				collapsible: false,

                layout:'accordion',
                border:false,

                items: [                    
					<%=sb.toString()%>
                ]
				},
			tabs
		]
	});
	
	setTimeout(function(){
		Ext.get('loading').remove();
		Ext.get('loading-mask').fadeOut({remove:true});
		}, 250);
});
</script>

<div id="north-div"><a href="logout.do" class="frame-logout">退出</a><div class="frame-title">出票集成系统</div>
	<div id='toolbar-div'></div>
</div>

<div id="west-div"></div>

<div id='center'><div id='center-div'></div></div>

</body>
</HTML>


