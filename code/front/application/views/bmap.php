<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=gbk" />
    <title>Baidu Map V1.2</title>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2&services=true">
        <!-- add baidu map api -->
    </script>
</head>
<body>
    <div id="container" style="width: 600px; height: 400px;">
    </div>
</body>
</html>
<script type="text/javascript">
    var map = new BMap.Map("container");                    // new Map
    var point = new BMap.Point(116.397128, 39.916527);        // Location, （经度, 纬度）
    map.centerAndZoom(point, 15);                           // show Map

    // 添加缩放功能
    map.enableScrollWheelZoom();
    map.enableKeyboard();
</script>