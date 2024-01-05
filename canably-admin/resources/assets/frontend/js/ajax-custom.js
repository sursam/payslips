var baseUrl = APP_URL + '/';
var data ='';
var products ='';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function productsfilter(){
    findProducts().done(function(response){
       data = response.data;
    });
};
function productsdataRefresh(){
    setTimeout(() => {
        $('.the-basics .typeahead').typeahead('destroy');
        products = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local:data
        });
        products.initialize(),
        $('.the-basics .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
            },
            {
            name: 'products',
            display: 'name',
            source: products.ttAdapter(),
            templates: {
                empty: [
                '<div class="empty-message">',
                    'No Record Found !',
                '</div>'
                ].join('\n'),
                suggestion: function (data) {
                    return '<a href="'+data.url+'" class="man-section"><div class="image-section"><img src='+data.picture+'></div><div class="description-section"><h4>'+data.name+'</h4><span>'+data.price+'</span></div></a>';
                }
            },
        });
    }
    , 1500);
};
$(document).ready(function () {
    productsfilter();
    productsdataRefresh();
    $('.masterCategory').on('change',function(){
        productsfilter();
        productsdataRefresh();
    });


    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
          var matches, substringRegex;
          matches = [];
          substrRegex = new RegExp(q, 'i');
          $.each(strs, function(i, str) {
            if (substrRegex.test(str)) {
              matches.push(str);
            }
          });
          cb(matches);
        };
    };

    $('.searchProductByCategory').on('click',function(){
        // var searchData = new FormData($('#searchCategoryWiseProductForm')[0]);
        var location = baseUrl+'shop-by-category/'+$('.masterCategory').val();
        // console.log($("input[name=search]").val());
        if($("input[name=search]").val() != '' ){
            location += '?search='+$("input[name=search]").val();
        }
        window.location.href= location;
    })
});



function findProducts(){
    var formdata = new FormData($('#searchCategoryWiseProductForm')[0]);
    return $.ajax({
        type: "post",
        data:formdata,
        url: baseUrl + 'ajax/getProducts',
        processData: false,
        contentType: false,
        dataType: "json",
    });

}
