<?php 
	include("../scripts/include/dbcon.php");
    require "../scripts/clases/class.dbsession.php";
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: ../index.php");
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Asoc. Deportiva | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type='text/javascript' src='../js/jquery.highlightFade.js'></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script> 
</head>
<body>
<div class="container">		
    
    <div id="header">
   	  <div id="user_id">Bienvenido <?php echo $_SESSION["nombre"]; ?> | <a title="salir del sistema" href="../scripts/close-session.php">Salir</a></div>
	  <h1><img alt="QSERVICE - Integrate" src="../img/logo.png" /> RED - - Empresa Autorizada -</h1>
    </div>
    
    <div id="navegacion"> 
       <ul id="menu">
        <?php
			$seccion = "asociaciondeportiva";
			include("../scripts/menu.php");
        ?>       
        </ul>             
            <ul id="submenu">
                <?php
			        $seccion = "modificar";
			        include("../scripts/menu-asociaciondeportiva.php");
                ?>
            </ul>            
    </div>
    
    <div id="form">
      
        <div id="listado-inventario">
        	<?php /*?><h2>Contratos</h2>
            <input type="hidden" name="nocontrato" id="nocontrato">
            <input type="hidden" name="nofolio" id="nofolio">
            <input type="hidden" name="productos" id="productos">
            <input type="hidden" name="intercambio" id="intercambio">            
            <table width="950" border="0">
            <thead>
                  <tr>
                    <th>FOLIO</td>
                    <th>CLIENTE</td>
                    <th>DOCUMENTO</td>
                    <th>NO. DE PAGOS</td>
                    <th>MONTO</td>
                    <th>ACCIONES</td>
                  </tr>
            </thead>
            <?php
				$contrato->mostrarContratos();
            ?>
 
           </table><?php */?>
		<!--<div id="dialog" title="Estas seguro que deseas eliminar?">
			<p>Contrato con folio: <span id="no_contrato" style="font-weight:bold;"></span><br />
            
			</p>
		</div>   -->         

        </div>             
    </div>
    
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>        
</div>    
</body>
</html>
