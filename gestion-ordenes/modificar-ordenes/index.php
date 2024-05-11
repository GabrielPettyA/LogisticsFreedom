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

//$email = $varsession;

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../../images/favicon.png">
  <title>Logistic freedom</title>
  <link rel="stylesheet" href="/styles/main.css ">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
  body {
    width: 100%;
    height: 100%;
    display: flex;
    background-color: cadetblue;
    padding: 0;
  }

  .inicio {
    color: black;
    margin-top: 2%;
    justify-content: center;
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    font-size: 7vh;
    background-color: cadetblue;
    border-radius: 10px;
  }

  .container {
    background-color: darkcyan;
    max-width: 2100px;
    /*min-width: 50px;*/
  }


  th {
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    font-size: 1.32rem;
    color: blue;
    max-width: 2100px;
  }

  td {
    text-align: center;
    color: black;
    max-width: 2100px;
  }

  table 
   {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: seagreen;
    max-width: 2100px;
  }

  th, td{
    border: 1px solid #ddd;
    background-color: seagreen;
  }
</style>

<body translate="no">

  <div style="min-width: 1100px;" class="container">
 
      <h2 class="inicio">Sistema Órdenes de Compra</h2>
      <h4>Buscador por fecha</h4>
      <br>
      <div class="tablaGeneral">
        <form action="" method="GET">
          <div class="#">
            <div class="#">
              <div style="width: 300px;" class="#">
                <label><b>Desde Dia :</b></label>
                <input type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                  echo $_GET['from_date'];
                } ?>" class="form-control">
              </div>
            </div>
            <div style="width: 300px;" class="#">
              <div class="form-group">
                <label><b> Hasta Dia :</b></label>
                <input type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                  echo $_GET['to_date'];
                } ?>" class="form-control">
              </div>
            </div>
            <div class="#">
              <div class="form-group">
                <b></b> <br>
                <button type="submit" class=" btn btn-success">Buscar</button>
              </div>
            </div>
          </div>
        </form>

        <table style="width:100%; " class="container text-center mb-5">

          <thead class="">
            <tr class=""><br>
              <th> id </th>
              <th> n_orden </th>
              <th> fecha_orden </th>
              <th> proveedor</th>
              <th> cuit r.social</th>
              <th> administrador </th>
              <th> sn_producto </th>
              <th> cant </th>
              <th> estado_orden </th>
              <th> motivo_orden </th>
            </tr>
          </thead>

          <form class="id" action="../modificar-ordenes/modificar.php" method="post">
            <div class="mt-1">
              <label for="formGroupExampleInput" class="form-label">Sección Modificar Producto</label>
              <input class="form-control" type="number" min="0" step="1"
                onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;"
                placeholder="Ingrese id de producto  *" name="modificar" required autocomplete="off"><br>
              <button type="submit" class="btn btn-warning ">Modificar</button>
            </div>
          </form>
          <form class="id" action="../baja-ordenes/index.php" method="post">
            <div class="mt-5 ">
              <label for="formGroupExampleInput" class="form-label">Sección Modificar Estado o Eliminar Orden</label>
              <input class="form-control" type="text" placeholder="Ingrese N° Orden de compra  *" name="eliminar"
                id="eliminar" required autocomplete="off"><br>
              <button type="submit" class="btn btn-warning ">Cambiar / Eliminar</button>
              <input class="btn btn-danger" style="margin-left: 15px; margin-bottom: 2px; " type="button"
                name="cancelar" value="Cancelar" onclick="location.href='../modificar-ordenes/index.php'">
            </div>

            <a class="volver" href="../index.php"> <button type="button" class="btn btn-primary mt-5">
                <h5>Volver</h5> "Alta Orden de Compra"
              </button>
            </a>
          </form>
          <br>
          <br>
          <?php

          $conexion = mysqli_connect("localhost", "root", "", "bd_stock");
          if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
            $from_date = $_GET['from_date'];
            $to_date = $_GET['to_date'];
            $query = "SELECT * FROM orden_compra /*LEFT JOIN permisos ON user.rol = permisos.id*/ WHERE fecha_orden BETWEEN '$from_date' AND '$to_date' ";
            $query_run = mysqli_query($conexion, $query);
            if (mysqli_num_rows($query_run) > 0) {
              foreach ($query_run as $fila) {

                $fila['id'];
                $fila['n_orden'];
                $fila['fecha_orden'];
                $fila['proveedor'];
                $fila['cuit'];
                $fila['administrador'];
                $fila['sn'];
                $fila['cant'];
                $fila['estado_orden'];
                $fila['motivo_orden'];

                /* SE CREARON LAS VARIABLES PARA PODER LLAMAR AL CAMPO REQUERIDOS Y SE VUELCA LA INFORMACIÓN EN LAS VARIABLES '$fila' */
                if ($fila['id'] > 0) {
                  ?>
                  <tbody class="tbody">
                    <tr class="carga">
                      <td class="id">
                        <?php echo $fila['id'];
                        ?>
                      </td>
                      <td class="n_orden">
                        <?php echo $fila['n_orden']; ?>
                      </td>
                      <td class="fecha_orden">
                        <!--<input id="casilla2" type="checkbox" name="casilla2" value="1">-->
                        <?php echo $fila['fecha_orden']; ?>
                      </td>
                      <td class="proveedor">
                        <?php echo $fila['proveedor']; ?>
                      </td>
                      <td class="cuit">
                        <?php echo $fila['cuit']; ?>
                      </td>
                      <td class="administrador">
                        <?php echo $fila['administrador']; ?>
                      </td>
                      <td class="sn">
                        <?php echo $fila['sn']; ?>
                      </td>
                      <td class="cant">
                        <?php echo $fila['cant']; ?>
                      </td>
                      <td class="estado_orden">
                        <?php echo $fila['estado_orden']; ?>
                      </td>
                      <td class="motivo_orden">
                        <?php echo $fila['motivo_orden']; ?>
                        <!--<a class="edit" type="checkbox" value='1' href="editDel.php">Edit/Del</a>-->
                      </td>
                    </tr>
                  </tbody>

                  <?php
                }
              }
            } else {
              ?>
              <tr>
                <div>
                  <td>
                    <?php
                    echo "
                    <script>
                      alert('No hay Información de período solicitado, intente nuevamente!!!');
                      window.location = 'index.php?page=otrapagina'
                    </script>";
                    ?>
                  </td>
                </div>
                <?php
            }
          }
          $conexion->close();
          ?>

        </table>
      </div>
      <!-- Bootstrap -->
      <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
      <script src="obtenerAlarmas.js"></script>

</body>

</html>