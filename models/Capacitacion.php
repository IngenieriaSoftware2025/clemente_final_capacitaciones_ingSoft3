<?php

namespace Model;
use Model\ActiveRecord;

class Capacitacion extends ActiveRecord {
    
    public static $tabla = 'avpc_capacitacion';
    public static $idTabla = 'capacitacion_id';
    public static $columnasDB = 
    [
        'capacitacion_nombre',
        'capacitacion_descripcion',
        'capacitacion_duracion_horas',
        'capacitacion_objetivos',
        // 'capacitacion_fecha_creacion',
        'capacitacion_usuario_creo',
        'capacitacion_situacion'
    ];
    
    public $capacitacion_id;
    public $capacitacion_nombre;
    public $capacitacion_descripcion;
    public $capacitacion_duracion_horas;
    public $capacitacion_objetivos;
    public $capacitacion_fecha_creacion;
    public $capacitacion_usuario_creo;
    public $capacitacion_situacion;
    
    public function __construct($capacitacion = [])
    {
        $this->capacitacion_id = $capacitacion['capacitacion_id'] ?? null;
        $this->capacitacion_nombre = $capacitacion['capacitacion_nombre'] ?? '';
        $this->capacitacion_descripcion = $capacitacion['capacitacion_descripcion'] ?? '';
        $this->capacitacion_duracion_horas = $capacitacion['capacitacion_duracion_horas'] ?? 0;
        $this->capacitacion_objetivos = $capacitacion['capacitacion_objetivos'] ?? '';
        $this->capacitacion_fecha_creacion = $capacitacion['capacitacion_fecha_creacion'] ?? '';
        $this->capacitacion_usuario_creo = $capacitacion['capacitacion_usuario_creo'] ?? null;
        $this->capacitacion_situacion = $capacitacion['capacitacion_situacion'] ?? 1;
    }
    
    public static function EliminarCapacitacion($id){
        $sql = "UPDATE avpc_capacitacion SET capacitacion_situacion = 0 WHERE capacitacion_id = $id";
        return self::SQL($sql);
    }
}