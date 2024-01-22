$(document).on('click', '.fare_edit_btn', function(){
    let catId = $(this).data('catid');
    let data = JSON.parse($(this).attr('data-value'));
    //console.log(data);
    let time24 = data.start_at;
    let timeParts = time24.split(":");
    let hours = parseInt(timeParts[0], 10);
    let minutes = timeParts[1];
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    let time12 = hours + ':' + minutes + ' ' + ampm;
    /* End time */
    let endtime24 = data.end_at;
    let endtimeParts = endtime24.split(":");
    let endhours = parseInt(endtimeParts[0], 10);
    let endminutes = endtimeParts[1];
    let endampm = endhours >= 12 ? 'PM' : 'AM';
    endhours = endhours % 12;
    endhours = endhours ? endhours : 12;
    let endtime12 = endhours + ':' + endminutes + ' ' + endampm;
    $('#fare_'+catId+' .fare_id').val(data.id);
    $('#fare_'+catId+' .start_at').val(time12);
    $('#fare_'+catId+' .end_at').val(endtime12);
    $('#fare_'+catId+' .amount').val(data.amount);
    $('#fare_'+catId+' .fare_edit_btn_hide').show();
    $('#fare_'+catId+' .submit-btn').html('Update');
})
$(document).on('click', '.fare_edit_btn_hide', function(){
    let catId = $(this).data('catid');
    $('#faresubmit_'+catId)[0].reset();
    $('#fare_'+catId+' .submit-btn').html('Add');
    $(this).hide();
})

