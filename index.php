<?php
include "config/conection.php";

require 'vendor/autoload.php'; 

$cliente = new MongoDB\Client("mongodb://localhost:27017");
$coleccion = $cliente->Clinica->Citas;

$resultado = $coleccion->find();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6 border border-1 rounded-2 shadow bg-light sm p-3 my-3">
                <h2 class="text-center">Registra un cita</h2>
                <form action="php/guardar.php" method="post">
                    <div class="mb-2">
                        <label for="paciente">Paciente</label>
                        <input class="form-control" type="text" name="paciente" id="paciente" required>
                    </div>
                    <div class="mb-2">
                        <label for="fecha">Fecha de la cita</label>
                        <input class="form-control" type="date" name="fecha" id="fecha" required>
                    </div>
                    <div class="mb-2">
                        <label for="hora">Hora de la cita</label>
                        <input class="form-control" type="time" name="hora" id="hora" required>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Motivo</span>
                        <textarea class="form-control" aria-label="With textarea" name="motivo" 
                        id="motivo"></textarea>
                    </div>
                    <button class="btn btn-primary w-100">Guardar</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>Paciente</td>
                        <th>Fecha de la Cita</th>
                        <th>Hora de la Cita</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($resultado as $row) {
                ?>
                  <tr>
                      <td><?= $row['paciente'] ?></td>
                      <td><?= $row['fecha'] ?></td>
                      <td><?= $row['hora'] ?></td>
                      <td><?= $row['motivo'] ?></td>
                      <td>
                          <a class="btn btn-warning" href="php/editar.php?id=<?= $row['_id']?>">Editar</a>
                          <a class="btn btn-danger" href="#" id="eliminar-btn" onclick="confirmarEliminacion('<?= $row['_id'] ?>')">Eliminar</a>
                      </td>
                  </tr> 
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmarEliminacion(id) {
          // Verifica que el ID se pasa correctamente
          console.log("ID pasado:", id);  

          // Mostrar la alerta de confirmación
          Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
            if (result.isConfirmed) {
              console.log("Redirigiendo a eliminar.php?id=" + id);
              window.location.href = 'php/eliminar.php?id=' + id; 
            } else {
              Swal.fire('Cancelado', 'La acción ha sido cancelada.', 'info');
            }
          });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
