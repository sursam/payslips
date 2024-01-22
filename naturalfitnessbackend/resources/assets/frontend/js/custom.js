

//stellarnav
jQuery(document).ready(function ($) {
	jQuery('.stellarnav').stellarNav({
		theme: 'light',
		breakpoint: 3000,
		position: 'right',
	});
});



// aos init
AOS.init({
    offset: 300,
    	once: true
	
})


//    scroll top
var btn = $('#topbtn');

$(window).scroll(function () {
	if ($(window).scrollTop() > 300) {
		btn.addClass('show');
	} else {
		btn.removeClass('show');
	}
});

btn.on('click', function (e) {
	e.preventDefault();
	$('html, body').animate({ scrollTop: 0 }, '300');
});

// scroll color change
$(window).scroll(function () {
	if ($(this).scrollTop() > 50)  /*height in pixels when the navbar becomes non scroll*/ {
		$('.scroll-navbar').addClass('scroll');
	} else {
		$('.scroll-navbar').removeClass('scroll');
	}
}); 

// actively supports
$('.actively-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:2
        }
    }
})