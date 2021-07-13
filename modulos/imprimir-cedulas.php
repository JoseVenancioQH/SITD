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
      <input type="hidden" id="evento" value="<?php echo $_GET["evento"]; ?>"/>       
	  <input type="hidden" id="municipio" value="<?php echo $_GET["municipio"]; ?>"/>
      <input type="hidden" id="evento_text" value="<?php echo $_GET["evento_text"]; ?>"/>       
	  <input type="hidden" id="municipio_text" value="<?php echo $_GET["municipio_text"]; ?>"/>       
	   
	  <input type="hidden" id="sexo" value="<?php echo $_GET["sexo"]; ?>"/>       
	  <input type="hidden" id="deporte" value="<?php echo $_GET["deporte"]; ?>"/>       
	  <input type="hidden" id="categoria" value="<?php echo $_GET["categoria"]; ?>"/>       
	  <input type="hidden" id="modalidad" value="<?php echo $_GET["modalidad"]; ?>"/>
      
      <input type="hidden" id="cedula_sel" value="<?php echo $_GET["cedula_sel"]; ?>"/>       
	  <input type="hidden" id="ano" value="<?php echo $_GET["ano"]; ?>"/>       
	  <input type="hidden" id="nombres" value="<?php echo $_GET["nombres"]; ?>"/>       
	  <input type="hidden" id="appaterno" value="<?php echo $_GET["appaterno"]; ?>"/>
      <input type="hidden" id="apmaterno" value="<?php echo $_GET["apmaterno"]; ?>"/> 		 	  
	  
	  <table style="margin:0px 0px 0px 0px;" width="100%" id ="imprimir_cedulas" height:"100%;" border="0" cellpadding="0" cellspacing="0">
	  </table>
	 
          <script type="text/javascript"> 
	    var evento_text = $("#evento option[value="+$('#evento').val()+"]").text();						
		var municipio_text = $("#municipio option[value="+$('#municipio').val()+"]").text();
		var deporte = $("#deporte").val();
		var categoria = $("#categoria").val();		 
		var municipio = $("#municipio").val();
		var nombres = $("#nombres").val();
		var appaterno = $("#appaterno").val();
		var apmaterno = $("#apmaterno").val();
		var modalidad = $("#modalidad").val();
		var sexo = $("#sexo").val();
		var ano = $("#ano").val();
		var evento = $("#evento").val();		

	    $.ajax({
	    type: "POST",
	    url: "../scripts/BuscarCedulas.php",
	    processData: false,
	    dataType: "json",
	    data:"deporte="+deporte+"&municipio="+municipio+"&nombres="+nombres+"&appaterno="+appaterno+"&apmaterno="+apmaterno+"&sexo="+sexo+"&ano="+ano+"&modalidad="+modalidad+"&categoria="+categoria+"&evento="+evento,
	    beforeSend: function(){JSBlockUI('Realizando Busqueda...','80000')},
	    success: function(data){if(unJSBlockUI(data.cancelado)){if(data=='no') error(); else despliegacedulas(data);}},
	    timeout: 80000
	    });
		
		function despliegacedulas(data)
		{	
		  	  		  
		  if(data.result == 'si')    
		   {                       

            if(parseInt(window.screen.height)== 1024){var heighttabla = 281;}; 
            if(parseInt(window.screen.height)== 960) {var heighttabla = 281;};                      
            if(parseInt(window.screen.height)== 768) {var heighttabla = 281;};
            if(parseInt(window.screen.height)== 720) {var heighttabla = 281;}; 
            if(parseInt(window.screen.height)== 600) {var heighttabla = 281;};
            if(parseInt(window.screen.height)== 864) {var heighttabla = 281;};			
			
			var	cargo = data.municipio[0].cargo;
    	    var	responsable = data.municipio[0].responsable;
			

			var prueba = '';
			var descartar = $('#cedula_sel').val();
			var elementosdescartar = new Array();
			var arraypruebas = new Array(8);			
			var ban = false;
			var cont = 0;
			var contr = 0;
			var contpage = 0;
			var imprimirtr = '';		
			
			elementosdescartar = descartar.split(',');
			$('#imprimir_cedulas').html('');			
			$.each(data.items, function(i,item){						    		    
			    $.each(elementosdescartar,function(index,dato){				 
				  if(dato == item.id_registro+'-'+item.idcategoriapar) {ban = true; };				 
				});							
				
				//generar tr
				if(!ban){				    				    
				    cont++														 
					if(contr == 0){
					contpage++;
					imprimirtr +=''
					+   '<tr><td><table  height="800px" width="100%"><tr>'
					+       '<td colspan="2" style="width: 50%; height: 35px; vertical-align:top;">'
					+       '<table><tr>'
					+       '<td style="text-align:center; width: 15%; height: 35px; vertical-align:top;"><img src="../img/logo_imprimir.png" /><img style="margin-left:5px;" src="../img/gbcs.png" /></td>'
					+       '<td class="header_text" style="text-align:center; width: 45%; height: 35px; vertical-align:top;">- Empresa Autorizada - - Registro Estatal de Deporte <br />'
					+       evento_text+'<br />C&eacute;dulas de Inscripci&oacute;n</td>'
					+       '<td style="text-align:center; width: 30%; height: 35px; vertical-align:top;"><img src="../img/logo_lapaz.png" /><img style="margin-left:5px;" src="../img/logo_loscabos.png" /><img style="margin-left:5px;" src="../img/logo_mulege.png" /><img style="margin-left:5px;" src="../img/logo_comondu.png" /><img style="margin-left:5px;" src="../img/logo_loreto.png" /></td>'					
                    +       '<td style="text-align:center; width: 10%; height: 35px; vertical-align:top;">'+' Pag. '+String(contpage)+'</td>'					
					+       '</tr></table>'
					+   '</td>'										
					+   '</tr>';					
					contr++					
					}
					
					if(cont == 1){
					imprimirtr += '<tr>';					
					}								
					
					arraypruebas[0]="";arraypruebas[1]="";arraypruebas[2]="";arraypruebas[3]="";arraypruebas[4]="";arraypruebas[5]="";arraypruebas[6]="";arraypruebas[7]="";						
					listapruebas = item.pruebas.split(',');
					$.each(listapruebas,function(indexp,datop){		
					       if(datop == 'null') arraypruebas[indexp] = ''; else arraypruebas[indexp] = datop; 		 
				    });
									
					imprimirtr += '<td class="header_principal" style=" border:1px solid #333333;  width: 50%; height: '+heighttabla+'px; vertical-align:top;" ><table border="1" bordercolor="#CCCCCC" cellpadding="3" cellspacing="0" width="100%" height="100%">';
					imprimirtr += '<tr><td colspan="4" class="header_uno">'+item.municipio+' - ('+item.modalidad+') ['+item.deporte+'] ['+item.categoria+' ('+item.rangoinicio+' - '+item.rangofin+')]</td></tr>';					
					imprimirtr += '<tr><td class="header_uno" style="width: 50px; text-align:center;">Validado:</td><td style="width: 71px; heigth: 100px" rowspan="6"><img src="../fotosparticipantes/'+item.curp+'.png?nocache='+Math.random()*1000+'" /></td><td class="header_uno datos">Nombres:</td><td>'+acentos(item.nombre.toUpperCase())+'</td></tr>';
					imprimirtr += '<tr><td>Acta Nac.</td><td class="header_uno datos">Paterno:</td><td>'+acentos(item.appaterno.toUpperCase())+'</td></tr>';
					imprimirtr += '<tr><td>Const. Med</td><td class="header_uno datos">Materno:</td><td>'+acentos(item.apmaterno.toUpperCase())+'</td></tr>';
					imprimirtr += '<tr><td>CURP</td><td class="header_uno datos">C.U.R.P:</td><td>'+item.curp+'</td></tr>';
					imprimirtr += '<tr><td>SIRED</td><td class="header_uno datos">F. Nacimiento:</td><td>'+item.fechanac.substr(8,2)+'-'+item.fechanac.substr(5,2)+'-'+item.fechanac.substr(0,4)+'</td></tr>';
					imprimirtr += '<tr><td>FOTOS</td><td class="header_uno datos">Rama:</td><td>'+item.rama+'</td></tr>';					
					imprimirtr += '<tr><td>Nota:</td><td class="header_uno" colspan="5">Pruebas:</td></tr>';										
					imprimirtr += '<tr><td></td><td colspan="4"><table>';										
					imprimirtr += '<tr><td style="width: 5%;">1.-</td><td style="width: 45%;">'+arraypruebas[0]+'</td><td style="width: 5%;">2.-</td><td style="width: 45%;">'+arraypruebas[1]+'</td></tr>';					
					imprimirtr += '<tr><td style="width: 5%;">3.-</td><td style="width: 45%;">'+arraypruebas[2]+'</td><td style="width: 5%;">4.-</td><td style="width: 45%;">'+arraypruebas[3]+'</td></tr>';					
					imprimirtr += '<tr><td style="width: 5%;">5.-</td><td style="width: 45%;">'+arraypruebas[4]+'</td><td style="width: 5%;">6.-</td><td style="width: 45%;">'+arraypruebas[5]+'</td></tr>';
					imprimirtr += '<tr><td style="width: 5%;">7.-</td><td style="width: 45%;">'+arraypruebas[6]+'</td><td style="width: 5%;">8.-</td><td style="width: 45%;">'+arraypruebas[7]+'</td></tr>';					
					imprimirtr += '</table></td></tr>';
					imprimirtr += '</table></td>';					
					
					if(cont == 2){
					   cont = 0;					   
					   imprimirtr += '</tr>';				   					   
					   contr++                                           
					   if(contr == 4){
					      contr = 0;
					      imprimirtr +=''
						  +  '<tr>'					      
						  +  '<td colspan = "2" style="width: 50%; heigth: 35px; text-align:center;"><br />Sello<br />Direcci&oacute;n del Deporte</td>'
					      +  '<td style="width: 50%; heigth: 35px; text-align:center;">'			  
					      +  '</td>'
					      +  '</tr>'
					      +  '<tr>'
					      +  '<td style="width: 40%; heigth: 35px; text-align:center;">LED. Mayo Antonino Fernandez Oryorzabal<br />Subdirector de Desarrollo del Deporte<br /><br /><br />'						  
					      +  '</td>'						  
					      +  '<td style="width: 40%; heigth: 35px; text-align:center;">'+responsable+'<br />'+cargo+'<br /><br /><br />'						  
					      +  '</td>'
					      +  '</tr>'						  
					      +  '</table></td></tr>';	                         
		                  $('#imprimir_cedulas').append(imprimirtr);
						  imprimirtr = '';
					   }
					}											
				}			
				//fin generar tr					
			    ban = false;				 	
			});	
			if(cont == 1){
			   imprimirtr += '<td class="header_principal" style="width: 50%; height: '+heighttabla+'px; vertical-align:top;" ><table cellpadding="3" cellspacing="0" width="100%" height="100%">';
			   imprimirtr += '<tr><td></td><td></td></tr>';
			   imprimirtr += '<tr><td></td><td></td></tr>';
			   imprimirtr += '<tr><td></td><td></td></tr>';
			   imprimirtr += '<tr><td></td><td></td></tr>';
			   imprimirtr += '<tr><td></td><td></td></tr>';
			   imprimirtr += '<tr><td></td><td></td></tr>';
			   imprimirtr += '<tr><td></td><td></td></tr>';
			   imprimirtr += '</table></td></tr>';					
               imprimirtr += ''
						  +  '<tr>'					      
						  +  '<td colspan = "2" style="width: 50%; heigth: 35px; text-align:center;"><br />Sello<br />Direcci&oacute;n del Deporte</td>'
					      +  '<td style="width: 50%; heigth: 35px; text-align:center;">'			  
					      +  '</td>'
					      +  '</tr>'
					      +  '<tr>'
					      +  '<td style="width: 40%; heigth: 35px; text-align:center;">LED. Mayo Antonino Fernandez Oryorzabal<br />Subdirector de Desarrollo del Deporte<br /><br /><br />'
					      +  '</td>'						  
					      +  '<td style="width: 40%; heigth: 35px; text-align:center;">'+responsable+'<br />'+cargo+'<br /><br /><br />'						  
					      +  '</td>'
					      +  '</tr>'
					      +  '</table></td></tr>';
              $('#imprimir_cedulas').append(imprimirtr);
			}			
			else
			{
			 if(contr != 0)
			 {
			   imprimirtr += ''
						  +  '<tr>'					      
						  +  '<td colspan = "2" style="width: 50%; heigth: 35px; text-align:center;"><br />Sello<br />Direcci&oacute;n del Deporte</td>'
					      +  '<td style="width: 50%; heigth: 35px; text-align:center;">'			  
					      +  '</td>'
					      +  '</tr>'
					      +  '<tr>'
					      +  '<td style="width: 40%; heigth: 35px; text-align:center;">LED. Mayo Antonino Fernandez Oryorzabal<br />Subdirector de Desarrollo del Deporte<br /><br /><br />'						  
					      +  '</td>'						  
					      +  '<td style="width: 40%; heigth: 35px; text-align:center;">'+responsable+'<br />'+cargo+'<br /><br /><br />'						  
					      +  '</td>'
					      +  '</tr>'
						  +  '</table></td></tr>';
              $('#imprimir_cedulas').append(imprimirtr);
			}                  			  
			}			
		   }
		   else
		   {
		       $('#imprimir_cedulas').html('');
		       $('#imprimir_cedulas').html('Sin resultados la busqueda...');
		   }
		}	   
    </script>		
</body>
</html>
