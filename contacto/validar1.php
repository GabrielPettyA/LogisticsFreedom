<?php
if (isset($_POST['submit'])) {
    $nombre = $_POST['name'];
    $email = $_POST['email'];
    $tel = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];
    $validacion = [false, false, false];

    function isValid($value)
    {
        return $value == true;

    }

    if (empty($nombre) || strlen($nombre) > 15) {
        echo "<p class='text-danger'> El nombre ingresado debe tener menos de 15 caracteres. </p>";
    } else {
        $validacion[0] = true;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='text-danger'> El email ingresado no es válido. </p>";
    } else {
        $validacion[1] = true;
    }

    if (strlen($tel) < 8 || strlen($tel) > 10) {
        echo "<p class='text-danger'> El teléfono ingresado no es válido. Ingrese entre 8 a 10 digitos numericos </p>";
    } else {
        $validacion[2] = true;
    }

    $validacionArray = array_filter($validacion, 'isValid');
    if (count($validacionArray) == 3) {
       
        echo '<script type="text/javascript">
        alert("El formulario ha sido enviado con exito!. Nos contactaremos a la brevedad.");
        </script>';

        require("../includes/config/db-config.php");

        $sql = "INSERT INTO contacto (nombre,email,telefono,mensaje) VALUES ('$nombre','$email','$tel','$mensaje')";
        $guardando = $conexion->query($sql);

        $conexion->close();
    } else {
        echo '<script type="text/javascript">
        alert("Por favor revise el formulario ha ingresado campos invalidos.");
        </script>';
    }

}

?>