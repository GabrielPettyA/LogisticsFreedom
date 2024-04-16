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
        $sql = "INSERT INTO orden_compra (n_orden,fecha_orden,proveedor,administrador,sn,cant,estado_orden,motivo_orden) VALUE ('$orden','$fecha','$prov','$adm','$prod','$cantidad','$estado','$motivo')";
        $guardando = $conexion->query($sql);

      } else {
        $validar = "SELECT * FROM productos WHERE sn = $prod";
        $validando = $conexion->query($validar);
        if ($validando->num_rows != $_POST['producto']) {
          ?>

          <br>
          <h2 style="color: blue; margin-left: 20px; width: 96%; background-color:green;"> <?php echo "=►" . $prod . '<hr />'; ?>
          </h2>

          <?php
        }
      }
    }
  }
}
$conexion->close();

?>
<div style="background-color: green; width: 96%; height:auto; margin-left:20px; margin-right:20px;">
  <br>
  <h2 style="justify-content: center; text-align:center;  "> SN a ingresar por "Alta de productos" </h2>
  <a style="text-decoration: none;" href="../gestion-ordenes/">
    <h2
      style="margin-left: 20px; margin-top: 15%; width:60vh; font-family:Georgia, 'Times New Roman', Times, serif; color: wheat; ">
      Volver a
      'Gestión de órdenes...'</h2>
  </a>
  <div>
    <h1> N° de Orden Generada= <?php echo $orden ?></h1>
  </div>

</div>

<?php

?>