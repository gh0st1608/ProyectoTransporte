		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_facturas.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar la factura")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_facturas.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}
		
		function imprimir_factura(id_factura){
			console.log("asd");
			var url = location.origin;
			if (url == "http://localhost" || url == "http://localhost:8080") {
	           	window.open(url + '/sitrans/comprobantedepago.php?idfactura='+id_factura, '_blank');
           }else{
	           	window.open(url + '/comprobantedepago.php?idfactura='+id_factura, '_blank');
           }
		}


	$(function() {
		$("#nombus").autocomplete({
			source: "./ajax/autocomplete/bus.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				console.log(ui.item);
				$('#idbus').val(ui.item.idbus);
				$('#nombus').val(ui.item.placa);				
			 }
		});

		$("#nombus_n").autocomplete({
			source: "./ajax/autocomplete/bus.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				console.log(ui.item);
				$('#idbus_n').val(ui.item.idbus);
				$('#nombus_n').val(ui.item.placa);				
			 }
		});

		$("#sucursal_llegada").autocomplete({
				source: "./ajax/autocomplete/sucursales.php",
				appendTo: "#nuevoEncomienda",	
				minLength: 2,
				select: function(event, ui) {
					event.preventDefault();
					$('#sucursales').val(ui.item.id_sucursal);
					$('#sucursal_llegada').val(ui.item.nombre_sucursal);
				 }
			});
	});

	$(document).on('click','#mostrar_reporte',function(){

			fecha_reporte = $("#fecha_reporte").val();
			idbus = $("#idbus").val();
			n_idbus = $("#nombus").val();
			if (fecha_reporte.length && idbus.length) {
				var url = location.origin;
				window.open(url + '/sitrans/pdf_reporte_bus.php?fecha='+fecha_reporte+'&idbus='+idbus+'&n_idbus='+n_idbus, '_blank');
			}else{
				swal('Mensaje','No se encontraron datos','error');
			}

	});
	$(document).on('click','#pdf_mani',function(){

			fecha_reporte = $("#fecha_reporte_n").val();
			idbus = $("#idbus_n").val();
			n_idbus = $("#nombus_n").val();

			correlativo_ = $("#correlativo_").val();
			tarjeta = $("#tarjeta").val();
			piloto = $("#piloto").val();
			lc_piloto = $("#lc_piloto").val();
			copiloto = $("#copiloto").val();
			lc_copiloto = $("#lc_copiloto").val();
			axiliar = $("#axiliar").val();
			dni_axiliar = $("#dni_axiliar").val();
			origen = $("#origen").val();
			destino = $("#destino").val();
			
			temp = "&correlativo_="+correlativo_+"&tarjeta="+tarjeta+"&piloto="+piloto+"&lc_piloto="+lc_piloto+"&copiloto="+copiloto+"&lc_copiloto="+lc_copiloto+"&axiliar="+axiliar+"&dni_axiliar="+dni_axiliar+"&origen="+origen+"&destino="+destino;
			if (fecha_reporte.length && idbus.length) {
				var url = location.origin;
				window.open(url + '/sitrans/pdf_manifiesto.php?fecha='+fecha_reporte+'&idbus='+idbus+'&n_idbus='+n_idbus+temp, '_blank');
			}else{
				swal('Mensaje','No se encontraron datos','error');
			}

	});