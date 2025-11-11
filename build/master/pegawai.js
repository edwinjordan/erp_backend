function runningFormatter(value, row, index) {
    return index+1;
}

function actionPeriode(value, row, index){
   return '<div class="btn-group" role="group" aria-label="..."><a href="#" onclick="editdata(\''+row.kode_karyawan+'\')" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Edit</a><a href="#" onclick="editdatalogin(\''+row.kode_karyawan+'\',\''+row.username+'\')" type="button" class="btn btn-danger"><span aria-hidden="true"></span>Login</a></div>';
}

function ubah_status(value, row, index){
		if(row.status==0){
			return '<div class="btn-group" role="group" aria-label="..."><a href="'+linke+'Pegawai/ubah_status_pegawai/'+row.kode_karyawan+'/'+row.status+'" type="button" class="btn btn-success"><span aria-hidden="true"></span>Aktif</a></div>';
		}else{
			return '<div class="btn-group" role="group" aria-label="..."><a href="'+linke+'Pegawai/ubah_status_pegawai/'+row.kode_karyawan+'/'+row.status+'" type="button" class="btn btn-primary"><span aria-hidden="true"></span>Tidak Aktif</a></div>';
		}
}

function tampil_tambah(){
		//$('[name="kode_karyawan"]').val('');
		$('[name="nama"]').val('');
		$('[name="alamat"]').val('');
		$('[name="kota"]').val('');
		$('[name="negara"]').val('');
		$('[name="kode_pos"]').val('');
		$('[name="no_telp"]').val('');
		$('[name="email"]').val('');
        $('#modal-1'+mdl).modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
}

function editdata(id){
	    var kota = '';
	    var kode = '';
	    $.ajax({
            url : linke+"Pegawai/pegawai_where_id/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(datasupplierwhere)
            {
                $('[name="id_karyawan"]').val(datasupplierwhere.id_karyawan);    
        		$('[name="kode_karyawan"]').val(id);
        		$('[name="nama"]').val(datasupplierwhere.nama);
        		$('[name="alamat"]').val(datasupplierwhere.alamat);
        		$('[name="kota"]').val(datasupplierwhere.kota);
        		$('[name="negara"]').val(datasupplierwhere.negara);
                $('[name="kode_pos"]').val(datasupplierwhere.kode_pos);
                $('[name="no_telp"]').val(datasupplierwhere.no_telp);
                $('[name="email"]').val(datasupplierwhere.email);
                $('[name="gaji_karyawan"]').val(datasupplierwhere.gaji_karyawan);
        		kode = datasupplierwhere.id_lokasi;
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                
            }
        });
	    

        var okeylokasi = '<select name="id_lokasi" class="form-control">';

        $.getJSON(linke+'Pegawai/lokasie/', {
                    format: "json"
                })
                        .done(function (datae) {
                            $.each(datae, function (key, val) {
                                if(kode==val.id_lokasi){
                                    okeylokasi += '<option value="' + val.id_lokasi + '" selected >' + val.nama_lokasi + '</option>';
                                }else{
                                    okeylokasi += '<option value="' + val.id_lokasi + '" >' + val.nama_lokasi + '</option>';
                                }
                                
                            });
                            okeylokasi += '</select></div></div>';

                            console.log(okeylokasi);
                            console.log(kode);
                            var f = document.getElementById("pengganti_lokasie");
                            f.innerHTML= okeylokasi;
                            document.getElementById('pengganti_lokasie').style.display = "block";
                            document.getElementById('pengganti_lokasi').style.display = "none";
                         })

         var okeydepartment = '<select name="id_department" class="form-control">';

        $.getJSON(linke+'Pegawai/department/', {
                    format: "json"
                })
                        .done(function (datae) {
                            $.each(datae, function (key, val) {
                                if(kode==val.id_department){
                                    okeydepartment += '<option value="' + val.id_department + '" selected >' + val.department + '</option>';
                                }else{
                                    okeydepartment += '<option value="' + val.id_department + '" >' + val.department + '</option>';
                                }
                                
                            });
                            okeydepartment += '</select></div></div>';

                            console.log(okeydepartment);
                            console.log(kode);
                            var f = document.getElementById("pengganti_departmente");
                            f.innerHTML= okeydepartment;
                            document.getElementById('pengganti_departmente').style.display = "block";
                            document.getElementById('pengganti_department').style.display = "none";
                         })

        var okeycabang = '<select name="id_cabang" class="form-control">';

        $.getJSON(linke+'Pegawai/cabang/', {
                    format: "json"
                })
                        .done(function (datae) {
                            $.each(datae, function (key, val) {
                                if(kode==val.id_cabang){
                                    okeycabang += '<option value="' + val.id_cabang + '" selected >' + val.cabang + '</option>';
                                }else{
                                    okeycabang += '<option value="' + val.id_cabang + '" >' + val.cabang + '</option>';
                                }
                                
                            });
                            okeycabang += '</select></div></div>';

                            console.log(okeycabang);
                            console.log(kode);
                            var f = document.getElementById("pengganti_cabange");
                            f.innerHTML= okeycabang;
                            document.getElementById('pengganti_cabange').style.display = "block";
                            document.getElementById('pengganti_cabang').style.display = "none";
                         })  

        var okeyjabatan = '<select name="id_jabatan" class="form-control">';

        $.getJSON(linke+'Pegawai/jabatan/', {
                    format: "json"
                })
                        .done(function (datae) {
                            $.each(datae, function (key, val) {
                                if(kode==val.id_jabatan){
                                    okeyjabatan += '<option value="' + val.id_jabatan + '" selected >' + val.jabatan + '</option>';
                                }else{
                                    okeyjabatan += '<option value="' + val.id_jabatan + '" >' + val.jabatan + '</option>';
                                }
                                
                            });
                            okeyjabatan += '</select></div></div>';

                            console.log(okeyjabatan);
                            console.log(kode);
                            var f = document.getElementById("pengganti_jabatane");
                            f.innerHTML= okeyjabatan;
                            document.getElementById('pengganti_jabatane').style.display = "block";
                            document.getElementById('pengganti_jabatan').style.display = "none";
                         })                                                  

		$('#modal-2'+mdl).modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
	}

function editdatalogin(kode, user){
        $('[name="kode_karyawan"]').val(kode);
        $('[name="username"]').val(user);
        $('#modal-3'+mdl).modal('show');
        $('.modal').on('shown.bs.modal', function() {
          $(this).find('[autofocus]').focus();
        });
}	