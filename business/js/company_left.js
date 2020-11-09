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
document.writeln('					<a class="nav-link active"><i class="fe fe-users"></i>나의정보</a>');
document.writeln('					<div class="collapse show">');
document.writeln('						<ul class="nav nav-sm flex-column">');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_member_list");>나의 정보</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("OPT");>OTP 인증</a></li>');
// document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_assets_list");>자산 관리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_calculate_list");>자산 관리</a></li>');
document.writeln('							<li class="nav-item" id="a_history"><a class="nav-link" href=javascript:left_menu("c_order_user");>주문 내역</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_withdraw");>출금 관리</a></li>');
// document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_company_type");>업체 유형</a></li>');
// document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_company_assets");>업체 자산</a></li>');
// document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_order_company");>주문 내역(업체)</a></li>');

document.writeln('						</ul>');
document.writeln('					</div>');
document.writeln('				</li>');
document.writeln('				<li class="nav-item">');
document.writeln('					<a class="nav-link active"><i class="fe fe-credit-card"></i>상품관리</a>');
document.writeln('					<div class="collapse show">');
document.writeln('						<ul class="nav nav-sm flex-column">');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_goods_list");>상품 관리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_shoping_bak");>장바 구니</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_s_collect");>찜한 상품</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_s_review");>후기 관리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_shipping_list");>배송중 상품</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_product_return");>환불 관리</a></li>');
document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("c_payment");>구매 확정</a></li>');
document.writeln('						</ul>');
document.writeln('					</div>');
document.writeln('				</li>');
// document.writeln('				<li class="nav-item">');
// document.writeln('					<a class="nav-link active"><i class="fe fe-users"></i>기타</a>');
// document.writeln('					<div class="collapse show">');
// document.writeln('						<ul class="nav nav-sm flex-column">');
// document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_qa_content");>공지사항 & Q/A</a></li>');
// document.writeln('							<li class="nav-item"><a class="nav-link" href=javascript:left_menu("a_marketing");>마케팅 지원</a></li>');
// document.writeln('						</ul>');
// document.writeln('					</div>');
// document.writeln('				</li>');
document.writeln('					</ul>');
document.writeln('					<hr class="navbar-divider my-3">');
document.writeln('				</div>');
document.writeln('			</div>');
document.writeln('		</nav>');
document.writeln('		<nav id="sidebarSmall"></nav>');
document.writeln('		<div class="main-content" id="topnav">');
document.writeln('		</div>');

function left_menu(result) {
    if (result == "c_member_list") {
        // 회원관리
        location.href = "./c_member_list.html";
    } else if (result == "c_goods_list") {
        // 상품관리
        location.href = "./c_goods_list.html";
    } else if (result == "c_s_collect") {
        //찜 상품
        location.href = "./c_s_collect.html"
    }else if ( result == "c_shoping_bak"){
        location.href = "./c_shoping_bak";
    }else if (result == "OPT"){
        location.href = "./OPT.html";
    }else if (result == "c_s_review"){
        location.href = "./c_s_review.html"
    }else if (result == "c_order_user" ){
        location.href = "./c_order_user.html"
    }else if (result == "c_shipping_list"){
        location.href = "./c_shipping_list.html"
    }else if( result == "c_payment"){
        location.href ="./c_payment.html"
    }else if(result == "c_calculate_list"){
        location.href = "./c_calculate_list.html"
    }else if(result == "c_withdraw"){
        location.href = "./c_withdraw.html"
    }else if(result == "c_product_return"){
        location.href = "./c_product_return"
    }

}


var pk_id = 0;

setInterval(function () {
    
    
    ck_cookie();

    function ck_cookie() {
        var data = {
            result: 'c_ck_cookie'
        }

        $.ajax({
            type: 'POST',
            url: '../company_db.php',
            dataType: 'text',
            data: data,
            success: function(data) {
                var json_data = JSON.parse(data);

                if (json_data.code == 1) {
                    pk_id = json_data.pk_id;

                    check(pk_id)


                } else {
                    alert("잘못된 접근이거나. 아이디 혹은 비밀번호가 틀렸습니다.");
                    location.href = "../../login.html";
                }
            },
            error: function(err) {
                alert('error: ' + JSON.stringify(err));
            }
        });
    }

    }, 1000 * 60)

function check (pk_id) {
    var data = {
        pk_id:pk_id,
        result: 'a_check_history'
    }
    console.log("check -> data", data)

    $.ajax({
        url: '../company_db.php',
        dataType: 'text',
        type: 'post',
        data: data,

        success: function (data) {
        console.log("check -> data", data)
        var json_data = JSON.parse(data)
        if (json_data.code == 1) {
            if (json_data.message > 0) {
            $('#a_history').html(
                '<a class="nav-link"href=javascript:left_menu("c_order_user");>주문 내역&nbsp;&nbsp;&nbsp;<span class="badge badge-pill badge-danger">new</span></a>'
            )
            } else {
            $('#a_history').html(
                '<a class="nav-link" href=javascript:left_menu("c_order_user");>주문 내역</a>'
            )
            }
        } else {
        }
        }
    })
}
