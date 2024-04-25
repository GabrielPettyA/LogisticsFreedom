<?php 

session_start();
error_reporting(0);
$varsession = $_SESSION['email'];
$roles = $_SESSION['roles'];
if ($varsession == null || $varsession == '') {
  header("Location:http://localhost/tp2/");
}

if (!in_array("recepcion ordenes", $roles)) {
  header("Location:http://localhost/tp2/inicio/");
}

$email = $varsession;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <title>Logistic freedom</title>
  <link rel="stylesheet" href="../styles/alta-productos.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="stylesheet" href="../styles/orden.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>


<body>
</body>


<?php 



if (!isset($_POST["orden"])) {

  echo"aca no";
  
}else{
  
  
  $orden = $_POST["orden"];
  $fechaRecep = $_POST['date'];
  $snRecep = $_POST["producto"];
  $cantRecep = $_POST["cantidad"];

  require_once("../includes/config/db-config.php");

  /* ESTO NO ESTA FUNCIONANDO !!!
  $buscar = "SELECT * FROM productos WHERE sn = '$snRecep' ";
  $resultado = $conexion->query($buscar);
  if (mysqli_num_rows($resultado) > 0) {
    foreach ($query_run as $fila) {
      $snPedido= $fila['sn'];
      if ($snPedido <= $snRecep){*/

        $valor = "UPDATE orden_compra SET fecha_recep='$fechaRecep', adm_recepcion='$varsession', cant_recep='$cantRecep' WHERE sn='$snRecep'";
        if ($conexion->query($valor)){
          echo "acaaa vamosssosos !!!";
        }
      /*}else{
        echo "ERROR: Cantidad superior a solicitada, ".$snPedido;
      }
    }
  }else{
    echo "ERROR: no se encuentra registro de SN solicitado.";
  }*/
  

  }

  $conexion->close();

?>

</html>