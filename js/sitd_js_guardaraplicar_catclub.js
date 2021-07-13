jQuery.noConflict();

jQuery().ready(function(){		
	jQuery("#form_catclub").validationEngine({promptPosition: "topRight"});	
});

function validar(tipo)
{  	          	 
    if(jQuery("#form_catclub").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_catclub").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	    
   /*var nombrerama_var = '';		
   if(tipo!='gurdartodo')
   nombrerama_var=jQuery('#rama').val();}else{nombrerama_var=jQuery('#ids').val();}*/	
   if(tipo == 'guardartodo' ){var array_check_me = new Array();jQuery("#filter_club_all option").each(function(){array_check_me.push(this.text)});}	
   jQuery.post("../scripts/sitd_script_"+tipo+"_catclub.php", {nombreclub: (tipo != 'guardartodo') ? jQuery('#club').val() : array_check_me.join('<&>') , asocdep: jQuery('#filter_asocdep').val(), idusuario:  jQuery('#idusuario').val(), id: jQuery('#id').val()}, function(data){loaddata(data,tipo);});
}

function loaddata(data,tipo)
{	
    mensaje(data,6000);
	if(tipo == 'guardartodo' || tipo == 'aplicar'){var sliderIntervalID = setInterval(function(){location.href="../modulos/sitd_mod_lista_catclub.php"; clearInterval(sliderIntervalID);},7000);}else
	{jQuery('#club').val('');jQuery('#filter_asocdep').val('');}    
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/sitd_script_editar_catclub.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");		
}


function load_edit_data(data)
{	    
	jQuery.each(data, function(i,item){	 
		 jQuery('#club').val(item.nombreclub);		 
		 jQuery('#filter_asocdep').val(item.idasocdep);		
	});
}