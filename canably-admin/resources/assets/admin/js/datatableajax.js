var baseUrl = APP_URL + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var roledataColumn = [
    { data: 'sr', name: 'sr' },
    { data: 'name', name: 'name' },
    { data: 'short_code', name: 'short_code' },
    { data: 'role_type', name: 'role_type' },
    { data: 'action', name: 'action' },
];
var roleTable= $('#roleTable').DataTable({
                responsive: true,
                searching: false,
                lengthChange: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: baseUrl+'ajax/getRoles',
                    dataType: "json",
                    type: "get",
                    // data:function ( d ) {
                    //     return $.extend( {}, d, {
                    //         "search": $(".loaddata").val() ?? ''
                    //     } );
                    // },
                },

                columns:roledataColumn,
                "ordering": true,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                // initComplete: function () {
                //     roleTable.buttons().container().appendTo('#roleTable_wrapper .col-md-6:eq(0)');
                // },
                "fnDrawCallback": function(oSettings) {
                    // $("input[data-bootstrap-switch]").each(function(){
                    //     $(this).bootstrapSwitch();
                    // });
                    if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                        $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info').hide();
                    } else {
                        $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info').show();
                    }
                }
            });
var permissiondataColumn = [
    { data: 'sr', name: 'sr' },
    { data: 'name', name: 'name' },
    { data: 'slug', name: 'slug' }
];
var permissionTable= $('#permissionTable').DataTable({
                responsive: true,
                searching: true,
                lengthChange: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: baseUrl+'ajax/getPermissions',
                    dataType: "json",
                    type: "get",
                    // data:function ( d ) {
                    //     return $.extend( {}, d, {
                    //         "search": $(".loaddata").val() ?? ''
                    //     } );
                    // },
                },

                columns:permissiondataColumn,
                "ordering": true,
                // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                // initComplete: function () {
                //     roleTable.buttons().container().appendTo('#roleTable_wrapper .col-md-6:eq(0)');
                // },
                "fnDrawCallback": function(oSettings) {
                    // $("input[data-bootstrap-switch]").each(function(){
                    //     $(this).bootstrapSwitch();
                    // });
                    if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                        $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info').hide();
                    } else {
                        $(oSettings.nTableWrapper).find('.dataTables_paginate,.dataTables_info').show();
                    }
                }
            });




