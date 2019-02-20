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
	$.ajax({
					contentType:"application/json",
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_team?",
					data:{},
					dataType:"json",
					cache:false,
					async:true,
					success:function(json){
//							data = JSON.stringify(data);
//							alert(data);
						if(json.success == "1"){
							$(".content table tr:not(:first-child)").detach();
							for(var i = 0;i < json.data.length; i++){
							$(".content table ").append('<tr id="'+json.data[i].rank+'"><td><a href="javascript:void(0);"><img src="images/special/头像.png" alt="" width="65" height="65"/><span>'+json.data[i].t_name+'</span></a></td><td>2000</td><td>'+json.data[i].t_wintime+'</td><td>'+json.data[i].t_losttime+'</td><td>'+json.data[i].percent+'</td><td>'+json.data[i].rank+'</td></tr>');
							}
							$(".content table tr").click(function(){
								var tId = $(this).attr('id');
								setCookie("tId",tId,7);
								window.location.href="teamData.html";
							})
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
