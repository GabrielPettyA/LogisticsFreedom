<?php
session_start();
error_reporting(0);
$varsession = $_SESSION['email'];
$roles = $_SESSION['roles'];

if ($varsession == null || $varsession == '') {
  header("Location:http://localhost/tp2/");
}

if (!in_array("gestion usuarios", $roles)) {
  header("Location:http://localhost/tp2/inicio/");
}

// ---- Roles dinamicos
require_once "../includes/config/db-config.php";
$sql = "SELECT * FROM usuarios WHERE email= '$varsession'";
$result = $conexion->query($sql);
$id;

while ($row = $result->fetch_assoc()) {

  $id = $row["id"];
}

$sql = "SELECT acceso FROM roles WHERE id_usuario = '$id'";
$result = $conexion->query($sql);

$roles = array();
while ($row = $result->fetch_assoc()) {
  $roles[] = $row['acceso'];
}

// --- Fin roles dinamicos
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<?php

require_once "../includes/api/alarmas-reposicion-api/servAlarmas.php";

if (isset($_POST['ean']) < 0) {
  echo "INGRESE PRODUCTO";
}

if (isset($_POST['ean']) > 0) {

  $ean = $_POST['ean'];
  $prod = $_POST['prod'];
  $cant = $_POST['cantidad'];

  $validar = "SELECT * FROM productos WHERE sn = '$ean'";
  $validando = $conexion->query($validar);

  if ($validando->num_rows > 0) {

    echo '<script type="text/javascript">
          alert("Número de serie ya registrado verifique el stock.");
          </script>';
  }

  if ($validando->num_rows == 0) {

    $sql = "INSERT INTO productos (name,sn,cant) VALUE ('$prod','$ean','$cant')";
    $guardando = $conexion->query($sql);

    // ---- Parche creación de alarma
    $sql = "SELECT * FROM productos WHERE sn = '$ean'";
    $verificarIngreso = $conexion->query($sql);

    $alarmaCreada;

    if ($verificarIngreso->num_rows > 0) {

      $row = $verificarIngreso->fetch_assoc();
      $productoFK = $row["id"];

      $alarmaServ = new AlarmaService($conexion);
      $alarmaCreada = $alarmaServ->crearAlarma($productoFK);
    }

    if ($guardando && $alarmaCreada) {

      echo '<script type="text/javascript">
            alert("Ingreso exitoso, puede seguir operando.");
            </script>';
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

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
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

            if (in_array("gestion alarmas", $roles)) {
              echo '<li class="nav-item">
                                            <a class="nav-link" href="/tp2/alarmas-reposicion/">Gestión de alarmas</a>
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

  <section class="cardSection">

    <h1 class="title"> Alta de productos</h1>

    <form class="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

      <div class="mb-3">
        <label for="ean" class="form-label">Número de serie del producto:</label>
        <input type="text" class="form-control" name="ean" id="ean" placeholder="Ingrese el número de serie del producto" required>
      </div>

      <div class="mb-3">
        <label for="prod" class="form-label">Nombre del producto:</label>
        <input type="text" class="form-control" name="prod" id="prod" placeholder="Ingrese el nombre del producto" required>
      </div>

      <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad:</label>
        <input type="number" class="form-control" name="cantidad" id="cantidad" required>
      </div>

      <button type="submit" class="btn btn-success"> Ingresar producto</button>
      <a class="btn btn-primary" href="/tp2/alta-automatica/altaAutomaticoProducto.php"> ALTA AUTOMÁTICA PRODUCTOS (solo
        para inicializar DB.)</a>

    </form>
  </section>

  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>