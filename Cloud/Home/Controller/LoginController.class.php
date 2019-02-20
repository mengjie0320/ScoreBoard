<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function ret_data($data_check){
				
		$data[0]['reg_id'] = $data_check[0]['reg_id'];
		$data[0]['reg_name'] = $data_check[0]['reg_name'];
		$data[0]['reg_nickname'] = $data_check[0]['reg_nickname'];
		$data[0]['reg_phone'] = $data_check[0]['reg_phone'];
		$data[0]['reg_image'] = $data_check[0]['reg_image'];
		$data[0]['reg_wintime'] = $data_check[0]['reg_wintime'];
		$data[0]['reg_losttime'] = $data_check[0]['reg_losttime'];
		$data[0]['reg_address'] = $data_check[0]['reg_address'];
		$data[0]['reg_intro'] = $data_check[0]['reg_intro'];
		$data[0]['reg_level'] = $data_check[0]['reg_level'];
		$data[0]['reg_good'] = $data_check[0]['reg_good'];
		$data[0]['reg_nogood'] = $data_check[0]['reg_nogood'];
		
		$map['reg_id'] = $data_check[0]['reg_id'];
		$res_team = M('user_team') -> where($map) ->select();
		$map_team['t_id'] = $res_team[0]['t_id'];
		$res = M('team') -> where($map_team) ->select();
		$data[0]['t_name'] = $res[0]['t_name'];
		$data[0]['t_level'] = $res[0]['t_level'];
		$res_sb = M('scoreboard') -> where($map) ->select();
		$data[0]['sb_num'] = $res_sb[0]['sb_num'];
		$data[0]['sb_nickname'] = $res_sb[0]['sb_nickname'];
		return $data;
	}
    public function do_login(){
//      $this -> check_verify(); //检测验证码是否正确
        try{
        	$callback = $_GET["callback"];
        	$map_phone['reg_phone'] = $_GET['phone_name'];
			$map_name['reg_name'] = $_GET['phone_name'];
			$check_phone = M('reguser') -> where($map_phone) ->select();
			$check_name = M('reguser') -> where($map_name) ->select();
			if($check_phone){
				if($check_phone[0]['reg_pwd'] == $_GET['login_pwd']){					
					$return["success"] = "1";
					$return["info"] = "登陆成功"; 
					$data = $this -> ret_data($check_phone);					
					$return['data'] = $data;
					$return['func'] = $callback;
//					$this -> ajaxReturn($return);
				}else{
					$return["success"] = "0";
					$return["info"] = "密码错误"; 
					$return['data'] = "";
					$return['func'] = $callback;
//					$this -> ajaxReturn($return);
				}
			}else if($check_name){
			    	if($check_name[0]['reg_pwd'] == $_GET['login_pwd']){
						$data = $this -> ret_data($check_name);					
						$return['data'] = $data;
						$return["success"] = "1";
						$return["info"] = "登陆成功"; 
						$return['data'] = $data;
						$return['func'] = $callback;
//						$this -> ajaxReturn($return);
			    	}else{
						$return["success"] = "0";
						$return["info"] = "密码错误"; 
						$return['data'] = "";
						$return['func'] = $callback;
//						$this -> ajaxReturn($return);
					}
			}else{
				$return["success"] = "0";
				$return["info"] = "您未注册"; 
				$return['data'] = "";	
				$return['func'] = $callback;				
			}
			$result = json_encode($return);
			echo "flightHandler($result)";
//			$this -> ajaxReturn($return);
        }catch(Exception $e){
		 	$e->getMessage(); 
		}	    
	}
    public function do_reg(){
		try{
			$callback = $_GET["callback"];
            $map['reg_name'] = $_GET['reg_name'];
			$is_check = M('reguser') -> where($map) ->select();
		    if($is_check){
		    	$return["success"] = "0";
				$return["info"] = "此用户名已存在，请重新注册！"; 
				$return['data'] = "";
				$return['func'] = $callback;
//					$this -> ajaxReturn($return);	    				    
		    }else{
		    	$data['reg_name'] = $_GET['reg_name'];
		    	$data['reg_phone'] = $_GET['reg_phone'];
		    	$data['reg_pwd'] = $_GET['reg_pwd'];
                $reguser = M('reguser');
	    		$res = $reguser ->add($data);
				if($res){
					$return["success"] = "1";
//						$return['type'] = $_SERVER['CONTENT_TYPE'];
					$return["info"] = "恭喜您注册信息提交成功!"; 
					$return['data'] = "";
					$return['func'] = $callback;
//						$this -> ajaxReturn($return);
				}else{
					$return["success"] = "0";
//						$return['type'] = $_SERVER['CONTENT_TYPE'];
					$return["info"] = "出错，请汇报管理员！"; 
					$return['data'] = "";
					$return['func'] = $callback;
//						$this -> ajaxReturn($return);
				}			    									
			}
			$result = json_encode($return);
			echo "flightHandler($result)";
        }catch(Exception $e){
		 	$e->getMessage(); 
		}		
	}
	public function login_test(){
		$callback = $_GET["callback"];
		$a = array(
			'code'=>'CA1998',
			'price'=>'6000',
			'tickets'=>20,
			'func'=>$callback,
		);
		$result = json_encode($a);
		echo "flightHandler($result)";
	}
}
