<?php

namespace Model;
use Model\ActiveRecord;

class Instructor extends ActiveRecord {
    
    public static $tabla = 'avpc_instructor';
    public static $idTabla = 'instructor_id';
    public static $columnasDB = 
    [
        'instructor_usuario_id',
        'instructor_grado',
        'instructor_arma',
        'instructor_anos_servicio',
        // 'instructor_fecha_registro',
        'instructor_situacion'
    ];
    
    public $instructor_id;
    public $instructor_usuario_id;
    public $instructor_grado;
    public $instructor_arma;
    public $instructor_anos_servicio;
    public $instructor_fecha_registro;
    public $instructor_situacion;
    
    public function __construct($instructor = [])
    {
        $this->instructor_id = $instructor['instructor_id'] ?? null;
        $this->instructor_usuario_id = $instructor['instructor_usuario_id'] ?? null;
        $this->instructor_grado = $instructor['instructor_grado'] ?? '';
        $this->instructor_arma = $instructor['instructor_arma'] ?? '';
        $this->instructor_anos_servicio = $instructor['instructor_anos_servicio'] ?? 0;
        $this->instructor_fecha_registro = $instructor['instructor_fecha_registro'] ?? '';
        $this->instructor_situacion = $instructor['instructor_situacion'] ?? 1;
    }
    
    public static function EliminarInstructor($id){
        $sql = "UPDATE avpc_instructor SET instructor_situacion = 0 WHERE instructor_id = $id";
        return self::SQL($sql);
    }
}