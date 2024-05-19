
<?php

// Función para validar la entrada (limpia caracteres especiales)

$data = $_POST['cuit'];
function validar_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Obtener el número ingresado (en este caso, desde formulario con metho=$_POST[])
$numero = validar_input($_POST["cuit"]);

// Extraer los dos primeros dígitos
$dosPrimerosDigitos = substr($numero, 0, $numero < 0 ? 3 : 2);

// Validar los dígitos según tus criterios
if (
  $dosPrimerosDigitos == 20 || $dosPrimerosDigitos == 23 || 
  $dosPrimerosDigitos == 24 || $dosPrimerosDigitos == 27 ||
  $dosPrimerosDigitos == 30 || $dosPrimerosDigitos == 33 || 
  $dosPrimerosDigitos == 34
) {
  return $numero;
} else {
  echo
    "<script>
alert('ERROR: El CUIT/CUIL no cumple la norma fiscal, Verifique...');
window.location='index.php?page=otrapagina'
</script>";
  return false;


}


?>