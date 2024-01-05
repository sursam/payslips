var baseUrl = APP_URL + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('.addCostBtn').click(function (e) {
        e.preventDefault();
        let count = $(this).data('count');
        let html = `<div class="card p-2">
                    <div class="sm:flex sm:justify-between sm:items-center my-2 justify-content-end">
                        <button type="button" class="btn border-slate-200 hover:border-slate-300 deleteCost">
                            <svg class="w-4 h-4 fill-current text-rose-500 shrink-0" viewBox="0 0 16 16">
                                <path d="M5 7h2v6H5V7zm4 0h2v6H9V7zm3-6v2h4v2h-1v10c0 .6-.4 1-1 1H2c-.6 0-1-.4-1-1V5H0V3h4V1c0-.6.4-1 1-1h6c.6 0 1 .4 1 1zM6 2v1h4V2H6zm7 3H3v9h10V5z" />
                            </svg>
                        </button>
                    </div>
                    <div class="grid gap-3 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="country-`+ (count + 1) + `">Country <span
                                    class="text-rose-500">*</span></label>
                                    <select class="form-select getPopulate countries required" id="country-`+ (count + 1) + `" name="shipping[`+ (count + 1) + `][country]" data-location="state-`+ (count + 1) + `" data-message="state"></select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="state-`+ (count + 1) + `">State <span
                                    class="text-rose-500">*</span></label>
                                    <select class="form-select states required" id="state-`+ (count + 1) + `" name="shipping[`+ (count + 1) + `][state]" data-location="city-`+ (count + 1) + `" data-message="city"></select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="city-`+ (count + 1) + `">City <span
                                    class="text-rose-500">*</span></label>
                                    <select class="form-select cities required" id="city-`+ (count + 1) + `" name="shipping[`+ (count + 1) + `][city]"></select>
                        </div>
                    </div>
                    <div class="grid gap-2 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="pincode-`+ (count + 1) + `">Pincodes(e.g:123456,123456,234567....)</label>
                                    <textarea class="form-input w-full" rows="2" id="pincode-`+ (count + 1) + `" name="shipping[`+ (count + 1) + `][pincode]"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="cost-`+ (count + 1) + `">Cost <span
                                    class="text-rose-500">*</span></label>
                                    <input type="number" class="form-control form-input w-full cost required" id="cost-`+ (count + 1) + `" name="shipping[`+ (count + 1) + `][cost]">
                        </div>
                    </div>
                </div>`
        $('.addCostContainer').append(html);
        getCountries('country-'+(count + 1));
        $(this).data('count', count + 1);
    });
    $(document).on("change", ".getPopulate", function(){
        var optHtml='<option value="">Select A '+$(this).data('message')+'</option>';
        if($(this).val!=''){
            populateData($(this));
        }else{
            $('.'+$(this).data('location')).html('').html(optHtml);
        }
    });
    $(document).on('change','.states',function(e){
        var optHtml='<option value="">Select A '+$(this).data('message')+'</option>';
        if($(this).val!=''){
            getCities($(this));
        }else{
            $('.'+$(this).data('location')).html('').html(optHtml);
        }
    });
    $("#shippingForm").validate({
        errorElement: "span",
        errorClass: 'is-invalid',
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            $(".addCost").prop("disabled", true);
            var formData = new FormData($('#shippingForm')[0]);
            $.ajax({
                type: "post",
                data:formData,
                url: baseUrl + 'ajax/addCosts',
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response){
                    if(response.status){
                        showToast('success','Costs','Added successfully');
                       location.href= baseUrl+'admin/shipping-cost';
                    }
                },
                error: function(){
                    $('#shippingForm').trigger('reset');
                    $(".addCost").prop("disabled", false);
                    showToast('error','Error','Something Went Wrong');
                },
                done: function(){

                }
            });
        }
    });
});
$(document).on('click','.deleteCost',function(e){
    e.preventDefault();
    $(this).parent().parent().remove();
});


function populateData(selector){
    var optHtml = '';
    var populatelocation=selector.data('location');
    var selected = $('.'+populatelocation).data('auth') ?? '' ;
    var populatemessage = selector.data('message');
    var populateStr = selector.find('option:selected').data("populate");
    optHtml += (populateStr.length == 0) ?  '<option value="" selected="selected" disabled >No '+populatemessage+'</option>' : '<option value="">Select A '+populatemessage+'</option>';
    for(var key in populateStr){
        var select= (selected && selected==key) ? 'selected' : '';
        optHtml += '<option value="'+key+'" '+select+'>'+populateStr[key]+'</option>';
    }
    $('#'+populatelocation).html('').html(optHtml);
}
function getCountries(selector){
    $.ajax({
        url: baseUrl + 'ajax/getCountries',
            method:'get',
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('#'+selector).html(response.data);
                }else{
                    showToast('error','Error','Something Went Wrong');
                }
            }
    });
}
function getCities(selector){
    var populatelocation=selector.data('location');
    var value = selector.find('option:selected').val();
    $.ajax({
        url: baseUrl + 'ajax/getCities',
            method:'get',
            data:{'state_id':value},
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    $('#'+populatelocation).html(response.data);
                }else{
                    showToast('error','Error','Something Went Wrong');
                }
            }
    });
}
