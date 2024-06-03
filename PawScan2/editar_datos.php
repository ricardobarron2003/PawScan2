<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioUsuario.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

// Obtener los datos del usuario
Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();
$usuario = RepositorioUsuario::obtener_usuario_por_id($conexion, $_SESSION['usuario_id']);
Conexion::cerrar_conexion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="icono.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Datos - PawScan</title>
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #17a7a1;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #138b82;
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
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #138b82;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar mis datos</h1>
        <form action="actualizar_datos.php" method="post">
            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" required>
            <input type="email" name="email" placeholder="Correo Electrónico" value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>" required>
            <div style="position: relative;">
                <input type="password" id="password" name="password" placeholder="Nueva contraseña" required>
                <span class="toggle-password" onclick="togglePassword()">Mostrar</span>
            </div>
            <input type="text" name="telefono" placeholder="Teléfono" value="<?php echo htmlspecialchars($usuario['telefono_usuario']); ?>" required>
            <input type="text" name="direccion" placeholder="Dirección" value="<?php echo htmlspecialchars($usuario['direccion_usuario']); ?>" required>
            <input type="submit" value="Guardar cambios" onclick="return confirm('¿Seguro que deseas realizar los cambios?')">
        </form>
        <button class="back-button" onclick="window.location.href='sesion_iniciada.php'">Volver</button>
    </div>
</body>
</html>
<script>
function togglePassword() {
    var passwordField = document.getElementById("password");
    var togglePasswordText = document.querySelector(".toggle-password");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePasswordText.textContent = "Ocultar";
    } else {
        passwordField.type = "password";
        togglePasswordText.textContent = "Mostrar";
    }
}
</script>
