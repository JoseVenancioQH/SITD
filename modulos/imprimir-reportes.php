<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Imprimir Cedulas | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/print.css" type="text/css" media="print,screen">
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../js/controller-unBlock.js"></script> 
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/controller-acentos.js" ></script>

</head>
<body style="margin:0px 0px 0px 0px;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">      <input type="hidden" id="evento_text" value="<?php echo $_GET["evento_text"]; ?>"/>
      <input type="hidden" id="lista_orden" value="<?php echo $_GET["lista_orden"]; ?>"/>
	  <input type="hidden" id="lista_prueba" value="<?php echo $_GET["lista_prueba"]; ?>"/>  		 	  
	  <input type="hidden" id="evento_global" value="<?php echo $_GET["evento_global"]; ?>"/>  		 	  
	  <input type="hidden" id="municipio_global" value="<?php echo $_GET["municipio_global"]; ?>"/>  		 	  
	  <input type="hidden" id="modalidad_global" value="<?php echo $_GET["modalidad_global"]; ?>"/>  		 	  
	  <input type="hidden" id="rama_global" value="<?php echo $_GET["rama_global"]; ?>"/>  		 	  
	  <input type="hidden" id="deporte_global" value="<?php echo $_GET["deporte_global"]; ?>"/>  		 	  
	  <input type="hidden" id="categoria_global" value="<?php echo $_GET["categoria_global"]; ?>"/>  		 	  
	  <input type="hidden" id="anoinicio_global" value="<?php echo $_GET["anoinicio_global"]; ?>"/>  		 	  
	  <input type="hidden" id="anofin_global" value="<?php echo $_GET["anofin_global"]; ?>"/>  		 	  
	  <input type="hidden" id="convivencia_global" value="<?php echo $_GET["convivencia_global"]; ?>"/>  		 	  
	  <input type="hidden" id="nombres_global" value="<?php echo $_GET["nombres_global"]; ?>"/>  		 	  
	  <input type="hidden" id="appaterno_global" value="<?php echo $_GET["appaterno_global"]; ?>"/>
	  <input type="hidden" id="apmaterno_global" value="<?php echo $_GET["apmaterno_global"]; ?>"/>
	  <input type="hidden" id="curp_global" value="<?php echo $_GET["curp_global"]; ?>"/>  		 	  
	  <input type="hidden" id="descartarreportes" value="<?php echo $_GET["descartarreportes"]; ?>"/>  		
	  <input type="hidden" id="desplegar_foto" value="<?php echo $_GET["desplegar_foto"]; ?>"/>  		   
	  <table  id ="imprimir_reporte" style="margin:0px 0px 0px 0px;" width="100%" height:"auto" border="1" cellpadding="0" cellspacing="1"></table>'
      <script type="text/javascript"> 
	    var descartarreportes = $('#descartarreportes').val();						
	    var lista_orden = $('#lista_orden').val();						
		var lista_prueba = $('#lista_prueba').val();						
	    var evento_global = $('#evento_global').val();						
	    var municipio_global = $('#municipio_global').val();						
	    var modalidad_global = $('#modalidad_global').val();						
	    var deporte_global = $('#deporte_global').val();
		var categoria_global = $('#categoria_global').val();
		var anoinicio_global = $('#anoinicio_global').val();
		var anofin_global = $('#anofin_global').val();
		var convivencia_global = $('#convivencia_global').val();
		var nombres_global = $('#nombres_global').val();
		var appaterno_global = $('#appaterno_global').val();
		var apmaterno_global = $('#apmaterno_global').val();
		var curp_global = $('#curp_global').val();
		var rama_global = $('#rama_global').val();
		var evento_text = $('#evento_text').val();
		var desplegar_foto = $('#desplegar_foto').val();

            $.ajax({
		 type: "POST",
		 url: "../scripts/DesplegarReportes_Varios.php",
		 processData: false,
		 dataType: "json",
		 data:"descartarreportes="+descartarreportes+"&lista_orden="+lista_orden+"&lista_prueba="+lista_prueba+"&evento_global="+evento_global+"&municipio_global="+municipio_global+"&modalidad_global="+modalidad_global+"&rama_global="+rama_global+"&deporte_global="+deporte_global+"&categoria_global="+categoria_global+"&anoinicio_global="+anoinicio_global+"&anofin_global="+anofin_global+"&convivencia_global="+convivencia_global+"&nombres_global="+nombres_global+"&appaterno_global="+appaterno_global+"&apmaterno_global="+apmaterno_global+"&curp_global="+curp_global,
		 beforeSend: function(){JSBlockUI('Realizando Busqueda...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){ if(data=='no') error(); else despliegareportes(data);}},
		 timeout: 80000
	    });
		
	function despliegareportes(data)
	{
	  var desplegar_foto_pantalla = '';
	  var arraycaracteristicas = new Array(); 	
	  var arraydatoscaracteristicas = new Array();
	  var arraydatos = new Array();	  
	  var var_convivencia ='';
	  var contpage = 0;
	  var row_display = 0;
	  var imprimirtr = '';
	  var id_registro_fuera = '';
	  var ban = false; 
	  var imprimirtr = '';
	  var elementosdescartar = new Array();
	  elementosdescartar = descartarreportes.split('@');	  
	  $.each(data.items, function(i,item){ 	   
	   $.each(elementosdescartar,function(index,dato){				 
				  if(dato == item.id_registro) {ban = true;}				 
	   });							
	   if(!ban){ 
	       
		var html_mdcp = '';		
		arraycaracteristicas = item.caracteristicas.split('<br />');
		$.each(arraycaracteristicas,function(ic,dc){		    
			arraydatoscaracteristicas = dc.split(' | ');								 
			var h3_text = '';			
			$.each(arraydatoscaracteristicas,function(idc,ddc){		   
			   arraydatos = ddc.split(':');		   		   
			   if(jQuery.trim(arraydatos[0].toUpperCase()) == 'MODALIDAD') if(arraydatos[1]!='' && arraydatos[1] != 'null')h3_text = arraydatos[1];
			   if(jQuery.trim(arraydatos[0].toUpperCase()) == 'NOMBRE DEPORTE') if(arraydatos[1]!='' && arraydatos[1] != 'null') h3_text +=' de '+arraydatos[1];
			   if(jQuery.trim(arraydatos[0].toUpperCase()) == 'NOMBRE CATEGORIA') if(arraydatos[1]!='' && arraydatos[1] != 'null') h3_text +=' ['+ arraydatos[1]+'] ';
			   if(jQuery.trim(arraydatos[0].toUpperCase()) == 'PRUEBAS') if(arraydatos[1]!='' && arraydatos[1] != 'null')h3_text+=' ('+arraydatos[1]+') ';     	   
			});		
			html_mdcp += '< '+h3_text+' >';		
		});
		
		if(item.convivencia != '')
		{var_convivencia = '('+item.convivencia+')';}
		else{var_convivencia = '';}	
		
		if(item.direccion == 'null' || item.direccion.toUpperCase() == 'X'){item.direccion = '';}
		else
		{item.direccion = ' [Dir: '+item.direccion+'] ';}
		if(item.colonia == 'null' || item.colonia.toUpperCase() == 'X'){item.colonia = '';}
		else
		{item.colonia = ' [Col: '+item.colonia+'] ';}
		if(item.localidad == 'null' || item.localidad.toUpperCase() == 'X'){item.localidad = '';}
		else
		{item.localidad = ' [Loc: '+item.localidad+'] ';}
		if(item.codigop == 'null' || item.codigop.toUpperCase() == 'X'){item.codigop = '';}
		else
		{item.codigop = ' [Cod. P.: '+item.codigop+'] ';}
		if(item.telefonos == 'null' || item.telefonos.toUpperCase() == 'X'){item.telefonos = '';}
		else
		{item.telefonos = ' [Tel: '+item.telefonos+'] ';}
		if(item.correo == 'null' || item.correo.toUpperCase() == 'X'){item.correo = '';}
		else
		{item.correo = ' [Mail: '+item.correo+'] ';}
		if(item.peso == 'null' || item.peso.toUpperCase() == 'X'){item.peso = '';}
		else
		{item.peso = ' [Peso: '+item.peso+'] ';}
		if(item.talla == 'null' || item.talla.toUpperCase() == 'X'){item.talla = '';}
		else
		{item.talla = ' [Talla: '+item.talla+'] ';}
		if(item.rfc == 'null' || item.rfc.toUpperCase() == 'X'){item.rfc = '';}
		else
		{item.rfc = ' [RFC: '+item.rfc+'] ';}
		if(item.tiposanguineo == 'null' || item.tiposanguineo.toUpperCase() == 'X'){item.tiposanguineo = '';}	  
		else
		{item.tiposanguineo = ' [T. San.: '+item.tiposanguineo+'] ';}
		var arrayfecha = new Array();
		arrayfecha = item.fechanac.split('-');
		item.fechanac = 'F. Nac.: '+arrayfecha[2]+'/'+arrayfecha[1]+'/'+arrayfecha[0];
		
		if(item.sexo == 'H') item.sexo = 'Hombre'; else item.sexo = 'Mujer';		
		
		if(desplegar_foto=='si'){desplegar_foto_pantalla = '<br /><img src="../fotosparticipantes/'+item.curp+'.png?nocache='+Math.random()*1000+'">';}else{desplegar_foto_pantalla = ''}
		
		if(row_display == 0){		
		contpage++;					
		imprimirtr += ''
					+   '<tr>'
					+       '<td colspan="2" style="width: 100%; height: 35px; vertical-align:top;">'
					+       '<table><tr>'
					+       '<td style="text-align:center; width: 15%; height: 35px; vertical-align:top;"><img src="../img/logo_imprimir.png" /><img style="margin-left:5px;" src="../img/gbcs.png" /></td>'
					+       '<td class="header_text datos" style="text-align:center; width: 45%; height: 35px; vertical-align:top;">- Empresa Autorizada - - Registro Estatal de Deporte <br />'
					+       evento_text+'<br />Reportes de Inscripci&oacute;n</td>'
		   			+       '<td style="text-align:center; width: 35%; height: 35px; vertical-align:top;"><img src="../img/logo_lapaz.png" /><img style="margin-left:5px;" src="../img/logo_loscabos.png" /><img style="margin-left:5px;" src="../img/logo_mulege.png" /><img style="margin-left:5px;" src="../img/logo_comondu.png" /><img style="margin-left:5px;" src="../img/logo_loreto.png" /></td>'					
                    +       '<td style="text-align:center; width: 5%; height: 35px; vertical-align:top;">'+' Pag. '+String(contpage)+'</td>'					
					+       '</tr></table>'
					+       '</td>'										
					+   '</tr>';					
		}		
		
		imprimirtr += ''
		+     '<tr>'
		+        '<td style="width:10%;">'
		+        desplegar_foto_pantalla
		+        '</td>'  
		+        '<td style="width:90%; vertical-align:top;">'
		+          '<table style="margin:0px 0px 0px 0px;" width="100%" height:"auto" border="0" cellpadding="0" cellspacing="0">'
		+            '<tr>'
		+               '<td style="width:12%; height:30px">'
		+               'Generales:'
		+               '</td>'     
		+               '<td style="width:88%; height:30px">'
		+               var_convivencia+item.municipio+' ['+acentos(item.nombre.toUpperCase()) + ' ' + acentos(item.appaterno.toUpperCase()) + ' ' + acentos(item.apmaterno.toUpperCase()) +'] '+' ('+item.curp+') '+' ['+item.fechanac+' ]'+' ['+item.sexo+' ]'
		+               '</td>'		
		+            '</tr>'
		+          '</table>'
		+          '<table style="margin:0px 0px 0px 0px;" width="100%" height:"auto" border="0" cellpadding="0" cellspacing="0">'
		+            '<tr>'
		+               '<td style="width:12%; height:30px">'
		+               'Adicionales:' 
		+               '</td>'     
		+               '<td style="width:88%; height:30px">'
		+               item.direccion+item.colonia+item.localidad+item.codigop+item.telefonos+item.correo+item.peso+item.talla+item.rfc+item.tiposanguineo 
		+               '</td>'		
		+            '</tr>'
		+          '</table>'
		+          '<table style="margin:0px 0px 0px 0px;" width="100%" height:"auto" border="0" cellpadding="0" cellspacing="0">' 
		+            '<tr>'	
		+               '<td style="width:12%; height:43px">'
		+               'Caracteristicas:' 
		+               '</td>'   
		+               '<td style="width:88%; height:43px">'
		+               html_mdcp
		+               '</td>'   		
		+            '</tr>'
		+          '</table>'
		+        '</td>'  
		+     '</tr>';		
		row_display++;
		if(row_display == 9)
		{
		 row_display=0;		 
		}		
		}
		ban = false;		
	  }); 
	  $('#imprimir_reporte').append(imprimirtr);
	}
    </script>		
</body>
</html>
