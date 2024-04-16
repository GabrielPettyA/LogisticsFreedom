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

$email = $varsession;

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
  <title>Logistic freedom</title>
  <link rel="stylesheet" href="../styles/modificar_orden.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
  body {
    background-color: rgb(130, 130, 150);
    border-style: double;
    margin: 1%;
    border-color: black;
    min-width: 115vh;
  }
  table{
    width: 100%;
    border-collapse: collapse;
    background-color: seagreen ;
  }
  th{
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    font-size: 1.32rem;
    color: blue;
  }
  td{
    text-align: center;
    color: black;
  }

  table th, td{
    border:1px solid #ddd;
    padding: 10px;
    padding-top: 8px;    
    padding-bottom: 8px;

}

  
</style>


<body>

  <br>
  <div class="container">
    <div class="titulo">
      <h2 style="color:black;" >Sistema Órdenes de Compra</h2>
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
                <label><b></b></label> <br>
                <button type="submit" class="btnBuscar">Buscar</button>
              </div>
            </div>
          </div>
          <br>
        </form>
        <table class="tablaInicio" id="tabla_id">
          <thead class="tabla">
            <tr class="titulosTabla"><br>
              <th> id </th>
              
              <th> n_orden </th>
              
              <th> fecha_orden </th>
             
              <th> proveedor</th>
             
              <th> administrador </th>
              
              <th> sn_producto </th>
              
              <th> cant </th>
             
              <th> estado_orden </th>
              
              <th> motivo_orden </th>

            </tr>
          </thead>
          <form class="id" action="../modificar-ordenes/modificar.php" method="post">
            Modificar Orden <br>
            <label for="idu"></label>
            <input class="#" type="text" placeholder="id  *" name="idu" id="idu" required><br>
            <input type="submit" value="CAMBIAR" class="boton">
          </form>
          <br><br>
          <form class="id" action="eliminarPublicacion.php" method="post">
            Eliminar Orden <br>
            <label for="idu"></label>
            <input class="#" type="text" placeholder="id *" name="idu" id="idu" required><br>
            <input type="submit" value="ELIMINAR" class="boton">
            <br>
            <br>
            <a style="color: darkblue ; border:groove; border-color:aliceblue; 
            font-family:'Franklin Gothic Medium', 'Arial Narrow', 
            Arial, sans-serif;
            text-decoration:none; background-color:chocolate;" href="../index.php"> Volver ► Alta Orden de Compra ◄
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
                        <?php echo "-" . $fila['fecha_orden']; ?>
                      </td>
                      <td class="proveedor">
                        <?php echo $fila['proveedor']; ?>
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

</body>

</html>