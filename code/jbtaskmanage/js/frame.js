MenuPanel = function(id,title){
	MenuPanel.superclass.constructor.call(this,{
		//id:'menu',
		//region:'west',
		//contentEl:'west-div',
		title:title,
		split:true,
		width: 240,
		minSize: 175,
		maxSize: 400,
		collapsible: true,
		margins:'0 0 0 0',
		rootVisible:false,
		lines:false,
        autoScroll:true,
		root: new Ext.tree.AsyncTreeNode({
			text: '文件夹',
			allowDrag:false,
			allowDrop:false,
			expanded:true
		}),
		loader: new Ext.tree.TreeLoader({
            dataUrl:'showMenu.do?id=' + id
        })
	});
};

Ext.extend(MenuPanel, Ext.tree.TreePanel, {});