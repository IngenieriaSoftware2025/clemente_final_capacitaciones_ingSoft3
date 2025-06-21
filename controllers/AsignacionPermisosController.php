<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\AsignacionPermisos;

class AsignacionPermisosController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('asignacionpermisos/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // USUARIO OBLIGATORIO
        if (empty($_POST['asignacion_usuario_id'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un usuario'
            ]);
            exit;
        }

        // APLICACIÓN OBLIGATORIA
        if (empty($_POST['asignacion_app_id'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una aplicación'
            ]);
            exit;
        }

        // PERMISO OBLIGATORIO
        if (empty($_POST['asignacion_permiso_id'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un permiso'
            ]);
            exit;
        }

        // USUARIO QUE ASIGNA OBLIGATORIO
        if (empty($_POST['asignacion_usuario_asigno'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe indicar el usuario que realiza la asignación'
            ]);
            exit;
        }

        // MOTIVO OBLIGATORIO
        $_POST['asignacion_motivo'] = ucfirst(strtolower(trim(htmlspecialchars($_POST['asignacion_motivo']))));
        $cantidad_motivo = strlen($_POST['asignacion_motivo']);
        if ($cantidad_motivo < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El motivo debe tener al menos 5 caracteres'
            ]);
            exit;
        }

        // VERIFICAR ASIGNACIÓN DUPLICADA
        $verificarDuplicado = self::fetchArray("SELECT asignacion_id FROM avpc_asig_permisos WHERE asignacion_usuario_id = '{$_POST['asignacion_usuario_id']}' AND asignacion_app_id = '{$_POST['asignacion_app_id']}' AND asignacion_permiso_id = '{$_POST['asignacion_permiso_id']}' AND asignacion_situacion = 1");
        if (count($verificarDuplicado) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Este usuario ya tiene asignado este permiso para esta aplicación'
            ]);
            exit;
        }

        $asignacion = new AsignacionPermisos($_POST);
        $resultado = $asignacion->crear();

        if ($resultado['resultado'] == 1) {
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Asignación de permiso realizada correctamente',
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al realizar la asignación de permiso',
                'datos' => $_POST,
                'asignacion' => $asignacion,
            ]);
            exit;
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["a.asignacion_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "a.asignacion_fecha >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "a.asignacion_fecha <= '{$fecha_fin}'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT a.*, 
                           u.usuario_nom1, u.usuario_nom2, u.usuario_ape1, u.usuario_ape2,
                           app.app_nombre_corto, app.app_nombre_largo,
                           p.permiso_nombre, p.permiso_clave,
                           ua.usuario_nom1 as asigno_nom1, ua.usuario_ape1 as asigno_ape1
                    FROM avpc_asig_permisos a 
                    LEFT JOIN avpc_usuario u ON a.asignacion_usuario_id = u.usuario_id 
                    LEFT JOIN avpc_aplicacion app ON a.asignacion_app_id = app.app_id 
                    LEFT JOIN avpc_permiso p ON a.asignacion_permiso_id = p.permiso_id
                    LEFT JOIN avpc_usuario ua ON a.asignacion_usuario_asigno = ua.usuario_id
                    WHERE $where 
                    ORDER BY a.asignacion_fecha DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Asignaciones obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las asignaciones',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['asignacion_id'];

            // USUARIO OBLIGATORIO
            if (empty($_POST['asignacion_usuario_id'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar un usuario'
                ]);
                exit;
            }

            // APLICACIÓN OBLIGATORIA
            if (empty($_POST['asignacion_app_id'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar una aplicación'
                ]);
                exit;
            }

            // PERMISO OBLIGATORIO
            if (empty($_POST['asignacion_permiso_id'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar un permiso'
                ]);
                exit;
            }

            // USUARIO QUE ASIGNA OBLIGATORIO
            if (empty($_POST['asignacion_usuario_asigno'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe indicar el usuario que realiza la asignación'
                ]);
                exit;
            }

            // MOTIVO OBLIGATORIO
            $_POST['asignacion_motivo'] = ucfirst(strtolower(trim(htmlspecialchars($_POST['asignacion_motivo']))));
            $cantidad_motivo = strlen($_POST['asignacion_motivo']);
            if ($cantidad_motivo < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El motivo debe tener al menos 5 caracteres'
                ]);
                exit;
            }

            // VERIFICAR ASIGNACIÓN DUPLICADA 
            $verificarDuplicado = self::fetchArray("SELECT asignacion_id FROM avpc_asig_permisos WHERE asignacion_usuario_id = '{$_POST['asignacion_usuario_id']}' AND asignacion_app_id = '{$_POST['asignacion_app_id']}' AND asignacion_permiso_id = '{$_POST['asignacion_permiso_id']}' AND asignacion_situacion = 1 AND asignacion_id != {$id}");
            if (count($verificarDuplicado) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Este usuario ya tiene otra asignación igual para esta aplicación y permiso'
                ]);
                exit;
            }

            // ACTUALIZAR ASIGNACIÓN
            $asignacion = AsignacionPermisos::find($id);
            $asignacion->sincronizar([
                'asignacion_usuario_id' => $_POST['asignacion_usuario_id'],
                'asignacion_app_id' => $_POST['asignacion_app_id'],
                'asignacion_permiso_id' => $_POST['asignacion_permiso_id'],
                'asignacion_usuario_asigno' => $_POST['asignacion_usuario_asigno'],
                'asignacion_motivo' => $_POST['asignacion_motivo'],
                'asignacion_situacion' => 1
            ]);

            $resultado = $asignacion->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Asignación modificada correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar la asignación',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            AsignacionPermisos::EliminarAsignacion($id);

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

    public static function obtenerPermisosAPI()
    {
        getHeadersApi();
        try {
            $app_id = isset($_GET['app_id']) ? $_GET['app_id'] : null;
            
            $condiciones = ["permiso_situacion = 1"];
            
            if ($app_id) {
                $condiciones[] = "app_id = '{$app_id}'";
            }
            
            $where = implode(" AND ", $condiciones);
            $permisos = self::fetchArray("SELECT permiso_id, permiso_nombre, permiso_clave, app_id FROM avpc_permiso WHERE $where ORDER BY permiso_nombre ASC");

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Permisos obtenidos correctamente',
                'data' => $permisos
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener permisos',
                'detalle' => $e->getMessage()
            ]);
        }
    }
}