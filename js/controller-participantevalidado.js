var idregcat = '';
var documentos_actualizar = '';	
var count_arraydocumentos = 0;
var participante_sel = new Array();

$().ready(function(){
	
	$(function(){					   
	    $('#dialog_validar_participante').dialog({
			autoOpen: false,
			width: 300,
			buttons: {
				"Grabar": function() {					 					 					 
					 Grabar_Documentos();
				}, 
				"Salir": function() {				    				   
					$(this).dialog("close"); 					
					
				} 
			}
		});	
		
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
	
	$("#listvalidar").jqGrid({
			url:'../scripts/GeneraValidar.php?tipo_consulta=0',
			datatype: "json",
			height: 350,					
			colNames:['Nombres','Paterno','Materno','Modalidad','Deporte','Categoria','Prueba','Sexo','Docum.','Foto','Validado'],
			colModel:[{name:'nombre',index:'nombre', classes:'jqgrid uppercasecss bold', width:100}, 					  					                      {name:'paterno',index:'paterno', classes:'jqgrid uppercasecss bold', width:100},
					  {name:'materno',index:'materno', classes:'jqgrid uppercasecss bold', width:100},
					  {name:'modalidad',index:'modalidad', width:100},
					  {name:'deporte',index:'deporte', width:100},
					  {name:'categoria',index:'categoria', width:150},
					  {name:'prueba',index:'prueba', width:120},					  
				      {name:'sexo',index:'sexo', width:50},
					  {name:'docum',index:'docum', width:40},
					  {name:'foto',index:'foto', width:70},
					  {name:'validado',index:'validado', hidden:'false'}],					  
			rowNum:0,						
			mtype: "POST",
			pager: jQuery('#listvalidarpager'),			
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
				
				$('#listvalidar tbody tr').each(function(i){
				   var id =	$(this).attr('id');								 
				   if(id!=''){
					  var ret = jQuery("#listvalidar").jqGrid('getRowData',id);
					  if(ret.validado=='si'){
					  $('#'+$('#'+id+' input:checkbox').attr('id')).wrap('<span></span>').parent().css({background:"#069", border:"2px #069 solid"}); 	  
                      /*alert(ret.validado+' - '+$('#'+id+' input:checkbox').attr('id'));*/ 
					  }
				   }
		        });
				
				/*$.each(participante_sel,function(i,dato){
				if(dato!='' && dato!=undefined){			   
				   arrayparticipante_sel.push(dato.split('-')[1]);		   
				}*/                
			},
			onCellSelect: function(rowid,iCol,aData){
				/*alert($('#'+rowid+' input:checkbox').attr('id'));*/
				if(iCol!=0) {
					$("#listvalidar").jqGrid('setSelection',rowid);
				}	
			},
   	        pginput:false,						
			viewrecords: true,
			sortorder: "asc",
			multiselect: true,
			caption: "Lista Participantes a Validar"
	});
	
	$('#buscar_registro').click(function(){			   								 
       gridvalidarReload();
	});	
	
	$('#todas_documento').click(function(){
		if($(this).is(":checked")){
			$('#acta_documento').attr('checked', true);
            $('#constancia_documento').attr('checked', true);
	        $('#curp_documento').attr('checked', true);
	        $('#sired_documento').attr('checked', true);
	        $('#fotos_documento').attr('checked', true);
			$('#identificacion_documento').attr('checked', true);
		}else{
			$('#acta_documento').attr('checked', false);
            $('#constancia_documento').attr('checked', false);
	        $('#curp_documento').attr('checked', false);
	        $('#sired_documento').attr('checked', false);
	        $('#fotos_documento').attr('checked', false);
			$('#identificacion_documento').attr('checked', true);
		}										 
	});	
});

//...............................Funciones......................................................
function seleccionar_validar_participantes(){	  
	 participante_sel = $("#listvalidar").jqGrid('getGridParam','selarrrow'); 	 
	 /*if(participante_sel.length!=0){
	 $('#selpart').html('Participantes Seleccionados( '+participante_sel.length+' )'); DesactivarDatos(); $('#limpiarparticipante').css('display','inline');	  
	  clearInterval(setinterval_foto); 
	  $('#div_upload_button').css('display','none');
	}else{*/
	  /*$('#selpart').html('Seleccionar Participantes'); ActivarDatos(); $('#limpiarparticipante').css('display','none');      crearinterval_foto();
	  participante_sel = [];
	}*/
}


function ValidarParticipante(tipo_validar)
{	    
    if(participante_sel.length>0){	  
	  var arrayparticipante_sel = new Array();	  
	  $.each(participante_sel,function(i,dato){
		 if(dato!='' && dato!=undefined){			   
		   arrayparticipante_sel.push(dato.split('-')[1]);		   
		 }
	  });  
	  $.ajax({
		 type: "POST",
		 url: "../scripts/ValidarParticipante.php",
		 processData: true,
		 dataType: "json",		 
		 data: "participante_sel="+arrayparticipante_sel.join(',')+'&tipo_validar='+tipo_validar,
		 beforeSend: function(){JSBlockUI('Validando...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)) participantesvalidados(data,participante_sel,tipo_validar);},
		 timeout: 80000
	  });
	}else{
	  /*$('#selpart').html('Seleccionar Participantes'); ActivarDatos(); $('#limpiarparticipante').css('display','none');      crearinterval_foto();*/
	  participante_sel = [];
	}	
}


function Grabar_Documentos(){	
	var arraydocumentos = new Array();		
	if($('#acta_documento').is(":checked")) arraydocumentos.push('acta');
	if($('#curp_documento').is(":checked")) arraydocumentos.push('curp');
	if($('#sired_documento').is(":checked")) arraydocumentos.push('sired');
	if($('#constancia_documento').is(":checked")) arraydocumentos.push('constancia');
	if($('#fotos_documento').is(":checked")) arraydocumentos.push('fotos');		
	if($('#fotos_documento').is(":checked")) arraydocumentos.push('identificacion');		
		
	documentos_actualizar = arraydocumentos.join(',');	
	count_arraydocumentos = arraydocumentos.length;	
	
	$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarDocumentos.php",
		 processData: true,
		 dataType: "json",		 
		 data: "documentos="+documentos_actualizar+"&idregcat="+idregcat+"&evento="+$('#evento').val(),
		 beforeSend: function(){JSBlockUI('Grabando Documentos...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)) documentosgrabados(data);},
		 timeout: 80000
	});	
}

function gridvalidarReload(){ 
         var deporte = $("#deportes_registro").val();
		 var categoria = $("#selectcategoria_registro").val();		 
		 var municipio = $("#municipio").val();
		 var nombres = $("#nombres_registro").val();
		 var appaterno = $("#appaterno_registro").val();
		 var apmaterno = $("#apmaterno_registro").val();
		 var modalidad = $("#modalidad_registro").val();
		 var rama = $("#sexo_registro").val();
		 var ano = $("#ano_registro").val();
		 var evento = $("#evento").val();		 
		 
		 
		 
		 if(deporte+categoria+municipio+nombres+appaterno+apmaterno+modalidad+rama+ano!=''){
			 $("#listvalidar").jqGrid('setGridParam',{url:"../scripts/GeneraValidar.php?deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&ano="+ano+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&tipo_consulta=1",page:1}).trigger("reloadGrid");
		 }else{
			 alert('Especifique Filtro de Busqueda...');
		 }		 
}

function documentos(idregistrocategoria,documentos){
	idregcat = idregistrocategoria;
	var arraydocumentos = documentos.split(',');	
	$('#todas_documento').attr('checked', false);
	$('#acta_documento').attr('checked', false);
    $('#constancia_documento').attr('checked', false);
	$('#curp_documento').attr('checked', false);
	$('#sired_documento').attr('checked', false);
	$('#fotos_documento').attr('checked', false);
	$('#identifciacion_documento').attr('checked', false);
	$.each(arraydocumentos,function(iad,dataad){										   
		   if('acta' == dataad) $('#acta_documento').attr('checked', true);
		   if('constancia' == dataad) $('#constancia_documento').attr('checked', true);
		   if('curp' == dataad) $('#curp_documento').attr('checked', true);
		   if('sired' == dataad) $('#sired_documento').attr('checked', true);
		   if('fotos' == dataad) $('#fotos_documento').attr('checked', true);
		   if('identificacion' == dataad) $('#identificacion_documento').attr('checked', true);
	});	
	$('#dialog_validar_participante').dialog('open');								   	
}

function despliegapruebas_registro(data)
{	
	$('#categoria_registro').html(data);
	$("#selectcategoria_registro option[value='"+$("#selectcategoria_registro :contains('General')").val()+"']").remove();
}

function documentosgrabados (data){
	$.growl.settings.displayTimeout = 8000;
	$.growl('Actualizado', data.documento, '../img/button_ok_25.png', 'high');	
	
	if(count_arraydocumentos == 6){
		$("#listvalidar").jqGrid('setRowData',idregcat,{docum:"<img src='../img/documentos_todos.jpg' style='vertical-align:top; cursor:pointer;' onclick='javascript:documentos(\""+idregcat+"\",\""+documentos_actualizar+"\");' />"});		
	}
	else{
		$("#listvalidar").jqGrid('setRowData',idregcat,{docum:"<img style='vertical-align:top; cursor:pointer;' src='../img/documentos_"+count_arraydocumentos+".jpg' onclick='javascript:documentos(\""+idregcat+"\",\""+documentos_actualizar+"\");' />"});		
	}	
	$('#dialog_validar_participante').dialog("close");	
}

function participantesvalidados(data,arraypartsel,tipo_validar){
	$.growl.settings.displayTimeout = 8000;
	$.growl('Validado', data.validado, '../img/button_ok_25.png', 'high');	
	
	$.each(arraypartsel,function(i,dato){						 
		 if(dato!='' && dato!=undefined){			   		   		   		   
		   if(tipo_validar=='si'){	
		       var ret = jQuery("#listvalidar").jqGrid('getRowData',dato);			   
			   if(ret.validado!='si'){
				 $("#listvalidar").jqGrid('setRowData',dato,{validado:tipo_validar});
				 $('#'+$('#'+dato+' input:checkbox').attr('id'))
				 .wrap('<span></span>')
				 .parent()
				 .css({background:"#069", border:"2px #069 solid"}); 					 
			   }
		   }else{			         			   
			   var ret = jQuery("#listvalidar").jqGrid('getRowData',dato);			   
			   if(ret.validado!='no'){	 
			     $("#listvalidar").jqGrid('setRowData',dato,{validado:tipo_validar});
				 var html_validado = $('#'+$('#'+dato+' input:checkbox').attr('id')).parent().html();
				 $('#'+$('#'+dato+' input:checkbox').attr('id')).parent().parent().html(html_validado);				 
			   }				
		   }		   
		 }
	});	
	$("#listvalidar").jqGrid('resetSelection');	
	participante_sel = [];
}

function ImprimirValidar()
{	    
	 var deporte = $("#deportes_registro").val();
	 var categoria = $("#selectcategoria_registro").val();		 
	 var municipio = $("#municipio").val();
	 var nombres = $("#nombres_registro").val();
	 var appaterno = $("#appaterno_registro").val();
	 var apmaterno = $("#apmaterno_registro").val();
	 var modalidad = $("#modalidad_registro").val();
	 var rama = $("#sexo_registro").val();
	 var ano = $("#ano_registro").val();
	 var evento = $("#evento").val();
	
	 var deportetext = (deporte!='') ? $("#deportes_registro option[value="+deporte+"]").text() : '';
	 var categoriatext = (categoria!='') ? $("#selectcategoria_registro option[value="+categoria+"]").text() : '';
	 var municipiotext = (municipio!='') ? $("#municipio option[value="+municipio+"]").text() : '';
	 var modalidadtext = (modalidad!='') ? $("#modalidad_registro option[value="+modalidad+"]").text() : '';
	 var ramatext = (rama!='') ? $("#sexo_registro option[value="+rama+"]").text() : '';
	 var anotext = (ano!='') ? $("#ano_registro option[value="+ano+"]").text() : '';
	 var eventotext = (evento!='') ? $("#evento option[value="+evento+"]").text() : '';
	
	 var caracteristicas ="type=fullWindow,fullscreen, scrollTo, resizable=0, toolbar=0, menubar=0, personalbar=0, scrollbars=0, location=0";
	
      tamano_hoja='letter';orientacion_hoja = 'l'; tamano_hoja_mm = 279; tamano_fuente = 6; separacion_linea = 2.5;
	/*tamano_hoja='letter';orientacion_hoja = 'p'; tamano_hoja_mm = 216; tamano_fuente = 3.5; separacion_linea = 2; */ 	 
	
	 var variables_config_hoja = "&orientacion_hoja="+orientacion_hoja+"&tamano_hoja="+tamano_hoja+"&tamano_hoja_mm="+tamano_hoja_mm+"&tamano_fuente="+tamano_fuente+'&separacion_linea='+separacion_linea;	
	
	 var variables = "deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&ano="+ano+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento;
	 
	 var variables_text = "&deportetext="+deportetext+"&municipiotext="+municipiotext+"&ramatext="+ramatext+"&anotext="+anotext+"&modalidadtext="+modalidadtext+"&categoriatext="+categoriatext+"&eventotext="+eventotext;
	 
	 nueva=window.open("../fpdf/imprimir_validados.php?"+variables+variables_text+variables_config_hoja, 'Popup', caracteristicas); 
	 	
     return false;  
}


//.............................Fin Funciones.......................................................
