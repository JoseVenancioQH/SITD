<?php
error_reporting(E_ALL);
class categoria extends MySQL
{
  	var $evento = 0;
    var $iddeporte = 0;
    var $nombrecat = '';
    var $anoinicio = 0;
    var $anofin = 0;
    var $listapruebas = '';
	var $rama = '';	
	var $evento_text = '';
	var $deporte_text = '';
	var $idusuario = 0;	
	var $id = 0;
	var $statususuario = '';
	var $deportes_lista = '';	
	var $evento_lista = '';
	
function utf8($string_utf8)
	{
	         $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	         $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
			 return	$string_utf8_res;
	}
	
function grabarCategoria()
	{	         	         
	    $consulta = parent::consulta("SELECT id_categoria FROM cat_categoria WHERE id_evento = ".$this->evento." and id_deporte = ".$this->iddeporte." and ucase(cat_categoria_nombre) = ucase('".$this->utf8($this->nombrecat)."') and cat_categoria_rangoinicio = ".$this->anoinicio." and cat_categoria_rangofin = ".$this->anofin." and cat_categoria_rama = '".$this->utf8($this->rama)."'");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros==0)
		{ 
		 $consulta = parent::consulta("INSERT INTO cat_categoria (id_evento,id_deporte,cat_categoria_nombre,cat_categoria_rangoinicio,cat_categoria_rangofin,cat_categoria_prueba,cat_categoria_rama,id_usuario) VALUES (".$this->evento.",".$this->iddeporte.",'".$this->utf8($this->nombrecat)."',".$this->anoinicio.",".$this->anofin.",'".$this->utf8(substr($this->listapruebas, 0, strlen($this->listapruebas) - 1))."','".$this->utf8($this->rama)."',".$this->idusuario.")");
		 
		 
		 return (mysql_affected_rows() > 0)?"<tr id=\"".mysql_insert_id()."\"><td>$this->evento_text</td><td>$this->deporte_text</td><td>$this->rama</td><td>$this->nombrecat</td><td>$this->anoinicio</td><td>$this->anofin</td><td>".str_replace(",",", ",substr($this->listapruebas, 0, strlen($this->listapruebas) - 1))."</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminarcategoria('".mysql_insert_id()."');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editarcategoria('".mysql_insert_id()."');\" src=\"../img/icons/edit.png\" /></td></tr>":"no";	
	    }
		else
	    {
		 return "no";
		}	
	}		
	
	function eliminarCategoria()
	  {
	   	 	   
	   $consulta = parent::consulta("DELETE FROM cat_categoria WHERE id_categoria = ".$this->id);
	   return (mysql_affected_rows() > 0)?"si":"no";
	  }
	  
	function editarCategoria()
	  {			 
	  
	   $consulta = parent::consulta("UPDATE cat_categoria SET id_evento = ".$this->evento.",id_deporte = ".$this->iddeporte.",cat_categoria_nombre = '".$this->utf8($this->nombrecat)."',cat_categoria_rangoinicio = ".$this->anoinicio.",cat_categoria_rangofin =".$this->anofin.",cat_categoria_prueba ='".$this->utf8(substr($this->listapruebas, 0, strlen($this->listapruebas) - 1))."',cat_categoria_rama = '".$this->utf8($this->rama)."',id_usuario = ".$this->idusuario." WHERE id_categoria = ".$this->id);		   	 
	   return (mysql_affected_rows() > 0)?"si":"no";
	  }	   
	  
	function GenerarLista_Categorias()
	  {		    
	    if($this->evento_lista != '') $eventobusca = ' And e.id_evento = '.$this->evento_lista; else $eventobusca = '';
		if($this->deportes_lista != '') $deportesbusca = ' And d.id_deporte = '.$this->deportes_lista; else $deportesbusca = '';
		if($this->statususuario != 'desactivado') $usuario = ' Where c.id_usuario = '.$this->idusuario; else $usuario = '';		
		
	    $consulta = parent::consulta("SELECT * FROM (cat_categoria as c INNER JOIN reg_eventos as e ON c.id_evento = e.id_evento".$eventobusca.") inner join cat_deportes as d ON d.id_deporte = c.id_deporte".$deportesbusca.$usuario." ORDER BY c.id_categoria DESC,e.id_evento,d.id_deporte");		
		
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		 {			
			while($categoria = parent::fetch_array($consulta))
			{
				  extract($categoria);
				  $cat_categoria_prueba = str_replace(",",", ",$cat_categoria_prueba);
				  echo "<tr id=\"$id_categoria\"><td>$reg_eventos_nombre</td><td>$cat_deporte_nombre</td><td>$cat_categoria_rama</td><td>$cat_categoria_nombre</td><td>$cat_categoria_rangoinicio</td><td>$cat_categoria_rangofin</td><td>$cat_categoria_prueba</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminarcategoria('$id_categoria');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editarcategoria('$id_categoria');\" src=\"../img/icons/edit.png\" /></td></tr>";				  
			}			
		 }		
	 }	  
	  
}

?>