<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="icono.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión Iniciada - PawScan</title>
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
            min-height: 100vh;
        }

        .container {
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 800px;
            text-align: center;
        }

        .header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 10px;
        }

        .container a {
            background-color: #17a7a1;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 15px;
            transition: background-color 0.3s;
            display: inline-block;
            margin: 10px 5px;
        }

        .container a:hover {
            background-color: #138b82;
        }

        .back-button-container, .logout-button-container {
            margin: 10px;
        }

        .back-button, .logout-button {
            background-color: #17a7a1;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .back-button:hover, .logout-button:hover {
            background-color: #138b82;
        }

        /* Estilo del título */
        h1 {
            font-size: 2.5rem;
            margin-top: 5px;
            margin-bottom: 30px;
            background: linear-gradient(45deg, #ff6b6b, #ffcc33);
            -webkit-background-clip: text;
            color: transparent;
            animation: gradient-animation 3s infinite;
        }

        @keyframes gradient-animation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .title-shadow {
            text-shadow: 0 2px 5px rgba(255, 107, 107, 0.8), 0 2px 10px rgba(255, 204, 51, 0.5);
        }

        img {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 600px) {
            .container a {
                font-size: 0.875rem;
                padding: 10px 15px;
            }

            .back-button, .logout-button {
                font-size: 0.875rem;
                padding: 8px 15px;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Botón de Retroceso -->
        <div class="back-button-container">
            <button class="back-button" onclick="goBack()">← Volver</button>
        </div>

        <!-- Botón de Cerrar Sesión -->
        <div class="logout-button-container">
            <form action="logout.php" method="POST">
                <button type="submit" class="logout-button">Cerrar sesión</button>
            </form>
        </div>
    </div>
    
    <div class="container">
        <h1 class="title-shadow" style="font-size: 80px">Menú principal</h1>
        <div class="buttons">
            <a href="registrar_mascota.php">Registrar Mascota</a>
            <a href="mascotas_registradas.php">Ver Mascotas</a>
            <a href="eliminar_mascota.php">Eliminar Mascotas</a>
        </div>
        <div class="community-text">
            <img src="imagenes/logo.jpeg" alt="Instagram" width="400px" height="500px">
        </div>
        <div class="buttons" style="padding-top: 10px; padding-bottom: 10px">
            <a href="editar_datos.php">Editar mis datos</a>
            <a class="payment-button" onclick="window.location.href='realizar_pedido.php'">Realizar pedido</a>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
