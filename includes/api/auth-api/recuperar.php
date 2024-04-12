<?php

require '../../config/db-config.php';

function resetearContrasena($conexion, $email)
{

    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        $nuevaContrasena = generarNuevaContrasena();

        $hashContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashContrasena, $email);
        $stmt->execute();

        enviarCorreo($email, $nuevaContrasena);

        echo "Se ha enviado una nueva contraseña al correo electrónico proporcionado.";
    } else {
        echo "El correo electrónico no existe en la base de datos.";
    }

    $stmt->close();
}

function generarNuevaContrasena($longitud = 12)
{
    $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($caracteres), 0, $longitud);
}

function enviarCorreo($email, $nuevaContrasena)
{

    $para = $email;
    $asunto = "Contraseña restablecida";
    $mensaje = "<h3> Se ha solicitado un reinicio de su contraseña.</h3><p> Su nueva contraseña es: " . $nuevaContrasena . "
    </p> <p>Si no ha solicitado este reinicio por favor de aviso al administrador.</p> <p> De lo contrario
    ya puede ingresar con la nueva contraseña.</p><p> Cordialmente: Sistema de respuesta automática - Logistcs Freedom</p>";

    // Cabeceras del correo
    $headers = "From: remitente@example.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Envía el correo
    if (mail($para, $asunto, $mensaje, $headers)) {
        echo "El correo se envió correctamente.";
    } else {
        echo "No se pudo enviar el correo.";
    }
}

// Endpoint recuperar cuenta
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = json_decode(file_get_contents("php://input"));
    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {

        $email = $data->email;

        resetearContrasena($conexion, $email);

        $conexion->close();
    }
}
