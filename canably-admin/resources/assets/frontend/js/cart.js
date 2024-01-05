var baseUrl = APP_URL + '/';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    if($('.countries').length){
        populateData($('.countries'));
    }
    let check= $('.check').val();
    getStores($('#zip_code').val());

    $('.applyCoupon').click(function (e) {
        e.preventDefault();
        applyCoupon($('.coupon').val());
    });
    $('.removeCoupon').click(function (e) {
        e.preventDefault();
        removeCoupon();
    });
    $('#delivery-form').submit(function (e) {
        e.preventDefault();
        if(!$('.coupon').val()){
            removeCoupon(false);
        }
        let delivery_type = $('input[name="delivery_type"]:checked').val();
        if (delivery_type == 'store-pickup') {
            let store_address = $(document).find('.store_address').attr('checked',true).val();
            if(store_address=='' || store_address == undefined){
                showToast('error', 'Store Address', 'Please select a store');
                return false;
            }
            $(this)[0].submit();
        } else if (delivery_type == 'delivery') {
            let country= $('.countries').val();
            let state= $('.states').val();
            let city= $('.cities').val();
            let zipcode= $('.delivery_zipcode').val();
            let street_address= $('.street_address').val();
            if(country == ''){
                showToast('error', 'Location', 'Please select country');
                return false;
            }else if(state == ''){
                showToast('error', 'Location', 'Please select state');
                return false;
            }else if(zipcode ==''){
                showToast('error', 'Location', 'Please enter zipcode');
                return false;
            }else if(street_address ==''){
                showToast('error', 'Location', 'Please enter street address');
                return false;
            }
            if(country!='' && state!='' && city!='' && street_address!='' && zipcode!=''){
                $.ajax({
                    url: baseUrl+'ajax/get-shipping-cost',
                    type: 'post',
                    data: new FormData($('#delivery-form')[0]),
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response){
                        if(response.status){
                            $('.shippingcost').text('$'+response.data);
                            // showCartTotal(response.data);
                            setTimeout(() => {
                                e.currentTarget.submit();
                            }, 500);
                        }
                    },
                    error:function(response){
                        showToast('error', 'Delivery', 'Something went wrong');
                    },
                    done: function(response){

                        if(response.status){

                        }
                    }
                });
            }
        }
    });

    $(document).on('click', '.addToCart', function () {
        var uuid = $(this).data('uuid')
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/add-to-cart',
            data: { 'uuid': uuid },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('.cartProducts').html(response.data.cartHtml);
                    $('.side-total').html('$'+response.data.total);
                    $('.inverce').html(response.data.totalProducts);
                    showToast('success', 'Cart', 'Product Added to cart successfully');
                    // showCartTotal(40);
                } else {
                    showToast('error', 'Cart', 'Sorry something went wrong');
                }
            },
        });
    });

    $(document).on('click', '.clearCart', function () {

        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/clear-cart',
            data: {},
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('.cart-card').html(response.data.cartHtml);
                    showToast('success', 'Cart', 'Cart cleared successfully');
                } else {
                    showToast('error', 'Cart', 'Sorry something went wrong');
                }
            },
        });
    });

    $(document).on('click', '.removeFromCart', function () {
        var id = $(this).data('id')
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/remove-from-cart',
            data: { 'id': id },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('.cart-card').html(response.data.cartHtml);
                    showToast('success', 'Cart', 'Product Removed from cart successfully');
                } else {
                    showToast('error', 'Cart', 'Sorry something went wrong');
                }
            }, done: function (response) {
                setTimeout(() => {
                    showCartTotal();
                }, 500);

            }
        });
    });

    $(document).on('click', '.quantity-plus,.quantity-minus', function () {
        var id = $(this).data('id');
        var quantity = $(this).hasClass('quantity-plus') ? parseInt($(this).data('quantity')) + 1 : parseInt($(this).data('quantity')) - 1
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/update-cart',
            data: { 'id': id, 'quantity': quantity },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('.cart-card').html(response.data.cartDetail);
                    $('.side-total').html('$'+response.data.total);
                    $('.side-total').html('$'+response.data.total);
                    showToast('success', 'Cart', 'Product updated in cart successfully');
                } else {
                    showToast('error', 'Cart', 'Sorry something went wrong');
                }
            },
        });
        showCartTotal();
    });

    $(document).on("click",".add",function () {
        if ($(this).prev().val() < 10) {
            $(this).prev().val(+$(this).prev().val() + 1);
        } else {
            showToast('warning', 'Maximum', 'Order quantity is at maximum');
        }
    });

    $(document).on("click",".sub",function () {
        if ($(this).next().val() > 1) {
            $(this).next().val(+$(this).next().val() - 1);
        } else {
            showToast('error', 'Minimum', 'Order quantity is at minimum');
        }
    });

    $('.delivery-type').click(function (e) {
        if ($(this).val() == 'delivery') {
            $('.delivery').removeClass('d-none');
            $('.store-pickup').addClass('d-none');
        } else if ($(this).val() == 'store-pickup') {
            $('.store-pickup').removeClass('d-none');
            $('.delivery').addClass('d-none');
        }
    });

    $(document).on("change", ".getPopulate", function () {
        var optHtml = '<option value="">Select A ' + $(this).data('message') + '</option>';
        if ($(this).val != '') {
            populateData($(this));
        } else {
            $('.' + $(this).data('location')).html('').html(optHtml);
        }
    });

    $(document).on('change', '.states', function (e) {
        var optHtml = '<option value="">Select A ' + $(this).data('message') + '</option>';
        if ($(this).val != '') {
            getCities($(this));
        } else {
            $('.' + $(this).data('location')).html('').html(optHtml);
        }
    });

    /* search a zip code */

    $("#zip_code").keyup(function (e) {
        validateZipCode();
    });

    $("#zip_code").blur(function (e) {

        let is_validate = validateZipCode();
        if (is_validate == true) {
            getStores($(this).val());

            //console.log(value);
        } else {
            showToast('error', 'ZipCode', 'Wrong zipcode format');
        }
    });

});
function populateData(selector) {
    var optHtml = '';
    var populatelocation = selector.data('location');
    var selected = 'California';
    var populatemessage = selector.data('message');
    var populateStr = selector.find('option:selected').data("populate");
    optHtml += (populateStr.length == 0) ? '<option value="" selected="selected" disabled >No ' + populatemessage + '</option>' : '<option value="">Select a ' + populatemessage + '</option>';
    $.each(populateStr, function (key, value) {
        var select = (selected && selected == value) ? 'selected' : '';
        optHtml += '<option value="' + key + '" ' + select + '>' + value + '</option>';
    });

    $('.' + populatelocation).html('').html(optHtml);
    getCities($('.states'));
}
function getCities(selector) {
    var populatelocation = selector.data('location');
    var value = selector.find('option:selected').val();
    $.ajax({
        url: baseUrl + 'ajax/getCities',
        method: 'get',
        data: { 'state_id': value,'select':'san-diego'},
        dataType: "json",
        success: function (response) {
            if (response.status) {
                $('.' + populatelocation).html(response.data);
                $('.' + populatelocation).attr("style", "pointer-events: none;");
                $('.countries,.states').attr("style", "pointer-events: none;");
                $('.checkoutBtn').attr("disabled",false);
            } else {
                $('.checkoutBtn').attr("disabled",true);
                showToast('error', 'Error', 'Something Went Wrong');
            }
        }
    });
}
function validateZipCode() {

    let zip_code = $("#zip_code").val();
    var regex = new RegExp(/^[1-9]{1}[0-9]{2}\s{0,1}[0-9]{2}$/);

    if (regex.test(zip_code)) {
        $("#zip_code").removeClass('is-invalid');
        return true;
    } else {
        $("#zip_code").addClass('is-invalid');
        return false;
    }

}

function getStores(zipcode=92103){
    let html = '';
    let zip = zipcode;
    $.ajax({
        type: "post",
        url: baseUrl + 'ajax/store-pickup',
        data: { zip: zip },
        dataType: "json",
        success: function (response) {
            if (response.status) {
                $.each(response.data, function (key, value) {
                    var checked = key==0 ? 'checked': '';
                    html += `<div class="form-check">
                                <input class="form-check-input store_address" ${checked} type="radio" name="store_address" value="${value.uuid}" id="address-key-${key}">
                                <label class="form-check-label" for="address-key-${key}">
                                ${value.full_address}
                                </label>
                            </div>`;
                });
                $('#pickupAddress').html(html);
            } else {
                $('#pickupAddress').empty();
            }



        }
    });
}

function applyCoupon(code){
    $.ajax({
        type: "post",
        url: baseUrl+"ajax/customer/apply-coupon",
        data: {'code': code},
        dataType: "json",
        success: function (response) {
            if(response.status){
                $('.applyCoupon').hide();
                $('.removeCoupon').show();
                $('.coupon').attr('readonly',true);
                $('.discount').text('$'+response.data.discount)
                $('.total').text('$'+response.data.total)
                showToast('success','Coupon',response.message);
            }
            else{
                if(response.response_code== 422){
                    $.each(response.message, function (key, value) {

                        showToast('error','Coupon',value);
                    });
                }else{
                    $('.coupon').val('');
                    showToast('error','Coupon',response.message);
                }
            }
        },error:function(response){

        }
    });
}

function removeCoupon(flash=true){
    $.ajax({
        type: "get",
        url: baseUrl+"ajax/customer/remove-cart-coupon",
        dataType: "json",
        success: function (response) {
            if(response.status){
                $('.removeCoupon').hide();
                $('.applyCoupon').show();
                $('.coupon').attr('readonly',false);
                $('.coupon').val('');
                $('.discount').text('$'+response.data.discount)
                $('.total').text('$'+response.data.total)
                if(flash){
                    showToast('warning','Coupon',response.message);
                }
            }
        }
    });
}



