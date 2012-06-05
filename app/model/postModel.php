<?php
class postModel extends model {
	
	public $tabela = "we3_post";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function listagem_total() {
		$sql = "SELECT * FROM {$this->tabela}";
		return $this->conn->query($sql);
	}
	
	
}