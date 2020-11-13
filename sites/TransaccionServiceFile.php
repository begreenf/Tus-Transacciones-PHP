<?php

class TransaccionServiceFile implements IServiceBase
{
    private $utilities;
    public $filehandler;
    public $directory;
    public $filename;


    public function __construct($directory = "data")
    {
        $this->utilities = new Utilities();
        $this->directory = $directory;
        $this->filename = "transacciones";
        $this->filehandler = new JsonFileHandler($this->directory, $this->filename);
    }

    public function GetList()
    {
        $ListadoTransaccionesDecode = $this->filehandler->ReadFile();
        $ListadoTransacciones = array();

        if ($ListadoTransaccionesDecode == false) {

            $this->filehandler->SaveFile($ListadoTransacciones);
        } else {

            foreach ($ListadoTransaccionesDecode as $elementDecode) {
                $element = new Transaccion();
                $element->set($elementDecode);

                array_push($ListadoTransacciones, $element);
            }
        }
        return $ListadoTransacciones;
    }




    public function GetByCodigo($codigo)
    {
        $ListadoTransacciones = $this->GetList();
        $transaccion = $this->utilities->searchProperty($ListadoTransacciones, 'codigo', $codigo)[0];
        return $transaccion;
    }

    public function Add($entity)
    {
        $ListadoTransacciones = $this->GetList();
        $transaccionid = 1;

        if (!empty($ListadoTransacciones)) {
            $lastTransaccion = $this->utilities->getLastElement($ListadoTransacciones);
            $transaccionid = $lastTransaccion->codigo + 1;
        }
        $entity->codigo = $transaccionid;

        array_push($ListadoTransacciones, $entity);

        $this->filehandler->SaveFile($ListadoTransacciones);
    }

    public function Update($codigo, $entity)
    {
        $element = $this->GetByCodigo($codigo);
        $ListadoTransacciones = $this->GetList();

        $elementIndex = $this->utilities->getIndexElement($ListadoTransacciones, 'codigo', $codigo);

        $ListadoTransacciones[$elementIndex] = $entity;

        $this->filehandler->SaveFile($ListadoTransacciones);
    }

    public function Delete($codigo)
    {
        $ListadoTransacciones = $this->GetList();

        $elementIndex = $this->utilities->getIndexElement($ListadoTransacciones, 'codigo', $codigo);

        unset($ListadoTransacciones[$elementIndex]);

        $ListadoTransacciones = array_values($ListadoTransacciones);

        $this->filehandler->SaveFile($ListadoTransacciones);
    }
}
