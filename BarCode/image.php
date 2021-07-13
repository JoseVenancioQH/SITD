<?php
function CrearBarCode($code, $t, $r, $rot, $text, $f1, $f2, $o, $dpi, $a1, $a2)
{
	$class_dir = "";
	require($class_dir . 'BCGColor.php');
	require($class_dir . 'BCGBarcode.php');
	require($class_dir . 'BCGDrawing.php');
	require($class_dir . 'BCGFont.php');
	include($class_dir . 'BCG' . $code . '.barcode.php');
	/*if(include($class_dir . '/BCG' . $code . '.barcode.php')) {*/
		if($f1 !== '0' && $f1 !== '-1' && intval($f2) >= 1) {
			$font = new BCGFont($class_dir . '/' . $f1, intval($f2));
		} else {
			$font = 0;
		}
		$color_black = new BCGColor(0, 0, 0);
		$color_white = new BCGColor(255, 255, 255);
		$codebar = 'BCG' . $code;
		$code_generated = new $codebar();
		if(isset($a1) && intval($a1) === 1) {
			$code_generated->setChecksum(true);
		}
		if(isset($a2) && !empty($a2)) {
			$code_generated->setStart($a2);
		}
		if(isset($_GET['a3']) && !empty($a3)) {
			$code_generated->setLabel($a3);
		}
		
		$code_generated->setThickness($t);
		$code_generated->setScale($r);
		$code_generated->setBackgroundColor($color_white);
		$code_generated->setForegroundColor($color_black);
		$code_generated->setFont($font);
		$code_generated->parse($text);
		$drawing = new BCGDrawing('', $color_white);
		$drawing->setBarcode($code_generated);
		$drawing->setRotationAngle($rot);
		$drawing->setDPI($dpi == 'null' ? null : (int)$dpi);
		$drawing->draw();
		
		/*if(intval($_GET['o']) === 1) {
			header('Content-Type: image/png');
		} elseif(intval($_GET['o']) === 2) {
			header('Content-Type: image/jpeg');
		} elseif(intval($_GET['o']) === 3) {
			header('Content-Type: image/gif');
		}*/
		imagepng($drawing->finish(intval($o)),"../GaffeteTem/".$text."_barcode.png");
		/*$drawing->finish(intval($_GET['o']));*/
		
	/*}
	else{
		header('Content-Type: image/png');
		readfile('error.png');
	}*/
}
?>