<?php
/**
 * 
 * Classe com funções para gerar alguns itens em HTML
 * @author Carlos
 *
 */
class html {	
	/**
	 * @param: $arquivo, pode ser valor unico ou um array com varios.
	 * Gera link de arquivo css
	 */
   static function css($arquivo,$dir=false) {
   		$dir = $dir ? $dir : BASE_URL."app/webroot";
   		
  		$returno = '';
	    if (is_array($arquivo)) {
	    	if (!empty($arquivo)) {
				foreach ($arquivo as $nom_arquivo_css) {
					if (substr($nom_arquivo_css, 0, 4) == 'http') {
	    				$link_arquivo = $nom_arquivo_css;
	    			} else {
	    				$link_arquivo = "{$dir}/css/{$nom_arquivo_css}";	 
	    			}
					$returno .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"{$link_arquivo}\" />\n\t\t";
					exit($returno);
				}
				return $returno;
			} 
			
	    } else {
	    	$link_arquivo = "{$dir}/css/{$arquivo}";	 
	    	$returno .= "<link type=\"text/css\" rel=\"stylesheet\" href=\"{$link_arquivo}\" />\n\t\t";
	    	return $returno;
	    }
    }
	
	
	/**
	 * @param: $arquivo, pode ser valor unico ou um array com varios.
	 * Gera link de arquivo script
	 */
   static function script($arquivo, $dir=false) {
   		$dir = $dir ? $dir : BASE_URL."app/webroot";
   		
    	$return = '';   	
	    if (is_array($arquivo)) {
	    	if (!empty($arquivo)) {
				foreach ($arquivo as $linkCss) {
					if (substr($linkCss, 0, 4) == 'http') {
	    				$linkArquivo = $linkCss;
	    			} else {
	    				$linkArquivo = "{$dir}/js/{$linkCss}";
	    			}	
					$return .= "<script type=\"text/javascript\" src=\"{$linkArquivo}\"></script>\n";
				}
				return $return;
			} else {
				if (substr($arquivo, 0, 4) == 'http') {
    				$linkArquivo = $arquivo;
    			} else {
    				$linkArquivo = "{$dir}/js/{$arquivo}";
    			}	 			
				$return .= "<script type=\"text/javascript\" src=\"{$linkArquivo}\"></script>\n";
			}
	    }
    }
	
	
	/**
	 * Cria metatag
	 * @param: $arr (Array) cont�m os dados para metatags
	 */
    static function meta($arr) {
    	$meta = "<meta%s/>"; 
		$metaDados = '';		
    	if (is_array($arr)) {
	    	foreach ($arr as $metaName => $metaValor) {
				switch ($metaName) {
					case 'name':
						$metaDados .= " name=\"{$metaValor}\"";
						break;
						
					case 'content':
						$metaDados .= " content=\"{$metaValor}\"";
						break;
						
					case 'http-equiv':
						$metaDados .= " http-equiv=\"{$metaValor}\"";
						break;
				}	
			}
			return sprintf($meta,$metaDados)."\n";
		}
			
    }
	
	/**
	 * @author: Carlos Augusto Gartner <carlos@we3online.com.br>
	 * @param: $valor: (String) valor do botao
	 * @param: $link: (String) Link, por padr�o vazio
	 * @param: $arrAttr: (Array) Array contendo v�rios atributos
	 * Funcao para gerar um botao
	 */
    static function button($valor,$link='',$arrAttr=array()) {
    	$but_ini = "<button %s%s>"; 
    	$but_ini_sem_attr = "<button>"; 
		$but_fim = "</button>"; 
		$retorno = '';
		$atributos = '';
		$target = "window.location.href='%s'";
		
    	if (is_array($arrAttr)) {
	    	foreach ($arrAttr as $attrName => $attrValor) {
	    		if ($attrName == 'target' and $attrValor == '__blank' ) {
	    			$target = "window.open('%s')";
	    		}else {
	    			$atributos .= " {$attrName}=\"{$attrValor}\"";
	    		}	    			
			}
			if ($link) {
			$retorno = sprintf($but_ini,'onclick="'.sprintf($target,$link).'"',$atributos);
			}
			return ($retorno ? $retorno : $but_ini_sem_attr). $valor . $but_fim ."\n\t\t";
		}
			
    }
	
	/**
	 * @author: Carlos Augusto Gartner <carlos@we3online.com.br>
	 * @param: $arr array contendo as linhas
	 * Funcao usada para gerar um link em html
	 */
    static function a($objLink,$htmllink) {
    	$dir = BASE_URL; // Root do View
    	$link_ini = "<a%s>"; 
		$link_fim = "</a>";
		$$parLink = '';
		
	    if (is_array($htmllink)) {
	    	foreach ($htmllink as $mlink => $vLink) {
	    		
				switch ($mlink) {
					case 'href':
						$parLink .= " href=\"{$vLink}\"";
						break;
						
					case 'class':
						$parLink .= " class=\"{$vLink}\"";
						break;
						
					case 'id':
						$parLink .= " id=\"{$vLink}\"";
						break;
						
					case 'title':
						$parLink .= " title=\"{$vLink}\"";
						break;
				}	
			}
			return sprintf($link_ini,$parLink).$objLink.$link_fim."\n\t\t";
	    } else {
	    	
	    }
    }
	
	/**
	 * @author: Carlos Augusto Gartner <carlos@we3online.com.br>
	 * @param: $string contendo o valor.
	 * Funcao usada para gerar titulo de header.
	 */
    static function titulo($string) {
    	return sprintf("<title>%s</title>\n\t\t",$string);
    }
	
	/**
	 * @author: Carlos Augusto Gartner <carlos@we3online.com.br>
	 * @param: $string contendo o valor.
	 * Funcao usada para gerar titulo imagem.
	 */
   static function img($url,$arrAttr) {
    	$img = "<img src=\"%s\" %s />"; 
		$attrImg = '';
		if (is_array($arrAttr)) {
	    	foreach ($arrAttr as $imgAttr => $imgValor) {
				$attrImg = $imgAttr."=\"{$imgValor}\"";
			}
			return sprintf($img,$url,$attrImg)."\n\t\t";
	    } else {
	    	return false;
	    }
		
    }
	
}