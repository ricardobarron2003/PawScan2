<?php
include_once 'php/Conexion.php';
include_once 'php/RepositorioUsuario.php';
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $usuario_id = $_SESSION['usuario_id'];
    $password = $_POST['password'];
    
    

    Conexion::abrir_conexion();
    $conexion = Conexion::obtener_conexion();

    if (!empty($password)) {
        // Si se proporciona una nueva contraseña, hashearla
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    } else {
        // Si no se proporciona una nueva contraseña, obtener la contraseña actual del usuario
        $usuario_actual = RepositorioUsuario::obtener_usuario_por_email($conexion, $usuario_id);
        if ($usuario_actual) {
            $password_hashed = $usuario_actual['password'];
        } else {
            echo "Error: No se pudo obtener la contraseña actual del usuario.";
            Conexion::cerrar_conexion();
            exit();
        }
    }

    $actualizado = RepositorioUsuario::actualizar_usuario($conexion, $usuario_id, $nombre, $email, $password_hashed, $telefono, $direccion);

    Conexion::cerrar_conexion();

    if ($actualizado) {
        // Actualizar el email en la sesión si se ha cambiado
        $_SESSION['usuario'] = $email;
        header('Location: sesion_iniciada.php');
        
        exit();
    } else {
        echo "Error al actualizar los datos del usuario.";
    }
}
?>
