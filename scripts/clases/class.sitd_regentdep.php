<?php
error_reporting(E_ALL);
class regentdep extends MySQL
{   
    var $pagina = '';
	var $paginado = '';
	var $limite = '';
	var $filtro = '';
	var $campo = '';
	var $orden = '';
	
	var $prueba = '';
	var $idcategoria = '';	

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
	var $eventonacional = '';
	var $deportes = '';
	var $moddep = '';
	var $rama = '';
	var $modelo = '';
	var $linea = '';		
	var $cilindros = '';
	var $color = '';
	var $comext = '';
	var $comint = '';
	var $acc = '';
	var $commec = '';
	
	var $nombrecat = '';	
	var $catanoinicio = '';
	var $catanofin = '';
	var $filter_deportes = '';
	var $filter_rama = '';
	var $filter_moddep = '';
	var $pruebas = '';		
	
	var $catalogo = '';	
	var $id = '';	
	var $ids = '';
	var $tipo = '';	
	var $foto = '';
	var $idusuario = '';
	
	function utf8($string_utf8)
	{
	         $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	         $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
			 return	$string_utf8_res;
	}
	
	function ascii($string_ascii)
	{
	   $string_ascii_temp = html_entity_decode($string_ascii);	   
	   return	$string_ascii_temp;
	}
	
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
	
	function borrarCatRama()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){	
		         $consulta = parent::consulta("SELECT id_rama FROM cat_rama as r WHERE r.id_rama = ".$id_act);
				 $num_total_registros = parent::num_rows($consulta);
				 if($num_total_registros!=0)
				  {	
					$consulta = parent::consulta("DELETE FROM cat_rama where id_rama = ".$id_act);
					if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
				  }				
		}
	    return implode(',',$array_ids);
	}
	
	function grabarCatPrueba()
    {
	   $consulta = parent::consulta("SELECT cat_prueba_nombre FROM cat_prueba WHERE id_categoria = ".$this->idcategoria." and cat_prueba_nombre = '".$this->prueba."'");
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {			
		 //se registrara una nueva prueba		  
		 $consulta = parent::consulta("INSERT INTO cat_prueba (cat_prueba_nombre, id_categoria) VALUES ('".$this->prueba."',".$this->idcategoria.")");	  	 
		 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente la prueba..."}';	
	   }
	  else
	   {	 
		 return '{"tipo":"error","mensaje":"Prueba ya existente para categoria, verifique..."}';
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
	
	function aplicarCatPrueba()
	{	
	   $consulta = parent::consulta("SELECT cat_prueba_nombre FROM cat_prueba WHERE cat_prueba_nombre = '".$this->prueba."' And  id_categoria = ".$this->idcategoria);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {			 
			 $consulta = parent::consulta("UPDATE cat_prueba SET cat_prueba_nombre = '".$this->prueba."', id_usuario = ".$this->idusuario.", id_categoria = ".$this->idcategoria." WHERE id_prueba = ".$this->id);		 
		     return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente la prueba..."}';
		}else{
	         return '{"tipo":"error","mensaje":"Nombre de la prueba existente para la Categoria y Evento Nacional..."}';
		}	   
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
	
    function ListaComboPrueba()
	{
		/*array multidimencional de los catalogos en lista, agregar*/
		if($this->ideventonacional!="" && $this->lista!="")
		{
		$lista = explode(',', $this->lista);
		foreach ($lista as $cat) {
 		   $consulta = parent::consulta("SELECT cat_".$cat."_nombre as nombre, id_".$cat." as id FROM cat_".$cat." where id_eventonacional = ".$this->ideventonacional);		
		   $num_total_registros = parent::num_rows($consulta);
		   if($num_total_registros>0)
		   {
			 while ($actual = parent::fetch_assoc($consulta)) 
			 {		    
			   $arrData[] = $actual; 				
			 }			   			 
		   }
		   else
		   {			 
			 $arrData[] = "";
		   }	
		   $arrayenvio[$cat] =  $arrData;	
		   $arrData = array();
		}
		}else{
			$arrayenvio = "";
		}
		return $arrayenvio;
	}
	
	function ListaComboCategoria()
	{
		/*array multidimencional de los catalogos en lista, agregar*/
		if($this->eventonacional!="")
		{			   
		   $criterios_FILTRO="";$criterios_eventonacional ="";$criterios_deporte ="";$criterios_moddep ="";$criterios_rama ="";
		   if($this->eventonacional!='') $criterios_eventonacional = " And cat.id_eventonacional = ".$this->eventonacional;
		   if($this->deporte!='') $criterios_deporte = " And dep.id_deportes = ".$this->deporte;
		   if($this->rama!='') $criterios_rama = " And rama.id_rama = ".$this->rama;
		   if($this->moddep!='') $criterios_moddep = " And moddep.id_moddep = ".$this->moddep;
		   
		   $criterio_SELECT = $criterios_deporte.$criterios_rama.$criterios_moddep;	  
		  
		   if(!empty($criterios_FILTRO) || !empty($criterio_SELECT)){
				   if(empty($criterios_FILTRO)){
					  $criterio_SELECT = substr($criterio_SELECT,4,strlen($criterio_SELECT));	
				   }
				   $criterios_FILTRO = ' WHERE '.$criterios_FILTRO.$criterio_SELECT;
		   }	
		   
 		   $consulta = parent::consulta("SELECT 										 
					 id_categoria as id,                     
                     CONCAT('[',dep.cat_deportes_nombre,'] (',rama.cat_rama_nombre,')] ',cat.cat_categoria_nombre,' (',cat.cat_categoria_anoinicio,'-',cat.cat_categoria_anofin,')',', ',moddep.cat_moddep_nombre) as nombre                    
					 FROM (((cat_categoria as cat inner join cat_deportes as dep on cat.id_deportes = dep.id_deportes) 
						  inner join cat_rama as rama on cat.id_rama = rama.id_rama)
						  inner join cat_moddep as moddep on cat.id_moddep = moddep.id_moddep)".$criterios_FILTRO);										 
						 
		   $num_total_registros = parent::num_rows($consulta);
		   if($num_total_registros>0)
		   {
			 while ($actual = parent::fetch_assoc($consulta)) 
			 {		    
			   $arrData[] = $actual; 				
			 }			   			 
		   }
		   else
		   {			 
			 $arrData[] = "";
		   }	
		   $arrayenvio["catprueba"] =  $arrData;	
		   $arrData = array();			   		
		}else{
			$arrayenvio = "";
		}
		return $arrayenvio;
	}
	
	
	function listar_catalogo($catalogo,$id)
	{		
	    $consulta = parent::consulta("SELECT * FROM cat_".$catalogo." where id_usuario = ".$id);		
		$num_total_registros = parent::num_rows($consulta);
				
		if($num_total_registros>0)
		{
				echo "<select name='filter_".$catalogo."' id='filter_".$catalogo."' class='validate[required] inputbox'>";
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
	
	function mostrarRegEnteDep()
	{
		include("class.fg.php");
		$fg = new fg();		
		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";	
		  $criterios_eventonacional ="";$criterios_deportes ="";$criterios_moddep ="";$criterios_rama ="";$criterios_anoinicio ="";$criterios_anofin ="";
		  
		  if($this->filtro!='') $criterios_FILTRO = " ca.cat_categoria_nombre LIKE \"%".$this->filtro."%\"";	 
		  
		  if($this->eventonacional!='') $criterios_eventonacional = " And en.id_eventonacional = ".$this->eventonacional;
		  if($this->filter_deportes!='') $criterios_deportes = " And de.id_deportes = ".$this->filter_deportes;
		  if($this->filter_moddep!='') $criterios_moddep = " And md.id_moddep = ".$this->filter_moddep;
		  if($this->filter_rama!='') $criterios_rama = " And ra.id_rama = ".$this->filter_rama;
		  if($this->catanoinicio!='') $criterios_anoinicio = " And ca.cat_categoria_anoinicio >= ".$this->catanoinicio;
		  if($this->catanofin!='') $criterios_anofin = " And ca.cat_categoria_anofin <= ".$this->catanofin;
		  
		  $criterio_SELECT = $criterios_eventonacional.$criterios_deportes.$criterios_moddep.$criterios_rama.$criterios_anoinicio.$criterios_anofin;	  
		  
          if(!empty($criterios_FILTRO) || !empty($criterio_SELECT)){
			     if(empty($criterios_FILTRO)){
			        $criterio_SELECT = substr($criterio_SELECT,4,strlen($criterio_SELECT));	
				 }
    			 $criterios_FILTRO = ' WHERE '.$criterios_FILTRO.$criterio_SELECT;
		  }	  
		  
		  if($this->campo!='')  $criterios_ORDEN = " ORDER BY ".$this->campo." ".$this->orden;
		  if($this->limite!=0)  $criterios_LIMITE = " LIMIT ".($this->paginado).", ".$this->limite;
		  
		  	 
		  $consulta = parent::consulta("
			 SELECT 
			 entd.id_regentdep as idregentdep,			 
			 entd.id_estado as idestado,			 			 			 
			 entd.reg_entdep_genero as genero,
			 entd.reg_entdep_nombre as nombre,
			 entd.reg_entdep_app as app,
			 entd.reg_entdep_apm as apm,
			 entd.reg_entdep_curp as curp,
			 entd.reg_entdep_fechanac as fechanac,
			 entd.reg_entdep_fechahorareg as fechahorareg,
			 es.cat_estado_nombre as estado,			 
			 ru.reg_usuario_nombre as nombre,
			 ru.reg_usuario_appaterno as appaterno,
			 ru.reg_usuario_apmaterno as apmaterno
			 FROM 
			 ((
			 reg_entdep as entd inner join 		     	 
			 cat_estado as es on entd.id_estado = es.id_estado and entd.id_usuario = ".$this->idusuario.") inner join			 
             reg_usuario as ru on entd.id_usuario = ru.id_usuario) ".$criterios_FILTRO/*." GROUP BY ca.id_categoria "*/.$criterios_ORDEN.$criterios_LIMITE);
	  
		  $consulta_totalregistro = parent::consulta("
			 SELECT 
			 entd.id_regentdep as idregentdep,			 
			 entd.id_estado as idestado,			 			 			 
			 entd.reg_entdep_genero as genero,
			 entd.reg_entdep_nombre as nombre,
			 entd.reg_entdep_app as app,
			 entd.reg_entdep_apm as apm,
			 entd.reg_entdep_curp as curp,
			 entd.reg_entdep_fechanac as fechanac,
			 entd.reg_entdep_fechahorareg as fechahorareg,
			 es.cat_estado_nombre as estado,			 
			 ru.reg_usuario_nombre as nombre,
			 ru.reg_usuario_appaterno as appaterno,
			 ru.reg_usuario_apmaterno as apmaterno
			 FROM 
			 ((
			 reg_entdep as entd inner join 		     	 
			 cat_estado as es on entd.id_estado = es.id_estado and entd.id_usuario = ".$this->idusuario.") inner join			 
             reg_usuario as ru on entd.id_usuario = ru.id_usuario) ".$criterios_FILTRO/*." GROUP BY ca.id_categoria "*/);
		  
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
					
					<th width=\"15%\" class=\"title\">Foto</th>
					
					<th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('entdep.reg_entdep_nombre','".$fg->ordena('entdep.reg_entdep_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre".$fg->ordenaimg('entdep.reg_entdep_nombre',$this->campo,$this->orden)."</a>
                    </th>
					
				    <th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('entdep.reg_entdep_app','".$fg->ordena('entdep.reg_entdep_app',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Ap. Paterno".$fg->ordenaimg('entdep.reg_entdep_app',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('entdep.reg_entdep_apm','".$fg->ordena('entdep.reg_entdep_apm',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Ap. Materno".$fg->ordenaimg('entdep.reg_entdep_apm',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('es.cat_estado_nombre','".$fg->ordena('es.cat_estado_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Estado Rep.".$fg->ordenaimg('es.cat_estado_nombre',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('entdep.reg_entdep_fechanac','".$fg->ordena('entdep.reg_entdep_fechanac',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Fecha Nac.".$fg->ordenaimg('entdep.reg_entdep_fechanac',$this->campo,$this->orden)."</a>
                    </th>
                    
					<th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('entdep.reg_entdep_genero','".$fg->ordena('entdep.reg_entdep_genero',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Genero".$fg->ordenaimg('entdep.reg_entdep_genero',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('entdep.reg_entdep_curp','".$fg->ordena('entdep.reg_entdep_curp',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">CURP".$fg->ordenaimg('entdep.reg_entdep_curp',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"10%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('entdep.reg_entdep_fechahorareg','".$fg->ordena('entdep.reg_entdep_fechahorareg',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Fecha Hora Reg".$fg->ordenaimg('entdep.reg_entdep_fechahorareg',$this->campo,$this->orden)."</a>
                    </th>	
					
					<th width=\"10%\" class=\"title\">Nombre Usuario</th>
					
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('entdep.id_regentdep','".$fg->ordena('entdep.id_regentdep',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('entdep.id_regentdep',$this->campo,$this->orden)."</a>
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
				while($regentdep = parent::fetch_array($consulta))
				{				
					extract($regentdep);			
					
					if(file_exists("../fotosparticipantes/".$curp.".png")) 
					 {
						$fotop = "<img class='edit_foto' style=' vertical-align:top; cursor:pointer;' src='../img/editar_img.jpg' onclick='javascript:editarfoto(\"".$curp."\",\"fotosparticipantes/"."\");'/><br /><img id='foto".$curp."' src='../fotosparticipantes/".$curp.".png?nocache=".(rand()*1000)."' style='vertical-align:top; cursor:pointer;' onmouseover='javascript:actualizarfoto(\"".$curp."\");' onclick='javascript:actualizarfoto(\"".$curp."\");'/>";
					 }else{
					    $fotop = "<img class='edit_foto' style=' vertical-align:top; cursor:pointer;' src='../img/editar_img.jpg' onclick='javascript:editarfoto(\"".$curp."\",\"\");'/><br /><img id='foto".$curp."'  src='../img/foto_renovar.jpg' style='vertical-align:middle; cursor:pointer;' onmouseover='javascript:actualizarfoto(\"".$curp."\");' onclick='javascript:actualizarfoto(\"".$curp."\");'/>";
					 }					
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"$idregentdep\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						
						<td style=\"text-align:center\"><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$idregentdep\"/><p></p><p></p><img class=\"imgeditarparticipante\" style=' vertical-align:top; cursor:pointer;' src='../img/icons/edit.png' onclick='javascript:editarparticipante(\"".$idregentdep."\",\"".$this->utf8($nombre)."\",\"".$this->utf8($app)."\",\"".$this->utf8($apm)."\",\"".$idestado."\",\"".$genero."\",\"".$curp."\",\"".$fechanac."\");'/><p></p><p></p><img class=\"imgborrarparticipante\" style=' vertical-align:top; cursor:pointer;' src='../img/icons/delete.png' onclick='javascript:eliminarparticipante(\"".$idregentdep."\");'/></td>
						<td>$fotop</td>
						<td style=\"text-align:center\"><a href=\"../modulos/sitd_mod_guardaraplicar_catprueba.php?id=$idregentdep&tipo=edit&texto=Editar Prueba\">$nombre</a></td>
						<td style=\"text-align:center\"><a href=\"../modulos/sitd_mod_guardaraplicar_catprueba.php?id=$idregentdep&tipo=edit&texto=Editar Prueba\">$app</a></td>
						<td style=\"text-align:center\"><a href=\"../modulos/sitd_mod_guardaraplicar_catprueba.php?id=$idregentdep&tipo=edit&texto=Editar Prueba\">$apm</a></td>
						<td style=\"text-align:center\">$estado</td>
						<td style=\"text-align:center\">$fechanac</td>	
						<td style=\"text-align:center\">$genero</td>	
						<td style=\"text-align:center\">$curp</td>	
						<td style=\"text-align:center\">$fechahorareg</td>	
						<td style=\"text-align:center\">$nombre $appaterno $apmaterno</td>													
						<td style=\"text-align:center\">$idregentdep</td>
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
	
	function cargareditarCatPrueba()
	{			 
	         /*$consulta = parent::consulta("
			 SELECT 
			 ca.id_categoria as idcategoria,			 
			 ca.id_eventonacional as idevenac,
			 en.cat_eventonacional_nombre as nombreevenac,
			 ca.id_deportes as iddeporte,
			 ca.id_moddep as idmoddep,
			 ca.id_rama as idrama,
			 ca.cat_categoria_anofin as catanofin,
			 ca.cat_categoria_anoinicio as catanoinicio,
			 ca.cat_categoria_nombre as catnombre,
			 de.cat_deportes_nombre as depnombre,			
			 md.cat_moddep_nombre as moddepnombre,			 
			 ra.cat_rama_nombre as ramanombre,			 
             ru.reg_usuario_nombre as usuarionomcompleto
			 FROM 
			 ((((((cat_categoria as ca inner join cat_eventonacional as en on ca.id_eventonacional = en.id_eventonacional and             ca.id_categoria) inner join 
             cat_deportes as de on ca.id_deportes = de.id_deportes) inner join
             cat_moddep as md on ca.id_moddep = md.id_moddep) inner join
             cat_rama as ra on ca.id_rama = ra.id_rama) inner join
             reg_usuario as ru on ca.id_usuario = ru.id_usuario) left join
             cat_prueba as p on p.id_categoria = ca.id_categoria and p.id_prueba = ".$this->id.") "GROUP BY ca.id_categoria);*/        
			 
			 $consulta = parent::consulta("SELECT 	
					 cat.id_eventonacional as ideventonacional,
                     CONCAT('[',dep.cat_deportes_nombre,'] (',rama.cat_rama_nombre,')] ',cat.cat_categoria_nombre,' (',cat.cat_categoria_anoinicio,'-',cat.cat_categoria_anofin,')',', ',moddep.cat_moddep_nombre) as categoria,                   
			         cat.id_categoria as idcategoria,        					
			         dep.cat_deportes_nombre as deporte,
					 dep.id_deportes as iddeporte,					 
					 rama.cat_rama_nombre as rama,
					 rama.id_rama as idrama,
					 moddep.cat_moddep_nombre as moddep,
					 moddep.id_moddep as idmoddep,
					 pru.cat_prueba_nombre as prueba,
					 pru.id_prueba as idprueba					 
					 FROM ((((cat_categoria as cat inner join cat_prueba as pru on cat.id_categoria = pru.id_categoria and pru.id_prueba = ".$this->id.")
						  inner join cat_deportes as dep on cat.id_deportes = dep.id_deportes) 
						  inner join cat_rama as rama on cat.id_rama = rama.id_rama)
						  inner join cat_moddep as moddep on cat.id_moddep = moddep.id_moddep)");
			 
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