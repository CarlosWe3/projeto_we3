<?php
class indexController extends controller {
	
	private static $model;
	//public $auth = true;
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->loaderLib("html");
		$this->_view->titulo = "Teste";	
		
		
	}

}	