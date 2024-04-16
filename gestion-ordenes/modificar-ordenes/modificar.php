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
  <link rel="stylesheet" href="css/mod.css">
  <link rel="stylesheet" href="../styles/mod.css">
  <title>Modificar</title>
</head>

<?php

$conn = mysqli_connect("localhost", "root", "", "bd_stock");
$registro = $_POST['idu'];
$sql = "SELECT * FROM orden_compra WHERE id = '$registro' ";
$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
  $fila = mysqli_fetch_array($resultado);
  $id = $fila[0];
  $n_orden = $fila[1];
  $fecha_orden = $fila[2];
  $proveedor = $fila[3];
  $administrador = $fila[4];
  $sn = $fila[5];
  $cant = $fila[6];
  $estado_orden = $fila[7];
  $motivo_orden = $fila[8];
  ?>

  <body translate="no" class="bodyModificar" translate="no">
    <h1 class="tituloMod"> SISTEMA DE MODIFICACIÓN</h1>
    <form class="formModificar" action="../modificar-ordenes/modificarDatos.php" method="post">
      <h2>id:</h2>(no habilitado para modificación) <br>
      <input class="ind" type="text" readonly name="id" value="<?php echo $id ?>"><br><br>
      <h2>n_orden:</h2>(no habilitado para modificación) <br>
      <input class="ind" type="text" readonly name="orden" value="<?php echo $n_orden ?>"><br><br>
      <h2>administrador:</h2>(no habilitado para modificación) <br>
      <input class="ind" type="text" readonly name="idu" value="<?php echo $administrador ?>"><br><br>
      <h2>sn_producto:</h2>(no habilitado para modificación) <br>
      <input class="ind" type="text" readonly name="sn" value="<?php echo $sn ?>"><br><br>
      <?php
      $sql = "SELECT * FROM productos WHERE sn = '$sn' ";
      $resultado = $conn->query($sql);
      if ($resultado->num_rows > 0) {
        $fila = mysqli_fetch_array($resultado);
        $detalle = $fila[1];
        ?>
        <h2>detalle_producto:</h2>(no habilitado para modificación) <br>
        <input style="width: 460px; height: 70px; " class="ind" type="text" readonly name="detalle" value="<?php echo $detalle ?>"><br><br>
      <?php
      }
      ?>
      <h2>proveedor:</h2><br>
      <div class="contenedorMensaje">
        <textarea name="prov" id="prov" rows="5" cols="61"><?php echo $proveedor ?> </textarea>
      </div>

      <h2>cantidad:</h2><br>
      <div class="contenedorMensaje">
        <textarea name="cantidad" id="cantidad" rows="5" cols="61"><?php echo $cant ?> </textarea>
      </div>

      <br>
      <br>
      <input class="botonModificar" type="submit" value="Modificar">

      <a class="botonModificar" style="margin-left: 10px;
      color:red; text-decoration:none;border:groove;
      font-family:Georgia, 'Times New Roman', Times, serif;
      " href="../modificar-ordenes/index.php">Cancelar</a>
      <br>
      <br>
      <br>
    </form>

    <?php
} else {

  echo 
  "<script>
  alert('Se requiere : ID para ingresar !!!');
  window.location='index.php?page=otrapagina'
  </script>";
}
$conn->close();
?>
</body>
</html>