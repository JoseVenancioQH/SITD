jQuery.noConflict();

jQuery().ready(function(){	
	jQuery("#prueba").keypress(function(event) {
	  if(event.which == 13) {
		addprueba();
	  }	  
	});
	
	jQuery("#add").click(function(){								  
		 addprueba();  
	});
	
	jQuery("#form_catcat").validationEngine({promptPosition: "topRight"});		
	
	
	//jQuery("#catanoinicio").datepicker({
//      /*defaultDate: "+1w",
//      changeMonth: true,*/      
//	  dateFormat: 'dd-mm-yy',
//      onClose: function( selectedDate ) {		
//        jQuery( "#catanoinicio" ).datepicker( "option", "minDate", selectedDate );
//      }
//    });	
//	
//    jQuery( "#catanofin" ).datepicker({
//      /*defaultDate: "+1w",
//      changeMonth: true,
//      numberOfMonths: 3,*/
//	  dateFormat: 'dd-mm-yy',
//      onClose: function( selectedDate ) {
//        jQuery( "#catanofin" ).datepicker( "option", "maxDate", selectedDate );
//      }
//    });	
	
	jQuery('#filter_eventonacional').change(function(){
			var lista_cat='deportes,rama,moddep';	   											 
			var array_lista=lista_cat.split(',');											 
			if(this.value!=""){											 		   
			   jQuery.post("../scripts/sitd_script_listacombo_catcat.php", {ideventonacional: this.value, lista:lista_cat}, function(data){loaddatalistacombo(data,lista_cat);},"json");			
			}else{jQuery.each(array_lista,function(ilista,datalista){jQuery('#filter_'+datalista).empty().append('<option value="" selected>- Selecciona '+datalista+' -</option>').attr('disabled','disabled')});}
	});	
	
	jQuery('#catanoinicio').change(function(){
		   /*var d = new Date(); 
		   d=d.getFullYear(); */		   
		   jQuery('#catanofin').empty().append('<option value="" selected>- Selecciona A&ntilde;o Fin -</option>')
		   for (var i = this.value; i >= 1940; i--){
			   jQuery('#catanofin').append('<option value="'+i+'">'+i+'</option>');
		   }			
	});	
	
});

function cargarcombo(id,iddeporte,idrama,idmoddep)
{
	var lista_cat='deportes,rama,moddep';	   											 
	var array_lista=lista_cat.split(',');											 
	if(id!=""){											 		   
	   jQuery.post("../scripts/sitd_script_listacombo_catcat.php", {ideventonacional: id, lista:lista_cat}, function(data){loaddatalistacombo(data,lista_cat);},"json");			
	}else{jQuery.each(array_lista,function(ilista,datalista){jQuery('#filter_'+datalista).empty().append('<option value="" selected>- Selecciona '+datalista+' -</option>').attr('disabled','disabled')});}
}

function addprueba()
{
	 var ban = true;
	 jQuery('#tbprueba tbody tr').each(function(i){	
		if(jQuery(this).children("td").eq(2).html()==jQuery('#prueba').val())
		{ban=false;}
	 });
	 if(jQuery('#prueba').val()!='' && ban){
	   jQuery('#tbprueba tbody tr').each(function(i){	
		  jQuery(this).children("td").eq(0).html(jQuery('#tbprueba tbody tr').length-i);										
	   });
	   var index = jQuery('#tbprueba tbody tr').length+1;
	   jQuery('#tbprueba tbody').prepend('<tr id="tr'+index+'">'+
	   '<td ALIGN="CENTER">'+eval(index)+'</td>'+		 
	   '<td ALIGN="CENTER"><a href="#" onclick="javascript:borrarprueba('+index+')"><img src="../img/del16px.png"></a></td>'+
	   '<td>'+jQuery('#prueba').val()+'</td>'+
	   '</tr>');  
	   jQuery('#prueba').val('').focus(); 
	 }else{mensaje('{"tipo":"error","mensaje":"Introdusca el nombre de la prueba &oacute; prueba duplicada <<<< '+jQuery('#prueba').val()+' >>>> ..."}',6000);}
}

function borrarprueba(num)
{
	jQuery("#tr"+num).remove().fadeOut(800);
	jQuery('#tbprueba tbody tr').each(function(i){			
      jQuery(this).children("td").eq(0).html(jQuery('#tbprueba tbody tr').length-i);
    });	
}

function loaddatalistacombo(data,lista)
{									 
	arraylista = lista.split(',');
	jQuery.each(data,function(ilista,datalista){								 
	  if(datalista.length!=0 && datalista != ""){
		jQuery('#filter_'+ilista).empty().removeAttr('disabled').append('<option value="">- Selecciona '+ilista+' -</option>');	 
		jQuery.each(datalista, function(i,item){	
		   jQuery('#filter_'+ilista).append('<option value="'+item.id+'">'+item.nombre+'</option>');					   	
		});			
	  }else{jQuery('#filter_'+ilista).empty().append('<option value="" selected>- Selecciona '+ilista+' -</option>').attr('disabled','disabled');}
    });	
}

function validar(tipo)
{  	          	 
    if(jQuery("#form_catcat").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_catcat").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	   	
   var array_pruebas = new Array();
   jQuery('#tbprueba tbody tr').each(function(index){array_pruebas.push(jQuery(this).children("td").eq(2).text());});
   
   /*alert(array_pruebas.serializeArray());*/   
   /*jQuery('#tbprueba tbody tr td:eq(0)').each(function(index){alert(jQuery(this).text);});
   
   alert(jQuery('#tbprueba tbody tr .dato_prueba td').each(function(){this.text}));   
   alert(JSON.stringify({myarray: array_pruebas}));*/
   
   if(tipo == 'guardartodo' ){var array_check_me = new Array();jQuery("#filter_rama_all option").each(function(){array_check_me.push(this.text)});}
   
   jQuery.post("../scripts/sitd_script_"+tipo+"_catcat.php", {nombrecat: (tipo != 'guardartodo') ? jQuery('#cat').val() : array_check_me.join('<&>') , eventonacional: jQuery('#filter_eventonacional').val(), idusuario:  jQuery('#idusuario').val(), catanoinicio:jQuery('#catanoinicio').val(), catanofin:jQuery('#catanofin').val(),  filter_deportes:jQuery('#filter_deportes').val(), filter_rama:jQuery('#filter_rama').val(), filter_moddep:jQuery('#filter_moddep').val(), pruebas:array_pruebas.join('<&>'), id: jQuery('#id').val()}, function(data){loaddata(data,tipo);});   
}

function loaddata(data,tipo)
{	
    mensaje(data,6000);
	if(tipo == 'guardartodo' || tipo == 'aplicar'){var sliderIntervalID = setInterval(function(){location.href="../modulos/sitd_mod_lista_catcat.php"; clearInterval(sliderIntervalID);},7000);}else
	{jQuery('#cat').val('');/*jQuery('#filter_eventonacional').val('');*//*jQuery('#filter_deportes').val('').empty().append('<option value="" selected>- Selecciona Deportes -</option>').attr('disabled','disabled');jQuery('#filter_rama').val('').empty().append('<option value="" selected>- Selecciona Rama -</option>').attr('disabled','disabled');jQuery('#filter_moddep').val('').empty().append('<option value="" selected>- Selecciona Modalidad Deportiva -</option>').attr('disabled','disabled');*/ jQuery('#tbprueba tbody tr').remove();}    
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/sitd_script_editar_catcat.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");		
}

function load_edit_data(data)
{	    
	jQuery.each(data, function(i,item){	 		 
         jQuery('#catanoinicio').val(item.catanoinicio);
		 jQuery('#catanofin').val(item.catanofin);		 
		 jQuery('#cat').val(item.catnombre);		 
		 jQuery('#filter_eventonacional').val(item.idevenac);				 
		 cargarcombo(item.idevenac);		 
		 jQuery("#filter_deportes option[value="+ item.iddeporte +"]").attr("selected",true);
		 jQuery("#filter_rama option[value="+ item.idrama +"]").attr("selected",true);
		 jQuery("#filter_moddep option[value="+ item.idmoddep +"]").attr("selected",true);		  
	});
}