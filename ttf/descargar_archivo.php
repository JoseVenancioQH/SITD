<?php    
    @ini_set('memory_limit', '128M');
    set_time_limit(0);
    include("../scripts/include/dbcon.php");
    require "../scripts/clases/class.dbsession.php";
	require "../scripts/clases/class.ftp.php";
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: index.php");
	}   
	
	include("../scripts/clases/class.mysql.php");
	$MySQL = new MySQL();
	
	include("../scripts/clases/class.funcionesgenerales.php");
	$funcionesgenerales = new funcionesgenerales();
	
	$deporte = $_GET["deporte"];
	$municipio = $_GET["municipio"];
	$nombres = $_GET["nombres"];		
	$appaterno = $_GET["appaterno"];
	$apmaterno = $_GET["apmaterno"];
	$modalidad = $_GET["modalidad"];
	$categoria = $_GET["categoria"];
	$rama = $_GET["rama"];
	$anoinicio = $_GET["anoinicio"];
	$anofin = $_GET["anofin"];
	$convanoinicio = $_GET["convanoinicio"];
	$evento = $_GET["evento"];
	$validado = $_GET["validado"];	
	
	$deportetext = $_GET["deportetext"];
	$municipiotext = $_GET["municipiotext"];	
	$modalidadtext = $_GET["modalidadtext"];
	$categoriatext = $_GET["categoriatext"];
	$ramatext = $_GET["ramatext"];
	$ordenar = $_GET["ordenar"];
	$ordenartext = $_GET["ordenartext"];
	
	$eventotext = $_GET["eventotext"];
	$anoiniciotext = $_GET["anoiniciotext"];
	$anofintext = $_GET["anofintext"];
	$convanoiniciotext = $_GET["convanoiniciotext"];
	$validadotext = $_GET["validadotext"];
	
	$filtroreporte = 'Filtros: ';
	if(!empty($deportetext)) $filtroreporte .=  '[Deporte: '.$deportetext.']';
	if(!empty($municipiotext)) $filtroreporte .=  '[Municipio: '.$municipiotext.']';
	if(!empty($modalidadtext)) $filtroreporte .=  '[Modalidad: '.$modalidadtext.']';
	if(!empty($categoriatext)) $filtroreporte .=  '[Categoria: '.$categoriatext.']';
	if(!empty($ramatext)) $filtroreporte .=  '[Rama: '.$ramatext.']';
	if(!empty($eventotext)) $filtroreporte .=  '[Evento: '.$eventotext.']';		
	if(!empty($anoiniciotext)) $filtroreporte .=  '[Año Ini.: '.$anoiniciotext.']';	
	if(!empty($anofintext)) $filtroreporte .=  '[Año Fin.: '.$anofintext.']';	
	if(!empty($convanoiniciotext)) $filtroreporte .=  '['.$convanoiniciotext.']';	
	if(!empty($validadotext)) $filtroreporte .=  '['.$validadotext.']';
	if(!empty($ordenartext)) $filtroreporte .=  '[Orden:'.$ordenartext.']';
	
	$orientacion_hoja = $_GET["orientacion_hoja"];
	$tamano_hoja = $_GET["tamano_hoja"];
	$tamano_hoja_mm = $_GET["tamano_hoja_mm"];
	$tamano_fuente = $_GET["tamano_fuente"];	
	$separacion_linea = $_GET["separacion_linea"];		
	
	if(empty($municipio) || $municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " WHERE cat_mu.id_municipio = ".$municipio;	
	
	if(empty($deporte) || $deporte == 0) $filtrodeporte = ''; else $filtrodeporte = ' and cat_d.id_deporte = '.$deporte;
	  
	if(empty($evento)) $filtroevento = ''; else $filtroevento = ' and reg_e.id_evento = '.$evento;
	
	if(empty($municipio) || $municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " and cat_mu.id_municipio = ".$municipio;
	
	if(empty($nombres)) $filtronombres = ''; else $filtronombres = " and UCASE(reg_p.reg_participante_nombre) like '%".strtoupper($nombres)."%'";
			
	if(empty($appaterno)) $filtroappaterno = ''; else $filtroappaterno = " and UCASE(reg_p.reg_participante_paterno) like '%".strtoupper($appaterno)."%'";
			
	if(empty($apmaterno)) $filtroapmaterno = ''; else $filtroapmaterno = " and UCASE(reg_p.reg_participante_materno) like '%".strtoupper($apmaterno)."%'";			            	           
	if(empty($modalidad)) $filtromodalidad = ''; else $filtromodalidad = ' and reg_m.id_modalidad = '.$modalidad;
	if(empty($categoria)) $filtrocategoria = ''; else $filtrocategoria = ' and reg_c.id_categoria = '.$categoria;	
	if(empty($rama)) $filtrorama = ''; else $filtrorama = ' and reg_p.reg_participante_sexo = \''.$rama.'\'';
	
	if(empty($validado)) $filtrovalidado = ''; else $filtrovalidado = ' and reg_c.reg_categoriaparticipante_validado = "'.$validado.'"';
	  
	if(empty($anoinicio) && empty($anofin)) $filtroano = ''; else $filtroano = " and (year(reg_p.reg_participante_fechanac) BETWEEN ".$anoinicio." AND ".$anofin.")";		
	
	$filtro = $filtromunicipio.$filtroano.$filtrovalidado.$filtromodalidad.$filtrodeporte.$filtrorama.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtrocategoria.$filtroevento;
	
	if(!empty($filtro)){
		 $filtro = substr($filtro,5,strlen($filtro));		
		 $filtro = ' WHERE '.$filtro;
	}
	
	if($ordenar!=''){		  
		 $arrorden = explode(',',$ordenar);		 
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
	
	/*$consulta = $MySQL->consulta("select
      cat_d.cat_deporte_nombre as deporte,			
	  ".$cad_consulta."
      COUNT(*) as total	  
		  from
		  ((((((reg_participante as reg_p 
				inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro)
				inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
				inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad)
				left join cat_municipio as cat_mu on cat_mu.id_municipio = reg_p.id_municipio)
				left join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria)
				left join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte)
				left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro GROUP BY cat_d.id_deporte");	*/	
	 
	/*$arch = 'fotosparticipantes/AAAA940416MBSYGM02.png'; 
	header( "Content-Type: application/octet-stream"); 
	header( "Content-Disposition: attachment; filename=".$arch."");  
	$handle = fopen ($arch, "r"); 
	echo fread ($handle, filesize ($arch)); 
	fclose ($arch); */	
	
	
	# Linear connection info for connecting to FTP 

	# set up basic connection
	$ftp_server = "QSERVICE - Integrate";
	$ftp_user    = "QSERVICE - Integrate";
	$ftp_pass	   = "qfsd21kl";
	 
	$ftp_conn   = ftp_connect($ftp_server);
	$ftp_login   = ftp_login($ftp_conn, $ftp_user, $ftp_pass);
	 
	ftp_pasv($ftp_conn, true);
	 
	# check connection
	if ((!$ftp_conn) || (!$ftp_login)) {
		echo "FTP connection has failed!";
		echo "Attempted to connect to $ftp_server for user $ftp_user";
	} else {
		echo "Connected to $ftp_server, for user $ftp_user";
	}
	 
	echo "Currently in ".ftp_pwd($ftp_conn);
	 
	if (ftp_chdir($ftp_conn, "IDX_Version_5")) {
		echo "Current directory is now: " . ftp_pwd($ftp_conn) . "\n";
	} else {
		echo "Couldn't change directory\n";
	}
	 
	# Dump the data to the screen
	var_dump(ftp_rawlist($ftp_conn, '.'));
	 
	echo APPPATH;
	 
	# For the actual ftp actions, I use a FTP class I wrote which you can grab below
	FTP::download(APPPATH.'data/idx', '.', $ftp_conn);	
	
	// definir algunas variables
	/*$archivo_local = 'c:\FotoTemporal\AAAA940416MBSYGM02.png';
	$archivo_servidor = 'fotosparticipantes/AAAA940416MBSYGM02.png';
	
	$servidor_ftp = "QSERVICE - Integrate";
	$ftp_nombre_usuario = "QSERVICE - Integrate";
	$ftp_contrasenya = "qfsd21kl";*/
	
	// configurar conexión básica
	/*$id_con = ftp_connect($servidor_ftp);*/
	
	// iniciar sesión con nombre de usuario y contraseña
	/*$resultado_login = ftp_login($id_con, $ftp_nombre_usuario, $ftp_contrasenya);*/
	
	// intentar la descarga de $archivo_servidor y guardarlo en $archivo_local
	/*if (ftp_get($id_con, $archivo_local, $archivo_servidor, FTP_BINARY)) {
		echo "Se ha guardado satisfactoriamente en $archivo_local\n";
	} else {
		echo "Ha ocurrido un problema\n";
	}*/
	
	// cerrar la conexión
	/*ftp_close($id_con);*/				
	
?>