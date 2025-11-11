var save_method;
var link = "<?php echo site_url('Bpb_master')?>";
var table;

function swal_berhasil() { swal({ title:"SUCCESS", text:"Berhasil", type: "success", closeOnConfirm: true}); }
function swal_error(msg) { swal({ title:"ERROR", text: msg, type: "warning", closeOnConfirm: true});  }

$(document).ready(function(){
    $('#form-add'+mdl).submit(function(e) {
        tinyMCE.triggerSave();
        e.preventDefault(); var formData = new FormData($(this)[0]);
        $.ajax({
            url: $(this).attr("action"), type: 'POST', dataType: 'json', data: formData, async: true,
            beforeSend: function() { $('#spass'+mdl).text('saving...'); $('#spass').attr('disabled',true); },
            success: function(response) {
                if(response.status) { Batal(); reload_table(); swal_berhasil(); $("#ModalBpb"+mdl).modal('hide');
                } else { Batal(); reload_table(); swal_error(response.error); }
            },
            complete: function() { $('#spass'+mdl).text('Tambah'); $('#spass'+mdl).attr('disabled',false); },
            cache: false, contentType: false, processData: false
        });
        return false;
    });

});

$(document).ready(function() {
        table = $('#tableBpb').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "bDestroy": true,
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url":  linke+"Bpb_master/ajax_list",
            "type": "POST"
        },

        //Set column definition initialisation properties.
       responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'asc' ]

    });
 });

function reload_table() {
        table.ajax.reload(null, false);
}

$(document).on('click', '#btnTambah'+mdl, function(){
		save_method = 'add'; 
		$("#ModalBpb"+mdl).modal('show');
});

