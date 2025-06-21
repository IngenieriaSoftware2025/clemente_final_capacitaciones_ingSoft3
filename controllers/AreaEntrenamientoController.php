<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\AreaEntrenamiento;

class AreaEntrenamientoController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('areaentrenamiento/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // NOMBRE DEL ÁREA OBLIGATORIO
        $_POST['area_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['area_nombre']))));
        $cantidad_nombre = strlen($_POST['area_nombre']);
        if ($cantidad_nombre < 3) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del área debe tener más de 2 caracteres'
            ]);
            exit;
        }

        // DESCRIPCIÓN OBLIGATORIA
        $_POST['area_descripcion'] = ucfirst(strtolower(trim(htmlspecialchars($_POST['area_descripcion']))));
        $cantidad_descripcion = strlen($_POST['area_descripcion']);
        if ($cantidad_descripcion < 10) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción debe tener al menos 10 caracteres'
            ]);
            exit;
        }

        // DIRECCIÓN OBLIGATORIA
        $_POST['area_direccion'] = ucwords(strtolower(trim(htmlspecialchars($_POST['area_direccion']))));
        $cantidad_direccion = strlen($_POST['area_direccion']);
        if ($cantidad_direccion < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La dirección debe tener al menos 5 caracteres'
            ]);
            exit;
        }

        // VERIFICAR NOMBRE EXISTENTE
        $verificarNombreExistente = self::fetchArray("SELECT area_id FROM avpc_area_entrenamiento WHERE area_nombre = '{$_POST['area_nombre']}' AND area_situacion = 1");
        if (count($verificarNombreExistente) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe un área de entrenamiento registrada con este nombre'
            ]);
            exit;
        }

        $area = new AreaEntrenamiento($_POST);
        $resultado = $area->crear();

        if ($resultado['resultado'] == 1) {
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Área de entrenamiento registrada correctamente',
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar el área de entrenamiento',
                'datos' => $_POST,
                'area' => $area,
            ]);
            exit;
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["area_situacion = 1"];

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT * FROM avpc_area_entrenamiento WHERE $where ORDER BY area_nombre ASC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Áreas de entrenamiento obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las áreas de entrenamiento',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['area_id'];

            // NOMBRE DEL ÁREA OBLIGATORIO
            $_POST['area_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['area_nombre']))));
            $cantidad_nombre = strlen($_POST['area_nombre']);
            if ($cantidad_nombre < 3) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre del área debe tener más de 2 caracteres'
                ]);
                exit;
            }

            // DESCRIPCIÓN OBLIGATORIA
            $_POST['area_descripcion'] = ucfirst(strtolower(trim(htmlspecialchars($_POST['area_descripcion']))));
            $cantidad_descripcion = strlen($_POST['area_descripcion']);
            if ($cantidad_descripcion < 10) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La descripción debe tener al menos 10 caracteres'
                ]);
                exit;
            }

            // DIRECCIÓN OBLIGATORIA
            $_POST['area_direccion'] = ucwords(strtolower(trim(htmlspecialchars($_POST['area_direccion']))));
            $cantidad_direccion = strlen($_POST['area_direccion']);
            if ($cantidad_direccion < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La dirección debe tener al menos 5 caracteres'
                ]);
                exit;
            }

            // VERIFICAR NOMBRE EXISTENTE (excluyendo el área actual)
            $verificarNombreExistente = self::fetchArray("SELECT area_id FROM avpc_area_entrenamiento WHERE area_nombre = '{$_POST['area_nombre']}' AND area_situacion = 1 AND area_id != {$id}");
            if (count($verificarNombreExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otra área de entrenamiento registrada con este nombre'
                ]);
                exit;
            }

            //ACTUALIZAR ÁREA
            $area = AreaEntrenamiento::find($id);
            $area->sincronizar([
                'area_nombre' => $_POST['area_nombre'],
                'area_descripcion' => $_POST['area_descripcion'],
                'area_direccion' => $_POST['area_direccion'],
                'area_situacion' => 1
            ]);

            $resultado = $area->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Área de entrenamiento modificada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el área de entrenamiento',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            AreaEntrenamiento::EliminarAreaEntrenamiento($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El área de entrenamiento ha sido eliminada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el área de entrenamiento',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}