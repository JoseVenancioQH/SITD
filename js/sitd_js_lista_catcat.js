jQuery.noConflict();
var campo='ca.id_categoria';
var orden='desc';
var limite=10;
var filtro='';
var pagina=1;
var paginado=0;

jQuery().ready(function(){							
		repeat_ready();		
	    jQuery('#restablecer').click(function () { jQuery('.inputbox').val(''); jQuery('#search').val(''); pagina=1;  paginado=0; readdata(); });			
		jQuery('#ir').click(function () {pagina=1;  paginado=0; readdata();});
		jQuery('.inputbox').change(function () {pagina=1;  paginado=0; readdata();});
		jQuery('#filter_eventonacional').change(function(){
			var lista_cat='deportes,rama,moddep';	   											 
			var array_lista=lista_cat.split(',');											 
			if(this.value!=""){											 		   
			   jQuery.post("../scripts/sitd_script_listacombo_catcat.php", {ideventonacional: this.value, lista:lista_cat}, function(data){loaddatalistacombo(data,lista_cat);},"json");			
			}else{jQuery.each(array_lista,function(ilista,datalista){jQuery('#filter_'+datalista).empty().append('<option value="" selected>- Selecciona '+datalista+' -</option>').attr('disabled','disabled')});}
		});		
});		

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

function repeat_ready()
{	
	jQuery('#checkAll').click(function () {									
		jQuery(this).parents('#tabla_desplegado').find(':checkbox').attr('checked', this.checked);
	});	
	jQuery('#limit').change(function () {pagina=1; paginado=0; readdata();});
}

function readfilter()
{	
	limite=jQuery('#limit').val(); filtro=jQuery("#search").val();		
}

function tableOrdering(campo_,orden_)
{
	campo=campo_;
	orden=orden_;	
	readdata();
}

function paginar(paginado_num,pagina_num)
{
	pagina=pagina_num;
	paginado=paginado_num;
	readdata();
}

function readdata()
{
	readfilter();	
	if(jQuery("#limit").length == 0) limite=10;
	jQuery.blockUI({ message: '<h2 style="color:#FFFFFF;"><img src="../img/ajax-loader.gif" />Buscando...</h2>',
					 css: { 
							   border: 'none', 
							   padding: '15px', 
							   backgroundColor: '#000', 
							   '-webkit-border-radius': '10px', 
							   '-moz-border-radius': '10px', 
							   opacity: .5, 
							   color: '#fff'
					 }
				 });
	jQuery.post("../scripts/sitd_script_lista_catcat.php", 
			  {paginado: paginado, pagina: pagina, limite: limite, filtro: filtro, campo:  campo, orden:  orden, idusuario:  jQuery('#idusuario').val(), eventonacional:jQuery('#filter_eventonacional').val(), deportes:jQuery('#filter_deportes').val(), rama:jQuery('#filter_rama').val(), moddep:jQuery('#filter_moddep').val(), anoinicio:jQuery('#catanoinicio').val(), anofin:jQuery('#catanofin').val()}, function(data){loaddata(data);repeat_ready();jQuery.unblockUI();}
	);
}

function loaddata(data)
{
	if(data=='cancel')location.href="../index.php";
	else jQuery('#tabla_desplegado').html(data);
	jQuery('#tabla_desplegado tbody tr').each(function(){
		if(this.id!='')jQuery("a[rel='"+this.id+"']").colorbox({slideshow:true});		
	});
}

function operacion(tipo,texto)
{	
    if(tipo=='addall'){	
		if(jQuery('.check_me:checked').length>=1){
		  var array_check_me = new Array();
          jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});			
		  location.href="sitd_mod_editargrupo_catcat.php?ids="+array_check_me+"&tipo="+tipo+"&texto="+texto;			
		}else{
		  mensaje('{"tipo":"error","mensaje":"Seleccione un elemento de la lista, para editar..."}',4000);			 			 
		}
	}

    if(tipo=='edit'){		
		if(jQuery('.check_me:checked').length==1){
			location.href="sitd_mod_guardaraplicar_catcat.php?id="+jQuery('.check_me:checked').val()+"&tipo="+tipo+"&texto="+texto;			
		}else{
			 mensaje('{"tipo":"error","mensaje":"Seleccione un elemento de la lista, para editar..."}',4000);		 			 
		}				
	}
	
	if(tipo=='add'){
		location.href="sitd_mod_guardaraplicar_catcat.php?id=0&tipo="+tipo+"&texto="+texto;		
	}
}

function status(tipo)
{	 
    var array_check_me = new Array();
    jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});
	if(array_check_me.length>0){
	jQuery.post("../scripts/caut_script_status_invauto.php", 
			  {tipo: tipo, ids: array_check_me.join(',')}, function(data){loaddatastatus(data,tipo);}
	);}else{mensaje('{"tipo":"error","mensaje":"Seleccione un elemento de la lista, para habilitar / deshabilitar..."}',4000);}	
}

function loaddatastatus(data,tipo)
{
	if(data=='cancel')location.href="../index.php";
	else{	
	     if(tipo=='deshabilitar') var status_change='habilitar'; else var status_change='deshabilitar';
		 jQuery.each(data.split(','),function(i,d){					  
		  jQuery('#'+d).html("<a href='#'><img src='../images/"+tipo+".png' onclick='javascript:changestatus(\""+status_change+"\","+d+")' width='16' height='16' border='0' alt=''/></a>");		  	  
		  
		 });		 		 
	}
}

function changestatus(status,id)
{
	jQuery.post("../scripts/caut_script_status_invauto.php", 
			  {tipo: status, ids: id}, function(data){loaddatachangestatus(data,status);}
	);
}

function loaddatachangestatus(data,status)
{	
	if(data=='cancel')location.href="../index.php";
	else{ 				
	      if(status=='deshabilitar') var status_change='habilitar'; else var status_change='deshabilitar';	     
		  jQuery('#'+data).html("<a href='#'><img src='../images/"+status+".png' onclick='javascript:changestatus(\""+status_change+"\","+data+")' width='16' height='16' border='0' alt=''/></a>");		  	 		 		 
	}
}

function borrar()
{	
	var array_check_me = new Array();
    jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});
	if(array_check_me.length>0){
	jQuery.post("../scripts/sitd_script_borrar_catrama.php", 
			  {ids: array_check_me.join(',')}, function(data){loaddataborrar(data);}
	);}else{mensaje('{"tipo":"error","mensaje":"Seleccione un elemento de la lista, para borrar..."}',4000);}	
}

function loaddataborrar(data)
{
	if(data=='cancel')location.href="../index.php";
	else{     	     
	     readdata();
		 /*jQuery.each(data.split(','),function(i,d){					  
		  jQuery('#tr'+d).remove();									  	  
		 });		 		 
		 colorcelda();*/
	}
}

function colorcelda()
{	
	jQuery(".adminlist tr").removeClass("row0");
	jQuery(".adminlist tr").removeClass("row1");
	
	jQuery(".adminlist tr:even").addClass("row0");
	jQuery(".adminlist tr:odd").addClass("row1");	
}

function mensaje(data,timer)
{
	var data = eval('(' + data + ')');							   
	if(data.tipo=='error'){
		jQuery('#mensaje').html("<dl id=\"system-message\"><dt class=\"error\">Error</dt><dd class=\"error message fade\"><ul><li>"+data.mensaje+"</li></ul></dd></dl>");
	}else{
		jQuery('#mensaje').html("<dl id=\"system-message\"><dt class=\"succes\"></dt><dd class=\"succes message fade\"><ul><li>"+data.mensaje+"</li></ul></dd></dl>");	
	} 	
	if(timer!=0){
		var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);},timer);		
	}
}