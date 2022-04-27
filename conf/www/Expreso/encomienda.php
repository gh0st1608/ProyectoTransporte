<?php

	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_encomienda="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Encomienda | Expreso Lima";


	
?>
<!DOCTYPE html>
<html lang="es">
<link rel="icon" href="img/expreso.jpg">

<head>
    <?php include("head.php");?>

</head>

<body>
    <?php
	include("navbar.php");
	?>


    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <a href="nueva_encomienda.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>
                        Nueva Encomienda</a>
                </div>
                <h4><i class='glyphicon glyphicon-search'></i> Buscar Encomienda</h4>
            </div>
            <div class="panel-body">



                <?php
			include("modal/registrar_encomienda.php");
			include("modal/editar_encomienda.php");
			include("modal/Registrar_detalle_encomienda.php");
			include("modal/editar_encomienda_detalle.php");
			include("modal/listar_datos_encomienda.php");
			?>
                <form class="form-horizontal" role="form" id="datos_cotizacion">
                    <div class="form-group row">
                        <label for="q" class="col-md-2 control-label">Código o Documento</label>
                        <div class="col-md-5 reemplazo">
                            <input type="text" class="form-control busqueda" id="q" placeholder="Código o Documento"
                                onkeyup="load(1);">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-default" id="removess" onclick='load(1);'>
                                <span class="glyphicon glyphicon-search"></span> Buscar</button>
                            <span id="loader"></span>
                        </div>

                    </div>



                </form>
                <div id="resultados">
                </div><!-- Carga los datos ajax -->
                <div class=''>
                    <div class="">
                        <div class="">
                            <div class="col-sm-15 col-sm-offset-0">
                                <!-- Nav tabs -->
                                <ul class="tabs nav nav-tabs tabs border-0 flex-column flex-lg-row"
                                    data-tabgroup="first-tab-group">

                                    <li class="nav-item active" id="eviados" data-toggle="tab">
                                        <a href="#tab1" class="nav-link active"><i class="fe fe-home"></i>Enviados</a>
                                    </li>

                                    <li class="nav-item" id="verificar" data-toggle="tab">
                                        <a href="#tab2" class="nav-link"><i class="fe fe-image"></i> Recibidos</a>
                                    </li>
                                </ul>

                                <section id="first-tab-group" class="tabgroup">
                                    <!-- TAB NUMERO 1 -->
                                    <div id="tab1" class="outer_div">
                                        <!-- CONTAINER PARA PONER LOS INPUTS -->

                                    </div>
                                    <!-- TAB NUMERO 2 -->
                                    <div id="tab2" class="Recibidos">
                                        <!-- CONTAINER -->

                                    </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Carga los datos ajax -->

            </div>
        </div>

    </div>
    <hr>

    <?php
	include("footer.php");
	?>

    <script type="text/javascript" src="js/encomienda.js"></script> <!--INVOCACION A FUNCIONES DE JAVASCRIPT-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</body>

</html>


<script>
//$( "#guardar_encomienda" ).submit(function( event ) {

$(document).on('click', '#guardar_datos', function(e) {

    var parametros = $('#guardar_encomienda').serialize();
    var params = $('#registrar_detalle_encomienda').serialize();

    encomienda(parametros);
    detalle_encomienda(params);
    $('.delteimputs').val("");

})

$(document).on('click', '#guardardatos', function(e) {

    //var parametros = $('#guardar_encomienda').serialize();
    var params = $('#registrar_detalle_encomiendas').serialize();
    //$(this).attr()
    //encomienda(parametros);
    $('.delteimput').val("");
    detalle_encomienda(params);
})

function encomienda(parametros) {
    $.ajax({
        type: "POST",
        url: "ajax/nuevo_encomienda.php",
        data: parametros,

        beforeSend: function(objeto) {},
        success: function(datos) {
            $('#nuevoEncomienda').modal('hide');
            nom = (datos == "Su registro ha sido ingresado satisfactoriamente.") ? "success" : "error";
            Swal(
                'Mensaje',
                datos,
                nom
            )
            load(1);
        }
    });
    event.preventDefault();
}


function detalle_encomienda(params) {
    //console.log("jajaj");
    $.ajax({
        type: "POST",
        url: "ajax/registrar_detalle_encomienda.php",
        data: params,
        beforeSend: function(objeto) {

        },
        success: function(datos) {
            $('#datosEncomienda').modal('hide');
            nom = (datos == "Su registro ha sido ingresado satisfactoriamente.") ? "success" : "error";
            Swal(
                'Mensaje',
                datos,
                nom
            )
            //load(1);
        }
    });
    event.preventDefault();
}

$(function() {

    $("#bus").autocomplete({
        source: "./ajax/autocomplete/bus.php",
        appendTo: "#nuevoEncomienda",
        minLength: 2,
        select: function(event, ui) {
            event.preventDefault();
            $('#id_bus').val(ui.item.idbus);
            $('#bus').val(ui.item.placa);
        }
    });


    $("#sucursal_destino").autocomplete({
        source: "./ajax/autocomplete/sucursales.php",
        appendTo: "#nuevoEncomienda",
        minLength: 2,
        select: function(event, ui) {
            event.preventDefault();
            $('#sucursales').val(ui.item.id_sucursal);
            $('#sucursal_destino').val(ui.item.nombre_sucursal);
        }
    });
});

/* probar esto*/

$("#registrar_detalle_encomienda").submit(function(event) {

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/registrar_detalle_encomienda.php",
        data: parametros,
        beforeSend: function(objeto) {

        },
        success: function(datos) {
            $('#datosEncomienda').modal('hide');
            nom = (datos == "Su registro ha sido ingresado satisfactoriamente.") ? "success" :
                "error";
            Swal(
                'Mensaje',
                datos,
                nom
            )
            load(1);
        }
    });
    event.preventDefault();
})




$("#editar_encomienda").submit(function(event) {
    $('#').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/editar_encomienda.php",
        data: parametros,
        beforeSend: function(objeto) {

        },
        success: function(datos) {
            $('#editarEncomienda').modal('hide');
            $('#actualizar_datos').attr("disabled", false);
            nom = (datos == "El registro ha sido actualizado satisfactoriamente.") ? "success" :
                "error";
            Swal(
                'Mensaje',
                datos,
                nom
            )
            load(1);
        }
    });
    event.preventDefault();
})




function obtener_datos(id) {
    var bus = $("#id_bus" + id).val();
    var id_llegada = $("#id_llegada" + id).val();
    var id_cliente = $("#id_cliente" + id).val();
    var id_partida = $("#id_partida" + id).val();
    var id_encomienda = $("#id_encomienda" + id).val(); //console.log(id_encomienda);		
    var estado = $("#estado" + id).val();
    //var id_ec = $("#id_encomienda").val(id_encomienda);



    $("#id_encomiendas").val(id_encomienda);

    $("#mod_cliente").val(id_cliente);
    $("#mod_bus").val(bus);
    $("#mod_sucursal_partida").val(id_partida);
    $("#mod_sucursal_llegada").val(id_llegada);
    $("#mod_estado").val(estado);
}



$(function() {
    $("#mod_cliente").autocomplete({
        source: "./ajax/autocomplete/clientes.php",
        appendTo: "#editarEncomienda",
        minLength: 2,
        select: function(event, ui) {
            event.preventDefault();
            $('#modif_cliente').val(ui.item.id_cliente);
            $('#mod_cliente').val(ui.item.nombre_cliente);
        }
    });


    $("#mod_bus").autocomplete({
        source: "./ajax/autocomplete/bus.php",
        appendTo: "#editarEncomienda",
        minLength: 2,
        select: function(event, ui) {
            event.preventDefault();
            $('#modif_bus').val(ui.item.id_bus);
            $('#mod_bus').val(ui.item.placa);
        }
    });


});



$("#nombre_cliente").on("keydown", function(event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui
        .keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event
        .keyCode == $.ui.keyCode.BACKSPACE) {
        $("#id_cliente").val("");
    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
        $("#id_cliente").val("");
    }
});

$("#bus").on("keydown", function(event) {
    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui
        .keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event
        .keyCode == $.ui.keyCode.BACKSPACE) {
        $("#id_bus").val("");
    }
    if (event.keyCode == $.ui.keyCode.DELETE) {
        $("#id_bus").val("");
    }
});
</script>