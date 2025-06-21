<?php

namespace Model;
use Model\ActiveRecord;

class Compania extends ActiveRecord {
    
    public static $tabla = 'avpc_compania';
    public static $idTabla = 'app_id';
    public static $columnasDB = 
    [
        'app_nombre_largo',
        'app_nombre_corto',
        // 'app_fecha_creacion',
        'app_situacion'
    ];
    
    public $app_id;
    public $app_nombre_largo;
    public $app_nombre_corto;
    public $app_fecha_creacion;
    public $app_situacion;
    
    public function __construct($compania = [])
    {
        $this->app_id = $compania['app_id'] ?? null;
        $this->app_nombre_largo = $compania['app_nombre_largo'] ?? '';
        $this->app_nombre_corto = $compania['app_nombre_corto'] ?? '';
        $this->app_fecha_creacion = $compania['app_fecha_creacion'] ?? '';
        $this->app_situacion = $compania['app_situacion'] ?? 1;
    }
    
    public static function EliminarCompania($id){
        $sql = "UPDATE avpc_compania SET app_situacion = 0 WHERE app_id = $id";
        return self::SQL($sql);
    }
}