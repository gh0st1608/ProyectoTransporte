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
	$active_productos="";
	$active_usuarios="active";
	$title="Productividad | Expreso Lima E.I.R.L";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="icon"  href="img/expreso.jpg">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <?php include("head.php");?>
  </head>
  <style type="text/css">
    #bs-example-navbar-collapse-1{margin-top: -20px;}
  </style>
<body>
  <?php include("navbar.php"); ?>
  <style type="text/css">
    .ui-autocomplete {z-index: 215000000 !important;}
  </style>
  <div class="col-md-3"></div>
  <div class="col-md-6 well">
    <h3 class="text-primary">Reporte de productividad por Usuario</h3>
    <hr style="border-top:1px dotted #000;"/>
    <form class="form-inline" method="POST" action="">
      <label>Fecha Desde:</label>
      <input type="date" class="form-control" placeholder="Start"  name="date1"/>
      <label>Hasta</label>
      <input type="date" class="form-control" placeholder="End"  name="date2"/>
      <button class="btn btn-primary" name="search"><span class="glyphicon glyphicon-search"></span></button> <a href="productividad.php" type="button" class="btn btn-success"><span class = "glyphicon glyphicon-refresh"><span></a>
    </form>
    <br /><br/>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="alert-info">
          <tr>
            <th>Sucursal</th>
            <th>Boletos</th>
            <th>Usuario</th>
            <th>Total</th>
            <th>Monto total</th>
          </tr>
        </thead>
        <tbody>
          <?php include'busquedaproductividad.php'?>
        </tbody>
      </table>
    </div>
    <a href="usuarios.php" class="btn btn-success" style="float: right;">Regresar</a>
    <!-- <p align="right"><a href="usuarios.php" class="btn btn-success">Regresar</a></p> -->
  </div>
  <?php include("footer.php"); ?>
</body>
</html>