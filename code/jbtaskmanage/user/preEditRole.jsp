<%@ page contentType="text/html; charset=utf-8" isELIgnored="false"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/fmt" prefix="fmt" %>
<%@ taglib uri="http://java.sun.com/jsp/jstl/functions" prefix="fn" %>
<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/custom" prefix="f"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="keywords" content="keyword1,keyword2,keyword3"/>
    <meta http-equiv="description" content="Tradeshows Organizer List"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>添加/编辑角色</title>
	<link rel="stylesheet" type="text/css" href="/extjs/resources/css/ext-all.css" />
	<link rel="stylesheet" type="text/css" href="/css/frame.css" />
	<link type="text/css" rel="stylesheet" href="<%=request.getContextPath()%>/user/css/common-style.css">
	<link rel="stylesheet" type="text/css" href="<%=request.getContextPath()%>/user/css/style.css" />
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/common.js"></script>
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/pagedData.js"></script>
	<script type='text/javascript' src="<%=request.getContextPath()%>/user/js/role.js"></script>
	<script type="text/javascript" src="/extjs/adapter/ext/ext-base.js"></script>
	<script type="text/javascript" src="/extjs/ext-all.js"></script>
	<script type="text/javascript" src="/js/TreeCheckedNodeUI.js"></script>
	<script type='text/javascript'>
Ext.onReady(function(){
    var tree = new Ext.tree.TreePanel({
        el:'tree-ct',
        width:952,
        autoHeight:true,
        rootVisible:false,
        autoScroll:true,
        title: '设置权限',
		checkModel: 'cascade',   //对树的级联多选
		onlyLeafCheckable: false,//对树所有结点都可选
		
        loader: new Ext.tree.TreeLoader({
            dataUrl:'/user/getRolePriTree.do?id=${role.id}&ui=che&iconCls=icon-cls',
			uiProviders:{
                'che': Ext.ux.TreeCheckNodeUI
            }
        }),
        root: new Ext.tree.AsyncTreeNode({
            text:'功能列表'
        })
    });
	tree.render();
	//tree.getLoader().load(tree.getRootNode(),function(){alert('aaa');});
});
		</script>

</head>

<body>
<form id="iform" method="post" action="<%=request.getContextPath()%>/user/createOrUpdateRole.do" onsubmit="return inputcheck();"> 
<c:if test="${not empty role.id}"><input name="id" type="hidden" value="${role.id}"/></c:if>
<div width="100%" style="padding-left:20px;padding-top:20px;">
<table  border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <th width="30%" scope="row">角色名称：</th>
    <td width="70%"><input name="rolename" type="text" value="${role.rolename}" size="100"/></td>
  </tr>
  <tr>
    <th width="30%" scope="row">描述：</th>
    <td width="70%"><input name="description" type="text" value="${role.description}" size="100"/></td>
  </tr>
  <tr>
    <th width="30%" scope="row">是否可用：</th>
    <td width="70%">
    	<c:choose>
    		<c:when test="${role.isAble==1}">
    			<input name="isAble" type="radio" value="1" checked="checked"/>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			<input name="isAble" type="radio" value="0"/>否
    		</c:when>
    		<c:otherwise>
    			<input name="isAble" type="radio" value="1"/>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			<input name="isAble" type="radio" value="0" checked="checked"/>否
    		</c:otherwise>
    	</c:choose>
    </td>
  </tr>
</table>
<br/>
<div id="tree-ct"></div>
<br/><br/>
<p align="center"><input name="save" type="submit" value="保存"/> <input name="reset" type="reset" value="重置" />
</div>

</form>
</body>
</html>

