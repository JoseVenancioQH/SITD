<?php
error_reporting(E_ALL);
class empresa extends MySQL
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
	
	var $id = '';
	
	var $ids = '';
	var $tipo = '';
	
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
						
	function statusEmpresa()
	{		    
	    $array_ids = array();
		$act=($this->tipo == 'habilitar') ? 1 : 0;
		
		foreach (explode(',',$this->ids) as $id_act){			    
				$consulta = parent::consulta("UPDATE tb_empresa SET tb_empresa_activado = $act WHERE id_empresa = ".$id_act);
		        if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
		}
	    return implode(',',$array_ids);
	}
	
	function borrarEmpresa()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){			    
				$consulta = parent::consulta("DELETE FROM tb_empresa where id_empresa = ".$id_act);
		        if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
		}
	    return implode(',',$array_ids);
	}
		
	function mostrarEmpresa()
	{
		include("class.fg.php");
		$fg = new fg();		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";	
		  
		  if($this->filtro!='') $criterios_FILTRO = " WHERE e.tb_empresa_nombre LIKE \"%".$this->filtro."%\" OR e.tb_empresa_propietario LIKE \"%".$this->filtro."%\"";	                      		
		  if($this->campo!='')  $criterios_ORDEN = " ORDER BY ".$this->campo." ".$this->orden;
		  if($this->limite!=0)  $criterios_LIMITE = " LIMIT ".($this->paginado).", ".$this->limite;	
		  
		  $consulta = parent::consulta("SELECT * FROM tb_empresa as e".$criterios_FILTRO.$criterios_ORDEN.$criterios_LIMITE);
		  
		  $consulta_totalregistro = parent::consulta("SELECT * FROM tb_empresa as e".$criterios_FILTRO);
		  
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
					
				    <th class=\"title\">
                        <a href=\"javascript:tableOrdering('tb_empresa_nombre','".$fg->ordena('tb_empresa_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Empresa".$fg->ordenaimg('tb_empresa_nombre',$this->campo,$this->orden)."</a>
                    </th>
                    
                    <th width=\"12%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('tb_empresa_propietario','".$fg->ordena('tb_empresa_propietario',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Propietario".$fg->ordenaimg('tb_empresa_propietario',$this->campo,$this->orden)."</a>				 
                    </th>
                    
                    <th width=\"5%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('tb_empresa_activado','".$fg->ordena('tb_empresa_activado',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Habilitado".$fg->ordenaimg('tb_empresa_activado',$this->campo,$this->orden)."</a>		
                    </th>
                        
                    <th width=\"5%\" class=\"title\">Tipo Fiscal</th>                  
                    
                    <th width=\"30%\" class=\"title\">Direcci&oacute;n</th>
                    
                    <th width=\"5%\" class=\"title\">R.F.C.</th>            
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('id_empresa','".$fg->ordena('id_empresa',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('id_empresa',$this->campo,$this->orden)."</a>
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
				while($empresa = parent::fetch_array($consulta))
				{				
					extract($empresa);				
					
					/*$privilegios = array();
		            $acciones = array();
					
					foreach (explode(',',$tb_empresa_modulos) as $modulos){					
					        $privilegios[]="<a href=\"#\">".$array_privilegios[array_search($modulos, $array_privilegios_clave)]."</a>";					
					}
					
					foreach (explode(',',$tb_empresa_acciones) as $accion){					
					        $acciones[]="<a href=\"#\">".$array_acciones[array_search($accion, $array_acciones_claves)]."</a>";					
					}*/
					
					if($tb_empresa_activado==1) $img_status = '<a href="#" onclick="javascript:changestatus(\'deshabilitar\','.$id_empresa.')"><img src="../images/habilitar.png" width="16" height="16" border="0" alt="" /></a>'; else $img_status = '<a href="#" onclick="javascript:changestatus(\'habilitar\','.$id_empresa.')"><img src="../images/deshabilitar.png" width="16" height="16" border="0" alt="" /></a>';
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"tr$id_empresa\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$id_empresa\"/></td>
						<td><a href=\"../modulos/caut_mod_guardaraplicar_empresa.php?id=$id_empresa&tipo=edit&texto=Editar Empresa\">$tb_empresa_nombre</a></td>
						<td style=\"text-align:center\">$tb_empresa_propietario</td>
						<td id=\"$id_empresa\" style=\"text-align:center\">$img_status</td>
						<td style=\"text-align:center\">$tb_empresa_tipofiscal</td>											
						<td>$tb_empresa_direccion</td>
						<td>$tb_empresa_rfc</td>
						<td style=\"text-align:center\">$id_empresa</td>
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
	



function grabarEmpresa()
	{	         
	         $consulta = parent::consulta("SELECT id_empresa FROM tb_empresa WHERE tb_empresa_nombre = '".$this->nombreempresa."'");
			 $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros==0)
			 {
			    $consulta = parent::consulta("INSERT INTO tb_empresa (tb_empresa_nombre, tb_empresa_propietario, tb_empresa_tipofiscal, tb_empresa_direccion, tb_empresa_rfc, tb_empresa_activado) VALUES ('".$this->nombreempresa."','".$this->propietario."','".$this->tipofiscal."', '".$this->direccion."', '".$this->rfc."', true)");
		        return (mysql_affected_rows() > 0)?"<dl id=\"system-message\"><dt class=\"succes\"></dt><dd class=\"succes message fade\"><ul><li>Operaci&oacute;n realizada con &eacute;xito...</li></ul></dd></dl>":"<dl id=\"system-message\"><dt class=\"error\">Error</dt><dd class=\"error message fade\"><ul><li>No se grabo correctamente la empresa...</li></ul></dd></dl>";	
			 }else{
				return "<dl id=\"system-message\"><dt class=\"error\">Error</dt><dd class=\"error message fade\"><ul><li>Nombre de empresa existente</li></ul></dd></dl>";
			 }
	}

function aplicarEmpresa()
	{				  
			 $consulta = parent::consulta("UPDATE tb_empresa SET tb_empresa_nombre = '".$this->nombreempresa."', tb_empresa_propietario = '".$this->propietario."', tb_empresa_tipofiscal='".$this->tipofiscal."', tb_empresa_direccion = '".$this->direccion."' , tb_empresa_rfc = '".$this->rfc."' WHERE id_empresa = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?"<dl id=\"system-message\"><dt class=\"succes\"></dt><dd class=\"succes message fade\"><ul><li>Operaci&oacute;n realizada con &eacute;xito...</li></ul></dd></dl>":"<dl id=\"system-message\"><dt class=\"error\">Error</dt><dd class=\"error message fade\"><ul><li>No se grabo correctamente la empresa...</li></ul></dd></dl>";
	
	}	


function cargareditarEmpresa()
	{			 
	       $consulta = parent::consulta("SELECT * FROM tb_empresa Where id_empresa = ".$this->id);		 
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