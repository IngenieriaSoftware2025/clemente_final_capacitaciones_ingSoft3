<?php

namespace Controllers;

use MVC\Router;

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
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
<<<<<<< HEAD
=======
=======
class AppController {
    public static function index(Router $router){
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
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
<<<<<<< HEAD
}
=======
<<<<<<< HEAD
}
=======
}


//docker exec -it dockerApps sh
//lnav /var/log/apache2/error.log
//tail -f /var/log/apache2/error.log
>>>>>>> d2a8c3cdb20f7cff9ab25a7a1b6a528ae532b3db
>>>>>>> 50ced8adf869d8399e84c958de3886b846d5d675
