<?php
error_reporting(E_ALL);
class catalogo extends MySQL
{   
    var $catalogos = '';	
	var $idempresa = '';
	var $nombre = '';
	var $catalogo = '';	
	
	function mostrarCatalogo()
	 {
	   $catalogos = explode(',', $this->catalogos);	   
	   foreach ($catalogos as $id)
	   {
		  $consulta = parent::consulta("SELECT id_".$id.", cat_".$id."_nombre FROM cat_".$id." where id_empresa = ".$this->idempresa);
		  $num_total_registros = parent::num_rows($consulta);	
		  if($num_total_registros>0)
		   {	
		     $array_reg=array();
			 $array_ids=array();
			 $array_nombres=array();
		     while ($row = parent::fetch_assoc($consulta)) {
			   $array_ids[] = $row["id_".$id];	
			   $array_nombres[] = $row["cat_".$id."_nombre"];
			 }			 		     
			 $array_datos[$id]['ids'] = $array_ids;
			 $array_datos[$id]['nombres'] = $array_nombres;				
		   }
	   }	
	   return $array_datos;
	 }
	
	function addCatalogo()
	 {
		 
		$consulta = parent::consulta("INSERT INTO cat_".$this->catalogo." (cat_".$this->catalogo."_nombre, id_empresa) VALUES ('".$this->nombre."',".$this->idempresa.")");
		
		return mysql_insert_id();	
		
	 }
	
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
}

?>