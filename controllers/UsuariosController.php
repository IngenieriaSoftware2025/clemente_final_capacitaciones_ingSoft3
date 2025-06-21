<?php

namespace Controllers;

use Exception;
use MVC\Router;
use Model\ActiveRecord;
use Model\Usuarios;

class UsuariosController extends ActiveRecord
{
    public static function renderizarPagina(Router $router)
    {
        $router->render('usuarios/index', []);
    }

    public static function guardarAPI()
    {
        getHeadersApi();

        // PRIMER NOMBRE OBLIGATORIO
        $_POST['usuario_nom1'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_nom1']))));
        $cantidad_nombre = strlen($_POST['usuario_nom1']);
        if ($cantidad_nombre < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El primer nombre debe tener más de 1 caracter'
            ]);
            exit;
        }

        // SEGUNDO NOMBRE OBLIGATORIO
        $_POST['usuario_nom2'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_nom2']))));
        $cantidad_nombre2 = strlen($_POST['usuario_nom2']);
        if ($cantidad_nombre2 < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El segundo nombre debe tener más de 1 caracter'
            ]);
            exit;
        }

        // PRIMER APELLIDO OBLIGATORIO
        $_POST['usuario_ape1'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_ape1']))));
        $cantidad_apellido = strlen($_POST['usuario_ape1']);
        if ($cantidad_apellido < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El primer apellido debe tener más de 1 caracter'
            ]);
            exit;
        }

        // SEGUNDO APELLIDO OBLIGATORIO
        $_POST['usuario_ape2'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_ape2']))));
        $cantidad_apellido2 = strlen($_POST['usuario_ape2']);
        if ($cantidad_apellido2 < 2) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El segundo apellido debe tener más de 1 caracter'
            ]);
            exit;
        }

        // TELÉFONO OBLIGATORIO
        $_POST['usuario_tel'] = filter_var($_POST['usuario_tel'], FILTER_SANITIZE_NUMBER_INT);
        if (strlen($_POST['usuario_tel']) != 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El teléfono debe tener 8 números'
            ]);
            exit;
        }

        // DIRECCIÓN OBLIGATORIA
        $_POST['usuario_direc'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_direc']))));
        $cantidad_direccion = strlen($_POST['usuario_direc']);
        if ($cantidad_direccion < 5) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La dirección debe tener al menos 5 caracteres'
            ]);
            exit;
        }

        // DPI OBLIGATORIO
        $_POST['usuario_dpi'] = trim(htmlspecialchars($_POST['usuario_dpi']));
        if (strlen($_POST['usuario_dpi']) != 13) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La cantidad de dígitos del DPI debe ser igual a 13'
            ]);
            exit;
        }

        // VERIFICAR DPI EXISTENTE
        $verificarDpiExistente = self::fetchArray("SELECT usuario_id FROM avpc_usuario WHERE usuario_dpi = '{$_POST['usuario_dpi']}' AND usuario_situacion = 1");
        if (count($verificarDpiExistente) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe un usuario registrado con este DPI'
            ]);
            exit;
        }

        // CORREO OBLIGATORIO
        $_POST['usuario_correo'] = filter_var($_POST['usuario_correo'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($_POST['usuario_correo'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'El correo electrónico no es válido'
            ]);
            exit;
        }

        // VERIFICAR CORREO EXISTENTE
        $verificarCorreoExistente = self::fetchArray("SELECT usuario_id FROM avpc_usuario WHERE usuario_correo = '{$_POST['usuario_correo']}' AND usuario_situacion = 1");
        if (count($verificarCorreoExistente) > 0) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Ya existe un usuario registrado con este correo electrónico'
            ]);
            exit;
        }

        // CONTRASEÑA OBLIGATORIA
        if (strlen($_POST['usuario_contra']) < 8) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'La contraseña debe tener al menos 8 caracteres'
            ]);
            exit;
        }

        // CONFIRMAR CONTRASEÑA OBLIGATORIO
        if ($_POST['usuario_contra'] !== $_POST['confirmar_contra']) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Las contraseñas no coinciden'
            ]);
            exit;
        }

        $_POST['usuario_token'] = uniqid();
        $dpi = $_POST['usuario_dpi'];
        $_POST['usuario_fecha_creacion'] = '';
        $_POST['usuario_fecha_contra'] = '';

        // FOTOGRAFÍA OPCIONAL
        if (isset($_FILES['usuario_fotografia']) && $_FILES['usuario_fotografia']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['usuario_fotografia'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileError = $file['error'];

            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Extensiones permitidas
            $allowed = ['jpg', 'jpeg', 'png'];

            if (!in_array($fileExtension, $allowed)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 2,
                    'mensaje' => 'Solo puede cargar archivos JPG, PNG o JPEG',
                ]);
                exit;
            }

            if ($fileSize >= 2000000) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 2,
                    'mensaje' => 'La imagen debe pesar menos de 2MB',
                ]);
                exit;
            }

            if ($fileError === 0) {
                $ruta = "storage/fotosUsuarios/$dpi.$fileExtension";

                $directorioFotos = __DIR__ . "/../../storage/fotosUsuarios/";
                if (!file_exists($directorioFotos)) {
                    mkdir($directorioFotos, 0755, true);
                }

                $subido = move_uploaded_file($file['tmp_name'], __DIR__ . "/../../" . $ruta);

                if ($subido) {
                    $_POST['usuario_fotografia'] = $ruta;
                } else {
                    http_response_code(500);
                    echo json_encode([
                        'codigo' => 0,
                        'mensaje' => 'Error al subir la fotografía',
                    ]);
                    exit;
                }
            } else {
                http_response_code(500);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Error en la carga de fotografía',
                ]);
                exit;
            }
        } else {
            $_POST['usuario_fotografia'] = '';
        }

        $_POST['usuario_contra'] = password_hash($_POST['usuario_contra'], PASSWORD_DEFAULT);
        $usuario = new Usuarios($_POST);
        $resultado = $usuario->crear();

        if ($resultado['resultado'] == 1) {
            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuario registrado correctamente',
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al registrar el usuario',
                'datos' => $_POST,
                'usuario' => $usuario,
            ]);
            exit;
        }
    }

    public static function buscarAPI()
    {
        try {
            $fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
            $fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

            $condiciones = ["usuario_situacion = 1"];

            if ($fecha_inicio) {
                $condiciones[] = "usuario_fecha_creacion >= '{$fecha_inicio}'";
            }

            if ($fecha_fin) {
                $condiciones[] = "usuario_fecha_creacion <= '{$fecha_fin}'";
            }

            $where = implode(" AND ", $condiciones);
            $sql = "SELECT * FROM avpc_usuario WHERE $where ORDER BY usuario_fecha_creacion DESC";
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

    public static function modificarAPI()
    {
        getHeadersApi();

        try {
            $id = $_POST['usuario_id'];

            // PRIMER NOMBRE OBLIGATORIO
            $_POST['usuario_nom1'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_nom1']))));
            $cantidad_nombre = strlen($_POST['usuario_nom1']);
            if ($cantidad_nombre < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El primer nombre debe tener más de 1 caracter'
                ]);
                exit;
            }

            // SEGUNDO NOMBRE OBLIGATORIO
            $_POST['usuario_nom2'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_nom2']))));
            $cantidad_nombre2 = strlen($_POST['usuario_nom2']);
            if ($cantidad_nombre2 < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El segundo nombre debe tener más de 1 caracter'
                ]);
                exit;
            }

            // PRIMER APELLIDO OBLIGATORIO
            $_POST['usuario_ape1'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_ape1']))));
            $cantidad_apellido = strlen($_POST['usuario_ape1']);
            if ($cantidad_apellido < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El primer apellido debe tener más de 1 caracter'
                ]);
                exit;
            }

            // SEGUNDO APELLIDO OBLIGATORIO
            $_POST['usuario_ape2'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_ape2']))));
            $cantidad_apellido2 = strlen($_POST['usuario_ape2']);
            if ($cantidad_apellido2 < 2) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El segundo apellido debe tener más de 1 caracter'
                ]);
                exit;
            }

            // TELÉFONO OBLIGATORIO
            $_POST['usuario_tel'] = filter_var($_POST['usuario_tel'], FILTER_SANITIZE_NUMBER_INT);
            if (strlen($_POST['usuario_tel']) != 8) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El teléfono debe tener 8 números'
                ]);
                exit;
            }

            // DIRECCIÓN OBLIGATORIA
            $_POST['usuario_direc'] = ucwords(strtolower(trim(htmlspecialchars($_POST['usuario_direc']))));
            $cantidad_direccion = strlen($_POST['usuario_direc']);
            if ($cantidad_direccion < 5) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La dirección debe tener al menos 5 caracteres'
                ]);
                exit;
            }

            // DPI OBLIGATORIO
            $_POST['usuario_dpi'] = trim(htmlspecialchars($_POST['usuario_dpi']));
            if (strlen($_POST['usuario_dpi']) != 13) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La cantidad de dígitos del DPI debe ser igual a 13'
                ]);
                exit;
            }

            // VERIFICAR DPI EXISTENTE (excluyendo el usuario actual)
            $verificarDpiExistente = self::fetchArray("SELECT usuario_id FROM avpc_usuario WHERE usuario_dpi = '{$_POST['usuario_dpi']}' AND usuario_situacion = 1 AND usuario_id != {$id}");
            if (count($verificarDpiExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otro usuario registrado con este DPI'
                ]);
                exit;
            }

            // CORREO OBLIGATORIO
            $_POST['usuario_correo'] = filter_var($_POST['usuario_correo'], FILTER_SANITIZE_EMAIL);
            if (!filter_var($_POST['usuario_correo'], FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'El correo electrónico no es válido'
                ]);
                exit;
            }

            // VERIFICAR CORREO EXISTENTE (excluyendo el usuario actual)
            $verificarCorreoExistente = self::fetchArray("SELECT usuario_id FROM avpc_usuario WHERE usuario_correo = '{$_POST['usuario_correo']}' AND usuario_situacion = 1 AND usuario_id != {$id}");
            if (count($verificarCorreoExistente) > 0) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Ya existe otro usuario registrado con este correo electrónico'
                ]);
                exit;
            }

            // CONTRASEÑA OBLIGATORIA
            if (strlen($_POST['usuario_contra']) < 8) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'La contraseña debe tener al menos 8 caracteres'
                ]);
                exit;
            }

            // CONFIRMAR CONTRASEÑA OBLIGATORIO
            if ($_POST['usuario_contra'] !== $_POST['confirmar_contra']) {
                http_response_code(400);
                echo json_encode([
                    'codigo' => 0,
                    'mensaje' => 'Las contraseñas no coinciden'
                ]);
                exit;
            }

            // FOTOGRAFÍA OPCIONAL
            $dpi = $_POST['usuario_dpi'];

            // Obtener la fotografía actual del usuario
            $usuarioActual = Usuarios::find($id);
            $fotografiaActual = $usuarioActual->usuario_fotografia;

            if (isset($_FILES['usuario_fotografia']) && $_FILES['usuario_fotografia']['error'] !== UPLOAD_ERR_NO_FILE) {
                $file = $_FILES['usuario_fotografia'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];

                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Extensiones permitidas
                $allowed = ['jpg', 'jpeg', 'png'];

                if (!in_array($fileExtension, $allowed)) {
                    http_response_code(400);
                    echo json_encode([
                        'codigo' => 2,
                        'mensaje' => 'Solo puede cargar archivos JPG, PNG o JPEG',
                    ]);
                    exit;
                }

                if ($fileSize >= 2000000) {
                    http_response_code(400);
                    echo json_encode([
                        'codigo' => 2,
                        'mensaje' => 'La imagen debe pesar menos de 2MB',
                    ]);
                    exit;
                }

                if ($fileError === 0) {
                    $ruta = "storage/fotosUsuarios/$dpi.$fileExtension";

                    $directorioFotos = __DIR__ . "/../../storage/fotosUsuarios/";
                    if (!file_exists($directorioFotos)) {
                        mkdir($directorioFotos, 0755, true);
                    }

                    // Eliminar la fotografía anterior si existe
                    if ($fotografiaActual && file_exists(__DIR__ . "/../../" . $fotografiaActual)) {
                        unlink(__DIR__ . "/../../" . $fotografiaActual);
                    }

                    $subido = move_uploaded_file($file['tmp_name'], __DIR__ . "/../../" . $ruta);

                    if ($subido) {
                        $_POST['usuario_fotografia'] = $ruta;
                    } else {
                        http_response_code(500);
                        echo json_encode([
                            'codigo' => 0,
                            'mensaje' => 'Error al subir la fotografía',
                        ]);
                        exit;
                    }
                } else {
                    http_response_code(500);
                    echo json_encode([
                        'codigo' => 0,
                        'mensaje' => 'Error en la carga de fotografía',
                    ]);
                    exit;
                }
            } else {
                // Si no se subió nueva foto, mantener la actual
                $_POST['usuario_fotografia'] = $fotografiaActual;
            }

            // Encriptar la nueva contraseña
            $_POST['usuario_contra'] = password_hash($_POST['usuario_contra'], PASSWORD_DEFAULT);
            
            //ACTUALIZAR USUARIO
            $usuario = Usuarios::find($id);
            $usuario->sincronizar([
                'usuario_nom1' => $_POST['usuario_nom1'],
                'usuario_nom2' => $_POST['usuario_nom2'],
                'usuario_ape1' => $_POST['usuario_ape1'],
                'usuario_ape2' => $_POST['usuario_ape2'],
                'usuario_tel' => $_POST['usuario_tel'],
                'usuario_direc' => $_POST['usuario_direc'],
                'usuario_dpi' => $_POST['usuario_dpi'],
                'usuario_correo' => $_POST['usuario_correo'],
                'usuario_contra' => $_POST['usuario_contra'],
                'usuario_fotografia' => $_POST['usuario_fotografia'], 
                'usuario_situacion' => 1
            ]);

            $resultado = $usuario->actualizar();

            http_response_code(200);
            echo json_encode([
                'codigo' => 1,
                'mensaje' => 'Usuario modificado correctamente'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'codigo' => 0,
                'mensaje' => 'Error al modificar el usuario',
                'detalle' => $e->getMessage(),
            ]);
        }
    }

    public static function eliminarAPI()
    {
        try {
            $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
            Usuarios::EliminarUsuarios($id);

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