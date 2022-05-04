<?php
if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array();
/* If connection to database, run sql statement. */
if ($con)
{	
	//$tipdoc = ($_GET['d'] == "03") ? 1 : 2;
	if ($_GET['d']=="0") {
		$tipdoc = "where id_tipo_persona in (1,2)";
	}else if ($_GET['d'] == "03"){
		$tipdoc = "where id_tipo_persona =1";
	}else{
		$tipdoc = "where id_tipo_persona =2";
	}

	$sql ="SELECT * FROM tb_cliente $tipdoc and n_documento_identidad like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50";
	//print_r($sql);
	$fetch = mysqli_query($con,$sql); 

	//print_r($fetch);
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		//$id_cliente=$row['id_cliente'];
		$row_array['value'] = $row['n_documento_identidad'];
		//print_r($row);
		$row_array['id_cliente']=$row['id_cliente'];
		$row_array['nombre_cliente']=$row['nombre_cliente'];
		$row_array['documentoidentidad']=$row['n_documento_identidad'];
		$row_array['direcc']=$row['direccion'];
		array_push($return_arr,$row_array);
    }
	
}

/* Free connection resources. */
mysqli_close($con);
	//		print_r($return_arr);

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
?>