<?php
/**
 * Arquivo controlador do aplicativo
 * @author Carlos Augusto Gartner
 */
class controller {
	/**
	 * Variavel contendo os htmls da visualizacao
	 * @var objeto
	 */
	public $_view;
	/**
	 * Controller usado na aplicacao
	 * @var objeto
	 */
	public $_request;
	/**
	 * 
	 * Contem informacoes e acoes para autenticacao.
	 * Seu valor e setado caso o metodo esteja com a variavel da classe controller setada como 'true'
	 * @var objeto
	 */
	public $_auth;
	
	/**
	 * 
	 * Variavel que define se o metodo/controller necessitará de autenticação.
	 * @var boolean
	 */
	public $auth = false;
	
	public function __construct() 
	{
		$this->_request = new Request();
		$this->_view = new View($this -> _request);
		
		// Verifica caso necessite algum login
		if ($this->auth) {
			self::autenticaSessao();
		}
	}
	/**
	 * 
	 * Classe responsavel para carregar o modulo na memoria
	 * @param string $model - Nome do modulo.
	 */
	function loadModel($model=false) 
	{	
		// Caso o nome do model não seja informado, pega o nome do controller	
		if (!$model) {
			$model = $this->_request->getController();
		}
		// Caso os model sejam chamados por Array
		if (is_array($model)) {
			foreach ($model as $mod) {
				$model_path = APP_PATH . "model" . DS . $mod . "Model.php";
				if (is_readable($model_path)) {
					require($model_path);
					$nomeModelo = $mod."Model";
					$this->$mod = new $nomeModelo();
				} else {
					throw new Exception("Model não pode ser carregado  em ".$model_path);
				}
			}
		} else { // Caso esteja chamando um unico arquivo
			$model_path = APP_PATH . "model" . DS . $model . "Model.php";
			if (is_readable($model_path)) {
				require($model_path);
				$nomeModelo = $model."Model";
				$this->$model = new $nomeModelo();
			} else {
				throw new Exception("Model não pode ser carregado  em ".$model_path);
			}
		}
	}
	
	/**
	 * 
	 * Função para redirecionamento
	 * @param $caminho, pode ser array, contendo o redirecionamento separado por controlle, actions e valores.
	 */
	function redir($caminho) 
	{
    	if (is_array($caminho)) {
    		$controller = false;
    		$action = '';
    		$valor  = '';
    		if (isset($caminho['controller'])) {
    			$controller = $caminho['controller'];
    		}
    		if (isset($caminho['action'])) {
    			$action = "/" . $caminho['action'];
    		}
    		if (isset($caminho['value'])) {
    			$valor = "/" . $caminho['value'];
    		}
    		if ($controller) {
    			header("Location: ". BASE_URL . $controller . $action . $valor);
    			exit;
    		}
    	} else if (is_string($caminho)) {
    		header("Location: ".$caminho);
    		exit;
    	}
    }
    
    /**
     * 
     * Carrega biblioteca para utiliza-la, e carrega lib no controller com o nome "_"<nome>, ex: $this->_html
     * @param string/array $name - Poder ser apenas um arquivo ou varios passando um array ex: array('email','formulario','html');
     */
    function loaderLib($name) 
    {
    	if (!$name) {
    		throw new Exception("loaderLib:: Nome do lib não definido!");
    		return false;
    	}    	
   		 // Caso sejam chamados por Array, mais que uma lib
		if (is_array($name)) {
			foreach ($name as $lib) {
				$lib_path = LIB_PATH . $lib . DS . $lib . ".php";
				if (is_readable($lib_path)) {
					require($lib_path);
					$this->{"_".$lib} = new $lib();
				} else {
					throw new Exception("Lib não pode ser carregado  em ".$lib_path);
				}
			}
		} else { // Caso esteja chamando um único arquivo
			$lib_path = LIB_PATH . $name . DS . $name . ".php";
			if (is_readable($lib_path)) {
				require($lib_path);
				$this->{"_".$name} = new $name();
			} else {
				throw new Exception("Lib não pode ser carregado  em ".$lib_path);
			}
		}
    }
    
    /**
     * 
     * controller::autenticaSessao() - Executa auteticacao
     */
    public function autenticaSessao() 
    {
    	$this->_auth = new auth();
    }
	
	public function __destruct() 
	{
		if (!$this->_view->_html){
			$this->_view->renderView($this->_request->getMethod());
		}
		echo $this->_view->_html;
	}
	
	
}