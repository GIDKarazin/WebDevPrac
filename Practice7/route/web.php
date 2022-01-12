<?php
class Route{
    function loadPage($db, $controllerName, $actionName = 'index'){
        include_once 'app/Controllers/IndexController.php';
        include_once 'app/Controllers/UsersController.php';

        $controller = match ($controllerName) {
            'users' => new UsersController($db),
            default => new IndexController($db),
        };

        // Starting the desired method
        $controller->$actionName();
    }
}
