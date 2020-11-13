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

if (isset($_GET['codigo'])) {



  $transaccionid = $_GET['codigo'];

  $element = $service->GetByCodigo($transaccionid);

  if (isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['monto']) && isset($_POST['descripcion'])) {

    $updateTransaccion = new Transaccion();

    $updateTransaccion->InitializeData($transaccionid, $_POST['fecha'], $_POST['hora'], $_POST['monto'], $_POST['descripcion']);

    $service->Update($transaccionid, $updateTransaccion);

    $logFile = fopen("data/log.txt", 'a') or die("Error creando archivo");
    fwrite($logFile, "\n" . date("d/m/Y H:i:s") . " Se edito transaccion ID " . $element->codigo) or die("Error escribiendo en el archivo");
    fclose($logFile);

    header("Location: transacciones.php");
    exit();
  };
} else {

  header("Location: transacciones.php");
  exit();
}





?>

<?php $layout->printHeader(true); ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edición de transaccion ID <?php echo $element->codigo ?></h1>
  </div>
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Editar transacción
        </div>
        <div class="card-body">
          <form enctype="multipart/form-data" action="editar.php?codigo=<?php echo $element->codigo ?>" method="POST">
            <div class="">
              <div class="form-group">
                <label for="codigo">ID de Transacción</label>
                <input type="numfmt_create" class="form-control" value="<?php echo $element->codigo ?>" placeholder="<?php echo $transaccionid; ?>" readonly>
              </div>

              <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" value="<?php echo $element->fecha ?>" placeholder="Fecha de la transacción" name="fecha" required>
              </div>
              <div class="form-group">
                <label for="hora">Hora</label>
                <input type="time" class="form-control" id="hora" value="<?php echo $element->hora ?>" placeholder="Hora de la transacción" name="hora" required>
              </div><br>
              <div class="form-group">
                <label for="monto">Monto</label>
                <input type="number" class="form-control" id="monto" value="<?php echo $element->monto ?>" placeholder="Monto de la transacción" name="monto" required>
              </div>

              <div class="form-group">
                <p>Descripción:</p>
                <textarea name="descripcion" class="form-control" rows="4" cols="70" wrap="off"><?php echo $element->descripcion; ?></textarea>
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