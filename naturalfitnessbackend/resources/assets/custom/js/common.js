// JavaScript Document
'use strict';
var baseUrl = APP_URL + '/';
var pagetype = jQuery('input[name="pagetype"]').val();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(".show_hide_password a").on('click', function(event) {
    event.preventDefault();
    var $this= $(this).closest('.show_hide_password');
    var type= $this.find('input').attr("type");
    if(type == "text"){
        $this.find('input').attr('type', 'password');
        $this.find('a i').attr("class","fa fa-eye-slash");
        $this.find('svg').attr('data-icon', 'eye-slash');
    }else if(type == "password"){
        console.log($this.find('a i').length);
        $this.find('input').attr('type', 'text');
        $this.find('a i').attr("class","fa fa-eye");
        $this.find('svg').attr('data-icon', 'eye');
    }
});

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$('.showOnUpload').change(function(){
    $('#showOnUpload').prop('src',URL.createObjectURL(this.files[0]));
});
$('.showOnBrowse').change(function(){
    $('#'+$(this).data('show-loaction')).prop('src',URL.createObjectURL(this.files[0]));
});
$('.showMultipleOnUpload').change(function(){
    $('#showMultipleOnUpload').html('');
    var filesAmount = this.files.length;
    var i;
    for (i = 0; i < filesAmount; i++) {
        var reader = new FileReader();
        reader.onload = function(event) {
            $($.parseHTML('<img>')).attr({'src':event.target.result,'width':200,'height':200}).addClass('img-fluid img-thumbnail m-2').appendTo('#showMultipleOnUpload');
            $
        }
        reader.readAsDataURL(this.files[i]);
    }
    // $('#showOnUpload').prop('src',URL.createObjectURL(this.files[0]));
});
$(document).ready(function (e) {
    $(document).on("change", ".getPopulate", function () {
        var optHtml = '<option value="">Select a ' + $(this).data('message') + '</option>';
        if ($(this).val() != '') {
            populateData($(this));
        } else {
            $('.' + $(this).data('location')).html('').html(optHtml);
        }
    });
    $(document).on("change", ".getMultiPopulate", function () {
        var optHtmlFirst = '<option value="">Select a ' + $(this).data('message-first') + '</option>';
        if ($(this).val() != '') {
            var populateStrFirst = $(this).find('option:selected').data("populate-first");
            populateMultiData($(this), $(this).data('location-first'), $(this).data('message-first'), populateStrFirst);
            //populateData($(this));
        } else {
            $('.' + $(this).data('location-first')).html('').html(optHtmlFirst);
        }
        var optHtmlSecond = '<option value="">Select a ' + $(this).data('message-second') + '</option>';
        if ($(this).val() != '') {
            var populateStrSecond = $(this).find('option:selected').data("populate-second");
            populateMultiData($(this), $(this).data('location-second'), $(this).data('message-second'), populateStrSecond);
        } else {
            $('.' + $(this).data('location-second')).html('').html(optHtmlSecond);
        }
    });
    if($('.getPopulate').length && $('.getPopulate').val()){
        $('.getPopulate').trigger('change');
    }
    if($('.getMultiPopulate').length && $('.getMultiPopulate').val()){
        $('.getMultiPopulate').trigger('change');
    }

    $(document).on('change', '.is_vat_registered', function (e) {
        if($(this).val() == '1'){
            $('.vat_number').show();
        }else{
            $('.vat_no').val('');
            $('.vat_number').hide();
        }
    });
    if($('.vat_no').length){
        if($('.vat_no').val()){
            $('.vat_number').show();
        }else{
            $('.vat_number').hide();
        }
    }

    $(document).on('click', '.statusChange', function (e) {
        changeStatus($(this));
    });
    $(document).on('click', '.modal button.resetBtn', function (e) {
        if ($('form.formSubmit .password_section').length > 0) $('form.formSubmit .password_section').removeClass('d-none');
        if ($('form.formSubmit .cv_section label span').length > 0) $('form.formSubmit .cv_section label span').removeClass('d-none');
        $('form.formSubmit').trigger('reset');
        $('form.formSubmit').prop('action', $('form.formSubmit').data('url'));
        $('form.formSubmit #email').prop('disabled', false);
        $('.display_picture').addClass("d-none");
    });
    $(document).on('click', '.deleteData', function (e) {
        // console.log('here');
        deleteData($(this));
    });
    $('.customdatatable').on('click', '.changeStatus', function (e) {
        changeStatus($(this));
    });
    $('.customdatatable').on('click', '.changeBrandingStatus', function (e) {
        var $this = $(this);
        var uuid = $this.data('uuid');
        var action = $this.data('action');
        var status = (action == 'accept') ? 2 : 3;
        var icon = (action == 'accept') ? 'success' : 'warning';
        //console.log(uuid);
        var find = $this.data('table');
        Swal.fire({
            title: "Do you want to "+action+" Da'ride Branding request?",
            // html: '<label><input type="radio" name="banding_accept" class="banding_accept" value="2">Accept</label><label><input type="radio" name="banding_accept" class="banding_accept" value="3">Reject</label>',
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            focusConfirm: false,
            // preConfirm: () => {
            //     const banding_accept = Swal.getPopup().querySelector('.banding_accept:checked').value
            //     if (!banding_accept) {
            //         Swal.showValidationMessage(`Please click on any option`)
            //     }
            //     return { banding_accept: banding_accept }
            // }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "put",
                    url: baseUrl + 'ajax/updateBrandingStatus',
                    data: { 'uuid': uuid, 'find': find, 'is_branding': status },
                    cache: false,
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status) {
                            let responseStatus = (status == 2) ? 'accepted' : 'rejected';
                            Swal.fire({
                                icon: 'success',
                                title: "Da'ride Branding request "+responseStatus+"!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function (response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now. Please try again after some time',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    ,
                    complete: function(response){
                        location.reload();
                    }
                });
            }

        });
    });
    $('.customdatatable').on('click', '.deleteData', function (e) {
        deleteData($(this));
    });
    $(document).on('click', '.deleteTableData', function (e) {
        console.log('here');
        deleteTableData($(this));
    });
    $('.deleteDocument').on('click', function (e) {
        var $this = $(this);
        var uuid = $this.data('uuid');
        var find = $this.data('table');
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
                    url: baseUrl + 'ajax/deleteData',
                    data: { 'uuid': uuid, 'find': find },
                    cache: false,
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Successfully',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function (response) {
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

    $('.customdatatable').on('click', '.changeUserStatus,.changePaymentStatus,.changeUserBlock', function (e) {
        var $this = $(this);
        var state = $this.prop('checked') == true ? 1 : 0;
        var uuid = $this.data('uuid');
        if ($this.hasClass('changeUserStatus')) {
            var value = {
                'is_active': $this.data('value')
            };
        }else if($this.hasClass('changePaymentStatus'))
        {
            var value = {
                'is_paid': state
            };
        } else {
            var value = {
                'is_blocked': $this.data('block')
            };
        }
        var find = $this.data('table');
        var message = $this.data('message') ?? 'test message';
        Swal.fire({
            title: 'Are you sure you want to change the status?',
            text: 'The status will be changed',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "put",
                    url: baseUrl + 'ajax/updateStatus',
                    data: { 'uuid': uuid, 'find': find, 'value': value },
                    cache: false,
                    dataType: "json",
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'We are facing some technical issue now.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $this.prop('checked', !state);
                        }
                    },
                    error: function (response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now. Please try again after some time',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $this.prop('checked', !state);
                    }
                    /* ,
                    complete: function(response){
                        location.reload();
                    } */
                });
            }else {
                $this.prop('checked', !state);
            }
        });
    });

});
//profile tab height adjust with footer
function calcProfileHeight() {
    setTimeout(() => {
        var leftbarHeight = $('.o-post-inner-lft').outerHeight();
        $('.profile-info-tab').css('min-height', leftbarHeight);
    }, 200);
}


$(window).on('resize', function () {
    calcProfileHeight();
});

function populateMultiData(selector, populatelocation, populatemessage, populateStr) {
    var optHtml = '';
    var selected = $('.' + populatelocation).data('auth') ?? '';
    optHtml += (populateStr.length == 0) ? '<option value="" selected="selected" disabled >No ' + populatemessage + '</option>' : '<option value="">Select A ' + populatemessage + '</option>';
    for (var key in populateStr) {
        //console.log(selected, key);
        var select = (selected && selected == key) ? 'selected' : '';
        optHtml += '<option value="' + key + '" ' + select + '>' + populateStr[key] + '</option>';
    }
    $('#' + populatelocation).html('').html(optHtml);
}
function populateData(selector) {
    var optHtml = '';
    var populatelocation = selector.data('location');
    var selected = $('.' + populatelocation).data('auth') ?? '';
    //console.log(selected);
    var populatemessage = selector.data('message');
    var populateStr = selector.find('option:selected').data("populate");
    optHtml += (populateStr.length == 0) ? '<option value="" selected="selected" disabled >No ' + populatemessage + '</option>' : '<option value="">Select A ' + populatemessage + '</option>';
    for (var key in populateStr) {
        var select = (selected && selected == key) ? 'selected' : '';
        optHtml += '<option value="' + key + '" ' + select + '>' + populateStr[key] + '</option>';
    }
    $('#' + populatelocation).html('').html(optHtml);
}

function changeStatus(selector) {
    var $this = selector;
    var statusAttr = $this.data('type');
    // console.log(statusAttr);
    var state = $this.prop('checked') == true ? 1 : 0;
    var is_active = state;
    var alertTitle = "Are you sure you want to change the status?";
    if (typeof statusAttr !== 'undefined' && statusAttr == 'suspend') {
        if($this.prop('checked') == true){
            is_active = 0;
            alertTitle = "Are you sure you want to suspend this user?";
        }else{
            is_active = 1;
            alertTitle = "Are you sure you want to activate this user?";
        }
    }
    var uuid = $this.data('uuid');
    // console.log(uuid);
    // console.log(is_active);
    var find = $this.data('table');
    var message = $this.data('message') ?? 'test message';
    Swal.fire({
        title: alertTitle,
        text: 'The status will be changed',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "put",
                url: baseUrl + 'ajax/updateStatus',
                data: { 'uuid': uuid, 'find': find, 'is_active': is_active },
                cache: false,
                dataType: "json",
                beforeSend: function () {

                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $this.data('message', message == 'deactive' ? 'active' : 'deactive');
                        if ($this.parent().hasClass('inTable')) {
                            $this.parent().closest('tr.manage-enable').toggleClass('block-disable');
                            let divRight = $this.parent().parent().siblings().find('div.dot-right');
                            divRight.hasClass('pe-none') ? divRight.removeClass('pe-none') : divRight.addClass('pe-none');
                        } else {
                            $this.parent().closest('div.manage-data').toggleClass('block-disable');
                            let divRight = $this.parent().closest('div.dot-right');
                            divRight.hasClass('pe-none') ? divRight.removeClass('pe-none') : divRight.addClass('pe-none');
                        }
                        $this.parent().find('label').text(state ? 'Active': 'Inactive').css('color',state ? 'green': 'red');

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $this.prop('checked', !state);

                    }
                },
                error: function (response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'We are facing some technical issue now. Please try again after some time',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $this.prop('checked', !state);
                }
                /* ,
                complete: function(response){
                    location.reload();
                } */
            });
        } else {
            $this.prop('checked', !state);
        }

    });
}

function deleteData(selector) {
    var $this = selector;
    var uuid = $this.data('uuid');
    var find = $this.data('table');
    var message = $this.data('message') ?? 'test message';
    Swal.fire({
        title: 'Are you sure you want to delete it?',
        text: 'You wont be able to revert this action!!',
        icon: 'warning',
        width: '350px',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#1D9300',
        cancelButtonColor: '#F90F0F',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "delete",
                url: baseUrl + 'ajax/deleteData',
                data: { 'uuid': uuid, 'find': find },
                cache: false,
                dataType: "json",
                beforeSend: function () {

                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function (response) {
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
}
function deleteCouncilData(selector) {
    var $this = selector;
    var uuid = $this.data('uuid');
    var find = $this.data('table');
    var message = $this.data('message') ?? 'test message';
    Swal.fire({
        title: 'Are you sure you want to delete it?',
        text: 'You wont be able to revert this action!!',
        icon: 'warning',
        width: '350px',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#1D9300',
        cancelButtonColor: '#F90F0F',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "delete",
                url: baseUrl + 'ajax/deleteCouncilData',
                data: { 'uuid': uuid, 'find': find },
                cache: false,
                dataType: "json",
                beforeSend: function () {

                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function (response) {
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
}
function deleteTableData(selector) {
    var $this = selector;
    var uuid = $this.data('uuid');
    var find = $this.data('table');
    var message = $this.data('message') ?? 'test message';
    Swal.fire({
        title: 'Are you sure you want to delete it?',
        text: 'You wont be able to revert this action!!',
        icon: 'warning',
        width: '350px',
        allowOutsideClick: false,
        showCancelButton: true,
        confirmButtonColor: '#1D9300',
        cancelButtonColor: '#F90F0F',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "delete",
                url: baseUrl + 'ajax/deleteTableData',
                data: { 'uuid': uuid, 'find': find },
                cache: false,
                dataType: "json",
                beforeSend: function () {

                },
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function (response) {
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
}
$('#parent_category,#sub_category').change(function (e) {
    e.preventDefault();
    let categoryId= $(this).val();
    let location= $(this).data('location');
    var data='';
    $.ajax({
        type: "post",
        url: baseUrl+"ajax/getGroupedTypes",
        data: {'category': categoryId},
        dataType: "json",
        success: function (response) {
            $('.selecttoolbox').html('');
            if(response.status && response.data.length > 0) {
                $.each(response.data, function (key, value) {
                    key=parseInt(key)+1;
                    data += `<div class="selecttool-text ${(key%2 ==0) ? 'selecttool-textbg' : ''}">
                    <h5>${value.name}</h5>
                    <input type="checkbox" name="types[]" class="form-checkinput" value="${value.value}">
                </div>`;
                });
                $('.selecttoolbox').html(data);
            }
        }
    });
});

$(document).on("change", ".recharge-custom-amount", function() {
    $('.recharge-amount').val($(this).val());
    $('.recharge-default-amount').prop('checked', false);
});
$(document).on("change", ".recharge-default-amount", function() {
    $('.recharge-amount').val($(this).val());
    $('.recharge-custom-amount').val('');
});

$(document).on('click', '.changeMediaStatus', function (e) {
    var $this = $(this);
    var user_uuid = $this.data('user-uuid');
    var media_type = $this.data('media-type');
    var message = $this.data('message') ?? 'test message';
    var title = '';
    if(media_type == 'image'){
        title = 'Are you sure you want to approve the profile picture?';
    }else if(media_type == 'vehicle_image'){
        title = 'Are you sure you want to approve the vehicle image?';
    }else{
        title = 'Are you sure you want to approve the '+media_type+' document?';
    }
    Swal.fire({
        title: title,
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, approve it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "put",
                url: baseUrl + 'ajax/updateMediaStatus',
                data: { 'user_uuid': user_uuid, 'media_type': media_type, 'is_approve': 1 },
                cache: false,
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        //alert(response.data);
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'We are facing some technical issue now.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $this.prop('checked', !state);

                    }
                },
                error: function (response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'We are facing some technical issue now. Please try again after some time',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $this.prop('checked', !state);
                }
                ,
                complete: function(response){
                    location.reload();
                }
            });
        } else {
            $this.prop('checked', !state);
        }

    });
});
$(document).on('change', '.referral_form .reference_type', function(){
    if($(this).val() == 'other'){
        $('.referral_form .show_for_other').show();
        $('.referral_form .show_for_other').find('.form-control').prop('required',true);
    }else{
        $('.referral_form .show_for_other').hide();
        $('.referral_form .show_for_other').find('.form-control').prop('required',false);
    }
});
$(document).on('change', '.referral_form .reference_source', function(){
    if($(this).find('option:selected').text() == 'DSR IBD'){
        $('.referral_form .show_for_dsr').fadeIn();
        $('.referral_form .show_for_dsr').find('.form-control').prop('required',true);
        $('.referral_form .reference_type').trigger('change');
    }else{
        $('.referral_form .show_for_dsr').fadeOut();
        $('.referral_form .show_for_dsr').find('.form-control').prop('required',false);
    }
});
