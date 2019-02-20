<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
        $this->display();
    }
/*
 * team
 */
	public function team(){
		$team = M('team');		
		import("@.ORG.Page");
		$count = $team -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$team_info = $team -> where('t_id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		// 赋值分页输出
		$this->assign("team_info",$team_info);
		// 赋值数据集
		$this->display();
	}	
	public function add_t(){
		try{
			$map_name['t_name'] = $_POST['add_t_name'];
			$map_phone['t_phone'] = $_POST['add_t_phone'];
			$map_cate['t_cate'] = $_POST['add_t_cate'];
			$team = M('team');
			$is_check = $team -> where($map_phone) ->where($map_cate) ->selete();
			if($is_check){
				$this->error("注册球队已存在",U("Home/Index/team"),1);
			}else{
				$is_name = $team ->where($map_cate) ->where($map_name) ->select();
				if($is_name){
					$this->error("注册同类球队名已存在",U("Home/Index/team"),1);
				}else{
					$upload = new \Think\Upload();
					//实例化上传类
					$upload -> maxSize = 3145728;
					// 设置附件上传大小 2M = 1024*1024*2=2097152 3M = 1024*1024*3=3145728
					$upload -> exts = array('jpg', 'jpeg', 'png', 'gif');
					$upload -> rootPath = './Public/info/team/image/';
					$info = $upload -> uploadOne($_FILES['add_t_image']);
					if($info){
						$data['t_name'] = $_POST['add_t_name'];
						$data['t_image'] = $info['savepath'] . $info['savename'];
						$data['t_startTime'] = $_POST['add_t_startTime'];
						$data['t_address'] = $_POST['add_t_address'];
						$data['t_phone'] = $_POST['add_t_phone'];
						$data['t_cate'] = $_POST['add_t_cate'];
						$data['t_intro'] = $_POST['add_t_intro'];
						$data['t_watchword'] = $_POST['add_t_watchword'];
						$res = $team -> add($data);
						if($res){
							$this->success("添加成功！",U("Home/Index/team"),1);
						}else{
							$this->error("添加错误，请汇报管理员！",U("Home/Index/team"),1);
						}
					}
					
				}
			}
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
    public function change_t(){
    	try{
    		$map['t_id'] = $_GET['t_id'];
			$team = M('team');
			$is_check = $team ->where($map) ->select();
			if($is_check){
				$this -> assign("is_check",$is_check);
				$this->display();
			}else{
				$this->error("操作错误，请汇报管理员！",U("Home/Index/team"),1);
			}		
    	}catch(Exception $e){
			$e ->getMessage();
		}    	
	}
	public function do_change_t(){
		try{
			$map_name['t_name'] = $_POST['change_t_name'];
			$map_phone['t_phone'] = $_POST['change_t_phone'];
			$map_cate['t_cate'] = $_POST['change_t_cate'];
			$team = M('team');
			$is_check = $team -> where($map_phone) ->where($map_cate) ->selete();
			if(!$is_check){
				$this->error("球队不存在",U("Home/Index/team"),1);
			}else{
				$is_name = $team ->where($map_cate) ->where($map_name) ->select();
				if($is_name){
					$this->error("同类球队名已存在",U("Home/Index/team"),1);
				}else{
					$upload = new \Think\Upload();
					//实例化上传类
					$upload -> maxSize = 3145728;
					// 设置附件上传大小 2M = 1024*1024*2=2097152 3M = 1024*1024*3=3145728
					$upload -> exts = array('jpg', 'jpeg', 'png', 'gif');
					$upload -> rootPath = './Public/info/team/image/';
					$info = $upload -> uploadOne($_FILES['change_t_image']);
					if($info){
						$data['t_name'] = $_POST['change_t_name'];
						$data['t_image'] = $info['savepath'] . $info['savename'];
						$data['t_startTime'] = $_POST['change_t_startTime'];
						$data['t_changeress'] = $_POST['change_t_changeress'];
						$data['t_phone'] = $_POST['change_t_phone'];
						$data['t_cate'] = $_POST['change_t_cate'];
						$data['t_intro'] = $_POST['change_t_intro'];
						$data['t_watchword'] = $_POST['change_t_watchword'];
						$res = $team -> save($data);
						if($res){
							$this->success("修改成功！",U("Home/Index/team"),1);
						}else{
							$this->error("修改错误，请汇报管理员！",U("Home/Index/team"),1);
						}
					}					
				}
			}		
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
	public function delete_t(){
		try{
			if($_SESSION['admin_limit'] == '1'){
				$map['t_id'] = $_GET['t_id'];
				$team = M('team');
				$is_check = $team -> where($map) ->selete();
				if($is_check){
					$res = $team -> where($map) ->delete();
					if($res){
						$this->success("删除成功！",U("Home/Index/team"),1);
					}else{
						$this->error("删除错误，请汇报管理员！",U("Home/Index/team"),1);
					}
				}			
			}else{
				$this ->error("您已经越权！",U("Home/Index/team"),3);
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
/*
 * user&&member
 */
    public function user(){    	
    	$reguser = M('reguser');
		import("@.ORG.Page");
		$count = $reguser -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$data = $reguser -> where('reg_id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
	    $show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		$this->assign("data",$data);
		$this->display();
    }
	public function member(){
		$no_reguser = M('no_reguser');
		import("@.ORG.Page");
		$count = $no_reguser -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$data = $no_reguser -> where('no_regid') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		$this->assign("data",$data);
		$this->display();
	}
/*
 * pk
 */
	public function pk(){
		$pk = M('pk');
		import("@.ORG.Page");
		$count = $pk -> count();
		$Page = new \Think\Page($count, 8);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$pk_info = $pk -> where('t_id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		$this->assign("pk_info",$pk_info);
		$this->display();
	}
	public function add_pk(){
		try{
			$map['t_id1'] = $_POST['add_pk_t_id1'];
			$map['t_id2'] = $_POST['add_pk_t_id2'];
			$pk = M('pk');
			$is_check = $pk -> where($map) ->selete();
			if($is_check){
				$this->error("pk赛已存在",U("Home/Index/pk"),1);
			}else{
                $upload = new \Think\Upload();
				//实例化上传类
				$upload -> maxSize = 3145728;
				// 设置附件上传大小 2M = 1024*1024*2=2097152 3M = 1024*1024*3=3145728
				$upload -> exts = array('jpg', 'jpeg', 'png', 'gif');
				$upload -> rootPath = './Public/info/pk/image/';
				$info1 = $upload -> uploadOne($_FILES['add_pk_image1']);
				$info2 = $upload -> uploadOne($_FILES['add_pk_image2']);
				$info3 = $upload -> uploadOne($_FILES['add_pk_image3']);
				
				$accessKey = '-ESxi5g3EQ6Dr0ZhJzIGsc_GgsIp5IGZnHnWwiCc';
			    $secretKey = 'qp_wu634M8xfk1JIQdwrzvCGkMkmx2_mlNDSK8Aw';
			    vendor('Qiniu.autoload');
			     // 初始化签权对象
			    $auth = new \Qiniu\Auth($accessKey, $secretKey);
			    $bucket='meng';
			     //生成上传Token
			    $token=$auth->uploadToken($bucket);
			     //构建UploadManager对象
			    $uploadMgr=new \Qiniu\Storage\UploadManager();
			     //在资源管理类 BucketManager 中主要负责空间中文件的管理： 复制，移动，删除，获取元信息，修改Mime，拉取文件到七牛空间，列取文件
			     //初始化BucketManager
			    $bucketMgr = new \Qiniu\Storage\BucketManager($auth);
			    $key = $_FILES['file']['name'];
					$filePath = $_FILES['file']['tmp_name'];  
			    // 调用 UploadManager 的 putFile 方法进行文件的上传
			    list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);   
			    //有错误
			    if ($err !== null) {
			        var_dump($err);	
			    }else{
			    	$this -> success('上传成功');
					$url = "http://offiv0yzx.bkt.clouddn.com/".$ret['add_pk_video'];
			    }
				if($info1&&$info2&&$info3){
					$data['t_id1'] = $_POST['add_pk_t_id1'];
					$data['t_id2'] = $_POST['add_pk_t_id2'];
					$data['intro'] = $_POST['add_pk_intro'];
					$data['score1'] = $_POST['add_pk_score1'];
					$data['score2'] = $_POST['add_pk_score2'];
					$data['image1'] = $info1['savepath'] . $info1['savename'];
					$data['image2'] = $info2['savepath'] . $info2['savename'];
					$data['image3'] = $info3['savepath'] . $info3['savename'];
					$data['video'] = $url;
					$data['time'] = $_POST['add_pk_time'];
					$data['place'] = $_POST['add_pk_place'];
					$data['sb_id'] = $_POST['add_pk_sb_id'];
					$res = $pk -> add($data);
					if($res){
						$this->success("添加成功！",U("Home/Index/pk"),1);
					}else{
						$this->error("添加错误，请汇报管理员！",U("Home/Index/pk"),1);
					}
				}				
			}
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function change_pk(){
    	try{
    		$map['pk_id'] = $_GET['pk_id'];
			$pk = M('pk');
			$is_check = $pk ->where($map) ->select();
			if($is_check){
				$this -> assign("is_check",$is_check);
				$this->display();
			}else{
				$this->error("操作错误，请汇报管理员！",U("Home/Index/pk"),1);
			}		
    	}catch(Exception $e){
			$e ->getMessage();
		}    	
	}
    public function do_change_pk(){
		try{
			$map['pk_id'] = $_GET['pk_id'];
			$pk = M('pk');
			$is_check = $pk -> where($map) ->select();
			if($is_check){
				$upload = new \Think\Upload();
				//实例化上传类
				$upload -> maxSize = 3145728;
				// 设置附件上传大小 2M = 1024*1024*2=2097152 3M = 1024*1024*3=3145728
				$upload -> exts = array('jpg', 'jpeg', 'png', 'gif');
				$upload -> rootPath = './Public/info/pk/image/';
				$info1 = $upload -> uploadOne($_FILES['add_pk_image1']);
				$info2 = $upload -> uploadOne($_FILES['add_pk_image2']);
				$info3 = $upload -> uploadOne($_FILES['add_pk_image3']);
				if($info1&&$info2&&$info3){
					$data['t_id1'] = $_POST['change_pk_t_id1'];
					$data['t_id2'] = $_POST['change_pk_t_id2'];
					$data['intro'] = $_POST['change_pk_intro'];
					$data['score1'] = $_POST['change_pk_score1'];
					$data['score2'] = $_POST['change_pk_score2'];
					$data['image1'] = $info1['savepath'] . $info1['savename'];
					$data['image2'] = $info2['savepath'] . $info2['savename'];
					$data['image3'] = $info3['savepath'] . $info3['savename'];
					$data['time'] = $_POST['change_pk_time'];
					$data['place'] = $_POST['change_pk_place'];
					$data['sb_id'] = $_POST['change_pk_sb_id'];
					$res = $pk -> where($map)->save($data);
					if($res){
						$this->success("修改成功！",U("Home/Index/pk"),1);
					}else{
						$this->error("修改错误，请汇报管理员！",U("Home/Index/pk"),1);
					}
				}
				
			}else{				
				$this->error("此比赛不存在，请汇报管理员！",U("Home/Home/change_pk"),1);		
			}						
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
	public function delete_pk(){
		try{
			if($_SESSION['admin_limit'] == '1'){
				$map['pk_id'] = $_GET['pk_id'];
				$pk = M('pk');
				$is_check = $pk -> where($map) ->selete();
				if($is_check){
					$res = $pk -> where($map) ->delete();
					if($res){
						$this->success("删除成功！",U("Home/Index/pk"),1);
					}else{
						$this->error("删除错误，请汇报管理员！",U("Home/Index/pk"),1);
					}
				}			
			}else{
				$this ->error("您已经越权！",U("Home/Index/pk"),3);
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
/*
 * mscore
 */
	public function mscore(){
		$tm = M('tm_score');
		import("@.ORG.Page");
		$count = $tm -> where($map) -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$tm_info = $tm -> where('id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		$this->assign("tm_info",$tm_info);
		$this->display();
	}
	public function add_ms(){
		try{
			$map['t_id'] = $_POST['add_ms_t_id'];
			$map['member_id'] = $_POST['add_ms_member_id'];
			$map['pk_id'] = $_POST['add_ms_pk_id'];
			$tm_score = M('tm_score');
			$is_check = $tm_score -> where($map) ->selete();
			if($is_check){
				$this->error("该成员成绩已存在，您可以选择修改",U("Home/Index/mscore"),1);
			}else{
				$data['t_id'] = $_POST['add_ms_t_id'];
				$data['member_id'] = $_POST['add_ms_member_id'];
				$data['ms_id'] = $_POST['add_ms_pk_id'];
				$data['m_score'] = $_POST['add_ms_m_score'];
				$res = $tm_score -> add($data);
				if($res){
					$this->success("添加成功！",U("Home/Index/mscore"),1);
				}else{
					$this->error("添加错误，请汇报管理员！",U("Home/Index/mscore"),1);
				}
			}
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function change_ms(){
		try{
    		$map['id'] = $_GET['id'];
			$tm_score = M('tm_score');
			$is_check = $tm_score ->where($map) ->select();
			if($is_check){
				$this -> assign("is_check",$is_check);
				$this->display();
			}else{
				$this->error("操作错误，请汇报管理员！",U("Home/Index/mscore"),1);
			}		
    	}catch(Exception $e){
			$e ->getMessage();
		} 
	}
	public function do_change_ms(){
		try{
			$map['id'] = $_GET['id'];
			$mscore = M('tm_score');				
			$check = $mscore ->where($map) ->select();
			if($check){
				$data['t_id'] = $_POST['change_ms_t_id'];
				$data['member_id'] = $_POST['change_ms_member_id'];
				$data['pk_id'] = $_POST['change_ms_pk_id'];
				$data['m_score'] = $_POST['change_ms_m_score'];
				$res = $mscore -> where($map) ->save($data);
				if($res){
					$this->success("修改成功！",U("Home/Index/mscore"),1);
				}else{
					$this->error("修改错误，请汇报管理员！",U("Home/Index/mscore"),1);
				}	
			}else{
				$this->error("不存在，请汇报管理员！",U("Home/Index/mscore"),1);					
			}				
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
	public function delete_ms(){
		try{
			if($_SESSION['admin_limit'] == '1'){
				$map['id'] = $_GET['id'];
				$tm_score = M('tm_score');
				$is_check = $tm_score -> where($map) ->selete();
				if($is_check){
					$res = $tm_score -> where($map) ->delete();
					if($res){
						$this->success("删除成功！",U("Home/Index/mscore"),1);
					}else{
						$this->error("删除错误，请汇报管理员！",U("Home/Index/mscore"),1);
					}
				}			
			}else{
				$this ->error("您已经越权！",U("Home/Index/mscore"),3);
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
/*
 * news
 */
    public function news(){
    	$news = M('news');
		import("@.ORG.Page");
		$count = $news -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$news_info = $news -> where('news_id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		$this->assign("news_info",$news_info);
    	$this->display();
    }
	public function add_news(){
		try{
			$news = M('news');
			$data['pk_id'] = $_POST['add_news_pk_id'];
			$data['news'] = $_POST['add_news_news'];
			$res = $news -> add($data);
			if($res){
				$this->success("添加成功！",U("Home/Index/news"),1);
			}else{
				$this->error("添加错误，请汇报管理员！",U("Home/Index/news"),1);
			}
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function change_news(){
		try{
    		$map['news_id'] = $_GET['news_id'];
			$news = M('news');
			$is_check = $news ->where($map) ->select();
			if($is_check){
				$this -> assign("is_check",$is_check);
				$this->display();
			}else{
				$this->error("操作错误，请汇报管理员！",U("Home/Index/news"),1);
			}		
    	}catch(Exception $e){
			$e ->getMessage();
		} 
	}
	public function do_change_news(){
		try{
			$map['news_id'] = $_GET['news_id'];	
			$news = M('news');
			$check = $news ->where($map) ->select();
			if($check){
				$data['pk_id'] = $_POST['change_news_pk_id'];
				$data['news'] = $_POST['change_news_news'];;
				$res = $news -> save($data);
				if($res){
					$this->success("修改成功！",U("Home/Index/news"),1);
				}else{
					$this->error("修改错误，请汇报管理员！",U("Home/Index/news"),1);
				}			
			}else{
				$this->error("不存在，请汇报管理员！",U("Home/Index/mscore"),1);
			}									
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function delete_news(){
		try{
			if($_SESSION['admin_limit'] == '1'){
				$map['news_id'] = $_GET['news_id'];
				$news = M('news');
				$is_check = $news -> where($map) ->selete();
				if($is_check){
					$res = $news -> where($map) ->delete();
					if($res){
						$this->success("删除成功！",U("Home/Index/news"),1);
					}else{
						$this->error("删除错误，请汇报管理员！",U("Home/Index/news"),1);
					}
				}			
			}else{
				$this ->error("您已经越权！",U("Home/Index/news"),3);
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
/*
 * order
 */
    public function order(){
    	$order = M('order');
		import("@.ORG.Page");
		$count = $order -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$order_info = $order -> where('news_id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		$this->assign("order_info",$order_info);
    	$this->display();
    }
	public function add_order(){
		try{
			$order = M('order');
			$data['reg_id'] = $_POST['add_order_reg_id'];
			$data['sb_id'] = $_POST['add_order_sb_id'];
			$data['shopTime'] = $_POST['add_order_shopTime'];
			$data['is_paid'] = $_POST['add_order_is_paid'];
			$data['price'] = $_POST['add_order_price'];
			$res = $order -> add($data);
			if($res){
				$this->success("添加成功！",U("Home/Index/order"),1);
			}else{
				$this->error("添加错误，请汇报管理员！",U("Home/Index/order"),1);
			}
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function change_order(){
		try{
    		$map['order_id'] = $_GET['order_id'];
			$order = M('order');
			$is_check = $order ->where($map) ->select();
			if($is_check){
				$this -> assign("is_check",$is_check);
				$this->display();
			}else{
				$this->error("操作错误，请汇报管理员！",U("Home/Index/order"),1);
			}		
    	}catch(Exception $e){
			$e ->getMessage();
		} 
	}
	public function do_change_order(){
		try{
			$map['order_id'] = $_GET['order_id'];	
			$order = M('order');
			$check = $order ->where($map) ->select();
			if($check){
				$data['reg_id'] = $_POST['change_order_reg_id'];
				$data['sb_id'] = $_POST['change_order_sb_id'];
				$data['shopTime'] = $_POST['change_order_shopTime'];
				$data['is_paid'] = $_POST['change_order_is_paid'];
				$data['price'] = $_POST['change_order_price'];
				$res = $order -> where($map)->save($data);
				if($res){
					$this->success("修改成功！",U("Home/Index/order"),1);
				}else{
					$this->error("修改错误，请汇报管理员！",U("Home/Index/order"),1);
				}			
			}else{
				$this->error("不存在，请汇报管理员！",U("Home/Index/order"),1);
			}									
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function delete_order(){
		try{
			if($_SESSION['admin_limit'] == '1'){
				$map['order_id'] = $_GET['order_id'];
				$order = M('order');
				$is_check = $order -> where($map) ->selete();
				if($is_check){
					$res = $order -> where($map) ->delete();
					if($res){
						$this->success("删除成功！",U("Home/Index/order"),1);
					}else{
						$this->error("删除错误，请汇报管理员！",U("Home/Index/order"),1);
					}
				}			
			}else{
				$this ->error("您已经越权！",U("Home/Index/order"),3);
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
/*
 * scoreboard
 */
    public function sb(){
    	$sb = M('scoreboard');
		import("@.ORG.Page");
		$count = $sb -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$sb_info = $sb -> where('news_id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		$this->assign("sb_info",$sb_info);
    	$this->display();
    }
	public function add_sb(){
		try{
			$sb = M('scoreboard');
			$map['sb_nickname'] = $_POST['add_sb_sb_nickname'];			
			$check_name = $sb ->where($map) -> select();
			if($check_name){
				$this->error("昵称已存在",U("Home/Index/scoreboard"),1);
			}else{
				$data['sb_pwd'] = $_POST['add_sb_sb_pwd'];
			    $data['sb_nickname'] = $_POST['add_sb_sb_nickname'];
				$res = $sb -> add($data);
				if($res){
					$this->success("添加成功！",U("Home/Index/scoreboard"),1);
				}else{
					$this->error("添加错误，请汇报管理员！",U("Home/Index/scoreboard"),1);
				}
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function change_sb(){
		try{
    		$map['sb_id'] = $_GET['sb_id'];
			$sb = M('scoreboard');
			$is_check = $sb ->where($map) ->select();
			if($is_check){
				$this -> assign("is_check",$is_check);
				$this->display();
			}else{
				$this->error("操作错误，请汇报管理员！",U("Home/Index/scoreboard"),1);
			}		
    	}catch(Exception $e){
			$e ->getMessage();
		} 
	}
	public function do_change_sb(){
		try{
			$map['sb_id'] = $_GET['sb_id'];	
			$sb = M('scoreboard');
			$check = $sb ->where($map) ->select();
			if($check){
				$map_nick['sb_nickname'] = $_POST['add_sb_sb_nickname'];			
				$check_name = $sb ->where($map_nick) -> select();
				if($check_name){
					$this->error("昵称已存在",U("Home/Index/scoreboard"),1);
				}else{
//					$data['sb_pwd'] = $_POST['change_sb_sb_pwd'];
				    $data['sb_nickname'] = $_POST['change_sb_sb_nickname'];
					$res = $sb -> where($map) ->save($data);
					if($res){
						$this->success("修改成功！",U("Home/Index/scoreboard"),1);
					}else{
						$this->error("修改错误，请汇报管理员！",U("Home/Index/scoreboard"),1);
					}	
				}
			}else{
				$this->error("不存在，请汇报管理员！",U("Home/Index/scoreboard"),1);
			}									
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function delete_sb(){
		try{
			if($_SESSION['admin_limit'] == '1'){
				$map['sb_id'] = $_GET['sb_id'];
				$sb = M('scoreboard');
				$is_check = $sb -> where($map) ->selete();
				if($is_check){
					$res = $sb -> where($map) ->delete();
					if($res){
						$this->success("删除成功！",U("Home/Index/scoreboard"),1);
					}else{
						$this->error("删除错误，请汇报管理员！",U("Home/Index/scoreboard"),1);
					}
				}			
			}else{
				$this ->error("您已经越权！",U("Home/Index/scoreboard"),3);
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
/*
 * admin
 */
	public function admin(){
		$admin = M('admin');
		import("@.ORG.Page");
		$count = $admin -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$admin_info = $admin -> where('news_id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		// 分页显示输出
		//dump($show);       //dump出来是一个空数组***************
		$this -> assign('page', $show);
		$this->assign("admin_info",$admin_info);
    	$this->display();
    }
	public function add_admin(){
		try{
			$admin = M('admin');
			$map['admin_name'] = $_POST['add_admin_admin_name'];			
			$check_name = $admin ->where($map) -> select();
			if($check_name){
				$this->error("昵称已存在",U("Home/Index/admin"),1);
			}else{
				$data['admin_pwd'] = $_POST['add_admin_admin_pwd'];
			    $data['admin_name'] = $_POST['add_admin_admin_name'];
			    $data['admin_limit'] = $_POST['add_admin_admin_limit'];
				$res = $admin -> add($data);
				if($res){
					$this->success("添加成功！",U("Home/Index/admin"),1);
				}else{
					$this->error("添加错误，请汇报管理员！",U("Home/Index/admin"),1);
				}
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function change_admin(){
		try{
    		$map['admin_id'] = $_GET['admin_id'];
			$admin = M('admin');
			$is_check = $admin ->where($map) ->select();
			if($is_check){
				$this -> assign("is_check",$is_check);
				$this->display();
			}else{
				$this->error("操作错误，请汇报管理员！",U("Home/Index/admin"),1);
			}		
    	}catch(Exception $e){
			$e ->getMessage();
		} 
	}
	public function do_change_admin(){
		try{
			$map['admin_id'] = $_GET['admin_id'];	
			$admin = M('admin');
			$check = $admin ->where($map) ->select();
			if($check){
				$map_nick['admin_name'] = $_POST['add_admin_admin_name'];			
				$check_name = $admin ->where($map_nick) -> select();
				if($check_name){
					$this->error("昵称已存在",U("Home/Index/admin"),1);
				}else{
//					$data['admin_pwd'] = $_POST['change_admin_admin_pwd'];
				    $data['admin_name'] = $_POST['change_admin_admin_name'];
				    $data['admin_limit'] = $_POST['change_admin_admin_limit'];
					$res = $admin -> where($map) ->save($data);
					if($res){
						$this->success("修改成功！",U("Home/Index/admin"),1);
					}else{
						$this->error("修改错误，请汇报管理员！",U("Home/Index/admin"),1);
					}	
				}
			}else{
				$this->error("不存在，请汇报管理员！",U("Home/Index/admin"),1);
			}									
		}catch(Exception $e){
			$e ->getMessage();
		}
	}
	public function delete_admin(){
		try{
			if($_SESSION['admin_limit'] == '1'){
				$map['admin_id'] = $_GET['admin_id'];
				$admin = M('admin');
				$is_check = $admin -> where($map) ->selete();
				if($is_check){
					$res = $admin -> where($map) ->delete();
					if($res){
						$this->success("删除成功！",U("Home/Index/admin"),1);
					}else{
						$this->error("删除错误，请汇报管理员！",U("Home/Index/admin"),1);
					}
				}			
			}else{
				$this ->error("您已经越权！",U("Home/Index/admin"),3);
			}			
		}catch(Exception $e){
			$e ->getMessage();
		}		
	}
    public function admin_message(){
    	$admin_mes = M('admin_message');
        $map['admin_name'] = $_SESSION['name'];	
		$admin = M('admin');
		$res1 = $admin -> where($map) ->select();
		if($res1){
			$map1['admin_id'] = $res1[0]['admin_id'];
			$res = $admin_mes ->where($map1)-> select();
			if($res){
				import("@.ORG.Page");
				$count = $admin_mes ->where($map1)-> count();
				$Page = new \Think\Page($count, 20);
				$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
				$list = $admin_mes -> where('id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
				$show = $Page -> show();
				$this -> assign('page', $show);
				$this -> assign('list', $list);
				$this->display();
			}
		}		
    }
	public function delete_mes(){
		$map['id'] = $_GET['id'];
		$admin_mes = M('admin_message');
		$res = $admin_mes ->where($map) ->delete();
		if($res){
			$this->success("删除成功！",U("Home/Index/admin_message"),1);
		}else{
			$this->error("删除错误，请汇报管理员！",U("Home/Index/admin_message"),1);
		}
	}
/*
 * left
 */
	public function left(){
		$admin_limit = $_SESSION['admin_limit'];
		$this->assign("admin_limit",$admin_limit);
		$this->display();
	}
/*
 * search
 */
    public function search_t(){
    	$searchtext = $_POST['searchtext'];
		$team = M('team');
		$map_t['t_name'] = array('like', "%{$searchtext}%");
		$map_t['t_address'] = array('like', "%{$searchtext}%");
		$map_t['t_phone'] = array('like', "%{$searchtext}%");
		$map_t['t_cate'] = array('like', "%{$searchtext}%");
		$map_t['t_watchword'] = array('like', "%{$searchtext}%");
		$map_t['t_id'] = array('like', "%{$searchtext}%");
		$map_t['_logic'] = 'OR';
		import("@.ORG.Page");
		$count = $team -> where($map_t) -> count();
		$Page = new \Think\Page($count, 20);
		$nowPage = isset($_GET['p']) ? $_GET['p'] : 1;
		$list = $team -> where($map_t) -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
		$show = $Page -> show();
		$this -> assign('page', $show);
		$this -> assign('list', $list);
		$this -> display();
    }
}