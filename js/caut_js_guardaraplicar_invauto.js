jQuery.noConflict();

jQuery().ready(function(){			
	jQuery("#form_invauto").validationEngine({promptPosition: "topRight"});		
	
	jQuery('.nodo').click(function(){var checked_nodo = this.checked; jQuery("input[name='"+this.name+"']").each(function(){this.checked = checked_nodo});});	
	
	jQuery('input[type="text"]').blur(function(){jQuery("#form_invauto").validationEngine('hideAll');});		
	
	jQuery('#noserie').change(function(){if(jQuery('#noserie').val()!='')jQuery('#mensaje').html('');});
	
	jQuery('#si').click(function(){eliminar_foto_todas(); jQuery.unblockUI();});
	
	jQuery('#no').click(function(){jQuery.unblockUI(); return false;});
	
	var button = jQuery('#upload_button');	
	new AjaxUpload(button,{		
	action: '../scripts/upload.php', 
	name: 'userfile',
	onSubmit : function(file, ext){	
	    if(jQuery('#noserie').val()!=''){
		  if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){		    
			  /* Setting data */
			  this.setData({'noserie'    :   jQuery('#noserie').val(),
							'overwrite'  :   "no",
							'action'     :   "image",
							'idempresa'    :   jQuery('#idempresa').val()});
			  
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
		  jQuery('#noserie').focus();
		  mensaje('{"tipo":"error","mensaje":"Capture N&uacute;mero de Serie del Auto para poder subir im&aacute;genes, solo podra modificar el N&uacute;mero de Serie si elimina todas las fotos agregadas..."}',0); 	   		  
		  return false;	
		}
	},
	onComplete: function(file, response){		
	    if(response != '0'){
			var nomfoto = response.split('.')[0]
			jQuery('#imgautos').prepend('<tr id="'+nomfoto+'"><td style="text-align:center;"><a href="'+'../imgautos/'+jQuery('#idempresa').val()+'/'+jQuery('#noserie').val()+'/'+response+"?nocache="+Math.random()*1000+'" rel="autos"><img src="'+'../imgautosthumb/'+jQuery('#idempresa').val()+'/'+jQuery('#noserie').val()+'/'+response+"?nocache="+Math.random()*1000+'"/></a></td></tr><tr id="'+nomfoto+'_eliminar"><td class="button"><a href="javascript:eliminar_foto(\''+jQuery('#idempresa').val()+'/'+jQuery('#noserie').val()+'/'+response+'\',\''+nomfoto+'\')">Eliminar</a></td></tr>');	
			jQuery("a[rel='autos']").colorbox({slideshow:true});
			jQuery.unblockUI();
			jQuery('#noserie').attr('disabled',true);
		}else{
			alert('No se cargo la imagen, excede el tama\u00F1o permitido, Redusca la imagen de tama\u00F1o, he intente de nuevo');
		}
	} 
	});
	
});

function validar(tipo)
{  	          	   		
    if(jQuery("#form_invauto").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_invauto").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function eliminar_foto(foto,nomfoto)
{
	jQuery.post("../scripts/caut_script_eliminar_foto.php", {foto:foto}, function(data){res_elimina_foto(data,nomfoto);});
}

function res_elimina_foto(data,nomfoto)
{
	jQuery('#'+nomfoto).remove();jQuery('#'+nomfoto+'_eliminar').remove();
	 if(jQuery('#imgautos tr').length==0){
		jQuery('#noserie').attr('disabled',false);
	    jQuery('#imgautos').html(''); 		 
	 }
}

function eliminar_foto_todas()
{
	if(jQuery('#noserie').val()==''){
	   jQuery('#noserie').focus();
	   mensaje('{"tipo":"error","mensaje":"Capture Numero de Serie del Auto para poder subir imagenes, solo podra modificar el Numero de Serie si elimina todas las fotos agregadas..."}',0); 	   
	}else{	
	   if(jQuery('#imgautos tr').length>0){
	      jQuery.post("../scripts/caut_script_eliminar_foto_todas.php", {noserie:jQuery('#noserie').val(), idempresa:jQuery('#idempresa').val()}, function(data){res_elimina_foto_todas(data);});		
	   }else{		  
		  mensaje('{"tipo":"error","mensaje":"Sin imagenes para borrar..."}',4000); 
	   } 
	}	
}

function res_elimina_foto_todas(data)
{
	jQuery('#noserie').attr('disabled',false);
	jQuery('#imgautos').html('');
}

function guardar_aplicar(tipo)
{	    
      var array_comext = new Array();
	  var array_comint = new Array();
	  var array_acc = new Array();
	  var array_commec = new Array();	  	  
	  
      jQuery("input[name='ex[]']:checked:not(#comext)").each(function(){array_comext.push(this.id)});	  
	  jQuery("input[name='in[]']:checked:not(#comint)").each(function(){array_comint.push(this.id)});	  
	  jQuery("input[name='ac[]']:checked:not(#acc)").each(function(){array_acc.push(this.id)});	  
	  jQuery("input[name='cm[]']:checked:not(#commec)").each(function(){array_commec.push(this.id)});
	  
	  jQuery.post("../scripts/caut_script_"+tipo+"_invauto.php", 
		{idempresa: jQuery('#idempresa').val(),
		 idauto: jQuery('#id').val(),
		 noserie: jQuery('#noserie').val(),
		 nopedimento: jQuery('#nopedimento').val(),
		 millas:  jQuery('#millas').val(),
		 noplacas:  jQuery('#noplacas').val(),
		 nomotor:  jQuery('#nomotor').val(),
		 norfa:  jQuery('#norfa').val(),
		 nofactura:  jQuery('#nofactura').val(),
		 notenencia:  jQuery('#notenencia').val(),
		 tcirculacion:  jQuery('#tcirculacion').val(),
		 kmrecorridos:  jQuery('#kmrecorridos').val(),
		 color:  array_catalogos_ids_envio[jQuery.inArray('color', array_catalogos)],
		 marca:  array_catalogos_ids_envio[jQuery.inArray('marca', array_catalogos)],
		 modelo:  array_catalogos_ids_envio[jQuery.inArray('modelo', array_catalogos)],
		 linea:  array_catalogos_ids_envio[jQuery.inArray('linea', array_catalogos)],
		 tipo:  array_catalogos_ids_envio[jQuery.inArray('tipo', array_catalogos)],
		 cilindros:  array_catalogos_ids_envio[jQuery.inArray('cilindros', array_catalogos)],
		 comext:  array_comext.join(','),
		 comint:  array_comint.join(','),
		 acc:  array_acc.join(','),
		 commec:  array_commec.join(',')}
		 , function(data){guardar_aplicar_result(data);});	   
}

function guardar_aplicar_result(data)
{	   
   mensaje(data,4000);   
   if(eval('(' + data + ')').tipo=='succes'){
	 reset_var();
	 location.href="../modulos/caut_mod_lista_invauto.php";
   }else{
	 jQuery('#noserie').attr('disabled',false);
   }   
}

function reset_var()
{
	jQuery('#noserie').attr('disabled',false);
	jQuery('#imgautos').html('');
	array_catalogos_ids_envio=[];
	jQuery("#form_invauto").reset();
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/caut_script_editar_invauto.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");		
}

function load_edit_data(data)
{   
  jQuery.each(data, function(i,item){		
	   if(item.imagenes!=''){ 						 
		 jQuery.each(item.imagenes.split(','), function(i_img,item_img){
			var nomfoto = item_img.split('.')[0]
			jQuery('#imgautos').prepend('<tr id="'+nomfoto+'"><td style="text-align:center;"><a href="'+'../imgautos/'+item.idempresa+'/'+item.noserie+'/'+item_img+"?nocache="+Math.random()*1000+'" rel="autos"><img src="'+'../imgautosthumb/'+item.idempresa+'/'+item.noserie+'/'+item_img+"?nocache="+Math.random()*1000+'"/></a></td></tr><tr id="'+nomfoto+'_eliminar"><td class="button"><a href="javascript:eliminar_foto(\''+item.idempresa+'/'+item.noserie+'/'+item_img+'\',\''+nomfoto+'\')">Eliminar</a></td></tr>');							   
		 });	   	
		 jQuery('#noserie').attr('disabled',true);
	   }else{jQuery('#noserie').attr('disabled',false);}
	   jQuery('#id').val(item.idauto);
	   jQuery('#noserie').val(item.noserie);
	   jQuery('#nopedimento').val(item.nopedimento);
	   jQuery('#millas').val(item.millas);
	   jQuery('#noplacas').val(item.noplaca);
	   jQuery('#nomotor').val(item.nomotor);
	   jQuery('#norfa').val(item.norfa);
	   jQuery('#nofactura').val(item.nacnofactura);
	   jQuery('#notenencia').val(item.nacnotenencia);
	   jQuery('#tcirculacion').val(item.nactcirculacion);
	   jQuery('#kmrecorridos').val(item.nackmrecorrido);
	   jQuery('#marca').val(item.marca);
	   jQuery('#modelo').val(item.modelo);
	   jQuery('#linea').val(item.linea);
	   jQuery('#tipo').val(item.tipo);
	   jQuery('#color').val(item.color);
	   jQuery('#cilindros').val(item.cilindros);
	   array_catalogos_ids_envio[jQuery.inArray('color', array_catalogos)] = item.idcolor;
	   array_catalogos_ids_envio[jQuery.inArray('marca', array_catalogos)] = item.idmarca;
	   array_catalogos_ids_envio[jQuery.inArray('modelo', array_catalogos)] = item.idmodelo;
	   array_catalogos_ids_envio[jQuery.inArray('linea', array_catalogos)] = item.idlinea;
	   array_catalogos_ids_envio[jQuery.inArray('tipo', array_catalogos)] = item.idtipo;
	   array_catalogos_ids_envio[jQuery.inArray('cilindros', array_catalogos)] = item.idcilindros;	   
	   if(item.exterior!=''){
		   jQuery.each(item.exterior.split(','), function(i_ext,item_ext){jQuery('#'+item_ext).attr('checked', true);});
	   }
	   if(item.interior!=''){
	       jQuery.each(item.interior.split(','), function(i_int,item_int){jQuery('#'+item_int).attr('checked', true);});
	   }
	   if(item.accesorio!=''){
	       jQuery.each(item.accesorio.split(','), function(i_acc,item_acc){jQuery('#'+item_acc).attr('checked', true);});
	   }
	   if(item.compmec!=''){
	       jQuery.each(item.compmec.split(','), function(i_com,item_com){jQuery('#'+item_com).attr('checked', true);});
	   }
  });
  jQuery("a[rel='autos']").colorbox({slideshow:true});  
}