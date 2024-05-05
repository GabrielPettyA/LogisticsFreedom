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
  <title>Logistic freedom</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="../styles/revisar-contacto.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

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
                                    <a class="nav-link" aria-current="page" href="/tp2/alta-productos">Alta de productos</a>
                                </li>';
            }

            if (in_array("gestion usuarios", $roles)) {
              echo '<li class="nav-item">
                                    <a class="nav-link active" href="/tp2/gestion-usuarios/">Gestión de usuarios</a>
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


  <?php

  $consulta = "SELECT * FROM contacto";
  $resultado = $conexion->query($consulta);

  if (!$resultado) {
    echo '<script type="text/javascript">
        alert("No hubo resultados para la consulta.");
            </script>';
  }

  echo '<section class="cardSection">
    <h1> Revisar mensajes </h1>
    <table id="tableContactos" class="table table-bordered">
    <thead> 
    <tr>
    <th>id</th>
    <th>Nombre</th>
    <th>Email</th>
    <th>Telefono</th>
    <th>Mensaje</th>
    </tr>
    ';

  while ($fila = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo "<td>" . $fila[0] . "</td>";
    echo "<td>" . $fila[1] . "</td>";
    echo "<td>" . $fila[2] . "</td>";
    echo "<td>" . $fila[3] . "</td>";
    echo "<td>" . $fila[4] . "</td>";
  }
  echo "</table>
    </section>";
  $conexion->close();


  ?>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="usuarios.js"></script>
</body>

</html>