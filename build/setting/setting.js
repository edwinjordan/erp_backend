function swal_berhasil() { swal({ title:"SUCCESS", text:"Berhasil", type: "success", closeOnConfirm: true}); }
function swal_error(msg) { swal({ title:"ERROR", text: msg, type: "warning", closeOnConfirm: true});  }

$(document).ready(function(){
    //$('#idImgLoader').show(2000);
   ubah();
   ubah_hpp(); 
  });

function ubah() {
   // link_edit = "ajax_edit";
    $.ajax({
    url : linke+"/Setup/ajax_edit/",
    type: "GET",
    dataType: "JSON",
    success: function(result) {
  
    $("#BONUS").val(result.set_data1); 
    $("#BATASBOLOS").val(result.set_data2);
    $("#DENDABOLOS").val(result.set_data3);
    $("#UANGMAKAN").val(result.set_data4);		
    $("#MINBONUS").val(result.set_data5);
    $("#PRESENTASEBONUS").val(result.set_data6);		   
                
    }, error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
    }
    });
}

function ubah_hpp() {
    // link_edit = "ajax_edit";
     $.ajax({
     url : linke+"/Setup/ajax_edit_hpp/",
     type: "GET",
     dataType: "JSON",
     success: function(result) {
   
     $("#hpp").val(result.set_data1); 	   
                 
     }, error: function (jqXHR, textStatus, errorThrown) {
         alert('Error get data from ajax');
     }
     });
 }

$(document).on('submit', '#formAksi', function(e) { 
  //  tinyMCE.triggerSave(); 
      e.preventDefault();
			// var link_sub = '<?php echo $this->session->userdata('current_language')=='english'?>';
			// if(link_sub){
			// 	link_edit = "update_link_en";
			// }else{
			// 	link_edit = "update_link";
			// }
        $.ajax({
            url : linke+"/Setup/update_link/",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){                 
                swal_berhasil(); 
                ubah();
                //$('#a7').val();  
                setTimeout(function(){
                    $('#btn_save').text('Ubah');
                    $('#btn_save').attr('disabled', false);
                    //document.getElementById('formAksi').reset();
                }, 1000);

            }           
        });
        return false;
    });

$(document).on('submit', '#formAksi2', function(e) { 
        //  tinyMCE.triggerSave(); 
            e.preventDefault();
                  // var link_sub = '<?php echo $this->session->userdata('current_language')=='english'?>';
                  // if(link_sub){
                  // 	link_edit = "update_link_en";
                  // }else{
                  // 	link_edit = "update_link";
                  // }
              $.ajax({
                  url : linke+"/Setup/update/",
                  type: "POST",
                  data:  new FormData(this),
                  contentType: false,
                  cache: false,
                  processData:false,
                  success: function(data){                 
                      swal_berhasil(); 
                      ubah_hpp();
                      //$('#a7').val();  
                      setTimeout(function(){
                          $('#btn_save').text('Ubah');
                          $('#btn_save').attr('disabled', false);
                          //document.getElementById('formAksi').reset();
                      }, 1000);
      
                  }           
              });
              return false;
});