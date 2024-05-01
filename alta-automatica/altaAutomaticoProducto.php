<?php
session_start();
error_reporting(0);
$varsession = $_SESSION['email'];
if ($varsession == null || $varsession == '') {
  header("Location:http://localhost/tp2/");
}

// session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logistic freedom</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="../styles/alta-automatica-producto.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

  <nav class="navbar bg-body-tertiary fixed-top" style="padding: 0;">

    <div class="container-fluid">

      <div>
        <a class="navbar-brand" href="#">
          <img class="imageNav" src="../images/favicon.png" alt="logo">
        </a>

        <a class="btn btn-warning m-1" href="../includes/api/auth-api/logout.php"> Cerrar session </a>
      </div>

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/tp2/alta-productos">Alta de productos</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/tp2/gestion-usuarios/">Gestión de usuarios</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/tp2/reportes/">Reportes</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/tp2/stock/">Stock</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/tp2/contacto/">Contacto</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/tp2/revisar-contacto/">Revisar contacto</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/tp2/gestion-ordenes/">Gestión de órdenes</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/tp2/recepcion-ordenes/">Recepción de Órdenes</a>
            </li>

          </ul>

        </div>

      </div>

    </div>

  </nav>

  <?php

  require("../includes/config/db-config.php");
  require "../includes/api/alarmas-reposicion-api/servAlarmas.php";


  $sql = "INSERT INTO productos (name,sn,cant) VALUES 
  ('Computadora acrílica zxl 520','7799123456789','10'),
  ('Torre de computos xL','7799789456123','10'),
  ('Monitor Samsung 475RD3','7799147258369','10'),
  ('Router SeGeMCOM','7799321654987','10'),
  ('Placa para ventilación tz1025','7799987654321','10'),
  ('Fuente de poder 600hz','7799741852963','10'),
  ('Reproductor de señal AXR 1000/TR','7799852963741','10'),
  ('Estabilizador MACO x6efe','7799159123456','10'),
  ('Fuente mather xscoria REmado','7799111456332','10'),
  ('Gabinete acrílico R70pro','7799753464221','10')";

  $consulta = "SELECT * FROM productos";
  $resultado = $conexion->query($consulta);

  if ($resultado->num_rows > 0) {
    echo '<section> 

    <h1> No se ha ejecutado la carga automática </h1>

    <p> <span class="text-danger" style="font-weight:bold;">Error:</span> No es posible ejecutar el alta masiva si la base de datos posee registros.
    La funcionalidad está pensada para poder generar datos cuando la base de datos esta vacía y poder ejecutar pruebas. </p>
    
    <div class="botones"> 
      <a class="btn btn-primary" href="/tp2/alta-productos"> Volver a stock </a>
    </div>
    
    </section>';
  } elseif ($resultado->num_rows == 0) {
    
    $result = $conexion->query($sql);

    $sql = "SELECT * FROM productos";
    $productosQuery = $conexion->query($sql);

    if ($productosQuery->num_rows > 0) {

      $alarmaServ = new AlarmaService($conexion);

      while ($row = $productosQuery->fetch_assoc()) {

        $productoFK = $row["id"];
        $alarmaCreada = $alarmaServ->crearAlarma($productoFK);

      }

      $alarmaServ->cerrarConexion();

    }


    echo '<section> 

    <h1>  Carga de Datos Exitosa </h1>

    <p> <span class="text-success" style="font-weight:bold;">Información:</span> Se han cargado 10 productos de manera automática. Se podrán realizar todas las
    gestiones referidas al manejo de productos con esta información. </p>
    
    <div class="botones"> 
      <a class="btn btn-primary" href="/tp2/alta-productos"> Volver a stock </a>
    </div>
    
    </section>';
  } else {

    echo '<section> 

    <h1> Ha ocurrido un error </h1>

    <p> <span class="text-danger" style="font-weight:bold;">Error:</span> No se ha podido realizar la carga automatica. Vuelva a intentarlo
    más tarde. Si el problema persiste por favor informe al administrador. </p>
    
    <div class="botones"> 
      <a class="btn btn-primary" href="/tp2/alta-productos"> Volver a stock </a>
    </div>
    
    </section>';
  }


  $conexion->close();


  ?>



  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>