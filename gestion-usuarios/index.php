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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logistic freedom</title>
  <link rel="icon" type="image/png" href="../images/favicon.png">
  <link rel="stylesheet" href="../styles/gestion-usuarios.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body style="min-height: 100vh;">

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

  <section class="cardContent">

    <header class="cardTitle">
      <h1>Gestión de usuarios</h1>
    </header>

    <hr class="cardDivider">

    <div class="cardBody">

      <select id="selectModType" class="form-select mb-3" aria-label="Select tipo de form" onchange="cangeForm()">
        <option selected>Seleccione tipo de gestion</option>
        <option value="C">Crear usuario</option>
        <option value="E">Editar usuario</option>
        <option value="D">Eliminar usuario</option>
      </select>

      <form id="formNewUser">

        <div class="mb-3">
          <label for="newUserMail" class="form-label">Usuario:</label>
          <input type="email" class="form-control" id="newUserMail" onkeyup="validarEmail()"
            placeholder="Ingrese el email del usuario">
        </div>

        <p class="text-danger" id="newUserMailErr" style="display: none;"> El formato de email es invalido o el usuario
          ya existe.</p>

        <div class="mb-3">
          <label for="newUserPass" class="form-label">Contraseña:</label>
          <input type="text" class="form-control" id="newUserPass" onkeyup="validarPassword()"
            placeholder="Ingrese la contraseña">
        </div>

        <p class="text-danger" id="newUserPassErr" style="display: none;"> El formato de la contraseña es invalido.</p>

        <label for="exampleFormControlInput1" class="form-label">Permisos</label>


        <div class="form-check">
          <input class="form-check-input newUserAccessCheck" id="check1" name="check1" type="checkbox"
            value="alta productos">
          <label class="form-check-label" for="check1">
            Alta de productos
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input newUserAccessCheck" id="check2" name="check2" type="checkbox"
            value="gestion usuarios">
          <label class="form-check-label" for="check2">
            Gestion de usuarios
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input newUserAccessCheck" id="check3" name="check3" type="checkbox" value="reportes">
          <label class="form-check-label" for="check3">
            Reportes
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input newUserAccessCheck" id="check4" name="check4" type="checkbox" value="stock">
          <label class="form-check-label" for="check4">
            Stock
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input newUserAccessCheck" id="check5" name="check5" type="checkbox" value="contacto">
          <label class="form-check-label" for="check5">
            Contacto
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input newUserAccessCheck" id="check6" name="check6" type="checkbox"
            value="revisar contacto">
          <label class="form-check-label" for="check6">
            Revisar contacto
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input newUserAccessCheck" id="check7" name="check7" type="checkbox"
            value="gestion ordenes">
          <label class="form-check-label" for="check7">
            Gestion de ordenes
          </label>
        </div>

      </form>

      <form id="formEditUser" style="display: none;">

        <select id="selectEditUser" class="form-select mb-3" aria-label="Select editar usuario"
          onchange="validarFormEditarUsuario()">
        </select>

        <label for="exampleFormControlInput1" class="form-label">Permisos</label>

        <div class="form-check">
          <input class="form-check-input editUserAccessCheck" name="check8" id="check8" type="checkbox"
            value="alta productos">
          <label class="form-check-label" for="check8">
            Alta de productos
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input editUserAccessCheck" name="check9" id="check9" type="checkbox"
            value="gestion usuarios">
          <label class="form-check-label" for="check9">
            Gestion de usuarios
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input editUserAccessCheck" name="check10" id="check10" type="checkbox"
            value="reportes">
          <label class="form-check-label" for="check10">
            Reportes
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input editUserAccessCheck" name="check11" id="check11" type="checkbox" value="stock">
          <label class="form-check-label" for="check11">
            Stock
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input editUserAccessCheck" name="check12" id="check12" type="checkbox"
            value="contacto">
          <label class="form-check-label" for="check12">
            Contacto
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input editUserAccessCheck" name="check13" id="check13" type="checkbox"
            value="revisar contacto">
          <label class="form-check-label" for="check13">
            Revisar contacto
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input editUserAccessCheck" name="check14" id="check14" type="checkbox"
            value="gestion ordenes">
          <label class="form-check-label" for="check14">
            Gestión órdenes
          </label>
        </div>

      </form>

      <form id="formDelUser" style="display: none;">

        <select id="selectDeleteUser" class="form-select mb-3" aria-label="Select eliminar usuario"
          onchange="validarFormEliminarUsuario()">
        </select>

      </form>


    </div>

    <hr class="cardDivider">

    <footer class="cardFooter">

      <div id="btnNewUser" class="botones">
        <!-- Open modal crear usuario -->
        <button type="button" class="btn btn-success m-1" id="btnCrearUsuario" data-bs-toggle="modal"
          data-bs-target="#modalCrearUsuario" disabled>
          Crear Usuario
        </button>

        <!-- Open modal reiniciar formulario -->
        <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
          data-bs-target="#modalReiniciarFormNewUser">
          Reiniciar formulario
        </button>

        <!-- Modal crear usuario -->
        <div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-labelledby="modalCrearUsuarioLabel"
          aria-hidden="true">
          <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalCrearUsuarioLabel">Confirme creación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <p id="textConfirmarUsuario"></p>
              </div>
              <div class="modal-footer">

                <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="crearUsuario()">
                  Crear
                </button>

                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                  Cancelar
                </button>

              </div>
            </div>
          </div>
        </div>


        <!-- Modal crear usuario -->
        <div class="modal fade" id="modalReiniciarFormNewUser" tabindex="-1"
          aria-labelledby="modalReiniciarFormNewUserLabel" aria-hidden="true">
          <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalReiniciarFormNewUserLabel">Confirme creación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <p>
                  Está a punto de borrar la información cargada en todos los campos. <br>
                  ¿Desea continuar?
                </p>
              </div>
              <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="resetFormnuevoUsuario()">
                  Reiniciar
                </button>

                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                  cancelar
                </button>

              </div>
            </div>
          </div>
        </div>


      </div>

      <div id="btnEditUser" class="botones" style="display: none;">

        <!-- Open modal editar usuario -->
        <button type="button" class="btn btn-warning m-1" id="btnEditarUsuarioModal" data-bs-toggle="modal"
          data-bs-target="#modalEditarUsuario" disabled>
          Editar Usuario
        </button>

        <!-- Modal editar usuario -->
        <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel"
          aria-hidden="true">
          <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarUsuarioLabel">Confirme edición</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <p id="textConfirmarEditarUsuario"></p>
              </div>
              <div class="modal-footer">

                <button type="button" id="btnEditarUsuario" class="btn btn-warning" data-bs-dismiss="modal"
                  onclick="editarUsuario()" disabled>
                  Editar
                </button>

                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                  Cancelar
                </button>

              </div>
            </div>
          </div>
        </div>

      </div>

      <div id="btnDelUser" class="botones" style="display: none;">

        <!-- Open modal eliminar usuario -->
        <button type="button" class="btn btn-danger m-1" id="btnEliminarUsuarioModal" data-bs-toggle="modal"
          data-bs-target="#modalEliminarUsuario" disabled>
          Eliminar Usuario
        </button>

        <!-- Modal eliminar usuario -->
        <div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-labelledby="modalEliminarUsuarioLabel"
          aria-hidden="true">
          <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEliminarUsuarioLabel">Confirme eliminación</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <p id="textConfirmarEliminarUsuario"></p>
              </div>
              <div class="modal-footer">

                <button type="button" id="btnEliminarUsuario" class="btn btn-danger" data-bs-dismiss="modal"
                  onclick="eliminarUsuario()">
                  Eliminar
                </button>

                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                  Cancelar
                </button>

              </div>
            </div>
          </div>
        </div>

      </div>

    </footer>

  </section>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
    crossorigin="anonymous"></script>
  <script src="usuarios.js"></script>
</body>

</html>