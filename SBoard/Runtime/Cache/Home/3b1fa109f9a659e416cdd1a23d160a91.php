<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>云体秀登录</title>

<link href="/ScoreBoard/Public/CSS/login.css" rel="stylesheet" type="text/css"/>
</head>


<script>

</script>

<body >
<!--logo-->
<div id="top">
	<div id="logo">
    	<!--<a href="/ScoreBoard/index.php/Home/Index/index" target="_blank"><img  src="/ScoreBoard/Public/images/logo.png" alt="教练缘" /></a><b></b>-->
    </div>
</div>


<div id="warp">
	<div id="bg-pic">
    	<div id="login">
        	<div class="login-form">
                <h3>欢迎登录云体秀系统</h3>
                <!--<a href="/ScoreBoard/index.php/Home/register/register" target="_blank">注册</a>-->
                <form id="" enctype="multipart/form-data" method="post" action="/ScoreBoard/index.php/Home/Login/do_login">
                    <div class="login-box">
                        <span id="user-pic"class="login-label name-label" for="loginname"></span>
                        <input class="login" id="login-name" type="text" name="login_name" placeholder="用户名/手机号码"/>
                    </div>
                    <div class="login-box">
                        <label id="pwd-pic"class="login-label pwd-label" for="loginpwd"></label>
                        <input class="login" id="login-pwd" type="password" name="login_pwd" placeholder="密　码"/>
                    </div>                	
                    <!--验证码框及其显示-->
                    <div class="codes-box">
                     	<span id="verify"class="login-label name-label" for="verify"></span>
                        <input class="" id="verify" type="text" name="verify" placeholder="验证码"/>
                      </div>
                    <div class="codes-img">
                    	<img src="/ScoreBoard/index.php/Home/Login/verify"  alt="验证码"/>
                    </div>
                    <button type="submit" name="login-btn" id="login-btn"></button>
                </form>
            </div>

               
            <div class="safe">
                <input id="remember-me" class="remember" type="checkbox" />
                <label for="">记住我</label>
                <a  id="forget-pwd" class="" target="_blank" href="#">忘记密码？</a>      
            </div>
           </div>
        </div>
    </div>
</body>
</html>