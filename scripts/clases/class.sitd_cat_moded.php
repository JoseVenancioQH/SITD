<?php
error_reporting(E_ALL);
class catmoded extends MySQL
{   
    var $pagina = '';
	var $paginado = '';
	var $limite = '';
	var $filtro = '';
	var $campo = '';
	var $orden = '';
	
	var $idempresa = '';
	var $nombrecatmoded = '';
	var $appaternocliente = '';
	var $apmaternocliente = '';
	var $dircliente = '';
	var $telcasa = '';
	var $telcel = '';
	var $rfccliente = '';
	var $municipio = '';
	var $eventonacional = '';
	
	
	var $id = '';
	
	var $ids = '';
	var $tipo = '';
	var $idusuario = '';
	
	function mostrarTipoFiscal()
	 {
		$consulta = parent::consulta("SELECT tb_empresa_tipofiscal FROM tb_empresa");
		$num_total_registros = parent::num_rows($consulta);	
		if($num_total_registros>0)
		{						
		        print "<option value=\"\"  selected=\"selected\">- Selecciona Tipo Fiscal -</option>";
				while($tipofiscal = parent::fetch_array($consulta))
				{				
					extract($tipofiscal);				
					print "<option value=\"".$tb_empresa_tipofiscal."\" >".$tb_empresa_tipofiscal."</option>";				
				}										
		}
		else
		{
			print "";
		}
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
	 
	 function listar_moded($catalogo,$ids,$idusuario)
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
						
	function statusClientes()
	{		    
	    $array_ids = array();
		$act=($this->tipo == 'habilitar') ? 1 : 0;
		
		foreach (explode(',',$this->ids) as $id_act){			    
				$consulta = parent::consulta("UPDATE tb_cliente SET tb_cliente_activado = $act WHERE id_cliente = ".$id_act);
		        if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
		}
	    return implode(',',$array_ids);
	}
	
	function borrarCatModed()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){			    
				$consulta = parent::consulta("DELETE FROM cat_moded where id_moded = ".$id_act);
		        if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
		}
	    return implode(',',$array_ids);
	}
		
	function mostrarCatModed()
	{
		include("class.fg.php");
		$fg = new fg();		
		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";	
		  $criterios_eventonacional ="";
		  
		  if($this->filtro!='') $criterios_FILTRO = " m.cat_moded_nombre LIKE \"%".$this->filtro."%\"";	 
		  
		  if($this->eventonacional!='') $criterios_eventonacional = " And en.id_eventonacional = ".$this->eventonacional;
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
			 m.id_usuario as idusuario, 
			 reg_usuario_nombre as nombre,
			 reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 cat_moded_nombre as nombrecatmoded,
			 cat_eventonacional_nombre as eventonacional,
			 id_moded as idcatmoded
			 FROM 
			 (cat_moded as m inner join cat_eventonacional as en on m.id_eventonacional = en.id_eventonacional) inner join reg_usuario as u on m.id_usuario = u.id_usuario and m.id_usuario = ".$this->idusuario." ".$criterios_FILTRO.$criterios_ORDEN.$criterios_LIMITE);
		  
		  $consulta_totalregistro = parent::consulta("
			 SELECT 
			 m.id_usuario as idusuario, 
			 reg_usuario_nombre as nombre,
			 reg_usuario_appaterno as appaterno,
			 reg_usuario_apmaterno as apmaterno,
			 cat_moded_nombre as nombremoded,
			 cat_eventonacional_nombre as eventonacional,
			 id_moded as idmoded
			 FROM 
			 (cat_moded as m inner join cat_eventonacional as en on m.id_eventonacional = en.id_eventonacional) inner join reg_usuario as u on m.id_usuario = u.id_usuario and m.id_usuario = ".$this->idusuario." ".$criterios_FILTRO);
		  
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
                        <a href=\"javascript:tableOrdering('cat_moded_nombre','".$fg->ordena('cat_moded_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Modalidad Ente Deportivo".$fg->ordenaimg('cat_moded_nombre',$this->campo,$this->orden)."</a>
                    </th>					
                    
                    <th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('cat_eventonacional_nombre','".$fg->ordena('cat_eventonacional_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Evento Nacional".$fg->ordenaimg('cat_eventonacional_nombre',$this->campo,$this->orden)."</a>				 
                    </th>
										   
                    <th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('reg_usuario_nombre','".$fg->ordena('reg_usuario_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Usuario".$fg->ordenaimg('reg_usuario_nombre',$this->campo,$this->orden)."</a>		
                    </th>	
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('id_moded','".$fg->ordena('id_moded',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('id_moded',$this->campo,$this->orden)."</a>
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
				while($catmoded = parent::fetch_array($consulta))
				{				
					extract($catmoded);			
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"$idcatmoded\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$idcatmoded\"/></td>				
						<td style=\"text-align:center\"><a href=\"../modulos/sitd_mod_guardaraplicar_catmoded.php?id=$idcatmoded&tipo=edit&texto=Editar Modalidad Ente Deportivo\">$nombrecatmoded</a></td>
						<td style=\"text-align:center\">$eventonacional</td>
						<td style=\"text-align:center\">$nombre</td>																	
						<td style=\"text-align:center\">$idcatmoded</td>
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
	
	function grabartodoCatModed()
    {		
	    $array_ids = array();
		$insert_affected_moded = '';
	    foreach (explode('<&>',$this->nombrecatmoded) as $id_act){			
		   $consulta = parent::consulta("SELECT id_moded FROM cat_moded where cat_moded_nombre = '".$id_act."' And id_eventonacional = ".$this->eventonacional." And id_usuario = ".$this->idusuario);
		   $num_total_registros = parent::num_rows($consulta);		   					
		   if($num_total_registros==0)
	       {			   
 	         $consulta = parent::consulta("INSERT INTO cat_moded (cat_moded_nombre, id_eventonacional, id_usuario) VALUES ('".$id_act."',".$this->eventonacional.",".$this->idusuario.")");		   
			 $insert_affected_moded .= (mysql_affected_rows() > 0)?'':' <'.$id_act.'> ';											  			
		   }else{$insert_affected_moded .= ' <'.$id_act.'> ';}		   
		}	
		return ($insert_affected_moded == '')?'{"tipo":"succes","mensaje":"'.$insert_affected_moded.'Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"'.$insert_affected_moded.' Error al registrar, Verifique, Duplicidad..."}';		  
    }
	
    function grabarCatModed()
	{ 	
	  $consulta = parent::consulta("SELECT cat_moded_nombre FROM cat_moded WHERE cat_moded_nombre = '".$this->nombrecatmoded."' and id_eventonacional = ".$this->eventonacional);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {				  
		  //se registrara un nuevo auto\		  
		  $consulta = parent::consulta("INSERT INTO cat_moded (cat_moded_nombre, id_eventonacional, id_usuario) VALUES ('".$this->nombrecatmoded."',".$this->eventonacional.",".$this->idusuario.")");	  
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente la rama..."}';	
	   }
	  else
	   {		   
		 //$mensaje['tipo']='error';$mensaje['mensaje']='N&uacute;mero de Serie del Auto Existente';  
		 return '{"tipo":"error","mensaje":"Rama ya Existe, verifique..."}';
	   }	
	}

    function aplicarCatModed()
	{				  
		$consulta = parent::consulta("SELECT cat_moded_nombre FROM cat_moded WHERE cat_moded_nombre = '".$this->nombrecatmoded."' and id_eventonacional = ".$this->eventonacional);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {
		$consulta = parent::consulta("UPDATE cat_moded SET cat_moded_nombre = '".$this->nombrecatmoded."', id_eventonacional = ".$this->eventonacional.", id_usuario=".$this->idusuario." WHERE id_moded = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente el Evento Nacional..."}';
		}else{
			
		}
	    return '{"tipo":"error","mensaje":"Evento Nacional Existente..."}';	
	}	


    function cargareditarCatModed()
	{			 
	         $consulta = parent::consulta("SELECT 
			 r.id_usuario as idusuario, 			 
			 cat_moded_nombre as nombremoded,
			 cat_eventonacional_nombre as eventonacional,
			 r.id_eventonacional as ideventonacional,
			 id_moded as idmoded
			 FROM 
			 cat_moded as r inner join cat_eventonacional as en on r.id_eventonacional = en.id_eventonacional where id_moded = ".$this->id);
	       		 
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

    function mostrarNombresClientes()
	{			 
	        $consulta = parent::consulta("SELECT 
			 r.id_usuario as idusuario, 			 
			 cat_moded_nombre as nombremoded,
			 cat_eventonacional_nombre as eventonacional,
			 r.id_eventonacional as ideventonacional,
			 id_moded as idmoded
			 FROM 
			 cat_moded as r inner join cat_eventonacional as en on r.id_eventonacional = en.id_eventonacional where id_moded = ".$this->id);
	       		 
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