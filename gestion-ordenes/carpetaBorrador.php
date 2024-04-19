<?php




/*


foreach ($_POST['producto'] as $prod) {
  echo $prod . '<hr />';
  
}









require ("../includes/config/db-config.php");


$validar = "SELECT * FROM productos WHERE sn = $prod";
$validando = $conexion->query($validar);
if ($validando->num_rows > 0) {
  echo"va por carpetaBorrador";
} else {
  echo "está ingresando productos que no han sido dados de alta, verifique...";
  ?>
  <a href="../gestion-ordenes/altaOrden.php"></a>
<?php

}




$conexion->close();






//                            ARCHIVO NO UTILIZADO POR EL MOMENTO, SE RESERVA POR POSIBLES NECESIDADES


require ("../includes/config/db-config.php");
  $validar = "SELECT * FROM 'productos' WHERE sn = '$ean'";
  $validando = $conexion->query($validar);
  if ($validando->num_rows > 0) {
    
    
    $validar = "SELECT * FROM 'orden_compra' WHERE sn = '$ean'";
    $validando = $conexion->query($validar);
    if ($validando->num_rows > 0) {
      $n_orden = $orden;
      $estado = 'pendiente de entrega';
      $motivo = 'alta orden';
      $sql = "INSERT INTO 'orden_compra' (n_orden,proveedor,administrador,sn,cant,estado_orden,motivo_orden) VALUE ('$n_orden','$prov','$adm','$ean','$cant','$estado','$motivo')";
      $guardando = $conexion->query($sql);
      if ($guardando === true) {
        ?>
        <script type="text/javascript">
          alert("orden de compra generada exitosamente, puede seguir operando.");
        </script>';
        <?php
      } else { ?>
        <script type="text/javascript">
          alert("Error en la carga, intente muevamente.");
        </script>';
        <?php
      }

    } else {
      ?>
      <script type="text/javascript">
        alert("Producto sin registrar en DB. Genere alta de producto.");
      </script>
      <?php
    }



  }
  $conn->close();



  ES DE altaOrden.php

  if (isset($_POST['producto'])) {
    foreach ($_POST['producto'] as $indice => $prod) {
      $cantidad = $_POST['cantidad'][$indice];
      $consulta_sql = "INSERT INTO orden_compra SET sn = '$prod',
      cant = '$cantidad' ";
      mysqli_query($conexion, $consulta_sql);

      }

    }
    
    echo "
      <script>
        alert('Modificación Exitosa !!!');
        window.location = 'index.php?page=otrapagina'
      </script>";
    
    





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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logistics Freedom</title>
  <link rel="icon" type="image/x-icon" href="../images/favicon.png">
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
    padding: 0;
    background-color: darkred;
  }

  .tituloMod {
    color: white;
    margin-left: 30%;
    margin-top: 2%;
    margin-bottom: 3%;
  }

  th {
    text-align: center;
    font-family: 'Times New Roman', Times, serif;
    font-size: 1.32rem;
    color: blue;
  }

  td {
    text-align: center;
  }

  table th,
  td {
    border: 1px solid #ddd;
    padding: 10px;
    padding-top: 8px;
    padding-bottom: 8px;
    background-color: seagreen;
  }
</style>


<body translate="no">
  <h1 class="tituloMod"> SISTEMA DE MODIFICACIÓN</h1>
  <?php
  if (isset($_POST['eliminar']) < 0) {
    echo "INGRESE N° ORDEN";
  }
  if (isset($_POST['eliminar']) > 0) {
    $conn = mysqli_connect("localhost", "root", "", "bd_stock");
    $registro = $_POST['eliminar'];
    $adm = $email;

    $sql = "SELECT * FROM orden_compra WHERE n_orden = '$registro' ";
    $resultado = $conn->query($sql);
    ?>
    <table class="container text-center mb-5">
      <thead class="">
        <tr class=""><br>
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
      <br>
      <br>
      <?php

      if ($resultado->num_rows > 0) {
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];
        $query = "SELECT * FROM orden_compra WHERE n_orden = '$registro' ";
        $query_run = mysqli_query($conn, $query);
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
                    <?php echo $fila['id']; ?>
                  </td>
                  <td class="n_orden">
                    <?php echo $fila['n_orden']; ?>
                  </td>
                  <td class="fecha_orden">
                    <?php echo $fila['fecha_orden']; ?>
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
                      alert('No hay Información requerida, intente nuevamente!!!');
                      window.location = 'index.php?page=otrapagina'
                    </script>";
                ?>
              </td>
            </div>
            <?php
        }
      }
  } else { ?>
        echo "
        <script>
          alert('Ingreso invalido, respete credenciales.');
          window.location = 'index.php?page=otrapagina'
        </script>";
        }
        ?>
    </table>
    <?php
    $conn->close();
  }
  ?>
  <div style="margin-left: 31%;">
    <form style="margin-left:26%" class="formModificar" action="../baja-ordenes/eliminar.php" method="post">
      <div class="mb-1">
        <label style="font-family:'Times New Roman', Times, serif; font-size: 2rem; color:white;"
          for="exampleFormControlTextarea1" class="form-label">Motivos de Baja</label><br>
        <textarea style="border-radius: 10px; padding:10px; " name="mensaje" id="mensaje" rows="2" require
          cols="61"><?php echo $cant ?> </textarea>
      </div>


      <div>
        <label for="disabledTextInput" class="form-label"></label>
        <input class="form-control" style="width: 300px; margin-bottom:3%;" type="text" readonly name="administrador"
          value="<?php echo $administrador ?>">
      </div>



      <input style="border-radius: 10px; background-color:cornflowerblue; 
        font-size:1.2rem; width: auto; height: 40px; " class="botonModificar" type="submit" value="Eliminar Orden">
    </form>
  </div>
  <br>
  <br>
</body>

</html>
















    */

?>