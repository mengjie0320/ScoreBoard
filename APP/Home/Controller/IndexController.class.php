<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	echo "ddd";
    }
	public function car(){
    	$this -> display();
    }
/*
 * 地图
 */
	public function map(){
    	$a = $_GET['jingdu'];//经度
		$b = $_GET['weidu'];//纬度
//		dump($_GET['jingdu']);
//		dump($a);
//		dump($b);
		$this -> assign("a",$a);
		$this -> assign("b",$b);
		$this -> display();
    }
/*
 * 约赛推荐根据能力值推荐  17.2.14 afternoon
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
				$res_all = M('team') ->order('t_level desc') -> select();
			    if($res_all){
					$count = count($res_all);
					for($j=0;$j<$count;$j++){
						$data2[$j]['t_name'] = $res_all[$j]['t_name'];
						$data2[$j]['t_level'] = $res_all[$j]['t_level'];
						$data2[$j]['t_wintime'] = $res_all[$j]['t_wintime'];
						$data2[$j]['t_losttime'] = $res_all[$j]['t_losttime'];
					} 
					$return['data2'] = $data2;
				}else{
					$return['data2'] = "";
				}	
	
//				}else{
//					$return["success"] = "0";
//					$return["info"] = "获取推荐失败"; 
//					$return['data1'] = "";
//					$return['data2'] = "";
//				}
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
 * 约赛推荐---推荐全部  17.2.14 afternoon
 */
//	public function recommend_pk_all(){
//		try{
////			$map['reg_id'] = $_GET['reg_id'];
////			$check = M('reguser') -> where($map) -> select();
////			if($check){				
//				
////			}else{
////				$return["success"] = "0";
////				$return["info"] = "用户不存在，请汇报管理员！"; 
////				$return['data'] = "";				
////			}
//			$this -> ajaxReturn($return);
//		}catch(Exception $e){
//		 	$e->getMessage(); 
//		}
//	}
/*
 * 发布赛事   17.2.20 afternoon
 */
    public function publish_pk(){
    	try{
			$map['reg_id'] = $_GET['reg_id'];
			$t_id = M('user_team') -> where($map) -> select();
//			$check = M('reguser') -> where($map) -> select();
			if($t_id){				
				$data['t_id1'] = $t_id[0]['t_id'];
				$data['time'] = $_GET['time'];
				$data['place'] = $_GET['place'];
				$data['intro'] = $_GET['intro'];
				$data['pk_name'] = $_GET['pk_name'];
				$t_id1['t_id'] = $t_id[0]['t_id'];//登记已发布战事队名
				$t_name = M('team') -> where($t_id1) -> select();
				$data['pk_name'] = $t_name[0]['t_name'];
				$data['state'] = 0;	
				$data['pk_character'] = 0;		
				$res = M('pk') -> add($data);
//				$ret_data = M('pk') -> select();
//				$data['pk_'] = 
				if($res){
					$level['t_level'] = $t_id[0]['t_level'] + 2;//增加能力值
					$add_level = M('team') -> where($t_id1) ->save($level);
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
				$return["info"] = "队不存在，不能发布战事！"; 
				$return['data'] = "";				
			}
			$this -> ajaxReturn($return);
		}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }   	

/*
 * 应战  17.2.17 night
 */
    public function accept_pk(){
    	try{
			$map['reg_id'] = $_GET['reg_id'];
			$check = M('reguser') -> where($map) -> select();
			if($check){
				$check_team = M('user_team') -> where($map) ->select();
				if($check_team){
					$map_pk['pk_id'] = $_GET['pk_id'];				
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
			$this -> ajaxReturn($return);
		}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }
/*
 * 点赞ren
 */	
    public function add_good(){
    	try{
    		$map['reg_id'] = $_GET['reg_id'];
    		$is_check = M('reguser') -> where($map) -> select();
			if($is_check){									
				$map_add['reg_good'] = 1+(int)$is_check[0]['reg_good'];
				$res = M('reguser') -> where($map) -> save($map_add);
				if($res){
					$return["success"] = "1";
					$return["info"] = "点赞成功！"; 
					$return['data'] = "";
				}else{								
					$return["success"] = "0";
					$return["info"] = "点赞失败！"; 
					$return['data'] = "";
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
 * 比赛分数增加
 */	
    public function add_score(){
    	try{
//  		$map['reg_id'] = $_GET['reg_id'];
//  		$is_check = M('reguser') -> where($map) -> select();			
//			if($is_check){
				$map_pk['pk_id'] = $_GET['pk_id'];
				$is_pk = M('pk') -> where($map_pk) ->select();
				if($is_pk){
					if($_GET['team'] == '1'){					
						$res_score = M('pk') -> where($map_pk) ->select();
						$map_add['score1'] = (int)$_GET['add_score']+(int)$res_score[0]['score1'];
						$res = M('pk') -> where($map_pk) -> save($map_add);
						if($res){
							$res_res = M('pk') -> where($map_pk)->select();
							$data['score1'] = $res_res[0]['score1'];
							$data['score2'] = $res_res[0]['score2'];
//							$data_section = M('section') -> where($map_pk) ->select();
//							$data['section'] = $data_section[0]['pk_section'];
							$return["success"] = "1";
							$return["info"] = "队一加分成功！"; 
							$return['data'] = $data;
						}else{
							$return["success"] = "0";
							$return["info"] = "队一加分失败！"; 
							$return['data'] = "";
						}					
					}else if($_GET['team'] == '2'){
						$res_score = M('pk') -> where($map_pk) ->select();
						$map_add['score2'] = (int)$_GET['add_score']+(int)$res_score[0]['score2'];
						$res = M('pk') -> where($map_pk) -> save($map_add);
						if($res){
							$res_res = M('pk') -> where($map_pk)->select();
							$data['score1'] = $res_res[0]['score1'];
							$data['score2'] = $res_res[0]['score2'];
//							$data_section = M('section') -> where($map_pk) ->select();
//							$data['section'] = $data_section[0]['pk_section'];
							$return["success"] = "1";
							$return["info"] = "队二加分成功！"; 
							$return['data'] = $data;
						}else{
							$return["success"] = "0";
							$return["info"] = "队二加分失败！"; 
							$return['data'] = "";
						}					
					}else{
						$return["success"] = "0";
						$return["info"] = "加分出错，请汇报管理员！"; 
						$return['data'] = "";
					}
				}else{
					$return["success"] = "0";
					$return["info"] = "赛事不存在，请汇报管理员！"; 
					$return['data'] = "";
				}			
//			}else{
//				$return["success"] = "0";
//				$return["info"] = "用户不存在，请汇报管理员！"; 
//				$return['data'] = "";				
//			}
		    $this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 修改昵称地址电话
 */	
    public function change_personal(){
    	try{
    		$map['reg_id'] = $_GET['reg_id'];
    		$is_check = M('reguser') -> where($map) -> select();			
			if($is_check){
				if($_GET['change_nickname'] != ""){
					$data_chg['reg_nickname'] = $_GET['change_nickname'];
				}
				if($_GET['change_phone'] != ""){
					$data_chg['reg_phone'] = $_GET['change_phone'];
				}
				if($_GET['change_address'] != ""){
					$data_chg['reg_address'] = $_GET['change_address'];
				}
                $res = M('reguser') -> where($map) -> save($data_chg);
				$data =  M('reguser') -> where($map) -> select();
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
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 添加设备
 */	
    public function add_device(){
    	try{
    		$map['reg_id'] = $_GET['reg_id'];
    		$is_check = M('reguser') -> where($map) -> select();			
			if($is_check){
				$map_device['sb_num'] = $_GET['sb_num'];
				$is_device = M('scoreboard') -> where($map_device) -> select();
				if($is_device){
					$res = M('scoreboard') -> where($map_device) -> save($map);
					if($res){
						$return["success"] = "1";
						$return["info"] = "添加设备成功！"; 
						$return['data'] = "";
					}else{
						$return["success"] = "0";
						$return["info"] = "添加设备失败！"; 
						$return['data'] = "";
					}
				}else{
					$return["success"] = "0";
					$return["info"] = "设备不存在，请重新输入！"; 
					$return['data'] = "";
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
    		$this -> ajaxReturn($return);
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
				
				$map_date['t_id1'] = $is_check[0]['t_id']; //接受的赛事
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
 * 添加球队  球类分类未写
 */	
    public function add_team(){
		try{
			if($_POST['reg_phone']){
				$data['t_name'] = $_POST['t_name'];
				$data['t_image'] = $_POST['t_image'];
				$data['t_startTime'] = $_POST['t_startTime'];
				$data['t_address'] = $_POST['t_address'];
				$data['t_phone'] = $_POST['t_phone'];
				$data['t_cate'] = $_POST['t_cate'];
				$data['t_intro'] = $_POST['t_intro'];
				$data['t_watchword'] = $_POST['t_watchword'];
				$team = M('team');
				$res = $team ->add($data);
//				if($_POST['t_cate'] == ""){
//					
//				}
                if($res&&$res_cate){
                	$return["success"] = "1";
					$return["info"] = "添加成功！"; 
					$return['data'] = "";
					$this -> ajaxReturn($return);
                }else{
                	$return["success"] = "0";
					$return["info"] = "添加失败，汇报管理员！"; 
					$return['data'] = "";
					$this -> ajaxReturn($return);
                }
			}else{
				$return["success"] = "0";
				$return["info"] = "出错，请汇报管理员！"; 
				$return['data'] = "";
				$this -> ajaxReturn($return);
			}
		}catch(Exception $e){
		 	$e->getMessage();  
		}		
	}
/*
 * 添加成员
 */	
    public function add_member(){
    	try{
				$map['t_id'] = $_GET['t_id'];
				$map['cate'] = 0;
				$check_all = M('user_team') -> where($map) ->select();
				if($check_all){
					$return["success"] = "0";
					$return["info"] = "该队已经满员，无法添加新的成员！"; 
					$return['data'] = "";
				}else{
					$data1['reg_id'] = $_GET['member1'];
					$data1['t_id'] = $_GET['t_id'];
					$res1 = M('user_team') -> add($data1);
					$data2['reg_id'] = $_GET['member2'];
					$data2['t_id'] = $_GET['t_id'];
					$res2 = M('user_team') -> add($data2);
					$data3['reg_id'] = $_GET['member3'];
					$data3['t_id'] = $_GET['t_id'];
					$res3 = M('user_team') -> add($data3);
					$data4['reg_id'] = $_GET['member4'];
					$data4['t_id'] = $_GET['t_id'];
					$res4 = M('user_team') -> add($data4);
					if($res1&&$res2&&$res3&&$res4){
						$return["success"] = "1";
						$return["info"] = "添加成功！"; 
						$return['data'] = "";
					}else{
						$return["success"] = "0";
						$return["info"] = "添加失败，请重新尝试或者找管理员！"; 
						$return['data'] = "";
					}
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
 * 取消已经发布或者接下的战事
 */	
    public function cancel_pk(){
    	try{
	    	$map['reg_id'] = $_GET['reg_id'];
			$is_check = M('reguser') -> where($map) -> select();			
			if($is_check){
				$map_a['pk_id'] = $_GET['pk_id'];
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
			$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
//  public function cancel_pk(){
//  	try{
//  		$map['reg_id'] = $_GET['reg_id'];
//  		$is_check = M('reguser') -> where($map) -> select();			
//			if($is_check){
//				$map_pk1['pk_id'] = $_GET['pk_id'];
//				$map_pk1['t_id1'] = $_GET['reg_id'];
//				$map_pk2['pk_id'] = $_GET['pk_id'];
//				$map_pk2['t_id2'] = $_GET['reg_id'];
//				$check_id1 = M('pk') -> where($map_pk1) ->select();
//				$check_id2 = M('pk') -> where($map_pk2) ->select();
//				if($check_id1){
//					$res = M('pk') -> where($map_pk1) -> select();
//					if($res[0]['state'] != 1){
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
//  		$this -> ajaxReturn($return);
//		}catch(Exception $e){
//	 	    $e->getMessage(); 
//		}
//  }
/*
 * 传送节次
 */	
	public function send_section(){
		try{
    		$map['pk_id'] = $_GET['pk_id'];
    		$is_check = M('pk') -> where($map) -> select();			
			if($is_check[0]['state'] == 3){
				$check_section = M('section') -> where($map) ->select();
				if($check_section){
					$data['pk_section'] = $_GET['pk_section'];
					$res = M('section')  -> where($map) -> save($data);
					if($res){
						$return["success"] = "1";
						$return["info"] = "成功！"; 
						$return['data'] = "";
					}else{
						$return["success"] = "0";
						$return["info"] = "失败，请找管理员！"; 
						$return['data'] = "";
					}
				}else{
					$data['pk_id'] = $_GET['pk_id'];
					$data['pk_section'] = $_GET['pk_section'];
					$res = M('section') -> add($data);
					if($res){
						$return["success"] = "1";
						$return["info"] = "成功！"; 
						$return['data'] = "";
					}else{
						$return["success"] = "0";
						$return["info"] = "失败，请找管理员！"; 
						$return['data'] = "";
					}
				}
			}else{
				$return["success"] = "0";
				$return["info"] = "比赛ID传送值不合理，请协同管理员检查！"; 
				$return['data'] = "";				
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
	}
/*
 * 更改赛事状态
 */	
    public function end_pk(){
    	try{
    		$map['pk_id'] = $_GET['pk_id'];
    		$is_check = M('pk') -> where($map) -> select();		
//			dump($is_check);	
			if($is_check[0]['state'] == 3){
				$data['state'] = 1;
				$res = M('pk') -> where($map) -> save($data);
				if($res){
					$return["success"] = "1";
					$return["info"] = "该比赛已完成！"; 
					$return['data'] = "";
				}else{
					$return["success"] = "0";
					$return["info"] = "该比赛不具备节次值，请汇报管理员！"; 
					$return['data'] = "";
				}
			}else{
				$return["success"] = "0";
				$return["info"] = "比赛ID传送值不合理，请协同管理员检查！"; 
				$return['data'] = "";				
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 未知
 */	
    public function aaa(){
    	try{
    		$map['reg_id'] = $_GET['reg_id'];
    		$is_check = M('reguser') -> where($map) -> select();			
			if($is_check){
				
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
}