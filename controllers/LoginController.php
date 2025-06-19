<?php

namespace Controllers;

use Model\ActiveRecord;
use MVC\Router;
use Exception;
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

            $queryExisteUser = "SELECT usuario_id, usuario_nom1, usuario_contra
                   FROM avpc_usuario
                   WHERE usuario_dpi = '$dpi' AND usuario_situacion = 1";

            $existeUsuario = ActiveRecord::fetchArray($queryExisteUser)[0];

            if ($existeUsuario) {
                $passDB = $existeUsuario['usuario_contra'];

                if (password_verify($contrasena, $passDB)) {
                    session_start();

                    $nombreUser = $existeUsuario['usuario_nom1'];
                    $usuarioId = $existeUsuario['usuario_id'];

                    $_SESSION['user'] = $nombreUser;
                    $_SESSION['dpi'] = $dpi;
                    $_SESSION['usuario_id'] = $usuarioId;

                    // Asignar rol básico por defecto (puedes modificar esto según tu lógica de roles)
                    $_SESSION['rol'] = 'Usuario Básico';

                    RutasActividadesController::registrarRutaActividad(
                        'LOGIN', 
                        'INICIAR_SESION', 
                        "Usuario $nombreUser inició sesión exitosamente",
                        '/base_login/login'
                    );

                    echo json_encode([
                        'codigo' => 1,
                        'mensaje' => 'Usuario iniciado exitosamente',
                    ]);
                } else {
                    if (!isset($_SESSION)) session_start();
                    $_SESSION['usuario_id'] = $existeUsuario['usuario_id'];
                    $_SESSION['user'] = $existeUsuario['usuario_nom1'];
                    
                    RutasActividadesController::registrarRutaActividad(
                        'LOGIN', 
                        'INTENTO_FALLIDO', 
                        "Intento de login fallido - Contraseña incorrecta para DPI: $dpi",
                        '/base_login/login'
                    );
                    
                    unset($_SESSION['usuario_id']);
                    unset($_SESSION['user']);

                    echo json_encode([
                        'codigo' => 0,
                        'mensaje' => 'La contraseña que ingreso es incorrecta',
                    ]);
                }
            } else {
                RutasActividadesController::registrarRutaActividad(
                    'LOGIN', 
                    'USUARIO_INEXISTENTE', 
                    "Intento de login con DPI inexistente: $dpi",
                    '/base_login/login'
                );

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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user']) || !isset($_SESSION['usuario_id'])) {
            header("Location: /clemente_final_capacitaciones_ingSoft3/");
            exit;
        }

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

        if (isset($_SESSION['user'])) {
            RutasActividadesController::registrarRutaActividad(
                'LOGIN', 
                'CERRAR_SESION', 
                'Usuario cerró sesión',
                '/base_login/logout'
            );
        }

        $_SESSION = [];
        session_destroy();
        $login = $_ENV['APP_NAME'];
        header("Location: /$login");
        exit;
    }
}