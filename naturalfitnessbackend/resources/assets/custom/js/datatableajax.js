var baseUrl = APP_URL + '/';
var userType = userType ?? '';
var change = $('.loaddata').find(":selected").val();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let pageDataColumn= [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'title', name: 'title',sClass: 'w-50' },
    { data: 'slug', name: 'slug',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let orderDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'user', name: 'user',sClass: 'w-50' },
    { data: 'order_no', name: 'order_no',sClass: 'w-50' },
    { data: 'delivery_status', name: 'delivery_status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let purchaseOrderDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'order_no', name: 'order_no'},
    { data: 'user', name: 'user',sClass: 'w-50' },
    { data: 'email', name: 'email',sClass: 'w-50' },
    { data: 'contact', name: 'contact',sClass: 'w-50' },
    { data: 'request', name: 'request',sClass: 'w-50' },
    { data: 'quantity', name: 'quantity',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let categoryDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'picture', name: 'picture',sClass: 'w-50' },
    { data: 'parent_category', name: 'parent_category',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-50' },
    { data: 'action', name: 'action',sorting:false}

];
let deskAdminDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'email', name: 'email',sClass: 'w-50' },
    { data: 'mobile_number', name: 'mobile_number',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
];

let attributeDataColumn = [
    { data: 'id', name: 'id'},
    { data: 'name', name: 'name',sClass: 'w-50' },
    { data: 'status', name: 'status',sClass: 'w-25' },
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
let userTable = $('#userTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        "lengthMenu": "Counts per page_MENU_",
        searchPlaceholder: "Search By phone number , name, official id , email"
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
                "is_active": $(".loaddata").find(":selected").val() ?? ''
            });
        },
    },
    columns: userType== 'attendee' ? attendeeDataColumn : deskAdminDataColumn,
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f >>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
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
let purchaseOrderTable = $('#purchaseOrderTable').DataTable({
    responsive: true,
    searching: true,
    lengthChange: true,
    "language": {
        lengthMenu: "Counts per page_MENU_",
        searchPlaceholder: "Search by user's name, contact or email"
    },
    autoWidth: false,
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + 'ajax/getPurchaseOrders',
        dataType: "json",
        type: "get",
    },
    columns: purchaseOrderDataColumn,
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
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f>>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
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
var categoriesTable = $('#categoriesTable').DataTable({
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
        url: baseUrl + 'ajax/getCategories',
        dataType: "json",
        type: "get",

    },
    columns: categoryDataColumn,
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f>>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
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
        if(data.is_active== true){
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
        if(data.is_active== true){
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
        if(data.is_active== true){
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
        if(data.is_active== true){
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
    dom: '<".d-flex"<".col-6" l><".col-6 text-right" f>>t<".d-flex"<".col-6" i><".col-6 text-right"p>>',
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
$(document).ready(function () {
    $('.dataTables_filter input[type="search"]').css({
        'width': '400px',
        'display': 'inline-block',
        'margin': '24px -12px 6px 10px',
     });
    $('.loaddata').change(function () {
        change = $(this).find(":selected").val();
        if (change) {
            if ($(this).hasClass('statusDropdown')) {
                userTable.ajax.reload();
            }
        }
    });
    $('.search').on('keydown',function (e) {
        userTable.ajax.reload();
    });
})




