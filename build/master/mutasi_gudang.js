function tampil_tambah(){
	$('[id="kode_keranjang"]').val('');

    $('[id="jumlah_barang"]').val('');
    var list_barang = '<input type="text" name="ambil_get_barang" id="ambil_get_barang" onclick="get_barang()" class="form-control" readonly><input type="hidden" id="ambil_get_kode" name="ambil_get_kode">';
    var e = document.getElementById("list_barang"+mdl);
    e.innerHTML= list_barang;
    document.getElementById('list_barang'+mdl).style.display = "block";

	var lokasine = "<select autofocus onchange='javascript:valueselectsatuan()' class='form-control' name='kode_lokasi' id='kode_lokasi'>";

    var lokasine_asal = "<select autofocus class='form-control' name='kode_lokasi_asal' id='kode_lokasi_asal'>";

	$.getJSON(linke+'Mutasi_gudang/lokasinenya/', {
		            format: "json"
		        })
	            .done(function (data1) {
	            	$.each(data1, function (key, val) {
	            		lokasine += '<option value="'+val.id_lokasi+'">'+val.nama_lokasi+'</option>';
	            	});
	            	lokasine += '</select>';
	            	var eaaa = document.getElementById("barangas"+mdl);
		        	eaaa.innerHTML= lokasine;
			      	document.getElementById('barangas'+mdl).style.display = "block";


			      	$.each(data1, function (key, val) {
	            		lokasine_asal += '<option value="'+val.id_lokasi+'">'+val.nama_lokasi+'</option>';
	            	});
	            	lokasine_asal += '</select>';
	            	var eaaa = document.getElementById("barangas_asal"+mdl);
		        	eaaa.innerHTML= lokasine_asal;
			      	document.getElementById('barangas_asal'+mdl).style.display = "block";
	            })

	$('#modal-2'+mdl).modal('show');
}	

function get_barang(){
	$('#get_barang'+mdl).modal('show');
}

function actionpilihbarang(value, row, index){
	var str = row.nama_barang;
	var res = str.replace('"', '|');
	res = res.replace('"', '|');
	return '<div class="btn-group" role="group" aria-label="...">'
	+'<a href="#" onclick="pilihDatabarang('+row.id_barang+',\''+res+'\')" class="btn btn-success">Pilih</a></div>';
}

function runningFormatter(value, row, index) {
   return index+1;
}

function pilihDatabarang(kode, nama){
	var res = nama.replace('|', '"');
	res = res.replace('|', '"');
	document.getElementById('ambil_get_kode').value = kode;
	document.getElementById('ambil_get_barang').value = res;

	var id = kode;
	var okey = '<div class="col-xs-12"><div class="col-xs-6"><div class="form-group">Satuan Barang Asal</div></div><div class="col-xs-6"><div class="form-group"><select name="kode_konversi" onchange="javascript:valueselectsatuan()" id="kode_konversi"  class="form-control"   >';
		$.getJSON(linke+'Mutasi_gudang/coba_akses_barang_satuan/'+id, {
            format: "json"
    })

	.done(function (data) {
                $.each(data, function (key, val) {
                	
                		okey += '<option value="' + val.id_varian_harga + '" >' + val.satuan +'</option>';
                	
                	
                });
                okey += '</select></div></div></div>';
               // console.log(okey);
                var e = document.getElementById("showedit");
	        	e.innerHTML= okey;
		      	document.getElementById('showedit').style.display = "block";

		      	var ie = document.getElementById('kode_lokasi');
                var ide = ie.options[ie.selectedIndex].value;
                $.ajax({
		            url : linke+"Mutasi_gudang/ajax_jumlah/" + id+"/"+ide,
		            type: "GET",
		            dataType: "JSON",
		            success: function(data_max)
		            {
		            	var iea = document.getElementById('kode_konversi');
		        		var idea = iea.options[iea.selectedIndex].value;

		            	$.ajax({
				            url : linke+"Mutasi_gudang/ajax_konversi/" +idea+"/"+ide,
				            type: "GET",
				            dataType: "JSON",
				            success: function(dataeer)
				            {
				            	//if(dataeer.identitas_konversi==1){
				            		//$('#jumlah_barang').attr('max',data_max.stok_gudang);
				            		if(dataeer==null){
										var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok :0';
					            	}else{
					            		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+dataeer.stok_gudang;
					            	}
				            		//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+data_max.stok_gudang;
				            		var edddd = document.getElementById("max_jml");
									edddd.innerHTML= okeyhistroy;
								  	document.getElementById('max_jml').style.display = "block";
				            	//}
				            	
				            	//document.getElementById('jumlah_barang').value = dataee.jumlah*dataeer.jumlah_konversi;
				            },
				    			error: function (jqXHR, textStatus, errorThrown)
				    		{
				        		alert('Error get data from ajax');
				    		}
						});

		     //        	if(data_max==null){
							// var okeyhistroy = '';
		     //        	}else{
		     //        		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+data_max.stok_gudang;
		     //        	}

		      //       			$('#jumlah_barang').attr('max',data_max.stok_gudang);

		      //       			if(data_max==null){
								// 	var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : 0';
				    //         	}else{
				    //         		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+data_max.stok_gudang;
				    //         	}
				    //         	//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+stok;
				    //         	var edddd = document.getElementById("max_jml");
				    //         	edddd.innerHTML= okeyhistroy;
								// document.getElementById('max_jml').style.display = "block";

			
		            },
            			error: function (jqXHR, textStatus, errorThrown)
            		{
                		alert('Error get data from ajax');
            		}
        		});
             })		
	// onchange="javascript:valueselectsatuan()"
	var okey2 = '<div class="col-xs-12"><div class="col-xs-6"><div class="form-group">Satuan Barang Tujuan</div></div><div class="col-xs-6"><div class="form-group"><select name="kode_konversi2"  id="kode_konversi2" onchange="javascript:valueselectsatuan2()" class="form-control"   >';
		$.getJSON(linke+'Mutasi_gudang/coba_akses_barang_satuan/'+id, {
            format: "json"
    })

	.done(function (data) {
                $.each(data, function (key, val) {
                	
                		okey2 += '<option value="' + val.id_varian_harga + '" >' + val.satuan +'</option>';
                	
                	
                });
                okey2 += '</select></div></div></div>';
               // console.log(okey);
                var e = document.getElementById("showedit2");
	        	e.innerHTML= okey2;
		      	document.getElementById('showedit2').style.display = "block";

		      	var ie = document.getElementById('kode_lokasi_asal');
                var ide = ie.options[ie.selectedIndex].value;
                $.ajax({
		            url : linke+"Mutasi_gudang/ajax_jumlah/" + id+"/"+ide,
		            type: "GET",
		            dataType: "JSON",
		            success: function(data_max)
		            {
		            	var iea = document.getElementById('kode_konversi2');
		        		var idea = iea.options[iea.selectedIndex].value;

		            	$.ajax({
				            url : linke+"Mutasi_gudang/ajax_konversi/" + idea+"/"+ide,
				            type: "GET",
				            dataType: "JSON",
				            success: function(dataeer)
				            {
				            	//if(dataeer.identitas_konversi==1){
				            		//$('#jumlah_barang').attr('max',data_max.stok_gudang);
				            		if(dataeer==null){
										var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok :0';
					            	}else{
					            		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+dataeer.stok_gudang;
					            	}
				            		//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+data_max.stok_gudang;
				            		var edddd = document.getElementById("max_jml2");
									edddd.innerHTML= okeyhistroy;
								  	document.getElementById('max_jml2').style.display = "block";
				            	//}
				            	
				            	//document.getElementById('jumlah_barang').value = dataee.jumlah*dataeer.jumlah_konversi;
				            },
				    			error: function (jqXHR, textStatus, errorThrown)
				    		{
				        		alert('Error get data from ajax');
				    		}
						});

		     //        	if(data_max==null){
							// var okeyhistroy = '';
		     //        	}else{
		     //        		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+data_max.stok_gudang;
		     //        	}

		      //       			$('#jumlah_barang').attr('max',data_max.stok_gudang);

		      //       			if(data_max==null){
								// 	var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : 0';
				    //         	}else{
				    //         		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+data_max.stok_gudang;
				    //         	}
				    //         	//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+stok;
				    //         	var edddd = document.getElementById("max_jml");
				    //         	edddd.innerHTML= okeyhistroy;
								// document.getElementById('max_jml').style.display = "block";

			
		            },
            			error: function (jqXHR, textStatus, errorThrown)
            		{
                		alert('Error get data from ajax');
            		}
        		});
             })		

	$('#get_barang'+mdl).modal('hide');
}	

function valueselectsatuan(){
		//var i = document.getElementById('kode_barang');
    	//var id = i.options[i.selectedIndex].value;

    	var id = document.getElementById('ambil_get_kode').value;
        var ie = document.getElementById('kode_lokasi');
        var ide = ie.options[ie.selectedIndex].value;

        $.ajax({
            url : linke+"Mutasi_gudang/ajax_jumlah/" + id+"/"+ide,
            type: "GET",
            dataType: "JSON",
            success: function(dataee)
            {

            	var iea = document.getElementById('kode_konversi');
        		var idea = iea.options[iea.selectedIndex].value;

            	$.ajax({
		            url : linke+"Mutasi_gudang/ajax_konversi/" +idea+"/"+ide,
		            type: "GET",
		            dataType: "JSON",
		            success: function(dataeer)
		            {
		            	//if(dataeer.identitas_konversi==1){
		            		//$('#jumlah_barang').attr('max',dataee.stok_gudang);
		            		if(dataeer==null){
										var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok :0';
					            	}else{
					            		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+dataeer.stok_gudang;
					            	}
		            		//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+dataee.stok_gudang;
		            		var edddd = document.getElementById("max_jml");
							edddd.innerHTML= okeyhistroy;
						  	document.getElementById('max_jml').style.display = "block";
		            	//}
		            	
		            	//document.getElementById('jumlah_barang').value = dataee.jumlah*dataeer.jumlah_konversi;
		            },
		    			error: function (jqXHR, textStatus, errorThrown)
		    		{
		        		alert('Error get data from ajax');
		    		}
				});
    //         	$('#jumlah_barang').attr('max',dataee.stok_gudang);
		  //       var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+dataee.stok_gudang;
		  //       var edddd = document.getElementById("max_jml");
				// edddd.innerHTML= okeyhistroy;
				// document.getElementById('max_jml').style.display = "block";
   
            },
    			error: function (jqXHR, textStatus, errorThrown)
    		{
        		alert('Error get data from ajax');
    		}
		});
              
}

function valueselectsatuan2(){
		//var i = document.getElementById('kode_barang');
    	//var id = i.options[i.selectedIndex].value;

    	var id = document.getElementById('ambil_get_kode').value;
        var ie = document.getElementById('kode_lokasi_asal');
        var ide = ie.options[ie.selectedIndex].value;

        $.ajax({
            url : linke+"Mutasi_gudang/ajax_jumlah/" + id+"/"+ide,
            type: "GET",
            dataType: "JSON",
            success: function(dataee)
            {

            	var iea = document.getElementById('kode_konversi2');
        		var idea = iea.options[iea.selectedIndex].value;

            	$.ajax({
		            url : linke+"Mutasi_gudang/ajax_konversi/" +idea+"/"+ide,
		            type: "GET",
		            dataType: "JSON",
		            success: function(dataeer)
		            {
		            	//if(dataeer.identitas_konversi==1){
		            		//$('#jumlah_barang').attr('max',dataee.stok_gudang);
		            		if(dataeer==null){
										var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok :0';
					            	}else{
					            		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+dataeer.stok_gudang;
					            	}
		            		//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+dataee.stok_gudang;
		            		var edddd = document.getElementById("max_jml2");
							edddd.innerHTML= okeyhistroy;
						  	document.getElementById('max_jml2').style.display = "block";
		            	//}
		            	
		            	//document.getElementById('jumlah_barang').value = dataee.jumlah*dataeer.jumlah_konversi;
		            },
		    			error: function (jqXHR, textStatus, errorThrown)
		    		{
		        		alert('Error get data from ajax');
		    		}
				});
    //         	$('#jumlah_barang').attr('max',dataee.stok_gudang);
		  //       var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+dataee.stok_gudang;
		  //       var edddd = document.getElementById("max_jml");
				// edddd.innerHTML= okeyhistroy;
				// document.getElementById('max_jml').style.display = "block";
   
            },
    			error: function (jqXHR, textStatus, errorThrown)
    		{
        		alert('Error get data from ajax');
    		}
		});
              
}

function valueselecttujuan(){
// 		var i = document.getElementById('kode_barang');
//         var id = i.options[i.selectedIndex].value;
        var id = document.getElementById('ambil_get_kode').value;
		var ie = document.getElementById('kode_lokasi');
        var ide = ie.options[ie.selectedIndex].value;

        $.ajax({
            url : linke+"Mutasi_gudang/ajax_jumlah/" + id+"/"+ide,
            type: "GET",
            dataType: "JSON",
            success: function(data_max)
            {

            	var iea = document.getElementById('kode_konversi');
        		var idea = iea.options[iea.selectedIndex].value;

            	$.ajax({
		            url : linke+"Mutasi_gudang/ajax_konversi/" + id+"/"+idea,
		            type: "GET",
		            dataType: "JSON",
		            success: function(dataeer)
		            {
		     //        	if(dataeer.identitas_konversi==1){
		     //        		$('#jumlah_barang').attr('max',data_max.jumlah);
		     //        		var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+data_max.jumlah;
		     //        		var edddd = document.getElementById("max_jml");
							// edddd.innerHTML= okeyhistroy;
						 //  	document.getElementById('max_jml').style.display = "block";
		     //        	}else if(dataeer.identitas_konversi==2){
		     //        		$('#jumlah_barang').attr('max',data_max.jumlah/dataeer.jumlah_konversi);
		     //        		var pakai = parseInt(data_max.jumlah)/parseInt(dataeer.jumlah_konversi);
		     //        		var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+pakai;
		     //        		var edddd = document.getElementById("max_jml");
							// edddd.innerHTML= okeyhistroy;
						 //  	document.getElementById('max_jml').style.display = "block";
		     //        	}else{
		     //        		$.ajax({
					  //           url : "<?php echo site_url('penjualan/ajax_konversi_identitas_satu/')?>" + id,
					  //           type: "GET",
					  //           dataType: "JSON",
					  //           success: function(dataeerg)
					  //           {
					  //           	$('#jumlah_barang').attr('max',data_max.jumlah/dataeerg.jumlah_konversi);
					  //           	var pakai = parseInt(data_max.jumlah)/parseInt(dataeerg.jumlah_konversi);
					  //           	var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+pakai;
				   //          		var edddd = document.getElementById("max_jml");
							// 		edddd.innerHTML= okeyhistroy;
							// 	  	document.getElementById('max_jml').style.display = "block";
					  //           },
					  //   			error: function (jqXHR, textStatus, errorThrown)
					  //   		{
					  //       		alert('Error get data from ajax');
					  //   		}
					  //   	});
		     //        	}
		     				if(dataeer==null){
										var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok :0';
					            	}else{
					            		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+dataeer.stok_gudang;
					            	}
		            		//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+dataee.stok_gudang;
		            		var edddd = document.getElementById("max_jml");
							edddd.innerHTML= okeyhistroy;
						  	document.getElementById('max_jml').style.display = "block";
		            	
		            	//document.getElementById('jumlah_barang').value = dataee.jumlah*dataeer.jumlah_konversi;
		            },
		    			error: function (jqXHR, textStatus, errorThrown)
		    		{
		        		alert('Error get data from ajax');
		    		}
				});
            	if(data_max==null){
					var okeyhistroy = '';
            	}else{
            		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+data_max.jumlah;
            	}
            	
				//var edddd = document.getElementById("max_jml");
				//edddd.innerHTML= okeyhistroy;
			  	//document.getElementById('max_jml').style.display = "block";
            	//document.getElementById('jumlah_barang').value = data_max.jumlah;
            	//$('#jumlah_barang').attr('max',data_max.jumlah);
            },
    			error: function (jqXHR, textStatus, errorThrown)
    		{
        		alert('Error get data from ajax');
    		}
		});
	}

	function actionPeriode(value){
        return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="ubah_keranjang('+value+')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Ubah</a><a href="Mutasi_gudang/keranjang_gudang_delete_antar_gudang/'+value+'" class="btn btn-danger"><span aria-hidden="true"></span>Hapus</a></div>';
	}

	function confirmDelete(id){
        $("#buttonConfirmDelete").attr("href", "Mutasi_gudang/keranjang_gudang_delete_antar_gudang/"+id);
        $('#alertDelete').modal('show');
    }

  //   $(document).ready(function() {
  //   $('#kode_konversi').on('change', function() {
  //       console.log(this.value);
  //       if ( this.value == 'cod'){
  //       	$('#biaya_ekspedisi').hide();
  //       }else{
  //       	$('#biaya_ekspedisi').show();
  //       }
  //   });
 	// });

 	function ubah_keranjang(id){
		$.ajax({
            url : linke+"Mutasi_gudang/keranjang_edit_gudang/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
            	//console.log(data);
            	$('[id="kode_keranjang"]').val(data.kode_mutasi_keranjang);
            	$('[id="jumlah_barang"]').val(data.jumlah_keranjang);
            	$('[id="jumlah_barang2"]').val(data.jumlah_keranjang_tujuan);
                $('#modal-2'+mdl).modal('show'); // show bootstrap modal when complete loaded
		        //--------------------------list barang --------------------------------
		        var list_barang = '<input type="text" name="ambil_get_barang" id="ambil_get_barang" onclick="get_barang()" class="form-control" value="'+data.nama_barang+'" readonly><input type="hidden" id="ambil_get_kode" name="ambil_get_kode" value="'+data.id_barang+'" >';
				
	               // console.log(okey);
	                var e = document.getElementById("list_barang"+mdl);
		        	e.innerHTML= list_barang;
			      	document.getElementById('list_barang'+mdl).style.display = "block";
	            //----------------------------------------satuan ------------------------
	            var okey = '<div class="col-xs-12"><div class="col-xs-6"><div class="form-group">Satuan</div></div><div class="col-xs-6"><div class="form-group"><select name="kode_konversi" id="kode_konversi"  class="form-control" onchange="javascript:valueselectsatuan()" >';
				$.getJSON(linke+'Mutasi_gudang/coba_akses_barang_satuan/'+data.id_barang, {
		            format: "json"
		        })
                .done(function (data2) {
                    $.each(data2, function (key, val) {
                    	if (val.id_varian_harga==data.kode_konversi) {
                        	okey += '<option value="' + val.id_varian_harga + '" selected="selected">' + val.satuan + '</option>';
                        }else{
                        	okey += '<option value="' + val.id_varian_harga + '" >' + val.satuan + '</option>';
                        }
                        // console.log(option);
                    });
                    okey += '</select></div></div></div>';
                   // console.log(okey);
                    var e = document.getElementById("showedit");
		        	e.innerHTML= okey;
			      	e.style.display = "block";

			      	 $.ajax({
			            url : linke+"Mutasi_gudang/ajax_jumlah/" + data.id_barang + '/' +data.lokasi_tujuan,
			            type: "GET",
			            dataType: "JSON",
			            success: function(data_max)
			            {
			    //         	if(data_max==null){
							// 	var okeyhistroy = '';
			    //         	}else{
			    //         		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+data_max.stok_gudang;
			    //         	}
			            	
							// var edddd = document.getElementById("max_jml");
							// edddd.innerHTML= okeyhistroy;
						 //  	document.getElementById('max_jml').style.display = "block";
			    //         	//document.getElementById('jumlah_barang').value = data_max.jumlah;
			    //         	$('#jumlah_barang').attr('max',data_max.stok_gudang);
			            	$.ajax({
					            url : linke+"Mutasi_gudang/ajax_konversi/" +data.kode_konversi+"/"+data.lokasi_permintaan,
					            type: "GET",
					            dataType: "JSON",
					            success: function(dataeer)
					            {
					            	//if(dataeer.identitas_konversi==1){
					            		//$('#jumlah_barang').attr('max',dataee.stok_gudang);
					            		if(dataeer==null){
													var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok :0';
								            	}else{
								            		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+dataeer.stok_gudang;
								            	}
					            		//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+dataee.stok_gudang;
					            		var edddd = document.getElementById("max_jml");
										edddd.innerHTML= okeyhistroy;
									  	document.getElementById('max_jml').style.display = "block";
					            	//}
					            	
					            	//document.getElementById('jumlah_barang').value = dataee.jumlah*dataeer.jumlah_konversi;
					            },
					    			error: function (jqXHR, textStatus, errorThrown)
					    		{
					        		alert('Error get data from ajax');
					    		}
							});
			            },
	            			error: function (jqXHR, textStatus, errorThrown)
	            		{
	                		alert('Error get data from ajax');
	            		}
	        		})
                 })

                var okey2 = '<div class="col-xs-12"><div class="col-xs-6"><div class="form-group">Satuan</div></div><div class="col-xs-6"><div class="form-group"><select name="kode_konversi2" id="kode_konversi2"  class="form-control" onchange="javascript:valueselectsatuan2()" >';
				$.getJSON(linke+'Mutasi_gudang/coba_akses_barang_satuan/'+data.id_barang, {
		            format: "json"
		        })
		         .done(function (data2) {
                    $.each(data2, function (key, val) {
                    	if (val.id_varian_harga==data.kode_konversi_tujuan) {
                        	okey2 += '<option value="' + val.id_varian_harga + '" selected="selected">' + val.satuan + '</option>';
                        }else{
                        	okey2 += '<option value="' + val.id_varian_harga + '" >' + val.satuan + '</option>';
                        }
                        // console.log(option);
                    });
                    okey2 += '</select></div></div></div>';
                   // console.log(okey);
                    var e = document.getElementById("showedit2");
		        	e.innerHTML= okey2;
			      	e.style.display = "block";

			      	$.ajax({
			            url : linke+"Mutasi_gudang/ajax_jumlah/" + data.id_barang + '/' +data.lokasi_permintaan,
			            type: "GET",
			            dataType: "JSON",
			            success: function(data_max)
			            {
			    //         	if(data_max==null){
							// 	var okeyhistroy = '';
			    //         	}else{
			    //         		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+data_max.stok_gudang;
			    //         	}
			            	
							// var edddd = document.getElementById("max_jml");
							// edddd.innerHTML= okeyhistroy;
						 //  	document.getElementById('max_jml').style.display = "block";
			    //         	//document.getElementById('jumlah_barang').value = data_max.jumlah;
			    //         	$('#jumlah_barang').attr('max',data_max.stok_gudang);
			            	$.ajax({
					            url : linke+"Mutasi_gudang/ajax_konversi/" +data.kode_konversi+"/"+data.lokasi_tujuan,
					            type: "GET",
					            dataType: "JSON",
					            success: function(dataeer)
					            {
					            	//if(dataeer.identitas_konversi==1){
					            		//$('#jumlah_barang').attr('max',dataee.stok_gudang);
					            		if(dataeer==null){
													var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok :0';
								            	}else{
								            		var okeyhistroy = '<strong><font color="red">*</font></strong>Total stok : '+dataeer.stok_gudang;
								            	}
					            		//var okeyhistroy = '<strong><font color="red">*</font></strong>Total Stok : '+dataee.stok_gudang;
					            		var edddd = document.getElementById("max_jml2");
										edddd.innerHTML= okeyhistroy;
									  	document.getElementById('max_jml2').style.display = "block";
					            	//}
					            	
					            	//document.getElementById('jumlah_barang').value = dataee.jumlah*dataeer.jumlah_konversi;
					            },
					    			error: function (jqXHR, textStatus, errorThrown)
					    		{
					        		alert('Error get data from ajax');
					    		}
							});
			            },
	            			error: function (jqXHR, textStatus, errorThrown)
	            		{
	                		alert('Error get data from ajax');
	            		}
	        		})
                 })

                var lokasine = "<select autofocus class='form-control' name='kode_lokasi' id='kode_lokasi' onchange='javascript:valueselecttujuan()'>";

                var lokasine_asal = "<select autofocus class='form-control' name='kode_lokasi_asal' id='kode_lokasi_asal' onchange='javascript:valueselecttujuan()'>";

	            $.getJSON(linke+'Mutasi_gudang/lokasinenya/', {
			            format: "json"
			        })
		            .done(function (data31) {
		            	$.each(data31, function (key, val) {
		            		if(data.lokasi_permintaan==val.id_lokasi){
		            			lokasine_asal += '<option value="'+val.id_lokasi+'" selected>'+val.nama_lokasi+'</option>';
		            		}else{
		            			lokasine_asal += '<option value="'+val.id_lokasi+'">'+val.nama_lokasi+'</option>';
		            		}
		            		
		            	});
		            	lokasine_asal += '</select>';
		            	var eaaa = document.getElementById("barangas"+mdl);
			        	eaaa.innerHTML= lokasine_asal;
				      	document.getElementById('barangas'+mdl).style.display = "block";

				      	$.each(data31, function (key, val) {
		            		if(data.lokasi_tujuan==val.id_lokasi){
		            			lokasine += '<option value="'+val.id_lokasi+'" selected>'+val.nama_lokasi+'</option>';
		            		}else{
		            			lokasine += '<option value="'+val.id_lokasi+'">'+val.nama_lokasi+'</option>';
		            		}
		            		
		            	});
		            	lokasine += '</select>';
		            	var eaaa = document.getElementById("barangas_asal"+mdl);
			        	eaaa.innerHTML= lokasine;
				      	document.getElementById('barangas_asal'+mdl).style.display = "block";
		            })

		           

        		
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
	}

