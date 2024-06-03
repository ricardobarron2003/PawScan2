<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioMascota.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

Conexion::abrir_conexion();
$mascotas = RepositorioMascota::obtener_mascotas_por_usuario(Conexion::obtener_conexion());
Conexion::cerrar_conexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_mascota'])) {
    $id_mascota = $_POST['id_mascota'];

    Conexion::abrir_conexion();
    $mascota_eliminada = RepositorioMascota::eliminar_mascota(Conexion::obtener_conexion(), $id_mascota);
    Conexion::cerrar_conexion();

    if ($mascota_eliminada) {
        echo "<script>alert('Mascota eliminada correctamente'); window.location.href = 'editar_mascotas.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error al eliminar la mascota');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mascotas - PawScan</title>
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

        .mascotas-container {
            margin-top: 20px;
        }

        .mascota-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .mascota-item form {
            display: inline;
            margin-left: 10px;
        }

        .mascota-item button {
            background-color: #ff4d4d;
            color: #ffffff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .mascota-item button:hover {
            background-color: #e60000;
        }
    </style>
    <script>
        function confirmarEliminacion() {
            return confirm('¿Estás seguro de que deseas eliminar esta mascota?');
        }
    </script>
</head>
<body>
    <h1>Editar Mascotas</h1>
    <div class="mascotas-container">
        <?php foreach ($mascotas as $mascota) { ?>
            <div class="mascota-item">
                <a href="editar_mascota.php?id=<?php echo $mascota['id_mascota']; ?>"><?php echo htmlspecialchars($mascota['nombre_mascota']); ?></a>
                <form method="POST" onsubmit="return confirmarEliminacion();">
                    <input type="hidden" name="id_mascota" value="<?php echo $mascota['id_mascota']; ?>">
                    <button type="submit" name="eliminar_mascota">Eliminar Mascota</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>
