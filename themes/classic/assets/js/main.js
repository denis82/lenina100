$(function(){
	
	$('.slider').mobilyslider({
		content: '.sliderContent',
		children: 'a',
		transition: 'fade',
		animationSpeed: 500,
		autoplay: true,
		autoplaySpeed: 10000,
		pauseOnHover: false,
		bullets: false,
		arrows: true,
		arrowsHide: false,
		prev: 'prev',
		next: 'next'
	});

	$(".sub").click(function(){
		if($(this).hasClass("sub_active")){
			$(".sub_active").removeClass("sub_active");
			$(".submenu").fadeOut();
			return false;
			}else{
			$(".sub_active").removeClass("sub_active");
			$(".submenu").fadeOut();
			$(this).addClass("sub_active");
			$(this).siblings(".submenu").fadeIn();
		};

		$('html').click(function() { $(".submenu").fadeOut(); $(".sub_active").removeClass("sub_active"); });
		$('.submenu').click(function(e){e.stopPropagation();});
		return false;
	});

	$(".price a").click(function(){
		$(".price table").fadeToggle();
		return false;
	});

	$(".popup .icon-close, .popup-bg").click(function(){
		$(".popup, .popup-bg").fadeOut();
		return false;
	});

	$(".header button.red").click(function(){
		$(".popup, .popup-bg").fadeIn();
		return false;
	});

	$(".questions-menu a").click(function(){
		$(".questions-menu a.active").removeClass("active");
		$(this).addClass("active");
	});
	
	$(".quest a").click(function(){
		$(".questions-menu a.active").removeClass("active");
		$(this).addClass("active");
	});

	$(".specialists-list a").click(function(){
		id = $(this).attr("name-id");
		$(".specialists.active").slideToggle().removeClass("active");
		$(".specialists-"+id).slideToggle().addClass("active");
		
	});

	$(window).resize(function(){
		$('.slider .item img').map(function(indx, element){
			w = parseInt($(element).css("width"));
			all = parseInt($('.slider').width());
			$(element).css("left",all-w);
		});
	});
	$(window).resize();
	$(".scrollable").scrollable();

	//Cufon.replace(".heliocti",{fontFamily: "heliocti"});
	//Cufon.replace(".HLS37",{fontFamily: "HLS37"});
	//Cufon.replace(".HLS38",{fontFamily: "HLS38"});
//	Cufon.replace(".heliosct",{fontFamily: "heliosct"});
//	if(!$('html').hasClass("ie7")){Cufon.replace(".pfdintextcondpro, h1",{fontFamily: "pfdintextcondpro"});}
	
	$(".shadow").prepend("<div class='shadow-before'></div><div class='shadow-after'></div>");
	$(".main-menu li a").prepend("<div class='menu-before'></div><div class='menu-after'></div>");

});