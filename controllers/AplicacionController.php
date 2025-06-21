<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Aplicacion;

class AplicacionController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('aplicacion/index', []);
    }

    public static function guardarAPI()
    {
        header('Content-Type: application/json');

        try {
            // NOMBRE LARGO OBLIGATORIO
            $_POST['app_nombre_largo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['app_nombre_largo']))));
            $cantidad_nombre_largo = strlen($_POST['app_nombre_largo']);
            if ($cantidad_nombre_largo < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre largo debe tener más de 4 caracteres'
                ]);
                exit;
            }

            // NOMBRE CORTO OBLIGATORIO
            $_POST['app_nombre_corto'] = ucwords(strtolower(trim(htmlspecialchars($_POST['app_nombre_corto']))));
            $cantidad_nombre_corto = strlen($_POST['app_nombre_corto']);
            if ($cantidad_nombre_corto < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre corto debe tener más de 1 caracter'
                ]);
                exit;
            }

            // VERIFICAR NOMBRE LARGO EXISTENTE
            $verificarNombreLargoExistente = self::fetchArray("SELECT app_id FROM avpc_aplicacion WHERE app_nombre_largo = '{$_POST['app_nombre_largo']}' AND app_situacion = 1");
            if (count($verificarNombreLargoExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe una aplicación registrada con este nombre largo'
                ]);
                exit;
            }

            // VERIFICAR NOMBRE CORTO EXISTENTE
            $verificarNombreCortoExistente = self::fetchArray("SELECT app_id FROM avpc_aplicacion WHERE app_nombre_corto = '{$_POST['app_nombre_corto']}' AND app_situacion = 1");
            if (count($verificarNombreCortoExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe una aplicación registrada con este nombre corto'
                ]);
                exit;
            }

            // ESTABLECER FECHA DE CREACIÓN AUTOMÁTICA
            $_POST['app_fecha_creacion'] = '';

            $aplicacion = new Aplicacion($_POST);
            $resultado = $aplicacion->crear();

            if ($resultado['resultado'] == 1) {
                http_response_code(200);
                echo json_encode([
                    'codigo' => 1,
                    'mensaje' => 'Aplicación registrada correctamente',
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error al registrar la aplicación',
                    'detalle' => 'Error en la base de datos'
                ]);
            }
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error interno del servidor',
                'detalle' => $e->getMessage()
            ]);
        }
        exit;
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["app_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "app_fecha_creacion >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "app_fecha_creacion <= '{$fecha_fin}'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT * FROM avpc_aplicacion WHERE $where ORDER BY app_fecha_creacion DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Aplicaciones obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las aplicaciones',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        header('Content-Type: application/json');

        try {
            $id = $_POST['app_id'];

            // NOMBRE LARGO OBLIGATORIO
            $_POST['app_nombre_largo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['app_nombre_largo']))));
            $cantidad_nombre_largo = strlen($_POST['app_nombre_largo']);
            if ($cantidad_nombre_largo < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre largo debe tener más de 4 caracteres'
                ]);
                exit;
            }

            // NOMBRE CORTO OBLIGATORIO
            $_POST['app_nombre_corto'] = ucwords(strtolower(trim(htmlspecialchars($_POST['app_nombre_corto']))));
            $cantidad_nombre_corto = strlen($_POST['app_nombre_corto']);
            if ($cantidad_nombre_corto < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre corto debe tener más de 1 caracter'
                ]);
                exit;
            }

            // VERIFICAR NOMBRE LARGO EXISTENTE 
            $verificarNombreLargoExistente = self::fetchArray("SELECT app_id FROM avpc_aplicacion WHERE app_nombre_largo = '{$_POST['app_nombre_largo']}' AND app_situacion = 1 AND app_id != {$id}");
            if (count($verificarNombreLargoExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otra aplicación registrada con este nombre largo'
                ]);
                exit;
            }

            // VERIFICAR NOMBRE CORTO EXISTENTE 
            $verificarNombreCortoExistente = self::fetchArray("SELECT app_id FROM avpc_aplicacion WHERE app_nombre_corto = '{$_POST['app_nombre_corto']}' AND app_situacion = 1 AND app_id != {$id}");
            if (count($verificarNombreCortoExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otra aplicación registrada con este nombre corto'
                ]);
                exit;
            }

            //ACTUALIZAR APLICACIÓN
            $aplicacion = Aplicacion::find($id);
            $aplicacion->sincronizar([
                'app_nombre_largo' => $_POST['app_nombre_largo'],
                'app_nombre_corto' => $_POST['app_nombre_corto'],
                'app_situacion' => 1
            ]);

            $resultado = $aplicacion->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Aplicación modificada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la aplicación',
                'detalle' => $e->getMessage(),
            ]);
        }
        exit;
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            Aplicacion::EliminarAplicacion($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'La aplicación ha sido eliminada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar la aplicación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}