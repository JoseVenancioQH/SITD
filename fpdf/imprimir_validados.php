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
	$ano = $_GET["ano"];
	$evento = $_GET["evento"];
	
	$deportetext = $_GET["deportetext"];
	$municipiotext = $_GET["municipiotext"];	
	$modalidadtext = $_GET["modalidadtext"];
	$categoriatext = $_GET["categoriatext"];
	$ramatext = $_GET["ramatext"];
	$anotext = $_GET["anotext"];
	$eventotext = $_GET["eventotext"];
	
	$filtroreporte = 'Filtros: ';
	if(!empty($deportetext)) $filtroreporte .=  '['.$deportetext.']';
	if(!empty($municipiotext)) $filtroreporte .=  '['.$municipiotext.']';
	if(!empty($modalidadtext)) $filtroreporte .=  '['.$modalidadtext.']';
	if(!empty($categoriatext)) $filtroreporte .=  '['.$categoriatext.']';
	if(!empty($ramatext)) $filtroreporte .=  '['.$ramatext.']';
	if(!empty($anotext)) $filtroreporte .=  '['.$anotext.']';
	if(!empty($eventotext)) $filtroreporte .=  '['.$eventotext.']';	
	
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
	$pdf->nombrereporte = "Reporte Participantes Validados";
	$pdf->filtroreporte = $filtroreporte;
	$pdf->headfont = $tamano_fuente;
	$pdf->anchohoja = $tamano_hoja_mm;
	$pdf->separacion_linea = $separacion_linea;
	
	$pdf->Open();	
	
	$pdf->SetAutoPageBreak(true, 20);
    $pdf->SetMargins(2, ($separacion_linea*3)+12, 20);
	$pdf->AddPage();
	$pdf->AliasNbPages(); 

	$columns = 11; //five columns   
	
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
	
    $header_type2[0]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,2);//no 
	$header_type2[1]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,10);//curp 
	$header_type2[2]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,8);//nombres
	$header_type2[3]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,8);//appaterno	
	$header_type2[4]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,8);//apmaterno
	$header_type2[5]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,6);//modalidad
	$header_type2[6]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,6);//deporte
	$header_type2[7]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,12);//categoria
	$header_type2[8]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,19);//pruebas	
	$header_type2[9]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,16);//documentos
	$header_type2[10]['WIDTH'] = $funcionesgenerales->CPaN($tamano_hoja_mm,3);//validado	

	$header_type2[0]['TEXT'] = "No.";
	$header_type2[0]['T_ALIGN'] = "C";
	
	$header_type2[1]['TEXT'] = "CURP";
	$header_type2[1]['T_ALIGN'] = "L";
	
	$header_type2[2]['TEXT'] = "Nombres";
	$header_type2[2]['T_ALIGN'] = "L";
	
	$header_type2[3]['TEXT'] = "Paterno";	
	$header_type2[3]['T_ALIGN'] = "L";
	
    $header_type2[4]['TEXT'] = "Materno";	
	$header_type2[4]['T_ALIGN'] = "L";
	
	$header_type2[5]['TEXT'] = "Modalidad";	
	$header_type2[5]['T_ALIGN'] = "L";
	
	$header_type2[6]['TEXT'] = "Deporte";	
	$header_type2[6]['T_ALIGN'] = "L";
	
	$header_type2[7]['TEXT'] = "Categoria";	
	$header_type2[7]['T_ALIGN'] = "L";
	
	$header_type2[8]['TEXT'] = "Pruebas";	
	$header_type2[8]['T_ALIGN'] = "L";
	
	$header_type2[9]['TEXT'] = "Documentos";
	$header_type2[9]['T_ALIGN'] = "L";
	
	$header_type2[10]['TEXT'] = "Val.";
	$header_type2[10]['T_ALIGN'] = "C";
	
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
	if(empty($ano)) $filtroano = ''; else $filtroano = " and (year(reg_participante_fechanac) BETWEEN ".$ano." AND ".$ano.")";	
	
	$filtro = $filtromunicipio.$filtroano.$filtromodalidad.$filtrodeporte.$filtrorama.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtrocategoria.$filtroevento;
	
	if(!empty($filtro)){
		 $filtro = substr($filtro,5,strlen($filtro));		
		 $filtro = ' WHERE '.$filtro;
	}
	
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
      cat_m.cat_modalidad_nombre as modalidad, 
      cat_d.cat_deporte_nombre as deporte,
      cat_c.cat_categoria_nombre as categoria,
      cat_c.cat_categoria_prueba as prueba,
	  reg_e.reg_eventoparticipante_documentos as documentos,
	  reg_c.reg_categoriaparticipante_validado as validado
	  from
	  ((((((reg_participante as reg_p 
			inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro)
			inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
			inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad)
			left join cat_municipio as cat_mu on cat_mu.id_municipio = reg_p.id_municipio)
			left join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria)
			left join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte)
			left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro");	
	$n=0;	
	$num_total_registros = $MySQL->num_rows($consulta);				
	if($num_total_registros>0)
		{			        
				while($arrayvalidados = $MySQL->fetch_array($consulta))
				{				    
				  extract($arrayvalidados);				  				  			  
				  			  
				  $n++;				  
				  $data = Array();
				  $data[0]['TEXT'] = $n;
				  $data[0]['T_SIZE'] = $fsize;
				  $data[0]['T_ALIGN'] = "C";
				  $data[0]['V_ALIGN'] = "T";				  
				  $data[0]['LN_SIZE'] = $separacion_linea;				  				  
				  
				  $data[1]['TEXT'] = $curp;
				  $data[1]['T_SIZE'] = $fsize;
				  $data[1]['T_ALIGN'] = "L";
				  $data[1]['V_ALIGN'] = "T";
				  $data[1]['LN_SIZE'] = $separacion_linea;				  				  
				  
				  $data[2]['TEXT'] = html_entity_decode($nombre);
				  $data[2]['T_SIZE'] = $fsize;
				  $data[2]['T_ALIGN'] = "L";
				  $data[2]['V_ALIGN'] = "T";
				  $data[2]['LN_SIZE'] = $separacion_linea;				  				  
				  
				  $data[3]['TEXT'] = html_entity_decode($appaterno);
				  $data[3]['T_SIZE'] = $fsize;
				  $data[3]['T_ALIGN'] = "L";
				  $data[3]['V_ALIGN'] = "T";
				  $data[3]['LN_SIZE'] = $separacion_linea;				  
				  
				  $data[4]['TEXT'] = html_entity_decode($apmaterno);
				  $data[4]['T_SIZE'] = $fsize;
				  $data[4]['T_ALIGN'] = "L";
				  $data[4]['V_ALIGN'] = "T";
				  $data[4]['LN_SIZE'] = $separacion_linea;
				  
				  $data[5]['TEXT'] = $modalidad;				  				  
				  $data[5]['T_SIZE'] = $fsize;
				  $data[5]['T_ALIGN'] = "L";
				  $data[5]['V_ALIGN'] = "T";
				  $data[5]['LN_SIZE'] = $separacion_linea;			  				  
				  
				  $data[6]['TEXT'] = $deporte;				  
				  $data[6]['T_SIZE'] = $fsize;
				  $data[6]['T_ALIGN'] = "L";
				  $data[6]['V_ALIGN'] = "T";
				  $data[6]['LN_SIZE'] = $separacion_linea;
				  
				  $data[7]['TEXT'] = html_entity_decode($categoria);				  
				  $data[7]['T_SIZE'] = $fsize;
				  $data[7]['T_ALIGN'] = "L";
				  $data[7]['V_ALIGN'] = "T";
				  $data[7]['LN_SIZE'] = $separacion_linea; 
				  
				  $data[8]['TEXT'] = html_entity_decode($prueba);				  
				  $data[8]['T_SIZE'] = $fsize;
				  $data[8]['T_ALIGN'] = "L";
				  $data[8]['V_ALIGN'] = "T";
				  $data[8]['LN_SIZE'] = $separacion_linea;
				  
				  $data[9]['TEXT'] = html_entity_decode($documentos);				  
				  $data[9]['T_SIZE'] = $fsize;
				  $data[9]['T_ALIGN'] = "L";
				  $data[9]['V_ALIGN'] = "T";
				  $data[9]['LN_SIZE'] = $separacion_linea;
				  
				  $data[10]['TEXT'] = $validado;				  
				  $data[10]['T_SIZE'] = $fsize;
				  $data[10]['T_ALIGN'] = "C";
				  $data[10]['V_ALIGN'] = "T";
				  $data[10]['LN_SIZE'] = $separacion_linea;
				  
				  if($n%2==0){
				  for ($j=0; $j<20; $j++)
					{
					   $data[$j]['BG_COLOR'] = array(250, 250, 250);
					}
				  }
				  				  
				  $pdf->tbDrawData($data);				  
				}				
	   }
   else
	   {
				$data = Array();
				$data[0]['TEXT'] = 'Sin Contratos...';
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