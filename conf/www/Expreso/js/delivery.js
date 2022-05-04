
	Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
		});


	$(function() {
		var tipdoc = 0;
		$("#nombre_cliente").autocomplete({
			source: "./ajax/autocomplete/clientes.php?d="+tipdoc,
			appendTo: "#nuevoEncomienda",	
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				//console.log(ui);
				$('#id_cliente').val(ui.item.id_cliente);
				$('#Didentidad').val(ui.item.nombre_cliente);
				$('#nombre_cliente').val(ui.item.documentoidentidad);
				//$('#direcc').val(ui.item.direcc);
			 }
		});

		/*$('.solo-numero').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
      });*/

      $(".solo-numero").keydown(function(event) {
	   if(event.shiftKey)
	   {
	        event.preventDefault();
	   }

	   if (event.keyCode == 46 || event.keyCode == 8)    {
	   }
	   else {
	        if (event.keyCode < 95) {
	          if (event.keyCode < 48 || event.keyCode > 57) {
	                event.preventDefault();
	          }
	        } 
	        else {
	              if (event.keyCode < 96 || event.keyCode > 105) {
	                  event.preventDefault();
	              }
	        }
	      }
	   });

	});
	
	


	$(document).on('click','#verificar',function(e){
				var q='';
				var page=1;
				$(this).addClass("disabled");
				$("#loader").fadeIn('slow');
				$.ajax({
					url:'./ajax/buscar_delivery_recibida.php?action=ajax&page='+page+'&q='+q,
					 beforeSend: function(objeto){
					  $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
				  },
					success:function(data){
						$(".Recibidos").html(data).fadeIn('slow');
						$('#loader').html('');
						$(".busqueda").attr("onkeyup","mostrar(1);");
					}
				})

		});



	$(document).ready(function(){
		load(1);

			$('.tabgroup > div').hide();
			$('.tabgroup > div:first-of-type').show();
			$('.tabs a').click(function(e){
			  	e.preventDefault();
			    var $this = $(this),
			        tabgroup = '#'+$this.parents('.tabs').data('tabgroup'),
			        others = $this.closest('li').siblings().children('a'),
			        target = $this.attr('href');
			    others.removeClass('active');
			    $this.addClass('active');
			    $(tabgroup).children('div').hide();
			    $(target).show();
			  
			})
			$('#registro').val(new Date().toDateInputValue());
			$('.regis').val(new Date().toDateInputValue());
			
	});






 		$(document).on('click','#eviados',function(e){
				var q='';
				var page=1;
				$("#loader").fadeIn('slow');
				$.ajax({
					url:'./ajax/buscar_delivery.php?action=ajax&page='+page+'&q='+q,
					 beforeSend: function(objeto){
					 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
				  },
					success:function(data){
						$(".outer_div").html(data);
						$('#loader').html('');
						$(".busqueda").attr("onkeyup","load(1);");

					}
				})

 			});


						

		function listar(id)
		{
			console.log("as");
			var q= $("#q").val();
				console.log(id);
				$.ajax({
		        type: "GET",
		        url: './ajax/listar_datos_delivery.php?action=ajax',
		        data: "id="+id,"q":q,
				 beforeSend: function(objeto){
					
				  },
		        success: function(datos){
				
				$(".listar").html(datos);
				
				}
				});	
		}



		function load(page){
			console.log("load");
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_delivery.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				  $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data);
					$('#loader').html('');
					$(".busqueda").attr("onkeyup","load(1);");
					
				}
			})
		}


	

	function mostrar(page){
			var q= $("#q").val();

			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_delivery_recibida.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".Recibidos").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}



	$(document).on('change','#verificar',function(){
			var id = $(this).parents('tr').find('td.id_detalle').html();

			Swal({
			  title: 'Estas Seguro?',
			  text: "Esta accion no podra modificarse",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Revisado'
			}).then((result) => {
				if (result.value) {
					$.ajax({
				        type: "POST",
				        url: './ajax/buscar_detalle_delivery.php?action=modificar',
				        data: "id="+id,"q":q,
						 beforeSend: function(objeto){
						  },
				        success: function(datos){
						// tipo = (datos == "Ha sido actualizado satisfactoriamente.") ? "success" : "error";
							Swal(
						      'Actualizado!',
						      "Ha sido actualizado satisfactoriamente.",
						      "success"
						      
						    )
							

						}
					});	

				}

			})
	});




	function detalles(id)
		{
			var q= $("#q").val();
				console.log(id);
				$.ajax({
		        type: "POST",
		        url: './ajax/buscar_detalle_delivery.php?action=ajax',
		        data: "id="+id,"q":q,
				 beforeSend: function(objeto){
					
				  },
		        success: function(datos){
				
				$(".detalles").html(datos);

				}
				});	
		}









		function eliminar(id){
			var q= $("#q").val();	
			Swal({
			  title: 'Estas Seguro?',
			  text: "Deseas eliminar la Encomienda !",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Eliminar'
			}).then((result) => {
				if (result.value) {
					$.ajax({
			        type: "GET",
			        url: "./ajax/buscar_encomienda.php",
			        data: "id="+id,"q":q,
					 beforeSend: function(objeto){
					  },
			        success: function(datos){
					tipo = (datos == "Datos eliminados exitosamente.") ? "success" : "error";
							Swal(
						      'Eliminado!',
						      "Datos eliminados exitosamente.",
						      "success"
						    )
							load(1);
							}	
						});
					
					}

			})
		}	

		


// -------------------------------------------
