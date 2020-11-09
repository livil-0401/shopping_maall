$(function(){

	/*------------- home 提示窗 ---------------------------------------------------------------------------------------------*/
	// $('#prompt').fadeIn(200).delay(1500).fadeOut(200);


	/*------------- home 首页 滑动导航 ---------------------------------------------------------------------------------------------*/
	$('#nav').navbarscroll();

	/*------------- home 首页 购物车 关掉 -----------*/
	$('#basket_header .close_btn').click(function(){
		$('#basket').stop(true).animate({top:'100%'},200);
		$('#basket_footer').stop(true).animate({bottom:'-100px'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});

	/*------------- home 首页 详情页 打开 -----------------------------------------------------------------------------------------------*/
	$('#main #main_contents ul li .product').click(function(){
		$('#detail').stop(true).animate({top:'0'},200);
		$('#detail_footer').stop(true).animate({bottom:'20px'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	/*------------- home 首页 详情页 关掉 -----------*/
	$('#detail_header .close_btn').click(function(){
		$('#detail').stop(true).animate({top:'100%'},200);
		$('#detail_footer').stop(true).animate({bottom:'-100px'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});



	/*------------- home 상세페이지에 구매페이지 열기 详情页购买页面 打开 ---------------------------------------------------------------------------------------------*/
	$('#detail_footer .inner .price .btn').click(function(){
		$('#purchase').stop(true).animate({top:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	/*------------- home 상세페이지에 구매페이지 닫기 详情页购买页面 关掉 -----------*/
	$('#purchase .bg').click(function(){
		$('#purchase').stop(true).animate({top:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});





	/*------------- home 상세 구매페이지에 옵션 열기&닫기 详情页购买页面 按钮伸缩 ---------------------------------------------------------------------------------------------*/
	var $opbtn = $('#purchase .purchase_contents #menu .m1 .text'),
		$optext = $('#purchase .purchase_contents #menu .m1 .m2');

	$optext.hide();

	$opbtn.click(function(){
		$optext.slideUp();//收起所有text
  		if($(this).next().is(':visible')) {//如果当前点击的text是打开的
         	$(this).next().slideUp();//收起
  		}else{//否则
  			 $(this).next().slideDown();//展开
 		 }
	});

	/*------------- home 상세페이지에 옵션 버튼 색상 详情页购买页面 选项按钮颜色 -----------*/
	$('.purchase_contents .m1 .text').click(function(){
		$('.purchase_contents .m1 .text').removeClass('on');
		$(this).addClass('on');
	});

	/*------------- home 상세페이지에 옵션 버튼 색상 详情页购买页面 选项按钮颜色 -----------*/
	var btn1 = $('#purchase .purchase_contents .price .btn .btn1'),
		btn2 = $('#purchase .purchase_contents .price .btn .btn2');

	btn1.click(function(){
		$(this).css({backgroundColor: '#403F40', color: '#fff'});
		btn2.css({backgroundColor: '#fff', color: '#403F40'});
	});

	btn2.click(function(){
		$(this).css({backgroundColor: '#403F40', color: '#fff'});
		btn1.css({backgroundColor: '#fff', color: '#403F40'});
	});


	$('#payment_header .inner .close_btn').click(function(){
		$('#payment').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});
	





	/*------------- home 주소변경 ---------------------------------------------------------------------------------------------*/
	$('#payment_contents .address .info .inner .zipCode').click(function(){
		$('#address').stop().animate({left:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	$('#address #address_header .inner p').click(function(){
		$('#address').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});

	/*------------- home 주소변경 검색바 안에 x표 누를때 -----------*/
	$('#address_contents .search .searchBar p').click(function(){
		$('#address_contents .ctn2').css('display','none');
		$('#address_contents .ctn1').css('display','block');
	});

	/*------------- home 주소변경 검색버튼 누를때 -----------*/
	$('#address_contents .search .searchBtn').click(function(){
		$('#address_contents .ctn2').css('display','block');
		$('#address_contents .ctn1').css('display','none');
	});

	/*------------- home 주소변경 주소선택 후 -----------*/
	$('#address_contents .ctn2 .text').click(function(){
		$('#address').stop().animate({left:'100%'},200);
	});





	/*------------- home 상품후기 열기&닫기 -----------------------------------------------------------------------------------------------*/
	$('#detail_contents .comment #review').click(function(){
		alert("Aaaa");
		$('#photoReview').stop().animate({left:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	$('#photoReview_header .inner .close_btn').click(function(){
		$('#photoReview').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});





	/*------------- home 상품후기 글짜수 제한 -----------*/
	$('#textReview .userReview .text p').each(function(){
		var maxwidth=100;

		if($(this).text().length>maxwidth){ 
			$(this).text($(this).text().substring(0,maxwidth)); 
			$(this).html($(this).html() + '...');
		}
	});

	/*------------- home 후기페이지에 이미지페이지 -----------*/
	$('#photoImg #photoImg_header .inner .close_btn').click(function(){
		$('#photoImg').stop(true).animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});





	/*------------- home 후기페이지에 이미지리뷰 열기&닫기 -----------------------------------------------------------------------------------------------*/
	$('#detail_contents .photoReview .photo ul li, #photoReview_contents .photoReview .photo ul li, #photoImg_contents ul li').click(function(){
		$('#imgReview').stop(true).animate({top:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	/*------------- home Q&A 질문하는 부분 下拉框 -----------------------------------------------------------------------------------------------*/
	var $qbtn = $('#QA_contents .questions .title .q_btn'),
		$qtext = $('#QA_contents .questions .ctn'),
		$abtn = $('#QA_contents #answer .ctn .title'),
		$atext = $('#QA_contents #answer .ctn .text');

	$qtext.hide();
	$atext.hide();

	$qbtn.click(function(){
		$qtext.slideToggle();
	});

	$abtn.click(function(){
		$atext.slideUp();//收起所有text
  		if($(this).next().is(':visible')) {//如果当前点击的text是打开的
         	$(this).next().slideUp();//收起
  		}else{//否则
  			 $(this).next().slideDown();//展开
 		 }
	});

	/*------------- home Q&A 열기&닫기 -----------*/
	$('#detail_contents .comment #QandA').click(function(){
		alert("bbbb");
		$('#QA').stop().animate({left:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});
	
	$('#QA_header .inner .close_btn').click(function(){
		$('#QA').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});	

	/*------------- mall 首页 导航颜色 -----------------------------------------------------------------------------------------------*/
	$('#main_contents .btn1 a').click(function(){
		$('#main_contents .btn1').css('background-color', '#403F40');
		$(this).css('color', '#fff');
		$('#main_contents .btn2').css('background-color', '#fff');
		$('#main_contents .btn2 a').css('color', '#403F40');
	});

	$('#main_contents .btn2 a').click(function(){
		$('#main_contents .btn2').css('background-color', '#403F40');
		$(this).css('color', '#fff');
		$('#main_contents .btn1').css('background-color', '#fff');
		$('#main_contents .btn1 a').css('color', '#403F40');
	});




	
	/*------------- mall 店铺界面 打开&关掉 ---------------------------------------------------------------------------------------------*/
	$('#main_contents .shopInner .shop').click(function(){
		$('#store').stop(true).animate({top:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});






	/*------------- myPage 리뷰쓰기에 상품이름 글짜수 ---------------------------------------------------------------------------------------------*/
	var $Ptit = $('#WReview_contents .product .product_list .details .product_text p:nth-child(2)')
	$Ptit.each(function(){
		var maxwidth=10;
 
		if($(this).text().length>maxwidth){ 
			$(this).text($(this).text().substring(0,maxwidth)); 
			$(this).html($(this).html() + '...');
		}
	});

	/*------------- myPage 리뷰쓰기에 등록버튼 색상변경 -----------*/
	var cBtn = $('#WReview_contents .footer_btn .cancel'),
		record = $('#main_contents #container ul .record');

	
	cBtn.click(function(){
		$('#WReview').stop().animate({left:'100%'},200);
	});

	record.click(function(){ 
		$('#WReview').stop().animate({left:'0'},200);
	});






	/*------------- my page 주문 · 배송 글짜수 ---------------------------------------------------------------------------------------------*/
	var $deliveryTit = $('#delivery_contents .product_list .details .product_text div p:nth-child(2)');
	$deliveryTit.each(function(){
		var maxwidth=10;
 
		if($(this).text().length>maxwidth){ 
			$(this).text($(this).text().substring(0,maxwidth)); 
			$(this).html($(this).html() + '...');
		}
	});

	/*------------- my page 주문 · 배송 열기&닫기 -----------*/
	var	$delclose = $('#delivery #delivery_header .inner>p');

	$delclose.click(function(){ 
		$('#delivery').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});

	/*------------- my page 주문 · 배송 버튼 색상변경 -----------*/
	$('#purchaseHistory_contents .product_list .btn p, #delivery_contents .product_list .btn p').click(function(){
		$('#purchaseHistory_contents .product_list .btn p, #delivery_contents .product_list .btn p').removeClass('on');
		$(this).addClass('on');
	});

	/*------------- my page 상세 내역 글짜수 ---------------------------------------------------------------------------------------------*/
	var $deliveryTit = $('#purchaseDetails_contents .product_list .details .product_text div p:nth-child(2)');
	$deliveryTit.each(function(){
		var maxwidth=10;
 
		if($(this).text().length>maxwidth){ 
			$(this).text($(this).text().substring(0,maxwidth)); 
			$(this).html($(this).html() + '...');
		}
	});

	/*------------- my page 상세 내역 열기&닫기 -----------*/
	// $PDopen = $('#delivery_contents .product .shop .call'),
	var	$PDclose = $('#purchaseDetails_header .inner>p');

	$PDclose.click(function(){ 
		$('#purchaseDetails').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});




	/*------------- myPage 구매내역에 상품명 글짜수 ---------------------------------------------------------------------------------------------*/
	var $Htit = $('#purchaseHistory_contents .product_list .details .product_text p:nth-child(2)');
	$Htit.each(function(){
		var maxwidth=10;
 
		if($(this).text().length>maxwidth){ 
			$(this).text($(this).text().substring(0,maxwidth)); 
			$(this).html($(this).html() + '...');
		}
	});

	/*------------- myPage 구매내역 열기&닫기 -----------*/
	var $record = $('#main_contents #container ul .record'),
		$recordpg = $('#purchaseHistory #purchaseHistory_header p');

	
	$record.click(function(){
		$('#purchaseHistory').stop().animate({left:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	$recordpg.click(function(){ 
		$('#purchaseHistory').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});



	/*------------- myPage 구매내역에 반품요청 열기&닫기 ---------------------------------------------------------------------------------------------*/
	$('#purchaseHistory_contents .product_list .btn .buyback').click(function(){
		$('#return').stop().animate({left:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	$('#return_header .inner p').click(function(){ 
		$('#return').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});

	/*------------- myPage 구매내역에 반품요청 버튼 색상변경 -----------*/
	$('#return_contents .reason .text .btn .seller p').click(function(){
		$('#return_contents .reason .text .btn .seller p').removeClass('on');
		$(this).addClass('on');
	});




	/*------------- my page 구매내역에 반품정보 ---------------------------------------------------------------------------------------------*/
	$('#purchaseHistory_contents .product_list .details .product_text .text_1 .confirmation').click(function(){
		$('#returnInfo').stop().animate({left:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	$('#returnInfo_header .inner>p').click(function(){
		$('#returnInfo').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});

	/*------------- myPage 리뷰쓰기에 상품명 글짜수 ---------------------------------------------------------------------------------------------*/
	var $Rtit = $('#WReview_contents .product .product_list .details .product_text p:nth-child(2)');
	$Rtit.each(function(){
		var maxwidth=10;
 
		if($(this).text().length>maxwidth){ 
			$(this).text($(this).text().substring(0,maxwidth)); 
			$(this).html($(this).html() + '...');
		}
	});

	/*------------- myPage 리뷰쓰기에 버튼 색상변경 -----------*/
	$('#purchaseHistory_contents .product_list .btn p').click(function(){
		$('#purchaseHistory_contents .product_list .btn p').removeClass('on');
		$(this).addClass('on');
	});

	/*------------- myPage 구매내역에 상품명 글짜수 ---------------------------------------------------------------------------------------------*/
	var $Htit = $('#purchaseHistory_contents .product_list .details .product_text p:nth-child(2)');
	$Htit.each(function(){
		var maxwidth=10;
 
		if($(this).text().length>maxwidth){ 
			$(this).text($(this).text().substring(0,maxwidth)); 
			$(this).html($(this).html() + '...');
		}
	});

	/*------------- my page 자주 묻는 질문 ---------------------------------------------------------------------------------------------*/

	$('#FAQ_header .inner>p ').click(function(){
		$('#FAQ').stop(true).animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});

	/*------------- my page 공지사항 ---------------------------------------------------------------------------------------------*/
	$('#main_contents #container ul .notice').click(function(){
		$('#notice').stop(true).animate({left:'0'},200);
		$('html, body').css({'overflow': 'hidden', 'height': '100%'});
	});

	$('#notice_header .inner>p').click(function(){
		$('#notice').stop(true).animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});






	/*------------- myPage 나의정보 ---------------------------------------------------------------------------------------------*/
	$('#myInfo_header .inner p').click(function(){
		$('#myInfo').stop(true).animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});





	/*------------- home 주소변경 ---------------------------------------------------------------------------------------------*/
	$('#address #address_header .inner p').click(function(){
		$('#address').stop().animate({left:'100%'},200);
		$('html, body').css({'overflow': 'auto', 'height': '100%'});
	});

	/*------------- home 주소변경 검색바 안에 x표 누를때 -----------*/
	$('#address_contents .search .searchBar p').click(function(){
		$('#address_contents .ctn2').css('display','none');
		$('#address_contents .ctn1').css('display','block');
	});

	/*------------- home 주소변경 검색버튼 누를때 -----------*/
	$('#address_contents .search .searchBtn').click(function(){
		$('#address_contents .ctn2').css('display','block');
		$('#address_contents .ctn1').css('display','none');
	});

	/*------------- home 주소변경 주소선택 후 -----------*/
	$('#address_contents .ctn2 .text').click(function(){
		$('#address').stop().animate({left:'100%'},200);
	});


	

});
