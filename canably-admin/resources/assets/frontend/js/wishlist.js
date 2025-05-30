var baseUrl = APP_URL + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $(document).on('click', '.addToWishlist', function (event) {
        event.stopPropagation();
        var uuid = $(this).data('uuid');
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/customer/add-item-to-wishlist',
            data: { 'uuid': uuid },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    if ($(event.target).closest('i').attr('class') == 'fa-regular fa-heart') {
                        $(`#${uuid}_v`).attr('class', 'fa-solid fa-heart');
                        $(`#${uuid}_h`).attr('class', 'fa-solid fa-heart');
                        showToast('success', 'Wishlist', 'Product Added to wishlist successfully');
                    } else {
                        $(`#${uuid}_v`).attr('class', 'fa-regular fa-heart');
                        $(`#${uuid}_h`).attr('class', 'fa-regular fa-heart');
                        showToast('success', 'Wishlist', 'Product Removed from wishlist successfully');
                    }
                }
                else {
                    showToast('error', 'Wishlist', 'Sorry something went wrong');
                }
            },
        });


    });
    $(document).on('click', '.removeFromWishlist', function () {
        var uuid = $(this).data('uuid');
        $.ajax({
            type: "post",
            url: baseUrl + 'ajax/customer/remove-item-from-wishlist',
            data: { 'uuid': uuid },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('#wishlistHtmlDetails').html(response.data.wishlistHtml);
                   //location.reload();
                    showToast('success', 'Wishlist', 'Product Removed from wishlist successfully');
                } else {
                    showToast('error', 'Wishlist', 'Sorry something went wrong');
                }
            },
        });


    });

});

