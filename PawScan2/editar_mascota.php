<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioMascota.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id_mascota'])) {
    header('Location: mascotas_registradas.php');
    exit();
}

$id_mascota = $_GET['id_mascota'];

Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();

$mascota = RepositorioMascota::obtener_mascota_por_id($conexion, $id_mascota);

Conexion::cerrar_conexion();

if (!$mascota) {
    header('Location: mascotas_registradas.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Información de Mascota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="back-button-container">
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
    </div>
    <div class="container">
        <h1>Editar Información de Mascota</h1>
        <form action="actualizar_mascota.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_mascota" value="<?php echo htmlspecialchars($mascota['id_mascota']); ?>">
            <label for="nombre_mascota">Nombre:</label>
            <input type="text" name="nombre_mascota" id="nombre_mascota" value="<?php echo htmlspecialchars($mascota['nombre_mascota']); ?>" required>
            <label for="foto_mascota">Foto:</label>
            <input type="file" name="foto_mascota" id="foto_mascota" accept="image/*">
            <label for="edad_mascota">Edad:</label>
            <input type="number" name="edad_mascota" id="edad_mascota" value="<?php echo htmlspecialchars($mascota['edad_mascota']); ?>" required>
            <label for="vacunas_mascota">Vacunas:</label>
            <input type="text" name="vacunas_mascota" id="vacunas_mascota" value="<?php echo htmlspecialchars($mascota['vacunas_mascota']); ?>" required>
            <label for="caracteristicas_mascota">Características:</label>
            <input type="text" name="caracteristicas_mascota" id="caracteristicas_mascota" value="<?php echo htmlspecialchars($mascota['caracteristicas_mascota']); ?>" required>
            <button type="submit">Guardar cambios</button>
        </form>
    </div>
</body>
</html>





