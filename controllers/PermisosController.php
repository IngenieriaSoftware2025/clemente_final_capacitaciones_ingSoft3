<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Permisos;

class PermisosController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('permisos/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // USUARIO OBLIGATORIO
        if (empty($_POST['usuario_id'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un usuario'
            ]);
            exit;
        }

        // APLICACIÓN OBLIGATORIA
        if (empty($_POST['app_id'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una aplicación'
            ]);
            exit;
        }

        // NOMBRE DEL PERMISO OBLIGATORIO
        $_POST['permiso_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['permiso_nombre']))));
        $cantidad_nombre = strlen($_POST['permiso_nombre']);
        if ($cantidad_nombre < 3) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El nombre del permiso debe tener al menos 3 caracteres'
            ]);
            exit;
        }

        // CLAVE DEL PERMISO OBLIGATORIA
        $_POST['permiso_clave'] = strtoupper(trim(htmlspecialchars($_POST['permiso_clave'])));
        $cantidad_clave = strlen($_POST['permiso_clave']);
        if ($cantidad_clave < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La clave del permiso debe tener al menos 2 caracteres'
            ]);
            exit;
        }

        // DESCRIPCIÓN OBLIGATORIA
        $_POST['permiso_desc'] = ucfirst(strtolower(trim(htmlspecialchars($_POST['permiso_desc']))));
        $cantidad_descripcion = strlen($_POST['permiso_desc']);
        if ($cantidad_descripcion < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La descripción debe tener al menos 5 caracteres'
            ]);
            exit;
        }

        // MOTIVO OBLIGATORIO
        $_POST['permiso_motivo'] = ucfirst(strtolower(trim(htmlspecialchars($_POST['permiso_motivo']))));
        $cantidad_motivo = strlen($_POST['permiso_motivo']);
        if ($cantidad_motivo < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El motivo debe tener al menos 5 caracteres'
            ]);
            exit;
        }

        // VERIFICAR PERMISO DUPLICADO
        $verificarDuplicado = self::fetchArray("SELECT permiso_id FROM avpc_permiso WHERE usuario_id = '{$_POST['usuario_id']}' AND app_id = '{$_POST['app_id']}' AND permiso_nombre = '{$_POST['permiso_nombre']}' AND permiso_situacion = 1");
        if (count($verificarDuplicado) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Este usuario ya tiene un permiso con el mismo nombre para esta aplicación'
            ]);
            exit;
        }

        $permiso = new Permisos($_POST);
        $resultado = $permiso->crear();

        if ($resultado['resultado'] == 1) {
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Permiso registrado correctamente',
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar el permiso',
                'datos' => $_POST,
                'permiso' => $permiso,
            ]);
            exit;
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["p.permiso_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "p.permiso_fecha >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "p.permiso_fecha <= '{$fecha_fin}'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT p.*, u.usuario_nom1, u.usuario_nom2, u.usuario_ape1, u.usuario_ape2, 
                           a.app_nombre_corto, a.app_nombre_largo
                    FROM avpc_permiso p 
                    LEFT JOIN avpc_usuario u ON p.usuario_id = u.usuario_id 
                    LEFT JOIN avpc_aplicacion a ON p.app_id = a.app_id 
                    WHERE $where 
                    ORDER BY p.permiso_fecha DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Permisos obtenidos correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los permisos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['permiso_id'];

            // USUARIO OBLIGATORIO
            if (empty($_POST['usuario_id'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar un usuario'
                ]);
                exit;
            }

            // APLICACIÓN OBLIGATORIA
            if (empty($_POST['app_id'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar una aplicación'
                ]);
                exit;
            }

            // NOMBRE DEL PERMISO OBLIGATORIO
            $_POST['permiso_nombre'] = ucwords(strtolower(trim(htmlspecialchars($_POST['permiso_nombre']))));
            $cantidad_nombre = strlen($_POST['permiso_nombre']);
            if ($cantidad_nombre < 3) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El nombre del permiso debe tener al menos 3 caracteres'
                ]);
                exit;
            }

            // CLAVE DEL PERMISO OBLIGATORIA
            $_POST['permiso_clave'] = strtoupper(trim(htmlspecialchars($_POST['permiso_clave'])));
            $cantidad_clave = strlen($_POST['permiso_clave']);
            if ($cantidad_clave < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La clave del permiso debe tener al menos 2 caracteres'
                ]);
                exit;
            }

            // DESCRIPCIÓN OBLIGATORIA
            $_POST['permiso_desc'] = ucfirst(strtolower(trim(htmlspecialchars($_POST['permiso_desc']))));
            $cantidad_descripcion = strlen($_POST['permiso_desc']);
            if ($cantidad_descripcion < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La descripción debe tener al menos 5 caracteres'
                ]);
                exit;
            }

            // MOTIVO OBLIGATORIO
            $_POST['permiso_motivo'] = ucfirst(strtolower(trim(htmlspecialchars($_POST['permiso_motivo']))));
            $cantidad_motivo = strlen($_POST['permiso_motivo']);
            if ($cantidad_motivo < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El motivo debe tener al menos 5 caracteres'
                ]);
                exit;
            }

            // VERIFICAR PERMISO DUPLICADO (excluyendo el actual)
            $verificarDuplicado = self::fetchArray("SELECT permiso_id FROM avpc_permiso WHERE usuario_id = '{$_POST['usuario_id']}' AND app_id = '{$_POST['app_id']}' AND permiso_nombre = '{$_POST['permiso_nombre']}' AND permiso_situacion = 1 AND permiso_id != {$id}");
            if (count($verificarDuplicado) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Este usuario ya tiene otro permiso con el mismo nombre para esta aplicación'
                ]);
                exit;
            }

            // ACTUALIZAR PERMISO
            $permiso = Permisos::find($id);
            $permiso->sincronizar([
                'usuario_id' => $_POST['usuario_id'],
                'app_id' => $_POST['app_id'],
                'permiso_nombre' => $_POST['permiso_nombre'],
                'permiso_clave' => $_POST['permiso_clave'],
                'permiso_desc' => $_POST['permiso_desc'],
                'permiso_motivo' => $_POST['permiso_motivo'],
                'permiso_tipo' => $_POST['permiso_tipo'],
                'permiso_situacion' => 1
            ]);

            $resultado = $permiso->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Permiso modificado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el permiso',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            Permisos::EliminarPermiso($id);

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
            $usuarios = self::fetchArray("SELECT usuario_id, usuario_nom1, usuario_nom2, usuario_ape1, usuario_ape2 FROM avpc_usuario WHERE usuario_situacion = 1 ORDER BY usuario_nom1 ASC");

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

    public static function obtenerAplicacionesAPI()
    {
        getHeadersApi();
        try {
            $aplicaciones = self::fetchArray("SELECT app_id, app_nombre_corto, app_nombre_largo FROM avpc_aplicacion WHERE app_situacion = 1 ORDER BY app_nombre_corto ASC");

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Aplicaciones obtenidas correctamente',
                'data' => $aplicaciones
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener aplicaciones',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}