<?php
error_reporting(E_ALL);
class empresa extends MySQL
{    						
	function cambiarStatus()
	 {
	    $consulta = parent::consulta("UPDATE usuarios SET status='".$this->status."' WHERE id_usuario = ".$this->id);
		return (mysql_affected_rows() > 0) ? true : false;
	 }
		
	function mostrarEmpresa()
	 {
		$consulta = parent::consulta("SELECT * FROM tb_empresa");
		$num_total_registros = parent::num_rows($consulta);	
		if($num_total_registros>0)
		{						
		        print "<option value=\"\"  selected=\"selected\">- Selecciona Empresa -</option>";
				while($empresa = parent::fetch_array($consulta))
				{				
					extract($empresa);				
					print "<option value=\"".$id_empresa."\" >".$tb_empresa_nombre."</option>";				
				}										
		}
		else
		{
			print "";
		}
	 }
	 
   function grabarUsuarios()
	{
	         if($this->municipio != '')
			 {$var_municipio = ', id_municipio';
			  $val_municipio = ",".$this->municipio;}
			 else
			 {$var_municipio = ', id_municipio';
			  $val_municipio = ", null";}
			 $consulta = parent::consulta("INSERT INTO usuarios (nombre, username, password, rol, privilegios, fecha_registro".$var_municipio.") VALUES ('".$this->nombreusuario."','".$this->nombre."','".$this->pass."', '".$this->rolusuario."', '".$this->privilegios."',NOW()".$val_municipio.")");
		 return (mysql_affected_rows() > 0)?mysql_insert_id():"no";	
	}	


function actualizarUsuarios()
	{			 
	       if($this->municipio != '')
			 {$var_municipio = ', id_municipio';
			  $val_municipio = " = ".$this->municipio;}
			 else
			 {$var_municipio = ', id_municipio';
			  $val_municipio = " = null";}
			  
			 $consulta = parent::consulta("UPDATE usuarios SET nombre = '".$this->nombreusuario."', username = '".$this->nombre."', password='".$this->pass."', rol = '".$this->rolusuario."' , privilegios = '".$this->privilegios."'".$var_municipio.$val_municipio ."  WHERE id_usuario = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?mysql_insert_id():"no";
	
	}	
}

?>