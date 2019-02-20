<?php
namespace Home\Controller;
use Think\Controller;
class DoController extends Controller {
	public function index(){
		echo "ggg";
	}
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
 * 外部赛事
 */
    public function outnews_show(){
    	$outnews = M('outnews');
		$data = $outnews ->select();
		$return["success"] = "0";
		$return["info"] = $data; 
		$return['data'] = "";
		$this -> ajaxReturn($return);
    }
/*
 * 球队分类排行 //分类暂未写
 */
	public function rank_team(){
		$team = M('team');
		$data = $team -> order('t_good desc') ->field('t_name,t_winTime,t_lostTime,t_good')->select();
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
		$data = $team -> order('reg_good desc') ->field('reg_name,reg_winTime,reg_lostTime,reg_good')->select();
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