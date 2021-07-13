<?php
error_reporting(E_ALL);
class desplegargaffetes extends MySQL
{
    var $deporte = '';
	var $municipio = '';	
	var $nombres = '';
	var $appaterno = '';
	var $apmaterno = '';
	var $rama = '';	
	var $modalidad = '';		
	var $categoria = '';	
	var $evento = '';
	var $anoinicio = '';
	var $anofin = '';
	var $convanoinicio = '';
	var $validado = '';
	var $ordenar = '';
	var $gaffete_sel = '';
	var $registro_actual = '';	
    
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
	
	function borrar_directorio($dir, $borrarme)
    {
    if(!$dh = @opendir($dir)) return;
		while (false !== ($obj = readdir($dh))) 
		{
			if($obj=='.' || $obj=='..') continue;
			if (!@unlink($dir.'/'.$obj)) borrar_directorio($dir.'/'.$obj, false);
		}
        closedir($dh);
        if ($borrarme)
        {
           @rmdir($dir);
        }
    }
	
	function ContarGaffetes()
	  {
		  if(empty($this->deporte) || $this->deporte == 0) $filtrodeporte = ''; else $filtrodeporte = ' and cat_d.id_deporte = '.$this->deporte;
		  
		  if(empty($this->evento)) $filtroevento = ''; else $filtroevento = ' and reg_e.id_evento = '.$this->evento;
		  
		  if(empty($this->municipio) || $this->municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " and cat_mu.id_municipio = ".$this->municipio;
		  
		  if(empty($this->nombres)) $filtronombres = ''; else $filtronombres = " and UCASE(reg_p.reg_participante_nombre) like '%".strtoupper($this->nombres)."%'";
				  
		  if(empty($this->appaterno)) $filtroappaterno = ''; else $filtroappaterno = " and UCASE(reg_p.reg_participante_paterno) like '%".strtoupper($this->appaterno)."%'";
				  
		  if(empty($this->apmaterno)) $filtroapmaterno = ''; else $filtroapmaterno = " and UCASE(reg_p.reg_participante_materno) like '%".strtoupper($this->apmaterno)."%'";			            	           
		  if(empty($this->modalidad)) $filtromodalidad = ''; else $filtromodalidad = ' and reg_m.id_modalidad = '.$this->modalidad;
		  if(empty($this->categoria)) $filtrocategoria = ''; else $filtrocategoria = ' and reg_c.id_categoria = '.$this->categoria;
		  if(empty($this->validado)) $filtrovalidado = ''; else $filtrovalidado = ' and reg_c.reg_categoriaparticipante_validado = "'.$this->validado.'"';
		  
		  if(empty($this->anoinicio) && empty($this->anofin)) $filtroano = ''; else $filtroano = " and (year(reg_p.reg_participante_fechanac) BETWEEN ".$this->anoinicio." AND ".$this->anofin.")";  
		  
		  //if(!empty($this->rama)) {if($this->rama == 'H') $this->rama = 'Varonil'; else $this->rama = 'Femenil';}
		  if(empty($this->rama)) $filtrorama = ''; else $filtrorama = ' and reg_p.reg_participante_sexo = \''.$this->rama.'\'';	     
		 
          if(empty($this->gaffete_sel))
		  {
			    $filtrodescartargaffetes = '';
		  }else{				
				$filtrodescartargaffetes = " and reg_p.id_registro not in (".$this->gaffete_sel.")";				
		  }
		  
		  $filtro = $filtromunicipio.$filtromodalidad.$filtrodeporte.$filtrorama.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtrocategoria.$filtroano.$filtrovalidado.$filtroevento.$filtrodescartargaffetes;
		  
		  if(!empty($filtro)){
			   $filtro = substr($filtro,5,strlen($filtro));		
			   $filtro = ' WHERE '.$filtro;
		  }
		  
		  
		  
		  $consulta = parent::consulta("select reg_p.id_registro as id_registro
		  from
		  ((((((reg_participante as reg_p 
				inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro)
				inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
				inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad)
				left join cat_municipio as cat_mu on cat_mu.id_municipio = reg_p.id_municipio)
				left join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria)
				left join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte)
				left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro
		  GROUP BY reg_p.id_registro");
		  
		  return parent::num_rows($consulta);		  
	  }
	
	function GeneraGaffetes()
	  {	   	
	      $mtime = microtime(); 
          $mtime = explode(" ",$mtime); 
          $mtime = $mtime[1] + $mtime[0]; 
          $tiempoinicial = $mtime;
			  
		  if(empty($this->deporte) || $this->deporte == 0) $filtrodeporte = ''; else $filtrodeporte = ' and cat_d.id_deporte = '.$this->deporte;
		  
		  if(empty($this->evento)) $filtroevento = ''; else $filtroevento = ' and reg_e.id_evento = '.$this->evento;
		  
		  if(empty($this->municipio) || $this->municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " and cat_mu.id_municipio = ".$this->municipio;
		  
		  if(empty($this->nombres)) $filtronombres = ''; else $filtronombres = " and UCASE(reg_p.reg_participante_nombre) like '%".strtoupper($this->nombres)."%'";
				  
		  if(empty($this->appaterno)) $filtroappaterno = ''; else $filtroappaterno = " and UCASE(reg_p.reg_participante_paterno) like '%".strtoupper($this->appaterno)."%'";
				  
		  if(empty($this->apmaterno)) $filtroapmaterno = ''; else $filtroapmaterno = " and UCASE(reg_p.reg_participante_materno) like '%".strtoupper($this->apmaterno)."%'";			            	           
		  if(empty($this->modalidad)) $filtromodalidad = ''; else $filtromodalidad = ' and reg_m.id_modalidad = '.$this->modalidad;
		  if(empty($this->categoria)) $filtrocategoria = ''; else $filtrocategoria = ' and reg_c.id_categoria = '.$this->categoria;
		  if(empty($this->validado)) $filtrovalidado = ''; else $filtrovalidado = ' and reg_c.reg_categoriaparticipante_validado = "'.$this->validado.'"';
		  
		  if(empty($this->anoinicio) && empty($this->anofin)) $filtroano = ''; else $filtroano = " and (year(reg_p.reg_participante_fechanac) BETWEEN ".$this->anoinicio." AND ".$this->anofin.")";  
		  
		  //if(!empty($this->rama)) {if($this->rama == 'H') $this->rama = 'Varonil'; else $this->rama = 'Femenil';}
		  if(empty($this->rama)) $filtrorama = ''; else $filtrorama = ' and reg_p.reg_participante_sexo = \''.$this->rama.'\'';	     
		 
          if(empty($this->gaffete_sel))
		  {
			    $filtrodescartargaffetes = '';
		  }else{				
				$filtrodescartargaffetes = " and reg_p.id_registro not in (".$this->gaffete_sel.")";				
		  } 

           if($this->ordenar!=''){		  
		   $arrorden = explode(',',$this->ordenar);		 
		   $orden_reporte = array();
		   $banano = false;
		   foreach ($arrorden as $val) {		  			  
				  if($val == 'municipio'){$orden_reporte[] = 'cat_mu.cat_municipio_nombre ASC';}
				  if($val == 'nombres'){$orden_reporte[] = 'reg_p.reg_participante_nombre ASC';} 
				  if($val == 'appaterno'){$orden_reporte[] = 'reg_p.reg_participante_paterno ASC';} 
				  if($val == 'apmaterno'){$orden_reporte[] = 'reg_p.reg_participante_materno ASC';} 
				  if($val == 'modalidad'){$orden_reporte[] = 'cat_m.cat_modalidad_nombre ASC';} 
				  if($val == 'categoria'){$orden_reporte[] = 'cat_c.cat_categoria_nombre ASC';}
				  if($val == 'sexo'){$orden_reporte[] = 'reg_p.reg_participante_sexo ASC';}
				  if(($val == 'anoinicio' || $val == 'anoinicio' || $val == 'anoinicio') && !$banano)
				  {
					  $banano = true;
					  $orden_reporte[] = 'cat_d.cat_deporte_nombre ASC';
				  }
				  if($val == 'deporte'){$orden_reporte[] = 'cat_mu.cat_municipio_nombre ASC';}		  	 
		   }	
		   $filtroordenar = 'ORDER BY '.implode(',',$orden_reporte);		 
	       }else{$filtroordenar = '';}

		  $filtro = $filtromunicipio.$filtromodalidad.$filtrodeporte.$filtrorama.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtrocategoria.$filtroano.$filtrovalidado.$filtroevento.$filtrodescartargaffetes;
		  
		  if(!empty($filtro)){
			   $filtro = substr($filtro,5,strlen($filtro));		
			   $filtro = ' WHERE '.$filtro;
		  }			
		  
		  $consulta = parent::consulta("select			
		  reg_p.id_registro as id_registro,  	     
		  reg_p.reg_participante_curp as curp,    			 		 			 
		  reg_p.reg_participante_nombre as nombre,
		  reg_p.reg_participante_paterno as appaterno,
		  reg_p.reg_participante_materno as apmaterno,
		  reg_p.reg_participante_fechanac as fechanac,
		  reg_p.reg_participante_sexo as sexo,					  
		  cat_c.cat_categoria_rangoinicio as rangoinicio,
		  cat_c.cat_categoria_rangofin as rangofin,
		  reg_m.reg_modalidadparticipante_cargo as cargo,		  
		  cat_mu.cat_municipio_nombre AS municipio,
		  GROUP_CONCAT(DISTINCT cat_d.cat_deporte_nombre SEPARATOR ', ') as deporte,
		  cat_m.cat_modalidad_nombre as modalidad,
		  GROUP_CONCAT(DISTINCT cat_c.cat_categoria_nombre SEPARATOR ', ') as categoria,
		  cat_c.cat_categoria_rama as rama,
		  GROUP_CONCAT(DISTINCT reg_c.reg_categoriaparticipante_pruebas SEPARATOR ' | ') as pruebas	  
		  from
		  ((((((reg_participante as reg_p 
				inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro)
				inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
				inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad)
				left join cat_municipio as cat_mu on cat_mu.id_municipio = reg_p.id_municipio)
				left join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria)
				left join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte)
				left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro GROUP BY reg_p.id_registro $filtroordenar LIMIT ".$this->registro_actual.",40");	
		  
		  /*GROUP_CONCAT(DISTINCT cat_mu.cat_municipio_nombre SEPARATOR ',') AS municipio,
		  GROUP_CONCAT(DISTINCT cat_d.cat_deporte_nombre SEPARATOR ', ') as deporte,
		  GROUP_CONCAT(DISTINCT cat_m.cat_modalidad_nombre SEPARATOR ', ') as modalidad,
		  GROUP_CONCAT(DISTINCT cat_c.cat_categoria_nombre SEPARATOR ', ') as categoria,
		  GROUP_CONCAT(DISTINCT cat_c.cat_categoria_rama SEPARATOR ', ') as rama,
		  GROUP_CONCAT(DISTINCT reg_c.reg_categoriaparticipante_pruebas SEPARATOR ' | ') as pruebas*/
			
			/*$consulta = parent::consulta("select "			
			.$filtroconvivencia
			."reg_p.id_registro, "			  	         			 
			."cat_mu.cat_municipio_nombre as municipio, "			 
			."year(reg_p.reg_participante_fechanac) as anoparticipante, "
			."reg_p.reg_participante_nombre as nombre, "
			."reg_p.reg_participante_paterno as appaterno, "
			."reg_p.reg_participante_materno as apmaterno, "
			."reg_p.reg_participante_curp as curp, "
			."reg_p.reg_participante_fechanac as fechanac, "
			."reg_p.reg_participante_entidad as entidad, "
			."reg_p.reg_participante_direccion as direccion, "
			."reg_p.reg_participante_codigop as codigop, "
			."reg_p.reg_participante_telefonos as telefonos, "
			."reg_p.reg_participante_correo as correo, "
			."reg_p.reg_participante_peso as peso, "
			."reg_p.reg_participante_talla as talla, "
			."reg_p.reg_participante_sexo as sexo, "
			."reg_p.reg_participante_tiposanguineo as tiposanguineo, "
			."reg_p.reg_participante_localidad as localidad, "
			."reg_p.reg_participante_colonia as colonia, "			 		 
			."reg_p.reg_participante_rfc as rfc, "			 		 
			."reg_m.reg_modalidadparticipante_cargo as cargo,"
			."group_concat(DISTINCT cat_d.cat_deporte_nombre SEPARATOR ', ') as deporte,"
			."group_concat(DISTINCT cat_m.cat_modalidad_nombre SEPARATOR ', ') as modalidad,"
			."group_concat(DISTINCT cat_c.cat_categoria_nombre SEPARATOR ', ') as categoria,"
			."group_concat(DISTINCT reg_c.reg_categoriaparticipante_pruebas SEPARATOR ' | ') as pruebas,"			
			."cat_c.cat_categoria_rangoinicio as rangoinicio, "
			."cat_c.cat_categoria_rangofin as rangofin, "		 
			."cat_c.cat_categoria_rama as rama  "			 
			."from "
		 ."(((reg_participante as reg_p inner join cat_municipio as cat_mu on reg_p.id_municipio = cat_mu.id_municipio) left join ((reg_modalidadparticipante as reg_m inner join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad) left join  cat_deportes as cat_dd on reg_m.reg_modalidadparticipante_deporte = cat_dd.id_deporte) on reg_p.id_registro = reg_m.id_registro) inner join (reg_eventoparticipante as reg_ep inner join reg_eventos as reg_e on reg_ep.id_evento = reg_e.id_evento) on reg_p.id_registro = reg_ep.id_registro) left join ((reg_categoriaparticipante as reg_c inner join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria) inner join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte) on reg_p.id_registro = reg_c.id_registro ".$filtroreporte." GROUP BY reg_p.id_registro".$filtroorden." LIMIT ".$this->registro_actual.",40");*/			
			
			 $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros>0)
			 {			   
	           /*$this->borrar_directorio('../GaffeteTem', false);*/		   
			   $mtime = microtime(); 
               $mtime = explode(" ",$mtime); 
               $mtime = $mtime[1] + $mtime[0]; 
               $tiempoinicial = $mtime;			   
			   /*set_time_limit(($num_total_registros*2)+$tiempototal);*/
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {		      
			     
			      if(is_null($actual['apmaterno'])) $actual['apmaterno'] = 'Ninguno';
				  /*if(is_null($actual['direccion'])) $actual['direccion'] = 'Ninguno';
				  if(is_null($actual['codigop'])) $actual['codigop'] = 'Ninguno';
				  if(is_null($actual['telefonos'])) $actual['telefonos'] = 'Ninguno';
				  if(is_null($actual['correo'])) $actual['correo'] = 'Ninguno';
				  if(is_null($actual['peso'])) $actual['peso'] = 'Ninguno';
				  if(is_null($actual['talla'])) $actual['talla'] = 'Ninguno';
				  if(is_null($actual['tiposanguineo'])) $actual['tiposanguineo'] = 'Ninguno';
				  if(is_null($actual['localidad'])) $actual['localidad'] = 'Ninguno';
				  if(is_null($actual['colonia'])) $actual['colonia'] = 'Ninguno';
				  if(is_null($actual['rfc'])) $actual['rfc'] = 'Ninguno';*/				  
				  if(is_null($actual['rangoinicio'])) $actual['rangoinicio'] = 'Ninguno';
				  if(is_null($actual['rangofin'])) $actual['rangofin'] = 'Ninguno';				  
				  
				  //crear y guardar el gaffete de participante...
				  
				  
				  if(eregi("DEPORTISTA",$actual['modalidad']))
				   $modalidad_gaffete = 'DEPORTISTA';
				  if(eregi("ENTRENADOR",$actual['modalidad']))
				   $modalidad_gaffete = 'ENTRENADOR'; 
				  if(eregi("GENERAL",$actual['modalidad']))
				   $modalidad_gaffete = 'DELEGADOGENERAL'; 
				  if(eregi("DEPORTE",$actual['modalidad']))
				   $modalidad_gaffete = 'DELEGADOPORDEPORTE';
				  if(eregi("AUXILIAR",$actual['modalidad']))
				   $modalidad_gaffete = 'AUXILIAR';
				  if(eregi("JUEZ",$actual['modalidad']))
				   $modalidad_gaffete = 'JUEZ';
				  if(eregi("ORGANIZADOR",$actual['modalidad']))
				   $modalidad_gaffete = 'COMITEORGANIZADOR';
				  if(eregi("PRENSA",$actual['modalidad']))
				   $modalidad_gaffete = 'PRENSA';				  
				  if(eregi("ENTRENADOR",$actual['modalidad']) && eregi("AUXILIAR",$actual['modalidad'])) 
				  $modalidad_gaffete = 'ENTRENADORAUXILIAR';
				  
				  $gaffete = imagecreatefrompng("../GaffetesBase/FONDOGAFFETE_MEDIO.png");
				  $modalidad = imagecreatefrompng("../GaffetesBase/".$modalidad_gaffete.".png");
				  $municipio_text = strtr(strtoupper($this->ascii($actual['municipio'])), "àáâãäåæçèéêëìíîïðñòóôõöøùüú", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ");
				  $municipio = imagecreatefrompng("../Municipios/".$municipio_text.".png");
				  
				  
				  //size imagenes...				  
				  $gaffete_x = imagesx($gaffete);
				  $gaffete_y = imagesy($gaffete);
				  
				  $modalidad_x = imagesx($modalidad);
				  $modalidad_y = imagesy($modalidad);	
				  
				  $municipio_x = imagesx($municipio);
				  $municipio_y = imagesy($municipio);				  
				  
				  if($modalidad_gaffete == 'DEPORTISTA'){
					if($actual['sexo']=='H') $rama = 'Varonil'; else $rama = 'Femenil';  
				    $ramas = imagecreatefrompng("../Ramas/".strtoupper($rama).".png");
				    $ramas_x = imagesx($ramas);
				    $ramas_y = imagesy($ramas);				  
				    $x = 15;
				    $y = 135;			  
				    imagecopy($gaffete,$ramas,$x,$y,0,0,$ramas_x,$ramas_y);
				    imagedestroy($ramas);			  
				  }
				  
				  //posicionar modalidad...
				  $x = intval($gaffete_x - $modalidad_x);
				  $y = intval($gaffete_y - $modalidad_y);			  
				  
				  imagecopy($gaffete,$modalidad,$x,$y,0,0,$modalidad_x,$modalidad_y);
				  imagedestroy($modalidad);			  
				  
				  $x = 94;
				  $y = 240;			  
				  
				  imagecopy($gaffete,$municipio,$x,$y,0,0,$municipio_x,$municipio_y);
				  imagedestroy($municipio);		  
				  
				  //union de gaffete y foto...			  
				  if (file_exists('../fotosparticipantes/'.$actual['curp'].'.png')){		       
				     $foto = imagecreatefrompng("../fotosparticipantes/".$actual['curp'].".png");
					 //size foto				 
					 $foto_x = imagesx($foto);
				     $foto_y = imagesy($foto);
					 
					 $x = 19;
				     $y = intval(($gaffete_y / 2) - 51);
					 				  
					 imagecopy($gaffete,$foto,$x,$y,0,0,$foto_x,$foto_y);
					 imagedestroy($foto);				  				     				 
			      }		  
				  //ESCRIBIENDO TEXTO EN GAFFTE...				  
				  $bg = imagecolorallocate($gaffete,255,255,255);
				  $gris = imagecolorallocate($gaffete,100,100,100);
				  $azul_claro = imagecolorallocate($gaffete,2,43,117);			 				  
				  
				  //generamos imagenes del nombre...
				  $imagen = imagecreatetruecolor( 420, 132);
                  $fondo = imagecreatefrompng( "../abcpng/bg_big.png" );
                  imagesettile( $imagen, $fondo );
				  imagefill( $imagen, 0, 0, IMG_COLOR_TILED );			  
				  $palabra = strtolower($this->ascii($actual['nombre']));
				  
				  
				  $texto = preg_split( '//', $palabra, -1);
				  $x = 10;				  
				  // Definimos la escala
				  $escala = 5;				  
				  
                  $cont= strlen($palabra);
				  $var = 0;
				  
                  while ($var<$cont)
                  { 
                   $letra=$palabra[$var];  				   
                   $var++;
				   if($letra == ' ') $letra = 'space';
				   if($letra == 'á' || $letra == 'Á') $letra = 'a';
				   if($letra == 'é' || $letra == 'É') $letra = 'e';
				   if($letra == 'í' || $letra == 'Í' ) $letra = 'i';
				   if($letra == 'ó' || $letra == 'Ó') $letra = 'o';
				   if($letra == 'ú' || $letra == 'Ú') $letra = 'u';
				   if($letra == 'ñ' || $letra == 'Ñ') $letra = 'ñ';				   
				   if (file_exists("../abcpng/".$letra.".png")){
				   $char = imagecreatefrompng( "../abcpng/".$letra.".png" );					
				   }else
				   {
				   $char = imagecreatefrompng( "../abcpng/space.png" );					
				   }
				   imagecopyresampled( $imagen, $char, $x, 10, 0, 0, imagesx( $char ) * ( $escala / 100 ),imagesy( $char ) * ( $escala / 100 ), imagesx( $char ), imagesy( $char ) );					
			       $x += imagesx( $char ) * ( $escala / 100 );					
				   imagedestroy( $char );					  
                  }
				  				  			  
				  $imagen_x = imagesx($imagen);
				  $imagen_y = imagesy($imagen);				  		  
				  //posicionar letras...
				  $x = 85;
				  $y = 150;
				  imagecopy($gaffete,$imagen,$x,$y,0,0,420,132);			  
				  imagedestroy( $fondo );
				  imagedestroy( $imagen );			
				  //fin generamos imagenes del nombre...
				  
				  //generamos imagenes del appaterno...
				  $imagen = imagecreatetruecolor( 420, 132);
                  $fondo = imagecreatefrompng( "../abcpng/bg_big.png" );
                  imagesettile($imagen, $fondo );
				  imagefill( $imagen, 0, 0, IMG_COLOR_TILED );
				  
				  $palabra = strtolower($this->ascii($actual['appaterno']));			  
				 			  
				  $x = 10;				  
				  // Definimos la escala
				  $escala = 5;				  
				  
                  $cont= strlen($palabra);
				  $var = 0;
                  while ($var<$cont)
                  { 
                   $letra=$palabra[$var];  				   
                   $var++;
				   if($letra == ' ') $letra = 'space';
				   if($letra == 'á' || $letra == 'Á') $letra = 'a';
				   if($letra == 'é' || $letra == 'É') $letra = 'e';
				   if($letra == 'í' || $letra == 'Í' ) $letra = 'i';
				   if($letra == 'ó' || $letra == 'Ó') $letra = 'o';
				   if($letra == 'ú' || $letra == 'Ú') $letra = 'u';
				   if($letra == 'ñ' || $letra == 'Ñ') $letra = 'ñ';
				   if (file_exists("../abcpng/".$letra.".png")){
				   $char = imagecreatefrompng( "../abcpng/".$letra.".png" );					
				   }else
				   {
				   $char = imagecreatefrompng( "../abcpng/space.png" );					
				   }
				   imagecopyresampled( $imagen, $char, $x, 10, 0, 0, imagesx( $char ) * ( $escala / 100 ),imagesy( $char ) * ( $escala / 100 ), imagesx( $char ), imagesy( $char ) );					
			       $x += imagesx( $char ) * ( $escala / 100 );					
				   imagedestroy( $char );					  
                  }
				  				  			  
				  $imagen_x = imagesx($imagen);
				  $imagen_y = imagesy($imagen);				  		  
				  //posicionar letras...
				  $x = 85;
				  $y = 170;
				  imagecopy($gaffete,$imagen,$x,$y,0,0,420,132);			  
				  imagedestroy( $fondo );
				  imagedestroy( $imagen );			
				  //fin generamos imagenes del appaterno...
				  
				  
				  //generamos imagenes del apmaterno...
				  $imagen = imagecreatetruecolor( 420, 132);
                  $fondo = imagecreatefrompng( "../abcpng/bg_big.png" );
                  imagesettile( $imagen, $fondo );
				  imagefill( $imagen, 0, 0, IMG_COLOR_TILED );			
				  $palabra = strtolower($this->ascii($actual['apmaterno']));			    

				  
				  $x = 10;				  
				  // Definimos la escala
				  $escala = 5;
				  
				  
                  $cont= strlen($palabra);
				  $var = 0;
                  while ($var<$cont)
                  { 
                   $letra=$palabra[$var];  				   
                   $var++;
				   if($letra == ' ') $letra = 'space';
				   if($letra == 'á' || $letra == 'Á') $letra = 'a';
				   if($letra == 'é' || $letra == 'É') $letra = 'e';
				   if($letra == 'í' || $letra == 'Í' ) $letra = 'i';
				   if($letra == 'ó' || $letra == 'Ó') $letra = 'o';
				   if($letra == 'ú' || $letra == 'Ú') $letra = 'u';
				   if($letra == 'ñ' || $letra == 'Ñ') $letra = 'ñ';			   
				  
				   if (file_exists("../abcpng/".$letra.".png")){
				   $char = imagecreatefrompng( "../abcpng/".$letra.".png" );					
				   }else
				   {
				   $char = imagecreatefrompng( "../abcpng/space.png" );					
				   }
				   imagecopyresampled( $imagen, $char, $x, 10, 0, 0, imagesx( $char ) * ( $escala / 100 ),imagesy( $char ) * ( $escala / 100 ), imagesx( $char ), imagesy( $char ) );					
			       $x += imagesx( $char ) * ( $escala / 100 );					
				   imagedestroy( $char );					  
                  }
				  				  			  
				  $imagen_x = imagesx($imagen);
				  $imagen_y = imagesy($imagen);				  		  
				  //posicionar letras...
				  $x = 85;
				  $y = 190;
				  imagecopy($gaffete,$imagen,$x,$y,0,0,420,132);			  
				  imagedestroy( $fondo );
				  imagedestroy( $imagen );			
				  //fin generamos imagenes del apmaterno...
				  
				  
				  //generamos imagenes del curp...
				  $imagen = imagecreatetruecolor( 420, 132);
                  $fondo = imagecreatefrompng( "../abcpng/bg_big.png" );
                  imagesettile( $imagen, $fondo );
				  imagefill( $imagen, 0, 0, IMG_COLOR_TILED );			  
				  $palabra = strtolower($this->ascii($actual['curp']));			  
				  
				  
				  $x = 10;				  
				  // Definimos la escala
				  $escala = 5;
				  
				  
                  $cont= strlen($palabra);
				  $var = 0;
                  while ($var<$cont)
                  { 
                   $letra=$palabra[$var];  				   
                   $var++;
				   if($letra == ' ') $letra = 'space';
				   if($letra == 'á' || $letra == 'Á') $letra = 'a';
				   if($letra == 'é' || $letra == 'É') $letra = 'e';
				   if($letra == 'í' || $letra == 'Í' ) $letra = 'i';
				   if($letra == 'ó' || $letra == 'Ó') $letra = 'o';
				   if($letra == 'ú' || $letra == 'Ú') $letra = 'u';
				   if($letra == 'ñ' || $letra == 'Ñ') $letra = 'ñ';
				  
				   if (file_exists("../abcpng/".$letra.".png")){
				   $char = imagecreatefrompng( "../abcpng/".$letra.".png" );					
				   }else
				   {
				   $char = imagecreatefrompng( "../abcpng/space.png" );					
				   }
				   imagecopyresampled( $imagen, $char, $x, 10, 0, 0, imagesx( $char ) * ( $escala / 100 ),imagesy( $char ) * ( $escala / 100 ), imagesx( $char ), imagesy( $char ) );					
			       $x += imagesx( $char ) * ( $escala / 100 );					
				   imagedestroy( $char );					  
                  }
				  				  			  
				  $imagen_x = imagesx($imagen);
				  $imagen_y = imagesy($imagen);				  		  
				  //posicionar letras...
				  $x = 85;
				  $y = 210;
				  imagecopy($gaffete,$imagen,$x,$y,0,0,420,132);			  
				  imagedestroy( $fondo );
				  imagedestroy( $imagen );			
				  //fin generamos imagenes del curp...
				  
				  
				  if($actual['deporte'] != ''){
				  //escribiendo deporte............				 				  
				  $fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 12;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($this->ascii($actual['deporte'])));
				  $x = ((($gaffete_x) - (($bbox[2]) - $bbox[0]))/2);
				  $y = $gaffete_y-30; 	
				  imagettftext($gaffete,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, strtoupper($this->ascii($actual['deporte'])));				  
				  //fin deporte............
				  }
				  
				  
				  if(!is_null($actual['pruebas']) && $actual['pruebas'] != 'null' && $actual['pruebas'] != ''){
				  $actual['pruebas'] = ' ['.$actual['pruebas'].']';
				  }else{
				  $actual['pruebas'] = '';
				  }
				  
				  if(!is_null($actual['categoria']) && $actual['categoria'] != 'null' && $actual['categoria'] != ''){
				   $actual['categoria'] = ' ['.$actual['categoria'].']';
				  }else{
				   $actual['categoria'] = '';
				  }
				  
				  
				  
				  //escribiendo categoria y pruebas............
				 $contpalabra = 0;
				 $limite_y = 280;
				 $tam_palabra = 8;			  
				 $palabra_desplegar = "";
				 $arr_categoria = split(' ',$this->ascii($actual['categoria'].$actual['pruebas']));				                 $fuente = "../ttf/verdana.ttf";
				  foreach($arr_categoria as $key => $palabra ){
				    $palabra_desplegar_anterior = $palabra_desplegar;//antes de juntar ambas
				    $palabra_desplegar .= $palabra." ";//una vez junatadas ambas					
					$bbox = imagettfbbox($tam_palabra, 0, $fuente, trim($palabra_desplegar));
					if($contpalabra <= 5){										
					if(($bbox[2] > ($gaffete_x))){
					  $palabra_desplegar = $palabra_desplegar_anterior;					  					  
					  $bbox = imagettfbbox($tam_palabra, 0, $fuente, trim($palabra_desplegar));
					  $contpalabra=$contpalabra+1;
					  $x = ((($gaffete_x) - (($bbox[2]) - $bbox[0]))/2);					
					  $y = $limite_y + ( 15 * $contpalabra ) + 10;					
					  imagettftext($gaffete,  $tam_palabra, 0, $x, $y, $gris, $fuente, trim($palabra_desplegar));
					  $palabra_desplegar = $palabra." ";
					}				
					}
				  }	
				  
				  if($contpalabra <= 5){
				  if(($palabra_desplegar != '')){
				    $contpalabra=$contpalabra+1;
				    $bbox = imagettfbbox($tam_palabra, 0, $fuente, trim($palabra_desplegar)); 
				    $x = ((($gaffete_x) - (($bbox[2]) - $bbox[0]))/2);					
					$y = $limite_y + ( 15 * $contpalabra ) + 10;					
					imagettftext($gaffete,  $tam_palabra, 0, $x, $y, $gris, $fuente, trim($palabra_desplegar));
					$palabra_desplegar = ""; 
				  }				  		
				  }  
				  //fin escribiendo evento............			   
		  
				  imagepng($gaffete,"../GaffeteTem/".$actual['curp'].".png");			  				  
				  imagedestroy($gaffete);
			      /////////////////fin crear y guardar el gaffete de participante///////////////// 
			      //$arrData[] = $actual; 
				  
				  
				  $arrData[] = $actual['curp'];			  
				  
				  $mtime = microtime(); 
                  $mtime = explode(" ",$mtime); 
                  $mtime = $mtime[1] + $mtime[0]; 
                  $tiempofinal = $mtime;
				  $tiempototal = ($tiempofinal - $tiempoinicial); 
				  if($tiempototal > 19) {break;}
                  /*echo "el gaffete ".$actual['curp']." se tardo ".$tiempototal." segundos";	  */
			   }
			   
			   return $arrData;			 
			 }
			 else
			 {
			   return "nada";
			 }			 
	  }  	  	  	      	

	  
}

?>


 


