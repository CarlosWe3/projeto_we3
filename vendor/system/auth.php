<?php
/**
 * 
 * Classe de autenticacao de sistema por usuarios.
 * @author Carlos
 */
class auth {
	/**
	 * 
	 * Codigo do usuario ativo
	 * @var int - usuario ativo
	 */
	public $usuario_ativo = false;
	/**
	 * 
	 * Nome do controller que o usuario será redirecionado caso não esteja autenticado.
	 * @var string
	 */
	private $controller = "login";
	/**
	 * 
	 * Nome da action que o usuário sera redirecionado, caso seja index deixar vazio
	 * @var string
	 */
	private $action = "";	
	/**
	 * 
	 * Classe construtora que verifica se o usuario esta ativo 
	 */
	public function __construct() {
		// Verifica se nao exite alguma sessao criada.
		if (isset($_SESSION['_cod_usuario'])) {
			$this->usuario_ativo = session::getSession('_cod_usuario');
		}
		// Verifica se nao
		if (isset($_COOKIE['_cod_usuario'])) {
			$this->usuario_ativo = cookie::getCookie('_cod_usuario');
		}
		// 
		if (!$this->usuario_ativo) {
			header("Location: ".BASE_URL . "login");
			exit;
		}
	}
	
}