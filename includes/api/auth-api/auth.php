<?php

require '../../config/db-config.php';


//Loguearse
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = json_decode(file_get_contents("php://input"));

    if ($data === null) {

        echo "FALSE";
    } else {

        $email = $conexion->real_escape_string($data->email);
        $password = $conexion->real_escape_string($data->password);
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {

            $fila = $resultado->fetch_assoc();
            $hash_almacenado = $fila['password'];
            $id = $fila['id'];

            // Verificar si la contraseña coincide con el hash almacenado
            if (password_verify($password, $hash_almacenado)) {

                session_start();

                // Roles
                $sql = "SELECT acceso FROM roles WHERE id_usuario = '$id'";
                $result = $conexion->query($sql);

                $roles = array();
                while ($row = $result->fetch_assoc()) {
                    $roles[] = $row['acceso'];
                }

                $_SESSION['roles'] = $roles;
                $_SESSION['email'] = $email;

                echo "TRUE";
            } else {

                echo "FALSE";
            }
        } else {

            echo "FALSE";
        }

        $conexion->close();
    }
}
