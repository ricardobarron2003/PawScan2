<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioMascota.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();
$mascotas = RepositorioMascota::obtener_mascotas_por_usuario($conexion, $id_usuario);
Conexion::cerrar_conexion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="icono.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mascotas Registradas - PawScan</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .mascota {
            background-color: #1a1a1a;
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .mascota img {
            width: 200px;
            height: auto;
            border-radius: 5px;
        }
        .btn-ver-qr {
            background-color: #1cb9b3;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-ver-qr:hover {
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
    <h1>Mascotas Registradas</h1>
    <?php foreach ($mascotas as $mascota) { ?>
        <div class="mascota">
            <h2><?php echo htmlspecialchars($mascota['nombre_mascota']); ?></h2>
            <img src="<?php echo htmlspecialchars($mascota['foto_mascota']); ?>" alt="Foto de <?php echo htmlspecialchars($mascota['nombre_mascota']); ?>">
            <p>Edad: <?php echo htmlspecialchars($mascota['edad_mascota']); ?> años</p>
            <p>Vacunas: <?php echo htmlspecialchars($mascota['vacunas_mascota']); ?></p>
            <p>Características: <?php echo htmlspecialchars($mascota['caracteristicas_mascota']); ?></p>
            <br>
            <a href="QR_mascota.php?id=<?php echo urlencode($mascota['id_mascota']); ?>" class="btn-ver-qr">Ver QR</a>
            <a href="editar_mascota.php?id_mascota=<?php echo htmlspecialchars($mascota['id_mascota']); ?>" class="btn-ver-qr">Editar información de mascota</a>
        </div>
    <?php } ?>
</body>
</html>
