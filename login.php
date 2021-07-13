<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" >

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords"  />
  <meta name="description" content="SAD - Inicio" />
  <title>Sistema Administrador Deportivo</title>
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />        
 
  <link rel="stylesheet" href="css/system.css" type="text/css" />
  <link href="css/login.css" rel="stylesheet" type="text/css" />
   
   
  <!--[if IE 7]>
  <link href="css/ie7.css" rel="stylesheet" type="text/css" />
  <![endif]-->
   
  <!--[if lte IE 6]>
  <link href="css/ie6.css" rel="stylesheet" type="text/css" />
  <![endif]-->
 
  <link rel="stylesheet" type="text/css" href="css/rounded.css" />
 
  <script language="javascript" type="text/javascript"> 
      function setFocus() {
          document.login.username.select();
          document.login.username.focus();
      }
  </script>
</head>

<body onload="javascript:setFocus()">
	<div id="border-top" class="h_blue">
		<div>
			<div>
				<span class="title"></span>
			</div>
		</div>
	</div>
	<div id="content-box">
		<div class="padding">
			<div id="element-box" class="login">
				<div class="t">
					<div class="t">
						<div class="t"></div>
					</div>
				</div>
				<div class="m">
 
					<h1>Acceso Sistema Administrador Deportivo</h1>
					
                    <?php
		if(isset($_GET["action"])){echo ($_GET["action"]=="bye")?"<dl id=\"system-message\"><dt class=\"message\">Mensaje</dt><dd class=\"message message fade\"><ul><li>Has Salido del Sistema.</li></ul></dd></dl>":"<dl id=\"system-message\"><dt class=\"error\">Error</dt><dd class=\"error message fade\"><ul><li>Nombre de usuario y contraseña no encontrados</li></ul></dd></dl>";}
                    ?>                 
							<div id="section-box">
			<div class="t">
				<div class="t">
					<div class="t"></div>
		 		</div>
	 		</div>
			<div class="m">
	<form action="scripts/session-auth.php" method="post" name="login" id="form-login" style="clear: both;">
	<p id="form-login-username">
		<label for="modlgn_username">Nombre de usuario</label>
		<input name="username" id="modlgn_username" type="text" class="inputbox" size="15" />
	</p>
 
	<p id="form-login-password">
		<label for="modlgn_passwd">Contraseña</label>
		<input name="passwd" id="modlgn_passwd" type="password" class="inputbox" size="15" />
	</p>
		<p id="form-login-lang" style="clear: both;">
			</p>
	<div class="button_holder">
	<div class="button1">
		<div class="next">
			<a onclick="login.submit();">
				Acceder</a>
 
		</div>
	</div>
	</div>
	<div class="clr"></div>
	<input type="submit" style="border: 0; padding: 0; margin: 0; width: 0px; height: 0px;" value="Acceder" />
	</form>
				<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
		 			<div class="b"></div>
				</div>
			</div>
		</div>
		
					<p>Usa un nombre de usuario y contraseña válido para poder tener acceso a la administración.</p>
					<p>
						<a href="#/joomla/">Regresar a la página de inicio</a>
					</p>
					<div id="lock"></div>
					<div class="clr"></div>
				</div>
				<div class="b">
					<div class="b">
						<div class="b"></div>
					</div>
				</div>
			</div>
			<noscript>
				¡Advertencia! JavaScript debe estar habilitado para un correcto funcionamiento de la Administración			</noscript>
			<div class="clr"></div>
		</div>
	</div>
	<div id="border-bottom"><div><div></div></div>
</div>
<div id="footer">
	<p class="copyright">
		<a href="#" target="_blank">Sistema Administrador Deportivo - </a>
		<a>Empresa Autorizada</a>.
    </p>
</div>
</body>
</html>

