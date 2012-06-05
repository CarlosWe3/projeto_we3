<?php
	/**
	 * Classe que reune metodos para facilitar trabalhos com data.
	 * @author Carlos Augusto Gartner
	 */
	class data {
		
		function __construct() 
		{}
		
		/**
		 * Transforma data no formato dd/mm/aaaa para formato mysql aaaa-mm-dd
		 * @param $d = Cont�m string da data no formato dd/mm/aaaa
		 */
		static function dataMysql($d) {
			if ($d) {
				$dTemp = explode('/',$d);
				$dia   = $dTemp[0];
				$mes   = $dTemp[1];
				$ano   = $dTemp[2];
				
				return sprintf('%s-%s-%s',$ano,$mes,$dia);
			} else {
				return NULL;
			}
		}
		/**
		 * Transforma data no formato dd/mm/aaaa hh:mm para formato mysql aaaa-mm-dd hh:mm
		 * @param $d = Cont�m string da data no formato dd/mm/aaaa hh:mm
		 */
		static function dataHoraMysql($d) {
			if ($d) {
				$hTemp = explode(' ',$d);
				$dTemp = explode('/',$hTemp[0]);
				$dia   = $dTemp[0];
				$mes   = $dTemp[1];
				$ano   = $dTemp[2];
				$hora  = $hTemp[1];
				
				return sprintf('%s-%s-%s %s',$ano,$mes,$dia,$hora);
			} else {
				return NULL;
			}
		}
		/**
		 * Transforma datas para formato Brasileiro
		 * @param $d = Cont�m string da data no formato dd/mm/aaaa hh:mm ou Timestamp
		 */
		static function data($d) {
			// Caso for formato unix
			if (is_int($d)) {
				return date('d/m/Y H:i:s',$d);
				exit;
			}
			// Caso for uma string
			if ($d) {
				$dTemp = explode('-',$d);
				$dia   = $dTemp[2];
				$mes   = $dTemp[1];
				$ano   = $dTemp[0];
				
				return sprintf('%s/%s/%s',$dia,$mes,$ano);
			} else {
				return NULL;
			}
		}
		/**
		 * Transforma datas para formato Brasileiro quando for unix
		 * @param $d = Cont�m string da data no formato Unix
		 */
		static function dataTimeStamp($d) {
				
			if ($d) {
				return date('d/m/Y H:i:s',(int)$d);
				exit;
			}
				
		}
		/**
		 * Calcula diferen�a de tempo em horas entre duas datas
		 * @param $d1 = Cont�m string da data no formato Unix
		 * @param $d2 = Cont�m string da data no formato Unix
		 */
		static function tempoPercorrido($d1,$d2) {
			$unix_data1 = $d1;
			$unix_data2 = $d2;
			
			$nHoras   = ($unix_data2 - $unix_data1) / 3600;
			$nMinutos = (($unix_data2 - $unix_data1) % 3600) / 60;
			$nSegundos = ((($unix_data2 - $unix_data1) % 3600) %60);
			
			return sprintf('%02d:%02d:%02d', $nHoras, $nMinutos,$nSegundos);
		}
		/**
		 * Monta tempo em horas, minutos e segundos
		 * @param $timestamp = Formato Unix
		 */
		static function tempoUnix($timestamp) {
			
			$nHoras   = ($timestamp) / 3600;
			$nMinutos = (($timestamp) % 3600) / 60;
			$nSegundos = ((($timestamp) % 3600) %60);
			
			$nMinutos = str_replace('-', '', $nMinutos);
			$nSegundos = str_replace('-', '', $nSegundos);
			
			return sprintf('%02d:%02d:%02d', $nHoras, $nMinutos,$nSegundos);
		}
		
		/**
		 * Transforma data no formato mysql aaaa-mm-dd hh:mm para segundos unix
		 * @param $d = Cont�m int da data no formato Unix
		 */
		static function dataHoraMysql2unix($d) {
			if ($d) {
				$hTemp = explode(' ',$d);
				$dTemp = explode('/',$hTemp[0]);
				$hTmp  = explode(':',$hTemp[1]);
				$dia   = $dTemp[0];
				$mes   = $dTemp[1];
				$ano   = $dTemp[2];
				$hora  = $hTmp[0];
				$min   = $hTmp[1];
				$seg   = $hTmp[2];
				
				// Pega tempo em segundos.
				$unix = mktime($hora,$min,$seg,$mes,$dia,$ano);
				
				return $unix;
			} else {
				return NULL;
			}
		}
		
		/**
		 * Transforma data no formato dd/mm/AAAA HH:mm:ss para unix
		 * @param $d = Cont�m int da data no formato dd/mm/aaaa
		 */
		static function data2unix($d) {
			if ($d) {
			
				$hTemp = explode(' ',$d);
				$dTemp = explode('/',$hTemp[0]);
				$hTmp  = explode(':',$hTemp[1]);
				$dia   = $dTemp[0];
				$mes   = $dTemp[1];
				$ano   = $dTemp[2];
				$hora  = $hTmp[0];
				$min   = $hTmp[1];
				$seg   = $hTmp[2];
				
				// Pega tempo em segundos.
				$unix = mktime($hora,$min,$seg,$mes,$dia,$ano);
				
				return $unix;
			} else {
				return NULL;
			}
		}
		
		static function ultimoDiaMes($newData){
	      /*Desmembrando a Data*/
	      list($newDia, $newMes, $newAno) = explode("/", $newData);
	      return date("d/m/Y", mktime(0, 0, 0, $newMes+1, 0, $newAno));
	   }
	   
		static function primeiroDiaMes($newData){
			//var_dump($newData); exit;
	      /*Desmembrando a Data*/
	      list($newDia, $newMes, $newAno) = explode("/", $newData);
	      return date("d/m/Y", mktime(0, 0, 0, $newMes, 1, $newAno));
	   }
		

	}
	