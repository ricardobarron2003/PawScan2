<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioMascota.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_mascota = $_POST['nombre_mascota'];
    $edad_mascota = $_POST['edad_mascota'];
    $vacunas_mascota = $_POST['vacunas_mascota'];
    $caracteristicas_mascota = $_POST['caracteristicas_mascota'];
    $id_usuario = $_SESSION['usuario_id'];
    
    // Manejo de la imagen subida
    $foto_mascota = $_FILES['foto_mascota'];
    $nombre_imagen = basename($foto_mascota['name']);
    $ruta_imagen = 'uploads/' . $nombre_imagen;
    $ruta_absoluta = __DIR__ . '/' . $ruta_imagen;
    
    if (move_uploaded_file($foto_mascota['tmp_name'], $ruta_absoluta)) {
        Conexion::abrir_conexion();
        $conexion = Conexion::obtener_conexion();

        $mascota_registrada = RepositorioMascota::registrar_mascota($conexion, $id_usuario, $nombre_mascota, $ruta_imagen, $edad_mascota, $vacunas_mascota, $caracteristicas_mascota);

        Conexion::cerrar_conexion();

        if ($mascota_registrada) {
            echo "<script>alert('Mascota registrada correctamente'); window.location.href = 'sesion_iniciada.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error al registrar la mascota');</script>";
        }
    } else {
        echo "<script>alert('Error al subir la imagen');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="icono.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Mascota - PawScan</title>
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px #000000;
        }

        form div {
            margin-bottom: 10px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="file"],
        form input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
        }

        form input[type="submit"] {
            background-color: #1cb9b3;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form input[type="submit"]:hover {
            background-color: #17a7a1;
        }
    </style>
</head>
<body>
    <button  class="back-button" onclick="goBack()" style="background-color: #17a7a1; /* Verde agua */
                 color: white;
                 border: none;
                 padding: 10px 20px;
                 font-size: 16px;
                 border-radius: 5px;
                 cursor: pointer;
                 box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                 transition: background-color 0.3s ease;
                 position: fixed;
                 top: 10px;
                 left: 10px;
                 z-index: 1000;">← Volver
        </button>
        <script>
        function goBack() {
            window.history.back();
        }
        </script>
    <form action="registrar_mascota.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nombre_mascota">Nombre de la mascota</label>
            <input type="text" name="nombre_mascota" id="nombre_mascota" required>
        </div>
        <div>
            <label for="foto_mascota">Foto de la mascota</label>
            <input type="file" name="foto_mascota" id="foto_mascota" required>
        </div>
        <div>
            <label for="edad_mascota">Edad de la mascota</label>
            <input type="number" name="edad_mascota" id="edad_mascota" required>
        </div>
        <div>
            <label for="vacunas_mascota">Vacunas de la mascota</label>
            <input type="text" name="vacunas_mascota" id="vacunas_mascota" required>
        </div>
        <div>
            <label for="caracteristicas_mascota">Características de la mascota</label>
            <input type="text" name="caracteristicas_mascota" id="caracteristicas_mascota" required>
        </div>
        <div>
            <input type="submit" value="Registrar Mascota" style="align-self: center;">
        </div>
        <img src="imagenes/peces.jpeg">
    </form>
</body>
</html>
