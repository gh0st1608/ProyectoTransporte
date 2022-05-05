<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}
$active_encomienda = "active";
$active_productos  = "";
$active_clientes   = "";
$active_usuarios   = "";
$title             = "Nueva Encomienda | Expreso Lima E.I.R.L";

/* Connect To Database*/
require_once "config/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "config/conexion.php"; //Contiene funcion que conecta a la base de datos
		$query ="SELECT * FROM tb_sucursales";
	$fetch = mysqli_query($con,$query);

	$query ="SELECT * FROM tb_sucursales";
	$fetch2 = mysqli_query($con,$query);

	$querya ="SELECT * FROM encargado";
	$fetcha = mysqli_query($con,$querya);

		$query1 ="SELECT * FROM tb_buses";
	$fetch1 = mysqli_query($con,$query1);

    $query3 ="SELECT * FROM tb_pago";
	$fetch3 = mysqli_query($con,$query3);



?>
<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="text/css" href="img/envio_encomiendas.jpg">

<head>
    <?php include "head.php";?>
</head>

<body>
    <?php
include "navbar.php";
?>
    <div style="width: 1200px" class="container">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="btn-group pull-right">
                    <a class="btn btn-info" href="encomienda.php"><span class="glyphicon glyphicon-arrow-left"></span>
                        Regresar</a>
                </div>
                <h4><i class='glyphicon glyphicon-edit'></i> Nueva Encomienda</h4>
            </div>
            <div class="panel-body">
                <?php
include "modal/buscar_productos.php";
include "modal/registro_clientes.php";
?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-9">
                            <form class="form-horizontal" role="form" id="datos_encomienda">
                                <div class="form-group row">
                                    <label style="font-size: 12px" for="codigo"
                                        class="col-md-1 control-label">Codigo</label>
                                    <div class="col-md-3">
                                        <input style="width: 150px" type="text" class="form-control input-sm"
                                            id="codigo" name="codigo" readonly value="<?php echo generarCodigo(6) ?>"
                                            required>

                                    </div>
                                    <label style="font-size: 12px"  class="col-md-1 control-label">DNI</label>
                                    <div class="col-md-3">
                                        <input style="width: 150px" type="text" class="form-control input-sm"
                                            id="Didentidad" value="" name="Didentidad"
                                            placeholder="Ingresar Numero de documento">
                                    </div>
                                    <label style="font-size: 12px" for="nombre_cliente"
                                        class="col-md-1 control-label">Remitente</label>
                                    <div class="col-md-3">
                                        <input style="width: 150px" type="text" class="form-control input-sm"
                                            id="nombre_cliente" readonly>
                                        <input id="id_cliente" name="id_cliente" type='hidden'>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label style="font-size: 12px" for="consignatario"
                                        class="col-md-1 control-label">Destinatario</label>
                                    <div class="col-md-3">
                                        <input style="width: 150px" type="text" class="form-control input-sm"
                                            id="consignatario" value="" name="consignatario">
                                    </div>

                                    <label style="font-size: 12px" for="consignatario"
                                        class="col-md-1 control-label">Celular</label>
                                    <div class="col-md-3">
                                        <input style="width: 150px" type="text" class="form-control input-sm"
                                            id="celular" value="" name="celular">
                                    </div>

                                    <label style="font-size: 12px" for="dni" class="col-md-1 control-label">DNI</label>
                                    <div class="col-md-3">
                                        <input style="width: 150px" type="text" class="form-control input-sm" id="dni"
                                            value="" name="dni">
                                    </div>
                                </div class="form-group row">
                                <div class="form-group row">
                                    <label style="font-size: 12px" for="encargado" class="col-md-1 control-label">Encargado</label>
                                    <div class="col-md-3">
                                        <select style="width: 150px" name="id_encargado" id="id_encargado"
                                            class="form-control">
                                            <option>Seleccione</option>
                                            <?php
											while ($row = mysqli_fetch_array($fetcha)) {
											?>

                                            <option value="<?php echo $row['id_encargado']?>">
                                                <?php echo $row['nombre'] ?></option>
                                            <?php
											}
											?>
                                        </select>
                                    </div>
                                    <label style="font-size: 12px" for="tel2" class="col-md-1 control-label">Tipo</label>
                                    <div class="col-md-3">
                                            <select onclick="activar();" style="width: 150px" name="tipdoc" id="tipdoc" class="form-control">
                                            <option value="3">Frágil</option>
                                            <option value="3">Pesado</option>
                                            </select>
                                    </div>
                                    <label style="font-size: 12px" for="email" class="col-md-1 control-label">Destino</label>
                                    <div class="col-md-3">
                                        <select style="width: 150px" class="form-control" id="sucursal_llegada" name="id_sucu_llegada">
                                            <option value="">Seleccione</option>
                                            <?php
                                            while ($row = mysqli_fetch_array($fetch)) {
                                            ?>
                                            <option value="<?php echo $row['id_sucursal']?>"><?php echo $row['nombre_sucursal'] ?></option>
                                            <?php
                                        }
                                            ?>
                                        </select>
                                    </div>
                                </div class="form-group row">
                                <div class="form-group row">
                                    <label style="font-size: 12px" for="hora_aprox" class="col-md-1 control-label">Hora
                                        Aprox.</label>
                                    <div class="col-md-3">
                                        <input style="width: 150px" type="time" class="form-control input-sm" id="id"
                                            value="" name="time">
                                    </div>
                                    <label style="font-size: 12px" class="col-md-1 control-label">Entrega</label>
                                    <div class="col-md-3">
                                        <input type="button" name="Sede" id="Sede" value="Sede"
                                            onclick="desactivarcaja();datoinput1()">
                                        <input type="button" name="Delivery" id="Delivery2" value="Delivery"
                                            onclick="activarcaja();activarprecio();datoinput2()">
                                        <input type="text" name="delivery" id="delivery">
                                    </div>
                                    <label style="font-size: 12px" class="col-md-1 control-label">Dirección</label>
                                    <div class="col-md-3">
                                        <input style="width: 150px" class="form-control input-sm" type="text"
                                            name="direccion_delivery" id="direccion_delivery" disabled="">
                                    </div>
                                </div class="form-group row">
                                <script type="text/javascript">
                                function activarcaja() {
                                    document.getElementById('direccion_delivery').disabled = false
                                }

                                function activarprecio() {
                                    document.getElementById('precio_delivery').disabled = false
                                }

                                function desactivarcaja() {
                                    document.getElementById('direccion_delivery').disabled = true
                                }

                                function desactivarprecio() {
                                    document.getElementById('precio_delivery').disabled = true
                                }

                                function datoinput1() {
                                    document.getElementById('delivery').value = 'Sede'
                                }

                                function datoinput2() {
                                    document.getElementById('delivery').value = 'Delivery'
                                }
                                </script>
                                <div class="form-group row" >
                                    <label style="font-size: 12px" for="pago" class="col-md-1 control-label">Pago</label>
                                    <div class="col-md-3">
                                        <select style="width: 150px" class="form-control" id="id_pago" name="id_pago">
                                            <option value="">Seleccione</option>
                                            <?php
                                            while ($row = mysqli_fetch_array($fetch3)) {
                                            ?>
                                            <option value="<?php echo $row['id_pago']?>"><?php echo $row['pago'] ?></option>
                                            <?php
                                        }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" id="cambios">
                                    <div class="pull-right">
                                        <button type="button"  id="guardar_datosgenerales" class="btn btn-default">
                                            <span class="glyphicon glyphicon-print"></span> Generar Comprobante
                                        </button>
                                    </div>
                                </div>
                                <select style="visibility: hidden;width: 150px" class="form-control" id="idbus"
                                    name="id_bus">
                                    <option value="1">Seleccione</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form class="form-horizontal" method="post" id="registrar_detalle_encomiendas">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table style="margin-left: -30px">
                                                <td><label style="font-size: 12px" for="envio"
                                                        class="col-sm-2 control-label"> Precio</label></td>
                                                <td><input style="width: 70px" type="number"
                                                        class="form-control delteimputs" id="precio" name="precio"
                                                        required></td>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table style="margin-left: -30px">
                                                <td><label style="font-size: 12px" for="cantidad"
                                                        class="col-sm-1 control-label"> Cantidad</label></td>
                                                <td><input style="width: 50px" type="number"
                                                        class="form-control delteimputs" id="cantidad" name="cantidad"
                                                        required> </td>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table style="margin-left: 30px">
                                                <td><label style="font-size: 12px" for="precio_delivery"
                                                        class="col-sm-1 control-label"> Delivery</label></td>
                                                <td><input style="width: 70px" type="number"
                                                        class="form-control delteimputs" id="precio_delivery"
                                                        name="precio_delivery" required> </td>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <label for="descripcion" class="col-sm-2 control-label"> Descripción</label>
                                <textarea type="text" class="form-control delteimputs" id="descripcion"
                                    name="descripcion" required> </textarea>
                                <button type="button" onclick="addencomiendasdetalle();" class="form-control btn btn-danger"
                                    id="guardar_datos_encomiendas">Insertar datos</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
    </div>

    <?php
//include "footer.php";

function generarCodigo($longitud)
{
    $key     = '';
    $pattern = '1234567890';
    $max     = strlen($pattern) - 1;
    for ($i = 0; $i < $longitud; $i++) {
        $key .= mt_rand(0, $max);
    }

    return strtoupper($key);
}

?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="js/clientes.js"></script>
    <script>
    function activar() {
        var sel = document.getElementById("tipdoc").value;
        if (sel == "1") {
            var activar = document.getElementById("consignatario").hidden = false;

        }

    }

    $(function() {
        hola();
        $('#variabledina').toggle();
        $('#variabledina').toggle();
        //$("#cambios").css("display", "block");

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

    function addencomiendasdetalle() {
        var cantidad = $('#cantidad').val();
        var precio = $('#precio').val();
        var tipdoc = $('#tipdoc').val();

        // if (cantidad=="") {
        // 	alert("error");
        // }

        if (isNaN(cantidad) || isNaN(precio)) {
            Swal('Mensaje', 'Ingresar campos numericos correspondientes', 'warning');
            return false;
        }
        codigo = $('#codigo').val();
        fecha = new Date().toDateInputValue();
        $.ajax({
            type: "POST",
            url: "./ajax/agregar_encomienda.php",
            data: $('#registrar_detalle_encomiendas').serialize() + "&codigo=" + codigo + '&fecha=' + fecha +
                '&tipdoc=' + tipdoc,
            beforeSend: function(objeto) {},
            success: function(datos) {
                // $("#myModal").modal("hide");
                //$('.delteimputs').val("");
                $("#resultados").html(datos);
                validartipdoc();
            }
        });
        //alert("hola");

    }

    /*
    function addencomiendascabecera() {
            //total = $('table#tablaencomienda').find('tr.total   .valor').html();
            cantidad = $('#cantidad').val();
            precio = $('#precio').val();
            precio_delivery = $('#precio_delivery').val();          
            subtotal = 0.82 * (cantidad * precio);
            igv = ((subtotal * 18 ) / 100) * cantidad;
            total = subtotal + igv;
            cliente = $('#id_cliente').val();
            idbus = $('#idbus').val();
            sucursales = $('#sucursal_llegada').val();
            console.log('HOLA');
            console.log(cantidad);
            if (cliente.trim().length && idbus.trim().length && sucursales.trim().length) {
            fecha = new Date().toDateInputValue();
            var tipdoc = $('#tipdoc').val();          
            alert($('#datos_encomienda').serialize());
            $.ajax({
                type: "POST",
                url: "./ajax/save_encomienda.php",
                data: $('#datos_encomienda').serialize() + '&fecha=' + fecha + '&subtotal=' + subtotal +
                    '&igv=' + igv + '&total=' + total + '&tipdoc=' + tipdoc,
                beforeSend: function(objeto) {},
                success: function(datos) {
                    var idfac = datos.split("-");
                    alert($('#datos_encomienda').serialize() + '&fecha=' + fecha + '&subtotal=' + subtotal +
                    '&igv=' + igv + '&total=' + total + '&tipdoc=' + tipdoc);
                    status = (idfac[1] == "El documento fue creada correctamente") ? 'success' :
                        'error';
                    alert(idfac)
                    alert(idfac[1]); //undefined
                    Swal('Mensaje', idfac[1], status);

                    var url = location.origin;
                    idfac[0] = parseInt(idfac[0]); //idfac[0].replace(/ /g, "").toString();

                    if (url == "http://34.237.13.233/" || url == "http://34.237.13.233:8080") {
                        finurl = url + "/Expreso/ver_encomienda.php?id_encomienda=" + idfac[0];
                        window.location.href = finurl;
                    } else {
                        window.location.href = url + "/Expreso/ver_encomienda.php?id_encomienda=" + idfac[
                            0];
                    }
                }
            });
        } else {
            Swal('Mensaje', 'Completar todos los datos requeridos', 'warning');
        }
    }
    */
    
    $(document).on('click', '#guardar_datosgenerales', function(e) {

        total = $('table#tablaencomienda').find('tr.total td.valor').html();
        cliente = $('#id_cliente').val();
        idbus = $('#idbus').val();
        sucursales = $('#sucursal_llegada').val();
        //alert(sucursales);

        if (total != 0 && cliente.trim().length && idbus.trim().length && sucursales.trim().length) {
            fecha = new Date().toDateInputValue();
            var tipdoc = $('#tipdoc').val();
            subtotal = $('table#tablaencomienda').find('tr.subtotal td.valor').html();
            igv = $('table#tablaencomienda').find('tr.igv td.valor').html();
            total = $('table#tablaencomienda').find('tr.total td.valor').html();
            console.log($('#datos_encomienda').serialize());
            $.ajax({
                type: "POST",
                url: "./ajax/save_encomienda.php",
                data: $('#datos_encomienda').serialize() + '&fecha=' + fecha + '&subtotal=' + subtotal +
                    '&igv=' + igv + '&total=' + total + '&tipdoc=' + tipdoc,
                beforeSend: function(objeto) {},
                success: function(datos) {

                    var idfac = datos.split("-");
                    alert(idfac)
                    status = (idfac[1] == "El documento fue creada correctamente") ? 'success' :
                        'error';
                    alert(idfac[1]); //undefined
                    Swal('Mensaje', idfac[1], status);

                    var url = location.origin;
                    idfac[0] = parseInt(idfac[0]); //idfac[0].replace(/ /g, "").toString();

                    if (url == "http://localhost" || url == "http://localhost:8080") {
                        alert('ENTRO AL IF');
                        finurl = url + "/Expreso/ver_encomienda.php?id_encomienda=" + idfac[0];
                        window.location.href = finurl;
                    } else {
                        window.location.href = url + "/Expreso/ver_encomienda.php?id_encomienda=" + idfac[
                            0];
                    }
                }
            });
        } else {
            Swal('Mensaje', 'Completar todos los datos requeridos', 'warning');
        }
    });


    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 19);
    });

    function eliminar(id) {
        codigo = $('#codigo').val();
        tipdoc = $('#tipdoc').val();
        $.ajax({
            type: "GET",
            url: "./ajax/agregar_encomienda.php",
            data: "id=" + id + "&codigo=" + codigo + "&tipdoc=" + tipdoc,
            beforeSend: function(objeto) {

            },
            success: function(datos) {
                $("#resultados").html(datos);
                validartipdoc();
            }
        });
    }

    function validartipdoc() {
        total = parseInt($('table#tablaencomienda').find('tr.total td.valor').html());
        console.log(total);
        if (total != 1) {
            $('#tipdoc').attr({
                'disabled': 'true'
            });
        } else {
            document.getElementById("tipdoc").removeAttribute("disabled");
        }
    }
    $(document).on('change', '#tipdoc', function() {
        $('#nombre_cliente').val("");
        $('#id_cliente').val("");
        $('#Didentidad').val("");
        hola();
        var valor = $(this).val();

        //$('#variabledina').toggle();

        // if (valor == 1) { $("#cambios").css("display", "none");} else{ $("#cambios").css("display", "block");}
    });

    function hola() {
        id = ($('#tipdoc').val() == 3) ? "03" : "01";
        $("#Didentidad").autocomplete({
            source: "./ajax/autocomplete/clientes.php?d=" + id,
            minLength: 3,
            select: function(event, ui) {
                event.preventDefault();
                console.log(ui.item);
                $('#id_cliente').val(ui.item.id_cliente);
                $('#nombre_cliente').val(ui.item.nombre_cliente);
                $('#Didentidad').val(ui.item.documentoidentidad);
            }
        });
    }
    </script>

</body>

</html>