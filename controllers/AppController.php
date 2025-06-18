<?php

namespace Controllers;

use MVC\Router;

class AppController {
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


//docker exec -it dockerApps sh
//lnav /var/log/apache2/error.log
//tail -f /var/log/apache2/error.log