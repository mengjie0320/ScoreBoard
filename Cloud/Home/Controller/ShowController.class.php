<?php
namespace Home\Controller;
use Think\Controller;
class ShowController extends Controller {
	public function add_view(){
        try{
        	$callback = $_GET["callback"];
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
			$result = json_encode($return);
			echo "flightHandler($result)";
//			$this -> ajaxReturn($return);
   		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
	public function add_download(){
        try{
        	$callback = $_GET["callback"];
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
			$result = json_encode($return);
			echo "flightHandler($result)";
//			$this -> ajaxReturn($return);
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
 * 展示所有pk赛事，按照state区分0创建伊始2接赛3直播中1比完
 */	
    public function show_all_pk(){
    	try{
    		$map_pk['pk_character'] = 2;
			$map_league['pk_character'] = 1;
    		$res = M('pk') ->where($map_pk) -> select();
			$res_league = M('pk') ->where($map_league) -> select();
			$count = count($res);
			$count_league = count($res_league);
//			var_dump($res);var_dump($res_league);
			if($res||$res_league){
					if($res){
					for($i=0;$i<$count;$i++){
						$data[$i]['pk_id'] = $res[$i]['pk_id'];
						$data[$i]['time'] = $res[$i]['time'];	
						$data[$i]['place'] = $res[$i]['place'];		
						$data[$i]['state'] = $res[$i]['state'];
						$t_id1['t_id'] = $res[$i]['t_id1'];//队1名
						$name1 = M('team') -> where($t_id1) ->select();
						$data[$i]['pk_name1'] = $name1[0]['t_name'];
						$data[$i]['t_good1'] = $name1[0]['t_good'];	
						$data[$i]['t_image1'] = $name1[0]['t_image'];
						$data[$i]['t_score1'] = $res[$i]['score1'];	
						$t_id2['t_id'] = $res[$i]['t_id2'];//队2名
						$name2 = M('team') -> where($t_id2) ->select();
						$data[$i]['pk_name2'] = $name2[0]['t_name'];
						$data[$i]['t_good2'] = $name2[0]['t_good'];
						$data[$i]['t_image2'] = $name1[0]['t_image'];						
						$data[$i]['t_score2'] = $res[$i]['score2'];
						$data[$i]['image1'] = $res[$i]['image1'];
						if($res[$i]['state'] == "3"){
							$map['pk_id'] = $res[$i]['pk_id'];
							$pk_section = M('section') -> where($map) ->select();
							$data[$i]['pk_section'] = $pk_section[0]['pk_section'];
						}	
					}
				}
				if($res_league){
					for($i=0;$i<$count_league;$i++){
						$data[$count+$i]['pk_id'] = $res_league[$i]['pk_id'];
						$data[$count+$i]['time'] = $res_league[$i]['time'];	
						$data[$count+$i]['place'] = $res_league[$i]['place'];		
						$data[$count+$i]['state'] = $res_league[$i]['state'];
//						$t_id1['t_id'] = $res[$i]['t_id1'];//队1名
//						$name1 = M('team') -> where($t_id1) ->select();
						$data[$count+$i]['pk_name1'] = $res_league[$i]['t_id1'];;
//						$data[$count+$i]['t_good1'] = $name1[0]['t_good'];	
//						$data[$count+$i]['t_image1'] = $name1[0]['t_image'];
						$data[$count+$i]['t_score1'] = $res_league[$i]['score1'];	
//						$t_id2['t_id'] = $res[$i]['t_id2'];//队2名
//						$name2 = M('team') -> where($t_id2) ->select();
						$data[$count+$i]['pk_name2'] = $res_league[$i]['t_id2'];;
//						$data[$count+$i]['t_good2'] = $name2[0]['t_good'];
//						$data[$count+$i]['t_image2'] = $name1[0]['t_image'];
//						
						$data[$count+$i]['t_score2'] = $res_league[$i]['score2'];
//						$data[$count+$i]['image1'] = $res[$i]['image1'];
						if($res[$i]['state'] == "3"){
							$map['pk_id'] = $res_league[$i]['pk_id'];
							$pk_section = M('section') -> where($map) ->select();
							$data[$count+$i]['pk_section'] = $pk_section[0]['pk_section'];
						}	
					}
				}
				$return["success"] = "1";
				$return["info"] = "查询成功"; 				
				$return['data'] = $data;
			}else{
				$return["success"] = "1";
				$return["info"] = "查询成功，暂无数据"; 
				$return['data'] = "";
			}
//			$return['data_pk'] = $res;
//			$return['data_league'] = $res_league;
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 展示所有pk赛事，按照state区分0创建伊始2接赛3直播中1比完
 */	
    public function show_all_pk_1(){
    	try{
    		$res = M('pk') -> select();
			if($res){
				$count = count($res);
				for($i=0;$i<$count;$i++){
					$data[$i]['pk_id'] = $res[$i]['pk_id'];
					$data[$i]['time'] = $res[$i]['time'];	
					$data[$i]['place'] = $res[$i]['place'];		
					$data[$i]['state'] = $res[$i]['state'];
					$t_id1['t_id'] = $res[$i]['t_id1'];//队1名
					$name1 = M('team') -> where($t_id1) ->select();
					$data[$i]['pk_name1'] = $name1[0]['t_name'];
					$data[$i]['t_good1'] = $name1[0]['t_good'];	
					$data[$i]['t_image1'] = $name1[0]['t_image'];
					$data[$i]['t_score1'] = $res[$i]['score1'];	
					$t_id2['t_id'] = $res[$i]['t_id2'];//队2名
					$name2 = M('team') -> where($t_id2) ->select();
					$data[$i]['pk_name2'] = $name2[0]['t_name'];
					$data[$i]['t_good2'] = $name2[0]['t_good'];
					$data[$i]['t_image2'] = $name1[0]['t_image'];
					
					$data[$i]['t_score2'] = $res[$i]['score2'];
					$data[$i]['image1'] = $res[$i]['image1'];
					if($res[$i]['state'] == "3"){
						$map['pk_id'] = $res[$i]['pk_id'];
						$pk_section = M('section') -> where($map) ->select();
						$data[$i]['pk_section'] = $pk_section[0]['pk_section'];
					}	
				}
				$return["success"] = "1";
				$return["info"] = "查询成功"; 				
				$return['data'] = $data;
			}else{
				$return["success"] = "1";
				$return["info"] = "查询成功，暂无数据"; 
				$return['data'] = "";
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 对应队参与赛事信息。参数：t_id
 */	
    public function show_t_pk(){
    	try{
    		$map1['t_id1'] = $_GET['t_id'];
			$map2['t_id2'] = $_GET['t_id'];
    		$res1 = M('pk') ->where($map1)-> select();
			$res2 = M('pk') ->where($map2)-> select();
			if($res1||$res2){
				$count = count($res1);
				for($i=0;$i<$count;$i++){
					$data[$i]['pk_id'] = $res1[$i]['pk_id'];
					$data[$i]['time'] = $res1[$i]['time'];	
					$data[$i]['place'] = $res1[$i]['place'];		
					$data[$i]['t_id1'] = $res1[$i]['t_id1'];//队1
					$t_id1['t_id'] = $res1[$i]['t_id1'];//队1名
					$name1 = M('team') -> where($t_id1) ->select();
					$data[$i]['pk_name1'] = $name1[0]['t_name'];
					$data[$i]['t_good1'] = $name1[0]['t_good'];	
					$data[$i]['t_score1'] = $res1[$i]['score1'];
					$data[$i]['t_id2'] = $res1[$i]['t_id2'];//队2	
					$t_id2['t_id'] = $res1[$i]['t_id2'];//队2名
					$name2 = M('team') -> where($t_id2) ->select();
					$data[$i]['pk_name2'] = $name2[0]['t_name'];
					$data[$i]['t_good2'] = $name2[0]['t_good'];
//					$data[$i]['t_image2'] = $name1[0]['t_image'];					
					$data[$i]['t_score2'] = $res1[$i]['score2'];
//					$data[$i]['image1'] = $res1[$i]['image1'];	
				}
				$count2 = count($res2);
				for($j=0;$j<$count2;$j++){
					$data[$count2+$j]['pk_id'] = $res2[$j]['pk_id'];
					$data[$count2+$j]['time'] = $res2[$j]['time'];	
					$data[$count2+$j]['place'] = $res2[$j]['place'];
					$data[$count2+$j]['t_id1'] = $res2[$j]['t_id1'];//队1		
					$t_id21['t_id'] = $res2[$j]['t_id1'];//队1名
					$name21 = M('team') -> where($t_id21) ->select();
					$data[$count2+$j]['pk_name1'] = $name21[0]['t_name'];
					$data[$count2+$j]['t_good1'] = $name21[0]['t_good'];	
					$data[$count2+$j]['t_score1'] = $res2[$j]['score1'];
					$data[$count2+$j]['t_id2'] = $res2[$j]['t_id2'];//队1		
					$t_id22['t_id'] = $res2[$j]['t_id2'];//队2名
					$name22 = M('team') -> where($t_id22) ->select();
					$data[$count2+$j]['pk_name2'] = $name22[0]['t_name'];
					$data[$count2+$j]['t_good2'] = $name22[0]['t_good'];				
					$data[$count2+$j]['t_score2'] = $res2[$j]['score2'];
				}
				$return["success"] = "1";
				$return["info"] = "查询成功"; 				
				$return['data'] = $data;
			}else{
				$return["success"] = "1";
				$return["info"] = "查询成功，暂无数据"; 
				$return['data'] = "";
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 获取对应ID之后展示pk赛事具体信息
 */	
    public function show_pk_id(){
    	try{
    		$map['pk_id'] = $_GET['pk_id'];
    		$res = M('pk') -> where($map) -> select();
			if($res){
				$data['pk_id'] = $res[0]['pk_id'];
				$data['time'] = $res[0]['time'];	
				$data['place'] = $res[0]['place'];		
				$data['state'] = $res[0]['state'];
				$data['t_id1'] = $res[0]['t_id1'];
				$t_id1['t_id'] = $res[0]['t_id1'];//队1名
				$name1 = M('team') -> where($t_id1) ->select();
				$data['pk_name1'] = $name1[0]['t_name'];
				$data['t_good1'] = $name1[0]['t_good'];	
				$data['t_image1'] = $name1[0]['t_image'];
				$data['t_score1'] = $res[0]['score1'];	
				$data['t_id2'] = $res[0]['t_id2'];
				$t_id2['t_id'] = $res[0]['t_id2'];//队2名
				$name2 = M('team') -> where($t_id2) ->select();
				$data['pk_name2'] = $name2[0]['t_name'];
				$data['t_good2'] = $name2[0]['t_good'];
				$data['t_image2'] = $name1[0]['t_image'];					
				$data['t_score2'] = $res[0]['score2'];
				$data['image1'] = $res[0]['image1'];
				if($res['state'] == "3"){
					$map['pk_id'] = $res['pk_id'];
					$pk_section = M('section') -> where($map) ->select();
					$data[0]['pk_section'] = $pk_section[0]['pk_section'];
				}	
				$return["success"] = "1";
				$return["info"] = "查询成功"; 				
				$return['data'] = $data;
			}else{
				$return["success"] = "0";
				$return["info"] = "查询失败，暂无数据"; 
				$return['data'] = "";
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 赛事比分消息,无参数
 */
    public function pk_show(){
    	try{
//  		if($_SERVER['CONTENT_TYPE']){
	    		$map['state'] = array('egt',1);
	    		$res = M('pk') -> where($map) ->select();
				if($res){
					$count = count($res);
					for($i=0;$i<$count;$i++){
//						$data[$i]['score1'] = (int)$res[$i]['score1'];	
//						$data[$i]['score2'] = (int)$res[$i]['score2'];
//						if($res[$i]['pk_character']==1){
//							$data[$i]['pk_name1'] = $res[$i]['t_id1'];
//							$data[$i]['pk_name2'] = $res[$i]['t_id2'];
//						}else{
//							$t_id1['t_id'] = $res[$i]['t_id1'];//队1名
//							$name1 = M('team') -> where($t_id1) ->select();
//							$data[$i]['pk_name1'] = $name1[0]['t_name'];
//							$data[$i]['t_good1'] = (int)$name1[0]['t_good'];
//							$t_id2['t_id'] = $res[$i]['t_id2'];//队2名
//							$name1 = M('team') -> where($t_id2) ->select();
//							$data[$i]['pk_name2'] = $name1[0]['t_name'];	
//							$data[$i]['t_good2'] = (int)$name1[0]['t_good'];
//						}						
//						$data[$i]['pk_name'] = $res[$i]['pk_name'];
//						$data[$i]['time'] = $res[$i]['time'];
//						$data[$i]['place'] = $res[$i]['place'];	
						$data[$i]['score1'] =(int) $res[$i]['score1'];	
						$data[$i]['score2'] = (int)$res[$i]['score2'];		
						$data[$i]['state'] = (int)$res[$i]['state'];
						$data[$i]['pk_name'] = $res[$i]['pk_name'];
						$t_id1['t_id'] = $res[$i]['t_id1'];//队1名
						$name1 = M('team') -> where($t_id1) ->select();
						$data[$i]['pk_name1'] = $name1[0]['t_name'];	
						$t_id2['t_id'] = $res[$i]['t_id2'];//队2名
						$name1 = M('team') -> where($t_id2) ->select();
						$data[$i]['pk_name2'] = $name1[0]['t_name'];	
					}
					$return["success"] = "1";
					$return["info"] = "获取pk赛信息成功！"; 
					$return['data'] = $data;
				}
//			}else{
//				$return["success"] = "0";
//				$return["info"] = "暂无数据！"; 
//				$return['data'] = $res;				
//			}
			$this -> ajaxReturn($return);
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}	
    }
/*
 * 时事热点   如何收集是个问题
 */
	public function show_news(){
		try{
//			if($_SERVER['CONTENT_TYPE']){
				$outnews = M('outnews');
				$res_word = $outnews ->limit(0,6) ->select();
				$res_pw = $outnews ->limit(6,3) ->select();
				if($res_word||$res_pw){
					$return["success"] = "1";
					$return["info"] = "信息获取成功！"; 
					$return['just_word'] = $res_word;
					$return['pic_word'] = $res_pw;
				}else{
					$return["success"] = "0";
					$return["info"] = "暂无数据！"; 
					$return['just_word'] = "";
					$return['pic_word'] = "";
	//				$this -> ajaxReturn($return);
				}
//			}else{
//				$return["success"] = "0";
//				$return["info"] = "暂无数据！"; 
//				$return['data'] = $res;				
//			}
			$this -> ajaxReturn($return);
		}catch(Exception $e){
		 	$e->getMessage(); 
		}		
	}
/*
 * 展示所有联赛信息
 */
 	public function show_league(){
        try{
        	$map['pk_character'] = 1;
        	$res = M('pk') ->where($map) ->select();
			if($res){
				$count = count($res);
				for($i=0;$i<$count;$i++){
					$data[$i]['t_name1'] = $res[$i]['t_id1'];
					$data[$i]['t_name2'] = $res[$i]['t_id2'];
					$data[$i]['pk_name'] = $res[$i]['pk_name'];
					$data[$i]['time'] = $res[$i]['time'];
					$data[$i]['place'] = $res[$i]['place'];
				}
				$return["success"] = "1";
				$return["info"] = "访问成功！"; 
				$return['data'] = $data;	
			}else{
				$return["success"] = "0";
				$return["info"] = "无数据！"; 
				$return['data'] = "";
			}
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
						$data[$i]['pk_id'] = (int)$res[$i]['pk_id'];	
						$data[$i]['time'] = $res[$i]['time'];		
						$data[$i]['place'] = $res[$i]['place'];
						$data[$i]['intro'] = $res[$i]['intro'];
						$map_1['t_id'] = (int)$res[$i]['t_id1'];	
						$res1 = M('team') -> where($map_1) ->select();
						$data[$i]['t_name1'] = $res1[0]['t_name'];
						$data[$i]['t_image1'] = $res1[0]['t_image'];
						$data[$i]['t_level1'] = (int)$res1[0]['t_level'];
						$reg_id = M('user_team') -> where($map_1) ->select();
						$map_reg_id['reg_id'] = $reg_id[0]['reg_id'];
						$res_sb = M('scoreboard') -> where($map_reg_id) ->select();
						if($res_sb){
							$data[$i]['scoreboard'] = "1";
						}else{
							$data[$i]['scoreboard'] = "0";
						}
//						$map_2[$i]['t_id'] = $res[$i]['t_id2'];	
//						$res2 = M('team') -> where($map_2) ->select();
//						$data[$i]['t_name2'] = $res2[0]['t_name'];	
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
 * 视频，返回视频图片（标题，描述）
 */
	public function show_videos(){
		try{
//			if($_SERVER['CONTENT_TYPE']){
	    		$pk = M('pk');
				$res_word = $pk -> where('state=1') -> field('image1,pk_name,intro')->order('pk_id desc')->limit(0,4) ->select();
				$res_pw = $pk -> where('state=1') -> field('image1,pk_name,intro')->order('pk_id desc')->limit(4,3) ->select();
				if($res_word||$res_pw){
					$return["success"] = "1";
					$return["info"] = "信息获取成功！"; 
					$return['just_word'] = $res_word;
					$return['pic_word'] = $res_pw;
				}else{
					$return["success"] = "0";
					$return["info"] = "暂无数据！"; 
					$return['data'] = "";		
				}
//			}else{
//				$return["success"] = "0";
//				$return["info"] = "暂无数据！"; 
//				$return['data'] = $res;				
//			}
	        $this -> ajaxReturn($return);
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}		
	}
 /*
 * 推荐商家logo6个记分牌图片2张
 */
/*
 * 主页轮播图
 */
    public function scanner_show(){
    	try{
//  		if($_SERVER['CONTENT_TYPE']){
	    		$pk = M('pk');
				$res = $pk -> where('state=1') -> field('image1,pk_name')->limit(0,4) ->select() ;
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
//          }else{
//				$return["success"] = "0";
//				$return["info"] = "暂无数据！"; 
//				$return['data'] = $res;				
//			}
	        $this -> ajaxReturn($return);
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}		
	}
 /*
 * 展示对应赛事的信息
 */
    public function pk_reg_user(){
    	try{

    		$this -> ajaxReturn($return);
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }

 /*
 * 新闻中间部分（篮球，羽毛球，足球，大杂烩）
 */
    public function pk_news(){
    	try{
//  		if($_SERVER['CONTENT_TYPE']){
//  		}else{
//				$return["success"] = "0";
//				$return["error"] = "401";
////				$return["data"] = $headers['Content-Type'];
//				$return["info"] = "kongzhi！";
//			}	
    		$this -> ajaxReturn($return);
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }
 /*
 * 赛事比分
 */
    public function show_team(){
    	try{
//  		if($_SERVER['CONTENT_TYPE']){
	    		$res = M('team') ->select();
				if($res){
					$count = count($res);
					for($i=0;$i<$count;$i++){
						$data[$i]['rank'] = $i+1;
						$data[$i]['t_name'] = $res[$i]['t_name'];	
						$data[$i]['t_wintime'] = $res[$i]['t_wintime'];		
						$data[$i]['t_losttime'] = $res[$i]['t_losttime'];
	//					{$row['nk_zx']/$row['nk_ip']*100|round=2}%	
						$percent = floatval($data[$i]['t_wintime'])/(floatval($data[$i]['t_wintime'])+floatval($data[$i]['t_losttime']));						
	//				    dump($percent);
					    $data[$i]['percent'] = round($percent*100,0).'%';
					}
					$return["success"] = "1";
					$return["info"] = "获取赛事比分消息成功"; 
					$return['data'] = $data;
				}
//			}else{
//				$return["success"] = "0";
//				$return["error"] = "401";
////				$return["data"] = $headers['Content-Type'];
//				$return["info"] = "kongzhi！";
//			}
			$this -> ajaxReturn($return);
    	}catch(Exception $e){
		 	$e->getMessage(); 
		}
    }
 /*
 * 赛事比分消息
 */
}
