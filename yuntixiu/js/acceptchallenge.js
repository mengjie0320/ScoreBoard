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
	$("#time").fdatepicker();//日期调用
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
	/*展示所有约赛的信息*/
     	$.ajax({
		contentType:"application/json",
		type:"get",
		url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_publish?",
		data:{},
		dataType:"json",
		cache:false,
		async:true,
		success:function(json){
//			data = JSON.stringify(json);
//			alert(data);
			if(json.success=="1"){
				$("#all_team ul li").detach();
			
				for(var i = 0;i < json.data.length;i++ ){
					$("#all_team ul").append('<li id="'+json.data[i].pk_id+'"><aside class="head_pic"><img src="images/homepage/云体秀logo.png" alt="" width="70px" height="70px"/></aside><article class="team_info"><header><h1>'+json.data[i].t_name1+'</h1><small>能力值：<span>'+json.data[i].t_level+'</span></small></header><footer><p>约赛时间：<span>'+json.data[i].time+'</span></p><p>约赛地点：<span>'+json.data[i].place+'</span></p><p>预期对手要求：<span>'+json.data[i].intro+'</span></p></footer>	</article><section class="right_zone"><section class="sign"><p>记分牌：<span>有</span></p></section><aside class="btn"><button>去应赛</button></aside></section></li>');
				}
				accept();
			}else{
				
			}
		},
		error:function(XMLHttpRequest, textStatus, errorThrown){
			alert(XMLHttpRequest.status);
			alert(XMLHttpRequest.readyState);
			alert(textStatus);
		}
	})
		function formatDate(now) { 
				var year=now.getFullYear(); 
				var month=now.getMonth()+1; 
				
				var date=now.getDate(); 
				if(month < 10 && date < 10){
					var mon = '0'+month;
					var dates = '0'+date;
				}else{
					var mon = month;
					var dates = date;
				}
				//var hour=now.getHours(); 
				//var minute=now.getMinutes(); 
				//var second=now.getSeconds(); 
				return year+"-"+mon+"-"+dates; 
					}	 
			$("#search").click(function(){
				
				var time = $("#time").val();
				var dd = new Date(time);
				var legalTime =formatDate(dd);
				var province_id = $(".set_city select:nth-child(2) option:selected").val();
				var city_id = $(".set_city select:nth-child(3) option:selected").val();
				var area_id = $(".set_city select:nth-child(4) option:selected").val();
				if( province_id !=="-1" && city_id !== "-1" && area_id !== "-1" && time == "" ){						/*按地点查询*/			
						$.ajax({
							contentType:"application/json",
							type:"get",
							url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Search/research_place_pk?",
							data:{
								provinceID:province_id,
								cityID:city_id,
								areaID:area_id
							},
							dataType:"json",
							cache:false,
							async:true,
							success:function(json){
//								json= $.parseJSON(json);
						
//								alert(json.data[1].place);
//								alert(json.data.length);
								if(json.success=="1"){
									$("#all_team ul li").detach();
									
									for(var j =0;j < json.data.length; j++){
//										alert("1");

										$("#all_team ul").append('<li id="'+json.data[j].pk_id+'"><aside class="head_pic"><img src="images/homepage/云体秀logo.png" alt="" width="70px" height="70px"/></aside><article class="team_info"><header><h1>'+json.data[j].t_name1+'</h1><small>能力值：<span>'+json.data[j].t_level+'</span></small></header><footer><p>约赛时间：<span>'+json.data[j].time+'</span></p><p>约赛地点：<span>'+json.data[j].place+'</span></p><p>预期对手要求：<span>'+json.data[j].intro+'</span></p></footer></article><section class="right_zone"><section class="sign"><p>记分牌：<span>有</span></p></section><aside class="btn"><button>去应赛</button></aside></section></li>');
									}	
									accept();
									
									}else{
										
									}
							},
							error:function(XMLHttpRequest, textStatus, errorThrown){
								alert(XMLHttpRequest.status);
								alert(XMLHttpRequest.readyState);
								alert(textStatus);
							}
						})
					
				}else if(time !== ""  && province_id =="-1" && city_id == "-1" && area_id == "-1"){							/*按时间查询*/
					$.ajax({
							contentType:"application/json",
							type:"get",
							url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Search/research_time_pk?",
							data:{
								time:legalTime,
							},
							dataType:"json",
							cache:false,
							async:true,
							success:function(json){
//								data = JSON.stringify(json);
//								alert(json);
//									alert(json.data.length);
								if(json.success=="1"){
									$("#all_team ul li").detach();
									for(var i = 0;i < json.data.length;i++ ){
										$("#all_team ul").append('<li id="'+json.data[i].pk_id+'"><aside class="head_pic"><img src="images/homepage/云体秀logo.png" alt="" width="70px" height="70px"/></aside><article class="team_info"><header><h1>'+json.data[i].t_name1+'</h1><small>能力值：<span>'+json.data[i].t_level+'</span></small></header><footer><p>约赛时间：<span>'+json.data[i].time+'</span></p><p>约赛地点：<span>'+json.data[i].place+'</span></p><p>预期对手要求：<span>'+json.data[i].intro+'</span></p></footer>	</article><section class="right_zone"><section class="sign"><p>记分牌：<span>有</span></p></section><aside class="btn"><button>去应赛</button></aside></section></li>');
									}	
									accept();
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
				else if( province_id !=="-1" && city_id !== "-1" && area_id !== "-1" && time !== ""  ){						/*联合查询*/					
						$.ajax({
							contentType:"application/json",
							type:"get",
							url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Search/research_tp_pk?",
							data:{
								provinceID:province_id,
								cityID:city_id,
								areaID:area_id,
								time:legalTime
							},
							dataType:"json",
							cache:false,
							async:true,
							success:function(json){
//								data = JSON.stringify(datac);
//								alert(datac.data.length);
								if(json.success=="1"){
									$("#all_team ul li").detach();
									for(var k = 0;k < json.data.length;k++ ){
										$("#all_team ul").append('<li id="'+json.data[k].pk_id+'"><aside class="head_pic"><img src="images/homepage/云体秀logo.png" alt="" width="70px" height="70px"/></aside><article class="team_info"><header><h1>'+json.data[k].t_name1+'</h1><small>能力值：<span>'+json.data[k].t_level+'</span></small></header><footer><p>约赛时间：<span>'+json.data[k].time+'</span></p><p>约赛地点：<span>'+json.data[k].place+'</span></p><p>预期对手要求：<span>'+json.data[k].intro+'</span></p></footer></article><section class="right_zone"><section class="sign"><p>记分牌：<span>有</span></p></section><aside class="btn"><button>去应赛</button></aside></section></li>');
									}	
									accept();
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
					alert("请选择时间、地点进行查询！");
				}
				
			
			})
			function accept(){						
					$(".btn").click(function(){

					var	pId = $(this).parents('li').attr('id');
					/*去应赛*/
					if(rId != "" && pId != ""){
					$.ajax({
							contentType:"application/json",
							type:"get",
							url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/accept_pk?",
							data:{
								reg_id:rId,
								pk_id:pId
							},
							dataType:"jsonp",
							jsonpCallback:"flightHandler",
							cache:false,
							async:true,
							success:function(data){
//									data = JSON.stringify(data);
//									alert(data);
								if(data.success=="1"){
									
									alert("应战成功！");
								}else{
									alert("该赛事已被应战！");
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
			})
					}
})
