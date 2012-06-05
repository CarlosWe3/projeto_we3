<?php
/**
 * 
 * Classe que gerencia cookies, todo cookie criado por aqui terá criptografia conforme a chave informada em configurações
 * @author Carlos
 *
 */
class cookie {
	
	function __construct() 
	{}
	/**
	 * 
	 * Metodo para criar novo cookie
	 * @param string $nome - indice do cookie
	 * @param string/int/boolean $valor - Valor do cookie
	 * @param int $tempo - Tempo de vida do cookie, em segundos.
	 * @return boolean - retorno true caso de sucesso e false caso de erros
	 */
	static function setCookie($nome,$valor,$tempo=3600) 
	{
		if(setcookie($nome,criptografia::encriptar($valor), time()+$tempo)) {
			return true;
		} else {
			return false;
		}
		
	}
	/**
	 * 
	 * Metodo para destruir um cookie
	 * @param string $nome - indice do cookie
	 * @return boolean - retorno true caso de sucesso e false caso de erros
	 */
	static function destroiCookie($nome) 
	{
		if (setcookie($nome,'',time()-3600)) {
			return true;
		} else {
			return false;
		}
		
	}
	/**
	 * 
	 * Metodo para capturar o valor de um cookie.
	 * @param string $nome - indice do cookie
	 * @return string - valor que estava guardado no cookie
	 */
   	static function getCookie($nome) 
   	{
		return criptografia::desencriptar($_COOKIE[$nome]);
	}
}