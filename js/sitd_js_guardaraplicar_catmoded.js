jQuery.noConflict();
var idautocomplet = 0;
var array_autocomplet_nombre = Array();

jQuery().ready(function(){
	jQuery("#form_catmoded").validationEngine({promptPosition: "topRight"});	
	jQuery('.autocomplete_nombre').focus(function() {
      idautocomplet = jQuery(this).attr('id');	  
    });	
});

function validar(tipo)
{  	          	
    if(jQuery("#form_catmoded").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_catmoded").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	    
       if(tipo == 'guardartodo')
	   {var array_check_me = new Array();jQuery("#filter_moded_all option").each(function(){array_check_me.push(this.text)});}	
       jQuery.post("../scripts/sitd_script_"+tipo+"_catmoded.php",
				   {nombrecatmoded: (tipo != 'guardartodo') ? jQuery('#catmoded').val() : array_check_me.join('<&>') , 
				   eventonacional: jQuery('#filter_eventonacional').val(), 
				   idusuario:  jQuery('#idusuario').val(),
				   id: jQuery('#id').val()}, 
				   function(data){loaddata(data,tipo);});
   
	  /*jQuery.post("../scripts/sitd_script_"+tipo+"_catmoded.php", 
				{nombrecatmoded: jQuery('#catmoded').val(), eventonacional: jQuery('#filter_eventonacional').val(), idusuario:  jQuery('#idusuario').val(), id: jQuery('#id').val()}, function(data){loaddata(data);});*/		   
}

function loaddataedit(data,tipo)
{
	mensaje(data,3000);
	if(tipo == 'guardartodo' || tipo == 'aplicar'){var sliderIntervalID = setInterval(function(){location.href="../modulos/sitd_mod_lista_catmoded.php"; clearInterval(sliderIntervalID);},5000);}else
	{jQuery('#catmoded').val('');jQuery('#filter_eventonacional').val('');}	
	
}

function loaddata(data,tipo)
{	
   mensaje(data,3000);   
  if(tipo == 'guardartodo'){var sliderIntervalID = setInterval(function(){location.href="../modulos/sitd_mod_lista_catmoded.php"; clearInterval(sliderIntervalID);},5000);}else
	{jQuery('#catmoded').val('');jQuery('#filter_eventonacional').val('');}	
   
}

function reset_var()
{
	jQuery("#form_catmoded").reset();
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/sitd_script_editar_catmoded.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");		
}

function load_edit_data(data)
{	    
	jQuery.each(data, function(i,item){	 
		 jQuery('#catmoded').val(item.nombremoded);		 
		 jQuery('#filter_eventonacional').val(item.ideventonacional);		
	});
}

function loaddata_autocomplet_nombre()
{		
	jQuery.post("../scripts/caut_script_autocomplete_nombre.php", {idempresa:jQuery('#idempresa').val()}, function(data){autocomplet_result_nombre(data);});			
}

function autocomplet_result_nombre(data)
{  	     
    array_autocomplet_nombre = eval(data);	
	autocomplete_renovar(eval(data));
}

