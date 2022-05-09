<?php
  $con=mysqli_connect("db","user","passw0rd","transporte");
  if(ISSET($_POST['search'])) {
    $date1 = date("Y-m-d", strtotime($_POST['date1']));
    $date2 = date("Y-m-d", strtotime($_POST['date2']));
    $query=mysqli_query($con, "select tb3.nombre_sucursal, COUNT(case when tb1.id_tipo_documento='3' and tb1.id_sucursal=tb1.id_sucursal then 1 else null end) as MONTBOLETOS , COUNT(case when tb1.id_tipo_documento='1' then 1 else null end) as MONTFACTURAS ,tb2.nombre_usuario, SUM(CASE WHEN tb1.id_usuario_creador=tb2.id_usuario THEN precio_total ELSE 0 END) as montos, COUNT(case when tb1.id_tipo_documento='3' and tb1.id_sucursal=tb1.id_sucursal then 1 else null end) + COUNT(case when tb1.id_tipo_documento='1' then 1 else null end) AS total FROM tb_facturacion_cab tb1 INNER JOIN tb_usuarios tb2 ON tb1.id_usuario_creador=tb2.id_usuario INNER JOIN tb_sucursales tb3 ON tb1.id_sucursal=tb3.id_sucursal INNER JOIN tb_encomienda_cab tb4 on tb4.id_encomienda=tb1.id_facturacion and tb4.id_pago = 1 GROUP BY tb2.nombre_usuario ORDER BY tb2.nombre_usuario;") or die(mysqli_error($con));
    $row=mysqli_num_rows($query);
    if($row>0) {
      while($fetch=mysqli_fetch_array($query)) {
?>
  <tr>
    <td><?php echo $fetch['nombre_sucursal']?></td>
    <td><?php echo $fetch['MONTBOLETOS']?></td>
    <td><?php echo $fetch['nombre_usuario']?></td>
    <td><?php echo $fetch['total']?></td>
    <td><?php echo $fetch['montos']?></td>
  </tr>
<?php
        
      }
    }else {
      echo' <tr><td colspan = "5"><center>No existen Registros</center></td></tr>';
    }
  }else {
    $query=mysqli_query($con, "select tb3.nombre_sucursal, COUNT(case when tb1.id_tipo_documento='3' and tb1.id_sucursal=tb1.id_sucursal then 1 else null end) as MONTBOLETOS , COUNT(case when tb1.id_tipo_documento='1' then 1 else null end) as MONTFACTURAS ,tb2.nombre_usuario, SUM(CASE WHEN tb1.id_usuario_creador=tb2.id_usuario THEN precio_total ELSE 0 END) as montos, COUNT(case when tb1.id_tipo_documento='3' and tb1.id_sucursal=tb1.id_sucursal then 1 else null end) + COUNT(case when tb1.id_tipo_documento='1' then 1 else null end) AS total FROM tb_facturacion_cab tb1 INNER JOIN tb_usuarios tb2 ON tb1.id_usuario_creador=tb2.id_usuario INNER JOIN tb_sucursales tb3 ON tb1.id_sucursal=tb3.id_sucursal INNER JOIN tb_encomienda_cab tb4 on tb4.id_encomienda=tb1.id_facturacion and tb4.id_pago = 1 GROUP BY tb2.nombre_usuario ORDER BY tb2.nombre_usuario;") or die(mysqli_error($con));
    while($fetch=mysqli_fetch_array($query)) {
?>
  <tr>
    <td><?php echo $fetch['nombre_sucursal']?></td>
    <td><?php echo $fetch['MONTBOLETOS']?></td>
    <td><?php echo $fetch['nombre_usuario']?></td>
    <td><?php echo $fetch['total']?></td>
    <td><?php echo $fetch['montos']?></td>
  </tr>
<?php
      
    }
  }
?>