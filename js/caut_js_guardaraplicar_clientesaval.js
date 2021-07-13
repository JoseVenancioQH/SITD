jQuery.noConflict();
var idautocomplet = 0;
var idcliente = 0;
var array_autocomplet_nombre = Array();
var array_autocomplet_nombreaval = Array();

jQuery().ready(function(){
	jQuery("#form_clienteaval").validationEngine({promptPosition: "topRight"});	
	jQuery('.autocomplete_nombre').focus(function() {
      idautocomplet = jQuery(this).attr('id');	  
    });	
});

function validar(tipo)
{  	          	
    if(jQuery("#form_clienteaval").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_clienteaval").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	    
	  jQuery.post("../scripts/caut_script_"+tipo+"_clientesaval.php", 
				{idempresa: jQuery('#idempresa').val(), 
				 nomaval: jQuery('#nomaval').val(),
				 appaternoaval: jQuery('#appaternoaval').val(), 
				 apmaternoaval:  jQuery('#apmaternoaval').val(), 
				 diraval:  jQuery('#diraval').val(), 
				 telcasaval:  jQuery('#telcasa').val(),
				 telcelaval:  jQuery('#telcel').val(),				 
				 id:  jQuery('#id').val(),
				 cliente:  idcliente, 
				 municipio:  array_catalogos_ids_envio[jQuery.inArray('municipio', array_catalogos)]}, 
				 function(data){if(tipo=='guardar'){loaddata(data);}else{loaddataedit(data);}}				
	  );	   
}

function loaddataedit(data)
{
	mensaje(data,3000);
	var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);    location.href="../modulos/caut_mod_lista_clientesaval.php";},3000);
}

function loaddata(data)
{	
   mensaje(data,4000);   
   if(eval('(' + data + ')').tipo=='succes'){	 
	 array_autocomplet_nombre.push(eval({nombre:jQuery('#nomcliente').val(),appaterno:jQuery('#appaternocliente').val(),apmaterno:jQuery('#apmaternocliente').val(),direccion:jQuery('#dircliente').val()}));	 
	 autocomplete_renovar(array_autocomplet_nombre);
	 reset_var();	 
   }  
}

function reset_var()
{
	jQuery("#form_clienteaval").reset();
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/caut_script_editar_clientesaval.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");		
}

function load_edit_data(data)
{	    
	jQuery.each(data, function(i,item){		
		 jQuery('#nomaval').val(item.tb_avalcliente_nombre);
		 jQuery('#appaternoaval').val(item.tb_avalcliente_appaterno);
		 jQuery('#apmaternoaval').val(item.tb_avalcliente_apmaterno);
		 jQuery('#diraval').val(item.tb_avalcliente_direccion);
		 jQuery('#telcel').val(item.tb_avalcliente_telefonocel);
		 jQuery('#telcasa').val(item.tb_avalcliente_telefonocasa);
		 jQuery('#municipio').val(item.cat_municipio_nombre);
		 jQuery('#cliente').val(item.tb_cliente_nombre+' '+item.tb_cliente_appaterno+' '+item.tb_cliente_apmaterno);
	     array_catalogos_ids_envio[jQuery.inArray('municipio', array_catalogos)] = item.id_municipio;	 
		 idcliente = item.id_cliente;
	});
	jQuery('#cliente').attr('disabled',true);
}

function loaddata_autocomplet_nombre()
{		
	jQuery.post("../scripts/caut_script_autocomplete_nombreaval.php", {idempresa:jQuery('#idempresa').val()}, function(data){autocomplet_result_nombreaval(data);});
	
	jQuery.post("../scripts/caut_script_autocomplete_nombre.php", {idempresa:jQuery('#idempresa').val()}, function(data){autocomplet_result_nombre(data);});
}

function autocomplet_result_nombreaval(data)
{  	     
    array_autocomplet_nombreaval = eval(data);	
	autocomplete_renovaraval(eval(data));
}

function autocomplet_result_nombre(data)
{  	     
    array_autocomplet_nombre = eval(data);	
	autocomplete_renovar(eval(data));
}

function autocomplete_renovar(data)
{
	jQuery('#cliente').autocomplete(data, {
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
		    return row.nombre.toUpperCase() + " " + row.appaterno.toUpperCase() + " " + row.apmaterno.toUpperCase();						
		}
	}).result(function(event, item){idcliente=item.id_cliente; jQuery('#cliente').attr('disabled',true)});	
}


function autocomplete_renovaraval(data)
{
	jQuery('#nomaval').autocomplete(data, {
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
	
	jQuery('#appaternoaval').autocomplete(data, {
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
	
	jQuery('#apmaternoaval').autocomplete(data, {
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

function borrarcliente()
{	
	jQuery('#cliente').val('').attr('disabled',false);
	idcliente=0;
}
