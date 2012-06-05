<?php
/**
 * Classe Request
 * Pega o $_GET['url'], limpa de possíveis caracteres indesejados.
 * A partir do $_GET['url'], especifica o Controller, o Método e os 
 * Argumentos e alimenta as propriedades privadas relacionadas.
 */
class request {

    private $_controller;
    private $_method;
    private $_args;

    function __construct() {
        //Pega o $_GET['url']
        if (isset($_GET['url'])) {
            //Limpa o que tem no get
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            //Divide a url
            $url = explode('/', $url);
            //executa a limpeza do $url pelo FILTER_SANITIZE_URL
            $url = array_filter($url);
            
            //alimenta as propriedades
            $this->_controller = strtolower(array_shift($url));
            $this->_method = strtolower(array_shift($url));
            $this->_args = $url;
        }

        if (!$this->_controller) {
            //Caso não haja o controller na URL, alimenta com o default
            //definido na global DEFAULT
            $this->_controller = 'index';
        }
        if (!$this->_method) {
            //Caso não haja o método, alimenta com o index 
            $this->_method = 'index';
        }
        if (!isset($this->_args)) {
            //Caso não haja argumentos, alimenta com um array() vazio.
            $this->_args = array();
        }
    }

    //Retorna o controller
    public function getController() {
        return $this->_controller;
    }

    //Retorna o método
    public function getMethod() {
        return $this->_method;
    }
    
    //Retorna os argumentos
    public function getArgs() {
        return $this->_args;
    }

}