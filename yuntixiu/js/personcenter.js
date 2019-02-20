$(function(){
	teammate_id ="";
	var regId = getCookie("reg_id");
	var username = getCookie("username");
	var url =window.location.href;
	setCookie("url",url,7);
		//登录的名字
	function loginName(){
		$(".nav_last").html("").append('<ul><li id="new_li">我的<ul><div class="triangle_up"><span></span></div><a href="#">安全退出</a></ul></li></ul>')
		$("#new_li ul a").click(function(){
			delCookie("username");
			delCookie("reg_id");
			loginOut();
		})
	}
    function loginOut(){
    	window.location.href="login.html";
    }
  
	if( regId !==""){
			loginName();
			
	}else{
		delCookie("reg_id");
		window.location.href="login.html";
	}
	$("#new_li").hover(function(){
		$(this).children('ul').stop(true).fadeIn('slow').css({
			'boxShadow':'0 0 10px #ccc',
		})  //显示退出的下拉菜单
	},function(){
		$(this).children('ul').stop(true).fadeOut('slow')
	});
	$("#id_name").click(function(){
		$("#peseon_info").toggle();
	})
	$("#changePwd p").click(function(){
		$("#pwd_zone").toggle();
	})
	$("#add_click").click(function(){
		$("#member_info").toggle();
	})
	$("#li_third").hover(function(){
		$(this).children('ul').stop(true).fadeIn('slow')  //顶部nav的下拉菜单
	},function(){
		$(this).children('ul').stop(true).fadeOut('slow')
	});
	$(".pic").hover(function(){
		$(this).next().show();
	},function(){
		$(this).next().hide();
	});
//	$("#my_set").hover(function(){
//		$(this).children('ul').stop(true).fadeIn('slow')  //顶部nav的下拉菜单
//	},function(){
//		$(this).children('ul').stop(true).fadeOut('slow')
//	});

	$("#amend").click(function(){
		$("#team_n input").prop('disabled',null);
	})
	$("#team_n input").on('focusout',function(){
		$(this).attr('disabled','disabled');
	})
	$("#change_name").click(function(){
		$("#nickname").prop('disabled',null);
	})
	$("#nickname").on('focusout',function(){
		$(this).attr('disabled','disabled');
	})
	$("#only_id").val(username);
	if(regId != ""){
			$.ajax({																			/*个人中心初始化*/
					contentType:"application/json",																
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/show_personal?",
					data:{
						reg_id:regId,
					},
					dataType:"json",
					cache:false,
					async:true,
					success:function(json){
						if(json.success == "1"){
							var newNickName = json.data[0].reg_nickname;
							$("#nickname").val(newNickName);
							$("#save_pwd").click(function(){
								var oldPwd = json.data[0].reg_pwd;
								var old_pwd = $("#previousPwd").val();
								var new_pwd = $("#nowPwd").val();
								var new_pwd2 = $("#nowPwd2").val();
								if(old_pwd == oldPwd ){
									if(new_pwd == new_pwd2){
										$.ajax({
												contentType:"application/json",
												type:"get",
												url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/change_personal?",
												data:{
													reg_id:regId,
													old_pwd:oldPwd,
													change_pwd:new_pwd
												},
												dataType:"jsonp",
												jsonpCallback:"flightHandler",
												cache:false,
												async:true,
												success:function(json){
/*														data = JSON.stringify(json);
														alert(data);*/
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
										alert("两次输入密码不一致！")
									}
								}else{
									alert("你输入的旧密码错误 ！");
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
			$.ajax({
					contentType:"application/json",												/*消息*/
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/show_mes?",
					data:{
						reg_id:regId,
					},
					dataType:"json",
					cache:false,
					async:true,
					success:function(json){
//						data = JSON.stringify(json);
//							alert(data);
						if(json.success == "1"){
							$("#inform ul li").detach();
							for(var i = 0;i < json.data.length;i++){
								$("#inform ul").append('<li>'+json.data[i]+'</li>');
							}
								var info = $("#inform ul").text();
								if(info !=""){
									$("#inform i").css("backgroundImage","url(images/special/消息.png)");
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
	$.ajax({																		/*展示个人赛事*/
					contentType:"application/json",
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/pk_myself?",
					data:{
						reg_id:regId,
					},
					dataType:"json",
					cache:false,
					async:true,
					success:function(json){
//						data = JSON.stringify(json);
//							alert(data);
						if(json.success == "1"){
							$(".menudiv #con_one_1 table tr").detach();	/*发布*/
							for(var i = 0;i < json.data2.length;i++){
								$(".menudiv #con_one_1 table").append('<tr id="'+json.data2[i].pk_id+'"><td>'+json.data2[i].pk_name+'</td><td>'+json.data2[i].time+'</td><td>'+json.data2[i].place+'</td><td><button type="reset">取消</button></td></tr>');
							}
							$(".menudiv #con_one_4 table tr").detach();	/*创赛*/
							for(var i = 0;i < json.data1.length;i++){
								$(".menudiv #con_one_4 table").append('<tr id="'+json.data1[i].pk_id+'"><td>'+json.data1[i].pk_name+'</td><td>'+json.data1[i].time+'</td><td>'+json.data1[i].place+'</td><td><button type="reset">取消</button></td></tr>');
							}
							$(".menudiv #con_one_3 table tr").detach();	/*约赛*/
							for(var i = 0;i < json.data3.length;i++){
								$(".menudiv #con_one_3 table").append('<tr id="'+json.data3[i].pk_id+'"><td>'+json.data3[i].pk_name+'</td><td>'+json.data3[i].time+'</td><td>'+json.data3[i].place+'</td><td><button type="reset">取消</button></td></tr>');
							}
							$(".menudiv #con_one_2 table tr").detach();	/*应赛*/
							for(var i = 0;i < json.data4.length;i++){
								$(".menudiv #con_one_2 table").append('<tr id="'+json.data4[i].pk_id+'"><td>'+json.data4[i].pk_name+'</td><td>'+json.data4[i].time+'</td><td>'+json.data4[i].place+'</td><td><button type="reset">取消</button></td></tr>');
							}
							$(".menudiv button").click(function(){
								var cancel_id = $(this).parents('tr').attr('id');
								var result = confirm("你确定取消这场比赛？");
								alert(result);
								if(result){
									$.ajax({
									contentType:"application/json",												/*取消赛事*/
									type:"get",
									url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/cancel_pk?",
									data:{
										reg_id:regId,
										pk_id:cancel_id
									},
									dataType:"jsonp",
									jsonpCallback:"flightHandler",
									cache:false,
									async:true,
									success:function(data){
//										data = JSON.stringify(data);
//											alert(data);
										if(data.success == "1"){
											
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
	
	}
	$("#nickname").on('focusout',function(){											/*修改昵称*/
		var nickName = $("#nickname").val();
			$.ajax({
					contentType:"application/json",
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/change_personal?",
					data:{
						reg_id:regId,
						change_nickname:nickName
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
	})

	var count = 0;
	function clickTimes(){
		count++
		return count;
	}
//	function alowAdd(){

			$("#add_continue").click(function(){
			var	 t_name =$("#team_name").val();
		clickTimes();
		if(count<5){
		
		$(this).after('<input type="text" id="'+count+'"/>').css({'marginRight':'50px'});
		
		

		}else{
			return false;
		}
			$("#add_continue").next().on('change',function(){
//		alert("45")
		var nowInput_id =	$(this).attr('id');
//		alert(nowInput_id);
//				$('#'+nowInput_id+'').on('focusout',function(){
	
		var member_value = $(this).val();
//		alert(member_value)
		$.ajax({
					contentType:"application/json",
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/app.php/Home/Index/check_member?",
					data:{
						member_name:member_value
					},
					dataType:"json",
					cache:false,
					async:true,
					success:function(json){
							data = JSON.stringify(json);
							alert(data); 
						if(json.success == "1"){
							 teammate_id = json.data;
//							alert(teammate_id);
						if(typeof(array_id)=="undefined"){
							array_id = new Array();
								}
//							alert(teammate_id);		
							array_id.push(teammate_id);
//							alert(array_id.length);
//							var member1 = array_id[0];
//							var member2 = array_id[1];
//							var member3 = array_id[2];
//							var member4 = array_id[3];
							var member = '';
//							alert(member1+' '+member2+' '+member3+' '+member4);	
//							for(var j =0; j<4;j++){
								for(var i = 0;i<array_id.length;i++){
								 member +=array_id[i]+',';
									}
//								if(member.length==7){
										member = member.substring(0,member.length-1);
//								}
							
								alert(member)
//							}
						   	var newArray = member.split(',');
							 var member1 = newArray[0];
							 var member2 = newArray[1];
							 var member3 = newArray[2];
							 var member4 = newArray[3];
							if(newArray.length==4){
										$("#add_save").click(function(){
											$.ajax({
													contentType:"application/json",
													type:"get",
													url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/add_member?",
													data:{
														member1:member1,
														member2:member2,
														member3:member3,
														member4:member4,
														t_name:t_name,
														reg_id:regId
													},
													dataType:"jsonp",
													jsonpCallback:"flightHandler",
													cache:false,
													async:true,
													success:function(json){
															data = JSON.stringify(json);
															alert(data);
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
												})	
							}else{
								
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
		
				
//	})
})	
	})
										
//	}

})

