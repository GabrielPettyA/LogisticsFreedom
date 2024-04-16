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
    
    
    */

?>