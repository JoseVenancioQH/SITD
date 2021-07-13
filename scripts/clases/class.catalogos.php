<?php
error_reporting(E_ALL);
class catalogos extends MySQL
{
        var $acronimo = "";				
		var $descripcion = "";				
		var $claves = "";
		var $id = 0;														
						
	function cambiarStatus()
	{
	    $consulta = parent::consulta("UPDATE usuarios SET status='".$this->status."' WHERE id_usuario = ".$this->id);
		return (mysql_affected_rows() > 0) ? true : false;
	}
		
	function mostrarMaterial()
	{
		$consulta = parent::consulta("SELECT * FROM cat_material");		
		$num_total_registros = parent::num_rows($consulta);		
		if($num_total_registros>0)
		{
				$i=0;
				while($material = parent::fetch_array($consulta))
				{
				    
					extract($material);										
					if($i%2==0){$flag = "class=\"pintalo\"";}else{$flag = " ";}
					  print "
					  <tr id=\"tr$id_material\" $flag>
						<td>$cat_material_clavemat</td>
						<td>$cat_material_desmat</td>						
						<td><img style=\"cursor:pointer;\" onclick=\"editar_material($id_material);\" alt=\"Editar Material\" src=\"../img/icons/edit.png\" /></td>
										
					  </tr>
					  ";
					  $i++;					
				}								
		}
		else
		{
			print "<div id=\"notice-tabla\" class=\"notice\"><img style=\"vertical-align:middle; margin-left:10px;\" alt=\"info\" src=\"../img/icons/info.png\" />No existen materiales aun</div>";
		}
	}	
	
	
	function mostrarFamiliaMaterial()
	{
		$consulta = parent::consulta("SELECT * FROM cat_familiamaterial");		
		$num_total_registros = parent::num_rows($consulta);		
		if($num_total_registros>0)
		{
				$i=0;
				while($familiamaterial = parent::fetch_array($consulta))
				{
				    
					extract($familiamaterial);										
					if($i%2==0){$flag = "class=\"pintalo\"";}else{$flag = " ";}
					  print "
					  <tr id=\"tr$id_familiamaterial\" $flag>
						<td>$cat_familiamaterial_acronimo</td>
						<td>$cat_familiamaterial_descripcion</td>						
						<td>$cat_familiamaterial_claves</td>						
						<td><img style=\"cursor:pointer;\" onclick=\"editar_familiamaterial($id_familiamaterial);\" alt=\"Editar Familia Material\" src=\"../img/icons/edit.png\" /></td>
										
					  </tr>
					  ";
					  $i++;					
				}
		print "<div class=\"notice\" style=\"visibility:hidden;\"></div>";										
		}
		 else
		 {
			print "<div class=\"notice\"><img style=\"vertical-align:middle; margin-left:10px; \" alt=\"info\" src=\"../img/icons/info.png\" >No existen familia de materiales aun</div>";
		 }
	}



function grabarFamiliaMaterial()
	{	         
			 $consulta = parent::consulta("INSERT INTO cat_familiamaterial (cat_familiamaterial_acronimo, cat_familiamaterial_descripcion, cat_familiamaterial_claves) VALUES ('".$this->acronimo."','".$this->descripcion."','".$this->claves."')");
		 return (mysql_affected_rows() > 0)?mysql_insert_id():"no";
	
	}	


function actualizarFamiliaMaterial()
	{			 
			 $consulta = parent::consulta("UPDATE cat_familiamaterial SET cat_familiamaterial_acronimo = '".$this->acronimo."', cat_familiamaterial_descripcion = '".$this->descripcion."', cat_familiamaterial_claves='".$this->claves."'  WHERE id_familiamaterial = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?mysql_update_id():"no";
	
	}	
}

?>