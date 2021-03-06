<!DOCTYPE HTML>
<html id="todo" xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Vidali</title>
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
	<link rel="shortcut icon" href="vdl-themes/default/img/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="vdl-themes/default/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="vdl-themes/default/css/bootstrap-responsive.css" />
	<link rel="Stylesheet" type="text/css" href="vdl-themes/default/css/smoothness/jquery-ui-1.8.21.custom.css" />	
	<link rel="stylesheet" type="text/css" href="vdl-themes/default/css/style.css" />
	<script type="text/javascript" src="vdl-themes/default/js/jquery.js" ></script>
	<script type="text/javascript" src="vdl-themes/default/js/jquery-ui.js" ></script>
	<script type="text/javascript" src="vdl-themes/default/js/bootstrap.js" ></script>
	<script type="text/javascript" src="vdl-themes/default/js/less.js"></script>
	<script type="text/javascript" src="vdl-themes/default/js/script_default.js"></script>
	<script>
	$(function() {
		$( "#date" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "yy-mm-dd",
			yearRange: "1950:1998"
		});
	});
	</script>
<!--Fin Script -->
	<script type="text/javascript">
	function valida(elque)
	{
		if(elque == "pass1" || elque == "pass2")
		{
			var Exp = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,10})$/;
			if ((document.vdlreg.pass1.value.match(Exp)) && (document.vdlreg.pass1.value!='')) 
			{  
				document.getElementById('confirm1').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/tick.png' alt='Ok'>"; 
			}
			else
			{
				document.getElementById('confirm1').innerHTML = "";
				document.getElementById('confirm2').innerHTML = "";
			}
	
			if ((document.vdlreg.pass1.value!='') && (document.vdlreg.pass2.value!='') && (document.vdlreg.pass2.value==document.vdlreg.pass1.value)) 
			{  
				document.getElementById('confirm2').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/tick.png' alt='Ok'>"; 
			}
			else
			{
				document.getElementById('confirm2').innerHTML = "";
			}
		}
		
		if(elque == "nick")
		{
			if(document.vdlreg.nick.value != 0)
			{
			xmlHttp = new XMLHttpRequest();

			xmlHttp.open("POST", "vdl-include/register_ajax.php", true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
			xmlHttp.send("user="+document.vdlreg.nick.value);
			
			xmlHttp.onreadystatechange=function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200)
			{
				if(xmlHttp.responseText == 0)
				{
					document.getElementById('confirm3').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/tick.png' alt='Ok'>";
				}
				else
				{
					document.getElementById('confirm3').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/mal.png' alt='Incorrecto'>";
				}
			}
			}
			}
			else
			{
				document.getElementById('confirm3').innerHTML = "";
			}
		
		}
		if(elque == "email")
		{
			var val = /^([a-zA-Z0-9._-]+\@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})$/
			if(val.test(document.vdlreg.email.value))
			{
			xmlHttp = new XMLHttpRequest();

			xmlHttp.open("POST", "vdl-include/register_ajax.php", true);
			xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=ISO-8859-1');
			xmlHttp.send("email="+document.vdlreg.email.value);
			
			xmlHttp.onreadystatechange=function(){
			if (xmlHttp.readyState==4 && xmlHttp.status==200)
			{
				if(xmlHttp.responseText == 0)
				{
					document.getElementById('confirm4').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/tick.png' alt='Ok'>";
				}
				else
				{
					document.getElementById('confirm4').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/mal.png' alt='Incorrecto'>";
				}
			}
			}
			}
			else
			{
				document.getElementById('confirm4').innerHTML = "";
			}
		}		
		if(elque == "date")
		{
			if(document.vdlreg.birthdate.value != 0 && document.vdlreg.birthdate.value.match("[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])"))
			{
				document.getElementById('confirm5').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/tick.png' alt='Ok'>";
			}
			else
			{
				document.getElementById('confirm5').innerHTML = "";
			}			
		}
		if(elque == "name")
		{
			if(document.vdlreg.name.value != 0)
			{
				document.getElementById('confirm6').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/tick.png' alt='Ok'>";
			}
			else
			{
				document.getElementById('confirm6').innerHTML = "";
			}
		}
		if(elque == "location")
		{
			if(document.vdlreg.location.value != 0)
			{
				document.getElementById('confirm7').innerHTML = "<img style='padding-left: 5px;' src='vdl-themes/default/img/icons/tick.png' alt='Ok'>";
			}
			else
			{
				document.getElementById('confirm7').innerHTML = "";
			}
		}
}
	</script>
</head>
<body>
    <div class="navbar navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
			<div class="span2"><a class="brand" href="#"><img src="vdl-themes/default/img/logo.png"></a></div>
			<ul class="nav pull-right">
				<li><a href="http://vdli.wordpress.com/">Blog</a></li>
				<li><a href="https://github.com/vidali/Vidali/wiki">Wiki</a></li>
				<li><a href="https://github.com/vidali/Vidali">Github</a></li>
				<li><a href="http://twitter.com/VidaliSN">Twitter</a></li>
			</ul>
        </div>
      </div>
    </div>

<section class="container-fluid">
	<div class="row-fluid">
		<div class="span6">
			<form class="form-horizontal" name="vdlreg" action="vdl-include/reg.php" method="post">
				<fieldset>
					<div class="control-group">
						<label class="control-label" for="input01">Nick</label>
						<div class="controls">
							<input name="nick" type="text" class="input-xlarge" id="input01" onkeyup="valida('nick')">
							<span id="confirm3"></span>
							<p class="help-block">Introduce tu nombre de usuario</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input02">Contraseña</label>
						<div class="controls">
							<input name="pass1" type="password" class="input-xlarge" id="input02" onkeyup="valida('pass1')">
							<span id="confirm1"></span>
							<p class="help-block">Recomendado: 8 caracteres.</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input03">Repita contraseña</label>
						<div class="controls">
							<input name="pass2" type="password" class="input-xlarge" id="input03" onkeyup="valida('pass2')">
							<span id="confirm2"></span>
							<p class="help-block">Repita la contraseña anterior.</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input04">Email</label>
						<div class="controls">
							<input name="email" type="email" class="input-xlarge" id="input04" onkeyup="valida('email')">
							<span id="confirm4"></span>
							<p class="help-block">Introduzca un email válido</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input05">Nombre</label>
						<div class="controls">
							<input name="name" type="text" class="input-xlarge" id="input05" onkeyup="valida('name')">
							<span id="confirm6"></span>
							<p class="help-block">Introduzca un Nombre real</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input06">Fecha de nacimiento:</label>
						<div class="controls">
							<input name="birthdate" type="text" class="input-xlarge" id="date" onkeyup="valida('date')">
							<span id="confirm5"></span>
							<p class="help-block">Selecciona tu fecha de nacimiento </p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input07">Ubicación</label>
						<div class="controls">
							<input name="location" type="text" class="input-xlarge" id="input07" onkeyup="valida('location')">
							<span id="confirm7"></span>
							<p class="help-block">Ej: Tenerife</p>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="input08">Sexo</label>
						<div class="controls">
							<select name= "sex" id="sex">
								<option value="male">Hombre</option>
								<option value="female">Mujer</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="textarea">Descripción</label>
						<div class="controls">
							<textarea class="input-xlarge" name="bio" id="textarea" rows="3" placeholder="Describete!"></textarea>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">!Comenzar!</button>
					</div>
				</fieldset>

			</form>
		</div>
		<div class="span6">
			<h2>Bienvenido a Vidali</h2>
			<p>Gracias por registrarte en nuestra red. Por favor lee las siguientes recomendaciones para usar nuestro sitio.</p>
			<h3>Recomendaciones</h3>
			<ul>
				<li>Usa una contraseña que incluya letras mayusculas, números y simbolos.</li>
				<li>Usa tu nombre real. No será visible para usuarios que no te conozcan.</li>
				<li>Usa tu ubicación real. Con colocar el nombre de tu ciudad es suficiente.</li>
			</ul>
			<h3>Restricciones</h3>
			<ul>
				<li>Queda totalmente prohibido el uso de perfiles falsos (famosos de dudosa realidad, nombres con insultos, etc...).</li>
				<li>Tu fecha de nacimiento <b>no podrá ser modificada</b>. Piensalo 2 veces antes de usar una fecha falsa.</li>
				<li>No se permite la creación de perfiles de marcas. En próximas versiones añadiremos herramientas para publicidad</li>
			</ul>
			<h4>Además, al registrarte en nuestro sitio, aceptas nuestros:</h4>
			<ul>
				<li><h5>Términos y condiciones de uso.</h5></li>
				<li><h5>Sistema de recopilación estadística anonima.</h5></li>
			</ul>
		</div>
	</div>
</section>

    <footer class="footer">
      <div class="container">
        <p class="pull-right"><img src="vdl-themes/default/img/html5.png"><img src="vdl-themes/default/img/agpl.png"></p>
        <h6>Powered by Vidali.</h6>
      </div>
    </footer>


</body>
</html>
