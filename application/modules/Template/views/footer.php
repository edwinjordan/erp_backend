<!-- <script>

		$(document).ready(function(){

				$(".btn-hapus").on('click',function(){
					confirm('ready');
				})
				
				// Select2
				$('.select2').select2();

				// Supplier Delete
				$('.btndel').click(function(){11
					var idne = $(this).attr('idne');
					$("input[name=id]").val(idne);
					$('#boostrapModal').modal('show');
				});

				// Import Excel data barang

				$('#import_form').on('submit', function(event){
					event.preventDefault();
					$.ajax({
						url:"<?php echo base_url(); ?>Barang/import_excel",
						method:"POST",
						data:new FormData(this),
						contentType:false,
						cache:false,
						processData:false,
						success:function(data){
							$('#file').val('');
							console.log(data);
							// alert('Import data berhasil !!');
							// document.location.reload();
						}
					})
				}); 

				$('#example1').dataTable();
			});
			

			var count = 0;
			var countEl = document.getElementById("coly");
			$('#plus').click(function(){
				if(countEl.value > 0){
					count = countEl.value
				}
		    count++;
		    countEl.value = count;
			});

			$('#minus').click(function(){
				if(countEl.value > 0){
					count = countEl.value
				}
				if (count > 1) {	
			    count--;
			    countEl.value = count;
		  	}
			});
						
		</script>
		<script>
				$(document).ready(function(){  
					$('#btn-print').on('click',function(){
					console.log('asdsa');
				}); 
					var dataTable = $('#tbl_barang').DataTable({
						"lengthMenu": [[5, 10, 50, 100, -1], [5, 10, 50, 100, "Semua"]],
						"stateSave": true,  
						"processing":true,  
						"serverSide":true,  
						"order":[],  
						"ajax":{  
							url:"<?php echo base_url() . 'Barang/list_barang'; ?>",  
							type:"POST"  
						},  
						"columnDefs":[  
						{  
							"targets":[0, 7],  
							"orderable":false,  
						},  
						],  
					});
					
				}); 


		</script> -->