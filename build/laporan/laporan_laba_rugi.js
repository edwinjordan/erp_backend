function tampil_data(){
    // var kode_pos=$("#kode_pos").val();
    var bulan1=$("#bln1").val();
    var bulan2=$("#bln2").val();
    var tahun=$("#tahun").val();
    // var nama_pos=$("#nama_pos").val(); 
 //   console.log('jenis: '+jenis+' nama: '+nama_pos);
    if(bulan1!="" && bulan2!="" && tahun!=""){
                    $("#result").html("<img style='display: block; margin: 0 auto; text-align: center; ' src='"+linke+"assets/img/ajax-loader.gif'/> ");
                     $.ajax({
                        type:"post",
                        "url": linke+"Laporan/create_laba_rugi/"+bulan1+"/"+bulan2+"/"+tahun,
                        data:{bulan1:bulan1, bulan2:bulan2, tahun:tahun},
                        success:function(data){
                            $("#result").html(data);
                         }
                      });
    }
}