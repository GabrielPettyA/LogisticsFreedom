<?php
session_start();
error_reporting(0);
$varsession = $_SESSION['email'];
$roles = $_SESSION['roles'];
if ($varsession == null || $varsession == '') {
  header("Location:http://localhost/tp2/");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logistics Freedom</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
  body {
    background-color: wheat;
  }
</style>



<body translate="no">

  <?php

  if (isset($_POST['mensaje']) < 0) {
    echo "Debe ingresar motivos de baja !!!";
  }
  if (isset($_POST['mensaje']) > 0) {
    $conn = mysqli_connect("localhost", "root", "", "bd_stock");

    $orden = $_POST['orden'];
    $adm = $_POST['administrador'];
    $estado = 'Alta';
    $mensaje = $_POST['mensaje'];
    $estadoActual = $_POST['estadoActual'];

    $sql = "SELECT * FROM orden_compra WHERE n_orden = '$orden' ";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
      if ($estado == true && $estadoActual == 'Alta') {
        $sql = "UPDATE  orden_compra SET administrador = '$adm' , estado_orden = '$estado' , motivo_orden = '$mensaje' WHERE n_orden = '$orden' ";
        if ($conn->query($sql) == true) {
          ?>

          <h2>Baja Exitosa !!!</h2>
          <a href="../modificar-ordenes/index.php"> volver </a>

          <?php
          
        }
      } else { ?>



        <h2>N° Orden ya dada de baja !!!</h2>
        <a href="../modificar-ordenes/index.php"> volver </a>

        <?php





      }


    } else {
      echo "Error de carga, Verifique N° orden o Estado de la misma...";
    }


    $conn->close();

  }

  ?>

</body>

</html>