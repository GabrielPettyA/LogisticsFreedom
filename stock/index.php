<?php
session_start();
error_reporting(0);
$varsession = $_SESSION['email'];
$roles = $_SESSION['roles'];
if ($varsession == null || $varsession == '') {
  header("Location:http://localhost/tp2/");
}

if (!in_array("stock", $roles)) {
  header("Location:http://localhost/tp2/inicio/");
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logistic freedom</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="../styles/stock.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                                  <a class="nav-link active" href="/tp2/stock/">Stock</a>
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
                                            <a class="nav-link" href="/tp2/gestion-ordenes/">Gestión órdenes</a>
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


  <main>
    <h1 class="stock_title">Control de Stock</h1>
    <div id="botones" class="botones">
      <button id="btnPrevPage" class="btn" onclick="prevPage()"><i class="fa-solid fa-angle-left"></i></button>
      <span> Page <span id="pageActual"></span> of <span id="lastPage"> </span> </span>
      <button id="btnNextPage" class="btn" onclick="nextPage()"><i class="fa-solid fa-angle-right"></i></button>
    </div>
    <section>
      <!--Tabla de productos-->
      <table id="tableStock" class="table table-bordered">
        <thead>
          <tr>
            <th scope="col" class="tab_h">
              ID PRODUCTO
            </th>
            <th scope="col" class="tab_h">
              Nombre de Producto
            </th>
            <th scope="col" class="tab_h">
              SN
            </th>
            <th scope="col" class="tab_h">
              Cantidad
            </th>
            <th scope="col" class="tab_h">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody id="table_body">

        </tbody>
      </table>


      <!-- Editar producto -->
      <div class="modal fade" id="editProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editProductLabel">Editar producto</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="edit_form">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">Nombre</span>
                  <input type="text" id="edit_name" class="form-control" onkeyup="prueba()"
                    placeholder="Nombre del producto" aria-label="nombre del producto" aria-describedby="basic-addon1">
                </div>
                <p id="editName_error" class="text-danger text-center" style="display: none;">El nombre
                  del producto debe tener entre 3 o 20 caracteres.</p>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">SN</span>
                  <input type="text" id="edit_sn" class="form-control" placeholder="Número de serie"
                    aria-label="número de serie" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">Cantidad</span>
                  <input type="number" id="edit_cant" class="form-control" placeholder="Cantidad" aria-label="cantidad"
                    aria-describedby="basic-addon1">
                </div>
                <select class="form-select mb-3" id="edit_mot">
                  <option value="" selected disabled> Selecione motivo</option>
                  <option value="Transferencia">Transferencia</option>
                  <option value="Corrección de producto">Correcciones varias</option>
                  <option value="Corrección de nombre">Corrección de nombre</option>
                  <option value="Corrección de sn">Corrección de sn</option>
                  <option value="Corrección de cantidad">Corrección de cantidad</option>
                  <option value="Producto no existente">Producto no existente</option>
                </select>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-warning" data-bs-dismiss="modal"
                onclick="editProduct()">Editar</button>
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Eliminar producto -->
      <div class="modal fade" id="deleteProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deleteProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="deleteProductLabel">Por favor confirme acción</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Va a elimiar el producto: </p>
              <p>
                <span style="font-weight: bold;">ID: </span> <span id="delete_id"></span> <br>
                <span style="font-weight: bold;">Producto: </span> <span id="delete_name"></span> <br>
                <span style="font-weight: bold;">SN: </span> <span id="delete_sn"></span> <br>
                <span style="font-weight: bold;">Cantidad: </span> <span id="delete_cant"></span> <br>
              </p>
              <p id="delete_alert" class="text-danger"></p>
            </div>
            <div class="modal-footer">
              <button id="delete_button" type="button" class="btn btn-danger" data-bs-dismiss="modal"
                onclick="deleteProduct()">Eliminar</button>
              <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>


    </section>
  </main>




  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <script src="stock.js"></script>
</body>

</html>