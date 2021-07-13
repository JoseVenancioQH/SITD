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
	
	$tamano_fuente = $tamano_fuente-.5;
	$separacion_linea = $separacion_linea + 1;
	
	$bg_color1 = array(234, 255, 218);
	$bg_color2 = array(165, 250, 220);
	$bg_color3 = array(255, 252, 249);		
	
	$pdf = new pdf_usage($orientacion_hoja,'mm',$tamano_hoja);			
	$pdf->nombrereporte = "Reporte Resumen por Municipio - Deporte";
	$pdf->filtroreporte = $filtroreporte;
	$pdf->headfont = $tamano_fuente;
	$pdf->anchohoja = $tamano_hoja_mm;
	$pdf->separacion_linea = $separacion_linea;
	
	$pdf->Open();	
	
	$pdf->SetAutoPageBreak(true,10);
    $pdf->SetMargins(2, ($separacion_linea*3)+12, 20);
	$pdf->AddPage();
	$pdf->AliasNbPages(); 	
	
	if(empty($municipio) || $municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " WHERE cat_mu.id_municipio = ".$municipio;	
	
	$consulta = $MySQL->consulta("SELECT cat_mu.id_municipio as idmunicipio, cat_mu.cat_municipio_nombre as nommunicipio FROM cat_municipio as cat_mu $filtromunicipio");	
	
	$num_total_registros = $MySQL->num_rows($consulta);	
	
	$municipio_nom = array();
	$municipio_id = array();	
	$municipio_text = array(); 	
	while($arraymunicipio = $MySQL->fetch_array($consulta))
	 {				    
	      extract($arraymunicipio);			  		  		  
		  $municipio_nom[] = html_entity_decode($nommunicipio);
		  $municipio_id[] = $idmunicipio;
		  $municipio_text[$idmunicipio] = str_replace('&uacute;','u',str_replace('&eacute;','e',strtolower(str_replace(' ','',$nommunicipio))));		  
		  $municipio_totales[str_replace('&uacute;','u',str_replace('&eacute;','e',strtolower(str_replace(' ','',$nommunicipio))))] = array("H"=>0,"M"=>0);		   	  
	 }	

	$columns = ($num_total_registros*3)+1; //five columns   
	
	$pdf->SetStyle("p","times","",10,"130,0,30");
	$pdf->SetStyle("t1","arial","",10,"0,151,200");
	$pdf->SetStyle("size","times","BI",13,"0,0,120");
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, true);
	
	//set the Table Type	
	$table_default_table_type['L_MARGIN'] = 0; 
	$pdf->tbSetTableType($table_default_table_type);
	
	//Table Header	
	for($i=0; $i<$columns; $i++) {		
		$header_type2[$i] = $table_default_header_type;
		$header_type2[$i]['T_SIZE'] = $tamano_fuente;		
	}
	
	$header_type2[0]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,10);//Deporte 
	$header_type2[0]['TEXT'] = "Deporte";
	$header_type2[0]['T_ALIGN'] = "L";
	
	$i=1;
	while($i<$columns) {			
		foreach ($municipio_nom as $datoarr) {
			$header_type2[$i]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,5);//contadores 
			$header_type2[$i]['TEXT'] = $datoarr."\n Hombre";
			$header_type2[$i]['T_ALIGN'] = "C";
			$i++;
			$header_type2[$i]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,5);//contadores 
			$header_type2[$i]['TEXT'] = $datoarr."\n Mujer";
			$header_type2[$i]['T_ALIGN'] = "C";
			$i++;
			$header_type2[$i]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,5);//contadores 
			$header_type2[$i]['TEXT'] = $datoarr."\n Total";
			$header_type2[$i]['T_ALIGN'] = "C";		
			$i++;
		}		
	}    
	
	$header_type2[$i]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,5);//contadores 
	$header_type2[$i]['TEXT'] = "Total";
	$header_type2[$i]['T_ALIGN'] = "C";
	
	$aHeaderArray = array(
		/*$header_type1,*/
		$header_type2
	);	

	//set the Table Header
	$pdf->tbSetHeaderType($aHeaderArray, true);
	
	//Draw the Header
	$pdf->tbDrawHeader();

	//Table Data Settings
	$data_type = Array();//reset the array
	for ($i=0; $i<$columns; $i++) $data_type[$i] = $table_default_data_type;

	$pdf->tbSetDataType($data_type);
	
	$fsize = $tamano_fuente;
	
	$rgb_r = 255;
	$rgb_g = 255;
	$rgb_b = 255;
	
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
	  
	$cad_consulta = '';  
	foreach ($municipio_id as $datoarr) {
		$cad_consulta .= "COUNT(if(reg_p.id_municipio =".$datoarr." and reg_p.reg_participante_sexo='H',1,null)) as ".$municipio_text[$datoarr]."h,";
		$cad_consulta .= "COUNT(if(reg_p.id_municipio =".$datoarr." and reg_p.reg_participante_sexo='M',1,null)) as ".$municipio_text[$datoarr]."m,";
		$cad_consulta .= "COUNT(if(reg_p.id_municipio =".$datoarr.",1,null)) as ".$municipio_text[$datoarr]."total,";
	}  	  
	
	$consulta = $MySQL->consulta("select
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
				left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro GROUP BY cat_d.id_deporte");	
	
	$n=0;	
	$num_total_registros = $MySQL->num_rows($consulta);				
	if($num_total_registros>0)
		{			        
				while($arrayresumen = $MySQL->fetch_assoc($consulta))
				{				    
				  			  
				  $data = Array();
				  $data[0]['TEXT'] = html_entity_decode($arrayresumen['deporte']);
				  $data[0]['T_SIZE'] = $fsize;
				  $data[0]['T_ALIGN'] = "L";
				  $data[0]['V_ALIGN'] = "T";				  
				  $data[0]['LN_SIZE'] = $separacion_linea;			  
				  
				  $i=1;
	              while($i<$columns) {				  
					foreach ($municipio_text as $datoarr) {				 						
						$data[$i]['TEXT'] = $arrayresumen[$datoarr.'h'];
						$data[$i]['T_SIZE'] = $fsize;
						$data[$i]['T_ALIGN'] = "C";
						$data[$i]['V_ALIGN'] = "T";				  
						$data[$i]['LN_SIZE'] = $separacion_linea;					   
						$i++;
						
						$data[$i]['TEXT'] = $arrayresumen[$datoarr.'m'];
						$data[$i]['T_SIZE'] = $fsize;
						$data[$i]['T_ALIGN'] = "C";
						$data[$i]['V_ALIGN'] = "T";				  
						$data[$i]['LN_SIZE'] = $separacion_linea;					   
						$i++;
						
						$data[$i]['TEXT'] = $arrayresumen[$datoarr.'total'];
						$data[$i]['T_SIZE'] = $fsize;
						$data[$i]['T_ALIGN'] = "C";
						$data[$i]['V_ALIGN'] = "T";				  
						$data[$i]['LN_SIZE'] = $separacion_linea;					   
						$i++;
					} 
				  }				 
				  
				  $data[$i]['TEXT'] = $arrayresumen['total'];
				  $data[$i]['T_SIZE'] = $fsize;
				  $data[$i]['T_ALIGN'] = "C";
				  $data[$i]['V_ALIGN'] = "T";				  
				  $data[$i]['LN_SIZE'] = $separacion_linea;			  
					
				  $pdf->tbDrawData($data);	  
				  
				}//3 while				
	   }
   else
	   {
				$data = Array();
				$data[0]['TEXT'] = 'Sin Resultados...';
				$data[0]['COLSPAN'] = 19;
				$data[0]['T_ALIGN'] = "L";
				
				$pdf->tbDrawData($data);
	   }
	   
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();	

	$pdf->Output();

?>