<?php

include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id = session_id();
//print_r($session_id);die();
//if (isset($_POST['producto'])){$producto=$_POST['producto'];}
//if (isset($_POST['peso'])){$peso=$_POST['peso'];}
if (isset($_POST['precio'])) {$precio = $_POST['precio'];}
if (isset($_POST['cantidad'])) {$cantidad = $_POST['cantidad'];}
if (isset($_POST['descripcion'])) {$descripcion = $_POST['descripcion'];}
if (isset($_POST['codigo'])) {$codigo = $_POST['codigo'];}
if (isset($_POST['fecha'])) {$fecha = date("Y/m/d", strtotime($_POST['fecha']));}
if (isset($_POST['tipdoc'])) {$tipdoc = $_POST['tipdoc'];}
if (isset($_POST['celular'])) {$celular = $_POST['celular'];}
if (isset($_POST['dni'])) {$dni = $_POST['dni'];}
if (isset($_POST['precio_delivery'])) {$precio_delivery = $_POST['precio_delivery'];}


/* Connect To Database*/
require_once "../config/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../config/conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
include "../funciones.php";

if (!empty($precio) and !empty($cantidad) and !empty($descripcion)) {
    $sqlque     = "INSERT INTO tb_encomienda_det (id_encomienda, producto, peso, descripcion, cantidad, precio, estado_detalle, fecha_registro, codigo,precio_delivery ) VALUES ('0', '$descripcion', '', '$descripcion', $cantidad, $precio, '0', '$fecha', '$codigo','$precio_delivery')";
    $insert_tmp = mysqli_query($con, $sqlque);

    //print_r($sqlque);

}
if (isset($_GET['id'])) //codigo elimina un elemento del array
{
    $id_tmp = intval($_GET['id']);
    $delete = mysqli_query($con, "DELETE FROM tb_encomienda_det WHERE id_encomienda_det='" . $id_tmp . "'");

    $codigo = $_GET['codigo'];
    $tipdoc = $_GET['tipdoc'];
}
?>
<table class="table" id="tablaencomienda">
<tr>
	<th class='text-center'>#</th>
	<th class='text-center'>Cantidad</th>
	<th>Descripcion</th>
	<th class='text-right'>Precio Unitario</th>
	<th class='text-right'>Precio Total</th>
	<th></th>
</tr>
<?php
$sumador_total = 0;
$sql           = mysqli_query($con, "select * from tb_encomienda_det where tb_encomienda_det.codigo='" . $codigo . "'");
$hash          = 0;
$subtotal      = 0;
$delivery      = 0;
while ($row = mysqli_fetch_array($sql)) {

    $hash++;
    $cantidad    = $row["cantidad"];
    $descripcion = $row["producto"];
    $precio_delivery = $row["precio_delivery"];
    $iddet       = $row['id_encomienda_det'];

    $precio  = $row["precio"];
    $preciou = $row["precio"] / $cantidad;

    /*$precio_venta=$row['precio_tmp'];
    $precio_venta_f=number_format($precio_venta,2);//Formateo variables
    $precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
    $precio_total=$precio_venta_r*$cantidad;
    $precio_total_f=number_format($precio_total,2);//Precio total formateado
    $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
    $sumador_total+=$precio_total_r;//Sumador*/

    ?>
		<tr>
			<td class='text-center'><?php echo $hash; ?></td>
			<td class='text-center'><?php echo $cantidad; ?></td>
			<td><?php echo $descripcion; ?></td>
			<td class='text-right'><?php echo number_format($preciou, 2); ?></td>
			<td class='text-right'><?php echo number_format($precio, 2); ?></td>
			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $iddet ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
		</tr>
		<?php

    $subtotal += $row["precio"];
    $delivery += $row["precio_delivery"];

}
$simbolo_moneda = "S/.";
$impuesto       = "18";

if ($tipdoc == 3) {

    $subtotal  = number_format($subtotal, 2, '.', '');
    $delivery  = number_format($delivery, 2, '.', '');
    $subtotal = $subtotal / 1.18;
   $igv       = $subtotal * (18 / 100);
    $total     = $subtotal + $igv + $delivery ;
    $tipotexto = "SUBTOTAL";
} else {
    $total     = $subtotal;
    $igv       = ($subtotal * 18 ) / 100;
    $subtotal  = number_format($subtotal, 2, '.', '');
    $tipotexto = "OP INAFECTA";

}

?>
<tr class="subtotal">
	<td class='text-right' colspan=4><?php echo $tipotexto . " " . $simbolo_moneda; ?></td>
	<td class='text-right valor'><?php echo number_format($subtotal, 2); ?></td>
	<td></td>
</tr>
<tr class="igv">
	<td class='text-right' colspan=4>IGV (<?php echo $impuesto; ?>)% <?php echo $simbolo_moneda; ?></td>
	<td class='text-right valor'><?php echo number_format($igv, 2); ?></td>
	<td></td>
</tr>
<tr class="delivery">
	<td class='text-right' colspan=4>DELIVERY <?php echo $simbolo_moneda; ?></td>
	<td class='text-right valor'><?php echo number_format($delivery, 2); ?></td>
	<td></td>
</tr>
<tr class="total">
	<td class='text-right' colspan=4>TOTAL <?php echo $simbolo_moneda; ?></td>
	<td class='text-right valor'><?php echo number_format($total, 2); ?></td>
	<td></td>
</tr>

</table>
