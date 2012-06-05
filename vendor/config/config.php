<?php
/**
 *  Dados para a conexao
 */
defined("USER_CON") 	? null : define("USER_CON", "root");
defined("SERVIDOR_CON") ? null : define("SERVIDOR_CON", "localhost");
defined("SENHA_CON") 	? null : define("SENHA_CON", "WE3SERVER01");
defined("BD_CON") 		? null : define("BD_CON", "carlos");
defined("TIPO_CON") 	? null : define("TIPO_CON", "mysql");
defined("CONEXAO") 		? null : define("CONEXAO", true);
/**
 * Chave de segunranca que nada mais é que uma frase secreta, que será usada como chave para criar as criptografias de sessions,cookies e registros no Banco de dados.
 */
defined("CHAVE") 		? null : define("CHAVE", "WE3online.com.br");
/**
 * Salt para criptar junto as senhas dificultando metodos de desencriptacao.
 */
defined("SALT") 		? null : define("SALT", "HAUEH89S84S@$2#435231]@A");
/**
 * Idioma utilizado no sistema
 */
setlocale (LC_ALL, 'pt-BR');
/**
 * Tempo de vida de cookies
 */
defined("COOKIE_TIME") ? null : define("COOKIE_TIME", 3600); // Um dia
/**
 * Fuso horário
 */
date_default_timezone_set("America/Sao_Paulo");
/**
 * Exibicao de erros
 * Comentar quando o sistema estiver publicado
 */
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL);
