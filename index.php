<?php
include('./includes/config.inc.php');
session_start();

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
if ($scriptPath !== '/' && strpos($requestPath, $scriptPath) === 0) {
    $requestPath = substr($requestPath, strlen($scriptPath));
}
$requestPath = trim($requestPath, '/');
if ($requestPath === 'index.php') {
    $requestPath = '';
}
$oldal = ($requestPath === '') ? '/' : $requestPath;

if ($oldal !== '/') {
    if (isset($oldalak[$oldal]) && file_exists("./templates/pages/{$oldalak[$oldal]['fajl']}.tpl.php")) {
        $keres = $oldalak[$oldal];
    } else {
        $keres = $hiba_oldal;
        header("HTTP/1.0 404 Not Found");
    }
} else {
    $keres = $oldalak['/'];
}

include('./templates/index.tpl.php');
?>