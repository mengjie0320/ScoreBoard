<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends Controller {
	public function search_place(){
		try{
			if($_GET['id'] == ""){
				$return["success"] = "0";
				$return["info"] = "id不能为空！"; 
				$return['data'] = "";
			}else{
				if($_GET['id'] == "province"){
					$province = M('province') -> select();
					$count = count($province);
					for($i=0;$i<$count;$i++){
						$data[$i]['id'] = $province[$i]['provinceid'];
						$data[$i]['name'] = $province[$i]['province'];
					}
				}else{
					$fatherID['fatherID'] = $_GET['id'];
					$city = M('city') -> where($fatherID) -> select();
					if($city){
						$count = count($city);
						for($i=0;$i<$count;$i++){
							$data[$i]['id'] = $city[$i]['cityid'];
							$data[$i]['name'] = $city[$i]['city'];
						}
					}
					$area = M('area') -> where($fatherID) -> select();
					if($area){
						$count = count($area);
						for($i=0;$i<$count;$i++){
							$data[$i]['id'] = $area[$i]['areaid'];
							$data[$i]['name'] = $area[$i]['area'];
						}
					}						
				}
				$return["success"] = "1";
				$return["info"] = "province信息返回成功！"; 
				$return['data'] = $data;
			}			
			$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
	}
/*
 * 展示省及各个直辖区
 */	
    public function show_province(){
    	try{
    		$province = M('province') -> select();
			$count = count($province);
			for($i=0;$i<$count;$i++){
				$data[$i]['id'] = $province[$i]['provinceid'];
				$data[$i]['name'] = $province[$i]['province'];
			}			
			$return["success"] = "1";
			$return["info"] = "province信息返回成功！"; 
			$return['data'] = $data;
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 展示省及各个直辖区之下的城市
 */	
    public function show_city(){
    	try{//$_GET['provinceid'];
			$fatherID['fatherID'] = $_GET['id'];
			$city = M('city') -> where($fatherID) -> select();
			$count = count($city);
			for($i=0;$i<$count;$i++){
				$data[$i]['id'] = $city[$i]['cityid'];
				$data[$i]['name'] = $city[$i]['city'];
			}		
			$return["success"] = "1";
			$return["info"] = "city信息返回成功！"; 
			$return['data'] = $data;
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 展示省及各个直辖区之下的城市的区
 */	
    public function show_area(){
    	try{
			$fatherID['fatherID'] = $_GET['id'];
			$area = M('area') -> where($fatherID) -> select();
			$count = count($area);
			for($i=0;$i<$count;$i++){
				$data[$i]['id'] = $area[$i]['areaid'];
				$data[$i]['name'] = $area[$i]['area'];
			}
			$return["success"] = "1";
			$return["info"] = "area信息返回成功！"; 
			$return['data'] = $data;
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 按照提交的地点类似查询
 */	
    public function search_place_pk(){
    	try{
    		$map['place'] = array('like','%'.$_GET['place'].'%');
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
				$return["info"] = "通过地址查询比赛成功！"; 
				$return['data'] = $res;
			}else{
				$return["success"] = "1";
				$return["info"] = "无相关数据！"; 
				$return['data'] = "";				
			}
    		$this -> ajaxReturn($return);
		}catch(Exception $e){
	 	    $e->getMessage(); 
		}
    }
/*
 * 根据时间查找赛事
 */	
    public function search_time_pk(){
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
