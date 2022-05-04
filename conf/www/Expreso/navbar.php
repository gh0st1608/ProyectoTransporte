 <?php
    if (isset($title))
    {
  ?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand"><?php echo $_SESSION['sucursal']; ?></a>
    </div>

     <?php 
      require_once ("config/db.php");
      require_once ("config/conexion.php");
      require_once("classes/Login.php");
          
          $query="select * from tb_usuarios where id_usuario='".$_SESSION['user_id'] ."'";
          $result_query=mysqli_query($con,$query);
          $row_navbar= mysqli_fetch_array($result_query);
          $rol = $row_navbar['id_rol'];
        
      if($rol == 1)
        { 

   ?>
     <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Clientes</a></li>
      <li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-lock'></i> Usuarios</a></li>
      <li class="<?php echo $active_encomienda;?>"><a href="encomienda.php"><i  class='glyphicon glyphicon-lock'></i> Encomienda</a></li>
       
    </ul> 
    <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      <li>
        <a>
          <span class="hidden-xs"><?php echo $_SESSION['user_name']; ?></span>
        </a> 
      </li>
    </ul>
  </div>
  <?php 
    }else{
  ?>
   <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Clientes</a></li>
      <li class="<?php echo $active_encomienda;?>"><a href="encomienda.php"><i  class='glyphicon glyphicon-lock'></i> Encomienda</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      <li>
        <a>
          <span class="hidden-xs"><?php echo $_SESSION['user_name']; ?></span>

        </a>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
  <?php
    }
  ?>

  </div><!-- /.container-fluid -->
</nav>
  <?php
    }
  ?>