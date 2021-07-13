$(function($){$("#fechanacimiento").mask("d9-m9-wxs9");});
		
var contador = 0;
var cambioimg=false;
var ap = new Array();
var statususuario = 'desactivado';
var status = false;
var id_editar = 0;
var aplongitud = 0;
var lista_pruebas = '';						
var deportistas2008 = new Array();
var nombre = '';
var modalidad = '';
var deporte_registro = '';
var curp_foto_editar = '';
var tipo_foto = '';
var tabla_categoria_registro = '';
var lista_categorias_tabla_registro = '';
var participante_sel = '';
var ind_cat = 0;
var totalrow_categoria = 0;
var setinterval_foto = 0;
var idregistro = 0;

$().ready(function(){	
	var button = $('#upload_button');
	new AjaxUpload(button,{		
	action: '../scripts/upload.php', 
	name: 'userfile',
	onSubmit : function(file, ext){
		if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
		    
			/* Setting data */
			this.setData({'nombreparticipantes': $('#curp').val(),
						  'overwrite' : "si",
						  'action' : "image"});
			
			button.attr("src","../img/ajax-loader.gif");
		} else {				
			// cancel upload
			alert('solo imagenes');
			return false;				
		}		
	},
	onComplete: function(file, response){		
	    if(response != '1'){
		button.fadeOut(function(){			
			objImagePreloader.onload = function() {
				button
				.removeAttr('src')
				.attr('src',"../fotosparticipantes/"+response+"?nocache="+Math.random()*1000)
				.fadeIn();
				}
				objImagePreloader.src = "../fotosparticipantes/"+response+"?nocache="+Math.random()*1000;										
			});		
		}else
		{alert('No se cargo la imagen, excede el tama\u00F1o permitido, Redusca la imagen de tama\u00F1o, he intente de nuevo'); button.attr("src","../img/foto.png");}
	}
	});			   
	
	$("#list4").jqGrid({
			url:'../scripts/GeneraJson.php?tipo_consulta=0',
			datatype: "json",
			height: 255,			
			colNames:['CURP','Nombre', 'Paterno', 'Materno','Municipio','Sexo','Deporte','Modalidad','Nacimiento','Foto'],
			colModel:[{name:'curp',index:'curp', classes:'jqgrid uppercasecss bold' ,width:150}, 
					 {name:'nombre',index:'nombre', classes:'jqgrid uppercasecss bold', width:109}, 
					 {name:'paterno',index:'paterno', classes:'jqgrid uppercasecss bold', width:109}, 
					 {name:'materno',index:'materno', classes:'jqgrid uppercasecss bold', width:109}, 
					 {name:'municipio',index:'municipio', classes:'jqgrid', width:70}, 
					 {name:'sexo',index:'sexo', classes:'jqgrid', width:50},
					 {name:'deporte',index:'deporte', classes:'jqgrid', width:144},
					 {name:'modalidad',index:'modalidad', classes:'jqgrid', width:144},
					 {name:'nacimiento',index:'nacimiento', classes:'jqgrid', width:80},
					 {name:'foto',index:'foto', width:75, align:"center"}],
			rowNum:0,			
			//rowList:[5,10,15,20,25,30,35,40,100],
			mtype: "POST",
			pager: jQuery('#list4pager'),			
			sortname: 'curp',
			pgbuttons: false,
   	        pgtext: true,
   	        pginput:false,
			viewrecords: true,
			onSelectRow: function(id){cargar_participantes();}, 
			onSelectAll: function(){cargar_participantes();}, 
			loadComplete: function() { 
            var recs = jQuery("#list4").jqGrid('getGridParam','records');			
            if (recs == -1) {location.href="../index.php";}},
			//loadError:   function(xhr,st,err) { alert("Type: "+st+"; Response: "+ xhr.status +" "+xhr.statusText); },			
			sortorder: "asc",
			multiselect: true/*,
			subGrid : true, subGridUrl: '../scripts/GeneraJsonSubgrid.php', subGridModel: [{ name : ['Evento','Modalidad','Deporte','Categoria','Pruebas'], width : [100,100,100,180,200]}], 
			caption: "Selecciona Participante"*/
	});	
	
	$("#listcategoria").jqGrid({
			datatype: "local",
			height: 80,
			viewrecords: true,
			/*hiddengrid: true,*/
			/*hidegrid: true,*/
			colNames:['Modalidad','Deporte', 'Categoria', 'Pruebas','Borrar','Claves'],
			colModel:[{name:'modalidad',index:'modalidad', width:180}, 
					 {name:'deporte',index:'deporte', width:150}, 
					 {name:'categoria',index:'categoria', width:180}, 
					 {name:'prueba',index:'prueba', width:350},
			         {name:'borrar',index:'borrar', width:50, align:"center"},
					 {name:'claves',index:'claves', hidden:'false'}],
			caption: "Lista de Modalidad y Categorias"
	});
	
	$("#listregistro").jqGrid({
			url:'../scripts/GeneraJsonRegistro.php?tipo_consulta=0',
			datatype: "json",
			height: 350,					
			colNames:['Eliminar','Editar','CURP ','Nombres','Paterno','Materno','Municipio','Fecha','Sexo','Foto'],
			colModel:[{name:'borrar',index:'borrar', width:35, align:"center"},
					  {name:'editar',index:'editar', width:35, align:"center"},
					  {name:'curp',index:'curp', classes:'jqgrid uppercasecss bold',width:160}, 					  
					  {name:'nombre',index:'nombre', classes:'jqgrid uppercasecss bold', width:110}, 					  
					  {name:'paterno',index:'paterno', classes:'jqgrid uppercasecss bold', width:110},
					  {name:'materno',index:'materno', classes:'jqgrid uppercasecss bold', width:110},					 
					  {name:'municipio',index:'municipio', width:120}, 					 				 
					  {name:'fecha',index:'fecha', width:90},
					  {name:'sexo',index:'sexo', width:50},
					  {name:'foto',index:'foto', width:70, align:"center"}],
			rowNum:0,						
			mtype: "POST",
			pager: jQuery('#listregistropager'),			
			sortname: 'curp',
			pgbuttons: false,
   	        pgtext: true,
			loadComplete: function() {
				$('.edit_foto').hover(function(){
					$(this).attr('src','../img/editar_img_sobre.jpg');
				}, function(){
					$(this).attr('src','../img/editar_img.jpg');
				});

			},			
   	        pginput:false,						
			viewrecords: true,
			subGrid : true, subGridUrl: '../scripts/GeneraJsonSubgridRegistro.php?evento='+$('#evento').val(), subGridModel: [{ name : ['Evento','Modalidad','Deporte','Categoria','Pruebas'], width : [100,100,100,180,200]}],			
			caption: "Lista de Participantes Registrados"
	});
	
	crearinterval_foto();		
	
	$(function(){					   
	    $('#dialog_renovar_participante').dialog({
			autoOpen: false,
			width: 1080,
			buttons: {				 
				"Salir": function() {				    
				   /* $.validationEngine.closePrompt(".formError", true);	*/				
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
	
	$("#renovar-participante").validationEngine({	
						   promptPosition: "topRight", 										   
						   inlineValidation: false,     
						   success : function(){RenovarParticipante();}, 
                           failure : function(){var sliderIntervalID = setInterval(function(){$.validationEngine.closePrompt(".formError", true);clearInterval(sliderIntervalID);},10000);}
	});
	
	$("#grabar-participante").validationEngine({	
	promptPosition: "topRight", 										   
	inlineValidation: false,     
    success : function() {if(!status){ 
	                       GrabarParticipante(); }else{
						   ActualizarParticipante();}
	}, 
    failure : function() {var sliderIntervalID = setInterval(function(){$.validationEngine.closePrompt(".formError", true);clearInterval(sliderIntervalID);},10000);} 
    });		
	
	$("#sinpruebas").click(function(){
		if($(this).is(":checked"))
		{
		   aplongitud = 0;
		   $('#pruebas_check :checkbox').each(function(i){
			  $(this).attr('checked', false).attr('disabled','disabled');		  
		   });
		}else{
		   $('#pruebas_check :checkbox').each(function(i){
			  $(this).removeAttr('disabled');	
			  var pruebas_text = jQuery.trim($('#pruebas'+$('#selectcategoria').val()).html());			  		 
			  if(pruebas_text != ''){
				ap = pruebas_text.split(',');		  
				aplongitud = ap.length;
			  }
		   });	
		}
	});	
	
	$('#curp').focus(function(){
	 if($("#curpautomatico").is(":checked")){						  
	  cargarcurp(); $('#rfc').val($('#curp').val().substr(0,10));
	 }
	});
	
	$('#curp').change(function(){	
	 /*if($("#curpautomatico").is(":checked")){*/						   
	  nombre = $('#curp').val();						   
	  $('#rfc').val($('#curp').val().substr(0,10));
	 /*}*/
	});
	
	$('#buscar_curp').click(function(){
	 if($("#curpautomatico").is(":checked")){								 
       curpbusca();
	 }
	});	
	
	
	$('#deportes').change(function(){				
		$.ajax({
		 type: "POST",
		 url: "../scripts/GeneraCategoria.php",
		 processData: false,
		 dataType: "html",
		 data:"deporte="+$(this).val()+"&evento="+$('#evento').val(),
		 beforeSend: function(){JSBlockUI('Generando Categorias...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') {error();} else despliegapruebas(data);}},
		 timeout: 80000
	    });			  
	});
	
	$('#modalidad').change(function(){	
									
		$('#deportes').val('');	
		$('#categoria').html('<p><label for="categoria">Categoria: </label><select name="selectcategoria" id="selectcategoria" class="span-12 cselect" disabled="disabled">   <option value="" selected>Ninguno</option></select></p>');			
		$('#pruebas').html('');	
		$('#lista_categorias').html('');							
									
		modalidad = $("#modalidad option[value="+$("#modalidad").val()+"]").text().toUpperCase();		
		
		//delegado
		if(modalidad == 'DELEGADO' || modalidad == 'DELEGADO GENERAL')
		{			   
		   $('#div_deportes_extras').css('display','none');
		   $('#fieldsetcategoria').css('display','none');		   
		   $("#div_cargo").css('display','none');		   
		   $("#div_prensa").css('display','none');		   
		   $("#deportes_extras").removeClass("validate[required] span-7 cselect").val('');
		   $("#cargo").removeClass("validate[required] span-7 text").val('');
		   $("#prensa").removeClass("validate[required] span-7 text").val('');
		   $("#cargo").val('');
		   $("#deportes_extras").val('');		   
		   $("#deportes").removeClass("validate[required] span-7 cselect").val('');
		   $("#selectcategoria").removeClass("validate[required] span-12 cselect").val('');		
		   $('#pruebas').html('');
		   totalrow_categoria = 0;		   
		   $("#deportes option[value='"+$("#deportes :contains('Sin Especificar')").val()+"']").attr('selected','selected');
		   GeneraCategorias_Otros();	   
		}
		
		//deportista, entrenadores, auxiliares, delegado por deporte
		if(modalidad == 'DEPORTISTA' || modalidad == 'ENTRENADOR' || modalidad == 'AUXILIAR' || modalidad == 'DELEGADO POR DEPORTE' || modalidad == 'JUEZ')
		{			
		   $("#titulo_prueba").css('display','inline');
		   $("#selectcategoria").removeAttr('disabled');
		   $('#div_deportes_extras').css('display','none');		   	   
		   $("#div_cargo").css('display','none');
		   $("#div_prensa").css('display','none');		   
		   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
		   $("#cargo").removeClass("validate[required] span-7 text").val('');
		   $("#prensa").removeClass("validate[required] span-7 text").val('');
		   $("#deportes").addClass("validate[required] span-7 cselect").val('');
		   $("#selectcategoria").addClass("validate[required] span-12 cselect").val('');
		   $('#fieldsetcategoria').css('display','block');			   
		   $('#pruebas').html('');
		   
		   
		   if(modalidad == 'ENTRENADOR' || modalidad == 'AUXILIAR' || modalidad == 'DELEGADO POR DEPORTE' || modalidad == 'JUEZ')
		   {
			  $("#titulo_prueba").css('display','none'); 
			  $("#selectcategoria").addClass("validate[required] span-12 cselect");
			  $("#selectcategoria").attr('disabled', 'disabled');		  
		   }
		   
		   totalrow_categoria = $('#listcategoria').jqGrid('getGridParam','records');
		}
		
		//comite organizador
		if (modalidad=='COMIT\u00C9 ORGANIZADOR' || modalidad=='COMITE ORGANIZADOR' || modalidad=='COMIT&Eaute; ORGANIZADOR' || modalidad=='COMIT&EACUTE; ORGANIZADOR')
		{		   
		   $('#div_deportes_extras').css('display','none');
		   $('#fieldsetcategoria').css('display','none');			
		   $("#div_cargo").css('display','block').val('');
		   $("#div_prensa").css('display','none').val('');
		   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
		   $("#cargo").addClass("validate[required] span-7 text").val('');
		   $("#deportes").removeClass("validate[required] span-7 cselect").val('');
		   $("#prensa").removeClass("validate[required] span-7 cselect").val('');
		   $("#selectcategoria").removeClass("validate[required] span-12 cselect");
		   $('#pruebas').html('');
		   totalrow_categoria = 0;
		   $("#deportes option[value='"+$("#deportes :contains('Sin Especificar')").val()+"']").attr('selected','selected');
		   GeneraCategorias_Otros();
		}
		
		//prensa
		if (modalidad=='PRENSA')
		{		   
		   $('#div_deportes_extras').css('display','none');
		   $('#fieldsetcategoria').css('display','none');			
		   $("#div_cargo").css('display','none').val('');
		   $("#div_prensa").css('display','block').val('');
		   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
		   $("#prensa").addClass("validate[required] span-7 text").val('');
		   $("#cargo").removeClass("validate[required] span-7 text").val('');
		   $("#deportes").removeClass("validate[required] span-7 cselect").val('');
		   $("#selectcategoria").removeClass("validate[required] span-12 cselect").val('');
		   $('#pruebas').html('');
		   totalrow_categoria = 0;
		   $("#deportes option[value='"+$("#deportes :contains('Sin Especificar')").val()+"']").attr('selected','selected');
		   GeneraCategorias_Otros();
		}
		
	});
	
	$('#buscar_renovar').click(function(){										
       gridReload();
	});
	
	$('#buscar_registro').click(function(){										
       gridregistroReload();
	});	
});

//************************************************************************************
function eliminarparticipante(idregistro){
	$.ajax({
		 type: "POST",
		 url: "../scripts/EliminarParticipante.php",
		 processData: true,
		 dataType: "json",		 
		 data: "idregistro="+idregistro+"&evento="+$('#evento').val(),
		 beforeSend: function(){JSBlockUI('Eliminando Participante','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){participanteeliminado(data,idregistro);}},
		 timeout: 80000
	});
}

function participanteeliminado(data,idregistro)
{
	$.growl.settings.displayTimeout = 8000;
	$.growl('Eliminado','Operaci&oacute;n Realizada', '../img/button_'+data.status+'_25.png', 'high');
	var su=$("#listregistro").jqGrid('delRowData',idregistro);	
}

function LimpiarCamposForm()
{	
	limpiarcategoria();
	LimpiarDatosParticipante();
    limpiargenerales();
	LimpiarParticipante();
	if(status){CancelarActualizacion();}
}

function ActualizarParticipante_Submit()
{
	$('#grabar-participante').submit();
}

function ActualizarParticipante()
{
	var lista_modalidad_categorias = 'null';	
	if($('#municipio').val()=='') {$('#municipio').seekAttention();return false;}
	if(totalrow_categoria==0){							   
	   var pruebas = 'null';
	   var categoria =  $('#selectcategoria').val();	
	   var cargo_prensa = ($('#cargo').val() != '') ? $('#cargo').val() : 'null';
	   cargo_prensa = ($('#prensa').val() != '') ? $('#prensa').val() : cargo_prensa;
	   var modalidad = $('#modalidad').val();
	   var deporte = $('#deportes').val();
	   var arraylistapruebas = new Array();	   
	   
	   if(parseInt(aplongitud) > 0){
		$('#pruebas_check :checkbox').each(function(i){
			  if($(this).is(":checked"))
			   {
				arraylistapruebas.push(ap[i]);			  
			   }
		});		
		if(arraylistapruebas.length==0) {$('#pruebas_check').seekAttention();return false;} 
		pruebas = arraylistapruebas.join(',');		
	   }		
	  
	   var arraylistacategoria = new Array();		
	   arraylistacategoria.push(modalidad+'{x}'+deporte+'{x}'+categoria+'{x}'+pruebas+'{x}'+cargo_prensa);					
	   lista_modalidad_categorias = arraylistacategoria.join('{y}');  
	}else{							
	   var listacategoria= $("#listcategoria").jqGrid('getRowData');		
	   var arraylistacategoria = new Array();
	   for(var i=0;i<listacategoria.length;i++){			
		  arraylistacategoria.push(listacategoria[i].claves);			
	   }		
	   lista_modalidad_categorias = arraylistacategoria.join('{y}');					
	}	
	
	$.ajax({
		 type: "POST",
		 url: "../scripts/ActualizarParticipante.php",
		 processData: true,
		 dataType: "json",		 
		 data: "lista_modalidad_categorias="+lista_modalidad_categorias+"&idregistro="+idregistro+DatosComunes(),
		 beforeSend: function(){JSBlockUI('Actualizando Participante...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){desplegarstatuactualizado(data); LimpiarParticipante(); limpiargenerales();}},
		 timeout: 80000
	});
}

function CancelarActualizacion()
{
	$('#actualizar_participante_div').css('display','none');
	$('#cancelar_actualizar_div').css('display','none');  
	$('#grabar_participante_div').css('display','inline');  
	status = false;
	$('#selparticipante_div').css('display','inline');
	$('#cargardatosadicionales').css('display','inline');	
	LimpiarCamposForm();
}

function GrabarParticipante_submit()
{
	$('#grabar-participante').submit();										 
}

function editarparticipante(idregistro)
{	
		$.ajax({
		 type: "POST",
		 url: "../scripts/CargarDatosParticipante_Editar.php",
		 processData: true,
		 dataType: "json",		 
		 data: "idregistro="+idregistro+"&evento="+$('#evento').val(),
		 beforeSend: function(){JSBlockUI('Generando Datos...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){CargarDatosParticipante_Editar(data);}},
		 timeout: 80000
	    });		
	
}

function CargarDatosAdicionales(){
	var curp = $('#curp').val();	
	if(parseInt(curp.length) == 18){
		$.ajax({
		 type: "POST",
		 url: "../scripts/CargarDatosParticipante.php",
		 processData: true,
		 dataType: "json",		 
		 data: "curp="+curp,
		 beforeSend: function(){JSBlockUI('Generando Datos C.U.R.P...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){CargarDatosCurp(data);}},
		 timeout: 80000
	    });		
	}else{
		alert('Imposible Realizar Operacion, \n C.U.R.P. debe de ser de 18 caracteres');
	}	
}
 
function GeneraCategorias_Otros(){
	    $.ajax({
		 type: "POST",
		 url: "../scripts/GeneraCategoria.php",
		 processData: false,
		 dataType: "html",
		 data:"deporte="+$('#deportes').val()+"&evento="+$('#evento').val(),
		 beforeSend: function(){JSBlockUI('Generando Categorias...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') {error();} else {$('#categoria').html(data);$('#pruebas').html(''); $("#selectcategoria option[value='"+$("#selectcategoria :contains('Ninguna')").val()+"']").attr('selected','selected');}}},
		 timeout: 80000
	    });
}

function crearinterval_foto(){
   	setinterval_foto = setInterval(function() {					 
		  if(parseInt($('#curp').val().length) == 18)
		   {$('#div_upload_button').css('display','block');cambioimg=true;}
		  else
		   {$('#div_upload_button').css('display','none');if(cambioimg){$('#upload_button').attr("src","../img/foto.png");}
		   cambioimg=false;}}, 100);
}

function LimpiarCategorias(){
	$('#limpiarcategorias').css('display','none');
	$("#listcategoria").jqGrid('clearGridData');
	$('#listacategoria_div').css('display','none');	
	totalrow_categoria = $('#listcategoria').jqGrid('getGridParam','records');
	
	$("#modalidad").removeClass("span-7 cselect");
	$("#deportes").removeClass("span-7 cselect").val('');
	$("#selectcategoria").removeClass("span-12 cselect").val('');	
	
	$("#deportes").addClass("validate[required] span-7 cselect").val('');
    $("#selectcategoria").addClass("validate[required] span-12 cselect").val('').attr('disabled','disabled');;
    $("#modalidad").addClass("validate[required] span-7 cselect");	
	$('#pruebas').html('');	
}

function BorrarCategoria(ind){
	var su=$("#listcategoria").jqGrid('delRowData',ind);
	totalrow_categoria = $('#listcategoria').jqGrid('getGridParam','records');			
	if(totalrow_categoria==0){
		$('#limpiarcategorias').css('display','none');
	   	$('#listacategoria_div').css('display','none');	
		
		$("#modalidad").removeClass("span-7 cselect").val('');
		$("#deportes").removeClass("span-7 cselect").val('');
		$("#selectcategoria").removeClass("span-12 cselect").val('');	
		
		$("#deportes").addClass("validate[required] span-7 cselect").val('');
		$("#selectcategoria").addClass("validate[required] span-12 cselect").val('');
		$("#modalidad").addClass("validate[required] span-7 cselect").val('');
	}	
}

function AgregarCategoria(){   
	if($('#modalidad').val()==""){$('#modalidad').seekAttention();return false;}
	if($('#deportes').val()==""){$('#deportes').seekAttention();return false;}
	if($('#selectcategoria').val()==''){$('#selectcategoria').seekAttention();return false;}
	
	var modalidad_cat = $("#modalidad option[value="+$('#modalidad').val()+"]").text();
	var deportes_cat = $("#deportes option[value="+$('#deportes').val()+"]").text();
	var selectcategoria_cat = $("#selectcategoria option[value="+$('#selectcategoria').val()+"]").text();
	
	ind_cat++;	
	var pruebas = '';
	var pruebas_des = '';	
	if(modalidad=='DEPORTISTA'){
	//pruebas...................
	   var arraylistapruebas = new Array();	   	
	   if(parseInt(aplongitud) > 0){	  
		$('#pruebas_check :checkbox').each(function(i){
			  if($(this).is(":checked"))
			   {
				arraylistapruebas.push(ap[i]);			  
			   }
		});		
		if(arraylistapruebas.length==0) {$('#pruebas_check').seekAttention();return false;} 	  
		pruebas = arraylistapruebas.join(',');
		pruebas_des = pruebas; 	  	  
	   }else{pruebas='null'; pruebas_des='';}		 
	//fin pruebas................
	}
	$('#listacategoria_div').css('display','inline');
	
	if (modalidad=='DEPORTISTA'){  	  
	  var claves = $('#modalidad').val()+'{x}'+$('#deportes').val()+'{x}'+$('#selectcategoria').val()+'{x}'+pruebas+'{x}null';
	}else{	  		  
	  pruebas = '';
	  var claves = $('#modalidad').val()+'{x}'+$('#deportes').val()+'{x}'+$('#selectcategoria').val()+'{x}null{x}null';	
	}
	
	var datarow = {modalidad:modalidad_cat,deporte:deportes_cat,categoria:selectcategoria_cat,prueba: pruebas_des,borrar:'<img style="vertical-align:middle; cursor:pointer;" src="../img/icons/delete.png" onclick="javascript:BorrarCategoria('+ind_cat+');"/>',claves:claves};
	
	var su=$("#listcategoria").jqGrid('addRowData',ind_cat,datarow);
	totalrow_categoria = $('#listcategoria').jqGrid('getGridParam','records');	
	$('#limpiarcategorias').css('display','inline');			
}
function LimpiarParticipante(){
	$('#selpart').html('Seleccionar Participantes'); ActivarDatos(); $('#limpiarparticipante').css('display','none');
	$("#list4").jqGrid('resetSelection');
	crearinterval_foto();
}
function cargar_participantes(){	  
	participante_sel = $("#list4").jqGrid('getGridParam','selarrrow');
	if(participante_sel.length!=0){
	  $('#selpart').html('Participantes Seleccionados( '+participante_sel.length+' )'); DesactivarDatos(); $('#limpiarparticipante').css('display','inline');	  
	  clearInterval(setinterval_foto); 
	  $('#div_upload_button').css('display','none');
	}else{
	  $('#selpart').html('Seleccionar Participantes'); ActivarDatos(); $('#limpiarparticipante').css('display','none');      participante_sel = [];
	  crearinterval_foto();
	}
}

function gridReload(){ 
         var deporte = $("#deportes_buscar").val();
		 var municipio = $("#municipio").val();
		 var nombres = $("#nombres_buscar").val();
		 var appaterno = $("#appaterno_buscar").val();
		 var apmaterno = $("#apmaterno_buscar").val();
		 var rama = $("#sexo_buscar").val();
		 var modalidad = $("#modalidad_buscar").val();
		 var ano = $("#ano_buscar").val();				 
		 
		 if($('#municipio').val()=='') {$('#dialog_renovar_participante').dialog("close"); $('#municipio').seekAttention(); return false;}
		 
		 if(deporte+municipio+nombres+appaterno+apmaterno+modalidad+rama+ano!=''){
			$("#list4").jqGrid('setGridParam',{url:"../scripts/GeneraJson.php?deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&ano="+ano+"&modalidad="+modalidad+"&tipo_consulta=1",page:1}).trigger("reloadGrid");
		 }else{
			 alert('Especifique Filtro de Busqueda...');
		 }		 
}

function gridregistroReload(){ 
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
		 
		 if($('#municipio').val()=='') {$('#municipio').seekAttention(); return false;}
		 
		 if(deporte+categoria+municipio+nombres+appaterno+apmaterno+modalidad+rama+ano!=''){
			 $("#listregistro").jqGrid('setGridParam',{url:"../scripts/GeneraJsonRegistro.php?deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&ano="+ano+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&tipo_consulta=1",page:1}).trigger("reloadGrid");
		 }else{
			 alert('Especifique Filtro de Busqueda...');
		 }		 
}

function UltimosRegistrados(){          
		 var evento = $("#evento").val();
		 var municipio = $("#municipio").val();
		 $("#listregistro").jqGrid('setGridParam',{url:"../scripts/GeneraJsonUltimosRegistro.php?evento="+evento+"&municipio="+municipio,page:1}).trigger("reloadGrid");	  		 
}


function RenovarParticipante()
{    	
  $('#dialog_renovar_participante').dialog('open');								   
}

function GrabarParticipante()
{	    
    GrabarParticipante_Registro();
}

function DesactivarDatos()
{	
	 $("#nombres").removeClass("validate[required] span-4 text mayuscula");
     $("#appaterno").removeClass("validate[required] span-3 text mayuscula");
	 $("#apmaterno").removeClass("validate[required] span-3 text mayuscula");
	 $("#curp").removeClass("validate[required,length[18,18]] span-6 text mayuscula");
     $("#fechanacimiento").removeClass("validate[required,custom[date],length[0,10]] span-3 icon-fecha text");
	 $("#sexo").removeClass("validate[required] span-3 cselect");
     $("#entidad").removeClass("validate[required] span-6 cselect");
	 $("#direccion").removeClass("validate[required] span-4 text");
     $("#colonia").removeClass("validate[required] span-4 text");
	 $("#localidad").removeClass("validate[required] span-4 text");     
	 $("#telefonos").removeClass("validate[required] span-4 text");     
	 $("#peso").removeClass("validate[required] span-4 text");
	 $("#talla").removeClass("validate[required] span-4 text");
	 $("#rfc").removeClass("validate[required] span-4 text");	 
	 $(".divocultar").css('display','none');
	 clearInterval(setinterval_foto);
}

function ActivarDatos()
{
	 $("#nombres").addClass("validate[required] span-4 text mayuscula");
     $("#appaterno").addClass("validate[required] span-3 text mayuscula");
	 $("#apmaterno").addClass("validate[required] span-3 text mayuscula");
	 $("#curp").addClass("validate[required,length[18,18]] span-6 text mayuscula");
     $("#fechanacimiento").addClass("validate[required,custom[date],length[0,10]] span-3 icon-fecha text");
	 $("#sexo").addClass("validate[required] span-3 cselect");
     $("#entidad").addClass("validate[required] span-6 cselect");
	 $("#direccion").addClass("validate[required] span-4 text");
     $("#colonia").addClass("validate[required] span-4 text");
	 $("#localidad").addClass("validate[required] span-4 text");
	 $("#telefonos").addClass("validate[required] span-4 text");
	 $("#peso").addClass("validate[required] span-4 text");
	 $("#talla").addClass("validate[required] span-4 text");
	 $("#rfc").addClass("validate[required] span-4 text");
	 $(".divocultar").css('display','inline');	 
}

function DatosComunes()
   {	
       var idusuario = $('#idusuario').val();
	   var evento = $('#evento').val();
	   
	   var municipio = $('#municipio').val();
	   var modalidad = $('#modalidad').val();
	   var curp = $('#curp').val();
	   
	   var nombres = $('#nombres').val();
	   var appaterno = $('#appaterno').val();
	   var apmaterno = $('#apmaterno').val();
	   var fechanacimiento = $('#fechanacimiento').val();
	   var sexo = $('#sexo').val();
	   var entidad = $('#entidad').val();	   	   
	   var direccion = $('#direccion').val();
	   var colonia = $('#colonia').val();
	   var localidad = $('#localidad').val();
	   var codigopostal = $('#codigopostal').val();
	   var telefonos = $('#telefonos').val();
	   var correo = $('#correo').val();
	   var peso = $('#peso').val();
	   var talla = $('#talla').val();
	   var rfc = $('#rfc').val();
	   var tiposanguineo = $('#tiposanguineo').val();
	   
	   if(nombres=='') nombres = 'null';
	   if(appaterno=='') appaterno = 'null';
	   if(apmaterno=='') apmaterno = 'null';
	   if(fechanacimiento=='') fechanacimiento = 'null';
	   if(sexo=='') sexo = 'null';	
	   if(curp=='') curp = 'null';	
	   
	   if(entidad=='') entidad = 'null';
	   if(direccion=='') direccion = 'null';
	   if(colonia=='') colonia = 'null';
	   if(localidad=='') localidad = 'null';
	   if(codigopostal=='') codigopostal = 'null';
	   if(telefonos=='') telefonos = 'null';
	   if(correo=='') correo = 'null';
	   if(peso=='') peso = 'null';
	   if(talla=='') talla = 'null';
	   if(rfc=='') rfc = 'null';
	   if(tiposanguineo=='') tiposanguineo = 'null';
	   
	   return "&entidad="+entidad+"&evento="+evento+"&municipio="+municipio+"&modalidad="+modalidad+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&fechanacimiento="+fechanacimiento+"&sexo="+sexo+"&direccion="+direccion+"&telefonos="+telefonos+"&colonia="+colonia+"&localidad="+localidad+"&codigopostal="+codigopostal+"&correo="+correo+"&peso="+peso+"&talla="+talla+"&rfc="+rfc+"&curp="+curp+"&tiposanguineo="+tiposanguineo+"&idusuario="+idusuario;   
   }

function GrabarParticipante_Registro()
{
	var lista_modalidad_categorias = 'null';	
	if($('#municipio').val()==''){$('#municipio').seekAttention();return false;}
	if(totalrow_categoria==0){							   
	   var pruebas = 'null';
	   var categoria =  $('#selectcategoria').val();	
	   var cargo_prensa = ($('#cargo').val() != '') ? $('#cargo').val() : 'null';
	   cargo_prensa = ($('#prensa').val() != '') ? $('#prensa').val() : cargo_prensa;
	   var modalidad = $('#modalidad').val();
	   var deporte = $('#deportes').val();
	   var arraylistapruebas = new Array();	   
	   if(parseInt(aplongitud) > 0){
		$('#pruebas_check :checkbox').each(function(i){
			  if($(this).is(":checked"))
			   {
				arraylistapruebas.push(ap[i]);			  
			   }
		});		
		if(arraylistapruebas.length==0) {$('#pruebas_check').seekAttention();return false;} 
		pruebas = arraylistapruebas.join(',');		
	   }		
	  
	   var arraylistacategoria = new Array();		
	   arraylistacategoria.push(modalidad+'{x}'+deporte+'{x}'+categoria+'{x}'+pruebas+'{x}'+cargo_prensa);					
	   lista_modalidad_categorias = arraylistacategoria.join('{y}');  
	}else{							
	   var listacategoria= $("#listcategoria").jqGrid('getRowData');		
	   var arraylistacategoria = new Array();
	   for(var i=0;i<listacategoria.length;i++){			
		  arraylistacategoria.push(listacategoria[i].claves);			
	   }		
	   lista_modalidad_categorias = arraylistacategoria.join('{y}');					
	}		
	
	$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarParticipante.php",
		 processData: true,
		 dataType: "json",		 
		 data: "lista_modalidad_categorias="+lista_modalidad_categorias+"&participante_sel="+participante_sel+DatosComunes(),
		 beforeSend: function(){JSBlockUI('Grabando Deportista...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){ desplegarstaturegistro(data); LimpiarParticipante(); limpiargenerales();}},
		 timeout: 80000
	});		
}

function desplegarstatuactualizado(data)
{
	$.growl.settings.displayTimeout = 8000;
	$.growl('Actualizaci&oacute;n','Realizada','../img/button_'+data.actualizado+'_25.png', 'high');
	$('#actualizar_participante_div').css('display','none');
	$('#cancelar_actualizar_div').css('display','none');  
	$('#grabar_participante_div').css('display','inline');  
	status = false;
	$('#selparticipante_div').css('display','inline');
	$('#cargardatosadicionales').css('display','inline');	
	limpiarcategoria();
	LimpiarDatosParticipante();
    limpiargenerales();
	LimpiarParticipante();	
}

function desplegarstaturegistro(data)
{
	 $.growl.settings.displayTimeout = 8000;
	 $.growl('Participante','Insertados: '+data.participante_insertado+ '<br />Existente: '+data.participante_existente, '../img/button_ok_25.png', 'high');
	 
	 $.growl.settings.displayTimeout = 9000;
     $.growl('Evento','Insertados: '+data.eventos_insertado+ '<br />Existente: '+data.eventos_existente, '../img/button_ok_25.png', 'high');
	 
	 $.growl.settings.displayTimeout = 10000;
     $.growl('Modalidad','Insertados: '+data.modalidad_insertado+ '<br />Existente: '+data.modalidad_existente, '../img/button_ok_25.png', 'high');
	 
	 $.growl.settings.displayTimeout = 11000;
     $.growl('Categoria','Insertados: '+data.categoria_insertado+ '<br />Existente: '+data.categoria_existente, '../img/button_ok_25.png', 'high');
	 
	 //inicializar datos del participante de captura
	 LimpiarDatosParticipante();
	 limpiargenerales();
	 LimpiarParticipante();
	 
}

function desplegadoerrores(data)
 {
   if(data.multiple == 'no'){
     $.growl.settings.displayTimeout = 8000;
	 $.growl('Participante', data.participante, '../img/button_'+data.logoparticipante+'_25.png', 'high');
	 $.growl.settings.displayTimeout = 9000;
     $.growl('Evento', data.eventos, '../img/button_'+data.logoeventos+'_25.png', 'high');
	 $.growl.settings.displayTimeout = 10000;
     $.growl('Modalidad', data.modalidad, '../img/button_'+data.logomodalidad+'_25.png', 'high');	 
	 	 
	 if(data.categoria!='null')
	   {
		 var arraycat = Array();
		 var arraylogo = Array();
		 var categoria_error = '';
		 var rel = 0;
		 
		 arraycat = data.categoria.split(',');
		 arraylogo = data.logocategoria.split(',');		  
		 
		 $.each(arraycat,function(i,datacat){			
			$.growl.settings.displayTimeout = 11000+rel;					    
			$.growl('Categoria', datacat, '../img/button_'+arraylogo[i]+'_25.png', 'high');   		            rel = rel + 1000;					   
		 });
		 deporte_registro=$("#deportes option[value="+$('#deportes').val()+"]").text();
	   }
	 else
	   {	
	     var modalidad_registro = $("#modalidad option[value="+$('#modalidad').val()+"]").text().toUpperCase();		
	     if (modalidad_registro=='COMIT\u00C9 ORGANIZADOR' || modalidad_registro=='COMITE ORGANIZADOR' || modalidad_registro=='COMIT&Eaute; ORGANIZADOR' || modalidad_registro=='COMIT&EACUTE; ORGANIZADOR')
		 {		 
		 deporte_registro='';
		 tabla_categoria_registro=$('#cargo').val();
		 }
		else
		 {
		   if(modalidad_registro=='DELEGADO')
			{		    
			  deporte_registro='';
			  tabla_categoria_registro='';		   
			}
			else
			{
			  deporte_registro=$("#deportes_extras option[value="+$('#deportes_extras').val()+"]").text();
			  tabla_categoria_registro='';			 
			}
		 }
	   }	   
   }else{
	   
	 $.growl.settings.displayTimeout = 6000;
	 $.growl('Participante', data.participante, '../img/button_'+data.logoparticipante+'_25.png', 'high');
	 $.growl.settings.displayTimeout = 7000;
     $.growl('Evento', data.eventos, '../img/button_'+data.logoeventos+'_25.png', 'high');
	 $.growl.settings.displayTimeout = 9000;
     $.growl('Modalidad', data.modalidad, '../img/button_'+data.logomodalidad+'_25.png', 'high');
	 $.growl.settings.displayTimeout = 10000;
     $.growl('Categoria', data.categoria, '../img/button_'+data.logocategoria+'_25.png', 'high');	   
   }	   
}

function despliegapruebas_registro(data)
{
	$('#categoria_registro').html(data);
	$("#selectcategoria_registro option[value='"+$("#selectcategoria_registro :contains('General')").val()+"']").remove();  			
}
	
function despliegapruebas(data)
{
	$('#categoria').html(data);		
	$('#pruebas').html('');		
	  $('#selectcategoria').change(function(){    		
	   $('#sinpruebas').attr('checked', false);										
	   if($('#selectcategoria').val() != '' && modalidad == 'DEPORTISTA'){								  
		var pruebas_text = jQuery.trim($('#pruebas'+$('#selectcategoria').val()).html());
		var lista_pruebas = '';		 
		if(pruebas_text != ''){
		  ap = pruebas_text.split(',');		  
		  aplongitud = ap.length;
		  var cont = 0;
		  $.each(ap,function(iap,dataap){	   					 
			if(cont == 0)
			{lista_pruebas += '<tr><td><table class="nospace"><tr>'
						   +'<td  width="10px"><input type="checkbox">'
						   +'</td><td>'+dataap+'</td></tr></table></td>';}      
			else{lista_pruebas += '<td><table class="nospace"><tr>'+
								  '<td width="10px"><input type="checkbox">'
								  +'</td><td>'+dataap+'</td></tr></table></td>';}
			cont++; 
			if(cont == 5 || aplongitud == iap+1) {lista_pruebas += '</tr>'; cont = 0;}		    
		  });
		  $('#pruebas').html('<table id = "pruebas_check"  class="nospace">'+lista_pruebas+'</table>');	  
		}else{aplongitud = 0;}	  
	   }else{$('#pruebas').html(''); aplongitud = 0;}
	  });	
}

function CargarDatosCurp(data){
   if(data.items != 'no'){
	 $.each(data.items, function(i,item){		 
		$('#nombres').val(item.nombre);
		$('#appaterno').val(item.appaterno);
		$('#apmaterno').val(item.apmaterno);
		$('#fechanacimiento').val(item.fechanac);
		$('#sexo').val(item.sexo);
		$('#entidad').val(item.entidad);	   	   
		$('#direccion').val(item.direccion);
		$('#colonia').val(item.colonia);
		$('#localidad').val(item.localidad);
		$('#codigopostal').val(item.codigop);
		$('#telefonos').val(item.telefonos);
		$('#correo').val(item.correo);
		$('#peso').val(item.peso);
		$('#talla').val(item.talla);
		$('#rfc').val(item.rfc);
		$('#tiposanguineo').val(item.tiposanguineo);	  
		$('#div_upload_button').html(item.foto);		
	});
  }else{
	$('#nombres').val('');
		$('#appaterno').val('');
		$('#apmaterno').val('');
		$('#fechanacimiento').val('');
		$('#sexo').val('');
		$('#entidad').val('');	   	   
		$('#direccion').val('');
		$('#colonia').val('');
		$('#localidad').val('');
		$('#codigopostal').val('');
		$('#telefonos').val('');
		$('#correo').val('');
		$('#peso').val('');
		$('#talla').val('');
		$('#rfc').val('');
		$('#tiposanguineo').val('');  
  }
}


function GenerarLista_Categoria()
    {		
	     var deportes_lista = $('#deportes_lista').val();		
		 var evento_lista = $('#evento_lista').val();
		 var idusuario = $('#idusuario').val();		 
			 
		 $.ajax({
		 type: "POST",
		 url: "../scripts/GenerarLista_Categorias.php",
		 processData: false,
		 dataType: "html",		 		 		 
		 data:"evento_lista="+evento_lista+"&deportes_lista="+deportes_lista+"&idusuario="+idusuario+"&statususuario="+statususuario,
		 beforeSend: function(){JSBlockUI('Actualizando Lista...','80000')},
		 success: function(data){if(unJSBlockUI(data)) GenerarLista(data);}		 
	    });
		
		
	}
	
function GenerarLista(datos)
    {
		$('#lista_categorias').html(datos);
		colorceldas();
		statususuario='desactivado';
	}	
	
function borrar(id)
	{
		$('#'+id).remove();
		$('#listapruebas').val('');		
		$('#lista_pruebas li').each(function(){
        $('#listapruebas').val($('#listapruebas').val() + $(this).text() + ',');		
        });  		
	}
function borradototal()
	{
		$('#lista_pruebas').empty();
		$('#listapruebas').val('');			
		status = false;
		colorceldas();
		
	}	

function LimpiarDatosParticipante()
	{
		$('#nombres').val('');	
		$('#appaterno').val('');	
		$('#apmaterno').val('');	
		$('#fechanacimiento').val('');	
		$('#entidad').val('BS');
		$('#sexo').val('');
		$('#curp').val('');		
		$('#nombres').focus();
	}	

function limpiarregistro()
	{		
		$('#cargo').val('');
		$('#prensa').val('');
	
	}	

function limpiarcategoria()
	{
		$('#deportes').val('');	
		$('#categoria').html('<p><label for="categoria">Categoria: </label><select name="selectcategoria" id="selectcategoria" class="span-12 cselect" disabled="disabled">   <option value="" selected>Ninguno</option></select></p>');			
		$('#pruebas').html('');	
		$('#lista_categorias').html('');
		LimpiarCategorias();
	}	

function limpiargenerales()
	{
		$('#direccion').val('');	
		$('#colonia').val('');	
		$('#localidad').val('');	
		$('#codigopostal').val('');	
		$('#telefonos').val('');	
		$('#correo').val('');	
		$('#peso').val('');	
		$('#talla').val('');	
		$('#rfc').val('');	
		$('#tiposanguineo').val('');			
	}	

function CargarDatosParticipante_Editar(data)
{	
     var contmodcat = 0;	
	 $.each(data.items, function(i,item){
		idregistro = item.idregistro;						 
		$('#nombres').val(acentos(item.nombre));
		$('#curp').val(item.curp);
		$('#appaterno').val(acentos(item.appaterno));
		$('#apmaterno').val(acentos(item.apmaterno));
		$('#fechanacimiento').val(item.fechanac);
		$('#sexo').val(item.sexo);
		$('#entidad').val(item.entidad);	   	   
		$('#direccion').val(item.direccion);
		$('#colonia').val(item.colonia);
		$('#localidad').val(item.localidad);
		$('#codigopostal').val(item.codigop);
		$('#telefonos').val(item.telefonos);
		$('#correo').val(item.correo);
		$('#peso').val(item.peso);
		$('#talla').val(item.talla);
		$('#rfc').val(item.rfc);
		$('#tiposanguineo').val(item.tiposanguineo);	  
		$('#div_upload_button').html(item.foto);		
				   
		$("#listcategoria").jqGrid('clearGridData');		
		$.each(item.modalidadcategoria, function(i,itemmc){											 
			var modalidad_edit = itemmc.modalidad.toUpperCase();		
			if(modalidad_edit == 'DEPORTISTA' || modalidad_edit == 'ENTRENADOR' || modalidad_edit == 'AUXILIAR' || modalidad_edit == 'DELEGADO POR DEPORTE' || modalidad_edit == 'JUEZ')
			{		 
			  if (modalidad_edit=='DEPORTISTA'){			    
				var claves = itemmc.idmodalidad+'{x}'+itemmc.iddeporte+'{x}'+itemmc.idcategoria+'{x}'+itemmc.pruebas+'{x}null';				
			  }else{	  					
				var claves = itemmc.idmodalidad+'{x}'+itemmc.iddeporte+'{x}'+itemmc.idcategoria+'{x}null{x}null';	
			  } 			  			  
			  var datarow = {modalidad:itemmc.modalidad,deporte:itemmc.deporte,categoria:itemmc.categoria,prueba: itemmc.pruebas,borrar:'<img style="vertical-align:middle; cursor:pointer;" src="../img/icons/delete.png" onclick="javascript:BorrarCategoria('+itemmc.id_categoriapar+');"/>',claves:claves};
			  
			  $("#titulo_prueba").css('display','inline');
			  $("#selectcategoria").removeAttr('disabled');
			  $('#div_deportes_extras').css('display','none');		   	   
			  $("#div_cargo").css('display','none');
			  $("#div_prensa").css('display','none');		   
			  $("#deportes_extras").removeClass("validate[required] span-7 cselect");
			  $("#cargo").removeClass("validate[required] span-7 text").val('');
			  $("#prensa").removeClass("validate[required] span-7 text").val('');
			  
			  $("#deportes").removeClass("validate[required] span-7 cselect").val('');
		      $("#selectcategoria").removeClass("validate[required] span-12 cselect").val('');
			  $("#modalidad").removeClass("validate[required] span-7 cselect").val('');
			  
			  $("#modalidad").addClass("span-7 cselect").val('');
			  $("#deportes").addClass("span-7 cselect").val('');
			  $("#selectcategoria").addClass("span-12 cselect").val('');
			  
			  /*
			  $("#modalidad").removeClass("validate[required] span-7 cselect").val('');
			  $("#deportes").addClass("validate[required] span-7 cselect").val('');
			  $("#selectcategoria").addClass("validate[required] span-12 cselect").val('');
			  */
			  
			  $('#fieldsetcategoria').css('display','block');			   
			  $('#pruebas').html('');
			  
			if(modalidad_edit == 'ENTRENADOR' || modalidad_edit == 'AUXILIAR' || modalidad_edit == 'DELEGADO POR DEPORTE' || modalidad_edit == 'JUEZ')
			  {
				  $("#titulo_prueba").css('display','none'); 
				  $("#selectcategoria").addClass("validate[required] span-12 cselect");
				  $("#selectcategoria").attr('disabled', 'disabled');		  
			  }
			  
			  $('#lista_categorias').html('');					  
			  $('#listacategoria_div').css('display','inline');
			  $('#deportes').val('');					  
			  
			 
			  var su=$("#listcategoria").jqGrid('addRowData',itemmc.id_categoriapar,datarow);
			  totalrow_categoria = $('#listcategoria').jqGrid('getGridParam','records');	
			  $('#limpiarcategorias').css('display','inline'); 					
			} 
			
			if (modalidad_edit=='COMIT\u00C9 ORGANIZADOR' || modalidad_edit=='COMITE ORGANIZADOR' || modalidad_edit=='COMIT&Eaute; ORGANIZADOR' || modalidad_edit=='COMIT&EACUTE; ORGANIZADOR')
			{		   
			   $('#div_deportes_extras').css('display','none');
			   $('#fieldsetcategoria').css('display','none');			
			   $("#div_cargo").css('display','block').val('');
			   $("#div_prensa").css('display','none').val('');
			   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
			   $("#cargo").addClass("validate[required] span-7 text").val('');
			   $("#deportes").removeClass("validate[required] span-7 cselect").val('');
			   $("#prensa").removeClass("validate[required] span-7 cselect").val('');
			   $("#selectcategoria").removeClass("validate[required] span-12 cselect");
			   $('#pruebas').html('');
			   totalrow_categoria = 0;
			   $("#deportes option[value='"+$("#deportes :contains('Sin Especificar')").val()+"']").attr('selected','selected');
			   GeneraCategorias_Otros();
			}	
			//prensa
			if (modalidad_edit=='PRENSA')
			{		   
			   $('#div_deportes_extras').css('display','none');
			   $('#fieldsetcategoria').css('display','none');			
			   $("#div_cargo").css('display','none').val('');
			   $("#div_prensa").css('display','block').val('');
			   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
			   $("#prensa").addClass("validate[required] span-7 text").val('');
			   $("#cargo").removeClass("validate[required] span-7 text").val('');
			   $("#deportes").removeClass("validate[required] span-7 cselect").val('');
			   $("#selectcategoria").removeClass("validate[required] span-12 cselect").val('');
			   $('#pruebas').html('');
			   totalrow_categoria = 0;
			   $("#deportes option[value='"+$("#deportes :contains('Sin Especificar')").val()+"']").attr('selected','selected');
			   GeneraCategorias_Otros();
			}
			//delegado
			if(modalidad_edit == 'DELEGADO' || modalidad_edit == 'DELEGADO GENERAL')
			{			   
			   $('#div_deportes_extras').css('display','none');
			   $('#fieldsetcategoria').css('display','none');		   
			   $("#div_cargo").css('display','none');		   
			   $("#div_prensa").css('display','none');		   
			   $("#deportes_extras").removeClass("validate[required] span-7 cselect").val('');
			   $("#cargo").removeClass("validate[required] span-7 text").val('');
			   $("#prensa").removeClass("validate[required] span-7 text").val('');
			   $("#cargo").val('');
			   $("#deportes_extras").val('');		   
			   $("#deportes").removeClass("validate[required] span-7 cselect").val('');
			   $("#selectcategoria").removeClass("validate[required] span-12 cselect").val('');		
			   $('#pruebas').html('');
			   totalrow_categoria = 0;		   
			   $("#deportes option[value='"+$("#deportes :contains('Sin Especificar')").val()+"']").attr('selected','selected');
			   GeneraCategorias_Otros();	   
			}			
		});		
	});
	 
	$('#actualizar_participante_div').css('display','inline');
	$('#cancelar_actualizar_div').css('display','inline');
	$('#grabar_participante_div').css('display','none');
	$('#selparticipante_div').css('display','none');	
	$('#cargardatosadicionales').css('display','none');		
	status = true;
}

function error()
	{
		$.growlUI('No se realizo el registro','Registro Duplicado...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
	}		

function colorceldas(id)
    {
		$("#"+id+" tr:even").css("background-color", "#CCCCCC");
	    $("#"+id+" tr:odd").css("background-color", "#EFF1F1");
	}
/*---------------------inicio eliminacion de categoria-------------------------*/
function eliminarcategoria(id)
    {		
	    $('#'+id).remove();
	    $.growlUI('Se ha eliminado la categoria','Eliminaci&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");		
		colorceldas();
		
	}	
/*---------------------fin eliminacion de categoria-------------------------*/	

/*---------------------inicio actualizacion de categoria-------------------------*/	
function ActualizarCategoria()
    {			
		var idusuario = $('#idusuario').val();
		var evento = $('#evento').val();
		var iddeporte = $('#deportes').val();
		var nombrecat = $('#nombrecategoria').val();
		var anoinicio = $('#anoinicio').val();
		var anofin = $('#anofin').val();
		var listapruebas = $('#listapruebas').val();
		var rama = $('#rama').val();
		var listapruebas = $('#listapruebas').val();
		
		
		var evento_text = $("#evento option[value="+$('#evento').val()+"]").text();
		var deporte_text = $("#deportes option[value="+$('#deportes').val()+"]").text();
		
		$.ajax({
		 type: "POST",
		 url: "../scripts/EditarCategoria.php",
		 processData: false,
		 dataType: "html",		 
		 data:"evento="+evento+"&iddeporte="+iddeporte+"&nombrecat="+nombrecat+"&anoinicio="+anoinicio+"&anofin="+anofin+"&listapruebas="+listapruebas+"&rama="+rama+"&evento_text="+evento_text+"&deporte_text="+deporte_text+"&idusuario="+idusuario+"&id="+id_editar,
		 beforeSend: function(){JSBlockUI('Editando Categoria','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') erroreditar(); else categoriaeditado(id_editar,evento_text,deporte_text,rama,nombrecat,anoinicio,anofin,listapruebas);}},
		 timeout: 80000
	    });	
	}
	
function editarcategoria(id)
    { 	
	    colorceldas();
		status=true;
		id_editar=id;
				
		$('#evento').val($('#'+id_editar).children('td').eq(0).html());
		$('#deportes').val($('#'+id_editar).children('td').eq(1).html());
		$('#rama').val($('#'+id_editar).children('td').eq(2).html());
		$('#nombrecategoria').val($('#'+id_editar).children('td').eq(3).html());
		$('#anoinicio').val($('#'+id_editar).children('td').eq(4).html());
		$('#anofin').val($('#'+id_editar).children('td').eq(5).html());
		
		var lista_pruebas = $('#'+id_editar).children('td').eq(6).html();		
		var pruebas = '';
		var pruebas_html = '';
		ap = lista_pruebas.split(', ');		
		$.each(ap,function(iap,dataap){
		pruebas += dataap+',';				   
		pruebas_html += '<li id =\''+iap+'\' style="margin-left: 10px; margin-top: 10px; float:left; width:20%; height:auto; border-bottom:1px solid #CCCCCC;"><img style=\"vertical-align:middle; cursor:pointer;\" src="../img/icons/delete.png" onclick="javascript:borrar(\''+iap+'\');"/>'+dataap+'</li>';			
		});
		
		$('#listapruebas').val(pruebas);
		$("#lista_pruebas").html(pruebas_html);		
		
		$('#'+id).css("background","#FFFF33");		
		$('#grabar_categoris_buttom').val('Editar Categoria');
		$('#nombre-text').focus();
		
	}	
function erroreditar()
    {
		$.growlUI('No se realizo la edici&oacute;n','Ninguna afectaci&oacute;n a los datos...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
		status = false;
		colorceldas();
		$('#grabar_deportes_buttom').val('Grabar Categoria');		
		$('#nombre-text').focus();
	}
	
function categoriaeditado(id_editar,evento_text,deporte_text,rama,nombrecat,anoinicio,anofin,listapruebas)
    {	
		$.growlUI('Se ha realizado la edici&oacute;n','Edici&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		
		var pruebas = '';		
		listapruebas = listapruebas.substring(0,listapruebas.length-1);		
		ap = listapruebas.split(',');		
		$.each(ap,function(iap,dataap){
		pruebas += dataap+', ';				
		});
		
		pruebas = pruebas.substring(0,pruebas.length-2);		
		
		$('#'+id_editar).children('td').eq(0).html(evento_text);
		$('#'+id_editar).children('td').eq(1).html(deporte_text);
		$('#'+id_editar).children('td').eq(2).html(rama);
		$('#'+id_editar).children('td').eq(3).html(nombrecat);
		$('#'+id_editar).children('td').eq(4).html(anoinicio);
		$('#'+id_editar).children('td').eq(5).html(anofin);
		$('#'+id_editar).children('td').eq(6).html(pruebas);
		
		
		status = false;
		colorceldas();
		$('#grabar_categoris_buttom').val('Grabar Categoria');		
		$('#nombre-text').focus();
	}	
/*---------------------fin actualizacion de categoria-------------------------*/		
