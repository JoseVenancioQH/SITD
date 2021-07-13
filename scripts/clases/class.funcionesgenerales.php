<?php
error_reporting(E_ALL);
class funcionesgenerales extends MySQL
{  	
    /* importe - tipomonedaidentificada - tipodemonedaaconvertir */ 
	function ConversionTipoMoneda($contratoimporte,$valortipomoneda_bd,$valortipomoneda_reporte)
	{			
		return (($contratoimporte/$valortipomoneda_bd)*$valortipomoneda_reporte);		
	}
	
	function CPaN($tamanopapel_mm,$porciento)
	{		   
	   return ($tamanopapel_mm*($porciento/100));		
	}
	
	function utf8($string_utf8)
	{
	         $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	         $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
			 return	$string_utf8_res;
	}
	
	function ascii($string_ascii)
	{
	   $string_ascii_temp = html_entity_decode($string_ascii);	   
	   return	$string_ascii_temp;
	}	
	
}
?>