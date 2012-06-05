<?php
/**
 * 
 * Classe de conexão em PDO
 * @author Carlos Augusto Gatner
 *
 */
class conexao {
	/**
	 * 
	 * Objeto da conexao
	 * @var Objeto
	 */
	public $conn;
	/**
	 * 
	 * Codificação da conexão
	 * @var String
	 * @example utf8
	 */
	public $encode = 'utf8';
	
	/**
	 * Pega as informações do arquivo de configuracao e monta a nova conexao
	 */
	public function __construct() {
		// Pega dados do arquivo de configuracao.
		$tip_bd 	= TIPO_CON;
		$host 		= SERVIDOR_CON;
		$bd			= BD_CON;
		$usuario 	= USER_CON;
		$senha 		= SENHA_CON;
		$encode 	= $this->encode;
		$Conn 		= false;
		
		switch ($tip_bd) {
			case 'mysql':			
			try {
				// Conexao de mysql.
				$Conn = new PDO("mysql:host={$host}; dbname={$bd}", "{$usuario}", "{$senha}");
				$Conn -> exec("SET CHARACTER SET {$encode}");
				$this->conn = $Conn;
			} catch (PDOException $e) {
            	echo 'Erro na conexão: ' . $e->getMessage();
                exit;
            }
			break;
		}
	}
	
	/**
	 * 
	 * Captura a conexao instacianda no __construct
	 */
	public function getConexao() {
		return $this->conn;
	}
	
	/**
	 * 
	 * Destroi a conexao
	 */
	public function __destruct() {
		unset($this->conn);
	}
	
}