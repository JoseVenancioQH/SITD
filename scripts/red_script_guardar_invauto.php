<?php
set_time_limit(0);	
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	 echo "cancel";
}else{
	include("clases/class.mysql.php");
	include("clases/class.caut_invauto.php");	
	$invauto = new invauto();	 	
	$invauto->idempresa = $_POST['idempresa'];
	$invauto->id = $_POST['idauto'];
	$invauto->noserie = $_POST['noserie'];
	$invauto->nopedimento = $_POST['nopedimento'];
	$invauto->millas = $_POST['millas'];
	$invauto->noplacas = $_POST['noplacas'];
	$invauto->nomotor = $_POST['nomotor'];	
	$invauto->norfa = $_POST['norfa'];
	$invauto->nofactura = $_POST['nofactura'];
	$invauto->notenencia = $_POST['notenencia'];
	$invauto->tcirculacion = $_POST['tcirculacion'];
	$invauto->kmrecorridos = $_POST['kmrecorridos'];
	$invauto->color = $_POST['color'];
	$invauto->marca = $_POST['marca'];
	$invauto->modelo = $_POST['modelo'];
	$invauto->linea = $_POST['linea'];	
	$invauto->tipo = $_POST['tipo'];
	$invauto->cilindros = $_POST['cilindros'];
	$invauto->comext = $_POST['comext'];
	$invauto->comint = $_POST['comint'];
	$invauto->acc = $_POST['acc'];
	$invauto->commec = $_POST['commec'];	
	echo $invauto->grabarInvAuto();	
}
?>