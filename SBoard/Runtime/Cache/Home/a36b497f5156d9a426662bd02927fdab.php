<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 thansitional//EN" "http://www.w3.org/th/xhtml1/DTD/xhtml1-thansitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>云体秀球队信息</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <include file="/ScoreBoard/index.php/Home/Index/left"></include>
	    <form enctype="multipart/form-data" action="/ScoreBoard/index.php/Home/Index/add_t" method="post">
	    	<table>
				<thead>
					<tr>
						<th>团队名称</th>
						<th>样貌精神</th>
						<th>成立时间</th>
						<th>团队地址</th>
						<th>联系方式（队长）</th>
						<th>球队类型</th>
						<th>团队简介</th>
						<th>团队口号</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th><input type="text" name="add_t_name" id=""></th>
						<th><input type="file" name="add_t_image" id=""></th>
						<th><input type="text" name="add_t_startTime" id=""></th>
						<th><input type="text" name="add_t_address" id=""></th>
						<th><input type="text" name="add_t_phone" id=""></th>
						<th><input type="text" name="add_t_cate" id=""></th>
						<th><input type="text" name="add_t_intho" id=""></th>
						<th><input type="text" name="add_t_watchword" id=""></th>
					</tr>
				</tbody>
			</table>
			<input type="submit" width="30px" height="70px" value="添加team信息" name="submit_add_t"> 
	   </form>
	<br><br>
	<?php if(is_array($team_info)): $i = 0; $__LIST__ = $team_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team_info): $mod = ($i % 2 );++$i;?><table>
			<thead>
				<th>
					<th>团队名称</th>
					<th>样貌精神</th>
					<th>成立时间</th>
					<th>团队地址</th>
					<th>联系方式（队长）</th>
					<th>球队类型</th>
					<th>团队简介</th>
					<th>团队口号</th>
					<th>赢过比赛次数</th>
					<th>输过比赛次数</th>
					<th>获邀次数</th>
					<th>主动邀约次数</th>
					<th>团队等级</th>
					<th>点赞数</th>
					<th>点差数</th>
					<th>修改</th>
					<th>删除</th>
				</th>
				<th>
					<th><?php echo ($team_info['t_name']); ?></th>
					<th><img src="/ScoreBoard/Public/info/team/image/<?php echo ($team_info['t_image']); ?>" width="60px" height ="40px"></th>
					<th><?php echo ($team_info['t_startTime']); ?></th>
					<th><?php echo ($team_info['t_address']); ?></th>
					<th><?php echo ($team_info['t_phone']); ?></th>
					<th><?php echo ($team_info['t_cate']); ?></th>
					<th><?php echo ($team_info['t_intho']); ?></th>
					<th><?php echo ($team_info['t_watchword']); ?></th>
					<th><?php echo ($team_info['t_winTime']); ?></th>
					<th><?php echo ($team_info['t_lostTime']); ?></th>
					<th><?php echo ($team_info['t_invitedTime']); ?></th>
					<th><?php echo ($team_info['t_inviteTime']); ?></th>
					<th><?php echo ($team_info['t_level']); ?></th>
					<th><?php echo ($team_info['t_good']); ?></th>
					<th><?php echo ($team_info['t_nogood']); ?></th>
					<th><a href="/ScoreBoard/index.php/Home/Index/change_t/<?php echo ($team_info['t_id']); ?>">修改</th>
					<th><a href="/ScoreBoard/index.php/Home/Index/delete_t/<?php echo ($team_info['t_id']); ?>">删除</th>
				</th>
			</thead>
		</table><?php endforeach; endif; else: echo "" ;endif; ?>
	
</body>
</html>