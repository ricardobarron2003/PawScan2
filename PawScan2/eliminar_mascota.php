<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Conexión a la base de datos
include_once 'php/Conexion.php';
include_once 'php/RepositorioMascota.php';

$id_usuario = $_SESSION['usuario_id'];

// Si se ha enviado el formulario para eliminar una mascota
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mascota = $_POST['id_mascota'];

    Conexion::abrir_conexion();
    $conexion = Conexion::obtener_conexion();
    RepositorioMascota::eliminar_mascota($conexion, $id_mascota);
    Conexion::cerrar_conexion();

    // Redirigir después de eliminar
    header('Location: eliminar_mascota.php');
    exit();
}

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
    <title>Eliminar Mascotas - PawScan</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            width: 80%;
            max-width: 800px;
            text-align: center;
        }

        .header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 10px;
        }

        .back-button-container {
            margin: 10px;
        }

        .back-button {
            background-color: #17a7a1;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #138b82;
        }

        .mascota {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #333;
            border-radius: 5px;
        }

        .mascota img {
            border-radius: 5px;
            margin-top: 10px;
        }

        .mascota-buttons form {
            display: inline-block;
        }

        .mascota-buttons button {
            background-color: #ff4c4c;
            color: white;
            border: none;
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .mascota-buttons button:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Botón de Retroceso -->
        <div class="back-button-container">
            <button class="back-button" onclick="goBack()">← Volver</button>
        </div>
    </div>

    <div class="container">
        <h1>Eliminar Mascotas</h1>
        <?php if (!empty($mascotas)): ?>
            <?php foreach ($mascotas as $mascota): ?>
                <div class="mascota">
                    <p>Nombre: <?php echo htmlspecialchars($mascota['nombre_mascota']); ?></p>
                    <p>Edad: <?php echo htmlspecialchars($mascota['edad_mascota']); ?> años</p>
                    <p>Vacunas: <?php echo htmlspecialchars($mascota['vacunas_mascota']); ?></p>
                    <p>Características: <?php echo htmlspecialchars($mascota['caracteristicas_mascota']); ?></p>
                    <img src="<?php echo htmlspecialchars($mascota['foto_mascota']); ?>" alt="Foto de <?php echo htmlspecialchars($mascota['nombre_mascota']); ?>" width="150">
                    <div class="mascota-buttons">
                        <form action="eliminar_mascota.php" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar a tu mascota?')">
                            <input type="hidden" name="id_mascota" value="<?php echo htmlspecialchars($mascota['id_mascota']); ?>">
                            <button type="submit">Eliminar Mascota</button>
                        </form>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tienes mascotas registradas.</p>
        <?php endif; ?>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
