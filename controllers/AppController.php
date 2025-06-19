<?php

namespace Controllers;

use MVC\Router;

class AppController
{
//     public static function index(Router $router)
//     {
//         session_start();
        
//         if (!isset($_SESSION['user']) || !isset($_SESSION['usuario_id'])) {
//             header('Location: /clemente_final_capacitaciones_ingSoft3/');
//             exit;
//         }
        
//         $router->render('pages/index', []);
//     }
// }




public static function index(Router $router){
        $router->render('login/index', [], $layout = 'layout/layoutlogin');
        //renderizar para la pagina principal, para que aparezaca
    }

    public static function testLogin() {
    getHeadersApi();
    echo json_encode([
        'codigo' => 1,
        'mensaje' => 'Test exitoso'
    ]);
}
}