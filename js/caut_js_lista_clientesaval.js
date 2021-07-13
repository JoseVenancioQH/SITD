jQuery.noConflict();
var campo='id_avalcliente';
var orden='desc';
var limite=10;
var filtro='';
var pagina=1;
var paginado=0;

jQuery().ready(function(){							
		repeat_ready();		
	    jQuery('#restablecer').click(function () { jQuery('#search').val(''); pagina=1;  paginado=0; readdata(); });			
		jQuery('#ir').click(function () {  pagina=1;  paginado=0; readdata(); });		
});

function repeat_ready()
{
	jQuery('#checkAll').click(function () {									
		jQuery(this).parents('#tabla_desplegado').find(':checkbox').attr('checked', this.checked);
	});	
	
	jQuery('#limit').change(function () { pagina=1; paginado=0; readdata();});
}

function readfilter()
{
	limite=jQuery('#limit').val();filtro=jQuery("#search").val();		
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
	if(jQuery("#limit").length == 0) limite=0;
	jQuery.post("../scripts/caut_script_lista_clientesaval.php", 
			  {paginado: paginado, pagina: pagina, limite: limite, filtro: filtro, campo:  campo, orden:  orden }, function(data){loaddata(data);repeat_ready();}
	);
}

function loaddata(data)
{
	if(data=='cancel')location.href="../index.php";
	else jQuery('#tabla_desplegado').html(data);
}

function operacion(tipo,texto)
{	
    if(tipo=='edit'){		
		if(jQuery('.check_me:checked').length==1){
			location.href="caut_mod_guardaraplicar_clientesaval.php?id="+jQuery('.check_me:checked').val()+"&tipo="+tipo+"&texto="+texto;			
		}else{
			 mensaje('Seleccione un elemento de la lista, para editar...','error','Error');			 
		}				
	}
	
	if(tipo=='add'){
		location.href="caut_mod_guardaraplicar_clientesaval.php?id=0&tipo="+tipo+"&texto="+texto;		
	}
}

function status(tipo)
{	
    var array_check_me = new Array();
    jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});
	if(array_check_me.length>0){
	jQuery.post("../scripts/caut_script_status_clientes.php", 
			  {tipo: tipo, ids: array_check_me.join(',')}, function(data){loaddatastatus(data,tipo);}
	);}else{mensaje('Seleccione un elemento de la lista, para habilitar / deshabilitar...','error','Error');}	
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
	jQuery.post("../scripts/caut_script_status_clientes.php", 
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

function borraraval()
{
	
	var array_check_me = new Array();
    jQuery(".check_me:checked").each(function(){array_check_me.push(this.value)});
	if(array_check_me.length>0){
	jQuery.post("../scripts/caut_script_borrar_clientesaval.php", 
			  {ids: array_check_me.join(',')}, function(data){loaddataborrar(data);}
	);}else{mensaje('Seleccione un elemento de la lista, para borrar...','error','Error');}
	
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

function mensaje(mensaje,class_mensaje,texto_mensaje)
{
	jQuery('#mensaje').html("<dl id=\"system-message\"><dt class=\""+class_mensaje+"\">"+texto_mensaje+"</dt><dd class=\""+class_mensaje+" message fade\"><ul><li>"+mensaje+"</li></ul></dd></dl>");
    var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);},5000);
}