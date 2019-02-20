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
		$('#demo-3').fdatepicker({
			format: 'yyyy-mm-dd hh:ii',
			pickTime: true
		});
	$('#demo-2').fdatepicker({
			format: 'yyyy-mm-dd hh:ii',
			pickTime: true
		});
	$("#public").click(function(){
		var time = $("#demo-2").val();
		var info = $("#information").val();
		var place = $(".set_city select:nth-child(2) option:selected").text()+$(".set_city select:nth-child(3) option:selected").text() +$(".set_city select:nth-child(4) option:selected").text();
		if(time == "" || info == "" || place == "" ){
			alert("时间、地点、要求不能为空！");
		}else{
			
			if(regId != ""){
				$.ajax({
							contentType:"application/json",
							type:"get",
							url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/publish_pk?",
							data:{
								reg_id:regId,
								time:time,
								place:place,
								intro:info
							},
							dataType:"jsonp",
							jsonpCallback:"flightHandler",
							cache:"false",
							async:true,
							success:function(data){
//									data = JSON.stringify(data);
//									alert(data);
								if(data.success=="1"){
									
									alert("发布成功！");
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
				}
		})
	
			$.ajax({
							contentType:"application/json",
							type:"get",
							url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/recommend_pk?",
							data:{
								reg_id:regId,
						},
							dataType:"json",
							cache:"false",
							async:true,
							success:function(data){
//									data = JSON.stringify(data);
//									alert(data);
								if(data.success=="1"){
									$(".hot-teams .team-list ul li").detach();
									$(".all-teams .team-list ul li").detach();
									for(var i = 0;i < data.data1.length;i++){
										$(".hot-teams .team-list ul").append('<li id="'+data.data1[i].t_id+'"><div class="touxiang fl"><img src="images/homepage/云体秀logo.png"></div><div class="team-info fl">'+data.data1[i].t_name+'</h5><p class="nlz">能力值：<span>'+data.data1[i].t_level+'</span></p><p class="jfp">记分牌：<span>有</span></p></div><div class="yuesai fl"><a href="javascript:void(0);" class="clickMe">去约赛</a></div></li>');
									}
									for(var j = 0;j < data.data2.length; j++){
										$(".all-teams .team-list ul").append('<li><div class="touxiang fl"><img src="images/homepage/云体秀logo.png"></div><div class="team-info fl">'+data.data1[j].t_name+'</h5><p class="nlz">能力值：<span>'+data.data1[j].t_level+'</span></p><p class="jfp">记分牌：<span>有</span></p></div><div class="yuesai fl"><a href="javascript:void(0);" class="clickMe">去约赛</a></div></li>');
										
									}
									var winHeight = $(document).height();
									 $('.clickMe').click(function() {
									  tId =	$(this).parents('li').attr('id');
								        $('#code').center();
								        $('#goodcover').css('height',winHeight).show();
								        $('#code').fadeIn();
								    });
								      $('#closebt').click(function() {
								        $('#code').hide();
								        $('#goodcover').hide();
								    });
									$('#goodcover').click(function() {
								        $('#code').hide();
								        $('#goodcover').hide();
								    });
								 
  						$("#submit_all").bind('click',function(){
    						
    					
    						var timeDemo = $("#demo-3").val();
    						var addressDetail = $("#layer_address").val();
    						
//  						if(timeDemo == "" && addressDetail == ""){
    				if(regId != ""){	
  						$.ajax({
							contentType:"application/json",
							type:"get",
							url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/date_to?",
							data:{
								reg_id:regId,
								t_id2:tId,
								time:timeDemo,
								place:addressDetail
							},
							dataType:"jsonp",
							jsonpCallback:"flightHandler",
							cache:false,
							async:true,
							beforeSend:function(data){
								alert("正在请求")
							},
							success:function(data){
									data = JSON.stringify(data);
									alert(data);
								if(data.success=="1"){
									
									alert("约赛成功！");
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
  							window.location.href="login.html";
  						}
//  						}else{
//  							alert("请填写日期和地址！");
//  						}
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
