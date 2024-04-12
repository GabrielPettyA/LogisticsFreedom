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
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <title>Logistic freedom</title>
  <link rel="stylesheet" href="../styles/alta-productos.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<?php
if (isset($_POST['sn']) < 0) {
  ?>
  <script type="text/javascript">
    alert("Ingrese Producto para continuar");
  </script>';
  <?php
}
if (isset($_POST['sn']) > 0) {

  $adm = $email;
  $prov = $_POST['prov'];
  $ean = $_POST['sn'];
  $cant = $_POST['cant'];


  require ("../includes/config/db-config.php");
  $validar = "SELECT * FROM productos WHERE sn = '$ean'";
  $validando = $conexion->query($validar);
  if ($validando->num_rows > 0) {
    ?>
    <script type="text/javascript">
      alert("PRODUCTO REGISTRADO EN SU DB...PROSIGA CON CARGA DE ORDEN");
    </script>';

    <?php
    $validar = "SELECT * FROM orden_compra WHERE sn = $'ean'";
    $validando = $conexion->query($validar);
    if ($validando->num_rows > 0) {
      $n_orden = "55555";
      $estado = 'pendiente de entrega';
      $motivo = 'alta orden';
      $sql = "INSERT INTO orden_compra (n_orden,proveedor,administrador,sn,cant,estado_orden,motivo_orden) VALUE ('$n_orden','$prov','$adm','$ean','$cant','$estado','$motivo')";
      $guardando = $conexion->query($sql);
      if ($guardando === true) {
        ?>
        <script type="text/javascript">
          alert("orden de compra generada exitosamente, puede seguir operando.");
        </script>';
        <?php
      } else { ?>
        <script type="text/javascript">
          alert("Error en la carga, intente muevamente.");
        </script>';
        <?php
      }

    } else {
      ?>
      <script type="text/javascript">
        alert("Producto sin registrar en DB. Genere alta de producto.");
      </script>
      <?php
    }



  }
  $conexion->close();
}
?>

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

            ?>

            <li class="nav-item">
              <a class="nav-link" href="/tp2/historia/">Historia</a>
            </li>

          </ul>

        </div>

      </div>

    </div>

  </nav>

  <section class="cardSection">

    <h1 class="title"> Alta Orden de Compra</h1>
    <form class="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <h4> Administrador : <?php echo $email ?> </h4>

      <div class="mb-3">
        <label for="prov" class="form-label">Nombre proveedor:</label>
        <input type="text" class="form-control" name="prov" id="prov" placeholder="Ingrese proveedor." required>
      </div>

      <div class="mb-3">
        <label for="prov" class="form-label">SN del producto:</label>
        <input type="text" class="form-control" name="sn" id="sn" placeholder="Ingrese sn de producto." required>
      </div>

      <div class="mb-3">
        <label for="venc" class="form-label">Cantidad del producto:</label>
        <input type="text" class="form-control" name="cant" id="cant" placeholder="Ingrese unidades." required>
      </div>





      <button type="submit" class="btn btn-success"> Crear Orden </button>

      <a class="btn btn-success" href="../gestion-ordenes/baja-ordenes/index.php"> Baja de Órdenes </a>

      <a class="btn btn-success" href="../gestion-ordenes/modificar-ordenes/index.php"> Modificar Órdenes </a>

      <br>
      <br>
      <input class="btn btn-warning" type="button" name="cancelar" value="Cancelar"
        onclick="location.href='../gestion-ordenes/index.php'">






    </form>
  </section>

  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</body>

</html>