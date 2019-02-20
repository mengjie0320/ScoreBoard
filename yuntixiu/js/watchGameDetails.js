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
	var pId = getCookie("pkId");
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
	$.ajax({						/*点赞*/
			contentType:"application/json",
			type:"get",
			url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Show/show_pk_id?",
			data:{
				pk_id:pId,
			},
			dataType:"json",
			cache:"false",
			async:true,
			success:function(json){
//					data = JSON.stringify(json);
//					alert(data);
				if(json.success=="1"){
					$(".warpper article table").detach();
					$(".warpper article").append('<table id="score_list"><tr id="tr_1"><td><figure><figcaption>'+json.data.pk_name1+'</figcaption><img src="'+json.data.t_image1+'" width="350" height="198" alt=""/></figure></td><td rowspan="2" class="center_td"><ul><li>'+json.data.t_score1+'</li><li><img src="images/special/xian.jpg" alt=""/></li><li>'+json.data.t_score2+'</li></ul></td><td><figure><figcaption>'+json.data.pk_name2+'</figcaption><img src="'+json.data.t_image2+'" width="350" height="198" alt=""/></figure></td></tr><tr id="tr_2"><td><figure id="support_1"><img src="images/special/绿赞.png" width="35" height="38" alt="" /><figcaption>'+json.data.t_good1+'</figcaption></figure></td><td><figure id="support_2"><img src="images/special/黑赞.png" width="35" height="38" alt="" /><figcaption>'+json.data.t_good2+'</figcaption></figure></td></tr></table>');
					var tId_1 = json.data.t_id1;
					var tId_2 = json.data.t_id2;
						function once(fn, context) { 
									   	 var result;
									
										return function() { 
									    if(fn) {
									      result = fn.apply(context || this, arguments);
									      fn = null;
									    }
									
									    return result;
										};
										}
										var addNum_1 =once(function(){
											 num1 =	Number($("#support_1 figcaption ").text());
											 num1=num1+1;
											return num1;
										})
										var addNum_2 =once(function(){
											 num2 =	Number($("#support_2 figcaption ").text());
											 num2=num2+1;
											return num2;
										})
										$("#support_1 img").one('click',function(){
												addNum_1();
											$("#support_1 figcaption ").text(num1);
											$.ajax({
										contentType:"application/json",
										type:"get",
										url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/add_good_team?",
										data:{
											t_id:tId_1,
											t_good:num1
										},
										dataType:"jsonp",
										jsonpCallback:"flightHandler",
										cache:"false",
										async:true,
										success:function(data){
//												data = JSON.stringify(data);
//												alert(data);
											if(data.success=="1"){
												
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
										$("#support_2 img").one('click',function(){ 
												addNum_2();
											$("#support_2 figcaption ").text(num2);
										$.ajax({
										contentType:"application/json",
										type:"get",
										url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/add_good_team?",
										data:{
											t_id:tId_2,
											t_good:num2
										},
										dataType:"jsonp",
										jsonpCallback:"flightHandler",
										cache:"false",
										async:true,
										success:function(data){
//												data = JSON.stringify(data);
//												alert(data);
											if(data.success=="1"){
												
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
			},
			error:function(XMLHttpRequest, textStatus, errorThrown){
				alert(XMLHttpRequest.status);
				alert(XMLHttpRequest.readyState);
				alert(textStatus);
			}
					})
	
})
