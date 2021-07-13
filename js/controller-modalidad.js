//************************************************************************************
$().ready(function(){				   
	$("#grabar-modalidad").validationEngine({			
	 inlineValidation: true,     
     success : function() { if(!status)GrabarModalidad(); else ActualizarModalidad();}, 
     failure : function() {} 
    });	
	
	GenerarLista_Modalidad();	
});
//************************************************************************************
jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
var status = false;
var id_editar = 0;

function GenerarLista_Modalidad()
    {		
		$.ajax({
		 type: "POST",
		 url: "../scripts/GenerarLista_Modalidad.php",
		 processData: false,
		 dataType: "html",		 		 
		 beforeSend: function(){},
		 success: function(data){GenerarLista(data);}		 
	    });
		
		
	}
	
function GenerarLista(datos)
    {
		$('#lista_modalidad').html(datos);
		colorceldas();
	}

function GrabarModalidad()
	{		
		var nombre = $('#nombre-text').val();		
		
		$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarModalidad.php",
		 processData: false,
		 dataType: "html",		 
		 data:"nombre-text="+nombre,
		 beforeSend: function(){JSBlockUI('Garbando Modalidad...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') error(); else agregarmodalidad(data);}},
		 timeout: 80000
	 });	
	}
	
function agregarmodalidad(agregado)
	{
		$("#lista_modalidad").prepend(agregado);		
		$.growlUI('Se ha registrado una modalidad','Registro Exitoso...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		colorceldas();		
		$('#grabar-modalidad').reset();
		$('#nombre-text').focus();
		
	}
	
function error()
	{
		$.growlUI('No se realizo el registro','Registro Duplicado...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
	}		

function colorceldas()
    {
		$("tr:even").css("background-color", "#CCCCCC");
	    $("tr:odd").css("background-color", "#EFF1F1");
	}
	
/*---------------------inicio eliminacion de modalidad-------------------------*/
function eliminarmodalidad(id)
    {		
		$.ajax({
		 type: "POST",
		 url: "../scripts/EliminarModalidad.php",
		 processData: false,
		 dataType: "html",		 
		 data:"id="+id,
		 beforeSend: function(){JSBlockUI('Eliminando Modalidad','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') erroreliminar(); else modalidadeliminado(id);}},
		 timeout: 80000
	    });		
	}	

function erroreliminar()
    {
		$.growlUI('No se realizo la eliminaci&oacute;n','Servicio suspendido, contacte al administrador...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
	}
function modalidadeliminado(id)
    {	
		$.growlUI('Se ha eliminado la modalidad','Eliminaci&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		$('#'+id).remove();
		colorceldas();
	}
/*---------------------fin eliminacion de modalidad-------------------------*/	

/*---------------------inicio actualizacion de modalidad-------------------------*/	
function ActualizarModalidad()
    {
		var nombre = $('#nombre-text').val();		
		
		$.ajax({
		 type: "POST",
		 url: "../scripts/EditarModalidad.php",
		 processData: false,
		 dataType: "html",		 
		 data:"nombre-text="+nombre+"&id="+id_editar,
		 beforeSend: function(){JSBlockUI('Editando Modalidad...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') erroreditar(); else modalidadeditado(id_editar,nombre);}},
		 timeout: 80000
	    });	
	}
function editarmodalidad(id)
    { 	
	    colorceldas();
		status=true;
		id_editar=id;
		$('#nombre-text').val($('#'+id_editar).children('td').eq(0).html());
		$('#'+id).css("background","#FFFF33");		
		$('#grabar_modalidad_buttom').val('Editar Modalidad');
		$('#nombre-text').focus();
		
	}	
function erroreditar()
    {
		$.growlUI('No se realizo la edici&oacute;n','Ninguna afectaci&oacute;n a los datos...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
		status = false;
		colorceldas();
		$('#grabar_modalidad_buttom').val('Grabar Modalidad');
		$('#grabar-modalidad').reset();
		$('#nombre-text').focus();
	}
function modalidadeditado(id,data)
    {	
		$.growlUI('Se ha realizado la edici&oacute;n','Edici&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		$('#'+id).children('td').eq(0).html(data);
		status = false;
		colorceldas();
		$('#grabar_modalidad_buttom').val('Grabar Modalidad');
		$('#grabar-modalidad').reset();
		$('#nombre-text').focus();
	}	
/*---------------------fin actualizacion de modalidad-------------------------*/		
	