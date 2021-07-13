jQuery.noConflict();
var idautocomplet = 0;
var array_autocomplet_nombre = Array();

jQuery().ready(function(){
	jQuery("#form_cliente").validationEngine({promptPosition: "topRight"});	
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
  jQuery.post("../scripts/sitd_script_"+tipo+"_catmoded.php", 
  {nombrecatmoded: jQuery('#catmoded').val(), eventonacional: jQuery('#filter_eventonacional').val(), idusuario:  jQuery('#idusuario').val(), id: jQuery('#id').val()}, function(data){loaddata(data);});		   
}

function loaddataedit(data)
{
	mensaje(data,3000);
	var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);    location.href="../modulos/sitd_mod_lista_catmoded.php";},3000);
}

function loaddata(data)
{	
   mensaje(data,4000);   
   var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);},3000);
   reset_var();
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

function autocomplete_renovar(data)
{
	jQuery('#nomcliente').autocomplete(data, {
		minChars: 0,
		width: 600,
		matchContains: "word",
		autoFill: false,
		selectFirst: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + row.nombre.toUpperCase() + " " + row.appaterno.toUpperCase() + " " + row.apmaterno.toUpperCase() + "\" [" + row.direccion.toUpperCase() + "]";
		},
		formatMatch: function(row, i, max) {
			return row.nombre + " " + row.appaterno + " " + row.apmaterno;
		},
		formatResult: function(row) {		
		    return row.nombre.toUpperCase();			
		}
	});	
	
	jQuery('#appaternocliente').autocomplete(data, {
		minChars: 0,
		width: 600,
		matchContains: "word",
		autoFill: false,
		selectFirst: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + row.nombre.toUpperCase() + " " + row.appaterno.toUpperCase() + " " + row.apmaterno.toUpperCase() + "\" [" + row.direccion.toUpperCase() + "]";
		},
		formatMatch: function(row, i, max) {
			return row.nombre + " " + row.appaterno + " " + row.apmaterno;
		},
		formatResult: function(row) {		
		    return row.appaterno.toUpperCase();			
		}
	});
	
	jQuery('#apmaternocliente').autocomplete(data, {
		minChars: 0,
		width: 600,
		matchContains: "word",
		autoFill: false,
		selectFirst: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \"" + row.nombre.toUpperCase() + " " + row.appaterno.toUpperCase() + " " + row.apmaterno.toUpperCase() + "\" [" + row.direccion.toUpperCase() + "]";
		},
		formatMatch: function(row, i, max) {
			return row.nombre + " " + row.appaterno + " " + row.apmaterno;
		},
		formatResult: function(row) {				    
			return row.apmaterno.toUpperCase();			
		}
	});
}
