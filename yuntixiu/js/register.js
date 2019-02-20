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
	/*调注册接口*/
//	function flightHandler(data) {
//		alert(data);				/*jsonp 回调函数声明*/
//	}
$(function(){
	
function checkPhone(){ 
    var phone = document.getElementById('phone').value;
    if(!(/^1[34578]\d{9}$/.test(phone))){ 
     $("#info").show().text("手机号码格式有误，请重新填写！"); 
        return false; 
    } 
}
$("#phone").change(function(){
	var rtn = checkPhone();
	if(rtn==false){
	$(this).val("").focus();
	}
	return false;
})
	$("#btn").click(function(){
		var  phone = $("#phone").val();    	/*获取用户的手机号码*/
		var  username = $("#user_name").val();	/*获取用户的输入的用户名*/
		var  password = $("#password").val();	/*获取用户输入的密码*/
		var  password_confirm =$("#password_confirm").val();
		var flag=0;/*再次输入的密码*/
//		alert("手机："+phone+"用户名："+username+"密码："+password+"再次输入密码："+password_confirm);
			 if(phone == "" || username == "" || password == "" || password_confirm == ""){
//	 		alert();
				$("#info").show().text("请填写完整的信息！");
	 			return
	 		}else{
	 			$("#info").text("").hide();
	 		}
			 if(password == password_confirm){
			 	$("#info").text("").hide();
			 	/*调注册接口*/
	 	$.ajax({
	 				contentType:"application/json",
					type:"GET",
//					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Index/do_reg?", 
					url:"http://120.27.95.22/ScoreBoard/cloud.php/Home/Login/do_reg?",
					data:{ reg_name:username,
						    reg_pwd:password,
							reg_phone:phone
						},
					dataType:"jsonp",
					jsonp:"callback",
					jsonpCallback:"flightHandler",
					cache:"false",
					async:true, 
					success: function (data){
//						alert(JSON.stringify(data))
						if(data.success=="1"){
							setTimeout(function(){
							$("#info").show().text("恭喜，注册账号成功！");
							},50000000000000000000);
								flag=1;
								if(flag==1){
							setTimeout(function(){
								window.location.href="login.html";
							},1000) 
								}else{
									return false;
								}
						}else{
							$("#info").show().text('用户名已经存在，请重新注册！');
						}
						
				      },
					 error:function(XMLHttpRequest, textStatus, errorThrown) {
					       alert(XMLHttpRequest.status);
					       alert(XMLHttpRequest.readyState);
					       alert(textStatus);
								}
			})
			}
			 else{
					$("#info").show().text("两次密码输入不一致！");
			}
			})

			})
