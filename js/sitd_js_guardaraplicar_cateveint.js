jQuery.noConflict();

jQuery().ready(function(){		
	jQuery("#form_catevenac").validationEngine({promptPosition: "topRight"});	
	jQuery( "#fechainicio" ).datepicker({
      /*defaultDate: "+1w",*/
      changeMonth: true,
      numberOfMonths: 3,
	  dateFormat: 'dd-mm-yy',
      onClose: function( selectedDate ) {		
        jQuery( "#fechatermina" ).datepicker( "option", "minDate", selectedDate );
      }
    });	
    jQuery( "#fechatermina" ).datepicker({
      /*defaultDate: "+1w",*/
      changeMonth: true,
      numberOfMonths: 3,
	  dateFormat: 'dd-mm-yy',
      onClose: function( selectedDate ) {
        jQuery( "#fechainicio" ).datepicker( "option", "maxDate", selectedDate );
      }
    });	
});

function validar(tipo)
{  	          	 
    if(jQuery("#form_cateveint").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_cateveint").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	    
   /*var nombrerama_var = '';		
   if(tipo!='gurdartodo')
   nombrerama_var=jQuery('#rama').val();}else{nombrerama_var=jQuery('#ids').val();}*/	
   /*if(tipo == 'guardartodo' ){var array_check_me = new Array();jQuery("#filter_evenac_all option").each(function(){array_check_me.push(this.text)});}	*/
   jQuery.post("../scripts/sitd_script_"+tipo+"_cateveint.php", {nombreeveint: jQuery('#eveint').val() , fechainicio: jQuery('#fechainicio').val(), fechatermina: jQuery('#fechatermina').val(), idusuario:  jQuery('#idusuario').val(), id: jQuery('#id').val()}, function(data){loaddata(data,tipo);});
}

function loaddata(data,tipo)
{	
    mensaje(data,6000);
	if(tipo == 'guardartodo' || tipo == 'aplicar'){var sliderIntervalID = setInterval(function(){location.href="../modulos/sitd_mod_lista_cateveint.php"; clearInterval(sliderIntervalID);},7000);}else
	{jQuery('#eveint').val('');jQuery('#filter_eventointer').val('');}    
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/sitd_script_editar_cateveint.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");  
}

function load_edit_data(data)
{	   
	jQuery.each(data, function(i,item){								   
	   jQuery('#eveint').val(item.nombreeveint);	   
	   /*var fechainicio_date = new Date(item.fechainicio.split('-')[2],item.fechainicio.split('-')[1],item.fechainicio.split('-')[0]);
	   
	   var fechatermina_date = new Date(item.fechatermina.split('-')[2],item.fechatermina.split('-')[1],item.fechatermina.split('-')[0]); */	   
	   jQuery('#fechainicio').datepicker("setDate",item.fechainicio);
	   jQuery('#fechatermina').datepicker("setDate",item.fechatermina);
	});
}