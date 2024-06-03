<?php
session_start();
include_once 'php/Conexion.php';
include_once 'php/RepositorioUsuario.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener los datos del usuario
Conexion::abrir_conexion();
$conexion = Conexion::obtener_conexion();
$usuario = RepositorioUsuario::obtener_usuario_por_id($conexion, $_SESSION['usuario_id']);
Conexion::cerrar_conexion();

if (!$usuario) {
    echo "Error: No se pudo obtener la información del usuario.";
    exit();
}

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres_mascotas = $_POST['nombres_mascotas'];
    $comprobante_pago = $_FILES['comprobante_pago'];

    // Validar y mover el archivo de comprobante de pago
    if ($comprobante_pago['error'] == 0) {
        $comprobante_path = 'uploads/' . basename($comprobante_pago['name']);
        move_uploaded_file($comprobante_pago['tmp_name'], $comprobante_path);

        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pawscanpw@gmail.com'; // Cambia esto por tu correo de Gmail
            $mail->Password = 'lotpphtwywmoroav'; // Cambia esto por tu contraseña de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('pawscanpw@gmail.com', 'PawScan');
            $mail->addAddress('pawscanpw@gmail.com');
            
            //Enviar el comprobante de pago al correo de la empresa
            $mail->addAttachment($comprobante_path);

            $mail->isHTML(true);
            $mail->Subject = 'Nuevo Pedido Realizado';
            $mail->Body = "El usuario ha realizado un nuevo pedido.<br><br>";
            $mail->Body .= "Nombre: " . $usuario['nombre_usuario'] . "<br>";
            $mail->Body .= "Correo: " . $usuario['email_usuario'] . "<br>";
            $mail->Body .= "Teléfono: " . $usuario['telefono_usuario'] . "<br>";
            $mail->Body .= "Dirrección: " . $usuario['direccion_usuario'] . "<br>";
            $mail->Body .= "Nombres de las mascotas: " . $nombres_mascotas . "<br>";

            $mail->send();

            // Redirigir a una página de éxito
            header('Location: pedido_exitoso.php');
            exit();
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error al subir el comprobante de pago.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="icon" href="icono.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido - PawScan</title>
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 5vh;
            
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

        input[type="text"], input[type="email"], input[type="file"], input[type="number"] {
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

        .steps {
            text-align: left;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Realizar Pedido 📿</h1>
        <div class="steps">
            <p>Precios:</p>
            <ul>
                <li>100$ (Collar con QR para una mascota)</li>
                <li>200$ (Collar con QR para máximo 5 mascotas)</li>
            </ul>
            <p>Paso 1: Realizar el pago al número de cuenta: xx-xx-xx-xx-xx-xx-xx-xxxx.</p>
            <p>Paso 2: Adjuntar en el siguiente campo la imagen del comprobante de pago realizado al número de cuenta anterior.</p>
            <p>Paso 3: Proporcionar por texto los nombres de la(s) mascota(s) a la cual(es) se le(s) generará collar QR.</p>
            <p>Paso 4: Presione el botón de Enviar pedido.</p>
            <p>Tenga en cuenta que los datos de su correo, domicilio y teléfono para seguir su pedido se tomarán directamente de sus datos registrados en su cuenta actual.</p>
        </div>
        <form action="realizar_pedido.php" method="post" enctype="multipart/form-data">
            <input type="file" name="comprobante_pago" required>
            <input type="text" name="nombres_mascotas" placeholder="Nombres de las mascotas" required>
            <input type="submit" value="Enviar pedido">
             <button class="back-button" onclick="window.location.href='sesion_iniciada.php'">Volver</button>
        </form>
        <br>
        <div class="" style="align-self: center; background-color: darkslategray; border-radius: 10px; padding-top: 1px; padding-bottom: 1px">
            <h4>Dudas o aclaraciones favor de comunicarse con nosotros: </h4>
            <img src="icono.png" alt="Correo" width="50" height="50">
                <p>pawscanpw@gmail.com</p>
        </div>
    </div>
</body>
</html>
