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
			$.ajax({
					contentType:"application/json",
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_all_pk?",
					data:{},
					dataType:"json",
					cache:false,
					async:true,
					success:function(json){
//							data = JSON.stringify(data);
//							alert(data);
						if(json.success == "1"){
							$(".match-list ul li").detach();
							for(var i = 0;i < json.data.length;i++){
								if(json.data[i].state == 3){
									$(".match-ing .match-list ul").append('<li id="'+json.data[i].pk_id+'"><a href="javascript:void(0);"><span class="date-t fl"><span>'+json.data[i].time+'</span></span><p class="teams fl"><span class="fl">'+json.data[i].pk_name1+'</span><span class="fr">'+json.data[i].pk_name2+'</span></p><span class="add fl">'+json.data[i].place+'</span></a></li>');
								}else if(json.data[i].state == 1){
									$(".match-ed .match-list ul").append('<li id="'+json.data[i].pk_id+'"><a href="javascript:void(0);"><span class="date-t fl"><span>'+json.data[i].time+'</span></span><p class="teams fl"><span class="fl">'+json.data[i].pk_name1+'</span><span class="team1-score fl">'+json.data[i].t_score1+'</span><span class="fr">'+json.data[i].pk_name2+'</span><span class="team2-score fr">'+json.data[i].t_score2+'</span></p></a></li>');
								}else{
									$(".match-will .match-list ul").append('<li id="'+json.data[i].pk_id+'"><a href="javascript:void(0);"><span class="date-t fl"><span>'+json.data[i].time+'</span></span><p class="teams fl"><span class="fl">'+json.data[i].pk_name1+'</span><span class="fr">'+json.data[i].pk_name2+'</span></p><span class="add fl">'+json.data[i].place+'</span></a></li>');
								}
							}
							$(".match-list ul li").bind("click",function(){
								var pkId = $(this).attr('id');
								setCookie("pkId",pkId,7);
								window.location.href="watchGameDetials.html";
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
