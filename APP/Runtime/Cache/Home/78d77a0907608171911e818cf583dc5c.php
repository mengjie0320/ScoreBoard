<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>按起终点经纬度规划路线</title>
    <link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
    <style type="text/css">
        #panel {
            position: fixed;
            background-color: white;
            max-height: 90%;
            overflow-y: auto;
            top: 10px;
            right: 10px;
            width: 280px;
        }
    </style>
    <script type="text/javascript" src="http://webapi.amap.com/maps?v=1.3&key=b1edc59452a28f459105925d278c1cdb&plugin=AMap.Walking"></script>
    <script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
</head>
<body>
	<!--<p id="d" value="<?php echo ($a); ?>"><?php echo ($a); echo ($b); ?></p>-->
		<p id="a" hidden ><?php echo ($a); ?></p>
		<p id="b" hidden ><?php echo ($b); ?></p>
<div id="container"></div>
<div id="panel"></div>
<script type="text/javascript">
    var map = new AMap.Map('container', {
        resizeEnable: true,
        zoom:15,   
   });    
    var customMarker = new AMap.Marker({
        offset: new AMap.Pixel(-12, -12)//相对于基点的位置
    });

    var toolBar;
    map.plugin(["AMap.ToolBar"],function(){ 
    toolBar = new AMap.ToolBar({locationMarker: customMarker}); //设置地位标记为自定义标记
    map.addControl(toolBar);  
    var loc=toolBar.doLocation();
    AMap.event.addListener(toolBar, 'location', onLocation);//返回定位信息
    });
    //步行导航
    var walking = new AMap.Walking({
        map: map,
        panel: "panel"
    }); 
//  var a = <?php echo ($a); ?>;
//  var b = <?php echo ($b); ?>;
//	var a=Number(a.innerText);
//	var b=Number(b.innerHTML);
//	var d=document.getElementById("c");
	var aa=a.innerHTML;
	var	bb=b.innerHTML;
//	 alert(aa);
//	b.innerHTML;
//	alert("hfa");
////	alert(a.getAttribute("accesskey");
//	alert(a);
	
//  var a=110.627281;
//  var b=21.303419;
    var abcArray;
    var abc;
    var c;
   function onLocation() {
     c=toolBar.getLocation();
     abc=c.toLocaleString();
     abcArray = abc.split(',');
     look(aa,bb);
   }
   function look(a,b){
   	walking.search([abcArray[0],abcArray[1]], [a, b]);
   }
    //根据起终点坐标规划步行路线
</script>
</body>
</html>