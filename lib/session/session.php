<?php
/**
 * 
 * Classe responsável por gerenciar Sessions.
 * @author Carlos
 *
 */
class session 
{
	function __construct() 
	{}
	
	/**
	 * Cria nova session
	 * @param string $key - Nome do indice da session
	 * @param string $valor - Valor da session (Todo valor pro segurança será encriptado)
	 */
	static public function setSession($key,$valor) 
	{
		if ($key) {
			$_SESSION[$key] = criptografia::encriptar($valor);
			return true;
		} else {
			throw new Exception("É necessário informar o indice da Session para cría-la");
			return false;
		}
		
	}
	
	/**
	 * Captura session existente.
	 * @param string $key - Nome do indice da session
	 */
	static public function getSession($key) 
	{
		return criptografia::desencriptar($_SESSION[$key]);
	}
	
	/**
	 * 
	 * Destroi session especifica
	 * @param string $key - indice da session que será destruida
	 */
	static public function destroySession($key) 
	{
		if ($key) {
			unset($_SESSION[$key]);
			return true;
		} else {
			throw new Exception("É necessário informar o indice da Session para destruí-la");
			return false;
		}
		
	}
	
	/**
	 * 
	 * Destroi todas as sessions ativas no site.
	 */
	static public function destroyAllSessions() 
	{
		session_destroy();
	}
	
	
}