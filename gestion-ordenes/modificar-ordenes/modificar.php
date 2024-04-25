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

//$email = $varsession;

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

<body translate="no" class="text-bg-success">
  <h1 style="margin-left:30%; margin-top:2%; margin-bottom:3%;" class="tituloMod"> SISTEMA DE MODIFICACIÓN</h1>
  <?php

  $conn = mysqli_connect("localhost", "root", "", "bd_stock");
  $registro = $_POST['modificar'];
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


    <form style="margin-left:26%" class="formModificar" action="../modificar-ordenes/modificarDatos.php" method="post">

      <label for="disabledTextInput" class="form-label">ID - (no habilitado para modificación)</label>
      <input class="form-control" style="width: 300px; margin-bottom:3%;" type="text" readonly name="id"
        value="<?php echo $id ?>">

      <label for="disabledTextInput" class="form-label">N° Orden - (no habilitado para modificación)</label>
      <input class="form-control" style="width: 300px; margin-bottom:3%;" type="text" readonly name="orden"
        value="<?php echo $n_orden ?>">

      <label for="disabledTextInput" class="form-label">Administrador - (no habilitado para modificación)</label>
      <input class="form-control" style="width: 300px; margin-bottom:3%;" type="text" readonly name="idu"
        value="<?php echo $administrador ?>">

      <label for="disabledTextInput" class="form-label">SN Producto - (no habilitado para modificación)</label>
      <input class="form-control" style="width: 300px; margin-bottom:3%;" type="text" readonly name="sn"
        value="<?php echo $sn ?>">

      <?php
      $sql = "SELECT * FROM productos WHERE sn = '$sn' ";
      $resultado = $conn->query($sql);
      if ($resultado->num_rows > 0) {
        $fila = mysqli_fetch_array($resultado);
        $detalle = $fila[1];
        ?>
        <label for="disabledTextInput" class="form-label">Detalle Producto - (no habilitado para modificación)</label>
        <input class="form-control" style="width: 470px; height:40px; margin-bottom:3%;" type="text" readonly name="detalle"
          value="<?php echo $detalle ?>">
        <?php
      }
      ?>

      <div class="mb-1">
        <label for="exampleFormControlTextarea1" class="form-label">Proveedor</label><br>
        <textarea style="border-radius: 10px; padding:10px;" name="prov" id="prov" rows="2"
          cols="61"><?php echo $proveedor ?> </textarea>
      </div><br>

      <div class="mb-1">
        <label for="exampleFormControlTextarea1" class="form-label">Cantidad</label><br>
        <textarea style="border-radius: 10px; padding:10px; " name="cantidad" id="cantidad" rows="2"
          cols="61"><?php echo $cant ?> </textarea>
      </div>
      <br>
      <br>

      
      <input style="border-radius: 10px; background-color:cornflowerblue; 
      font-size:1.2rem; width: 100px; height: 40px; " class="botonModificar" type="submit" value="Modificar">

      <a class="botonModificar" style="margin-left: 30px;
      color:darkred;  font-size:1.5rem;
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