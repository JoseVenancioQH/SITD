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
<body style="margin:0px 0px 0px 0px;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
     
      <input type="hidden" id="municipio" value="<?php echo $_GET["municipio"]; ?>"/>
      <input type="hidden" id="deporte" value="<?php echo $_GET["deporte"]; ?>"/>
      <input type="hidden" id="nombres" value="<?php echo $_GET["nombres"]; ?>"/>
      <input type="hidden" id="appaterno" value="<?php echo $_GET["appaterno"]; ?>"/>
      <input type="hidden" id="apmaterno" value="<?php echo $_GET["apmaterno"]; ?>"/>
      <input type="hidden" id="rama" value="<?php echo $_GET["rama"]; ?>"/>
      <input type="hidden" id="modalidad" value="<?php echo $_GET["modalidad"]; ?>"/>
      <input type="hidden" id="categoria" value="<?php echo $_GET["categoria"]; ?>"/>
      <input type="hidden" id="evento" value="<?php echo $_GET["evento"]; ?>"/>
      <input type="hidden" id="anoinicio" value="<?php echo $_GET["anoinicio"]; ?>"/>
      <input type="hidden" id="anofin" value="<?php echo $_GET["anofin"]; ?>"/>
      <input type="hidden" id="convanoinicio" value="<?php echo $_GET["convanoinicio"]; ?>"/>
      <input type="hidden" id="validado" value="<?php echo $_GET["validado"]; ?>"/>
      <input type="hidden" id="ordenar" value="<?php echo $_GET["ordenar"]; ?>"/>
      <input type="hidden" id="gaffete_sel" value="<?php echo $_GET["gaffete_sel"]; ?>"/>
      
	  <table  id ="imprimir_gaffete" style="margin:0px 0px 0px 0px;" width="100%" height:"auto" border="0" cellpadding="0" cellspacing="0"></table>
      <script type="text/javascript"> 
	    var totalgaffetes = 0;
		var var_cancelado = '';
		var object_json = new Object();
		var object_status = '';
	    var ordenar = $('#ordenar').val();						
	    var gaffete_sel = $('#gaffete_sel').val();						
		var validado = $('#validado').val();						
	    var convanoinicio = $('#convanoinicio').val();						
	    var anofin = $('#anofin').val();						
	    var anoinicio = $('#anoinicio').val();						
	    var evento = $('#evento').val();
		var categoria = $('#categoria').val();
		var modalidad = $('#modalidad').val();
		var rama = $('#rama').val();
		var nombres = $('#nombres').val();
		var apmaterno = $('#apmaterno').val();
		var appaterno = $('#appaterno').val();
		var deporte = $('#deporte').val();
		var municipio = $('#municipio').val();		
		var total_reg = 0;		
		
		var s_count = 0;
		var h_inicio = 0;
		var m_inicio = 0;
		var s_inicio = 0;
		var img_gaffete_load = 0;
		var estimado_s = 0;
		var gaffetes_count = 0;
		var estimados_s_new = 0;
		var arrayh = String((total_reg*1.5)/3600).split('.');
		var arraym = String((total_reg*1.5)/60).split('.');
		var estimado_h = arrayh[0];
		var estimado_m = arraym[0];		
		
		if(arraym.length > 1){
		estimado_s = Math.round(('0.'+arraym[1])*60);
		}
		
		if (estimado_h <= 9) estimado_h = "0" + estimado_h;
		if (estimado_m <= 9) estimado_m = "0" + estimado_m;
		if (estimado_s <= 9) estimado_s = "0" + estimado_s;	
		
		var horas = '';
		var minutos = '';
		var segundos = '';
		
		var tiempo_estimado = estimado_h+':'+estimado_m+':'+estimado_s;
		   
		function reloj()
		{		   
		   if (m_inicio == 60) {h_inicio = h_inicio+1; m_inicio=0;}
		   if (s_inicio == 60) {m_inicio = m_inicio+1; s_inicio=0;}
		   s_inicio = s_inicio + 1;
		   s_count = s_count + 1;
		   
		   if (h_inicio <= 9) horas = "0" + h_inicio; else horas = h_inicio;
		   if (m_inicio <= 9) minutos = "0" + m_inicio; else minutos = m_inicio;
		   if (s_inicio <= 9) segundos = "0" + s_inicio; else segundos = s_inicio;	   	   
		   
		   $('#img_gaffete_load').html(img_gaffete_load+' de '+total_reg);
		   $('#reloj').html(horas+":"+minutos+":"+segundos);
		}   
		
		
		$.ajax({
		 type: "POST",
		 url: "../scripts/ContarGaffetes.php",
		 processData: false,
		 dataType: "json",		   
		 data:"deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&anoinicio="+anoinicio+"&anofin="+anofin+"&convanoinicio="+convanoinicio+"&validado="+validado+"&gaffete_sel="+gaffete_sel,	   
		 beforeSend: function(){JSBlockUI('Contando Gaffetes...','');},			   
		 success: function(data){var_cancelado = data.cancelado; total_reg = data.contador;},
		 complete : function(){if(unJSBlockUI(var_cancelado)){despliegareportes_onetime();}}
		});
		
		  
		function despliegareportes_onetime()
		{		 
		  $.ajax({
		   type: "POST",
		   url: "../scripts/DesplegarGaffetes.php",
		   processData: false,
		   dataType: "json",		   
		   
		   data:"deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&anoinicio="+anoinicio+"&anofin="+anofin+"&convanoinicio="+convanoinicio+"&validado="+validado+"&gaffete_sel="+gaffete_sel+"&ordenar="+ordenar+"&registro_actual=0",		   
		   beforeSend: function(){JSBlockUI('Generando Gaffetes...<br /> Generados: '+totalgaffetes+' de '+total_reg+'<br /><span id ="reloj"></span> de '+tiempo_estimado,''); var sliderIntervalID = setInterval("reloj()",1000);},
		   success: function(data){var_cancelado = data.cancelado; object_json = data.items;object_status = data.status;},
		   complete : function(){if(unJSBlockUI(var_cancelado)){despliegareportes();}}
		  });
		}
		
	    function despliegareportes()
	    {	
		
	    if(object_status == 'si'){
		    gaffetes_count = totalgaffetes;
			$.each(object_json, function(i,item){
			  totalgaffetes++; 	   	  					
			  $('#imprimir_gaffete').append('<tr><td style="width:50%; height:440px; text-align:right;"><img src="../GaffetesBase/FONDOGAFFETE_MEDIO_ATRAZ.png" /></td><td style="width:50%; height:440px; text-align:left;"><img id = "'+item+'"/></td></tr>');	
			  var objImagePreloader = new Image();
			  objImagePreloader.onload = function() {
				$('#'+item).attr('src',objImagePreloader.src)							
				img_gaffete_load++;
				}				 
			  objImagePreloader.src = "../GaffeteTem/"+item+".png?nocache="+Math.random()*1000;  
			});  
			
			estimados_s_new = s_count/(totalgaffetes - gaffetes_count);						
			s_count = 0; 			
			estimado_s = 0;
			arrayh = String((total_reg*estimados_s_new)/3600).split('.');
			arraym = String((total_reg*estimados_s_new)/60).split('.');
			estimado_h = arrayh[0];
			estimado_m = arraym[0];		
			if(arraym.length > 1){
			estimado_s = Math.round(('0.'+arraym[1])*60);
			}
			
			if (estimado_h <= 9) estimado_h = "0" + estimado_h;
			if (estimado_m <= 9) estimado_m = "0" + estimado_m;
			if (estimado_s <= 9) estimado_s = "0" + estimado_s;			
			
			tiempo_estimado = estimado_h+':'+estimado_m+':'+estimado_s;		
						
			$.ajax({
			 type: "POST",
			 url: "../scripts/DesplegarGaffetes.php",
			 processData: false,
			 dataType: "json",
			 
			 data:"deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&rama="+rama+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento+"&anoinicio="+anoinicio+"&anofin="+anofin+"&convanoinicio="+convanoinicio+"&validado="+validado+"&ordenar="+ordenar+"&gaffete_sel="+gaffete_sel+"&registro_actual="+totalgaffetes,			 
			 beforeSend: function(){JSBlockUI('Generando Gaffetes...<br /> Generados: '+totalgaffetes+' de '+total_reg+'<br /><span id ="reloj"></span> de '+tiempo_estimado+'<br />Cargados: <span id="img_gaffete_load">'+img_gaffete_load+' de '+total_reg+'</span>','')},
			 success: function(data){var_cancelado = data.cancelado; object_json = data.items; object_status = data.status;},
			 complete: function(){if(unJSBlockUI(var_cancelado)){despliegareportes();}}
			});	
		} 
		else{
		  if(total_reg != img_gaffete_load){
		  JSBlockUI('Cargando Gaffetes Generados...<br /> Cargados: <span id="img_gaffete_load">'+img_gaffete_load+' de '+total_reg+'</span>','');
		  clearInterval(sliderIntervalID);
		  var sliderIntervalID = setInterval("gaffetes_cargados()",1000);		  
		  }
		}	
	}
	
	function gaffetes_cargados()
		{
		  if(parseInt(total_reg) == parseInt(img_gaffete_load) || parseInt(totalgaffetes) == parseInt(img_gaffete_load))
		  {
		   if(unJSBlockUI('')){}		  		   
		  }
		  else
		  {
		   $('#img_gaffete_load').html(img_gaffete_load+' de '+total_reg);
		  }
		}
    </script>		
</body>
</html>
