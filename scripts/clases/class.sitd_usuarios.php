<?php
error_reporting(E_ALL);
class usuarios extends MySQL
{   
    var $pagina = '';
	var $paginado = '';
	var $limite = '';
	var $filtro = '';
	var $campo = '';
	var $orden = '';
	
	var $municipio = '';
	var $accion = '';
	var $privilegio = '';
	var $perfil = '';
	var $nombre = '';
	var $appaterno = '';
	var $apmaterno = '';
	var $nombreusuario = '';
	var $pass = '';
	
	var $id = '';
	
	var $ids = '';
	var $tipo = '';
	
	function listar_catalogo($catalogo,$id)
	{		
	    $consulta = parent::consulta("SELECT * FROM cat_".$catalogo." where id_usuario = ".$id);		
		$num_total_registros = parent::num_rows($consulta);
				
		if($num_total_registros>0)
		{
				echo "<select name='filter_".$catalogo."' id='filter_".$catalogo."' class='inputbox'>";
	            echo "<option value='' selected>- Selecciona ".ucfirst($catalogo)." -</option>";
				while($listacatalogo = parent::fetch_array($consulta))
				{				    
					extract($listacatalogo);					
					echo "<option value='".$listacatalogo['id_'.$catalogo]."'>".ucfirst($listacatalogo['cat_'.$catalogo.'_nombre'])."</option>";					
				}				
				echo "</select>";
		}
		else
		{
		    echo "<select name='filter_disabled' id='filter_disabled' class='inputbox' disabled='disabled'>";
			echo "<option value='' selected>Ninguno</option>";
			echo "</select>";
		}		
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
						
	function statusUsuarios()
	{		    
	    $array_ids = array();
		$act=($this->tipo == 'habilitar') ? 1 : 0;
		
		foreach (explode(',',$this->ids) as $id_act){			    
				$consulta = parent::consulta("UPDATE reg_usuario SET reg_usuario_activado = $act WHERE id_usuario = ".$id_act);
		        if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
		}
	    return implode(',',$array_ids);
	}
	
	function borrarUsuarios()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){			    
				$consulta = parent::consulta("DELETE FROM reg_usuario where id_usuario = ".$id_act);
		        if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
		}
	    return implode(',',$array_ids);
	}
		
	function mostrarUsuarios()
	{
		include("class.fg.php");
		$fg = new fg();		
		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";
		  
		  if($this->filtro!='') $criterios_FILTRO = " WHERE reg_usuario_nombre LIKE \"%".$this->filtro."%\"";	                      		
		  if($this->campo!='')  $criterios_ORDEN = " ORDER BY ".$this->campo." ".$this->orden;
		  if($this->limite!=0)  $criterios_LIMITE = " LIMIT ".($this->paginado).", ".$this->limite;	
		  
		  
		  $consulta = parent::consulta("SELECT 
									    u.id_usuario as idusuario,
									    reg_usuario_perfil as perfil, 
										reg_usuario_fechaegistro as fecharegistro, 
										reg_usuario_acciones as accionesu, 
										reg_usuario_modulos as modulos, 
										reg_usuario_pass as pass, 
										reg_usuario_nomusuario as nomusuario, 
										reg_usuario_nombre as nombre,
										reg_usuario_appaterno as appaterno,
										reg_usuario_apmaterno as apmaterno,
										u.id_municipio as municipio,
										reg_usuario_activado as status,
										cat_municipio_nombre as nommunicipio
									   FROM reg_usuario as u left join cat_municipio as m on u.id_municipio = m.id_municipio $criterios_ORDEN ".$criterios_FILTRO.$criterios_LIMITE);		  
		  
		  $consulta_totalregistro = parent::consulta("SELECT * FROM reg_usuario ".$criterios_FILTRO);		  
		  
		  $num_total_registros = parent::num_rows($consulta);		  
		  
		  $num_total_registros_paginar = parent::num_rows($consulta_totalregistro);
		  
		  if($num_total_registros==0 && $num_total_registros_paginar>0){$this->paginado=$this->paginado-$this->limite;$this->pagina=$this->pagina-1;}else{$ban=false;}		  
		}
		
		$array_privilegios_clave=array('sis','sisusu','sispc','cat','catrama','catmodentdep','catdep','catclub','catliga','catevenac','catmun','catasodep','catprueba','catmoddep','cateveint','catest','catcat','asodep','asodepvincular','asodepimprimir','asodepimpsirred','asodepimpcedula','asodepimpcredencial','asodepimpreportes','evaseg','evasegvincular','evasegimprimir','evasegimpcurriculum','evasegimpreportes','evedep','evedepvincular','evedepvalidar','evedepresultados','evedepimprimir','evedepimpcedula','evedepimpgaffete','evedepimpreportes','evedepimpresultados','regentdep','imp','impcredencial','impstatus','impreporte');
		
		$array_privilegios=array('Sistema','Gestor Usuarios','Panel de Control','Cat&aacute;logos','Rama','Modalidad Ente Deportivo','Depotes','Club','Liga','Evento Nacional','Municipio','Asociaci&oacute;n Deportiva','Prueba','Modalidad Deportiva','Evento Internacional','Estado','Categoria','Asociaci&oacute;n Deportiva','Vincular Ente Deportivo Asoc. Dep.','Imprimir Asociaci&oacute;n Deportiva','SIRRED','C&aacute;dula de Inscripci&oacute;n','Imprimir Credencial','Imprimir Reporte Asoc. Dep.','Evaluaci&oacute;n y Seguimiento','Vincular Ente Deportivo Evaluaci&oacute;n y Seguimiento','Imprimir Eva. y Seg.','Imprimir Eva. Seg. Curriculum','Impimir Reportes Eav. Seg.','Eventos Deportivos','Vincular Evento Deportivo','Validar Evento Deportivo','Resultados Evento Dep.','Imprimir Evento Deportivo','Imprimir C&eacute;dula Evento Dep.','Imprimir Gaffete Evento Dep.','Imprimir Reporte Evento Dep.','Imprimir Resultados Evento Dep.','Registro Ente Depotivo','Imprimir','Imprimir Credencial','Imprimir Status','Imprimir Reportes');	
		
		$array_acciones_claves=array('grabar','borrar','editar');			
		$array_acciones=array('Grabar','Borrar','Editar');
		
		if($num_total_registros>0)
		{		
		       	 print "
				 <table class=\"adminlist\" cellpadding=\"1\">
                 <thead><tr>
                    <th width=\"2%\" class=\"title\">#</th>                    
				    <th width=\"3%\" class=\"title\">
					   <input type=\"checkbox\" name=\"toggle\" value=\"\" id=\"checkAll\" />
					</th>         
					
				    <th class=\"title\">
                        <a href=\"javascript:tableOrdering('reg_usuario_nombre','".$fg->ordena('reg_usuario_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre".$fg->ordenaimg('tb_usuario_nombre',$this->campo,$this->orden)."</a>
                    </th>
					
					<th class=\"title\">
                        <a href=\"javascript:tableOrdering('reg_usuario_appaterno','".$fg->ordena('tb_usuario_appaterno',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Ap. Paterno".$fg->ordenaimg('tb_usuario_appaterno',$this->campo,$this->orden)."</a>
                    </th>
					
					<th class=\"title\">
                        <a href=\"javascript:tableOrdering('reg_usuario_apmaterno','".$fg->ordena('reg_usuario_apmaterno',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Ap. Materno".$fg->ordenaimg('tb_usuario_apmaterno',$this->campo,$this->orden)."</a>
                    </th>
                    
                    <th width=\"12%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('reg_usuario_nomusuario','".$fg->ordena('reg_usuario_nomusuario',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre de usuario".$fg->ordenaimg('reg_usuario_nomusuario',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"12%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_municipio_nombre','".$fg->ordena('cat_municipio_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Municipio".$fg->ordenaimg('reg_usuario_nomusuario',$this->campo,$this->orden)."</a>				 
                    </th>
                    
                    <th width=\"5%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('reg_usuario_activado','".$fg->ordena('reg_usuario_activado',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Habilitado".$fg->ordenaimg('reg_usuario_activado',$this->campo,$this->orden)."</a>		
                    </th>
                        
                    <th width=\"5%\" class=\"title\">Contrase&ntilde;a</th>                  
                    
                    <th width=\"30%\" class=\"title\">Modul&oacute;s</th>
                    
                    <th width=\"5%\" class=\"title\">Acci&oacute;nes</th>           
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('u.id_usuario','".$fg->ordena('u.id_usuario',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('u.id_usuario',$this->campo,$this->orden)."</a>
					</th>
                  </tr></thead>
				 <tfoot>
				  <tr>
					  <td colspan=\"12\">
						  <del class=\"container\"><div class=\"pagination\"> 	                      	             
						   ".$fg->paginar($num_total_registros_paginar,$this->limite,$this->pagina)."
	                      </div></del>				
					  </td>
				  </tr>
				 </tfoot>
				 <tbody>";
				
				$i=0;
				while($usuarios = parent::fetch_array($consulta))
				{				
					extract($usuarios);				
					
					$privilegios = array();
		            $acciones = array();
					
					foreach (explode(',',$modulos) as $modulo){					
					        $privilegios[]="<a href=\"#\">".$array_privilegios[array_search($modulo, $array_privilegios_clave)]."</a>";					
					}
					
					foreach (explode(',',$accionesu) as $accion){					
					        $acciones[]="<a href=\"#\">".$array_acciones[array_search($accion, $array_acciones_claves)]."</a>";					
					}
					
					if($status==1) $img_status = '<a href="#" onclick="javascript:changestatus(\'deshabilitar\','.$idusuario.')"><img src="../images/habilitar.png" width="16" height="16" border="0" alt="" /></a>'; else $img_status = '<a href="#" onclick="javascript:changestatus(\'habilitar\','.$idusuario.')"><img src="../images/deshabilitar.png" width="16" height="16" border="0" alt="" /></a>';
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"tr$idusuario\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$idusuario\"/></td>
						<td><a href=\"../modulos/sitd_mod_guardaraplicar_usuarios.php?id=$idusuario&tipo=edit&texto=Editar Usuario\">$nombre</a></td>
						<td><a href=\"../modulos/sitd_mod_guardaraplicar_usuarios.php?id=$idusuario&tipo=edit&texto=Editar Usuario\">$appaterno</a></td>
						<td><a href=\"../modulos/sitd_mod_guardaraplicar_usuarios.php?id=$idusuario&tipo=edit&texto=Editar Usuario\">$apmaterno</a></td>						
						<td style=\"text-align:center\">$nomusuario</td>
						<td style=\"text-align:center\">$nommunicipio</td>
						<td id=\"$idusuario\" style=\"text-align:center\">$img_status</td>
						<td style=\"text-align:center\">$pass</td>						
						<td>".implode(' &bull; ',$privilegios)."</td>
						<td>".implode(' &bull; ',$acciones)."</td>					
						<td style=\"text-align:center\">$idusuario</td>
					  </tr>
					  ";
					  $i++;					
				}		
				print "</tbody></table>";
				
		}
		 else
		 {
			print "<div class=\"notice\"><img style=\"vertical-align:middle; margin-left:10px;\" alt=\"info\" src=\"../img/icons/info.png\" />Sin Resultados...</div>";
		 }
	}

function grabarUsuarios()
	{	         
	         $consulta = parent::consulta("SELECT id_usuario FROM reg_usuario WHERE reg_usuario_nomusuario = '".$this->nombreusuario."'");
			 $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros==0)
			 {
				if($this->municipio==''){$this->municipio=0;} 
			    $consulta = parent::consulta("INSERT INTO reg_usuario (reg_usuario_perfil, reg_usuario_fechaegistro, reg_usuario_acciones, reg_usuario_modulos, reg_usuario_pass, reg_usuario_nomusuario, reg_usuario_nombre,reg_usuario_appaterno,reg_usuario_apmaterno, reg_usuario_activado, id_municipio) VALUES ('".$this->perfil."','".date("Y-m-d H:i:s")."','".$this->accion."','".$this->privilegio."','".$this->pass."', '".$this->nombreusuario."', '".$this->nombre."', '".$this->appaterno."', '".$this->apmaterno."',  true,".$this->municipio.")");
				 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente el usuario..."}';	       	
			 }else{
				 //$mensaje['tipo']='error';$mensaje['mensaje']='N&uacute;mero de Serie del Auto Existente';  
		         return '{"tipo":"error","mensaje":"Usuario ya Existe, verifique..."}';
			 }
	}	


function aplicarUsuarios()
	{  	     
	         if($this->municipio==''){$this->municipio=0;}
			 $consulta = parent::consulta("UPDATE reg_usuario SET reg_usuario_perfil = '".$this->perfil."', reg_usuario_acciones='".$this->accion."', reg_usuario_modulos = '".$this->privilegio."' , reg_usuario_pass = '".$this->pass."', reg_usuario_nomusuario='".$this->nombreusuario."', reg_usuario_nombre='".$this->nombre."', reg_usuario_appaterno='".$this->appaterno."', reg_usuario_apmaterno='".$this->apmaterno."', id_municipio=".$this->municipio."  WHERE id_usuario = ".$this->id);		 			 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Actualizaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se pudo realizar la actualización con &eacute;xito, verifique..."}';	
	}	

function cargareditarUsuarios()
	{			 
	       $consulta = parent::consulta("SELECT 
										reg_usuario_perfil as perfil, 
										reg_usuario_fechaegistro as fecharegistro, 
										reg_usuario_acciones as acciones, 
										reg_usuario_modulos as privilegios, 
										reg_usuario_pass as pass, 
										reg_usuario_nomusuario as nomusuarios, 
										reg_usuario_nombre as nombre,
										reg_usuario_appaterno as appaterno,
										reg_usuario_apmaterno as apmaterno,
										id_municipio as idmunicipio,
										reg_usuario_activado as status 
										FROM reg_usuario Where id_usuario = ".$this->id);		 
			 $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros>0)
			 {
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {			    		    
                $arrData[] = $actual; 
			   }
			   return $arrData;			   
			 }
			 else
			 {
			   return "no";
			 }			 
	
	}	
}

?>