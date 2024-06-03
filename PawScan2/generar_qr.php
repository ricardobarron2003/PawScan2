<?php
include_once 'barcode-1.1.1/barcode.php';

$generador = new barcode_generator();

header('Content-Type: image/svg+xml');

$svg = $generador->render_svg("qr", "https://google.com", "");

echo $svg;
?>
