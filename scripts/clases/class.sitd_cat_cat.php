<?php
error_reporting(E_ALL);
class catcat extends MySQL
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
	
	function grabarCatCat()
    {
	   $consulta = parent::consulta("SELECT cat_categoria_nombre FROM cat_categoria WHERE cat_categoria_nombre = '".$this->nombrecat."' and id_eventonacional = ".$this->eventonacional." and cat_categoria_anofin = ".$this->catanofin." and cat_categoria_anoinicio = ".$this->catanoinicio. " and id_deportes = ".$this->filter_deportes);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {			
		 //se registrara una nueva categoria		  
		 $consulta = parent::consulta("INSERT INTO cat_categoria (cat_categoria_nombre, id_eventonacional, id_usuario, cat_categoria_anofin, cat_categoria_anoinicio, id_moddep, id_rama, id_deportes) VALUES ('".$this->nombrecat."',".$this->eventonacional.",".$this->idusuario.",".$this->catanofin.",".$this->catanoinicio.",".$this->filter_moddep.",".$this->filter_rama.",".$this->filter_deportes.")");	  
		 
		 if($this->pruebas != ''){		 
			 $id_insert_categoria = mysql_insert_id();		   
			 $lista = explode('<&>', $this->pruebas);
			 foreach ($lista as $pruebas){	
				$consulta = parent::consulta("SELECT cat_prueba_nombre FROM cat_prueba WHERE cat_prueba_nombre = '".$pruebas."' and id_categoria = ".$id_insert_categoria);
			   $num_total_registros = parent::num_rows($consulta);
			   if($num_total_registros==0)
				{		
				   $consulta = parent::consulta("INSERT INTO cat_prueba (cat_prueba_nombre, id_categoria, id_usuario) VALUES ('".$pruebas."',".$id_insert_categoria.",".$this->idusuario.")");	  		   
				}
			 }		 
		 }
		 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente la categoria..."}';	
	   }
	  else
	   {	 
		 return '{"tipo":"error","mensaje":"Categoria ya Existe, verifique..."}';
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
	
	function aplicarCatRama()
	{	
	   $consulta = parent::consulta("SELECT cat_rama_nombre FROM cat_rama WHERE cat_rama_nombre = '".$this->nombrerama."' and id_eventonacional = ".$this->eventonacional);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {
			 $consulta = parent::consulta("UPDATE cat_rama SET cat_rama_nombre = '".$this->nombrerama."', id_eventonacional = ".$this->eventonacional.", id_usuario=".$this->idusuario." WHERE id_rama = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente la rama..."}';
		}else{
			
		}
	   return '{"tipo":"error","mensaje":"Nombre de rama existente para Evento Nacional..."}';
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
	
    function ListaComboCat()
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
	
	function mostrarCatCat()
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
			 ca.id_categoria as idcategoria,			 
			 ca.id_deportes as iddeporte,
			 ca.id_eventonacional as idevenac,
			 en.cat_eventonacional_nombre as nombreevenac,
			 ca.id_moddep as idmoddep,
			 ca.id_rama as idrama,
			 ca.cat_categoria_anofin as catanofin,
			 ca.cat_categoria_anoinicio as catanoinicio,
			 ca.cat_categoria_nombre as catnombre,
			 de.cat_deportes_nombre as depnombre,
			 md.cat_moddep_nombre as moddepnombre,
			 ra.cat_rama_nombre as ramanombre,
             ru.reg_usuario_nombre as nombre,
			 ru.reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 GROUP_CONCAT(DISTINCT p.cat_prueba_nombre SEPARATOR ', ') AS pruebas       
			 FROM 
			 ((((((cat_categoria as ca inner join cat_eventonacional as en on ca.id_eventonacional = en.id_eventonacional and             ca.id_usuario = ".$this->idusuario.") inner join 
             cat_deportes as de on ca.id_deportes = de.id_deportes) inner join
             cat_moddep as md on ca.id_moddep = md.id_moddep) inner join
             cat_rama as ra on ca.id_rama = ra.id_rama) inner join
             reg_usuario as ru on ca.id_usuario = ru.id_usuario) left join
             cat_prueba as p on p.id_categoria = ca.id_categoria) ".$criterios_FILTRO." GROUP BY ca.id_categoria ".$criterios_ORDEN.$criterios_LIMITE);
	  
		  $consulta_totalregistro = parent::consulta("
			 SELECT 
			 ca.id_categoria as idcategoria,			 
			 ca.id_deportes as iddeporte,
			 ca.id_eventonacional as idevenac,
			 en.cat_eventonacional_nombre as nombreevenac,
			 ca.id_moddep as idmoddep,
			 ca.id_rama as idrama,
			 ca.cat_categoria_anofin as catanofin,
			 ca.cat_categoria_anoinicio as catanoinicio,
			 ca.cat_categoria_nombre as catnombre,
			 de.cat_deportes_nombre as depnombre,
			 md.cat_moddep_nombre as moddepnombre,
			 ra.cat_rama_nombre as ramanombre,
             ru.reg_usuario_nombre as nombre,
			 ru.reg_usuario_appaterno as appaterno,
			 ru.reg_usuario_apmaterno as apmaterno,
             GROUP_CONCAT(DISTINCT p.cat_prueba_nombre SEPARATOR ', ') AS pruebas
			 FROM 
			 ((((((cat_categoria as ca inner join cat_eventonacional as en on ca.id_eventonacional = en.id_eventonacional and             ca.id_usuario = ".$this->idusuario.") inner join 
             cat_deportes as de on ca.id_deportes = de.id_deportes) inner join
             cat_moddep as md on ca.id_moddep = md.id_moddep) inner join
             cat_rama as ra on ca.id_rama = ra.id_rama) inner join
             reg_usuario as ru on ca.id_usuario = ru.id_usuario) left join
             cat_prueba as p on p.id_categoria = ca.id_categoria) ".$criterios_FILTRO." GROUP BY ca.id_categoria ");
		  
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
                        <a href=\"javascript:tableOrdering('cat_categoria_nombre','".$fg->ordena('cat_categoria_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Categoria".$fg->ordenaimg('cat_categoria_nombre',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('cat_categoria_anoinicio','".$fg->ordena('cat_categoria_anoinicio',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">A&ntilde;o Inicio".$fg->ordenaimg('cat_categoria_anoinicio',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('cat_categoria_anofin','".$fg->ordena('cat_categoria_anofin',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">A&ntilde;o Fin".$fg->ordenaimg('cat_categoria_anofin',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('de.cat_deportes_nombre','".$fg->ordena('de.cat_deportes_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Deporte".$fg->ordenaimg('de.cat_deportes_nombre',$this->campo,$this->orden)."</a>
                    </th>
                    
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('md.cat_moddep_nombre','".$fg->ordena('md.cat_moddep_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Modalidad Deporte".$fg->ordenaimg('md.cat_moddep_nombre',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('ra.cat_rama_nombre','".$fg->ordena('ra.cat_rama_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Rama".$fg->ordenaimg('ra.cat_rama_nombre',$this->campo,$this->orden)."</a>
                    </th>				
										
                    <th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_eventonacional_nombre','".$fg->ordena('cat_eventonacional_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Evento Nacional".$fg->ordenaimg('cat_eventonacional_nombre',$this->campo,$this->orden)."</a>				 
                    </th>
										   
                    <th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('reg_usuario_nombre','".$fg->ordena('reg_usuario_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Usuario".$fg->ordenaimg('reg_usuario_nombre',$this->campo,$this->orden)."</a>		
                    </th>
					
					<th width=\"8%\" class=\"title\" nowrap=\"nowrap\">Pruebas</th>
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('ca.id_categoria','".$fg->ordena('ca.id_categoria',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('ca.id_categoria',$this->campo,$this->orden)."</a>
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
				while($catcat = parent::fetch_array($consulta))
				{				
					extract($catcat);			
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"$idcategoria\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$idcategoria\"/></td>				
						<td style=\"text-align:center\"><a href=\"../modulos/sitd_mod_guardaraplicar_catcat.php?id=$idcategoria&tipo=edit&texto=Editar Categoria\">$catnombre</a></td>
						<td style=\"text-align:center\">$catanoinicio</td>
						<td style=\"text-align:center\">$catanofin</td>	
						<td style=\"text-align:center\">$depnombre</td>	
						<td style=\"text-align:center\">$moddepnombre</td>	
						<td style=\"text-align:center\">$ramanombre</td>	
						<td style=\"text-align:center\">$nombreevenac</td>	
						<td style=\"text-align:center\">$depnombre</td>					
						<td style=\"text-align:center\">$pruebas</td>	
						<td style=\"text-align:center\">$idcategoria</td>
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
	
	function cargareditarCatCat()
	{			 
	         $consulta = parent::consulta("
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
             ru.reg_usuario_nombre as nombre,
			 ru.reg_usuario_appaterno as appaterno,
			 ru.reg_usuario_apmaterno as apmaterno,
			 GROUP_CONCAT(DISTINCT p.cat_prueba_nombre SEPARATOR ', ') AS pruebas       
			 FROM 
			 ((((((cat_categoria as ca inner join cat_eventonacional as en on ca.id_eventonacional = en.id_eventonacional and             ca.id_categoria = ".$this->id.") inner join 
             cat_deportes as de on ca.id_deportes = de.id_deportes) inner join
             cat_moddep as md on ca.id_moddep = md.id_moddep) inner join
             cat_rama as ra on ca.id_rama = ra.id_rama) inner join
             reg_usuario as ru on ca.id_usuario = ru.id_usuario) left join
             cat_prueba as p on p.id_categoria = ca.id_categoria) GROUP BY ca.id_categoria");        
	       		 
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