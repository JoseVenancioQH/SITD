/*Funcion CURP-------------------------------------------------------------*/
/*-------------------------------------------------------------------------*/

function isEmpty(s)
{ 
   return ((s == null) || (s.length == 0)); 
}

function isSpace(c)
{ 
   return ((c == "\n") || (c == " ") || (c == "\b") || (c == "\t")); 
}

function isWhiteSpace(s)
{
  for(i=0; i<s.length; i++)
  if(!isSpace(s.charAt(i))) return false;
  return true;
}


function StringReplace( findText, replaceText ) { 
	var originalString = new String(this);
	var pos = 0;

	// Validate parameter values
	if (findText+"" != "undefined" || findText == null || findText == "")
		return originalString;
	if (replaceText+"" != "undefined" || replaceText == null)
		return originalString;

	var len = findText.length;
	var limit = originalString.length;
	
	pos = originalString.indexOf(findText);
	while (pos != -1 && i < limit) { 
		// Get the first and last parts of the string:  preString + findText + postString
		// then change to preString + replaceText + postString to replace findText
		preString = originalString.substring(0, pos);
		postString = originalString.substring(pos+len, originalString.length);
		originalString = preString + replaceText + postString;
		pos = originalString.indexOf(findText); 
		i++;
	} 
	
	return originalString;	
}


var tablaseleccionada;
var temp;
var letra1;
var insidencia;
var letra2;
var letraextraida;
var excepciones = 'DA DAS DE DEL DER DI DIE DD EL LA LOS LAS LE LES MAC MC VAN VON Y MARIA JOSE JOSÉ ';
var vocales = 'A E I O U ';
var antisonante = 'BUEI CACA CAGA CAKA COGE COJE COJO FETO JOTO KACO KAGO KOJO KULO LOCO LOKO MAMO MEAS MION MULA BUEY CACO CAGO CAKO COJA COJI CULO GUEY KACA KAGA KOGE KAKA LOCA LOKA MAME MEAR MEON MOCO PEDA PEDO PUTA QULO RUIN PENE PUTO RATA ';
var consonantes = 'B C D F G H J K L M N Ñ P Q R S T V W X Y Z ';
var carEspeciales = '';

function replace(texto,s1,s2){
	return texto.split(s1).join(s2);
}

function curpbusca()
{
	
  var curp = $('#curp').val();    
  
  $.ajax({
		 type: "POST",
		 url: "../scripts/BuscarCURP.php",
		 processData: false,
		 dataType: "html",
		 data:"curp="+curp,
		 beforeSend: function(){JSBlockUI('Buscando CURP...','80000')},
		 success: function(data){if(unJSBlockUI(data)){ if(data=='no') errorcurp(); else curpencontrado(data);}},
		 timeout: 80000
  });	
  
}

function curpencontrado(data)
   {
	   var datoscurp = array(); 
	   datoscurp = data.split('-'); 
       
	   $('#nombres').val(datoscurp[0]);
	   $('#appaterno').val(datoscurp[1]);
	   $('#apmaterno').val(datoscurp[2]);
	   
	   if(datoscurp[5] == 'Hombre') $('#sexo').val('H'); else $('#sexo').val('M'); 	   
	   $('#entidad').val(datoscurp[6]);
	   
	   var fechanac = array();
	   fechanac = datoscurp[6].split('-');
	   $('#fechanacimiento').val(fechanac[2]+'-'+fechanac[1]+'-'+fechanac[0]);   
   }
function errorcurp()
   {
	   $.growlUI('No se encontro el CUR','Registro Exitoso...',5000);
	   $("div.growlUI").css("background","url(../img/button_ok.png) no-repeat 10px 10px"); 	 
   }   

function cargarcurp()
{
	
	var nombre = document.getElementById('nombres').value;
    var appaterno = document.getElementById('appaterno').value;
    var apmaterno = document.getElementById('apmaterno').value;  
    var cbodia = document.getElementById('fechanacimiento').value.substr(0,2);
    var cbomes = document.getElementById('fechanacimiento').value.substr(3,2);  
    var txtanio = document.getElementById('fechanacimiento').value.substr(8,2);    
    
	
	if (nombre!= '' && appaterno != '' && cbodia != '' && cbomes != '' && txtanio != '' )
	{
    //document.getElementById('txtcurp').value = curp(appaterno.toUpperCase(), apmaterno.toUpperCase(), nombre.toUpperCase(), cbodia+'/'+cbomes+'/'+txtanio);
	document.getElementById('curp').value = curp(appaterno.toUpperCase(), apmaterno.toUpperCase(), nombre.toUpperCase(), cbodia+'/'+cbomes+'/'+txtanio);
	}
	else
	{
      $.growlUI('Imposible Generar CURP','Datos Faltantes...',5000);
	  $("div.growlUI").css("background","url(../img/button_cancel.png) no-repeat 10px 10px");		
	  /*alert('Imposible Generara CURP, Datos Faltantes');*/
	  document.getElementById('curp').value = '';	 
	}
	
}

function curp(app, apm, nombres, fechan)
{
var curptemp;
var rt1;
var rt2;
var rt3;
var rt4;
var rt5;
var rt6;
var rt7;
var rt8;
        
        rt1 =  (genapp(app));
//		alert("rt1: "+rt1);
		rt2 =  (genapm(apm));
//		alert("rt2: "+rt2);
		rt3 =  (gennombres(nombres));
//		alert("rt3: "+rt3);
		rt4 =  (genfechan(fechan));
//		alert("rt4: "+rt4);
		rt5 =  (gensexo());
//		alert("rt5: "+rt5);
		rt6 =  (genlocalidad());
//		alert("rt6: "+rt6);
		rt7 =  (genconsonante(app, apm, nombres));
//		alert("rt7: "+rt7);
        
		
        curptemp = rt1+rt2+rt3+rt4+rt5+rt6+rt7;	
	
         
        //verifica si las primeras 4 letras son antisonantes
		var curptemp2 = curptemp.substr(0, 4); 
		insidencia = antisonante.search(curptemp2+' ');
        if (insidencia >= 0) 
		{
           curptemp = curptemp.substr(0, 1)+'X'+curptemp.substr(3);
		}
		
		rt8 =  (CurpVerificador(curptemp+'0'));
		
		curptemp = rt8;
		
return curptemp;         
}

function genapp(appaterno)
{
if (!isEmpty(appaterno) && !isWhiteSpace(appaterno))
{
temp = palabracompuesta(appaterno);

letra1 = temp.substr(0,1);

if (letra1 == 'Ñ') letra1 = 'X';
if (letra1 == '') letra1 = 'X';

letra2 = '';

for (ind=1; ind <= temp.length-1; ind++)
    {
       letraextraida = temp.substr(ind, 1);
	   insidencia = vocales.search(letraextraida+' ');
       if(insidencia >= 0)
	   {
       letra2 = letraextraida;
       break;
	   }   
    }

   if (letra2 == 'Ñ') letra2 = 'X';
   if (letra2 == '') letra2 = 'X';
   
return letra1+letra2;
}
else
{
return 'X';	
}
}

function genapm(apmaterno)
{
if (!isEmpty(apmaterno) && !isWhiteSpace(apmaterno))
{
  temp = palabracompuesta(apmaterno);

  letra1 = temp.substr(0, 1);
   
  if (letra1 == 'Ñ') letra1 = 'X';
   
  return letra1;
}
else
{  
  return 'X';  
}
}

function gennombres(nombres)
{
temp = palabracompuesta(nombres);

letra1 = temp.substr(0, 1);

if (letra1 == 'Ñ') letra1 = 'X';


return letra1;
}


function genfechan(fn)
{
return fn.substr(6,2)+fn.substr(3,2)+fn.substr(0,2);
}

function genlocalidad()
{  
return document.getElementById('entidad').value;
}

function gensexo()
{ 

return document.getElementById('sexo').value; 

/*var rdbhombre = document.getElementById('rdbhombre').checked;
var rdbmujer = document.getElementById('rdbmujer').checked;

if (rdbhombre) return 'H';
if (rdbmujer) return 'M';*/
}

function genconsonante(app, apm, nombres)
{
var tempp;
var tempm;
var tempn;
var cons1;
var cons2;
var cons3;

if (!isEmpty(app) && !isWhiteSpace(app))
{
tempp = palabracompuesta(app);
cons1 = 'X'
for (ind=1; ind <= tempp.length-1; ind++)
    {
       letraextraida = tempp.substr(ind, 1);
	   insidencia = consonantes.search(letraextraida+' ');
       if(insidencia >= 0)
	   {
       cons1 = letraextraida;
	   if (cons1 == 'Ñ') cons1 = 'X'; 
       break;;
	   }   
    }
}
else
{
  cons1 = 'X';
}

if (!isEmpty(apm) && !isWhiteSpace(apm))
{
tempm = palabracompuesta(apm);
cons2 = 'X'
for (ind=1; ind <= tempm.length-1; ind++)
    {
       letraextraida = tempm.substr(ind, 1);
	   insidencia = consonantes.search(letraextraida+' ');
       if(insidencia >= 0)
	   {
       cons2 = letraextraida;	          
	   if (cons2 == 'Ñ') cons2 = 'X'; 
       break;
	   }   
    }
}
else
{
  cons2 = 'X';
}

if (!isEmpty(nombres) && !isWhiteSpace(nombres))
{
cons3 = 'X'
tempn = palabracompuesta(nombres);
for (ind=1; ind <= tempn.length-1; ind++)
    {
       letraextraida = tempn.substr(ind, 1);
	   insidencia = consonantes.search(letraextraida+' ');
       if(insidencia >= 0)
	   {
       cons3 = letraextraida;
	   if (cons3 == 'Ñ') cons3 = 'X'; 
       break;
	   }   
    }
}
else
{
  cons3 = 'X';
}

return cons1+cons2+cons3;
}

function palabracompuesta(cad)
{
var arraycad = new Array();
var elem;
var cadtemp = '';
var palabra = '';

if (!isEmpty(cad) && !isWhiteSpace(cad))
{
arraycad = cad.split(' ');

elem = arraycad.length;


if (elem > 1)
{
	for (ind=0; ind <= elem-1; ind++)
    {	   	 
       cadtemp = arraycad[ind];
	   insidencia = excepciones.search(cadtemp+' ');
       if(insidencia < 0)
	   {
         palabra = arraycad[ind];
         break;
	   }
    }	
}
else
{
    palabra = arraycad[0];
}
return palabra;
}
else
{
return 'X';	
}
}

function CurpVerificador(cCurp)
{
    var cCaracteres='0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
	var nFactor=19;
	var nSuma=0;
	
    
	for (nIndice=0; nIndice < cCaracteres.length; nIndice++)
    {
	  	
	   cCaracter=cCurp.substr(nIndice,1);
	   nPos=cCaracteres.search(cCaracter);
	   nFactor=nFactor-1;
	   nSuma=nSuma+nPos*nFactor;	    	
       
    } 
	
	nDigito=10-mod(nSuma,10);
	if(nDigito==10) nDigito = 0;
	cCurp=cCurp+Math.abs(nDigito);

	return cCurp;
}

// Función modulo, regresa el residuo de una división 
function mod(dividendo , divisor) 
{ 
  resDiv = dividendo / divisor ;  
  parteEnt = Math.floor(resDiv);            // Obtiene la parte Entera de resDiv 
  parteFrac = resDiv - parteEnt ;      // Obtiene la parte Fraccionaria de la división
  modulo = Math.round(parteFrac * divisor);  // Regresa la parte fraccionaria * la división (modulo) 
  return modulo; 
} // Fin de función mod

function Mayusculas(cadena) {
    var result="";
    var str = cadena.split(''); 
    for(i=0; i<=str.length-1; i++) {
        str[i] = str[i].toUpperCase();
        result+=str[i];
    }    
	return(result);
}
/*-------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------*/