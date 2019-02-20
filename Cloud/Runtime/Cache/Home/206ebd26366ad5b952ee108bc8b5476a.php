<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>		
		<meta charset="UTF-8">
		<title></title>
		<meta name="uyan_auth" content="c016374b6e" />
	</head>
	<body>
		<form id="" enctype="multipart/form-data" method="post" action="/ScoreBoard/cloud.php/Home/Index/index">
            <div class="login-box">
                <label id="pwd-pic"class="login-label pwd-label" for="loginpic">上传图片</label>
                <input class="login" type="file" name="image" required="required" placeholder=""/>
            </div>
            <button type="submit" id="login-btn">提交</button>
        </form>
		<!-- UY BEGIN -->
		<div id="uyan_frame"></div>
		<script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=2126782"></script>
		<!-- UY END -->       
	</body>
</html>