<?php
	include './db/dbconfig.php';
	header('Content-Type: text/html; charset=UTF-8');
	date_default_timezone_set('Asia/Seoul');
	$result = $_POST['result'];

	if($result == "a_login"){
		if($conn){
			$user_id = $_POST['user_id'];
			$password = md5($_POST['password']);
			$password = md5($password);


			$sql_select = " SELECT * FROM `admin` WHERE `id` = '".$user_id."' AND `password` = '".$password."' ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				setcookie("a_mall_admin_id",$row['id'],0,"/","excatch.com");
				setcookie("a_mall_admin_password",$row['password'],0,"/","excatch.com");

				$arr = array(
					"code" => 1,
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
	}else if($result == "a_ck_cookie"){
		if($conn){
			setcookie("u_email",$l_email,0,"/",".excatch.com");
			$sql_select = " SELECT * FROM `admin` WHERE `id` = '".$_COOKIE["a_mall_admin_id"]."' AND `password` = '".$_COOKIE["a_mall_admin_password"]."' ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$res = array(
					"pk_id" => $row['pk_id']
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
	}else if($result == "a_add_company_type"){
		if($conn){
			$i_k_company = $_POST['i_k_company'];
			$i_c_company = $_POST['i_c_company'];
			$i_e_company = $_POST['i_e_company'];
			$i_order_n = $_POST['i_order_n'];

			$sql_insert = " INSERT INTO `s_company_type` (`pk_id`,`k_company`,`c_company`,`e_company`,`order_n`) VALUES ";
			$sql_insert .= " (NULL,'".$i_k_company."','".$i_c_company."','".$i_e_company."','".$i_order_n."') ";
			mysqli_query($conn, $sql_insert);

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
	}else if($result == "a_company_type_count"){
		if($conn){
			$s_pk_id = $_POST['s_pk_id'];
			$s_k_company = $_POST['s_k_company'];
			$s_c_company = $_POST['s_c_company'];
			$s_e_company = $_POST['s_e_company'];

			$sql_select = " SELECT COUNT(*) AS `count` FROM `s_company_type` WHERE `pk_id` != '' ";
			if($s_pk_id != ""){ $sql_select .= " AND `pk_id` = ".$s_pk_id." "; }
			if($s_k_company != ""){ $sql_select .= " AND `k_company` = '".$s_k_company."' "; }
			if($s_c_company != ""){ $sql_select .= " AND `c_company` = '".$s_c_company."' "; }
			if($s_e_company != ""){ $sql_select .= " AND `e_company` = '".$s_e_company."' "; }
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['count'] == 0){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $row['count']
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
	}else if($result == "a_company_type"){
		if($conn){
			$s_pk_id = $_POST['s_pk_id'];
			$s_k_company = $_POST['s_k_company'];
			$s_c_company = $_POST['s_c_company'];
			$s_e_company = $_POST['s_e_company'];
			$s_data = $_POST['s_data'];
			$e_data = $_POST['e_data'];

			$sql_select = " SELECT * FROM `s_company_type` WHERE `pk_id` != '' ";
			if($s_pk_id != ""){ $sql_select .= " AND `pk_id` = ".$s_pk_id." "; }
			if($s_k_company != ""){ $sql_select .= " AND `k_company` = '".$s_k_company."' "; }
			if($s_c_company != ""){ $sql_select .= " AND `c_company` = '".$s_c_company."' "; }
			if($s_e_company != ""){ $sql_select .= " AND `e_company` = '".$s_e_company."' "; }
			$sql_select .= " ORDER BY `order_n` ASC LIMIT ".$s_data.", ".$e_data." ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"k_company" => $row['k_company'],
					"c_company" => $row['c_company'],
					"e_company" => $row['e_company'],
					"percent" => $row['percent'],
					"order_n" => $row['order_n']
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
	}else if($result == "a_modified_company_type"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$m_k_company = $_POST['m_k_company'];
			$m_c_company = $_POST['m_c_company'];
			$m_e_company = $_POST['m_e_company'];
			$m_order_n = $_POST['m_order_n'];

			$sql_update = " UPDATE `s_company_type` SET `k_company`='".$m_k_company."',`c_company`='".$m_c_company."',`e_company`='".$m_e_company."',`order_n`='".$m_order_n."' WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_update);

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
	}else if($result == "a_company_type_delete"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_delete = " DELETE FROM `s_company_type` WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_delete);

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
	}else if($result == "a_logout"){
		setcookie("a_mall_admin_id",null,-1,"/","excatch.com");
		setcookie("a_mall_admin_password",null,-1,"/","excatch.com");

		$arr = array(
			"code" => 1,
			"message" => "SUCC"
		);
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_select_company_type"){
		if($conn){
			$sql_select = " SELECT * FROM `s_company_type` ORDER BY `order_n` ASC ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"k_company" => $row['k_company'],
					"c_company" => $row['c_company'],
					"e_company" => $row['e_company'],
					"order_n" => $row['order_n']
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
	}else if($result == "a_add_company"){
		if($conn){
			$i_company_type = $_POST['i_company_type'];
			$i_company_name = $_POST['i_company_name'];
			$i_company_address = $_POST['i_company_address'];
			$i_company_contact = $_POST['i_company_contact'];
			$i_company_number = $_POST['i_company_number'];
			$i_return_address = $_POST['i_return_address'];
			$i_total_percent = $_POST['i_total_percent'];
			$img_file_1 = isset($_FILES['i_company_img_1']);
			$img_file_2 = isset($_FILES['i_company_img_2']);
			$img_file_name_1 = $_FILES['i_company_img_1']['name'];
			$img_file_name_2 = $_FILES['i_company_img_2']['name'];

			$tmp_path = "./img/company/tmp/";

			if($img_file_1 && $img_file_name_1 != "" && $img_file_2 && $img_file_name_2 != ""){
				$time = time();
				$max_file_size = 2097152;
				$ext_img = "jpg,jpeg,png";
				$allowed = explode(',',$ext_img);
				$ext_i = substr($img_file_name_1, strrpos($img_file_name_1, '.') + 1);   // 확장자
				$ext_2 = substr($img_file_name_2, strrpos($img_file_name_2, '.') + 1);   // 확장자

				if(!in_array($ext_i, $allowed) || !in_array($ext_2, $allowed)){ 
					print "<script language=javascript> alert('업로드할 수 없는 확장자 입니다.'); history.back(-1); </script>";
				}else{
					if($_FILES['i_company_img_1']['size'] > $max_file_size || $_FILES['i_company_img_2']['size'] > $max_file_size){
						print "<script language=javascript> alert('이미지 파일은 2MB 까지만 없로드 가능합니다.'); history.back(-1); </script>";
					}else{
						$img_name_1 = "";
						$img_name_2 = "";
						for($i=1; $i<3; $i++){
							if($i==1){
								$t_img = $time."_0".$i.".".$ext_i;
								$tmp_name = "i_company_img_1";
								$img_name_1 = $t_img;
							}else{
								$t_img = $time."_0".$i.".".$ext_2;
								$tmp_name = "i_company_img_2";
								$img_name_2 = $t_img;
							}
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
									if($p == 0){
										$w=50;
										$h=50;
										$img_path = "./img/company/main/imgthum/";
									}else{
										$w=500;
										$h=500;
										$img_path = "./img/company/main/imgmain/";
									}
									$canvas=imagecreatetruecolor($w,$h);
									imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
									$dir_n=$img_path.$t_img;
									imagegif($canvas,$dir_n);
								}
							}
						}
						$password = md5("1234");
						$password = md5($password);
						$sql_insert = " INSERT INTO `s_company` (`pk_id`,`company_name`,`company_address`,`company_contact`,`company_number`,`company_type`,`password`,`status`,`insert_time`,`update_time`,`coin_amount`,`company_img_1`,`company_img_2`,`return_address`,`percent`) VALUES ";
						$sql_insert .= "(NULL,'".$i_company_name."','".$i_company_address."','".$i_company_contact."','".$i_company_number."',".$i_company_type.",'".$password."',1,'".$time."','".$time."',0,'".$img_name_1."','".$img_name_2."','".$i_return_address."',".$i_total_percent.")";
						mysqli_query($conn, $sql_insert);

					}
				}
				print "<script language=javascript> alert('등록 성공'); location.replace('./admin/a_company_list.html');</script>";
			}else{ print "<script language=javascript> alert('파일이 업로드 되지 않았습니다.'); history.back(-1); </script>"; }
		}else{ print "<script language=javascript> alert('서버에러 잠시후 다시시도 하세요.'); history.back(-1); </script>"; }

	}else if($result == "a_company_count"){
		if($conn){
			$s_company_type = $_POST['s_company_type'];
			$s_company_name = $_POST['s_company_name'];
			$s_company_contact = $_POST['s_company_contact'];
			$s_company_number = $_POST['s_company_number'];

			$sql_select = " SELECT COUNT(*) AS `count` FROM `s_company` WHERE `pk_id` != '' ";
			if($s_company_type != 0 && $s_company_type != ""){ $sql_select .= " AND `company_type` = ".$s_company_type." "; }
			if($s_company_name != ""){ $sql_select .= " AND `company_name` = '".$s_company_name."' "; }
			if($s_company_contact != ""){ $sql_select .= " AND `company_contact` = '".$s_company_contact."' "; }
			if($s_company_number != ""){ $sql_select .= " AND `company_number` = '".$s_company_number."' "; }
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['count'] == 0){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $row['count']
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
	}else if($result == "a_company"){
		if($conn){
			$s_company_type = $_POST['s_company_type'];
			$s_company_name = $_POST['s_company_name'];
			$s_company_contact = $_POST['s_company_contact'];
			$s_company_number = $_POST['s_company_number'];
			$s_data = $_POST['s_data'];
			$e_data = $_POST['e_data'];

			$sql_select = " SELECT A.*,B.`k_company`,B.`c_company`,B.`e_company` FROM `s_company` A, `s_company_type` B WHERE A.`company_type` = B.`pk_id` ";
			if($s_company_type != 0 && $s_company_type != ""){ $sql_select .= " AND A.`company_type` = ".$s_company_type." "; }
			if($s_company_name != ""){ $sql_select .= " AND A.`company_name` = '".$s_company_name."' "; }
			if($s_company_contact != ""){ $sql_select .= " AND A.`company_contact` = '".$s_company_contact."' "; }
			if($s_company_number != ""){ $sql_select .= " AND A.`company_number` = '".$s_company_number."' "; }
			$sql_select .= " ORDER BY A.`pk_id` DESC LIMIT ".$s_data.", ".$e_data." ";
			$result = mysqli_query($conn, $sql_select);

			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"company_name" => $row['company_name'],
					"company_address" => $row['company_address'],
					"company_contact" => $row['company_contact'],
					"company_number" => $row['company_number'],
					"company_type" => $row['company_type'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
					"update_time" => $row['update_time'],
					"coin_amount" => $row['coin_amount'],
					"company_img_1" => $row['company_img_1'],
					"company_img_2" => $row['company_img_2'],
					"return_address" => $row['return_address'],
					"k_company" => $row['k_company'],
					"c_company" => $row['c_company'],
					"c_company" => $row['c_company'],
					"paybank_id" => $row['paybank_id'],
					"otp_ck" => $row['otp_ck'],
					"percent" => $row['percent']
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
	}else if($result == "a_company_delete"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_update = " UPDATE `s_company` SET `status` = 0 WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_update);

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
	}else if($result == "a_company_release"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_update = " UPDATE `s_company` SET `status` = 1 WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_update);

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
	}else if($result == "a_modified_company"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$m_company_type = $_POST['m_company_type'];
			$m_company_name = $_POST['m_company_name'];
			$m_company_address = $_POST['m_company_address'];
			$m_company_contact = $_POST['m_company_contact'];
			$m_company_number = $_POST['m_company_number'];
			$m_return_address = $_POST['m_return_address'];
			$img_file_2 = isset($_FILES['m_company_img_2']);
			$img_file_name_2 = $_FILES['m_company_img_2']['name'];

			if($img_file_2 && $img_file_name_2 != ""){
				$time = time();
				$max_file_size = 2097152;
				$ext_img = "jpg,jpeg,png";
				$allowed = explode(',',$ext_img);
				$ext_2 = substr($img_file_name_2, strrpos($img_file_name_2, '.') + 1);   // 확장자
				if(!in_array($ext_2, $allowed)){
					print "<script language=javascript> alert('업로드할 수 없는 확장자 입니다.'); history.back(-1); </script>";
				}else{
					if($_FILES['m_company_img_2']['size'] > $max_file_size){
						print "<script language=javascript> alert('이미지 파일은 2MB 까지만 없로드 가능합니다.'); history.back(-1); </script>";
					}else{
						$sql_select = " SELECT `company_img_2` FROM `s_company` WHERE `pk_id` = ".$j_pk_id." ";
						$result = mysqli_query($conn, $sql_select);
						$row = mysqli_fetch_array($result);
						$tmp_path = "./img/company/tmp/";
						$t_img = $row['company_img_2'];

						if(move_uploaded_file($_FILES['m_company_img_2']['tmp_name'], $tmp_path.$t_img)){
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
								if($p == 0){
									$w=50;
									$h=50;
									$img_path = "./img/company/main/imgthum/";
								}else{
									$w=500;
									$h=500;
									$img_path = "./img/company/main/imgmain/";
								}
								$canvas=imagecreatetruecolor($w,$h);
								imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
								$dir_n=$img_path.$t_img;
								imagegif($canvas,$dir_n);
							}
						}
						$sql_update = " UPDATE `s_company` SET `company_name`='".$m_company_name."',`company_address`='".$m_company_address."',`company_contact`='".$m_company_contact."', ";
						$sql_update .= " `company_number`='".$m_company_number."',`company_type`=".$m_company_type.",`return_address`='".$m_return_address."' WHERE `pk_id` = ".$j_pk_id." ";
						mysqli_query($conn, $sql_update);
						print "<script language=javascript> alert('수정 성공'); location.replace('./admin/a_company_list.html');</script>";
					}
				}
				
			}else{
				$sql_update = " UPDATE `s_company` SET `company_name`='".$m_company_name."',`company_address`='".$m_company_address."',`company_contact`='".$m_company_contact."', ";
				$sql_update .= " `company_number`='".$m_company_number."',`company_type`=".$m_company_type.",`return_address`='".$m_return_address."' WHERE `pk_id` = ".$j_pk_id." ";
				mysqli_query($conn, $sql_update);
				print "<script language=javascript> alert('수정 성공'); location.replace('./admin/a_company_list.html');</script>";
			}
		}else{
			print "<script language=javascript> alert('서버에러 잠시후 다시시도 하세요.'); history.back(-1); </script>";
		}
	}else if($result == "a_add_category"){
		if($conn){
			$i_k_name = $_POST['i_k_name'];
			$i_c_name = $_POST['i_c_name'];
			$i_e_name = $_POST['i_e_name'];
			$i_order_n = $_POST['i_order_n'];

			$sql_insert = " INSERT INTO `s_category` (`pk_id`,`k_name`,`c_name`,`e_name`,`order_n`,`j_id`) VALUES ";
			$sql_insert .= " (NULL,'".$i_k_name."','".$i_c_name."','".$i_e_name."',".$i_order_n.",0) ";
			mysqli_query($conn, $sql_insert);

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
	}else if($result == "a_category_count"){
		if($conn){
			$s_pk_id = $_POST['s_pk_id'];
			$s_k_name = $_POST['s_k_name'];
			$s_c_name = $_POST['s_c_name'];
			$s_e_name = $_POST['s_e_name'];
			
			$sql_select = " SELECT COUNT(*) AS `count` FROM `s_category` WHERE `pk_id` != '' ";
			if($s_pk_id != ""){ $sql_select .= " AND `pk_id` = ".$s_pk_id." "; }
			if($s_k_name != ""){ $sql_select .= " AND `k_name` = '".$s_k_name."' "; }
			if($s_c_name != ""){ $sql_select .= " AND `c_name` = '".$s_c_name."' "; }
			if($s_e_name != ""){ $sql_select .= " AND `e_name` = '".$s_e_name."' "; }
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['count'] == 0){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $row['count']
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
	}else if($result == "a_category"){
		if($conn){
			$s_pk_id = $_POST['s_pk_id'];
			$s_k_name = $_POST['s_k_name'];
			$s_c_name = $_POST['s_c_name'];
			$s_e_name = $_POST['s_e_name'];
			$s_data = $_POST['s_data'];
			$e_data = $_POST['e_data'];

			$sql_select = " SELECT * FROM `s_category` WHERE `pk_id` != '' ";
			if($s_pk_id != ""){ $sql_select .= " AND `pk_id` = ".$s_pk_id." "; }
			if($s_k_name != ""){ $sql_select .= " AND `k_name` = '".$s_k_name."' "; }
			if($s_c_name != ""){ $sql_select .= " AND `c_name` = '".$s_c_name."' "; }
			if($s_e_name != ""){ $sql_select .= " AND `e_name` = '".$s_e_name."' "; }
			$sql_select .= " ORDER BY `order_n` ASC LIMIT ".$s_data.", ".$e_data." ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"k_name" => $row['k_name'],
					"c_name" => $row['c_name'],
					"e_name" => $row['e_name'],
					"order_n" => $row['order_n']
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
	}else if($result == "a_category_delete"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];

			$sql_delete = " DELETE FROM `s_category` WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_delete);

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
	}else if($result == "a_category_modified"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$m_k_name = $_POST['m_k_name'];
			$m_c_name = $_POST['m_c_name'];
			$m_e_name = $_POST['m_e_name'];
			$m_order_n = $_POST['m_order_n'];

			$sql_update = " UPDATE `s_category` SET `k_name`='".$m_k_name."',`c_name`='".$m_c_name."',`e_name`='".$m_e_name."',`order_n`=".$m_order_n." WHERE `pk_id` = ".$j_pk_id." ";
			mysqli_query($conn, $sql_update);

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
	}else if($result == "c_login"){
		if($conn){
			$user_id = $_POST['user_id'];
			$password = md5($_POST['password']);
			$password = md5($password);

			$sql_select = " SELECT `pk_id`,`company_number`,`password`,`status` FROM `s_company` WHERE `company_number` = '".$user_id."' AND `password` = '".$password."' ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				setcookie("c_mall_company_number",$row['company_number'],0,"/","excatch.com");
				setcookie("c_mall_company_password",$row['password'],0,"/","excatch.com");
				setcookie("c_mall_company_status",$row['status'],0,"/","excatch.com");

				$arr = array(
					"code" => 1,
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
	}else if($result == "c_logout"){
		setcookie("c_mall_company_number",null,-1,"/","excatch.com");
		setcookie("c_mall_company_password",null,-1,"/","excatch.com");
		setcookie("c_mall_company_status",null,-1,"/","excatch.com");

		$arr = array(
			"code" => 1,
			"message" => "SUCC"
		);
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_ck_cookie"){
		if($conn){
			$sql_select = " SELECT `pk_id`,`status`,`company_name`,`company_address`,`company_contact`,`otp_ck`,`paybank_id`,`return_address` FROM `s_company` WHERE `company_number` = '".$_COOKIE["c_mall_company_number"]."' AND `password` = '".$_COOKIE["c_mall_company_password"]."' ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$arr = array(
					"code" => 1,
					"pk_id" => $row['pk_id'],
					"status" => $row['status'],
					"otp_ck" => $row['otp_ck'],
					"company_name" => $row['company_name'],
					"paybank_id" => $row['paybank_id'],
					"company_address" => $row['company_address'],
					"company_contact" => $row['company_contact'],
					"return_address" => $row['return_address']
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
	}else if($result == "c_select_category"){
		if($conn){
			$sql_select = " SELECT * FROM `s_category` ORDER BY `order_n` ASC ";
			$result = mysqli_query($conn, $sql_select);
			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"k_name" => $row['k_name'],
					"c_name" => $row['c_name'],
					"e_name" => $row['e_name'],
					"order_n" => $row['order_n']
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
	}else if($result == "c_add_product"){
		if($conn){
			$pk_id = $_POST['pk_id'];             					    // 업체 pk_id
			$size_color_count = $_POST['size_color_count'];             // 싸이즈 및 색상 선택 갯수
			$i_c_pk_id = $_POST['i_c_pk_id'];                           // 카테고리
			$i_type = $_POST['i_type'];                                 // type (1. 하루세일, 2. 일반)
			$i_product_name = $_POST['i_product_name'];                 // 상품이름
			$i_product_explanation = $_POST['i_product_explanation'];   // 상품설명
			$i_product_price = $_POST['i_product_price'];               // 판매가격
			$i_sale_price = $_POST['i_sale_price'];                     // 세일가격

			$i_main_img = isset($_FILES['i_main_img']);                 // 메인이미지
			$i_detail_img_1 = isset($_FILES['i_detail_img_1']);         // 상세이미지1
			$i_detail_img_2 = isset($_FILES['i_detail_img_2']);         // 상세이미지2
			$i_detail_img_3 = isset($_FILES['i_detail_img_3']);         // 상세이미지3
			$i_detail_img_4 = isset($_FILES['i_detail_img_4']);         // 상세이미지4
			$i_detail_img_5 = isset($_FILES['i_detail_img_5']);         // 상세이미지5
			$i_detail_img_6 = isset($_FILES['i_detail_img_6']);         // 상세이미지6
			$i_detail_img_7 = isset($_FILES['i_detail_img_7']);         // 상세이미지7
			
			$i_main_img_name = $_FILES['i_main_img']['name'];           // 메인이미지 이름

			$i_detail_img_1_name = $_FILES['i_detail_img_1']['name'];   // 상세이미지 이름1

			$i_detail_img_2_name = $_FILES['i_detail_img_2']['name'];   // 상세이미지 이름2

			$i_detail_img_3_name = $_FILES['i_detail_img_3']['name'];   // 상세이미지 이름3

			$i_detail_img_4_name = $_FILES['i_detail_img_4']['name'];   // 상세이미지 이름4

			$i_detail_img_5_name = $_FILES['i_detail_img_5']['name'];   // 상세이미지 이름5
			$i_detail_img_6_name = $_FILES['i_detail_img_6']['name'];   // 상세이미지 이름6
			$i_detail_img_7_name = $_FILES['i_detail_img_7']['name'];   // 상세이미지 이름7

			if($i_main_img_name && $i_detail_img_1_name && $i_detail_img_2_name && $i_detail_img_3_name && $i_detail_img_4_name){
				$time = time();
				$tmp_path = "./img/user/tmp/";
				$max_file_size = 2097152;
				$ext_img = "jpg,jpeg,png";
				$allowed = explode(',',$ext_img);
				$ext_0 = substr($i_main_img_name, strrpos($i_main_img_name, '.') + 1);   		 // 확장자
				$ext_1 = substr($i_detail_img_1_name, strrpos($i_detail_img_1_name, '.') + 1);   // 확장자
				$ext_2 = substr($i_detail_img_2_name, strrpos($i_detail_img_2_name, '.') + 1);   // 확장자
				$ext_3 = substr($i_detail_img_3_name, strrpos($i_detail_img_3_name, '.') + 1);   // 확장자
				$ext_4 = substr($i_detail_img_4_name, strrpos($i_detail_img_4_name, '.') + 1);   // 확장자

				if(!in_array($ext_0, $allowed) || !in_array($ext_1, $allowed) || !in_array($ext_2, $allowed) || !in_array($ext_3, $allowed) || !in_array($ext_4, $allowed)){
					print "<script language=javascript> alert('업로드할 수 없는 확장자 입니다.'); history.back(-1); </script>";
				}else{
					if($_FILES['i_main_img']['size'] > $max_file_size || $_FILES['i_detail_img_1']['size'] > $max_file_size || $_FILES['i_detail_img_2']['size'] > $max_file_size || $_FILES['i_detail_img_3']['size'] > $max_file_size || $_FILES['i_detail_img_4']['size'] > $max_file_size){
						print "<script language=javascript> alert('이미지 파일은 2MB 까지만 없로드 가능합니다.'); history.back(-1); </script>";
					}else{
						$img_name_0 = "";
						$img_name_1 = "";
						$img_name_2 = "";
						$img_name_3 = "";
						$img_name_4 = "";
						$img_name_5 = "";
						$img_name_6 = "";
						$img_name_7 = "";
						for($i=0; $i<5; $i++){
							if($i==0){
								$t_img = $time."_0".$i."".$pk_id.".".$ext_0;
								$tmp_name = "i_main_img";
								$img_name_0 = $t_img;
							}else if($i==1){
								$t_img = $time."_0".$i."".$pk_id.".".$ext_1;
								$tmp_name = "i_detail_img_1";
								$img_name_1 = $t_img;
							}else if($i==2){
								$t_img = $time."_0".$i."".$pk_id.".".$ext_2;
								$tmp_name = "i_detail_img_2";
								$img_name_2 = $t_img;
							}else if($i==3){
								$t_img = $time."_0".$i."".$pk_id.".".$ext_3;
								$tmp_name = "i_detail_img_3";
								$img_name_3 = $t_img;
							}else if($i==4){
								$t_img = $time."_0".$i."".$pk_id.".".$ext_4;
								$tmp_name = "i_detail_img_4";
								$img_name_4 = $t_img;
							}
							
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
								if($i==0){
									for($p=0; $p<2; $p++){
										if($p==0){
											$w=150;
											$h=150;
											$img_path = "./img/user/main/thum_".$t_img;
										}else{
											$w=480;
											$h=600;
											$img_path = "./img/user/main/main_".$t_img;
										}
										$canvas=imagecreatetruecolor($w,$h);
										imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
										$dir_n=$img_path;
										imagegif($canvas,$dir_n);
									}
								}else{
									$w=1005;
									$h=1005;
									$img_path = "./img/user/details/".$t_img;
									$canvas=imagecreatetruecolor($w,$h);
									imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
									$dir_n=$img_path;
									imagegif($canvas,$dir_n);
								}
							}
						}

						if($i_detail_img_5_name){
							$ext_5 = substr($i_detail_img_5_name, strrpos($i_detail_img_5_name, '.') + 1);   		 // 확장자
							$t_img = $time."_05".$pk_id.".".$ext_5;
							$tmp_name = "i_detail_img_5";
							$img_name_5 = $t_img;

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
								$w=1005;
								$h=1005;
								$img_path = "./img/user/details/".$t_img;
								$canvas=imagecreatetruecolor($w,$h);
								imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
								$dir_n=$img_path;
								imagegif($canvas,$dir_n);
							}
						}
						if($i_detail_img_6_name){
							$ext_6 = substr($i_detail_img_6_name, strrpos($i_detail_img_6_name, '.') + 1);   		 // 확장자
							$t_img = $time."_06".$pk_id.".".$ext_6;
							$tmp_name = "i_detail_img_6";
							$img_name_6 = $t_img;

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
								$w=1005;
								$h=1005;
								$img_path = "./img/user/details/".$t_img;
								$canvas=imagecreatetruecolor($w,$h);
								imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
								$dir_n=$img_path;
								imagegif($canvas,$dir_n);
							}
						}
						if($i_detail_img_7_name){
							$ext_7 = substr($i_detail_img_7_name, strrpos($i_detail_img_7_name, '.') + 1);   		 // 확장자
							$t_img = $time."_07".$pk_id.".".$ext_7;
							$tmp_name = "i_detail_img_7";
							$img_name_7 = $t_img;

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
								$w=1005;
								$h=1005;
								$img_path = "./img/user/details/".$t_img;
								$canvas=imagecreatetruecolor($w,$h);
								imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
								$dir_n=$img_path;
								imagegif($canvas,$dir_n);
							}
						}
						
						// db 저장
						$sql_insert = " INSERT INTO `s_product` (`pk_id`,`product_name`,`product_explanation`,`c_pk_id`,`company_id`,`product_price`,`sale_price`,`product_quantity`,`insert_time`,`update_time`,`main_img`,`serve_img_1`,`serve_img_2`,`serve_img_3`,`serve_img_4`,`serve_img_5`,`serve_img_6`,`serve_img_7`,`status`,`type`) VALUES ";
						$sql_insert .= " (NULL,'".$i_product_name."','".$i_product_explanation."',".$i_c_pk_id.",".$pk_id.",".$i_product_price.",".$i_sale_price.",0,'".$time."','".$time."','".$img_name_0."','".$img_name_1."','".$img_name_2."','".$img_name_3."','".$img_name_4."','".$img_name_5."','".$img_name_6."','".$img_name_7."',1,".$i_type.") ";
						mysqli_query($conn, $sql_insert);

						$sql_select = " SELECT `pk_id` FROM `s_product` WHERE `company_id` = ".$pk_id." ORDER BY `pk_id` DESC LIMIT 1 ";
						$result = mysqli_query($conn, $sql_select);
						$row = mysqli_fetch_array($result);
						
						$total_quantity = 0;
						for($i=0; $i<$size_color_count; $i++){
							$sql_i_cs = " INSERT INTO `s_color_size` (`pk_id`,`color`,`size`,`p_id`,`quantity`) VALUES ";
							$sql_i_cs .= " (NULL,'".$_POST['i_size_color_'.$i.'_color']."','".$_POST['i_size_color_'.$i.'_size']."',".$row['pk_id'].",".$_POST['i_size_color_'.$i.'_quantity'].") ";
							mysqli_query($conn, $sql_i_cs);
							$total_quantity = $total_quantity + $_POST['i_size_color_'.$i.'_quantity'];
						}
						$sql_update = " UPDATE `s_product` SET `product_quantity` = ".$total_quantity." WHERE `pk_id` = ".$row['pk_id']." ";
						mysqli_query($conn, $sql_update);
						print "<script language=javascript> alert('등록 완료'); location.replace('./company/c_goods_list.html');</script>";
					}
				}
			}else{ 
				print "<script language=javascript> alert('이미지 파일이 업로드 되지 않았습니다.'); history.back(-1); </script>"; }
		}else{ 
			print "<script language=javascript> alert('서버에러 잠시후 다시시도 하세요.'); history.back(-1); </script>"; }
	}else if($result == "c_goods_count"){
		if($conn){
			$pk_id = $_POST['pk_id'];
			$s_c_pk_id = $_POST['s_c_pk_id'];
			$s_status = $_POST['s_status'];
			$s_pk_id = $_POST['s_pk_id'];
			$s_product_name = $_POST['s_product_name'];

			$sql_select = " SELECT COUNT(*) AS `count` FROM `s_product` WHERE `company_id` = ".$pk_id." ";
			if($s_c_pk_id != 0 && $s_c_pk_id != ""){ $sql_select .= " AND `c_pk_id` = ".$s_c_pk_id." "; }
			if($s_status != 0 && $s_status != ""){ $sql_select .= " AND `status` = ".$s_status." "; }
			if($s_pk_id != ""){ $sql_select .= " AND `pk_id` = ".$s_pk_id." "; }
			if($s_product_name != ""){ $sql_select .= " AND `product_name` = '".$s_product_name."' "; }
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['count'] == 0){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $row['count']
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
	}else if($result == "c_goods"){
		if($conn){
			$pk_id = $_POST['pk_id'];
			$s_c_pk_id = $_POST['s_c_pk_id'];
			$s_status = $_POST['s_status'];
			$s_pk_id = $_POST['s_pk_id'];
			$s_product_name = $_POST['s_product_name'];
			$s_data = $_POST['s_data'];
			$e_data = $_POST['e_data'];

			$sql_select = " SELECT A.*,B.`k_name` FROM `s_product` A, `s_category` B WHERE A.`company_id` = ".$pk_id." AND A.`c_pk_id` = B.`pk_id` ";
			if($s_c_pk_id != 0 && $s_c_pk_id != ""){ $sql_select .= " AND A.`c_pk_id` = ".$s_c_pk_id." "; }
			if($s_status != 0 && $s_status != ""){ $sql_select .= " AND A.`status` = ".$s_status." "; }
			if($s_pk_id != ""){ $sql_select .= " AND A.`pk_id` = ".$s_pk_id." "; }
			if($s_product_name != ""){ $sql_select .= " AND A.`product_name` = '".$s_product_name."' "; }
			$sql_select .= " ORDER BY A.`pk_id` DESC LIMIT ".$s_data.", ".$e_data." ";
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
					"k_name" => $row['k_name']
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
	}else if($result == "c_product_delete"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$sql_select = " SELECT * FROM `s_product` WHERE `pk_id` = ".$j_pk_id." ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$path = "./img/user/";
				unlink($path."main/main_".$row['main_img']);
				unlink($path."main/thum_".$row['main_img']);
				unlink($path."details/".$row['serve_img_1']);
				unlink($path."details/".$row['serve_img_2']);
				unlink($path."details/".$row['serve_img_3']);
				unlink($path."details/".$row['serve_img_4']);
				unlink($path."tmp/".$row['main_img']);
				unlink($path."tmp/".$row['serve_img_1']);
				unlink($path."tmp/".$row['serve_img_2']);
				unlink($path."tmp/".$row['serve_img_3']);
				unlink($path."tmp/".$row['serve_img_4']);

				if($row['serve_img_5']){
					unlink($path."details/".$row['serve_img_5']);
					unlink($path."tmp/".$row['serve_img_5']);
				}

				if($row['serve_img_6']){
					unlink($path."details/".$row['serve_img_6']);
					unlink($path."tmp/".$row['serve_img_6']);
				}

				if($row['serve_img_7']){
					unlink($path."details/".$row['serve_img_7']);
					unlink($path."tmp/".$row['serve_img_7']);
				}

				$sql_d1 = " DELETE FROM `s_color_size` WHERE `p_id` = ".$j_pk_id." ";
				mysqli_query($conn, $sql_d1);

				$sql_d2 = " DELETE FROM `s_product` WHERE `pk_id` = ".$j_pk_id." ";
				mysqli_query($conn, $sql_d2);


				$sql_d3 = " DELETE FROM `s_collect` WHERE `product_id` = ".$j_pk_id." ";
				mysqli_query($conn, $sql_d3);

				$sql_d4 = " DELETE FROM `s_shopping_basket` WHERE `product_id` = ".$j_pk_id." ";
				mysqli_query($conn, $sql_d4);

				$arr = array(
					"code" => 1,
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
	}else if($result == "a_notice_count"){
		if($conn){
			//count 페이지의 개수
            $count_sql = "select count(*) as cnt from s_notice";
            //query문 실행
			$result = mysqli_query($conn, $count_sql);
			//query 결과 가져오기
			$row = mysqli_fetch_array($result);
			//결과값 front 보내주기
            if($row){
                //array  선언해서 결과 코드 구분
                $arr = array(
                    "code" => 1,
                    "message" => $row['cnt']
                );
            }else{
                $arr = array(
                    "code" => 0,
                    "message"=> "failure"
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
	}else if($result == "a_notice"){
		if($conn){
			//front에서 받은 값
			$s_point = $_POST['s_point'];
			$list = $_POST['list'];

			 //select sql문
			$select_sql = "select * from s_notice ORDER BY pk_id desc limit ".$s_point.", ".$list." "; 
			 //결과 값
			$result = mysqli_query($conn, $select_sql);
			 //DB 값 front return하기 
			while($row = mysqli_fetch_array($result)){
				$db_list[] = array(
					"pk_id" => $row['pk_id'],
					"title" => $row['title'],
					"content" => $row['content'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
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
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_add_notice"){
		if($conn){
			//front에서 받아온 데이터 
			$i_status = $_POST['i_status'];
			$i_title = $_POST['i_title'];
			$i_content = $_POST['i_content'];
			$time = time();

			//insert sql문
            $insert_sql = "insert into s_notice(pk_id,title,content,status,insert_time)values(null,'".$i_title."','".$i_content."','".$i_status."','".$time."')";
            //query문
			$result = mysqli_query($conn, $insert_sql);
			
			$arr = array(
                "code"=>1,
                "message"=>"success"
            );
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_notice_delete"){
		if($conn){
			$j_pk_id = $_POST['j_pk_id'];
			$delete_sql = "delete from s_notice where pk_id = ".$j_pk_id."";
			mysqli_query($conn, $delete_sql);

			$arr = array(
				"code" => 1,
				"message" => "success"
			);
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_edit_notice"){
		if($conn){
			$m_pk_id = $_POST['m_pk_id'];
            $m_title = $_POST['m_title'];
			$m_content = $_POST['m_content'];
			$m_status = $_POST['m_status'];
			
			//update sql
            $update_sql = "update s_notice set title = '".$m_title."', content = '".$m_content."', `status` = '".$m_status."' where pk_id = ".$m_pk_id."";
            //결과 값
			mysqli_query($conn, $update_sql);
			$arr = array(
				"code"=>1,
                "message"=>"success"
            );
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_C_count"){
		if($conn){

            //s_question_answer 데이터 count
            $C_count_sql = "select count(*) AS cnt from s_question_answer";

            //query 문 
            $result = mysqli_query($conn, $C_count_sql);
            
            //결과 값
            $row = mysqli_fetch_array($result);


            if($row){
                $arr = array(
                    "code" => 1,
                    "message" =>$row['cnt']
                );
            }else{
                $arr = array(
                    "code" => 0,
                    "message" => "count_fail"
                );
            }
        }else{
                $arr = array(
                    "code" => 0,
                    "message" => "DB_fail"
                );
            }

            $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
            echo $arr;
	}else if($result == "a_C_update"){
		if($conn){
            //front data 받기 오기

            $pk_id = $_POST['pk_id'];
            $reply = $_POST['content'];
            $time = time();

            //sql update 

            $sql_update = "update s_question_answer set reply = '".$reply."', update_time = '".$time."', status = 2 where pk_id = ".$pk_id." ";
        
            //query 문

            $result = mysqli_query($conn, $sql_update);


            //값 있으면 결과 처리 하기 
            if($result){
                $arr = array(
                "code"=>1,
                "message"=>"success"
                );
            }else{
                $arr = array(
                "code"=>0,
                "message"=>"update_fail"
                );
			}
			
			
			


        }else{
            $arr = array(
                "code" => 0,
                "message" => "mysql_error"
            );
        }

        $arr = json_decode($arr, JSON_UNESCAPED_UNICODE);
        echo $arr;
	}else if($result == "a_S_product"){
		if($conn){
              //s_question_answer 데이터 count
            $S_count_sql = "select count(*) AS cnt from s_product";

            //query 문 
            $result = mysqli_query($conn, $S_count_sql);
            
            //결과 값
            $row = mysqli_fetch_array($result);

            if($row){
                $arr = array(
                    "code" => 1,
                    "message" =>$row['cnt']
                );
            }else{
                $arr = array(
                    "code" => 0,
                    "message" => "count_fail"
                );
            }
        }else{
            $arr = array(
                "code"=>0,
                "message"=>"sql fail"
            );
        }

        $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $arr;
	}else if($result == "a_S_product_data"){
		if($conn){
            //front 받은 데이터 
            $s_point = $_POST['s_point'];
            $list = $_POST['list'];

            //select product_data 

            $S_sql = "select P.*, B.company_name from s_product P, s_company B where P.company_id = B.pk_id order by P.pk_id desc limit ".$s_point.", ".$list."";
            
            //query sql 

            $result = mysqli_query($conn,$S_sql);
            while($row = mysqli_fetch_array($result)){
                    $db_list[] = array(
					"pk_id" => $row['pk_id'],
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"c_pk_id" => $row['c_pk_id'],
					"company_name" => $row['company_name'],
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
				);
            }

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
                "code"=> 0,
                "message" => "DB_fail"
            );
        }
        $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $arr;
	}else if($result == "a_delete_img"){
		if($conn){
            
            $S_pk = $_POST['S_pk_id'];
            $pk_id = $_POST['pk_id'];
            //sql select 

            $S_sql = "select * from s_product where pk_id = ".$pk_id."";

            //query
            $result = mysqli_query($conn, $S_sql);
            
            //DB 데이터의 값
            $row = mysqli_fetch_array($result);
            
            //if걸어서 DB 이미지 값을 조회
            //DB 결과 값이 있으면 삭제 없으면 
            

            $main_img = $row['main_img']; 

            $serve_img_1 = $row['serve_img_1']; 
            $serve_img_2 = $row['serve_img_2']; 
            $serve_img_3 = $row['serve_img_3']; 
            $serve_img_4 = $row['serve_img_4']; 
            
            //이미지 경로 변수 처리 
            $S_main_img = "./img/user/main/thum_".$main_img;
            $L_main_img = "./img/user/main/main_".$main_img;
            $D_server_img_1 ="./img/user/details/".$serve_img_1;
            $D_server_img_2 ="./img/user/details/".$serve_img_2;
            $D_server_img_3 ="./img/user/details/".$serve_img_3;
            $D_server_img_4 ="./img/user/details/".$serve_img_4;
    
            $T_main_img = "./img/user/tmp/".$main_img;
            $T_server_img_1 ="./img/user/tmp/".$serve_img_1;
            $T_server_img_2 ="./img/user/tmp/".$serve_img_2;
            $T_server_img_3 ="./img/user/tmp/".$serve_img_3;
            $T_server_img_4 ="./img/user/tmp/".$serve_img_4;


            //모든 이미지 데이터 array 담기
            $img_array = array(
                $S_main_img,$L_main_img,$D_server_img_1,$D_server_img_2,$T_main_img,
                $D_server_img_3,$D_server_img_4,$T_server_img_1,$T_server_img_2,$T_server_img_3,$T_server_img_4
            );
            

            
            for($i=0; $i< sizeof($img_array); $i++){
                unlink($img_array[$i]);
                echo "working";
            }
            

            $D_sql = "delete from s_product where pk_id = ".$pk_id."";
            $D_sql2 = "delete from s_collect where product_id = ".$pk_id."";
            $D_sql3 = "delete from s_shopping_basket where product_id = ".$pk_id."";
            $D_sql4 = "delete from s_color_size where p_id = ".$pk_id."";
            
            $result = mysqli_query($conn,$D_sql);
            $result = mysqli_query($conn,$D_sql2);
            $result = mysqli_query($conn,$D_sql3);
            $result = mysqli_query($conn,$D_sql4);
            
            //값 있으면 결과 처리 하기 
            if($result){
                $arr = array(
                "code"=>1,
                "message"=>"success"
                );
            }else{
                $arr = array(
                "code"=>0,
                "message"=>"delete"
                );
            }

        }else{
            $arr = array(
                "code"=> 0,
                "message" => "DB_fail"
            );
        }
        $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $arr;
	}else if($result == "a_P_product"){
		//product_edit.html 
        if($conn){

            $pk_id = $_POST['pk_id'];

            $S_sql = "select * from s_product where pk_id = ".$pk_id."";
            
            $result = mysqli_query($conn,$S_sql);
            
            while($row = mysqli_fetch_array($result)){
                    $db_list[] = array(
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
				);
            }
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
                "code"=> 0,
                "message" => "DB_fail"
            );
        }
        $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $arr;
	}else if($result == "a_form_data"){
		  //현재 시간
            $time = time();
            $pk_id = $_POST['company_id'];
            $S_pk_id = $_POST['S_pk_id'];
            $product_name = $_POST['product_name'];
            $product_explanation = $_POST['product_explanation'];
            $category_name = $_POST['category_name'];
            $product_price = $_POST['product_price'];
            $sale_price = $_POST['sale_price'];
            

            //front select_box 받아온 데이터 값
            $main = $_POST['select_box'];
            
            //이미지 위치 경로 설정 
            $tmp_path = './img/user/tmp/';


            //DB 조회 

            $S_sql = "select * from s_product where pk_id = ".$S_pk_id."";
            $result = mysqli_query($conn, $S_sql);
            //DB 데이터의 값
            $row = mysqli_fetch_array($result);
            


            if($_FILES['file']['name']){
                if($main == 1){
                
                $Main_img = $row['main_img']; 
                

                //이미지 경로 설정 
                $Main_img_path ="./img/user/main/main_".$Main_img;
                $Thum_img_path ="./img/user/main/thum_".$Main_img;
                $T_img_path ="./img/user/tmp/".$Main_img;
                

                //이미지 삭제 
                unlink($Main_img_path);
                unlink($Thum_img_path);
                unlink($T_img_path);
				echo "이미지가 삭제되었습니다";

                //front에서 받은 데이터 이름 처리 및 경로 처리 
                $serve_img_1_name = $_FILES['file']['name'];
                $ext_1 = substr($serve_img_1_name, strrpos($serve_img_1_name, '.') + 1); 
                    
                //새로운 경로 설정 
                $U_main_img ="main_".$time."_00".$pk_id.".".$ext_1;  
                $U_thum_img ="thum_".$time."_00".$pk_id.".".$ext_1;
                $T_img = $time."_00".$pk_id.".".$ext_1;

                //가상의 경로 설정
                if(move_uploaded_file($_FILES['file']['tmp_name'],$tmp_path.$T_img)){
                    $info_image = getimagesize($tmp_path.$T_img);
                            switch($info_image['mime']){
                                case "image/jpg";
                                    $new_image=imagecreatefromjpeg($tmp_path.$T_img);
                                break;
                                case "image/png";
                                    $new_image=imagecreatefrompng($tmp_path.$T_img);
                                break;
                                case "image/jpeg";
                                    $new_image=imagecreatefromjpeg($tmp_path.$T_img);
                                break;
                            }
                    if($new_image){
                        $w=480;
                        $h=600;
						$img_path = "./img/user/main/".$U_main_img;
                        $canvas=imagecreatetruecolor($w,$h);
                        imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
                        $dir_n=$img_path;
                        imagegif($canvas,$dir_n);
                    }
                    //이미지 자르기 thum
                    if($new_image){
                        $w=150;
                        $h=150;
						$img_path = "./img/user/main/".$U_thum_img;
						echo $img_path;
                        $canvas=imagecreatetruecolor($w,$h);
                        imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
                        $dir_n=$img_path;
                        imagegif($canvas,$dir_n);
                    }
                }

                // upload sql 

                $main_img = "main_img = '".$T_img."',"; 


            }else{


                $serve_img_1_name = $_FILES['file']['name'];
                $ext_1 = substr($serve_img_1_name, strrpos($serve_img_1_name, '.') + 1); 

                if($main == 2){
                    $data_list = $row['serve_img_1'];
                    $serve_img1 = $time."_01".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_1 = '".$serve_img1."',"; 
                }else if($main == 3){
                    $data_list = $row['serve_img_2'];
                    $serve_img1 = $time."_02".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_2 = '".$serve_img1."',"; 
                }else if($main == 4){
                    $data_list = $row['serve_img_3']; 
                    $serve_img1 = $time."_03".$pk_id.".".$ext_1;
                    $main_img = "serve_img_3 = '".$serve_img1."',";    
                }else if($main == 5){
                    $data_list = $row['serve_img_4'];
                    $serve_img1 = $time."_04".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_4 = '".$serve_img1."',"; 
                }else if($main == 6){
                    $data_list = $row['serve_img_5'];
                    $serve_img1 = $time."_05".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_5 = '".$serve_img1."',"; 
                }else if($main == 7){
                    $data_list = $row['serve_img_6'];
                    $serve_img1 = $time."_06".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_6 = '".$serve_img1."',"; 
                }else if($main == 8){
                    $data_list = $row['serve_img_7'];
                    $serve_img1 = $time."_07".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_7 = '".$serve_img1."',"; 
                }

                //삭제 할 경로 설정
                $D_img_path ="./img/user/details/".$data_list;
                $T_img_path ="./img/user/tmp/".$data_list;

                //이미지 삭제 
                unlink($D_img_path);
                unlink($T_img_path);
    
                //sub 이미지 
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$tmp_path.$serve_img1)){
                        $info_image = getimagesize($tmp_path.$serve_img1);
                            switch($info_image['mime']){
                                case "image/jpg";
                                    $new_image=imagecreatefromjpeg($tmp_path.$serve_img1);
                                        break;
                                case "image/png";
                                    $new_image=imagecreatefrompng($tmp_path.$serve_img1);
                                        break;
                                case "image/jpeg";
                                        $new_image=imagecreatefromjpeg($tmp_path.$serve_img1);
                                        break;
                                }
                                //sub 이미지 자르기 1번 
                                if($new_image){
                                    $w=1500;
                                    $h=1500;
                                    $img_path = "./img/user/details/".$serve_img1;
                                    $canvas=imagecreatetruecolor($w,$h);
                                    imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
                                    $dir_n=$img_path;
                                    imagegif($canvas,$dir_n);
                                }
                    }

            }
            }

            
            //mysql 업데이트 문 
            $U_mysql = "update s_product set ".@$main_img." product_name = '".$product_name."', product_explanation = '".$product_explanation."' 
            ,c_pk_id = ".$category_name.",product_price = ".$product_price.",sale_price = ".$sale_price." where pk_id = ".$S_pk_id."";

            //qurey 날리기 
            $result = mysqli_query($conn,$U_mysql);

            //이미지 경로 설정 
			print "<script language=javascript> alert('수정 성공'); location.replace('./admin/product.html');</script>";

	}else if($result == "a_C_data"){
		if($conn){
            
            //front data 받아온 값

            $s_point = $_POST['s_point'];
            $list = $_POST['list'];

            //select s_question_answer data
            $select_sql = "select S.*, M.email from s_question_answer S inner join s_member as M on S.member_id = M.pk_id order by pk_id desc limit ".$s_point.", ".$list."";

            //query 문
            $result = mysqli_query($conn, $select_sql);
            while($row = mysqli_fetch_array($result)){
                    $db_list[] = array(
					"pk_id" => $row['pk_id'],
					"type" => $row['type'],
					"member_id" => $row['member_id'],
					"title" => $row['title'],
					"content" => $row['content'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
					"email" => $row['email'],
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
                "code"=> 0,
                "message" => "DB_fail"
            );
        }

        $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $arr;
	}else if($result == "a_S_collect_count"){
		if($conn){

			  //s_question_answer 데이터 count
            $S_count_sql = "select count(*) AS cnt from s_collect";

            //query 문 
            $result = mysqli_query($conn, $S_count_sql);
            
            //결과 값
            $row = mysqli_fetch_array($result);

            if($row){
                $arr = array(
                    "code" => 1,
                    "message" =>$row['cnt']
                );
            }else{
                $arr = array(
                    "code" => 0,
                    "message" => "count_fail"
                );
            }
        }else{
            $arr = array(
                "code"=>0,
                "message"=>"sql fail"
            );
        }

        $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $arr;
	}else if($result == "a_S_collect-data"){
		if($conn){

			$s_point = $_POST['s_point'];
			$list = $_POST['list'];

			//select all 데이터 

			$S_sql = 'select S.pk_id,P.product_name,P.product_explanation, P.c_pk_id,P.company_id,P.product_price,P.sale_price,P.product_quantity,P.insert_time,P.update_time,P.main_img,C.company_name,
					P.status,P.type, M.email from s_collect S INNER JOIN s_product as P on P.pk_id = S.product_id inner join s_member AS M on M.pk_id = S.member_id inner join s_company as C on C.pk_id = P.company_id
					order by S.pk_id desc limit '.$s_point.', '.$list.'';

			$result = mysqli_query($conn, $S_sql);
			while($row = mysqli_fetch_array($result)){
                    $db_list[] = array(
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
					"status" => $row['status'],
					"type" => $row['type'],
					"email" => $row['email'],
					"company_name" => $row['company_name']
				);
			}
			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);
			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
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
	}else if($result == "a_S_member"){
		if($conn){
			

			$pk_id = $_POST['pk_id'];
			$status = $_POST['status'];
			$email = $_POST['email'];
			$start_date = $_POST['start_date'];
			$stop_date = $_POST['stop_date'];


			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}

			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);
	
			//Select count member 
			$C_sql = "select count(*) AS cnt from s_member where `pk_id` != ''";

			if($pk_id != ""){ $C_sql .= " AND `pk_id` = ".$pk_id." "; }
			if($status != ""){ $C_sql .= " AND `status` = ".$status." "; }
			if($email != ""){ $C_sql .= " AND `email` = '".$email."' "; }
			if($insert_time!= ""){ $C_sql .= " AND `update_time` > '".$insert_time."' "; }
			if($update_time!= ""){ $C_sql .= " AND `update_time` < '".$update_time."' "; }


			$result = mysqli_query($conn,$C_sql);

			$row = mysqli_fetch_array($result);

			if($row){
                $arr = array(
                    "code" => 1,
                    "message" =>$row['cnt']
                );
            }else{
                $arr = array(
                    "code" => 0,
                    "message" => "count_fail"
                );
            }

		}else{
			$arr = array(
				"code" => 0,
				"message" => "fail"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == 'a_S_member_data'){
		if($conn){

			//front 받은 데이터

			$pk_id = $_POST['pk_id'];
			$status = $_POST['status'];
			$email = $_POST['email'];
			$start_date = $_POST['start_date'];
			$stop_date = $_POST['stop_date'];
			$s_point = $_POST['s_point'];
			$list = $_POST['list'];


			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}

			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);
			//select SQL 
	
			$S_sql = "select * from s_member where `pk_id` != '' ";
			if($pk_id != ""){ $S_sql .= " AND `pk_id` = ".$pk_id." "; }
			if($status != ""){ $S_sql .= " AND `status` = ".$status." "; }
			if($email != ""){ $S_sql .= " AND `email` = '".$email."' "; }
			if($insert_time!= ""){ $S_sql .= " AND `update_time` > '".$insert_time."' "; }
			if($update_time!= ""){ $S_sql .= " AND `update_time` < '".$update_time."' "; }
			$S_sql .= "order by pk_id desc limit ".$s_point.",".$list." ";

			$result = mysqli_query($conn, $S_sql);

			while($row = mysqli_fetch_array($result)){
				$res_list[] = array(
					"pk_id" => $row['pk_id'],
					"email" => $row['email'],
					"p_id" => $row['p_id'],
					"p_account" => $row['p_account'],
					"p_name" => $row['p_name'],
					"address" => $row['address'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
					"update_time" => $row['update_time']
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
				"message" => "fail"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == 'c_S_collect_count'){
		if($conn){
		

			$pk_id = $_POST['pk_id'];
			  //s_question_answer 데이터 count

			$S_count_sql = "select count(*) AS cnt from s_collect S, s_product P, s_member M, s_company C where P.pk_id = S.product_id and S.member_id = M.pk_id and P.company_id = C.pk_id and C.pk_id = ".$pk_id." ";

            //query 문 
            $result = mysqli_query($conn, $S_count_sql);
            
            //결과 값
            $row = mysqli_fetch_array($result);

            if($row['cnt'] == 0){
				
				$arr = array(
                    "code" => 0,
                    "message" => "count_fail"
                );
            }else{
					$arr = array(
						"code" => 1,
						"message" =>$row['cnt']
					);
            }
		}else{
			if($row){
                $arr = array(
                    "code" => 0,
                    "message" => "fail"
                );
            }
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "C_S_collect-data"){
		if($conn){
			
			$pk_id = $_POST['pk_id'];
			$s_point = $_POST['s_point'];
			$list = $_POST['list'];

			//select sql 
			
			//$S_sql ="select P.pk_id,P.product_name,P.product_explanation, P.c_pk_id,P.company_id,P.product_price,P.sale_price,P.product_quantity,P.insert_time,P.update_time,P.main_img,C.company_name, P.status,P.type,M.email"; 
			//$S_sql .= " from s_product P, s_collect S, s_member M, s_company C where P.pk_id = S.product_id and S.member_id = M.pk_id and C.pk_id = ".$pk_id." and C.pk_id = P.company_id  ORDER by S.pk_id desc LIMIT ".$s_point.",".$list."";

			$S_sql = "select P.main_img,P.product_name,P.product_explanation,P.c_pk_id,P.product_price,P.sale_price,P.insert_time,P.update_time,P.pk_id,C.company_name,P.status,P.type,M.email"; 
			$S_sql .= " from s_collect S, s_product P, s_member M, s_company C where P.pk_id = S.product_id and S.member_id = M.pk_id and P.company_id = C.pk_id and C.pk_id = ".$pk_id." ORDER by S.pk_id desc LIMIT ".$s_point.",".$list."";


			$result = mysqli_query($conn, $S_sql);


			
			while($row = mysqli_fetch_array($result)){
					
                    $db_list[] = array(
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
					"status" => $row['status'],
					"type" => $row['type'],
					"email" => $row['email'],
					"company_name" => $row['company_name']
				);
			}

			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);


			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}

		}else{
			$arr = array(
				"code"=> 0,
				"message" => "fail"
			);
		}

		$arr = json_encode($arr,JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_S_shopping_count"){
		if($conn){
				

			$email = $_POST['email'];
			$company_name = $_POST['company_name'];
			
			  //s_shopping_basket 데이터 count
			$S_count_sql = "select count(*) AS cnt from s_shopping_basket S INNER JOIN s_product AS P on P.pk_id = S.product_id INNER JOIN s_company AS C on C.pk_id = P.company_id 
							INNER JOIN s_member as M on M.pk_id = S.member_id where S.pk_id!= '' ";
			
			if($email != ""){ $S_count_sql .= " AND M.email = '".$email."' "; }
			if($company_name != ""){ $S_count_sql .= " AND C.company_name = '".$company_name."' "; }


            //query 문 
            $result = mysqli_query($conn, $S_count_sql);
            
            //결과 값
            $row = mysqli_fetch_array($result);
			
            if($row){
                $arr = array(
                    "code" => 1,
                    "message" =>$row['cnt']
                );
            }else{
                $arr = array(
                    "code" => 0,
                    "message" => "count_fail"
                );
            }
		}else{
			$arr = array(
				"code" => 0,
				"message" => "fail"
			); 
		}
		$arr = json_encode($arr,JSON_UNESCAPED_UNICODE);
		echo $arr;

	}else if($result == "a_S_shopping_basket"){
		if($conn){
			
			//front data

			$s_point = $_POST['s_point'];
			$list = $_POST['list'];
			$company_name = $_POST['company_name'];
			$email = $_POST['email'];
			//sql

			// $S_sql = "select DISTINCT P.pk_id,P.product_name,P.product_explanation, P.c_pk_id,P.company_id,P.product_price,P.sale_price,P.main_img,C.company_name, P.status,P.type, M.email,P.c_pk_id,CO.size, CO.color from s_shopping_basket S INNER JOIN s_product as P on P.pk_id = S.product_id inner join s_member AS M on M.pk_id = S.member_id 
				// inner join s_company as C on C.pk_id = P.company_id INNER JOIN s_color_size as CO on CO.p_id = S.product_id where S.pk_id != '' ";

			$S_sql = " SELECT A.`pk_id`,B.`main_img`,B.`product_name`,B.`product_explanation`,B.`c_pk_id`,B.`product_price`,B.`sale_price`,B.`status`,B.`type`,C.`email`,D.`color`,D.`size`,E.`company_name` FROM `s_shopping_basket` A, `s_product` B, `s_member` C, `s_color_size` D, `s_company` E ";
			$S_sql .= " WHERE A.`product_id` = B.`pk_id` AND A.`member_id` = C.`pk_id` AND A.`color_size_id` = D.`pk_id` AND B.`company_id` = E.`pk_id` ";
			

			if($email != ""){ $S_sql .= " AND C.email = '".$email."' "; }
			if($company_name != ""){ $S_sql .= " AND E.company_name = '".$company_name."' "; }
			$S_sql .= " order by A.pk_id desc limit ".$s_point.", ".$list." ";

			$result = mysqli_query($conn, $S_sql);

			while($row = mysqli_fetch_array($result)){
                $db_list[] = array(
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"product_price" => $row['product_price'],
					"sale_price" => $row['sale_price'],
					"main_img" => $row['main_img'],
					"company_name" => $row['company_name'],
					"status" => $row['status'],
					"type" => $row['type'],
					"size" => $row['size'],
					"color" => $row['color'],
					"email" => $row['email'],
					"c_pk_id" => $row['c_pk_id']
				);
			}

			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);	


			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}

		}else{
			$arr = array(
				"code"=> 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr,JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_S_shopping_count"){

		if($conn){
			
			//front data 
			$pk_id = $_POST['pk_id'];
			$email = $_POST['email'];
			$company_name = $_POST['company_name'];

			//S_sql 
			

			$S_count_sql = " SELECT count(*) AS cnt from `s_shopping_basket` A, `s_product` B, `s_member` C, `s_color_size` D, `s_company` E ";
			$S_count_sql .= " WHERE A.`product_id` = B.`pk_id` AND A.`member_id` = C.`pk_id` AND A.`color_size_id` = D.`pk_id` AND B.`company_id` = E.`pk_id` AND E.pk_id  = ".$pk_id."";
			
			if($email != ""){ $S_count_sql .= " AND  C.email = '".$email."' "; }
			if($company_name != ""){ $S_count_sql .= " AND E.company_name = '".$company_name."' "; }

            //query 문 
            $result = mysqli_query($conn, $S_count_sql);
            
            //결과 값
            $row = mysqli_fetch_array($result);
			
            if($row['cnt'] == 0){
				$arr = array(
					"code" => 0,
					"message" => "count_fail"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" =>$row['cnt']
				);
            }
			
		}else{
			$arr = array(
				"code" => 0,
				"message" => "fail"
			); 
		}
		$arr = json_encode($arr,JSON_UNESCAPED_UNICODE);
		echo $arr;
		
	}else if($result == "c_S_shopping_basket"){
		if($conn){

			$pk_id = $_POST['pk_id'];
			$s_point = $_POST['s_point'];
			$list = $_POST['list'];
			$company_name = $_POST['company_name'];
			$email = $_POST['email'];

			$S_sql = " SELECT A.`pk_id`,B.`main_img`,B.`product_name`,B.`product_explanation`,B.`c_pk_id`,B.`product_price`,B.`sale_price`,B.`status`,B.`type`,C.`email`,D.`color`,D.`size`,E.`company_name` FROM `s_shopping_basket` A, `s_product` B, `s_member` C, `s_color_size` D, `s_company` E ";
			$S_sql .= " WHERE A.`product_id` = B.`pk_id` AND A.`member_id` = C.`pk_id` AND A.`color_size_id` = D.`pk_id` AND B.`company_id` = E.`pk_id` AND E.pk_id  = ".$pk_id."";
			
			if($email != ""){ $S_sql .= " AND C.email = '".$email."' "; }
			if($company_name != ""){ $S_sql .= " AND B.company_name = '".$company_name."' "; }
			$S_sql .= " order by A.pk_id desc limit ".$s_point.", ".$list." ";

			$result = mysqli_query($conn, $S_sql);


			while($row = mysqli_fetch_array($result)){
                $db_list[] = array(
					"product_name" => $row['product_name'],
					"product_explanation" => $row['product_explanation'],
					"product_price" => $row['product_price'],
					"sale_price" => $row['sale_price'],
					"main_img" => $row['main_img'],
					"company_name" => $row['company_name'],
					"status" => $row['status'],
					"type" => $row['type'],
					"size" => $row['size'],
					"color" => $row['color'],
					"email" => $row['email'],
					"c_pk_id" => $row['c_pk_id']
				);
			}

			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);

			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}

		}else{
			$arr = array(
				"code"=> 0,
				"message" => "fail"
			);
		}
		$arr = json_encode($arr,JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_information_action"){
		if($conn){

			$pk_id = $_POST['pk_id'];
            $username = $_POST['username'];
			$mobile = $_POST['mobile'];
			$company_address = $_POST['company_address'];
			$return_address = $_POST['return_address'];
			
			$U_sql = "update s_company set company_name = '".$username."', company_contact = '".$mobile."',return_address ='".$$return_address."', company_address= '".$company_address	."' where pk_id = ".$pk_id."";
			$result = mysqli_query($conn, $U_sql);

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
	}else if($result == "c_password_action"){

		if($conn){
			$pk_id = $_POST['pk_id'];
			$OG_password = $_POST['OG_password'];
			$New_password = $_POST['New_password'];

			$OG_md5 = md5($OG_password);
			$OG_two_md5 = md5($OG_md5);


			$new_md5 = md5($New_password);
			$two_md5 = md5($new_md5);

			$S_sql = "select pk_id from s_company where pk_id = ".$pk_id." and password = '".$OG_two_md5."'";
			$result = mysqli_query($conn, $S_sql);
		
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				$U_sql = "update s_company set password = '".$two_md5."' where pk_id = ".$pk_id." ";
				$result = mysqli_query($conn, $U_sql);
				$arr = array(
					"code" => 1,
					"message" => "SUCC"
				);
			}else{
				$arr = array(
					"code" => 0,
					"message" => "update_FAIL"
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
	}else if($result == "c_insert_google"){
		if($conn){

			$pk_id = $_POST['pk_id'];
			$data = google_otp($pk_id);

			$arr = array(
				"code" => 1,
				"message" => $data
			);

		}else{
			$arr = array(
				"code" => 0,
				"message"=> "fail"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if ($result == "c_authenticate"){
		if($conn){
			require_once './class/GoogleAuthenticator.php';
			$pk_id = $_POST['pk_id'];
			$number_id = $_POST['number_id'];
			$secret = $_POST['secret'];
			$ga = new PHPGangsta_GoogleAuthenticator();
			$qrCodeUrl = $ga->getQRCodeGoogleUrl("uid_".$pk_id, $secret);
			$oneCode = $ga->getCode($secret);
			$get_oneCode = $number_id;
			if($oneCode == $get_oneCode){
				$sql_update = " UPDATE s_company SET `otp_ck` = '".$secret."' WHERE `pk_id` = ".$pk_id." ";
				mysqli_query($conn, $sql_update);
				$arr = array(
					"code" => 1,
					"message" => "SUCC"
				);
			}else{
				$arr = array(
					"code" => 0,
					"message" => "NO_OTP"
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
	}else if($result == "c_authenticate_termination"){
		if($conn){
			$m_user_id = $_POST['m_user_id'];
			$m_password = $_POST['m_password'];

			$OG_md5 = md5($m_password);
			$OG_two_md5 = md5($OG_md5);

			$m_otp_number = $_POST['m_otp_number'];

			$sql_select = " SELECT `pk_id`,`otp_ck` FROM `s_company` WHERE `company_number` = '".$m_user_id."' AND `password` = '".$OG_two_md5."' ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);

			if($row['pk_id']){
				require_once './class/GoogleAuthenticator.php';
				$ga = new PHPGangsta_GoogleAuthenticator();
				$secret = $row['otp_ck'];
				$qrCodeUrl = $ga->getQRCodeGoogleUrl("uid_".$row['pk_id'], $secret);
				$oneCode = $ga->getCode($secret);
				$get_oneCode = $m_otp_number;

				if($oneCode == $get_oneCode){
					$sql_update = " UPDATE `s_company` SET `otp_ck` = 0 WHERE `company_number` = '".$m_user_id."' AND `password` = '".$OG_two_md5."' ";
					mysqli_query($conn, $sql_update);
					$arr = array(
						"code" => 1,
						"message" => "SUCC"
					);
				}else{
					$arr = array(
						"code" => 0,
						"message" => "NO_OTP"
					);
				}
			}else{
				$arr = array(
					"code" => 0,
					"message" => "NO_PA"
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
	}else if($result == "c_queren_button"){
		if($conn){
			$p_uid = $_POST['p_uid'];
			$pk_id = $_POST['pk_id'];
			$http_url = 'http://agent.paybank.com/business/dbtest.php';

			$row_p = post($http_url, array('result'=>'u_queren_button', 'data'=>$p_uid));
			$row_p = json_decode($row_p, JSON_UNESCAPED_UNICODE);

			if($row_p["code"] == 1){
				$arr = array(
					"code" => 1,
					"p_uid" => $row_p['id'],
					"user_name" => $row_p['user_name'],
					"message" => "SUCC"
				);
			}else{
				if($row_p['message'] == "FAIL"){
					$arr = array(
						"code" => 0,
						"message" => "FAIL"
					);
				}else if($row_p['message'] == "NO"){
					$arr = array(
						"code" => 0,
						"message" => "NO"
					);
				}
			}
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_queren_uid"){
		if($conn){
			require_once './class/GoogleAuthenticator.php';
			$paybank_uid = $_POST['paybank_uid'];
			$google_otp = $_POST['google_otp'];
			$pk_id = $_POST['pk_id'];

			$sql_select = " SELECT `otp_ck` FROM `s_company` WHERE `pk_id` = ".$pk_id." ";
			$result = mysqli_query($conn, $sql_select);
			$row = mysqli_fetch_array($result);
			$ga = new PHPGangsta_GoogleAuthenticator();
			$secret = $row['otp_ck'];
			$qrCodeUrl = $ga->getQRCodeGoogleUrl("uid_".$agent_id, $secret);
			$oneCode = $ga->getCode($secret);
			$get_oneCode = $google_otp;

			if($oneCode == $get_oneCode){
				$sql_update = " UPDATE `s_company` SET `paybank_id` = ".$paybank_uid." WHERE `pk_id` = ".$pk_id." ";
				mysqli_query($conn, $sql_update);
				$arr = array(
					"code" => 1,
					"sql" => $sql_update,
					"message" => "SUCC"
				);
			}else{
				$arr = array(
					"code" => 0,
					"message" => "OTP"
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


	}else if($result == "a_reset_otp"){
		if($conn){
			
			$pk_id = $_POST['company_pk_id'];


			$U_sql = "update `s_company` SET `otp_ck` = 0 where pk_id = ".$pk_id." ";

			$result = mysqli_query($conn, $U_sql);

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
	}else if($result == "a_reset_password"){
		if($conn){
			
			//update sql

			$company_pk_id = $_POST['company_pk_id'];

			$reset_password = 1234;

			$OG_md5 = md5($reset_password);

			$OG_two_md5 = md5($OG_md5);

			$U_sql = "update s_company set password = '".$OG_two_md5."' where pk_id = ".$company_pk_id."";

			$result = mysqli_query($conn, $U_sql);

			$arr = array(
				"code" => 1,
				"sql" => $U_sql,
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
	}else if($result == "a_reset_paybank"){
		if($conn){
			
			//update sql

			$company_pk_id = $_POST['company_pk_id'];

			$U_sql = "update s_company set paybank_id = 0 where pk_id = ".$company_pk_id."";

			$result = mysqli_query($conn, $U_sql);

			$arr = array(
				"code" => 1,
				"sql" => $U_sql,
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
	}else if($result == "a_country_count"){
		if($conn){
			
			$C_sql = "select count(*) as cnt from s_country_code";

			$result = mysqli_query($conn, $C_sql);

			$row = mysqli_fetch_array($result);

			if($row){
				$arr = array(
					"code" => 1,
					"message" => $row['cnt']
				);
			}else{
				$arr = array(
					"code" => 0,
					"message" => "Nodata"
				);
			}

		}else{
			$arr = array(
				"code" =>0,
				"message" => "fail"
			);
		}

		$arr = json_encode($arr,JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_r_country_code"){
		if($conn){

			$status = $_POST['status'];
            $country_code = $_POST['country_code'];
			$order_number = $_POST['order_number'];
			
			$I_sql = "insert into s_country_code(pk_id,code,order_n,status)values(null,'".$country_code."','.$order_number.','$status')";

			$result = mysqli_query($conn, $I_sql);

			$arr = array(
				"code" => 1,
				"sql" =>$I_sql,
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
	}else if($result == "a_country_data"){
		if($conn){
			
			$s_point = $_POST['s_point'];
			$list = $_POST['list'];

			//select data 

			$S_sql = "select * from s_country_code order by order_n asc limit ".$s_point.",".$list."";

			$result = mysqli_query($conn, $S_sql);

			while($row = mysqli_fetch_array($result)){
                $db_list[] = array(
					"pk_id" => $row['pk_id'],
					"code" => $row['code'],
					"order_n" => $row['order_n'],
					"status" => $row['status'],
				);
			}
			
			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);

			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}
		
		}else{
			$arr = array(
				"code"=> 0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_E_country_edit"){
		if($conn){

			$E_country_code = $_POST['E_country_code'];
			$E_pk_id = $_POST['E_pk_id'];
            $E_status = $_POST['E_status'];
			$E_order_number = $_POST['E_order_number'];
			
			$U_sql = "update s_country_code set code = ".$E_country_code.", status = ".$E_status.", order_n = ".$E_order_number." where pk_id = ".$E_pk_id."";
			
			$result = mysqli_query($conn, $U_sql);

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


	}else if($result == "a_D_country_code"){
		if($conn){
			
			$pk_id = $_POST['pk_id'];

			$D_sql = "DELETE FROM `s_country_code` WHERE `pk_id` = ".$pk_id." ";
			mysqli_query($conn, $D_sql);

			$arr = array(
				"code" => 1,
				"sql" =>$D_sql,
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
	}else if($result == "a_review_count"){
		if($conn){

			$C_sql = "select count(*) as cnt from s_review";

			$result = mysqli_query($conn, $C_sql);
			
			$row = mysqli_fetch_array($result);

			if($row['cnt'] == 0){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $row['cnt']
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

	}else if($result == "a_review_data"){
		if($conn){
			
			$s_point = $_POST['s_point'];
			$list = $_POST['list'];
			
			$S_sql = "select R.*, C.company_name from s_review R INNER JOIN s_member as M on M.pk_id = R.member_id INNER JOIN s_product as P on P.pk_id = R.product_id INNER JOIN s_company as C on C.pk_id = P.company_id";
			$S_sql .= " order by R.pk_id desc limit ".$s_point.",".$list."";

			$result = mysqli_query($conn, $S_sql);
			
			while($row = mysqli_fetch_array($result)){
					$db_list[] = array(
					"pk_id" => $row['pk_id'],
					"member_id" => $row['member_id'],
					"title" => $row['title'],
					"score" => $row['score'],
					"content" => $row['content'],
					"insert_time" => $row['insert_time'],
					"img_path" => $row['img_path'],
					"product_id" => $row['product_id'],
					"company_name" => $row['company_name'],
				);
			};
			
			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);

			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}
		}else{
			$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_review_count"){
		if($conn){
		
			$pk_id = $_POST['pk_id'];

			$C_sql = "select count(*) as cnt from s_review R inner join s_company as C on C.pk_id=".$pk_id."";
				
			$result = mysqli_query($conn, $C_sql);
			
			$row = mysqli_fetch_array($result);

			if($row['cnt'] == 0){
				$arr = array(
					"code" => 0,
					"message" => "NoData"
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $row['cnt']
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
	}else if($result == "c_review_data"){
		if($conn){

			$pk_id = $_POST['pk_id'];
            $s_point =$_POST['s_point'];
			$list = $_POST['list'];
			
			$S_sql = "select R.*, C.company_name from s_review R INNER JOIN s_member as M on M.pk_id = R.member_id INNER JOIN s_product as P on P.pk_id = R.product_id INNER JOIN s_company as C on C.pk_id = P.company_id";
			$S_sql .= " where C.pk_id = ".$pk_id." order by R.pk_id desc limit ".$s_point.", ".$list."";

			$result = mysqli_query($conn, $S_sql);

			while($row = mysqli_fetch_array($result)){
					$db_list[] = array(
					"pk_id" => $row['pk_id'],
					"member_id" => $row['member_id'],
					"title" => $row['title'],
					"score" => $row['score'],
					"content" => $row['content'],
					"insert_time" => $row['insert_time'],
					"img_path" => $row['img_path'],
					"product_id" => $row['product_id'],
					"company_name" => $row['company_name'],
				);
			};
			
			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);

			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
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
	}else if($result == "a_c_order_history"){
		if($conn){
			
			//front data 

			$email = $_POST['email'];
			$company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $order_status = $_POST['order_status'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
            $PID_order_num = $_POST['PID_order_num'];


			// select member pk_id 
			
			$M_pk_id = 0;

				if($email != ""){
				$S_sql = "select pk_id from s_member where `email` = '".$email."' ";
				$S_result = mysqli_query($conn, $S_sql);
				$S_row = mysqli_fetch_array($S_result);
				if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}
				}


			$C_sql = "select count(*) as cnt from s_order_history H inner join s_product as P on P.pk_id = H.product_id inner join s_company as C on C.pk_id = P.company_id inner join s_member as M on M.pk_id = H.member_id where H.pk_id != '' ";
			
			if($email != ""){ $C_sql .= " AND H.member_id = ".$M_pk_id." "; }
			if($company_name != ""){ $C_sql .= " AND C.company_name = '".$company_name."' "; }
			if($status != ""){ $C_sql .= " AND H.status = '".$status."' "; }
			if($order_num != ""){ $C_sql .= " AND H.order_num = ".$order_num." "; }
			if($order_status != 0){ $C_sql .= " AND H.order_status = ".$order_status." ";}
			if($start_date != ""){ $S_sql .= " AND insert_time > '".$start_date."' "; }
			if($stop_date != ""){ $C_sql .= " AND H.insert_time < '".$stop_date."' "; }
			if($PID_order_num != ""){ $C_sql .= " AND H.PID_order_num = '".$PID_order_num."' "; }

			$C_result = mysqli_query($conn, $C_sql);

			$row = mysqli_fetch_array($C_result);

			$arr = array(
				"code" =>1,
				"message" => $row['cnt']
			);

		}else{
			$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;

	}else if($result == "a_s_order_history"){
		if($conn){


			$email = $_POST['email'];
			$company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $order_status = $_POST['order_status'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
            $PID_order_num = $_POST['PID_order_num'];
			$list = $_POST['list'];
			$s_point = $_POST['s_point'];


			//Member pk_id 가져오기 
			$M_pk_id = 0;

			if($email != "" ){
				$S_sql = "select pk_id from s_member where `email` = '".$email."' ";
				$S_result = mysqli_query($conn, $S_sql);
				$S_row = mysqli_fetch_array($S_result);
				if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}
				if($M_pk_id != 0){ $C_sql .= " AND `member_id` = ".$M_pk_id." "; }
			}

	

			//stop time change
			
			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}

			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);
			

			//2번쨰 sql 

			$S_sql2 = "select H.*, M.email,CO.company_name,C.size,C.color,P.product_explanation,P.product_name,P.c_pk_id from s_order_history H INNER JOIN s_product as P on P.pk_id = H.product_id INNER JOIN s_color_size AS C on C.pk_id = H.color_size_id"; 
			$S_sql2 .= " INNER JOIN s_company as CO on CO.pk_id = P.company_id INNER JOIN s_member as M on M.pk_id = H.member_id ";
			
			if($email != ""){ $S_sql2 .= " AND H.member_id = ".$M_pk_id." "; }
			if($company_name != ""){ $S_sql2 .= " AND CO.company_name = '".$company_name."' "; }
			if($order_num != ""){ $S_sql2 .= " AND H.order_num = ".$order_num." "; }
			if($order_status != 0){ $S_sql2 .= " AND H.order_status = ".$order_status." ";}
			if($stop_date != ""){ $S_sql2 .= " AND H.insert_time > '".$insert_time."' "; }
			if($stop_date != ""){ $S_sql2 .= " AND H.insert_time < '".$update_time."' "; }
			if($PID_order_num != ""){ $S_sql2 .= " AND H.p_order_num = ".$PID_order_num." "; }
			


			$S_sql2 .= " order by H.pk_id desc limit ".$s_point.",".$list." ";
			
			$result2 = mysqli_query($conn, $S_sql2);

			while($row = mysqli_fetch_array($result2)){
                $db_list[] = array(
					"email" => $row['email'],
					"order_num" => $row['order_num'],
					"p_order_num" => $row['p_order_num'],
					"product_price" => $row['product_price'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
					"type" => $row['type'],
					"quantity" => $row['quantity'],
					"order_status" => $row['order_status'],
					"memo_lan" => $row['memo_lan'],
					"recipient" => $row['recipient'],
					"code" => $row['code'],
					"phone_number" => $row['phone_number'],
					"address" => $row['address'],
					"detailed_address" => $row['detailed_address'],
					"contents" => $row['contents'],
					"company_name" => $row['company_name'],
					"size" => $row['size'],
					"color" => $row['color'],
					"product_explanation" => $row['product_explanation'],
					"product_name" => $row['product_name'],
					"c_pk_id" => $row['c_pk_id'],
					"pk_id"=> $row['pk_id']

				);
			}

			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);

			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}

		}else{$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_s_shipping_order_history"){
		if($conn){
			
			//front data 

			$email = $_POST['email'];
			$company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $start_date = $_POST['start_date'];
			$stop_date = $_POST['stop_date'];
			$type_status = $_POST['type_status'];			

			// select member pk_id 
			
			$M_pk_id = 0;

			$S_sql = "select pk_id from s_member where `email` = '".$email."' ";

			$S_result = mysqli_query($conn, $S_sql);
			$S_row = mysqli_fetch_array($S_result);
			if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}


			$C_sql = "select count(*) as cnt from s_order_history H inner join s_product as P on P.pk_id = H.product_id inner join s_company as C on C.pk_id = P.company_id inner join s_member as M on M.pk_id = H.member_id where H.pk_id != '' and H.type != 3 ";
			
			if($M_pk_id != 0){ $C_sql .= " AND H.member_id = ".$M_pk_id." "; }
			if($type != 0){ $C_sql .= " AND H.type = ".$type." "; }
			if($company_name != ""){ $C_sql .= " AND C.company_name = '".$company_name."' "; }
			if($order_status != ""){ $C_sql .= " AND H.order_status = ".$order_status." ";}
			if($start_date != ""){ $S_sql .= " AND insert_time > '".$start_date."' "; }
			if($stop_date != ""){ $C_sql .= " AND H.insert_time < '".$stop_date."' "; }
			if($type_status != 0){ $C_sql .= " AND H.type = '".$type_status."' "; }

			$C_result = mysqli_query($conn, $C_sql);

			$row = mysqli_fetch_array($C_result);

			$arr = array(
				"code" =>1,
				"message" => $row['cnt']
			);

		}else{
			$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_shipping_order_history"){
		if($conn){

				
			$email = $_POST['email'];
			$company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
			$type_status = $_POST['type_status'];	
			$order_status = $_POST['order_status'];	
			$list = $_POST['list'];
			$s_point = $_POST['s_point'];


			//Member pk_id 가져오기 
			$M_pk_id = 0;

			$S_sql = "select pk_id from s_member where `email` = '".$email."' ";

			$S_result = mysqli_query($conn, $S_sql);
			$S_row = mysqli_fetch_array($S_result);
			if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}

			if($M_pk_id != 0){ $C_sql .= " AND `member_id` = ".$M_pk_id." "; }
	

			//stop time change
			
			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}

			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);
			

			//2번쨰 sql 

			$S_sql2 = "select H.*, M.email,CO.company_name,C.size,C.color,P.product_explanation,P.product_name,P.c_pk_id from s_order_history H INNER JOIN s_product as P on P.pk_id = H.product_id INNER JOIN s_color_size AS C on C.pk_id = H.color_size_id"; 
			$S_sql2 .= " INNER JOIN s_company as CO on CO.pk_id = P.company_id INNER JOIN s_member as M on M.pk_id = H.member_id and H.type != 3 ";
			
			if($M_pk_id != 0){ $S_sql2 .= " AND H.member_id = ".$M_pk_id." "; }
			if($company_name != ""){ $S_sql2 .= " AND CO.company_name = '".$company_name."' "; }
			if($order_num != ""){ $S_sql2 .= " AND H.order_num = ".$order_num." "; }
			if($stop_date != ""){ $S_sql2 .= " AND H.insert_time > '".$insert_time."' "; }
			if($stop_date != ""){ $S_sql2 .= " AND H.insert_time < '".$update_time."' "; }
			if($type_status != 0){ $S_sql2 .= " AND H.type = ".$type_status." "; }
			if($order_status != ""){ $S_sql2 .= " AND H.status = ".$order_status." "; }



			$S_sql2 .= " order by H.pk_id desc limit ".$s_point.",".$list." ";
			
			$result2 = mysqli_query($conn, $S_sql2);

			while($row = mysqli_fetch_array($result2)){
                $db_list[] = array(
					"email" => $row['email'],
					"order_num" => $row['order_num'],
					"p_order_num" => $row['p_order_num'],
					"product_price" => $row['product_price'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
					"type" => $row['type'],
					"quantity" => $row['quantity'],
					"order_status" => $row['order_status'],
					"memo_lan" => $row['memo_lan'],
					"recipient" => $row['recipient'],
					"code" => $row['code'],
					"phone_number" => $row['phone_number'],
					"address" => $row['address'],
					"detailed_address" => $row['detailed_address'],
					"contents" => $row['contents'],
					"company_name" => $row['company_name'],
					"size" => $row['size'],
					"color" => $row['color'],
					"product_explanation" => $row['product_explanation'],
					"product_name" => $row['product_name'],
					"c_pk_id" => $row['c_pk_id'],
					"pk_id" => $row['pk_id']

				);
			}

			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);

			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"sql" =>$S_sql2,
					"message" => $db_list
				);
			}

		}else{$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_c_order_history"){
		
		if($conn){
			
			$pk_id = $_POST['pk_id'];
			$email = $_POST['email'];
			$product_name = $_POST['product_name'];
            $order_num = $_POST['order_num'];
            $order_status = $_POST['order_status'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
            $PID_order_num = $_POST['PID_order_num'];


			// select member pk_id 
			
			$M_pk_id = 0;

			$S_sql = "select pk_id from s_member where `email` = '".$email."' ";

			$S_result = mysqli_query($conn, $S_sql);
			$S_row = mysqli_fetch_array($S_result);
			if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}


			$C_sql = "select count(*) as cnt from s_order_history H inner join s_product as P on P.pk_id = H.product_id inner join s_company as C on C.pk_id = P.company_id inner join s_member as M on M.pk_id = H.member_id where H.pk_id != '' and C.pk_id = ".$pk_id."";
			
			if($M_pk_id != 0){ $C_sql .= " AND H.member_id = ".$M_pk_id." "; }
			if($product_name != ""){ $C_sql .= " AND P.product_name = '".$product_name."' "; }
			if($status != ""){ $C_sql .= " AND H.status = '".$status."' "; }
			if($order_num != ""){ $C_sql .= " AND H.order_num = ".$order_num." "; }
			if($order_status != 0){ $C_sql .= " AND H.order_status = ".$order_status." ";}
			if($start_date != ""){ $S_sql .= " AND H.insert_time > '".$start_date."' "; }
			if($stop_date != ""){ $C_sql .= " AND H.insert_time < '".$stop_date."' "; }
			if($PID_order_num != ""){ $C_sql .= " AND H.PID_order_num = '".$PID_order_num."' "; }

			$C_result = mysqli_query($conn, $C_sql);

			$row = mysqli_fetch_array($C_result);

			$arr = array(
				"code" =>1,
				"message" => $row['cnt']
			);


		}else{
			$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_s_order_history"){
		if($conn){


			$email = $_POST['email'];
			$product_name = $_POST['product_name'];
            $order_num = $_POST['order_num'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
			$order_status = $_POST['order_status'];	
			$PID_order_num = $_POST['PID_order_num'];	
			$list = $_POST['list'];
			$s_point = $_POST['s_point'];
			$pk_id = $_POST['pk_id'];

			//Member pk_id 가져오기 
			$M_pk_id = 0;

			$S_sql = "select pk_id from s_member where `email` = '".$email."' ";

			$S_result = mysqli_query($conn, $S_sql);
			$S_row = mysqli_fetch_array($S_result);
			if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}

			if($M_pk_id != 0){ $C_sql .= " AND `member_id` = ".$M_pk_id." "; }
	

			//stop time change
			
			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}

			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);
			

			//2번쨰 sql 

			$S_sql2 = "select H.*, M.email,CO.company_name,C.size,C.color,P.product_explanation,P.product_name,P.c_pk_id from s_order_history H INNER JOIN s_product as P on P.pk_id = H.product_id INNER JOIN s_color_size AS C on C.pk_id = H.color_size_id"; 
			$S_sql2 .= " INNER JOIN s_company as CO on CO.pk_id = P.company_id INNER JOIN s_member as M on M.pk_id = H.member_id ";
			
			if($M_pk_id != 0){ $S_sql2 .= " AND H.member_id = ".$M_pk_id." "; }
			if($product_name != ""){ $S_sql2 .= " AND P.product_name = '".$product_name."' "; }
			if($order_num != ""){ $S_sql2 .= " AND H.order_num = ".$order_num." "; }
			if($stop_date != ""){ $S_sql2 .= " AND H.insert_time > '".$insert_time."' "; }
			if($stop_date != ""){ $S_sql2 .= " AND H.insert_time < '".$update_time."' "; }
			if($order_status != 0){ $S_sql2 .= " AND H.order_status = ".$order_status." "; }
			if($PID_order_num != ""){ $S_sql2 .= " AND H.p_order_num = ".$PID_order_num." "; }
			


			$S_sql2 .= "where CO.pk_id = ".$pk_id." order by H.pk_id desc limit ".$s_point.",".$list." ";
			
			$result2 = mysqli_query($conn, $S_sql2);

			while($row = mysqli_fetch_array($result2)){
                $db_list[] = array(
					"email" => $row['email'],
					"pk_id" => $row['pk_id'],
					"update_time" => $row['update_time'],
					"order_num" => $row['order_num'],
					"p_order_num" => $row['p_order_num'],
					"product_price" => $row['product_price'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
					"type" => $row['type'],
					"quantity" => $row['quantity'],
					"order_status" => $row['order_status'],
					"memo_lan" => $row['memo_lan'],
					"recipient" => $row['recipient'],
					"code" => $row['code'],
					"phone_number" => $row['phone_number'],
					"address" => $row['address'],
					"detailed_address" => $row['detailed_address'],
					"contents" => $row['contents'],
					"company_name" => $row['company_name'],
					"size" => $row['size'],
					"color" => $row['color'],
					"product_explanation" => $row['product_explanation'],
					"product_name" => $row['product_name'],
					"c_pk_id" => $row['c_pk_id'],

				);
			}

			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);

			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}

		}else{$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_shipping_order_history"){
		if($conn){
			
			//front data 
			$pk_id = $_POST['pk_id'];
			$email = $_POST['email'];
			$company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $start_date = $_POST['start_date'];
			$stop_date = $_POST['stop_date'];
			$type_status = $_POST['type_status'];			

			// select member pk_id 
			
			$M_pk_id = 0;

			$S_sql = "select pk_id from s_member where `email` = '".$email."' ";

			$S_result = mysqli_query($conn, $S_sql);
			$S_row = mysqli_fetch_array($S_result);
			if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}


			$C_sql = "select count(*) as cnt from s_order_history H inner join s_product as P on P.pk_id = H.product_id inner join s_company as C on C.pk_id = P.company_id inner join s_member as M on M.pk_id = H.member_id where H.pk_id != '' and C.pk_id =".$pk_id."";
			
			if($M_pk_id != 0){ $C_sql .= " AND H.member_id = ".$M_pk_id." "; }
			if($type != 0){ $C_sql .= " AND H.type = ".$type." "; }
			if($company_name != ""){ $C_sql .= " AND C.company_name = '".$company_name."' "; }
			if($order_status != ""){ $C_sql .= " AND H.order_status = ".$order_status." ";}
			if($start_date != ""){ $S_sql .= " AND insert_time > '".$start_date."' "; }
			if($stop_date != ""){ $C_sql .= " AND H.insert_time < '".$stop_date."' "; }
			if($type_status != 0){ $C_sql .= " AND H.type = '".$type_status."' "; }

			$C_result = mysqli_query($conn, $C_sql);

			$row = mysqli_fetch_array($C_result);

			$arr = array(
				"code" =>1,
				"message" => $row['cnt']
			);

		}else{
			$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_shipping_order_data"){
		if($conn){

			$email = $_POST['email'];
			$company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
			$type_status = $_POST['type_status'];	
			$list = $_POST['list'];
			$s_point = $_POST['s_point'];
			$pk_id = $_POST['pk_id'];

			//Member pk_id 가져오기 
			$M_pk_id = 0;

			$S_sql = "select pk_id from s_member where `email` = '".$email."' ";

			$S_result = mysqli_query($conn, $S_sql);
			$S_row = mysqli_fetch_array($S_result);
			if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}

			if($M_pk_id != 0){ $C_sql .= " AND `member_id` = ".$M_pk_id." "; }
	

			//stop time change
			
			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}

			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);
			

			//2번쨰 sql 

			$S_sql2 = "select H.*, M.email,CO.company_name,C.size,C.color,P.product_explanation,P.product_name,P.c_pk_id from s_order_history H INNER JOIN s_product as P on P.pk_id = H.product_id INNER JOIN s_color_size AS C on C.pk_id = H.color_size_id"; 
			$S_sql2 .= " INNER JOIN s_company as CO on CO.pk_id = P.company_id INNER JOIN s_member as M on M.pk_id = H.member_id ";
			
			if($M_pk_id != 0){ $S_sql2 .= " AND H.member_id = ".$M_pk_id." "; }
			if($company_name != ""){ $S_sql2 .= " AND CO.company_name = '".$company_name."' "; }
			if($order_num != ""){ $S_sql2 .= " AND H.order_num = ".$order_num." "; }
			if($stop_date != ""){ $S_sql2 .= " AND H.insert_time > '".$insert_time."' "; }
			if($stop_date != ""){ $S_sql2 .= " AND H.insert_time < '".$update_time."' "; }
			if($type_status != 0){ $S_sql2 .= " AND H.type = ".$type_status." "; }
			

			$S_sql2 .= " where CO.pk_id = ".$pk_id." order by H.pk_id desc limit ".$s_point.",".$list." ";
			
			$result2 = mysqli_query($conn, $S_sql2);

			while($row = mysqli_fetch_array($result2)){
                $db_list[] = array(
					"email" => $row['email'],
					"pk_id" => $row['pk_id'],
					"order_num" => $row['order_num'],
					"p_order_num" => $row['p_order_num'],
					"product_price" => $row['product_price'],
					"status" => $row['status'],
					"insert_time" => $row['insert_time'],
					"type" => $row['type'],
					"quantity" => $row['quantity'],
					"order_status" => $row['order_status'],
					"memo_lan" => $row['memo_lan'],
					"recipient" => $row['recipient'],
					"code" => $row['code'],
					"phone_number" => $row['phone_number'],
					"address" => $row['address'],
					"detailed_address" => $row['detailed_address'],
					"contents" => $row['contents'],
					"company_name" => $row['company_name'],
					"size" => $row['size'],
					"color" => $row['color'],
					"product_explanation" => $row['product_explanation'],
					"product_name" => $row['product_name'],
					"c_pk_id" => $row['c_pk_id'],

				);
			}

			$db_list = json_encode($db_list, JSON_UNESCAPED_UNICODE);

			if($db_list == "null"){
				$arr = array(
					"code" => 0,
					"message" => "NoData",
				);
			}else{
				$arr = array(
					"code" => 1,
					"message" => $db_list
				);
			}

		}else{$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_update_order_history"){
		if($conn){

			$H_pk_id = $_POST['H_pk_id'];
			$type = $_POST['type'];
			$company_name = $_POST['company_name'];
			$order_number = $_POST['order_number'];
			
			//update sql

			$U_sql = "update s_order_history set type = 2, delivery_company = ".$company_name.", invoice_number = '".$order_number."' where pk_id = ".$H_pk_id."";

			$result = mysqli_query($conn, $U_sql);

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
	}else if($result == "c_update_order_history2"){
		if($conn){

			$H_pk_id = $_POST['H_pk_id'];
			$type = $_POST['type'];
			$time = time();
			//update sql

			$U_sql = "update s_order_history set type = 3, update_time = $time where pk_id = ".$H_pk_id."";

			$result = mysqli_query($conn, $U_sql);

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
	}else if($result == "c_P_product"){
		if($conn){
            $H_pk_id = $_POST['H_pk_id'];
			$company_pk_id = $_POST['company_pk_id'];
            $S_sql = "select * from s_product where company_id = ".$company_pk_id." and pk_id = ".$H_pk_id."";
            
            $result = mysqli_query($conn,$S_sql);
            
            while($row = mysqli_fetch_array($result)){
                    $db_list[] = array(
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
				);
            }
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
                "code"=> 0,
                "message" => "DB_fail"
            );
        }
        $arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $arr;
	}else if($result == "c_form_data"){
		$time = time();
            $pk_id = $_POST['company_id'];
            $S_pk_id = $_POST['S_pk_id'];
            $product_name = $_POST['product_name'];
            $product_explanation = $_POST['product_explanation'];
            $category_name = $_POST['category_name'];
            $product_price = $_POST['product_price'];
            $sale_price = $_POST['sale_price'];
            

            //front select_box 받아온 데이터 값
            $main = $_POST['select_box'];
            
            //이미지 위치 경로 설정 
            $tmp_path = './img/user/tmp/';


            //DB 조회 

            $S_sql = "select * from s_product where pk_id = ".$S_pk_id." and company_id = ".$pk_id."";
            $result = mysqli_query($conn, $S_sql);
            //DB 데이터의 값
            $row = mysqli_fetch_array($result);
            


            if($_FILES['file']['name']){
                if($main == 1){
                
                $Main_img = $row['main_img']; 
                

                //이미지 경로 설정 
                $Main_img_path ="./img/user/main/main_".$Main_img;
                $Thum_img_path ="./img/user/main/thum_".$Main_img;
                $T_img_path ="./img/user/tmp/".$Main_img;
                

                //이미지 삭제 
                unlink($Main_img_path);
                unlink($Thum_img_path);
                unlink($T_img_path);
				echo "이미지가 삭제되었습니다";

                //front에서 받은 데이터 이름 처리 및 경로 처리 
                $serve_img_1_name = $_FILES['file']['name'];
                $ext_1 = substr($serve_img_1_name, strrpos($serve_img_1_name, '.') + 1); 
                    
                //새로운 경로 설정 
                $U_main_img ="main_".$time."_00".$pk_id.".".$ext_1;  
                $U_thum_img ="thum_".$time."_00".$pk_id.".".$ext_1;
                $T_img = $time."_00".$pk_id.".".$ext_1;

                //가상의 경로 설정
                if(move_uploaded_file($_FILES['file']['tmp_name'],$tmp_path.$T_img)){
                    $info_image = getimagesize($tmp_path.$T_img);
                            switch($info_image['mime']){
                                case "image/jpg";
                                    $new_image=imagecreatefromjpeg($tmp_path.$T_img);
                                break;
                                case "image/png";
                                    $new_image=imagecreatefrompng($tmp_path.$T_img);
                                break;
                                case "image/jpeg";
                                    $new_image=imagecreatefromjpeg($tmp_path.$T_img);
                                break;
                            }
                    if($new_image){
                        $w=480;
                        $h=600;
						$img_path = "./img/user/main/".$U_main_img;
                        $canvas=imagecreatetruecolor($w,$h);
                        imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
                        $dir_n=$img_path;
                        imagegif($canvas,$dir_n);
                    }
                    //이미지 자르기 thum
                    if($new_image){
                        $w=150;
                        $h=150;
						$img_path = "./img/user/main/".$U_thum_img;
						echo $img_path;
                        $canvas=imagecreatetruecolor($w,$h);
                        imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
                        $dir_n=$img_path;
                        imagegif($canvas,$dir_n);
                    }
                }

                // upload sql 

                $main_img = "main_img = '".$T_img."',"; 


            }else{


                $serve_img_1_name = $_FILES['file']['name'];
                $ext_1 = substr($serve_img_1_name, strrpos($serve_img_1_name, '.') + 1); 

                if($main == 2){
                    $data_list = $row['serve_img_1'];
                    $serve_img1 = $time."_01".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_1 = '".$serve_img1."',"; 
                }else if($main == 3){
                    $data_list = $row['serve_img_2'];
                    $serve_img1 = $time."_02".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_2 = '".$serve_img1."',"; 
                }else if($main == 4){
                    $data_list = $row['serve_img_3']; 
                    $serve_img1 = $time."_03".$pk_id.".".$ext_1;
                    $main_img = "serve_img_3 = '".$serve_img1."',";    
                }else if($main == 5){
                    $data_list = $row['serve_img_4'];
                    $serve_img1 = $time."_04".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_4 = '".$serve_img1."',"; 
                }else if($main == 6){
                    $data_list = $row['serve_img_5'];
                    $serve_img1 = $time."_05".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_5 = '".$serve_img1."',"; 
                }else if($main == 7){
                    $data_list = $row['serve_img_6'];
                    $serve_img1 = $time."_06".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_6 = '".$serve_img1."',"; 
                }else if($main == 8){
                    $data_list = $row['serve_img_7'];
                    $serve_img1 = $time."_07".$pk_id.".".$ext_1;   
                    $main_img = "serve_img_7 = '".$serve_img1."',"; 
                }

                //삭제 할 경로 설정
                $D_img_path ="./img/user/details/".$data_list;
                $T_img_path ="./img/user/tmp/".$data_list;

                //이미지 삭제 
                unlink($D_img_path);
                unlink($T_img_path);
    
                //sub 이미지 
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$tmp_path.$serve_img1)){
                        $info_image = getimagesize($tmp_path.$serve_img1);
                            switch($info_image['mime']){
                                case "image/jpg";
                                    $new_image=imagecreatefromjpeg($tmp_path.$serve_img1);
                                        break;
                                case "image/png";
                                    $new_image=imagecreatefrompng($tmp_path.$serve_img1);
                                        break;
                                case "image/jpeg";
                                        $new_image=imagecreatefromjpeg($tmp_path.$serve_img1);
                                        break;
                                }
                                //sub 이미지 자르기 1번 
                                if($new_image){
                                    $w=1500;
                                    $h=1500;
                                    $img_path = "./img/user/details/".$serve_img1;
                                    $canvas=imagecreatetruecolor($w,$h);
                                    imagecopyresampled($canvas,$new_image,0,0,0,0,$w,$h,$info_image[0],$info_image[1]);
                                    $dir_n=$img_path;
                                    imagegif($canvas,$dir_n);
                                }
                    }

				}
            }

            
            //mysql 업데이트 문 
            $U_mysql = "update s_product set ".@$main_img." product_name = '".$product_name."', product_explanation = '".$product_explanation."' 
            ,c_pk_id = ".$category_name.",product_price = ".$product_price.",sale_price = ".$sale_price." where pk_id = ".$S_pk_id."";

            //qurey 날리기 
            $result = mysqli_query($conn,$U_mysql);
			
            //이미지 경로 설정 
			print "<script language=javascript> alert('등록 완료'); location.replace('./company/c_goods_list.html');</script>";

	}else if($result =="a_order_cofirm_count"){
		if($conn){
            $company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $order_comfirm = $_POST['order_comfirm'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
            $PID_order_num = $_POST['PID_order_num'];
			$M_pk_id = 0;
			
			if($company_name != ""){
				$S_sql = "select pk_id from s_company where `company_name` = '".$company_name."' ";
				$S_result = mysqli_query($conn, $S_sql);
				$S_row = mysqli_fetch_array($S_result);
				if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}
			}
			
			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}
			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);



				$S_sql = "select ";

				$S_sql .= "(select count(*) as cnt from s_confirmation_purchase where pk_id != '' ";
				if($company_name != ""){ $S_sql .= " AND company_id = ".$M_pk_id." "; }
				if($order_comfirm != 0){ $S_sql .= " AND `status` = ".$order_comfirm." "; }
				if($order_num != ""){ $S_sql .= " AND order_num  = '".$order_num."' "; }
				if($PID_order_num != ""){ $S_sql .= " AND p_order_num = ".$PID_order_num." ";}
				if($start_date != ""){ $S_sql .= " AND insert_time > '".$insert_time."' "; }
				if($stop_date != ""){ $S_sql .= " AND insert_time < '".$update_time."' "; }
				$S_sql .= " ) AS `total_count`, ";

				$S_sql .= "(select sum(product_price) as total from s_confirmation_purchase where pk_id != '' ";
				if($company_name != ""){ $S_sql .= " AND company_id = ".$M_pk_id." "; }
				if($order_comfirm != 0){ $S_sql .= " AND `status` = ".$order_comfirm." "; }
				if($order_num != ""){ $S_sql .= " AND order_num  = '".$order_num."' "; }
				if($PID_order_num != ""){ $S_sql .= " AND p_order_num = ".$PID_order_num." ";}
				if($start_date != ""){ $S_sql .= " AND insert_time > '".$insert_time."' "; }
				if($stop_date != ""){ $S_sql .= " AND insert_time < '".$update_time."' "; }
				$S_sql .= " ) AS `total_product_price`, ";

				$S_sql .= "(select sum(coin_amount) as total from s_confirmation_purchase where pk_id != '' ";
				if($company_name != ""){ $S_sql .= " AND company_id = ".$M_pk_id." "; }
				if($order_comfirm != 0){ $S_sql .= " AND `status` = ".$order_comfirm." "; }
				if($order_num != ""){ $S_sql .= " AND order_num  = '".$order_num."' "; }
				if($PID_order_num != ""){ $S_sql .= " AND p_order_num = ".$PID_order_num." ";}
				if($start_date != ""){ $S_sql .= " AND insert_time > '".$insert_time."' "; }
				if($stop_date != ""){ $S_sql .= " AND insert_time < '".$update_time."' "; }
				$S_sql .= " ) AS `total_coin_amount`, ";	

				$S_sql .= "(select sum(paybank_pax) as total from s_confirmation_purchase where pk_id != '' ";
				if($company_name != ""){ $S_sql .= " AND company_id = ".$M_pk_id." "; }
				if($order_comfirm != 0){ $S_sql .= " AND `status` = ".$order_comfirm." "; }
				if($order_num != ""){ $S_sql .= " AND order_num  = '".$order_num."' "; }
				if($PID_order_num != ""){ $S_sql .= " AND p_order_num = ".$PID_order_num." ";}
				if($start_date != ""){ $S_sql .= " AND insert_time > '".$insert_time."' "; }
				if($stop_date != ""){ $S_sql .= " AND insert_time < '".$update_time."' "; }
				$S_sql .= " ) AS `total_paybank_pax` ";	
				$S_sql .= " from s_confirmation_purchase limit 1";

			
				$result = mysqli_query($conn, $S_sql);
				$row = mysqli_fetch_array($result);



			
			$arr = array(
				"code" =>1,
				"total_count" => $row['total_count'],
				"total_product_price" => ($row['total_product_price'] == null ? 0 : $row['total_product_price']),
				"total_coin_amount" => ($row['total_coin_amount'] == null ? 0 : $row['total_coin_amount']),
				"total_paybank_pax" => ($row['total_paybank_pax'] == null ? 0 : $row['total_paybank_pax'])
			);


		}else{

			$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_confirm_purchase"){
		if($conn){
			
			$company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $order_comfirm = $_POST['order_comfirm'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
			$PID_order_num = $_POST['PID_order_num'];
			$list = $_POST['list'];
			$s_point = $_POST['s_point'];

			$M_pk_id = 0;
			
			if($company_name != ""){
				$S_sql = "select pk_id from s_company where `company_name` = '".$company_name."' ";
				$S_result = mysqli_query($conn, $S_sql);
				$S_row = mysqli_fetch_array($S_result);
				if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}
			}
			
			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}
			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);



			$S_sql2 = "select CP.*, C.company_name,C.percent,S.size,S.color,P.product_name, C.percent, P.c_pk_id,CP.coin_amount,CP.paybank_pax from s_confirmation_purchase CP INNER JOIN s_company AS C on C.pk_id = CP.company_id inner join s_color_size as S on S.pk_id = CP.color_size_id";
			$S_sql2 .= " inner join s_product as P on P.pk_id = CP.product_id where CP.pk_id != '' ";
			
			if($company_name != ""){ $S_sql2 .= " AND C.pk_id = ".$M_pk_id." "; }
			if($order_comfirm != 0){ $S_sql2 .= " AND CP.status = ".$order_comfirm." "; }
			if($order_num != ""){ $S_sql2 .= " AND CP.order_num  = '".$order_num."' "; }
			if($PID_order_num != ""){ $S_sql2 .= " AND CP.p_order_num = ".$PID_order_num." ";}
			if($start_date != ""){ $S_sql2 .= " AND CP.insert_time > '".$insert_time."' "; }
			if($stop_date != ""){ $S_sql2 .= " AND CP.insert_time < '".$update_time."' "; }

			$S_sql2 .= " order by CP.pk_id desc limit ".$s_point.",".$list."";
			$C_result2 = mysqli_query($conn, $S_sql2);

			while($row2 = mysqli_fetch_array($C_result2)){
                    $db_list[] = array(
					"pk_id" => $row2['pk_id'],
					"company_name" => $row2['company_name'],
					"p_order_num" => $row2['p_order_num'],
					"product_price" => $row2['product_price'],
					"status" => $row2['status'],
					"insert_time" => $row2['insert_time'],
					"update_time" => $row2['insert_time'],
					"quantity" => $row2['quantity'],
					"product_name" => $row2['product_name'],
					"c_pk_id" => $row2['c_pk_id'],
					"order_num" => $row2['order_num'],
					"color" => $row2['color'],
					"size" => $row2['size'],
					"percent" => $row2['percent'],
					"coin_amount" => $row2['coin_amount'],
					"paybank_pax" => $row2['paybank_pax']

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
				"code" =>0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_final_comfirm"){
		if($conn){

			$S_sql ="select CP.pk_id, CP.company_id, CP.product_price, S.percent from s_confirmation_purchase CP INNER JOIN s_company as S on S.pk_id = CP.company_id where CP.status = 1 order by CP.pk_id asc limit 1000";
			$S_result = mysqli_query($conn, $S_sql);
		
			mysqli_autocommit($conn,TRUE);
			while($row = mysqli_fetch_array($S_result)){
				$price = $row['product_price'];
				$percent = $row['percent'];
				$pk_id = $row['pk_id'];
				$C_pk_id = $row['company_id'];

				//계산 사업자 수익 product_price * percent = $회사 수익
				$company_income = $price * $percent / 100;

				//product_pirice - 회사 수익 ($100) = 사업자 수익 
				$client_income = $price - $company_income;


				$U_sql .= "update s_confirmation_purchase set paybank_pax = ".$company_income.", coin_amount =".$client_income.", status = 2 where pk_id = ".$pk_id."; ";
				$U_sql .= "update s_company set paybank_pax = paybank_pax + ".$company_income.", coin_amount = coin_amount + ".$client_income.", status = 2 where pk_id = ".$C_pk_id.";";
			}

			mysqli_multi_query($conn, $U_sql);
			mysqli_commit($conn);
			
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
	}else if($result == "c_order_comfirm_count"){
		if($conn){

			$pk_id = $_POST['pk_id'];
            $company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $order_comfirm = $_POST['order_comfirm'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
            $PID_order_num = $_POST['PID_order_num'];
			$M_pk_id = 0;
			
			if($company_name != ""){
				$S_sql = "select pk_id from s_company where pk_id = ".$pk_id." ";
				$S_result = mysqli_query($conn, $S_sql);
				$S_row = mysqli_fetch_array($S_result);
				if($S_row['pk_id']){$M_pk_id = $S_row['pk_id'];}
			}
			
			if($start_date){
				$start_date .= "00:00:01";
			}
			if($stop_date){
				$stop_date .="23:59:59";
			}
			$insert_time = strtotime($start_date);
			$update_time = strtotime($stop_date);



				$S_sql = "select ";

				$S_sql .= "(select count(*) as cnt from s_confirmation_purchase where pk_id != '' and  company_id = ".$pk_id." ";
				if($company_name != ""){ $S_sql .= " AND company_id = ".$M_pk_id." "; }
				if($order_comfirm != 0){ $S_sql .= " AND `status` = ".$order_comfirm." "; }
				if($order_num != ""){ $S_sql .= " AND order_num  = '".$order_num."' "; }
				if($PID_order_num != ""){ $S_sql .= " AND p_order_num = ".$PID_order_num." ";}
				if($start_date != ""){ $S_sql .= " AND insert_time > '".$insert_time."' "; }
				if($stop_date != ""){ $S_sql .= " AND insert_time < '".$update_time."' "; }
				$S_sql .= " ) AS `total_count`, ";

				$S_sql .= "(select sum(product_price) as total from s_confirmation_purchase where pk_id != '' and company_id = ".$pk_id." ";
				if($company_name != ""){ $S_sql .= " AND company_id = ".$M_pk_id." "; }
				if($order_comfirm != 0){ $S_sql .= " AND `status` = ".$order_comfirm." "; }
				if($order_num != ""){ $S_sql .= " AND order_num  = '".$order_num."' "; }
				if($PID_order_num != ""){ $S_sql .= " AND p_order_num = ".$PID_order_num." ";}
				if($start_date != ""){ $S_sql .= " AND insert_time > '".$insert_time."' "; }
				if($stop_date != ""){ $S_sql .= " AND insert_time < '".$update_time."' "; }
				$S_sql .= " ) AS `total_product_price`, ";

				$S_sql .= "(select sum(coin_amount) as total from s_confirmation_purchase where pk_id != '' and company_id = ".$pk_id." ";
				if($company_name != ""){ $S_sql .= " AND company_id = ".$M_pk_id." "; }
				if($order_comfirm != 0){ $S_sql .= " AND `status` = ".$order_comfirm." "; }
				if($order_num != ""){ $S_sql .= " AND order_num  = '".$order_num."' "; }
				if($PID_order_num != ""){ $S_sql .= " AND p_order_num = ".$PID_order_num." ";}
				if($start_date != ""){ $S_sql .= " AND insert_time > '".$insert_time."' "; }
				if($stop_date != ""){ $S_sql .= " AND insert_time < '".$update_time."' "; }
				$S_sql .= " ) AS `total_coin_amount`, ";	

				$S_sql .= "(select sum(paybank_pax) as total from s_confirmation_purchase where pk_id != '' and company_id = ".$pk_id." ";
				if($company_name != ""){ $S_sql .= " AND company_id = ".$M_pk_id." "; }
				if($order_comfirm != 0){ $S_sql .= " AND `status` = ".$order_comfirm." "; }
				if($order_num != ""){ $S_sql .= " AND order_num  = '".$order_num."' "; }
				if($PID_order_num != ""){ $S_sql .= " AND p_order_num = ".$PID_order_num." ";}
				if($start_date != ""){ $S_sql .= " AND insert_time > '".$insert_time."' "; }
				if($stop_date != ""){ $S_sql .= " AND insert_time < '".$update_time."' "; }
				$S_sql .= " ) AS `total_paybank_pax` ";	
				$S_sql .= " from s_confirmation_purchase limit 1";

			
				$result = mysqli_query($conn, $S_sql);
				$row = mysqli_fetch_array($result);


			
			$arr = array(
				"code" =>1,
				"total_count" => $row['total_count'],
				"total_product_price" => ($row['total_product_price'] == null ? 0 : $row['total_product_price']),
				"total_coin_amount" => ($row['total_coin_amount'] == null ? 0 : $row['total_coin_amount']),
				"total_paybank_pax" => ($row['total_paybank_pax'] == null ? 0 : $row['total_paybank_pax'])
			);


		}else{

			$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}
		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "c_confirm_purchase"){
		if($conn){

				
			$pk_id = $_POST['pk_id'];
            $company_name = $_POST['company_name'];
            $order_num = $_POST['order_num'];
            $order_comfirm = $_POST['order_comfirm'];
            $start_date = $_POST['start_date'];
            $stop_date = $_POST['stop_date'];
            $PID_order_num = $_POST['PID_order_num'];
            $s_point = $_POST['s_point'];
            $list = $_POST['list'];

		
			$S_sql2 = "select CP.*, C.company_name,C.percent,S.size,S.color,P.product_name, C.percent, P.c_pk_id,CP.coin_amount,CP.paybank_pax from s_confirmation_purchase CP INNER JOIN s_company AS C on C.pk_id = CP.company_id inner join s_color_size as S on S.pk_id = CP.color_size_id";
			$S_sql2 .= " inner join s_product as P on P.pk_id = CP.product_id where CP.company_id = ".$pk_id." ";
			
			if($company_name != ""){ $S_sql2 .= " AND C.pk_id = ".$pk_id." "; }
			if($order_comfirm != 0){ $S_sql2 .= " AND CP.status = ".$order_comfirm." "; }
			if($order_num != ""){ $S_sql2 .= " AND CP.order_num  = '".$order_num."' "; }
			if($PID_order_num != ""){ $S_sql2 .= " AND CP.p_order_num = ".$PID_order_num." ";}
			if($start_date != ""){ $S_sql2 .= " AND CP.insert_time > '".$insert_time."' "; }
			if($stop_date != ""){ $S_sql2 .= " AND CP.insert_time < '".$update_time."' "; }

			$S_sql2 .= " order by CP.pk_id desc limit ".$s_point.",".$list."";
			$C_result2 = mysqli_query($conn, $S_sql2);

			while($row2 = mysqli_fetch_array($C_result2)){
                    $db_list[] = array(
					"pk_id" => $row2['pk_id'],
					"company_name" => $row2['company_name'],
					"p_order_num" => $row2['p_order_num'],
					"product_price" => $row2['product_price'],
					"status" => $row2['status'],
					"insert_time" => $row2['insert_time'],
					"update_time" => $row2['insert_time'],
					"quantity" => $row2['quantity'],
					"product_name" => $row2['product_name'],
					"c_pk_id" => $row2['c_pk_id'],
					"order_num" => $row2['order_num'],
					"color" => $row2['color'],
					"size" => $row2['size'],
					"percent" => $row2['percent'],
					"coin_amount" => $row2['coin_amount'],
					"paybank_pax" => $row2['paybank_pax']

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
				"code" => 0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_delivery_count"){
		if($conn){
			
			$C_sql = "select count(*) as cnt from s_delivery_company";
			$result = mysqli_query($conn, $C_sql);

			$row = mysqli_fetch_array($result);

			$arr = array(
				"code" => 1,
				"message" => $row['cnt']
			);
		}else{
			$arr = array(
				"code" => 0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_delivery_company"){
		if($conn){
				
			//front data 

			$company_name = $_POST['company_name'];
            $URL_address = $_POST['URL_address'];
			$order_number = $_POST['order_number'];
			
			$I_sql = "INSERT INTO s_delivery_company(pk_id,name,order_n,url_value)VALUES(null,'".$company_name."','".$order_number."','".$URL_address."')";

			$result = mysqli_query($conn, $I_sql);

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
	}else if($result == "a_delivery_data"){
		
		if($conn){
			
			$s_point = $_POST['s_point'];
			$list = $_POST['list'];


			$S_sql = "select * from s_delivery_company order by order_n asc limit ".$s_point.",".$list."";

			$result = mysqli_query($conn, $S_sql);
			

			while($row = mysqli_fetch_array($result)){
				$db_list[] = array(
					"pk_id" => $row['pk_id'],
					"name" => $row['name'],
					"order_n" => $row['order_n'],
					"url_value" => $row['url_value'],
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
				"code" => 0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;

	}else if($result == "a_E_delivery_company"){
		if($conn){
				//front data
			$pk_id =  $_POST['pk_id'];
            $URL_address = $_POST['URL_address'];
            $order_number = $_POST['order_number'];
			$company_name = $_POST['company_name'];
			
			$U_sql = "UPDATE s_delivery_company set order_n = ".$order_number.", name = '".$company_name."', url_value = '".$URL_address."' where pk_id = ".$pk_id."";
			$result = mysqli_query($conn, $U_sql);

		
			$arr = array(
				"code" =>1,
				"message" => "SUCC"
			);
		}else{
			$arr = array(
				"code" =>0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}else if($result == "a_D_delivery_company"){
		if($conn){
				
			$pk_id = $_POST['pk_id'];
			$D_sql = "delete from s_delivery_company where pk_id = ".$pk_id."";
			$result = mysqli_query($conn, $D_sql);

			$arr = array(
				"code"=> 1,
				"message" => "SUCC"
			);

		}else{
			$arr = array(
				"code"=> 0,
				"message" => "FAIL"
			);
		}

		$arr = json_encode($arr, JSON_UNESCAPED_UNICODE);
		echo $arr;
	}
	

	function google_otp($pk_id){
		require_once './class/GoogleAuthenticator.php';

		$ga = new PHPGangsta_GoogleAuthenticator();
		$secret = $ga->createSecret(); // 시크릿키 생성
		$qrCodeUrl = $ga->getQRCodeGoogleUrl("UID_".$pk_id, $secret);
		$otc_code = array(
			"otc_code" => urlencode($qrCodeUrl),
			"secret" =>  $secret
		);
		$otc_code = json_encode($otc_code, JSON_UNESCAPED_UNICODE);
		return $otc_code;
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


	mysql_close($conn);
?>