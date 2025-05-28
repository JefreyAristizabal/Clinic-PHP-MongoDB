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

// Obtener el ID de la cita que se desea editar
$id = $_GET['id']; // Suponemos que el ID es pasado como parámetro en la URL

// Buscar el documento por su ID
$filter = ['_id' => new MongoDB\BSON\ObjectId($id)];  // Convertir el ID a un ObjectId de MongoDB
$cita = $collection->findOne($filter);

if (!$cita) {
    echo "Cita no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Cita</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 border border-1 rounded-2 shadow bg-light sm p-3 my-3">
            <h2 class="text-center">Editar cita</h2>
            <form action="actualizar.php" method="post">
                <input type="hidden" name="id" id="id" value="<?= $cita['_id'] ?>">
                <div class="mb-2">
                    <label for="paciente">Paciente</label>
                    <input class="form-control" type="text" name="paciente" id="paciente" value="<?= $cita['paciente'] ?>" required>
                </div>
                <div class="mb-2">
                    <label for="fecha">Fecha de la cita</label>
                    <input class="form-control" type="date" name="fecha" id="fecha" value="<?= $cita['fecha'] ?>" required>
                </div>
                <div class="mb-2">
                    <label for="hora">Hora de la cita</label>
                    <input class="form-control" type="time" name="hora" id="hora" value="<?= $cita['hora'] ?>" required>
                </div>
                <div class="input-group mb-2">
                    <span class="input-group-text">Motivo</span>
                    <textarea class="form-control" aria-label="With textarea" name="motivo" id="motivo"><?= $cita['motivo'] ?></textarea>
                </div>
                <button class="btn btn-primary w-100">Actualizar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
