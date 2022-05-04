
		$(document).ready(function(){
			load(1);
			$('#fecha').val(new Date().toDateInputValue());
			//console.log("funcionao");



		});

		Date.prototype.toDateInputValue = (function() {
		    var local = new Date(this);
		    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
		    return local.toJSON().slice(0,19);
		});

	$(document).on('change', '#fenvio', function(e) {
		idbus = $('#idbus').val();
		fecha = $('#fenvio').val(); //new Date().toDateInputValue();
		if (idbus.length > 0 && fecha.length > 0) {
			$.ajax({
	            url: './ajax/modal_bus_50.php',
	            type: 'POST',
	            data: 'idbus='+idbus+'&fecha='+fecha,
	            dataType: "json",
	            beforeSend: function() {
	                 $.ajaxblock();
	            },
	            success: function(response) {
	                
	            },
	            complete: function(datos) {
	               $.ajaxunblock(); 	               
	               $("#diseño_bus").html(datos.responseText);
	               // $('#diseño_bus').html()
	    //            if (idbus == 1 || idbus == 17) { $("#modalbus54").modal(); }
					// else if (idbus == 18 || idbus == 19){ $("#modalbus50").modal(); }
					// 	else if (idbus == 16) { $("#modalbus53").modal(); }
	            }
	        });
		}else{
			Swal('Mensaje','seleccionar un bus y/o fecha salida', 'warning');
		}
	});
	(function($){
		$.ajaxblock 	= function(){
			$("body").prepend("<div id='ajax-overlay'><div id='ajax-overlay-body' class='center'><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><span class='sr-only'>Loading...</span></div></div>");
			$("#ajax-overlay").css({
				position: 'absolute',
				color: '#FFFFFF',
				top: '0',
				left: '0',
				width: '100%',
				height: '100%',
				position: 'fixed',
				background: 'rgba(39, 38, 46, 0.67)',
				'text-align': 'center',
				'z-index': '9999'
			});
			$("#ajax-overlay-body").css({
				position: 'absolute',
				top: '40%',
				left: '50%',
				width: '120px',
				height: '48px',
				'margin-top': '-12px',
				'margin-left': '-60px',
				//background: 'rgba(39, 38, 46, 0.1)',
				'-webkit-border-radius':	'10px',
				'-moz-border-radius':	 	'10px',
				'border-radius': 		 	'10px'
			});
			$("#ajax-overlay").fadeIn(50);
		};
		$.ajaxunblock 	= function(){
			$("#ajax-overlay").fadeOut(100, function()
			{
				$("#ajax-overlay").remove();
			});
		};
	})(jQuery);

	
		
		function eliminar (id)
		{	
			 $("#tabledetalle").remove();
		}

	$(document).on('click', '.idrow', function(e) {
		valrow = $(this).find('.valrow span').html();
		valpiso = $(this).parents('table').attr('piso');
		$('#piso').val(valpiso);

		
		//console.log(valasiento);
		//console.log(valpsio);
		$.ajax({
            url: './ajax/agregar_bus.php',
            type: 'POST',
            data: 'valrow='+valrow+'&valpiso='+valpiso,
            dataType: "json",
            beforeSend: function() {
                 $.ajaxblock();
            },
            success: function(response) {
                
            },
            complete: function(datos) {
               $.ajaxunblock(); 
               if (idbus == 1 || idbus == 17) { $("#modalbus54").modal("hide"); }
				else if (idbus == 18 || idbus == 19){ $("#modalbus50").modal("hide"); }
					else if (idbus == 16) { $("#modalbus53").modal("hide"); }
               $("#resultados").html(datos.responseText);

            }
        });
	});

	$(document).on('keyup', '#valorunitario', function(e) {
		padre= $(this);
		valUnitario = $(this).val();
		$(this).parents('tr').find('td.preciototal').html(parseFloat(valUnitario).toFixed(2));
		calcularpreciosdetalle(valUnitario,padre);
		
	});	
	function calcularpreciosdetalle(valUnitario,padre){
		var igv = "0.00"
		var subtotal = parseFloat(valUnitario);
		var total = parseFloat(valUnitario);

		$(padre).parents('tbody').find('tr.subtotal td.valor').html(parseFloat(subtotal).toFixed(2));
		$(padre).parents('tbody').find('tr.igv td.valor').html(parseFloat(igv).toFixed(2));
		$(padre).parents('tbody').find('tr.total td.valor').html(parseFloat(total).toFixed(2));
	}
	
	// $(document).on('click', '#save', function(e) {
		
	// 	cliente = $('#id_cliente').val(); 		
	// 	bus = $('#idbus').val();

	// 	pasajero = $('#id_pasajero').val();
	// 	tipodoc = $('#tipdoc').val();

	// 	precio = $('#cant_precio').val(); //cambiar
	// 	asiento = $('#asiento span').html();// cambiar
	// 	piso = $('#piso_cab span').html();// cambiar
	// 	sucursales = $('#sucursales').val();
		
	// 	subtotal = precio;
	// 	igv = 0;
	// 	total = precio;

	// 	desc = "Piso # "+piso+" Asiento # "+asiento;		

	// 	if (sucursales.length && cliente.length && bus.length && !isNaN(parseInt(precio))  && parseInt(precio) > 0) {

	// 		if (tipodoc != '03')
	// 		{ 
	// 			if (pasajero=="")
	// 			{
	// 				Swal('Mensaje','Completar el campo pasajero ingresando el DNI','warning'); return;
	// 			}
	// 		}

	// 		temp = '&subtotal='+subtotal+'&igv='+igv+'&total='+total+'&desc='+desc+'&preciotexto='+precio+"&asiento="+asiento+"&piso="+piso;
	// 		$.ajax({
	//             url: './ajax/agregar_facturacion.php',
	//             type: 'POST',
	//             data: $('#datos_factura').serialize() + temp,
	//             beforeSend: function() {
	//                 $.ajaxblock();
	//             },
	//             success: function(datos){
	//             	var idfac = datos.split("-");
	// 				// status = (idfac[1] == "El documento fue creada correctamente") ? 'success' : 'error' ;            	
	//             	Swal('Mensaje','El documento fue creada correctamente','success');   

	//             	var url = location.origin;
	               
	//                if (url == "http://localhost" || url == "http://localhost:8080") {
	//                	window.location.href  = url + "/Sistema-Huari-Tours/ver_factura.php?id_factura="+idfac[0];
	//                }else{
	//                	window.location.href  = url + "/ver_factura.php?id_factura="+idfac[0];
	//                }
	//             },
	//             complete: function() {	              	
	//                $.ajaxunblock();               		             
	//             }
	//         });
	// 	}else{
	// 		Swal('Mensaje','Completar todos los datos necesarios','warning');
	// 	}
		
	// });

	$(document).on('click', '.asiento-disponible', function(e) {
		asiento = $(this).attr('numero');
		piso = $(this).attr('piso');
		$("#piso_cab span").html(piso);
		$("#asiento span").html(asiento);
	});


	$(document).on('click', '.asiento-seleccionado', function(e) {
		Swal('Mensaje','Asiento esta ocupado', 'warning');
	});
	$(document).on('click', '.asiento-ocupado', function(e) {
		Swal('Mensaje','Asiento esta ocupado', 'warning');
	});
	$(document).on('click', '.asiento-separado', function(e) {
		Swal('Mensaje','El Asiento Pertenece a una Agencia', 'warning');
	});

//cambios

	$(document).on('click', '#save', function(e) {
		
		cliente = $('#id_cliente').val(); 		
		bus = $('#idbus').val();

		pasajero = $('#id_pasajero').val();
		tipodoc = $('#tipdoc').val();

		precio = $('#cant_precio').val(); //cambiar
		asiento = $('#asiento span').html();// cambiar
		piso = $('#piso_cab span').html();// cambiar
		sucursales = $('#sucursal_llegada').val();
		fecha = $('#fenvio').val();
		
		subtotal = precio;
		igv = 0;
		total = precio;

		desc = "Piso # "+piso+" Asiento # "+asiento;		

		if (sucursales.length && cliente.length && bus.length && !isNaN(parseInt(precio))  && parseInt(precio) > 0) {

			if (tipodoc != '03')
			{ 
				if (pasajero=="")
				{
					Swal('Mensaje','Completar el campo pasajero ingresando el DNI','warning'); return;
				}
			}

			temp = '&subtotal='+subtotal+'&igv='+igv+'&total='+total+'&desc='+desc+'&preciotexto='+precio+"&asiento="+asiento+"&piso="+piso;
			$.ajax({
	            url: './ajax/validar_asientos_agregar_facturacion.php',
	            type: 'POST',
	            data: 'idbus='+bus+'&fecha='+fecha+'&piso='+piso+'&asiento='+asiento,
	            dataType: "json",
	            beforeSend: function() {
	                $.ajaxblock();
	            },
	            success: function(data){
	            	if (data==0) {
	            		console.log(data);
						$.ajax({
						    url: './ajax/agregar_facturacion.php',
						    type: 'POST',
						    data: $('#datos_factura').serialize() + temp,
						    success: function(datos){
						    	var idfac = datos.split("-");
						    	var accion = idfac[0].replace(/\s+/, "");

						    	console.log(datos);
						    	console.log(accion); //return;

								if (accion==='A') {
									Swal('Mensaje','Lo siento algo ha salido mal intenta nuevamente','warning'); 
								}else if (accion==='B') {
									Swal('Mensaje','No se registro el control de asientos','warning'); 
								}else if (accion==='C') {
									Swal('Mensaje','No se registro la facturacion','warning');
								}else {
					  		  		Swal('Mensaje','El documento fue creada correctamente','success');
					  		  		var url = location.origin;
					  		  		if (url == "http://localhost" || url == "http://localhost:8080") {
						 	      		window.location.href  = url + "/sitrans/ver_factura.php?id_factura="+idfac[0];
						 	      	}else{
						 	      		window.location.href  = url + "/ver_factura.php?id_factura="+idfac[0];
						 	       }
								}
						    },
						    complete: function() {
						       $.ajaxunblock();
						    }
						});
	            	} else {
	            		Swal('Mensaje','El asiento elegido se encuentra ocupado o on existe, intentar nuevamente','warning'); 
	            	}
	            },
	            complete: function() {
	               $.ajaxunblock();
	            }
	        });
		}else{
			Swal('Mensaje','Completar todos los datos necesarios','warning');
		}
		
	});