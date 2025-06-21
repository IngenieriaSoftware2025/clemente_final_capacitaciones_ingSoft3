<?php

namespace Controllers;

use Exception;
use Model\ActiveRecord;
use MVC\Router;

class EstadisticasEntrenamientoController extends ActiveRecord
{

    public static function renderizarPagina(Router $router)
    {
        $router->render('estadisticasentrenamiento/index', []);
    }

    public static function buscarAPI()
    {
        header('Content-Type: application/json');
        
        try {
            // 1. ENTRENAMIENTOS POR CAPACITACIÓN
            $sqlCapacitaciones = "SELECT 
                                    c.capacitacion_nombre as capacitacion, 
                                    c.capacitacion_id, 
                                    COUNT(e.entrenamiento_id) as cantidad_entrenamientos
                                FROM avpc_capacitacion c
                                LEFT JOIN avpc_entrenamiento e ON c.capacitacion_id = e.entrenamiento_capacitacion_id 
                                    AND e.entrenamiento_situacion = 1
                                WHERE c.capacitacion_situacion = 1
                                GROUP BY c.capacitacion_id, c.capacitacion_nombre 
                                ORDER BY cantidad_entrenamientos DESC";
            $capacitaciones = self::fetchArray($sqlCapacitaciones);

            // 2. ESTADOS DE ENTRENAMIENTOS
            $sqlEstados = "SELECT 
                            entrenamiento_estado as estado, 
                            COUNT(*) as cantidad
                        FROM avpc_entrenamiento 
                        WHERE entrenamiento_situacion = 1 
                        GROUP BY entrenamiento_estado 
                        ORDER BY cantidad DESC";
            $estados = self::fetchArray($sqlEstados);

             3. INSTRUCTORES MÁS ACTIVOS
            $sqlInstructores = "SELECT 
                                (u.usuario_nom1 || ' ' || u.usuario_ape1) as instructor_nombre,
                                i.instructor_grado,
                                COUNT(e.entrenamiento_id) as total_entrenamientos
                            FROM avpc_instructor i
                            INNER JOIN avpc_usuario u ON i.instructor_usuario_id = u.usuario_id
                            LEFT JOIN avpc_entrenamiento e ON i.instructor_id = e.entrenamiento_instructor_id 
                                AND e.entrenamiento_situacion = 1
                            WHERE i.instructor_situacion = 1 AND u.usuario_situacion = 1
                            GROUP BY i.instructor_id, u.usuario_nom1, u.usuario_ape1, i.instructor_grado
                            ORDER BY total_entrenamientos DESC
                            LIMIT 10";
            $instructores = self::fetchArray($sqlInstructores);

            // 4. ENTRENAMIENTOS POR MES
            $sqlEntrenamientosMes = "SELECT 
                                        MONTH(entrenamiento_fecha_inicio) as mes,
                                        YEAR(entrenamiento_fecha_inicio) as anio,
                                        COUNT(*) as total_entrenamientos
                                    FROM avpc_entrenamiento 
                                    WHERE entrenamiento_situacion = 1 
                                        AND entrenamiento_fecha_inicio >= (TODAY - 365 UNITS DAY)
                                    GROUP BY MONTH(entrenamiento_fecha_inicio), YEAR(entrenamiento_fecha_inicio)
                                    ORDER BY anio, mes";
            $entrenamientosMes = self::fetchArray($sqlEntrenamientosMes);

            // 5. COMPAÑÍAS CON MÁS ENTRENAMIENTOS
            $sqlCompanias = "SELECT 
                                comp.app_nombre_largo as compania_nombre,
                                COUNT(e.entrenamiento_id) as total_entrenamientos
                            FROM avpc_compania comp
                            LEFT JOIN avpc_entrenamiento e ON comp.app_id = e.entrenamiento_compania_id 
                                AND e.entrenamiento_situacion = 1
                            WHERE comp.app_situacion = 1
                            GROUP BY comp.app_id, comp.app_nombre_largo
                            ORDER BY total_entrenamientos DESC
                            LIMIT 8";
            $companias = self::fetchArray($sqlCompanias);

            // 6. ÁREAS DE ENTRENAMIENTO MÁS UTILIZADAS
            $sqlAreas = "SELECT 
                            a.area_nombre,
                            COUNT(e.entrenamiento_id) as total_entrenamientos
                        FROM avpc_area_entrenamiento a
                        LEFT JOIN avpc_entrenamiento e ON a.area_id = e.entrenamiento_area_id 
                            AND e.entrenamiento_situacion = 1
                        WHERE a.area_situacion = 1
                        GROUP BY a.area_id, a.area_nombre
                        ORDER BY total_entrenamientos DESC";
            $areas = self::fetchArray($sqlAreas);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Estadísticas de entrenamientos obtenidas correctamente',
                'capacitaciones' => $capacitaciones,
                'estados' => $estados,
                'instructores' => $instructores,
                'entrenamientosMes' => $entrenamientosMes,
                'companias' => $companias,
                'areas' => $areas
            ]);
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las estadísticas de entrenamientos',
                'detalle' => $e->getMessage()
            ]);
        }
        exit;
    }

    // MÉTODO ADICIONAL
    public static function buscarPorFechasAPI()
    {
        header('Content-Type: application/json');
        
        try {
            $fechaInicio = $_GET['fecha_inicio'] ?? null;
            $fechaFin = $_GET['fecha_fin'] ?? null;
            
            $condicionFecha = "";
            if ($fechaInicio && $fechaFin) {
                $condicionFecha = "AND e.entrenamiento_fecha_inicio BETWEEN '{$fechaInicio}' AND '{$fechaFin}'";
            }

            // Entrenamientos en el rango de fechas
            $sqlRangoFechas = "SELECT 
                                    DATE(e.entrenamiento_fecha_inicio) as fecha,
                                    COUNT(*) as cantidad_entrenamientos,
                                    c.capacitacion_nombre
                                FROM avpc_entrenamiento e
                                INNER JOIN avpc_capacitacion c ON e.entrenamiento_capacitacion_id = c.capacitacion_id
                                WHERE e.entrenamiento_situacion = 1 {$condicionFecha}
                                GROUP BY DATE(e.entrenamiento_fecha_inicio), c.capacitacion_nombre
                                ORDER BY fecha DESC";
            $rangoFechas = self::fetchArray($sqlRangoFechas);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Estadísticas por fechas obtenidas correctamente',
                'rangoFechas' => $rangoFechas
            ]);
            
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las estadísticas por fechas',
                'detalle' => $e->getMessage()
            ]);
        }
        exit;
    }
}