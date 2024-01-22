
$('form.formSubmit').on('submit', function (e) {
    e.preventDefault();
    var $this = $(this);
    console.log($this);
    var formActionUrl = $this.prop('action');
    console.log($($this).attr('id'))
    if ($($this).hasClass('fileUpload')) {
        var fd = new FormData(document.getElementById($($this).attr('id')));
    }else{
        var fd = $(document.getElementById($($this).attr('id'))).serialize();
    }
    let commonOption={'type':'post','url':formActionUrl,'data':fd,'dataType':"json"};
    if ($($this).hasClass('fileUpload')) {
        commonOption['cache']=false;
        commonOption['processData']=false;
        commonOption['contentType']=false;
    }
    console.log(commonOption);
    $.ajax({
        ...commonOption,
        beforeSend: function () {
        },
        success: function (response) {
            if (response.status) {
                showToast('success','Excel Upload',response.message);
                location.reload();
            } else {
                showToast('error','Excel Upload','Something went Wrong');
            }
        },
        error: function (response) {
            let responseJSON = response.responseJSON;
            $(".err_message").removeClass("d-block").remove();
            $("form .form-control").removeClass("is-invalid");
            $.each(responseJSON.errors, function (index, valueMessage) {
                showToast('error','Error',valueMessage);
            });
        }
        /* ,
        complete: function(response){
            location.reload();
        } */
    });
});
