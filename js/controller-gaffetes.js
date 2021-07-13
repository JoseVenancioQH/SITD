var validado_sub = 'si';
var cont_ordenar = 0;
var lista_ordenar = new Array();
var lista_ordenar_text = new Array();
$().ready(function(){	
	$(function(){					   	
		$('#dialog_editar_imagen').dialog({
			autoOpen: false,
			width: 'auto',
			position:'center',
		 	buttons: {
				"Editar": function() {					 					 					 
					 editar_foto();
				}, 
				"Salir": function() {				    
				   /* $.validationEngine.closePrompt(".formError", true);	*/				
					$(this).dialog("close"); 
				} 
			}
		});	
	});		
	
	$('#anoinicio').change(function(){
		var value_select = this.value;
		var var_select = false;
		$('#anofin option').css('display','block');		
		if(value_select != ''){
			$("#anofin").attr('disabled',false);		
			$('#anofin option').each(function(){
			  if(this.value == ''){$(this).css('display','none');}
			  if(parseInt(value_select) == parseInt(this.value)){
				  $(this).attr("selected","selected");
				  anofin_global = this.value;	
				  var_select = true;
			  }
			  if(parseInt(value_select) > parseInt(this.value))
			  {
				  $(this).css('display','none');
			  }
			});
			if(!var_select){
				$("#anofin option :visible").eq(0).attr("selected", "selected");
				anofin_global = $("#anofin option :visible").eq(0).val();
			}
		}else{
			$("#anofin").val('');	
		    $("#anofin").attr('disabled',true);	
			text_filtro = '';
		}
	});
	
	$('#anoinicio').change(function(){
	  	$('#span-anoinicio').html('A&ntilde;o Inicio ('+$("#anoinicio option[value="+$('#anoinicio').val()+"]").text()+') ');					
	 anoinicio_global = $('#anoinicio').val();	
	});
	
	$('#anofin').change(function(){
	  	$('#span-anofin').html('A&ntilde;o Fin ('+$("#anofin option[value="+$('#anofin').val()+"]").text()+') ');								
		anofin_global = $('#anofin').val();	
	});
	
	$('#convanoinicio').change(function(){
	  	$('#span-convivencia').html('A&ntilde;o Convivencia ('+$("#convanoinicio option[value="+$('#convanoinicio').val()+"]").text()+') ');	
		convivencia_global = $('#convanoinicio').val();	
	});
	
	cambio_orden();
	
	$("#listgaffetes").jqGrid({
			url:'../scripts/GeneraJsonReportes.php?tipo_consulta=0',
			datatype: "json",
			height: 350,					
			colNames:['Conv.'/*,'CURP ','Nombres','Paterno','Materno'*/,'CURP [Nombre Completo]','Documentos','Municipio','Fecha','Sexo','Generales','Foto'],
			colModel:[{name:'convivencia',index:'convivencia', classes:'jqgrid_rep uppercasecss bold',width:50},					  
					  /*{name:'curp',index:'curp', classes:'jqgrid_rep uppercasecss bold',width:140}, 					  
					  {name:'nombre',index:'nombre', classes:'jqgrid_rep uppercasecss bold', width:100},			  
					  {name:'paterno',index:'paterno', classes:'jqgrid_rep uppercasecss bold', width:100},
					  {name:'materno',index:'materno', classes:'jqgrid_rep uppercasecss bold', width:100},*/
					  {name:'curpnom',index:'curpnom', classes:'jqgrid_rep bold', width:180},
					  {name:'documentos',index:'documentos', classes:'jqgrid_rep bold', width:130},					  
					  {name:'municipio',index:'municipio', classes:'jqgrid_rep bold', width:90}, 					 				 
					  {name:'fecha',index:'fecha', classes:'jqgrid_rep bold', width:90},
					  {name:'sexo',index:'sexo', classes:'jqgrid_rep bold', width:50},
					  {name:'generales',index:'generales', classes:'jqgrid_rep bold', width:250},
					  {name:'foto',index:'foto', width:70, align:"center"}],
			rowNum:0,						
			mtype: "POST",
			pager: jQuery('#listgaffetespager'),			
			sortname: 'curp',
			pgbuttons: false,
   	        pgtext: true,
			loadComplete: function() {
				$('.edit_foto').hover(function(){
					$(this).attr('src','../img/editar_img_sobre.jpg');
				}, function(){
					$(this).attr('src','../img/editar_img.jpg');
				});
			},			
   	        pginput:false,						
			viewrecords: true,
			multiselect: true,
			subGrid : true, 
			subGridUrl: '../scripts/GeneraJsonSubgridReportes.php?evento='+$('#evento').val()+'&validado=',
			subGridModel: [{ name : ['Evento','Validado','Modalidad','Deporte','Categoria','Pruebas'],
			width : [80,80,80,80,180,180]}],			
			caption: "Imprimir Gaffetes"
	});	
	
	$('#buscar_registro').click(function(){											   
       gridreporteReload();
	});	
	
	$('#solovalidados').click(function(){
		if($('#solovalidados').is(":checked")){validado_sub='si';}else{validado_sub='';}					
	});		   
});

//...............................Funciones......................................................
function cambio_orden(){
	$('.ordenar_rep').click(function(){											 
		var indice = -1;
		var ordenar_text = this.id.split('_')[0];
		$.each(lista_ordenar,function(i,data){
			if(ordenar_text==data)
			{indice=i;}
		});		
		if(indice == -1){	
		  lista_ordenar.push(this.id.split('_')[0]);
		  if(this.id.split('_')[0]!='anonacimiento'){
		     lista_ordenar_text.push($('#'+this.id.split('_')[0]+'_ordenar').html());
		  }else{
			 lista_ordenar_text.push('Fecha Nacimiento'); 
		  }		  										 			     							
		  $('#span-titulo').html('Filtro Y Orden( '+lista_ordenar_text.join(', ')+' ) de Busqueda');  						  	  
        }else{
		  delete lista_ordenar[indice];
		  delete lista_ordenar_text[indice];		  
		  var lista_ordenar_temp = new Array();
		  var lista_ordenar_text_temp = new Array();
		  $.each(lista_ordenar,function(iap,dataap){										
			  if(dataap!=undefined){lista_ordenar_temp.push(dataap);  lista_ordenar_text_temp.push($('#'+dataap+'_ordenar').html());} 		          });		  
		  lista_ordenar =[];		
		  lista_ordenar_text =[];		
		  $.each(lista_ordenar_temp,function(iap,dataap){	
		      if(dataap!=undefined){							 				 
				 lista_ordenar_text.push($('#'+dataap+'_ordenar').html());			  
				 lista_ordenar.push(dataap);
			  }    
		  });		   
		  $('#span-titulo').html('Filtro Y Orden( '+lista_ordenar_text.join(', ')+' ) de Busqueda');		  
		}
	}).hover(function(){
		$(this).css('color','#F90');
	}, function(){
	    $(this).css('color','#000');
	});
}
function gridreporteReload(){ 

         var deporte = $("#deportes_registro").val();
		 var categoria = $("#selectcategoria_registro").val();		 
		 var municipio = $("#municipio").val();
		 var nombres = $("#nombres_registro").val();
		 var appaterno = $("#appaterno_registro").val();
		 var apmaterno = $("#apmaterno_registro").val();
		 var modalidad = $("#modalidad_registro").val();
		 var rama = $("#sexo_registro").val();		 
		 var evento = $("#evento").val();		 
		 var anofin = $("#anofin").val();
		 var anoinicio = $("#anoinicio").val();
		 var convanoinicio = $("#convanoinicio").val();
		 var validado = '';
		 var ordenar = lista_ordenar.join(',');
		 
		 if($('#solovalidados').is(":checked")){validado='si'}else{validado=''}		 
		 
		 if(deporte+categoria+municipio+nombres+appaterno+apmaterno+modalidad+rama!=''){
			 $("#listgaffetes").jqGrid('setGridParam',{url:"../scripts/GeneraJsonReportes.php?deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&anoinicio="+anoinicio+"&anofin="+anofin+"&convanoinicio="+convanoinicio+"&validado="+validado+"&ordenar="+ordenar+"&tipo_consulta=1",page:1}).trigger("reloadGrid");
		 }else{
			 alert('Especifique Filtro de Busqueda...');
		 }		 
}

function ImprimirGaffetes()
{	    
    var deporte = $("#deportes_registro").val();
    var categoria = $("#selectcategoria_registro").val();		 
    var municipio = $("#municipio").val();
    var nombres = $("#nombres_registro").val();
    var appaterno = $("#appaterno_registro").val();
    var apmaterno = $("#apmaterno_registro").val();
    var modalidad = $("#modalidad_registro").val();
    var rama = $("#sexo_registro").val();
    var evento = $("#evento").val();		 
    var anofin = $("#anofin").val();
    var anoinicio = $("#anoinicio").val();
    var convanoinicio = $("#convanoinicio").val();
    var validado = '';		 
	var ordenar = lista_ordenar.join(',');			
	
	if($('#solovalidados').is(":checked")){validado='si'}else{validado=''}
	
	var gaffete_sel = $("#listgaffetes").jqGrid('getGridParam','selarrrow');		
		
	var caracteristicas ="height=700, width=800, scrollTo, resizable=0, toolbar=1, menubar=1, personalbar=1, scrollbars=1, location=0";
	
	
	
	var variables = "deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&anoinicio="+anoinicio+"&anofin="+anofin+"&convanoinicio="+convanoinicio+"&validado="+validado+"&ordenar="+ordenar+"&gaffete_sel="+gaffete_sel;
	
    nueva=window.open("../modulos/imprimir-gaffetes.php?"+variables, 'Popup', caracteristicas);  	
    return false
}
//.............................Fin Funciones.......................................................



//.............................Fin Funciones.......................................................
