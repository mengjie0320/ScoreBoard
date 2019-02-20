$(function(){
	var regId = getCookie("reg_id");
	var username = getCookie("username");
	var url =window.location.href;
	setCookie("url",url,7);
	$("#li_third").hover(function(){
		$(this).children('ul').stop(true).fadeIn('slow')  //顶部nav的下拉菜单
	},function(){
		$(this).children('ul').stop(true).fadeOut('slow')
	});
	$(".pic").hover(function(){
		$(this).next().show();			//底部关注
	},function(){
		$(this).next().hide();
	});
		//登录的名字
	function loginName(){
		$(".nav_last").html("").append('<ul><li id="new_li">欢迎您，'+username+'<ul><div class="triangle_up"><span></span></div><p><a href="personcenter.html"><img src="images/homepage/个人中心.png" />个人中心</a></p><p><a href="personcenter.html"><img src="images/homepage/消息.png" />我的消息<i></i></a></p><a href="#" id="login_out"><img src="images/homepage/退出.png" />安全退出</a></ul></li></ul>')
		$("#new_li ul #login_out").click(function(){
			delCookie("username");
			delCookie('reg_id');
			loginOut();
		})
	}
    function loginOut(){
    	window.location.href="login.html";
    }
  
	if(username !== "" && regId !==""){
			loginName();
			
	}else{
		delCookie("reg_id");
	}
	$("#new_li").hover(function(){
		$(this).children('ul').stop(true).fadeIn('slow').css({
			'boxShadow':'0 0 10px #ccc',
		})  //显示退出的下拉菜单
	},function(){
		$(this).children('ul').stop(true).fadeOut('slow')
	});
	   var map, geolocation;
    //加载地图，调用浏览器定位服务
    map = new AMap.Map('container', {
        resizeEnable: true
    });
    map.plugin('AMap.Geolocation', function() {
        geolocation = new AMap.Geolocation({
            enableHighAccuracy: true,//是否使用高精度定位，默认:true
            timeout: 10000,          //超过10秒后停止定位，默认：无穷大
            buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
            zoomToAccuracy: true,      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
            buttonPosition:'RB'
        });
        map.addControl(geolocation);
        geolocation.getCurrentPosition();
        AMap.event.addListener(geolocation, 'complete', onComplete);//返回定位信息
        AMap.event.addListener(geolocation, 'error', onError);      //返回定位出错信息
    });
    //解析定位结果
    function onComplete(data) {
   var keyWords = getCookie("keyWords");
// alert(keyWords)
   var sort = getCookie('sort');
  	var lng = data.position.getLng()
  	var lat = data.position.getLat();
//	alert(lng);
//	alert(lat);
  	$.ajax({
		contentType:"application/json",
		type:"get",
		url:'http://restapi.amap.com/v3/place/around?key=533a3770dad7367679915eb25a97f8a6&location='+lng+','+lat+'&keywords='+keyWords+'&offset=20&page=1&extensions=all',
		dataType:"json",
		cache:false,
		async:true,
		success:function(data){
//			data = JSON.stringify(data);
//			alert(data);
			if(data.status=="1"){
				$("#left").text(sort);
				$("#right").text('.'+keyWords);
				$("#content .content2").detach();
			
				for(var i = 0;i < data.pois.length;i++ ){
					if(data.pois[i].photos.length == ""){
					$("#content").append('<div class="content2"><div class="left"><img src="images/special/头像.png"><div class="message"><p>店名：'+data.pois[i].name+'</p><p>号码：'+data.pois[i].tel+'</p><p>地址：'+data.pois[i].address+'</p></div></div><div class="right"><a href="#" ><img src="images/special/地图.png"></a><div class="nav" id="'+data.pois[i].location+'"><a href="javascript:void(0);" >查看地图</a></div></div></div>');
						
					}else{
					$("#content").append('<div class="content2"><div class="left"><img src="'+data.pois[i].photos[0].url+'"><div class="message"><p>店名：'+data.pois[i].name+'</p><p>号码：'+data.pois[i].tel+'</p><p>地址：'+data.pois[i].address+'</p></div></div><div class="right"><a href="#" ><img src="images/special/地图.png"></a><div class="nav" id="'+data.pois[i].location+'"><a href="javascript:void(0);" >查看地图</a></div></div></div>');
						
					}
					
				}
				var winHeight = $(document).height();
				$(".nav").click(function(){
					var location = $(this).attr('id');
					var arr = new Array();
					var imgHref = $(this).parent().prev().find('img:first-child').attr('src');
					var pfcontent = $(this).parent().prev().find('p:first-child').text();
					var pscontent = $(this).parent().prev().find('p:nth-child(2)').text();
					var ptcontent = $(this).parent().prev().find('p:last-child').text();
					 arr.push(pfcontent);
					 arr.push(pscontent);
					 arr.push(ptcontent);
					var sname = arr[0],stel = arr[1],saddress = arr[2]; 
					var str = new Array();
					str = location.split(",");
					var	newLng = str[0];
					var	newLat = str[1];
					 $('#code').center();
						      $('#goodcover').css('height',winHeight).show();
						      $('#code').fadeIn();
					//地图初始化时，在地图上添加一个marker标记,鼠标点击marker可弹出自定义的信息窗体
    var map = new AMap.Map("layer_center", {
        resizeEnable: true,
        center: [newLng, newLat],
        zoom: 16
    });   
       AMap.plugin(['AMap.ToolBar','AMap.Scale','AMap.OverView'],function(){
            map.addControl(new AMap.ToolBar());
            map.addControl(new AMap.Scale());
    })
    addMarker();
    //添加marker标记
    function addMarker() {
        map.clearMap();
        var marker = new AMap.Marker({
            map: map,
            position: [newLng,newLat]
        });
        //鼠标点击marker弹出自定义的信息窗体
        AMap.event.addListener(marker, 'click', function() {
            infoWindow.open(map, marker.getPosition());
        });
    }

    //实例化信息窗体
    var title = ''+sname+'',
        content = [];
    content.push('<img src="'+imgHref+'" width="100" height="66" >'+saddress+'');
    content.push(''+stel+'');
    var infoWindow = new AMap.InfoWindow({
        isCustom: true,  //使用自定义窗体
        content: createInfoWindow(title, content.join("<br/>")),
        offset: new AMap.Pixel(16, -45)
    });

    //构建自定义信息窗体
    function createInfoWindow(title, content) {
        var info = document.createElement("div");
        info.className = "info";

        //可以通过下面的方式修改自定义窗体的宽高
        //info.style.width = "400px";
        // 定义顶部标题
        var top = document.createElement("div");
        var titleD = document.createElement("div");
        var closeX = document.createElement("img");
        top.className = "info-top";
        titleD.innerHTML = title;
        closeX.src = "http://webapi.amap.com/images/close2.gif";
        closeX.onclick = closeInfoWindow;

        top.appendChild(titleD);
        top.appendChild(closeX);
        info.appendChild(top);

        // 定义中部内容
        var middle = document.createElement("div");
        middle.className = "info-middle";
        middle.style.backgroundColor = 'white';
        middle.innerHTML = content;
        info.appendChild(middle);

        // 定义底部内容
        var bottom = document.createElement("div");
        bottom.className = "info-bottom";
        bottom.style.position = 'relative';
        bottom.style.top = '0px';
        bottom.style.margin = '0 auto';
        var sharp = document.createElement("img");
        sharp.src = "http://webapi.amap.com/images/sharp.png";
        bottom.appendChild(sharp);
        info.appendChild(bottom);
        return info;
    }

    //关闭信息窗体
    function closeInfoWindow() {
        map.clearInfoWindow();
    }
    	var mock = {
		log: function(result) {
			window.parent.setIFrameResult('log', result);
		}
	}
	console = mock;
	window.Konsole = {
		exec: function(code) {
			code = code || '';
			try {
				var result = window.eval(code);
				window.parent.setIFrameResult('result', result);
			} catch (e) {
				window.parent.setIFrameResult('error', e);
			}
		}
	}
						  });
						    $('#closebt').click(function(){
						      $('#code').hide();
						      $('#goodcover').hide();
						  });
						$('#goodcover').click(function(){
						      $('#code').hide();
						      $('#goodcover').hide();
						  });
			
			}else{
				
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
			alert(XMLHttpRequest.status);
			alert(XMLHttpRequest.readyState);
			alert(textStatus);
		}
	})
    }
    //解析定位错误信息
    function onError(data) {
        document.body.innerHTML = '定位失败';
    }
})
