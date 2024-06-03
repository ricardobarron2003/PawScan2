<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioMascota.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mascota = $_POST['id_mascota'];
    $nombre_mascota = $_POST['nombre_mascota'];
    $edad_mascota = $_POST['edad_mascota'];
    $vacunas_mascota = $_POST['vacunas_mascota'];
    $caracteristicas_mascota = $_POST['caracteristicas_mascota'];

    // Manejo de la nueva imagen si se ha subido una
    if (isset($_FILES['foto_mascota']) && $_FILES['foto_mascota']['error'] === UPLOAD_ERR_OK) {
        $archivo_temp = $_FILES['foto_mascota']['tmp_name'];
        $nombre_archivo = basename($_FILES['foto_mascota']['name']);
        $ruta_imagen = 'uploads/' . $nombre_archivo;

        // Mover la imagen subida a la carpeta de destino
        if (!move_uploaded_file($archivo_temp, $ruta_imagen)) {
            die('Error al subir la imagen');
        }
    } else {
        // Mantener la imagen existente si no se sube una nueva
        Conexion::abrir_conexion();
        $conexion = Conexion::obtener_conexion();
        $mascota = RepositorioMascota::obtener_mascota_por_id($conexion, $id_mascota);
        $ruta_imagen = $mascota['foto_mascota'];
        Conexion::cerrar_conexion();
    }

    Conexion::abrir_conexion();
    $conexion = Conexion::obtener_conexion();

    RepositorioMascota::actualizar_mascota($conexion, $id_mascota, $nombre_mascota, $ruta_imagen, $edad_mascota, $vacunas_mascota, $caracteristicas_mascota);

    Conexion::cerrar_conexion();

    header('Location: mascotas_registradas.php');
    exit();
}
?>
