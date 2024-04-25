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
  <title>Logistics Freedom</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="modificarDatos.css">
</head>
<style>
  body {
    background-color: lavenderblush;
    margin: 4rem;
    margin-left: 32%;
    font-size: 3.2rem;
  }

  .modificarDatos {
    text-decoration: none;
  }

  .modificarDatos2 {
    text-decoration: none;
  }

  .modificarDatos:hover {
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    width: 30rem;
    background-color: burlywood;
    color: black;
    transition: all 1.3s linear;
  }

  .modificarDatos2:hover {
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
    width: 35rem;
    background-color: burlywood;
    color: black;
    transition: all 1.3s linear;
  }
</style>

<body class="modificar">
  <?php
  $conn = mysqli_connect("localhost", "root", "", "bd_stock");
  $id = $_POST['id'];
  $n_orden = $_POST['orden'];
  $proveedor = $_POST['prov'];
  $cant = $_POST['cantidad'];
  $sn = $_POST['sn'];
  //$detalle = $_POST['detalle'];

  $sql = "SELECT * FROM orden_compra WHERE n_orden = '$n_orden'";
  $resultado = $conn->query($sql);
  if ($resultado->num_rows > 0) {
    $sql = "UPDATE  orden_compra SET proveedor='$proveedor' WHERE n_orden = '$n_orden' ";
    if ($conn->query($sql) === true) {
    }
  } else {
    echo "Error...no se pudo modificar campos seleccionados.\nIntente nuevamente más tarde.";
  }
  $sql = "SELECT * FROM orden_compra WHERE id = '$id'";
  $resultado = $conn->query($sql);
  if ($resultado->num_rows > 0) {
    $sql = "UPDATE  orden_compra SET cant='$cant' WHERE id = '$id' ";
    if ($conn->query($sql) === true) {
      echo "
      <script>
        alert('Modificación Exitosa !!!');
        window.location = 'index.php?page=otrapagina'
      </script>";
    }
  } else {
    echo "Error...no se pudo modificar campos seleccionados.\nIntente nuevamente más tarde.";
  }

  $conn->close();
  ?>
  <br><br>
  <a class="modificarDatos" href="../2c2023-main">╚► Página Principal...</a><br><br>
  <a class="modificarDatos2" href="../modificar-ordenes/index.php">╚► Registro Administrativo DB...</a>
</body>

</html>