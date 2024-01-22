var baseUrl = APP_URL + '/';
var userType = userType ?? '';
var change = $('.loaddata').find(":selected").val();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let pageDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'title', name: 'title',sClass: 'w-50' },
    { data: 'slug', name: 'slug',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let fareDataColumn = [
    { data: 'category', name: 'category',sClass: 'w-50' },
    { data: 'hours_range', name: 'hours_range',sClass: 'w-50' },
    { data: 'amount', name: 'amount',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}
];
let helperFareDataColumn = [
    { data: 'amount', name: 'amount',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}
];
let vehicleDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'info', name: 'info',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let vehicleTypeDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'image', name: 'image',sClass: 'w-50' },
    { data: 'type', name: 'type',sClass: 'w-50' },
    // { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let companyDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let zoneDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let membershipDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'duration', name: 'duration',sClass: 'w-50' },
    { data: 'price', name: 'price',sClass: 'w-50' },
    { data: 'active-users', name: 'active-users',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let questionDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'issues', name: 'issues',sClass: 'w-50' },
    { data: 'type', name: 'type',sClass: 'w-50' },
    // { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let orderDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'user', name: 'user',sClass: 'w-50' },
    { data: 'order_no', name: 'order_no',sClass: 'w-50' },
    { data: 'delivery_status', name: 'delivery_status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let categoryDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    // { data: 'picture', name: 'picture',sClass: 'w-50' },
    // { data: 'parent_category', name: 'parent_category',sClass: 'w-50' },
    { data: 'status', name: 'status', sClass: 'w-50' },
    { data: 'action', name: 'action', sClass: 'w-20',sorting:false}

];
let deskAdminDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'email', name: 'email',sClass: 'w-50' },
    { data: 'mobile_number', name: 'mobile_number',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
];
let userDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'contact', name: 'contact',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
    { data: 'action', name: 'action',sorting:false}
];
let driverDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name', sClass: 'w-50' },
    { data: 'contact', name: 'contact', sClass: 'w-20' },
    // { data: 'vehicleType', name: 'vehicleType', sClass: 'w-50' },
    { data: 'walletBalance', name: 'walletBalance', sClass: 'w-10' },
    { data: 'registrationDate', name: 'registrationDate', sClass: 'w-10' },
    { data: 'branding', name: 'branding', sClass: 'w-50' },
    { data: 'approveStatus', name: 'approveStatus', sClass: 'w-10' },
    { data: 'status', name: 'status', sClass: 'w-10' },
    { data: 'action', name: 'action', sorting:false}
];
let customerDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'contact', name: 'contact',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
    { data: 'action', name: 'action',sorting:false}
];
let councilDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
    { data: 'action', name: 'action',sorting:false}
];
let agentDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
    { data: 'action', name: 'action',sorting:false}
];

let attributeDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
    { data: 'action', name: 'action',sClass: 'w-50' },
];
let roleDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'action', name: 'action',sClass: 'w-50' },
];
let groupDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'set', name: 'set',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
    { data: 'action', name: 'action',sClass: 'w-50' },
];
let brandDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-25' },
    { data: 'picture', name: 'picture',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
    { data: 'action', name: 'action',sClass: 'w-50' },
];
let productDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-25' },
    { data: 'category', name: 'category',sClass: 'w-50' },
    { data: 'brand', name: 'brand',sClass: 'w-25' },
    { data: 'price', name: 'price',sClass: 'w-25' },
    { data: 'status', name: 'status',sClass: 'w-25' },
    { data: 'action', name: 'action',sClass: 'w-50' },
];
let transactionsDataColumn = [
    { data: 'sr', name: 'sr'},
    { data: 'txnId', name: 'txnId',sClass: 'w-50' },
    { data: 'amount', name: 'amount',sClass: 'w-40' },
];
let bookingDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'patient', name: 'patient', sClass: 'w-30' },
    { data: 'doctor', name: 'doctor', sClass: 'w-30' },
    { data: 'issue', name: 'issue', sClass: 'w-20' },
    { data: 'bookingDate', name: 'bookingDate', sClass: 'w-20' },
    { data: 'amount', name: 'amount', sClass: 'w-10' },
    { data: 'status', name: 'status', sClass: 'w-10' },
    { data: 'action', name: 'action', sorting:false}
];
let referralDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name', sClass: 'w-40' },
    { data: 'mobile_number', name: 'mobile_number', sClass: 'w-40' },
    { data: 'ibd_number', name: 'ibd_number' },
    { data: 'referred_user', name: 'referred_user' },
    { data: 'reference_type', name: 'reference_platform' },
    { data: 'reference_platform', name: 'reference_platform' },
    { data: 'action', name: 'action', sorting:false}
];
let issueDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name' },
    { data: 'type', name: 'type' },
    { data: 'action', name: 'action',sClass: 'w-20',sorting:false}
];
let doctorAvailabilityDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name' },
    { data: 'availability', name: 'availability' },
    { data: 'action', name: 'action',sClass: 'w-20',sorting:false}
];
let userColumn = userDataColumn;
let searchPlaceholderText = "Search by name, email, phone number";
switch(userType){
    case 'attendee':
        userColumn = attendeeDataColumn;
        break;
    case 'driver':
        userColumn = driverDataColumn;
        searchPlaceholderText = "Search by name, phone number, email";
        break;
}
let userTable = $('#userTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        "lengthMenu": "Counts per page:_MENU_",
        searchPlaceholder: searchPlaceholderText
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getUsers/' + userType,
        dataType: "json",
        type: "get",
        data: function (d) {
            return $.extend({}, d, {
                "status": $(".loaddata").find(":selected").val() ?? 'all',
                "vtype": $("#userTable").data("vtype") ?? '',
                'is_registered': 1
            });
        },
    },
    columns: userColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-3" l><".col-span-12 lg:col-span-9 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    },
    // buttons: ["excel"],
    initComplete: function () {
        $('.status-div').appendTo('#userTable_wrapper .col-span-12:eq(1)');
        $('.export-div').appendTo('#userTable_wrapper .col-span-12:eq(1)');
        // userTable.buttons().container().appendTo('#userTable_wrapper .col-span-12:eq(1)');
    },
});
let customerTable = $('#customerTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        "lengthMenu": "Counts per page_MENU_",
        searchPlaceholder: "Search by phone number , name , email"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getUsers/customer',
        dataType: "json",
        type: "get",
    },
    columns: customerDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
let councilTable = $('#councilTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        "lengthMenu": "Counts per page_MENU_",
        searchPlaceholder: "Search by name , email"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getUsers/council',
        dataType: "json",
        type: "get",
    },
    columns: councilDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
let membershipTable = $('#membershipTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        "lengthMenu": "Counts per page_MENU_",
        searchPlaceholder: "Search by name,amount,duration"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getMemberships',
        dataType: "json",
        type: "get",
    },
    columns: membershipDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
let agentTable = $('#agentTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        "lengthMenu": "Counts per page_MENU_",
        searchPlaceholder: "Search by name , email"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getUsers/agent',
        dataType: "json",
        type: "get",
    },
    columns: agentDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active== true){
            $(row).addClass('block-disable');
        }
    }
});
let orderTable = $('#orderTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by order no,user name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getOrders',
        dataType: "json",
        type: "get",
    },
    columns: orderDataColumn,
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f>>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
});
let pageTable = $('#pagesTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name or title or slug"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getPages',
        dataType: "json",
        type: "get",

    },
    columns: pageDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});

let faresTable = $('#faresTable').DataTable({
    responsive: true,
    searching: false,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name or title or slug"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getFares',
        dataType: "json",
        type: "get",

    },
    columns: fareDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
let roleTable = $('#rolesTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getRoles',
        dataType: "json",
        type: "get",

    },
    columns: roleDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
let questionTable = $('#questionsTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by question, issues"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getQuestions',
        dataType: "json",
        type: "get",

    },
    columns: questionDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
$('#categoriesTable').each(function(i) {
    let type = $(this).data('type');
    var categoriesTable = $(this).DataTable({
        responsive: true,
        searching: true,
        lengthChange: true,
        "language": {
            lengthMenu: "Counts per page_MENU_",
            searchPlaceholder: "Search by name"
        },
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl + 'ajax/getCategories/?type='+type,
            dataType: "json",
            type: "get",

        },
        columns: categoryDataColumn,
        dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
        "ordering": true,
        "fnDrawCallback": function(oSettings) {
            let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
            oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
        },
        "createdRow": function (row, data, dataIndex) {
            $(row).addClass('manage-enable');
            if(data.is_active){
                $(row).addClass('block-disable');
            }
        }
    });
});
var attributesTable = $('#attributesTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getAttributes',
        dataType: "json",
        type: "get",

    },
    columns: attributeDataColumn,
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f>>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
var tagTable = $('#tagsTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getTags',
        dataType: "json",
        type: "get",

    },
    columns: attributeDataColumn,
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f>>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
var groupTable = $('#groupsTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getGroups',
        dataType: "json",
        type: "get",

    },
    columns: groupDataColumn,
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f>>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
var brandsTable = $('#brandsTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getBrands',
        dataType: "json",
        type: "get",

    },
    columns: brandDataColumn,
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f>>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
var productsTable = $('#productsTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name,category,brand"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getProducts',
        dataType: "json",
        type: "get",

    },
    columns: productDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
$(document).ready(function () {
    $('.dataTables_filter input[type="search"]').css({
        'width': '350px',
        'display': 'inline-block',
        'margin': '20px 0px 6px 10px',
     });
    $('.loaddata').change(function () {
        change = $(this).find(":selected").val();
        //if (change) {
            if ($(this).hasClass('statusDropdown')) {
                let currentUrl = location.protocol + '//' + location.host + location.pathname;
                if(change != 'all'){
                    currentUrl += '?status='+change;
                }
                console.log(currentUrl);
                window.location.href = currentUrl;
            }
            if ($(this).hasClass('bookingStatusDropdown')) {
                let currentUrl = location.protocol + '//' + location.host + '/booking/list';
                if(change != 'all'){
                    currentUrl += '/'+change;
                }
                window.location.href = currentUrl;
            }
        //}
    });
    $('.search').on('keydown',function (e) {
        userTable.ajax.reload();
    });
})


let companiesTable = $('#companiesTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getCompanies',
        dataType: "json",
        type: "get",

    },
    columns: companyDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});

let zoneTable = $('#zonesTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getZones',
        dataType: "json",
        type: "get",

    },
    columns: zoneDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});

let vehicleTable = $('#vehiclesTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by vehicle number or company name",
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getVehicles',
        dataType: "json",
        type: "get",

    },
    columns: vehicleDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});

let vehicleTypesTable = $('#vehicleTypesTable').DataTable({
    responsive: true,
    searching: false,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by type",
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getVehicleTypes/' + $('#vehicleTypesTable').data('uuid'),
        dataType: "json",
        type: "get",

    },
    columns: vehicleTypeDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
let vehicleBodyTypesTable = $('#vehicleBodyTypesTable').DataTable({
    responsive: true,
    searching: false,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by type",
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getVehicleBodyTypes/' + $('#vehicleBodyTypesTable').data('uuid'),
        dataType: "json",
        type: "get",

    },
    columns: vehicleTypeDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});

let helperFaresTable = $('#helperFaresTable').DataTable({
    responsive: true,
    searching: false,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by name or title or slug"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getHelperFares',
        dataType: "json",
        type: "get",

    },
    columns: helperFareDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
$('#container-helper-fare-edit').hide();
$(document).on('click', '.helper_fare_edit_btn', function(){
    let data = JSON.parse($(this).attr('data-value'));
    // console.log(data);
    $('#helper_fare_edit_id').val(data.id);
    $('#helper_fare_edit_amount').val(data.amount);
    $('#container-helper-fare-edit').show();
})
$(document).on('click', '.helper_fare_edit_btn_hide', function(){
    $('#container-helper-fare-edit').hide();
})

let transactionsTable = $('#transactionsTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by transaction id, date, amount or debit / credit"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getWalletTransactions',
        dataType: "json",
        type: "get",
        data: function (d) {
            return $.extend({}, d, {
                "user_uuid": $('#transactionsTable').data("user_uuid")
            });
        }
    },
    columns: transactionsDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" l><".col-span-12 lg:col-span-6 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});

let bookingTable = $('#bookingTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        "lengthMenu": "Counts per page:_MENU_",
        searchPlaceholder: "Search by patient's name, doctor's name, issue"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    // pageLength: 10,
    ajax: {
        url: baseUrl + 'ajax/getBookings/' + $('#bookingTable').data("status"),
        dataType: "json",
        type: "get",
        data: function (d) {
            return $.extend({}, d, {
                "status": $(".loaddata").find(":selected").val() ?? 'all',
                "daterange": $(".daterange-div .daterange").val()
            });
        },
    },
    columns: bookingDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-3" l><".col-span-12 lg:col-span-9 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    },
    // buttons: ["excel"],
    initComplete: function () {
        $('.status-div').appendTo('#bookingTable_wrapper .col-span-12:eq(1)');
        // $('.export-div').appendTo('#bookingTable_wrapper .col-span-12:eq(1)');
    },
});
$('.daterange-div input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
    bookingTable.ajax.reload();
});
$('.daterange-div input[name="daterange"]').on('change', function (ev) {
    bookingTable.ajax.reload();
});
let referralsTable = $('#referralsTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        "lengthMenu": "Counts per page:_MENU_",
        searchPlaceholder: "Search by id, referred by, mobile, IBD number, referred user, type, platform."
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    // pageLength: 10,
    ajax: {
        url: baseUrl + 'ajax/getReferrals',
        dataType: "json",
        type: "get",
        data: function (d) {
            return $.extend({}, d, {
                "status": $(".loaddata").find(":selected").val() ?? 'all',
                "daterange": $(".daterange-div .daterange").val()
            });
        },
    },
    columns: referralDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-3" l><".col-span-12 lg:col-span-9 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    },
    // buttons: ["excel"],
    initComplete: function () {
        $('.status-div').appendTo('#referralsTable_wrapper .col-span-12:eq(1)');
    },
});
let issuesTable = $('#issuesTable').DataTable({
    responsive: true,
    searching: false,
    lengthChange: false,
    "language": {
        "lengthMenu": "Counts per page:_MENU_",
        searchPlaceholder: "Search by name, type"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getIssues',
        dataType: "json",
        type: "get",
    },
    columns: issueDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-4" l><".col-span-12 lg:col-span-8 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});

let availabilitiesTable = $('#availabilitiesTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: false,
    "language": {
        "lengthMenu": "Counts per page:_MENU_",
        searchPlaceholder: "Search by doctor's name"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getDoctorAvailabilities',
        dataType: "json",
        type: "get",
    },
    columns: doctorAvailabilityDataColumn,
    dom: '<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-4" l><".col-span-12 lg:col-span-8 text-right" f >>t<".grid grid-cols-12 gap-6"<".col-span-12 lg:col-span-6" i><".col-span-12 lg:col-span-6 text-right"p>>',
    "ordering": true,
    "fnDrawCallback": function(oSettings) {
        let pagination = $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info,.dataTables_length');
        oSettings._iDisplayLength > oSettings.fnRecordsDisplay() ? pagination.hide() : pagination.show();
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('manage-enable');
        if(data.is_active){
            $(row).addClass('block-disable');
        }
    }
});
