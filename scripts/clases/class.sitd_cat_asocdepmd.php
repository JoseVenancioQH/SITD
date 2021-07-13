<?php
error_reporting(E_ALL);
class catasocdepmd extends MySQL
{   
    var $pagina = '';
	var $paginado = '';
	var $limite = '';
	var $filtro = '';
	var $campo = '';
	var $orden = '';
	
	var $nombreempresa = '';
	var $propietario = '';
	var $tipofiscal = '';
	var $direccion = '';

	var $idempresa = '';
	var $noserie = '';	

	//grabar actualizar inventario auto	
	var $nopedimento = '';
	var $millas = '';
	var $noplacas = '';
	var $nomotor = '';	
	var $norfa = '';
	var $nofactura = '';
	var $notenencia = '';
	var $tcirculacion = '';
	var $kmrecorridos = '';
	
	var $modelo = '';
	var $linea = '';		
	var $cilindros = '';
	var $color = '';
	var $comext = '';
	var $comint = '';
	var $acc = '';
	var $commec = '';
	
	var $asocdep = '';
	var $nombre = '';
	var $app = '';
	var $apm = '';
	var $cargo = '';
	var $telefono = '';
	var $dom = '';
	var $rfc = '';
	var $idusuario = '';
	
	var $catalogo = '';	
	var $id = '';	
	var $ids = '';
	var $tipo = '';	
	var $foto = '';
	
	
	function statusInvAuto()
	{		    
	    $array_ids = array();
		$act=($this->tipo == 'habilitar') ? 1 : 0;
		
		foreach (explode(',',$this->ids) as $id_act){			    
		         $consulta = parent::consulta("SELECT id_auto FROM tb_ventaauto as v WHERE v.id_auto = ".$id_act);
				 $num_total_registros = parent::num_rows($consulta);
				 if($num_total_registros==0)
				  {
					$consulta = parent::consulta("UPDATE tb_auto SET tb_auto_activado = $act WHERE id_auto = ".$id_act);
					if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
				  }
		}
	    return implode(',',$array_ids);
	}
	
	function borrarCatAsocDepMD()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){	
		         $consulta = parent::consulta("SELECT id_mesadir FROM cat_mesadir as m WHERE m.id_mesadir = ".$id_act);
				 $num_total_registros = parent::num_rows($consulta);
				 if($num_total_registros!=0)
				  {	
					$consulta = parent::consulta("DELETE FROM cat_mesadir where id_mesadir = ".$id_act);
					if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
				  }				
		}
	    return implode(',',$array_ids);
	}
	
	function grabarCatAsocDepMD()
    {	   
	   $consulta = parent::consulta("SELECT cat_mesadir_nombre FROM cat_mesadir WHERE cat_mesadir_nombre = '".$this->nombre."' and cat_mesadir_app = '".$this->app."' and cat_mesadir_apm = '".$this->apm."' and cat_mesadir_cargo ='".$this->cargo."' and id_asocdep = ".$this->asocdep);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {		 		
		  //se registrara un nuevo auto\		  
		  $consulta = parent::consulta("INSERT INTO cat_mesadir (cat_mesadir_nombre, cat_mesadir_app, cat_mesadir_apm, cat_mesadir_cargo, cat_mesadir_telefono, cat_mesadir_domicilio, cat_mesadir_rfc, cat_mesadir_fechahorareg, id_asocdep, id_usuario) VALUES ('".$this->nombre."','".$this->app."','".$this->apm."','".$this->cargo."','".$this->telefono."','".$this->dom."','".$this->rfc."','".date("Y/m/d")."',".$this->asocdep.",".$this->idusuario.")");	  
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente la Asociaci&oacute;n Deportiva..."}';	
	   }
	  else
	   {		   
		 //$mensaje['tipo']='error';$mensaje['mensaje']='N&uacute;mero de Serie del Auto Existente';  
		 return '{"tipo":"error","mensaje":"Miembro de Asociaci&oacute;n ya Existe, verifique..."}';
	   }	  
    }
	
	function grabartodoCatRama()
    {		
	    $array_ids = array();
		$insert_affected_rama = '';
	    foreach (explode('<&>',$this->nombrerama) as $id_act){			
		   $consulta = parent::consulta("SELECT id_rama FROM cat_rama where cat_rama_nombre = '".$id_act."' And id_eventonacional = ".$this->eventonacional." And id_usuario = ".$this->idusuario);
		   $num_total_registros = parent::num_rows($consulta);		   					
		   if($num_total_registros==0)
	       {			   
 	         $consulta = parent::consulta("INSERT INTO cat_rama (cat_rama_nombre, id_eventonacional, id_usuario) VALUES ('".$id_act."',".$this->eventonacional.",".$this->idusuario.")");		   
			 $insert_affected_rama .= (mysql_affected_rows() > 0)?'':' <'.$id_act.'> ';											  			
		   }else{$insert_affected_rama .= ' <'.$id_act.'> ';}
		   
		}	
		return ($insert_affected_rama == '')?'{"tipo":"succes","mensaje":"'.$insert_affected_rama.'Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"'.$insert_affected_rama.' Error al registrar, Verifique, Duplicidad..."}';		  
    }
	
	function aplicarCatAsocDepMD()
	{		
	  /* $consulta = parent::consulta("SELECT cat_mesadir_nombre FROM cat_mesadir WHERE cat_mesadir_nombre = '".$this->nombre."' and cat_mesadir_app = ".$this->app." and cat_mesadir_apm = ".$this->apm." and cat_mesadir_cargo = ".$this->cargo." and cat_mesadir_telefono = ".$this->telefono." and cat_mesadir_domicilio = ".$this->dom." and ");
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {*/		
			 $consulta = parent::consulta("UPDATE cat_mesadir SET cat_mesadir_nombre = '".$this->nombre."', cat_mesadir_app = '".$this->app."', cat_mesadir_apm ='".$this->apm."', cat_mesadir_cargo = '".$this->cargo."', cat_mesadir_telefono = '".$this->telefono."', cat_mesadir_domicilio = '".$this->dom."', cat_mesadir_rfc = '".$this->rfc."', id_asocdep = ".$this->asocdep." WHERE id_mesadir = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente el miembro de la mesa directiva..."}';
		/*}else{
			
		}
	   return '{"tipo":"error","mensaje":"Mesa directiva existente para Asociaci&oacute;n Deportiva..."}';*/
	}	

	function deleteAuto()
	{	
		unlink('../imgautos/'.$this->foto);
		unlink('../imgautosthumb/'.$this->foto);		
		echo "si";
	}
	
	function deletetodasAuto()
	{
		include("class.fg.php");
		$fg = new fg();		
		$fg->rm_recursive('../imgautos/'.$this->idempresa.'/'.$this->noserie);
		$fg->rm_recursive('../imgautosthumb/'.$this->idempresa.'/'.$this->noserie);		
		echo 'si';
	}
	
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
	
	function listar_ramas($catalogo,$ids,$idusuario)
	{		
	    $array_ids = array();
		echo "<select name='filter_".$catalogo."_all' id='filter_".$catalogo."_all' class='inputbox' multiple='yes'>";		
	    foreach (explode(',',$ids) as $id_act){			
		   $consulta = parent::consulta("SELECT * FROM cat_".$catalogo." where id_".$catalogo." = ".$id_act." And id_usuario = ".$idusuario);
		   $num_total_registros = parent::num_rows($consulta);		   					
				while($listacatalogo = parent::fetch_array($consulta))
				{				    
					extract($listacatalogo);					
					echo "<option value='".$listacatalogo['id_'.$catalogo]."'>".ucfirst($listacatalogo['cat_'.$catalogo.'_nombre'])."</option>";					
				}											  			
		}    
		echo "</select>";
				
		/*if($num_total_registros>0)
		{
				echo "<select name='filter_".$catalogo."_all' id='filter_".$catalogo."_all' class='inputbox' multiple='yes'>";
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
		}		*/
	}
	
	function mostrarCatAsocDepMD()
	{
		include("class.fg.php");
		$fg = new fg();		
		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";	
		  $criterios_asocdep ="";
		  
		  if($this->filtro!='') $criterios_FILTRO = " m.cat_mesadir_nombre LIKE \"%".$this->filtro."%\""." or m.cat_mesadir_app LIKE \"%".$this->filtro."%\""." or m.cat_mesadir_apm LIKE \"%".$this->filtro."%\""." or m.cat_mesadir_cargo LIKE \"%".$this->filtro."%\""." or m.cat_mesadir_telefono LIKE \"%".$this->filtro."%\""." or m.cat_mesadir_domicilio LIKE \"%".$this->filtro."%\""." or m.cat_mesadir_rfc LIKE \"%".$this->filtro."%\"";	 
		  
		  if($this->asocdep!='') $criterios_asocdep = " And a.id_asocdep = ".$this->asocdep;
		  /*if($this->modelo!='') $criterios_modelo = " And mo.id_modelo = ".$this->modelo;
		  if($this->linea!='') $criterios_linea = " And li.id_linea = ".$this->linea;
		  if($this->tipo!='') $criterios_tipo = " And ti.id_tipo = ".$this->tipo;
		  if($this->color!='') $criterios_color = " And co.id_color = ".$this->color;*/
		  
		  $criterio_SELECT = $criterios_asocdep;	  
		  
          if(!empty($criterios_FILTRO) || !empty($criterio_SELECT)){
			     if(empty($criterios_FILTRO)){
			        $criterio_SELECT = substr($criterio_SELECT,4,strlen($criterio_SELECT));	
				 }
    			 $criterios_FILTRO = ' WHERE'.$criterios_FILTRO.$criterio_SELECT;
		  }	  
		  
		  if($this->campo!='')  $criterios_ORDEN = " ORDER BY ".$this->campo." ".$this->orden;
		  if($this->limite!=0)  $criterios_LIMITE = " LIMIT ".($this->paginado).", ".$this->limite;			  
		  
				  
		  $consulta = parent::consulta("
			 SELECT 
			 m.id_usuario as idusuario, 
			 reg_usuario_nombre as nombre, 
			 reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 cat_asocdep_nombre as nombreasocdep,
			 cat_mesadir_nombre as nombremesadir,
			 cat_mesadir_cargo as mesadircargo,
			 cat_mesadir_telefono as mesadirtel,
			 cat_mesadir_domicilio as mesadirdom,
			 cat_mesadir_rfc as mesadirrfc,
			 cat_mesadir_apm as mesadirapm,
			 cat_mesadir_app as mesadirapp,
			 cat_mesadir_fechahorareg as mesadirfechahorareg,			 
			 id_mesadir as idmesadir
			 FROM 
			 (cat_mesadir as m inner join cat_asocdep as a on m.id_asocdep = a.id_asocdep) inner join reg_usuario as u on m.id_usuario = u.id_usuario and m.id_usuario = ".$this->idusuario." ".$criterios_FILTRO.$criterios_ORDEN.$criterios_LIMITE);
		  
		  $consulta_totalregistro = parent::consulta("
			 SELECT 
			 m.id_usuario as idusuario, 
			 reg_usuario_nombre as nombre, 
			 reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 cat_asocdep_nombre as nombreasocdep,
			 cat_mesadir_nombre as nombremesadir,
			 cat_mesadir_cargo as mesadircargo,
			 cat_mesadir_telefono as mesadirtel,
			 cat_mesadir_domicilio as mesadirdom,
			 cat_mesadir_rfc as mesadirrfc,
			 cat_mesadir_apm as mesadirapm,
			 cat_mesadir_app as mesadirapp,
			 cat_mesadir_fechahorareg as mesadirfechahorareg,			 
			 id_mesadir as idmesadir
			 FROM 
			 (cat_mesadir as m inner join cat_asocdep as a on m.id_asocdep = a.id_asocdep) inner join reg_usuario as u on m.id_usuario = u.id_usuario and m.id_usuario = ".$this->idusuario." ".$criterios_FILTRO);
		  
		  $num_total_registros = parent::num_rows($consulta);		  
		  
		  $num_total_registros_paginar = parent::num_rows($consulta_totalregistro);		
		  
		  if($num_total_registros==0 && $num_total_registros_paginar>0){$this->paginado=$this->paginado-$this->limite;$this->pagina=$this->pagina-1;}else{$ban=false;}		  
		}			
		
		if($num_total_registros>0)
		{		
		       	 print "
				 <table class=\"adminlist\" cellpadding=\"1\">
                 <thead><tr>
                    <th width=\"2%\" class=\"title\">#</th>                    
				    <th width=\"3%\" class=\"title\">
					   <input type=\"checkbox\" name=\"toggle\" value=\"\" id=\"checkAll\" />
					</th>        				
					
				    <th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('cat_asocdep_nombre','".$fg->ordena('cat_asocdep_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Asoc. Deportiva".$fg->ordenaimg('cat_asocdep_nombre',$this->campo,$this->orden)."</a>
                    </th>					           
					
					<th width=\"8%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_mesadir_cargo','".$fg->ordena('cat_mesadir_cargo',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Cargo".$fg->ordenaimg('cat_mesadir_cargo',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"8%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_mesadir_telefono','".$fg->ordena('cat_mesadir_telefono',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Telefono".$fg->ordenaimg('cat_mesadir_telefono',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"10%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_mesadir_domicilio','".$fg->ordena('cat_mesadir_domicilio',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Domicilio".$fg->ordenaimg('cat_mesadir_domicilio',$this->campo,$this->orden)."</a>				 
                    </th>
							
					<th width=\"8%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_mesadir_rfc','".$fg->ordena('cat_mesadir_rfc',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">R.F.C.".$fg->ordenaimg('cat_mesadir_rfc',$this->campo,$this->orden)."</a>				 
                    </th>		
					
					<th width=\"8%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_mesadir_nombre','".$fg->ordena('cat_mesadir_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre".$fg->ordenaimg('cat_mesadir_nombre',$this->campo,$this->orden)."</a>				 
                    </th>		
					
					<th width=\"8%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_mesadir_app','".$fg->ordena('cat_mesadir_app',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Apellido Paterno".$fg->ordenaimg('cat_mesadir_app',$this->campo,$this->orden)."</a>				 
                    </th>		
					
					<th width=\"8%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_mesadir_apm','".$fg->ordena('cat_mesadir_apm',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Apellido Materno".$fg->ordenaimg('cat_mesadir_apm',$this->campo,$this->orden)."</a>				 
                    </th>		
					
					<th width=\"10%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_mesadir_fechahorareg','".$fg->ordena('cat_mesadir_fechahorareg',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Fecha de Registro".$fg->ordenaimg('cat_mesadir_fechahorareg',$this->campo,$this->orden)."</a>				 
                    </th>		
					
                    <th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('reg_usuario_nombre','".$fg->ordena('reg_usuario_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Usuario".$fg->ordenaimg('reg_usuario_nombre',$this->campo,$this->orden)."</a>		
                    </th>	
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('id_mesadir','".$fg->ordena('id_mesadir',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('id_mesadir',$this->campo,$this->orden)."</a>
					</th>
					
                  </tr></thead>
				 <tfoot>
				  <tr>
					  <td colspan=\"13\">
						  <del class=\"container\"><div class=\"pagination\"> 	                      	             
						   ".$fg->paginar($num_total_registros_paginar,$this->limite,$this->pagina)."
	                      </div></del>				
					  </td>
				  </tr>
				 </tfoot>
				 <tbody>";
				
				$i=0;
				while($catasocdepmd = parent::fetch_array($consulta))
				{				
					extract($catasocdepmd);			
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;					
					  print "
					  <tr id=\"$idmesadir\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$idmesadir\"/></td>	
						<td style=\"text-align:center\">$nombreasocdep</td>
						<td style=\"text-align:center\"><a href=\"../modulos/sitd_mod_guardaraplicar_catasocdepmd.php?id=$idmesadir&tipo=edit&texto=Editar Asoc. Dep. Mesa Directiva\">$mesadircargo</a></td>						
						<td style=\"text-align:center\">$mesadirtel</td>
						<td style=\"text-align:center\">$mesadirdom</td>						
						<td style=\"text-align:center\">$mesadirrfc</td>						
						<td style=\"text-align:center\">$nombremesadir</td>
						<td style=\"text-align:center\">$mesadirapp</td>
						<td style=\"text-align:center\">$mesadirapm</td>
						<td style=\"text-align:center\">".$fg->fechalarga($mesadirfechahorareg)."</td>
						<td style=\"text-align:center\">$nombre</td>																	
						<td style=\"text-align:center\">$idmesadir</td>
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
	
	function cargareditarCatAsocDepMD()
	{			 
	        $consulta = parent::consulta("SELECT 
			 m.id_usuario as idusuario, 			 
			 cat_mesadir_nombre as nombremesadir,
			 cat_mesadir_cargo as mesadircargo,
			 cat_mesadir_telefono as mesadirtel,
			 cat_mesadir_domicilio as mesadirdom,
			 cat_mesadir_rfc as mesadirrfc,
			 cat_mesadir_apm as mesadirapm,
			 cat_mesadir_app as mesadirapp,			 
			 id_mesadir as idmesadir,
			 id_asocdep as idasocdep
			 FROM 
			 cat_mesadir as m where id_mesadir = ".$this->id);
	       		 
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