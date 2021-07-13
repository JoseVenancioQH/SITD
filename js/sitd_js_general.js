jQuery.noConflict();
var array_catalogos = new Array();
var array_catalogos_ids_envio = new Array();
var array_catalogos_nombres = new Array();
var array_catalogos_ids = new Array();
var id_catalogo = -1;

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };
jQuery.fn.reset = function () {jQuery(this).each (function() { this.reset(); });}

jQuery().ready(function(){
						
	jQuery(".autocomplete").focus(function(){      
      jQuery(this).select();
    });
	
	jQuery(".autocomplete").change(function(){  											
		var idselec = jQuery(this).attr('id');
		var dato = jQuery(this).val().trim();
		if(dato!=''){
		  id_catalogo = jQuery.inArray(idselec, array_catalogos);	  	  
		  if(array_catalogos_nombres.length!=0)var id_seleccion = jQuery.inArray(dato, array_catalogos_nombres[id_catalogo]);	
		  else var id_seleccion = -1;	  	  
		  if(id_seleccion<0)
		  {		      		  
			  jQuery.blockUI({ message: '<h3 style="color:#FFFFFF;"><img src="../img/ajax-loader.gif" />Grabando Catalogo...</h3>',
							   css: {border: 'none', padding: '15px', backgroundColor: '#000', '-webkit-border-radius': '10px', 
									   '-moz-border-radius': '10px', opacity: .5, color: '#fff'}
							});	
			  
			  jQuery.post("../scripts/caut_script_add_catalogo.php", {nombre: dato, catalogo:idselec, idempresa:jQuery('#idempresa').val()}, function(data){addarray(data,dato,idselec);});
			  
		  }else{		  	      
			  array_catalogos_ids_envio[id_catalogo]=array_catalogos_ids[id_catalogo][id_seleccion];			  
		  }	  
		}
    });
});

function addarray(data,dato,idselec)
{
  if(array_catalogos_ids.length!=0){	
    array_catalogos_ids[id_catalogo].push(data);	
    array_catalogos_nombres[id_catalogo].push(dato);		
	array_catalogos_ids_envio[id_catalogo]=data;	
	jQuery('#'+idselec).autocomplete(array_catalogos_nombres[id_catalogo],{selectFirst:false});
  }else{
	autocomplet_result('{"municipio":{"ids":["'+data+'"],"nombres":["'+dato+'"]}}');
  }
  jQuery.unblockUI();  	
}

function loaddata_autocomplet()
{	    
	jQuery('.autocomplete').each(function(i){		
		array_catalogos.push(jQuery(this).attr('id'));			 
		array_catalogos_ids_envio.push(-1);
	});
	
	jQuery.post("../scripts/caut_script_autocomplete_catalogo.php", {catalogos: array_catalogos.join(','), idempresa:jQuery('#idempresa').val()}, function(data){autocomplet_result(data);});			
}

function autocomplet_result(data)
{
  if(data!=''){	
	var data = eval('(' + data + ')');
	jQuery.each(array_catalogos,function(i_cat,d_cat){  								 
	  jQuery.each(data,function(i_data,d_data){	 		
	     array_catalogos_ids.push(d_data.ids);		 
		 array_catalogos_nombres.push(d_data.nombres);	 		 
	  });	  	  	  
	  jQuery('#'+d_cat).autocomplete(array_catalogos_nombres[i_cat],{selectFirst:false});
	});
  }
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