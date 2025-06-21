<?php

namespace Model;
use Model\ActiveRecord;

class AreaEntrenamiento extends ActiveRecord {
    
    public static $tabla = 'avpc_area_entrenamiento';
    public static $idTabla = 'area_id';
    public static $columnasDB = 
    [
        'area_nombre',
        'area_descripcion',
        'area_direccion',
        'area_situacion'
    ];
    
    public $area_id;
    public $area_nombre;
    public $area_descripcion;
    public $area_direccion;
    public $area_situacion;
    
    public function __construct($area = [])
    {
        $this->area_id = $area['area_id'] ?? null;
        $this->area_nombre = $area['area_nombre'] ?? '';
        $this->area_descripcion = $area['area_descripcion'] ?? '';
        $this->area_direccion = $area['area_direccion'] ?? '';
        $this->area_situacion = $area['area_situacion'] ?? 1;
    }
    
    public static function EliminarAreaEntrenamiento($id){
        $sql = "UPDATE avpc_area_entrenamiento SET area_situacion = 0 WHERE area_id = $id";
        return self::SQL($sql);
    }
}