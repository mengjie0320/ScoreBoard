$(function(){
	var url = window.location.href;
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
	var username = getCookie("username");
	var rId = getCookie("reg_id");
	
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
  
	if(username !== "" && rId !==""){
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
	var tId = getCookie("tId");
	$.ajax({
				contentType:"application/json",
				type:"get",
				url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_t_pk?",
				data:{
					t_id:tId
				},
				dataType:"json",
				cache:"false",
				async:true,
				success:function(json){
//						data = JSON.stringify(json);
//						alert(data);
					if(json.success=="1"){
						$(".team-matches table tr:not(:first-child)").detach();
						for(var i = 0; i<json.data.length;i++){
							$(".team-matches table").append('<tr><td><span>'+json.data[i].pk_name1+'</span>&amp;<span>'+json.data[i].pk_name2+'</span></td><td><span>'+json.data[i].time+'</span></td><td><span>'+json.data[i].t_score1+'&nbsp;:&nbsp;'+json.data[i].t_score2+'</span></td><td><span>'+json.data[i].t_good1+'</span></td></tr>');
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
})
