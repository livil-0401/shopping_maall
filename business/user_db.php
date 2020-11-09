<?php
	include './db/dbconfig.php';
	header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('Asia/Seoul');
	$result = $_POST['result'];

	if($result == "u_select_category"){
		if($conn){
			$sql_select = " SELECT * FROM `s_category` ORDER BY `order_n` ASC ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"k_name" => $row['k_name'],
					"c_name" => $row['c_name'],
					"e_name" => $row['e_name'],
					"order_n" => $row['order_n'],
					"img" => $row['img']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_content_list"){
		if($conn){
			$pk_id = $_POST['pk_id'];
			$s_search = $_POST['s_search'];
			$count = $_POST['count'];
			$category_count = $_POST['category_count'];
			$page = 10;

			$sql_select = " SELECT A.*,B.`company_name` FROM `s_product` A, `s_company` B WHERE A.`company_id` = B.`pk_id` ";
			if($category_count != 0){ $sql_select .= " AND A.`c_pk_id` = ".$category_count." "; }
			if($s_search != ""){ $sql_select .= " AND A.`product_name` LIKE '%".$s_search."%' "; }
			$sql_select .= " ORDER BY A.`pk_id` DESC LIMIT ".$count.", ".$page." ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$collect = 0;
				$sql_ss = " SELECT `pk_id` FROM `s_collect` WHERE `member_id` = ".$pk_id." AND `product_id` = ".$row['pk_id']." ";
				$res_ss = mysqli_query($conn, $sql_ss);
				$row_ss = mysqli_fetch_array($res_ss);
				if($row_ss['pk_id']){ $collect = 1; }

				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"c_pk_id" => $row['c_pk_id'],
					"company_id" => $row['company_id'],
					"product_price" => $row['product_price'],
					"sale_price" => $row['sale_price'],
					"product_quantity" => $row['product_quantity'],
					"insert_time" => $row['insert_time'],
					"update_time" => $row['update_time'],
					"main_img" => $row['main_img'],
					"serve_img_1" => $row['serve_img_1'],
					"serve_img_2" => $row['serve_img_2'],
					"serve_img_3" => $row['serve_img_3'],
					"serve_img_4" => $row['serve_img_4'],
					"serve_img_5" => $row['serve_img_5'],
					"serve_img_6" => $row['serve_img_6'],
					"serve_img_7" => $row['serve_img_7'],
					"status" => $row['status'],
					"type" => $row['type'],
					"company_name" => $row['company_name'],
					"collect" => $collect
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"sql_select" => $sql_select,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_authen_code"){
		if($conn){
			$l_email = $_POST['l_email'];
			$rand_num = sprintf('%06d',rand(000000,999999));
			// setcookie("mall",$rand_num,time() + 1800,"/","114.203.211.76");
			setcookie("mall",$rand_num,time() + 1800,"/",".excatch.com");

			require 'email.class.php';
			$mailto=$l_email;
			$mailsubject="쇼핑몰 로그인 메일인증";
			$mailbody="인증번호: ".$rand_num;
			$smtpserver     = "smtpdm.aliyun.com";
			$smtpserverport = 25;
			$smtpusermail   = "admin@worldf2f.com";
			// 发件人的账号，填写控制台配置的发信地址,比如xxx@xxx.com
			$smtpuser       = "admin@worldf2f.com";
			// 访问SMTP服务时需要提供的密码(在控制台选择发信地址进行设置)
			$smtppass       = "QWqw121212";
			$mailsubject    = "=?UTF-8?B?" . base64_encode($mailsubject) . "?=";
			$mailtype       = "HTML";
			//可选，设置回信地址
			$smtpreplyto    = "***";
			$smtp           = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
			$smtp->debug    = false;
			$cc   ="";
			$bcc  = "";
			$additional_headers = "";
			//设置发件人名称，名称用户可以自定义填写。
			$sender  = "발신:";
			$smtp->sendmail($mailto,$smtpusermail, $mailsubject, $mailbody, $mailtype, $cc, $bcc, $additional_headers, $sender, $smtpreplyto);

			$arr = array(
				"code" => 1,
				"message" => "SUCC"
			);
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_login"){
		if($conn){
			$l_email = $_POST['l_email'];
			$l_authen_code = $_POST['l_authen_code'];
			
			if($_COOKIE["mall"] == $l_authen_code){
				setcookie("u_email",$l_email,0,"/",".excatch.com");

				$sql_select = " SELECT `pk_id` FROM `s_member` WHERE `email` = '".$l_email."' ";
				$result = mysqli_query($conn, $sql_select);
				$row = mysqli_fetch_array($result);
				$time = time();

				if($row['pk_id']){
					$sql_update = " UPDATE `s_member` SET `update_time` = '".$time."' WHERE `email` = '".$l_email."' ";
					mysqli_query($conn, $sql_update);
				}else{
					$sql_insert = " INSERT INTO `s_member` (`pk_id`,`email`,`p_id`,`p_account`,`p_name`,`address`,`insert_time`,`update_time`,`status`) VALUES ";
					$sql_insert .= " (NULL,'".$l_email."',0,'','','','".$time."','".$time."',1) ";
					mysqli_query($conn, $sql_insert);
				}

				$arr = array(
					"code" => 1,
					"aaa" => $_COOKIE["u_email"],
					"message" => "SUCC"
				);
			}else{
				$arr = array(
					"code" => 0,					
					"message" => "NO"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_ck_cookie"){
		if($conn){
			$sql_select = " SELECT `pk_id`,p_id,`address`,`name`,`code`,`phone_number`,`zip_code`,`detailed_address`,`in_ck` FROM `s_member` WHERE `email` = '".$_COOKIE["u_email"]."' ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$sql_count = " SELECT COUNT(*) AS `count` FROM `s_shopping_basket` WHERE `member_id` = ".$row['pk_id']." ";
				$res_count = mysqli_query($conn, $sql_count);
				$row_count = mysqli_fetch_array($res_count);

				$arr = array(
					"code" => 1,
					"message" => $row['pk_id'],
					"p_id" => $row['p_id'],
					"count" => $row_count['count'],
					"address" => $row['address'],
					"name" => $row['name'],
					"g_code" => $row['code'],
					"phone_number" => $row['phone_number'],
					"zip_code" => $row['zip_code'],
					"detailed_address" => $row['detailed_address'],
					"in_ck" => $row['in_ck']
				);
			}else{
				$arr = array(
					"code" => 0,
					"message" => 0
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_collect"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];    // 상품 PK_id
			$pk_id = $_POST['pk_id'];        // 사용자 PK_id

			$sql_select = " SELECT `pk_id` FROM `s_collect` WHERE `member_id` = ".$pk_id." AND `product_id` = ".$j_pk_id." ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$sql_delete = " DELETE FROM `s_collect` WHERE `member_id` = ".$pk_id." AND `product_id` = ".$j_pk_id." ";
				mysqli_query($conn, $sql_delete);

				$arr = array(
					"code" => 1,
					"message" => 2
				);
			}else{
				$sql_insert = " INSERT INTO `s_collect` (`pk_id`,`member_id`,`product_id`) VALUES (NULL,".$pk_id.",".$j_pk_id.") ";
				mysqli_query($conn, $sql_insert);

				$arr = array(
					"code" => 1,
					"message" => 1
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_collect_list"){
		if($conn){
			$pk_id = $_POST['pk_id'];
			$count = $_POST['count'];
			$page = 10;

			$sql_select = " SELECT * FROM `s_collect` WHERE `member_id` = ".$pk_id." ";
			$sql_select .= " ORDER BY `pk_id` DESC LIMIT ".$count.", ".$page." ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$sql_ss = " SELECT * FROM `s_product` WHERE `pk_id` = ".$row['product_id']." ";
				$res_ss = mysqli_query($conn, $sql_ss);
				$row_ss = mysqli_fetch_array($res_ss);

				$res_list[] = array(
					"pk_id" => $row_ss['pk_id'],
					"product_name" => $row_ss['product_name'],
					"product_explanation" => $row_ss['product_explanation'],
					"c_pk_id" => $row_ss['c_pk_id'],
					"company_id" => $row_ss['company_id'],
					"product_price" => $row_ss['product_price'],
					"sale_price" => $row_ss['sale_price'],
					"product_quantity" => $row_ss['product_quantity'],
					"insert_time" => $row_ss['insert_time'],
					"update_time" => $row_ss['update_time'],
					"main_img" => $row_ss['main_img'],
					"serve_img_1" => $row_ss['serve_img_1'],
					"serve_img_2" => $row_ss['serve_img_2'],
					"serve_img_3" => $row_ss['serve_img_3'],
					"serve_img_4" => $row_ss['serve_img_4'],
					"serve_img_5" => $row_ss['serve_img_5'],
					"serve_img_6" => $row_ss['serve_img_6'],
					"serve_img_7" => $row_ss['serve_img_7'],
					"status" => $row_ss['status'],
					"type" => $row_ss['type']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_vies_detail"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$pk_id = $_POST['pk_id'];
			$sql_select = " SELECT * FROM `s_product` WHERE `pk_id` = ".$j_pk_id." ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			$sql_re = " SELECT * FROM `s_review` WHERE `product_id` = ".$row['pk_id']." AND `img_path` != '' ORDER BY `pk_id` DESC LIMIT 0,100 ";
			$res_re = mysqli_query($conn, $sql_re);
			while($row_re = mysqli_fetch_array($res_re)){
				$res_list[] = array(
					"pk_id" => $row_re['pk_id'],
					"member_id" => $row_re['member_id'],
					"title" => $row_re['title'],
					"content" => $row_re['content'],
					"score" => $row_re['score'],
					"insert_time" => $row_re['insert_time'],
					"img_path" => $row_re['img_path'],
					"product_id" => $row_re['product_id']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($row['pk_id']){
				$res = array(
					"pk_id" => $row['pk_id'],
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"c_pk_id" => $row['c_pk_id'],
					"company_id" => $row['company_id'],
					"product_price" => $row['product_price'],
					"sale_price" => $row['sale_price'],
					"product_quantity" => $row['product_quantity'],
					"insert_time" => $row['insert_time'],
					"update_time" => $row['update_time'],
					"main_img" => $row['main_img'],
					"serve_img_1" => $row['serve_img_1'],
					"serve_img_2" => $row['serve_img_2'],
					"serve_img_3" => $row['serve_img_3'],
					"serve_img_4" => $row['serve_img_4'],
					"serve_img_5" => $row['serve_img_5'],
					"serve_img_6" => $row['serve_img_6'],
					"serve_img_7" => $row['serve_img_7'],
					"status" => $row['status'],
					"type" => $row['type'],
					"review" => $res_list
				);
				$res = json_encode($res, JSON_UNESCAPED_UNICODE);
				$arr = array(
					"code" => 1,
					"sql_re" => $sql_re,
					"message" => $res
				);
			}else{
				$arr = array(
					"code" => 0,
					"message" => "NO"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_company_list"){
		if($conn){
			$count = $_POST['count'];
			$res = $_POST['res'];
			$s_search = $_POST['s_search'];
			$page = 10;

			$sql_select = " SELECT A.`pk_id`,A.`company_name`,A.`company_img_2`,B.`k_company` FROM `s_company` A, `s_company_type` B WHERE A.`company_type` = B.`pk_id` ";
			if($res == 1){ $sql_select .= " AND `type` = 1 "; }
			if($s_search != ""){ $sql_select .= " AND A.`company_name` LIKE '%".$s_search."%' "; }
			$sql_select .= " ORDER BY A.`pk_id` DESC LIMIT ".$count.", ".$page." ";
			$result = mysqli_query($conn, $sql_select);

			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"company_name" => $row['company_name'],
					"company_img_2" => $row['company_img_2'],
					"k_company" => $row['k_company']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_company_view"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.*,B.`k_company` FROM `s_company` A, `s_company_type` B WHERE A.`pk_id` = ".$j_pk_id." AND A.`company_type` = B.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$res = array(
					"pk_id" => $row['pk_id'],
					"company_name" => $row['company_name'],
					"company_address" => $row['company_address'],
					"company_contact" => $row['company_contact'],
					"company_img_2" => $row['company_img_2'],
					"k_company" => $row['k_company']
				);
				$res = json_encode($res, JSON_UNESCAPED_UNICODE);
				$arr = array(
					"code" => 1,
					"message" => $res
				);
			}else{
				$arr = array(
					"code" => 0,
					"message" => "NO"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_color_size"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.*,B.`product_price`,B.`sale_price` FROM `s_color_size` A, `s_product` B WHERE A.`p_id` = ".$j_pk_id." AND A.`p_id` = B.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"color" => $row['color'],
					"size" => $row['size'],
					"p_id" => $row['p_id'],
					"quantity" => $row['quantity'],
					"product_price" => $row['product_price'],
					"sale_price" => $row['sale_price']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"sql_select" => $sql_select,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_W_comment"){
		if($conn){
			$member_id = $_POST['pk_id'];
			$title = $_POST['title'];
            $content = $_POST['content'];
            $type = $_POST['type'];
			$time = time();
			
			$insert_sql = "insert into s_question_answer(pk_id,type,member_id,title,content,status,insert_time)values(null,".$type.",".$member_id.",'".$title."','".$content."',1,'".$time."')";
			mysqli_query($conn, $insert_sql);

			$arr = array(
                "code"=>1,
                "message"=>"success"
            );
		}else{
			$arr = array(
                "code"=>0,
                "message"=>"DB_fail"
            );
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_qa_list"){
		if($conn){
			$pk_id = $_POST['pk_id'];
			$S_sql = "select S.*, M.email from s_question_answer S INNER JOIN s_member as M on S.member_id = M.pk_id where M.pk_id = ".$pk_id." order by pk_id desc limit 0,30";
			$result = mysqli_query($conn, $S_sql);

			while($row = mysqli_fetch_array($result)){
				$db_list[] = array(
					"pk_id" => $row['pk_id'],
					"type" => $row['type'],
					"member_id" => $row['member_id'],
					"title" => $row['title'],
					"content" => $row['content'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
					"reply" => $row['reply'],
					"update_time" => $row['update_time'],
					"email" =>$row['email']
				);
			}
			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);
			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}
		}else{
			$arr = array(
				"code"=>0,
				"message"=>"DB_fail"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_adds_basket"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];      // s_color_size   pk_id
			$j_p_id = $_POST['j_p_id'];        // s_product      pk_id
			$pk_id = $_POST['pk_id'];          // 사용자 고유번호

			$sql_select = " SELECT `pk_id` FROM `s_shopping_basket` WHERE `member_id` = ".$pk_id." AND `product_id` = ".$j_p_id." AND `color_size_id` = ".$j_pk_id." ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$arr = array(
					"code" => 0,
					"message"=>"HAVE"
				);
			}else{
				$sql_insert = " INSERT INTO `s_shopping_basket` (`pk_id`,`member_id`,`product_id`,`color_size_id`) VALUES ";
				$sql_insert .= " (NULL,".$pk_id.",".$j_p_id.",".$j_pk_id.") ";
				mysqli_query($conn, $sql_insert);

				$arr = array(
					"code" => 1,
					"message"=>"SUCC"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_shopping_basket"){
		if($conn){
			$pk_id = $_POST['pk_id'];

			$sql_select = " SELECT A.`pk_id`,B.`product_name`,B.`product_explanation`,B.`product_price`,B.`main_img`,C.`color`,C.`size` FROM `s_shopping_basket` A, `s_product` B, `s_color_size` C WHERE A.`member_id` = ".$pk_id." AND A.`product_id` = B.`pk_id` AND A.`color_size_id` = C.`pk_id` ORDER BY A.`pk_id` DESC LIMIT 0, 50 ";
			$result = mysqli_query($conn, $sql_select);

			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"product_price" => $row['product_price'],
					"main_img" => $row['main_img'],
					"color" => $row['color'],
					"size" => $row['size']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_deletes_basket"){
		if($conn){
			$pk_id = $_POST['pk_id'];
			$send_array = $_POST['send_array'];

			if(count($send_array) <= 0){
				$arr = array(
					"code" => 0,
					"message"=>"NO"
				);
			}else{
				$sql_delete = " DELETE FROM `s_shopping_basket` WHERE `pk_id` IN ( ";
				for($i=0; $i<count($send_array); $i++){
					$sql_delete .= $send_array[$i].",";
				}
				$sql_delete = substr($sql_delete, 0, -1);
				$sql_delete .= ")";
				mysqli_query($conn, $sql_delete);

				$arr = array(
					"code" => 1,
					"message"=> "SUCC"
				);
			}

			
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);	
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_payment_list"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.`color`,A.`size`,A.`quantity`,B.*,C.`company_name`,C.`company_img_2` FROM `s_color_size` A, `s_product` B, `s_company` C WHERE A.`pk_id` = ".$j_pk_id." AND A.`p_id` = B.`pk_id` AND B.`company_id` = C.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$res = array(
					"pk_id" => $row['pk_id'],
					"color" => $row['color'],
					"size" => $row['size'],
					"quantity" => $row['quantity'],
					"company_name" => $row['company_name'],
					"company_img_2" => $row['company_img_2'],
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"product_price" => $row['product_price'],
					"sale_price" => $row['sale_price'],
					"main_img" => $row['main_img']
				);
				$res = json_encode($res, JSON_UNESCAPED_UNICODE);
				$arr = array(
					"code" => 1,
					"message" => $res
				);
			}else{
				$arr = array(
					"code" => 0,
					"message"=>"NO"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_select_list"){
		if($conn){
			$pk_id = $_POST['pk_id'];

			$sql_select = " SELECT * FROM `s_member` WHERE `pk_id` = ".$pk_id." ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$res = array(
					"pk_id" => $row['pk_id'],
					"email" => $row['email'],
					"p_id" => $row['p_id'],
					"p_account" => $row['p_account'],
					"p_name" => $row['p_name'],
					"address" => $row['address'],
					"insert_time" => $row['insert_time'],
					"update_time" => $row['update_time'],
					"status" => $row['status'],
					"name" => $row['name'],
					"code" => $row['code'],
					"phone_number" => $row['phone_number'],
					"zip_code" => $row['zip_code']
				);
				$res = json_encode($res, JSON_UNESCAPED_UNICODE);
				$arr = array(
					"code" => 1,
					"message" => $res
				);
			}else{
				$arr = array(
					"code" => 0,
					"message"=>"NO"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_select_country"){
		if($conn){
			$sql_select = " SELECT * FROM `s_country_code` WHERE `status` = 1 ORDER BY `order_n` ASC ";
			$result = mysqli_query($conn, $sql_select);

			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"code" => $row['code']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);	
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_information_change"){
		if($conn){
			$my_name = $_POST['my_name'];
			$my_phone_number = $_POST['my_phone_number'];
			$my_zipcode = $_POST['my_zipcode'];
			$my_address = $_POST['my_address'];
			$my_detailed_address = $_POST['my_detailed_address'];
			$country_code = $_POST['country_code'];
			$pk_id = $_POST['pk_id'];

			$sql_update = " UPDATE `s_member` SET `address` = '".$my_address."',`name` = '".$my_name."',`code` = '".$country_code."',`phone_number` = '".$my_phone_number."',`zip_code` = '".$my_zipcode."',`detailed_address` = '".$my_detailed_address."' WHERE `pk_id` = ".$pk_id." ";
			mysqli_query($conn, $sql_update);

			$arr = array(
				"code" => 1,
				"message"=>"SUCC"
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_select_shuliang"){
		if($conn){
			$i_goumai_suliang = $_POST['i_goumai_suliang'];   // 수량
			$j_pk_id = $_POST['j_pk_id'];                     // product   pk_id
			$s_pk_id = $_POST['s_pk_id'];                     // color_size   pk_id

			$sql_select = " SELECT A.`quantity`, B.`product_price` FROM `s_color_size` A, `s_product` B WHERE A.`pk_id` = ".$s_pk_id." AND A.`p_id` = B.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			$t_price = $row['product_price'] * $i_goumai_suliang;

			if($row['quantity'] < $i_goumai_suliang){
				$arr = array(
					"code" => 0,
					"quantity" => $row['quantity'],
					"message"=>"BIG"
				);
			}else{
				$arr = array(
					"code" => 1,
					"quantity" => $row['quantity'],
					"t_price" => $t_price,
					"message"=>"SUCC"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_ipaybank"){
		if($conn){
			$paybank_email = $_POST['paybank_email'];
			// $http_url = 'http://agent.paybank.com/business/get_id.php';       // 실서버
			$http_url = 'http://agent.paybank.com/business/get_id_test.php';     // 테스트 서버
			$row_p = post($http_url, array('result'=>'get_id', 'email'=>$paybank_email));
			$row_p = json_decode($row_p, JSON_UNESCAPED_UNICODE);

			if($row_p['code'] == 1){
				$message = json_decode($row_p['message'], JSON_UNESCAPED_UNICODE);

				$paybank_id = $message['id'];
				$paybank_name = $message['true_name'];
				$paybank_mobile = $message['user_name'];
				$invitee_id = $message['inviter_id'];

				$sql_select = " SELECT `pk_id` FROM `s_member` WHERE `p_id` = ".$paybank_id." ";
				$result = mysqli_query($conn, $sql_select);
				$row = mysqli_fetch_array($result);
				$time = time();
				setcookie("u_email",$paybank_email,0,"/",".excatch.com");
				if($row['pk_id']){
					$sql_update = " UPDATE `s_member` SET `email` = '".$paybank_email."',`p_account` = '".$paybank_mobile."',`p_name` = '".$paybank_name."',`update_time` = '".$time."',`in_ck` = 1 WHERE `p_id` = ".$paybank_id." ";
					mysqli_query($conn, $sql_update);
				}else{
					$sql_insert = " INSERT INTO `s_member` (`pk_id`,`email`,`p_id`,`p_account`,`p_name`,`address`,`insert_time`,`update_time`,`status`,`name`,`code`,`phone_number`,`zip_code`,`detailed_address`,`in_ck`) VALUES ";
					$sql_insert .= " (NULL,'".$paybank_email."',".$paybank_id.",'".$paybank_mobile."','".$paybank_name."','0','".$time."','".$time."',1,'0','0','0','0','0',1) ";
					mysqli_query($conn, $sql_insert);
				}

				$arr = array(
					"code" => 1,
					"sql_update" => $sql_update,
					"aaa" => $_COOKIE["u_email"],
					"sql_select" => $sql_select,
					"message" => "SUCC"
				);
			}else{
				$arr = array(
					"code" => 0,
					"message" => "FAIL"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_add_order_history"){
		if($conn){
			$t_price = $_POST['t_price'];                       // 총지불액
			$i_goumai_suliang = $_POST['i_goumai_suliang'];     // 수량
			$j_pk_id = $_POST['j_pk_id'];                       // 상품 pk_id
			$s_pk_id = $_POST['s_pk_id'];                       // color_size  pk_id
			$pk_id = $_POST['pk_id'];                           // 사용자 pk_id
			$paybank_id = $_POST['paybank_id'];                 // paybank uid
			$seconds = $_POST['seconds'];                       // 페이뱅크 오더번호
			$i_name = $_POST['i_name'];                         // 수령인
			$i_code = $_POST['i_code'];                         // 국가번호
			$i_phone_number = $_POST['i_phone_number'];         // 휴대폰
			$i_address = $_POST['i_address'];                   // 주소지
			$i_detailed_address = $_POST['i_detailed_address']; // 상세주소
			$i_remarks = $_POST['i_remarks'];                   // 내용
			$time = time();
			$order_num = $time.$pk_id.$j_pk_id;

			$sql_insert = " INSERT INTO `s_order_history` (`pk_id`,`member_id`,`product_id`,`color_size_id`,`order_num`,`p_order_num`,`product_price`,`status`,`insert_time`,";
			$sql_insert .= " `update_time`,`type`,`order_status`,`quantity`,`memo_lan`,`recipient`,`code`,`phone_number`,`address`,`detailed_address`,`contents`) VALUES ";
			$sql_insert .= " (NULL,".$pk_id.",".$j_pk_id.",".$s_pk_id.",'".$order_num."','".$seconds."',".$t_price.",1,'".$time."','".$time."',1,1,".$i_goumai_suliang.",'','".$i_name."',";
			$sql_insert .= " '".$i_code."','".$i_phone_number."','".$i_address."','".$i_detailed_address."','".$i_remarks."') ";
			mysqli_query($conn, $sql_insert);

			$sql_update_1 = " UPDATE `s_color_size` SET `quantity` = `quantity` - ".$i_goumai_suliang." WHERE `pk_id` = ".$s_pk_id." ";
			mysqli_query($conn, $sql_update_1);

			$sql_update_2 = " UPDATE `s_product` SET `product_quantity` = `product_quantity` - ".$i_goumai_suliang." WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_update_2);

			$sql_select = " SELECT B.`return_address` FROM `s_product` A, `s_company` B WHERE A.`pk_id` = ".$j_pk_id." AND A.`company_id` = B.`pk_id` ";
			$res_ss = mysqli_query($conn, $sql_select);
			$row_ss = mysqli_fetch_array($res_ss);

			if($row_ss['return_address']){
				$http_url = $row_ss['return_address'];     // 리턴주소

				$res = array(
					"status" => "1",
					"message" => "success",
					"order_num" => $seconds,
					"paybank_id" => $paybank_id,
					"price" => $t_price,
					"quantity" => $i_goumai_suliang,
					"recipient" => $i_name,
					"country_code" => $i_code,
					"phone_number" => $i_phone_number,
					"address" => $i_address,
					"detailed_address" => $i_detailed_address
				);
				$row_p = post($http_url, $res);
				
				$sql_u = " SELECT `pk_id` FROM `s_order_history` WHERE `order_num` = '".$order_num."' ";
				$res_u = mysqli_query($conn, $sql_u);
				$row_u = mysqli_fetch_array($res_u);
				$res = json_encode($res, JSON_UNESCAPED_UNICODE);
				$sql_u = " UPDATE `s_order_history` SET `memo_lan` = '".$res."' WHERE `pk_id` = ".$row_u['pk_id']." ";
				mysqli_query($conn, $sql_u);
			}
			
			$arr = array(
				"code" => 1,
				"sql_update_2" => $sql_update_2,
				"message"=>"SUCC"
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_notice_2"){
		if($conn){
			$sql_select = " SELECT * FROM `s_notice` WHERE `status` = 1 ORDER BY `pk_id` DESC ";
			$result = mysqli_query($conn, $sql_select);

			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"title" => $row['title'],
					"content" => $row['content'],
					"insert_time" => $row['insert_time']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_notice"){
		if($conn){
			$sql_select = " SELECT * FROM `s_notice` WHERE `status` = 2 ORDER BY `pk_id` DESC ";
			$result = mysqli_query($conn, $sql_select);

			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"title" => $row['title'],
					"content" => $row['content'],
					"insert_time" => $row['insert_time']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_order_delivery"){
		if($conn){
			$pk_id = $_POST['pk_id'];

			$sql_select = " SELECT A.`pk_id`,A.`product_price`,A.`insert_time`,A.`type`,B.`product_name`,B.`main_img` FROM `s_order_history` A, `s_product` B WHERE A.`member_id` = ".$pk_id." AND A.`type` != 3 AND A.`product_id` = B.`pk_id` ORDER BY A.`pk_id` DESC ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"product_price" => $row['product_price'],
					"insert_time" => $row['insert_time'],
					"type" => $row['type'],
					"product_name" => $row['product_name'],
					"main_img" => $row['main_img']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_order_detail"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.`pk_id`,A.`insert_time`,A.`type`,A.`quantity`,A.`product_price`,A.`recipient`,A.`code`,A.`phone_number`,A.`address`,A.`detailed_address`,A.`contents`,A.`delivery_company`,A.`invoice_number`, ";
			$sql_select .= " B.`main_img`,B.`product_name`,B.`product_explanation`,C.`company_img_2`,C.`company_name` ";
			$sql_select .= " FROM `s_order_history` A, `s_product` B, `s_company` C WHERE A.`pk_id` = ".$j_pk_id." AND A.`product_id` = B.`pk_id` AND B.`company_id` = C.`pk_id` ";

			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);
			if($row['delivery_company'] == 0){}
			else{
				$sql_ss = " SELECT `name` FROM `s_delivery_company` WHERE `pk_id` = ".$row['delivery_company']." ";
				$res_ss = mysqli_query($conn, $sql_ss);
				$row_ss = mysqli_fetch_array($res_ss);
			}
			$res = array(
				"pk_id" => $row['pk_id'],
				"insert_time" => $row['insert_time'],
				"type" => $row['type'],
				"quantity" => $row['quantity'],
				"product_price" => $row['product_price'],
				"recipient" => $row['recipient'],
				"code" => $row['code'],
				"phone_number" => $row['phone_number'],
				"address" => $row['address'],
				"detailed_address" => $row['detailed_address'],
				"contents" => $row['contents'],
				"main_img" => $row['main_img'],
				"product_name" => $row['product_name'],
				"product_explanation" => $row['product_explanation'],
				"company_img_2" => $row['company_img_2'],
				"company_name" => $row['company_name'],
				"invoice_number" => $row['invoice_number'],
				"delivery_name" => ($row_ss['name']==null?0:$row_ss['name'])
			);
			$res = json_encode($res, JSON_UNESCAPED_UNICODE);
			$arr = array(
				"code" => 1,
				"message" => $res
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_completion_receipt"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$time = time();

			$sql_update = " UPDATE `s_order_history` SET `update_time` = '".$time."', `type` = 3 WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_update);

			$arr = array(
				"code" => 1,
				"message"=>"SUCC"
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_purchaseHistory_contents"){
		if($conn){
			$pk_id = $_POST['pk_id'];

			$sql_select = " SELECT A.`pk_id`,A.`product_id`,A.`product_price`,A.`insert_time`,A.`order_status`,A.`quantity`,B.`product_name`,B.`product_explanation`,B.`main_img`,C.`company_name`,C.`company_img_2` FROM `s_order_history` A, `s_product` B, `s_company` C WHERE A.`member_id` = ".$pk_id." AND A.`type` = 3 AND A.`product_id` = B.`pk_id` AND B.`company_id` = C.`pk_id` ORDER BY A.`pk_id` DESC LIMIT 0, 50 ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"product_id" => $row['product_id'],
					"product_price" => $row['product_price'],
					"insert_time" => $row['insert_time'],
					"order_status" => $row['order_status'],
					"quantity" => $row['quantity'],
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"main_img" => $row['main_img'],
					"company_name" => $row['company_name'],
					"company_img_2" => $row['company_img_2']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_confirmation_purchase"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$time = time();
			$sql_update = " UPDATE `s_order_history` SET `order_status` = 2 WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_update);

			$sql_select = " SELECT A.*,B.`company_id` FROM `s_order_history` A, `s_product` B WHERE A.`pk_id` = ".$j_pk_id." AND A.`product_id` = B.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			$sql_insert = " INSERT INTO `s_confirmation_purchase` (`pk_id`,`order_id`,`member_id`,`product_id`,`color_size_id`,`company_id`,`order_num`,`p_order_num`,`product_price`,`insert_time`,`update_time`,`quantity`,`status`) VALUES ";
			$sql_insert .= " (NULL,".$row['pk_id'].",".$row['member_id'].",".$row['product_id'].",".$row['color_size_id'].",".$row['company_id'].",'".$row['order_num']."','".$row['p_order_num']."',".$row['product_price'].",'".$time."','".$time."',".$row['quantity'].",1) ";
			mysqli_query($conn, $sql_insert);

			$arr = array(
				"code" => 1,
				"message"=>"SUCC"
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_add_review"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.`pk_id`,A.`product_id`,A.`quantity`,A.`update_time`,B.`product_name`,B.`product_explanation`,B.`main_img`,C.`company_name`,C.`company_img_2` ";
			$sql_select .= " FROM `s_order_history` A, `s_product` B, `s_company` C WHERE A.`pk_id` = ".$j_pk_id." AND A.`product_id` = B.`pk_id` AND B.`company_id` = C.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			$res = array(
				"pk_id" => $row['pk_id'],
				"product_id" => $row['product_id'],
				"quantity" => $row['quantity'],
				"update_time" => $row['update_time'],
				"product_name" => $row['product_name'],
				"product_explanation" => $row['product_explanation'],
				"main_img" => $row['main_img'],
				"company_name" => $row['company_name'],
				"company_img_2" => $row['company_img_2']
			);
			$res = json_encode($res, JSON_UNESCAPED_UNICODE);
			$arr = array(
				"code" => 1,
				"message" => $res
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == 'u_form_add_review'){
		if($conn){
			$pk_id = $_POST['pk_id'];
			$j_pk_id = $_POST['j_pk_id'];
			$i_title = $_POST['i_title'];
			$i_content_text = $_POST['i_content_text'];
			$review_score = $_POST['review_score'];
			$img_file_1 = isset($_FILES['ex_filename']);
			$img_file_name_1 = $_FILES['ex_filename']['name'];
			$tmp_path = "./img/user/tmp/";
			$time = time();

			if($img_file_1 && $img_file_name_1 != ""){
				// 파일 있을시
				$max_file_size = 5242880;
				$ext_img = "jpg,jpeg,png";
				$allowed = explode(',',$ext_img);
				$ext_i = substr($img_file_name_1, strrpos($img_file_name_1, '.') + 1);   // 확장자
				if(!in_array($ext_i, $allowed)){
					print "<script language=javascript> alert('업로드할 수 없는 확장자 입니다.'); history.back(-1); </script>";
				}else{
					if($_FILES['ex_filename']['size'] > $max_file_size){
						print "<script language=javascript> alert('이미지 파일은 5MB 까지만 없로드 가능합니다.'); history.back(-1); </script>";
					}else{
						$t_img = $time.$pk_id.".".$ext_i;
						$tmp_name = "ex_filename";

						if(move_uploaded_file($_FILES[$tmp_name]['tmp_name'], $tmp_path.$t_img)){
							$info_image = getimagesize($tmp_path.$t_img);
							switch($info_image['mime']){
								case "image/jpg";
									$new_image=imagecreatefromjpeg($tmp_path.$t_img);
									break;
								case "image/png";
									$new_image=imagecreatefrompng($tmp_path.$t_img);
									break;
								case "image/jpeg";
									$new_image=imagecreatefromjpeg($tmp_path.$t_img);
									break;
							}
						}

						if($new_image){
							for($p=0; $p<2; $p++){
								if($p==0){
									$w=150;
									$h=150;
									$img_path = "./img/user/review/thum_".$t_img;
								}else{
									$w=480;
									$h=600;
									$img_path = "./img/user/review/main_".$t_img;
								}
								$canvas=imagecreatetruecolor($w,$h);
								imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
								$dir_n=$img_path;
								imagegif($canvas,$dir_n);
							}
						}
						$sql_insert = " INSERT INTO `s_review` (`pk_id`,`member_id`,`title`,`content`,`score`,`insert_time`,`img_path`,`product_id`) VALUES ";
						$sql_insert .= " (NULL,".$pk_id.",'".$i_title."','".$i_content_text."',".$review_score.",'".$time."','".$t_img."',".$j_pk_id.") ";
						mysqli_query($conn, $sql_insert);
						print "<script language=javascript> history.back(-1); </script>";
					}
				}
			}else{
				// 파일 없을시
				$sql_insert = " INSERT INTO `s_review` (`pk_id`,`member_id`,`title`,`content`,`score`,`insert_time`,`img_path`,`product_id`) VALUES ";
				$sql_insert .= " (NULL,".$pk_id.",'".$i_title."','".$i_content_text."',".$review_score.",'".$time."','',".$j_pk_id.") ";
				mysqli_query($conn, $sql_insert);
				print "<script language=javascript> history.back(-1); </script>";
			}
		}else{
			print "<script language=javascript> alert('서버에러 잠시후 다시시도 하세요.'); history.back(-1); </script>";
		}
	}else if($result == 'u_photo_total'){ 
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$sql_re = " SELECT * FROM `s_review` WHERE `product_id` = ".$j_pk_id." AND `img_path` != '' ORDER BY `pk_id` DESC LIMIT 0,100 ";
			$res_re = mysqli_query($conn, $sql_re);
			while($row_re = mysqli_fetch_array($res_re)){
				$res_list[] = array(
					"pk_id" => $row_re['pk_id'],
					"img_path" => $row_re['img_path']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == 'u_photo_detail'){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.`pk_id`,A.`title`,A.`content`,A.`img_path`,B.`email` FROM `s_review` A, `s_member` B WHERE A.`pk_id` = ".$j_pk_id." AND A.`member_id` = B.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			$res = array(
				"pk_id" => $row['pk_id'],
				"title" => $row['title'],
				"content" => $row['content'],
				"img_path" => $row['img_path'],
				"email" => $row['email']
			);
			$res = json_encode($res, JSON_UNESCAPED_UNICODE);
			$arr = array(
				"code" => 1,
				"message" => $res
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == 'u_open_review'){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.`pk_id`,A.`title`,A.`content`,A.`score`,A.`insert_time`,A.`img_path`,A.`product_id`,B.`main_img`,C.`email` FROM `s_review` A, `s_product` B, `s_member` C WHERE A.`product_id` = ".$j_pk_id." AND A.`product_id` = B.`pk_id` AND A.`member_id` = C.`pk_id` ORDER BY A.`pk_id` DESC LIMIT 50 ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"title" => $row['title'],
					"content" => $row['content'],
					"score" => $row['score'],
					"insert_time" => $row['insert_time'],
					"img_path" => $row['img_path'],
					"product_id" => $row['product_id'],
					"main_img" => $row['main_img'],
					"email" => $row['email']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == 'u_purchase_shopping_basket'){
		if($conn){
			$send_array = $_POST['send_array'];

			$sql_select = " SELECT `color_size_id` FROM `s_shopping_basket` WHERE `pk_id` = ".$send_array." ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			$arr = array(
				"code" => 1,
				"sql_select" => $sql_select,
				"message" => $row['color_size_id']
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_delivery"){
		if($conn){
			$sql_select = "SELECT A.invoice_number, A.pk_id, A.delivery_company,B.url_value FROM `s_order_history` A INNER JOIN s_delivery_company as B on B.pk_id = A.delivery_company";
			$sql_select .= " AND A.`type` = 2 order by A.pk_id asc limit 100";
			$result = mysqli_query($conn, $sql_select);
			$sql_update = "";
			mysqli_autocommit($conn,TRUE);
			while($row = mysqli_fetch_array($result)){
				$row_p = get($row['url_value'].$row['invoice_number']);  // 149
				$row_p = json_decode($row_p, JSON_UNESCAPED_UNICODE);
				$time = time();

				if($row_p['message']){  }
				else{
					$sql_update .= "UPDATE `s_order_history` SET `type` = 3, `update_time` = '".$time."' WHERE `pk_id` = ".$row['pk_id'].";";
				}
			}
			mysqli_multi_query($conn, $sql_update);
			mysqli_commit($conn);
			$arr = array(
				"code" => 1,
				"sql_update" => $sql_update,
				"message"=>"SUCC"
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_order_confirm"){
		if($conn){

			$time = time();
			$two_week = $time - 1209600;
			
			$sql_select = "SELECT H.*, C.pk_id as C_pk_id FROM s_order_history H INNER JOIN s_product as P on P.pk_id = H.product_id INNER JOIN s_company as C on C.pk_id = P.company_id"; 
			$sql_select .= " where H.update_time <= '".$two_week."' and  H.type = 3 and H.order_status = 1 order by H.pk_id asc limit 100";
			
			$result = mysqli_query($conn, $sql_select);
			mysqli_autocommit($conn,TRUE);
			$sql_update = "";

			while($row = mysqli_fetch_array($result)){
				
				$order_id = $row['pk_id'];
				$member_id = $row['member_id'];
				$product_id = $row['product_id'];
				$color_size_id = $row['color_size_id'];
				$order_num = $row['order_num'];
				$p_order_num = $row['p_order_num'];
				$quantity = $row['quantity'];
				$product_price = $row['product_price'];
				$C_pk_id = $row['C_pk_id'];
				$update_time = $row['update_time'];
				$product_price = $row['product_price'];

				$sql_update .= "UPDATE `s_order_history` SET `order_status` = 2, `update_time` = '".$time."' WHERE `pk_id` = ".$order_id.";";
				$sql_update .= "INSERT INTO s_confirmation_purchase(pk_id,order_id,member_id,product_id,color_size_id,company_id,order_num,p_order_num,product_price,insert_time,update_time,quantity,`status`,coin_amount,paybank_pax)";
				$sql_update .= "values(null,".$order_id.",".$member_id.",".$product_id.",".$color_size_id.",".$C_pk_id.",'".$order_num."','".$p_order_num."',".$product_price.",'".$time."','".$time."',".$quantity.",1,0,0);";
			}

			mysqli_multi_query($conn, $sql_update);
			mysqli_commit($conn);
			$arr = array(
				"code" => 1,
				"sql_update" => $sql_update,
				"message"=>"SUCC"
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_company_list22"){
		if($conn){
			$company_id = $_POST['company_id'];
			$count = $_POST['count'];
			$page = 10;

			$sql_select = " SELECT A.*,B.`company_name` FROM `s_product` A, `s_company` B WHERE A.`company_id` = ".$company_id." AND A.`company_id` = B.`pk_id` ";
			if($s_search != ""){ $sql_select .= " AND A.`product_name` LIKE '%".$s_search."%' "; }
			$sql_select .= " ORDER BY A.`pk_id` DESC LIMIT ".$count.", ".$page." ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"c_pk_id" => $row['c_pk_id'],
					"company_id" => $row['company_id'],
					"product_price" => $row['product_price'],
					"sale_price" => $row['sale_price'],
					"product_quantity" => $row['product_quantity'],
					"insert_time" => $row['insert_time'],
					"update_time" => $row['update_time'],
					"main_img" => $row['main_img'],
					"serve_img_1" => $row['serve_img_1'],
					"serve_img_2" => $row['serve_img_2'],
					"serve_img_3" => $row['serve_img_3'],
					"serve_img_4" => $row['serve_img_4'],
					"serve_img_5" => $row['serve_img_5'],
					"serve_img_6" => $row['serve_img_6'],
					"serve_img_7" => $row['serve_img_7'],
					"status" => $row['status'],
					"type" => $row['type'],
					"company_name" => $row['company_name']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			if($res_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"sql_select" => $sql_select,
					"message" => $res_list
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_return_request"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.`pk_id`,A.`insert_time`,A.`product_price`,A.`quantity`,B.`product_name`,B.`product_explanation`,B.`main_img`,C.`company_address`,C.`company_contact` FROM `s_order_history` A,`s_product` B, `s_company` C WHERE A.`pk_id` = ".$j_pk_id." AND A.`product_id` = B.`pk_id` AND B.`company_id` = C.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			$res = array(
				"pk_id" => $row['pk_id'],
				"insert_time" => $row['insert_time'],
				"product_price" => $row['product_price'],
				"quantity" => $row['quantity'],
				"product_name" => $row['product_name'],
				"product_explanation" => $row['product_explanation'],
				"main_img" => $row['main_img'],
				"company_address" => $row['company_address'],
				"company_contact" => $row['company_contact']
			);
			$res = json_encode($res, JSON_UNESCAPED_UNICODE);

			$sql_ss = " SELECT `pk_id`,`name` FROM `s_delivery_company` ORDER BY `order_n` ASC ";
			$res_ss = mysqli_query($conn, $sql_ss);
			while($row_ss = mysqli_fetch_array($res_ss)){
				$res_list[] = array(
					"pk_id" => $row_ss['pk_id'],
					"name" => $row_ss['name']
				);
			}
			$res_list = json_encode($res_list, JSON_UNESCAPED_UNICODE);
			$arr = array(
				"code" => 1,
				"message" => $res,
				"delivery" => $res_list
			);
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "u_return_request_action"){
		if($conn){
			$op = $_POST['op'];
			$r_invoice_number = $_POST['r_invoice_number'];
			$r_detailed_reason = $_POST['r_detailed_reason'];
			$j_pk_id = $_POST['j_pk_id'];

			$sql_select = " SELECT A.*,B.`company_id` FROM `s_order_history` A, `s_product` B WHERE A.`pk_id` = ".$j_pk_id." AND A.`product_id` = B.`pk_id` ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);


			if($row['pk_id']){
				$time = time();
				$sql_update = " UPDATE `s_order_history` SET `order_status` = 3 WHERE `pk_id` = ".$row['pk_id']." ";
				mysqli_query($conn, $sql_update);

				$sql_insert = " INSERT INTO `s_return_request` (`pk_id`,`order_id`,`member_id`,`product_id`,`color_size_id`,`company`,`order_num`,`p_order_num`,`product_price`,`insert_time`,`update_time`,`quantity`,`status`,`return_delivery`,`invoice_number`,`detailed_reason`) VALUES ";
				$sql_insert .= " (NULL,".$row['pk_id'].",".$row['member_id'].",".$row['product_id'].",".$row['color_size_id'].",".$row['company_id'].",'".$row['order_num']."','".$row['p_order_num']."',".$row['product_price'].",'".$time."','".$time."',".$row['quantity'].",0,".$op.",'".$r_invoice_number."','".$r_detailed_reason."') ";
				mysqli_query($conn, $sql_insert);

				$arr = array(
					"code" => 1,
					"message"=>"SUCC"
				);
			}else{
				$arr = array(
					"code" => 0,
					"message"=>"FAIL"
				);
			}
		}else{
			$arr = array(
				"code" => 0,
				"message"=>"FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}

	function post($url, $fields){
		$post_field_string = http_build_query($fields, '', '&');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
		curl_setopt($ch, CURLOPT_POST, true);
		$response = curl_exec($ch);
		curl_close ($ch);
		return $response;
	}

	function get($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		// curl_setopt($curl, CURLOPT_HTTP_VERSION, "CURL_HTTP_VERSION_1_1");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	mysql_close($conn);
?>