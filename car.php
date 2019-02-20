<?php
 
require_once 'curl.func.php';
 
$appkey = 'e8881ce28c96ce68';//你的appkey
$url = "http://api.jisuapi.com/licenseplaterecognition/recognize?appkey=$appkey";
 
$post = array(
    'pic'=>'@'.realpath('11.jpg') //'@'.realpath('11.jpg')
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