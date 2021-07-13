jQuery.noConflict();
var idautocomplet = 0;
var idauto = 0;
var array_autocomplet_invcosto = Array();

jQuery().ready(function(){
    jQuery(".numericreal").numeric({ negative: false });
	jQuery("#form_invcosto").validationEngine({promptPosition: "topRight"});	
	jQuery('.autocomplete_invcosto').focus(function() {
      idautocomplet = jQuery(this).attr('id');	  
    });	
});

function validar(tipo)
{  	          	
    if(jQuery("#form_invcosto").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_invcosto").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	    
	  jQuery.post("../scripts/caut_script_"+tipo+"_invcosto.php", 
				{idempresa: jQuery('#idempresa').val(), 
				 tipocosto: jQuery('#tipocosto').val(),
				 psiniva: jQuery('#psiniva').val(), 
				 anticipo:  jQuery('#anticipo').val(), 
				 pcontado:  jQuery('#pcontado').val(), 				 				 
				 id:  jQuery('#id').val(),				 
				 idauto:  idauto}, 
				 function(data){if(tipo=='guardar'){loaddata(data);}else{loaddataedit(data);}}				
	  );	   
}

function loaddataedit(data)
{
	mensaje(data,3000);
	var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);    location.href="../modulos/caut_mod_lista_invcosto.php";},3000);
}

function loaddata(data)
{	
   mensaje(data,4000);   
   if(eval('(' + data + ')').tipo=='succes'){	 
	 /*array_autocomplet_nombre.push(eval({nombre:jQuery('#nomcliente').val(),appaterno:jQuery('#appaternocliente').val(),apmaterno:jQuery('#apmaternocliente').val(),direccion:jQuery('#dircliente').val()}));	 
	 autocomplete_renovar(array_autocomplet_nombre);*/
	 reset_var();	 
   }  
}

function reset_var()
{
	jQuery("#form_invcosto").reset();
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/caut_script_editar_invcosto.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");		
}

function load_edit_data(data)
{	    
	jQuery.each(data, function(i,item){						
		 jQuery('#tipocosto').val(item.tipocosto);
		 jQuery('#psiniva').val(item.psiniva);
		 jQuery('#anticipo').val(item.anticipo);
		 jQuery('#pcontado').val(item.contado);	
		 jQuery('#auto').val(item.noserie.toUpperCase() + " - " + item.nopedimento.toUpperCase() + " - " + item.marca.toUpperCase()+ " - " + item.modelo.toUpperCase()+ " - " + item.linea.toUpperCase()+ " - " + item.tipo.toUpperCase());	     
		 idauto = item.idauto;
	});
	jQuery('#auto').attr('disabled',true);
}

function loaddata_autocomplet_invcosto()
{		
	jQuery.post("../scripts/caut_script_autocomplete_invcosto.php", {idempresa:jQuery('#idempresa').val()}, function(data){autocomplet_result_invcosto(data);});
}

function autocomplet_result_invcosto(data)
{    
    array_autocomplet_invcosto = eval(data);	
	autocomplete_renovar(eval(data));
}

function autocomplete_renovar(data)
{
	jQuery('#auto').autocomplete(data, {
		minChars: 0,
		width: 900,
		matchContains: "word",
		autoFill: false,
		selectFirst: false,
		formatItem: function(row, i, max) {
			return i + "/" + max + ": \" [Serie: " + row.noserie.toUpperCase() + "]  [Pedimento:" + row.nopedimento.toUpperCase() + "]  [Marca:" + row.marca.toUpperCase() + "]  [Modelo:" + row.modelo.toUpperCase() + "]  [Linea:" + row.linea.toUpperCase()+ "]  [Tipo:" + row.tipo.toUpperCase()+"] \"";
		},
		formatMatch: function(row, i, max) {
			return row.noserie + " " + row.nopedimento + " " + row.marca+ " " + row.modelo+ " " + row.linea+ " " + row.tipo;
		},
		formatResult: function(row) {				   
		    return row.noserie.toUpperCase() + " - " + row.nopedimento.toUpperCase() + " - " + row.marca.toUpperCase()+ " - " + row.modelo.toUpperCase()+ " - " + row.linea.toUpperCase()+ " - " + row.tipo.toUpperCase();						
		}
	}).result(function(event, item){idauto=item.idauto; jQuery('#auto').attr('disabled',true)});	
}

function borrarauto()
{	
	jQuery('#auto').val('').attr('disabled',false);
	idauto=0;
}
