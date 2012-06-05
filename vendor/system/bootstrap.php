<?php
/**
 * Classe Bootstrap
 * Gerencia os caminhos dos controllers e instancia o controller.
 * Define o método e o argumento.
 */
class bootstrap {

    public static function run(Request $request) {
        //Recebe o objeto REQUEST - classe Request
        //Define o controller
        $controller = $request->getController() . 'Controller';
        //Define o caminho do controller
        $path_controller = SITE_ROOT . 'app' . DS . 'controller' . DS . $controller . '.php';
        //Define o método e os argumentos
        $method = $request->getMethod();
        $args = $request->getArgs();
        
        //Verifica se o arquivo do controller é legível
        if (is_readable($path_controller)) {
            //Inclui o controller
            require_once $path_controller;
            //Instancia o controller
            $controller = new $controller;
            
            if (!is_callable(array($controller, $method))) {
                //Caso não seja possível chamar a função $method,
                //usa index por default.
                $method = 'index';
            }
            if (isset($args)) {
                //Caso tenha argumentos, executa o controller e método com os args
                call_user_func_array(array($controller, $method), $args);
            } else {
                //Caso não haja argumentos, executa somenteo o controller e método.
                call_user_func(array($controller, $method));
            }
        } else {
            //Retorna uma exception caso não encontre o arquivo do controller.
            throw new Exception("Controller não encontrado: {$path_controller}");
        }
    }

}