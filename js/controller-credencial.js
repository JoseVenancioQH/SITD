var idregcat = '';
var documentos_actualizar = '';	
var count_arraydocumentos = 0;
var participante_sel = new Array();

$().ready(function(){
	
	$(function(){					   	    
		$('#dialog_editar_imagen').dialog({
			autoOpen: false,
			width: 'auto',
			position:'center',
			buttons: {
				"Editar": function() {					 					 					 
					 editar_foto();
				}, 
				"Salir": function() {				    
				   /* $.validationEngine.closePrompt(".formError", true);	*/				
					$(this).dialog("close"); 
				} 
			}
		});	
	});		
	
	$("#deportes_credencial").addClass("cselect");	
	
	$("#listcredencial").jqGrid({
			url:'../scripts/GeneraCredencial.php?tipo_consulta=0',
			datatype: "json",
			height: 350,					
			colNames:['CURP','Nombres','Paterno','Materno','Fecha Nac.','Modalidad','Deporte','Sexo','Foto'],
			colModel:[{name:'CURP',index:'CURP', classes:'jqgrid uppercasecss bold', width:140},
					  {name:'nombre',index:'nombre', classes:'jqgrid uppercasecss bold', width:110}, 					  					                      {name:'paterno',index:'paterno', classes:'jqgrid uppercasecss bold', width:110},
					  {name:'materno',index:'materno', classes:'jqgrid uppercasecss bold', width:110},
					  {name:'fechanac',index:'fechanac', classes:'jqgrid uppercasecss bold', width:70},
					  {name:'modalidad',index:'modalidad', width:135},
					  {name:'deporte',index:'deporte', width:130},					  
				      {name:'sexo',index:'sexo', width:50},					  
					  {name:'foto',index:'foto', width:70}],					  
			rowNum:0,						
			mtype: "POST",
			pager: jQuery('#listcredencialpager'),			
			sortname: 'curp',
			pgbuttons: false,
   	        pgtext: true,			
			onSelectRow: function(id){seleccionar_validar_participantes();}, 
			onSelectAll: function(){seleccionar_validar_participantes();},
			loadComplete: function() {
				$('.edit_foto').hover(function(){
					$(this).attr('src','../img/editar_img_sobre.jpg');
				}, function(){
					$(this).attr('src','../img/editar_img.jpg');
				});											
			},			
   	        pginput:false,						
			viewrecords: true,
			sortorder: "asc",
			multiselect: true,
			caption: "Credencial Imprimir"
	});
	
	$('#buscar_registro').click(function(){			   								 
       gridcredencialReload();
	});	
});

//...............................Funciones......................................................
function gridcredencialReload(){ 
         var deporte = $("#deportes_credencial").val();		 
		 var municipio = $("#municipio").val();
		 var nombres = $("#nombres_registro").val();
		 var appaterno = $("#appaterno_registro").val();
		 var apmaterno = $("#apmaterno_registro").val();
		 var modalidad = $("#modalidad_registro").val();
		 var rama = $("#sexo_registro").val();
		 var ano = $("#ano_registro").val();
		 var evento = $("#evento").val();		 	 
		 
		 if(deporte+municipio+nombres+appaterno+apmaterno+modalidad+rama+ano!=''){
			 $("#listcredencial").jqGrid('setGridParam',{url:"../scripts/GeneraCredencial.php?deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&ano="+ano+"&modalidad="+modalidad+"&evento="+evento+"&tipo_consulta=1",page:1}).trigger("reloadGrid");
		 }else{
			 alert('Especifique Filtro de Busqueda...');
		 }		 
}

function ImprimirCredenciales()
{	    
	 var deporte = $("#deportes_credencial").val();		 
	 var municipio = $("#municipio").val();
	 var nombres = $("#nombres_registro").val();
	 var appaterno = $("#appaterno_registro").val();
	 var apmaterno = $("#apmaterno_registro").val();
	 var modalidad = $("#modalidad_registro").val();
	 var rama = $("#sexo_registro").val();
	 var ano = $("#ano_registro").val();
	 var evento = $("#evento").val();
	 var formatocredencial = ''; 
	 
	 var credencial_sel = $("#listcredencial").jqGrid('getGridParam','selarrrow');	
	 var deportetext = (deporte!='') ? $("#deportes_registro option[value="+deporte+"]").text() : '';	 
	 var municipiotext = (municipio!='') ? $("#municipio option[value="+municipio+"]").text() : '';
	 var modalidadtext = (modalidad!='') ? $("#modalidad_registro option[value="+modalidad+"]").text() : '';
	 var ramatext = (rama!='') ? $("#sexo_registro option[value="+rama+"]").text() : '';
	 var anotext = (ano!='') ? $("#ano_registro option[value="+ano+"]").text() : '';
	 var eventotext = (evento!='') ? $("#evento option[value="+evento+"]").text() : '';
	 
	 var deportetext_formatocredencial = (deporte!='') ? $("#deportes_credencial option[value="+deporte+"]").text() : '';
	 
	 
	 
	 if($('#formatoclub').is(":checked")){formatocredencial=deportetext_formatocredencial;}else{formatocredencial='';}
	
	 var caracteristicas ="type=fullWindow,fullscreen, scrollTo, resizable=0, toolbar=0, menubar=0, personalbar=0, scrollbars=0, location=0";
	
     /* tamano_hoja='letter';orientacion_hoja = 'l'; tamano_hoja_mm = 279; tamano_fuente = 6; separacion_linea = 2.5;*/
	tamano_hoja='letter';orientacion_hoja = 'p'; tamano_hoja_mm = 216; tamano_fuente = 6; separacion_linea = 2.5;  	 
	
	 var variables_config_hoja = "&orientacion_hoja="+orientacion_hoja+"&tamano_hoja="+tamano_hoja+"&tamano_hoja_mm="+tamano_hoja_mm+"&tamano_fuente="+tamano_fuente+'&separacion_linea='+separacion_linea;	
	
	 var variables = "deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&ano="+ano+"&modalidad="+modalidad+"&evento="+evento+"&credencial_sel="+credencial_sel+"&formatocredencial="+formatocredencial;
	 
	 var variables_text = "&deportetext="+deportetext+"&municipiotext="+municipiotext+"&ramatext="+ramatext+"&anotext="+anotext+"&modalidadtext="+modalidadtext+"&eventotext="+eventotext;
	 
	 nueva=window.open("../fpdf/imprimir_credenciales.php?"+variables+variables_text+variables_config_hoja, 'Popup', caracteristicas); 
	 	
     return false;  
}

function ImprimirGaffetes()
{	    
    var deporte = $("#deportes_registro").val();
    var categoria = $("#selectcategoria_registro").val();		 
    var municipio = $("#municipio").val();
    var nombres = $("#nombres_registro").val();
    var appaterno = $("#appaterno_registro").val();
    var apmaterno = $("#apmaterno_registro").val();
    var modalidad = $("#modalidad_registro").val();
    var rama = $("#sexo_registro").val();
    var evento = $("#evento").val();		 
    var anofin = $("#anofin").val();
    var anoinicio = $("#anoinicio").val();
    var convanoinicio = $("#convanoinicio").val();
    var validado = '';		 
	var ordenar = lista_ordenar.join(',');			
	
	if($('#solovalidados').is(":checked")){validado='si'}else{validado=''}
	
	var gaffete_sel = $("#listgaffetes").jqGrid('getGridParam','selarrrow');		
		
	var caracteristicas ="height=700, width=800, scrollTo, resizable=0, toolbar=1, menubar=1, personalbar=1, scrollbars=1, location=0";
	
	var variables = "deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&anoinicio="+anoinicio+"&anofin="+anofin+"&convanoinicio="+convanoinicio+"&validado="+validado+"&ordenar="+ordenar+"&gaffete_sel="+gaffete_sel;
	
    nueva=window.open("../modulos/imprimir-gaffetes.php?"+variables, 'Popup', caracteristicas);  	
    return false
}

//.............................Fin Funciones.......................................................
