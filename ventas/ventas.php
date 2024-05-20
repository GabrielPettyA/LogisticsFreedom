<?php
session_start();
error_reporting(0);
$varsession = $_SESSION['email'];
$roles = $_SESSION['roles'];
if ($varsession == null || $varsession == '') {
  header("Location:http://localhost/tp2/");
}

if (!in_array("reportes", $roles)) {
  header("Location:http://localhost/tp2/inicio/");
}

require ("../includes/config/db-config.php");

$consulta = "SELECT * FROM productos WHERE cant > 0" ;
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$result = $resultado->get_result();
$stock = $result->fetch_all(MYSQLI_ASSOC);

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


  <link rel="stylesheet" href="../styles/ventas.css">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">



  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <!--dataTables estilo bootstrap CSS-->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css" rel="stylesheet">

  <!--font awesome-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

</head>

<body>


  <nav class="navbar bg-body-tertiary fixed-top" style="padding: 0;">

    <div class="container-fluid">

      <div>
        <a class="navbar-brand" href="http://localhost/tp2/inicio/">
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


  <div id="fondo" class="row">
    <h1> VENTAS </h1>


    <hr style="color: gray;margin: 0.4rem auto 2rem auto; width: 95%">
    <!-- Agregar el area de graficos de ventas -->
    <div id="cart" class="text-end mt-3">
      <a href="grafico.php" class="btn btn-secondary">
        GRAFICOS DE VENTAS
      </a>
    </div>
    <div class="col-12">

      <div class="table-responsive">

        <form action="../../ventas-api/ventas.php" method="post">
          <table id="productos" class="table table-striped table-bordered" style="width:100%">
            <thead class="text-center">
              <tr>
<<<<<<< HEAD
                <td>
                  <input onchange="habilitarCantidad(this)" name="productos_seleccionados[]" type="checkbox"
                    value="<?php echo $modi['id']; ?>">
                </td>
                <td><?php echo $modi['name']; ?></td>
                <td><?php echo $modi['cant']; ?></td>
                <td><?php echo $modi['sn']; ?></td>
                <td>
                  <input type="number" name="cantidad_ventas[<?php echo $modi['id']; ?>]" value="0" min="0"
                    max="<?php echo $modi['cant']; ?>">
                </td>
=======
                <th class="pp"></th>
                <th class="pp">NOMBRE</th>
                <th class="pp">Cantidad de Stock</th>
                <th class="pp">SN</th>
                <th class="pp">Seleccionar Cantidad</th>
>>>>>>> 4eefae96b6973f0f33ed0db89cee6c3d7a698778
              </tr>
            </thead>
            <tbody>

              <?php foreach ($stock as $modi): ?>
                <tr>
                  <td>
                    <input onchange="habilitarCantidad(this)" name="productos_seleccionados[]" type="checkbox"
                      value="<?php echo $modi['id']; ?>">
                  </td>
                  <td class="nombreVentas"><?php echo $modi['name']; ?></td>


                  <td><?php echo $modi['cant']; ?></td>
                  <td><?php echo $modi['sn']; ?></td>
                  <td>
                    <input type="number" class="cantventas" name="cantidad_ventas[<?php echo $modi['id']; ?>]" value="0"
                      min="0" max="<?php echo $modi['cant']; ?>" disabled>

                  </td>
                </tr>
              <?php endforeach; ?>
      </div>
      </tbody>
      </table>
      </form>
      <!-- Agregar el área del carrito de compras -->
      <div class="text-end">
        <!-- Botón que abre la ventana modal -->
        <button onclick="btnenviarcant()" class="btn btn-success" data-bs-toggle="modal"
          data-bs-target="#confirmPurchaseModal">
          <i class="fas fa-shopping-cart"></i> Realizar compra
        </button>
      </div>

      <!-- Ventana Modal de Confirmación -->
      <div class="modal fade" id="confirmPurchaseModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Confirmar Compra</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ¿Está seguro de que desea realizar esta compra?
              <table class="table table-bordered" style="border-color: white;">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                  </tr>
                </thead>
                <tbody id="confirmarventastabla">

                </tbody>
              </table> 


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
              <button type="button" class="btn btn-success" onclick="vender()">Sí, quiero comprar</button>
            </div>
          </div>
        </div>
      </div>







    </div>
  </div>
  </div>



  <!-- jQuery, Popper.js, Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>

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
  <script type="text/javascript" src="ventas.js"></script>


  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>


  <script>
    $(document).ready(function () {
      $('#productos').DataTable();
    });
  </script>



  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
</body>

</html>