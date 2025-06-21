<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Entrenamiento;

class HorarioEntrenamientoController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('Horarioentrenamiento/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // CAPACITACIÓN OBLIGATORIA
        if (empty($_POST['entrenamiento_capacitacion_id']) || $_POST['entrenamiento_capacitacion_id'] == 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una capacitación'
            ]);
            exit;
        }

        // COMPAÑÍA OBLIGATORIA
        if (empty($_POST['entrenamiento_compania_id']) || $_POST['entrenamiento_compania_id'] == 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar una compañía'
            ]);
            exit;
        }

        // INSTRUCTOR OBLIGATORIO
        if (empty($_POST['entrenamiento_instructor_id']) || $_POST['entrenamiento_instructor_id'] == 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un instructor'
            ]);
            exit;
        }

        // ÁREA OBLIGATORIA
        if (empty($_POST['entrenamiento_area_id']) || $_POST['entrenamiento_area_id'] == 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un área de entrenamiento'
            ]);
            exit;
        }


       // FECHA INICIO OBLIGATORIA
            if (empty($_POST['entrenamiento_fecha_inicio'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La fecha de inicio es obligatoria'
                ]);
                exit;
            }

            // FECHA FIN OBLIGATORIA
            if (empty($_POST['entrenamiento_fecha_fin'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La fecha de fin es obligatoria'
                ]);
                exit;
            }

            // CONVERTIR FORMATO DE FECHAS PARA INFORMIX
            if (!empty($_POST['entrenamiento_fecha_inicio'])) {
                // Convertir de 2025-06-06T12:03 a 2025-06-06 12:03
                $_POST['entrenamiento_fecha_inicio'] = str_replace('T', ' ', $_POST['entrenamiento_fecha_inicio']);
            }
            
            if (!empty($_POST['entrenamiento_fecha_fin'])) {
                // Convertir de 2025-06-26T12:03 a 2025-06-26 12:03
                $_POST['entrenamiento_fecha_fin'] = str_replace('T', ' ', $_POST['entrenamiento_fecha_fin']);
            }

            // VALIDAR QUE FECHA FIN SEA MAYOR A FECHA INICIO
            $fechaInicio = strtotime($_POST['entrenamiento_fecha_inicio']);
            $fechaFin = strtotime($_POST['entrenamiento_fecha_fin']);
            
            if ($fechaFin <= $fechaInicio) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La fecha de fin debe ser posterior a la fecha de inicio'
                ]);
                exit;
            }

        // OBSERVACIONES OPCIONALES
        $_POST['entrenamiento_observaciones'] = trim(htmlspecialchars($_POST['entrenamiento_observaciones'] ?? ''));

        // USUARIO QUE CREA (por defecto 1, en un sistema real vendría de la sesión)
        $_POST['entrenamiento_usuario_creo'] = $_POST['entrenamiento_usuario_creo'] ?? 1;

        $entrenamiento = new Entrenamiento($_POST);
        $resultado = $entrenamiento->crear();

        if ($resultado['resultado'] == 1) {
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Entrenamiento registrado correctamente',
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar el entrenamiento',
                'datos' => $_POST,
                'entrenamiento' => $entrenamiento,
            ]);
            exit;
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["e.entrenamiento_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "e.entrenamiento_fecha_inicio >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "e.entrenamiento_fecha_fin <= '{$fecha_fin}'";
            }

            $where = implode(" AND ", $condiciones);
            
            // Primero, intentemos una consulta simple
            $sql = "SELECT * FROM avpc_entrenamiento e WHERE {$where} ORDER BY e.entrenamiento_fecha_inicio DESC";
            $data = self::fetchArray($sql);
            
            // Si hay datos, intentemos agregar los JOINs uno por uno
            if (count($data) > 0) {
            $sql = "SELECT 
                        e.*,
                        c.capacitacion_nombre,
                        comp.app_nombre_largo as compania_nombre,
                        (u_inst.usuario_nom1 || ' ' || u_inst.usuario_ape1) as instructor_nombre,
                        a.area_nombre,
                        (u_creo.usuario_nom1 || ' ' || u_creo.usuario_ape1) as usuario_creo_nombre
                    FROM avpc_entrenamiento e
                    LEFT JOIN avpc_capacitacion c ON e.entrenamiento_capacitacion_id = c.capacitacion_id
                    LEFT JOIN avpc_compania comp ON e.entrenamiento_compania_id = comp.app_id
                    LEFT JOIN avpc_instructor inst ON e.entrenamiento_instructor_id = inst.instructor_id
                    LEFT JOIN avpc_usuario u_inst ON inst.instructor_usuario_id = u_inst.usuario_id
                    LEFT JOIN avpc_area_entrenamiento a ON e.entrenamiento_area_id = a.area_id
                    LEFT JOIN avpc_usuario u_creo ON e.entrenamiento_usuario_creo = u_creo.usuario_id
                    WHERE {$where}
                    ORDER BY e.entrenamiento_fecha_inicio DESC";
                        
                $data = self::fetchArray($sql);
            }

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Entrenamientos obtenidos correctamente',
                'data' => $data
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los entrenamientos',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['entrenamiento_id'];

            // VALIDACIONES IGUALES AL GUARDAR
            if (empty($_POST['entrenamiento_capacitacion_id']) || $_POST['entrenamiento_capacitacion_id'] == 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar una capacitación'
                ]);
                exit;
            }

            if (empty($_POST['entrenamiento_compania_id']) || $_POST['entrenamiento_compania_id'] == 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar una compañía'
                ]);
                exit;
            }

            if (empty($_POST['entrenamiento_instructor_id']) || $_POST['entrenamiento_instructor_id'] == 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar un instructor'
                ]);
                exit;
            }

            if (empty($_POST['entrenamiento_area_id']) || $_POST['entrenamiento_area_id'] == 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar un área de entrenamiento'
                ]);
                exit;
            }

           
       // FECHA INICIO OBLIGATORIA
            if (empty($_POST['entrenamiento_fecha_inicio'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La fecha de inicio es obligatoria'
                ]);
                exit;
            }

            // FECHA FIN OBLIGATORIA
            if (empty($_POST['entrenamiento_fecha_fin'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La fecha de fin es obligatoria'
                ]);
                exit;
            }

            // CONVERTIR FORMATO DE FECHAS PARA INFORMIX
            if (!empty($_POST['entrenamiento_fecha_inicio'])) {
                // Convertir de 2025-06-06T12:03 a 2025-06-06 12:03
                $_POST['entrenamiento_fecha_inicio'] = str_replace('T', ' ', $_POST['entrenamiento_fecha_inicio']);
            }
            
            if (!empty($_POST['entrenamiento_fecha_fin'])) {
                // Convertir de 2025-06-26T12:03 a 2025-06-26 12:03
                $_POST['entrenamiento_fecha_fin'] = str_replace('T', ' ', $_POST['entrenamiento_fecha_fin']);
            }

            // VALIDAR QUE FECHA FIN SEA MAYOR A FECHA INICIO
            $fechaInicio = strtotime($_POST['entrenamiento_fecha_inicio']);
            $fechaFin = strtotime($_POST['entrenamiento_fecha_fin']);
            
            if ($fechaFin <= $fechaInicio) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La fecha de fin debe ser posterior a la fecha de inicio'
                ]);
                exit;
            }

            $fechaInicio = strtotime($_POST['entrenamiento_fecha_inicio']);
            $fechaFin = strtotime($_POST['entrenamiento_fecha_fin']);
            
            if ($fechaFin <= $fechaInicio) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La fecha de fin debe ser posterior a la fecha de inicio'
                ]);
                exit;
            }

            $_POST['entrenamiento_observaciones'] = trim(htmlspecialchars($_POST['entrenamiento_observaciones'] ?? ''));

            //ACTUALIZAR ENTRENAMIENTO
            $entrenamiento = Entrenamiento::find($id);
            $entrenamiento->sincronizar([
                'entrenamiento_capacitacion_id' => $_POST['entrenamiento_capacitacion_id'],
                'entrenamiento_compania_id' => $_POST['entrenamiento_compania_id'],
                'entrenamiento_instructor_id' => $_POST['entrenamiento_instructor_id'],
                'entrenamiento_area_id' => $_POST['entrenamiento_area_id'],
                'entrenamiento_fecha_inicio' => $_POST['entrenamiento_fecha_inicio'],
                'entrenamiento_fecha_fin' => $_POST['entrenamiento_fecha_fin'],
                'entrenamiento_estado' => $_POST['entrenamiento_estado'],
                'entrenamiento_observaciones' => $_POST['entrenamiento_observaciones'],
                'entrenamiento_situacion' => 1
            ]);

            $resultado = $entrenamiento->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Entrenamiento modificado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el entrenamiento',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            Entrenamiento::EliminarEntrenamiento($id);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'El entrenamiento ha sido eliminado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al eliminar el entrenamiento',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    // MÉTODOS AUXILIARES PARA OBTENER DATOS DE LOS SELECTS
    public static function obtenerCapacitacionesAPI()
    {
        try {
            $sql = "SELECT capacitacion_id, capacitacion_nombre FROM avpc_capacitacion WHERE capacitacion_situacion = 1 ORDER BY capacitacion_nombre";
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

    public static function obtenerCompaniasAPI()
    {
        try {
            $sql = "SELECT app_id, app_nombre_largo FROM avpc_compania WHERE app_situacion = 1 ORDER BY app_nombre_largo";
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

    public static function obtenerInstructoresAPI()
    {
        try {
            $sql = "SELECT 
                        i.instructor_id, 
                        (u.usuario_nom1 || ' ' || u.usuario_ape1) as instructor_nombre
                    FROM avpc_instructor i
                    INNER JOIN avpc_usuario u ON i.instructor_usuario_id = u.usuario_id
                    WHERE i.instructor_situacion = 1 
                    ORDER BY u.usuario_nom1";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Instructores obtenidos correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener los instructores',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function obtenerAreasAPI()
    {
        try {
            $sql = "SELECT area_id, area_nombre FROM avpc_area_entrenamiento WHERE area_situacion = 1 ORDER BY area_nombre";
            $data = self::fetchArray($sql);

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Áreas obtenidas correctamente',
                'data' => $data
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al obtener las áreas',
                'detalle' => $e->getMessage(),
            ]);
        }
    }
}