<?php
<<<<<<< HEAD

namespace Model;

=======
<<<<<<< HEAD

namespace Model;

=======
namespace Model;
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
use Model\ActiveRecord;

class Usuarios extends ActiveRecord {
    
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
    public static $tabla = 'avpc_usuario';
    public static $idTabla = 'usuario_id';
    public static $columnasDB = 
    [
        'usuario_nom1',
        'usuario_nom2',
        'usuario_ape1',
        'usuario_ape2',
        'usuario_tel',
        'usuario_direc',
        'usuario_dpi',
        'usuario_correo',
        'usuario_contra',
        'usuario_token',
        'usuario_fecha_creacion',
        'usuario_fecha_contra',
        'usuario_fotografia',
        'usuario_situacion'
    ];
    
    public $usuario_id;
    public $usuario_nom1;
    public $usuario_nom2;
    public $usuario_ape1;
    public $usuario_ape2;
    public $usuario_tel;
    public $usuario_direc;
    public $usuario_dpi;
    public $usuario_correo;
    public $usuario_contra;
    public $usuario_token;
    public $usuario_fecha_creacion;
    public $usuario_fecha_contra;
    public $usuario_fotografia;
    public $usuario_situacion;
    
    public function __construct($usuario = [])
    {
        $this->usuario_id = $usuario['usuario_id'] ?? null;
        $this->usuario_nom1 = $usuario['usuario_nom1'] ?? '';
        $this->usuario_nom2 = $usuario['usuario_nom2'] ?? '';
        $this->usuario_ape1 = $usuario['usuario_ape1'] ?? '';
        $this->usuario_ape2 = $usuario['usuario_ape2'] ?? '';
        $this->usuario_tel = $usuario['usuario_tel'] ?? 0;
        $this->usuario_direc = $usuario['usuario_direc'] ?? '';
        $this->usuario_dpi = $usuario['usuario_dpi'] ?? '';
        $this->usuario_correo = $usuario['usuario_correo'] ?? '';
        $this->usuario_contra = $usuario['usuario_contra'] ?? '';
        $this->usuario_token = $usuario['usuario_token'] ?? '';
        $this->usuario_fecha_creacion = $usuario['usuario_fecha_creacion'] ?? '';
        $this->usuario_fecha_contra = $usuario['usuario_fecha_contra'] ?? '';
        $this->usuario_fotografia = $usuario['usuario_fotografia'] ?? null;
        $this->usuario_situacion = $usuario['usuario_situacion'] ?? 1;
    }

    public static function EliminarUsuarios($id){
        $sql = "UPDATE avpc_usuario SET usuario_situacion = 0 WHERE usuario_id = $id";
        return self::SQL($sql);
    }

<<<<<<< HEAD
=======
=======
    public static $tabla = 'usuarios';
    public static $idTabla = 'id_usuario';
    public static $columnasDB = 
    [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'telefono',
        'direccion',
        'dpi',
        'correo',
        'contrasena',
        'token',
        // 'fecha_creacion',
        // 'fecha_contrasena',
        'fotografia',
        'id_rol',  
        'situacion'
    ];
    
    public $id_usuario;
    public $primer_nombre;
    public $segundo_nombre;
    public $primer_apellido;
    public $segundo_apellido;
    public $telefono;
    public $direccion;
    public $dpi;
    public $correo;
    public $contrasena;
    public $token;
    public $fecha_creacion;
    public $fecha_contrasena;
    public $fotografia;
    public $id_rol;  
    public $situacion;
    
    public function __construct($usuario = [])
    {
        $this->id_usuario = $usuario['id_usuario'] ?? null;
        $this->primer_nombre = $usuario['primer_nombre'] ?? '';
        $this->segundo_nombre = $usuario['segundo_nombre'] ?? '';
        $this->primer_apellido = $usuario['primer_apellido'] ?? '';
        $this->segundo_apellido = $usuario['segundo_apellido'] ?? '';
        $this->telefono = $usuario['telefono'] ?? '';
        $this->direccion = $usuario['direccion'] ?? '';
        $this->dpi = $usuario['dpi'] ?? '';
        $this->correo = $usuario['correo'] ?? '';
        $this->contrasena = $usuario['contrasena'] ?? '';
        $this->token = $usuario['token'] ?? '';
        $this->fecha_creacion = $usuario['fecha_creacion'] ?? '';
        $this->fecha_contrasena = $usuario['fecha_contrasena'] ?? '';
        $this->fotografia = $usuario['fotografia'] ?? '';
        $this->id_rol = $usuario['id_rol'] ?? null;  
        $this->situacion = $usuario['situacion'] ?? 1;
    }
    
    public static function EliminarUsuarios($id){
    $sql = "UPDATE usuarios SET situacion = 0 WHERE id_usuario = $id";
    return self::SQL($sql);
}

    //Obtener usuarios con información de rol
    public static function obtenerUsuariosConRol(){
        $sql = "SELECT u.*, r.nombre_rol, r.nombre_corto as rol_corto 
                FROM usuarios u 
                LEFT JOIN roles r ON u.id_rol = r.id_rol 
                WHERE u.situacion = 1 
                ORDER BY u.fecha_creacion DESC";
        return self::fetchArray($sql);
    }

    //Validar credenciales de login
    public static function validarCredenciales($correo, $contrasena){
        $sql = "SELECT u.*, r.nombre_rol, r.nombre_corto as rol_corto 
                FROM usuarios u 
                LEFT JOIN roles r ON u.id_rol = r.id_rol 
                WHERE u.correo = '$correo' AND u.situacion = 1";
        $usuario = self::fetchFirst($sql);
        
        if($usuario && password_verify($contrasena, $usuario['contrasena'])){
            return $usuario;
        }
        return false;
    }
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
}