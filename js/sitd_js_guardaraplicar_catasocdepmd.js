jQuery.noConflict();

jQuery().ready(function(){		
	jQuery("#form_catasocdepmd").validationEngine({promptPosition: "topRight"});	
});

function validar(tipo)
{  	          	 
    if(jQuery("#form_catasocdepmd").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_catasocdepmd").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	    
   /*var nombrerama_var = '';		
   if(tipo!='gurdartodo')
   nombrerama_var=jQuery('#rama').val();}else{nombrerama_var=jQuery('#ids').val();}*/	   
   jQuery.post("../scripts/sitd_script_"+tipo+"_catasocdepmd.php", {asocdep: jQuery('#filter_asocdep').val(), nombre: jQuery('#nombre').val(), app: jQuery('#app').val(), apm: jQuery('#apm').val(), cargo: jQuery('#cargo').val(), telefono: jQuery('#telefono').val(), dom: jQuery('#dom').val(), rfc: jQuery('#rfc').val(), idusuario:  jQuery('#idusuario').val(), id: jQuery('#id').val()}, function(data){loaddata(data,tipo);});
}

function loaddata(data,tipo)
{	
    mensaje(data,6000);
	if(tipo == 'guardartodo' || tipo == 'aplicar'){var sliderIntervalID = setInterval(function(){location.href="../modulos/sitd_mod_lista_catasocdepmd.php"; clearInterval(sliderIntervalID);},7000);}else
	{jQuery('#filter_asocdep').val('');jQuery('#nombre').val('');jQuery('#app').val('');jQuery('#apm').val('');jQuery('#cargo').val('');jQuery('#telefono').val('');jQuery('#dom').val('');jQuery('#rfc').val('');}    
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/sitd_script_editar_catasocdepmd.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");		
}


function load_edit_data(data)
{
	jQuery.each(data, function(i,item){	 
		 jQuery('#filter_asocdep').val(item.idasocdep);
		 jQuery('#nombre').val(item.nombremesadir);
		 jQuery('#app').val(item.mesadirapp);		
		 jQuery('#apm').val(item.mesadirapm);
 		 jQuery('#cargo').val(item.mesadircargo);
		 jQuery('#telefono').val(item.mesadirtel);
		 jQuery('#dom').val(item.mesadirdom);
		 jQuery('#rfc').val(item.mesadirrfc);
	});
}