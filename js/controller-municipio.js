//************************************************************************************
$().ready(function(){				   
	$("#grabar-municipio").validationEngine({			
	 inlineValidation: true,     
     success : function() { if(!status)GrabarMunicipio(); else ActualizarMunicipio();}, 
     failure : function() {} 
    });	
	
	GenerarLista_Municipio();	
});
//************************************************************************************
jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
var status = false;
var id_editar = 0;

function GenerarLista_Municipio()
    {		
		$.ajax({
		 type: "POST",
		 url: "../scripts/GenerarLista_Municipio.php",
		 processData: false,
		 dataType: "html",		 		 
		 beforeSend: function(){},
		 success: function(data){GenerarLista(data);}		 
	    });
		
		
	}
	
function GenerarLista(datos)
    {
		$('#lista_municipio').html(datos);
		colorceldas();
	}

function GrabarMunicipio()
	{		
		var nombre = $('#nombre-text').val();		
		
		$.ajax({
		 type: "POST",
		 url: "../scripts/GrabarMunicipio.php",
		 processData: false,
		 dataType: "html",		 
		 data:"nombre-text="+nombre,
		 beforeSend: function(){JSBlockUI('Grabando Municipio...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') error(); else agregarmunicipio(data);}},
		 timeout: 80000
	 });	
	}
function agregarmunicipio(agregado)
	{
		$("#lista_municipio").prepend(agregado);		
		$.growlUI('Se ha registrado una municipio','Registro Exitoso...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		colorceldas();		
		$('#grabar-municipio').reset();
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
	
/*---------------------inicio eliminacion de municipio-------------------------*/
function eliminarmunicipio(id)
    {		
		$.ajax({
		 type: "POST",
		 url: "../scripts/EliminarMunicipio.php",
		 processData: false,
		 dataType: "html",		 
		 data:"id="+id,
		 beforeSend: function(){JSBlockUI('Eliminar Municipio','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') erroreliminar(); else municipioeliminado(id);}},
		 timeout: 80000
	    });		
	}	

function erroreliminar()
    {
		$.growlUI('No se realizo la eliminaci&oacute;n','Servicio suspendido, contacte al administrador...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
	}
function municipioeliminado(id)
    {	
		$.growlUI('Se ha eliminado la municipio','Eliminaci&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		$('#'+id).remove();
		colorceldas();
	}
/*---------------------fin eliminacion de municipio-------------------------*/	

/*---------------------inicio actualizacion de municipio-------------------------*/	
function ActualizarMunicipio()
    {
		var nombre = $('#nombre-text').val();		
		
		$.ajax({
		 type: "POST",
		 url: "../scripts/EditarMunicipio.php",
		 processData: false,
		 dataType: "html",		 
		 data:"nombre-text="+nombre+"&id="+id_editar,
		 beforeSend: function(){JSBlockUI('Editando Municipio...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') erroreditar(); else municipioeditado(id_editar,nombre);}},
		 timeout: 80000
	    });	
	}
function editarmunicipio(id)
    { 	
	    colorceldas();
		status=true;
		id_editar=id;
		$('#nombre-text').val($('#'+id_editar).children('td').eq(0).html());
		$('#'+id).css("background","#FFFF33");		
		$('#grabar_municipio_buttom').val('Editar Municipio');
		$('#nombre-text').focus();
		
	}	
function erroreditar()
    {
		$.growlUI('No se realizo la edici&oacute;n','Ninguna afectaci&oacute;n a los datos...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
		status = false;
		colorceldas();
		$('#grabar_municipio_buttom').val('Grabar Municipio');
		$('#grabar-municipio').reset();
		$('#nombre-text').focus();
	}
function municipioeditado(id,data)
    {	
		$.growlUI('Se ha realizado la edici&oacute;n','Edici&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		$('#'+id).children('td').eq(0).html(data);
		status = false;
		colorceldas();
		$('#grabar_municipio_buttom').val('Grabar Municipio');
		$('#grabar-municipio').reset();
		$('#nombre-text').focus();
	}	
/*---------------------fin actualizacion de municipio-------------------------*/		
	