<?php
class postController extends controller {
	public $auth = false;
	
	function __construct() {
		parent::__construct();
		$this->loadModel();
	}
	
	function index() {
		$this->_view->titulo = "Trabalho";
		$this->loadModel('status');
		$res = $this->status->procura('todos');
		$this->_view->consulta = $res;
	}
	
	
	
	
}