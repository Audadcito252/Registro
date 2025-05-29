<?php
// Simplifica el enrutamiento para que funcione inicialmente
require_once __DIR__ . '/Controlador/RegistroController.php';

$controller = new RegistroController();
$controller->mostrarFormulario();
