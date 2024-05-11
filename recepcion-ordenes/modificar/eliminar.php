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
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <title>Logistics Freedom</title>
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

  .anuncio {
    justify-content: center;
    text-align: center;
    margin: 12%;
    font-family: 'Times New Roman', Times, serif;
    font-size: 3rem;
  }
</style>

<body translate="no">

  <?php
  // LLAMADO Y LÓGICA PARA REALIZAR LAS HABILITACIONES, SEGÚN EL ESTADO REQUERIDO, A LOS CAMBIOS EN DB.

  if (isset($_POST['orden']) < 0) {
    echo "Debe ingresar motivos de baja !!!";
  }
  if (isset($_POST['orden']) > 0) {
    $conn = mysqli_connect("localhost", "root", "", "bd_stock");

    $orden = $_POST['orden'];
    $admRecep = $varsession;
    $fechaRecep = $_POST['date'];
    $estadoReal = $_POST['estadoReal'];
    $mensaje = $_POST['mensaje'];
    $estadoActual = $_POST['estadoActual'];

    if ($estadoActual == 'Opción: Cambiar Estado' || $estadoActual == $estadoReal) {
      header("Location:http://localhost/tp2/recepcion-ordenes");
    } else {

      $sql = "SELECT * FROM orden_compra WHERE n_orden = '$orden' ";
      $resultado = $conn->query($sql);
      if ($resultado->num_rows > 0) {
        if ($estadoReal == 'RECHAZADA') {
          
          ?>
          <h2 class="anuncio">ERROR : estado ''RECHAZADA''  N° Orden <?php echo '"' . $orden . '"' ?>(no habilitada a
            modificación).<br>
            <a href="../modificar/modificar.php"> volver </a>
          </h2>
          <?php
        }else if ($estadoReal == 'DADA DE BAJA') {
          
          ?>
          <h2 class="anuncio">ERROR : estado ''DADA DE BAJA''  N° Orden <?php echo '"' . $orden . '"' ?>(no habilitada a
            modificación).<br>
            <a href="../modificar/modificar.php"> volver </a>
          </h2>
          <?php
        }else if ($estadoReal == 'ENTREGADA') {
          
          ?>
          <h2 class="anuncio">ERROR : estado ''ENTREGADA''  N° Orden <?php echo '"' . $orden . '"' ?>(no habilitada a
            modificación).<br>
            <a href="../modificar/modificar.php"> volver </a>
          </h2>
          <?php
        }else{
          $sql = "UPDATE  orden_compra SET fecha_recep='$fechaRecep', adm_recepcion='$admRecep' , estado_orden='$estadoActual' , motivo_orden='$mensaje' WHERE n_orden='$orden' ";
          if ($conn->query($sql) == true) {
            ?>
            <h2 class="anuncio">ALERT : Modificación en DB. Exitosa, N° orden: <?php echo '"'.$orden.'"' ?><br>
              <a href="../modificar/modificar.php "> volver </a>
            </h2>
            <?php
          } 
        }        
      }
    }
    $conn->close();
  }

  ?>

</body>

</html>