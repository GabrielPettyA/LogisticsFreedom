<?php
function conectarBaseDeDatos()
{
  $servername = "localhost:3306"; // Ojo caso particular de lucas puerto 3308
  $username = "root";
  $password = "";
  $dbname = "bd_stock";

  $conn = new mysqli($servername, $username, $password);
  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }

  // Crear la base si no existe
  $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
  if ($conn->query($sql) !== TRUE) {
    die("Error al crear la base de datos: " . $conn->error);
  }

  // Selecciona base de datos
  $conn->select_db($dbname);

  // Crear la tabla "productos" si no existe
  $sql = "CREATE TABLE IF NOT EXISTS productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30),
        sn VARCHAR(30),
        cant INT
    )";
  if ($conn->query($sql) !== TRUE) {
    die("Error al crear la tabla 'productos': " . $conn->error);
  }

  // Crear la tabla "mod_stock" si no existe
  $sql = "CREATE TABLE IF NOT EXISTS mod_stock (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_old INT,
        name_old VARCHAR(30),
        sn_old VARCHAR(30),
        cant_old INT,
        id_new INT,
        name_new VARCHAR(30),
        sn_new VARCHAR(30),
        cant_new INT,
        fecha DATE,
        motivo VARCHAR(30)
    )";
  if ($conn->query($sql) !== TRUE) {
    die("Error al crear la tabla 'mod_stock': " . $conn->error);
  }

  // Crear la tabla "orden_compra" si no existe
  $sql = "CREATE TABLE IF NOT EXISTS orden_compra (
      id INT AUTO_INCREMENT PRIMARY KEY,
      n_orden VARCHAR(5),
      fecha_orden DATE,
      proveedor VARCHAR(30) ,
      administrador VARCHAR(30) ,
      sn VARCHAR(13) ,
      cant INT,
      estado_orden VARCHAR(30),
      motivo_orden VARCHAR(255)
    )";
  if ($conn->query($sql) !== TRUE) {
    die("Error al crear la tabla 'orden_compra': " . $conn->error);
  }

  //Crear la tabla contacto si no existe 
  $sql = "CREATE TABLE IF NOT EXISTS contacto (
        id int AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(30),
        email varchar(30),
        telefono int,
        mensaje varchar(50)
        )";
  if ($conn->query($sql) !== TRUE) {
    die("Error al crear la tabla 'contacto' : " . $conn->error);
  }

  //Crear la tabla de usuarios
  $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(30),
        password VARCHAR(255)
    )";
  if ($conn->query($sql) !== TRUE) {
    die("Error al crear la tabla 'usuarios': " . $conn->error);
  }

  $admin = "admin@admin.com";
  $passw = password_hash("admin123", PASSWORD_DEFAULT);

  $sql = "SELECT * FROM usuarios WHERE email = '$admin'";
  $result = $conn->query($sql);
  if ($result->num_rows < 1) {
    $sql = "INSERT INTO usuarios (email, password )VALUE ('$admin', '$passw')";
    $result = $conn->query($sql);
  }

  //Crear la roles contacto si no existe 
  $sql = "CREATE TABLE IF NOT EXISTS roles (
        id int AUTO_INCREMENT PRIMARY KEY,
        acceso VARCHAR(30),
        id_usuario varchar(30)
        )";
  if ($conn->query($sql) !== TRUE) {
    die("Error al crear la tabla 'contacto' : " . $conn->error);
  }

  // Necesitamos el id del admin para ver si existe en roles - Lokitah !
  $sql = "SELECT id FROM usuarios WHERE email = '$admin'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $id = $row["id"];

  $sql = "SELECT acceso FROM roles WHERE id_usuario = '$id'";
  $result = $conn->query($sql);
  if ($result->num_rows < 1) {
    $sql = "INSERT INTO roles (id_usuario,acceso)
        VALUES ('$id', 'alta productos'), ('$id', 'contacto'), 
        ('$id', 'gestion usuarios'), ('$id', 'reportes'),
         ('$id', 'revisar contacto'), ('$id', 'stock'),
         ('$id','gestion ordenes')";
    $result = $conn->query($sql);
  }


  // Devolver la conexión
  return $conn;
}

// Llamar a la función para obtener la conexión a la base de datos
$conexion = conectarBaseDeDatos();
