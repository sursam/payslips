var baseUrl = APP_URL+ '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function() {
    $('button[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).data('bs-target'));
    });
    var activeTab = localStorage.getItem('activeTab');

    if(activeTab){
        $('.filter-tab button[data-bs-target="' + activeTab + '"]').tab('show');
    }


    $('.settingsForm').submit(function (e) {
        e.preventDefault();
        let data = new FormData(this);
        console.table(data);
        $.ajax({
            type: "put",
            url: baseUrl + 'ajax/update/settings',
            data: data,
            method:'post',
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    showToast('success','Settings','Site setting updated successfully');
                }else{
                    showToast('error','Error','Something Went Wrong');
                }
            }
        });
    });


});
