<?php

namespace Model;
use Model\ActiveRecord;

class AsignacionPermisos extends ActiveRecord {
    
    public static $tabla = 'avpc_asig_permisos';
    public static $idTabla = 'asignacion_id';
    public static $columnasDB = 
    [
        'asignacion_usuario_id',
        'asignacion_app_id',
        'asignacion_permiso_id',
        'asignacion_usuario_asigno',
        'asignacion_motivo',
        'asignacion_situacion'
    ];
    
    public $asignacion_id;
    public $asignacion_usuario_id;
    public $asignacion_app_id;
    public $asignacion_permiso_id;
    public $asignacion_fecha;
    public $asignacion_quitar_fechaPermiso;
    public $asignacion_usuario_asigno;
    public $asignacion_motivo;
    public $asignacion_situacion;
    
    public function __construct($asignacion = [])
    {
        $this->asignacion_id = $asignacion['asignacion_id'] ?? null;
        $this->asignacion_usuario_id = $asignacion['asignacion_usuario_id'] ?? null;
        $this->asignacion_app_id = $asignacion['asignacion_app_id'] ?? null;
        $this->asignacion_permiso_id = $asignacion['asignacion_permiso_id'] ?? null;
        $this->asignacion_fecha = $asignacion['asignacion_fecha'] ?? '';
        $this->asignacion_quitar_fechaPermiso = $asignacion['asignacion_quitar_fechaPermiso'] ?? '';
        $this->asignacion_usuario_asigno = $asignacion['asignacion_usuario_asigno'] ?? null;
        $this->asignacion_motivo = $asignacion['asignacion_motivo'] ?? '';
        $this->asignacion_situacion = $asignacion['asignacion_situacion'] ?? 1;
    }
    
    public static function EliminarAsignacion($id){
        $sql = "UPDATE avpc_asig_permisos SET asignacion_situacion = 0 WHERE asignacion_id = $id";
        return self::SQL($sql);
    }
}