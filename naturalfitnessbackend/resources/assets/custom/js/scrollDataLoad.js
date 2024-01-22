'use strict';
var baseUrl = APP_URL + "/";
var getUrl= $('.dataUrl').val();
var page = 1;
infinteLoadMore(page,getUrl);
$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() + 1 >= $(document).height()) {
        page++;
        infinteLoadMore(page,getUrl);
    }
});
function infinteLoadMore(page,url) {
    $.ajax({
        url: baseUrl + "ajax/"+url,
        data: { page: page },
        datatype: "html",
        type: "get",
        beforeSend: function () {
            $(".auto-load").show();
        },
    })
        .done(function (response) {
            if (response.data.length == 0) {
                $(".auto-load").html("No Data Found");
                return;
            }
            $(".auto-load").hide();
            $("#data-wrapper").append(response.data);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            showToast("error", "Data", "Something Went Wrong");
        });
}
