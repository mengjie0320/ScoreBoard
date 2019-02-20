<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		$this->display();
	}
	public function do_login(){
	    $this -> check_verify(); //检测验证码是否正确
	    $map['admin_name'] = $_POST['login_name'];
		$admin = M('admin');
		$is_check = $admin -> where($map) ->select();
	    if($is_check){
	    	if($is_check[0]['admin_pwd'] == $_POST['login_pwd']){
	    		session_start();
		        $_SESSION['name'] = $is_check[0]['admin_name'];
				$_SESSION['admin_limit'] = $is_check[0]['admin_limit'];
				$this->success('恭喜您登录成功', U('Home/Index/index'),3);
	    	}else{
				$this->error('您的密码错误，请重新填写', U('Home/Login/login'),3);
			}
	    }else{
			$this->error('无此客户存在，请重新登录或注册', U('Home/Login/login'),3);
		}
	}
	 public function verify()
       {
            $config =    array( 
            'fontSize'    =>    14,    // 验证码字体大小  
            'length'      =>    4,     // 验证码位数   
            'expire' => 60,//验证码的有效期（60秒）
            'useImgBg' => false,
            'codeSet' => '0123456789' //指定验证码的字符
//          'codeSet' => '0123456789abcdefghijklmnopqrstuvwxyz'  //指定验证码的字符
            );
            $Verify = new \Think\Verify($config);
            $Verify->entry();
       }
   
   
   /*
    *检测验证码是否正确 
     */
    public function check_verify( $id = '')
    {    
       $verify = new \Think\Verify();    
       $b=$verify->check($_POST['verify'], $id);
      if($b==false)
        $this->error('验证码错误，请重新输入',U('Home/Login/login'),3);
    }
	public function reg(){
		$this->display();
	}
	public function do_reg(){
		$map['admin_name'] = $_POST['reg_name'];
		$admin = M('admin');
		$is_check = $admin -> where($map) ->select();
	    if($is_check){
	    	$this->error('此客户名字已存在，请重新注册', U('Home/Login/reg'),3);	    				    
	    }else{
	    	$data['admin_name'] == $_POST['reg_name'];
	    	$data['admin_pwd'] == $_POST['reg_pwd'];
			$data['admin_limit'] == 0;
    		$res = $admin ->add($data);
			$admin_mes = M('admin_message');
			$map2['admin_id'] = 1;
			$data2['message'] = "用户名为".$data['admin_name']."申请注册，请审查！";
			$res2 = $admin_mes -> where($map2) ->add($data2);
			if($res&&$res2){
				$this->success('恭喜您注册信息提交成功，请等待终极管理员审批！约1-3个工作日', U('Home/Login/login'),3);
			}else{
				$this->error('出错，请汇报管理员', U('Home/Login/reg'),3);
			}			    									
		}
	}
	public function logout(){
//		$this->success("欢迎下次访问",U('Home/Login/login'),1);
     try{
        $_SESSION['name'] = "";
	     $this->success("欢迎下次访问",U('Home/Login/login'),1);
	 }catch(Exception $e){
		 	
		 }
  }
}