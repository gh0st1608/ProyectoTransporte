		$(document).on('click','#nuevocliente ', function (e) {
			$('.persona1').addClass('active');
			$('.persona2').removeClass('active');
			$( "#persona1" ).trigger( "change" );
			$(".updatedata").attr('tipPersona','1');
			$(".updatedata").attr('docIdentidad','1');
			
		});


		$(document).on('change','#persona1 ', function (e) {
			document.getElementById('modnombre').innerHTML = 'Nombre';
			document.getElementById('moddni').innerHTML = 'DNI';
			$(".updatedata").attr('tipPersona','1');
			$(".updatedata").attr('docIdentidad','1');
		});
			

		$(document).on('change','#persona2 ', function (e) {	
			document.getElementById('modnombre').innerHTML = 'Razon Social';
			document.getElementById('moddni').innerHTML = 'RUC';
			$(".updatedata").attr('tipPersona','2');
			$(".updatedata").attr('docIdentidad','6');
		});

		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_clientes.php?action=ajax&page='+page+'&q='+q,
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
			  text: "deseas eliminar el cliente !",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Eliminar'
			}).then((result) => {
			  	if (result.value) {
				  	$.ajax({
			        type: "GET",
			        url: "./ajax/buscar_clientes.php",
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
			})

			/*var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el cliente")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_clientes.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}*/
		}
		

		
	
$( "#guardar_cliente" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
 var docIdentidad = $(".docIdentidad").attr('id');
 	tipPersona   = $(".updatedata").attr('tipPersona');
	docIdentidad =$(".updatedata").attr('docIdentidad');
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_cliente.php",
			data: parametros + '&tipPersona=' + tipPersona + '&docIdentidad=' + docIdentidad,
			 beforeSend: function(objeto){
				//$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$('#nuevoClientemodal').modal('hide');
			$('.delete').val("");
			//document.getElementById("tipodoc").options[0].selected = true;
			//document.getElementById("estado").options[0].selected = true;
			//$("#resultados_ajax").html(datos);
			datos = datos.trim();
			nom = (datos =="Cliente ha sido ingresado satisfactoriamente.") ? "success" : "error";
			Swal(
			  'Mensaje',
			  datos,
			  nom
			)
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_cliente" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
	var parametros = $(this).serialize();
	 
	tipPersona   = $(".updatedata").attr('tipPersona');
	docIdentidad =$(".updatedata").attr('docIdentidad');
	 $.ajax({
			type: "POST",
			url: "ajax/editar_cliente.php",
			data: parametros + '&tipPersona=' + tipPersona + '&docIdentidad=' + docIdentidad,
			 beforeSend: function(objeto){
				//$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			//$("#resultados_ajax2").html(datos);
			$('#myModal2').modal('hide');
			datos = datos.trim();
			nom = (datos =="Cliente ha sido actualizado satisfactoriamente.") ? "success" : "error";
			Swal(
			  'Mensaje',
			  datos,
			  nom
			)
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
			var nombre_cliente = $("#nombre_cliente"+id).val();
			var telefono_cliente = $("#telefono_cliente"+id).val();
			var email_cliente = $("#email_cliente"+id).val();
			var direccion_cliente = $("#direccion_cliente"+id).val();
			var status_cliente = $("#status_cliente"+id).val();
			var n_dni = $("#n_dni"+id).val();
			var edad = $("#edad"+id).val();
			
			var tipo_doc = $("#tipo_doc"+id).val();
			var id_persona = $("#id_persona"+id).val();

			tipPersona   = $(".updatedata").attr('tipPersona', id_persona);
			docIdentidad =$(".updatedata").attr('docIdentidad', id);
	
			$("#mod_nombre").val(nombre_cliente);
			$("#mod_telefono").val(telefono_cliente);
			$("#mod_email").val(email_cliente);
			$("#mod_direccion").val(direccion_cliente);
			$("#mod_estado").val(status_cliente);
			$("#mod_id").val(id);
			$("#moddnis").val(n_dni);
			$("#mod_tipodocs").val(tipo_doc);
			$(".estado").attr('id',id_persona);
			$(".doc").attr('id',tipo_doc);
			$("#mod_edad").val(edad);

			if(id_persona=='1')
  			 {
  			 	   if(tipo_doc == '1') { 
                     $('#mod_dni').text('DNI'); 
                     $("#mod_tipodocs").val('1');
                 }else if(tipo_doc == '4'){
                 	 $('#mod_dni').text('Carnet'); 
                 	 $("#mod_tipodocs").val('4');
                 }else if(tipo_doc == '6'){
                 	 $('#mod_dni').text('Contr.');
                 	 $("#mod_tipodocs").val('6'); 
                }else if(tipo_doc == '7'){
                 	 $('#mod_dni').text('Pas.'); 
                 	 $("#mod_tipodocs").val('7');
                 }else if(tipo_doc == '8'){
                 	 $('#mod_dni').text('otros');
                 	 $("#mod_tipodocs").val('8'); 
                 }else{
                 	$('#mod_dni').text('DNI');
                 	$("#mod_tipodocs").val('1');
                 }

  			 	 

      			$('.persona1').addClass('active');
      			$('.persona2').removeClass('active');
      			$('#modnombre').text('Nombre');
      			$("#mod_tipodocs").removeAttr('disabled');
      			
				
   			}
    		else
   			{

      			$('.persona1').removeClass('active');
      			$('.persona2').addClass('active');
				$('#modnombre').text('Razon Social');
				$('#mod_dni').text('RUC');
				$("#mod_tipodocs").attr('disabled','disabled');
				$("#mod_tipodocs").val('0');
				
   			}
			
		
		}

		$(document).on('click','#tipodoc ', function (e) {
				var combo = document.getElementById("tipodoc"); 
                    var selected = combo.options[combo.selectedIndex].text;                   
                    if(selected == "Documento Nacional De Identidad") { 
                     $('#moddni').text('DNI'); 
                 }else if(selected == "Carnet De Extranjeria"){
                 	 $('#moddni').text('Carnet'); 
                 }else if(selected == "Registro Unico De Contribuyentes"){
                 	 $('#moddni').text('Contr.'); 
                }else if(selected == "Pasaporte"){
                 	 $('#moddni').text('Pas.'); 
                 }else if(selected == "Otros Tipo De Documentos"){
                 	 $('#moddni').text('otros'); 
                 }else{
                 	$('#moddni').text('DNI');
                 }
		});


		$(document).on('click','#mod_tipodocs', function (e) {
				var combo = document.getElementById("mod_tipodocs"); 
                    var selected = combo.options[combo.selectedIndex].text;                   
                    if(selected == "Documento Nacional De Identidad") { 
                     $('#mod_dni').text('DNI'); 
                 }else if(selected == "Carnet De Extranjeria"){
                 	 $('#mod_dni').text('Carnet'); 
                 }else if(selected == "Registro Unico De Contribuyentes"){
                 	 $('#mod_dni').text('Contr.'); 
                }else if(selected == "Pasaporte"){
                 	 $('#mod_dni').text('Pas.'); 
                 }else if(selected == "Otros Tipo De Documentos"){
                 	 $('#mod_dni').text('otros'); 
                 }else{
                 	$('#mod_dni').text('DNI');
                 }
		});


		 
	
		
		

