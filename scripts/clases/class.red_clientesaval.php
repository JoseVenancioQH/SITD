<?php
error_reporting(E_ALL);
class clientesaval extends MySQL
{   
    var $pagina = '';
	var $paginado = '';
	var $limite = '';
	var $filtro = '';
	var $campo = '';
	var $orden = '';
	
	var $idempresa = '';
	var $nomaval = '';
	var $appaternoaval = '';
	var $apmaternoaval = '';
	var $diraval = '';
	var $telcasaval = '';
	var $telcelaval = '';
	var $idcliente = '';
	var $municipio = '';
	
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
	
	function borrarClienteAval()
	{		    
	    $array_ids = array();	
		
		foreach (explode(',',$this->ids) as $id_act){			    
				$consulta = parent::consulta("DELETE FROM tb_avalcliente where id_avalcliente = ".$id_act);
		        if(mysql_affected_rows() > 0) $array_ids[]=$id_act;
		}
	    return implode(',',$array_ids);
	}
		
	function mostrarClientesAval()
	{
		include("class.fg.php");
		$fg = new fg();		
		$ban=true;
		while($ban){
		  $criterios_FILTRO ="";$criterios_ORDEN ="";$criterios_LIMITE ="";	
		  
		  if($this->filtro!='') $criterios_FILTRO = " WHERE a.tb_avalcliente_nombre LIKE \"%".$this->filtro."%\" OR a.tb_avalcliente_appaterno LIKE \"%".$this->filtro."%\" OR a.tb_avalcliente_apmaterno LIKE \"%".$this->filtro."%\" OR a.tb_avalcliente_direccion LIKE \"%".$this->filtro."%\" OR c.tb_cliente_nombre LIKE \"%".$this->filtro."%\" OR c.tb_cliente_appaterno LIKE \"%".$this->filtro."%\" OR c.tb_cliente_apmaterno LIKE \"%".$this->filtro."%\"";	                      		
		  if($this->campo!='')  $criterios_ORDEN = " ORDER BY ".$this->campo." ".$this->orden;
		  if($this->limite!=0)  $criterios_LIMITE = " LIMIT ".($this->paginado).", ".$this->limite;	
		  
		  $consulta = parent::consulta("SELECT 
									   tb_cliente_nombre,
									   tb_cliente_appaterno,
									   tb_cliente_apmaterno,
									   tb_avalcliente_nombre,
									   id_avalcliente,
									   tb_avalcliente_appaterno,
									   tb_avalcliente_apmaterno,
									   tb_avalcliente_direccion,
									   tb_avalcliente_telefonocel,
									   tb_avalcliente_telefonocasa
									   FROM tb_avalcliente as a inner join tb_cliente as c on a.id_cliente = c.id_cliente".$criterios_FILTRO.$criterios_ORDEN.$criterios_LIMITE);
		  
		  $consulta_totalregistro = parent::consulta("SELECT id_avalcliente FROM tb_avalcliente as a inner join tb_cliente as c on a.id_cliente = c.id_cliente".$criterios_FILTRO);		  
		  
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
                        <a href=\"javascript:tableOrdering('tb_cliente_nombre','".$fg->ordena('tb_cliente_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Cliente".$fg->ordenaimg('tb_cliente_nombre',$this->campo,$this->orden)."</a>
                    </th>
					
				    <th width=\"15%\" class=\"title\">
                        <a href=\"javascript:tableOrdering('tb_avalcliente_nombre','".$fg->ordena('tb_avalcliente_nombre',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Nombre Aval".$fg->ordenaimg('tb_avalcliente_nombre',$this->campo,$this->orden)."</a>
                    </th>
                    
                    <th width=\"15%\" class=\"title\" >
                        <a href=\"javascript:tableOrdering('tb_avalcliente_appaterno','".$fg->ordena('tb_avalcliente_appaterno',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Paterno Aval".$fg->ordenaimg('tb_avalcliente_appaterno',$this->campo,$this->orden)."</a>				 
                    </th>
                    
                    <th width=\"15%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('tb_avalcliente_apmaterno','".$fg->ordena('tb_avalcliente_apmaterno',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Materno Aval".$fg->ordenaimg('tb_avalcliente_apmaterno',$this->campo,$this->orden)."</a>		
                    </th>				
					
					<th width=\"18%\" class=\"title\" nowrap=\"nowrap\">
                        <a href=\"javascript:tableOrdering('tb_avalcliente_direccion','".$fg->ordena('tb_avalcliente_direccion',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Direcci&oacute;n Aval".$fg->ordenaimg('tb_avalcliente_direccion',$this->campo,$this->orden)."</a>		
                    </th>
                        
                    <th width=\"12%\" class=\"title\">Aval Telefono Celular</th>                  
                    
                    <th width=\"12%\" class=\"title\">Aval Telefono Casa</th>           
					
					<th width=\"6%\" class=\"title\"><a href=\"javascript:tableOrdering('id_avalcliente','".$fg->ordena('id_avalcliente',$this->campo,$this->orden)."','');\" title=\"Haz click para ordenar por esta columna\">Id".$fg->ordenaimg('id_avalcliente',$this->campo,$this->orden)."</a>
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
				while($avalcliente = parent::fetch_array($consulta))
				{				
					extract($avalcliente);													
					
					if($i%2==0){$flag = "class=\"row0\"";}else{$flag = "class=\"row1\"";}
					  $ii=$i+1;
					  print "
					  <tr id=\"tr$id_avalcliente\" $flag>
						<td style=\"text-align:center\">".$ii."</td>
						<td><input type=\"checkbox\" id=\"cb$i\" name=\"cid[]\" class=\"check_me\" value=\"$id_avalcliente\"/></td>
						<td style=\"text-align:center\">$tb_cliente_nombre $tb_cliente_appaterno $tb_cliente_apmaterno</td>
						<td><a href=\"../modulos/caut_mod_guardaraplicar_clientesaval.php?id=$id_avalcliente&tipo=edit&texto=Editar aval Cliente\">$tb_avalcliente_nombre</a></td>
						<td><a href=\"../modulos/caut_mod_guardaraplicar_clientesaval.php?id=$id_avalcliente&tipo=edit&texto=Editar Aval Cliente\">$tb_avalcliente_appaterno</a></td>
						<td><a href=\"../modulos/caut_mod_guardaraplicar_clientesaval.php?id=$id_avalcliente&tipo=edit&texto=Editar Aval Cliente\">$tb_avalcliente_apmaterno</a></td>						
						<td><a href=\"../modulos/caut_mod_guardaraplicar_clientesaval.php?id=$id_avalcliente&tipo=edit&texto=Editar Aval Cliente\">$tb_avalcliente_direccion</a></td>						
						<td style=\"text-align:center\">$tb_avalcliente_telefonocel</td>						
						<td style=\"text-align:center\">$tb_avalcliente_telefonocasa</td>						
						<td style=\"text-align:center\">$id_avalcliente</td>
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

function grabarClienteAval()
	{	         
	   $consulta = parent::consulta("SELECT id_avalcliente FROM tb_avalcliente WHERE tb_avalcliente_nombre = '".$this->nomaval."' and tb_avalcliente_appaterno = '".$this->appaternoaval."' and tb_avalcliente_apmaterno = '".$this->appaternoaval."' and id_empresa = ".$this->idempresa);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
	   {
		  $consulta = parent::consulta("INSERT INTO tb_avalcliente (tb_avalcliente_nombre, tb_avalcliente_appaterno, tb_avalcliente_apmaterno, tb_avalcliente_direccion, tb_avalcliente_telefonocel, tb_avalcliente_telefonocasa, id_municipio, id_empresa, id_cliente) VALUES ('".$this->nomaval."','".$this->appaternoaval."','".$this->apmaternoaval."', '".$this->diraval."', '".$this->telcelaval."', '".$this->telcasaval."', ".$this->municipio.", ".$this->idempresa.", ".$this->idcliente.")");
		  return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"No se grabo correctamente el aval..."}';	
	   }else{
		  return '{"tipo":"error","mensaje":"Nombre de Aval ya Existe..."}';
	   }
	}

function aplicarClienteAval()
	{				  
			 $consulta = parent::consulta("UPDATE tb_avalcliente SET tb_avalcliente_nombre = '".$this->nomaval."', tb_avalcliente_appaterno = '".$this->appaternoaval."', tb_avalcliente_apmaterno = '".$this->apmaternoaval."', tb_avalcliente_direccion = '".$this->diraval."' , tb_avalcliente_telefonocel = '".$this->telcelaval."' , tb_avalcliente_telefonocasa = '".$this->telcasaval."' , id_municipio = ".$this->municipio.", id_cliente = ".$this->idcliente." WHERE id_avalcliente = ".$this->id);		 
			 
		 return (mysql_affected_rows() > 0)?'{"tipo":"succes","mensaje":"Operaci&oacute;n realizada con &eacute;xito..."}':'{"tipo":"error","mensaje":"Sin cambios cliente..."}';
	
	}	


function cargareditarClientesAval()
	{			 
	       $consulta = parent::consulta("SELECT tb_avalcliente_nombre, tb_avalcliente_appaterno, tb_avalcliente_apmaterno, tb_avalcliente_direccion, tb_avalcliente_telefonocel, tb_avalcliente_telefonocasa, a.id_municipio, a.id_empresa, cat_municipio_nombre, c.id_cliente, tb_cliente_nombre, tb_cliente_appaterno, tb_cliente_apmaterno FROM (cat_municipio as m inner join tb_avalcliente as a on a.id_municipio = m.id_municipio) inner join tb_cliente as c on c.id_cliente = a.id_cliente Where a.id_avalcliente = ".$this->id);		 
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

function mostrarNombresClientesAval()
	{			 
	         $consulta = parent::consulta("SELECT tb_avalcliente_nombre as nombre, tb_avalcliente_appaterno as appaterno, tb_avalcliente_apmaterno as apmaterno, tb_avalcliente_direccion as direccion FROM tb_avalcliente Where id_empresa = ".$this->idempresa);		 
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
}
?>