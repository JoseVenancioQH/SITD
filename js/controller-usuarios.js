var apold = new Array(26); 
var apnew = new Array(26); 
var ap = new Array();
var urltipo = '';
var idusuario_log = '';
var usuarionew = new Array();
var usuarioslista = new Array();
var ban = false;

apold[0]="reportes";apold[1]="catalogos";apold[2]="valparticipantes";apold[3]="regparticipantes";apold[4]="asociaciondeportiva";apold[5]="eventos";apold[6]="sistema";apold[7]="gaffetes";apold[8]="credencial";apold[9]="cedulainscripcion";apold[10]="reportesvarios";apold[11]="prueba";apold[12]="equipo";apold[13]="liga";apold[14]="nombrecategoria";apold[15]="categoria";apold[16]="valparactivar";apold[17]="regparregistrar";apold[18]="regparmodificar";apold[19]="asociaciondeportivaregistrar";apold[20]="asociaciondeportivamodificar";apold[21]="eventosregistrar";apold[22]="eventosmodificar";apold[23]="usuarios";apold[24]="deportes";apold[25]="modalidad";apold[26]="municipio";

apnew[0]="Reportes";apnew[1]="Catalogos";apnew[2]="Validaci&oacute;n de Participantes";apnew[3]="Registro de Participantes";apnew[4]="Asociaci&oacute;n Deportiva";apnew[5]="Eventos";apnew[6]="Sistema";apnew[7]="Gaffetes";apnew[8]="Credencial";apnew[9]="Cedula de Inscripci&oacute;n";apnew[10]="Reportes Varios";apnew[11]="Prueba";apnew[12]="Equipo";apnew[13]="Liga";apold[14]="Nombre Categoria";apold[15]="Categoria";apnew[16]="Activar Validaci&oacute;n de Participantes";apnew[17]="Registro Participante";apnew[18]="Modificar Participante";apnew[19]="Registrar Asociaci&oacute;n Deportiva";apnew[20]="Modificar Asociaci&oacute;n Deportiva";apnew[21]="Registrar Evento";apnew[22]="Modificar Evento";apnew[23]="Usuarios";apnew[24]="Deportes";apnew[25]="Modalidad";apnew[26]="Municipio";

//plugin
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

jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}
$(function(){
	$('#dialog').dialog({
		autoOpen: false,
		width: 900,
		buttons: {
			"Grabar" : function() { 
			if(!valida_nombreusuario())
			{
				var privilegios = '';			
				if($('#sistema').is(":checked"))
				   privilegios = privilegios + 'sistema,';  				
				if($('#usuarios').is(":checked"))
				   privilegios = privilegios + 'usuarios,';  								
				if($('#eventos').is(":checked"))
				   privilegios = privilegios + 'eventos,';  				
				if($('#eventosregistrar').is(":checked"))
				   privilegios = privilegios + 'eventosregistrar,';  				
				if($('#eventosmodificar').is(":checked"))
				   privilegios = privilegios + 'eventosmodificar,';  				
				if($('#asociaciondeportiva').is(":checked"))
				   privilegios = privilegios + 'asociaciondeportiva,';  				
				if($('#asociaciondeportivaregistrar').is(":checked"))
				   privilegios = privilegios + 'asociaciondeportivaregistrar,';  				
				if($('#asociaciondeportivamodificar').is(":checked"))
				   privilegios = privilegios + 'asociaciondeportivamodificar,';  				
				if($('#regparticipantes').is(":checked"))
				   privilegios = privilegios + 'regparticipantes,';  				
				if($('#regparregistrar').is(":checked"))
				   privilegios = privilegios + 'regparregistrar,';  				
				if($('#regparmodificar').is(":checked"))
				   privilegios = privilegios + 'regparmodificar,';  				
				if($('#valparticipantes').is(":checked"))
				   privilegios = privilegios + 'valparticipantes,';  				
				if($('#valparactivar').is(":checked"))
				   privilegios = privilegios + 'valparactivar,';  				
				if($('#catalogos').is(":checked"))
				   privilegios = privilegios + 'catalogos,';  								
				if($('#liga').is(":checked"))
				   privilegios = privilegios + 'liga,';  				
				if($('#equipo').is(":checked"))
				   privilegios = privilegios + 'equipo,';  				
				if($('#categoria').is(":checked"))
				   privilegios = privilegios + 'categoria,';
				if($('#municipio').is(":checked"))
				   privilegios = privilegios + 'municipio,';   
				if($('#modalidad').is(":checked"))
				   privilegios = privilegios + 'modalidad,';   
				if($('#deportes').is(":checked"))
				   privilegios = privilegios + 'deportes,';    
				if($('#reportes').is(":checked"))
				   privilegios = privilegios + 'reportes,';  				
				if($('#cedulainscripcion').is(":checked"))
				   privilegios = privilegios + 'cedulainscripcion,';  				
				if($('#credencial').is(":checked"))
				   privilegios = privilegios + 'credencial,';  				
				if($('#gaffetes').is(":checked"))
				   privilegios = privilegios + 'gaffetes,';  				
				if($('#reportesvarios').is(":checked"))
				   privilegios = privilegios + 'reportesvarios,';
				   
				
				var rolusuario = $('#rolusuario-text').val();
				var nombreusuario = $('#nombreusuario-text').val();
				var nombre = $('#nombre-text').val();
				var pass = $('#pass-text').val();	
				var municipio = $('#municipio').val();	
	            
				privilegios = privilegios.substring(0, privilegios.length-1);		
				
				var noticias = '';
				
				if(privilegios == '') noticias += 'Permisos de Usuarios, '
				if(rolusuario == '') noticias += 'Rol de Usuarios, '
				if(nombreusuario == '') noticias += 'Nombre Completo de Usuarios, '
				if(nombre == '') noticias += 'Nombre de Sesi&oacute;n de Usuarios, ' 				
				if(pass == '') noticias += 'PassWord de Usuarios, '
				if(rolusuario != 'admin'){if(municipio == '') noticias += 'Municipio de Usuarios, '}
				
				if(noticias != '')			
				{
				noticias = noticias.substring(0, noticias.length-1);
				$('#notice').html('<img src="../img/icons/info.png" border="0" /> Capture '+noticias);
				 $('#notice').css("visibility","visible"); 
				 $('#notice').seekAttention();
				 //set the link          
				}
				else
				{
				 $('#notice').css("visibility","hidden");
				 $.ajax({
				 type: "POST",
				 url: urltipo,
				 processData: false,
				 dataType: "html",
				 data:"municipio="+municipio+"&privilegios="+privilegios+"&rolusuario="+rolusuario+"&nombreusuario="+nombreusuario+"&nombre="+nombre+"&pass="+pass+"&id="+idusuario_log,
				 beforeSend: function(){
				 $("#dialog").dialog("close");
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
				 },
				 success: function(data){	
				 $("#dialog").dialog("open");
				 if(data == 'no') {alert('No se pudo realizar el registro de usuario, consulte al administrador...');
				 }else 				 
				 {		 
				
				 var privilegiosnew = '';
		 	     ap = privilegios.split(',');
				 $.each(ap,function(iap,dataap){
				 $.each(apold,function(iold,dataold){
				 if(dataap == dataold) privilegiosnew += apnew[iold]+', ';
				 });
				 });
				 
				 if(idusuario_log == ''){
				 privilegiosnew = privilegiosnew.substring(0, privilegiosnew.length-1);
				 $('#desplegado-usuarios').append('<tr id=\"tr'+data+'\"><td>'+nombreusuario+'</td><td>'+pass+'</td><td>'+nombre+'</td><td title=\"'+privilegios+'\">'+privilegiosnew+'</td><td>'+rolusuario+'</td><td>'+$("#municipio option[value="+$('#municipio').val()+"]").text()+'</td><td><img style=\"cursor:pointer;\" onclick=\"editar_usuario('+data+');\" alt=\"Editar Usuario\" src=\"../img/icons/edit.png\" /></td><td><img id=\"img'+data+'\" style=\"cursor:pointer;\" onclick=\"cambiar_status('+data+');\" alt=\"Estado del Usuario\" src=\"../img/icons/accept.png\" /></td></tr>');			 		 
				 }
				 else
				 {					
					$('#tr'+idusuario_log).children('td').eq(0).html(nombre);
					$('#tr'+idusuario_log).children('td').eq(1).html(pass);
                    $('#tr'+idusuario_log).children('td').eq(2).html(nombreusuario);
                    $('#tr'+idusuario_log).children('td').eq(3).html(privilegiosnew);
					$('#tr'+idusuario_log).children('td').eq(3).attr('title',privilegios);
                    $('#tr'+idusuario_log).children('td').eq(4).html(rolusuario);					
				 }
				 
				 usuarionew = $('#nombre-text').val();
                 usuarioslista = $('#nombresusuarios').val();
				 
				 
                 $('#nombresusuarios').val(usuarionew+','+usuarioslista);				 
				 
				 }
				 $('#form-dialog').reset(); 			 					
				 $("#dialog").dialog("close");
				 $.unblockUI();
				 
				 		 
				}});
				$('#top-link').topLink({
		         min: 400,
		         fadeSpeed: 500
	             });
	             $.scrollTo(0,300);			 
				}
			    
							
			}}, 
			"Cancelar": function() { 
			    $('#form-dialog').reset();
				$(this).dialog("close"); 
				$('#top-link').topLink({
		         min: 400,
		         fadeSpeed: 500
	             });
	             $.scrollTo(0,300);
			} 
		}
	});
	
	$("#agregar").click(function(){
	   urltipo = "../scripts/agregar_usuario.php";	  
	   idusuario_log=''; 	
	   $('#dialog').dialog('open');	   	
	   $('#form-dialog').reset();
	   $('#notice').html('');
	   $('#notice').css("visibility","hidden");
	   });
	
	$("#nombre-text").change(function(){
	  valida_nombreusuario();
    });
	
	$("#tabla-sistema :checkbox").click(function(){
	 $('#sistema').attr('checked', false);
	 $('#tabla-sistema :checkbox').each(function()
     {
      if($(this).is(":checked")) $('#sistema').attr('checked', true);	   
     });   
    });
	
	$("#tabla-eventos :checkbox").click(function(){
	 $('#eventos').attr('checked', false);
	 $('#tabla-eventos :checkbox').each(function()
     {
      if($(this).is(":checked")) $('#eventos').attr('checked', true);	   
     });   
    });
	
	$("#tabla-asociaciondeportiva :checkbox").click(function(){
	 $('#asociaciondeportiva').attr('checked', false);
	 $('#tabla-asociaciondeportiva :checkbox').each(function()
     {
      if($(this).is(":checked")) $('#asociaciondeportiva').attr('checked', true);	   
     });   
    });
	
	$("#tabla-registroparticipantes :checkbox").click(function(){
	 $('#regparticipantes').attr('checked', false);
	 $('#tabla-registroparticipantes :checkbox').each(function()
     {
      if($(this).is(":checked")) $('#regparticipantes').attr('checked', true);   
     });   
    });
	
	$("#tabla-validacionparticipante :checkbox").click(function(){
	 $('#valparticipantes').attr('checked', false);

	 $('#tabla-validacionparticipante :checkbox').each(function()
     {
      if($(this).is(":checked")) $('#valparticipantes').attr('checked', true);
     });   
    });
	
	$("#tabla-catalogos :checkbox").click(function(){
	 $('#catalogos').attr('checked', false);

	 $('#tabla-catalogos :checkbox').each(function()
     {
      if($(this).is(":checked")) $('#catalogos').attr('checked', true);   
     });   
    });
	
	$("#tabla-reportes :checkbox").click(function(){
	 $('#reportes').attr('checked', false);

	 $('#tabla-reportes :checkbox').each(function()
     {
      if($(this).is(":checked")) $('#reportes').attr('checked', true);	   
     });   
    });
	
	$("#sistema").click(function(){	
	  if($("#sistema").is(":checked")) 
	    $("#tabla-sistema").checkCheckboxes();
	  else			
	    $("#tabla-sistema").unCheckCheckboxes();
	});
	
	$("#eventos").click(function(){
	  if($("#eventos").is(":checked")) 
	    $("#tabla-eventos").checkCheckboxes();
	  else			
	    $("#tabla-eventos").unCheckCheckboxes();	  
	});
	
	$("#asociaciondeportiva").click(function(){
	  if($("#asociaciondeportiva").is(":checked")) 
	    $("#tabla-asociaciondeportiva").checkCheckboxes();
	  else			
	    $("#tabla-asociaciondeportiva").unCheckCheckboxes();	  	  
	});
	
	$("#regparticipantes").click(function(){
	  if($("#regparticipantes").is(":checked")) 
	    $("#tabla-registroparticipantes").checkCheckboxes();
	  else			
	    $("#tabla-registroparticipantes").unCheckCheckboxes();	  	  	  
	});
    
	$("#valparticipantes").click(function(){
	  if($("#valparticipantes").is(":checked")) 
	    $("#tabla-validacionparticipante").checkCheckboxes();
	  else			
	    $("#tabla-validacionparticipante").unCheckCheckboxes();	  		
	});
	
	$("#catalogos").click(function(){
	  if($("#catalogos").is(":checked")) 
	    $("#tabla-catalogos").checkCheckboxes();
	  else			
	    $("#tabla-catalogos").unCheckCheckboxes();	  
	});
	
	$("#reportes").click(function(){
	  if($("#reportes").is(":checked")) 
	    $("#tabla-reportes").checkCheckboxes();
	  else			
	    $("#tabla-reportes").unCheckCheckboxes();	  
	});
	
	
});

function valida_nombreusuario()
{
      usuarionew = $('#nombre-text').val().toUpperCase();
	  usuarioslista = $('#nombresusuarios').val().toUpperCase().split(',');
	  ban = false;  
	  
	  $.each(usuarioslista,function(i,data){
	  if(data == usuarionew) ban = true; 								
      });	  
	  
	  if(ban)
	  {
	  if (idusuario_log == '')
	   {	  
	    $('#notice').html('<img src="../img/icons/info.png" border="0" /> Nombre de Usuario Duplicado...Verifique');
	    $('#notice').css("visibility","visible"); 
	    $('#notice').seekAttention();
	    return true;
	   }
	  else
	   {
		return false;  
	   }
	  }
	  else
	  {
	    $('#notice').html('');
	    $('#notice').css("visibility","hidden");	  
	    return false;
	  }	  
}

function editar_usuario(id)
{
urltipo = "../scripts/actualizar_usuario.php";
idusuario_log =id;
$('#dialog').dialog('open');
$('#form-dialog').reset();
$('#nombre-text').val($('#tr'+id).children('td').eq(0).html());
$('#pass-text').val($('#tr'+id).children('td').eq(1).html());
$('#nombreusuario-text').val($('#tr'+id).children('td').eq(2).html());
$('#rolusuario-text').val($('#tr'+id).children('td').eq(4).html());

usuarionew = $('#nombre-text').val().toUpperCase();
usuarioslista = $('#nombresusuarios').val().toUpperCase();

$('#nombresusuarios').val(usuarioslista.replace(usuarionew,''));

var ap = $('#tr'+id).children('td').eq(3).attr("title").split(',');


$.each(ap,function(iap,dataap){

$.each(apold,function(iold,dataold){
/*if(dataap=='categoria')alert(dataap.toUpperCase()+', '+dataold.toUpperCase())*/
if(jQuery.trim(dataap.toUpperCase()) == jQuery.trim(dataold.toUpperCase())) {$("#"+apold[iold].toLowerCase()).attr('checked', true);}
});

;


});

 $('#notice').html('');
 $('#notice').css("visibility","hidden");
	   	
}





function cambiar_status(id)
{ 
  if($('#img'+id).attr('src').indexOf('accept') != -1)
    var status = 'no';
  else 
    var status = 'si';
	
  $('#img'+id).attr('src','../img/indicator.gif');
  $.get("../scripts/cambiar_status.php?id="+id+"&status="+status, function(resultado){
					if(resultado == "0")
					{
						if(status == 'no')
                          $('#img'+id).attr('src','../img/icons/delete.png');
                        else
                          $('#img'+id).attr('src','../img/icons/accept.png');
					}
					else
					{
						alert("ERROR, contacta al administrador");
					}
				 });  
				 
  
}

