jQuery(function($){
   $("#anoinicio").mask("wxy9");
   $("#anofin").mask("wxy9");
});

//************************************************************************************
var contador = 0;
var ap = new Array();
var statususuario = 'desactivado';

$().ready(function(){	
				   
	$("#grabar-categoria").validationEngine({			
	 inlineValidation: true,     
     success : function() {if(!status)GrabarCategoria(); else ActualizarCategoria();}, 
     failure : function() {} 
    });	
	
	$("#agregar-prueba").click(function (){	
		if($('#pruebas').val()!=''){
				 contador++;						 
	             $("#lista_pruebas").append('<li id =\''+contador+'\' style="margin-left: 10px; margin-top: 10px; float:left; width:20%; height:auto; border-bottom:1px solid #CCCCCC;"><img style=\"vertical-align:middle; cursor:pointer;\" src="../img/icons/delete.png" onclick="javascript:borrar(\''+contador+'\');"/>'+$('#pruebas').val()+'</li>');
				 
		$('#listapruebas').val('');		
		$('#lista_pruebas li').each(function(){
        $('#listapruebas').val($('#listapruebas').val() + $(this).text() + ',');		
        });      
	   }
    });	
	
		
	
	$('#anoinicio').keypress(function(e,keyCode){
									  
	});
	
	$('#pruebas').keypress(function(e,keyCode) {									
									
			if(e.keyCode == 13)
			{
	           if($('#pruebas').val()!=''){
	             contador++;						 
	             $("#lista_pruebas").append('<li id =\''+contador+'\' style="margin-left: 10px; margin-top: 10px; float:left; width:20%; height:auto; border-bottom:1px solid #CCCCCC;"><img style=\"vertical-align:middle; cursor:pointer;\" src="../img/icons/delete.png" onclick="javascript:borrar(\''+contador+'\');"/>'+$('#pruebas').val()+'</li>');
				 
		         $('#listapruebas').val('');		
		         $('#lista_pruebas li').each(function(){
                 $('#listapruebas').val($('#listapruebas').val() + $(this).text() + ',');		
                 });	
				 return false;
			  }
			  else
			  {
				 return false;
			  }
				 
			}			
					
			if(e.which == 44)
			{
				return false; 
			}
			
	});	
	
	//GenerarLista_Categoria();
	
});
//************************************************************************************

jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
var status = false;
var id_editar = 0;

function GrabarCategoria()
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
		 url: "../scripts/GrabarCategoria.php",
		 processData: false,
		 dataType: "html",
		 data:"evento="+evento+"&iddeporte="+iddeporte+"&nombrecat="+nombrecat+"&anoinicio="+anoinicio+"&anofin="+anofin+"&listapruebas="+listapruebas+"&rama="+rama+"&evento_text="+evento_text+"&deporte_text="+deporte_text+"&idusuario="+idusuario,
		 beforeSend: function(){JSBlockUI('Generando Categorias...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') error(); else agregarcategoria(data);}},
		 timeout: 80000
	     });		
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

function limpiarform()
	{
		$('#grabar-categoria').reset();	
		borradototal();
		$('#grabar_categoris_buttom').val('Grabar Categoria');		
		$('#evento').focus();
	}	

function agregarcategoria(agregado)
	{
		$("#lista_categorias").prepend(agregado);		
		$.growlUI('Se ha registrado una categoria','Registro Exitoso...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		colorceldas();		
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

/*---------------------inicio eliminacion de categoria-------------------------*/
function eliminarcategoria(id)
    {		
		$.ajax({
		 type: "POST",
		 url: "../scripts/EliminarCategorias.php",
		 processData: false,
		 dataType: "html",		 
		 data:"id="+id,
		 beforeSend: function(){JSBlockUI('Eliminando Categoria','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') erroreliminar(); else categoriaeliminado(id);}},
		 timeout: 80000
	    });		
	}	

function erroreliminar()
    {
		$.growlUI('No se realizo la eliminaci&oacute;n','Servicio suspendido, contacte al administrador...',5000);
		$("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");
	}
function categoriaeliminado(id)
    {	
		$.growlUI('Se ha eliminado la categoria','Eliminaci&oacute;n Exitosa...',5000);
		$("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px");
		$('#'+id).remove();
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
	


