<?php
error_reporting(E_ALL);
class deportes extends MySQL
{
    var $nombre = "";
	var $iddeporte = 0;
	var $id = 0;				
	var $tabla = '';
						
	function utf8($string_utf8)
	{
	         $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	         $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
			 return	$string_utf8_res;
	}						
	
    function grabarDeportes()
	{	
	    $consulta = parent::consulta("SELECT id_deporte FROM cat_deportes WHERE ucase(cat_deporte_nombre) = ucase('".$this->utf8($this->nombre)."')");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros==0)
		{ 
		 $consulta = parent::consulta("INSERT INTO cat_deportes (cat_deporte_nombre) VALUES ('".$this->utf8($this->nombre)."')");
		 return (mysql_affected_rows() > 0)?"<tr id=\"".mysql_insert_id()."\"><td>".$this->utf8($this->nombre)."</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminardeporte('".mysql_insert_id()."');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editardeporte('".mysql_insert_id()."');\" src=\"../img/icons/edit.png\"/></td></tr>":"no";	
	    }
		else
	    {
		 return "no";
		}	
	}	  
	
	function GenerarLista_Deportes()
	{		    
	    $consulta = parent::consulta("SELECT * FROM cat_deportes ORDER BY id_deporte");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		 {			
			while($deportes = parent::fetch_array($consulta))
			{
				  extract($deportes);
				  echo "<tr id=\"$id_deporte\"><td>$cat_deporte_nombre</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminardeporte('$id_deporte');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editardeporte('$id_deporte');\" src=\"../img/icons/edit.png\"/></td></tr>";	
			}			
		 }		
	}	  
	
	
	 function eliminarDeportes()
	  {
	   	 	   
	   $consulta = parent::consulta("DELETE FROM cat_deportes WHERE id_deporte = ".$this->id);
	   return (mysql_affected_rows() > 0)?"si":"no";	   
	  }
	 
	 function editarDeportes()
	  {			 
			 $consulta = parent::consulta("UPDATE cat_deportes SET cat_deporte_nombre = '".$this->utf8($this->nombre)."'  WHERE id_deporte = ".$this->id);		 
	   return (mysql_affected_rows() > 0)?"si":"no";
	   //"<tr id=\"".$this->id."\"><td>".$this->utf8($this->nombre)."</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminardeporte('".$this->id."');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editardeporte('".$this->id."');\" src=\"../img/icons/edit.png\"/></td></tr>"
	  }	 
	  
	  
}

?>