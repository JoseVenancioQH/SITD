var arrhtml = new Array(25); 
var arruni = new Array(25); 
var arrayacentos = new Array();

arrhtml[0]="&NTILDE;";arrhtml[1]="&AACUTE;";arrhtml[2]="&EACUTE;";arrhtml[3]="&OACUTE;";arrhtml[4]="&UACUTE;";arrhtml[5]="&IACUTE;";arrhtml[6]="&Ntilde;";arrhtml[7]="&Aacute;";arrhtml[8]="&Eacute;";arrhtml[9]="&Oacute;";arrhtml[10]="&Uacute;";arrhtml[11]="&Iacute;";
arrhtml[12]="Ñ";arrhtml[13]="Á";arrhtml[14]="É";arrhtml[15]="Ó";arrhtml[16]="Ú";arrhtml[17]="Í";arrhtml[18]="Ñ";arrhtml[19]="Á";arrhtml[20]="É";arrhtml[21]="Ó";arrhtml[22]="Ú";arrhtml[23]="Í";arrhtml[24]="&ntilde;";

arruni[0]="\u00D1";arruni[1]="\u00C1";arruni[2]="\u00C9";arruni[3]="\u00D3";arruni[4]="\u00DA";arruni[5]="\u00CD";arruni[6]="\u00D1";arruni[7]="\u00C1";arruni[8]="\u00C9";arruni[9]="\u00D3";arruni[10]="\u00DA";arruni[11]="\u00CD";arruni[12]="\u00D1";arruni[13]="\u00C1";arruni[14]="\u00C9";arruni[15]="\u00D3";arruni[16]="\u00DA";arruni[17]="\u00CD";arruni[18]="\u00D1";arruni[19]="\u00C1";arruni[20]="\u00C9";arruni[21]="\u00D3";arruni[22]="\u00DA";arruni[23]="\u00CD";arrhtml[24]="\u00D1";

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

function firscharupper(cad)
{	
    return cad.substr(0,1).toUpperCase()+cad.toLowerCase().substr(1,cad.length);
}