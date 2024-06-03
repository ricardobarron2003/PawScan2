<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioUsuario.php';
include_once 'php/RepositorioMascota.php';
include_once 'barcode-1.1.1/barcode.php';

$id_mascota = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id_mascota) {
    echo "<script>alert('ID de mascota no especificado'); window.location.href = 'mascotas_registradas.php';</script>";
    exit();
}

Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();

$mascota = RepositorioMascota::obtener_mascota_por_id($conexion, $id_mascota);
if (!$mascota) {
    echo "<script>alert('Mascota no encontrada'); window.location.href = 'mascotas_registradas.php';</script>";
    exit();
}

$id_usuario = $mascota['id_usuario'];
$usuario = RepositorioUsuario::obtener_usuario_por_id($conexion, $id_usuario);
Conexion::cerrar_conexion();

if (!$usuario) {
    echo "<script>alert('Usuario no encontrado'); window.location.href = 'mascotas_registradas.php';</script>";
    exit();
}

$generador = new barcode_generator();
$qr_url = "http://localhost/PawScan2/QR_mascota.php?id=" . urlencode($id_mascota);
$svg = $generador->render_svg("qr", $qr_url, "");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de la Mascota - PawScan</title>
    <style>
        body {
            margin: 15vh;
            height: 100vh;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .container {
            margin-top: 50px;
            background-color: #17a7a1;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            align-self: center;
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
    <div class="container">
        <h1>Datos del dueño:</h1>
        <p>Nombre: <?php echo htmlspecialchars($usuario['nombre_usuario']); ?></p>
        <p>Email: <?php echo htmlspecialchars($usuario['email_usuario']); ?></p>
        <p>Teléfono: <?php echo htmlspecialchars($usuario['telefono_usuario']); ?></p>
        <p>Dirección: <?php echo htmlspecialchars($usuario['direccion_usuario']); ?></p>

        <h1>Datos de la mascota:</h1>
        <p>Nombre: <?php echo htmlspecialchars($mascota['nombre_mascota']); ?></p>
        <p>Edad: <?php echo htmlspecialchars($mascota['edad_mascota']); ?> años</p>
        <p>Vacunas: <?php echo htmlspecialchars($mascota['vacunas_mascota']); ?></p>
        <p>Características: <?php echo htmlspecialchars($mascota['caracteristicas_mascota']); ?></p>
        <img src="<?php echo htmlspecialchars($mascota['foto_mascota']); ?>" alt="Foto de <?php echo htmlspecialchars($mascota['nombre_mascota']); ?>" width="200" />
        
        <h2>QR Code:</h2>
        <div><?php echo $svg; ?></div>
    </div>
</body>
</html>
