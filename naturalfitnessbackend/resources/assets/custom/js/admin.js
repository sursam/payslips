$(document).ready(function() {
    $(document).on("change", "#booking_for", function() {
        if($(this).val() == 'other'){
            $('.booking_for_other').fadeIn();
        }else{
            $('.booking_for_other').fadeOut();
        }
    });
    if($("#booking_for").length){
        $("#booking_for").trigger("change");
    }

    function loadTimeSlots(selectedSlot = '') {
        $.ajax({
            type: "get",
            url: baseUrl+"ajax/getAvailableSlots",
            data: {'doctor_id': $('#doctor_id').val(), 'selected_date': $(".booking_date:checked").val(), 'selected_slot': selectedSlot},
            dataType: "json",
            beforeSend: function () {
                $('.loader').show();
            },
            success: function (response) {
                $('.loader').hide();
                if(response.status) {
                    $('.times_container').html(response.data);
                    $('.time_row').fadeIn();
                }
            },
            error: function (response) {
                $('.loader').hide();
                $('.booking_date').prop('checked', false);
                let responseJSON = response.responseJSON;
                $.each(responseJSON.errors, function (index, valueMessage) {
                    showToast('error','Error',valueMessage);
                });
            }
        });
    }
    $(document).on("change", ".booking_date", function() {
        var bookedDatetime = $(".booking_date:checked").data('bookedtime');
        loadTimeSlots(bookedDatetime);
    });
    if($(".booking_date").length && $(".booking_date:checked").val()){
        var bookedDatetime = $(".booking_date:checked").data('bookedtime');
        loadTimeSlots(bookedDatetime);
    }
    $(document).on("change", "#doctor_id", function() {
        if($('.booking_date:checked').length){
            $(".booking_date").trigger('change');
        }
    });
});
