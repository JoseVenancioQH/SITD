jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
var status = false;
var idevento_global = 0;
var status_actualizado = '';

var nombre_actualizar = '';
var coordina_actualizar = '';
var sede_actualizar = '';
var caracteristicas_actualizar = '';
var fechainicio_actualizar = '';
var fechafin_actualizar = '';
var ano_actualizar = '';

//************************************************************************************
jQuery(function($){
   $("#fechainicio").mask("99-99-9999");
   $("#fechafin").mask("99-99-9999");
});

$().ready(function(){					   
	$("#listeventos").jqGrid({
			url:'../scripts/GeneraEventos.php?tipo_consulta=1',
			datatype: "json",
			height: 250,					
			colNames:['Status','Editar','Nombre Evento','Coordinador','Sede','Caracteristicas','Fecha Ini.','Fecha Fin.','Ano'],
			colModel:[{name:'status',index:'status', classes:'jqgrid uppercasecss bold', width:50},
					  {name:'editar',index:'editar', classes:'jqgrid uppercasecss bold', width:50},
					  {name:'nombre',index:'nombre', classes:'jqgrid uppercasecss bold', width:200},
					  {name:'coordinador',index:'coordinador', classes:'jqgrid uppercasecss bold', width:110},
					  {name:'sede',index:'sede', classes:'jqgrid uppercasecss bold', width:110},
					  {name:'caracteristicas',index:'caracteristicas', classes:'jqgrid uppercasecss bold', width:110},
					  {name:'fechaini',index:'fechaini', classes:'jqgrid uppercasecss bold', width:90},
					  {name:'fechafin',index:'fechafin', classes:'jqgrid uppercasecss bold', width:90},
					  {name:'ano',index:'ano', width:135}],					  
			rowNum:0,						
			mtype: "POST",
			pager: $('#listeventospager'),			
			sortname: 'nombre',
			pgbuttons: false,
   	        pgtext: true,						
   	        pginput:false,						
			viewrecords: true,
			sortorder: "asc",			
			caption: "Eventos Registrados"
	});			   
	
	$("#grabar-evento").validationEngine({	
						 promptPosition: "topRight", 										   
						 inlineValidation: false,     
						 success : function() {if(!status){GrabarEvento();}else{ActualizarEvento();}}, 
						 failure : function() {var sliderIntervalID = setInterval(function(){$.validationEngine.closePrompt(".formError", true);clearInterval(sliderIntervalID);},10000);} 
    });
			   
	$('#fechafin').DatePicker({
					format:'d-m-Y', 
					date: $('#fechafin').val(),
					current: $('#fechafin').val(),
					starts: 1,
					position: 'r',
					onBeforeShow: function(){
					$('#fechafin').DatePickerSetDate($('#fechafin').val(), true);
			},
					onChange: function(formated, dates){
					$('#fechafin').val(formated);		
					$('#fechafin').DatePickerHide();		
			}
	});
	
	$('#fechainicio').DatePicker({
					format:'d-m-Y',
					date: $('#fechainicio').val(),
					current: $('#fechainicio').val(),
					starts: 1,
					position: 'top',
					onBeforeShow: function(){
					$('#fechainicio').DatePickerSetDate($('#fechainicio').val(), true);
			},
					onChange: function(formated, dates){
					$('#fechainicio').val(formated);		
					$('#fechainicio').DatePickerHide();		
			}
	});
	
	
	
});
//************************************************************************************
function RegistrarEvento_submit()
	{		
		$('#grabar-evento').submit();										 
	}
	
function ActualizarEvento_submit()
	{		
		$('#grabar-evento').submit();										 
	}	

function ActualizarEvento()
{
	nombre_actualizar = $('#nombre-text').val();
	coordina_actualizar = $('#coordina-text').val();
	sede_actualizar = $('#sede-text').val();
	caracteristicas_actualizar = $('#caracteristicas-text').val();
	fechainicio_actualizar = $('#fechainicio').val();
	fechafin_actualizar = $('#fechafin').val();
	ano_actualizar = $('#ano-text').val();
	
	unBlockSucces = true;
	$.ajax({
	 type: "POST",
	 url: "../scripts/ActualizarEvento.php",		 
	 processData: false,
	 dataType: "html",		 
	 data:"nombre-text="+nombre_actualizar+"&coordina-text="+coordina_actualizar+"&sede-text="+sede_actualizar+"&caracteristicas-text="+caracteristicas_actualizar+"&fechainicio="+fechainicio_actualizar+"&fechafin="+fechafin_actualizar+"&ano-text="+ano_actualizar+"&idevento="+idevento_global,
	 beforeSend: function(){JSBlockUI('Actualizar Evento...','80000');},
	 success: function(data){if(unJSBlockUI(data)) eventoactualizado()},
	 timeout: 80000
    });
}

function GrabarEvento()
{
	var nombre = $('#nombre-text').val();
	var coordina = $('#coordina-text').val();
	var sede = $('#sede-text').val();
	var caracteristicas = $('#caracteristicas-text').val();
	var fechainicio = $('#fechainicio').val();
	var fechafin = $('#fechafin').val();
	var ano = $('#ano-text').val();
	unBlockSucces = true;
	$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarEvento.php",		 
		 processData: false,
		 dataType: "html",		 
		 data:"nombre-text="+nombre+"&coordina-text="+coordina+"&sede-text="+sede+"&caracteristicas-text="+caracteristicas+"&fechainicio="+fechainicio+"&fechafin="+fechafin+"&ano-text="+ano,
		 beforeSend: function(){JSBlockUI('Grabando Evento...','80000');},
		 success: function(data){if(unJSBlockUI(data)) eventoregistrado()},
		 timeout: 80000
    });	 
}  

function eventoregistrado()
{
	$.growl.settings.displayTimeout = 8000;
	$.growl('Evento', 'Evento Registrado Correcto', '../img/button_ok_25.png', 'high');			
	$('#grabar-evento').reset();
}

function eventoactualizado()
{
	$.growl.settings.displayTimeout = 8000;
	$.growl('Evento', 'Evento Actualizado Correcto', '../img/button_ok_25.png', 'high');	
	
	$("#listeventos").jqGrid('setRowData',idevento_global,{nombre:nombre_actualizar,coordinador:coordina_actualizar,sede:sede_actualizar,caracteristicas:caracteristicas_actualizar,fechaini:fechainicio_actualizar,fechafin:fechafin_actualizar,ano:ano_actualizar});
	
	$('#actualizar_evento_div').css('display','none');
	$('#cancelar_actualizar_evento_div').css('display','none');
	$('#registrar_evento_div').css('display','inline');
	
	status = true;
	
	$('#grabar-evento').reset();
}

function editarevento(id)
{	    
	var rowData = $("#listeventos").jqGrid('getRowData',id);
	$('#nombre-text').val(rowData.nombre);
	$('#coordina-text').val(rowData.coordinador);
	$('#sede-text').val(rowData.sede);
	$('#caracteristicas-text').val(rowData.caracteristicas);
	$('#fechainicio').val(rowData.fechaini);
	$('#fechafin').val(rowData.fechafin);
	$('#ano-text').val(rowData.ano);
	
	$('#actualizar_evento_div').css('display','inline');
	$('#cancelar_actualizar_evento_div').css('display','inline');
	$('#registrar_evento_div').css('display','none');
	
	idevento_global = id;
	
	status = true;
}

function CancelarActualizarEvento()
{
	$('#actualizar_evento_div').css('display','none');
	$('#cancelar_actualizar_evento_div').css('display','none');
	$('#registrar_evento_div').css('display','inline');	
	status = true;	
	$('#grabar-evento').reset();
}
	
function cambiarstatus(id,status)
{	
  status_actualizado = status;
  idevento_global = id;
  $.ajax({
	   type: "POST",
	   url: "../scripts/CambiarStatusEvento.php",		 
	   processData: false,
	   dataType: "html",		 
	   data:"status="+status+"&idevento="+id,
	   beforeSend: function(){JSBlockUI('Cambiar Status Evento...','80000');},
	   success: function(data){if(unJSBlockUI(data)) statuscambiado(data)},
	   timeout: 80000
  });
}

function statuscambiado(data)
{
	
	if(data == 'activo'){status_actualizado = 'inactivo'; var icon_activado = '../img/icons/accept.png';}
	if(data == 'inactivo'){status_actualizado = 'activo'; var icon_activado = '../img/icons/delete.png';}
	
	$.growl.settings.displayTimeout = 8000;
	$.growl('Evento', 'Estado del Evento Actualizado', '../img/button_ok_25.png', 'high');	

	$("#listeventos").jqGrid('setRowData',idevento_global,{status:"<img id='activado"+idevento_global+"' style='vertical-align:middle; cursor:pointer;' src='"+icon_activado+"' onclick='javascript:cambiarstatus(\""+idevento_global+"\",\""+data+"\");'/>"});
	
}
