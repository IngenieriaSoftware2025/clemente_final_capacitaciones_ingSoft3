<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Compania;

class CompaniaController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('compania/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // NOMBRE LARGO OBLIGATORIO
        $_POST['app_nombre_largo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['app_nombre_largo']))));
        $cantidad_nombre_largo = strlen($_POST['app_nombre_largo']);
        if ($cantidad_nombre_largo < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre largo debe tener al menos 5 caracteres'
            ]);
            exit;
        }

        // NOMBRE CORTO OBLIGATORIO
        $_POST['app_nombre_corto'] = strtoupper(trim(htmlspecialchars($_POST['app_nombre_corto'])));
        $cantidad_nombre_corto = strlen($_POST['app_nombre_corto']);
        if ($cantidad_nombre_corto < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre corto debe tener al menos 2 caracteres'
            ]);
            exit;
        }

        // VERIFICAR NOMBRE LARGO EXISTENTE
        $verificarNombreLargoExistente = self::fetchArray("SELECT app_id FROM avpc_compania WHERE app_nombre_largo = '{$_POST['app_nombre_largo']}' AND app_situacion = 1");
        if (count($verificarNombreLargoExistente) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe una compañía registrada con este nombre largo'
            ]);
            exit;
        }

        // VERIFICAR NOMBRE CORTO EXISTENTE
        $verificarNombreCortoExistente = self::fetchArray("SELECT app_id FROM avpc_compania WHERE app_nombre_corto = '{$_POST['app_nombre_corto']}' AND app_situacion = 1");
        if (count($verificarNombreCortoExistente) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe una compañía registrada con este nombre corto'
            ]);
            exit;
        }

        $_POST['app_fecha_creacion'] = '';

        $compania = new Compania($_POST);
        $resultado = $compania->crear();

        if ($resultado['resultado'] == 1) {
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Compañía registrada correctamente',
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar la compañía',
                'datos' => $_POST,
                'compania' => $compania,
            ]);
            exit;
        }
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
            $sql = "SELECT * FROM avpc_compania WHERE $where ORDER BY app_fecha_creacion DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Compañías obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las compañías',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['app_id'];

            // NOMBRE LARGO OBLIGATORIO
            $_POST['app_nombre_largo'] = ucwords(strtolower(trim(htmlspecialchars($_POST['app_nombre_largo']))));
            $cantidad_nombre_largo = strlen($_POST['app_nombre_largo']);
            if ($cantidad_nombre_largo < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre largo debe tener al menos 5 caracteres'
                ]);
                exit;
            }

            // NOMBRE CORTO OBLIGATORIO
            $_POST['app_nombre_corto'] = strtoupper(trim(htmlspecialchars($_POST['app_nombre_corto'])));
            $cantidad_nombre_corto = strlen($_POST['app_nombre_corto']);
            if ($cantidad_nombre_corto < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre corto debe tener al menos 2 caracteres'
                ]);
                exit;
            }

            // VERIFICAR NOMBRE LARGO EXISTENTE 
            $verificarNombreLargoExistente = self::fetchArray("SELECT app_id FROM avpc_compania WHERE app_nombre_largo = '{$_POST['app_nombre_largo']}' AND app_situacion = 1 AND app_id != {$id}");
            if (count($verificarNombreLargoExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otra compañía registrada con este nombre largo'
                ]);
                exit;
            }

            // VERIFICAR NOMBRE CORTO EXISTENTE 
            $verificarNombreCortoExistente = self::fetchArray("SELECT app_id FROM avpc_compania WHERE app_nombre_corto = '{$_POST['app_nombre_corto']}' AND app_situacion = 1 AND app_id != {$id}");
            if (count($verificarNombreCortoExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otra compañía registrada con este nombre corto'
                ]);
                exit;
            }

            //ACTUALIZAR COMPAÑÍA
            $compania = Compania::find($id);
            $compania->sincronizar([
                'app_nombre_largo' => $_POST['app_nombre_largo'],
                'app_nombre_corto' => $_POST['app_nombre_corto'],
                'app_situacion' => 1
            ]);

            $resultado = $compania->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Compañía modificada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la compañía',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            Compania::EliminarCompania($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El registro ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}