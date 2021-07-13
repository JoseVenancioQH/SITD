<?php
error_reporting(E_ALL);
class modalidad extends MySQL
{
    var $nombre = "";
	var $idmodalidad = 0;
	var $id = 0;				
	var $tabla = '';
						
	function utf8($string_utf8)
	{
	         $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	         $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
			 return	$string_utf8_res;
	}						
	
    function grabarModalidad()
	{	
	    $consulta = parent::consulta("SELECT id_modalidad FROM cat_modalidad WHERE ucase(cat_modalidad_nombre) = ucase('".$this->utf8($this->nombre)."')");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros==0)
		{ 
		 $consulta = parent::consulta("INSERT INTO cat_modalidad (cat_modalidad_nombre) VALUES ('".$this->utf8($this->nombre)."')");
		 return (mysql_affected_rows() > 0)?"<tr id=\"".mysql_insert_id()."\"><td>".$this->utf8($this->nombre)."</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminarmodalidad('".mysql_insert_id()."');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editarmodalidad('".mysql_insert_id()."');\" src=\"../img/icons/edit.png\"/></td></tr>":"no";	
	    }
		else
	    {
		 return "no";
		}	
	}	  
	
	function GenerarLista_Modalidad()
	{		    
	    $consulta = parent::consulta("SELECT * FROM cat_modalidad ORDER BY id_modalidad");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		 {			
			while($deportes = parent::fetch_array($consulta))
			{
				  extract($deportes);
				  echo "<tr id=\"$id_modalidad\"><td>$cat_modalidad_nombre</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminarmodalidad('$id_modalidad');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editarmodalidad('$id_modalidad');\" src=\"../img/icons/edit.png\"/></td></tr>";	
			}			
		 }		
	}	  
	
	
	 function eliminarModalidad()
	  {
	   	 	   
	   $consulta = parent::consulta("DELETE FROM cat_modalidad WHERE id_modalidad = ".$this->id);
	   return (mysql_affected_rows() > 0)?"si":"no";	   
	  }
	 
	 function editarModalidad()
	  {			 
			 $consulta = parent::consulta("UPDATE cat_modalidad SET cat_modalidad_nombre = '".$this->utf8($this->nombre)."'  WHERE id_modalidad = ".$this->id);		 
	   return (mysql_affected_rows() > 0)?"si":"no";
	   //"<tr id=\"".$this->id."\"><td>".$this->utf8($this->nombre)."</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminardeporte('".$this->id."');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editardeporte('".$this->id."');\" src=\"../img/icons/edit.png\"/></td></tr>"
	  }	 
	  
	  
}

?>