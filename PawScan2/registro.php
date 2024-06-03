<?php
include_once 'php/Conexion.php';
session_start(); // Iniciar la sesión para manejar mensajes de éxito y error

$error_message = ""; // Variable para almacenar mensajes de error

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $fecha_registro = date('Y-m-d H:i:s');
    
    // Abrir la conexión a la base de datos
    Conexion::abrir_conexion();
    $conexion = Conexion::obtener_conexion();
    
    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre_usuario, email_usuario, password, telefono_usuario, direccion_usuario, fecha_registro, activo) VALUES (:nombre, :email, :password, :telefono, :direccion, :fecha_registro, 1)";
    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':fecha_registro', $fecha_registro);

    try {
        if ($stmt->execute()) {
            // Establecer mensaje de éxito en la sesión
            $_SESSION['mensaje_exito'] = "Registro exitoso.";
            
            // Redirigir al index.php
            header('Location: index.php');
            exit();
        }
    } catch (PDOException $e) {
        // Verificar si el error es por duplicidad del correo electrónico
        if ($e->getCode() == 23000) {
            $error_message = "Ese correo electrónico ya está en uso.";
        } else {
            $error_message = "Error al registrar el usuario: " . $e->getMessage();
        }
    }

    // Cerrar la conexión a la base de datos
    Conexion::cerrar_conexion();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="icono.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - PawScan</title>
    <style>
        body {
            background-image: url('fondo.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
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
            width: 300px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px -10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #1cb9b3;
            color: #ffffff;
            padding: 10px 20px;
            padding-left: 120px;
            padding-right: 120px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: center;
        }

        input[type="submit"]:hover {
            background-color: #17a7a1;
        }

        .error-message {
            color: #ff4c4c;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Registro de Usuario 📝</h1>
    <form action="registro.php" method="post">
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="text" name="direccion" placeholder="Dirección" required>
        <input type="submit" value="Registrar">
        
        <div class="back-button-container">
            <button style="background-color: #1cb9b3;
            color: #ffffff;
            padding: 10px 20px;
            padding-left: 120px;
            padding-right: 120px;
            text-align: center;
            border: none;
            border-radius: 5px;
            margin-top: 15px; 
            cursor: pointer;
            transition: background-color 0.3s;
            align-self: center;" class="back-button" onclick="goBack()">← Volver</button>
            <script>
        function goBack() {
            window.history.back();
        }
            </script>
        </div>
        
        
        
    </form>
</body>
</html>
