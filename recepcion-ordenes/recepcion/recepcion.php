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

//$email = $varsession;

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logistic freedom</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <link rel="stylesheet" href="/styles/main.css ">
  <link rel="stylesheet" href="../styles/navbar.css">
  <link rel="stylesheet" href="../styles/main.css">
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

  dbody {
    width: 100%;
    height: auto;
  }

  .todoTabla {
    margin-left: 1%;
  }

  .inicio {
    color: black;
    justify-content: center;
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    font-size: 7vh;
    border-radius: 10px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th {
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    font-size: 1rem;
    color: blue;
  }

  td {
    text-align: center;
    color: black;
  }

  table th,
  td {
    border: 0.2px solid #ddd;
    padding: 10px;
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: wheat;

  }
</style>

<body translate="no">
  <dbody class="cardSection mt-5">
    <div class="">
      <div class="todoTabla">
        <h2 class="inicio">Listado de Órdenes de compra</h2>
        <h4>Buscador por fecha</h4>
        <br>
        <div class="tablaGeneral">
          <form action="" method="GET">
            <div class="">
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
                  <button type="submit" class=" btn btn-success">Aceptar</button>
                </div>
              </div>
            </div>
          </form>
          <a class="btn btn-success" style="margin-bottom: 5px; margin-top:10px; background-color:darkcyan ; width: 84px; " href="../">
            Salir</a>
          <table class="container text-center mb-5">
            <thead class="">
              <tr class=""><br>
                <th> Id </th>
                <th> Orden </th>
                <!-- <th> Creada </th>-->
                <th> Proveedor</th>
                <!--<th> Administrador </th>-->
                <th> SN producto </th>
                <th> cant </th>
                <th> Fecha recep </th>
                <th> Adm recep </th>
                <th> Cant recep</th>
                <th> estado_orden </th>
                <th> motivo_orden </th>
              </tr>
            </thead>
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
                  // $fila['fecha_orden'];
                  $fila['proveedor'];
                  // $fila['administrador'];
                  $fila['sn'];
                  $fila['cant'];
                  $fila['fecha_recep'];
                  $fila['adm_recepcion'];
                  $fila['cant_recep'];
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
                        <td class="proveedor">
                          <!--<input id="casilla2" type="checkbox" name="casilla2" value="1">-->
                          <?php echo $fila['proveedor']; ?>
                        </td>
                        <td class="sn">
                          <?php echo $fila['sn']; ?>
                        </td>
                        <td class="cant">
                          <?php echo $fila['cant']; ?>
                        </td>
                        <td class="fecha_recep">
                          <?php echo $fila['fecha_recep']; ?>
                        </td>
                        <td class="adm_recepcion">
                          <?php echo $fila['adm_recepcion']; ?>
                        </td>
                        </td>
                        <td class="cant_recep">
                          <?php echo $fila['cant_recep']; ?>
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
                      alert('ERROR: no se encuentra información requerida, intente nuevamente');
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
      </div>
    </div>
  </dbody>
  <!-- Bootstrap -->
  <script src="https://kit.fontawesome.com/ce1f10009b.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
  <script src="obtenerAlarmas.js"></script>

</body>

</html>