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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="../../images/favicon.png">
  <title>Logistics Freedom</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body translate="no" class="text-bg-success">
  <h1 style="margin-left:30%; margin-top:2%; margin-bottom:3%; box-shadow: 4px 4px 10px 7px darkgreen; width: 32%; border-radius: 15px; " 
  class="tituloMod"> SISTEMA BAJA DE ÓRDENES</h1>
  <?php
/* OBTENCIÓN DE LOS DATOS ENVIADOS POR FORMULARIO Y LLAMADO A DB. PARA LISTAR LA INFORMACIÓN QUE POSEE Y PODER
   UTILIZARLA PARA LUEGO HACER LOS CAMBIOS REQUERIDOS VISUALIZÁNDOLOS EN TIEMPO REAL */

  $conn = mysqli_connect("localhost", "root", "", "bd_stock");
  $registro = $_POST['eliminar'];
  $fechaRecep = $_POST['date'];
  $sql = "SELECT * FROM orden_compra WHERE n_orden = '$registro' ";
  $resultado = $conn->query($sql);
  if ($resultado->num_rows > 0) {
    $fila = mysqli_fetch_array($resultado);
    $id = $fila[0];
    $n_orden = $fila[1];
    $fecha_orden = $fila[2];
    $proveedor = $fila[3];
    $cuit = $fila[4];
    $administrador = $fila[5];
    $sn = $fila[6];
    $cant = $fila[7];
    $estado_orden = $fila[11];
    $motivo_orden = $fila[12];
    //$baja = 'DADA DE BAJA';
    ?>
    <!-- FORMULARIO ARMADO PARA MODIFICAR LOS ESTADOS Y AGREGAR MENSAJE DE MOTIVO DE MODIFICACIÓN -->

    <form style="margin-left:26%" class="formModificar" action="../modificar/eliminar.php" method="post">
      <div>
        <label style="margin-left:10px;" for="date" class="form-label mt-5 mb-3"> Fecha Actual:</label>
        <input type="text" name="date" id="date" placeholder="" required autocomplete="off"
        value="<?php echo $fechaRecep?> ">
      </div>

      <label for="disabledTextInput" class="form-label">N° Orden afectada</label>
      <input class="form-control" style="width: 300px; margin-bottom:3%;" type="text" readonly name="orden"
        value="<?php echo $n_orden ?>">

      <label for="disabledTextInput" class="form-label">Estado actual de N° Orden</label>
      <input class="form-control" style="width: 300px; margin-bottom:3%;" type="text" readonly name="estadoReal"
        value="<?php echo $estado_orden ?>">

      <label for="Select" class="form-label">Cambiar Estado</label>

      <select onchange="habilitar(this)" style="width: 300px; box-shadow:4px 4px 35px 5px black; " 
      class="form-select" name="estadoActual" id="camEstado ">
        <option disable selected="">Opción: Cambiar Estado</option>
        <optgroup label="Gestión de Orden">
          <option value='SOLICITADA'>SOLICITADA</option>
          <option value='EN CAMINO'>EN CAMINO</option>
          <option value='DADA DE BAJA'>DADA DE BAJA</option>
        </optgroup>
        <optgroup label="Recepción">
          <option value='ENTREGADA'>ENTREGADA</option>
          <option value='RECHAZADA'>RECHAZADA</option>
        </optgroup>
      </select>

      <br>
      <br>

      <!-- LÓGICA PARA VALIDAR LOS "VALUE" PERMITIDOS A REALIZAR CAMBIOS EN LA VENTANA DE MENSAJE, PERMITIENDO 
           O NO EL ACCESO A LA MISMA, SEGÚN SU 'ESTADO' -->
      <script>
        function habilitar(obj) {
          var hab;
          frm = obj.form;
          num = obj.selectedIndex;
          if (num == -1 || num == 1 || num == 2 || num == 4) hab = true;
          else if (num == 3 || num == 5) hab = false;
          frm.mensaje.disabled = hab;
        }
      </script>

      <label for="disabledTextInput" class="form-label">Administrador de operación</label>
      <input class="form-control" style="width: 300px; margin-bottom:3%;" type="text" readonly name="administrador"
        value="<?php echo $administrador ?>">

      <div class="mb-1">
        <label for="exampleFormControlTextarea1" class="form-label">Proveedor afectado</label><br>
        <textarea style="border-radius: 10px; padding:10px;" name="prov" id="prov" rows="2" readonly
          cols="61"><?php echo $proveedor ?> </textarea>
      </div><br>

      <div class="mb-1">
        <label for="exampleFormControlTextarea1" class="form-label">Motivo de ''BAJA'' o ''RECHAZO''</label><br>
        <textarea style="border-radius: 10px; padding:10px; box-shadow:4px 4px 35px 5px black; " name="mensaje" id="mensaje" rows="2" cols="61"
          placeholder="Escriba motivos solo en caso de orden ''RECHAZADA'' o ''DADA DE BAJA''." disabled require></textarea>
      </div>

      <?php
      ?>


      <div class="form-group mt-5">
        <input type="submit" class="botonEliminar" value="Aceptar" style="border-radius: 10px; background-color:darkgray; color: darkblue; 
      font-size:1.5rem; width: 120px; height: 54px; box-shadow: 4px 4px 14px darkblue; font-family:'Times New Roman', Times, serif; " ">

        <a class="btn btn-default mb-1 " style="margin-left: 30px; box-shadow: 4px 4px 14px darkred;
      color: darkred ;  font-size:1.5rem;  background-color:darkgray; border-radius: 10px;
      font-family:'Times New Roman', Times, serif; " href="../modificar/modificar.php ">Cancelar</a>
      </div>
      <br>
      <br>
      <br>
    </form>

    <?php


  } //else {
  ?>
  <!--
    <h1 style="justify-content:center; text-align:center; color:brown; margin-top:12%; font-size:3rem; ">
      "ERROR: Orden No Existe. Verifique Nuevamente !!!"</h1>

    <a class="botonModificar" style="margin-left: 10%;
      color:blue;  font-size:1.5rem; text-decoration:none;
      font-family:Georgia, 'Times New Roman', Times, serif;
      " href="../modificar-ordenes/index.php">Volver</a>-->
  <?php
  //}
  $conn->close();
  ?>
</body>

</html>