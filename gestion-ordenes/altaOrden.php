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
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <title>Logistics Freedom</title>
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  
</head>
<style>
  body {
    background-image: linear-gradient(89deg, var(--blue), var(--green));
    width: 100%;
    height: 100%;
    display: inline-block;

  }

  #notificacion {
    justify-content: center;
    text-align: center;
    margin-top: 15px;
    margin-bottom: 3%;
  }

  .alert {
    margin-top: 8%;
    width: 30%;
    margin-left: 20px;
    transition: all 1.8s ease;
    display: flex;
  }

  .alert:hover {
    background-color: cadetblue;
    width: 96%;
  }

  .alert-link {
    color: black;
    font-family: 'Times New Roman', Times, serif;
    font-size: x-large;
    text-decoration: none;
  }

  .alert-link:hover {
    color: white;
  }

  .alert-secondary{
    min-width: 165px;
  }
</style>

<body translate="no">
  <h1 id="notificacion">SN - Ingresos"</h1>

  <?php
//genera orden de compra de manera automática
  require ("../gestion-ordenes/generate.php");
   
  // Lista los datos encontrados en la DB. para posteriormente ser insertados
  require ("../includes/config/db-config.php");
  
  if (isset($_POST["producto"])) {
    $prov = $_POST['prov'];
      $cuit = require("../gestion-ordenes/validarCuit.php");
      
      $adm = $email;
      $estado = 'SOLICITADA';
      $motivo = '';
      $fecha = $_POST['date'];
      $orden = $ordenCompra;
      $fechaRecep = 0;
      $admRecep = 'pendiente';
      $cantRecep = 0;
    foreach ($_POST['producto'] as $indice => $prod) {
      $cantidad = $_POST['cantidad'][$indice];
      

      if ($cuit == true) {
        $validar = "SELECT * FROM productos WHERE sn = $prod";
        $validando = $conexion->query($validar);
        if ($validando->num_rows > 0) {
          
          $sql = "INSERT INTO orden_compra (n_orden,fecha_orden,proveedor,cuit,administrador,sn,cant,fecha_recep,adm_recepcion,cant_recep,estado_orden,motivo_orden) VALUE ('$orden','$fecha','$prov','$cuit','$adm','$prod','$cantidad','$fechaRecep','$admRecep','$cantRecep','$estado','$motivo')";
          $guardando = $conexion->query($sql);
          $prodok=$prod;

        } else {
          $validar = "SELECT * FROM productos WHERE sn = $prod";
          $validando = $conexion->query($validar);
          if ($validando->num_rows != $_POST['producto']) {
            $prodNo=$prod;
            ?>
            <h4 style="margin-left:20px;">SN no encontrado en BD. regístrelo en 'Alta de productos':</h4>
            <br>
            <h2 style="color: white; display:flex; justify-content:center; align-items: center; ">
              <?php echo $prod ?>
            </h2>
            <?php
          }
        }
      }
    }
  }

  $conexion->close();
  ?>

  <div class="alert alert-secondary" role="alert">
    <a href="../gestion-ordenes/index.php" class="alert-link">Volver 'Alta Orden de Compra'</a>
  </div>

  <?php
  if ($prodNo == true && $prodok == false) {
  }
  if ($prodok == true && $prodNo == false) {
    ?>
    <div style="margin-left: 20px;">
      <h1> SN cargados en DB: </h1>
      <h1> N° de Orden = <?php echo $orden ?></h1>
    </div>
  <?php
  }
  if ($prodNo == true &&  $prodok == true) {
    ?>
    <div style="margin-left: 20px;">
      <h1> SN correctos, ingresados a DB con: </h1>
      <h1> N° de Orden = <?php echo $orden ?></h1>
    </div>
    <br>
  <?php
  }

  

  ?>
  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <script src="obtenerAlarmas.js"></script>

</body>


</html>