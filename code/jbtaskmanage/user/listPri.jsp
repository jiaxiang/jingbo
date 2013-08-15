<%@ page contentType="text/html; charset=utf-8" isELIgnored="false"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" prefix="fn" %>
<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/custom" prefix="f"%>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Customizing TreePanel</title>
		<link rel="stylesheet" type="text/css" href="/extjs/resources/css/ext-all.css" />
		<script type="text/javascript" src="/extjs/adapter/ext/ext-base.js"></script>
		<script type="text/javascript" src="/extjs/ext-all.js"></script>
		<script type="text/javascript" src="/js/ColumnTree.js"></script>		
		<script type='text/javascript'>
Ext.onReady(function(){
    var tree = new Ext.tree.ColumnTree({
        el:'tree-ct',
        width:952,
        autoHeight:true,
        rootVisible:false,
        autoScroll:true,
		//enableDD:true,
        title: '功能列表',
		/*
			tbar: [{
            iconCls:'add-feed',
            text:'添加新功能',
            handler: this.showWindow,
            scope: this
        },{
            id:'delete',
            iconCls:'delete-icon',
            text:'删除',
            handler: function(){
                var s = this.getSelectionModel().getSelectedNode();
                if(s){
                    this.removeFeed(s.attributes.url);
                }
            },
            scope: this
        }],
		*/
        columns:[{
            header:'功能名称',
            width:300,
            dataIndex:'text'
        },{
            header:'链接地址',
            width:500,
            dataIndex:'url'
        },{
            header:'操作',
            width:150,
            dataIndex:'text'
        }],
		
		editUrl:'<%=request.getContextPath()%>/user/preEditPri.do?id=',
		deleteUrl:'<%=request.getContextPath()%>/user/deletePri.do?id=',
		
        loader: new Ext.tree.TreeLoader({
            dataUrl:'listPri.do',
            uiProviders:{
                'col': Ext.tree.ColumnNodeUI
            }
			
        }),
        root: new Ext.tree.AsyncTreeNode({
            text:'功能列表'
        })
    });
	tree.render();
});
		</script>

    <link rel="stylesheet" type="text/css" href="css/column-tree.css" />
</head>
<body>
<br/>
<div width="100%" style="padding-left:20px;">
<div id="tree-ct"></div>
</div>
<div style="padding-left:20px;padding-top:20px">
		<input type="button" name="add" onclick="location.href = '<%=request.getContextPath()%>/user/preEditPri.do';" value="添加"  />
</div>
<br /><br /><br /><br /><br />
</body>
</html>
