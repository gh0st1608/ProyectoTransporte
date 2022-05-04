<?php
	 
/*include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
$id_factura= $_SESSION['id_factura'];
$numero_factura= $_SESSION['numero_factura'];
if (isset($_POST['id'])){$id=intval($_POST['id']);}
if (isset($_POST['cantidad'])){$cantidad=intval($_POST['cantidad']);}
if (isset($_POST['precio_venta'])){$precio_venta=floatval($_POST['precio_venta']);}

	 Connect To Database
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
/*if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{
$insert_tmp=mysqli_query($con, "INSERT INTO detalle_factura (numero_factura, id_producto,cantidad,precio_venta) VALUES ('$numero_factura','$id','$cantidad','$precio_venta')");

}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_detalle=intval($_GET['id']);	
$delete=mysqli_query($con, "DELETE FROM detalle_factura WHERE id_detalle='".$id_detalle."'");
}
//$simbolo_moneda=get_row('tb_empresa','simbolo', 'id_moneda', 1);
    $query=mysqli_query($con,"select simbolo from tb_facturacion_cab, tb_moneda where tb_moneda.id_moneda = tb_facturacion_cab.id_moneda and id_facturacion='$id_factura'");
	$rw=mysqli_fetch_array($query);
	$simbolo_moneda=$rw['simbolo'];
?>
<table class="table">
<tr>
	<th class='text-center'>Codigo</th>
	<th class='text-center'>Cantidad</th>
	<th class='text-center'>Descripcion</th>
	<th class='text-right'>Precio Unitario.</th>
	<th class='text-right'>Precio Total</th>
	<th></th>
</tr>
<?php
	$sub_total=0;$igv_total=0;
	$sql=mysqli_query($con, "select * from tb_producto, tb_facturacion_cab, tb_facturacion_det where tb_facturacion_cab.id_facturacion=tb_facturacion_det.id_facturacion and  tb_facturacion_cab.id_facturacion='$id_factura' and tb_producto.id_producto = tb_facturacion_det.id_producto");
	while ($row=mysqli_fetch_array($sql))
	{		?>
		<tr>
			<td class='text-center'><?php echo $row['codigo_producto']; ?></td>
			<td class='text-center'><?php echo $row['cantidad']; ?></td>
			<td class='text-center'><?php echo $row['nombre_producto']; ?></td>
			<td class='text-right'><?php echo number_format($row['precio_unitario'],2); ?></td>
			<td class='text-right'><?php echo number_format($row['precio_total'],2); ?></td>
			<td></td>
			<!--td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_detalle ?>')"><i class="glyphicon glyphicon-trash"></i></a></td-->
		</tr>		
		<?php
	}
	$query=mysqli_query($con,"select * from tb_facturacion_cab where id_facturacion='$id_factura'");
	$rw=mysqli_fetch_array($query);
?>
<tr>
	<td class='text-right' colspan=4>SUBTOTAL</td>
	<td class='text-right'><?php echo $simbolo_moneda; echo number_format($rw['valor_total'],2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4>TOTAL IGV</td>
	<td class='text-right'><?php echo $simbolo_moneda; echo number_format($rw['igv_total'],2);?></td>
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4>TOTAL</td>
	<td class='text-right'><?php echo $simbolo_moneda; echo number_format($rw['precio_total'],2);?></td>
	<td></td>
</tr>

</table>
