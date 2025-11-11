var save_method;
var link = "<?php echo site_url('Bpb_master')?>";
var table;

function swal_berhasil() { swal({ title:"SUCCESS", text:"Berhasil", type: "success", closeOnConfirm: true}); }
function swal_error(msg) { swal({ title:"ERROR", text: msg, type: "warning", closeOnConfirm: true});  }

// $(document).ready(function() {
//         table = $('#tableBpb').DataTable({

//         "processing": true, //Feature control the processing indicator.
//         "serverSide": true, //Feature control DataTables' server-side processing mode.
//         "bDestroy": true,
//         "order": [], //Initial no order.

//         // Load data for the table's content from an Ajax source
//         "ajax": {
//             "url":  linke+"Setting_harga/ajax_list",
//             "type": "POST"
//         },

//         //Set column definition initialisation properties.
//        responsive: {
//             details: {
//                 type: 'column'
//             }
//         },
//         columnDefs: [ {
//             className: 'control',
//             orderable: false,
//             targets:   0
//         } ],
//         order: [ 1, 'asc' ]

//     });
//  });
$(document).ready(function() {
            orde1(0);
}); 

function Fblok() {
    $("#tableBpb").dataTable().fnDestroy();
    orde1($('#id_kelompok'+mdl).val());
} 

function orde1(id_blok){
   // console.log("orde1: "+id_blok);
    table = $('#tableBpb').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, 
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": linke+"Setting_harga/ajax_list/"+id_blok,
            "type": "POST"
        },

        //Set column definition initialisation properties.
       "columnDefs":[  
        {  
           "targets":[0, 6],  
           "orderable":false,  
        },  
        ],  

    });
    table.ajax.reload();

  }
  
function reload_table() {
    table.ajax.reload(null, false);
}

