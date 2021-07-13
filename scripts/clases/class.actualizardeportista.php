<?php
error_reporting(E_ALL);
class actualizardeportista extends MySQL
{  
    var $idregistrocat = '';
    var $evento = '';
    var $categoria = '';
    var $pruebas = '';
    var $idregistro = '';		
	
function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
function actualizarDeportistas()
	{	
////Actualizar Categoria				
        if(!empty($this->idregistrocat)){
        $consulta = parent::consulta("SELECT id_categoriapar, cat_categoria_nombre  FROM reg_categoriaparticipante inner join cat_categoria on reg_categoriaparticipante.id_categoria = cat_categoria.id_categoria WHERE id_categoriapar = ".$this->idregistrocat);
		$data_categoria = parent::fetch_row($consulta);
		$num_total_registros = parent::num_rows($consulta);
		}else{$num_total_registros=0;}
		if($num_total_registros==0)
		 {
		     $consulta = parent::consulta("INSERT INTO reg_categoriaparticipante (id_evento,id_registro,id_categoria,reg_categoriaparticipante_pruebas) VALUES (".$this->evento.",".$this->idregistro.",".$this->categoria.",'".$this->utf8($this->pruebas)."')");
			 $error_categoria = " Registrada EXITOSAMENTE";
			 $error_categoria_logo = "ok";			 
			 $id_registrocat_new = mysql_insert_id();	
			 $consulta = parent::consulta("SELECT id_categoriapar, cat_categoria_nombre  FROM reg_categoriaparticipante inner join cat_categoria on reg_categoriaparticipante.id_categoria = cat_categoria.id_categoria WHERE id_categoriapar = ".$id_registrocat_new);		 
			 $data_categoria = parent::fetch_row($consulta);
			 $nombre_categoria = $data_categoria[1];
			 $tipo_update = "insert";
		 }
		else
		 {
		     $consulta = parent::consulta("UPDATE reg_categoriaparticipante SET id_evento = ".$this->evento.", id_registro = ".$this->idregistro.", id_categoria =".$this->categoria.", reg_categoriaparticipante_pruebas = '".$this->utf8($this->pruebas)."'  WHERE id_categoriapar = ".$this->idregistrocat);		 
			 
			 if(mysql_affected_rows() > 0)
			 {
			   $error_categoria = " Actualizada EXITOSAMENTE";
			   $error_categoria_logo = "ok";  
			   $id_registrocat_new = $this->idregistrocat;			   
			   $nombre_categoria = $data_categoria[1];
			   $tipo_update = "update";
			 }
			 else
			 {
			    $error_categoria = " Error, no se pudo actualizar...<br />Verifique con ADMINISTRADOR...";
			    $error_categoria_logo = "cancel";
				$id_registrocat_new = "no";
				$nombre_categoria = "no";
				$tipo_update = "no";
			 }	     
		 }
		 			
		$errorcategoria = "'nombre_categoria':'".$nombre_categoria."','id_registrocat_new':'".$id_registrocat_new."','categoria':'".$error_categoria."','logocategoria':'".$error_categoria_logo."','tipo_update':'".$tipo_update."'";	
		echo '({'.$errorcategoria.'})';	    	
	}
}	
?>