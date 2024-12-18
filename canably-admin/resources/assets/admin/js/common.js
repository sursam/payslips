// JavaScript Document
'use strict';
var baseUrl = APP_URL + '/';
var flashstatus = $('span.flashstatus').text();
var flashmessage = $('span.flashmessage').text();
var pagetype = jQuery('input[name="pagetype"]').val();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function (e) {
    console.log(getCookie('twentyOneCheck'));
    if (!getCookie('twentyOneCheck')) {
		$('#disclaimerModal').modal('show');
	}
    setTimeout(() => {
        showCartTotal();
    }, 600);

    $('.passwordHideShow').on('click', function () {
        $(this).find('.passwordHidden,.passwordShowed').toggleClass('d-none');
        var input = $(this).closest('.relative').find('.passwordField');
        input.attr("type") == "password" ? input.attr("type", "text") : input.attr("type", "password") ;
    });
    $(".leave").click(function(){
        window.location.replace('https://google.com','_self');
    });
	if ($.isFunction($.fn.tooltip)) {
		$('[data-toggle="tooltip"]').tooltip()
	}

    $('.newsletterForm').submit(function (e) {
        e.preventDefault();
        let newsLetterData= $('#newsletterForm').serialize();
        $.ajax({
            type: "post",
            url: baseUrl+"ajax/submit-newsletter",
            data: newsLetterData,
            dataType: "json",
            success: function (response) {
                if(response.status) showToast(response.message.heading,'NewsLetter',response.message.message);
                $('#newsletterForm').trigger('reset');
            },
            error: function (response) {
                showToast('error','NewsLetter','something went wrong');
            }
        });
    });

	/* ACCORDION */
	(function () {
		'use strict';
		//  Faqs Accordion
		var faqsAccordion = function () {
			var faqAcc = $('.faq-accordion h3');
			// Click
			faqAcc.on('click', function (event) {
				var $this = $(this);

				$('.faq-accordion').removeClass('active');
				$('.faq-accordion').find('.faq-body').slideUp(400);

				if (!$this.closest('.faq-accordion').find('.faq-body').is(':visible')) {
					$this.closest('.faq-accordion').addClass('active');
					$this.closest('.faq-accordion').find('.faq-body').slideDown(400);
				} else {
					$this.closest('.faq-accordion').removeClass('active');
					$this.closest('.faq-accordion').find('.faq-body').slideUp(400);
				}
				event.preventDefault();
				return false;
			});
		};
		// Document on load.
		$(function () {
			faqsAccordion();
		});
	}());

	if ($.isFunction($.fn.select2)) {
		$('.js-example-basic-single').select2();
	}

	if ($.isFunction($.fn.select2)) {
		$('.js-example-basic-single-multiple').select2({
			closeOnSelect : false,
			placeholder : "Please choose",
			allowHtml: true,
			allowClear: true,
			tags: true,
			containerCssClass : "multi-selector",
			dropdownCssClass: "multi-dropdown-checker"
		});
	}
	function iformat(icon, badge,) {
		var originalOption = icon.element;
		var originalOptionBadge = $(originalOption).data('badge');

		return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text + '<span class="badge">' + originalOptionBadge + '</span></span>');
	}
	/* $.ajaxSetup({
		'beforeSend': function () {
			$('.loader-blur, .loader').show();
		},
		'complete': function () {
			$('.loader-blur, .loader').hide();
		}
	}); */

	if (flashstatus == 'SUCCESS') {
		$.toast({
			heading: 'Success',
			text: flashmessage,
			loader: true,
			icon: 'success',
			position: TOAST_POSITION
		});
	}

	if (flashstatus == 'ERROR') {
		$.toast({
			heading: 'Error',
			text: flashmessage,
			loader: true,
			icon: 'error',
			position: TOAST_POSITION
		})
	}

	if (flashstatus == 'INFORMATION') {
		$.toast({
			heading: 'Information',
			text: flashmessage,
			loader: true,
			icon: 'info',
			position: TOAST_POSITION
		})
	}

	if (flashstatus == 'WARNING') {
		$.toast({
			heading: 'Warning',
			text: flashmessage,
			loader: true,
			icon: 'warning',
			position: TOAST_POSITION
		})
	}



    $(".leave").click(function(){
        window.location.replace('https://google.com','_self');
    });

	//toggle password

	$(document).on('click', '.toggle-password, #psd', function() {

		$(this).toggleClass("showPsd");

		var input = $("#password");
		input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
	});
	$(document).on('click', '#psdnew', function() {

		$(this).toggleClass("showPsd");

		var input = $("#newpassword");
		input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
	});
	$(document).on('click', '#psdconfirm', function() {

		$(this).toggleClass("showPsd");

		var input = $("#confirmpassword");
		input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
	});
	$(".menu-toggle").click(function (e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
		$(this).toggleClass('is-active');
		if ($(this).hasClass('is-active')) {
			$('.c-sidebar a').tooltip('enable');
		} else {
			$('.c-sidebar a').tooltip('disable');
		}
	});
	$(".dropdown-menu a").on('click', function(){
		$(this).parents('.btn-group').children(".btn:first-child").html($(this).text()+' <span class="caret"></span>');
	});

    $('.approveLicence').click(function (e) {
        var uuid = $(this).data('uuid');
        $.ajax({
            type: "post",
            url: baseUrl+"ajax/approve-licence",
            data: {'uuid':uuid},
            dataType: "json",
            success: function (response) {
                if(response.status){
                    showToast('success','Licence',response.message);
                    location.reload();
                }else{
                    showToast('error','Licence',response.message);
                }
            }
        });
    });

    $('.customdatatable').on('click','.changeStatus',function(e){
        var $this=$(this);
        var uuid= $this.data('uuid');
        var value= $this.data('value');
        var find= $this.data('table');
        var message = $this.data('message') ?? 'test message';
        Swal.fire({
            title: 'Are you sure you want to '+message+' it?',
            text: 'The status will be changed to '+message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, '+message+' it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "put",
                    url: baseUrl+'ajax/updateStatus',
                    data: {'uuid':uuid,'find':find,'value':value},
                    cache: false,
                    dataType: "json",
                    beforeSend: function(){

                    },
                    success: function(response){
                        if(response.status){
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function(response){
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now. Please try again after some time',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    /* ,
                    complete: function(response){
                        location.reload();
                    } */
                });
            }
          });
    });
    $('.customdatatable').on('click','.deleteData',function(e){
        var $this=$(this);
        var uuid= $this.data('uuid');
        var find= $this.data('table');
        var message = $this.data('message') ?? 'test message';
        Swal.fire({
            title: 'Are you sure you want to delete it?',
            text: 'You wont be able to revert this action!!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "delete",
                    url: baseUrl+'ajax/deleteData',
                    data: {'uuid':uuid,'find':find},
                    cache: false,
                    dataType: "json",
                    beforeSend: function(){

                    },
                    success: function(response){
                        if(response.status){
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function(response){
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now. Please try again after some time',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    /* ,
                    complete: function(response){
                        location.reload();
                    } */
                });
            }
          });
    });
    $('.deleteDocument').on('click',function(e){
        var $this=$(this);
        var uuid= $this.data('uuid');
        var find= $this.data('table');
        Swal.fire({
            title: 'Are you sure you want to delete it?',
            text: 'You wont be able to revert this action!!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "delete",
                    url: baseUrl+'ajax/deleteData',
                    data: {'uuid':uuid,'find':find},
                    cache: false,
                    dataType: "json",
                    beforeSend: function(){

                    },
                    success: function(response){
                        if(response.status){
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function(response){
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now. Please try again after some time',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    /* ,
                    complete: function(response){
                        location.reload();
                    } */
                });
            }
          });
    });

    $('.customdatatable').on('click','.changeUserStatus,.changeUserBlock',function(e){
        var $this=$(this);
        var uuid= $this.data('uuid');
        if($this.hasClass('changeUserStatus')){
            var value= {
                'is_active':$this.data('value')
            };
        }else{
            var value= {
                'is_blocked':$this.data('block')
            };
        }
        var find= $this.data('table');
        var message = $this.data('message') ?? 'test message';
        Swal.fire({
            title: 'Are you sure you want to '+message+' it?',
            text: 'The status will be changed to '+message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, '+message+' it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "put",
                    url: baseUrl+'ajax/updateStatus',
                    data: {'uuid':uuid,'find':find,'value':value},
                    cache: false,
                    dataType: "json",
                    beforeSend: function(){

                    },
                    success: function(response){
                        if(response.status){
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function(response){
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now. Please try again after some time',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    /* ,
                    complete: function(response){
                        location.reload();
                    } */
                });
            }
          });
    });
	//toggle checkout card price
	$(".chkout-card-header").on("click", function(e){
		$(this).toggleClass("expanded");
		$('.chkout-card-body').slideToggle();
	});

	$(document).on('change', '.country, .countrycity', function(){
        var cityHtml = '<option value="">Select city</option>';
        var timezoneHtml = '<option value="">Select timezone</option>';

        var cities = $('option:selected', this).attr('cities');
        cities = JSON.parse(cities);

		if($('option:selected', this).attr('timezones')){
			var timeZones = $('option:selected', this).attr('timezones');
        	timeZones = JSON.parse(timeZones);
		}

        if(cities != ''){
			if($(this).hasClass('countrycity')) {
				for(var key in cities){
					cityHtml += '<option value="'+cities[key]+'">'+cities[key]+'</option>';
				}
			}else{
				for (const [key, value] of Object.entries(cities)) {
					cityHtml += '<option value="'+key+'">'+value+'</option>';
				}
			}
        }

        if(timeZones != ''){
            $(timeZones).each(function(key, value){
                timezoneHtml += '<option value="'+value+'">'+value+'</option>';
            });
        }

        $('select[name="city"]').html(cityHtml);
        $('select[name="timezone"]').html(timezoneHtml);
	});

	//mobile search
	$('#advanced__search__button').click(function(){
		$('.escort-filter-wrapper').addClass('active');
		$('body').addClass('filter-open').append("<div class='body-overlay'></div>");
    	$('body').find('.body-overlay').fadeIn(100);
	});
	$('.search-main-close').click(function(){
		$('.escort-filter-wrapper').removeClass('active');
		$('body').find('.body-overlay').fadeOut(100);
	});
	//mobile search toggle
	$('#advanced__search__mobile').click(function(){
		$('.advanced__search__area').addClass('active');
	});
	$('.search-close').click(function(){
		$('.advanced__search__area').removeClass('active');
	});
	//desktop search toggle
	$('#advanced__search').click(function(){
		$('.advanced__search__area').toggleClass('active');
		// $('body').addClass('modal-open');
	});
	$('#filter__search').click(function(){
		$('.advanced__search__area').addClass('active');
		$('body').addClass('modal-open');
	});
	$('.advanced__search__cross').click(function(){
		$('.advanced__search__area').removeClass('active');
		// $('body').removeClass('modal-open');
	});

	$('#open__image__modal').click(function(){
		$('#image__modal').addClass('active');
		$('body').addClass('modal-open');
	});

	$('#open__video__modal').click(function(){
		$('#video__modal').addClass('active');
		$('body').addClass('modal-open');
	});
	$('.toggle__search').click(function(){
		$('#search__modal').addClass('active');
		$('body').addClass('modal-open');
	});

	$('.post__modal__btn').click(function(){
		$('#post__modal').addClass('active');
		$('body').addClass('modal-open');
	});
	$('.toggle__nav').on('click', function () {
		$(this).toggleClass('active');
		$('.o-content').toggleClass('active');
		$('body').toggleClass('sideBar-active');
	});

	$('.tab-pane:first').show();
	$('.filter--tab:first').addClass('current');
	$('.filter--tab').click(function(){
		if(!$(this).hasClass('current')) {
			$('.filter--tab.current').removeClass('current');
			$(this).addClass('current');
		} else {
			$(this).removeClass('current');
		}
		$(this).next().toggleClass('active');
		$('.tab-pane').not($(this).next()).removeClass('active');
	});

	//$('.notify-dropdown').hide();
  $('.notify-dp').on('click', function (e) {
    e.stopPropagation(),
    e.preventDefault();
    $('.notify-dropdown').slideToggle('slow');
    $('body').toggleClass('fixed');
    $('.o-navbar').toggleClass('nav-down');
  });
  $('.notf-close-modal').on('click', function (e) {
    e.stopPropagation();
    $('.notify-dropdown').fadeOut('fast');
    $('body').removeClass('fixed');
    $('.o-navbar').removeClass('nav-down');
  });

// Select all links with hashes
$('.static-base a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
      &&
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top - 80
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });

  if($('input[type=hidden][name="postdetailsurl"]').length){
    var clipboard = new Clipboard('.copytoclipboardpost', {
      text: function() {
        return document.querySelector('input[type=hidden][name="postdetailsurl"]').value;
      }
    });

    clipboard.on('success', function(e){
      $.toast({
        heading: "Info",
        text: "Post url copied.",
        loader: true,
        icon: "info",
        position: TOAST_POSITION,
      });

      e.clearSelection();
    });
  }

});
var transparent = $('.navbar--transparent').length;
$(window).on("scroll", function () {
	if(transparent){
		if ($(window).scrollTop() > 0) {
			$(".o-navbar").removeClass("navbar--transparent");
		} else {
			$(".o-navbar").addClass("navbar--transparent");
		}
	}
});

$(".compare_section").click(function() {
	$('html,body').animate({
		scrollTop: $("#compare_block").offset().top},
		'slow');
});

$('.warningCloseTrigger').on('click', function (e) {
    setcookie('twentyOneCheck', 'true', 365);
});

/* function warningPopUp() {
	var e = sessionStorage.getItem("enter_site");
	$("#warning-popup").hasClass("o-main-warning") && !e
		? $(body).addClass("preventBodyScroll")
		: $(body).removeClass("preventBodyScroll");
	$('.warningCloseTrigger').on('click', function (e) {
		e.preventDefault();
		if($(".disclaimerCheck").is(':checked'))
		{
			setcookie('eighteenCheck', 'true', 365);
			$(".o-main-warning").fadeOut(500);
			$(body).removeClass("preventBodyScroll");
        } else {
            showToast('error', 'Oops', 'Please Accept the terms and condition');
			// $('.disclaimer-alert-message').show();
		}
	});
} */

//profile tab height adjust with footer
function calcProfileHeight() {
  setTimeout(() => {
    var leftbarHeight = $('.o-post-inner-lft').outerHeight();
    $('.profile-info-tab').css('min-height', leftbarHeight);
  }, 200);
}

function showCartTotal(shippingCost= 0) {
    console.log(shippingCost);
    var totalPrice= 0;
    var tax= 0;
    if(shippingCost==0){
        shippingCost= parseFloat($('.shippingCost').val() ?? 0);
    }
    var allPrice = $('.detail-price');
    setTimeout(() => {
        $.each(allPrice, function (indexInArray, valueOfElement) {
            totalPrice=totalPrice+parseFloat($(this).html());
            tax=tax+parseFloat($(this).data('tax'));
        });
        $('.subtotal').html('$'+(totalPrice));
        $('.total').html('$'+(totalPrice+shippingCost));
        $('.total').val(totalPrice+shippingCost);
        $('.tax').html('$'+tax);
        $('.tax').val(tax);
        $('.shippingcost').html('$'+shippingCost);
        $('.shippingcost').val(shippingCost);
        $('.cart-items').html(allPrice.length);
    }, 200);
}

//motification listing modal height adjust
function notifyList() {
  setTimeout(() => {
    var notfheaderHeight = $('.notify-dropdown-header').outerHeight();
    var stickyfooterHeight = $('.o-mobile-footer').outerHeight();
    var bodyHeight = $(window).height();
    var totalHeight = Number(notfheaderHeight) + Number(stickyfooterHeight);
    var listHeight = bodyHeight - totalHeight;
    $('.notf-mobile').height(listHeight);
  }, 500);
}
$(window).on('resize', function () {
  notifyList();
  calcProfileHeight();
});


function setcookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1);
    if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}


function showToast(type, title, message) {
    $.toast({
        heading: title,
        text: message,
        loader: true,
        icon: type,
        position: 'bottom-right',
    });
}

