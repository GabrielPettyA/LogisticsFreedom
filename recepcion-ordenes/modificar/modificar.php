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

  table {
    border: 1px solid #ddd;
    padding: 8px;
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: seagreen;
    max-width: 2100px;
  }

  th,
  td {
    border: 1px solid #ddd;
    background-color: seagreen;
  }
</style>

<body translate="no">

  <div style="min-width: 1100px;" class="container">

    <h2 class="inicio">Área Recepción, Modificación de Estados</h2>

  <!-- FORMULARIO Y LLAMADO A DB. PARA INCORPORAR LOS DATOS EXISTENTES A REQUERIR POR BUSQUEDA
       DERIVANDO EL DATO QUE PERMITE ACCEDER AL ARCHIVO "INDEX.PHP" Y ENTREGÁNDOLE LOS DATOS
       PARA PODER PROCESARLOS Y TERMINAR DE RECORRER EL CICLO QUE PERMITE LA POSTERIOR UPDATE DE LA DB. -->

    <form class="id" action="../modificar/index.php" method="post">

      <div>
        <label style="margin-left: 67px;" for="date" class="form-label mt-5 mb-1"> Fecha:</label>
        <input type="date" name="date" id="date" placeholder="" required autocomplete="off">
      </div>

      <div class="mt-5 ">
        <label for="formGroupExampleInput" class="form-label">Área Modificar Estado o Rechazar Orden</label>
        <input class="form-control" type="text" placeholder="Ingrese N° Orden de compra  *" name="eliminar"
          id="eliminar" required autocomplete="off"><br>
        <button type="submit" class="btn btn-warning ">Modificar / Rechazar</button>
        <input class="btn btn-danger" style="margin-left: 15px; margin-bottom: 2px; " type="button" name="cancelar"
          value="Cancelar" onclick="location.href='../modificar/modificar.php'">
      </div>

      <a class="volver" href="../index.php"> <button type="button" class="btn btn-primary mt-5">
          <h5>Volver</h5>
        </button>
      </a>
    </form>
    <br>
    <br>
    <?php

    $conexion = mysqli_connect("localhost", "root", "", "bd_stock");
    $query = "SELECT * FROM orden_compra WHERE n_orden = value.'eliminar' ";
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