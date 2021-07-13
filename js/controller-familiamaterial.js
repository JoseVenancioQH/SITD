jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
jQuery.fn.topLink = function(settings) {
	settings = jQuery.extend({
		min: 1,
		fadeSpeed: 200
	}, settings);
	return this.each(function() {
		//listen for scroll
		var el = $(this);
		el.hide(); //in case the user forgot
		$(window).scroll(function() {
			if($(window).scrollTop() >= settings.min)
			{
				el.fadeIn(settings.fadeSpeed);
			}
			else
			{
				el.fadeOut(settings.fadeSpeed);
			}
		});
	});
};

var idfamiliamaterial = '';
var countrow = 0;

$().ready(function(){ 
	  /*$('#clavematerial-text').attr('disabled','true');*/	    
	  
	  var alternateRowColors = function($table){
		$('tbody tr:odd', $table).removeClass('even').addClass('odd');
	    $('tbody tr:even', $table).removeClass('odd').addClass('even');  
	  };  
	  
	  $("#limpiar").click(function(){							 
		   $(".filtrar tr:hidden").show();
		   $('#acronimo-text').removeAttr("disabled");		   
		   $('#form-familiamaterial').reset();
		   noticia_ocultar();							 
	  }); 
	  
	  $("#agregarclave").click(function(){		   
		 if(validardesmaterial())								
		 {
		   if(duplicado('descripcionmaterial-text'))
		   {
			 var indicenew = genera_indice();  
		     $('#desplegado-material').append('<tr id="trmaterial'+indicenew+'"><td>'+indicenew+'</td><td>'+$("#descripcionmaterial-text").val().toUpperCase()+'</td><td><img style=\"cursor:pointer;\" onclick=\"editar_material('+indicenew+');\" alt=\"Editar Material\" src=\"../img/icons/edit.png\"/></td><td><img style=\"cursor:pointer;\" onclick=\"eliminar_material('+indicenew+');\" alt=\"Eliminar Material\" src=\"../img/icons/delete.png\"/></td></tr>');    
			 alternateRowColors($('#table-desplegado-material'));
		   }
		 }
	  }); 
	  
	  $("#agregar").click(function(){  			
	   if(idfamiliamaterial == '')
	   {
		if(validar())
		{	  
		  if(duplicado('descripcionfamilia-text'))
		  {	  
			claves='';
			$("#desplegado-material tr:visible").each(function() { 
			   claves += $(this).children('td').eq(0).html()+',';
			});
			
			claves=claves.substring(0, claves.length-1);
			noticia_ocultar();    
			$.ajax({
			   type: "POST",
			   url: "../scripts/agregar_familiamaterial.php",
			   processData: false,
			   dataType: "html",
			   data:"acronimo="+$('#acronimo-text').val()+"&descripcion="+$('#descripcion-text').val()+"&claves="+claves,
			   beforeSend: function(){
				bloqueo();												
			   },
			   success: function(data){		  
				llegadaDatos(data);
			   }
			  });	    
		  }
		  else
		  { 
		   noticia_visible('Familia Repetida');
		  }
		}
		else
		{
		  noticia_visible('Capture Acronimo, Descripci&oacute;n y Claves...Verifique');	   	
		}
	   }
	   else
	   {
		  if(validar())
		  {  
				
		  $.ajax({
			   type: "POST",
			   url: "../scripts/editar_familiamaterial.php",
			   processData: false,
			   dataType: "html",
			   data:"id="+idfamiliamaterial+"&acronimo="+$('#acronimo-text').val()+"&descripcion="+$('#descripcion-text').val()+"&claves="+$('#claves-text').val(),
			   beforeSend: function(){
			   bloqueo();													
			   },
			   success: function(data){		 
			   llegadaDatos(data);
			   }
			  });
		  }
		  else
		  {
		   noticia_visible('Capture Acronimo, Descripci&oacute;n y Claves...Verifique');	 
		   $('#acronimo-text').attr('disabled','false');
		  }
	   } 
	  });  
});

function duplicado(id)
{
	  var sizefiltrado =  $(".filtrado tr:has(td:contains('"+$("#"+id).val().toLowerCase()+",'))").length;
	  if(sizefiltrado != 0)
	  {
	   alert(sizefiltrado);	  
	   noticia_visible('Descripci&oacute;n de Material Duplicado...');
	   atencion('notice');
	   return false;	  
	  }	  	  
	  noticia_ocultar();
	  return true;	  
}

function llegadaDatos(data)
	  {
		  if(data == 'no')
		  {
		   alert('No se actualizaron datos..., consulte al administrador...');
		   bloqueooff();
		   $(".filtrar tr:hidden").show();	 
		   $('#acronimo-text').removeAttr("disabled");	 	
		   $('#form-familiamaterial').reset();
		  }
		  else
		  {	  
			if(idfamiliamaterial == '')
			{	
			$('#desplegado-familiamaterial').prepend('<tr id=\"tr'+data+'\" class="anchotr"><td>'+$('#acronimo-text').val()+'</td><td>'+$('#descripcionfamilia-text').val()+'</td><td>'+$('#clavefamilia-text').val()+'</td><td><img style=\"cursor:pointer;\" onclick=\"editar_familiamaterial('+data+');\" alt=\"Editar Familia Material\" src=\"../img/icons/edit.png\" /></td></tr>');
			$('#form-familiamaterial').reset(); 			 							 
			bloqueooff();
			}
			else
			{	
			  $(".filtrar tr:hidden").show();
			  $('#acronimo-text').removeAttr("disabled");		
			  $('#tr'+idfamiliamaterial).children('td').eq(0).html($('#acronimo-text').val());
			  $('#tr'+idfamiliamaterial).children('td').eq(1).html($('#descripcionfamilia-text').val());
			  $('#tr'+idfamiliamaterial).children('td').eq(2).html($('#clavefamilia-text').val());			 
			  bloqueooff();	
			  $('#form-familiamaterial').reset();	
			}
		  }
	  }
	  
function editar_familiamaterial(id)
{
	idfamiliamaterial = id; 
	$('#acronimo-text').val($('#tr'+id).children('td').eq(0).html());
    $('#descripcionfamilia-text').val($('#tr'+id).children('td').eq(1).html());
    $('#clavefamilia-text').val($('#tr'+id).children('td').eq(2).html());
	$('#acronimo-text').attr('disabled','true');
}

function noticia_visible(texto)
{
	$('#notice').html('<img style="vertical-align:middle; margin-left:10px; " alt="info" src="../img/icons/info.png">'+texto);
    $('#notice').css("visibility","visible");	
}

function atencion(div)
{
$('#'+div).seekAttention();
}

function noticia_ocultar()
{
	$('#notice').html('');
    $('#notice').css("visibility","hidden");
}

function bloqueo()
{
         $.blockUI({ 
		 message: '<img src="../img/ajax-loader.gif" />Procesando, espere...',  
		 css: { 
               border: 'none', 
               padding: '15px', 
               backgroundColor: '#000', 
               '-webkit-border-radius': '10px', 
               '-moz-border-radius': '10px', 
               opacity: .5, 
               color: '#fff' 
         }});	
}

function bloqueooff()
{
         $.unblock();	
}


function validar()
{
	 var acronimo = $('#acronimo-text').val();
	 var descripcion = $('#descripcionfamilia-text').val();	 	 
     var sizetabla = $('#desplegado-material tr').length;	 	 
	
	 // Validando acronimo familia
	 if(acronimo==""){atencion("acronimo-text");return false;}
	 //Validando Descripcion familia
	 if(descripcion==""){atencion("descripcionfamilia-text");return false;} 
	 //Validando tabla de material
	 if(sizetabla==0){atencion("table-desplegado-material");return false;} 
	 
	 return true;	
}

function validardesmaterial()
{ 
	 var descripcionmaterial = $('#descripcionmaterial-text').val();
	 // Validando descripcion material
	 if(descripcionmaterial==""){atencion("descripcionmaterial-text");return false;}	  
	 return true;	
}

function genera_indice()
{
  var indice = 0;
  var indiceold = 1;  
  var indicesalida = '';
  
  if($('#desplegado-material tr').length == 0)
  {	
	indice = 0;
  }
  else
  {
  $.each($('#desplegado-material tr'),function(){	  									   
	indice = parseInt(Math.abs($(this).children('td').eq(0).html()));				   	
    });  
  }
  
  indice += 1;  
  indicesalida = '000'+indice; 
  indicesalida = indicesalida.substring(indicesalida.length-4, indicesalida.length);  
  return indicesalida;
}

