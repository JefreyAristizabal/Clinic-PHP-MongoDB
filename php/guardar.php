<?php
include "../config/conection.php";

// Crear la conexión con MongoDB usando el cliente
try {
    $client = new MongoDB\Client("mongodb://localhost:27017"); // Cambia la URI si es necesario
    $collection = $client->Clinica->Citas;  // Cambia "adminaloja" por tu base de datos y "Citas" por tu colección
} catch (Exception $e) {
    echo "Error de conexión a MongoDB: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $Paciente = $_POST['paciente'];
    $Fecha = $_POST['fecha'];
    $Hora = $_POST['hora'];
    $Motivo = $_POST['motivo'];

    // Crear el documento que será insertado
    $document = [
        'paciente' => $Paciente,
        'fecha' => $Fecha,
        'hora' => $Hora,
        'motivo' => $Motivo
    ];

    try {
        // Insertar el documento en la colección
        $insertResult = $collection->insertOne($document);

        if ($insertResult->getInsertedCount() > 0) {
            echo "<script>
                    alert('Registro Exitoso');
                    window.location.href = '../index.php'
                </script>";
        } else {
            echo "<script>
                    alert('Fallo al Insertar');
                    window.location.href = '../index.php'
                </script>";
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        echo "<script>
                alert('Error al insertar: " . $e->getMessage() . "');
                window.location.href = '../index.php'
            </script>";
    }
}
?>
