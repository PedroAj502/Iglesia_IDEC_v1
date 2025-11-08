<?php
$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'formulario_login';

$controllerClass = ucfirst($controller) . 'Controller';
$controllerFile = "../app/controllers/$controllerClass.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $ctrl = new $controllerClass();
    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        echo "Ubicación no encontrada.";
    }
} else {
    echo "Controlador no encontrado.";
}