$(function(){
	$(".nav_first li").hover(function(){
		$(this).children('ul').stop(true).fadeIn('slow')  //顶部nav的下拉菜单
	},function(){
		$(this).children('ul').stop(true).fadeOut('slow')
	});
	$(".nav_bottom ul li").hover(function(){
//		$that = $(this);
//		setTimeout(function(){
		$(this).children('ul').stop(true).fadeIn(); 
//		},300);
	},function(){
//	setTimeout(function(){
		$(this).children('ul').stop(true).fadeOut(); 
//		},300);
	});
	$(".pic").hover(function(){
		$(this).next().show();
	},function(){
		$(this).next().hide();
	});
	$(".video_top ul li a").mouseenter(function(){
		$(this).children('span').show();
	});
	$(".video_top ul li a").mouseleave(function(){
		$(this).children('span').hide();
	});
//	$("#login").click(function(){
//		location.href="login.html";
//	});
//	$("#register").click(function(){
//		location.href="register.html";
//	});
})
$(function(){

//	$("img[original]").lazyload({ placeholder:"images/color3.gif" });
	
	$('#demo01').flexslider({
		animation: "slide",
		direction:"horizontal",
		easing:"swing"
	});
	$('#demo02').flexslider({
		animation: "slide",
		direction:"horizontal",
		easing:"swing"

	});
	
	$('.demo2').Tabs({
		event:'click'
	});
	$('.demo1').Tabs();
	
	$('.demo2').Tabs({
		timeout:300
	});
	$('#data_rank tr:nth-child(even)').addClass('odd_color')
//	$('.demo4').Tabs({
//		auto:3000
//	});
//	$('.demo5').Tabs({
//		event:'click',
//		callback:lazyloadForPart
//	});
	//部分区域图片延迟加载
//	function lazyloadForPart(container) {
//		container.find('img').each(function () {
//			var original = $(this).attr("original");
//			if (original) {
//				$(this).attr('src', original).removeAttr('original');
//			}
//		});
//	}
			 
			    $(".list_bottom em").click(function(){
			    	var onOff =	$(".small_comment_frame").css("display");
			    	if(onOff=='none'){
			    		$(".small_comment_frame").css("display","block");
			    	}
			    	else{
			    		$(".small_comment_frame").css("display","none");
			    	}
			    })
});	
$(function(){
	var username = getCookie("username");
	var url =window.location.href;
	setCookie("url",url,7);
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
	if(username !== "" ){
			loginName();		
	}
	$("#new_li").hover(function(){
		$(this).children('ul').stop(true).fadeIn('slow')  //显示退出的下拉菜单
	},function(){
		$(this).children('ul').stop(true).fadeOut('slow')
	});
	/*对战*/
	$.ajax({
		contentType:"application/json",
		type:"get",
		url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/pk_show?",
		data:{},
		dataType:"json",
		cache:false,
		async:true,
		success:function(json){
//			data = JSON.stringify(json);
//			alert(data);
			if(json.success=="1"){
				$(".carousel_inner ul li").detach();
				$("#game_list .game_list").detach();
				for(var i = 0;i < json.data.length;i++ ){
					if(json.data[i].state==2){
					$("#game_list").append('<div class="game_list"><table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr  align="center" bgcolor="#eeeeee"><td width="20%"><a href="#">'+json.data[i].pk_name1+'</a></td><td width="10%" bgcolor="#e1e1e1">VS</td><td width="20%" ><a href="#">'+json.data[i].pk_name2+'</a></td></tr><tr align="center" bgcolor="#e5e5e5"><td width="10%"><a href="#">'+json.data[i].score1+'</a></td><td bgcolor="#e3e3e3">:</td><td width="10%"><a href="#">'+json.data[i].score2+'</a></td></tr><tr align="center" bgcolor="#eeeeee"><td width="10%" align="center" colspan="3"><span style="display:block;width:52px;height:30px;line-height:30px;background-color: #e3e3e3;">未开始</span><a href=""></a></td></tr></table></div>');
						
					}else if(json.data[i].state==3){
					$("#game_list").append('<div class="game_list"><table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr  align="center" bgcolor="#eeeeee"><td width="20%"><a href="#">'+json.data[i].pk_name1+'</a></td><td width="10%" bgcolor="#e1e1e1">VS</td><td width="20%" ><a href="#">'+json.data[i].pk_name2+'</a></td></tr><tr align="center" bgcolor="#e5e5e5"><td width="10%"><a href="#">'+json.data[i].score1+'</a></td><td bgcolor="#e3e3e3">:</td><td width="10%"><a href="#">'+json.data[i].score2+'</a></td></tr><tr align="center" bgcolor="#eeeeee"><td width="10%" align="center" colspan="3"><span style="display:block;width:52px;height:30px;line-height:30px;background-color: #e3e3e3;">直播中</span><a href=""></a></td></tr></table></div>');
						
					}else if(json.data[i].state==1){
					$("#game_list").append('<div class="game_list"><table width="100%" border="0" cellspacing="0" cellpadding="0" ><tr  align="center" bgcolor="#eeeeee"><td width="20%"><a href="#">'+json.data[i].pk_name1+'</a></td><td width="10%" bgcolor="#e1e1e1">VS</td><td width="20%" ><a href="#">'+json.data[i].pk_name2+'</a></td></tr><tr align="center" bgcolor="#e5e5e5"><td width="10%"><a href="#">'+json.data[i].score1+'</a></td><td bgcolor="#e3e3e3">:</td><td width="10%"><a href="#">'+json.data[i].score2+'</a></td></tr><tr align="center" bgcolor="#eeeeee"><td width="10%" align="center" colspan="3"><span style="display:block;width:52px;height:30px;line-height:30px;background-color: #e3e3e3;">已结束</span><a href=""></a></td></tr></table></div>');
						
					}

					$(".carousel_inner ul").append('<li><a href="javascript:;"><div class="battle_situlation"><p class="type"><em>'+json.data[i].pk_name+'</em><i><img src="" alt=""></i></p><p class="team_fisrt"><span>'+json.data[i].pk_name1+'</span><em>'+json.data[i].score1+'</em></p><p class="team_second"><span>'+json.data[i].pk_name2+'</span><em>'+json.data[i].score2+'</em></p></div></a></li>');
				}
//				alert(json.data.length)
			}else{
				
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
			alert(XMLHttpRequest.status);
			alert(XMLHttpRequest.readyState);
			alert(textStatus);
		}
	})
	/*左侧选项卡新闻*/
	$.ajax({
		contentType:"application/json",
		type:"get",
		url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_news?",
		data:{},
		dataType:"json",
		cache:false,
		async:true,
		success:function(json){
//			data = JSON.stringify(json);
//			alert(data);
			if(json.success=="1"){
				$(".news_top ul li").detach();
				for(var i = 0;i < json.just_word.length;i++ ){
					$(".news_top ul").append('<li><span></span><a href="newsshow.html">'+json.just_word[i].out_title+'</a></li>');
					
				}
					$(".news_bottom ul li").detach();
				for(var i = 0; i < json.pic_word.length;i++){
					$(".news_bottom ul").append('<li><a href="newsshow.html"><div class="news_pic"><img src="'+json.pic_word[i].out_image1+'" width="120" height="86"/></div><div class="news_word"><p>'+json.pic_word[i].out_title+'</p></div></a></li>');
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
	/*左侧选项卡视频*/
	$.ajax({
		contentType:"application/json",
		type:"get",
		url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_videos?",
		data:{},
		dataType:"json",
		cache:false,
		async:true,
		success:function(json){
//			data = JSON.stringify(json);
//			alert(data);
			if(json.success=="1"){
				$(".video_top ul li").detach();
				for(var i = 0;i < json.just_word.length;i++ ){
					$(".video_top ul").append('<li><a href="videoDetail.html"><img src="'+json.just_word[i].image1+'" width="115" height="90"/><p>'+json.just_word[i].pk_name+'</p><span class="play"></span></a></li>');
				}
					$(".video_bottom ul li").detach();
				for(var j = 0;j < json.pic_word.length;j++){
					$(".video_bottom ul").append('<li><div class="video_pic"><img src="'+json.pic_word[j].image1+'" /><span class="play"></span></div><div class="video_word"><div class="word_ft"><a href="#"><span></span></a></div><div class="word_sd"><a href="#"><span>'+json.pic_word[j].pk_name+'</span></a></div><div class="word_td"><span>'+json.pic_word[j].intro+'</span><a href="videoDetail.html">[详情]</a></div></div></li>');
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
	/*右侧选项卡数据*/
	$.ajax({
		contentType:"application/json",
		type:"get",
		url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_team?",
		data:{},
		dataType:"json",
		cache:false,
		async:true,
		success:function(json){
//			data = JSON.stringify(json);
//			alert(data);
			if(json.success=="1"){
				$(".rank_list table tbody tr").detach();
			
				for(var i = 0;i < json.data.length;i++ ){
					$(".rank_list table tbody").append('<tr align="center"><td width="30%">'+json.data[i].rank+'</td><td><a href="#">'+json.data[i].t_name+'</a></td><td>'+json.data[i].t_wintime+'</td><td>'+json.data[i].t_losttime+'</td><td>'+json.data[i].percent+'</td></tr>');

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
	/*中间轮播图*/
		$.ajax({
		contentType:"application/json",
		type:"get",
		url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/scanner_show?",
		data:{},
		dataType:"json",
		cache:false,
		async:true,
		success:function(json){
//			data = JSON.stringify(json);
//			alert(data);
			if(json.success=="1"){
				$("#demo02 .slides li").detach();
				
//				$("#demo02 ul li div").detach();
//				$("#demo02 ul li:nth-child(1)").append('<div class="img"><img src="'+json.data[0].image1+'" height="300" width="570" alt="" /></div>');
//				$("#demo02 ul li:nth-child(2)").append('<div class="img"><img src="'+json.data[1].image1+'" height="300" width="570" alt="" /></div>');
//				$("#demo02 ul li:nth-child(3)").append('<div class="img"><img src="'+json.data[2].image1+'" height="300" width="570" alt="" /></div>');
//				$("#demo02 ul li:nth-child(4)").append('<div class="img"><img src="'+json.data[3].image1+'" height="300" width="570" alt="" /></div>');
//				$("#demo02 ul li:nth-child(5)").append('<div class="img"><img src="'+json.data[0].image1+'" height="300" width="570" alt="" /></div>');
//				$("#demo02 ul li:nth-child(6)").append('<div class="img"><img src="'+json.data[0].image1+'" height="300" width="570" alt="" /></div>');
				for(var i=0;i < json.data.length;i++){
					
					$('#demo02 .slides').append('<li><div class="img"><img src="'+json.data[i].image1+'" height="300" width="570" alt="" /></div></li>');
					$("#demo02 .slides li").css({"float":"left","width":"570px"});
					
				}
					$("#demo02 .slides li:first-child").before('<li style="float:left"><div class="img"><img src="'+json.data[0].image1+'" height="300" width="570" alt="" /></div></li>');	
					$("#demo02 .slides li:last-child").after('<li style="float:left"><div class="img"><img src="'+json.data[0].image1+'" height="300" width="570" alt="" /></div></li>');
			}else{
				
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
			alert(XMLHttpRequest.status);
			alert(XMLHttpRequest.readyState);
			alert(textStatus);
		}
	})
		/*查看访问量*/
		$.ajax({
		contentType:"application/json",
		type:"get",
		url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/add_view?",
		data:{},
		dataType:"jsonp",
		jsonpCallback:"flightHandler",
		cache:false,
		async:true,
		success:function(json){
//			data = JSON.stringify(json);
//			alert(data);
			if(json.success=="1"){
					$.ajax({
							contentType:"application/json",
							type:"get",
							url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_view_download?",
							data:{},
							dataType:"json",
							cache:false,
							async:true,
							success:function(json){
					//			data = JSON.stringify(json);
					//			alert(data);
								if(json.success=="1"){
									$("#count").text("");
					//				for(var i = 0;i < json.data.length;i++ ){
										$("#count").append('总访问量：'+json.data[0].view_num+'');
										
					//				}
									
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
				
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
			alert(XMLHttpRequest.status);
			alert(XMLHttpRequest.readyState);
			alert(textStatus);
		}
	})

})
