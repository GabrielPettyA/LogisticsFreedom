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
  <title>Logistics freedom</title>
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


<?php
// SE OBTIENEN LOS INPUT DEL FORMULARIO Y ANALISAN LAS VARIABLES JUNTO A LA EXISTENCIA EN DB.

$conn = mysqli_connect("localhost", "root", "", "bd_stock");
$ordenRecep = $_POST['orden'];
$fechaRecep = $_POST['date'];
$admRecep = $varsession;
$prodRecep = $_POST['prod'];
$cantRecep = $_POST['cant'];
$estadoRecep = 'ENTREGADA';
$terminar = $_POST['cancelar'];


$conn = mysqli_connect("localhost", "root", "", "bd_stock");

require ("../includes/api/stock-api/servModStock.php");

// SE OBTIENEN LOS DATOS GUARDADOS EN DB. DE LA ORDEN DE COMPRA SOLICITADA

$sql = "SELECT * FROM orden_compra WHERE sn = '$prodRecep' ";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
  $fila = mysqli_fetch_array($resultado);
  $id = $fila[0];
  $n_orden = $fila[1];
  $fecha_orden = $fila[2];
  $proveedor = $fila[3];
  $administrador = $fila[5];
  $sn = $fila[6];
  $cant = $fila[7];
  $estado_orden = $fila[11];
  $motivo_orden = $fila[12];

  /* SE DECLARAN LAS INSTANCIAS QUE SE DEBEN CUMPLIR PARA PODER REALIZAR LA CARGA DE LO INGRESADO POR 
     FORMULARIO ACTUALIZANDO LA ORDEN DE COMPRA Y SU "SN" CORRESPONDIENTE */
  if ($estado_orden == 'RECHAZADA' || $estado_orden == 'DADA DE BAJA' || $estado_orden == 'ENTREGADA') {
    ?>
    <div style="color:white; background-color: darkred; " class="navbar-toggler">
      <h4> ALERT: dato incorrecto, Verifique ''orden'' o ''sn''.</h4>
    </div>
    <?php

  } else if ($cantRecep > $cant || $cantRecep < 0 /*|| $sn != $prodRecep*/) {
    ?>
      <div style="color:white; background-color: darkred; " class="navbar-toggler">
        <h4> ERROR: Cantidad de ''sn'' incorrecta.</h4>
      </div>
    <?php

  } else {

    $sql = "SELECT * FROM productos WHERE sn = '$prodRecep' ";
    $resultado = $conn->query($sql);
    if ($resultado->num_rows > 0) {
      $fila = mysqli_fetch_array($resultado);
      $idOld = $fila[0];
      $nameOld = $fila[1];
      $snOld = $fila[2];
      $cantOld = $fila[3];
      $cantTotal = $cantOld + $cantRecep;
      $motivoRecep = "RECEPCION ORDEN DE COMPRA";

      $mod = "INSERT INTO mod_stock (id_old,name_old,sn_old,cant_old) VALUE ('$idOld','$nameOld','$snOld','$cantOld')  ";
      if ($conn->query($mod) == TRUE) {
        $resul = "UPDATE mod_stock SET id_new='$id', name_new='$nameOld', sn_new='$prodRecep', cant_new='$cantTotal', fecha='$fechaRecep', motivo='$motivoRecep' WHERE sn_old = '$prodRecep' ";
        if ($conn->query($resul) === true) {
          $dato = "UPDATE  productos SET cant='$cantTotal' WHERE sn= '$prodRecep' ";
          if ($conn->query($dato) === true ) {
            $dato3 = "UPDATE  orden_compra SET fecha_recep='$fechaRecep', adm_recepcion='$admRecep', cant_recep='$cantRecep', estado_orden='$estadoRecep' WHERE sn= '$prodRecep' ";
            if ($conn->query($dato3) === true) {

              ?>
                <h3><strong>Cargando correctamente, CONTINUE...</strong></h3>
              <?php
             
             
            }
          }
        }
      }
    } else {
      echo "Error...proceso fallido, Intente nuevamente más tarde.";
    }
  }
}

$conn->close();
?>


<?php
// ACA VA EL NUEVO CÓDIGO CON EL BOTÓN FINALIZAR
?>



<?php
// SE OBTIENEN LOS DATOS INGRESADOS POR FORMULARIO DE ARCHIVO INDEX.PHP DE SECTOR RECEPCION-ORDENES

if (isset($_POST["orden"]) < 0) {
  echo "Verifique Orden de compra";
} else {
  $orden = $_POST['orden'];
  $fechaRecep = $_POST['date'];
  $recep = $varsession;


  ?>
  <!-- SE REALIZA FORMULARIO PARA MOSTRAR DATOS OBTENIDOS Y DERIVARLOS AL ACTUAL ARCHIVO
       UTILIZANDO "($_SERVER['PHP_SELF']);" -->

  <body>
    <nav class="navbar bg-body-tertiary fixed-top" style="padding: 0;">
      <div class="container-fluid">
        <div>
          <a class="navbar-brand" href="#">
            <img class="imageNav" src="../images/favicon.png" alt="logo">
          </a>
          <a class="btn btn-warning m-1" href="../includes/api/auth-api/logout.php"> Cerrar session </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
          aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
              <?php
              if (in_array("alta productos", $roles)) {
                echo '<li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/tp2/alta-productos">Alta de productos</a>
                            </li>';
              }
              if (in_array("gestion usuarios", $roles)) {
                echo '<li class="nav-item">
                                <a class="nav-link" href="/tp2/gestion-usuarios/">Gestión de usuarios</a>
                            </li>';
              }
              if (in_array("reportes", $roles)) {
                echo '  <li class="nav-item">
                                <a class="nav-link" href="/tp2/reportes/">Reportes</a>
                                </li>';
              }
              if (in_array("stock", $roles)) {
                echo '<li class="nav-item">
                            <a class="nav-link" href="/tp2/stock/">Stock</a>
                            </li>';
              }
              if (in_array("contacto", $roles)) {
                echo '<li class="nav-item">
                                <a class="nav-link" href="/tp2/contacto/">Contacto</a>
                            </li>';
              }
              if (in_array("revisar contacto", $roles)) {
                echo '<li class="nav-item">
                                <a class="nav-link" href="/tp2/revisar-contacto/">Revisar contacto</a>
                            </li>';
              }
              if (in_array("gestion ordenes", $roles)) {
                echo '<li class="nav-item">
                                <a class="nav-link" href="/tp2/gestion-ordenes/">Gestión de órdenes</a>
                            </li>';
              }
              if (in_array("recepcion ordenes", $roles)) {
                echo '<li class="nav-item">
                                    <a class="nav-link" href="/tp2/recepcion-ordenes/">Recepción de órdenes</a>
                                    </li>';
              }
              ?>
              <li class="nav-item">
                <a class="nav-link" href="/tp2/historia/">Historia</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <dbody class="cardSection">

      <h1 class="title" style="margin-top: 2%;  text-shadow: 4px 5px 5px black; "> Sistema Recepción de órdenes</h1>
      <h4 style="margin-left:8px; margin-top:40px; "> Recepcionista : <?php echo $email ?> </h4>

      <form class="formulario" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">

        <div>
          <label style="margin-left: 67px; width:100px; " for="date" class="form-label mt-2 mb-1"> Fecha de
            Recepción:</label>
          <input type="text" name="date" id="date" placeholder="" readonly value="<?php echo $fechaRecep ?>">
        </div>

        <div class="mb-3">
          <br>
          <br>
          <label style="margin-left: 10px;" for="prov" class="form-label"> N° orden de recepción</label>
          <input type="text" class="form-control" name="orden" id="orden" placeholder="" readonly
            value="<?php echo $orden ?>">
        </div>
        <br>

        <div>
          <span style="margin-left: 7px; ">SN. - recepción:</span>
          <input style="margin-left: 8px;" type="text" name="prod" id="sn" placeholder="Ingrese sn." required
            autocomplete="off" minlength="13" maxlength="13">
        </div>
        <br>
        <div>
          <span style="margin-left: 7px;">Cant recepción:</span>
          <input type="text" name="cant" id="cant" placeholder="Ingrese unidad." required autocomplete="off" min="0"
            step="1" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
        </div>

        <input type="submit" class="btn btn-success mb-3 mt-5" style="margin-left: 7px; " id="Cargar" value="INGRESAR">
        </input>


<!-- ESTE INPUT ES AGREGADO PARA VER SI SE PUEDE REGISTRAR TODOS LOS SN EN 0 ANUNCIANDOLO AL USUARIO, CASO CONTRARIO IRÍA EL INPUT DE ABAJO -->
        <input class="btn btn-primary  mb-3 mt-5" style="margin-left: 15px;" type="button" name="cancelar"
        value="FINALIZAR" onclick="location.href='../recepcion-ordenes/index.php'">


      </form>

      <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
  </body>

  </html>
  <?php
}
?>