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

$consulta = "SELECT * FROM mod_stock";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$result = $resultado->get_result();
$modificaciones = $result->fetch_all(MYSQLI_ASSOC);

$result->free();
$conexion->close();
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Logistic freedom</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.png">


    <link rel="stylesheet" href="../styles/reportes.css">
    <link rel="stylesheet" href="../styles/navbar.css">
    <link rel="stylesheet" href="../styles/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">



    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <!--dataTables estilo bootstrap CSS-->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css" rel="stylesheet">

    <!--font awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

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
<a class="nav-link" href="/tp2/gestion-usuarios/">Gestión de usuarios</a>
</li>';
}

if (in_array("reportes", $roles)) {
  echo '  <li class="nav-item">
<a class="nav-link active" href="/tp2/reportes/">Reportes</a>
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

if (in_array("gestion alarmas", $roles) && $totalAlarmas == 0) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/alarmas-reposicion/">Gestión de alarmas</a>
</li>';
}

if (in_array("gestion alarmas", $roles) && $totalAlarmas > 0) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/alarmas-reposicion/">
Gestión de alarmas
<span class="badge rounded-pill bg-danger">
' . $totalAlarmas . '+
<span class="visually-hidden">unread messages</span>
</span>

</a>
</li>';
}


if (in_array("visualizar alarmas", $roles) && $totalAlarmas == 0) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/visualizar-alarmas/">Visualizar alarmas</a>
</li>';
}

if (in_array("visualizar alarmas", $roles) && $totalAlarmas > 0) {
  echo '<li class="nav-item">
<a class="nav-link" href="/tp2/visualizar-alarmas/">
Visualizar de alarmas
<span class="badge rounded-pill bg-danger">
' . $totalAlarmas . '+
<span class="visually-hidden">unread messages</span>
</span>

</a>
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






    <div id="fondo" class="row">
        <h1> Reportes de Modificaciones de Stock </h1>

        <hr style="color: gray;margin: 0.4rem auto 2rem auto; width: 95%">
        <div class="col-12">
            <div class="table-responsive">
                <table id="tablaMod" class="table table-striped table-bordered" style="width:100%">
                    <thead class="text-center">
                        <tr>
                            <th class="pp">ID</th>
                            <th class="pp">ID OLD</th>
                            <th class="pp">NOMBRE OLD</th>
                            <th class="pp">SN OLD</th>
                            <th class="pp">CANTIDAD OLD</th>
                            <th class="pp">ID NEW</th>
                            <th class="pp">NOMBRE NEW</th>
                            <th class="pp">SN NEW</th>
                            <th class="pp">CANTIDAD NEW</th>
                            <th class="pp">FECHA</th>
                            <th class="pp">MOTIVO</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($modificaciones as $modi) {
                            echo "<tr>";
                            echo "<td>{$modi['id']}</td>";
                            echo "<td>{$modi['id_old']}</td>";
                            echo "<td>{$modi['name_old']}</td>";
                            echo "<td>{$modi['sn_old']}</td>";
                            echo "<td>{$modi['cant_old']}</td>";
                            echo "<td>{$modi['id_new']}</td>";
                            echo "<td>{$modi['name_new']}</td>";
                            echo "<td>{$modi['sn_new']}</td>";
                            echo "<td>{$modi['cant_new']}</td>";
                            echo "<td>{$modi['fecha']}</td>";
                            echo "<td>{$modi['motivo']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- datatables JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>


    <!-- JS -->
    <script type="text/javascript" src="reportes.js"></script>


    <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>


    <script>
        $(document).ready(function() {
            $('#tablaMod').DataTable();
        });
    </script>



    <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>