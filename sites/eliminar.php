<?php

require_once '../helpers/utilities.php';
require_once 'transaccion.php';
require_once '../service/iServiceBase.php';
require_once '../helpers/FileHandler/iFileHandler.php';
require_once '../helpers/FileHandler/JsonFileHandler.php';
require_once 'TransaccionServiceFile.php';
require_once '../helpers/FileHandler/SerializationFileHandler.php';


$service = new TransaccionServiceFile();

$isContainCodigo = isset($_GET['codigo']);

if ($isContainCodigo) {

    $transaccionid = $_GET['codigo'];

    $service->Delete($transaccionid);

    $logFile = fopen("data/log.txt", 'a') or die("Error creando archivo");
    fwrite($logFile, "\n" . date("d/m/Y H:i:s") . " Se elimino transaccion ID " . $transaccionid) or die("Error escribiendo en el archivo");
    fclose($logFile);
}

header('Location: transacciones.php');
exit();
