<?php

class Transaccion
{

    public $codigo;
    public $fecha;
    public $hora;
    public $monto;
    public $descripcion;

    private $utilities;

    public function __construct()
    {
        $this->utilities = new Utilities();
    }

    public function InitializeData($codigo, $fecha, $hora, $monto, $descripcion)
    {
        $this->codigo = $codigo ;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->monto = $monto;
        $this->descripcion = $descripcion;
        
    }

    public function set($data){
        foreach($data as $key => $value) $this->{$key} = $value;
    }
}
