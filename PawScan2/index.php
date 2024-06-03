<?php
include_once 'php/Conexion.php';
include_once 'php/RepositorioUsuario.php';

session_start(); // Iniciar la sesión para manejar mensajes de éxito

Conexion::abrir_conexion();
$total_usuarios = RepositorioUsuario::obtener_numero_usuarios(Conexion::obtener_conexion());
Conexion::cerrar_conexion();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="icon" href="icono.png" type="image/x-icon">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PawScan</title>
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
                min-height: 100vh;
            }

            .social-icons {
                position: absolute;
                top: 10px;
                left: 20px;
            }

            .social-icons a {
                margin-right: 10px;
            }

            .social-icons img {
                width: 50px;
                height: 50px;
            }

            h1 {
                font-size: 3em;
                color: #ffffff;
                opacity: 0;
                animation: fadeIn 2s forwards;
                text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            }

            .container {
                text-align: center;
                margin-top: 5px;
                background: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
                padding: 20px;
                border-radius: 10px;
            }

            .container img {
                max-width: 100%;
                height: auto;
                margin: 0px 0;
                opacity: 0;
                animation: fadeIn 2s 2s forwards;
            }

            .container .buttons {
                display: flex;
                justify-content: center;
                gap: 20px;
                flex-wrap: wrap; /* Para que los botones se ajusten en pantallas pequeñas */
                opacity: 0;
                animation: fadeIn 2s 3s forwards;
            }

            .container .buttons a {
                text-decoration: none;
                color: #ffffff;
                background-color: #1cb9b3;
                padding: 15px 30px;
                border-radius: 5px;
                font-size: 1em;
                transition: background-color 0.3s;
                margin: 10px; /* Añadido margen para separarlos en pantallas pequeñas */
            }

            .container .buttons a:hover {
                background-color: #17a7a1;
            }

            .community-text {
                color: #ffffff;
                font-weight: bold;
                font-size: 1.2em;
                opacity: 0;
                animation: fadeIn 2s 4s forwards;
            }

            @keyframes fadeIn {
                to {
                    opacity: 1;
                }
            }
        </style>
    </head>
    <body>
        <div class="social-icons">
            <a href="https://www.instagram.com/_pawscan_/" target="_blank">
                <img src="imagenes/instagram.jpeg" alt="Instagram">
            </a>
        </div>
        <h1>Bienvenido a PawScan</h1>
        <div class="container">
            <img src="imagenes/logo.jpeg" alt="Logo de PawScan">
            <div class="buttons">
                <a href="login.php">Iniciar Sesión</a>
                <a href="registro.php">Registrate</a>
            </div>

            <br><br>
            <div class="community-text">
                Únete a nuestra comunidad, ya somos: <?php echo $total_usuarios; ?> usuarios
            </div>
            <?php
            // Mostrar el mensaje de éxito si está presente
            if (isset($_SESSION['mensaje_exito'])) {
                echo "<p style='color: green;'>" . $_SESSION['mensaje_exito'] . "</p>";
                // Eliminar el mensaje de éxito de la sesión
                unset($_SESSION['mensaje_exito']);
            }
            ?>
        </div>
    </body>
</html>
