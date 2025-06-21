<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Instructor;

class InstructorController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('instructor/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // USUARIO OBLIGATORIO
        if (empty($_POST['instructor_usuario_id'])) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Debe seleccionar un usuario'
            ]);
            exit;
        }

        // GRADO OBLIGATORIO
        $_POST['instructor_grado'] = strtoupper(trim(htmlspecialchars($_POST['instructor_grado'])));
        $cantidad_grado = strlen($_POST['instructor_grado']);
        if ($cantidad_grado < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El grado debe tener al menos 2 caracteres'
            ]);
            exit;
        }

        // ARMA OBLIGATORIA
        $_POST['instructor_arma'] = strtoupper(trim(htmlspecialchars($_POST['instructor_arma'])));
        $cantidad_arma = strlen($_POST['instructor_arma']);
        if ($cantidad_arma < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El arma debe tener al menos 2 caracteres'
            ]);
            exit;
        }

        // AÑOS DE SERVICIO OBLIGATORIO
        $_POST['instructor_anos_servicio'] = filter_var($_POST['instructor_anos_servicio'], FILTER_VALIDATE_INT);
        if ($_POST['instructor_anos_servicio'] < 0 || $_POST['instructor_anos_servicio'] > 50) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Los años de servicio deben estar entre 0 y 50'
            ]);
            exit;
        }

        // VERIFICAR USUARIO EXISTENTE COMO INSTRUCTOR
        $verificarUsuarioExistente = self::fetchArray("SELECT instructor_id FROM avpc_instructor WHERE instructor_usuario_id = '{$_POST['instructor_usuario_id']}' AND instructor_situacion = 1");
        if (count($verificarUsuarioExistente) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Este usuario ya está registrado como instructor'
            ]);
            exit;
        }

        $_POST['instructor_fecha_registro'] = '';

        $instructor = new Instructor($_POST);
        $resultado = $instructor->crear();

        if ($resultado['resultado'] == 1) {
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Instructor registrado correctamente',
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar el instructor',
                'datos' => $_POST,
                'instructor' => $instructor,
            ]);
            exit;
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["i.instructor_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "i.instructor_fecha_registro >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "i.instructor_fecha_registro <= '{$fecha_fin}'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT i.*, u.usuario_nom1, u.usuario_nom2, u.usuario_ape1, u.usuario_ape2 
                    FROM avpc_instructor i 
                    LEFT JOIN avpc_usuario u ON i.instructor_usuario_id = u.usuario_id 
                    WHERE $where 
                    ORDER BY i.instructor_fecha_registro DESC";
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

    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['instructor_id'];

            // USUARIO OBLIGATORIO
            if (empty($_POST['instructor_usuario_id'])) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Debe seleccionar un usuario'
                ]);
                exit;
            }

            // GRADO OBLIGATORIO
            $_POST['instructor_grado'] = strtoupper(trim(htmlspecialchars($_POST['instructor_grado'])));
            $cantidad_grado = strlen($_POST['instructor_grado']);
            if ($cantidad_grado < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El grado debe tener al menos 2 caracteres'
                ]);
                exit;
            }

            // ARMA OBLIGATORIA
            $_POST['instructor_arma'] = strtoupper(trim(htmlspecialchars($_POST['instructor_arma'])));
            $cantidad_arma = strlen($_POST['instructor_arma']);
            if ($cantidad_arma < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El arma debe tener al menos 2 caracteres'
                ]);
                exit;
            }

            // AÑOS DE SERVICIO OBLIGATORIO
            $_POST['instructor_anos_servicio'] = filter_var($_POST['instructor_anos_servicio'], FILTER_VALIDATE_INT);
            if ($_POST['instructor_anos_servicio'] < 0 || $_POST['instructor_anos_servicio'] > 50) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Los años de servicio deben estar entre 0 y 50'
                ]);
                exit;
            }

            // VERIFICAR USUARIO EXISTENTE COMO INSTRUCTOR (excluyendo el instructor actual)
            $verificarUsuarioExistente = self::fetchArray("SELECT instructor_id FROM avpc_instructor WHERE instructor_usuario_id = '{$_POST['instructor_usuario_id']}' AND instructor_situacion = 1 AND instructor_id != {$id}");
            if (count($verificarUsuarioExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Este usuario ya está registrado como instructor'
                ]);
                exit;
            }

            //ACTUALIZAR INSTRUCTOR
            $instructor = Instructor::find($id);
            $instructor->sincronizar([
                'instructor_usuario_id' => $_POST['instructor_usuario_id'],
                'instructor_grado' => $_POST['instructor_grado'],
                'instructor_arma' => $_POST['instructor_arma'],
                'instructor_anos_servicio' => $_POST['instructor_anos_servicio'],
                'instructor_situacion' => 1
            ]);

            $resultado = $instructor->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Instructor modificado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el instructor',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            Instructor::EliminarInstructor($id);

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
}