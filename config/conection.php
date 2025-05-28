<?php
require_once __DIR__ . '/../vendor/autoload.php'; // <- Ruta corregida

use MongoDB\Client;

try {
    $mongoClient = new Client("mongodb://localhost:27017");
    $db = $mongoClient->Clinica;
} catch (Exception $e) {
    die("Error de conexión a MongoDB: " . $e->getMessage());
}

?>