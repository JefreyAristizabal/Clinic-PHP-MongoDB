<?php
include "../config/conection.php";

try {
    $client = new MongoDB\Client("mongodb://localhost:27017"); 
    $collection = $client->Clinica->Citas; 
} catch (Exception $e) {
    echo "Error de conexión a MongoDB: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $paciente = $_POST['paciente'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $motivo = $_POST['motivo'];

    $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];

    $update = [
        '$set' => [
            'paciente' => $paciente,
            'fecha' => $fecha,
            'hora' => $hora,
            'motivo' => $motivo
        ]
    ];

    $updateResult = $collection->updateOne($filter, $update);

    if ($updateResult->getModifiedCount() > 0) {
        echo "<script>
                alert('Edición Exitosa');
                window.location.href = '../index.php';
            </script>";
    } else {
        echo "<script>
                alert('Fallo al Editar');
                window.location.href = '../index.php';
            </script>";
    }
}
?>
