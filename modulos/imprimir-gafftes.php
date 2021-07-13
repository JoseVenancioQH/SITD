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
	  <table  id ="imprimir_gaffete" style="margin:0px 0px 0px 0px;" width="100%" height:"auto" border="1" cellpadding="0" cellspacing="1"></table>'
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
		 url: "../scripts/DesplegarGaffete.php",
		 processData: false,
		 dataType: "json",
		 data:"descartarreportes="+descartarreportes+"&lista_orden="+lista_orden+"&lista_prueba="+lista_prueba+"&evento_global="+evento_global+"&municipio_global="+municipio_global+"&modalidad_global="+modalidad_global+"&rama_global="+rama_global+"&deporte_global="+deporte_global+"&categoria_global="+categoria_global+"&anoinicio_global="+anoinicio_global+"&anofin_global="+anofin_global+"&convivencia_global="+convivencia_global+"&nombres_global="+nombres_global+"&appaterno_global="+appaterno_global+"&apmaterno_global="+apmaterno_global+"&curp_global="+curp_global,
		 beforeSend: function(){JSBlockUI('Realizando Busqueda...')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){if(data=='no') error(); else despliegareportes(data);}},
		 timeout: 30000
	    });
		
	function despliegareportes(data)
	{  
	  $.each(data.items, function(i,item){ 	   
	     alert('pito');	  					
	     $('#imprimir_gaffete').append('<tr><td><img src="../GaffeteTem/'+item.curp+'.png" /></td></tr>');				
	  }); 
	  
	}
    </script>		
</body>
</html>
