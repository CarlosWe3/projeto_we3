<?php
/**
 * 
 * Classe de criptografia.
 * @author Carlos
 *
 */
class criptografia {
	
	function Randomizar($iv_len)
	{
	    $iv = '';
	    while ($iv_len-- > 0) {
	        $iv .= chr(mt_rand() & 0xff);
	    }
	    return $iv;
	}
	
	/**
	 * 
	 * Função para encriptar string de acordo com uma chave.
	 * @param string $texto - String a ser criptografada.
	 * @param string $senha - Chave de seguran�a para criptografar.
	 * @param int $iv_len - Quantidade de vezes que ser� passado pela criptografia.
	 * @return Texto codificado.
	 */
	static function encriptar($texto, $iv_len = 16)
	{
		$senha = CHAVE;
	    $texto .= "\x13";
	    $n = strlen($texto);
	    if ($n % 16) $texto .= str_repeat("\0", 16 - ($n % 16));
	    $i = 0;
	    $Enc_Texto = self::Randomizar($iv_len);
	    $iv = substr($senha ^ $Enc_Texto, 0, 512);
	    while ($i < $n) {
	        $Bloco = substr($texto, $i, 16) ^ pack('H*', md5($iv));
	        $Enc_Texto .= $Bloco;
	        $iv = substr($Bloco . $iv, 0, 512) ^ $senha;
	        $i += 16;
	    }
	    return base64_encode($Enc_Texto);
	}
	
	/**
	 * 
	 * Função para encriptar string de acordo com uma chave.
	 * @param string $Enc_Texto - Texto criptografado
	 * @param string $senha - Chave de seguran�a para criptografar.
	 * @param int $iv_len - Quantidade de vezes que ser� passado pela criptografia.
	 * @return Texto desenvriptado.
	 */
	static function desencriptar($Enc_Texto, $iv_len = 16)
	{
		$senha = CHAVE;
	    $Enc_Texto = base64_decode($Enc_Texto);
	    $n = strlen($Enc_Texto);
	    $i = $iv_len;
	    $texto = '';
	    $iv = substr($senha ^ substr($Enc_Texto, 0, $iv_len), 0, 512);
	    while ($i < $n) {
	        $Bloco = substr($Enc_Texto, $i, 16);
	        $texto .= $Bloco ^ pack('H*', md5($iv));
	        $iv = substr($Bloco . $iv, 0, 512) ^ $senha;
	        $i += 16;
	    }
	    return preg_replace('/\\x13\\x00*$/', '', $texto);
	}
	
	/**
	 * 
	 * Cria criptografia com Salt para dificultar a resolução da senha
	 * @param STRING $texto
	 * @return HASH md5
	 */
	static function md5($texto) {
		return md5($texto).SALT;
	}
	
}