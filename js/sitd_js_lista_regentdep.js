jQuery.noConflict();
var campo='id_participante';
var orden='desc';
var limite=10;
var filtro='';
var pagina=1;
var paginado=0;
var objImagePreloader = new Image();
var operacion = "guardar";
var arrayordenimprimir = Array();

jQuery().ready(function(){							
		repeat_ready();		
		jQuery("#form_regentdep").validationEngine({promptPosition: "topRight"});	
	    jQuery('#restablecer').click(function () { jQuery('#search').val(''); pagina=1;  paginado=0; readdata(); });			
		jQuery('#ir').click(function () {  pagina=1;  paginado=0; readdata(); });		
		jQuery('.inputbox').change(function () {pagina=1;  paginado=0; readdata();});
		jQuery('input[type="text"]').blur(function(){jQuery("#form_regentdep").validationEngine('hideAll');});
		jQuery('#dialog_editar_imagen').dialog({
			autoOpen: false,
			width: 'auto',
			position:'center',
			buttons: {
				"Editar": function() {					 					 					 
					 editar_foto();
				}, 
				"Salir": function() {				    
				   /* $.validationEngine.closePrompt(".formError", true);	*/				
					jQuery(this).dialog("close"); 
				} 
			}
		});	
		jQuery("#fechadesde").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			showButtonPanel: true,		
			onSelect: function(){jQuery("#fechahasta").datepicker('option', 'minDate', jQuery('#fechadesde').datepicker("getDate"));jQuery('#fechahasta').datepicker("setDate",jQuery('#fechadesde').datepicker("getDate"));pagina=1;  paginado=0; readdata();}            				
	    }).mask("d9/m9/wx99");
		
		jQuery("#fechahasta").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			showButtonPanel: true,			
			onSelect: function(dateText){jQuery("#fechadesde").datepicker('option', 'maxDate', jQuery('#fechahasta').datepicker("getDate"));pagina=1;  paginado=0; readdata();}		
	    }).mask("d9/m9/wx99");
		
		jQuery("#fechanaccurp").datepicker({
			changeMonth: true,
			changeYear: true,			
			dateFormat: 'dd/mm/yy',
			showButtonPanel: true		
	    }).mask("d9/m9/wx99");
});

function repeat_ready()
{
	jQuery('#checkAll').click(function () {									
		jQuery(this).parents('#tabla_desplegado').find(':checkbox').attr('checked', this.checked);
	});	
	
	jQuery('#limit').change(function () { pagina=1; paginado=0; readdata();});
	
	jQuery('#foto_comprimida').click(function(){										
       editarfoto(curp_foto_editar,'');
    });
	
	jQuery('#foto_original').click(function(){										
		   editarfoto(curp_foto_editar,'fotosparticipantesevento/'+jQuery('#evento').val());	   
	});	
}

function readfilter()
{
	limite=jQuery('#limit').val();filtro=jQuery("#search").val();		
}

function tableOrdering(campo_,orden_)
{
	campo=campo_;
	orden=orden_;	
	readdata();
}

function paginar(paginado_num,pagina_num)
{
	pagina=pagina_num;
	paginado=paginado_num;
	readdata();
}

function ordenImprimirLimpiar()
{
   jQuery('.ordenimprimir').each(function(){
		  jQuery("#"+this.id).html('<img src=\"../images/header/icon-48-printorder.png\" \>');
   });	
   arrayordenimprimir = [];
}

function ordenImprimir(id)
{	
    var busca = arrayordenimprimir.indexOf(id);
	if(busca == -1)arrayordenimprimir.push(id); else arrayordenimprimir.splice(busca, 1);
	jQuery('.ordenimprimir').each(function(){
		  jQuery("#"+this.id).html('<img src=\"../images/header/icon-48-printorder.png\" \>');
	});
	jQuery.each(arrayordenimprimir, function(i,item){
		  jQuery("#"+item).html('<img src=\"../images/header/icon-48-printorder-'+(i+1)+'.png\" \>')
	});
	
	/*var acciones = jQuery('.ordenimprimir').val().split(',');
	
	jQuery.each(acciones, function(i_ext,item_ext){		
		if(item_ext=='editar')jQuery('.imgeditarparticipante').show();
		if(item_ext=='borrar')jQuery('.imgborrarparticipante').show();
	});*/
	
	jQuery('#'+id).html();
}

function agregaradd()
{
	jQuery('#tabla_desplegado tbody').prepend("<tr id=\"tradd\">"+
						"<td colspan=\"2\" style=\"text-align:center\"><button OnClick=\"limpiarrestaurar();\" type=\"button\">Limpiar Restaurar</button></td>"+						
						"<td style=\"text-align:center\">"+
						"<img id='imgreg' class='edit_foto' style='display:none; vertical-align:top; cursor:pointer;' src='../img/editar_img.jpg' onclick='javascript:editarfoto(\"\",\"\");'/><br /><img  id='fotoreg'  src='../img/foto_renovar.jpg' style='display:none; vertical-align:middle; cursor:pointer;' onmouseover='javascript:actualizarfoto_captura();' onclick='javascript:actualizarfoto_captura();'/>"+
						"</td>"+
						"<td style=\"text-align:center\"><input type=\"text\" id=\"nombre\" value=\"\" class=\"validate[required] mayuscula\"/></td>"+
						"<td style=\"text-align:center\"><input type=\"text\" id=\"appaterno\" value=\"\" class=\"validate[required] mayuscula\"/></td>"+
						"<td style=\"text-align:center\"><input type=\"text\" id=\"apmaterno\" value=\"\" class=\"validate[required] mayuscula\"/></td>"+
						"<td style=\"text-align:center\" id=\"cloneestado\">"+						
						"</td>"+
						
						"<td style=\"text-align:center\"><input type=\"text\" id=\"fechanaccurp\" class=\"icon-fecha fecha\" value=\"\" size=\"15\"/></td>"+
						"<td style=\"text-align:center\" id=\"clonegenero\"><select class=\"validate[required]\" id=\"addgenero\" name=\"filter_genero\"><option selected=\"\" value=\"\">- Genero -</option><option value=\"Hombre\">Hombre</option><option value=\"Mujer\">Mujer</option></select></td>"+
						"<td  style=\"text-align:center\"><input type=\"text\" id=\"curp\" value=\"\" class=\"validate[required] mayuscula\" size=\"27\"/></td>"+						
						"<td colspan=\"3\" id=\"idparticipanteadd\"style=\"text-align:center\"><button id=\"botonguardar\"OnClick=\"validarp();\" type=\"button\">Guardar</button></td>"+
					  "</tr>");  
		jQuery('#filter_estado').clone(false).attr('id','addestado').removeClass("inputbox").addClass("validate[required]").appendTo("#cloneestado");
		/*Query('#filter_modalidad').clone(false).attr('id','addmodalidad').removeClass("inputbox").addClass("validate[required]").appendTo("#clonemodalidad");	*/
		jQuery("#form_regentdep").validationEngine({promptPosition: "topRight"});
		jQuery('input[type="text"]').blur(function(){jQuery("#form_regentdep").validationEngine('hideAll');});
		
	jQuery('.imgeditarparticipante').hide();
	jQuery('.imgborrarparticipante').hide();
	
	
	/*var acciones = jQuery('#acciones').val().split(',');
	
	jQuery.each(acciones, function(i_ext,item_ext){
		
		if(item_ext=='editar')jQuery('.imgeditarparticipante').show();
		if(item_ext=='borrar')jQuery('.imgborrarparticipante').show();
	});*/
	
	/*jQuery("#fechanaccurp").datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd/mm/yy',
			showButtonPanel: true		
	});*/
	
	
	
	jQuery('#curp').focus(function(){     		
	  var genero_curp= '';
	  var fechanaccurp=jQuery('#fechanaccurp').val();
	  if(jQuery('#addgenero').val()=='Hombre')genero_curp='H';
	  if(jQuery('#addgenero').val()=='Mujer')genero_curp='M';
      var estado_curp=jQuery.trim(jQuery("#addestado option:selected").html().split(' - ')[0]);
	  var fechanac_curp = fechanaccurp.split('/');
	  var nombre = jQuery('#nombre').val().trim();
	  var apellido_paterno = jQuery('#appaterno').val().trim();
	  var apellido_materno = jQuery('#apmaterno').val().trim();
	  if(apellido_materno=='')apellido_materno='X';
	  if(fechanaccurp!='' && genero_curp!='' && estado_curp!='' && fechanac_curp!='' && nombre!='' && apellido_paterno!='')
	  {  
		var curp = generaCurp({
		  nombre            : nombre,
		  apellido_paterno  : apellido_paterno,
		  apellido_materno  : apellido_materno,
		  sexo              : genero_curp,
		  estado            : estado_curp,
		  fecha_nacimiento  : [parseInt(fechanac_curp[0]), parseInt(fechanac_curp[1]), parseInt(fechanac_curp[2])]
		});
		jQuery('#curp').val(curp);	
		jQuery('#imgreg, #fotoreg').show();	
	  }else{jQuery('#imgreg, #fotoreg').hide();jQuery('#curp').val('');}
	});
	
	jQuery('#addgenero, #addestado, #fechanaccurp, #nombre, #appaterno, #apmaterno').change(function(){																											
	  var genero_curp= '';
	  var fechanaccurp=jQuery('#fechanaccurp').val();
	  if(jQuery('#addgenero').val()=='Hombre')genero_curp='H';
	  if(jQuery('#addgenero').val()=='Mujer')genero_curp='M';
      var estado_curp=jQuery.trim(jQuery("#addestado option:selected").html().split(' - ')[0]);
	  var fechanac_curp = fechanaccurp.split('/');
	  var nombre = jQuery('#nombre').val().trim();
	  var apellido_paterno = jQuery('#appaterno').val().trim();
	  var apellido_materno = jQuery('#apmaterno').val().trim();
	  if(apellido_materno=='')apellido_materno='X';
	  if(fechanaccurp!='' && genero_curp!='' && estado_curp!='' && fechanac_curp!='' && nombre!='' && apellido_paterno!='')
	  {  
		var curp = generaCurp({
		  nombre            : nombre,
		  apellido_paterno  : apellido_paterno,
		  apellido_materno  : apellido_materno,
		  sexo              : genero_curp,
		  estado            : estado_curp,
		  fecha_nacimiento  : [parseInt(fechanac_curp[0]), parseInt(fechanac_curp[1]), parseInt(fechanac_curp[2])]
		});
		jQuery('#curp').val(curp);	
		jQuery('#imgreg, #fotoreg').show();	
	  }else{jQuery('#imgreg, #fotoreg').hide();jQuery('#curp').val('');}
	});
}

function readdata()
{
	readfilter();	
	if(jQuery("#limit").length == 0) limite=10;
	jQuery.blockUI({ message: '<h2 style="color:#FFFFFF;"><img src="../img/ajax-loader.gif" />Buscando...</h2>',
					 css: { 
							   border: 'none', 
							   padding: '15px', 
							   backgroundColor: '#000', 
							   '-webkit-border-radius': '10px', 
							   '-moz-border-radius': '10px', 
							   opacity: .5, 
							   color: '#fff'
					 }
				 });
	jQuery.post("../scripts/controlgc_script_lista_participante.php", 
			  {paginado: paginado, pagina: pagina, limite: limite, filtro: filtro, campo:  campo, orden:  orden, evento: jQuery('#evento').val(), idparticipanteenvio:  jQuery('#idparticipanteenvio').val(), pais:jQuery('#filter_pais').val(), modalidad:jQuery('#filter_modalidad').val()}, function(data){loaddatalist(data);repeat_ready();jQuery.unblockUI();});
}

/*function readdata()
{
	readfilter();
	if(jQuery("#limit").length == 0) limite=0;
	jQuery.post("../scripts/controlgc_script_lista_participante.php", 
			  {paginado: paginado, pagina: pagina, limite: limite, filtro: filtro, campo:  campo, orden:  orden }, function(data){loaddata(data);repeat_ready();}
	);
}*/

function loaddatalist(data)
{	
    
	var nombrer = jQuery('#nombre').val(); 
	var appaternor = jQuery('#appaterno').val();
	var apmaternor = jQuery('#apmaterno').val(); 
	var addpaisr = jQuery('#addpais').val(); 
	var addmodalidadr = jQuery('#addmodalidad').val(); 				 				 
	var addgeneror = jQuery('#addgenero').val();
	var idparticipanteenvior = jQuery('#idparticipanteenvio').val();
	var botonguardar = jQuery('#botonguardar').text();	
    
	if(data=='cancel')location.href="../index.php";
	else jQuery('#tabla_desplegado').html(data);	
	
	/*jQuery('#tabla_desplegado tbody tr').each(function(){
		if(this.id!='')jQuery("a[rel='"+this.id+"']").colorbox({slideshow:true});		
	});*/	
	
	agregaradd();
	
	jQuery('#nombre').val(nombrer); 
	jQuery('#appaterno').val(appaternor);
	jQuery('#apmaterno').val(apmaternor); 
	jQuery('#addpais').val(addpaisr); 
	jQuery('#addmodalidad').val(addmodalidadr); 				 				 
	jQuery('#addgenero').val(addgeneror);
	jQuery('#idparticipanteenvio').val(idparticipanteenvior);
	if(botonguardar=='' || operacion=='guardar')botonguardar='Guardar';
	jQuery('#botonguardar').html(botonguardar);
	
	jQuery('.imgeditarparticipante').hide();
	jQuery('.imgborrarparticipante').hide();
	
	/*var acciones = jQuery('#acciones').val().split(',');
	
	jQuery.each(acciones, function(i_ext,item_ext){
		
		if(item_ext=='editar')jQuery('.imgeditarparticipante').show();		
		if(item_ext=='borrar')jQuery('.imgborrarparticipante').show();
	});*/
}

function eliminarparticipante(id)
{
	//alert(jQuery('#filefoto').val());
	jQuery.post("../scripts/controlgc_script_borrar_participante.php", 
				{idparticipanteenvio: id},
				 function(data){loaddataeliminarp(data);}				
	 );
}

function loaddataeliminarp(data)
{
   mensaje(data,3000);      
   readdata();
}

function limpiarrestaurar()
{
	jQuery('#nombre').val(''); 
	jQuery('#appaterno').val('');
	jQuery('#apmaterno').val(''); 
	jQuery('#addpais').val(''); 
	jQuery('#addmodalidad').val(''); 				 				 
	jQuery('#addgenero').val('');
	jQuery('#idparticipanteenvio').val('');
	jQuery('#botonguardar').html('Guardar');
	operacion = "guardar";
	jQuery('#tituloform').html('Registro de Participantes');
}

function editarparticipante(idparticipante,nombre,appaterno,apmaterno,pais,modalidad,genero)
{
	jQuery('#nombre').val(nombre); 
	jQuery('#appaterno').val(appaterno);
	jQuery('#apmaterno').val(apmaterno); 
	jQuery('#addpais').val(pais); 
	jQuery('#addmodalidad').val(modalidad); 				 				 
	jQuery('#addgenero').val(genero);
	jQuery('#idparticipanteenvio').val(idparticipante);
	jQuery('#botonguardar').html('Guardar (id:'+idparticipante+')');
	operacion = "editar";
	jQuery('#tituloform').html('Registro de Participantes (Editar)');
}

function editarp()
{
	//alert(jQuery('#filefoto').val());
	jQuery.post("../scripts/controlgc_script_editar_participante.php", 
				{nombre: jQuery('#nombre').val(), 
				 appaterno: jQuery('#appaterno').val(),
				 apmaterno: jQuery('#apmaterno').val(), 
				 pais:  jQuery('#addpais').val(), 
				 modalidad:  jQuery('#addmodalidad').val(), 				 				 
				 genero:  jQuery('#addgenero').val(),
				 idparticipanteenvio: jQuery('.check_me:checked').val()},
				 function(data){loaddataaplicar(data);}				
	 );
}

function validarp()
{	
	if(jQuery("#form_regentdep").validationEngine('validate')){guardarp();}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_regentdep").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardarp()
{
	
	//alert(jQuery('#filefoto').val());
	jQuery.post("../scripts/controlgc_script_"+operacion+"_participante.php", 
				{nombre: jQuery('#nombre').val(), 
				 appaterno: jQuery('#appaterno').val(),
				 apmaterno: jQuery('#apmaterno').val(), 
				 pais:  jQuery('#addpais').val(), 
				 modalidad:  jQuery('#addmodalidad').val(), 				 				 
				 genero:  jQuery('#addgenero').val(), 
				 idparticipanteenvio: jQuery('#idparticipanteenvio').val()},
				 function(data){loaddataadd(data);}				
	);	
	
	jQuery('#nombre').val(''); 
	jQuery('#appaterno').val('');
	jQuery('#apmaterno').val(''); 
	jQuery('#botonguardar').html('Guardar');
	operacion = "guardar";
	jQuery('#tituloform').html('Registro de Participantes');
}

function loaddataadd(data)
{	
   mensaje(data,3000);   
   if(eval('(' + data + ')').tipo=='succes'){	 
	 /*array_autocomplet_nombre.push(eval({nombre:jQuery('#nomcliente').val(),appaterno:jQuery('#appaternocliente').val(),apmaterno:jQuery('#apmaternocliente').val(),direccion:jQuery('#dircliente').val()}));	 
	 autocomplete_renovar(array_autocomplet_nombre);*/
	 jQuery('#idinsertparticipante').val(eval('(' + data + ')').id);	 
	 /*reset_var();*/	 
   }  
   readdata();
}

function loaddataaplicar(data)
{	
   mensaje(data,3000);   
   if(eval('(' + data + ')').tipo=='succes'){	 
	 /*array_autocomplet_nombre.push(eval({nombre:jQuery('#nomcliente').val(),appaterno:jQuery('#appaternocliente').val(),apmaterno:jQuery('#apmaternocliente').val(),direccion:jQuery('#dircliente').val()}));	 
	 autocomplete_renovar(array_autocomplet_nombre);*/
	 /*jQuery('#idinsertparticipante').val(eval('(' + data + ')').id);*/	 
	 /*reset_var();*/	 
   }  
   readdata();
}

function status(tipo)
{	
    var array_check_me = new Array();
    jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});
	if(array_check_me.length>0){
	jQuery.post("../scripts/controlgc_script_status_participante.php", 
			  {tipo: tipo, ids: array_check_me.join(',')}, function(data){loaddatastatus(data,tipo);}
	);}else{mensaje('Seleccione un elemento de la lista, para habilitar / deshabilitar...','error','Error');}	
}

function loaddatastatus(data,tipo)
{
	if(data=='cancel')location.href="../index.php";
	else{	
	     if(tipo=='deshabilitar') var status_change='habilitar'; else var status_change='deshabilitar';
		 jQuery.each(data.split(','),function(i,d){					  
		  jQuery('#'+d).html("<a href='#'><img src='../images/"+tipo+".png' onclick='javascript:changestatus(\""+status_change+"\","+d+")' width='16' height='16' border='0' alt=''/></a>");		  	  
		  
		 });		 		 
	}
}

function changestatus(status,id)
{
	jQuery.post("../scripts/controlgc_script_status_participante.php", 
			  {tipo: status, ids: id}, function(data){loaddatachangestatus(data,status);}
	);
}

function loaddatachangestatus(data,status)
{	
	if(data=='cancel')location.href="../index.php";
	else{ 				
	      if(status=='deshabilitar') var status_change='habilitar'; else var status_change='deshabilitar';	     
		  jQuery('#'+data).html("<a href='#'><img src='../images/"+status+".png' onclick='javascript:changestatus(\""+status_change+"\","+data+")' width='16' height='16' border='0' alt=''/></a>");		  	 		 		 
	}
}

function borrar()
{
	
	var array_check_me = new Array();
    jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});
	if(array_check_me.length>0){
	jQuery.post("../scripts/controlgc_script_borrar_participante.php", 
			  {ids: array_check_me.join(',')}, function(data){loaddataborrar(data);}
	);}else{mensaje('Seleccione un elemento de la lista, para borrar...','error','Error');}
	
}

function loaddataborrar(data)
{
	if(data=='cancel')location.href="../index.php";
	else{     	     
	     readdata();
		 /*jQuery.each(data.split(','),function(i,d){					  
		  jQuery('#tr'+d).remove();									  	  
		 });		 		 
		 colorcelda();*/
	}
}

function colorcelda()
{	
	jQuery(".adminlist tr").removeClass("row0");
	jQuery(".adminlist tr").removeClass("row1");
	
	jQuery(".adminlist tr:even").addClass("row0");
	jQuery(".adminlist tr:odd").addClass("row1");	
}

function mensaje(data,timer)
{
	var data = eval('(' + data + ')');							   
	if(data.tipo=='error'){
		jQuery('#mensaje').html("<dl id=\"system-message\"><dt class=\"error\">Error</dt><dd class=\"error message fade\"><ul><li>"+data.mensaje+"</li></ul></dd></dl>");
	}else{
		jQuery('#mensaje').html("<dl id=\"system-message\"><dt class=\"succes\"></dt><dd class=\"succes message fade\"><ul><li>"+data.mensaje+"</li></ul></dd></dl>");	
	} 	
	if(timer!=0){
		var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);},timer);		
	}
}

function actualizarfoto_captura()
{
	var button = jQuery('#fotoreg');		
	new AjaxUpload(button,{		
	action: '../scripts/upload.php', 
	name: 'userfile',
	onSubmit : function(file, ext){	
	    if(jQuery('#curp').val()!=''){
		  if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){		    
			  /* Setting data */
			  this.setData({'curp'    :   jQuery('#curp').val(),
							'overwrite'  :   "si",
							'action'     :   "image"/*,
							'evento'    :   jQuery('#curp').val()*/});
			  
			  jQuery.blockUI({ message: '<h1 style="color:#FFFFFF;"><img src="../img/ajax-loader.gif" />Cargando Imagen...</h1>',
							   css: { 
										 border: 'none', 
										 padding: '15px', 
										 backgroundColor: '#000', 
										 '-webkit-border-radius': '10px', 
										 '-moz-border-radius': '10px', 
										 opacity: .5, 
										 color: '#fff'
							   }
							 });			  
			  /*button.attr("src","../img/loading.gif");*/
		  } else {				
			  // cancel upload
			  alert('solo imagenes');
			  return false;				
		  }	
		}else{	
		  jQuery('#fotoreg').focus();
		  mensaje('{"tipo":"error","mensaje":"Especifique curp del participante para poder subir im&aacute;genes"}',2000); 			          return false;	
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
		{alert('No se cargo la imagen, excede el tama\u00F1o permitido, Redusca la imagen de tama\u00F1o, he intente de nuevo');
		 button.attr("src","../img/foto.png");}
		 jQuery.unblockUI();
	} 
	});
}

function actualizarfoto(curp)
{		
	var button = jQuery('#foto'+curp);		
	new AjaxUpload(button,{		
	action: '../scripts/upload.php', 
	name: 'userfile',
	onSubmit : function(file, ext){	
	    if(curp!=''){
		  if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){		    
			  /* Setting data */
			  this.setData({'curp'    :   curp,
							'overwrite'  :   "si",
							'action'     :   "image"/*,
							'evento'    :   jQuery('#curp').val()*/});
			  
			  jQuery.blockUI({ message: '<h1 style="color:#FFFFFF;"><img src="../img/ajax-loader.gif" />Cargando Imagen...</h1>',
							   css: { 
										 border: 'none', 
										 padding: '15px', 
										 backgroundColor: '#000', 
										 '-webkit-border-radius': '10px', 
										 '-moz-border-radius': '10px', 
										 opacity: .5, 
										 color: '#fff'
							   }
							 });			  
			  /*button.attr("src","../img/loading.gif");*/
		  } else {				
			  // cancel upload
			  alert('solo imagenes');
			  return false;				
		  }	
		}else{	
		  jQuery('#foto'+curp).focus();
		  mensaje('{"tipo":"error","mensaje":"Especifique curp del participante para poder subir im&aacute;genes"}',2000); 			          return false;	
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
		{alert('No se cargo la imagen, excede el tama\u00F1o permitido, Redusca la imagen de tama\u00F1o, he intente de nuevo');
		 button.attr("src","../img/foto.png");}
		 jQuery.unblockUI();
	} 
	});
}
/*function mensaje(mensaje,class_mensaje,texto_mensaje)
{
	jQuery('#mensaje').html("<dl id=\"system-message\"><dt class=\""+class_mensaje+"\">"+texto_mensaje+"</dt><dd class=\""+class_mensaje+" message fade\"><ul><li>"+mensaje+"</li></ul></dd></dl>");
    var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);},5000);
}*/

////////////////////////////////////////////////////////////////////start Foto


function editar_foto()
{
	var x1 = jQuery('#x1').val();
	var y1 = jQuery('#y1').val();
	var x2 = jQuery('#x2').val();
	var y2 = jQuery('#y2').val();
	var w = jQuery('#w').val();
	var h = jQuery('#h').val();
	
	jQuery.blockUI({ message: '<h1 style="color:#FFFFFF;"><img src="../img/ajax-loader.gif" />Editando Imagen...</h1>',
							   css: { 
										 border: 'none', 
										 padding: '15px', 
										 backgroundColor: '#000', 
										 '-webkit-border-radius': '10px', 
										 '-moz-border-radius': '10px', 
										 opacity: .5, 
										 color: '#fff'
							   }
							 });
	jQuery.post("../scripts/EditarFoto.php", 
			  { x:x1, y:y1, w:w, h:h, evento:jQuery('#evento').val(), curp:curp_foto_editar, tipo_foto:tipo_foto}, function(data){jQuery.unblockUI();fotoeditada(data,curp_foto_editar);}
	);
}


function fotoeditada(data,curp)
{
	jQuery('#dialog_editar_imagen').dialog("close");
	jQuery('#foto'+curp).fadeOut(function(){			
			objImagePreloader.onload = function() {
				  jQuery('#foto'+curp)
				  .removeAttr('src')
				  .attr('src',"../fotosparticipanteseventothumb/"+jQuery('#evento').val()+"/"+curp+".png?nocache="+Math.random()*1000)
				  .fadeIn();
				}
				objImagePreloader.src = "../fotosparticipanteseventothumb/"+jQuery('#evento').val()+"/"+curp+".png?nocache="+Math.random()*1000;																		
	});
}

function editarfoto(curp_img,carpeta){	
    curp_foto_editar = curp_img; 	
	carpeta=(carpeta=='')? 'fotosparticipanteseventothumb/'+jQuery('#evento').val() : carpeta;
	if(carpeta=='') jQuery('#foto_comprimida').attr('checked', true);
	tipo_foto = carpeta;
	jQuery('#dialog_editar_imagen').css('display','inline');
	jQuery('#dialog_editar_imagen').dialog('open');		
	jQuery('#cropbox').remove();
	jQuery('#preview').remove();
	jQuery('#preview_td').html('<div style="width:70px;height:90px;overflow:hidden;">'             
							   +'<img id="preview" src="../img/foto.png"/>'
						  +'</div>');
	jQuery('#cropbox_td').html('<div style="width:auto;height:auto;overflow:hidden;">'    
							  +'<img id="cropbox_cargando" src="../img/cargando.gif"/>'
							  +'<img id="cropbox" src="../img/foto.png"/>'
						  +'</div>');
	
	jQuery('#preview').removeAttr('src').attr('src',"../"+carpeta+"/"+curp_img+".png?nocache="+Math.random()*1000);
	jQuery('#cropbox').fadeOut(function(){			
			   objImagePreloader.onload = function(){		      
			          
					  jQuery('#cropbox').css('width',objImagePreloader.width);
					  jQuery('#cropbox').css('height',objImagePreloader.height);
					  
					  jQuery('#cropbox')
					  .removeAttr('src')
					  .attr('src',"../"+carpeta+"/"+curp_img+".png?nocache="+Math.random()*1000)
					  .fadeIn().Jcrop({
									   onChange: showPreview,
									   onSelect: showPreview,								
									   aspectRatio: 0
					   }).load(function (){						                   						  
							               jQuery('#cropbox_cargando').css('display', 'none');										    
					   }).error(function (){						               						  
							               jQuery('#cropbox_cargando').css('display', 'none');
					   });		
					  
					   jQuery('#ancho_original').val(objImagePreloader.width);
					   jQuery('#alto_original').val(objImagePreloader.height);		 					   
					   
					   jQuery( "#dialog_editar_imagen" )
					   .dialog( "option", "width", "auto")
					   .dialog( "option", "height","auto")
					   .dialog( "option", "position", 'center' );				   
				}				
				objImagePreloader.src = "../"+carpeta+"/"+curp_img+".png?nocache="+Math.random()*1000;													
				jQuery("#dialog_editar_imagen" ).dialog( "option", "position", 'center' );						
	});	
	jQuery( "#dialog_editar_imagen" ).dialog( "option", "position", 'center' );
}

function showPreview(coords)
{	
		var ancho_original = jQuery('#ancho_original').val();
		var alto_original = jQuery('#alto_original').val();			
		
		jQuery('#x1').val(coords.x);
		jQuery('#y1').val(coords.y);
		jQuery('#x2').val(coords.x2);
		jQuery('#y2').val(coords.y2);
		jQuery('#w').val(coords.w);
		jQuery('#h').val(coords.h);
		
		if(parseFloat(ancho_original) <= 80 && parseFloat(alto_original) <= 110){ 		
		  var rx = ancho_original / coords.w;
		  var ry = alto_original / coords.h; 	
		  jQuery('#preview').css({
			  width: Math.round(rx * ancho_original) + 'px',
			  height: Math.round(ry * alto_original) + 'px',
			  marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			  marginTop: '-' + Math.round(ry * coords.y) + 'px'
		  });		
		}else{
		  var rx = coords.w / 70;
		  var ry = coords.h / 90; 		
		  jQuery('#preview').css({
			  width: Math.round(ancho_original / rx) + 'px',
			  height: Math.round(alto_original / ry) + 'px',
			  marginLeft: '-' + Math.round(coords.x / rx) + 'px',
			  marginTop: '-' + Math.round(coords.y / ry) + 'px'
		  }); 	
		}
}
////////////////////////////////////////////////////////////////////end Foto
////////////////////////////////////////////////////////////////////star Imprimir Gaffetes
function ImprimirGaffetes()
{	    
	var filtro = jQuery("#search").val();
	var campoenvio =  campo;
	var ordenenvio =  orden;
	var evento = jQuery('#evento').val();	
	var pais = jQuery('#filter_pais').val();
	var modalidad = jQuery('#filter_modalidad').val();			
	var ids = "";
	
	var array_check_me = new Array();
    jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});
	if(array_check_me.length>0){
		ids = array_check_me.join(',');
	}
	
	var caracteristicas ="height=700, width=800, scrollTo, resizable=0, toolbar=1, menubar=1, personalbar=1, scrollbars=1, location=0";	
	
	var variables = "filtro="+filtro+"&campo="+campoenvio+"&orden="+ordenenvio+"&evento="+evento+"&pais="+pais+"&modalidad="+modalidad+"&ids="+ids;
	
    nueva=window.open("../modulos/imprimir-gaffetes.php?"+variables, 'Popup', caracteristicas);	
    return false
}
////////////////////////////////////////////////////////////////////end Imprimir Gaffetes
////////////////////////////////////////////////////////////////////star Imprimir Reportes
function ImprimirReporte()
{	    
	var filtro = jQuery("#search").val();
	var campoenvio =  campo;
	var ordenenvio =  orden;
	var evento = jQuery('#evento').val();	
	var pais = jQuery('#filter_pais').val();
	var modalidad = jQuery('#filter_modalidad').val();			
	var ids = "";
	var ordenimprimir = arrayordenimprimir.join(',');
	
	var paistext = (pais!='') ? jQuery("#filter_pais option[value="+pais+"]").text() : '';
	var modalidadtext = (modalidad!='') ? jQuery("#filter_modalidad option[value="+modalidad+"]").text() : '';
	
	var array_check_me = new Array();
    jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});
	if(array_check_me.length>0){
		ids = array_check_me.join(',');
	}	
	
	var caracteristicas ="type=fullWindow,fullscreen, scrollTo, resizable=0, toolbar=0, menubar=0, personalbar=0, scrollbars=0, location=0";
	
    var tamano_hoja='letter'; var orientacion_hoja = 'l'; 
	var tamano_hoja_mm = 279; var tamano_fuente = 6.5; var separacion_linea = 1.5;	
	
	var variables_config_hoja = "&orientacion_hoja="+orientacion_hoja+"&tamano_hoja="+tamano_hoja+"&tamano_hoja_mm="+tamano_hoja_mm+"&tamano_fuente="+tamano_fuente+'&separacion_linea='+separacion_linea;
	
	var variables = "filtro="+filtro+"&campoenvio="+campoenvio+"&orden="+ordenenvio+"&evento="+evento+"&pais="+pais+"&modalidad="+modalidad+"&ids="+ids+"&ordenimprimir="+ordenimprimir+"&paistext="+paistext+"&modalidadtext="+modalidadtext;
	
    nueva=window.open("../fpdf/imprimir_reportes.php?"+variables+variables_config_hoja , 'Popup', caracteristicas);	
    return false
}
////////////////////////////////////////////////////////////////////end Imprimir Reportes