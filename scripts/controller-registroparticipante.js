jQuery(function($){
   $("#fechanacimiento").mask("d9-m9-wxs9");   
});
jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
//************************************************************************************
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
var tabla_categoria_registro = '';
var lista_categorias_tabla_registro = '';
var participante_sel = '';
var ind_cat = 0;
var totalrow_categoria = 0;
var setinterval_foto = 0;
var ban_accordion = 'desactivado';
var idregistro = 0;

var objImagePreloader = new Image();
var arrhtml = new Array(25); 
var arruni = new Array(25); 
var arrayacentos = new Array();

arrhtml[0]="&NTILDE;";arrhtml[1]="&AACUTE;";arrhtml[2]="&EACUTE;";arrhtml[3]="&OACUTE;";arrhtml[4]="&UACUTE;";arrhtml[5]="&IACUTE;";arrhtml[6]="&Ntilde;";arrhtml[7]="&Aacute;";arrhtml[8]="&Eacute;";arrhtml[9]="&Oacute;";arrhtml[10]="&Uacute;";arrhtml[11]="&Iacute;";
arrhtml[12]="Ñ";arrhtml[13]="Á";arrhtml[14]="É";arrhtml[15]="Ó";arrhtml[16]="Ú";arrhtml[17]="Í";arrhtml[18]="Ñ";arrhtml[19]="Á";arrhtml[20]="É";arrhtml[21]="Ó";arrhtml[22]="Ú";arrhtml[23]="Í";arrhtml[24]="&ntilde;";

arruni[0]="\u00D1";arruni[1]="\u00C1";arruni[2]="\u00C9";arruni[3]="\u00D3";arruni[4]="\u00DA";arruni[5]="\u00CD";arruni[6]="\u00D1";arruni[7]="\u00C1";arruni[8]="\u00C9";arruni[9]="\u00D3";arruni[10]="\u00DA";arruni[11]="\u00CD";arruni[12]="\u00D1";arruni[13]="\u00C1";arruni[14]="\u00C9";arruni[15]="\u00D3";arruni[16]="\u00DA";arruni[17]="\u00CD";arruni[18]="\u00D1";arruni[19]="\u00C1";arruni[20]="\u00C9";arruni[21]="\u00D3";arruni[22]="\u00DA";arruni[23]="\u00CD";arrhtml[24]="\u00D1";

$().ready(function(){	
				   
	$(function() {
	$('#navigation a').stop().animate({'marginLeft':'-22px'},1000);	
	$('#navigation > li').hover(function () {
		$('a',$(this)).stop().animate({'marginLeft':'-4px'},200);},
	    function () {
	    $('a',$(this)).stop().animate({'marginLeft':'-22px'},1000);});
	});

			   
				   
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
			pager: jQuery('#pagerb'),			
			sortname: 'curp',
			pgbuttons: false,
   	        pgtext: false,
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
	
	$("#accordion").accordion({collapsible: true, active: false, alwaysOpen: false, animated: false, autoheight: false, header: "h3"});
	
	$("#accordion").click(function(){
	   ban_accordion = (ban_accordion == 'desactivado') ? 'activado' : 'desactivado';		   
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
					  {name:'foto',index:'foto', width:75, align:"center"}],
			rowNum:0,			
			//rowList:[5,10,15,20,25,30,35,40,100],
			mtype: "POST",
			pager: jQuery('#pagerb'),			
			sortname: 'curp',
			pgbuttons: false,
   	        pgtext: false,
   	        pginput:false,
			viewrecords: true,
			subGrid : true, subGridUrl: '../scripts/GeneraJsonSubgridRegistro.php?evento='+$('#evento').val(), subGridModel: [{ name : ['Eliminar','Evento','Modalidad','Deporte','Categoria','Pruebas'], width : [30,100,100,100,180,200]}],			
			caption: "Lista de Participantes Registrados"
	});
	
	/*$.ajax({
		 type: "POST",
		 url: "../scripts/GeneraJsonAutoComplet.php",
		 processData: true,
		 dataType: "json",		 
		 beforeSend: function(){JSBlockUI('Generando Ambiente de Busqueda...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){ if(data=='no') error(); else autocomplet(data);}},
		 timeout: 80000
	});*/
	
	/*$("#list4").jqGrid({
		url:'../scripts/GeneraJson.php',
		datatype: "json",
		height: 255,
		colNames:[ 'CURP','Nombre', 'Paterno', 'Materno','Municipio','Sexo','Nacimiento','Caracteristicas'],
		colModel:[ {name:'curp',index:'curp', width:100}, 
				 {name:'nombre',index:'nombre', width:100, sorttype:"date"}, 
				 {name:'paterno',index:'paterno', width:100}, 
				 {name:'materno',index:'materno', width:100, align:"right",sorttype:"float"}, 
				 {name:'municipio',index:'municipio', width:100, align:"right",sorttype:"float"}, 
				 {name:'sexo',index:'sexo', width:100, align:"right",sorttype:"float"}, 
				 {name:'nacimiento',index:'nacimiento', width:100, sortable:false},
				 {name:'caracteristicas',index:'caracteristicas', width:100, sortable:false}],
		rowNum:50,
		rowList:[5,10,15,20,25,30,35,40,50],
		mtype: "POST",
		pager: jQuery('#pagerb'),
		pgbuttons: false,
		pgtext: false,
		pginput:false,
		sortname: 'curp',
		viewrecords: true,
		sortorder: "asc",
		multiselect: true,
		caption: "Selecciona Participante"
	});*/
	
    /*jQuery("#list4").jqGrid(
	{ datatype: "local",
	  height: 100,	  
	  colNames:[ 'Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
	  colModel:[ {name:'id',index:'id', width:100, sorttype:"int"}, 
				 {name:'invdate',index:'invdate', width:100, sorttype:"date"}, 
				 {name:'name',index:'name', width:100}, 
				 {name:'amount',index:'amount', width:100, align:"right",sorttype:"float"}, 
				 {name:'tax',index:'tax', width:100, align:"right",sorttype:"float"}, 
				 {name:'total',index:'total', width:100, align:"right",sorttype:"float"}, 
				 {name:'note',index:'note', width:100, sortable:false} ], 
	  multiselect: true, caption: "Manipulating Array Data"
	}); 	

	var mydata = [ 
	{id:"1",invdate:"2007-10-01",name:"test",note:"note",amount:"200.00",tax:"10.00",total:"210.00"},
	{id:"2",invdate:"2007-10-02",name:"test2",note:"note2",amount:"300.00",tax:"20.00",total:"320.00"},
	{id:"3",invdate:"2007-09-01",name:"test3",note:"note3",amount:"400.00",tax:"30.00",total:"430.00"},
	{id:"4",invdate:"2007-10-04",name:"test",note:"note",amount:"200.00",tax:"10.00",total:"210.00"},
	{id:"5",invdate:"2007-10-05",name:"test2",note:"note2",amount:"300.00",tax:"20.00",total:"320.00"},
	{id:"6",invdate:"2007-09-06",name:"test3",note:"note3",amount:"400.00",tax:"30.00",total:"430.00"},
	{id:"7",invdate:"2007-10-04",name:"test",note:"note",amount:"200.00",tax:"10.00",total:"210.00"},
	{id:"8",invdate:"2007-10-03",name:"test2",note:"note2",amount:"300.00",tax:"20.00",total:"320.00"},
	{id:"9",invdate:"2007-09-01",name:"test3",note:"note3",amount:"400.00",tax:"30.00",total:"430.00"} ]; 
	
	for(var i=0;i<=mydata.length;i++) jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);*/
	
	$("#deportes_buscar").addClass("cselect");
	$("#deportes_registro").addClass("cselect");
	$("#modalidad_buscar").removeClass("span-7").addClass("span-4");
	$("#modalidad_registro").removeClass("span-7").addClass("span-5");
	
	crearinterval_foto();
	
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
	
	$(function(){					   
	    $('#dialog_renovar_participante').dialog({
			autoOpen: false,
			width: 1080,
			buttons: {
				/*"Cargar": function() {					 
					 $("#renovar-participante").submit();	
					 DesactivarDatos();
					 cargar_participantes();
				},*/ 
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
	
	/*$("#agregar-categoria").click(function(){	
										   alert('entre');
	 var deportes = $('#deportes').val();							  
	 var selectcategoria = $('#selectcategoria').val();	
	 
	 var totalrow = $('#lista_categorias tr').length;
	 if(totalrow>0){
	   var cat_duplicada = false; 
	   $('#lista_categorias tr').each(function(){
		 if($(this).children('td').eq(0).html()==selectcategoria)
		 {
		   $.growlUI('No se pudo agregar la categoria','Categoria duplicada...',5000);
		   $("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
		   cat_duplicada = true;
		 }
       });
	   if(cat_duplicada) return false;
	 }
	 
	 if(deportes == ''){$('#deportes').seekAttention();return false;}
	 if(selectcategoria == ''){$('#selectcategoria').seekAttention(); return false;}
	 lista_pruebas = '';
	 if(aplongitud > 0) {
		 $('#pruebas_check :checkbox').each(function(i){
            if($(this).is(":checked"))
		     {
		      lista_pruebas += ap[i]+', ';			  
		     }
         });
	     if(lista_pruebas=='') {$('#pruebas_check').seekAttention();return false;} 
	 }
	 agregarcategoria();  
    });*/	
	
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
	
	$('#grabar_participante_div').click(function(){
		
	});
	
	
	$('#deportes').change(function(){		
	 /*if(modalidad == 'DEPORTISTA' || modalidad=='ENTRENADOR' || modalidad=='AUXILIAR' || modalidad=='DELEGADO POR DEPORTE' || modalidad=='JUEZ')
	  {*/		
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
	  /*}*/
	});
	
	$('#deportes_registro').change(function(){		
	 /*var modalidad_registro = $("#modalidad_registro option[value="+$('#modalidad_registro').val()+"]").text().toUpperCase();
	 if(modalidad_registro == 'DEPORTISTA' || modalidad_registro =='ENTRENADOR' || modalidad_registro =='AUXILIAR' || modalidad_registro=='DELEGADO POR DEPORTE' || modalidad_registro=='JUEZ' || modalidad_registro=='')
	  {*/		
		$.ajax({
		 type: "POST",
		 url: "../scripts/GeneraCategoria_Buscar.php",
		 processData: false,
		 dataType: "html",
		 data:"deporte="+$(this).val()+"&evento="+$("#evento").val(),
		 beforeSend: function(){JSBlockUI('Generando Categorias...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') {error();} else despliegapruebas_registro(data);}},
		 timeout: 80000
	    });		
	  //}
	});
	
	/*$('#deportes_buscar').change(function(){									   
		$.ajax({
		 type: "POST",
		 url: "../scripts/GeneraCategoria.php",
		 processData: false,
		 dataType: "html",
		 data:"deporte="+$(this).val(),
		 beforeSend: function(){JSBlockUI('Generando Categorias...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') {error();} else despliegacategoria(data);}},
		 timeout: 80000
	    });		
	});*/
	
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
	
	/*$('#list4').change(function(){	
	  $('.cbox').click(function(){										
		 participante_sel = jQuery("#list4").jqGrid('getGridParam','selarrrow');
		 $('#selpart').html('Participantes Seleccionados( '+participante_sel.length+' )');
		 alert(participante_sel.length);
	  });	
	});*/
	
});
//************************************************************************************
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
	   var pruebas = 'null</d></d></d></d>';
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
	   arraylistacategoria.push(modalidad+'<ev>'+deporte+'<ev>'+categoria+'<ev>'+pruebas+'<ev>'+cargo_prensa);					
	   lista_modalidad_categorias = arraylistacategoria.join('<evp>');  
	}else{							
	   var listacategoria= $("#listcategoria").jqGrid('getRowData');		
	   var arraylistacategoria = new Array();
	   for(var i=0;i<listacategoria.length;i++){			
		  arraylistacategoria.push(listacategoria[i].claves);			
	   }		
	   lista_modalidad_categorias = arraylistacategoria.join('<evp>');					
	}	
	
	/*alert("lista_modalidad_categorias="+lista_modalidad_categorias+"&idregistro="+idregistro+DatosComunes());*/
	
	$.ajax({
		 type: "POST",
		 url: "../scripts/ActualizarParticipante.php",
		 processData: true,
		 dataType: "json",		 
		 data: "lista_modalidad_categorias="+lista_modalidad_categorias+"&idregistro="+idregistro+DatosComunes(),
		 beforeSend: function(){JSBlockUI('Actualizando Participante...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){desplegarstatuactualizado(data); limpiarparticipante(); limpiargenerales();}},
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
	  var claves = $('#modalidad').val()+'<ev>'+$('#deportes').val()+'<ev>'+$('#selectcategoria').val()+'<ev>'+pruebas+'<ev>null';
	}else{	  		  
	  pruebas = '';
	  var claves = $('#modalidad').val()+'<ev>'+$('#deportes').val()+'<ev>'+$('#selectcategoria').val()+'<ev>null<ev>null';	
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
	img_cargarcurp
}

function actualizarfoto(idcurp){    
	var button = $('#foto'+idcurp);
	new AjaxUpload(button,{		
	action: '../scripts/upload.php', 
	name: 'userfile',
	onSubmit : function(file, ext){
		if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
		    
			/* Setting data */
			this.setData({'nombreparticipantes': idcurp,
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
	/*//DEPORTISTAS
	if (modalidad=='DEPORTISTA' || modalidad=='ENTRENADOR' || modalidad=='AUXILIAR' || modalidad=='DELEGADO POR DEPORTE' || modalidad=='JUEZ'){		 
		 GrabarDeportista();	 	 
	}
	
	//COMITE ORGANIZADOR
	if (modalidad=='COMIT\u00C9 ORGANIZADOR' || modalidad=='COMITE ORGANIZADOR' || modalidad=='PRENSA'){	
		 GrabarComiteOrganizador();	 	 	 
	}
	
	//DELEGADO, DELEGADO GENERAL
	if (modalidad=='DELEGADO' || modalidad=='DELEGADO GENERAL'){		  	    
		 GrabarDelegado();	 	 	 
	}
	
	//ELIGE
	if (modalidad=='ELIGE'){		  	    
		 $("#deportes").removeClass("validate[required]");
		 $("#selectcategoria").removeClass("validate[required]");		   
		 $("#deportes_extras").removeClass("validate[required]");
		 $("#cargo").removeClass("validate[required]");		  
		 $("#prensa").removeClass("validate[required]");		  
	}*/
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
	   arraylistacategoria.push(modalidad+'<ev>'+deporte+'<ev>'+categoria+'<ev>'+pruebas+'<ev>'+cargo_prensa);					
	   lista_modalidad_categorias = arraylistacategoria.join('<evp>');  
	}else{							
	   var listacategoria= $("#listcategoria").jqGrid('getRowData');		
	   var arraylistacategoria = new Array();
	   for(var i=0;i<listacategoria.length;i++){			
		  arraylistacategoria.push(listacategoria[i].claves);			
	   }		
	   lista_modalidad_categorias = arraylistacategoria.join('<evp>');					
	}	
	
	$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarParticipante.php",
		 processData: true,
		 dataType: "json",		 
		 data: "lista_modalidad_categorias="+lista_modalidad_categorias+"&participante_sel="+participante_sel+DatosComunes(),
		 beforeSend: function(){JSBlockUI('Grabando Deportista...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){ desplegarstaturegistro(data); limpiarparticipante(); limpiargenerales();}},
		 timeout: 80000
	});		
}

function GrabarComiteOrganizador()
{	
	var grabar_lista_categoria = 'null';
	var grabar_lista_pruebas = 'null';
	var grabar_lista_nom_categoria = 'null';	
	var nomevento = $("#evento option[value="+$('#evento').val()+"]").text();
	var nommunicipio = $("#municipio option[value="+$('#municipio').val()+"]").text();
	var nommodalidad = $("#modalidad option[value="+$('#modalidad').val()+"]").text();	
	var cargo = $("#cargo").val();
	var prensa = $("#prensa").val();
	var deporteextra ='null';
	
	$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarComiteOrganizador.php",
		 processData: true,
		 dataType: "json",		 
		 data: "deporteextra="+deporteextra+"&prensa="+prensa+"&cargo="+cargo+"&nommunicipio="+nommunicipio+"&nommodalidad="+nommodalidad+"&nomevento="+nomevento+"&lista_categoria="+grabar_lista_categoria+"&lista_pruebas="+grabar_lista_pruebas+"&lista_nom_categoria="+grabar_lista_nom_categoria+"&participante_sel="+participante_sel+DatosComunes(),
		 beforeSend: function(){JSBlockUI('Grabando Comit&eacute; Organizador...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)) desplegadoerrores(data);},
		 timeout: 80000
	});	
}


function GrabarDelegado()
{	
	var grabar_lista_categoria = 'null';
	var grabar_lista_pruebas = 'null';
	var grabar_lista_nom_categoria = 'null';	
	var nomevento = $("#evento option[value="+$('#evento').val()+"]").text();
	var nommunicipio = $("#municipio option[value="+$('#municipio').val()+"]").text();
	var nommodalidad = $("#modalidad option[value="+$('#modalidad').val()+"]").text();	
	var cargo = 'null';	
	var deporteextra ='null';
	
	$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarDelegado.php",
		 processData: true,
		 dataType: "json",		 
		 data: "deporteextra="+deporteextra+"&cargo="+cargo+"&nommunicipio="+nommunicipio+"&nommodalidad="+nommodalidad+"&nomevento="+nomevento+"&lista_categoria="+grabar_lista_categoria+"&lista_pruebas="+grabar_lista_pruebas+"&lista_nom_categoria="+grabar_lista_nom_categoria+DatosComunes(),
		 beforeSend: function(){JSBlockUI('Grabando Delegado...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)) desplegadoerrores(data);},
		 timeout: 80000
	});	
}


function GrabarTodoMas()
{	
	var grabar_lista_categoria = 'null';
	var grabar_lista_pruebas = 'null';
	var grabar_lista_nom_categoria = 'null';	
	var nomevento = $("#evento option[value="+$('#evento').val()+"]").text();
	var nommunicipio = $("#municipio option[value="+$('#municipio').val()+"]").text();
	var nommodalidad = $("#modalidad option[value="+$('#modalidad').val()+"]").text();	
	var deporteextra = $("#deportes_extras").val();	
	var cargo ='null';
	
	$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarTodoMas.php",
		 processData: true,
		 dataType: "json",		 
		 data: "deporteextra="+deporteextra+"&cargo="+cargo+"&nommunicipio="+nommunicipio+"&nommodalidad="+nommodalidad+"&nomevento="+nomevento+"&lista_categoria="+grabar_lista_categoria+"&lista_pruebas="+grabar_lista_pruebas+"&lista_nom_categoria="+grabar_lista_nom_categoria+DatosComunes(),
		 beforeSend: function(){JSBlockUI('Grabando Participante...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)) desplegadoerrores(data);},
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
	   
	 /*var municipio_registro_text = $("#municipio option[value="+$('#municipio').val()+"]").text();  
	 
	 $('#lista_registro').prepend(''
	  +'<tr>'
	  +     '<td style="display:none;">'+data.id_registro+'</td>'
	  +     '<td style="display:none;">'+data.id_evento+'</td>'
	  +     '<td style="display:none;">'+$('#municipio').val()+'</td>'
	  +     '<td style="display:none;">'+data.id_modalidad+'</td>'
	  +     '<td style="display:none;">'+$('#direccion').val()+'</td>'
	  +     '<td style="display:none;">'+$('#colonia').val()+'</td>'
	  +     '<td style="display:none;">'+$('#localidad').val()+'</td>'
	  +     '<td style="display:none;">'+$('#codigopostal').val()+'</td>'
	  +     '<td style="display:none;">'+$('#telefonos').val()+'</td>'
	  +     '<td style="display:none;">'+$('#correo').val()+'</td>'
	  +     '<td style="display:none;">'+$('#peso').val()+'</td>'
	  +     '<td style="display:none;">'+$('#talla').val()+'</td>'
	  +     '<td style="display:none;">'+$('#rfc').val()+'</td>'
	  +     '<td style="display:none;">'+$('#tiposanguineo').val()+'</td>'
	  +     '<td><ul style="list-style:none;"><li style="float:left;">'+'<img src="../img/'+data.logoeventos+'_8.png" /></li><li style="float:left;">'+$("#evento option[value="+$('#evento').val()+"]").text()+'</li></ul></td>'
	  +     '<td>'+municipio_registro_text+'</td>'
	  +     '<td>'+deporte_registro+'</td>'
	  +     '<td><ul style="list-style:none;"><li style="float:left;">'+'<img src="../img/'+data.logoparticipante+'_8.png" /></li><li style="float:left;">'+$('#curp').val()+'</li></ul></td>'
	  +     '<td>'+acentos($('#nombres').val().toUpperCase())+' '
	  +            acentos($('#appaterno').val().toUpperCase())+' '
	  +            acentos($('#apmaterno').val().toUpperCase())
	  +            '</td>'
	  +     '<td><ul style="list-style:none;"><li style="float:left;">'+'<img src="../img/'+data.logomodalidad+'_8.png" /></li><li style="float:left;">'+$("#modalidad option[value="+$('#modalidad').val()+"]").text()+'</li></ul></td>'
	  +     '<td>'+tabla_categoria_registro+'</td>'	  
	  +'</tr>');
	
	 colorceldas('lista_registro');*/
	 /*colorceldas_dos($('#curp').val()+lista_categorias_tabla_registro);*/	 
 }

function acentos(cad)
{
	arrayacentos = cad.split(' ');	
	
	$.each(arrayacentos,function(iacentos,dataacentos){
	  $.each(arrhtml,function(ihtml,datahtml){	
		if(dataacentos.indexOf(datahtml) > -1) {			   
		   arrayacentos[iacentos] = arrayacentos[iacentos].replace(datahtml,arruni[iacentos]);		 
	    }		    
	  });  
	});
				
	var newcad = '';			
	$.each(arrayacentos,function(i,data){
	  newcad += arrayacentos[i] + ' ';  
	  
	});	
	return newcad.substr(0,newcad.length-1);
}

/*function autocomplet(data)
    {
	 $("#nombres").autocomplete(data.items, {
		minChars: 1,
		width: 810,	
		matchContains: "word",
		autoFill: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + acentos(row.nombre.toUpperCase()) + " " + acentos(row.appaterno.toUpperCase()) + " " + acentos(row.apmaterno.toUpperCase()) + "\" [" + row.curp + "]" + " \"" + acentos(row.deporte) + "\""+" \""+acentos(row.categoria)+"\"" + " \"" + acentos(row.modalidad) + "\"" ;
		},
		formatMatch: function(row, i, max) {
			return row.curp + " " + row.nombre + " " + row.appaterno + " " + row.apmaterno;
		},
		formatResult: function(row) {			    
			return row.nombre;
		}
	  }).result(function(event, row, formatted) {        
	        $('#nombres').val(acentos(row.nombre.toUpperCase()));
            $('#appaterno').val(acentos(row.appaterno.toUpperCase()));			
            $('#apmaterno').val(acentos(row.apmaterno.toUpperCase()));
			var fecha = Array();
			fecha = row.fechanac.split('-');
            $('#fechanacimiento').val(fecha[2]+"-"+fecha[1]+"-"+fecha[0]);
			$('#entidad').val(row.curp.substr(11,2));
			$('#sexo').val(row.curp.substr(10,1));
			$('#curp').val(row.curp);			
        });
	 
	 $("#appaterno").autocomplete(data.items, {
		minChars: 0,
		width: 810,	
		matchContains: "word",
		autoFill: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + acentos(row.nombre.toUpperCase()) + " " + acentos(row.appaterno.toUpperCase()) + " " + acentos(row.apmaterno.toUpperCase()) + "\" [" + row.curp + "]" + " \"" + acentos(row.deporte) + "\""+" \""+acentos(row.categoria)+"\"" + " \"" + acentos(row.modalidad) + "\"" ;
		},
		formatMatch: function(row, i, max) {
			return row.curp + " " + row.nombre + " " + row.appaterno + " " + row.apmaterno;
		},
		formatResult: function(row) {			    
			return row.appaterno;
		}
	  }).result(function(event, row, formatted) {  
	        $('#nombres').val(acentos(row.nombre.toUpperCase()));
	        $('#appaterno').val(acentos(row.appaterno.toUpperCase()));            
            $('#apmaterno').val(acentos(row.apmaterno.toUpperCase()));
			var fecha = Array();
			fecha = row.fechanac.split('-');
            $('#fechanacimiento').val(fecha[2]+"-"+fecha[1]+"-"+fecha[0]);
			$('#entidad').val(row.curp.substr(11,2));
			$('#sexo').val(row.curp.substr(10,1));
			$('#curp').val(row.curp);
        });
    }
*/	
/*function despliegacategoria(data)
    {
		$('#categoria_buscar').html(data);				
	}	*/
	
function despliegapruebas_registro(data)
{
	/*var modalidad_registro = $("#modalidad_registro option[value="+$('#modalidad_registro').val()+"]").text().toUpperCase();	
	if(modalidad_registro == 'DEPORTISTA' ){*/	
	$('#categoria_registro').html(data);
	$("#selectcategoria_registro option[value='"+$("#selectcategoria_registro :contains('General')").val()+"']").remove();  			
	/*}
	if(modalidad_registro == 'ENTRENADOR' || modalidad_registro == 'AUXILIAR' || modalidad_registro == 'DELEGADO POR DEPORTE' || modalidad_registro == 'JUEZ'){
	  $("#selectcategoria_registro :contains('General')").attr("selected", "selected");
	  $("#selectcategoria_registro").attr("disabled", "disabled");	
	}*/
}
	
function despliegapruebas(data)
{
	$('#categoria').html(data);		
	$('#pruebas').html('');	
	if(modalidad == 'DEPORTISTA' ){			
	  $("#selectcategoria option[value='"+$("#selectcategoria :contains('General')").val()+"']").remove(); 
	  $('#selectcategoria').change(function(){    		
	   $('#sinpruebas').attr('checked', false);										
	   if($('#selectcategoria').val() != ''){									  
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
	}else{
	  $("#selectcategoria :contains('General')").attr("selected", "selected");
	  $("#selectcategoria").attr("disabled", "disabled");
	}
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
		/*$('#evento').val('');	
		$('#municipio').val('');	
		$('#modalidad').val('');
		$('#deportes_extras').val('');
		$('#div_deportes_extras').css('display','none');*/
		$('#cargo').val('');
		$('#prensa').val('');
		/*$('#div_cargo').css('display','none');*/		
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



/*function agregarcategoria()
	{
	  
	  lista_pruebas = '';
	  $('#pruebas_check :checkbox').each(function(i){
        if($(this).is(":checked"))
		{
		  lista_pruebas += ap[i]+', ';			  
		}
       });		
	   
	   var idcategoria_reg = $('#selectcategoria').val();
	   var iddeporte_reg = $('#deportes').val();
	   var categoria_text = $("#selectcategoria option[value="+idcategoria_reg+"]").text();
	   var deportes_text = $("#deportes option[value="+iddeporte_reg+"]").text();
	   
	   $("#lista_categorias").prepend('<tr id="'+idcategoria_reg+'"><td style="display:none;">'+idcategoria_reg+'</td><td>'+deportes_text+'</td><td>'+categoria_text+'</td><td>'+lista_pruebas.substr(0,lista_pruebas.length-2)+'</td><td><img style="vertical-align:middle; cursor:pointer;" onclick = "javascript:eliminarcategoria(\''+idcategoria_reg+'\');" src="../img/icons/delete.png"/></td</tr>');	
	   
	   colorceldas('lista_categorias');
	}*/	
function CargarDatosParticipante_Editar(data)
{	
     var contmodcat = 0;	
	 $.each(data.items, function(i,item){
		idregistro = item.idregistro;						 
		$('#nombres').val(item.nombre);
		$('#curp').val(item.curp);
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
		/*arraymc = item.modalidadcategoria;*/		
		/*if(arraymc.length>0){*/
		//deportista, entrenadores, auxiliares, delegado por deporte		   
		$("#listcategoria").jqGrid('clearGridData');
		$.each(item.modalidadcategoria, function(i,itemmc){
			var modalidad = itemmc.modalidad.toUpperCase();									 
			if(modalidad == 'DEPORTISTA' || modalidad == 'ENTRENADOR' || modalidad == 'AUXILIAR' || modalidad == 'DELEGADO POR DEPORTE' || modalidad == 'JUEZ'){														 
			  if (modalidad=='DEPORTISTA'){  	  
				var claves = itemmc.idmodalidad+'<ev>'+itemmc.iddeporte+'<ev>'+itemmc.idcategoria+'<ev>'+itemmc.pruebas+'<ev>null';
			  }else{	  		  
				pruebas = '';
				var claves = itemmc.idmodalidad+'<ev>'+itemmc.iddeporte+'<ev>'+itemmc.idcategoria+'<ev>null<ev>null';	
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
			  
			  if(modalidad == 'ENTRENADOR' || modalidad == 'AUXILIAR' || modalidad == 'DELEGADO POR DEPORTE' || modalidad == 'JUEZ')
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
		});		
		/*}else{	
		}*/	
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

/*function erroreliminar()
    {
		$.growlUI('No se realizo la eliminaci&oacute;n','Servicio suspendido, contacte al administrador...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
	}*/
/*function categoriaeliminado(id)
    {	
		$.growlUI('Se ha eliminado la categoria','Eliminaci&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		$('#'+id).remove();
		colorceldas();
	}*/
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
	


