<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends Controller {
/*
 * 根据时间查找赛事
 */	
    public function research_time_pk(){
    	try{
    		if($_GET['time']==""){
				$return["success"] = "0";
				$return["info"] = "无参数！"; 
				$return['data'] = "";
			}else{
    			$map['time'] = array('like','%'.$_GET['time'].'%');
				$res = M('pk') -> where($map) -> select();
				if($res){
					$count_res = count($res);
					for($i=0;$i<$count_res;$i++){
						$data[$i]['pk_id'] = $res[$i]['pk_id'];
						$data[$i]['time'] = $res[$i]['time'];
						$data[$i]['place'] = $res[$i]['place'];
						$data[$i]['intro'] = $res[$i]['intro'];
						$reg_id['reg_id'] = $res[$i]['t_id1'];
						$t_id = M('user_team') -> where($reg_id) -> select();
	//					dump($t_id);					
						$m_t_id['t_id'] = $t_id[0]['t_id'];
	//					dump($m_t_id);
						$team = M('team') -> where($m_t_id) ->select();
	//					dump($team);
						$data[$i]['t_name1'] = $team[0]['t_name'];
						$data[$i]['t_level'] = $team[0]['t_level'];
					}
					$return["success"] = "1";
					$return["info"] = "查询成功！"; 
					$return['data'] = $data;
				}else{
					$return["success"] = "0";
					$return["info"] = "查询失败，无此时间！"; 
					$return['data'] = $res;
				}
    		}    		
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 根据地点查找赛事
 */	
    public function research_place_pk(){
    	try{
    		if($_GET['provinceID']!=''||$_GET['cityID']!=''||$_GET['areaID']!=''){
				$p = M('province');
				$c = M('city');
				$a = M('area');
				$sheng['provinceID'] = $_GET['provinceID'];
				$province = $p ->where($sheng) ->select();
				$shi['cityID'] = $_GET['cityID'];
				$city = $c ->where($shi) ->select();
				$xian['areaID'] = $_GET['areaID'];
				$area = $a ->where($xian) ->select();
				$map_p['place'] = $province[0]['province'].$city[0]['city'].$area[0]['area'];
				if($province[0]['province']!= ""){
					$map['place'] = array('like','%'.$map_p['place'].'%');
					$res = M('pk') -> where($map) -> select();
					if($res){
						$count_res = count($res);
						for($i=0;$i<$count_res;$i++){
							$data[$i]['pk_id'] = $res[$i]['pk_id'];
							$data[$i]['time'] = $res[$i]['time'];
							$data[$i]['place'] = $res[$i]['place'];
							$data[$i]['intro'] = $res[$i]['intro'];
							$reg_id['reg_id'] = $res[$i]['t_id1'];
							$t_id = M('user_team') -> where($reg_id) -> select();
							$m_t_id['t_id'] = $t_id[0]['t_id'];
							$team = M('team') -> where($m_t_id) ->select();
							$data[$i]['t_name1'] = $team[0]['t_name'];
							$data[$i]['t_level'] = $team[0]['t_level'];
						}
						$return["success"] = "1";
						$return["info"] = "查询成功！"; 
						$return['data'] = $data;
					}else{
						$return["success"] = "0";
						$return["info"] = "查询失败，无此地点！"; 
						$return['data'] = "";
					}
				}else{
					$return["success"] = "0";
					$return["info"] = "获取参数有问题，请联系前端开发人员！"; 
					$return['data'] = "";
				}
				
			}else{
				$return["success"] = "0";
				$return["info"] = "获取参数失败，此接口有待沟通！"; 
				$return['data'] = "";
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 地点时间联合查询
 */	
    public function research_tp_pk(){
    	try{
    		if($_GET['provinceID']!=''||$_GET['cityID']!=''||$_GET['areaID']!=''){
				$p = M('province');
				$c = M('city');
				$a = M('area');
				$sheng['provinceID'] = $_GET['provinceID'];
				$province = $p ->where($sheng) ->select();
				$shi['cityID'] = $_GET['cityID'];
				$city = $c ->where($shi) ->select();
				$xian['areaID'] = $_GET['areaID'];
				$area = $a ->where($xian) ->select();
				$map_p['place'] = $province[0]['province'].$city[0]['city'].$area[0]['area'];
			}
			if($map_p['place']!=""){
				$map['place'] = array('like','%'.$map_p['place'].'%');
			}else{
				$map['place'] = "";
			}
			$map['time'] = array('like','%'.$_GET['time'].'%');
			$res = M('pk') -> where($map) -> select();
			if($res){
				$count_res = count($res);
				for($i=0;$i<$count_res;$i++){
					$data[$i]['pk_id'] = $res[$i]['pk_id'];
					$data[$i]['time'] = $res[$i]['time'];
					$data[$i]['place'] = $res[$i]['place'];
					$data[$i]['intro'] = $res[$i]['intro'];
					$reg_id['reg_id'] = $res[$i]['t_id1'];
					$t_id = M('user_team') -> where($reg_id) -> select();
					$m_t_id['t_id'] = $t_id[0]['t_id'];
					$team = M('team') -> where($m_t_id) ->select();
					$data[$i]['t_name1'] = $team[0]['t_name'];
					$data[$i]['t_level'] = $team[0]['t_level'];
				}
				$return["success"] = "1";
				$return["info"] = "查询成功！"; 
				$return['data'] = $data;
			}else{
				$return["success"] = "0";
				$return["info"] = "查询失败，无此地点！"; 
				$return['data'] = "";
			}			
			$this -> ajaxReturn($return);
    	}catch(Exception $e){
	 	    $e->getMessage(); 
		}
	}
}
