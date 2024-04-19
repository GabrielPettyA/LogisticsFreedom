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
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Logistic freedom</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="stylesheet" href="../styles/alarmas-reposicion.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

  <div class="contenedorSection">

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

    <section class="principal">

      <h3 class="titleAlRep"> Gestión de alarmas de reposición </h3>

      <div id="botones" class="botones">
        <button id="btnPrevPage" class="btn" onclick="prevPage()"><i class="fa-solid fa-angle-left"></i></button>
        <span> Page <span id="pageActual"></span> of <span id="lastPage"> </span> </span>
        <button id="btnNextPage" class="btn" onclick="nextPage()"><i class="fa-solid fa-angle-right"></i></button>
      </div>

      <div class="table-responsive" style="width: 95%;margin:auto">
        <table class="table table-bordered">

          <thead>
            <tr>

              <th class="align-top cuadroHeadTable15">
                Nombre de producto

                <div class="input-group my-1">
                  <input type="text" class="form-control" oninput="filterTable()" placeholder="Buscar por producto" aria-label="Busqueda producto" aria-describedby="Busqueda producto" id="productoSearch">
                </div>

              </th>

              <th class="align-top cuadroHeadTable15">
                SN

                <div class="input-group my-1">
                  <input type="number" class="form-control" oninput="filterTable()" placeholder="Buscar por sn" aria-label="Busqueda sn" aria-describedby="Busqueda sn" id="snSearch">
                </div>

              </th>

              <th class="align-top cuadroHeadTable10">
                Cantidad

                <div class="input-group my-1">
                  <input type="number" class="form-control" oninput="filterTable()" placeholder="Buscar por cantidad" aria-label="Busqueda cantidad" aria-describedby="Busqueda cantidad" id="cantidadSearch">
                </div>

              </th>

              <th class="align-top cuadroHeadTable10">
                Stock de aviso

                <div class="input-group my-1">
                  <input type="number" class="form-control" oninput="filterTable()" placeholder="Buscar por aviso" aria-label="Busqueda stock aviso" aria-describedby="Busqueda stock aviso" id="stockAvisoSearch">
                </div>

              </th>

              <th class="align-top cuadroHeadTable15">
                Estado

                <div class="input-group my-1">
                  <select class="form-select" id="estadoSearch" onchange="filterTable()">
                    <option value="">Todos</option>
                    <option value="I">Inactivo</option>
                    <option value="A">Activo</option>
                    <option value="D">Desactivado</option>
                  </select>
                </div>

              </th>

              <th class="align-top" style="text-align: center;min-width: 8rem;">
                Acciones

                <button class="btn btn-warning my-1" id="resetSearch" onclick="resetBusqueda()">
                  Resetear filtros
                </button>

              </th>

            </tr>
          </thead>

          <tbody id="table_alarmas">



          </tbody>

        </table>
      </div>


      <div class="contenedorAvisos" id="sinDatosAlarmas" style="display:none;">
        <h1>
          No existen datos para mostrar.
        </h1>
      </div>

    </section>

  </div>


  <!-- Modal Editar Alarma  -->
  <div class="modal fade" id="editarAlarma" tabindex="-1" aria-labelledby="editarAlarmaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editarAlarmaLabel"></h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModal()"></button>
        </div>

        <div class="modal-body">

          <form>

            <div class="input-group mb-3">
              <select class="form-select" id="editarEstado" onchange="validarEstado()">
                <option value="" disabled>Seleccione estado</option>
                <option value="I">Inactivo</option>
                <option value="A">Activo</option>
                <option value="D">Desactivado</option>
              </select>
            </div>

            <div class="input-group mb-3">
              <input type="number" class="form-control" placeholder="Stock de aviso" oninput="validarStockAviso()"
              aria-label="Stock aviso" aria-describedby="Stock aviso" id="editarStockAviso">
            </div>


          </form>


        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-warning" data-bs-dismiss="modal" id="btnEditarAlarma" onclick="editarAlarmaApi()">
            Editar alarma
          </button>

          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="cerrarModal()">
            Cerrar
          </button>

        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <!--JS-->
  <script src="obtenerAlarmas.js"></script>
  <script src="pipe-alarmas.js"></script>
  <script src="editarAlarma.js"></script>
</body>

</html>