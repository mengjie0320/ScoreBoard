
window.onload = function(){
	var pId = document.getElementById('container');
	var cId = document.getElementById('warpper');
	function divCenter(){
		var leftWidth = document.body.offsetWidth/2 - cId.offsetWidth/2;
//	alert(leftWidth);
	var topHeight = document.documentElement.clientHeight/2 - cId.offsetHeight/2;
//	alert(topHeight);
	cId.style.position = 'absolute';
	cId.style.top = topHeight + 'px';
	cId.style.left = leftWidth + 'px';
	}
	divCenter();
	window.onresize = function(){
		divCenter();
	}
	
	
	
} 
$(function(){
		/*生成验证码*/
	var code;
	var checkCode = document.getElementById('code');
	function createCode(){
		code = "";
		var codeLength = 4;//验证码的长度
		var random = new Array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');//随机数
		for(var i = 0;i < codeLength; i++){
			var index = Math.floor(Math.random()*36);
			code += random[index];
		}
		checkCode.innerHTML = code;
	}
		createCode();
	checkCode.onclick = function(){
		createCode();
	};
	/*检验验证码*/
	function validate(){
		var inputCode = document.getElementById('verify').value.toUpperCase();//将输入的验证码转为大写
		if(inputCode.length <= 0){
			$("#info").show().text("请输入验证码！");
			return false;
		}else if(inputCode != code){
			$("#info").show().text("验证码输入错误！");
			createCode();//刷新验证码
			document.getElementById('verify').value = "";//清空文本框
			return false;
		}else{
			$("#info").hide().text("");
//					myAjax();
			return true;
		}
		
	}
//	document.getElementById('login').onclick = function(){
//		validate();
//	}
//			function myAjax(){
				
			
	$("#login").bind("click",function(){
		var username = $("#user_name").val();
//		alert(typeof(username));
		var password = $("#password").val();
		
		setCookie("username",username,7);
		var prevUrl = getCookie("url");
			if(username == ""){
				$("#info").show().text("请填写用户名!");
				
			}else if(password == ""){
				$("#info").show().text("密码不能为空！");
			}else{
			if(validate()){
				$.ajax({
					contentType:"application/json",
					type:"get",
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Login/do_login?",  
//					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Login/login?",
					data:{
						phone_name:username,
						login_pwd:password	
					},
					dataType:"jsonp",
					jsonpCallback:"flightHandler",
					cache:false,
					async:true,
					success:function(datac){
						if(datac.success=="1"){
							$("#info").hide().text("");
							var regId = datac.data[0].reg_id;
							setCookie("reg_id",regId,7);
							if(prevUrl==""){
								window.location.href='http://hardtry.cn/ScoreBoard/yuntixiu/homepage.html';
							var username =	getCookie("username");
							}else{
									window.location.href=prevUrl;
							}

						}else{
							$("#info").show().text("用户名不存在！");
						}
					},
					 error:function(XMLHttpRequest, textStatus, errorThrown) {
					       alert(XMLHttpRequest.status);
					       alert(XMLHttpRequest.readyState);
					       alert(textStatus);
							}
		
				})
//			}
			}
			}
			})
	

})
