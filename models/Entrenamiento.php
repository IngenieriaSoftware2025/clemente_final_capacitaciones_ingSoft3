<?php

namespace Model;
use Model\ActiveRecord;

class Entrenamiento extends ActiveRecord {
    
    public static $tabla = 'avpc_entrenamiento';
    public static $idTabla = 'entrenamiento_id';
    public static $columnasDB = 
    [
        'entrenamiento_capacitacion_id',
        'entrenamiento_compania_id',
        'entrenamiento_instructor_id',
        'entrenamiento_area_id',
        'entrenamiento_fecha_inicio',
        'entrenamiento_fecha_fin',
        'entrenamiento_estado',
        'entrenamiento_observaciones',
        'entrenamiento_usuario_creo',
        'entrenamiento_situacion'
    ];
    
    public $entrenamiento_id;
    public $entrenamiento_capacitacion_id;
    public $entrenamiento_compania_id;
    public $entrenamiento_instructor_id;
    public $entrenamiento_area_id;
    public $entrenamiento_fecha_inicio;
    public $entrenamiento_fecha_fin;
    public $entrenamiento_estado;
    public $entrenamiento_observaciones;
    public $entrenamiento_usuario_creo;
    public $entrenamiento_situacion;
    
    public function __construct($entrenamiento = [])
    {
        $this->entrenamiento_id = $entrenamiento['entrenamiento_id'] ?? null;
        $this->entrenamiento_capacitacion_id = $entrenamiento['entrenamiento_capacitacion_id'] ?? 0;
        $this->entrenamiento_compania_id = $entrenamiento['entrenamiento_compania_id'] ?? 0;
        $this->entrenamiento_instructor_id = $entrenamiento['entrenamiento_instructor_id'] ?? 0;
        $this->entrenamiento_area_id = $entrenamiento['entrenamiento_area_id'] ?? 0;
        $this->entrenamiento_fecha_inicio = $entrenamiento['entrenamiento_fecha_inicio'] ?? '';
        $this->entrenamiento_fecha_fin = $entrenamiento['entrenamiento_fecha_fin'] ?? '';
        $this->entrenamiento_estado = $entrenamiento['entrenamiento_estado'] ?? 'PROGRAMADO';
        $this->entrenamiento_observaciones = $entrenamiento['entrenamiento_observaciones'] ?? '';
        $this->entrenamiento_usuario_creo = $entrenamiento['entrenamiento_usuario_creo'] ?? 0;
        $this->entrenamiento_situacion = $entrenamiento['entrenamiento_situacion'] ?? 1;
    }
    
    public static function EliminarEntrenamiento($id){
        $sql = "UPDATE avpc_entrenamiento SET entrenamiento_situacion = 0 WHERE entrenamiento_id = $id";
        return self::SQL($sql);
    }
}