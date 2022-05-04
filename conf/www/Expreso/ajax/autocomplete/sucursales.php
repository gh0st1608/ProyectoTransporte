<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
	session_start();
	$id_sucursal = $_SESSION['idsucursal'] ;
	$query ="SELECT * FROM tb_sucursales where nombre_sucursal like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' and id_sucursal NOT IN ('$id_sucursal') LIMIT 0 ,50";
	$fetch = mysqli_query($con,$query); 


	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		//$id_cliente=$row['id_cliente'];
		$row_array['value'] = $row['nombre_sucursal'];
		$row_array['nombre_sucursal'] = $row['nombre_sucursal'];
		$row_array['id_sucursal']=$row['id_sucursal'];
		
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>