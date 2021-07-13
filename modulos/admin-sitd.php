<?php 
	include("../scripts/include/dbcon.php");
    require "../scripts/clases/class.dbsession.php";
	include("../scripts/clases/class.mysql.php");			
	
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: ../index.php");
	}    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" id="minwidth" >
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="Deporte en Baja California Sur, Deporte Sudcaliforniano, Deporte BCS, DEPORTE, Instalaciones Deportivas, INSTALACIONES DEPORTIVAS" />
  <meta name="description" content="RED - Panel de Control" />
  <meta name="generator" content="Joomla! 1.5 - Open Source Content Management" />
  <title>RED - Panel de Control</title>
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" /> 
  
  <script type="text/javascript" src="../js/mootools.js"></script>
   <link rel="stylesheet" href="../css/system.css" type="text/css" />
  <link href="../css/template.css" rel="stylesheet" type="text/css" />
 
  <!--[if IE 7]>
  <link href="../css/ie7.css" rel="stylesheet" type="text/css" />
  <![endif]-->
 
  <!--[if lte IE 6]>
  <link href="../css/ie6.css" rel="stylesheet" type="text/css" />
  <![endif]-->
 
  <link rel="stylesheet" type="text/css" href="../css/rounded.css" />
 
  <script type="text/javascript" src="../js/menu.js"></script>
  <script type="text/javascript" src="../js/index.js"></script>
</head>

<body id="minwidth-body">

	<div id="border-top" class="h_blue">
		<div>
			<div>
				<span class="version">Bienvenido <?php echo $_SESSION["nombre"].", ".$_SESSION["municipio"];?></span>
				<span class="title"></span>
			</div>
		</div>
	</div>
    
	<div id="header-box">
		<div id="module-status">
			<span class="logout"><a href="../scripts/close-session.php"> Cerrar sesión</a></span>
		</div>
	
        <div id="module-menu">
         <ul id="menu" >
             <?php include("../scripts/menu.php"); ?>
         </ul>
        </div>
         
		<div class="clr"></div>
	</div>
    
    
	<div id="content-box">
		<div class="border">
			<div class="padding">
				<div id="element-box">					
					<div class="t">
						<div class="t">
							<div class="t"></div>
						</div>                   
                    </div>
                    
					<div class="m" >
						<table class="adminform">
						<tr>
							<td width="55%" valign="top">
								<div id="cpanel">            
                                
                                    <?php include("../scripts/panelcontrol.php"); ?>   
                                    
			                   </div>	
							</td>
                            
							<td width="45%" valign="top">
								<div id="content-pane" class="pane-sliders"><div class="panel"><h3 class="jpane-toggler title" id="cpanel-panel-custom"><span>Welcome to Joomla!</span></h3><div class="jpane-slider content"><div style="padding: 5px">  <p>   Congratulations on choosing Joomla! as your content management system. To   help you get started, check out these excellent resources for securing your   server and pointers to documentation and other helpful resources. </p> <p>   <strong>Security</strong><br /> </p> <p>   On the Internet, security is always a concern. For that reason, you are   encouraged to subscribe to the   <a href="http://feedburner.google.com/fb/a/mailverify?uri=JoomlaSecurityNews" target="_blank">Joomla!   Security Announcements</a> for the latest information on new Joomla! releases,   emailed to you automatically. </p> <p>   If this is one of your first Web sites, security considerations may   seem complicated and intimidating. There are three simple steps that go a long   way towards securing a Web site: (1) regular backups; (2) prompt updates to the   <a href="http://www.joomla.org/download.html" target="_blank">latest Joomla! release;</a> and (3) a <a href="http://docs.joomla.org/Security_Checklist_2_-_Hosting_and_Server_Setup" target="_blank" title="good Web host">good Web host</a>. There are many other important security considerations that you can learn about by reading the <a href="http://docs.joomla.org/Category:Security_Checklist" target="_blank" title="Joomla! Security Checklist">Joomla! Security Checklist</a>. </p> <p>If you believe your Web site was attacked, or you think you have discovered a security issue in Joomla!, please do not post it in the Joomla! forums. Publishing this information could put other Web sites at risk. Instead, report possible security vulnerabilities to the <a href="http://developer.joomla.org/security/contact-the-team.html" target="_blank" title="Joomla! Security Task Force">Joomla! Security Task Force</a>.</p><p><strong>Learning Joomla!</strong> </p> <p>   A good place to start learning Joomla! is the   "<a href="http://docs.joomla.org/beginners" target="_blank">Absolute Beginner's   Guide to Joomla!.</a>" There, you will find a Quick Start to Joomla!   <a href="http://help.joomla.org/ghop/feb2008/task048/joomla_15_quickstart.pdf" target="_blank">guide</a>   and <a href="http://help.joomla.org/ghop/feb2008/task167/index.html" target="_blank">video</a>,   amongst many other tutorials. The   <a href="http://community.joomla.org/magazine/view-all-issues.html" target="_blank">Joomla!   Community Magazine</a> also has   <a href="http://community.joomla.org/magazine/article/522-introductory-learning-joomla-using-sample-data.html" target="_blank">articles   for new learners</a> and experienced users, alike. A great place to look for   answers is the   <a href="http://docs.joomla.org/Category:FAQ" target="_blank">Frequently Asked   Questions (FAQ)</a>. If you are stuck on a particular screen in the   Administrator (which is where you are now), try clicking the Help toolbar   button to get assistance specific to that page. </p> <p>   If you still have questions, please feel free to use the   <a href="http://forum.joomla.org/" target="_blank">Joomla! Forums.</a> The forums   are an incredibly valuable resource for all levels of Joomla! users. Before   you post a question, though, use the forum search (located at the top of each   forum page) to see if the question has been asked and answered. </p> <p>   <strong>Getting Involved</strong> </p> <p>   <a name="twjs" title="twjs"></a> If you want to help make Joomla! better, consider getting   involved. There are   <a href="http://www.joomla.org/about-joomla/contribute-to-joomla.html" target="_blank">many ways   you can make a positive difference.</a> Have fun using Joomla!.</p></div></div></div><div class="panel"><h3 class="jpane-toggler title" id="cpanel-panel-logged"><span>Logged in Users</span></h3><div class="jpane-slider content">
<form method="post" action="index.php?option=com_users">
	<table class="adminlist">
		<thead>
			<tr>
				<td class="title">
					<strong>#</strong>
				</td>
				<td class="title">
					<strong>Nombre</strong>
				</td>
				<td class="title">
					<strong>Grupo</strong>
				</td>
				<td class="title">
					<strong>Cliente</strong>
				</td>
				<td class="title">
					<strong>Última vez Activo</strong>
				</td>
				<td class="title">
					<strong>Cerrar Sesión</strong>
				</td>
			</tr>
		</thead>
		<tbody>
				<tr>
				<td width="5%">
					1				</td>
				<td>
					<a href="index.php?option=com_users&amp;task=edit&amp;cid[]=62" title="Editar usuario">admin</a>				</td>
				<td>
					Super Administrator				</td>
				<td>
					administrator				</td>
				<td>
					0.0 horas				</td>
				<td>
								</td>
			</tr>
					</tbody>
	</table>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="client" value="" />
	<input type="hidden" name="cid[]" id="cid_value" value="" />
	<input type="hidden" name="28a82832bc4ec246ab2da9a6f408fc8c" value="1" /></form>
</div></div><div class="panel"><h3 class="jpane-toggler title" id="cpanel-panel-popular"><span>Popular</span></h3><div class="jpane-slider content">
<table class="adminlist">
<tr>
	<td class="title">
		<strong>Artículos populares</strong>
	</td>
	<td class="title">
		<strong>Creado</strong>
	</td>
	<td class="title">
		<strong>Impresiones</strong>
	</td>
</tr>
	<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=55">
				Directorio</a>
		</td>
		<td>
			2010-06-08 16:36:50		</td>
		<td>
			1260		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=70">
				INICIA QSERVICE - Integrate PREPARATIVOS PARA EL DESFILE CIVICO DEPORTIVO</a>
		</td>
		<td>
			2010-09-08 22:56:13		</td>
		<td>
			476		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=76">
				ALICIA GULUARTE SE PREPARA PARA PANAMERICANO DE CANOTAJE</a>
		</td>
		<td>
			2010-09-13 22:14:57		</td>
		<td>
			355		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=68">
				200 MIL PESOS MENSUALES DESTINARA EL ESTADO EN BECAS.</a>
		</td>
		<td>
			2010-09-08 22:51:09		</td>
		<td>
			352		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=57">
				ERICK IBARRA LOGRA LA MEDALLA DE ORO EN LUCHA GRECOROMANA</a>
		</td>
		<td>
			2010-06-09 15:10:18		</td>
		<td>
			346		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=78">
				INTEGRAN LA PRESELECCION DE BEISBOL DE PRIMERA FUERZA</a>
		</td>
		<td>
			2010-09-13 22:17:27		</td>
		<td>
			269		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=120">
				PARTIO LA SELECCIÓN AL NACIONAL DE BEISBOL DE JALISCO</a>
		</td>
		<td>
			2010-10-20 23:21:44		</td>
		<td>
			260		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=56">
				GABRIEL OSUNA TRIUNFA EN EL ABIERTO DE TKD EN CANADA</a>
		</td>
		<td>
			2010-06-09 14:47:00		</td>
		<td>
			200		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=95">
				LLEGA ENTRENADOR CHINO PARA LA DISCIPLINA DE CLAVADOS</a>
		</td>
		<td>
			2010-10-01 23:45:38		</td>
		<td>
			160		</td>
	</tr>
		<tr>
		<td>
			<a href="index.php?option=com_content&amp;task=edit&amp;id=122">
				BCS PIERDE Y SE COMPLICA LA CALIFICACION A LA SEGUNDA RONDA</a>
		</td>
		<td>
			2010-10-25 22:47:27		</td>
		<td>
			150		</td>
	</tr>
	</table>
</div></div><div class="panel"><h3 class="jpane-toggler title" id="cpanel-panel-latest"><span>Recent added Articles</span></h3><div class="jpane-slider content">
<table class="adminlist">
<tr>
	<td class="title">
		<strong>Últimos items</strong>
	</td>
	<td class="title">
		<strong>Creado</strong>
	</td>
	<td class="title">
		<strong>Autor</strong>
	</td>
</tr>
		<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=247">
					TRABAJO ESPECIAL PARA SELECCIONADOS DE CICLISMO: VALENZUELA</a>
			</td>
			<td>
				2011-04-08 16:09:52			</td>
			<td>
				COMSOCIAL			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=246">
					CHUCHO RAMIREZ HARA VISORIA PARA DETECTAR TALENTOS DE FUTBOL</a>
			</td>
			<td>
				2011-04-08 16:04:34			</td>
			<td>
				COMSOCIAL			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=245">
					SALVADOR ROBLES VILLALOBOS NUEVO DIRECTOR DEL QSERVICE - Integrate</a>
			</td>
			<td>
				2011-04-07 17:55:34			</td>
			<td>
				COMSOCIAL			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=244">
					BCS DEBE MANTENER EL LUGAR 15 EN EL MEDALLERO OLIMPICO</a>
			</td>
			<td>
				2011-03-31 16:47:11			</td>
			<td>
				comsocial			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=243">
					67 ATLETAS REPRESENTARAN A BCS EN LA OLIMPIADA NACIONAL</a>
			</td>
			<td>
				2011-03-31 16:37:32			</td>
			<td>
				comsocial			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=242">
					Instalacion Deportiva de Baja California Sur</a>
			</td>
			<td>
				2011-03-29 19:08:06			</td>
			<td>
				Jose Venancio Quintero Hermosillo			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=240">
					BCS PIERDE CON HIDALGO Y QUEDA ELIMINADA DEL BENITO JUAREZ</a>
			</td>
			<td>
				2011-03-25 03:20:25			</td>
			<td>
				COMSOCIAL			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=239">
					QSERVICE - Integrate SOLO MEDIARA EN  LA REESTRUCTURACION DEL BASQUETBOL</a>
			</td>
			<td>
				2011-03-25 00:18:23			</td>
			<td>
				COMSOCIAL			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=238">
					600 DEPORTISTAS INCRIBIRA BCS PARA LA OLIMPIADA NACIONAL</a>
			</td>
			<td>
				2011-03-25 00:16:49			</td>
			<td>
				COMSOCIAL			</td>
		</tr>
				<tr>
			<td>
				<a href="index.php?option=com_content&amp;task=edit&amp;id=237">
					DIEZ ARQUEROS REPRESENTARAN A BCS EN LA OLIMPIADA NACIONAL</a>
			</td>
			<td>
				2011-03-25 00:15:07			</td>
			<td>
				COMSOCIAL			</td>
		</tr>
		</table>
</div></div><div class="panel"><h3 class="jpane-toggler title" id="cpanel-panel-stats"><span>Menu Stats</span></h3><div class="jpane-slider content"><table class="adminlist">
	<tr>
		<td class="title" width="80%">
			<strong>Menú</strong>
		</td>
		<td class="title">
			<strong># Ítems</strong>
		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=becas2011">
				becas2011</a>
		</td>
		<td>
			1		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=ead">
				ead</a>
		</td>
		<td>
			2		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=ExamplePages">
				ExamplePages</a>
		</td>
		<td>
			4		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=institutosdeldeporte">
				institutosdeldeporte</a>
		</td>
		<td>
			6		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=keyconcepts">
				keyconcepts</a>
		</td>
		<td>
			3		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=mainmenu">
				mainmenu</a>
		</td>
		<td>
			7		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=othermenu">
				othermenu</a>
		</td>
		<td>
			7		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=redessociales">
				redessociales</a>
		</td>
		<td>
			3		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=sitios-relacionados">
				sitios-relacionados</a>
		</td>
		<td>
			5		</td>
	</tr>
	<tr>
		<td>
			<a href="index.php?option=com_menus&amp;task=view&amp;menutype=usuario-registrado">
				usuario-registrado</a>
		</td>
		<td>
			5		</td>
	</tr>
</table>
</div></div><div class="panel"><h3 class="jpane-toggler title" id="cpanel-panel-feed"><span>Joomla! Security Newsfeed</span></h3><div class="jpane-slider content"><div style="direction: ltr; text-align: left">
			<table cellpadding="0" cellspacing="0" class="moduletable">
							<tr>
				<td>
					<strong>
						<a href="http://developer.joomla.org/security/news.html" target="_blank">
						Joomla! Developer Network - Security News</a>
					</strong>
				</td>
				</tr>
						<tr>
			<td>
				<ul class="newsfeed"  >
									<li>
											<a href="http://feeds.joomla.org/~r/JoomlaSecurityNews/~3/nUW1H--gCks/340-20110401-core-information-disclosure.html" target="_child">
						[20110401] - Core - Information Disclosure</a>
											<div style="text-align: left ! important">
							<ul>
<li><strong>Project:</strong> Joomla!</li>
<li><strong>SubProject:</strong> All</li>
<li><strong>Severity:</strong> Low</li>
<li><strong>Versions:</strong> 1.5.22 and earlier</li>
<li><strong>Exploit type:</strong> Information Disclosure</li>
<li><strong>Reported Date:</strong> 2010-December-08</li>
<li><strong>Fixed Date:</strong> 2011-April-04</li>
</ul>
<h2>Description</h2>
<p><span dir="ltr">Inadequate error checking causes information disclosure.<br /></span></p>
<h2>Affected Installs</h2>
<p>Joomla! version 1.5.22 and all previous 1.5 versions</p>
<h2>Solution</h2>
<p>Upgrade to the latest Joomla! version (1.5.23 or later)</p>
<p>Reported by Hannes Papenberg</p>
<h2>Contact</h2>
<p>The JSST at the <a href="http://developer.joomla.org/security.html" title="Contact the JSST">Joomla! Security  Center</a>.</p><div>
<a href="http://feeds.joomla.org/~ff/JoomlaSecurityNews?a=nUW1H--gCks:ca-dsODggmQ:yIl2AUoC8zA"><img src="http://feeds.feedburner.com/~ff/JoomlaSecurityNews?d=yIl2AUoC8zA" border="0"></img></a>
</div><img src="http://feeds.feedburner.com/~r/JoomlaSecurityNews/~4/nUW1H--gCks" height="1" width="1" />						</div>
											</li>
									</ul>
			</td>
			</tr>
		</table>
		</div>
</div></div></div>
							</td>
						</tr>
						</table>
						<div class="clr"></div>
					</div>
					<div class="b">
						<div class="b">
							<div class="b"></div>
						</div>
					</div>
				</div>
				<noscript>
					¡Advertencia! JavaScript debe estar habilitado para un correcto funcionamiento de la Administración				</noscript>
				<div class="clr"></div>
			</div>
		</div>
	</div>
	<div id="border-bottom"><div><div></div></div></div>
	<div id="footer">
          <p class="copyright">
              <a href="#" target="_blank">Registro Estatal del Deporte - </a>
              <a href="http://www.insude.gob.mx">Instituto Sudcaliforniano del Deporte</a>.
          </p>
    </div>
</body>
</html>


