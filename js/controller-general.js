jQuery.fn.reset = function () {$(this).each (function() {this.reset();})}

var ban_accordion = 'desactivado';
var objImagePreloader = new Image();
var arrhtml = new Array(25); 
var arruni = new Array(25); 
var arrayacentos = new Array();

arrhtml[0]="&NTILDE;";arrhtml[1]="&AACUTE;";arrhtml[2]="&EACUTE;";arrhtml[3]="&OACUTE;";arrhtml[4]="&UACUTE;";arrhtml[5]="&IACUTE;";arrhtml[6]="&Ntilde;";arrhtml[7]="&Aacute;";arrhtml[8]="&Eacute;";arrhtml[9]="&Oacute;";arrhtml[10]="&Uacute;";arrhtml[11]="&Iacute;";
arrhtml[12]="Ñ";arrhtml[13]="Á";arrhtml[14]="É";arrhtml[15]="Ó";arrhtml[16]="Ú";arrhtml[17]="Í";arrhtml[18]="Ñ";arrhtml[19]="Á";arrhtml[20]="É";arrhtml[21]="Ó";arrhtml[22]="Ú";arrhtml[23]="Í";arrhtml[24]="&ntilde;";

arruni[0]="\u00D1";arruni[1]="\u00C1";arruni[2]="\u00C9";arruni[3]="\u00D3";arruni[4]="\u00DA";arruni[5]="\u00CD";arruni[6]="\u00D1";arruni[7]="\u00C1";arruni[8]="\u00C9";arruni[9]="\u00D3";arruni[10]="\u00DA";arruni[11]="\u00CD";arruni[12]="\u00D1";arruni[13]="\u00C1";arruni[14]="\u00C9";arruni[15]="\u00D3";arruni[16]="\u00DA";arruni[17]="\u00CD";arruni[18]="\u00D1";arruni[19]="\u00C1";arruni[20]="\u00C9";arruni[21]="\u00D3";arruni[22]="\u00DA";arruni[23]="\u00CD";arrhtml[24]="\u00D1";

$().ready(function(){		   
	
	
	
	$(function(){
		  $('#navigation a').stop().animate({'marginLeft':'-22px'},1000);	
		  $('#navigation > li').hover(function (){$('a',$(this)).stop().animate({'marginLeft':'-4px'},200);},
									  function (){$('a',$(this)).stop().animate({'marginLeft':'-22px'},1000);});
	});
				
	$.growl.settings.dockCss.width = '225px';
	$.growl.settings.noticeCss = {position: 'relative'};
	$.growl.settings.noticeTemplate = ''
	+ '<table width="225" border="0" cellpadding="0" cellspacing="0">'
	+ '	<tr>'
	+ '		<td style="background-image: url(../img/dm_top.png); width: 225px; height: 49px; background-repeat: no-repeat; color: #FFFFFF;">'
	+ '			<img src="%image%" style="max-width: 25px; max-height: 25px; text-align: center; margin-left: 15px; margin-top: 15px;" />'
	+ '			<h1 style="font-size: 18px; margin: 0pt; margin-left: 5px; margin-bottom: 5px; display: inline; color: #FFFFFF;">%title%</h1>'
	+ '		</td>'
	+ '	</tr>'
	+ '	<tr>'
	+ '		<td style="background-image: url(../img/dm_repeat.png); width: 225px; background-repeat: repeat-y; color: #ddd;">'
	+ '			<p style="margin: 10px;">%message%</p>'
	+ '		</td>'
	+ '	</tr>'
	+ '	<tr>'
	+ '	    <td style="background-image: url(../img/dm_bottom.png); background-repeat: no-repeat; width: 225px; height: 27px;" valign="top" align="right" >'
	+ '			<a style="margin-right: 0px; font-size: 10px; color: #fff; text-align: right; float:right;" href="" onclick="return false;" rel="close">Close</a>'
	+ '		</td>'
	+ '	</tr>'
	'+ </table>';
	
	$("#accordion").accordion({collapsible: true, active: false, alwaysOpen: false, animated: false, autoheight: false, header: "h3"});
	
	$("#accordion").click(function(){
	   ban_accordion = (ban_accordion == 'desactivado') ? 'activado' : 'desactivado';		   
	});	
	
	$("#deportes_buscar").addClass("cselect");
	$("#deportes_registro").addClass("cselect");
	$("#modalidad_buscar").removeClass("span-7").addClass("span-4");
	$("#modalidad_registro").removeClass("span-7").addClass("span-5");	
			
		
	$('#deportes_registro').change(function(){			 		
		$.ajax({
		 type: "POST",
		 url: "../scripts/GeneraCategoria_Buscar.php",
		 processData: false,
		 dataType: "html",
		 data:"deporte="+$(this).val()+"&evento="+$("#evento").val(),
		 beforeSend: function(){JSBlockUI('Generando Categorias...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') {error();} else despliegapruebas_registro(data);}},
		 timeout: 80000
	    });			  
	});	
	
	$('#foto_comprimida').click(function(){										
       editarfoto(curp_foto_editar,'');	   
	});
	
	$('#foto_original').click(function(){										
       editarfoto(curp_foto_editar,'fotosparticipantestemp');	   
	});		
});
//************************************************************************************
function editar_foto()
{
	var x1 = $('#x1').val();
	var y1 = $('#y1').val();
	var x2 = $('#x2').val();
	var y2 = $('#y2').val();
	var w = $('#w').val();
	var h = $('#h').val();
	$.ajax({
		 type: "POST",
		 url: "../scripts/EditarFoto.php",
		 processData: true,
		 dataType: "json",		 
		 data: "x="+x1+"&y="+y1+"&w="+w+"&h="+h+"&curp="+curp_foto_editar+"&tipo_foto="+tipo_foto,
		 beforeSend: function(){JSBlockUI('Aditando Foto...','80000')},
		 success: function(data){if(unJSBlockUI(data.cancelado)){fotoeditada(data,curp_foto_editar);}},
		 timeout: 80000
	});	
}

function fotoeditada(data,curp)
{
	$('#dialog_editar_imagen').dialog("close");
	$('#foto'+curp).fadeOut(function(){			
			objImagePreloader.onload = function() {
				  $('#foto'+curp)
				  .removeAttr('src')
				  .attr('src',"../fotosparticipantes/"+curp+".png?nocache="+Math.random()*1000)
				  .fadeIn();
				}
				objImagePreloader.src = "../fotosparticipantes/"+curp+".png?nocache="+Math.random()*1000;																		
	});
}

function editarfoto(curp_img,carpeta){	
    curp_foto_editar = curp_img; 	
	carpeta=(carpeta=='')? 'fotosparticipantes' : carpeta;
	if(carpeta=='') $('#foto_comprimida').attr('checked', true);
	tipo_foto = carpeta;
	$('#dialog_editar_imagen').css('display','inline');
	$('#dialog_editar_imagen').dialog('open');		
	$('#cropbox').remove();
	$('#preview').remove();
	$('#preview_td').html('<div style="width:70px;height:90px;overflow:hidden;">'             
							   +'<img id="preview" src="../img/foto.png"/>'
						  +'</div>');
	$('#cropbox_td').html('<div style="width:auto;height:auto;overflow:hidden;">'    
							  +'<img id="cropbox_cargando" src="../img/cargando.gif"/>'
							  +'<img id="cropbox" src="../img/foto.png"/>'
						  +'</div>');
	
	$('#preview').removeAttr('src').attr('src',"../"+carpeta+"/"+curp_img+".png?nocache="+Math.random()*1000);
	$('#cropbox').fadeOut(function(){			
			   objImagePreloader.onload = function(){		      
			          
					  $('#cropbox').css('width',objImagePreloader.width);
					  $('#cropbox').css('height',objImagePreloader.height);
					  
					  $('#cropbox')
					  .removeAttr('src')
					  .attr('src',"../"+carpeta+"/"+curp_img+".png?nocache="+Math.random()*1000)
					  .fadeIn().Jcrop({
									   onChange: showPreview,
									   onSelect: showPreview,								
									   aspectRatio: 0
					   }).load(function (){						                   						  
							               $('#cropbox_cargando').css('display', 'none');										    
					   }).error(function (){						               						  
							               $('#cropbox_cargando').css('display', 'none');
					   });		
					  
					   $('#ancho_original').val(objImagePreloader.width);
					   $('#alto_original').val(objImagePreloader.height);		 					   
					   
					   $( "#dialog_editar_imagen" )
					   .dialog( "option", "width", "auto")
					   .dialog( "option", "height","auto")
					   .dialog( "option", "position", 'center' );				   
				}				
				objImagePreloader.src = "../"+carpeta+"/"+curp_img+".png?nocache="+Math.random()*1000;													
				$("#dialog_editar_imagen" ).dialog( "option", "position", 'center' );						
	});	
	$( "#dialog_editar_imagen" ).dialog( "option", "position", 'center' );
}

function actualizarfoto(idcurp){    
	var button = $('#foto'+idcurp);	
	new AjaxUpload(button,{		
	action: '../scripts/upload.php', 
	name: 'userfile',
	onSubmit : function(file, ext){
		if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
		    
			/* Setting data */
			this.setData({'nombreparticipantes': idcurp,
						  'overwrite' : "si",
						  'action' : "image"});
			
			button.attr("src","../img/ajax-loader.gif");
		} else {				
			// cancel upload
			alert('solo imagenes');
			return false;				
		}		
	},
	onComplete: function(file, response){		
	    if(response != '1'){
		button.fadeOut(function(){			
			objImagePreloader.onload = function() {
				button
				.removeAttr('src')
				.attr('src',"../fotosparticipantes/"+response+"?nocache="+Math.random()*1000)
				.fadeIn();
				}
				objImagePreloader.src = "../fotosparticipantes/"+response+"?nocache="+Math.random()*1000;										
			});		
		}else
		{alert('No se cargo la imagen, excede el tama\u00F1o permitido, Redusca la imagen de tama\u00F1o, he intente de nuevo'); button.attr("src","../img/foto.png");}
	}
	});	
}

function acentos(cad)
{
	arrayacentos = cad.split(' ');	
	
	$.each(arrayacentos,function(iacentos,dataacentos){
	  $.each(arrhtml,function(ihtml,datahtml){	
		if(dataacentos.indexOf(datahtml) > -1) {			   
		   arrayacentos[iacentos] = arrayacentos[iacentos].replace(datahtml,arruni[iacentos]);		 
	    }		    
	  });  
	});
				
	var newcad = '';			
	$.each(arrayacentos,function(i,data){
	  newcad += arrayacentos[i] + ' ';  
	  
	});	
	return newcad.substr(0,newcad.length-1);
	
}

function despliegapruebas_registro(data)
{
	$('#categoria_registro').html(data);
	$("#selectcategoria_registro option[value='"+$("#selectcategoria_registro :contains('General')").val()+"']").remove();	
	
	$('#categoria_ordenar').click(function(){											 
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

function firscharupper(cad)
{	
    return cad.substr(0,1).toUpperCase()+cad.toLowerCase().substr(1,cad.length);
}

function showPreview(coords)
{	
		var ancho_original = $('#ancho_original').val();
		var alto_original = $('#alto_original').val();			
		
		$('#x1').val(coords.x);
		$('#y1').val(coords.y);
		$('#x2').val(coords.x2);
		$('#y2').val(coords.y2);
		$('#w').val(coords.w);
		$('#h').val(coords.h);
		
		if(parseFloat(ancho_original) <= 80 && parseFloat(alto_original) <= 110){ 		
		  var rx = ancho_original / coords.w;
		  var ry = alto_original / coords.h; 	
		  $('#preview').css({
			  width: Math.round(rx * ancho_original) + 'px',
			  height: Math.round(ry * alto_original) + 'px',
			  marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			  marginTop: '-' + Math.round(ry * coords.y) + 'px'
		  });		
		}else{
		  var rx = coords.w / 70;
		  var ry = coords.h / 90; 		
		  $('#preview').css({
			  width: Math.round(ancho_original / rx) + 'px',
			  height: Math.round(alto_original / ry) + 'px',
			  marginLeft: '-' + Math.round(coords.x / rx) + 'px',
			  marginTop: '-' + Math.round(coords.y / ry) + 'px'
		  }); 	
		}
}
//************************************************************************************