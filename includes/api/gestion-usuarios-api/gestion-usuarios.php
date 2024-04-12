<?php

require '../../config/db-config.php';

// Endpoint get usuarios para listar
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["usuarios"])) {
    $sql = "SELECT email,id FROM usuarios";
    $result = $conexion->query($sql);
    $response = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data = array(
                "email" => $row["email"],
                "id" => $row["id"]
            );
            $response[] = $data;
        }
    }

    $conexion->close();

    header("Content-Type: application/json");
    echo json_encode($response);
}


// Endpoint para crear usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {

        $validRquest = [false, false];

        $email = $data->email;
        $password = $data->password;
        $accesos = $data->roles;
        $passw = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (email ,password) VALUES (?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $email, $passw);
        if ($stmt->execute()) {
            $validRquest[0] = true;
        } else {
            $validRquest[0] = false;
        }

        $sql = "SELECT id FROM usuarios WHERE email = '$email'";
        $result = $conexion->query($sql);
        $row = $result->fetch_assoc();
        $id = $row["id"];

        // Uso otra varible para la segunda query porque se vuelve loco el cursor
        $stmt_roles = $conexion->prepare("INSERT INTO roles (acceso, id_usuario) VALUES (?, ?)");

        foreach ($accesos as $rol) {
            $stmt_roles->bind_param("si", $rol, $id);
            if ($stmt_roles->execute()) {
                $validRquest[1] = true;
            } else {
                $validRquest[2] = false;
            }
        }

        $validarSQL = array_filter($validRquest, function ($value) {
            return $value == 2;
        });

        if (count($validarSQL) == 2) {
            echo "Usuario añadido con exito.";
        } else {
            echo "Ah ocurrido un error en la solicitud.";
        }

        $stmt->close();
        $stmt_roles->close();
    }
}

// Endpoint para editar usuario
if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $data = json_decode(file_get_contents("php://input"));

    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {
        $validRequest = [false, false];

        $id = $data->id;
        $accesos = $data->roles;

        $sql = "DELETE FROM roles WHERE id_usuario = ?;";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $validRequest[0] = true;
        }

        if (!empty($accesos)) {

            $stmt_roles = $conexion->prepare("INSERT INTO roles (acceso, id_usuario) VALUES (?, ?)");

            foreach ($accesos as $rol) {
                $stmt_roles->bind_param("si", $rol, $id);
                if ($stmt_roles->execute()) {
                    $validRequest[1] = true;
                } else {
                    $validRequest[1] = false;
                }
            }

            $stmt_roles->close();
        } else {
            $validRequest[1] = true;
        }



        $validarSQL = array_filter($validRequest, function ($value) {
            return $value == false;
        });

        if (empty($validarSQL)) {
            echo "Usuario editado con éxito.";
        } else {
            echo "Ha ocurrido un error en la solicitud.";
        }

        $stmt->close();
    }
}

// Endpoint para eliminar usuario
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {

    $data = json_decode(file_get_contents("php://input"));

    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {
        $validRequest = [false, false];

        $id = $data->id;

        $sql = "DELETE FROM roles WHERE id_usuario = ?;";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $validRequest[0] = true;
        }

        $stmt_roles = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt_roles->bind_param("i", $id);
        if ($stmt_roles->execute()) {
            $validRequest[1] = true;
        } else {
            $validRequest[1] = false;
        }

        $validarSQL = array_filter($validRequest, function ($value) {
            return $value == false;
        });

        if (empty($validarSQL)) {
            echo "Usuario eliminado con éxito.";
        } else {
            echo "Ha ocurrido un error en la solicitud.";
        }

        
        $stmt->close();
        $stmt_roles->close();
    }
}
