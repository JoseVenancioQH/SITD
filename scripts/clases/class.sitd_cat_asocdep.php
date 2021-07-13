<?php
error_reporting(E_ALL);
class catasocdep extends MySQL
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
	var $rfc = '';
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
	
	var $municipio = '';
	var $deportes = '';
	var $dircalle = '';
	var $dircolonia = '';
	var $dirnum = '';
	var $telconv = '';
	var $telcel = '';
	var $dircorreo = '';	
	var $acronimo = '';
	
	var $modelo = '';
	var $linea = '';		
	var $cilindros = '';
	var $color = '';
	var $comext = '';
	var $comint = '';
	var $acc = '';
	var $commec = '';
	var $nombreasocdep = '';
	
	var $catalogo = '';	
	var $id = '';	
	var $ids = '';
	var $tipo = '';	
	var $foto = '';
	var $idusuario = '';
	
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
	
	function borrarCatAsocDep()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){	
		         $consulta = parent::consulta("SELECT id_asocdep FROM cat_asocdep as a WHERE a.id_asocdep = ".$id_act);
				 $num_total_registros = parent::num_rows($consulta);
				 if($num_total_registros!=0)
				  {	
					$consulta = parent::consulta("DELETE FROM cat_asocdep where id_asocdep = ".$id_act);
					if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
				  }				
		}
	    return implode(',',$array_ids);
	}
	
	function grabarCatAsocDep()
    {
	   $consulta = parent::consulta("SELECT cat_asocdep_nombre FROM cat_asocdep WHERE cat_asocdep_nombre = '".$this->nombreasocdep."' and id_deportes = ".$this->deportes." and id_municipio = ".$this->municipio);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {		 		  
		  //se registrara un nuevo auto\		  
		  $consulta = parent::consulta("INSERT INTO cat_asocdep (cat_asocdep_nombre, id_municipio, id_deportes, id_usuario, cat_asocdep_dircalle, cat_asocdep_dirnum, cat_asocdep_acronimo, cat_asocdep_dircolonia, cat_asocdep_telconv, cat_asocdep_telcel, cat_asocdep_dircorreo) VALUES ('".$this->nombreasocdep."',".$this->municipio.",".$this->deportes.",".$this->idusuario.",'".$this->dircalle."','".$this->dirnum."','".$this->acronimo."','".$this->dircolonia."','".$this->telconv."','".$this->telcel."','".$this->dircorreo."')");	  
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente la Asociación Deportiva..."}';	
	   }
	  else
	   {		   
		 //$mensaje['tipo']='error';$mensaje['mensaje']='N&uacute;mero de Serie del Auto Existente';  
		 return '{"tipo":"error","mensaje":"Asociaci&oacute;n Deportiva ya Existe, verifique..."}';
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
	
	function aplicarCatAsocDep()
	{	
	   /*$consulta = parent::consulta("SELECT cat_asocdep_nombre FROM cat_asocdep WHERE cat_asocdep_nombre = '".$this->nombreasocdep."' and id_municipio = ".$this->municipio." and id_deportes = ".$this->deportes);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {*/
			 $consulta = parent::consulta("UPDATE cat_asocdep SET cat_asocdep_nombre = '".$this->nombreasocdep."', id_municipio = ".$this->municipio.", id_deportes = ".$this->deportes.", id_usuario = ".$this->idusuario.", cat_asocdep_dircalle = '".$this->dircalle."', cat_asocdep_dirnum='".$this->dirnum."', cat_asocdep_acronimo='".$this->acronimo."', cat_asocdep_dircolonia='".$this->dircolonia."', cat_asocdep_telconv='".$this->telconv."', cat_asocdep_telcel='".$this->telcel."', cat_asocdep_dircorreo='".$this->dircorreo."' WHERE id_asocdep = ".$this->id);		 			 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente la asociaci&oacute;n deportiva..."}';
		/*}else{
			
		}
	   return '{"tipo":"error","mensaje":"Nombre de Asociaci&oacute;n Deportiva existente para para Municipio o Deporte..."}';*/
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
	
	function mostrarCatAsocDep()
	{
		include("class.fg.php");
		$fg = new fg();		
		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";	
		  $criterios_municipio ="";$criterios_deportes ="";
		  
		  if($this->filtro!='') $criterios_FILTRO = " a.cat_asocdep_nombre LIKE \"%".$this->filtro."%\" or a.cat_asocdep_dircalle LIKE \"%".$this->filtro."%\" or a.cat_asocdep_dircolonia LIKE \"%".$this->filtro."%\" or a.cat_asocdep_telconv LIKE \"%".$this->filtro."%\" or a.cat_asocdep_telcel LIKE \"%".$this->filtro."%\" or a.cat_asocdep_dircorreo LIKE \"%".$this->filtro."%\" ";	 
		  
		  if($this->municipio!='') $criterios_municipio = " And m.id_municipio = ".$this->municipio;
		  if($this->deportes!='') $criterios_deportes = " And d.id_deportes = ".$this->deportes;
		  /*if($this->linea!='') $criterios_linea = " And li.id_linea = ".$this->linea;
		  if($this->tipo!='') $criterios_tipo = " And ti.id_tipo = ".$this->tipo;
		  if($this->color!='') $criterios_color = " And co.id_color = ".$this->color;*/
		  
		  $criterio_SELECT = $criterios_municipio.$criterios_deportes;	  
		  
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
			 a.id_usuario as idusuario, 
			 reg_usuario_nombre as nombre, 
			 reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 cat_asocdep_nombre as nombreasocdep,
			 cat_asocdep_dircalle as nombredircalle,
			 cat_asocdep_dirnum as nombredirnum,
			 cat_asocdep_acronimo as nombreacronimo,
			 cat_asocdep_dircolonia as nombredircolonia,
			 cat_asocdep_telconv as telconv,
			 cat_asocdep_telcel as telcel,
			 cat_asocdep_dircorreo as dircorreo,
			 cat_municipio_nombre as municipio,
			 cat_deportes_nombre as deportes,
			 id_asocdep as idasocdep
			 FROM 
			 ((cat_asocdep as a inner join cat_municipio as m on a.id_municipio = m.id_municipio) inner join cat_deportes as d on a.id_deportes = d.id_deportes) inner join reg_usuario as u on a.id_usuario = u.id_usuario and a.id_usuario = ".$this->idusuario." ".$criterios_FILTRO.$criterios_ORDEN.$criterios_LIMITE);
		  
		  $consulta_totalregistro = parent::consulta("
			 SELECT 
			 a.id_usuario as idusuario, 
			 reg_usuario_nombre as nombre, 
			 reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 cat_asocdep_nombre as nombreasocdep,
			 cat_asocdep_dircalle as nombredircalle,
			 cat_asocdep_dirnum as nombredirnum,
			 cat_asocdep_acronimo as nombreacronimo,
			 cat_asocdep_dircolonia as nombredircolonia,
			 cat_asocdep_telconv as telconv,
			 cat_asocdep_telcel as telcel,
			 cat_asocdep_dircorreo as dircorreo,
			 cat_municipio_nombre as municipio,
			 cat_deportes_nombre as deportes,
			 id_asocdep as idasocdep
			 FROM 
			 ((cat_asocdep as a inner join cat_municipio as m on a.id_municipio = m.id_municipio) inner join cat_deportes as d on a.id_deportes = d.id_deportes) inner join reg_usuario as u on a.id_usuario = u.id_usuario and a.id_usuario = ".$this->idusuario." ".$criterios_FILTRO);
		  
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
					
				    <th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('cat_asocdep_nombre','".$fg->ordena('cat_asocdep_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Asociaci&oacute;n Deportiva".$fg->ordenaimg('cat_asocdep_nombre',$this->campo,$this->orden)."</a>
                    </th>					
                    
                    <th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_deportes_nombre','".$fg->ordena('cat_deportes_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Deporte".$fg->ordenaimg('cat_deportes_nombre',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_municipio_nombre','".$fg->ordena('cat_municipio_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Municipio".$fg->ordenaimg('cat_municipio_nombre',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_asocdep_dircalle','".$fg->ordena('cat_asocdep_dircalle',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Direcci&oacute;n Calle".$fg->ordenaimg('cat_asocdep_dircalle',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_asocdep_dirnum','".$fg->ordena('cat_asocdep_dirnum',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Direcci&oacute;n N&uacute;mero".$fg->ordenaimg('cat_asocdep_dirnum',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_asocdep_telconv','".$fg->ordena('cat_asocdep_telconv',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Tel&eacute;fono Convencional".$fg->ordenaimg('cat_asocdep_telconv',$this->campo,$this->orden)."</a>				 
                    </th>
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_asocdep_telcel','".$fg->ordena('cat_asocdep_telcel',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Tel&eacute;fono Celular".$fg->ordenaimg('cat_asocdep_telcel',$this->campo,$this->orden)."</a>				 
                    </th>
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_asocdep_dircorreo','".$fg->ordena('cat_asocdep_dircorreo',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Direcci&oacute;n Correo Electronico".$fg->ordenaimg('cat_asocdep_dircorreo',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_asocdep_acronimo','".$fg->ordena('cat_asocdep_acronimo',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Acronimo".$fg->ordenaimg('cat_asocdep_acronimo',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_asocdep_dircolonia','".$fg->ordena('cat_asocdep_dircolonia',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Direcci&oacute;n Colonia".$fg->ordenaimg('cat_asocdep_dircolonia',$this->campo,$this->orden)."</a>				 
                    </th>			
										   
                    <th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('reg_usuario_nombre','".$fg->ordena('reg_usuario_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Usuario".$fg->ordenaimg('reg_usuario_nombre',$this->campo,$this->orden)."</a>		
                    </th>	
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('id_asocdep','".$fg->ordena('id_asocdep',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('id_asocdep',$this->campo,$this->orden)."</a>
					</th>
					
                  </tr></thead>
				 <tfoot>
				  <tr>
					  <td colspan=\"14\">
						  <del class=\"container\"><div class=\"pagination\"> 	                      	             
						   ".$fg->paginar($num_total_registros_paginar,$this->limite,$this->pagina)."
	                      </div></del>				
					  </td>
				  </tr>
				 </tfoot>
				 <tbody>";
				
				$i=0;
				while($catrama = parent::fetch_array($consulta))
				{				
					extract($catrama);			
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"$idasocdep\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$idasocdep\"/></td>				
						<td style=\"text-align:center\"><a href=\"../modulos/sitd_mod_guardaraplicar_catasocdep.php?id=$idasocdep&tipo=edit&texto=Editar Asociaci&oacute;n Deportiva\">$nombreasocdep</a></td>
						<td style=\"text-align:center\">$deportes</td>
						<td style=\"text-align:center\">$municipio</td>
						<td style=\"text-align:center\">$nombredircalle</td>
						<td style=\"text-align:center\">$nombredirnum</td>
						<td style=\"text-align:center\">$telconv</td>
						<td style=\"text-align:center\">$telcel</td>
						<td style=\"text-align:center\">$dircorreo</td>
						<td style=\"text-align:center\">$nombreacronimo</td>
						<td style=\"text-align:center\">$nombredircolonia</td>
						<td style=\"text-align:center\">$nombre</td>																	
						<td style=\"text-align:center\">$idasocdep</td>
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
	
	function cargareditarCatAsocDep()
	{			 
	        $consulta = parent::consulta("
			 SELECT 
			 a.id_municipio as idmunicipio,
			 a.id_deportes as iddeportes,
			 cat_asocdep_nombre as nombreasocdep,
			 cat_asocdep_dircalle as nombredircalle,
			 cat_asocdep_dirnum as nombredirnum,
			 cat_asocdep_acronimo as nombreacronimo,
			 cat_asocdep_dircolonia as nombredircolonia,
			 cat_asocdep_telconv as telconv,
			 cat_asocdep_telcel as telcel,
			 cat_asocdep_dircorreo as dircorreo,
			 cat_municipio_nombre as municipio,
			 cat_deportes_nombre as deportes,
			 id_asocdep as idasocdep
			 FROM 
			 ((cat_asocdep as a inner join cat_municipio as m on a.id_municipio = m.id_municipio) inner join cat_deportes as d on a.id_deportes = d.id_deportes) where a.id_asocdep = ".$this->id);
	       		 
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