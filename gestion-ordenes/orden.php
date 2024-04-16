<?php 










//                       MOMENTANEAMENTE NO ESTOY USANDO ESTE ARCHIVO, RESERVADO POR POSIBLE NECESIDAD.
function generate_int()
{
  $numero = 3;
  $input = '0123456789';
  $input_length = strlen($input);
  $random_int = '';
  for ($i = 0; $i < $numero; $i++) {
    $random_num = $input[mt_rand(0, $input_length - 1)];
    $random_int .= $random_num;
    if ($numero == $random_int) {
      generate_int();
      return $random_int;
    }
  }
  return $random_int;
}
$ordenCompra = generate_int();


/*
require ('../includes/config/db-config.php');
$validar = "SELECT * FROM 'orden_compra' WHERE n_orden = '$ordenCompra'";
$validando = $conexion->query($validar);
if ($validando->num_rows > 0) {
  if ($validando == $ordenCompra) {
    generate_int();
    //$orden = $ordenCompra;
  } else {
    ?>
    <script type="text/javascript">
      alert("Orden generada".$ordenCompra);
    </script>
    <?php
  }
}
/*$random_int;*/
//$conn->close();
?>