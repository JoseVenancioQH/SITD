<?php
error_reporting(E_ALL);
class fg
{  	    
    function rm_recursive($filepath) {
    if (is_dir($filepath) && !is_link($filepath)) {
        if ($dh = opendir($filepath)) {
            while (($sf = readdir($dh)) !== false) {  
                if ($sf == '.' || $sf == '..') {
                    continue;
                }
                if (!$this->rm_recursive($filepath.'/'.$sf)) {
                    throw new Exception($filepath.'/'.$sf.' could not be deleted.');
                }
            }
            closedir($dh);
        }
        return rmdir($filepath);
    }
    return unlink($filepath);
    }	
	
	function fechalarga($fecha)//[2]->dia, [1]->mes, [0]->año 
	{			
	 $dia=array('domingo','lunes','martes','mi&eacute;rcoles','jueves','viernes','s&aacute;bado');
     $mes=array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
	 
	 $fechalarga = explode('-',$fecha);	//[2]->dia, [1]->mes, [0]->año 
	 $dianum= date("w",mktime(0,0,0,intval($fechalarga[2]), intval($fechalarga[1]), intval($fechalarga[0])));
	
     return $dia[$dianum].' '.$fechalarga[2].', de '.$mes[intval($fechalarga[1])].' del '.$fechalarga[0];
	}
	
	function ordena($campooriginal,$campopivote,$tipoorden)
	{			
		if($campooriginal==$campopivote){
			if($tipoorden=='desc') return 'asc'; else return 'desc';
		}else return 'desc';		
	}
	
	function ordenaimg($campooriginal,$campopivote,$tipoorden)
	{			
		if($campooriginal==$campopivote){
			if($tipoorden=='asc') return '<img src="../images/sort_asc.png" \>'; else return '<img src="../images/sort_desc.png" \>';
		}else return "";		
	}
	
	function totalpaginas($limite,$totalregistros)
	{
		$ban=true;
		$contador=0;
		while ($ban) {
              $totalregistros=$totalregistros-$limite;
			  $contador++;
			  if($totalregistros<=0)$ban=false;
		}		
		return $contador;
	}
	
	function paginar($totalregistro,$limite,$pagina)
	{						
	            $salto_limite="";
				$array_limite=array(5,10,15,20,25,30,50,100,0);
				
				foreach ($array_limite as $limite_paginado){					
				     if($limite_paginado==0)$text_limite="Todos"; else $text_limite=$limite_paginado;
				     if($limite==$limite_paginado)
					     $salto_limite.="<option value=\"".$limite_paginado."\" selected=\"selected\">".$text_limite."</option>";					
					 else
					     $salto_limite.="<option value=\"".$limite_paginado."\">".$text_limite."</option>";
				}			
				
				$salto_limite = "<div class=\"limit\">Mostrar n&uacute;m.
					<select name=\"limit\" id=\"limit\" class=\"inputbox\" size=\"1\">
					".$salto_limite."
					</select>
					</div>";
				
				$start_prev="";$paginado_lista="";$next_end="";$present="";           
				
				if($limite!=0){				
					$totalpaginas = $this->totalpaginas($limite,$totalregistro);
					
					$array_numeros=array();
					$array_paginado=array();
					
					for ($i  = 1; $i <= $totalpaginas; $i++) {
					  $array_numeros[]=$i;
					  $array_paginado[]=($i==1)?0:($i-1)*$limite;
					}											
					
					if($totalpaginas>1){					
						if($pagina>1){$paginaant=$array_paginado[$pagina-2]; $idpaginaant=$array_numeros[$pagina-2];}					
						
						$start_prev=($pagina==1)?"<div class=\"button2-right off\"><div class=\"start\"><span>Inicio</span></div></div><div class=\"button2-right off\"><div class=\"prev\"><span>Anterior</span></div></div>" : "<div class=\"button2-right\"><div class=\"start\"><a href=\"#\" title=\"Inicio\" onclick=\"javascript:paginar(0,1);\">Inicio</a></div></div><div class=\"button2-right\"><div class=\"prev\"><a href=\"#\" title=\"Anterior\" onclick=\"javascript:paginar($paginaant,$idpaginaant);\">Anterior</a></div></div>";
						
						$paginado_lista="";
						for ($i = 1; $i <= $totalpaginas; $i++) {
						  ($i==1)?$paginado=0:$paginado=($i-1)*$limite;
						  if($i==$pagina){$paginado_lista.="<span>$i</span>";}
						  else{$paginado_lista.="<a href=\"#\" title=\"$i\" onclick=\"javascript: paginar($paginado,$i);\">$i</a>";}	
						}					
									
						$paginado_lista="<div class=\"button2-left\"><div class=\"page\">".$paginado_lista."</div></div>";					
						
						$ultimapagina=$array_paginado[$totalpaginas-1];$idultimapagina=$array_numeros[$totalpaginas-1];
						
						if($pagina!=$totalpaginas){$paginasig=$array_paginado[$pagina]; $idpaginasig=$array_numeros[$pagina];}					
						
						$next_end=($pagina==$totalpaginas)?"<div class=\"button2-left off\"><div class=\"next\"><span>Siguiente</span></div></div><div class=\"button2-left off\"><div class=\"end\"><span>Final</span></div></div>" : "<div class=\"button2-left\"><div class=\"next\"><a href=\"#\" title=\"Siguiente\" onclick=\"javascript:paginar($paginasig,$idpaginasig);\">Siguiente</a></div></div><div class=\"button2-left\"><div class=\"end\"><a href=\"#\" title=\"Final\" onclick=\"javascript:paginar($ultimapagina,$idultimapagina);\">Final</a></div></div>";
						
						$present="<div class=\"limit\">P&aacute;gina ".$pagina." de ".$totalpaginas."</div>";
					}				
				}
				
				return $salto_limite.$start_prev.$paginado_lista.$next_end.$present;
	}
}
?>