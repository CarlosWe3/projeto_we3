<?php
/**
 * Framework WE3 Online
 * Desenvolvido por: Carlos Augusto Gartner  e Danial Salvagni
 * 
 * @copyright WE3 Online
 * @version 1.0.0.0
 * 
 * Antes de iniciar o sistema e necessario configurar alguns locais para rodar perfeitamente:
 * 
 * 1- Configurar o "BASE_URL" abaixo, para a url do projeto ex: http://www.projeto.com.br/site
 * 2- Configurar as demais configurações em -> /vendor/config/config.php
 * 
 */
// inicia a sessao
session_start();
// Configuracoes de pastas
defined('DS') 			? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') 	? null : define('SITE_ROOT', realpath(dirname(__FILE__)) . DS);
defined('LIB_PATH') 	? null : define('LIB_PATH', SITE_ROOT . 'lib' . DS);
defined('APP_PATH') 	? null : define('APP_PATH', SITE_ROOT . 'app' . DS);
defined('CONFIG_PATH')  ? null : define('CONFIG_PATH', SITE_ROOT . 'vendor' . DS . 'config' . DS);
defined('SYS_PATH') 	? null : define('SYS_PATH', SITE_ROOT . 'vendor' . DS . 'system' . DS);
defined('MEDIA_PATH') 	? null : define('MEDIA_PATH', SITE_ROOT . 'media' . DS);
defined('BASE_URL') 	? null : define('BASE_URL', 'http://server01:8082/we3dc/we3_framework/WE3_Framework/');

try {
	// configuracoes
	require_once CONFIG_PATH . 'config.php';
	
	// Dispatcher
	require_once SYS_PATH . 'request.php';
    require_once SYS_PATH . 'bootstrap.php';
	
	// Conexao
	require_once SYS_PATH . 'conexao.php';
	
	// Helpers
	require_once SYS_PATH . 'criptografia.php';
	require_once LIB_PATH . 'cookie/cookie.php';
	require_once LIB_PATH . 'session/session.php';
	require_once SYS_PATH . 'auth.php';
	
	// Sistema
	require_once SYS_PATH . 'controller.php';
    require_once SYS_PATH . 'model.php';
    require_once SYS_PATH . 'view.php';
    
    // inicia sistema
    bootstrap::run(new request());
	
} catch (Exception $e) {
	
    echo $e->getMessage();
    
}
