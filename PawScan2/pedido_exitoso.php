<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="icono.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Exitoso - PawScan</title>
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
        <h1>Pedido Exitoso</h1>
        <p>Tu pedido se ha procesado correctamente. Gracias por tu compra.</p>
        <button class="back-button" onclick="window.location.href='sesion_iniciada.php'">Volver a la página principal</button>
    </div>
</body>
</html>
