<?php

/**
 * Class extention for Header and Footer Definitions
 *
 */
 
class pdf_usage extends fpdf_table
{	
	var $nombrereporte = "";
	var $filtroreporte = "";
	var $headfont = "";
	var $anchohoja = 0;
	var $separacion_linea = 0;	
	
	public function Header()
	{
		$this->SetStyle("head1","arial","",$this->headfont+2,"160,160,160");
		$this->SetStyle("head2","arial","",$this->headfont+1,"0,0,0");
		$this->SetStyle("head3","arial","",$this->headfont+1,"0,119,220");
		
	    $this->SetY(10);
			    
	    $this->MultiCellTag(300, $this->separacion_linea, "<head1>Control Automotriz - $this->nombrereporte  (".date("d/M/Y").")</head1>");		
		$this->MultiCellTag(300, $this->separacion_linea, "<head2>$this->filtroreporte\n</head2><head3> QSERVICE - Integrate</head3>");
	    
		if($this->anchohoja==297) {$ancho_hoja_reporte = $this->anchohoja-80; $tamano_imagen = 105;}
		if($this->anchohoja==420) {$ancho_hoja_reporte = $this->anchohoja-90; $tamano_imagen = 120;}
		if($this->anchohoja==216) {$ancho_hoja_reporte = $this->anchohoja-50; $tamano_imagen = 70;}
		if($this->anchohoja==279) {$ancho_hoja_reporte = $this->anchohoja-55; $tamano_imagen = 75;}		
		
	    $this->Image('images/logo.jpg', $ancho_hoja_reporte, 8, $tamano_imagen, 0, '', '');
		//$this->Image('images/logo.jpg', $this->anchohoja-(($this->anchohoja/210)*35), 10, $this->headfont*15, 0, '', '');

	    $this->SetY($this->tMargin);
	}	
	
	public function Footer()
	{
	    $this->SetY(-10);
	    $this->SetFont('Arial','I',7);
	    $this->SetTextColor(170, 170, 170);
	    $this->MultiCell(0, 4, "Pagina {$this->PageNo()} de {nb}", 0, 'C');
	}
} 

?>