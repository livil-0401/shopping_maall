document.writeln('	<nav class="navbar navbar-vertical fixed-left navbar-expand-md " id="sidebar">');
document.writeln('		<div class="container-fluid">');
document.writeln('			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">');
document.writeln('				<span class="navbar-toggler-icon"></span>');
document.writeln('			</button>');
document.writeln('		<a class="navbar-brand" href=javascript:left_menu("a_member_list");><img src="../../assets/img/logo.png" class="navbar-brand-img mx-auto" alt=""></a>');
document.writeln('		<div class="navbar-user d-md-none">');
document.writeln('		              <div class="dropdown">');
// document.writeln('		                <a href="javascript:logout();" class="dropdown-toggle">');
// document.writeln('		                 로그아웃');
// document.writeln('		                </a>');
document.writeln('		              </div>');
document.writeln('		           </div>');
document.writeln('		<div class="collapse navbar-collapse" id="sidebarCollapse">');
document.writeln('			<ul class="navbar-nav">');
document.writeln('				<li class="nav-item">');
document.writeln('					<a class="nav-link active"><i class="fe fe-users"></i>회원관리</a>');
document.writeln('					<div class="collapse show">');
document.writeln('						<ul class="nav nav-sm flex-column">');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_member_list");>회원 관리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_company_list");>업체 관리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_company_type");>업체 유형</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_company_assets");>업체 자산</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_order_user");>주문 내역</a></li>');
document.writeln('							<li class="nav-item" id="a_withdraw"><a class="nav-link" href=javascript:left_menu("a_withdraw");>출금 관리</a></li>');
document.writeln('						</ul>');
document.writeln('					</div>');
document.writeln('				</li>');
document.writeln('				<li class="nav-item">');
document.writeln('					<a class="nav-link active"><i class="fe fe-credit-card"></i>상품관리</a>');
document.writeln('					<div class="collapse show">');
document.writeln('						<ul class="nav nav-sm flex-column">');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_goods_list");>상품 관리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_category_list");>카테 고리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_shipping_list");>배송중 상품</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_shoping_bak");>장바 구니</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_awesome_list");>찜한 상품</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_review");>후기 관리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_payment");>구매 확정</a></li>');
document.writeln('							<li class="nav-item" id="return_product"><a class="nav-link" href=javascript:left_menu("return_product");>환불 처리</a></li>');
document.writeln('						</ul>');
document.writeln('					</div>');
document.writeln('				</li>');
document.writeln('				<li class="nav-item">');
document.writeln('					<a class="nav-link active"><i class="fe fe-users"></i>기타</a>');
document.writeln('					<div class="collapse show">');
document.writeln('						<ul class="nav nav-sm flex-column">');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_notice");>공지&자주하는질문</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("country_code");>국가번호</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("Q/A");>Q/A</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("delivery_company");>택배 회사</a></li>');
document.writeln('						</ul>');
document.writeln('					</div>');
document.writeln('				</li>');
document.writeln('					</ul>');
document.writeln('					<hr class="navbar-divider my-3">');
document.writeln('				</div>');
document.writeln('			</div>');
document.writeln('		</nav>');
document.writeln('		<nav id="sidebarSmall"></nav>');
document.writeln('		<div class="main-content" id="topnav">');
document.writeln('		</div>');

function left_menu(result){
    if(result == "a_member_list"){
        // 회원관리
        location.href="./a_member_list.html";
    }else if(result == "a_company_list"){
		// 업체관리
		location.href="./a_company_list.html";
	}else if(result == "a_company_type"){
		// 업체유형
		location.href="./a_company_type.html";
	}else if(result == "a_company_assets"){
		location.hre = "./a_company_assets.html"
		// 업체자산
		location.href="./a_company_assets.html";
	}else if(result == "a_order_company"){
		// 주문내역(업체)
		location.href="./a_order_company.html";
	}else if(result == "a_order_user"){
		// 주문내역(회원)
		location.href="./a_order_user.html";
	}else if(result == "a_goods_list"){
		// 상품관리
		location.href="./product.html";
	}else if(result == "a_category_list"){
		// 카테고리
		location.href="./a_category_list.html";
	}else if(result == "a_shipping_list"){
		// 배송중 상품
		location.href="./a_shipping_list.html";
	}else if(result == "a_shoping_bak"){
		// 장바구니
		location.href="./a_shoping_bak.html";
	}else if(result == "a_awesome_list"){
		// 찜한상품
		location.href="./a_awesome_list.html";
	}else if(result == "a_notice"){
		// 공지&자주하는질문
		location.href="./a_notice.html";
	}else if(result == "Q/A"){
		// 공지&자주하는질문
		location.href="QA.html";
	}else if(result == "country_code"){
		location.href="a_country_code.html"
	}else if(result == "a_review"){
		location.href = "a_review.html"
	}else if(result == "a_payment"){
		location.href = "a_payment.html"
	}else if(result == "delivery_company"){
		location.href = "a_delivery_company.html"
	}else if(result == "a_withdraw"){
		location.href = "a_withdraw.html"
	}else if(result == "return_product"){
		location.href = "a_return_product"
	}
}




setInterval(function(){
	check();
	check2();
}, 1000*60);


function check(){

	var data = {
		result :"a_check_withdraw"
	}
		
	$.ajax({
		url:"../company_db.php",
		dataType:"text",
		type:"post",
		data: data,

		success:function(data){

			var json_data = JSON.parse(data)
			if(json_data.code == 1){
				if(json_data.message > 0){

					$('#a_withdraw').html('<a class="nav-link"href=javascript:left_menu("a_withdraw");>출금 관리&nbsp;&nbsp;&nbsp;<span class="badge badge-pill badge-danger">new</span></a>')
				}else{
					$('#a_withdraw').html('<a class="nav-link" href=javascript:left_menu("a_withdraw");>출금 관리</a>')
				}
			}else{

			}
		}
	})
}
function check2(){

	var data = {
		result :"a_check_refund"
	}
		
	$.ajax({
		url:"../company_db.php",
		dataType:"text",
		type:"post",
		data: data,

		success:function(data){

			var json_data = JSON.parse(data)
			if(json_data.code == 1){
				if(json_data.message > 0){

					$('#return_product').html('<a class="nav-link"href=javascript:left_menu("return_product");>환불 관리&nbsp;&nbsp;&nbsp;<span class="badge badge-pill badge-danger">new</span></a>')
				}else{
					$('#return_product').html('<a class="nav-link" href=javascript:left_menu("return_product");>환불 관리</a>')
				}
			}else{

			}
		}
	})
}