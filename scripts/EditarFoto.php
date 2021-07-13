<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{
	
	
	$targ_w = 70;
	$targ_h = 90;
	
	$src = '../'.$_POST['tipo_foto'].'/'.$_POST['curp'].'.png';
	$img_r = imagecreatefrompng($src);
	$dst_r = ImageCreateTrueColor($targ_w, $targ_h);
	
	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
		$targ_w,$targ_h,$_POST['w'],$_POST['h']);
	
	imagepng($dst_r,'../fotosparticipantes/'.$_POST['curp'].'.png');
	
	echo "({'editado':'ok'})";	
	
	
	
}
?>

		 
	