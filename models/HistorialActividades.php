<?php

namespace Model;

use Model\ActiveRecord;

class HistorialActividades extends ActiveRecord {
    
    public static $tabla = 'avpc_historial_actividades';
    public static $idTabla = 'historial_id';
    public static $columnasDB = 
    [
        'historial_usuario_id',
        'historial_usuario_nombre',
        'historial_modulo',
        'historial_accion',
        'historial_descripcion',
        'historial_ip',
        'historial_ruta',
        'historial_situacion',
    ];
    
    public $historial_id;
    public $historial_usuario_id;
    public $historial_usuario_nombre;
    public $historial_modulo;
    public $historial_accion;
    public $historial_descripcion;
    public $historial_ip;
    public $historial_ruta;
    public $historial_situacion;
    public $historial_fecha_creacion;
    
    public function __construct($historial = [])
    {
        $this->historial_id = $historial['historial_id'] ?? null;
        $this->historial_usuario_id = $historial['historial_usuario_id'] ?? '';
        $this->historial_usuario_nombre = $historial['historial_usuario_nombre'] ?? '';
        $this->historial_modulo = $historial['historial_modulo'] ?? '';
        $this->historial_accion = $historial['historial_accion'] ?? '';
        $this->historial_descripcion = $historial['historial_descripcion'] ?? '';
        $this->historial_ip = $historial['historial_ip'] ?? '';
        $this->historial_ruta = $historial['historial_ruta'] ?? '';
        $this->historial_situacion = $historial['historial_situacion'] ?? 1;
        $this->historial_fecha_creacion = $historial['historial_fecha_creacion'] ?? '';
    }
}