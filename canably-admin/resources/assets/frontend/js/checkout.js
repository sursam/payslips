$(document).ready(function(){
    $('#gridCheck').click(function () {
        if ($(this).is(':checked')) {
            let name = $('#name').val();
            let address_line_one = $('#address_line_one').val();
            let address_line_two = $('#address_line_two').val();
            let phone_number = $('#phone_number').val();
            let city = $('#city').val();
            let state = $('#state').val();
            let zip_code = $('#zip_code').val();
            $('#address_name').val(name).attr('readonly',true);
            $('#shipping_address_line_one').val(address_line_one).attr('readonly',true);
            $('#shipping_address_line_two').val(address_line_two).attr('readonly',true);
            $('#shipping_phone_number').val(phone_number).attr('readonly',true);
            $('#shipping_city').val(city).attr('readonly',true);
            $('#shipping_state').val(state).attr('readonly',true);
            $('#shipping_zip_code').val(zip_code).attr('readonly',true);

        }else{
            $('#address_name').val('').attr('readonly',false);
            $('#shipping_address_line_one').val('').attr('readonly',false);
            $('#shipping_address_line_two').val('').attr('readonly',false);
            $('#shipping_phone_number').val('').attr('readonly',false);
            $('#shipping_city').val('').attr('readonly',false);
            $('#shipping_state').val('').attr('readonly',false);
            $('#shipping_zip_code').val('').attr('readonly',false);
        }
    });

});
