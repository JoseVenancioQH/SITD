<?php
error_reporting(E_ALL);
class eventos extends MySQL
{
    var $nombre = "";				
	var $coordina = "";				
	var $sede = "";												
	var $caracteristicas = "";																
	var $fechainicio = "";
	var $fechafin = "";
	var $ano = 0;
	var $idevento = 0;
	var $status = "";
		
	function utf8($string_utf8)
	{
	         $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	         $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
			 return	$string_utf8_res;
	}
						
	function cambiarStatus()
	{
		if($this->status=='activo'){$this->status = 'inactivo';}
		if($this->status=='inactivo'){$this->status = 'activo';}
	    $consulta = parent::consulta("UPDATE usuarios SET status='".$this->status."' WHERE id_usuario = ".$this->id);
		return (mysql_affected_rows() > 0) ? true : false;
	}
	
	function cambiarStatusEvento()
	{
		if($this->status=='activo'){$status = 'inactivo';}
		if($this->status=='inactivo'){$status = 'activo';}
	    $consulta = parent::consulta("UPDATE reg_eventos SET reg_eventos_activado='".$status."' WHERE id_evento = ".$this->idevento);
		return $status;
	}
		
	function mostrarUsuarios()
	{
		$consulta = parent::consulta("SELECT * FROM usuarios");		
		$num_total_registros = parent::num_rows($consulta);
		
		$array_privilegios_clave=array('reportes','catalogos','valparticipantes','regparticipantes','asociaciondeportiva','eventos','sistema','gaffetes','credencial','cedulainscripcion','reportesvarios','prueba','equipo','liga','valparactivar','regparregistrar','regparmodificar','asociaciondeportivaregistrar','asociaciondeportivamodificar','eventosregistrar','eventosmodificar','usuarios');
		$array_privilegios=array("Reportes","Catalogos","Validaci&oacute;n de Participantes","Registro de Participantes","Asociaci&oacute;n Deportiva","Eventos","Sistema","Gaffetes","Credencial","Cedula de Inscripci&oacute;n","Reportes Varios","Prueba","Equipo","Liga","Activar Validaci&oacute;n de Participantes","Registro Participante","Modificar Participante","Registrar Asociaci&oacute;n Deportiva","Modificar Asociaci&oacute;n Deportiva","Registrar Evento","Modificar Evento","Usuarios");
		if($num_total_registros>0)
		{
				$i=0;
				$nombresusuarios = '';
				while($usuarios = parent::fetch_array($consulta))
				{
				    
					extract($usuarios);					
					$nombresusuarios = $nombresusuarios.$username.",";
					$privilegiosreal = $privilegios;
					$privilegios = str_replace($array_privilegios_clave,$array_privilegios,$privilegios);
					if($status == 'si') $img_status = 'accept.png'; else $img_status = 'delete.png';
					$privilegios = str_replace(",",", ",$privilegios);
					if($i%2==0){$flag = "class=\"pintalo\"";}else{$flag = " ";}
					  print "
					  <tr id=\"tr$id_usuario\" $flag>
						<td>$username</td>
						<td>$password</td>
						<td>$nombre</td>
						<td title=\"$privilegiosreal\">$privilegios</td>
						<td>$rol</td>
						<td><img style=\"cursor:pointer;\" onclick=\"editar_usuario($id_usuario);\" alt=\"Editar Usuario\" src=\"../img/icons/edit.png\" /></td>
						<td><img id=\"img$id_usuario\" style=\"cursor:pointer;\" onclick=\"cambiar_status($id_usuario);\" alt=\"Estado del Usuario\" src=\"../img/icons/".$img_status."\" /></td>					
					  </tr>
					  ";
					  $i++;					
				}				
				print "<input type=\"hidden\" name=\"nombresusuarios\" id=\"nombresusuarios\" value=\"$nombresusuarios\"/>";
		}
		 else
		 {
			print "<div class=\"notice\"><img style=\"vertical-align:middle; margin-left:10px;\" alt=\"info\" src=\"../img/icons/info.png\" />No existen usuarios aun</div>";
		 }
	}	
	



function grabarEventos()
	{	         
			 $consulta = parent::consulta("INSERT INTO reg_eventos (reg_eventos_nombre, reg_eventos_realizado,reg_eventos_caracteristicas,reg_eventos_fechaini,reg_eventos_fechafin,reg_eventos_ano,reg_eventos_sede,reg_eventos_activado) VALUES ('".$this->utf8($this->nombre)."','".$this->utf8($this->coordina)."','".$this->utf8($this->caracteristicas)."', '".date('Y-m-d', strtotime ($this->fechainicio))."', '".date('Y-m-d', strtotime ($this->fechafin))."',".$this->ano.", '".$this->utf8($this->sede)."', 'activo')");
			 
		 return (mysql_affected_rows() > 0)?mysql_insert_id():"no";	
	}
	
function actualizarEventos()
	{			 
		 $consulta = parent::consulta("UPDATE reg_eventos SET reg_eventos_nombre = '".$this->utf8($this->nombre)."', reg_eventos_realizado = '".$this->utf8($this->coordina)."', reg_eventos_caracteristicas='".$this->utf8($this->caracteristicas)."', reg_eventos_fechaini = '".date('Y-m-d', strtotime ($this->fechainicio))."' , reg_eventos_fechafin = '".date('Y-m-d', strtotime ($this->fechafin))."' , reg_eventos_ano = ".$this->ano." , reg_eventos_sede = '".$this->utf8($this->sede)."'  WHERE id_evento = ".$this->idevento);		 
			 
		 return (mysql_affected_rows() > 0)?mysql_insert_id():"no";	
	}	
	
function actualizarUsuarios()
	{			 
		 $consulta = parent::consulta("UPDATE usuarios SET nombre = '".$this->nombreusuario."', username = '".$this->nombre."', password='".$this->pass."', rol = '".$this->rolusuario."' , privilegios = '".$this->privilegios."'  WHERE id_usuario = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?mysql_insert_id():"no";
	
	}	
}

?>