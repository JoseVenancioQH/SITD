<?php
error_reporting(E_ALL);
class invcosto extends MySQL
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
	var $idauto = '';	
	var $tipocosto = '';
	var $psiniva = '';
	var $anticipo = '';	
	var $pcontado = '';		
	
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
	var $marca = '';
	var $modelo = '';
	var $linea = '';		
	var $cilindros = '';
	var $color = '';
	var $comext = '';
	var $comint = '';
	var $acc = '';
	var $commec = '';
	
	var $catalogo = '';	
	var $id = '';	
	var $ids = '';
	var $tipo = '';	
	var $foto = '';
	
	function mostrarInvCosto()
	{			 
	         $consulta = parent::consulta("SELECT 
				   id_auto as idauto, 
				   tb_auto_noserie as noserie,
				   tb_auto_nopedimento as nopedimento,
				   tb_auto_activado as activado,
				   cat_marca_nombre as marca,
				   cat_modelo_nombre as modelo,
				   cat_linea_nombre as linea,
				   cat_tipo_nombre as tipo
				   FROM (((((tb_auto as a inner join
				   cat_marca as ma on a.id_marca = ma.id_marca and a.id_empresa = ".$this->idempresa.") inner join 
				   cat_modelo as mo on a.id_modelo = mo.id_modelo) inner join
				   cat_linea as li on a.id_linea = li.id_linea) inner join
				   cat_tipo as ti on a.id_tipo = ti.id_tipo) inner join
				   cat_cilindros as ci on a.id_cilindros = ci.id_cilindros) inner join
				   cat_color as co on a.id_color = co.id_color");		 
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
			   return "";
			 }
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
	
	function borrarInvCosto()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){	
		         $consulta = parent::consulta("SELECT id_costoventa FROM tb_costoventa as c WHERE c.id_costoventa = ".$id_act);
				 $num_total_registros = parent::num_rows($consulta);
				 if($num_total_registros!=0)
				  {	
					$consulta = parent::consulta("DELETE FROM tb_costoventa where id_costoventa = ".$id_act);
					if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
				  }				
		}
	    return implode(',',$array_ids);
	}
	
	function grabarInvCosto()
    {
	   /*$consulta = parent::consulta("SELECT tb_auto_noserie FROM tb_costoventa WHERE tb_auto_noserie = '".$this->noserie."' and id_empresa = ".$this->idempresa);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {*/		 
		  //se registrara un nuevo auto\		  
		
		  $consulta = parent::consulta("INSERT INTO tb_costoventa (tb_costoventa_tipo, tb_costoventa_psiniva, tb_costoventa_anticipo,tb_costoventa_contado,id_auto) VALUES ('".$this->tipocosto."',".$this->psiniva.",".$this->anticipo.",".$this->pcontado.",".$this->idauto.")");	  		  
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente el costo del auto..."}';	
	  /* }
	  else
	   {		   
		 //$mensaje['tipo']='error';$mensaje['mensaje']='N&uacute;mero de Serie del Auto Existente';  
		 return '{"tipo":"error","mensaje":"N&uacute;mero de Serie del Auto ya Existe..."}';
	   }	*/  
    }
	
	function aplicarInvCosto()
	{	
	   /*$consulta = parent::consulta("SELECT tb_auto_noserie FROM tb_auto WHERE tb_auto_noserie = '".$this->noserie."' and id_empresa = ".$this->idempresa." and id_auto <> ".$this->id);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	    {*/
			 $consulta = parent::consulta("UPDATE tb_costoventa SET tb_costoventa_tipo = '".$this->tipocosto."', tb_costoventa_psiniva = ".$this->psiniva.", tb_costoventa_anticipo=".$this->anticipo.", tb_costoventa_contado = ".$this->pcontado." , id_auto = ".$this->idauto." WHERE id_costoventa = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente el auto..."}';
		/*}else{
			
		}
	   return '{"tipo":"error","mensaje":"N&uacute;mero de Serie del Auto ya esta ASIGNADO..."}';*/
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
	
	function listar_catalogo($catalogo,$idempresa)
	{		
	    $consulta = parent::consulta("SELECT * FROM cat_".$catalogo." where id_empresa = ".$idempresa);		
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
	
	function mostrarInvAutoCosto()
	{
		include("class.fg.php");
		$fg = new fg();		
		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";	
		  $criterios_marca ="";$criterios_modelo ="";$criterios_linea ="";$criterios_tipo ="";$criterios_color ="";
		  
		  if($this->filtro!='') $criterios_FILTRO = " a.tb_auto_noserie LIKE \"%".$this->filtro."%\" OR a.tb_auto_nopedimento LIKE \"%".$this->filtro."%\" OR ma.cat_marca_nombre LIKE \"%".$this->filtro."%\" OR mo.cat_modelo_nombre LIKE \"%".$this->filtro."%\" OR li.cat_linea_nombre LIKE \"%".$this->filtro."%\" OR co.cat_color_nombre LIKE \"%".$this->filtro."%\"";	 
		  
		  if($this->marca!='') $criterios_marca = " And ma.id_marca = ".$this->marca;
		  if($this->modelo!='') $criterios_modelo = " And mo.id_modelo = ".$this->modelo;
		  if($this->linea!='') $criterios_linea = " And li.id_linea = ".$this->linea;
		  if($this->tipo!='') $criterios_tipo = " And ti.id_tipo = ".$this->tipo;
		  if($this->color!='') $criterios_color = " And co.id_color = ".$this->color;
		  
		  $criterio_SELECT = $criterios_marca.$criterios_modelo.$criterios_linea.$criterios_tipo.$criterios_color;	  
		  
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
			 tb_auto_noserie as noserie,
			 tb_auto_nopedimento as nopedimento,
			 tb_auto_activado as activado,
			 cat_marca_nombre as marca,
			 cat_modelo_nombre as modelo,
			 cat_linea_nombre as linea,
			 cat_tipo_nombre as tipo,
			 cat_cilindros_nombre as cilindros,
			 cat_color_nombre as color,
			 tb_costoventa_tipo as tipocosto,
			 tb_costoventa_psiniva as psiniva,
			 tb_costoventa_anticipo as anticipo,
			 tb_costoventa_contado as contado,
			 id_costoventa
			 FROM 
			 (((((((tb_auto as a inner join tb_costoventa as cv on a.id_auto = cv.id_auto and a.id_empresa = ".$this->idempresa.") inner join
				   cat_marca as ma on a.id_marca = ma.id_marca) inner join 
				   cat_modelo as mo on a.id_modelo = mo.id_modelo) inner join
				   cat_linea as li on a.id_linea = li.id_linea) inner join
				   cat_tipo as ti on a.id_tipo = ti.id_tipo) inner join
				   cat_cilindros as ci on a.id_cilindros = ci.id_cilindros) inner join
				   cat_color as co on a.id_color = co.id_color) ".$criterios_FILTRO.$criterios_ORDEN.$criterios_LIMITE);
		  
		  $consulta_totalregistro = parent::consulta("
			 SELECT
			 tb_auto_noserie as noserie,
			 tb_auto_nopedimento as nopedimento,
			 cat_marca_nombre as marca,
			 cat_modelo_nombre as modelo,
			 cat_linea_nombre as linea,
			 cat_tipo_nombre as tipo,
			 cat_cilindros_nombre as cilindros,
			 cat_color_nombre as color,
			 id_costoventa
			 FROM 
			 (((((((tb_auto as a inner join tb_costoventa as cv on a.id_auto = cv.id_auto and a.id_empresa = ".$this->idempresa.") inner join
				   cat_marca as ma on a.id_marca = ma.id_marca) inner join 
				   cat_modelo as mo on a.id_modelo = mo.id_modelo) inner join
				   cat_linea as li on a.id_linea = li.id_linea) inner join
				   cat_tipo as ti on a.id_tipo = ti.id_tipo) inner join
				   cat_cilindros as ci on a.id_cilindros = ci.id_cilindros) inner join
				   cat_color as co on a.id_color = co.id_color) ".$criterios_FILTRO);
		  
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
					
					<th width=\"10%\" class=\"title\">Imagenes</th>
					
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('tb_costoventa_tipo','".$fg->ordena('tb_costoventa_tipo',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Tipo Costo".$fg->ordenaimg('tb_costoventa_tipo',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('tb_costoventa_psiniva','".$fg->ordena('tb_costoventa_psiniva',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Precio sin IVA".$fg->ordenaimg('tb_costoventa_psiniva',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('tb_costoventa_anticipo','".$fg->ordena('tb_costoventa_anticipo',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Anticipo".$fg->ordenaimg('tb_costoventa_anticipo',$this->campo,$this->orden)."</a>
                    </th>
					
					<th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('tb_costoventa_contado','".$fg->ordena('tb_costoventa_contado',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Precio Contado".$fg->ordenaimg('tb_costoventa_contado',$this->campo,$this->orden)."</a>
                    </th>
					
				    <th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('tb_auto_noserie','".$fg->ordena('tb_auto_noserie',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">No. Serie".$fg->ordenaimg('tb_auto_noserie',$this->campo,$this->orden)."</a>
                    </th>				
                    
                    <th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('tb_auto_nopedimento','".$fg->ordena('tb_auto_nopedimento',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">No. Pedimento".$fg->ordenaimg('tb_auto_nopedimento',$this->campo,$this->orden)."</a>				 
                    </th>
					
					<th width=\"5%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('activado','".$fg->ordena('activado',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Habilitado".$fg->ordenaimg('activado',$this->campo,$this->orden)."</a>		
                    </th>
                    
                    <th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('cat_marca_nombre','".$fg->ordena('cat_marca_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Marca".$fg->ordenaimg('cat_marca_nombre',$this->campo,$this->orden)."</a>		
                    </th>
					
					<th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('cat_modelo_nombre','".$fg->ordena('cat_modelo_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Modelo".$fg->ordenaimg('cat_modelo_nombre',$this->campo,$this->orden)."</a>		
                    </th>
					
					<th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('cat_linea_nombre','".$fg->ordena('cat_linea_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Linea".$fg->ordenaimg('cat_linea_nombre',$this->campo,$this->orden)."</a>		
                    </th>
					
					<th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('cat_tipo_nombre','".$fg->ordena('cat_tipo_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Tipo".$fg->ordenaimg('cat_tipo_nombre',$this->campo,$this->orden)."</a>		
                    </th>
					
					<th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('cat_cilindros_nombre','".$fg->ordena('cat_cilindros_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Cilindros".$fg->ordenaimg('cat_cilindros_nombre',$this->campo,$this->orden)."</a>		
                    </th>
					
					<th width=\"8%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('cat_color_nombre','".$fg->ordena('cat_color_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Color".$fg->ordenaimg('cat_color_nombre',$this->campo,$this->orden)."</a>		
                    </th>                    
					
					<th width=\"5%\" class=\"title\"><a href=\"javascript:tableOrdering('id_costoventa','".$fg->ordena('id_costoventa',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('id_costoventa',$this->campo,$this->orden)."</a>
					</th>
                  </tr></thead>
				 <tfoot>
				  <tr>
					  <td colspan=\"17\">
						  <del class=\"container\"><div class=\"pagination\"> 	                      	             
						   ".$fg->paginar($num_total_registros_paginar,$this->limite,$this->pagina)."
	                      </div></del>				
					  </td>
				  </tr>
				 </tfoot>
				 <tbody>";
				
				$i=0;
				while($invcosto = parent::fetch_array($consulta))
				{				
					extract($invcosto);									
					
					if($activado==1) $img_status = '<a href="#" onclick="javascript:changestatus(\'deshabilitar\','.$id_costoventa.')"><img src="../images/habilitar.png" width="16" height="16" border="0" alt="" /></a>'; else $img_status = '<a href="#" onclick="javascript:changestatus(\'habilitar\','.$id_costoventa.')"><img src="../images/deshabilitar.png" width="16" height="16" border="0" alt="" /></a>';
					
					$directorio='../imgautos/'.$this->idempresa.'/'.$noserie;
					$directoriothumb='../imgautosthumb/'.$this->idempresa.'/'.$noserie;
					$Lista_Archivos = '';
					if(is_dir($directorio)){
						$files = array(); 
						$dir = opendir($directorio); 
						while($item = readdir($dir)){ 
						// We filter the elements that we don't want to appear ".", ".." and ".svn" 
							 if(($item != ".") && ($item != "..") && ($item != ".svn") ){ 
								  $files[] = "<a href='".$directorio."/".$item."' rel='".$id_costoventa."'><img src='".$directoriothumb."/".$item."'  width='24' height='24' /></a>"; 
							 } 
						} 				
						$Lista_Archivos = implode($files,' ');
				    }
					
					/*<td><a href=\"#\" onclick=\"javascript:ver_imagenes('".$Lista_Archivos."','".$directorio."')\"><img src=\"../images/habilitar.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" /></a></td>*/
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"$id_costoventa\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$id_costoventa\"/></td>
						<td>$Lista_Archivos</td>
						<td>$tipocosto</td>
						<td>$psiniva</td>
						<td>$anticipo</td>
						<td>$contado</td>
						<td><a href=\"../modulos/caut_mod_guardaraplicar_invcosto.php?id=$id_costoventa&tipo=edit&texto=Editar Costo Auto\">$noserie</a></td>
						<td style=\"text-align:center\">$nopedimento</td>
						<td id=\"$id_costoventa\" style=\"text-align:center\">$img_status</td>
						<td style=\"text-align:center\">$marca</td>											
						<td>$modelo</td>
						<td>$linea</td>
						<td>$tipo</td>
						<td>$cilindros</td>
						<td>$color</td>
						<td style=\"text-align:center\">$id_costoventa</td>
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
	
	function cargareditarInvCosto()
	{			 
	        $consulta = parent::consulta("
			 SELECT 
			 tb_auto_noserie as noserie,
			 tb_auto_nopedimento as nopedimento,
			 tb_auto_activado as activado,
			 cat_marca_nombre as marca,
			 cat_modelo_nombre as modelo,
			 cat_linea_nombre as linea,
			 cat_tipo_nombre as tipo,
			 cat_cilindros_nombre as cilindros,
			 cat_color_nombre as color,
			 tb_costoventa_tipo as tipocosto,
			 tb_costoventa_psiniva as psiniva,
			 tb_costoventa_anticipo as anticipo,
			 tb_costoventa_contado as contado,
			 id_costoventa as idcostoventa,
			 cv.id_auto as idauto
			 FROM 
			 (((((((tb_auto as a inner join tb_costoventa as cv on a.id_auto = cv.id_auto and cv.id_costoventa = ".$this->id.") inner join
				   cat_marca as ma on a.id_marca = ma.id_marca) inner join 
				   cat_modelo as mo on a.id_modelo = mo.id_modelo) inner join
				   cat_linea as li on a.id_linea = li.id_linea) inner join
				   cat_tipo as ti on a.id_tipo = ti.id_tipo) inner join
				   cat_cilindros as ci on a.id_cilindros = ci.id_cilindros) inner join
				   cat_color as co on a.id_color = co.id_color)");		 
			 	 
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