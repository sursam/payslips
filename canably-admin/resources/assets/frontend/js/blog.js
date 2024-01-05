var baseUrl = APP_URL + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
const form = document.getElementById('blogSearchForm');

        // Add an event listener to the form
        form.addEventListener('keydown', function(event) {
            // Check if the pressed key is Enter (key code 13)
            if (event.keyCode === 13) {
                event.preventDefault();
                blogSearch(); // Prevent the default form submission behavior
            }
        });
$('.blogSearchButton').click(function (e) {
    e.preventDefault();
    blogSearch();
});

function blogSearch(){
    var formData= $('#blogSearchForm').serialize();
    $.ajax({
        type: "post",
        url: baseUrl + 'ajax/getBlogs',
        data: formData,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if(response.status){
                console.log(response.status);
                $('.popularpost-sec').html(response.data.searchResult);
            }
        }
    });
}
