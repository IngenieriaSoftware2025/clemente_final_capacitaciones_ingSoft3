<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\HistorialAct;

class HistorialActController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: /clemente_final_capacitaciones_ingSoft3/");
            exit;
        }
        
        $router->render('historial/index', []);
    }

    public static function registrarActividad($usuario_id, $ruta_id, $ejecucion)
    {
        try {
            if($usuario_id && $ruta_id) {
                $historial_actividad = new HistorialAct([
                    'historial_usuario_id' => $usuario_id,
                    'historial_ruta' => $ruta_id,
                    'historial_ejecucion' => $ejecucion,
                    'historial_situacion' => 1
                ]);
                $historial_actividad->crear();
            }
        } catch (Exception $e) {
            // Silenciar errores para no interrumpir el flujo
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
            $usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : null;
            $ruta_id = isset($_GET['ruta_id']) ? $_GET['ruta_id'] : null;

            $condiciones = ["h.historial_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "h.historial_fecha >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "h.historial_fecha <= '{$fecha_fin}'";
            }

            if ($usuario_id) {
                $condiciones[] = "h.historial_usuario_id = {$usuario_id}";
            }

            if ($ruta_id) {
                $condiciones[] = "h.historial_ruta = {$ruta_id}";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT 
                        h.*,
                        u.usuario_nom1,
                        u.usuario_ape1,
                        r.ruta_nombre,
                        r.ruta_descripcion
                    FROM avpc_historial_act h 
                    INNER JOIN avpc_usuario u ON h.historial_usuario_id = u.usuario_id
                    INNER JOIN avpc_rutas r ON h.historial_ruta = r.ruta_id
                    WHERE $where 
                    ORDER BY h.historial_fecha DESC, h.historial_id DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Actividades obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las actividades',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarUsuariosAPI()
    {
        try {
            $sql = "SELECT DISTINCT h.historial_usuario_id, u.usuario_nom1, u.usuario_ape1 
                    FROM avpc_historial_act h
                    INNER JOIN avpc_usuario u ON h.historial_usuario_id = u.usuario_id
                    WHERE h.historial_situacion = 1
                    ORDER BY u.usuario_nom1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuarios obtenidos correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los usuarios',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function exportarReporteAPI()
    {
        try {
            session_start();
            if (!isset($_SESSION['usuario_id'])) {
                http_response_code(401);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Usuario no autenticado'
                ]);
                return;
            }

            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
            $usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : null;

            $condiciones = ["h.historial_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "h.historial_fecha >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "h.historial_fecha <= '{$fecha_fin}'";
            }

            if ($usuario_id) {
                $condiciones[] = "h.historial_usuario_id = {$usuario_id}";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT 
                        h.historial_fecha as fecha,
                        u.usuario_nom1 || ' ' || u.usuario_ape1 as usuario,
                        r.ruta_nombre as ruta,
                        r.ruta_descripcion as descripcion,
                        h.historial_ejecucion as ejecucion
                    FROM avpc_historial_act h 
                    INNER JOIN avpc_usuario u ON h.historial_usuario_id = u.usuario_id
                    INNER JOIN avpc_rutas r ON h.historial_ruta = r.ruta_id
                    WHERE $where 
                    ORDER BY h.historial_fecha DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Reporte generado correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al generar el reporte',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarActividadPorUsuarioAPI()
    {
        try {
            $sql = "SELECT 
                        u.usuario_nom1 || ' ' || u.usuario_ape1 as usuario,
                        COUNT(h.historial_id) as actividades
                    FROM avpc_historial_act h
                    INNER JOIN avpc_usuario u ON h.historial_usuario_id = u.usuario_id
                    WHERE h.historial_situacion = 1
                    GROUP BY h.historial_usuario_id, u.usuario_nom1, u.usuario_ape1
                    ORDER BY actividades DESC
                    LIMIT 10";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Actividades por usuario obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las actividades por usuario',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarActividadPorDiaAPI()
    {
        try {
            $sql = "SELECT 
                        DATE(historial_fecha) as fecha,
                        COUNT(historial_id) as actividades
                    FROM avpc_historial_act
                    WHERE historial_situacion = 1
                    AND historial_fecha >= CURRENT DATE - 30 UNITS DAY
                    GROUP BY DATE(historial_fecha)
                    ORDER BY fecha DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Actividades por día obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las actividades por día',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function buscarActividadPorRutaAPI()
    {
        try {
            $sql = "SELECT 
                        r.ruta_nombre as ruta,
                        COUNT(*) as cantidad
                    FROM avpc_historial_act h
                    INNER JOIN avpc_rutas r ON h.historial_ruta = r.ruta_id
                    WHERE h.historial_situacion = 1
                    GROUP BY r.ruta_id, r.ruta_nombre
                    ORDER BY cantidad DESC";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Actividades por ruta obtenidas correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las actividades por ruta',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

}