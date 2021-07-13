<?php    
    @ini_set('memory_limit', '128M');
    set_time_limit(0);
	include("../scripts/include/dbcon.php");	
	require "../scripts/clases/class.dbsession.php";
	$session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: ../index.php");
	}   
	
	//Table Base Classs
	require_once("class.fpdf_table.php");
	
	//Class Extention for header and footer	
	require_once("header_footer.inc");
	
	//Table Defintion File
	require_once("table_def.inc");
	
	require('fpdf_alpha.php');

    $pdf_image=new PDF_ImageAlpha();
	
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
	$reporte_sel = $_GET["reporte_sel"];
	
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
	
	$orientacion_hoja = "p";
	$tamano_hoja = $_GET["tamano_hoja"];
	$tamano_hoja_mm = $_GET["tamano_hoja_mm"];
	$tamano_fuente = $_GET["tamano_fuente"];	
	$separacion_linea = $_GET["separacion_linea"];	
	
	$tamano_fuente = $tamano_fuente-.5;
	$separacion_linea = $separacion_linea + 1;
	
	/*$bg_color1 = array(234, 255, 218);
	$bg_color2 = array(165, 250, 220);
	$bg_color3 = array(255, 252, 249);	*/	
	
	$pdf = new pdf_usage($orientacion_hoja,'mm',$tamano_hoja);			
	$pdf->nombrereporte = "Impresion Fotos Paticipantes";
	$pdf->filtroreporte = $filtroreporte;
	$pdf->headfont = $tamano_fuente;
	$pdf->anchohoja = $tamano_hoja_mm;
	$pdf->separacion_linea = $separacion_linea;
	$pdf->AddPage();
	
	/*$pdf->SetAutoPageBreak(true,10);*/
    $pdf->SetMargins(2, ($separacion_linea*3)+12, 20);
	
	$pdf->AliasNbPages(); 

	//$columns = 15; //five columns   
	
	$pdf->SetStyle("p","times","",10,"130,0,30");
	$pdf->SetStyle("t1","arial","",10,"0,151,200");
	$pdf->SetStyle("size","times","BI",13,"0,0,120");
	
	if(empty($deporte) || $deporte == 0) $filtrodeporte = ''; else $filtrodeporte = ' and cat_d.id_deporte = '.$deporte;
	  
	if(empty($evento)) $filtroevento = ''; else $filtroevento = ' and reg_e.id_evento = '.$evento;
	
	if(empty($municipio) || $municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " and cat_mu.id_municipio = ".$municipio;
	
	if(empty($nombres)) $filtronombres = ''; else $filtronombres = " and UCASE(reg_p.reg_participante_nombre) like '%".strtoupper($nombres)."%'";
			
	if(empty($appaterno)) $filtroappaterno = ''; else $filtroappaterno = " and UCASE(reg_p.reg_participante_paterno) like '%".strtoupper($appaterno)."%'";
			
	if(empty($apmaterno)) $filtroapmaterno = ''; else $filtroapmaterno = " and UCASE(reg_p.reg_participante_materno) like '%".strtoupper($apmaterno)."%'";			            	           
	if(empty($modalidad)) $filtromodalidad = ''; else $filtromodalidad = ' and reg_m.id_modalidad = '.$modalidad;
	if(empty($categoria)) $filtrocategoria = ''; else $filtrocategoria = ' and reg_c.id_categoria = '.$categoria;	
	if(empty($rama)) $filtrorama = ''; else $filtrorama = ' and reg_p.reg_participante_sexo = \''.$rama.'\'';
	
	if(empty($reporte_sel)) $filtroreporte_sel = ''; else $filtroreporte_sel = ' and reg_p.id_registro IN('.$reporte_sel.')';
	
	
	if(empty($validado)) $filtrovalidado = ''; else $filtrovalidado = ' and reg_c.reg_categoriaparticipante_validado = "'.$validado.'"';
	  
	if(empty($anoinicio) && empty($anofin)) $filtroano = ''; else $filtroano = " and (year(reg_p.reg_participante_fechanac) BETWEEN ".$anoinicio." AND ".$anofin.")";		
	
	$filtro = $filtromunicipio.$filtroano.$filtrovalidado.$filtromodalidad.$filtrodeporte.$filtrorama.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtrocategoria.$filtroevento.$filtroreporte_sel;
	
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
	
	$consulta = $MySQL->consulta("select			
	  reg_p.id_registro as id_registro,  	     
	  reg_p.reg_participante_curp as curp,    			 		 			 
	  reg_p.reg_participante_nombre as nombre,
	  reg_p.reg_participante_paterno as appaterno,
	  reg_p.reg_participante_materno as apmaterno,
	  reg_p.reg_participante_fechanac as fechanac,
	  reg_p.reg_participante_sexo as sexo,		
	  cat_d.cat_deporte_nombre as deporte,
	  cat_m.cat_modalidad_nombre as modalidad,	  
	  GROUP_CONCAT(DISTINCT cat_mu.cat_municipio_nombre SEPARATOR ',') AS municipio,
	  GROUP_CONCAT(DISTINCT concat_WS('{x}', concat('V:',reg_c.reg_categoriaparticipante_validado),concat('M:',cat_m.cat_modalidad_nombre),concat('D:',cat_d.cat_deporte_nombre),concat('C:',cat_c.cat_categoria_nombre),concat('P:',reg_c.reg_categoriaparticipante_pruebas),concat('CG:',reg_m.reg_modalidadparticipante_cargo),concat('AI:',cat_c.cat_categoria_rangoinicio),concat('AF:',cat_c.cat_categoria_rangofin)) SEPARATOR '{y}') AS caracteristicas,
	  reg_p.reg_participante_direccion as direccion,
	  reg_p.reg_participante_codigop as codigop,
	  reg_p.reg_participante_telefonos as telefono,
	  reg_p.reg_participante_correo as correo,
	  reg_p.reg_participante_peso as peso,
	  reg_p.reg_participante_talla as talla,
	  reg_p.reg_participante_tiposanguineo as tiposanguineo,
	  reg_p.reg_participante_localidad as localidad,
	  reg_p.reg_participante_rfc as rfc,
	  reg_p.reg_participante_colonia as colonia,
	  reg_e.reg_eventoparticipante_documentos as documentos	 	  
	  from
	  ((((((reg_participante as reg_p 
			inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro)
			inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
			inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad)
			left join cat_municipio as cat_mu on cat_mu.id_municipio = reg_p.id_municipio)
			left join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria)
			left join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte)
			left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro GROUP BY reg_p.id_registro $filtroordenar");	
		
	$n=0;	
	$num_total_registros = $MySQL->num_rows($consulta);				
	if($num_total_registros>0)
		{		
		        $i=20;
				$i_cont=0;
				
				// Including all required classes
				//require('../BarCode/BCGFont.php');
//				require('../BarCode/BCGColor.php');
//				require('../BarCode/BCGDrawing.php'); 
				
				// Including the barcode technology
				//include('../BarCode/BCGcode39.barcode.php'); 
				
				// Loading Font
				//$font = new BCGFont('../BarCode/Arial.ttf', 8);
				
				// The arguments are R, G, B for color.
                //$color_black = new BCGColor(0, 0, 0);
//                $color_white = new BCGColor(255, 255, 255); 
				
				$y_texto = 5;
				while($arrayreporte = $MySQL->fetch_array($consulta))
				{				    
				  extract($arrayreporte);		
				  				  
				  $credencial = imagecreatefrompng("../CredencialBase/BaseFotosImprimir.png");				  
				  $credencial_x = imagesx($credencial);
				  $credencial_y = imagesy($credencial);				  
				  
				  //ESCRIBIENDO TEXTO EN GAFFTE...				  
				  $bg = imagecolorallocate($credencial,255,255,255);
				  $gris = imagecolorallocate($credencial,100,100,100);
				  $azul_claro = imagecolorallocate($credencial,2,43,117);
				  
				  //escribiendo nombre ............				 				  
				  //$fuente = "../ttf/verdana.ttf";
//				  $tam_palabra = 10;
//				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($funcionesgenerales->ascii($nombre)));
				  $x = 13;
				  $y = $y_texto + 20; 	
				  /*imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, strtoupper($funcionesgenerales->ascii($nombre))strtoupper($this->ascii($actual['deporte'])));*/
				  
				  $pdf->SetXY($x,$y);				  
				  $pdf->SetFont('Arial','',7);				  
				  $pdf->Write(3,strtoupper($funcionesgenerales->ascii($nombre)));
				  
				  
				  //escribiendo appateno y  apmateno ............				 				  
				  //$fuente = "../ttf/verdana.ttf";
//				  $tam_palabra = 10;
//				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($funcionesgenerales->ascii($appaterno." ".$apmaterno)));
				  $x = 13;
				  $y = $y_texto + 23; 	
				  /*imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, strtoupper($funcionesgenerales->ascii($appaterno." ".$apmaterno))strtoupper($this->ascii($actual['deporte'])));*/
				  
				  $pdf->SetXY($x,$y);				  
				  $pdf->SetFont('Arial','',7);				  
				  $pdf->Write(3,strtoupper($funcionesgenerales->ascii($appaterno." ".$apmaterno)));
				  
				  //escribiendo deporte ............				 				  
				  //$fuente = "../ttf/verdana.ttf";
//				  $tam_palabra = 10;
//				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, $funcionesgenerales->ascii($deporte));
				  $x = 13;
				  $y = $y_texto + 26; 	
				  /*imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, $funcionesgenerales->ascii($deporte)strtoupper($this->ascii($actual['deporte'])));*/
				  
				  $pdf->SetXY($x,$y);				  
				  $pdf->SetFont('Arial','',7);				  
				  $pdf->Write(3,$funcionesgenerales->ascii($deporte));
				  
				  //escribiendo modalidad ............				 				  
				  //$fuente = "../ttf/verdana.ttf";
//				  $tam_palabra = 10;
//				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, $funcionesgenerales->ascii($modalidad));
				  $x = 13;
				  $y = $y_texto + 29; 	
				  /*imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, $funcionesgenerales->ascii($modalidad)strtoupper($this->ascii($actual['deporte'])));*/
				  
				  $pdf->SetXY($x,$y);				  
				  $pdf->SetFont('Arial','',7);				  
				  $pdf->Write(3,$funcionesgenerales->ascii($modalidad));
				  
				  //escribiendo entidad ............				 				  
				  //$fuente = "../ttf/verdana.ttf";
//				  $tam_palabra = 10;
//				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, $funcionesgenerales->ascii("Baja California Sur (".$municipio.")"));
				  $x = 13;
				  $y = $y_texto + 32; 	
				 /* imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, "Baja California Sur (".$funcionesgenerales->ascii($municipio).")"strtoupper($this->ascii($actual['deporte'])));*/
				  
				  $pdf->SetXY($x,$y);				  
				  $pdf->SetFont('Arial','',7);				  
				  $pdf->Write(3,$funcionesgenerales->ascii("Baja California Sur (".$municipio.")"));
				  
				  //escribiendo curp............				 				  
				  /*$fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 9.5;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($funcionesgenerales->ascii($curp)));*/
				  $x = 13/*($credencial_x/2)-$bbox[2]-15*/;
				  $y = $y_texto + 35;	
				  //imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, $curp);
				  
				  $pdf->SetXY($x,$y);				  
				  $pdf->SetFont('Arial','',7);				  
				  $pdf->Write(3,strtoupper($funcionesgenerales->ascii($curp)));
				  
				  //escribiendo vigencia ............		
				  //$vigencia = "Enero ".date("Y")." a Diciembre ".date("Y");
//
//				  $fuente = "../ttf/verdana.ttf";
//				  $tam_palabra = 8;
//				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($funcionesgenerales->ascii($vigencia)));
//				  $x = 13;
//				  $y = $credencial_y-37; 	
//				  imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, $vigencia/*strtoupper($this->ascii($actual['deporte']))*/);
				  
				  if (file_exists('../fotosparticipantes/'.$curp.'.png')){			      
					  
					  $x_foto = 50;
					  $x_incremento = 23;
					  
					  $pdf->ImagePngWithAlpha("../fotosparticipantes/".$curp.".png",$x_foto,$i,18,26);
					  
					  $x_foto = $x_foto + $x_incremento;   
					  $pdf->ImagePngWithAlpha("../fotosparticipantes/".$curp.".png",$x_foto,$i,18,26);
					  
					  $x_foto = $x_foto + $x_incremento;   
					  $pdf->ImagePngWithAlpha("../fotosparticipantes/".$curp.".png",$x_foto,$i,18,26);
					  
					  $x_foto = $x_foto + $x_incremento;   
					  $pdf->ImagePngWithAlpha("../fotosparticipantes/".$curp.".png",$x_foto,$i,18,26);
					  
					  $x_foto = $x_foto + $x_incremento;   
					  $pdf->ImagePngWithAlpha("../fotosparticipantes/".$curp.".png",$x_foto,$i,18,26);
					  
					  $x_foto = $x_foto + $x_incremento;   
					  $pdf->ImagePngWithAlpha("../fotosparticipantes/".$curp.".png",$x_foto,$i,18,26);
					  
					  $x_foto = $x_foto + $x_incremento;   
					  $pdf->ImagePngWithAlpha("../fotosparticipantes/".$curp.".png",$x_foto,$i,18,26);
					  
					  //$pdf->Image("../fotosparticipantes/".$curp.".png",100,$i,26,18,'PNG');				  
					  
					  /*$foto = imagecreatefrompng("../fotosparticipantes/".$curp.".png");					  				 
					  $foto_x = imagesx($foto);
					  $foto_y = imagesy($foto);					   
					  
					  $base_x_foto = 227;
					  
					  $x = $base_x_foto;
					  $y = 5;					  
					  imagecopy($credencial,$foto,$x,$y,0,0,$foto_x,$foto_y);
					  
					  $x = $x + 72;
					  $y = 5;	
					  imagecopy($credencial,$foto,$x,$y,0,0,$foto_x,$foto_y);
					  
					  $x = $x + 72;
					  $y = 5;	
					  imagecopy($credencial,$foto,$x,$y,0,0,$foto_x,$foto_y);
					  
					  $x = $x + 72;
					  $y = 5;	
					  imagecopy($credencial,$foto,$x,$y,0,0,$foto_x,$foto_y);
					  
					  $x = $x + 72;
					  $y = 5;	
					  imagecopy($credencial,$foto,$x,$y,0,0,$foto_x,$foto_y);
					  
					  $x = $x + 72;
					  $y = 5;	
					  imagecopy($credencial,$foto,$x,$y,0,0,$foto_x,$foto_y);
					  
					  $x = $x + 72;
					  $y = 5;	
					  imagecopy($credencial,$foto,$x,$y,0,0,$foto_x,$foto_y);				  
					  
					  imagedestroy($foto);*/					  
					  
					 // $sello = imagecreatefrompng("../CredencialBase/sello_QSERVICE - Integrate.png");					  				 
//					  $sello_x = imagesx($sello);
//					  $sello_y = imagesy($sello);					   
//					  $x = 186;
//					  $y = intval(($credencial_y / 2) - 38);										
//					  imagecopy($credencial,$sello,$x,$y,0,0,$sello_x,$sello_y);
//					  imagedestroy($sello);					  
				  }			 
				  
				  //$code = new BCGcode39();
//				  $code-> setScale(1); // Resolution
//				  $code->setThickness(25); // Thickness
//				  $code->setForegroundColor($color_black); // Color of bars
//				  $code->setBackgroundColor($color_white); // Color of spaces
//				  $code->setFont($font); // Font (or 0)
//				  $code->parse($curp); // Text				  
				  
				  /* Here is the list of the arguments
				  1 - Filename (empty : display on screen)
				  2 - Background color */
				 // $drawing = new BCGDrawing("../CredencialTem/CodigoBarra/".$curp."_BarCode.png", $color_white);
//				  $drawing->setBarcode($code);
//				  $drawing->draw();
//
//				  $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
//				  
//				  $codebar = imagecreatefrompng("../CredencialTem/CodigoBarra/".$curp."_BarCode.png");
//				  $codebar_x = imagesx($codebar);
//				  $codebar_y = imagesy($codebar);					   
//				  $x = intval(($credencial_x / 2) + ((($credencial_x / 2) - $codebar_x)/2));
//				  $y = intval($credencial_y - 50);										
//				  imagecopy($credencial,$codebar,$x,$y,0,0,$codebar_x,$codebar_y);
//				  imagedestroy($codebar);
				  
				  
				  /*$firma = imagecreatefrompng("../CredencialBase/firma_hirales.png");					  				 
				  $firma_x = imagesx($firma);
				  $firma_y = imagesy($firma);					   
				  $x = 345;
				  $y = intval(($credencial_y / 2) - 55);										
				  imagecopy($credencial,$firma,$x,$y,0,0,$firma_x,$firma_y);
				  imagedestroy($firma);*/
				  
				  /*imagepng($credencial,"../FotosImprimirTemp/".$curp.".png");			  				  
				  imagedestroy($credencial);*/
				  
				  /*$pdf->Image("../FotosImprimirTemp/".$curp.".png",10,$i,201,30,'PNG');*/				  
				  $i = $i + 30; 		
				  $i_cont++;
				  
				  $y_texto = $y_texto + 30;
				  
				  if($i_cont == 8){					  
					  $pdf->AddPage();					 
					  $i = 20;
					  $i_cont = 0;
					  $y_texto = 5;
				  }		
				  
				}//3 while				
	   }
   else
	   {
				/*$data = Array();
				$data[0]['TEXT'] = 'Sin Resultados...';
				$data[0]['COLSPAN'] = 19;
				$data[0]['T_ALIGN'] = "L";
				
				$pdf->tbDrawData($data);*/
	   }
	   
	//output the table data to the pdf
	//$pdf->tbOuputData();
	
	//draw the Table Border
	//$pdf->tbDrawBorder();	

	$pdf->Output();

?>