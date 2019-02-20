<?php
namespace Home\Controller;
use Think\Controller;
require_once 'curl.func.php';
class CarController extends Controller {
//  public function index(){ 
//  	
////		$appkey = $_GET['appkey'];//你的appkey
////		$url = "http://api.jisuapi.com/licenseplaterecognition/recognize?appkey=".$_GET['appkey'];
//		$img = $_GET['pic'];
////		$post = array(
////		    'pic'=> curl_file_create(realpath($img)) //'@'.realpath('11.jpg')
////		);
//////		$re = curlOpen($url)
////		$result = curlOpen($url, array('post'=>$post, 'isupfile'=>true));
////		$jsonarr = json_decode($result, true);
////		 
////		if($jsonarr['status'] != 0)
////		{
////		    echo $jsonarr['msg'];
////		    exit();
////		}
////		$result = $jsonarr['result'];
////		foreach($result as $key=>$val)
////		{
////		    echo $key.' '.$val. '<br>';
////		}
//	}
	public function car_show(){
		$a = "sd";
		dump($a);		 
		$appkey = "e8881ce28c96ce68";//你的appkey
		$url = "http://api.jisuapi.com/licenseplaterecognition/recognize?appkey=".$appkey;		 
		$post = array(
		    'pic'=> '@'.realpath('11.jpg') //curl_file_create(realpath('11.jpg'))
		);
		$result = curlOpen($url, array('post'=>$post, 'isupfile'=>true));
		$jsonarr = json_decode($result, true);
		 
		if($jsonarr['status'] != 0)
		{
		    echo $jsonarr['msg'];
		    exit();
		}
		$result = $jsonarr['result'];
		foreach($result as $key=>$val)
		{
		    echo $key.' '.$val. '<br>';
		}
	}
	// 远程提交OCR获取数据
	public function cardOCR() {  //$filepath
//		$filepath = realpath ('C:\Users\YJS\Desktop\car.jpg'); //$filepath
		$str = file_get_contents('./curl.func.php');
		$str2 = file_put_contents('./curl.func.php');
		echo $str2;
		echo base64_encode($str);
		$file = array (
				"key" => "S2w7ySmGofvphdz2HJ8zze",
				"secret" => "c7cf9a19cbeb482f856d00c4aaf9c58c",
				"typeId" => "19",
				"format" => "json",
				"file" => base64_encode ($str)
		);
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, "http://netocr.com/api/recog.do" );
		curl_setopt ( $curl, CURLOPT_POST, true );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $file );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec ( $curl );
		echo "243";
		curl_close ( $curl );
		return json_decode ( $result, true );
	}
}