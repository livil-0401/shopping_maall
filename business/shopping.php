<?php
	$data = file_get_contents('php://input');
	$json = json_decode($data,TRUE);

	$time = time();

	if($json['userName']){
		$time = time();
		$authcode = $time.$json['userName'];
		$url = 'https://www.excatch.com/business/user/shoppingMall1_home.html?authCode='.$authcode.'&email='.$json['userName'].'';
		// $url = 'https://www.excatch.com?authCode='.$authcode.'&email='.$json['userName'].'';
		$arr = '{"code":200,"msg":"操作成功","data":{"redirectUrl":"'.$url.'","authCode":"'.$authcode.'","uid":"'.$json['uid'].'"}}';
		echo $arr;
	}else{
		$arr = '{"code":201,"msg":"无法确认邮箱地址","uid":"'.$json['uid'].'"}}';
		echo $arr;
	}

	
?>