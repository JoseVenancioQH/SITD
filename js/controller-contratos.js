
		$().ready(function(){
	    $("#ciudades").tabs();
		$("#overlay").overlay();     
		$("#capa-intercambio").css("color","#ccc");
		$("#inter-text").css("color","#ccc");		
		$("#promo-text").css("color","#ccc");				
		$("#actualiza-promo").css("visibility","hidden");						
		$("#actualiza-inter").css("visibility","hidden");								
		$('#monto-intercambio').attr("disabled", true); 
		$('#descripcion-intercambio').attr("disabled", true); 
		$('#promociones').attr("disabled", true); 		
		$('#intercambio').attr("disabled", true); 		
		$('#promocion').attr("disabled", true); 		
		$("input.money").numeric();
		$("input.money").numeric();		
	
		$("#actualiza-promo").click(function(){
			var newsubtotal = $("#subtotal").val()-$('#promocion').val()
			$("#iva").val(newsubtotal*0.10);
			$("#subtotal").val(newsubtotal);			
			$("#total").val(newsubtotal+parseInt($("#iva").val()));	
		});
		
		$("#actualiza-inter").click(function(){
			var newsubtotal = $("#subtotal").val()-$('#intercambio').val()
			$("#iva").val(newsubtotal*0.10);
			$("#subtotal").val(newsubtotal);						
			$("#total").val(newsubtotal+parseInt($("#iva").val()));	
		});		
		
		$("#interruptor-promocion").click(function(){
			if($("#interruptor-promocion").is(":checked"))
			{
				$("#promo-text").css("color","#222");
				$('#promocion').attr("disabled", false);
				$('#promociones').attr("disabled", false); 						
				$("#actualiza-promo").css("visibility","visible");										
			}
			else
			{
				$("#promo-text").css("color","#ccc");
				$('#promocion').attr("disabled", true);
				$('#promociones').attr("disabled", true); 										
				$("#actualiza-promo").css("visibility","hidden");										
			}
		});
		
		$("#interruptor-intercambio-up").click(function(){
			if($("#interruptor-intercambio-up").is(":checked"))
			{
				$("#capa-intercambio").css("color","#222");
				$("#inter-text").css("color","#222");						
				$('#intercambio').attr("disabled", false);
				$('#descripcion-intercambio').attr("disabled", false); 
				$("#actualiza-inter").css("visibility","visible");										
				
			}
			else
			{
				$("#capa-intercambio").css("color","#ccc");
				$("#inter-text").css("color","#ccc");						
				$('#intercambio').attr("disabled", true); 			 
				$('#descripcion-intercambio').attr("disabled", true); 
				$("#actualiza-inter").css("visibility","hidden");										
				
			}
		});		
		
		function roundNumber(num, dec) {
			var result = Math.round( Math.round( num * Math.pow( 10, dec + 1 ) ) / Math.pow( 10, 1 ) ) / Math.pow(10,dec);
			return result;
		}
		
				
		$("input:radio").click(function(){
			if(this.name=="formapagos")
			{
				var pagos = this.value;
			}
			var monto_pagos = roundNumber($("#total").val()/pagos,2);
			var nuevo_tr="";
			var i=0;
			var flag = "";
			for(i=0;i<pagos;i++)
			{
				inc = i+1;
			    if(inc%2==0){flag = "class=\"pintalo\"";}else{flag = " ";}
				nuevo_tr += "<tr "+flag+" id=\"pago"+inc+"\"> <td>"+inc+"</td><td>Pago "+inc+" de "+pagos+"</span></td><td><input class=\"span-3 icon-fecha\" id=\"fecha-facturacion"+inc+"\" name=\"fecha-facturacion"+inc+"\" type=\"text\" onclick=\"displayDatePicker('fecha-facturacion"+inc+"', this);\" /></td><td><input class=\"span-3 icon-fecha\" id=\"fecha-pago"+inc+"\" name=\"fecha-pago"+inc+"\" type=\"text\" onclick=\"displayDatePicker('fecha-pago"+inc+"', this);\" /></td><td><input class=\"span-3\" id=\"monto"+inc+"\" name=\"monto"+inc+"\" type=\"text\" value=\""+monto_pagos+"\" /></td></tr>";
			}
			$("#listado-pagos").html(nuevo_tr);
		});		
		
		$("#agregar-producto").click(function(){
			var id = document.getElementById("flowProdNumber").value;
			var nuevo_tr = "<tr id=\"pro"+id+"\"><td><img onclick=\"remove("+id+");\" style=\"vertical-align:middle; margin-left:10px; cursor:pointer;\" alt=\"borrar\" src=\"../img/icons/delete.png\" /></td><td><input style=\"border:0; border-bottom:1px solid #666666; background:none;\" disabled=\"disabled\" class=\"text\" id=\"producto"+id+"\" name=\"producto"+id+"\" type=\"text\" /><input id=\"hproducto"+id+"\" name=\"hproducto"+id+"\" type=\"hidden\" /><img id=\"imagen"+id+"\" onclick=\"openOverlay("+id+");\" style=\"vertical-align:middle; margin-left:10px; cursor:pointer;\" alt=\"buscar\" src=\"../img/icons/view.png\" /></td><td></td><td style=\"text-align:right;\"><input disabled=\"disabled\" style=\"text-align:right; border:0;\" class=\"span-3 money\" id=\"precio"+id+"\" name=\"precio"+id+"\" type=\"span-1\" /></td></tr>";
			$("#antes-de-aqui").before(nuevo_tr);
			$('#pro' + id).highlightFade({speed:300});
			id = (id - 1) + 2;
			document.getElementById("flowProdNumber").value = id;
		});
	});
	
	function procesa()
	{
		$("#cart").val(productosApilados);
	}

	function openOverlay(tbox)
	{ 
		$("#tempProducto").val("producto"+tbox);
		$("#tempProductoPrecio").val("precio"+tbox);
		$("#tempProductoImagen").val("imagen"+tbox);		
		$("#tempProductoId").val("hproducto"+tbox);				
		var api = $("#overlay").overlay(); 
		api.load();             
	}
	
	var productosApilados = new Array();
	function cargaProducto(a,b,c)
	{ 
		if(jQuery.inArray(b, productosApilados) == -1)
		{
			$("#"+$("#tempProductoImagen").val()).css("display","none");
			productosApilados.splice(0,0,b);
			//$("#cart").val();	
			var precio = parseInt(c);
			var pid = $("#tempProducto").val();
			var pp = $("#tempProductoPrecio").val();
			$("#"+pid).val(a);
			$("#"+pp).val(precio);

			var aa = $("#tempProductoId").val()
			$("#"+aa).val(b);
			
			$("#subtotal").val(parseInt($("#subtotal").val())+precio);
			$("#iva").val($("#subtotal").val()*0.10);
			$("#total").val(parseInt($("#subtotal").val())+parseInt($("#iva").val()));	
			$("#overlay").overlay().close();
		}
		else
		{
				alert("Espacio Ya Contratado");
		}
	}
	function remove(a)
	{
		var b = $("#hproducto"+a).val();
		var where = jQuery.inArray(b, productosApilados);
		var precio = $("#precio"+a).val();
		if(precio!="")
		{
			productosApilados.splice(where,1);
			$("#subtotal").val(parseInt($("#subtotal").val())-parseInt($("#precio"+a).val()));
			$("#iva").val($("#subtotal").val()*0.10);
			$("#total").val(parseInt($("#subtotal").val())+parseInt($("#iva").val()));	
		}
		$('#pro' + a).remove();		
	}	

