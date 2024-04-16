<?php
session_start();
error_reporting(0);
$varsession = $_SESSION['email'];
$roles = $_SESSION['roles'];
if ($varsession == null || $varsession == '') {
  header("Location:http://localhost/tp2/");
}

if (!in_array("gestion ordenes", $roles)) {
  header("Location:http://localhost/tp2/inicio/");
}

$email = $varsession;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Document</title>
</head>
<style>
  body {
    background-color: gren;
    width: 100%;
    height: 100%;
    padding: 0;
  }

  #notificacion {
    justify-content: center;
    text-align: center;
    margin-top: 15px;
  }
</style>

<body translate="no">
  <h1 id="notificacion">SN - Ingresos"</h1>




  <?php
  require ("../gestion-ordenes/generate.php");
  //echo $ordenCompra;
  
  require ("../includes/config/db-config.php");
  if (isset($_POST["producto"])) {
    foreach ($_POST['producto'] as $indice => $prod) {
      $cantidad = $_POST['cantidad'][$indice];
      $prov = $_POST['prov'];
      $adm = $email;
      $estado = 'Alta';
      $motivo = 'Compra';
      $fecha = $_POST['date'];
      $orden = $ordenCompra;

      if ($prod == true) {
        $validar = "SELECT * FROM productos WHERE sn = $prod";
        $validando = $conexion->query($validar);
        if ($validando->num_rows > 0) {
          $prodok = $prd;
          $sql = "INSERT INTO orden_compra (n_orden,fecha_orden,proveedor,administrador,sn,cant,estado_orden,motivo_orden) VALUE ('$orden','$fecha','$prov','$adm','$prodok','$cantidad','$estado','$motivo')";
          $guardando = $conexion->query($sql);
          

        } else {
          $validar = "SELECT * FROM productos WHERE sn = $prod";
          $validando = $conexion->query($validar);
          if ($validando->num_rows != $_POST['producto']) {
            
            ?>
            <h4 style="margin-left:20px;">SN no encontrado en BD. regístrelo en 'Alta de productos</h4>
            <br>
            <h2 style="color: orange; margin-left: 20px; width: 96%; background-color:green;">
              <?php echo " *". $prod."*" ?>
            </h2>
            <?php
          }
        }
      }
    }
  }
  $conexion->close();
  
  ?>
  <div style="background-color: blue; width: 96%; height:240px; margin-left:20px; margin-right:20px; margin-top:13%">
    <br>
    <a style="text-decoration: none;" href="../gestion-ordenes/">
      <h2
        style="margin-left: 20px; margin-top: 12%; width:70vh; font-family:Georgia, 'Times New Roman', Times, serif; color: wheat; ">
        Volver a
        'Gestión de órdenes...'</h2>
    </a>
    <div style="margin-left: 20px; margin-top:2%">
      <h1> N° de Orden = <?php echo $orden ?></h1>
    </div>

  </div>



  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</body>

</html>