jQuery.noConflict();

jQuery().ready(function(){		
	jQuery("#form_catasocdep").validationEngine({promptPosition: "topRight"});	
});

function validar(tipo)
{  	          	 
    if(jQuery("#form_catasocdep").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_catasocdep").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	    
   /*var nombrerama_var = '';		
   if(tipo!='gurdartodo')
   nombrerama_var=jQuery('#rama').val();}else{nombrerama_var=jQuery('#ids').val();}*/	
   if(tipo == 'guardartodo' ){var array_check_me = new Array();jQuery("#filter_asocdep_all option").each(function(){array_check_me.push(this.text)});}	
   jQuery.post("../scripts/sitd_script_"+tipo+"_catasocdep.php", {nombreasocdep: (tipo != 'guardartodo') ? jQuery('#asocdep').val() : array_check_me.join('<&>') , deportes: jQuery('#filter_deportes').val(), municipio: jQuery('#filter_municipio').val(), dircalle: jQuery('#dircalle').val(), dirnum: jQuery('#dirnum').val(), dircolonia: jQuery('#dircolonia').val(), acronimo: jQuery('#acronimo').val(), telconv: jQuery('#telconv').val(), telcel: jQuery('#telcel').val(), dircorreo: jQuery('#dircorreo').val(), idusuario:  jQuery('#idusuario').val(), id: jQuery('#id').val()}, function(data){loaddata(data,tipo);});
}

function loaddata(data,tipo)
{	
    mensaje(data,6000);
	if(tipo == 'guardartodo' || tipo == 'aplicar'){var sliderIntervalID = setInterval(function(){location.href="../modulos/sitd_mod_lista_catasocdep.php"; clearInterval(sliderIntervalID);},7000);}else
	{jQuery('#asocdep').val('');jQuery('#filter_municipio').val('');jQuery('#filter_deportes').val('');}    
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/sitd_script_editar_catasocdep.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");		
}


function load_edit_data(data)
{	    
	jQuery.each(data, function(i,item){	 
		 jQuery('#asocdep').val(item.nombreasocdep);		 
		 jQuery('#filter_municipio').val(item.idmunicipio);		
		 jQuery('#filter_deportes').val(item.iddeportes);		
		 jQuery('#dircalle').val(item.nombredircalle);				  
		 jQuery('#dirnum').val(item.nombredirnum);		 		 
		 jQuery('#dircolonia').val(item.nombredircolonia);
		 jQuery('#acronimo').val(item.nombreacronimo);		
		 jQuery('#telconv').val(item.telconv);		 
		 jQuery('#telcel').val(item.telcel);		
		 jQuery('#dircorreo').val(item.dircorreo);				
	});
}