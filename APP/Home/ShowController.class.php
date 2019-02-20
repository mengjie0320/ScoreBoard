<?php
namespace Home\Controller;
use Think\Controller;
class ShowController extends Controller {
	public function add_view(){
        try{
        	$map['id'] = 1;
   			$data_old = M('number') -> where($map) ->select();
//			dump($data_old);
			$data_new['view_num'] = $data_old[0]['view_num'] + 1;
			$res = M('number') -> where($map) ->save($data_new);
			if($res){
				$return["success"] = "1";
			}else{
				$return["success"] = "0";
			}
			$this -> ajaxReturn($return);
   		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
	public function add_download(){
        try{
        	$map['id'] = 1;
   			$data_old = M('number') -> where($map) ->select();
//			dump($data_old);
			$data_new['download_num'] = $data_old[0]['download_num'] + 1;
			$res = M('number') -> where($map) ->save($data_new);
			if($res){
				$return["success"] = "1";
			}else{
				$return["success"] = "0";
			}
			$this -> ajaxReturn($return);
   		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
	public function show_view_download(){
		try{
        	$map['id'] = 1;
   			$res = M('number') -> where($map) ->select();
			if($res){
				$return["success"] = "1";
				$return['data'] = $res;
			}else{
				$return["success"] = "0";
			}
			$this -> ajaxReturn($return);
   		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
	}
/*
 * 比赛结果展示
 */
    public function pk_show(){
    	try{
//  		$map['reg_id'] = $_GET['reg_id'];
//  		$is_check = M('reguser') -> where($map) -> select();			
//			if($is_check){
	    		$map['state'] = array('egt',1);
//				$map['pk_character'] = array('neq',1);
	    		$res = M('pk') -> where($map) ->select();
				if($res){
					$count = count($res);
					for($i=0;$i<$count;$i++){
						$data[$i]['score1'] = (int)$res[$i]['score1'];	
						$data[$i]['score2'] = (int)$res[$i]['score2'];
						if($res[$i]['pk_character']==1){
							$data[$i]['pk_name1'] = $res[$i]['t_id1'];
							$data[$i]['pk_name2'] = $res[$i]['t_id2'];
						}else{
							$t_id1['t_id'] = $res[$i]['t_id1'];//队1名
							$name1 = M('team') -> where($t_id1) ->select();
							$data[$i]['pk_name1'] = $name1[0]['t_name'];
							$data[$i]['t_good1'] = (int)$name1[0]['t_good'];
							$t_id2['t_id'] = $res[$i]['t_id2'];//队2名
							$name1 = M('team') -> where($t_id2) ->select();
							$data[$i]['pk_name2'] = $name1[0]['t_name'];	
							$data[$i]['t_good2'] = (int)$name1[0]['t_good'];
						}						
						$data[$i]['pk_name'] = $res[$i]['pk_name'];
						$data[$i]['time'] = $res[$i]['time'];
						$data[$i]['place'] = $res[$i]['place'];			
					}
					$return["success"] = "1";
					$return["info"] = "获取pk赛信息成功！"; 
					$return['data'] = $data;
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
 * 展示所有约战信息   17.2.14 afternoon
 */
   public function show_publish(){
   	    try{
   	    		$map['state'] = 0;
				$map['pk_character'] = array('neq',1);
	   	   	    $res = M('pk') -> where($map) ->select();
				if($res){
					$count = count($res);
					for($i=0;$i<$count;$i++){
						$data[$i]['pk_id'] = $res[$i]['pk_id'];	
						$data[$i]['time'] = $res[$i]['time'];		
						$data[$i]['place'] = $res[$i]['place'];
						$data[$i]['intro'] = $res[$i]['intro'];
						$map_1['t_id'] = $res[$i]['t_id1'];	
						$res1 = M('team') -> where($map_1) ->select();
						$data[$i]['t_name1'] = $res1[0]['t_name'];
						$data[$i]['t_image1'] = $res1[0]['t_image'];
						$data[$i]['t_level1'] = $res1[0]['t_level'];
						$reg_id = M('user_team') -> where($map_1) ->select();
						$map_reg_id['reg_id'] = $reg_id[0]['reg_id'];
						$res_sb = M('scoreboard') -> where($map_reg_id) ->select();
						if($res_sb){
							$data[$i]['scoreboard'] = "1";
						}else{
							$data[$i]['scoreboard'] = "0";
						}
//						$map_2['t_id'] = $res[$i]['t_id2'];	
//						$res2 = M('team') -> where($map_2) ->select();
//						$data[$i]['t_name2'] = $res2[0]['t_name'];
//						$data[$i]['t_level2'] = $res2[0]['t_level'];	
					}
//					$level['t_level'] = $check[0]['t_level'] + 2;//增加能力值
//					$add_level = M('team') -> where($map_user) ->save($level);
					$return["success"] = "1";
					$return["info"] = "获取待应战信息成功"; 
					$return['data'] = $data;
				}else{
					$return["success"] = "1";  
					$return["info"] = "无应战信息"; 
					$return['data'] = "";
				}  	    	
			$this -> ajaxReturn($return);
   	    }catch(Exception $e){
		 	$e->getMessage(); 
	    }
   }

/*
 * 主页轮播图
 */
    public function show_index(){
		try{
    		$pk = M('pk');
			$res = $pk -> field('image1,pk_name')->limit(0,3) ->select() ;
			if($res){
				$return["success"] = "1";
				$return["info"] = "信息获取成功！"; 
				$return['data'] = $res;
	//			$this -> ajaxReturn($return);
			}else{
				$return["success"] = "0";
				$return["info"] = "暂无数据！"; 
				$return['data'] = $res;
				
			}
	        $this -> ajaxReturn($return);
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}		
	}
/*
 * 时事热点   如何收集是个问题
 */
	public function show_outnews(){
		try{
			$outnews = M('outnews');
			$res_word = $outnews ->limit(0,6) ->select();
			$res_pw = $outnews ->limit(6,3) ->select();
			if($res_word){
				$return["success"] = "1";
				$return["info"] = "信息获取成功！"; 
				$return['just_word'] = $res_word;
				$return['pic_word'] = $res_pw;
			}else{
				$return["success"] = "0";
				$return["info"] = "暂无数据！"; 
				$return['data'] = "";
//				$this -> ajaxReturn($return);
			}
			$this -> ajaxReturn($return);
		}catch(Exception $e){
		 	$e->getMessage(); 
		}		
	}
/*
 * 球队点赞数排行 //分类暂未写
 */
	public function rank_team(){
//		$team = M('team');
		$data = M('team') -> order('t_good desc') ->field('t_name,t_winTime,t_lostTime,t_good')->select();		
		$count = count($data);
		for($i=0;$i<$count;$i++){
			$data[$i]['t_level'] = $data[$i]['t_good'];
		}
		$return["success"] = "0";
		$return["info"] = $data; 
		$return['data'] = "";
		$this -> ajaxReturn($return);
	}
/*
 * 成员等级排行
 */
	public function rank_user(){
		$team = M('reguser');
		$data = $team -> order('reg_level desc') ->field('reg_name,reg_winTime,reg_lostTime,reg_level')->select();
		$return["success"] = "0";
		$return["info"] = $data; 
		$return['data'] = "";
		$this -> ajaxReturn($return);
	}
/*
 * 记录赛事轮播
 */
    public function carousel_pic(){
    	$data = M('pk') -> field('pk_name,image1')->limit(0,3) ->select();
		$return["success"] = "0";
		$return["info"] = $data; 
		$return['data'] = "";
		$this -> ajaxReturn($return);
    }
}