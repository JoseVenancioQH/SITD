//************************************************************************************
$().ready(function(){				   
	$("#grabar-deportes").validationEngine({			
	 inlineValidation: true,     
     success : function() { if(!status)GrabarDeportes(); else ActualizarDeportes();}, 
     failure : function() {} 
    });	
	
	GenerarLista_Deportes();	
});
//************************************************************************************
jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
var status = false;
var id_editar = 0;

function GenerarLista_Deportes()
    {		
		$.ajax({
		 type: "POST",
		 url: "../scripts/GenerarLista_Deportes.php",
		 processData: false,
		 dataType: "html",		 		 
		 beforeSend: function(){},
		 success: function(data){GenerarLista(data);}		 
	    });
		
		
	}
	
function GenerarLista(datos)
    {
		$('#lista_deportes').html(datos);
		colorceldas();
	}

function GrabarDeportes()
	{		
		var nombre = $('#nombre-text').val();		
		
		$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarDeportes.php",
		 processData: false,
		 dataType: "html",		 
		 data:"nombre-text="+nombre,
		 beforeSend: function(){JSBlockUI('Grabar Deportes','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(jQuery.trim(data)=='no') error(); else agregardeporte(data);}},
		 timeout: 80000
	 });	
	}
function agregardeporte(agregado)
	{
		$("#lista_deportes").prepend(agregado);		
		$.growlUI('Se ha registrado un deporte','Registro Exitoso...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		colorceldas();		
		$('#grabar-deportes').reset();
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
	
/*---------------------inicio eliminacion de deporte-------------------------*/
function eliminardeporte(id)
    {		
		$.ajax({
		 type: "POST",
		 url: "../scripts/EliminarDeportes.php",
		 processData: false,
		 dataType: "html",		 
		 data:"id="+id,
		 beforeSend: function(){JSBlockUI('Eliminar Deportes','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') erroreliminar(); else deporteeliminado(id);}},
		 timeout: 80000
	    });		
	}	

function erroreliminar()
    {
		$.growlUI('No se realizo la eliminaci&oacute;n','Servicio suspendido, contacte al administrador...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
	}
function deporteeliminado(id)
    {	
		$.growlUI('Se ha eliminado el deporte','Eliminaci&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		$('#'+id).remove();
		colorceldas();
	}
/*---------------------fin eliminacion de deporte-------------------------*/	

/*---------------------inicio actualizacion de deporte-------------------------*/	
function ActualizarDeportes()
    {
		var nombre = $('#nombre-text').val();		
		
		$.ajax({
		 type: "POST",
		 url: "../scripts/EditarDeportes.php",
		 processData: false,
		 dataType: "html",		 
		 data:"nombre-text="+nombre+"&id="+id_editar,
		 beforeSend: function(){JSBlockUI('Editar Deportes','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') erroreditar(); else deporteeditado(id_editar,nombre);}},
		 timeout: 80000
	    });	
	}
function editardeporte(id)
    { 	
	    colorceldas();
		status=true;
		id_editar=id;
		$('#nombre-text').val($('#'+id_editar).children('td').eq(0).html());
		$('#'+id).css("background","#FFFF33");		
		$('#grabar_deportes_buttom').val('Editar Deporte');
		$('#nombre-text').focus();
		
	}	
function erroreditar()
    {
		$.growlUI('No se realizo la edici&oacute;n','Ninguna afectaci&oacute;n a los datos...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
		status = false;
		colorceldas();
		$('#grabar_deportes_buttom').val('Grabar Deporte');
		$('#grabar-deportes').reset();
		$('#nombre-text').focus();
	}
function deporteeditado(id,data)
    {	
		$.growlUI('Se ha realizado la edici&oacute;n','Edici&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		$('#'+id).children('td').eq(0).html(data);
		status = false;
		colorceldas();
		$('#grabar_deportes_buttom').val('Grabar Deporte');
		$('#grabar-deportes').reset();
		$('#nombre-text').focus();
	}	
/*---------------------fin actualizacion de deporte-------------------------*/		
	