jQuery.noConflict();

jQuery().ready(function(){
	
	jQuery('.item').click(function(){jQuery(".nodo[name='"+this.name+"']").attr('checked', jQuery(".item[name='"+this.name+"']:checked").length > 0 ? true : false); jQuery("#priv").attr('checked',jQuery(".nodo:not(input[name='ac[]']):checked").length > 0 ? true : false) });
	
	jQuery('.nodo').click(function(){var checked_nodo = this.checked; jQuery("input[name='"+this.name+"']").each(function(){this.checked = checked_nodo}); jQuery("#priv").attr('checked',jQuery(".nodo:not(input[name='ac[]']):checked").length > 0 ? true : false)});
			
	jQuery('#priv').click(function(){var checked_priv = this.checked; jQuery(".nodo:not(input[name='ac[]']), .item:not(input[name='ac[]'])").each(function(){this.checked = checked_priv});});
	
	jQuery('#perfil').change(function(){un_checkall(); switch (this.value){ case 'superadmin':	superadmin_check();	break; case 'admin': admin_check(); break; case 'reg':	reg_check(); break; case 'invitado': invitado_check(); break;}							  
	/*var checked_priv = this.checked; jQuery(".nodo:not(input[name='ac[]']), .item:not(input[name='ac[]'])").each(function(){this.checked = checked_priv});*/});	
	jQuery("#form_usuario").validationEngine({promptPosition: "topRight"});	
});

function un_checkall()
{
	jQuery(".nodo:not(input[name='ac[]']), .item:not(input[name='ac[]']), .padre").each(function(){this.checked = false;});
}

function superadmin_check()
{	
	jQuery(".nodo:not(input[name='ac[]']), .item:not(input[name='ac[]']), .padre").each(function(){this.checked = true});
}
function admin_check()
{
	jQuery(".nodo:not(input[name='ac[]'], input[name='sis[]']), .item:not(input[name='ac[]'], input[name='sis[]']), .padre").each(function(){this.checked = true});
}
function reg_check()
{
}
function invitado_check()
{
}

function validar(tipo)
{  	          	
    if(jQuery("#form_usuario").validationEngine('validate')){guardar_aplicar(tipo);}else{ var sliderIntervalID = setInterval(function(){jQuery("#form_usuario").validationEngine('hideAll'); clearInterval(sliderIntervalID);},5000);}
}

function guardar_aplicar(tipo)
{	
   if(jQuery('#password').val()==jQuery('#password2').val()){
	  var array_accion = new Array();
	  var array_privilegio = new Array();	
	  
	  jQuery("input[name='ac[]']:checked:not(#accion)").each(function(){array_accion.push(this.id)});    
	  jQuery(".nodo:not(input[name='ac[]']):checked, .item:not(input[name='ac[]']):checked").each(function(){array_privilegio.push(this.id)});    		  
	  
	  jQuery.post("../scripts/sitd_script_"+tipo+"_usuarios.php", 
				{accion: array_accion.join(','), privilegio: array_privilegio.join(','), /*empresa:  jQuery('#empresa').val(),*/ nombre:  jQuery('#nombre').val(),appaterno:  jQuery('#appaterno').val(), apmaterno:  jQuery('#apmaterno').val(), nombreusuario:  jQuery('#nomusuario').val(), pass:  jQuery('#password').val(), municipio:  jQuery('#filter_municipio').val(), id:  jQuery('#id').val(), perfil:  jQuery('#perfil').val() }, function(data){loaddata(data);}			
	  );	
   }else{
	  mensaje('{"tipo":"error","mensaje":"Verifique Contrase&ntilde;as, no concuerdan..."}',6000);
   }
}

function loaddata(data)
{	
    /*mensaje(data,6000);
	if(tipo == 'guardartodo' || tipo == 'aplicar'){var sliderIntervalID = setInterval(function(){location.href="../modulos/sitd_mod_lista_catrama.php"; clearInterval(sliderIntervalID);},7000);}else
	{jQuery('#rama').val('');jQuery('#filter_eventonacional').val('');} */	
    /*jQuery('#mensaje').html(data);*/
	
	mensaje(data,6000);
    var sliderIntervalID = setInterval(function(){jQuery('#mensaje').html(''); clearInterval(sliderIntervalID);},3000);
}

function edit_data()
{ 
  if(jQuery('#id').val()!='0')
  jQuery.post("../scripts/sitd_script_editar_usuarios.php", {id: jQuery('#id').val()}, function(data){load_edit_data(data);},"json");
}

function load_edit_data(data)
{
	jQuery.each(data, function(i,item){							   
		 jQuery.each(item.privilegios.split(','),function(ii,dato){			   
				jQuery('#'+dato).attr('checked',true);								
		 });		 
		 jQuery.each(item.acciones.split(','),function(ii,dato){			   
				jQuery('#'+dato).attr('checked',true);								
		 });
		 jQuery('#filter_municipio').val(item.idmunicipio);
		 jQuery('#perfil').val(item.perfil);		 
		 jQuery('#nombre').val(item.nombre);
		 jQuery('#appaterno').val(item.appaterno);
		 jQuery('#apmaterno').val(item.apmaterno);
		 jQuery('#nomusuario').val(item.nomusuarios);
		 jQuery('#password').val(item.pass);
		 jQuery('#password2').val(item.pass);
	});
	
	/*jQuery("#priv").attr('checked',jQuery(".nodo:not(input[name='ac[]']):checked").length > 0 ? true : false);
	jQuery("#accion").attr('checked',jQuery(".item:input[name='ac[]']:checked").length > 0 ? true : false);	*/
}