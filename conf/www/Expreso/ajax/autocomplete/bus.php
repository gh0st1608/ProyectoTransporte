<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{
	
	$query ="SELECT * FROM tb_buses where placa like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50";
	$fetch = mysqli_query($con,$query); 


	
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		//$id_cliente=$row['id_cliente'];
		$row_array['value'] = $row['placa'];

		$row_array['idbus']=$row['id_bus'];
		$row_array['placa']=$row['placa'];
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
