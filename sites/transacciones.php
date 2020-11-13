<?php
require_once '../layout/layout.php';
require_once '../helpers/utilities.php';
require_once 'transaccion.php';
require_once '../service/iServiceBase.php';
require_once '../helpers/FileHandler/iFileHandler.php';
require_once '../helpers/FileHandler/JsonFileHandler.php';
require_once 'TransaccionServiceFile.php';
require_once '../helpers/FileHandler/SerializationFileHandler.php';
require_once '../helpers/FileHandler/CsvFileHandler.php';


$layout = new Layout(true);
$service = new TransaccionServiceFile();
$utilities = new Utilities();

$listadoTransacciones = $service->GetList();

$json_filename = 'data/transacciones.json';
$csv_filename = 'data.csv';
// jsonToCSV($json_filename, $csv_filename);
$utilities->jsonToCSV($json_filename, $csv_filename);

?>

<?php $layout->printHeader(true); ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Transacciones</h1>
  </div>

  <h2></h2>
  <div class="table-responsive">
  <?php echo '<a style="float: right;" href="' . $csv_filename . '" target="_blank">Descarga todas las transacciones</a>' ?>
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>ID</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Monto</th>
          <th>Descripcion</th>
        </tr>
      </thead>
      <tbody>

        <?php if (empty($listadoTransacciones)) : ?>

          <h3>No hay transacciones registradas, registra aqui: <a href="nuevaTransaccion.php" class="btn btn-primary">nueva transacción</a> </h3>

        <?php else : ?>

          <?php foreach ($listadoTransacciones as $transac) : ?>

            <tr style="line-height: 300%;">
              <td><?php echo $transac->codigo ?></td>
              <td><?php echo $transac->fecha ?></td>
              <td><?php echo $transac->hora ?></td>
              <td><?php echo $transac->monto ?></td>
              <td><?php echo $transac->descripcion ?></td>
              <td><a href="editar.php?codigo=<?php echo $transac->codigo ?>" class="btn btn-outline-primary link">Editar</a></td>
              <?php echo "<td><a href='eliminar.php?codigo=$transac->codigo' onclick=\"return confirm('¿Está seguro que desea eliminar?');\" class='btn btn-outline-danger link'>Eliminar</a></td>"; ?>
            </tr>

          <?php endforeach; ?>

        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

<?php $layout->printFooter(true); ?>