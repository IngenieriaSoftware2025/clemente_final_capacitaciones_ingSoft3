<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Capacitacion;

class CapacitacionController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('capacitacion/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // NOMBRE OBLIGATORIO
        $_POST['capacitacion_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['capacitacion_nombre']))));
        $cantidad_nombre = strlen($_POST['capacitacion_nombre']);
        if ($cantidad_nombre < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre de la capacitación debe tener al menos 5 caracteres'
            ]);
            exit;
        }

        // DESCRIPCIÓN OBLIGATORIA
        $_POST['capacitacion_descripcion'] = ucfirst(trim(htmlspecialchars($_POST['capacitacion_descripcion'])));
        $cantidad_descripcion = strlen($_POST['capacitacion_descripcion']);
        if ($cantidad_descripcion < 10) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción debe tener al menos 10 caracteres'
            ]);
            exit;
        }

        // DURACIÓN EN HORAS OBLIGATORIA
        $_POST['capacitacion_duracion_horas'] = filter_var($_POST['capacitacion_duracion_horas'], FILTER_VALIDATE_INT);
        if ($_POST['capacitacion_duracion_horas'] <= 0 || $_POST['capacitacion_duracion_horas'] > 1000) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La duración debe ser un número mayor a 0 y menor a 1000 horas'
            ]);
            exit;
        }

        // OBJETIVOS OBLIGATORIOS
        $_POST['capacitacion_objetivos'] = ucfirst(trim(htmlspecialchars($_POST['capacitacion_objetivos'])));
        $cantidad_objetivos = strlen($_POST['capacitacion_objetivos']);
        if ($cantidad_objetivos < 10) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los objetivos deben tener al menos 10 caracteres'
            ]);
            exit;
        }

        // USUARIO CREADOR OBLIGATORIO
        if (empty($_POST['capacitacion_usuario_creo'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar el usuario que crea la capacitación'
            ]);
            exit;
        }

        // VERIFICAR NOMBRE EXISTENTE
        $verificarNombreExistente = self::fetchArray("SELECT capacitacion_id FROM avpc_capacitacion WHERE capacitacion_nombre = '{$_POST['capacitacion_nombre']}' AND capacitacion_situacion = 1");
        if (count($verificarNombreExistente) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe una capacitación registrada con este nombre'
            ]);
            exit;
        }

        $_POST['capacitacion_fecha_creacion'] = '';

        $capacitacion = new Capacitacion($_POST);
        $resultado = $capacitacion->crear();

        if ($resultado['resultado'] == 1) {
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Capacitación registrada correctamente',
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar la capacitación',
                'datos' => $_POST,
                'capacitacion' => $capacitacion,
            ]);
            exit;
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["c.capacitacion_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "c.capacitacion_fecha_creacion >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "c.capacitacion_fecha_creacion <= '{$fecha_fin}'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT c.*, u.usuario_nom1, u.usuario_ape1 
                    FROM avpc_capacitacion c 
                    LEFT JOIN avpc_usuario u ON c.capacitacion_usuario_creo = u.usuario_id 
                    WHERE $where 
                    ORDER BY c.capacitacion_fecha_creacion DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Capacitaciones obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las capacitaciones',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['capacitacion_id'];

            // NOMBRE OBLIGATORIO
            $_POST['capacitacion_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['capacitacion_nombre']))));
            $cantidad_nombre = strlen($_POST['capacitacion_nombre']);
            if ($cantidad_nombre < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre de la capacitación debe tener al menos 5 caracteres'
                ]);
                exit;
            }

            // DESCRIPCIÓN OBLIGATORIA
            $_POST['capacitacion_descripcion'] = ucfirst(trim(htmlspecialchars($_POST['capacitacion_descripcion'])));
            $cantidad_descripcion = strlen($_POST['capacitacion_descripcion']);
            if ($cantidad_descripcion < 10) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La descripción debe tener al menos 10 caracteres'
                ]);
                exit;
            }

            // DURACIÓN EN HORAS OBLIGATORIA
            $_POST['capacitacion_duracion_horas'] = filter_var($_POST['capacitacion_duracion_horas'], FILTER_VALIDATE_INT);
            if ($_POST['capacitacion_duracion_horas'] <= 0 || $_POST['capacitacion_duracion_horas'] > 1000) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La duración debe ser un número mayor a 0 y menor a 1000 horas'
                ]);
                exit;
            }

            // OBJETIVOS OBLIGATORIOS
            $_POST['capacitacion_objetivos'] = ucfirst(trim(htmlspecialchars($_POST['capacitacion_objetivos'])));
            $cantidad_objetivos = strlen($_POST['capacitacion_objetivos']);
            if ($cantidad_objetivos < 10) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Los objetivos deben tener al menos 10 caracteres'
                ]);
                exit;
            }

            // USUARIO CREADOR OBLIGATORIO
            if (empty($_POST['capacitacion_usuario_creo'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar el usuario que crea la capacitación'
                ]);
                exit;
            }

            // VERIFICAR NOMBRE EXISTENTE (excluyendo la capacitación actual)
            $verificarNombreExistente = self::fetchArray("SELECT capacitacion_id FROM avpc_capacitacion WHERE capacitacion_nombre = '{$_POST['capacitacion_nombre']}' AND capacitacion_situacion = 1 AND capacitacion_id != {$id}");
            if (count($verificarNombreExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otra capacitación registrada con este nombre'
                ]);
                exit;
            }

            //ACTUALIZAR CAPACITACIÓN
            $capacitacion = Capacitacion::find($id);
            $capacitacion->sincronizar([
                'capacitacion_nombre' => $_POST['capacitacion_nombre'],
                'capacitacion_descripcion' => $_POST['capacitacion_descripcion'],
                'capacitacion_duracion_horas' => $_POST['capacitacion_duracion_horas'],
                'capacitacion_objetivos' => $_POST['capacitacion_objetivos'],
                'capacitacion_usuario_creo' => $_POST['capacitacion_usuario_creo'],
                'capacitacion_situacion' => 1
            ]);

            $resultado = $capacitacion->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Capacitación modificada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la capacitación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            Capacitacion::EliminarCapacitacion($id);

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

    public static function obtenerUsuariosAPI()
    {
        getHeadersApi();
        try {
            $usuarios = self::fetchArray("SELECT usuario_id, usuario_nom1, usuario_ape1 FROM avpc_usuario WHERE usuario_situacion = 1 ORDER BY usuario_nom1 ASC");

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuarios obtenidos correctamente',
                'data' => $usuarios
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener usuarios',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}