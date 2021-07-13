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
	 $("#listcedula").jqGrid({
			url:'../scripts/GeneraCedulas.php?tipo_consulta=0',
			datatype: "json",
			height: 350,					
			colNames:['Nombres','Paterno','Materno','Modalidad','Deporte','Categoria','Prueba','Sexo','Foto'],
			colModel:[{name:'nombre',index:'nombre', classes:'jqgrid uppercasecss bold', width:110}, 					  					                      {name:'paterno',index:'paterno', classes:'jqgrid uppercasecss bold', width:110},
					  {name:'materno',index:'materno', classes:'jqgrid uppercasecss bold', width:100},
					  {name:'modalidad',index:'modalidad', width:110},
					  {name:'deporte',index:'deporte', width:100},
					  {name:'categoria',index:'categoria', width:150},
					  {name:'prueba',index:'prueba', width:130},					  
				      {name:'sexo',index:'sexo', width:50},
					  {name:'foto',index:'foto', width:70}],					  
			rowNum:0,						
			mtype: "POST",
			pager: jQuery('#listcedulapager'),			
			sortname: 'curp',
			pgbuttons: false,
   	        pgtext: false,
			loadComplete: function() {
				$('.edit_foto').hover(function(){
					$(this).attr('src','../img/editar_img_sobre.jpg');
				}, function(){
					$(this).attr('src','../img/editar_img.jpg');
				});

			},
   	        pginput:false,						
			viewrecords: true,
			sortorder: "asc",
			multiselect: true,
			caption: "Lista Cedulas a Imprimir"
	});
	 
	$('#buscar_registro').click(function(){										
       gridregistroReload();
	});
	
	$("#deportes_registro").addClass("cselect");
	$("#modalidad_registro").removeClass("span-7").addClass("span-5");
});

function gridregistroReload(){ 
         var deporte = $("#deportes_registro").val();
		 var categoria = $("#selectcategoria_registro").val();		 
		 var municipio = $("#municipio").val();
		 var nombres = $("#nombres_registro").val();
		 var appaterno = $("#appaterno_registro").val();
		 var apmaterno = $("#apmaterno_registro").val();
		 var modalidad = $("#modalidad_registro").val();
		 var rama = $("#sexo_registro").val();
		 var ano = $("#ano_registro").val();
		 var evento = $("#evento").val();		 
		 
		 if($('#municipio').val()=='') {$('#municipio').seekAttention(); return false;}
		 
		 if(deporte+categoria+municipio+nombres+appaterno+apmaterno+modalidad+rama+ano!=''){
			 $("#listcedula").jqGrid('setGridParam',{url:"../scripts/GeneraCedulas.php?deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&ano="+ano+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&tipo_consulta=1",page:1}).trigger("reloadGrid");
		 }else{
			 alert('Especifique Filtro de Busqueda...');
		 }		 
}

function ImprimirCedulas()
{	
	var evento_text = $("#evento option[value="+$('#evento').val()+"]").text();						
	var municipio_text = $("#municipio option[value="+$('#municipio').val()+"]").text();
	var deporte = $("#deportes_registro").val();
    var categoria = $("#selectcategoria_registro").val();		 
    var municipio = $("#municipio").val();
    var nombres = $("#nombres_registro").val();
    var appaterno = $("#appaterno_registro").val();
    var apmaterno = $("#apmaterno_registro").val();
    var modalidad = $("#modalidad_registro").val();
    var rama = $("#sexo_registro").val();
    var ano = $("#ano_registro").val();
    var evento = $("#evento").val();		
	
	if($('#municipio').val()=='') {$('#municipio').seekAttention(); return false;}
	
	var cedula_sel = $("#listcedula").jqGrid('getGridParam','selarrrow');	
	
	var caracteristicas ="height=700, width=800, scrollTo, resizable=0, toolbar=1, menubar=1, personalbar=1, scrollbars=1, location=0"; 
	
	var variables = "evento_text="+evento_text+"&municipio_text="+municipio_text+"&evento="+evento+"&municipio="+municipio+"&sexo="+rama+"&deporte="+deporte+"&categoria="+categoria+"&cedula_sel="+cedula_sel+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&ano="+ano+"&modalidad="+modalidad;	
	
    nueva=window.open("../modulos/imprimir-cedulas.php?"+variables, 'Popup', caracteristicas);  	
    return false;  
}