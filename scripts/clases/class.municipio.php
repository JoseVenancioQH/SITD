<?php
error_reporting(E_ALL);
class municipio extends MySQL
{
    var $nombre = "";
	var $idmunicipio = 0;
	var $id = 0;				
	var $tabla = '';
						
	function utf8($string_utf8)
	{
	         $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	         $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
			 return	$string_utf8_res;
	}						
	
    function grabarMunicipio()
	{	
	    $consulta = parent::consulta("SELECT id_municipio FROM cat_municipio WHERE ucase(cat_municipio_nombre) = ucase('".$this->utf8($this->nombre)."')");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros==0)
		{ 
		 $consulta = parent::consulta("INSERT INTO cat_municipio (cat_municipio_nombre) VALUES ('".$this->utf8($this->nombre)."')");
		 return (mysql_affected_rows() > 0)?"<tr id=\"".mysql_insert_id()."\"><td>".$this->utf8($this->nombre)."</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminarmunicipio('".mysql_insert_id()."');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editarmunicipio('".mysql_insert_id()."');\" src=\"../img/icons/edit.png\"/></td></tr>":"no";	
	    }
		else
	    {
		 return "no";
		}	
	}	  
	
	function GenerarLista_Municipio()
	{		    
	    $consulta = parent::consulta("SELECT * FROM cat_municipio ORDER BY id_municipio");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		 {			
			while($deportes = parent::fetch_array($consulta))
			{
				  extract($deportes);
				  echo "<tr id=\"$id_municipio\"><td>$cat_municipio_nombre</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminarmunicipio('$id_municipio');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editarmunicipio('$id_municipio');\" src=\"../img/icons/edit.png\"/></td></tr>";	
			}			
		 }		
	}	  
	
	
	 function eliminarMunicipio()
	  {
	   	 	   
	   $consulta = parent::consulta("DELETE FROM cat_municipio WHERE id_municipio = ".$this->id);
	   return (mysql_affected_rows() > 0)?"si":"no";	   
	  }
	 
	 function editarMunicipio()
	  {			 
			 $consulta = parent::consulta("UPDATE cat_municipio SET cat_municipio_nombre = '".$this->utf8($this->nombre)."'  WHERE id_municipio = ".$this->id);		 
	   return (mysql_affected_rows() > 0)?"si":"no";
	   //"<tr id=\"".$this->id."\"><td>".$this->utf8($this->nombre)."</td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:eliminardeporte('".$this->id."');\" src=\"../img/icons/delete.png\" /></td><td><img style=\"vertical-align:middle; cursor:pointer;\" onclick = \"javascript:editardeporte('".$this->id."');\" src=\"../img/icons/edit.png\"/></td></tr>"
	  }	 
	  
	  
}

?>