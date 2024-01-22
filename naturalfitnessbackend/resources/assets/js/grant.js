$('.checkForAddOption').on('click', function (e) {
    let innerHtml = '';
    if (this.checked) {
        innerHtml = `<div class="grid grid-cols-12 gap-6 p-2"><br>
                <input required type="text" class="form-control col-span-8 lg:col-span-8 2xl:col-span-8" name="option[]" placeholder="Option Value">
                <a href="javascript:void(0)" class="btn btn-sm btn-outline-success col-span-2 lg:col-span-2 2xl:col-span-2 addMore"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add More</a></div>`;
        $('.option').html(innerHtml);
    } else {
        $('.option').html('');
    }
});


$(document).on("change", "#type", function () {
    if (this.value == 'selectbox' || this.value == 'radio' || this.value == 'checkbox') {
        $('.option').show();
        $('.optionBtn').show();
    } else {
        $('.option').hide();
        $('.optionBtn').hide();
    }
});

$(document).on('keypress', '.number-only', function (e) {
    if (isNaN(this.value + "" + String.fromCharCode(e.charCode))) return false;
}).on("cut copy paste", function (e) {
    e.preventDefault();
});

$(document).on('click', '.operations', function (e) {
    const uuid = $(this).attr('data-id');
    $.confirm({
        confirmButton: 'Accept',
        cancelButton: 'Reject',
        title: 'Are you sure to Accept?',
        buttons: {
            confirm: function () {
                pitchAction(1, uuid);
            },
            cancel: function () {
                pitchAction(0, uuid);
            }
        }
    });
});

function pitchAction(val, uuid) {
    $.ajax({
        type: "put",
        url: baseUrl + 'ajax/pitchAction',
        data: { val,uuid },
        cache: false,
        dataType: "json",
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Operation Successfully',
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
    });
}


