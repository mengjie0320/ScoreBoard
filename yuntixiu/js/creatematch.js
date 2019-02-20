$(function(){
	$('#demo-2').fdatepicker({
			format: 'yyyy-mm-dd hh:ii',
			pickTime: true
		});
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
	/*展示所有所创的联赛*/
		$.ajax({
					contentType:"application/json",
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_league?",
					data:{},
					dataType:"json",
					cache:false,
					async:true,
					success:function(json){
//							data = JSON.stringify(data);
//							alert(data);
						if(json.success == "1"){
							$(".league-list ul li").detach();
							for(var i = 0;i < json.data.length; i++){
	$(".league-list ul").append('<li><div class="team-info team1 fl"><span>'+json.data[i].t_name1+'</span><p>'+json.data[i].pk_name+'</p></div><div class="team-info team2 fl"><span>'+json.data[i].t_name2+'</span><p>'+json.data[i].pk_name+'</p></div><div class="match-info fl"><div class="date-t"><span>'+json.data[i].time+'</span></div><p>'+json.data[i].place+'</p></div></li>');
							}
						}else{
							
						}
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						alert(XMLHttpRequest.status);
						alert(XMLHttpRequest.readyState);
						alert(textStatus);
					}
					})
		$("#btn").click(function(){
		var t_name1 = $(".team1-name input").val();
		var t_name2 = $(".team2-name input").val();
		var pk_name = $(".league-name input").val();
		var time = $("#demo-2").val();
		var place = $(".set_city select:nth-child(2) option:selected").text()+$(".set_city select:nth-child(3) option:selected").text() +$(".set_city select:nth-child(4) option:selected").text();
		if(t_name1 != "" && t_name2 != "" && pk_name != "" && time != "" && place != "-1" ){
			if(regId != ""){
					$.ajax({
					contentType:"application/json",
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/creative_League?",
					data:{
						reg_id:regId,
						t_name1:t_name1,
						t_name2:t_name2,
						pk_name:pk_name,
						time:time,
						place:place
					},
					dataType:"jsonp",
					jsonpCallback:"flightHandler",
					cache:false,
					async:true,
					success:function(json){
//							data = JSON.stringify(json);
//							alert(data);
						if(json.success == "1"){
							
						}else{
							
						}
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						alert(XMLHttpRequest.status);
						alert(XMLHttpRequest.readyState);
						alert(textStatus);
					}
					})
			}else{
				alert("请先登录！");
				window.location.href="login.html";
			}
		}else{
			alert("请输入完整信息！");
		}
		})
})
