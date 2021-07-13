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
	$rama = $_GET["rama"];
	$ano = $_GET["ano"];	
	$evento = $_GET["evento"];
	$formatocredencial = $_GET["formatocredencial"];
	
	$deportetext = $_GET["deportetext"];
	$municipiotext = $_GET["municipiotext"];	
	$modalidadtext = $_GET["modalidadtext"];	
	$ramatext = $_GET["ramatext"];	
	
	$eventotext = $_GET["eventotext"];	
	$anotext = $_GET["anotext"];
	
	$credencial_sel = $_GET["credencial_sel"];
	
	
	
	
	$filtroreporte = 'Filtros: ';
	if(!empty($deportetext)) $filtroreporte .=  '[Deporte: '.$deportetext.']';
	if(!empty($municipiotext)) $filtroreporte .=  '[Municipio: '.$municipiotext.']';
	if(!empty($modalidadtext)) $filtroreporte .=  '[Modalidad: '.$modalidadtext.']';	
	if(!empty($ramatext)) $filtroreporte .=  '[Rama: '.$ramatext.']';
	if(!empty($eventotext)) $filtroreporte .=  '[Evento: '.$eventotext.']';		
	if(!empty($anotext)) $filtroreporte .=  '[Año Ini.: '.$anotext.']';		
	
	$orientacion_hoja = $_GET["orientacion_hoja"];
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
	$pdf->nombrereporte = "Impresion Credenciales";
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
	
	//Initialize the table class
	//$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type	
	//$table_default_table_type['L_MARGIN'] = 0; 
	//$pdf->tbSetTableType($table_default_table_type);
	
	//Table Header	
	//for($i=0; $i<$columns; $i++) {		
		//$header_type2[$i] = $table_default_header_type;
		//$header_type2[$i]['T_SIZE'] = $tamano_fuente;		
	//}    
	
    /*$header_type2[0]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,2);//no 
	$header_type2[1]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,3);//convivencia 
	$header_type2[2]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,5);//municipio
	$header_type2[3]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,4);//rama
	$header_type2[4]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,10);//curp [nombre completo] [Fecha Nac.]
	$header_type2[5]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,13);//Direccion, Colonia, Codigo p.,Telefono
	$header_type2[6]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,10);//Correo, Peso, Talla	
	$header_type2[7]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,8);//Tipo s., localidad, RFC
	$header_type2[8]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,10);//Documentos
	$header_type2[9]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,2);//no categoria
	$header_type2[10]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,2);//Validado
	$header_type2[11]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,6);//modalidad
	$header_type2[12]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,6);//deporte	
	$header_type2[13]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,7.5);//categoria
	$header_type2[14]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,9.5);//prueba	total:98

	$header_type2[0]['TEXT'] = "No.";
	$header_type2[0]['T_ALIGN'] = "C";
	
	$header_type2[1]['TEXT'] = "Conv.";
	$header_type2[1]['T_ALIGN'] = "L";
	
	$header_type2[2]['TEXT'] = "Mun.";
	$header_type2[2]['T_ALIGN'] = "L";
	
	$header_type2[3]['TEXT'] = "Rama";
	$header_type2[3]['T_ALIGN'] = "L";
	
	$header_type2[4]['TEXT'] = "[CURP] Nombre Completo\n[Fecha Nac.]";
	$header_type2[4]['T_ALIGN'] = "L";
	
	$header_type2[5]['TEXT'] = "[Localidad] [Dirreción] [Colonia]\n[Codigo p.] [Telefono]";
	$header_type2[5]['T_ALIGN'] = "L";
	
	$header_type2[6]['TEXT'] = "[Tipo S.] [Peso] [Talla]";	
	$header_type2[6]['T_ALIGN'] = "L";
	
    $header_type2[7]['TEXT'] = "[Correo] [R.F.C.]";	
	$header_type2[7]['T_ALIGN'] = "L";
	
	$header_type2[8]['TEXT'] = "Documentos";	
	$header_type2[8]['T_ALIGN'] = "L";
	
	$header_type2[9]['TEXT'] = "No.";	
	$header_type2[9]['T_ALIGN'] = "L";
	
	$header_type2[10]['TEXT'] = "Val.";	
	$header_type2[10]['T_ALIGN'] = "L";
	
	$header_type2[11]['TEXT'] = "Modalidad";	
	$header_type2[11]['T_ALIGN'] = "L";
	
	$header_type2[12]['TEXT'] = "Deporte";	
	$header_type2[12]['T_ALIGN'] = "L";
	
	$header_type2[13]['TEXT'] = "Categoria";	
	$header_type2[13]['T_ALIGN'] = "L";
	
	$header_type2[14]['TEXT'] = "Pruebas";
	$header_type2[14]['T_ALIGN'] = "L";*/
	
	//$aHeaderArray = array(
		/*$header_type1,*/
		//$header_type2
	//);	

	//set the Table Header
	//$pdf->tbSetHeaderType($aHeaderArray, true);
	
	//Draw the Header
	//$pdf->tbDrawHeader();

	//Table Data Settings
	//$data_type = Array();//reset the array
//	for ($i=0; $i<$columns; $i++) $data_type[$i] = $table_default_data_type;
//
//	$pdf->tbSetDataType($data_type);
	
	//$fsize = $tamano_fuente;
//	
//	$rgb_r = 255;
//	$rgb_g = 255;
//	$rgb_b = 255;
	
	if(empty($deporte) || $deporte == 0) $filtrodeporte = ''; else $filtrodeporte = ' and cat_d.id_deporte = '.$deporte;
	  
	  if(empty($evento)) $filtroevento = ''; else $filtroevento = ' and reg_e.id_evento = '.$evento;
	  
	  if(empty($municipio) || $municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " and cat_mu.id_municipio = ".$municipio;
	  
	  if(empty($nombres)) $filtronombres = ''; else $filtronombres = " and UCASE(reg_p.reg_participante_nombre) like '%".strtoupper($nombres)."%'";
			  
	  if(empty($appaterno)) $filtroappaterno = ''; else $filtroappaterno = " and UCASE(reg_p.reg_participante_paterno) like '%".strtoupper($appaterno)."%'";
			  
	  if(empty($apmaterno)) $filtroapmaterno = ''; else $filtroapmaterno = " and UCASE(reg_p.reg_participante_materno) like '%".strtoupper($apmaterno)."%'";			            	           
	  if(empty($modalidad)) $filtromodalidad = ''; else $filtromodalidad = ' and reg_m.id_modalidad = '.$modalidad; 
	  
	  if(empty($rama)) $filtrorama = ''; else $filtrorama = ' and reg_p.reg_participante_sexo = \''.$rama.'\'';	     
	  if(empty($ano)) $filtroano = ''; else $filtroano = " and (year(reg_participante_fechanac) BETWEEN ".$ano." AND ".$ano.")";	
	  
	  if(empty($credencial_sel)) $filtrocredencial_sel = ''; else $filtrocredencial_sel = ' and reg_p.id_registro IN('.$credencial_sel.')';
	  
	  $filtro = $filtromunicipio.$filtroano.$filtromodalidad.$filtrodeporte.$filtrorama.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtroevento.$filtrocredencial_sel;
	  
	  if(!empty($filtro)){
		   $filtro = substr($filtro,5,strlen($filtro));		
		   $filtro = ' WHERE '.$filtro;
	  }
	
	/*if($ordenar!=''){		  
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
		 
	  }else{$filtroordenar = '';}*/
	
	$consulta = $MySQL->consulta("select			
	  reg_p.id_registro as id_registro,  	     
	  reg_p.reg_participante_curp as curp,    			 		 			 
	  reg_p.reg_participante_nombre as nombre,
	  reg_p.reg_participante_paterno as appaterno,
	  reg_p.reg_participante_materno as apmaterno,
	  reg_p.reg_participante_fechanac as fechanac,
	  reg_p.reg_participante_sexo as sexo,			
	  cat_mu.cat_municipio_nombre as municipio,
	  reg_c.id_categoriapar as idcategoriapar,
      GROUP_CONCAT(DISTINCT cat_m.cat_modalidad_nombre SEPARATOR ',') AS modalidad, 
	  GROUP_CONCAT(DISTINCT cat_d.cat_deporte_nombre SEPARATOR ',') AS deporte
	  from
	  ((((((reg_participante as reg_p 
			inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro)
			inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
			inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad)
			left join cat_municipio as cat_mu on cat_mu.id_municipio = reg_p.id_municipio)
			left join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria)
			left join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte)
			left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro GROUP BY reg_p.id_registro");	
	$n=0;	
	$num_total_registros = $MySQL->num_rows($consulta);				
	if($num_total_registros>0)
		{			
		
		        $i=20;
				$i_cont=0;
				
				// Including all required classes
				require('../BarCode/BCGFont.php');
				require('../BarCode/BCGColor.php');
				require('../BarCode/BCGDrawing.php'); 
				
				// Including the barcode technology
				include('../BarCode/BCGcode39.barcode.php'); 
				
				// Loading Font
				$font = new BCGFont('../BarCode/Arial.ttf', 8);
				
				// The arguments are R, G, B for color.
                $color_black = new BCGColor(0, 0, 0);
                $color_white = new BCGColor(255, 255, 255); 
				
				while($arrayreporte = $MySQL->fetch_array($consulta))
				{				    
				  extract($arrayreporte);		
				  
				  if(empty($formatocredencial)) $formatocredencial_imprimir = 'CredencialOficial.png'; else $formatocredencial_imprimir = 'CredencialOficial_'.$formatocredencial.".png";
				  
				  $credencial = imagecreatefrompng("../CredencialBase/".$formatocredencial_imprimir);
				  
				  $credencial_x = imagesx($credencial);
				  $credencial_y = imagesy($credencial);
				  
				  //ESCRIBIENDO TEXTO EN GAFFTE...				  
				  $bg = imagecolorallocate($credencial,255,255,255);
				  $gris = imagecolorallocate($credencial,100,100,100);
				  $azul_claro = imagecolorallocate($credencial,2,43,117);
				  
				  //escribiendo nombre ............				 				  
				  $fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 8;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($funcionesgenerales->ascii($nombre)));
				  $x = 13;
				  $y = $credencial_y-117; 	
				  imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, strtoupper($funcionesgenerales->ascii($nombre))/*strtoupper($this->ascii($actual['deporte']))*/);
				  
				  //escribiendo appateno y  apmateno ............				 				  
				  $fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 8;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($funcionesgenerales->ascii($appaterno." ".$apmaterno)));
				  $x = 13;
				  $y = $credencial_y-106; 	
				  imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, strtoupper($funcionesgenerales->ascii($appaterno." ".$apmaterno))/*strtoupper($this->ascii($actual['deporte']))*/);
				  
				  //escribiendo deporte ............				 				  
				  $fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 8;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, $funcionesgenerales->ascii($deporte));
				  $x = 13;
				  $y = $credencial_y-85; 	
				  imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, $funcionesgenerales->ascii($deporte)/*strtoupper($this->ascii($actual['deporte']))*/);
				  
				  //escribiendo modalidad ............				 				  
				  $fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 8;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, $funcionesgenerales->ascii($modalidad));
				  $x = 13;
				  $y = $credencial_y-63; 	
				  imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, $funcionesgenerales->ascii($modalidad)/*strtoupper($this->ascii($actual['deporte']))*/);
				  
				  //escribiendo entidad ............				 				  
				  $fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 8;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, $funcionesgenerales->ascii("Baja California Sur (".$municipio.")"));
				  $x = 13;
				  $y = $credencial_y-13; 	
				  imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, "Baja California Sur (".$funcionesgenerales->ascii($municipio).")"/*strtoupper($this->ascii($actual['deporte']))*/);
				  
				  //escribiendo curp............				 				  
				  $fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 7.5;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($funcionesgenerales->ascii($curp)));
				  $x = 13/*($credencial_x/2)-$bbox[2]-15*/;
				  $y = $credencial_y-140; 	;	
				  imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, $curp);
				  
				  //escribiendo vigencia ............		
				  $vigencia = "Enero ".date("Y")." a Diciembre ".date("Y");

				  $fuente = "../ttf/verdana.ttf";
				  $tam_palabra = 8;
				  $bbox = imagettfbbox($tam_palabra, 0, $fuente, strtoupper($funcionesgenerales->ascii($vigencia)));
				  $x = 13;
				  $y = $credencial_y-37; 	
				  imagettftext($credencial,  $tam_palabra, 0, $x, $y, $azul_claro, $fuente, $vigencia/*strtoupper($this->ascii($actual['deporte']))*/);
				  
				  if (file_exists('../fotosparticipantes/'.$curp.'.png')){				  
					  $foto = imagecreatefrompng("../fotosparticipantes/".$curp.".png");					  				 
					  $foto_x = imagesx($foto);
					  $foto_y = imagesy($foto);					   
					  $x = 247;
					  $y = intval(($credencial_y / 2) - 38);										
					  imagecopy($credencial,$foto,$x,$y,0,0,$foto_x,$foto_y);
					  imagedestroy($foto);					  
					  
					  $sello = imagecreatefrompng("../CredencialBase/sello_QSERVICE - Integrate.png");					  				 
					  $sello_x = imagesx($sello);
					  $sello_y = imagesy($sello);					   
					  $x = 186;
					  $y = intval(($credencial_y / 2) - 38);										
					  imagecopy($credencial,$sello,$x,$y,0,0,$sello_x,$sello_y);
					  imagedestroy($sello);					  
				  }			 
				  
				  $code = new BCGcode39();
				  $code-> setScale(1); // Resolution
				  $code->setThickness(25); // Thickness
				  $code->setForegroundColor($color_black); // Color of bars
				  $code->setBackgroundColor($color_white); // Color of spaces
				  $code->setFont($font); // Font (or 0)
				  $code->parse($curp); // Text				  
				  
				  /* Here is the list of the arguments
				  1 - Filename (empty : display on screen)
				  2 - Background color */
				  $drawing = new BCGDrawing("../CredencialTem/CodigoBarra/".$curp."_BarCode.png", $color_white);
				  $drawing->setBarcode($code);
				  $drawing->draw();

				  $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
				  
				  $codebar = imagecreatefrompng("../CredencialTem/CodigoBarra/".$curp."_BarCode.png");
				  $codebar_x = imagesx($codebar);
				  $codebar_y = imagesy($codebar);					   
				  $x = intval(($credencial_x / 2) + ((($credencial_x / 2) - $codebar_x)/2));
				  $y = intval($credencial_y - 50);										
				  imagecopy($credencial,$codebar,$x,$y,0,0,$codebar_x,$codebar_y);
				  imagedestroy($codebar);
				  
				  
				  $firma = imagecreatefrompng("../CredencialBase/firma_hirales.png");					  				 
				  $firma_x = imagesx($firma);
				  $firma_y = imagesy($firma);					   
				  $x = 345;
				  $y = intval(($credencial_y / 2) - 55);										
				  imagecopy($credencial,$firma,$x,$y,0,0,$firma_x,$firma_y);
				  imagedestroy($firma);
				  
				  imagepng($credencial,"../CredencialTem/".$curp.".png");			  				  
				  imagedestroy($credencial);
				  
				  $pdf->Image("../CredencialTem/".$curp.".png",10,$i,175,59,'PNG');				  
				  $i = $i + 60; 		
				  $i_cont++;
				  
				  if($i_cont == 4){					  
					  $pdf->AddPage();
					 
					  $i = 20;
					  $i_cont = 0;
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