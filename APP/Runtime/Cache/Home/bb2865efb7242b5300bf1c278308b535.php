<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>		
		<meta charset="UTF-8">
		<title></title>
		<meta name="uyan_auth" content="c016374b6e" />
	</head>
	<body>
		<p id="d" value="<?php echo ($a); ?>"><?php echo ($a); echo ($b); ?></p>
		<p id="a" hidden value="<?php echo ($a); ?>" accesskey="<?php echo ($a); ?>"><?php echo ($a); ?></p>
		<p id="b" hidden value="<?php echo ($b); ?>"><?php echo ($b); ?></p>
		<!--<form id="" enctype="multipart/form-data" method="post" action="/ScoreBoard/app.php/Home/Index/index">
            <div class="login-box">
                <label id="pwd-pic"class="login-label pwd-label" for="loginpic">上传图片</label>
                <input class="login" type="file" name="image" required="required" placeholder=""/>
            </div>
            <button type="submit" id="login-btn">提交</button>
        </form>-->
		<!-- UY BEGIN -->
		<!--<div id="uyan_frame"></div>
		<script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=2126782"></script>-->
		<!-- UY END -->    
		<script type="text/javascript">
		
			var a=document.getElementById("a");
			var b=document.getElementById("b");
			var d=document.getElementById("d");
			alert(a.getAttribute("id");
			alert(a.getAttribute("value");
			alert(a.getAttribute("accesskey");
			alert(d);
		</script>
	</body>
</html>