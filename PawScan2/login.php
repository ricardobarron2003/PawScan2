<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioUsuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    Conexion::abrir_conexion();
    $conexion = Conexion::obtener_conexion();

    $usuario = RepositorioUsuario::obtener_usuario_por_email($conexion, $email);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = $usuario['nombre_usuario'];
        $_SESSION['usuario_id'] = $usuario['id_usuario']; // Guardar id_usuario en la sesión
        header('Location: sesion_iniciada.php');
        exit();
    } else {
        $error = "Datos incorrectos. Inténtalo de nuevo.";
    }

    Conexion::cerrar_conexion();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="icono.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - PawScan</title>
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

        h1 {
            margin: 0;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px #000000;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #1cb9b3;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"]:hover {
            background-color: #17a7a1;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .back-button {
            background-color: #1cb9b3;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #17a7a1;
        }
    </style>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Correo Electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="submit" value="Iniciar Sesión">
        <button type="button" class="back-button" onclick="goBack()">← Volver</button>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </form>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
