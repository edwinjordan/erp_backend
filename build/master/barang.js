var table;

function runningFormatter(value, row, index) {
    return index+1;
}
        // $(document).ready(function(){

        //         $(".btn-hapus").on('click',function(){
        //             confirm('ready');
        //         })
                
        //         // Select2
        //         $('.select2').select2();

        //         // Supplier Delete
        //         $('.btndel').click(function(){11
        //             var idne = $(this).attr('idne');
        //             $("input[name=id]").val(idne);
        //             $('#boostrapModal').modal('show');
        //         });

        //         // Import Excel data barang

        //         $('#import_form').on('submit', function(event){
        //             event.preventDefault();
        //             $.ajax({
        //                 url:linke+"Barang/import_excel",
        //                 method:"POST",
        //                 data:new FormData(this),
        //                 contentType:false,
        //                 cache:false,
        //                 processData:false,
        //                 success:function(data){
        //                     $('#file').val('');
        //                     console.log(data);
        //                     // alert('Import data berhasil !!');
        //                     // document.location.reload();
        //                 }
        //             })
        //         }); 

        //         $('#example1').dataTable();
        //     });
            

            // var count = 0;
            // var countEl = document.getElementById("coly");
            // $('#plus').click(function(){
            //     if(countEl.value > 0){
            //         count = countEl.value
            //     }
            // count++;
            // countEl.value = count;
            // });

            // $('#minus').click(function(){
            //     if(countEl.value > 0){
            //         count = countEl.value
            //     }
            //     if (count > 1) {    
            //     count--;
            //     countEl.value = count;
            // }
            // });
                  
                $(document).ready(function(){  
                    $('#btn-print').on('click',function(){
                        console.log('asdsa');
                    }); 
                    var dataTable = $('#tbl_barang').DataTable({
                        "lengthMenu": [[5, 10, 50, 100, -1], [5, 10, 50, 100, "Semua"]],
                        "stateSave": true,  
                        "processing":true,  
                        "serverSide":true, 
                        "bDestroy": true ,
                        "order":[],  
                        "ajax":{  
                            url:linke+"Barang/list_barang",  
                            type:"POST"  
                        },  
                        "columnDefs":[  
                        {  
                            "targets":[0, 7],  
                            "orderable":false,  
                        },  
                        ],  
                    }).fnDestroy();
                    
                }); 
// $(document).ready(function() {
//             orde1(0,0);
// }); 

// function Fblok() {
//     $("#tbl_barang").dataTable().fnDestroy();
//     orde1($('#id_kelompok'+mdl).val(),$('#id_barang'+mdl).val());
  
// } 

// function orde1(id_blok, id_blok2){
//    // console.log("orde1: "+id_blok);
//     table = $('#tbl_barang').DataTable({

//         "processing": true, //Feature control the processing indicator.
//         "serverSide": true, 
//         "order": [], //Initial no order.

//         // Load data for the table's content from an Ajax source
//         "ajax": {
//             "url": linke+"Barang/ajax_list_barang/"+id_blok+'/'+id_blok2,
//             "type": "POST"
//         },

//         //Set column definition initialisation properties.
//        "columnDefs":[  
//         {  
//            "targets":[0, 5],  
//            "orderable":false,  
//         },  
//         ],  

//     });
//     table.ajax.reload();

//   }                
function actionPeriode(value){
    return '<div class="btn-group"><a href="'+linke+'Barang/detail_data/'+value+'" class="btn btn-primary btn-xs waves-effect waves-light "><span class="glyphicon glyphicon-list"></span> Detail</a><a class="btn btn-xs btn-info waves-effect waves-light" href="'+linke+'Barang/edit_data/'+value+'"><i class="fa fa-fw fa-edit"></i> Ubah</a><a href="'+linke+'Barang/delete_data/'+value+'" onclick="return confirm()" class="btn btn-xs btn-danger waves-effect waves-light" ><i class="fa fa-fw fa-trash"></i> Hapus</a></div>';
}

$("#filter_all").click(function () {
    //var url=linke+"Barang/get_pemasukan_harian/";
    var tgl_1=$("#id_kelompok").val();
    var tgl_2=$("#id_barang").val();
    if (tgl_1 != "" && tgl_2!="") {
      //console.log(url+"?tgl_1="+tgl_1+"&tgl_2="+tgl_2);
           $('#barang_perintah').bootstrapTable('refresh', {url: linke+'Barang/get_barang_tampil/' + tgl_1 + '/' + tgl_2});
          // saldo_asli = 0;
    }else {
      alert('Silahkan Masukkan Tanggal');
    }

});