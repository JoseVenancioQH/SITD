var unBlockSucces = true;

function unJSBlockUI(cancelado)
    {
	         $.unblockUI(); 			 
			 unBlockSucces = false;
			 if(cancelado=='cancelado' || cancelado=="({'cancelado':'cancelado'})") {location.href="../index.php"; return false;}else{return true;}
    }	
function JSBlockUI(mensaje,timeout)
    {		     
	
	         if(typeof mensaje == 'undefined'){mensaje = '<img src="../img/ajax-loader.gif" />Registrando, espere...';} else {mensaje = '<img src="../img/ajax-loader.gif" />'+mensaje;}
	         $.blockUI({ 				 	   
				 message: mensaje,  
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
			 if(typeof mensaje != 'undefined'){
			 if(timeout != ''){			 
				 setTimeout(function() { 
										$.unblockUI({ 
										onUnblock: function(){if(unBlockSucces){alert('Se agoto el tiempo de espera, no se realizo registro... Contacte al administrador');} } 
									   }); 
						   }, parseInt(timeout));
				 }
			 }
    }