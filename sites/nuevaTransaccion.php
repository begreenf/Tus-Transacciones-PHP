<?php
require_once '../layout/layout.php';
require_once '../helpers/utilities.php';
require_once 'transaccion.php';
require_once '../service/iServiceBase.php';
require_once '../helpers/FileHandler/iFileHandler.php';
require_once '../helpers/FileHandler/JsonFileHandler.php';
require_once 'TransaccionServiceFile.php';
require_once '../helpers/FileHandler/SerializationFileHandler.php';


$layout = new Layout(true);
$service = new TransaccionServiceFile();
$utilities = new Utilities();


global $transaccionid;

if (isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['monto']) && isset($_POST['descripcion'])) {

  $newTransaccion = new Transaccion();

  $newTransaccion->InitializeData(0, $_POST['fecha'], $_POST['hora'], $_POST['monto'], $_POST['descripcion']);

  $service->Add($newTransaccion);

  $logFile = fopen("data/log.txt", 'a') or die("Error creando archivo");
  fwrite($logFile, "\n" . date("d/m/Y H:i:s") . " Se creo nueva transaccion") or die("Error escribiendo en el archivo");
  fclose($logFile);

  header("Location: transacciones.php");
  exit();
};

?>

<?php $layout->printHeader(true); ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Nueva transacción</h1>
  </div>

  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Crear nueva transacción
        </div>
        <div class="card-body">
          <form class="was-validated" enctype="multipart/form-data" action="nuevaTransaccion.php" method="POST">
            <div class="">
              <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" placeholder="Fecha de la transaccion" name="fecha" required>
              </div>
              <div class="form-group">
                <label for="hora">Hora</label>
                <input type="time" class="form-control" id="hora" placeholder="Hora de la transaccion" name="hora" required>
              </div><br>
              <div class="form-group">
                <label for="monto">Monto</label>
                <input type="number" class="form-control" id="monto" placeholder="Monto de la transaccion" name="monto" required>
              </div>
              <div class="form-group">
                <p>Descripción:</p>
                <textarea class="form-control" name="descripcion" rows="4" cols="70" wrap="off"></textarea>
              </div>

            </div>

            <button type="submit" class="btn btn-primary float-right">Guardar</button>&nbsp;&nbsp;
            <a href="transacciones.php" class="btn btn-secondary float-right" role="button" aria-pressed="true">Volver atras</a>


            <?php
            
            ?>


          </form>
        </div>
      </div>
    </div>
    <div class="col-md-3"></div>
  </div>
  </div>
</main>

<?php $layout->printFooter(true); ?>