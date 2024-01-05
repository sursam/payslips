var baseUrl = APP_URL + '/';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    getOrders();
    $(document).on('click', '.nav-link', function () {
        let tab = ($(this).data('bs-target')).replace('#','');
        getOrders(tab);
    });
});

function getOrders(tab='all-orders'){
    $.ajax({
        type: "post",
        url: baseUrl + 'ajax/customer/get-orders-by-type',
        data: {'type':tab},
        dataType: "json",
        success: function (response) {
            if (response.status) {
                $('#'+tab).html(response.data.orders);
            }
        },
    });
}
