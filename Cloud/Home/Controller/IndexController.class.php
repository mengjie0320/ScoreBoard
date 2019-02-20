<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index(){
		$this ->display();
	}
/*
 * 发布赛事   17.2.20 afternoon
 */
    public function publish_pk(){
    	try{
    		$callback = $_GET["callback"];
			$map['reg_id'] = $_GET['reg_id'];
			$check = M('reguser') -> where($map) -> select();
			if($check){
				$data['t_id1'] = $_GET['reg_id'];
				$data['time'] = $_POST['time'];
				$data['place'] = $_POST['place'];
				$data['intro'] = $_POST['intro'];
//				$data['pk_name'] = $_POST['pk_name'];
				$pk_id1 = M('user_team') -> where($map) -> select();//登记已发布战事队名
				$t_id1['t_id1'] = $pk_id1[0]['t_id'];
				$t_name = M('team') -> where($t_id1) -> select();
				$data['pk_name'] = $t_name[0]['t_name'];
				$data['state'] = 0;	
				$data['pk_character'] = 0;		
				$res = M('pk') -> add($data);
//				$ret_data = M('pk') -> select();
//				$data['pk_'] = 
				if($res){
					$level['t_level'] = $check[0]['t_level'] + 2;//增加能力值
					$add_level = M('team') -> where($map) ->save($level);
					$return["success"] = "1";
					$return["info"] = "发布赛事成功"; 
					$return['data'] = "";
				}else{
					$return["success"] = "0";
					$return["info"] = "发布赛事失败"; 
					$return['data'] = "";
				}
			}else{
				$return["success"] = "0";
				$return["info"] = "用户不存在，请汇报管理员！"; 
				$return['data'] = "";				
			}
			$result = json_encode($return);
			echo "flightHandler($result)";
//			$this -> ajaxReturn($return);
		}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }   	

/*
 * 应战  17.2.19 night
 */
    public function accept_pk(){
    	try{
    		$callback = $_GET["callback"];
			$map['reg_id'] = $_GET['reg_id'];
			$check = M('reguser') -> where($map) -> select();
			if($check){
				$check_team = M('user_team') -> where($map) ->select();
				if($check_team){
					$map_pk['pk_id'] = $_POST['pk_id'];				
					$res_state = M('pk') -> where($map_pk) -> select();
					if($res_state[0]['state'] != 0){					
						$return["success"] = "0";
						$return["info"] = "该比赛已经被接战，请重试！"; 
						$return['data'] = "";
					}else{
						$data['state'] = 2;
						$data['t_id2'] = $_GET['reg_id'];
						$pk_id1 = M('user_team') -> where($map) -> select();
						$pk_t_id['t_id'] = $pk_id1[0]['t_id']; //查询已存发布战队名字
						$pk_name = M('team') -> where($pk_t_id) -> select();
						$data['pk_name'] = $res_state[0]['pk_name'].'VS'.$pk_name[0]['t_name'];
						$res = M('pk') -> where($map_pk) -> save($data);
						if($res){
							$level['t_level'] = $check[0]['t_level'] + 2;//增加能力值
						    $add_level = M('team') -> where($map) ->save($level);
							
							$reg_id = $_GET['reg_id'];
							$to_id = $res_state[0]['t_id1'];
							$accept_name = M('team') ->where($map_pk) ->select();
							$message = $accept_name[0]['t_name']."接了您创建的比赛"."时间为".$res_state[0]['time']."地点为".$res_state[0]['place'];
							$this->message($reg_id,$to_id,$message);
							
							$return["success"] = "1";
							$return["info"] = "应战成功！"; 
							$return['data'] = "";
						}else{
							$return["success"] = "0";
							$return["info"] = "应战失败，请重试！"; 
							$return['data'] = "";
						}					
					}
				}else{
					$return["success"] = "0";
					$return["info"] = "无战队，请汇报管理员！"; 
					$return['data'] = "";
				}				
			}else{
				$return["success"] = "0";
				$return["info"] = "用户不存在，请汇报管理员！"; 
				$return['data'] = "";				
			}
			$result = json_encode($return);
			echo "flightHandler($result)";
//			$this -> ajaxReturn($return);
		}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }
/*
 * 展示个人参赛消息
 */	
    public function pk_myself(){
    	try{
    		$map['reg_id'] = $_GET['reg_id'];
    		$is_check = M('user_team') -> where($map) -> select();		
			if($is_check){
				$reg_league = M('reg_league') ->where($map) ->select();
				if($reg_league){
					$count1 = count($reg_league);
					for($i=0;$i<$count1;$i++){						
						$map_league['pk_id'] = $reg_league[$i]['pk_id'];
						$res_league = M('pk') -> where($map_league) ->select();															
						$data1[$i] = $res_league[0];
						$t_id1['t_id'] = $is_check[0]['t_id'];
						$t_name1 = M('team') -> where($t_id1) ->select();
						$data1[$i]['t_name1'] = $t_name1[0]['t_name'];
						$data1[$i]['t_good1'] = $t_name1[0]['t_good'];
						
						$t_id2['t_id'] = $res_league['t_id2'];
						$t_name2 = M('team') -> where($t_id2) ->select();
						$data1[$i]['t_name2'] = $t_name2[0][ 't_name'];
						$data1[$i]['t_good2'] = $t_name2[0]['t_good'];
					}					
				}
				$map_accept['t_id2'] = $is_check[0]['t_id'];
				$map_accept['pk_character'] = 0;
				$res_accept = M('pk') -> where($map_accept) ->select();
				if($res_accept){
					$count2 = count($res_accept);
					for($j=0;$j<$count2;$j++){
						$data2[$j] = $res_accept[$j];
						$t_id1['t_id'] = $res_accept[$j]['t_id1'];
						$t_name1 = M('team') -> where($t_id1) ->select();
						$data2[$j]['t_name1'] = $t_name1[0]['t_name'];
						$data2[$j]['t_good1'] = $t_name1[0]['t_good'];
						
						$t_id2['t_id'] = $is_check[0]['t_id'];
						$t_name2 = M('team') -> where($t_id2) ->select();
						$data2[$j]['t_name2'] = $t_name2[0]['t_name'];
						$data2[$j]['t_good2'] = $t_name2[0]['t_good'];						
					}					
				}
				
				$map_add['t_id1'] = $is_check[0]['t_id'];
				$map_add['pk_character'] = 0;
				$res_add = M('pk') -> where($map_add) ->select();
				if($res_add){
					$count3 = count($res_add);
					for($k=0;$k<$count3;$k++){
						$data3[$k] = $res_add[$k];
						$t_id1['t_id'] = $is_check[0]['t_id'];
						$t_name1 = M('team') -> where($t_id1) ->select();
						$data3[$k]['t_name1'] = $t_name1[0]['t_name'];
						$data3[$k]['t_good1'] = $t_name1[0]['t_good'];
						
						$t_id2['t_id'] = $res_add[$k]['t_id2'];
						$t_name2 = M('team') -> where($t_id2) ->select();
						$data3[$k]['t_name2'] = $t_name2[0]['t_name'];
						$data3[$k]['t_good2'] = $t_name2[0]['t_good'];
					}					
				}
				
				$map_date['t_id1'] = $is_check[0]['t_id'];
				$map_date['pk_character'] = 2;
				$res_date = M('pk') -> where($map_date) ->select();
				if($res_date){
					$count4 = count($res_date);
					for($p=0;$p<$count4;$p++){
						$data4[$p] = $res_date[$p];
						$t_id1['t_id'] = $is_check[0]['t_id'];
						$t_name1 = M('team') -> where($t_id1) ->select();
						$data4[$p]['t_name1'] = $t_name1[0]['t_name'];
						$data4[$p]['t_good1'] = $t_name1[0]['t_good'];
						
						$t_id2['t_id'] = $res_date[$p]['t_id2'];
						$t_name2 = M('team') -> where($t_id2) ->select();
						$data4[$p]['t_name2'] = $t_name2[0][ 't_name'];
						$data4[$p]['t_good2'] = $t_name2[0]['t_good'];
					}					
				}
								
				if($data1||$data2||$data3||$data4){
					$return["success"] = "1";
					$return["info"] = "返回参赛信息成功！"; 
					$return['data1'] = $data1;//创建的联赛信息1
					$return['data2'] = $data3;//发布信息0
					$return['data3'] = $data4;//主动约赛的2
					$return['data4'] = $data2;//接收赛事
				}else{
					$return["success"] = "1";
					$return["info"] = "无任何赛事信息，请汇报管理员！"; 
					$return['data'] = "";//创建的联赛信息
				}
			}else{
				$return["success"] = "0";
				$return["info"] = "您无战队，更无比赛信息！"; 
				$return['data'] = "";				
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
   * 点赞队
   */	
    public function add_good_team(){
    	try{
    		$callback = $_GET["callback"];
			$map['t_id'] = $_GET['t_id'];
			$data1['t_good'] = $_POST['t_good'];
    		$res = M('team') -> where($map) -> save($data1);
				if($res){
					$data = M('team') -> where($map) ->select();
					$return["success"] = "1";
					$return["info"] = "点赞成功！"; 
					$return['data'] = $data[0]['t_good'];
				}else{								
					$return["success"] = "0";
					$return["info"] = "点赞失败！"; 
					$return['data'] = "";
				}
				$result = json_encode($return);
				echo "flightHandler($result)";
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }
/*
 * 添加成员
 */	
    public function add_member(){
    	try{
    		$callback = $_GET["callback"];
			$t_name['t_name'] = $_POST['t_name'];
			$check_team = M('team') -> where($t_name) -> select();			
			if($check_team){
				$check_t['t_id'] = $check_team[0]['t_id'];
				$res_check_team = M('user_team') -> select();
				if($res_check_team){
					$return["success"] = "0";
					$return["info"] = "您的用户名下改队名已存在！"; 
					$return['data'] = "";
				}				
			}else{				 
				$res_team = M('team') -> add($t_name);
				$res_t_id = M('team') ->where($t_name)-> select();
				$t_id['t_id'] = $res_t_id[0]['t_id'];
				$data1['reg_id'] = $_POST['member1'];
				$data1['t_id'] = $res_t_id[0]['t_id'];
				$res1 = M('user_team') -> add($data1);
				$data2['reg_id'] = $_POST['member2'];
				$data2['t_id'] = $res_t_id[0]['t_id'];
				$res2 = M('user_team') -> add($data2);
				$data3['reg_id'] = $_POST['member3'];
				$data3['t_id'] = $res_t_id[0]['t_id'];
				$res3 = M('user_team') -> add($data3);
				$data4['reg_id'] = $_POST['member4'];
				$data4['t_id'] = $res_t_id[0]['t_id'];
				$res4 = M('user_team') -> add($data4);
				$data5['reg_id'] = $_GET['reg_id'];
				$data5['t_id'] = $res_t_id[0]['t_id'];
				$data5['cate'] = 1;
				$res5 = M('user_team') -> add($data5);
				if($res_team&&$res1&&$res2&&$res3&&$res4&&$res5){
					$return["success"] = "1";
					$return["info"] = "添加成功！"; 
					$return['data'] = "";
				}else{
					$return["success"] = "0";
					$return["info"] = "添加失败，请重新尝试或者找管理员！"; 
					$return['data'] = "";
				}
				
			}			
    		$result = json_encode($return);
			echo "flightHandler($result)";
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 检查即将添加的成员的存在
 */	
    public function check_member(){
    	try{
			$other_id['reg_name'] = $_GET['member_name'];
			$check_member = M('reguser') -> where($other_id) -> select();
			if($check_member){
				$return["success"] = "1";
				$return["info"] = "可正确添加成员！"; 
				$return['data'] = $check_member[0]['reg_id'];
			}else{
				$return["success"] = "0";
				$return["info"] = "无此用户，无法正确添加成员！"; 
				$return['data'] = "";
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 展示个人可管理并修改的信息
 */
    public function show_personal(){
    	try{
			$map['reg_id'] = $_GET['reg_id'];
			$check = M('reguser') -> where($map) -> select();
			if($check){
				$return["success"] = "1";
				$return["info"] = "获取数据成功！"; 
				$return['data'] = $check;
			}else{
				$return["success"] = "0";
				$return["info"] = "无此用户，请联系管理员！"; 
				$return['data'] = "";
			}
    		$this -> ajaxReturn($return);
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }
	
///*
// * 修改图片，或者上传图片
// */	
//  public function change_image(){
//  	try{
//  		$map['reg_id'] = $_GET['reg_id'];
//			$upload=new \Think\Upload();//实例化上传类
//	        $upload->maxSize = 3145728 ;// 设置附件上传大小 2M = 1024*1024*2=2097152 3M = 1024*1024*3=3145728
//	        $upload->exts =array('jpg','jpeg','png','gif');
//	        $upload->rootPath ='./public/image/personal/';
//	        $info = $upload->uploadOne($_FILES['image']);//?
//	        $data_image['reg_image'] = $info['savePath'].$info['saveName'];
//			$res = M('reguser') -> where($map) -> save($data_chg);	
//			if($res){
//				$data =  M('reguser') -> where($map) -> select();
//				$return["success"] = "1";
//				$return["info"] = "修改头像图片成功！"; 
//				$return['data'] = $data;
//			}else{
//				$return["success"] = "0";
//				$return["info"] = "修改头像图片失败！"; 
//				$return['data'] = "";
//			}
//$this -> ajaxReturn($return);
//  	}catch(Exception $e){
//		 	$e->getMessage(); 
//		}					
//  }
/*
  
/*
 * 修改昵称地址电话
 */	
    public function change_personal(){
    	try{
    		$callback = $_GET["callback"];
    		$map['reg_id'] = $_GET['reg_id'];
    		$is_check = M('reguser') -> where($map) -> select();			
			if($is_check){
				if($_POST['old_pwd'] != ""){
					if($_POST['old_pwd'] == $is_check[0]['reg_pwd']){
						$data_chg['reg_pwd'] = $_POST['change_pwd'];
						$res = M('reguser') -> where($map) -> save($data_chg);
						$data =  M('reguser') -> where($map) -> select();
					}else{
						$res = "";
					}					
				}else{
					if($_POST['change_nickname'] != ""){
						$data_chg['reg_nickname'] = $_POST['change_nickname'];
					}
					if($_POST['change_phone'] != ""){
						$data_chg['reg_phone'] = $_POST['change_phone'];
					}					
					if($_POST['change_address'] != ""){
						$data_chg['reg_address'] = $_POST['change_address'];
					}					
					$res = M('reguser') -> where($map) -> save($data_chg);
					$data =  M('reguser') -> where($map) -> select();
				}				
                
				if($res){
					$return["success"] = "1";
					$return["info"] = "修改成功！"; 
					$return['data'] = $data;
				}else{
					$return["success"] = "0";
					$return["info"] = "修改失败！"; 
					$return['data'] = "";
				}
			}else{
				$return["success"] = "0";
				$return["info"] = "用户不存在，请汇报管理员！"; 
				$return['data'] = "";				
			}
    		$result = json_encode($return);
			echo "flightHandler($result)";
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
///*
// * 点赞队
// */	
//  public function add_good(){
//  	try{
//  		$map['t_id'] = $_POST['t_id'];
//  		$is_check = M('team') -> where($map) -> select();
//			if($is_check){									
//				$map_add['t_good'] = 1+(int)$is_check[0]['t_good'];
//				$res = M('team') -> where($map) -> save($map_add);
//				if($res){
//					$data = M('pk') -> where($map_pk) ->select();
//					$return["success"] = "1";
//					$return["info"] = "点赞成功！"; 
//					$return['data'] = $data[0]['t_good'];
//				}else{								
//					$return["success"] = "0";
//					$return["info"] = "点赞失败！"; 
//					$return['data'] = "";
//				}
//			}else{
//				$return["success"] = "0";
//				$return["info"] = "队不存在，请汇报管理员！"; 
//				$return['data'] = "";				
//			}
//		    $this -> ajaxReturn($return);
//		}catch(Exception $e){
//	 	    $e->getMessage(); 
//		}
//  }
/*
 * 约赛推荐根据能力值推荐  17.2.24 afternoon
 */
	public function recommend_pk(){
		try{
			$map['reg_id'] = $_GET['reg_id'];
			$check = M('reguser') -> where($map) -> select();
			if($check){
				$return["success"] = "1";
				$return["info"] = "获取推荐成功"; 											
				$res_tid = M('user_team') -> where($map) ->select();
				if($res_tid){
					$map_next['t_id'] = $res_tid[0]['t_id'];
					$res_team = M('team') -> where($map_next) ->select();
					$map_end['t_level'] = array('ELT',$res_team[0]['t_level']);
					$map_end['t_id'] = array('neq',$res_team[0]['t_id']);
					$res = M('team') -> where($map_end) ->order('t_level desc') -> select();
					if($res){
						$count = count($res);
						for($i=0;$i<$count;$i++){
							$data1[$i]['t_id'] = $res[$i]['t_id'];
							$data1[$i]['t_name'] = $res[$i]['t_name'];
							$data1[$i]['t_level'] = $res[$i]['t_level'];
							$data1[$i]['t_wintime'] = $res[$i]['t_wintime'];
							$data1[$i]['t_losttime'] = $res[$i]['t_losttime'];
						}
						$return['data1'] = $data1;//局部
					}
				}else{
						$return['data1'] = "";//局部
				}	
				$map_all['t_id'] = array('neq',$res_tid[0]['t_id']);				
				$res_all = M('team') -> where($map_all) ->order('t_level desc') -> select();
			    if($res_all){
					$count = count($res_all);
					for($j=0;$j<$count;$j++){
						$data2[$j]['t_id'] = $res_all[$j]['t_id'];
						$data2[$j]['t_name'] = $res_all[$j]['t_name'];
						$data2[$j]['t_level'] = $res_all[$j]['t_level'];
						$data2[$j]['t_wintime'] = $res_all[$j]['t_wintime'];
						$data2[$j]['t_losttime'] = $res_all[$j]['t_losttime'];
					} 
					$return['data2'] = $data2;
				}else{
					$return['data2'] = "";
				}	
			}else{
				$return["success"] = "0";
				$return["info"] = "用户不存在，请汇报管理员！"; 
				$return['data'] = "";				
			}
			$this -> ajaxReturn($return);
		}catch(Exception $e){
		 	$e->getMessage(); 
		}
	}
/*
 * 信息
 */	
    public function message($reg_id,$to_id,$message){
    	try{
    		$data['reg_id'] = $reg_id;
			$data['to_id'] = $to_id;
			$data['mes_time'] = date("Y-m-d H:i:s",time());
			$data['message'] = $message;
//			dump($data);
			$res = M('message') -> add($data);
			if($res){
//				$return["message_success"] = 1;
			}else{
				$return["mes_success"] = 0;
				$return["mes_info"] = "消息没有发送成功，请汇报管理员！"; 
			}
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}    	
    }
/*
 * 显示信息
 */	
    public function show_mes(){
    	try{
    		$map['reg_id'] = $_GET['reg_id'];
    		$is_check = M('reguser') -> where($map) -> select();			
			if($is_check){
				$map_id['to_id'] = $_GET['reg_id'];
				$res = M('message') -> where($map_id) -> select();
				if($res){
					$count_mes = count($res);
					for($i=0;$i<$count_mes;$i++){
						$data[$i] = $res[$i]['message'];
					}
					$return["success"] = "1";
					$return["info"] = "返回信息成功！"; 
					$return['data'] = $data;
				}
			}else{
				$return["success"] = "0";
				$return["info"] = "用户不存在，请汇报管理员！"; 
				$return['data'] = "";				
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }

/*
 * 创联赛
 */	
    public function creative_League(){
    	try{
    		$callback = $_GET["callback"];
     		$league['reg_id'] = $_GET['reg_id']; 
     		$map['t_id1'] = $_GET['t_name1'];
			$map['t_id2'] = $_GET['t_name2'];
			$map['pk_name'] = $_GET['pk_name'];
			$map['time'] = $_GET['time'];
			$map['place'] = $_GET['place'];
			$map['pk_character'] = 1;			
			$check = M('pk') ->where($map)-> select();			
			if($check){				
				$return["success"] = "0";
				$return["info"] = "改联赛已存在，不能重复设置！"; 
				$return['data'] = "";				
			}else{
				$res = M('pk') -> add($map);
				$aa = M('pk') -> where($map) ->select();
				$league['pk_id'] = $aa[0]['pk_id'];
				$league['reg_id'] = $_GET['reg_id'];
				$res_league = M('reg_league') -> add($league);
				if($res&&$res_league){
					$return["success"] = "1";
					$return["info"] = "创联赛成功！"; 
					$return['data'] = "";
				}else{
					$return["success"] = "0";
					$return["info"] = "创联赛失败！"; 
					$return['data'] = "";
				}
			}
    		$result = json_encode($return);
			echo "flightHandler($result)";
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 去约赛
 */	
    public function date_to(){
    	try{
    		$callback = $_GET["callback"];
    		$map['reg_id'] = $_GET['reg_id'];
    		$is_check = M('reguser') -> where($map) -> select();			
			if($is_check){
				$data['t_id1'] = $_GET['reg_id'];
				$data['t_id2'] = $_GET['t_id2'];
				$data['time'] = $_GET['time'];
				$data['place'] = $_GET['place'];
				$data['pk_character'] = 2;
				$check = M('pk') -> where($data)->select;
				if($check){
					$return["success"] = "0";
					$return["info"] = "同时同地同对手的比赛已存在，这次请求失败！"; 
					$return['data'] = "";
				}else{
					$res = M('pk') -> add($data);
					if($res){
						$return["success"] = "1";
						$return["info"] = "约赛成功！"; 
						$return['data'] = "";
					}else{
						$return["success"] = "0";
						$return["info"] = "约赛失败！"; 
						$return['data'] = "";
					}
				}
			}else{
				$return["success"] = "0";
				$return["info"] = "用户不存在，请汇报管理员！"; 
				$return['data'] = "";				
			}
    		$result = json_encode($return);
			echo "flightHandler($result)";
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 取消已经发布或者接下的战事
 */	
    public function cancel_pk(){
    	try{
    		$callback = $_GET["callback"];
	    	$map['reg_id'] = $_GET['reg_id'];
			$is_check = M('reguser') -> where($map) -> select();			
			if($is_check){
				$map_a['pk_id'] = $_POST['pk_id'];
				$check = M('pk') ->where($map_a) -> select();
				if($check){
					if($check[0]['state'] == 1){
						$return["success"] = "0";
						$return["info"] = "该比赛已完成，不可修改！"; 
						$return['data'] = "";
					}else{
						$res = M('pk') ->where($map_a) ->delete();
						if($check[0]['character'] = 1){
							$map2['reg_id'] = $_GET['reg_id'];
							$map2['pk_id'] = $_GET['pk_id'];
							$res2 = M('reg_league') -> where($map2) ->delete();
						}
						if($res){
							$return["success"] = "1";
							$return["info"] = "取消成功！"; 
							$return['data'] = "";
						}else{
							$return["success"] = "0";
							$return["info"] = "取消失败，请汇报管理员！"; 
							$return['data'] = "";
						}
					}
				}else{
					$return["success"] = "0";
					$return["info"] = "该pk赛已不存在！"; 
					$return['data'] = "";
				}
			}else{
				$return["success"] = "0";
				$return["info"] = "用户不存在，请汇报管理员！"; 
				$return['data'] = "";				
			}
			$result = json_encode($return);
			echo "flightHandler($result)";
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
//  public function cancel_pk(){
//  	try{
//  		$callback = $_GET["callback"];
//  		    		$map['reg_id'] = $_GET['reg_id'];
//  		$is_check = M('reguser') -> where($map) -> select();			
//			if($is_check){
//				$map_pk1['pk_id'] = $_POST['pk_id'];
//				$map_pk1['t_id1'] = $_GET['reg_id'];
//				$map_pk2['pk_id'] = $_POST['pk_id'];
//				$map_pk2['t_id2'] = $_GET['reg_id'];
//				$check_id1 = M('pk') -> where($map_pk1) ->select();
//				$check_id2 = M('pk') -> where($map_pk2) ->select();
//				if($check_id1){
//					$res = M('pk') -> where($map_pk1) -> select();
//					if($res[0]['state'] = 1){
//						$data = M('pk') -> where($map_pk1) -> delete();
//						if($data){							
//							$return["success"] = "1";
//							$return["info"] = "已发布的赛事取消成功！"; 
//							$return['data'] = "";					 
//						}else{
//							$return["success"] = "0";
//							$return["info"] = "已发布的赛事取消失败，请汇报管理员！"; 
//							$return['data'] = "";
//						}
//					}else{
//						$return["success"] = "0";
//						$return["info"] = " 该比赛已完成，不能取消！"; 
//						$return['data'] = "";
//					}					
//				}else if($check_id2){
//					$t_id2['t_id'] = $check_id2[0]['t_id2'];
//					$t_name = M('team') -> where($t_id2) -> select();
//					$change_pk['state'] = 0;
//					$change_pk['t_id2'] = 0;
//					$change_pk['pk_name'] = $t_name[0]['t_name'];
//					$res = M('pk') -> where($map_pk2) -> select();
//					if($res[0]['state'] = 1){
//						$data = M('pk') -> where($map_pk2) -> delete();
//						if($data){							
//							$return["success"] = "1";
//							$return["info"] = "已发布的赛事取消成功！"; 
//							$return['data'] = "";					 
//						}else{
//							$return["success"] = "0";
//							$return["info"] = "已发布的赛事取消失败，请汇报管理员！"; 
//							$return['data'] = "";
//						}
//					}else{
//						$return["success"] = "0";
//						$return["info"] = " 该比赛已完成，不能取消！"; 
//						$return['data'] = "";
//					}
//				}else{
//					$return["success"] = "0";
//					$return["info"] = "无此pk赛！"; 
//					$return['data'] = "";
//				}
//			}else{
//				$return["success"] = "0";
//				$return["info"] = "用户不存在，请汇报管理员！"; 
//				$return['data'] = "";				
//			}
//  		$result = json_encode($return);
//			echo "flightHandler($result)";
//		}catch(Exception $e){
//	 	    $e->getMessage(); 
//		}
//  }
/*
 * 未知
 */	
// 	public function view(){
// 		try{
// 			$data_old = M('number') -> where('id = 1') ->select();
//			$data_new[0]['view_num'] = $data_old[0]['view_num'] + 1;
//			$res = M('number') -> where('id = 1') ->save($data_new);
//			if($res){
//				
//			}
// 		}catch(Exception $e){
//	 	    $e->getMessage(); 
//		}
// 	}
    public function aaa(){
    	try{
    		$sql = M('pk');
			import("@.ORG.Page");
			// 导入分页类
			$count = $sql -> where('pk_id') -> count();
			// 查询满足要求的总记录数
			//dump($count);
			$Page = new \Think\Page($count, 8);
			$nowPage = isset($_POST['p']) ? $_POST['p'] : 1;
			$list = $sql -> where('pk_id') -> limit($Page -> firstRow . ',' . $Page -> listRows) -> select();
			$show = $Page -> show();
//  		$map['reg_id'] = $_GET['reg_id'];
//  		$is_check = M('reguser') -> where($map) -> select();			
//			if($is_check){
//				
//			}else{
				$return["success"] = "1";
				$return["info"] = "用户不存在，请汇报管理员！"; 
				$return['data'] = $Page;				
//			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }

}