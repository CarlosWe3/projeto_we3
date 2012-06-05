<?php
/**
 * WE3 Online - FrameWork
 * Classe modelo de comunicaçao do banco de dados.
 * @author Carlos Augusto Gartner
 *
 */
class model {
	/**
	 * Nome da tabela em questão -> Definido em vendor/config/config.php
	 * @var String
	 */
	public $tabela;
	/**
	 * Nome do banco de dados -> Definido em vendor/config/config.php
	 * @var String
	 */
	public $banco_dados;
	/**
	 * Dados de acesso ao banco de dados -> Definido em vendor/config/config.php
	 * @var Array()
	 */
	public $acessos = array();
	/**
	 * Nome da coluna da chave primaria, que é capturado na função setChavePrimaria()
	 * @var String
	 */
	public $chave_primaria;
	/**
	 * Objeto da conexao com o Banco de dados
	 * @var Objeto
	 */
	public $conn;
	/**
	 * Informações da tabela
	 * @var Array()
	 */
	public $tabela_info = array();
	/**
	 * 
	 * Código da chave primária
	 * @var Int - código
	 */
	public $id;
	
	public function __construct() {
		$this->tabela = $this->tabela;
		$this->banco_dados = BD_CON;
		// Caso a conexao definida em definido em vendor/config/config.php
		if (CONEXAO==true) {
			
			$conexao = new conexao(); 
			$this -> conn = $conexao -> getConexao();
			
			self::setChavePrimaria();
			self::setInfosTabela();
		}		
	}
	/**
	 * Função criada para pegar a chave primária do campo.
	 */
	protected function setChavePrimaria() {
		if (!$this->banco_dados) {
			throw new Exception("Banco de dados não definido. Linha: 15 - Classe Model");
		}
		if (!$this->tabela) {
			throw new Exception("Tabela do model não definida definido. Linha: 18 - Classe Model");
		}
		$sql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$this->banco_dados}' AND TABLE_NAME = '{$this->tabela}' AND COLUMN_KEY = 'PRI'";
		$pre = $this->conn->prepare($sql);
		$pre -> execute();
		$res = $pre -> fetch();
		$this->chave_primaria = $res['COLUMN_NAME'];
	}
	
	/**
	 * Pega as informações da tabela do model.
	 */
	protected function setInfosTabela() {
		$sql = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$this->banco_dados}' AND TABLE_NAME = '{$this->tabela}'";
		$pre = $this->conn->prepare($sql);
		unset($sql);
		$pre -> execute();
		$res= $pre -> fetchAll();
		$i = 0;
		foreach ($res as $ln)
		{ 
			$this->tabela_info[$i]['nome']		 = $ln['COLUMN_NAME'];
			$this->tabela_info[$i]['tamanho'] 	 = $ln['CHARACTER_MAXIMUM_LENGTH'];
			$this->tabela_info[$i]['tipo'] 		 = $ln['DATA_TYPE'];
			$this->tabela_info[$i]['posicao']  	 = $ln['ORDINAL_POSITION'];
			$this->tabela_info[$i]['null'] 		 = $ln['IS_NULLABLE'];
			$this->tabela_info[$i]['index'] 	 = $ln['COLUMN_KEY'];
			$this->tabela_info[$i]['comentario'] = $ln['COLUMN_COMMENT'];
			++$i;
		}
		unset($pre,$res,$ln,$i);
		return true;
	}
	
	/**
	 * Classe de pesquisa padrao do framework
	 * @param array $Condicoes - Contem condicoes dos parametros
	 * @param string $tipo - 'todos' - Todos os registros
	 * 						 'unico' - apenas um registro
	 * 						 'ultimo' - ultimo registro
	 * 						 'primeiro' - primeiro registro
	 */
	function procura($tipo='todos',$condicoes = array(),$debug=false) {
		// Caso tenha id informado
		if ($this -> id){
			if ($this->chave_primaria){
				$condicoes[$this->chave_primaria] = $this -> id;
			} else {
				exit('ID definido, porém não informado a chave primaria no Model '.$this->tabela);
			}
			
		}
		
		// Define tipo
		switch ($tipo){
			case 'todos':
				$funcaoBusca = "fetchAll";
				break;
			
			case 'unico':
				$funcaoBusca = "fetch";
				break;
				
			case 'ultimo':
				$funcaoBusca = 'fetch';
				$condicoes['order by'] = $this->chave_primaria.' DESC';
				if (!$this->chave_primaria)
					die('Não informado a chave primaria no Model '.$this->tabela);
				break;
				
			case 'primeiro':
				$funcaoBusca = 'fetch';
				$condicoes['order by'] = $this->chave_primaria.' ASC';
				if (!$this->chave_primaria)
					die('Não informado a chave primaria no Model '.$this->tabela);
				break;
		}
		
		// Monta condicoes
		$cond = self::montaCondicoes($condicoes);
		
		try {
			$sql = "SELECT * FROM {$this->tabela} {$cond}";
			
			
			$pre = $this -> conn -> prepare($sql);
			$pre -> execute();
			
			if ($debug){
				$erro = $pre->errorInfo();
				echo "
					<strong>Erro na query:</strong><br />
					Sql -> {$sql} <br />
					Erro Código -> {$erro[0]}<br />
					Erro Número -> {$erro[1]}<br />
					Erro Info -> {$erro[2]}<br />
				";
			}
			
			$retorno = $pre -> {$funcaoBusca}();
			return $retorno;
			
		} catch (PDOException $e) {
			echo "
				<strong>Erro na query:</strong><br />
				Sql -> {$sql} <br />
				Erro Info -> {$e->getMessage()}<br />
			";
		}
	}
	
	/**
	 * Metodo que monta exibicao das condicoes de uma consulta.
	 * @param array $Condicoes - Array contendo as condicoes da query.
	 * @return String com condicoes montadas.
	 */
	function montaCondicoes($Condicoes) {
		$retorno = false;
		$i = 1;
		if (is_array($Condicoes)) {
			foreach ($Condicoes as $cond => $valor) {
				switch ($cond){
					case 'limit':
						$retorno .= " LIMIT ".$valor;
						break;
						
					case 'order by':
						$retorno .= " ORDER BY ".$valor;
						break;
						
					case 'group by':
						$retorno .= " GROUP BY ".$valor;
						break;
						
					case 'custom':
						$retorno .= ($i > 1 ? " AND " : " WHERE ").$valor;
						break;
											
					default:
						$retorno .= ($i > 1 ? " AND " : " WHERE ").$cond." = ".(is_string($valor) ? "'{$valor}'" : "{$valor	}");
						++$i;
						break;
				}
				
			}
			
		}
		unset($i,$cond,$valor);
		return $retorno;		
	}
}