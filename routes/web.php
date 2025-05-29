<?php
require_once __DIR__ . '/../Controlador/RegistroController.php';
$controller = new RegistroController();
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
$uriParts = explode('/', $uri);
$last = end($uriParts);
if ($last === 'registro' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->mostrarFormulario();
} elseif ($last === 'registro' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->procesarRegistro();
} else {
    echo '<h2>404 No encontrado</h2>';
}
