<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

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

// Obtener el ID de la cita que se desea eliminar
$id = $_GET['id']; // Suponemos que el ID es pasado como parámetro en la URL

// Hacer una búsqueda en la base de datos para verificar que el documento existe
$filter = ['_id' => new MongoDB\BSON\ObjectId($id)];  // Convertir el ID a un ObjectId de MongoDB

try {
    // Intentar eliminar el documento
    $deleteResult = $collection->deleteOne($filter); // Eliminar el documento de la colección

    if ($deleteResult->getDeletedCount() > 0) {
        // Si se eliminó correctamente
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Cita eliminada',
                    text: 'La cita fue eliminada correctamente.',
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    window.location.href = '../index.php';
                });
            </script>
        </body>
        </html>";
    } else {
        // Si no se eliminó ningún documento (posiblemente no existía)
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo eliminar la cita. No se encontró.',
                    confirmButtonText: 'Volver'
                }).then(() => {
                    window.location.href = '../index.php';
                });
            </script>
        </body>
        </html>";
    }
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al eliminar la cita: " . $e->getMessage() . "',
                confirmButtonText: 'Volver'
            }).then(() => {
                window.location.href = '../index.php';
            });
        </script>
    </body>
    </html>";
}
?>
