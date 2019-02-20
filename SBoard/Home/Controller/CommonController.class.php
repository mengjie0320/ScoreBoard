<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
  function _initialize(){
      if($_SESSION['name'] == ""){
          $this->error("请先登录或离开",U('Home/Login/login'),1);
      }else{
      	$this->assign('name',$_SESSION['name']);
      }     
  } 

   
}