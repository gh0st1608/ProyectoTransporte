		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_usuarios.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
		function eliminar (id)
		{

			var q= $("#q").val();
			Swal({
			  title: 'Estas Seguro?',
			  text: "deseas eliminar el usuario !",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Eliminar'
			}).then((result) => {
			  	if (result.value) {
				  	$.ajax({
			        type: "GET",
			        url: "./ajax/buscar_usuarios.php",
			        data: "id="+id,"q":q,
					 	beforeSend: function(objeto){
							
					  },
				        success: function(datos){
						//$("#resultados").html(datos);
						tipo = (datos == "Datos eliminados exitosamente.") ? "success" : "error";
						Swal(
					      'Eliminado!',
					      datos,
					      tipo
					    )
						load(1);
						}
					});
			  	} 
			});

		}
		
		
		
		
		
		

