<?php
error_reporting(E_ALL);
class catevenac extends MySQL
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
	var $modelo = '';
	var $linea = '';		
	var $cilindros = '';
	var $color = '';
	var $comext = '';
	var $comint = '';
	var $acc = '';
	var $commec = '';
	var $nombreevenac = '';
	var $fechainicio = '';
	var $fechatermina = '';
	
	var $catalogo = '';	
	var $id = '';	
	var $ids = '';
	var $tipo = '';	
	var $foto = '';
	var $idusuario = '';
	
	function statusCatEveNac()
	{		    
	    $array_ids = array();
		$act=($this->tipo == 'habilitar') ? 1 : 0;
		
		foreach (explode(',',$this->ids) as $id_act){			
		         $consulta = parent::consulta("SELECT id_eventonacional FROM cat_eventonacional as e WHERE e.id_eventonacional = ".$id_act);
				 $num_total_registros = parent::num_rows($consulta);
				 if($num_total_registros!=0)
				  {
					$consulta = parent::consulta("UPDATE cat_eventonacional SET cat_eventonacional_status = $act WHERE id_eventonacional = ".$id_act);
					if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
				  }
		}
		
	    return implode(',',$array_ids);
	}
	
	function borrarCatEveNac()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){	
		         $consulta = parent::consulta("SELECT id_eventonacional FROM cat_eventonacional as e WHERE e.id_eventonacional = ".$id_act);
				 $num_total_registros = parent::num_rows($consulta);
				 if($num_total_registros!=0)
				  {	
					$consulta = parent::consulta("DELETE FROM cat_eventonacional where id_eventonacional = ".$id_act);
					if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
				  }				
		}
	    return implode(',',$array_ids);
	}
	
	function grabarEveNac()
    {
	   $consulta = parent::consulta("SELECT cat_eventonacional_nombre FROM cat_eventonacional WHERE cat_eventonacional_nombre = '".$this->nombreevenac."'");
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {		 
		  //se registrara un nuevo evento		  
		  $consulta = parent::consulta("INSERT INTO cat_eventonacional (cat_eventonacional_nombre, cat_eventonacional_fechainicio, cat_eventonacional_fechaterminacion, cat_eventonacional_status, id_usuario) VALUES ('".$this->nombreevenac."','".date('Y-m-d', strtotime ($this->fechainicio))."','".date('Y-m-d', strtotime ($this->fechatermina))."',"."1".",".$this->idusuario.")");	  
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente el Evento Nacional..."}';
		}
	  else
	   {		   
		 //$mensaje['tipo']='error';$mensaje['mensaje']='N&uacute;mero de Serie del Auto Existente';  
		 return '{"tipo":"error","mensaje":"Evento Nacional ya Existe, verifique..."}';
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
	
	function aplicarEveNac()
	{	
	   $consulta = parent::consulta("SELECT cat_eventonacional_nombre FROM cat_eventonacional WHERE cat_eventonacional_nombre = '".$this->nombreevenac."' and cat_eventonacional_fechainicio = '".date('Y-m-d', strtotime ($this->fechainicio))."' and cat_eventonacional_fechaterminacion = '".date('Y-m-d', strtotime ($this->fechatermina))."' and id_usuario = ".$this->idusuario);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {
			 $consulta = parent::consulta("UPDATE cat_eventonacional SET cat_eventonacional_nombre = '".$this->nombreevenac."', cat_eventonacional_fechainicio = '".date('Y-m-d', strtotime ($this->fechainicio))."', cat_eventonacional_fechaterminacion = '".date('Y-m-d', strtotime ($this->fechatermina))."' WHERE id_eventonacional = ".$this->id);		 			 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente el Evento Nacional..."}';
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
		echo "<select name='filter_".$catalogo."_all' id='filter_".$catalogo."_all' class='validate[required] inputbox' multiple='yes'>";		
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
	
	function mostrarCatEveNac()
	{
		include("class.fg.php");
		$fg = new fg();		
		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";	
		  $criterios_eventonacional ="";
		  
		  if($this->filtro!='') $criterios_FILTRO = " e.cat_eventonacional_nombre LIKE \"%".$this->filtro."%\"";	 
		  
		  /*if($this->eventonacional!='') $criterios_eventonacional = " And en.id_eventonacional = ".$this->eventonacional;*/
		  
		  /*if($this->modelo!='') $criterios_modelo = " And mo.id_modelo = ".$this->modelo;
		  if($this->linea!='') $criterios_linea = " And li.id_linea = ".$this->linea;
		  if($this->tipo!='') $criterios_tipo = " And ti.id_tipo = ".$this->tipo;
		  if($this->color!='') $criterios_color = " And co.id_color = ".$this->color;*/
		  
		  $criterio_SELECT = $criterios_eventonacional;	  
		  
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
			 e.id_usuario as idusuario, 
			 reg_usuario_nombre as nombre,
			 reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 cat_eventonacional_nombre as nombreevenac,
			 cat_eventonacional_fechaterminacion as fechaterminacionevenac,
			 cat_eventonacional_fechainicio as fechainicioevenac,
			 cat_eventonacional_status as statusevenac,
			 id_eventonacional as idevenac
			 FROM 
			 cat_eventonacional as e inner join reg_usuario as u on e.id_usuario = u.id_usuario and e.id_usuario = ".$this->idusuario." ".$criterios_FILTRO.$criterios_ORDEN.$criterios_LIMITE);
		  
		  $consulta_totalregistro = parent::consulta("
			 SELECT 
			 e.id_usuario as idusuario, 
			 reg_usuario_nombre as nombre, 
			 reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 cat_eventonacional_nombre as nombreevenac,
			 cat_eventonacional_fechaterminacion as fechaterminacionevenac,
			 cat_eventonacional_fechainicio as fechainicioevenac,
 			 cat_eventonacional_status as statusevenac,
			 id_eventonacional as idevenac
			 FROM 
			 cat_eventonacional as e inner join reg_usuario as u on e.id_usuario = u.id_usuario and e.id_usuario = ".$this->idusuario." ".$criterios_FILTRO);
		  
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
                        <a href=\"javascript:tableOrdering('cat_eventonacional_nombre','".$fg->ordena('cat_eventonacional_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Evento Nacional".$fg->ordenaimg('cat_eventonacional_nombre',$this->campo,$this->orden)."</a>
                    </th>					
                    
                    <th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_eventonacional_fechainicio','".$fg->ordena('cat_eventonacional_fechainicio',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Fecha Inicio Evento Nacional".$fg->ordenaimg('cat_eventonacional_fechainicio',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_eventonacional_fechaterminacion','".$fg->ordena('cat_eventonacional_fechaterminacion',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Fecha Terminaci&oacute;n Evento Nacional".$fg->ordenaimg('cat_eventonacional_fechaterminacion',$this->campo,$this->orden)."</a>				 
                    </th>
										   
                    <th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('reg_usuario_nombre','".$fg->ordena('reg_usuario_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Usuario".$fg->ordenaimg('reg_usuario_nombre',$this->campo,$this->orden)."</a>		
                    </th>	
					
					<th width=\"5%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('cat_eventonacional_status','".$fg->ordena('cat_eventonacional_status',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Habilitado".$fg->ordenaimg('cat_eventonacional_status',$this->campo,$this->orden)."</a>		
                    </th>
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('id_eventonacional','".$fg->ordena('id_eventonacional',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('id_eventonacional',$this->campo,$this->orden)."</a>
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
				while($catevenac = parent::fetch_array($consulta))
				{				
					extract($catevenac);			
					
					if($statusevenac==1) $img_status = '<a href="#" onclick="javascript:changestatus(\'deshabilitar\','.$idevenac.')"><img src="../images/habilitar.png" width="16" height="16" border="0" alt="" /></a>'; else $img_status = '<a href="#" onclick="javascript:changestatus(\'habilitar\','.$idevenac.')"><img src="../images/deshabilitar.png" width="16" height="16" border="0" alt="" /></a>';
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"$idevenac\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$idevenac\"/></td>				
						<td style=\"text-align:center\"><a href=\"../modulos/sitd_mod_guardaraplicar_catevenac.php?id=$idevenac&tipo=edit&texto=Editar Evento Nacional\">$nombreevenac</a></td>
						<td style=\"text-align:center\">".$fg->fechalarga($fechainicioevenac)/*[2]->dia, [1]->mes, [0]->año*/."</td>
						<td style=\"text-align:center\">".$fg->fechalarga($fechaterminacionevenac)/*[2]->dia, [1]->mes, [0]->año*/."</td>
						<td style=\"text-align:center\">$nombre</td>			
						<td id=\"status$idevenac\" style=\"text-align:center\">$img_status</td>
						<td style=\"text-align:center\">$idevenac</td>
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
	
	function cargareditarCatEveNac()
	 {			 
	        $consulta = parent::consulta("SELECT 
			 id_usuario as idusuario, 			 
			 cat_eventonacional_nombre as nombreevenac,			 
			 cat_eventonacional_fechaterminacion as fechatermina,
			 cat_eventonacional_fechainicio as fechainicio,
			 id_eventonacional as ideventonacional
			 FROM 
			 cat_eventonacional where id_eventonacional = ".$this->id);
	       		 
			 $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros>0)
			 {
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {		    
			     $actual['fechatermina'] = date('d-m-Y', strtotime ($actual['fechatermina']));
				 $actual['fechainicio'] = date('d-m-Y', strtotime ($actual['fechainicio']));
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