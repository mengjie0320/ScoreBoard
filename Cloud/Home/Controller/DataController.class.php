<?php
namespace Home\Controller;
use Think\Controller;
class DataController extends Controller {
    public function index(){
//	   	$length = 2 ;
	// 密码字符集，可任意添加你需要的字符 
//		$chars = array(
//	        '张','王','李','秀','飞','娟','英','华','慧','巧','美','娜','静','淑','惠','珠',
//			'翠','雅','芝','玉','萍','红','娥','玲','芬','芳','燕','安','迪','果','品',
//			'彩','菊','兰','凤','洁','梅','琳','素','云','莲','真',
//			'环',' 雪','荣','爱','妹','霞','香','月','莺','媛','艳',
//			'瑾','瑜','昊','天','思','聪','展','鹏','笑','愚','志','强',
//			'炫','明','松','思','源','智','渊','宇','浩','然','文','轩'
//		); 	  
//		// 在 $chars 中随机取 $length 个数组元素键名 
//		$keys = array_rand($chars, $length); 
//		$password = ""; 
//		for($i = 0; $i < $length; $i++) { 
//			// 将 $length 个数组元素连接成字符串 
//			$password .= $chars[$keys[$i]]; 
//		} 
//		dump($password);
//		return $password; 
		for($a=0;$a<1200;$a++){
			$data['reg_name'] = $this->make_name();
			$data['reg_nickname'] = $this->nickname();
			$data['reg_phone'] = $this->phoneNum();
			$data['reg_level'] = $this->RankNum();//good_Num
			$data['reg_winTime'] = $this->good_Num();//good_Num
			$data['reg_lostTime'] = $this->good_Num();//good_Num
			$data['reg_good'] = $this->good_Num();//good_Num
			$data['reg_nogood'] = $this->good_Num();//good_Num
			$res = M('reguser') -> add($data);
		}
	}
    public function add_team(){
		for($a=0;$a<300;$a++){
			$data['t_name'] = $this->team_name();
			$data['t_phone'] = $this->random_data();
			$data['t_level'] = $this->RankNum();//good_Num
			$data['t_cate'] = $this->RankNum();//good_Num
			$data['t_winTime'] = $this->good_Num();//good_Num
			$data['t_lostTime'] = $this->good_Num();//good_Num
			$data['t_invitedTime'] = $this->good_Num();//good_Num
			$data['t_inviteTime'] = $this->good_Num();//good_Num
			$data['t_good'] = $this->good_Num();//good_Num
			$data['t_nogood'] = $this->good_Num();//good_Num
			$res = M('team') -> add($data);
//dump($data);
		}
	}
	public function user_team(){
		for($a=0;$a<30;$a++){
			$randow_t_id = $this->random_t_id();
			for($b=0;$b<10;$b++){
				$data[$b]['reg_id'] = $this->random_reg_id();
				$data[$b]['t_id'] = $randow_t_id;				
				$data[$b]['cate'] = 0;//good_Num
				$data[0]['cate'] = 1;//good_Num
//				M('team') -> add($data[$b]);
				$res = M('team') -> add($data[$b]);
			}	
//			dump($data);		
		}
	}
	public function pk(){
		for($a=0;$a<3000;$a++){
			$data['t_id1'] = $this->random_t_id();	
			$data['t_id2'] = $this->random_t_id();	
			$data['state'] = 1;		
			$data['score1'] = $this->good_Num();//good_Num
			$data['score2'] = $this->good_Num();//good_Num
			$data['time'] = $this->random_time();
			$data['place'] = "油校".$this->RankNum()."号篮球场";//good_Num
			$data['view'] = $this->RankNum().$this->good_Num();//good_Num
			$res = M('pk') -> add($data);
//			dump($data);		
		}
	}
	public function random_time(){
		$length2 = 2 ;
		// 密码字符集，可任意添加你需要的字符 	
		$chars2 = array(
		'2017-02-08 09:30:00','2017-02-09 09:30:00','2017-02-10 09:30:00',
		'2017-03-08 09:30:00','2017-03-14 09:30:00','2017-04-05 09:30:00',
		'2017-03-09 12:30:00','2017-04-24 09:30:00','2017-05-02 09:30:00',
		'2017-03-24 09:30:00','2017-05-14 09:30:00','2017-04-05 14:30:00',
		'2017-04-28 09:30:00','2017-05-17 09:30:00','2017-09-03 09:30:00'
		);
		// 在 $chars 中随机取 $length 个数组元素键名 
		$keys = array_rand($chars2, $length2); 
		$password2 = ""; 		
		for($i = 1; $i < $length2; $i++) { 
		// 将 $length 个数组元素连接成字符串 
			$password2 .= $chars2[$keys[$i]]; 
		}
//		dump($password2);
		return $password2;		
	}
	public function random_reg_id(){
		$length2 = 2 ;
		// 密码字符集，可任意添加你需要的字符 	
		$phone_user = M('reguser')  -> select();
		$count = count($phone_user);	
		for($a = 0;$a<$count;$a++){
			$chars2[$a]= $phone_user[$a]['reg_id'];
		}
		// 在 $chars 中随机取 $length 个数组元素键名 
		$keys = array_rand($chars2, $length2); 
		$password2 = ""; 		
		for($i = 1; $i < $length2; $i++) { 
		// 将 $length 个数组元素连接成字符串 
			$password2 .= $chars2[$keys[$i]]; 
		}
		dump($password2);
		return $password2;
	}
	public function random_t_id(){
		$length2 = 2 ;
		// 密码字符集，可任意添加你需要的字符 	
		$phone_user = M('team')  -> select();
		$count = count($phone_user);	
		for($a = 0;$a<$count;$a++){
			$chars2[$a]= $phone_user[$a]['t_id'];
		}
		// 在 $chars 中随机取 $length 个数组元素键名 
		$keys = array_rand($chars2, $length2); 
		$password2 = ""; 		
		for($i = 1; $i < $length2; $i++) { 
		// 将 $length 个数组元素连接成字符串 
			$password2 .= $chars2[$keys[$i]]; 
		}
//		dump($password2);
		return $password2;
	}
	public function random_data(){
		$length2 = 2 ;
		// 密码字符集，可任意添加你需要的字符 	
		$phone_user = M('reguser')  -> select();
		$count = count($phone_user);	
		for($a = 0;$a<$count;$a++){
			$chars2[$a]= $phone_user[$a]['reg_phone'];
		}
		// 在 $chars 中随机取 $length 个数组元素键名 
		$keys = array_rand($chars2, $length2); 
		$password2 = ""; 		
		for($i = 1; $i < $length2; $i++) { 
		// 将 $length 个数组元素连接成字符串 
			$password2 .= $chars2[$keys[$i]]; 
		}
//		dump($chars2[0]);
//		dump($password2);
//		dump($keys);
//		dump($chars2['reg_phone']);	
		return $password2;
	}
	public function team_name(){		
//		for($a=0;$a<$num;$a++){
//		if($type = "name"){
			$length2 = 2 ;
			// 密码字符集，可任意添加你需要的字符 				
			$chars2 = array(
			'秀','娟','英','华','慧','巧','美','娜','静','淑','惠','珠',
			'翠','雅','芝','玉','萍','红','娥','玲','芬','芳','燕','珊',
			'彩','菊','兰','凤','洁','梅','琳','素','云','莲','真','海',
			'环','雪','荣','爱','妹','霞','香','月','莺','媛','艳','瑄',
			'雄','强','安','诗','丰','仙','书','勇','凌','伟','燕','滇',
			'瑾','瑜','昊','天','思','聪','展','鹏','笑','愚','志','强',
			'炫','明','松','思','源','智','渊','宇','浩','然','文','轩'
			); 		  
			// 在 $chars 中随机取 $length 个数组元素键名 
			$keys = array_rand($chars2, $length2); 
			$password2 = ""; 		
			for($i = 0; $i < $length2; $i++) { 
			// 将 $length 个数组元素连接成字符串 
				$password2 .= $chars2[$keys[$i]]; 
			}
			$result = $password2."队";
//				dump($result);		
			return $result;
//		}
//		}
	}

	/*
	 * 随机生成名字
	 * */
	public function make_name(){		
//		for($a=0;$a<$num;$a++){
		if($type = "name"){
			$length1 = 2 ;
			// 密码字符集，可任意添加你需要的字符 
			$chars1 = array(
			'诸葛','宋','林','叶','何','毛','戴',
			'王','李','胡','钱','孙','周','莫',
			'吴','郑','蒋','沈','韩','杨','朱',
			'秦','刘','陈','潘','涂','谢','习',
			'邱','齐','万','文','荣','赵','阮'
			); 		  
			// 在 $chars 中随机取 $length 个数组元素键名 
			$keys = array_rand($chars1, $length1); 
			$password = ""; 
			for($i = 1; $i < $length1; $i++) { 
			// 将 $length 个数组元素连接成字符串 
				$password .= $chars1[$keys[$i]];
			} 
			$length2 = 2 ;
			// 密码字符集，可任意添加你需要的字符 				
			$chars2 = array(
			'秀','娟','英','华','慧','巧','美','娜','静','淑','惠','珠',
			'翠','雅','芝','玉','萍','红','娥','玲','芬','芳','燕','珊',
			'彩','菊','兰','凤','洁','梅','琳','素','云','莲','真','海',
			'环','雪','荣','爱','妹','霞','香','月','莺','媛','艳','瑄',
			'雄','强','安','诗','丰','仙','书','勇','凌','伟','燕','滇',
			'瑾','瑜','昊','天','思','聪','展','鹏','笑','愚','志','强',
			'炫','明','松','思','源','智','渊','宇','浩','然','文','轩'
			); 		  
			// 在 $chars 中随机取 $length 个数组元素键名 
			$keys = array_rand($chars2, $length2); 
			$password2 = ""; 		
			for($i = 0; $i < $length2; $i++) { 
			// 将 $length 个数组元素连接成字符串 
				$password2 .= $chars2[$keys[$i]]; 
			}
			//dump($password2);
			//dump($password);
			$result = $password.$password2;
//				dump($result);		
			return $result;
		}
//		}
	}
		
	/*
	 * 随机生成英文昵称
	 */
	public function nickname() {  
	    // 密码字符集，可任意添加你需要的字符  
	    $length1 = 2;
	    $chars1 = array(
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O', 
			'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z'
			);   			
	    $password1 = '';  
		$keys1 = array_rand($chars1, $length1); 
		for($i = 1; $i < $length1; $i++) { 
			// 将 $length 个数组元素连接成字符串 
			$password1 .= $chars1[$keys1[$i]]; 
		} 
	    $length2 = 4;
	    $chars2 = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 
			'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's', 
			't', 'u', 'v', 'w', 'x', 'y','z',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9' 
			);   			
	    $password2 = '';  
		$keys2 = array_rand($chars2, $length2); 
		for($i = 0; $i < $length2; $i++) { 
			// 将 $length 个数组元素连接成字符串 
			$password2 .= $chars2[$keys2[$i]]; 
		} 
		$password = $password1.$password2;
//		dump($password);	 
	    return $password;  
	}
	/*
	 * 生成随机号码
	 */
	public function phoneNum(){
		$length = 8;	
		$phone='138';
	    // 密码字符集，可任意添加你需要的字符
	    $chars = array(
		'0','1','2','3','4','5','6','7','8','9','0','1','2','3'
		);
	    // 在 $chars 中随机取 $length 个数组元素键名
	    $keys = array_rand($chars, $length); 
	    $password = '';
	    for($i = 0; $i < $length; $i++)
	    {
	        // 将 $length 个数组元素连接成字符串
	        $password .= $chars[$keys[$i]];
	    }
		$result=$phone.$password;
//		dump($result);
	    return $result;
	}
/*
 * 比赛分数随机生成
 */
	public function matchNum(){	
		$length = 2;
	    // 密码字符集，可任意添加你需要的字符
	    $chars = array(
		'0','1','2','3','4','5','6','7','8','9'
		);
	    // 在 $chars 中随机取 $length 个数组元素键名
	    $keys = array_rand($chars, $length); 
	    $password = '';
	    for($i = 0; $i < $length; $i++)
	    {// 将 $length 个数组元素连接成字符串
	        $password .= $chars[$keys[$i]];			
	    }
//		dump($password);
//		$length1=2;
//		$chars1 = array(
//		'0','1','2','3','4','5','6','7','8','9'
//		);
//	    // 在 $chars 中随机取 $length 个数组元素键名
//	    $keys = array_rand($chars1, $length1); 
//	    $password = '';
//	    for($i = 0; $i < $length1; $i++)
//	    {
//	        // 将 $length 个数组元素连接成字符串
//	        $password .= $chars1[$keys[$i]];			
//	    }
//		$result1=$password;
//		dump($result1);		
	    return $password;
	}
 /*
  * 随机等级
  */
	public function RankNum(){
	    // 密码字符集，可任意添加你需要的字符
	    $length = 2;
	    $chars = array(
		'1','2','3','4','5','6','7','8','9' //'0',
		);
	    // 在 $chars 中随机取 $length 个数组元素键名
	    $keys = array_rand($chars, $length); 
	    $password = "";
	    for($i = 1; $i < $length; $i++)
	    {
	        // 将 $length 个数组元素连接成字符串
	        $password .= $chars[$keys[$i]];	
	    }
//		$result=$password;
//		dump($password);
	    return $password;
	}
 /*
  * 比赛点赞数
  */
	public function good_Num(){
	 	$length = 2;
	    // 密码字符集，可任意添加你需要的字符
	    $chars = array(
		'0','1','2','3','4','5','6','7','8','9'
		);
	    // 在 $chars 中随机取 $length 个数组元素键名
	    $keys = array_rand($chars, $length); 
	    $password = '';
	    for($i = 0; $i < $length; $i++)
	    {// 将 $length 个数组元素连接成字符串
	        $password .= $chars[$keys[$i]];	
	    }		
//		dump($password);
		return $password;
	}

}