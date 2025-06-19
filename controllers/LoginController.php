<?php

namespace Controllers;

use Model\ActiveRecord;
use MVC\Router;
use Exception;
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675

class LoginController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        $router->render('login/index', [], 'layouts/layoutlogin');
    }

    public static function login() {
        getHeadersApi();
        
        try {
            $dpi = htmlspecialchars($_POST['usuario_dpi']);
            $contrasena = htmlspecialchars($_POST['usuario_contra']);

            $queryExisteUser = "SELECT usuario_id, usuario_nom1, usuario_ape1, usuario_contra FROM avpc_usuario WHERE usuario_dpi = '$dpi' AND usuario_situacion = 1";
<<<<<<< HEAD
=======
=======
use Controllers\RutasActividadesController;

class LoginController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('login/index', [], 'layout/layoutlogin');
    }

    public static function login()
    {
        getHeadersApi();

        try {
            $dpi = htmlspecialchars($_POST['usu_codigo']);
            $contrasena = htmlspecialchars($_POST['usu_password']);

            $queryExisteUser = "SELECT u.id_usuario, u.primer_nombre, u.contrasena, r.nombre_corto, r.nombre_rol 
                   FROM usuarios u 
                   LEFT JOIN roles r ON u.id_rol = r.id_rol 
                   WHERE u.dpi = '$dpi' AND u.situacion = 1";
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675

            $existeUsuario = ActiveRecord::fetchArray($queryExisteUser)[0];

            if ($existeUsuario) {
<<<<<<< HEAD
                $passDB = $existeUsuario['usuario_contra'];
=======
<<<<<<< HEAD
                $passDB = $existeUsuario['usuario_contra'];
=======
                $passDB = $existeUsuario['contrasena'];
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675

                if (password_verify($contrasena, $passDB)) {
                    session_start();

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
                    $nombreCompleto = $existeUsuario['usuario_nom1'] . ' ' . $existeUsuario['usuario_ape1'];
                    $usuarioId = $existeUsuario['usuario_id'];
                    
                    $_SESSION['user'] = $nombreCompleto;
                    $_SESSION['dpi'] = $dpi;
                    $_SESSION['usuario_id'] = $usuarioId;

<<<<<<< HEAD
=======
=======
                    $nombreUser = $existeUsuario['primer_nombre'];
                    $usuarioId = $existeUsuario['id_usuario'];

                    $_SESSION['user'] = $nombreUser;
                    $_SESSION['dpi'] = $dpi;
                    $_SESSION['usuario_id'] = $usuarioId;

                    // Configurar rol
                    if (!empty($existeUsuario['nombre_rol'])) {
                        $_SESSION['rol'] = $existeUsuario['nombre_rol'];
                    } else {
                        $_SESSION['rol'] = 'Usuario Básico';
                    }

                    // Registrar login exitoso
                    RutasActividadesController::registrarRutaActividad(
                        'LOGIN', 
                        'INICIAR_SESION', 
                        "Usuario $nombreUser inició sesión exitosamente",
                        '/base_login/login'
                    );

>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
                    echo json_encode([
                        'codigo' => 1,
                        'mensaje' => 'Usuario iniciado exitosamente',
                    ]);
                } else {
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
                    // Registrar intento fallido
                    if (!isset($_SESSION)) session_start();
                    $_SESSION['usuario_id'] = $existeUsuario['id_usuario'];
                    $_SESSION['user'] = $existeUsuario['primer_nombre'];
                    
                    RutasActividadesController::registrarRutaActividad(
                        'LOGIN', 
                        'INTENTO_FALLIDO', 
                        "Intento de login fallido - Contraseña incorrecta para DPI: $dpi",
                        '/base_login/login'
                    );
                    
                    // Limpiar sesión temporal
                    unset($_SESSION['usuario_id']);
                    unset($_SESSION['user']);

>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
                    echo json_encode([
                        'codigo' => 0,
                        'mensaje' => 'La contraseña que ingreso es incorrecta',
                    ]);
                }
            } else {
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
                // Registrar intento de usuario inexistente
                RutasActividadesController::registrarRutaActividad(
                    'LOGIN', 
                    'USUARIO_INEXISTENTE', 
                    "Intento de login con DPI inexistente: $dpi",
                    '/base_login/login'
                );

>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El usuario que intenta ingresar no existe',
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al intentar ingresar',
                'detalle' => $e->getMessage()
            ]);
        }
    }

    public static function renderInicio(Router $router)
    {
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
        session_start();
        
        if (!isset($_SESSION['user']) || !isset($_SESSION['usuario_id'])) {
            header("Location: /clemente_final_capacitaciones_ingSoft3/");
            exit;
        }
        
        $router->render('pages/index', []);
    }

    public static function logout(){
        session_start();
        
        $_SESSION = [];
        session_destroy();
        header("Location: /clemente_final_capacitaciones_ingSoft3/");
        exit;
    }

<<<<<<< HEAD
=======
=======
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: /base_login/');
            exit;
        }

        // Registrar acceso al inicio
        RutasActividadesController::registrarRutaActividad(
            'INICIO', 
            'ACCEDER', 
            'Usuario accedió a la página de inicio',
            '/base_login/inicio'
        );

        $router->render('pages/index', [], 'layout/layout');
    }

    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Registrar logout antes de cerrar sesión
        if (isset($_SESSION['user'])) {
            RutasActividadesController::registrarRutaActividad(
                'LOGIN', 
                'CERRAR_SESION', 
                'Usuario cerró sesión',
                '/base_login/logout'
            );
        }

        $_SESSION = [];
        $login = $_ENV['APP_NAME'];
        header("Location: /$login");
    }
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
}