<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\HistorialActividades;

class HistorialActividadesController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('historial_actividades/index', []);
    }

    public static function registrarActividad($modulo, $accion, $descripcion, $ruta = '')
    {
        try {
 
            if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_nom1']) || !isset($_SESSION['usuario_ape1'])) {
                return;
            }

 
            $ip = self::obtenerIPUsuario();
            
       
            $nombre_completo = $_SESSION['usuario_nom1'] . ' ' . ($_SESSION['usuario_nom2'] ?? '') . ' ' . $_SESSION['usuario_ape1'] . ' ' . ($_SESSION['usuario_ape2'] ?? '');
            $nombre_completo = trim(preg_replace('/\s+/', ' ', $nombre_completo)); // Limpiar espacios extra

            $datos = [
                'historial_usuario_id' => $_SESSION['usuario_id'],
                'historial_usuario_nombre' => $nombre_completo,
                'historial_modulo' => strtoupper($modulo),
                'historial_accion' => strtoupper($accion),
                'historial_descripcion' => $descripcion,
                'historial_ip' => $ip,
                'historial_ruta' => $ruta,
                'historial_situacion' => 1
            ];

            $actividad = new HistorialActividades($datos);
            $actividad->crear();

        } catch (Exception $e) {
   
            error_log("Error al registrar actividad: " . $e->getMessage());
        }
    }

 
    private static function obtenerIPUsuario()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
         
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
        }
    }

  
    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;
            $usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : null;
            $modulo = isset($_GET['modulo']) ? $_GET['modulo'] : null;
            $accion = isset($_GET['accion']) ? $_GET['accion'] : null;

            $condiciones = ["historial_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "historial_fecha_creacion >= '{$fecha_inicio} 00:00:00'";
            }

            if ($fecha_fin) {
                $condiciones[] = "historial_fecha_creacion <= '{$fecha_fin} 23:59:59'";
            }

            if ($usuario_id) {
                $condiciones[] = "historial_usuario_id = {$usuario_id}";
            }

            if ($modulo) {
                $condiciones[] = "historial_modulo = '{$modulo}'";
            }

            if ($accion) {
                $condiciones[] = "historial_accion = '{$accion}'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT 
                        historial_id,
                        historial_usuario_id,
                        historial_usuario_nombre,
                        historial_modulo,
                        historial_accion,
                        historial_descripcion,
                        historial_ip,
                        historial_ruta,
                        historial_situacion,
                        historial_fecha_creacion
                    FROM avpc_historial_actividades 
                    WHERE $where 
                    ORDER BY historial_fecha_creacion DESC";
            
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
            $sql = "SELECT DISTINCT 
                        historial_usuario_id, 
                        historial_usuario_nombre 
                    FROM avpc_historial_actividades 
                    WHERE historial_situacion = 1 
                    ORDER BY historial_usuario_nombre";
            
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
}