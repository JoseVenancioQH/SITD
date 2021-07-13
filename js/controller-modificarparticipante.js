jQuery(function($){
   $("#fechanacimiento").mask("d9-m9-wxs9");   
});

jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
//************************************************************************************
var curp_upload = '';
var aplongitud = 0;
var lista_pruebas = '';						
var arrayp = new Array();
var deporte_registro = '';
var tabla_categoria_registro = '';
var lista_categorias_tabla_registro = '';
var idregistrocat_envio = '';
var id_registro = '';
var modalidad = '';
var idregmodalidad_envio = '';
var data_actual = {};
var data_data = {};
var data_new = {};
var idregmodalidad_global = '';
var idmodalidad_global = '';
var	modalidad_text_global = ''; 
var idmodalidad_change_global = '';
var new_modalidad_text_global = '';
var data_adicionales = new Object();
var data_generales = new Object();
var direccion_global = '';					
var colonia_global = '';					
var localidad_global = '';					
var codigopostal_global = '';					
var telefonos_global = '';					
var correo_global = '';					
var peso_global = '';					
var talla_global = '';					
var rfc_global = '';					
var tiposanguineo_global = '';					
var idparticipante_envio_adicional = '';

var ban_borrado = false;


var objImagePreloader = new Image();
var arrayparticipante = new Array();
var arraycaracteristicas = new Array();
var arraydato = new Array();
var ArrayBorrado = new Array();
var ArrayParticipantesEliminados = new Array;

$().ready(function(){		
	
	ArrayBorrado = [];
	
	$.growl.settings.dockCss.width = '225px';
	$.growl.settings.noticeCss = {position: 'relative'};
	$.growl.settings.noticeTemplate = ''
	+ '<table width="225" border="0" cellpadding="0" cellspacing="0">'
	+ '	<tr>'
	+ '		<td style="background-image: url(../img/dm_top.png); width: 225px; height: 49px; background-repeat: no-repeat; color: #FFFFFF;">'
	+ '			<img src="%image%" style="max-width: 25px; max-height: 25px; text-align: center; margin-left: 15px; margin-top: 15px;" />'
	+ '			<h1 style="font-size: 18px; margin: 0pt; margin-left: 5px; margin-bottom: 5px; display: inline; color: #FFFFFF;">%title%</h1>'
	+ '		</td>'
	+ '	</tr>'
	+ '	<tr>'
	+ '		<td style="background-image: url(../img/dm_repeat.png); width: 225px; background-repeat: repeat-y; color: #ddd;">'
	+ '			<p style="margin: 10px;">%message%</p>'
	+ '		</td>'
	+ '	</tr>'
	+ '	<tr>'
	+ '	    <td style="background-image: url(../img/dm_bottom.png); background-repeat: no-repeat; width: 225px; height: 27px;" valign="top" align="right" >'
	+ '			<a style="margin-right: 0px; font-size: 10px; color: #fff; text-align: right; float:right;" href="" onclick="return false;" rel="close">Close</a>'
	+ '		</td>'
	+ '	</tr>'
	'+ </table>';	
	
	 $("#actualizar-generales").validationEngine({	
						   promptPosition: "topRight", 										   
						   inlineValidation: false,     
						   success : function(){ActualizarGenerales(); $("#dialog_datos_generales").dialog("close");}, 
                           failure : function(){var sliderIntervalID = setInterval(function(){$.validationEngine.closePrompt(".formError", true);clearInterval(sliderIntervalID);},10000);}									   
    });	
	 
	$("#actualizar-categoria").validationEngine({	
						   promptPosition: "topRight", 										   
						   inlineValidation: false,     
						   success : function(){ActualizarParticipante();}, 
                           failure : function(){var sliderIntervalID = setInterval(function(){$.validationEngine.closePrompt(".formError", true);clearInterval(sliderIntervalID);},10000);}									   
    });
	
	$("#actualizar-adicionales").validationEngine({	
						   promptPosition: "topRight", 										   
						   inlineValidation: false,     
						   success : function(){ActualizarAdicionales(); $('#dialog_datos_adicionales').dialog("close");}, 
                           failure : function(){var sliderIntervalID = setInterval(function(){$.validationEngine.closePrompt(".formError", true);clearInterval(sliderIntervalID);},10000);}									   
    });
	
	//dialogos.........................
	$(function(){
		$('#dialog_categoria_pruebas').dialog({
			autoOpen: false,
			width: 1000,
			buttons: {
				"Actualizar": function() {
					 $("#actualizar-categoria").submit();								
				}, 
				"Cancelar": function() {				    
				    $.validationEngine.closePrompt(".formError", true);
					$(this).dialog("close"); 
				} 
			}
		});
		
		$('#dialog_datos_adicionales').dialog({
			autoOpen: false,
			width: 1000,
			buttons: {
				"Actualizar": function() { 
				    $("#actualizar-adicionales").submit();					 				
				}, 
				"Cancelar": function() { 				    
				    $.validationEngine.closePrompt(".formError", true);
					$(this).dialog("close"); 
				} 
			}
		});	
		
		$('#dialog_datos_generales').dialog({
			autoOpen: false,
			width: 1000,
			buttons: {
				"Actualizar": function() { 
				    $("#actualizar-generales").submit();							
				}, 
				"Cancelar": function() { 
				    $.validationEngine.closePrompt(".formError", true); 
					$(this).dialog("close"); 
				} 
			}
		});		
	});
	//fin dialogos............................
	
	//cambio en modalidad.....................
	$('#modalidad').change(function(){	   
		   var new_modalidad_text = $("#modalidad option[value="+$('#modalidad').val()+"]").text();	
		   var idmodalidad_change = $('#modalidad').val();
		   idmodalidad_change_global = idmodalidad_change;
		   new_modalidad_text_global = new_modalidad_text;
		   $.ajax({
			 type: "POST",
			 url: "../scripts/ActualizarModalidad.php",
			 processData: false,
			 dataType: "json",
			 data:"idmodalidad="+idmodalidad_change+"&idregmodalidad="+idregmodalidad_global,
			 beforeSend: function(){$.unblockUI; JSBlockUI('Cambiando modalidad...','80000')},
			 success: function(data){if(unJSBlockUI(data.cancelado)){ desplegadoerroresm(data); actualizarJsonDataM(data);}},
			 timeout: 80000
		   });		
	});
	//fin cambio en modalidad.................
	
	//curp.........
	$('#curp').focus(function(){
	  cargarcurp();
	});	
	$('#nombres').change(function(){
	 cargarcurp();
	});
	$('#appaterno').change(function(){
	 cargarcurp();								
	});
	$('#apmaterno').change(function(){
	 cargarcurp();								
	});
	$('#entidad').change(function(){
	 cargarcurp();							  
	});
	$('#sexo').change(function(){
	 cargarcurp();						   
	});
	$('#fechanacimiento').change(function(){
	 cargarcurp();							   
	});
	//fin curp.........
	
	//cambio en deporte.......................
	$('#deportes').change(function(){		
		$('#pruebas').html('');						   
		$.ajax({
		 type: "POST",
		 url: "../scripts/GeneraCategoria.php",
		 processData: false,
		 dataType: "html",
		 data:"deporte="+$(this).val(),
		 beforeSend: function(){JSBlockUI('Generando Categorias...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') {error();} else DespliegaPruebas_Empty(data);}},
		 timeout: 80000
	    });		
	});	
	//fin cambio en deporte...................
	
	//genera autocomplet principal...........
	$.ajax({
	 type: "POST",
	 url: "../scripts/GeneraJsonAutoCompletActual.php",
	 processData: true,
	 dataType: "json",		 	 
	 beforeSend: function(){JSBlockUI('Generando Ambiente de Busqueda...','80000')},
	 success: function(data){if(unJSBlockUI(data.cancelado)){if(data=='no') error(); else {data_actual = data; autocomplet();}}},
	 timeout: 80000
	});	
	//fin genera autocomplet principal........
	
	//adjuntar imagen........................
	var button = $('#upload_button');
	new AjaxUpload(button,{		
	action: '../scripts/upload.php', 
	name: 'userfile',
	onSubmit : function(file, ext){
		if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
			/* Setting data */
			this.setData({'nombreparticipantes': curp_upload,
						  'overwrite' : "si",
						  'action' : "image"});
			
			$('#foto').attr("src","../img/ajax-loader.gif");
		} else {				
			// cancel upload
			alert('solo imagenes');
			return false;				
		}		
	 },
	 onComplete: function(file, response){
		if(response != '1'){ 
		$('#foto').fadeOut(function(){			
			objImagePreloader.onload = function() {
				$('#foto')				
				.removeAttr('src')
				.attr('src',"../fotosparticipantes/"+response+"?nocache="+Math.random()*1000)
				.fadeIn();				
				}				 
				objImagePreloader.src = "../fotosparticipantes/"+response+"?nocache="+Math.random()*1000;						
			});		
		}else{
		alert('No se cargo la imagen, excede el tama\u00F1o permitido, Redusca la imagen de tama\u00F1o, he intente de nuevo'); $('#foto').attr("src","../img/foto.png");}
	 }
	 });
	//fin adjuntar imagen..........................
	
	
});

//************************************************************************************//
function autocomplet()
    {	 	 
	 $("#textobusqueda").autocomplete(data_actual.items, {	   
		minChars: 1,
		width: 910,		
		matchContains: "word",
		max: 30,
		autoFill: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + acentos(row.nombre.toUpperCase()) + " " + acentos(row.appaterno.toUpperCase()) + " " + acentos(row.apmaterno.toUpperCase()) + "\" [" + row.curp + "]" + " " + row.municipio + "<br />" + acentos(row.caracteristicas);
		},
		formatMatch: function(row, i, max) {
			return row.curp + " " + row.nombre + " " + row.appaterno + " " + row.apmaterno + " " + row.deporte+ " " + row.caracteristicas + " " + row.municipio;
		},
		formatResult:function(row){return row.curp}
        }).result(function(event, row, formatted){ 
		
		var borradop = false;
		$.each(ArrayParticipantesEliminados,function(ipe,datape){		    			
		    if(datape == row.id_registro){				
			  	borradop = true;
			}
		});
		
		if(!borradop){
			$('#participante_edit').html('Datos del Participante a Modificar <label style=" color:#666666; font-size:12px;">'+acentos(row.nombre.toUpperCase())+' '+acentos(row.appaterno.toUpperCase())+' '+acentos(row.apmaterno.toUpperCase())+', '+acentos(row.curp.toUpperCase())+' ['+row.municipio+']</label>');
			ActualizarDatosTabla(row);
			data_adicionales = row;
			data_generales = row;
			id_registro = row.id_registro;
			$("#textobusqueda").val('');
		}else{
			alert('El Participante Fue Borrado...'); 
		}	
		
		
		$('#foto')				
		.removeAttr('src')
		.attr('src','../img/foto.png?nocache='+Math.random()*1000);
		
		
	   });
     }
	
function ActualizarDatosTabla(datas)
{    
	    $('#datos_participante').html(''); 	
		arrayparticipante = datas.caracteristicas.split('<br />');		
		$.each(arrayparticipante,function(i,d){		   
		  arraycaracteristicas = d.split(' | ');			 
		  var cargo = '';
		  var deporte = '';
		  var deporte2 = '';
		  var modalidad_local = '';
	      var categoria = '';
		  var prueba = '';
		  var idparticipante_local = '';
		  var iddeporte = '';
		  var iddeporte2 = '';
		  var idcategoria = '';
		  var idregistrocat = '';
		  var idregmodalidad_local = '';
		  
		  $.each(arraycaracteristicas,function(ic,dc){												 
			arraydato = dc.split(':');	
			arraydato[0] = jQuery.trim(arraydato[0]);
			arraydato[1] = jQuery.trim(arraydato[1]);
			if(arraydato[0] == 'IDP')  {idparticipante_local = arraydato[1];}
			if(arraydato[0] == 'IDC')  idcategoria = arraydato[1];
			if(arraydato[0] == 'IDRC')  idregistrocat = arraydato[1];
			if(arraydato[0] == 'IDD')  iddeporte = arraydato[1];
			if(arraydato[0] == 'IDDD') iddeporte2 = arraydato[1];
			if(iddeporte == ''){if(iddeporte2 != '')iddeporte=iddeporte2;}			
			if(arraydato[0] == 'MOD') modalidad_local = arraydato[1];
			if(arraydato[0] == 'IDRM')  idregmodalidad_local = arraydato[1];
			if(arraydato[0] == 'ND')   deporte = arraydato[1];
			if(arraydato[0] == 'NDD')  deporte2 = arraydato[1];			
			if(deporte == ''){if(deporte2 != '')deporte=deporte2;}
			if(arraydato[0] == 'NC')   categoria = arraydato[1];
			if(arraydato[0] == 'PRU')  prueba = arraydato[1];
			if(arraydato[0] == 'CAR')  cargo = arraydato[1];		
			});		 
		  
		  if(acentos(modalidad_local.toUpperCase()) == 'DEPORTISTA' || acentos(modalidad_local.toUpperCase()) == 'ENTRENADOR' || acentos(modalidad_local.toUpperCase()) == 'AUXILIAR' || acentos(modalidad_local.toUpperCase()) == 'DELEGADO POR DEPORTE' || acentos(modalidad_local.toUpperCase()) == 'JUEZ')
			{
			  despliega_mod = '<a title="Cambiar Modalidad" href="javascript:CambiarModalidad(\''+idregmodalidad_local+'\',\''+datas.id_modalidad+'\',\''+modalidad_local+'\');">'+modalidad_local+'</a>';	
			}
			else{despliega_mod=modalidad_local;}
		  
		  $('#datos_participante').append(''
			+   '<tr>'			
			+         '<td>'+deporte+'</td>'
			+         '<td>'+despliega_mod+'</td>'
			+         '<td>'+categoria+'</td>'
			+         '<td>'+prueba+'</td>'
			+         '<td style="text-align:center;"><img style="cursor:pointer;" src="../img/icons/edit.png" onclick="javascript:ModificarCategoriaPruebas(\''+modalidad_local+'\',\''+idregmodalidad_local+'\',\''+categoria+'\',\''+prueba+'\',\''+idparticipante_local+'\',\''+idcategoria+'\',\''+iddeporte+'\',\''+idregistrocat+'\')" /></td>'
			+         '<td style="text-align:center;"><img style="cursor:pointer;" src="../img/icons/delete.png" onclick="javascript:EliminarRegistro(\''+idregistrocat+'\');" /></td>'
			+   '</tr>'			
			);			 
		});		
		
		$('#div_foto').css('display','inline');
		$('#operaciones_participantes').css('display','inline');		
		curp_upload = datas.curp;		
		objImagePreloader.onload = function() {
		        $('#foto')				
			    .removeAttr('src')
				.attr('src','../img/foto.png?nocache='+Math.random()*1000)				
				.fadeIn();				
				}				
		objImagePreloader.src = '../img/foto.png?nocache='+Math.random()*1000;	
				
		objImagePreloader.onload = function() {
		        $('#foto')				
			    .removeAttr('src')
				.attr('src',"../fotosparticipantes/"+curp_upload+'.png'+"?nocache="+Math.random()*1000)			
				.fadeIn();				
				}				
		objImagePreloader.src = "../fotosparticipantes/"+curp_upload+'.png'+"?nocache="+Math.random()*1000;
		
}

function EliminarRegistro(idregistrocategoria)
{
	if(idregistrocategoria != ''){
	   $.ajax({
			 type: "POST",
			 url: "../scripts/EliminarRegistro.php",
			 processData: false,
			 dataType: "json",
			 data:"idregistrocat="+idregistrocategoria,
			 beforeSend: function(){JSBlockUI('Actualizando Datos Generales...','80000')},
			 success: function(data){if(unJSBlockUI(data.cancelado)) desplegadoerroreser(data); actualizarJsonDataER(data);},
			 timeout: 80000
	   });
	   
	   function actualizarJsonDataER(data)
		   {
			   if(data.logoregistro == 'ok'){
			   var ArrayFinal = new Array();			  
			   $.each(data_actual.items, function(i,item){//recorre participantes			  
					if(item.id_registro == id_registro){						    		    
						var NewArrayCaracteristicas = new Array();
						arrayparticipante = item.caracteristicas.split('<br />');		
						if(arrayparticipante.length != 1){
						  $.each(arrayparticipante,function(ip,dp){//recorre caracteristicas	   
							   if(dp.indexOf('IDRC:'+idregistrocategoria) == -1){				   
								 NewArrayCaracteristicas.push(dp);							
						       }							   
						  });		
						  item.caracteristicas = NewArrayCaracteristicas.join('<br />');
						  ActualizarDatosTabla(item);
						}else{
						  var NewArray = Array();	
						  arraycaracteristicas = item.caracteristicas.split(' | ');			
						  $.each(arraycaracteristicas,function(ic,dc){						 
							arraydato = dc.split(':');	
							arraydato[0] = jQuery.trim(arraydato[0]);
							arraydato[1] = jQuery.trim(arraydato[1]);
							if(arraydato[0] == 'IDP')  {NewArray.push(dc);}							
							if(arraydato[0] == 'MOD')  {NewArray.push(dc);}
							if(arraydato[0] == 'IDRM') {NewArray.push(dc);}							
						 });					  
						 NewArrayCaracteristicas.push(NewArray.join(' | '));					 
						 item.caracteristicas = NewArrayCaracteristicas.join('<br />');
						 ActualizarDatosTabla(item); 
						}					
						return false;
				    }				
			   });		    
			   $("#textobusqueda").flushCache();
			   autocomplet();			             
			   }
		   }	   
	}
}

//actualiza generales..........................................
function ActualizarGenerales()
{	          
           
           // idregistrocat_envio, es global
		   var nombres = $('#nombres').val();
	       var appaterno = $('#appaterno').val();
	       var apmaterno = $('#apmaterno').val();
		   var fecha = new Array();
		   fecha = $('#fechanacimiento').val().split('-');		   
	       var fechanacimiento = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
	       var sexo = $('#sexo').val();
	       var entidad = $('#entidad').val();
	       var curp = $('#curp').val(); 
	       $.ajax({
			 type: "POST",
			 url: "../scripts/ActualizarGenerales.php",
			 processData: false,
			 dataType: "json",
			 data:"idregistro="+id_registro+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&fechanacimiento="+fechanacimiento+"&sexo="+sexo+"&entidad="+entidad+"&curp="+curp,
			 beforeSend: function(){$("#dialog_datos_generales").dialog("close"); JSBlockUI('Actualizando Datos Generales...','80000')},
			 success: function(data){if(unJSBlockUI(data.cancelado)){ desplegadoerroresdg(data); actualizarJsonDataDG(data);}},
			 timeout: 80000
		   });
		   
		   function actualizarJsonDataDG(data)
		   {
			   if(data.logoparticipante == 'ok'){
			   $.each(data_actual.items, function(i,item){//recorre participantes				
				   if(item.id_registro == id_registro){	
				        curp_upload = curp;
					    item.nombre = nombres;
						item.appaterno = appaterno;
						item.apmaterno = apmaterno;
						item.curp = curp;
						item.fechanac = fechanacimiento;
						item.sexo = sexo;
						item.entidad = entidad;
						$('#textobusqueda').val(item.curp);
						$('#participante_edit').html('Datos del Participante a Modificar <label style=" color:#666666; font-size:12px;">'+acentos(item.nombre.toUpperCase())+' '+acentos(item.appaterno.toUpperCase())+' '+acentos(item.apmaterno.toUpperCase())+', '+acentos(item.curp.toUpperCase())+' ['+item.municipio+']</label>');
						return false;
				  } 					
			   });
			   $("#textobusqueda").flushCache();
			   autocomplet();			 
			   }
		   }		   
}
//fin actualizar generales.........................................................


//actualizar participante.............................................................
function ActualizarParticipante()
{	
	//DEPORTISTAS,ENTRENADOR,AUXILIAR,DELEGADO POR DEPORTE
	if (modalidad=='DEPORTISTA' || modalidad=='ENTRENADOR' || modalidad=='AUXILIAR' || modalidad=='DELEGADO POR DEPORTE' || modalidad=='JUEZ'){		 
	 
	 if(modalidad=='DEPORTISTA'){
	    //pruebas...................
		lista_pruebas = '';
		if(aplongitud > 0) {
		  $('#pruebas_check :checkbox').each(function(i){
				if($(this).is(":checked"))
				 {
				  lista_pruebas += ap[i]+', ';			  
				 }
		  });
		  if(lista_pruebas=='') {$('#pruebas_check').seekAttention();return false;} 
		  grabar_lista_pruebas = lista_pruebas.substr(0,lista_pruebas.length-2);
		  
		  }
		}
		else{
		grabar_lista_pruebas = 'null';}  
		//fin pruebas...................
		ActualizarDatosDeportistas();
		$("#dialog_categoria_pruebas").dialog("close");
	} 
	
	//COMITE ORGANIZADOR
	if (modalidad=='COMIT\u00C9 ORGANIZADOR' || modalidad=='COMITE ORGANIZADOR' || modalidad=='PRENSA'){	  	  
	   ActualizarComiteOrganizadorPrensa();	 	 	 
	}	
	
	/*//JUEZ, ENTRENADOR, AUXILIAR, DELEGADOS
	if (modalidad=='JUEZ'){		  	    
	   GrabarTodoMas();	 	 	 
	}*/
	
	if (modalidad=='DELEGADO' || modalidad=='DELEGADO GENERAL'){		  	    
	   GrabarDelegado();	 	 	 
	}
}
//fin actualizar participante.........................................................

//actualizar Datos del Deportista
function ActualizarDatosDeportistas()
{	          
           // idregistrocat_envio, es global
		   var deportes = $('#deportes').val();
		   var categoria = $('#selectcategoria').val();		   		   
	       $.ajax({
			 type: "POST",
			 url: "../scripts/ActualizarDeportista.php",
			 processData: false,
			 dataType: "json",
			 data:"idregistro="+id_registro+"&categoria="+categoria+"&pruebas="+grabar_lista_pruebas+"&idregistrocat="+idregistrocat_envio,
			 beforeSend: function(){$("#dialog_categoria_pruebas").dialog("close"); JSBlockUI('Actualizando Datos...','80000')},
			 success: function(data){if(unJSBlockUI(data.cancelado)){ desplegadoerrores(data); actualizarJsonDataDD(data);}},
			 timeout: 30000
		   });
		   
		   function actualizarJsonDataDD(data)
		   {
			   if(data.logocategoria == 'ok'){
			   $.each(data_actual.items, function(i,item){//recorre participantes				
					if(item.id_registro == id_registro){	
					    var NewArray = new Array();
						var NewArrayCaracteristicas = new Array();
						var ban_rcategoria = false;						
						arrayparticipante = item.caracteristicas.split('<br />');		
						$.each(arrayparticipante,function(ip,dp){//recorre caracteristicas		 
						     if(data.tipo_update == 'update'){     
							   if(dp.indexOf('IDRC:'+data.id_registrocat_new) > -1){
							    arraycaracteristicas = dp.split(' | ');									
							  	$.each(arraycaracteristicas,function(ic,dc){//recorre item de caracteristicas
							 		var vardelete = false;
							 		arraydato = dc.split(':');		
							 		arraydato[0] = jQuery.trim(arraydato[0]);
							 		arraydato[1] = jQuery.trim(arraydato[1]);																
									
									 if(arraydato[0] == 'IDC')
									  arraydato[1] = categoria;
							 		 if(arraydato[0] == 'IDRC')
									  arraydato[1] = data.id_registrocat_new;
							 		 if(arraydato[0] == 'IDD')
									  arraydato[1] = deportes;							
							 		 if(arraydato[0] == 'ND')
									  arraydato[1] = $("#deportes option[value="+deportes+"]").text();							
							 		 if(arraydato[0] == 'NC')
									  arraydato[1] = data.nombre_categoria;
							 		 if(arraydato[0] == 'PRU')
									  arraydato[1] = grabar_lista_pruebas;							
							 		 if(arraydato[0] == 'IDDD')
									  {vardelete = true;}							
							 		 if(arraydato[0] == 'NDD')
									  {vardelete = true;}								
									
							 		if(!vardelete) {NewArray.push(arraydato.join(':'));}
							    });
								NewArrayCaracteristicas.push(NewArray.join(' | '));
							   }else{
								NewArrayCaracteristicas.push(dp);   
							   }						        
						     }
							 
							 if(data.tipo_update == 'insert'){
								if(dp.indexOf('IDP:'+data.id_registrocat_new) == -1 &&
								   dp.indexOf('IDDD:'+deportes) == -1 &&
								   dp.indexOf('MOD:'+firscharupper(modalidad)) == -1)
								   {NewArrayCaracteristicas.push(dp);}
							 }
						});	
						
						if(data.tipo_update == 'insert'){
						   NewArrayCaracteristicas.push(''
						   +  'IDP:'+id_registro+' | '
						   +  'IDRC:'+data.id_registrocat_new+' | '
						   +  'IDC:'+categoria+' | '
						   +  'IDD:'+deportes+' | '
						   +  'MOD:'+firscharupper(modalidad)+' | '
						   +  'ND:'+$("#deportes option[value="+deportes+"]").text()+' | '
						   +  'NC:'+data.nombre_categoria+' | '
						   +  'PRU:'+grabar_lista_pruebas
						   ); 
						}
						
						item.caracteristicas = NewArrayCaracteristicas.join('<br />');
						ActualizarDatosTabla(item);
						return false;
				  } 												  
			   });
			   $("#textobusqueda").flushCache();
			   autocomplet();			 
			   }
		   }		   
}
//fin actualizar datos deportista.........................................................


function EliminarParticipante()
{
	       $.ajax({
			 type: "POST",
			 url: "../scripts/EliminarParticipante.php",
			 processData: false,
			 dataType: "json",
			 data:"&idregistro="+id_registro,
			 beforeSend: function(){JSBlockUI('Eliminando Participante...','80000')},
			 success: function(data){if(unJSBlockUI(data.cancelado)) desplegadoerroresep(data); actualizarJsonDataEP(data);},
			 timeout: 80000
		   });

           function actualizarJsonDataEP(data)
		   {			   
			   if(data.logoparticipante == 'ok'){			   						
					   $('#datos_participante').html('');								
					   $('#participante_edit').html('Datos del Participante a Modificar');
					   $('#div_foto').css('display','none');
		               $('#operaciones_participantes').css('display','none');	
		
					   $("#textobusqueda").val('');
					   var elimina_participante = new TAFFY($.json.encode(data_actual.items));	   
					   elimina_participante.remove({id_registro:id_registro});	
					   //conv. el objeto taffy en string, para despues convertirla en objeto json
					   var text_stringify = elimina_participante.stringify(); 	   
					   data_actual.items = {};
					   data_actual.items = $.json.decode(text_stringify);						   
					   ArrayParticipantesEliminados.push(id_registro);	        
					   $("#textobusqueda").flushCache();
					   autocomplet();
			 }
		   }
}
function DatosComunes()
   {	   
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
	   
	   direccion_global = direccion;					
	   colonia_global = colonia;					
	   localidad_global = localidad;					
	   codigopostal_global = codigopostal;					
	   telefonos_global = telefonos;					
	   correo_global = correo;					
	   peso_global = peso;					
	   talla_global = talla;					
	   rfc_global = rfc;					
	   tiposanguineo_global = tiposanguineo;		
	   
	   return "direccion="+direccion+"&telefonos="+telefonos+"&colonia="+colonia+"&localidad="+localidad+"&codigopostal="+codigopostal+"&correo="+correo+"&peso="+peso+"&talla="+talla+"&rfc="+rfc+"&tiposanguineo="+tiposanguineo   
   }
   
function ActualizarAdicionales()
{
	       $.ajax({
			 type: "POST",
			 url: "../scripts/ActualizarDatosAdicionales.php",
			 processData: false,
			 dataType: "json",
			 data:DatosComunes()+"&idregparticipante="+id_registro,
			 beforeSend: function(){$("#dialog_datos_adicionales").dialog("close"); JSBlockUI('Actualizando Datos...','80000')},
			 success: function(data){if(unJSBlockUI(data.cancelado)){ desplegadoerroresda(data); actualizarJsonDataDA(data);}},
			 timeout: 80000
		   });

           function actualizarJsonDataDA(data)
		   {			   
			   if(data.logoadicionales == 'ok'){
			   $.each(data_actual.items, function(i,item){//recorre participantes				
					if(item.id_registro == id_registro){				
					    item.direccion = direccion_global;					
						item.colonia = colonia_global;					
						item.localidad = localidad_global;					
						item.codigop = codigopostal_global;					
						item.telefonos = telefonos_global;					
						item.correo = correo_global;					
						item.peso = peso_global;					
						item.talla = talla_global;					
						item.rfc = rfc_global;					
						item.tiposanguineo = tiposanguineo_global;					
						ActualizarDatosTabla(item);
						return false;
				    } 												  
			   });
			   $("#textobusqueda").flushCache();
			   autocomplet();			 
			   }
		   }         
}

function ActualizarComiteOrganizadorPrensa()
{	                  
           var cargo = $('#cargo').val();
		   var prensa = $('#prensa').val();
		   
		   if(cargo=='') cargo = prensa;
		   
	       $.ajax({
			 type: "POST",
			 url: "../scripts/ActualizarComiteOrganizadorPrensa.php",
			 processData: false,
			 dataType: "json",
			 data:"idregmodalidad="+idregmodalidad_envio+"&cargo="+cargo,
			 beforeSend: function(){$("#dialog_categoria_pruebas").dialog("close"); JSBlockUI('Actualizando Datos...','80000')},
			 success: function(data){if(unJSBlockUI(data.cancelado)){ desplegadoerrorescp(data); actualizarJsonDataCP(data);}},
			 timeout: 80000
		   });
		   
		   function actualizarJsonDataCP(data)
		   {
			   
			   if(data.logomodalidad == 'ok'){
			   $.each(data_actual.items, function(i,item){//recorre participantes				
					if(item.id_registro == id_registro){				
					    var NewArray = new Array(); 
						var NewArrayCaracteristicas = new Array();												
						arrayparticipante = item.caracteristicas.split('<br />');		
						$.each(arrayparticipante,function(ip,dp){//recorre caracteristicas				   					  
						       if(dp.indexOf('IDRM:'+idregmodalidad_envio) > -1){								  
							    arraycaracteristicas = dp.split(' | ');									
							  	$.each(arraycaracteristicas,function(ic,dc){
							    //recorre item de caracteristicas							 		
							 		arraydato = dc.split(':');		
							 		arraydato[0] = jQuery.trim(arraydato[0]);
							 		arraydato[1] = jQuery.trim(arraydato[1]);								
									if(arraydato[0] == 'CAR') arraydato[1] = cargo;
							 		NewArray.push(arraydato.join(':'));
							    });
								NewArrayCaracteristicas.push(NewArray.join(' | '));
								NewArray = [];
							   }else{
								NewArrayCaracteristicas.push(dp);   
							   }					     
						});					
						item.caracteristicas = NewArrayCaracteristicas.join('<br />');
						ActualizarDatosTabla(item);
						return false;
				  } 												  
			   });
			   $("#textobusqueda").flushCache();
			   autocomplet();			 
			   }
		   }		   
}

function desplegadoerrores(data)
 {	 
     $.growl.settings.displayTimeout = 8000;
	 $.growl('Categoria', data.categoria, '../img/button_'+data.logocategoria+'_25.png', 'high');	
	 
 }
 
function desplegadoerroreser(data)
 {	 
     $.growl.settings.displayTimeout = 8000;
	 $.growl('Registro', data.registro, '../img/button_'+data.logoregistro+'_25.png', 'high');	
	 
 } 

function desplegadoerroresdg(data)
 {	 
     $.growl.settings.displayTimeout = 8000;
	 $.growl('Datos Generales', data.participante, '../img/button_'+data.logoparticipante+'_25.png', 'high');	
	 
 }


function desplegadoerroresep(data)
 {	 
     $.growl.settings.displayTimeout = 8000;
	 $.growl('Participante', data.participante, '../img/button_'+data.logoparticipante+'_25.png', 'high');	
	 
	 $.growl.settings.displayTimeout = 9000;
	 $.growl('Modalidad', data.modalidad, '../img/button_'+data.logomodalidad+'_25.png', 'high');	
	 
	 $.growl.settings.displayTimeout = 10000;
	 $.growl('Evento', data.evento, '../img/button_'+data.logoevento+'_25.png', 'high');	
	 
	 $.growl.settings.displayTimeout = 11000;
	 $.growl('Categoria', data.categoria, '../img/button_'+data.logocategoria+'_25.png', 'high');	
	 
 }


function desplegadoerroresda(data)
 {	 
     $.growl.settings.displayTimeout = 8000;
	 $.growl('Datos Adicionales', data.adicionales, '../img/button_'+data.logoadicionales+'_25.png', 'high');	
	 
 }

function desplegadoerrorescp(data)
 {	 
     $.growl.settings.displayTimeout = 8000;
	 $.growl('Comite-Prensa', data.modalidad, '../img/button_'+data.logomodalidad+'_25.png', 'high');		 
 }
 
function desplegadoerroresm(data)
 {	 
     $.growl.settings.displayTimeout = 8000;
	 $.growl('Modalidad', data.modalidad, '../img/button_'+data.logomodalidad+'_25.png', 'high');	 
 }

function VerificaModalidad(dato)
{	

		modalidad = acentos(dato.toUpperCase());
		
		//delegado
		if(modalidad == 'DELEGADO' || modalidad == 'DELEGADO GENERAL')
		{	   
		   
		   $('#div_deportes_extras').css('display','none');
		   $('#fieldsetcategoria').css('display','none');		   
		   $("#div_cargo").css('display','none');		   
		   $("#div_prensa").css('display','none');		   
		   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
		   $("#cargo").removeClass("validate[required] span-7 text");
		   $("#prensa").removeClass("validate[required] span-7 text");
		   $("#cargo").val('');
		   $("#deportes_extras").val('');		   
		   $("#deportes").removeClass("validate[required] span-7 cselect");
		   $("#selectcategoria").removeClass("validate[required] span-12 cselect");		   		   
		}
		
		//deportista, entrenadores, auxiliares, delegado por deporte, juez
		if(modalidad == 'DEPORTISTA' || modalidad == 'ENTRENADOR' || modalidad == 'AUXILIAR' || modalidad == 'DELEGADO POR DEPORTE' || modalidad == 'JUEZ')
		{	
		   
		   $('#div_deportes_extras').css('display','none');		   	   
		   $("#div_cargo").css('display','none');
		   $("#div_prensa").css('display','none');		   
		   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
		   $("#cargo").removeClass("validate[required] span-7 text");
		   $("#prensa").removeClass("validate[required] span-7 text");
		   $("#deportes").addClass("validate[required] span-7 cselect");
		   $("#selectcategoria").addClass("validate[required] span-12 cselect");
		   $('#fieldsetcategoria').css('display','block');	
		   if(modalidad != 'DEPORTISTA')
		     {
				 $('#pruebas').html('');
		     }
		}
		
		//comite organizador
		if (modalidad=='COMIT\u00C9 ORGANIZADOR' || modalidad=='COMITE ORGANIZADOR' || modalidad=='COMIT&Eaute; ORGANIZADOR' || modalidad=='COMIT&EACUTE; ORGANIZADOR')
		{		   
		   $('#div_deportes_extras').css('display','none');
		   $('#fieldsetcategoria').css('display','none');			
		   $("#div_cargo").css('display','block');
		   $("#div_prensa").css('display','none');
		   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
		   $("#cargo").addClass("validate[required] span-7 text");
		   $("#deportes").removeClass("validate[required] span-7 cselect");
		   $("#prensa").removeClass("validate[required] span-7 cselect");
		   $("#selectcategoria").removeClass("validate[required] span-12 cselect");
		}
		
		//prensa
		if (modalidad=='PRENSA')
		{		   
		   $('#div_deportes_extras').css('display','none');
		   $('#fieldsetcategoria').css('display','none');			
		   $("#div_cargo").css('display','none');
		   $("#div_prensa").css('display','block');
		   $("#deportes_extras").removeClass("validate[required] span-7 cselect");
		   $("#prensa").addClass("validate[required] span-7 text");
		   $("#cargo").removeClass("validate[required] span-7 text");
		   $("#deportes").removeClass("validate[required] span-7 cselect");
		   $("#selectcategoria").removeClass("validate[required] span-12 cselect");
		}		
}


function CambiarModalidad(idregmodalidad,idmodalidad,modalidad_text)
{	
    idregmodalidad_global = idregmodalidad;
	idmodalidad_global = idmodalidad;
	modalidad_text_global = modalidad_text; 
	$.blockUI({message:  $('#cambiar_modalidad'), 
            css: { width: '260px' } ,
			timeout : 0
    });
	
	$('.blockOverlay').attr('title','Click para desbloquear').click($.unblockUI);
	$('.blockOverlay').css('cursor','default');
	$('#modalidad').val(idmodalidad);		   
}

function actualizarJsonDataM(data)
{			      
			   if(data.logomodalidad == 'ok'){
			   $.each(data_actual.items, function(i,item){//recorre participantes				
					if(item.id_registro == id_registro){	
					    var NewArray = new Array();
						var NewArrayCaracteristicas = new Array();												
						arrayparticipante = item.caracteristicas.split('<br />');		
						$.each(arrayparticipante,function(ip,dp){//recorre caracteristica                      
						       if(dp.indexOf('IDRM:'+idregmodalidad_global) > -1){							     
							    arraycaracteristicas = dp.split(' | ');									
							  	$.each(arraycaracteristicas,function(ic,dc){
							    //recorre item de caracteristicas							 		
							 		arraydato = dc.split(':');		
							 		arraydato[0] = jQuery.trim(arraydato[0]);
							 		arraydato[1] = jQuery.trim(arraydato[1]);								
									if(arraydato[0] == 'MOD') {arraydato[1] = new_modalidad_text_global;}									
							 		NewArray.push(arraydato.join(':'));
							    });
								NewArrayCaracteristicas.push(NewArray.join(' | '));								
								NewArray = [];
							   }else{
								NewArrayCaracteristicas.push(dp);   
							   }	
						});					
						item.caracteristicas = NewArrayCaracteristicas.join('<br />');
						item.id_modalidad = idmodalidad_change_global;
						ActualizarDatosTabla(item);
						return false;
				  } 												  
			   });
			  
			   }
}  	   
	

function ModificarCategoriaPruebas(modalidad_edit,idregmodalidad_edit,categoria, prueba, idparticipante, idcategoria, iddeporte,idregistrocat)
    {	    
	    VerificaModalidad(modalidad_edit);						
		idregmodalidad_envio = idregmodalidad_edit;
		if(modalidad == 'DEPORTISTA' || modalidad == 'ENTRENADOR' || modalidad == 'AUXILIAR' || modalidad == 'DELEGADO POR DEPORTE' || modalidad == 'JUEZ')
		{			   
		   idregistrocat_envio = idregistrocat; 		   
		   $('#deportes').val(iddeporte);
		   $.ajax({
			 type: "POST",
			 url: "../scripts/GeneraCategoria.php",
			 processData: false,
			 dataType: "html",
			 data:"deporte="+iddeporte,
			 beforeSend: function(){JSBlockUI('Generando Datos a Modificar...','80000');},
			 success: function(data){if(unJSBlockUI(data)){ if(data=='no') {error();} else DespliegaPruebas(data,idcategoria,modalidad_edit,prueba); $('#dialog_categoria_pruebas').dialog('open');}},
			 timeout: 80000
		   });
		}		
		
		if (modalidad=='COMIT\u00C9 ORGANIZADOR' || modalidad=='COMITE ORGANIZADOR' || modalidad=='COMIT&Eaute; ORGANIZADOR' || modalidad=='COMIT&EACUTE; ORGANIZADOR' || modalidad=='PRENSA')
		{			   
		  $('#dialog_categoria_pruebas').dialog('open');			
		}			
	}

function ModificarAdicionales()
    {    
		$('#dialog_datos_adicionales').dialog('open');
		if(data_adicionales.localidad == 'null') data_adicionales.localidad = '';
		if(data_adicionales.direccion == 'null') data_adicionales.direccion = '';
		if(data_adicionales.colonia == 'null') data_adicionales.colonia = '';
		if(data_adicionales.codigop == 'null') data_adicionales.codigop = '';
		if(data_adicionales.telefonos == 'null') data_adicionales.telefonos = '';
		if(data_adicionales.correo == 'null') data_adicionales.correo = '';
		if(data_adicionales.peso == 'null') data_adicionales.peso = '';
		if(data_adicionales.talla == 'null') data_adicionales.talla = '';
		if(data_adicionales.rfc == 'null') data_adicionales.rfc = '';
		if(data_adicionales.tiposanguineo == 'null') data_adicionales.tiposanguineo = '';
		$('#localidad').val(data_adicionales.localidad);
		$('#direccion').val(data_adicionales.direccion);
		$('#colonia').val(data_adicionales.colonia);
		$('#codigopostal').val(data_adicionales.codigop);
		$('#telefonos').val(data_adicionales.telefonos);
		$('#correo').val(data_adicionales.correo);
		$('#peso').val(data_adicionales.peso);
		$('#talla').val(data_adicionales.talla);
		$('#rfc').val(data_adicionales.rfc);
		$('#tiposanguineo').val(data_adicionales.tiposanguineo);
	}

function ModificarGenerales()
    {   	    
		$('#dialog_datos_generales').dialog('open');		
		$('#nombres').val(acentos(data_generales.nombre.toUpperCase()));
		$('#appaterno').val(acentos(data_generales.appaterno.toUpperCase()));
		$('#apmaterno').val(acentos(data_generales.apmaterno.toUpperCase()));
		
		var fecha = new Array();
		fecha = data_generales.fechanac.split('-');
		$('#fechanacimiento').val(fecha[2]+'-'+fecha[1]+'-'+fecha[0]);
		$('#entidad').val(data_generales.entidad.toUpperCase());
		$('#sexo').val(data_generales.sexo.toUpperCase());
		$('#curp').val(data_generales.curp.toUpperCase());		
	}
	
function DespliegaPruebas(data,idcategoria,modalidad_edit,prueba)
    {    
		$('#categoria').html(data);			
		$('#selectcategoria').val(idcategoria); 
		
		if(modalidad_edit.toUpperCase() == 'DEPORTISTA'){
			$('#selectcategoria').change(function(){	
		       MuestraDesplegadoPrueba("noseleccionar",prueba);	  
			});
			MuestraDesplegadoPrueba("seleccionar",prueba);
			
		}
	}
function DespliegaPruebas_Empty(data)
    {
		$('#categoria').html(data);			
		if(modalidad == 'DEPORTISTA'){
		$('#selectcategoria').change(function(){	
		  var cont = 0;	
		  var lista ='';
		  var sprueba =false;
		  ap = $('#pruebas'+$('#selectcategoria').val()).html().split(',');
		  aplongitud = ap.length;		  
		  if(aplongitud>0 && $('#pruebas'+$('#selectcategoria').val()).html() != ''){
		  $.each(ap,function(iap,dataap){		    			
		    if(cont == 0) {lista += '<tr>'+'<td><legend><input type="checkbox">'+dataap+'</legend></td>'; sprueba =false} else {lista += '<td><legend><input type="checkbox">'+dataap+'</legend></td>';}
		    if(cont == 5) {lista += '</tr>'; sprueba=true; cont=-1;}			
			cont++;
		  });
		  
		  if(sprueba==false) {lista += '</tr>';}
		  
	      $('#pruebas').html('<table id = "pruebas_check">'+lista+'</table>');	  
		  }		  
	    });
		}
	}
	
function MuestraDesplegadoPrueba(tipo,prueba)
{	      
	        var cont = 0;	
			var lista ='';
			var sprueba =false;			
			var clase ='';
			
			ap = $('#pruebas'+$('#selectcategoria').val()).html().split(',');
			aplongitud = ap.length;			
			if(aplongitud>0 && $('#pruebas'+$('#selectcategoria').val()).html() != ''){
			if(tipo=='seleccionar')arrayp = prueba.split(',');
			$.each(ap,function(iap,dataap){
				if(tipo=='seleccionar'){			   
					clase='';			   
					$.each(arrayp,function(i,data){					
					if(jQuery.trim(acentos(data.toUpperCase())) == jQuery.trim(acentos(dataap.toUpperCase())))
						{						
							clase='checked="checked"';
						}
						
					});
				}
				if(cont == 0) {lista += '<tr>'+'<td style="vertical-align:top;"><legend><input type="checkbox" '+clase+'>'+dataap+'</legend></td>'; sprueba =false;} else {lista += '<td style="vertical-align:top;"><legend><input type="checkbox" '+clase+'>'+dataap+'</legend></td>';}
				if(cont == 5) {lista += '</tr>'; sprueba=true; cont=-1;}			
				cont++;
			});		  
			if(sprueba==false) {lista += '</tr>';}		  
			$('#pruebas').html('<table id = "pruebas_check">'+lista+'</table>');		  	  		            }			
}
	
